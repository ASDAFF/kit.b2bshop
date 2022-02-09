<?

use Bitrix\Main\Loader;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixCatalogSmartFilter $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

$s404 = false;
$hasChecked = false;


$s404Cnt = 0;
$hasCheckedCnt = 0;

if(!Loader::includeModule('iblock'))
{
	ShowError(GetMessage("CC_BCF_MODULE_NOT_INSTALLED"));

	return;
}

$arParams["AJAX_OPTION_HISTORY"] = "N";
$FILTER_NAME = (string)$arParams["FILTER_NAME"];

global $msIsFilter;
$msIsFilter = 1;

$filterName = "f";
$maxDepthLevel = (int)$arParams["SECTIONS_DEPTH_LEVEL"];

global ${$FILTER_NAME};
if(!is_array(${$FILTER_NAME}))
	${$FILTER_NAME} = array();


$firstFilter = ${$FILTER_NAME};

$boolFacet = false;

if($arParams["SECTIONS"] == "Y" || !empty(${$FILTER_NAME}))
	$boolFacet = true;

if($this->StartResultCache(false, ($arParams["CACHE_GROUPS"] ? $USER->GetGroups() : false)))
{
	$arResult["FACET_FILTER"] = false;
	$arResult["COMBO"] = array();
	$arResult["PRICES"] = CIBlockPriceTools::GetCatalogPrices($arParams["IBLOCK_ID"], $arParams["PRICE_CODE"]);
	$arResult["ITEMS"] = $this->getResultItems();

	$propertyEmptyValuesCombination = array();
	foreach ($arResult["ITEMS"] as $PID => $arItem)
		$propertyEmptyValuesCombination[$arItem["ID"]] = array();

	if(!empty($arResult["ITEMS"]))
	{
		if($this->facet->isValid() && empty(${$FILTER_NAME}) && !$boolFacet)
		{
			$this->facet->setPrices($arResult["PRICES"]);
			$this->facet->setSectionId($this->SECTION_ID);
			$arResult["FACET_FILTER"] = array(
				"ACTIVE_DATE" => "Y",
				"CHECK_PERMISSIONS" => "Y",
			);
			if($this->arParams['HIDE_NOT_AVAILABLE'] == 'Y')
				$arResult["FACET_FILTER"]['CATALOG_AVAILABLE'] = 'Y';

			$res = $this->facet->query($arResult["FACET_FILTER"]);
			while ($row = $res->fetch())
			{
				$facetId = $row["FACET_ID"];
				if(\Bitrix\Iblock\PropertyIndex\Storage::isPropertyId($facetId))
				{
					$PID = \Bitrix\Iblock\PropertyIndex\Storage::facetIdToPropertyId($facetId);
					if ($arResult["ITEMS"][$PID]["PROPERTY_TYPE"] == "N")
					{
						$this->fillItemValues($arResult["ITEMS"][$PID], $row["MIN_VALUE_NUM"]);
						$this->fillItemValues($arResult["ITEMS"][$PID], $row["MAX_VALUE_NUM"]);
						if ($row["VALUE_FRAC_LEN"] > 0)
							$arResult["ITEMS"][$PID]["DECIMALS"] = $row["VALUE_FRAC_LEN"];
					}
					elseif ($arResult["ITEMS"][$PID]["DISPLAY_TYPE"] == "U")
					{
						$this->fillItemValues($arResult["ITEMS"][$PID], FormatDate("Y-m-d", $row["MIN_VALUE_NUM"]));
						$this->fillItemValues($arResult["ITEMS"][$PID], FormatDate("Y-m-d", $row["MAX_VALUE_NUM"]));
					}
					elseif ($arResult["ITEMS"][$PID]["PROPERTY_TYPE"] == "S")
					{
						$addedKey = $this->fillItemValues($arResult["ITEMS"][$PID], $this->facet->lookupDictionaryValue($row["VALUE"]), true);
						if (strlen($addedKey) > 0)
						{
							$arResult["ITEMS"][$PID]["VALUES"][$addedKey]["FACET_VALUE"] = $row["VALUE"];
							$arResult["ITEMS"][$PID]["VALUES"][$addedKey]["ELEMENT_COUNT"] = $row["ELEMENT_COUNT"];
						}
					}
					else
					{
						$addedKey = $this->fillItemValues($arResult["ITEMS"][$PID], $row["VALUE"], true);
						if (strlen($addedKey) > 0)
						{
							$arResult["ITEMS"][$PID]["VALUES"][$addedKey]["FACET_VALUE"] = $row["VALUE"];
							$arResult["ITEMS"][$PID]["VALUES"][$addedKey]["ELEMENT_COUNT"] = $row["ELEMENT_COUNT"];
						}
					}

				}
				else
				{
					$priceId = \Bitrix\Iblock\PropertyIndex\Storage::facetIdToPriceId($facetId);
					foreach ($arResult["PRICES"] as $NAME => $arPrice)
					{
						if($arPrice["ID"] == $priceId && isset($arResult["ITEMS"][$NAME]))
							$this->fillItemPrices($arResult["ITEMS"][$NAME], $row);
					}
				}
			}
		}
		else
		{

			$arElementFilter = array(
				"IBLOCK_ID" => $this->IBLOCK_ID,
				"SUBSECTION" => $this->SECTION_ID,
				"SECTION_SCOPE" => "IBLOCK",
				"ACTIVE_DATE" => "Y",
				"ACTIVE" => "Y",
				"CHECK_PERMISSIONS" => "Y",
			);

			if('Y' == $this->arParams['HIDE_NOT_AVAILABLE'])
				$arElementFilter['CATALOG_AVAILABLE'] = 'Y';


			$arElementFilter = array_merge($arElementFilter, ${$FILTER_NAME});


			$arElements = array();
			$arResult["arElements"] = array();

			if(!empty($this->arResult["PROPERTY_ID_LIST"]))
			{
				$rsElements = CIBlockElement::GetPropertyValues($this->IBLOCK_ID, $arElementFilter, false, array('ID' => $this->arResult["PROPERTY_ID_LIST"]));
				while ($arElement = $rsElements->Fetch())
					$arResult["arElements"][$arElement["IBLOCK_ELEMENT_ID"]] = $arElement;
			}
			else
			{
				$rsElements = CIBlockElement::GetList(array('ID' => 'ASC'), $arElementFilter, false, false, array(
					'ID',
					'IBLOCK_ID'
				));
				while ($arElement = $rsElements->Fetch())
					$arResult["arElements"][$arElement["ID"]] = array();
			}

			if(!empty($arResult["arElements"]) && $this->SKU_IBLOCK_ID && $arResult["SKU_PROPERTY_COUNT"] > 0)
			{
				$arSkuFilter = array(
					"IBLOCK_ID" => $this->SKU_IBLOCK_ID,
					"ACTIVE_DATE" => "Y",
					"ACTIVE" => "Y",
					"CHECK_PERMISSIONS" => "Y",
					"=PROPERTY_" . $this->SKU_PROPERTY_ID => array_keys($arResult["arElements"]),
				);
				if($this->arParams['HIDE_NOT_AVAILABLE'] == 'Y')
					$arSkuFilter['CATALOG_AVAILABLE'] = 'Y';

				$rsElements = CIBlockElement::GetPropertyValues($this->SKU_IBLOCK_ID, $arSkuFilter, false, array('ID' => $this->arResult["SKU_PROPERTY_ID_LIST"]));
				while ($arSku = $rsElements->Fetch())
				{
					foreach ($arResult["ITEMS"] as $PID => $arItem)
					{
						if(isset($arSku[$PID]) && $arSku[$this->SKU_PROPERTY_ID] > 0)
						{
							if(is_array($arSku[$PID]))
							{
								foreach ($arSku[$PID] as $value)
									$arResult["arElements"][$arSku[$this->SKU_PROPERTY_ID]][$PID][] = $value;
							}
							else
							{
								$arResult["arElements"][$arSku[$this->SKU_PROPERTY_ID]][$PID][] = $arSku[$PID];
							}
						}
					}
				}
			}

			$uniqTest = array();
			foreach ($arResult["arElements"] as $arElement)
			{
				$propertyValues = $propertyEmptyValuesCombination;
				$uniqStr = '';
				foreach ($arResult["ITEMS"] as $PID => $arItem)
				{
					if(is_array($arElement[$PID]))
					{
						foreach ($arElement[$PID] as $value)
						{
							$key = $this->fillItemValues($arResult["ITEMS"][$PID], $value);
							$propertyValues[$PID][$key] = $arResult["ITEMS"][$PID]["VALUES"][$key]["VALUE"];
							$uniqStr .= '|' . $key . '|' . $propertyValues[$PID][$key];
						}
					}
					elseif($arElement[$PID] !== false)
					{
						$key = $this->fillItemValues($arResult["ITEMS"][$PID], $arElement[$PID]);
						$propertyValues[$PID][$key] = $arResult["ITEMS"][$PID]["VALUES"][$key]["VALUE"];
						$uniqStr .= '|' . $key . '|' . $propertyValues[$PID][$key];
					}
				}

				$uniqCheck = md5($uniqStr);
				if(isset($uniqTest[$uniqCheck]))
					continue;
				$uniqTest[$uniqCheck] = true;

				$this->ArrayMultiply($arResult["COMBO"], $propertyValues);
			}

			$arSelect = array(
				"ID",
				"IBLOCK_ID"
			);
			foreach ($arResult["PRICES"] as &$value)
			{
				if(!$value['CAN_VIEW'] && !$value['CAN_BUY'])
					continue;
				$arSelect[] = $value["SELECT"];
				$arFilter["CATALOG_SHOP_QUANTITY_" . $value["ID"]] = 1;
			}
			$arSelect[] = "IBLOCK_SECTION_ID";
			$rsElements = CIBlockElement::GetList(array(), $arElementFilter, false, false, $arSelect);
			while ($arElement = $rsElements->Fetch())
			{
				foreach ($arResult["PRICES"] as $NAME => $arPrice)
					if(isset($arResult["ITEMS"][$NAME]))
						$this->fillItemPrices($arResult["ITEMS"][$NAME], $arElement);

				if($boolFacet)
				{
					$price = $arElement["CATALOG_PRICE_" . $arPrice["ID"]];
					if(strlen($price))
					{
						$arResult["arElements"][$arElement["ID"]][$NAME][] = $price;
					}

					$arResult["arElements"][$arElement["ID"]]["SECTION_ID"][$arElement["IBLOCK_SECTION_ID"]] = $arElement["IBLOCK_SECTION_ID"];
					//printr($arResult["arElements"][$arElement["ID"]]["SECTION_ID"]);
					$arResult["SEC"][$arElement["IBLOCK_SECTION_ID"]] = $arElement["IBLOCK_SECTION_ID"];
				}

			}

			//printr($arResult["SEC"]);
			if(isset($arSkuFilter))
			{
				if($boolFacet) $arSelect[] = "PROPERTY_" . $this->SKU_PROPERTY_ID;
				$rsElements = CIBlockElement::GetList(array(), $arSkuFilter, false, false, $arSelect);
				while ($arSku = $rsElements->Fetch())
				{
					foreach ($arResult["PRICES"] as $NAME => $arPrice)
						if(isset($arResult["ITEMS"][$NAME]))
						{
							$this->fillItemPrices($arResult["ITEMS"][$NAME], $arSku);
							if($boolFacet)
							{
								$price = $arSku["CATALOG_PRICE_" . $arPrice["ID"]];
								if(strlen($price))
								{
									$arResult["arElements"][$arSku["PROPERTY_" . $this->SKU_PROPERTY_ID . "_VALUE"]][$NAME][] = $price;
								}
							}


						}

				}
			}
		}

		foreach ($arResult["ITEMS"] as $PID => $arItem)
		{
			if(is_array($arResult["ITEMS"][$PID]["VALUES"]))
				uasort($arResult["ITEMS"][$PID]["VALUES"], array(
					$this,
					"_sort"
				));
		}

	}

	if($arParams["XML_EXPORT"] === "Y")
	{
		$arResult["SECTION_TITLE"] = "";
		$arResult["SECTION_DESCRIPTION"] = "";

		if($this->SECTION_ID > 0)
		{
			$arSelect = array(
				"ID",
				"IBLOCK_ID",
				"LEFT_MARGIN",
				"RIGHT_MARGIN"
			);
			if($arParams["SECTION_TITLE"] !== "")
				$arSelect[] = $arParams["SECTION_TITLE"];
			if($arParams["SECTION_DESCRIPTION"] !== "")
				$arSelect[] = $arParams["SECTION_DESCRIPTION"];

			$sectionList = CIBlockSection::GetList(array(), array(
				"=ID" => $this->SECTION_ID,
				"IBLOCK_ID" => $this->IBLOCK_ID,
			), false, $arSelect);
			$arResult["SECTION"] = $sectionList->GetNext();

			if($arResult["SECTION"])
			{
				$arResult["SECTION_TITLE"] = $arResult["SECTION"][$arParams["SECTION_TITLE"]];
				if($arParams["SECTION_DESCRIPTION"] !== "")
				{
					$obParser = new CTextParser;
					$arResult["SECTION_DESCRIPTION"] = $obParser->html_cut($arResult["SECTION"][$arParams["SECTION_DESCRIPTION"]], 200);
				}
			}
		}
	}


	/*Sections*/
	if($arParams["SECTIONS"] == "Y")
	{
		$arSectionsFilter = array(
			"ACTIVE" => "Y",
			"GLOBAL_ACTIVE" => "Y",
			"IBLOCK_ID" => $this->IBLOCK_ID
		);

		$rsSections = CIBlockSection::GetList(array("left_margin" => "asc"), $arSectionsFilter, false, array(
			"ID",
			"DEPTH_LEVEL",
			"NAME"
		));
		while ($arSection = $rsSections->Fetch())
		{
			if(isset($arResult["SEC"][$arSection["ID"]]))
			{
				$arSection["ACTIVE"] = "Y";
			}
			$arResult["SECTIONS"][$arSection["ID"]] = $arSection;
		}
		$depthLevel = 0;
		if(isset($arResult["SECTIONS"]) && !empty($arResult["SECTIONS"]))
		{
			foreach ($arResult["SECTIONS"] as $sectID => $arSect)
			{
				if($arSect["DEPTH_LEVEL"] == 1)
				{
					$firstSect = $sectID;
				}
				if(isset($arSect["ACTIVE"]))
				{
					$bool = false;
					$depthLevel = $arSect["DEPTH_LEVEL"];
					foreach ($arResult["SECTIONS"] as $sectChildID => $arSectChild)
					{
						if($sectChildID == $firstSect) $bool = true;
						if($depthLevel == $arSectChild["DEPTH_LEVEL"] && $bool) break 1;
						if($bool) $arResult["SECTIONS"][$sectChildID]["ACTIVE"] = "Y";

					}
				}
			}

			$depthLevel = 0;
			foreach ($arResult["SECTIONS"] as $sectID => $arSect)
			{
				if(!isset($arSect["ACTIVE"])) unset($arResult["SECTIONS"][$sectID]);
			}
			foreach ($arResult["SECTIONS"] as $sectID => $arSect)
			{
				if($arSect["DEPTH_LEVEL"] > $depthLevel && $depthLevel != 0) $arResult["SECTIONS"][$cuurentSect]["IS_PARENT"] = 1;
				$depthLevel = $arSect["DEPTH_LEVEL"];
				$cuurentSect = $sectID;
			}
		}
	}
	/*EndSections*/

	$this->EndResultCache();
}
else
{
	$this->facet->setPrices($arResult["PRICES"]);
	$this->facet->setSectionId($this->SECTION_ID);
}

if($boolFacet)
	$arResult["FACET_FILTER"] = false;

if($arParams["SECTIONS"] == "Y") $this->getItemSections();

/*Handle checked for checkboxes and html control value for numbers*/
if(isset($_REQUEST["ajax"]) && $_REQUEST["ajax"] === "y")
	$_CHECK = &$_REQUEST;
elseif(isset($_REQUEST["del_filter"]))
	$_CHECK = array();
elseif(isset($_GET["set_filter"]))
	$_CHECK = &$_GET;
elseif($arParams["SAVE_IN_SESSION"] && isset($_SESSION[$FILTER_NAME][$this->SECTION_ID]))
	$_CHECK = $_SESSION[$FILTER_NAME][$this->SECTION_ID];
else
	$_CHECK = array();

if($arParams["SEF_MODE_FILTER"] == "Y" && !isset($_REQUEST["del_filter"]))
{
	$CHECK = $this->getSefParams($arParams['SEF_MODE']);
	if($CHECK) $_CHECK = $CHECK;
}

if($_CHECK['PARSE_CHECK'])
{
	$pars = $_CHECK['PARSE_CHECK'];
	unset($_CHECK['PARSE_CHECK']);
}

if($pars)
{

	unset($pars['apply']);
	unset($pars['bxajaxid']);
	$s404 = true;

	foreach ($pars as $k => $par)
	{
		if(array_keys($par) == array(
				'from',
				'to'
			))
		{
			foreach ($par as $pa)
			{
				if($pa > 0)
				{
					++$s404Cnt;
				}
			}
		}
		else
		{
			$s404Cnt += count($par);
		}

	}
}
elseif($_CHECK)
{
	$s404 = true;
	$s404Cnt = count($_CHECK);
}
else
{
	$context = \Bitrix\Main\Application::getInstance()->getContext();
	$request = $context->getRequest();
	$requestUri = $request->getRequestUri();
	if(strpos($requestUri, '/filter') !== false && strpos($requestUri, '/apply') !== false)
	{
		$s404 = true;
	}
}

/*Set state of the html controls depending on filter values*/
$allCHECKED = array();
/*Faceted filter*/
$facetIndex = array();

foreach ($arResult["ITEMS"] as $PID => $arItem)
{
	foreach ($arItem["VALUES"] as $key => $ar)
	{
		if($arResult["FACET_FILTER"] && isset($ar["FACET_VALUE"]))
		{
			$facetIndex[$PID][$ar["FACET_VALUE"]] = &$arResult["ITEMS"][$PID]["VALUES"][$key];
		}

		if(isset($_CHECK[$ar["CONTROL_NAME"]]) && ($arItem["PROPERTY_TYPE"] == "N" || isset($arItem["PRICE"])))
		{
			$_CHECKCODES[$PID][$key] = $_CHECK[$ar["CONTROL_NAME"]];
			$arResult["ITEMS"][$PID]["VALUES"][$key]["SET_FILTER"] = "Y";
		}
		elseif(isset($_CHECK[$ar["CONTROL_NAME"]]))
		{
			$_CHECKCODES[$PID][$key] = $key;
		}


		if(
			isset($_CHECK[$ar["CONTROL_NAME"]])
			|| (
				isset($_CHECK[$ar["CONTROL_NAME_ALT"]])
				&& $_CHECK[$ar["CONTROL_NAME_ALT"]] == $ar["HTML_VALUE_ALT"]
			)
		)
		{
			if($arItem["PROPERTY_TYPE"] == "N")
			{
				$arResult["ITEMS"][$PID]["VALUES"][$key]["HTML_VALUE"] = htmlspecialcharsbx($_CHECK[$ar["CONTROL_NAME"]]);
				$arResult["ITEMS"][$PID]["DISPLAY_EXPANDED"] = "Y";
				if($key == 'MIN' || $key == 'MAX')
				{
					++$hasCheckedCnt;
					$hasChecked = true;
				}
				if($arResult["FACET_FILTER"] && strlen($_CHECK[$ar["CONTROL_NAME"]]) > 0)
				{
					if($key == "MIN")
						$this->facet->addNumericPropertyFilter($PID, ">=", $_CHECK[$ar["CONTROL_NAME"]]);
					elseif($key == "MAX")
						$this->facet->addNumericPropertyFilter($PID, "<=", $_CHECK[$ar["CONTROL_NAME"]]);
				}
			}
			elseif(isset($arItem["PRICE"]))
			{
				if($key == 'MIN' || $key == 'MAX')
				{
					++$hasCheckedCnt;
					$hasChecked = true;
				}
				$arResult["ITEMS"][$PID]["VALUES"][$key]["HTML_VALUE"] = htmlspecialcharsbx($_CHECK[$ar["CONTROL_NAME"]]);
				$arResult["ITEMS"][$PID]["DISPLAY_EXPANDED"] = "Y";
				if($arResult["FACET_FILTER"] && strlen($_CHECK[$ar["CONTROL_NAME"]]) > 0)
				{
					if($key == "MIN")
						$this->facet->addPriceFilter($arResult["PRICES"][$PID]["ID"], ">=", $_CHECK[$ar["CONTROL_NAME"]]);
					elseif($key == "MAX")
						$this->facet->addPriceFilter($arResult["PRICES"][$PID]["ID"], "<=", $_CHECK[$ar["CONTROL_NAME"]]);
				}
			}
			elseif($_CHECK[$ar["CONTROL_NAME"]] == $ar["HTML_VALUE"])
			{
				++$hasCheckedCnt;
				$hasChecked = true;
				$arResult["ITEMS"][$PID]["VALUES"][$key]["CHECKED"] = true;
				$arResult["ITEMS"][$PID]["DISPLAY_EXPANDED"] = "Y";
				$allCHECKED[$PID][$ar["VALUE"]] = true;
				if($arResult["FACET_FILTER"])
				{
					$this->facet->addDictionaryPropertyFilter($PID, "=", $ar["FACET_VALUE"]);
				}
			}
			elseif($_CHECK[$ar["CONTROL_NAME_ALT"]] == $ar["HTML_VALUE_ALT"])
			{
				++$hasCheckedCnt;
				$hasChecked = true;
				$arResult["ITEMS"][$PID]["VALUES"][$key]["CHECKED"] = true;
				$arResult["ITEMS"][$PID]["DISPLAY_EXPANDED"] = "Y";
				$allCHECKED[$PID][$ar["VALUE"]] = true;
				if($arResult["FACET_FILTER"])
				{
					$this->facet->addDictionaryPropertyFilter($PID, "=", $ar["FACET_VALUE"]);
				}
			}
		}
	}
}


$depthLevel = 0;
$arNewSectID = array();
if(isset($_CHECKCODES["SECTION_ID"]))
{
	$bool = false;
	foreach ($arResult["ITEMS"]["SECTION_ID"]["VALUES"] as $sectID => $arSect)
	{
		if(in_array($sectID, $_CHECKCODES["SECTION_ID"]) && !$bool)
		{
			$depthLevel = $arSect["DEPTH_LEVEL"];
			$bool = true;
			continue;
		}
		if($depthLevel >= $arSect["DEPTH_LEVEL"] && $bool) $bool = false;
		if($bool)
		{
			$arNewSectID[$sectID] = $sectID;
		}

	}

	if(!empty($arNewSectID))
	{
		foreach ($arNewSectID as $s)
		{
			$_CHECKCODES["SECTION_ID"][$s] = $s;
		}
	}
}

if($boolFacet)
{
	$arFilterElements = array();
	$arPropsNum = array();
	$arCountElements = array();

	foreach ($arResult["ITEMS"] as $itemPropID => $arItem)
	{
		$arFilterItems = array();
		if($arResult["arElements"])
			foreach ($arResult["arElements"] as $elementID => $arElement)
			{
				$boolF = true;
				if(!empty($_CHECKCODES))
				{
					foreach ($_CHECKCODES as $propID => $arRequestProp)
					{
						if($propID == $itemPropID)
						{
							$boolF = true;
							continue 1;
						}
						if(isset($arRequestProp["MAX"]) && isset($arRequestProp["MIN"]))
						{
							if(!$arRequestProp["MIN"] && !$arRequestProp["MAX"]) continue;
							if(!$arRequestProp["MIN"])
							{
								unset($_CHECKCODES[$propID]["MIN"]);
								unset($arRequestProp["MIN"]);
							}
							if(!$arRequestProp["MAX"])
							{
								unset($_CHECKCODES[$propID]["MAX"]);
								unset($arRequestProp["MAX"]);
							}
						}
						if(isset($arRequestProp["MAX"]) && isset($arRequestProp["MIN"]))
						{
							$min = (int)$arRequestProp["MIN"];
							$max = (int)$arRequestProp["MAX"];
							$current = $arElement[$propID];
							if(is_array($current))
							{
								foreach ($current as $cur)
								{
									$cur = (int)$cur;
									if($cur >= $min && $cur <= $max)
									{
										$boolF = true;
										break 1;
									}
									else $boolF = false;
								}
							}
							else
							{
								$current = (int)$current;
								if($current >= $min && $current <= $max)
								{
									$boolF = true;
								}
								else $boolF = false;
							}
						}
						elseif(isset($arRequestProp["MIN"]))
						{
							$min = (int)$arRequestProp["MIN"];
							$current = $arElement[$propID];
							if(is_array($current))
							{
								foreach ($current as $cur)
								{
									$cur = (int)$cur;
									if($cur >= $min)
									{
										$boolF = true;
										break 1;
									}
									else $boolF = false;
								}
							}
							else
							{
								$current = (int)$current;
								if($current >= $min)
								{
									$boolF = true;
								}
								else $boolF = false;
							}
						}
						elseif(isset($arRequestProp["MAX"]))
						{
							$max = (int)$arRequestProp["MAX"];
							$current = $arElement[$propID];
							if(is_array($current))
							{
								foreach ($current as $cur)
								{
									$cur = (int)$cur;
									if($cur <= $max)
									{
										$boolF = true;
										break 1;
									}
									else $boolF = false;
								}
							}
							else
							{
								$current = (int)$current;
								if($current <= $max)
								{
									$boolF = true;
								}
								else $boolF = false;
							}
						}
						else
						{
							if(is_array($arElement[$propID]))
							{
								foreach ($arElement[$propID] as $v)
								{
									if(isset($arRequestProp[$v]))
									{
										$boolF = true;
										break 1;
									}
									else $boolF = false;

								}

							}
							else
							{
								$v = $arElement[$propID];
								if(isset($arRequestProp[$v]))
								{
									$boolF = true;
								}
								else $boolF = false;


							}
						}
						if(!$boolF)
						{
							break 1;
						}
					}
				}

				if($boolF)
				{
					$arFilterItems[$elementID] = $elementID;
				}
			}
		$arFilterElements[$itemPropID] = $arFilterItems;
	}
	$arCountProps = array();
	if(!empty($arFilterElements))
	{
		foreach ($arFilterElements as $propID => $arEls)
		{

			foreach ($arEls as $elID)
			{
				$prop = $arResult["arElements"][$elID][$propID];
				if(is_array($prop))
				{
					foreach ($prop as $p)
					{
						$arCountProps[$propID][$p]++;
					}

				}
				else
				{
					$p = $prop;
					$arCountProps[$propID][$p]++;
				}
			}


		}
	}

	$depthLevel = 0;
	if(isset($arCountProps["SECTION_ID"]))
	{
		foreach ($arResult["ITEMS"]["SECTION_ID"]["VALUES"] as $sectID => $arSect)
		{
			if($arSect["DEPTH_LEVEL"] == 1)
			{
				$firstSect = $sectID;
			}
			if(isset($arResult["SEC"][$sectID]) && isset($arCountProps["SECTION_ID"][$sectID]))
			{
				$bool = false;
				$depthLevel = $arSect["DEPTH_LEVEL"];
				foreach ($arResult["ITEMS"]["SECTION_ID"]["VALUES"] as $sectChildID => $arSectChild)
				{
					if($sectChildID == $firstSect) $bool = true;
					if($depthLevel == $arSectChild["DEPTH_LEVEL"]) break 1;
					if($bool) $arCountProps["SECTION_ID"][$sectChildID] += $arCountProps["SECTION_ID"][$sectID];
				}
			}
		}
	}

	if(isset($arResult["ITEMS"]["SECTION_ID"]["VALUES"]))
	{
		foreach ($arResult["ITEMS"]["SECTION_ID"]["VALUES"] as $sectID => $arSect)
		{
			if($arSect["DEPTH_LEVEL"] > $maxDepthLevel) unset($arResult["ITEMS"]["SECTION_ID"]["VALUES"][$sectID]);
		}
	}

	foreach ($arResult["ITEMS"] as $PID => $arItem)
	{

		foreach ($arItem["VALUES"] as $key => $arValue)
		{
			/*Add from Sotbit*/
			$arResult["ITEMS"][$PID]["VALUES"][$key]["CNT"] = isset($arCountProps[$PID][$key]) ? $arCountProps[$PID][$key] : 0;
			if(!$arResult["ITEMS"][$PID]["VALUES"][$key]["CNT"]) $arResult["ITEMS"][$PID]["VALUES"][$key]["DISABLED"] = true;
			/*End*/
		}
	}
}

if($_CHECK)
{
	/*Disable composite mode when filter checked*/
	$this->setFrameMode(false);
	$arResult["SET_FILTER"] = "Y";
	if($arResult["FACET_FILTER"])
	{
		foreach ($arResult["ITEMS"] as $PID => &$arItem)
		{
			if($arItem["PROPERTY_TYPE"] != "N" && !isset($arItem["PRICE"]))
			{
				foreach ($arItem["VALUES"] as $key => &$arValue)
				{
					$arValue["DISABLED"] = true;
				}
				unset($arValue);
			}
		}
		unset($arItem);

		$res = $this->facet->query($arResult["FACET_FILTER"]);
		while ($row = $res->fetch())
		{
			$facetId = $row["FACET_ID"];
			if(\Bitrix\Iblock\PropertyIndex\Storage::isPropertyId($facetId))
			{
				$pp = \Bitrix\Iblock\PropertyIndex\Storage::facetIdToPropertyId($facetId);
				if($arResult["ITEMS"][$pp]["PROPERTY_TYPE"] == "N")
				{
					if(is_array($arResult["ITEMS"][$pp]["VALUES"]))
					{
						$arResult["ITEMS"][$pp]["VALUES"]["MIN"]["FILTERED_VALUE"] = $row["MIN_VALUE_NUM"];
						$arResult["ITEMS"][$pp]["VALUES"]["MAX"]["FILTERED_VALUE"] = $row["MAX_VALUE_NUM"];
					}
				}
				else
				{
					if(isset($facetIndex[$pp][$row["VALUE"]]))
						unset($facetIndex[$pp][$row["VALUE"]]["DISABLED"]);
				}
			}
			else
			{
				$priceId = \Bitrix\Iblock\PropertyIndex\Storage::facetIdToPriceId($facetId);
				foreach ($arResult["PRICES"] as $NAME => $arPrice)
				{
					if(
						$arPrice["ID"] == $priceId
						&& isset($arResult["ITEMS"][$NAME])
						&& is_array($arResult["ITEMS"][$NAME]["VALUES"])
					)
					{
						$arResult["ITEMS"][$NAME]["VALUES"]["MIN"]["FILTERED_VALUE"] = $row["MIN_VALUE_NUM"];
						$arResult["ITEMS"][$NAME]["VALUES"]["MAX"]["FILTERED_VALUE"] = $row["MAX_VALUE_NUM"];
					}
				}
			}
		}
	}
	elseif(!$boolFacet)
	{
		$index = array();
		foreach ($arResult["COMBO"] as $id => $combination)
		{
			foreach ($combination as $PID => $value)
			{
				$index[$PID][$value][] = &$arResult["COMBO"][$id];
			}
		}

		/*Handle disabled for checkboxes (TODO: handle number type)*/
		foreach ($arResult["ITEMS"] as $PID => &$arItem)
		{
			if($arItem["PROPERTY_TYPE"] != "N" && !isset($arItem["PRICE"]))
			{
				//All except current one
				$checked = $allCHECKED;
				unset($checked[$PID]);

				foreach ($arItem["VALUES"] as $key => &$arValue)
				{
					$found = false;
					if(isset($index[$PID][$arValue["VALUE"]]))
					{
						//Check if there are any combinations exists
						foreach ($index[$PID][$arValue["VALUE"]] as $id => $combination)
						{
							//Check if combination fits into the filter
							$isOk = true;
							foreach ($checked as $cPID => $values)
							{
								if(!isset($values[$combination[$cPID]]))
								{
									$isOk = false;
									break;
								}
							}

							if($isOk)
							{
								$found = true;
								break;
							}
						}
					}
					if(!$found)
						$arValue["DISABLED"] = true;
				}
				unset($arValue);
			}
		}
		unset($arItem);
	}
}

/*Make iblock filter*/

if($_CHECK)
{
	/*Disable composite mode when filter checked*/
	$arResult["SET_FILTER"] = "Y";
	$index = array();
	//echo "Handle disabled for checkboxes: ",round(microtime(true)-$sstime, 6),"<hr>";
}
foreach ($arResult["ITEMS"] as $PID => $arItem)
{
	if(!isset($arItem["VALUES"]["MAX"]) && !isset($arItem["VALUES"]["MIN"]))
	{
		$arResult["ITEMS"][$PID]["CODE_SEF"] = $arItem["CODE_SEF"] . "[]";
	}

	foreach ($arItem["VALUES"] as $key => $arValue)
	{
		/*Add from Sotbit*/

		if($key == "MIN")
		{
			$arResult["ITEMS"][$PID]["VALUES"][$key]["CONTROL_NAME_SEF"] = $arItem["CODE_SEF"] . "[from]";
		}
		elseif($key == "MAX")
		{
			$arResult["ITEMS"][$PID]["VALUES"][$key]["CONTROL_NAME_SEF"] = $arItem["CODE_SEF"] . "[to]";
		}

		/*End*/
	}
}

foreach ($arResult["ITEMS"] as $PID => $arItem)
{
	if(isset($arItem["PRICE"]))
	{
		if(strlen($arItem["VALUES"]["MIN"]["HTML_VALUE"]) && strlen($arItem["VALUES"]["MAX"]["HTML_VALUE"]))
			${$FILTER_NAME}["><CATALOG_PRICE_" . $arItem["ID"]] = array(
				$arItem["VALUES"]["MIN"]["HTML_VALUE"],
				$arItem["VALUES"]["MAX"]["HTML_VALUE"]
			);
		elseif(strlen($arItem["VALUES"]["MIN"]["HTML_VALUE"]))
			${$FILTER_NAME}[">=CATALOG_PRICE_" . $arItem["ID"]] = $arItem["VALUES"]["MIN"]["HTML_VALUE"];
		elseif(strlen($arItem["VALUES"]["MAX"]["HTML_VALUE"]))
			${$FILTER_NAME}["<=CATALOG_PRICE_" . $arItem["ID"]] = $arItem["VALUES"]["MAX"]["HTML_VALUE"];
	}
	elseif($arItem["PROPERTY_TYPE"] == "N")
	{
		$existMinValue = (strlen($arItem["VALUES"]["MIN"]["HTML_VALUE"]) > 0);
		$existMaxValue = (strlen($arItem["VALUES"]["MAX"]["HTML_VALUE"]) > 0);
		if($existMinValue || $existMaxValue)
		{
			$filterKey = '';
			$filterValue = '';
			if($existMinValue && $existMaxValue)
			{
				$filterKey = "><PROPERTY_" . $PID;
				$filterValue = array(
					$arItem["VALUES"]["MIN"]["HTML_VALUE"],
					$arItem["VALUES"]["MAX"]["HTML_VALUE"]
				);
			}
			elseif($existMinValue)
			{
				$filterKey = ">=PROPERTY_" . $PID;
				$filterValue = $arItem["VALUES"]["MIN"]["HTML_VALUE"];
			}
			elseif($existMaxValue)
			{
				$filterKey = "<=PROPERTY_" . $PID;
				$filterValue = $arItem["VALUES"]["MAX"]["HTML_VALUE"];
			}

			if($arItem["IBLOCK_ID"] == $this->SKU_IBLOCK_ID)
			{
				if(!isset(${$FILTER_NAME}["OFFERS"]))
				{
					${$FILTER_NAME}["OFFERS"] = array();
				}
				${$FILTER_NAME}["OFFERS"][$filterKey] = $filterValue;
			}
			else
			{
				${$FILTER_NAME}[$filterKey] = $filterValue;
			}
		}
	}
	else
	{
		foreach ($arItem["VALUES"] as $key => $ar)
		{
			if($ar["CHECKED"])
			{
				$backKey = htmlspecialcharsback($key);
				if($PID != "SECTION_ID") $filterKey = "=PROPERTY_" . $PID;
				else $filterKey = $PID;
				if($arItem["IBLOCK_ID"] == $this->SKU_IBLOCK_ID)
				{
					if(!isset(${$FILTER_NAME}["OFFERS"]))
					{
						${$FILTER_NAME}["OFFERS"] = array();
					}
					if(!isset(${$FILTER_NAME}["OFFERS"][$filterKey]))
						${$FILTER_NAME}["OFFERS"][$filterKey] = array($backKey);
					elseif(!is_array(${$FILTER_NAME}["OFFERS"][$filterKey]))
						${$FILTER_NAME}["OFFERS"][$filterKey] = array(
							$filter[$filterKey],
							$backKey
						);
					elseif(!in_array($backKey, ${$FILTER_NAME}["OFFERS"][$filterKey]))
						${$FILTER_NAME}["OFFERS"][$filterKey][] = $backKey;
				}
				else
				{
					if(!isset(${$FILTER_NAME}[$filterKey]))
						${$FILTER_NAME}[$filterKey] = array($backKey);
					elseif(!is_array(${$FILTER_NAME}[$filterKey]))
						${$FILTER_NAME}[$filterKey] = array(
							$filter[$filterKey],
							$backKey
						);
					elseif(!in_array($backKey, ${$FILTER_NAME}[$filterKey]))
						${$FILTER_NAME}[$filterKey][] = $backKey;
				}
			}
		}
	}
}

/*Save to session if needed*/
if($arParams["SAVE_IN_SESSION"])
{
	$_SESSION[$FILTER_NAME][$this->SECTION_ID] = array();
	foreach ($arResult["ITEMS"] as $PID => $arItem)
	{
		foreach ($arItem["VALUES"] as $key => $ar)
		{
			if(isset($_CHECK[$ar["CONTROL_NAME"]]))
			{
				if($arItem["PROPERTY_TYPE"] == "N" || isset($arItem["PRICE"]))
					$_SESSION[$FILTER_NAME][$this->SECTION_ID][$ar["CONTROL_NAME"]] = $_CHECK[$ar["CONTROL_NAME"]];
				elseif($_CHECK[$ar["CONTROL_NAME"]] == $ar["HTML_VALUE"])
					$_SESSION[$FILTER_NAME][$this->SECTION_ID][$ar["CONTROL_NAME"]] = $_CHECK[$ar["CONTROL_NAME"]];
			}
		}
	}
}

$pageURL = $APPLICATION->GetCurPageParam();
$paramsToDelete = array(
	"set_filter",
	"del_filter",
	"ajax",
	"bxajaxid",
	"AJAX_CALL",
	"mode"
);
foreach ($arResult["ITEMS"] as $PID => $arItem)
{
	foreach ($arItem["VALUES"] as $key => $ar)
	{
		$paramsToDelete[] = $ar["CONTROL_NAME"];
		$paramsToDelete[] = $ar["CONTROL_NAME_ALT"];
	}
}
$clearURL = CHTTP::urlDeleteParams($pageURL, $paramsToDelete, array("delete_system_params" => true));

if(isset($_REQUEST["ajax"]) && $_REQUEST["ajax"] === "y")
{
	$arFilter = $this->makeFilter($FILTER_NAME);
	$arResult["ELEMENT_COUNT"] = CIBlockElement::GetList(array(), $arFilter, array(), false);

	$paramsToAdd = array(
		"set_filter" => "y",
	);
	foreach ($arResult["ITEMS"] as $PID => $arItem)
	{
		foreach ($arItem["VALUES"] as $key => $ar)
		{
			if(isset($_CHECK[$ar["CONTROL_NAME"]]))
			{
				if($arItem["PROPERTY_TYPE"] == "N" || isset($arItem["PRICE"]))
					$paramsToAdd[$ar["CONTROL_NAME"]] = $_CHECK[$ar["CONTROL_NAME"]];
				elseif($_CHECK[$ar["CONTROL_NAME"]] == $ar["HTML_VALUE"])
					$paramsToAdd[$ar["CONTROL_NAME"]] = $_CHECK[$ar["CONTROL_NAME"]];
			}
			elseif(isset($_CHECK[$ar["CONTROL_NAME_ALT"]]))
			{
				if($_CHECK[$ar["CONTROL_NAME_ALT"]] == $ar["HTML_VALUE_ALT"])
					$paramsToAdd[$ar["CONTROL_NAME_ALT"]] = $_CHECK[$ar["CONTROL_NAME_ALT"]];
			}
		}
	}
	$arResult["FILTER_URL"] = htmlspecialcharsbx(CHTTP::urlAddParams($clearURL, $paramsToAdd, array(
		"skip_empty" => true,
		"encode" => true,
	)));

	if(isset($_GET["bxajaxid"]))
	{
		$arResult["COMPONENT_CONTAINER_ID"] = htmlspecialcharsbx("comp_" . $_GET["bxajaxid"]);
		if($arParams["INSTANT_RELOAD"])
			$arResult["INSTANT_RELOAD"] = true;
	}
	$arResult["FILTER_AJAX_URL"] = htmlspecialcharsbx(CHTTP::urlAddParams($clearURL, $paramsToAdd + array(
			"bxajaxid" => $_GET["bxajaxid"],
		), array(
		"skip_empty" => true,
		"encode" => true,
	)));
}

$arInputNames = array();
foreach ($arResult["ITEMS"] as $PID => $arItem)
{
	foreach ($arItem["VALUES"] as $key => $ar)
		$arInputNames[$ar["CONTROL_NAME"]] = true;
}
$arInputNames["set_filter"] = true;
$arInputNames["del_filter"] = true;

$arSkip = array(
	"AUTH_FORM" => true,
	"TYPE" => true,
	"USER_LOGIN" => true,
	"USER_CHECKWORD" => true,
	"USER_PASSWORD" => true,
	"USER_CONFIRM_PASSWORD" => true,
	"USER_EMAIL" => true,
	"captcha_word" => true,
	"captcha_sid" => true,
	"login" => true,
	"Login" => true,
	"backurl" => true,
	"ajax" => true,
	"mode" => true,
	"bxajaxid" => true,
	"AJAX_CALL" => true,
);

$arResult["FORM_ACTION"] = $clearURL;
$arResult["HIDDEN"] = array();
$boolSef = false;
foreach (array_merge($_GET, $_POST) as $key => $value)
{
	if($key == "sef")
	{
		$boolSef = true;
	}
	if(
		!isset($arInputNames[$key])
		&& !isset($arSkip[$key])
		&& !is_array($value)
	)
	{
		$arResult["HIDDEN"][] = array(
			"CONTROL_ID" => htmlspecialcharsbx($key),
			"CONTROL_NAME" => htmlspecialcharsbx($key),
			"HTML_VALUE" => htmlspecialcharsbx($value),
		);
	}
}


if($arParams["SEF_MODE"] == "Y")
{
	$section = false;
	if($this->SECTION_ID > 0)
	{
		$sectionList = CIBlockSection::GetList(array(), array(
			"=ID" => $this->SECTION_ID,
			"IBLOCK_ID" => $this->IBLOCK_ID,
		), false, array(
			"ID",
			"IBLOCK_ID",
			"SECTION_PAGE_URL"
		));
		$sectionList->SetUrlTemplates($arParams["SEF_RULE"]);
		$section = $sectionList->GetNext();
	}

	if($section)
	{
		$url = $section["DETAIL_PAGE_URL"];
	}
	else
	{
		$url = CIBlock::ReplaceSectionUrl($arParams["SEF_RULE"], array());
	}

	$arResult["JS_FILTER_PARAMS"]["SEF_SET_FILTER_URL"] = $this->makeSmartUrl($url, true);
	$arResult["JS_FILTER_PARAMS"]["SEF_DEL_FILTER_URL"] = $this->makeSmartUrl($url, false);
}


if($arParams["SEF_MODE_FILTER"] != "Y" && !$boolSef)
{
	$key = "sef";
	$value = "N";
	$arResult["HIDDEN"][] = array(
		"CONTROL_ID" => htmlspecialcharsbx($key),
		"CONTROL_NAME" => htmlspecialcharsbx($key),
		"HTML_VALUE" => htmlspecialcharsbx($value),
	);
}

if(!empty($arResult["ITEMS"]))
{
	foreach ($arResult["ITEMS"] as $i => $arItem)
	{
		$code = $arItem["CODE"];
		if(isset($firstFilter["PROPERTY_" . $code]))
		{
			unset($arResult["ITEMS"][$i]);
		}
	}
}


if(
	$arParams["XML_EXPORT"] === "Y"
	&& $arResult["SECTION"]
	&& ($arResult["SECTION"]["RIGHT_MARGIN"] - $arResult["SECTION"]["LEFT_MARGIN"]) === 1
)
{
	$exportUrl = CHTTP::urlAddParams($clearURL, array("mode" => "xml"));
	$APPLICATION->AddHeadString('<meta property="ya:interaction" content="XML_FORM" />');
	$APPLICATION->AddHeadString('<meta property="ya:interaction:url" content="' . CHTTP::urn2uri($exportUrl) . '" />');
}


if($s404 && (!$hasChecked || $s404Cnt != $hasCheckedCnt))
{
	if(
		((
			$_SESSION['MS_ONLY_CHECKED'] == 'Y' ||
			$_SESSION['MS_SECTIONS'] ||
			$_SESSION['MS_ONLY_AVAILABLE'] == 'Y' ||
			$_SESSION['MS_COUNT'] > 0 ||
			$_SESSION['MS_SORT'] > 0) && !$_CHECK)
		|| isset($_REQUEST['q']))
	{

	}
	else
	{
		@define("ERROR_404", "Y");
	}
}

if($arParams["XML_EXPORT"] === "Y" && $_REQUEST["mode"] === "xml")
{
	$this->setFrameMode(false);
	ob_start();
	$this->IncludeComponentTemplate("xml");
	$xml = ob_get_contents();
	$APPLICATION->RestartBuffer();
	while (ob_end_clean()) ;
	header("Content-Type: text/xml; charset=utf-8");
	echo $APPLICATION->convertCharset($xml, LANG_CHARSET, "utf-8");
	require_once($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/include/epilog_after.php");
	die();
}
elseif(isset($_REQUEST["ajax"]) && $_REQUEST["ajax"] === "y")
{
	$this->setFrameMode(false);
	$this->IncludeComponentTemplate("ajax");
	define("PUBLIC_AJAX_MODE", true);
	require_once($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/include/epilog_after.php");
	die();
}
else
{
	$this->IncludeComponentTemplate();

	if($arResult["JS_FILTER_PARAMS"]["SEF_SET_FILTER_URL"])
	{
		$APPLICATION->SetCurPage($arResult["JS_FILTER_PARAMS"]["SEF_SET_FILTER_URL"], "");
	}
	elseif($arParams["SEF_MODE_FILTER"] == "Y")
	{

		if(class_exists('B2BSSotbitParent'))
		{
			$APPLICATION->SetCurPage(B2BSSotbitParent::$pageURL, "");
		}
		elseif(class_exists('B2BSSotbitParent'))
		{
			$APPLICATION->SetCurPage(B2BSSotbitParent::$pageURL, "");
		}
		elseif(class_exists('B2BSSotbitParent'))
		{
			$APPLICATION->SetCurPage(B2BSSotbitParent::$pageURL, "");
		}
	}
}

