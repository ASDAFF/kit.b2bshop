<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
use Bitrix\Currency\CurrencyTable;
global $USER;

$name = $arResult["NAME"];
$text = $arResult["~PREVIEW_TEXT"]?$arResult["~PREVIEW_TEXT"]:$arResult["~DETAIL_TEXT"];
$url = $arResult["DETAIL_PAGE_URL"];
$img = $arResult["PREVIEW_PICTURE"]["SRC"]?$arResult["PREVIEW_PICTURE"]["SRC"]:$arResult["DETAIL_PICTURE"]["SRC"];

$Og = $arResult['OG'];
$Og->set(array());

//B2BSKit::createSocMeta($name, $text, $url, $img, "");
$arParams["PRODUCT_ID_VARIABLE"] = "s_id";
$strError = '';
$successfulAdd = true;
$this->initComponentTemplate();
?>
<?$frame = $this->__template->createFrame()->begin();?>
<script type="text/javascript">
	$(function() {
		<?if($USER->IsAuthorized()):?>
		$(".subscribe_new").hide();
		<?else:?>
		$(".subscribe_product_form").hide();
		<?endif;?>
	});
</script>
<?$frame->beginStub();?>
<?$frame->end();?>
<?

$codeBrand = $arParams["MANUFACTURER_LIST_PROPS"];
if (isset($_REQUEST[$arParams["ACTION_VARIABLE"]]) && isset($_REQUEST[$arParams["PRODUCT_ID_VARIABLE"]]))
{
	if(isset($_REQUEST[$arParams["ACTION_VARIABLE"]."BUY"]))
		$action = "BUY";
	elseif(isset($_REQUEST[$arParams["ACTION_VARIABLE"]."ADD2BASKET"]))
		$action = "ADD2BASKET";
	else
		$action = strtoupper($_REQUEST[$arParams["ACTION_VARIABLE"]]);

	$productID = intval($_REQUEST[$arParams["PRODUCT_ID_VARIABLE"]]);
	if (($action == "ADD2BASKET" || $action == "BUY" || $action == "SUBSCRIBE_PRODUCT" || $action == "DELAY") && $productID > 0)
	{
		if (\Bitrix\Main\Loader::includeModule("sale") && \Bitrix\Main\Loader::includeModule("catalog"))
		{
			$addByAjax = isset($_REQUEST['ajax_basket']) && 'Y' == $_REQUEST['ajax_basket'];
			$QUANTITY = isset($_REQUEST["quantity"])?$_REQUEST["quantity"]:1;
			$product_properties = array();
			$intProductIBlockID = intval(CIBlockElement::GetIBlockByID($productID));
			if (0 < $intProductIBlockID)
			{
				if ($arParams['ADD_PROPERTIES_TO_BASKET'] == 'Y')
				{
					if ($intProductIBlockID == $arParams["IBLOCK_ID"])
					{
						if (!empty($arParams["PRODUCT_PROPERTIES"]))
						{

							foreach($arParams["PRODUCT_PROPERTIES"] as $prop)
							{
								$arProp = $arResult["PROPERTIES"][$prop];
								$product_properties[] = array(
									"NAME" => $arProp["NAME"],
									"CODE" => $arProp["CODE"],
									"VALUE" => $arProp["VALUE"],
									"SORT" => "100"
								) ;
							}
							/*if (
								isset($_REQUEST[$arParams["PRODUCT_PROPS_VARIABLE"]])
								&& is_array($_REQUEST[$arParams["PRODUCT_PROPS_VARIABLE"]])
							)
							{
								$product_properties = CIBlockPriceTools::CheckProductProperties(
									$arParams["IBLOCK_ID"],
									$productID,
									$arParams["PRODUCT_PROPERTIES"],
									$_REQUEST[$arParams["PRODUCT_PROPS_VARIABLE"]],
									$arParams['PARTIAL_PRODUCT_PROPERTIES'] == 'Y'
								);
								if (!is_array($product_properties))
								{
									$strError = GetMessage("B2BS_CATALOG_ERROR2BASKET");
									$successfulAdd = false;
								}
							}
							else
							{
								$strError = GetMessage("B2BS_CATALOG_ERROR2BASKET");
								$successfulAdd  = false;
							}*/
						}
					}
					else
					{
						$skuAddProps = (isset($_REQUEST['basket_props']) && !empty($_REQUEST['basket_props']) ? $_REQUEST['basket_props'] : '');
						if (!empty($arParams["OFFERS_CART_PROPERTIES"]) || !empty($skuAddProps))
						{   /*$product_properties0 = $product_properties1 = array();
							if($arResult["PROPERTIES"][$codeBrand]["VALUE"])
							{
								$product_properties0 = CIBlockPriceTools::CheckProductProperties(
									$arParams["IBLOCK_ID"],
									$arResult["ID"],
									$arParams["PRODUCT_PROPERTIES"],
									array($codeBrand => $arResult["PROPERTIES"][$codeBrand]["VALUE_ENUM_ID"]),
									$arParams['PARTIAL_PRODUCT_PROPERTIES'] == 'Y'
								);
							}
							if(!is_array($product_properties0)) $product_properties0 = array();*/
							$product_properties = CIBlockPriceTools::GetOfferProperties(
								$productID,
								$arParams["IBLOCK_ID"],
								$arParams["OFFERS_CART_PROPERTIES"],
								$skuAddProps
							);

							//$product_properties = array_merge($product_properties0, $product_properties1);
						}
					}
				}
				if ($arParams["USE_PRODUCT_QUANTITY"])
				{
					if (isset($_REQUEST[$arParams["PRODUCT_QUANTITY_VARIABLE"]]))
					{
						$QUANTITY = doubleval($_REQUEST[$arParams["PRODUCT_QUANTITY_VARIABLE"]]);
					}
				}
				if (0 >= $QUANTITY)
				{
					$rsRatios = CCatalogMeasureRatio::getList(
						array(),
						array('PRODUCT_ID' => $productID),
						false,
						false,
						array('PRODUCT_ID', 'RATIO')
					);
					if ($arRatio = $rsRatios->Fetch())
					{
						$intRatio = intval($arRatio['RATIO']);
						$dblRatio = doubleval($arRatio['RATIO']);
						$QUANTITY = ($dblRatio > $intRatio ? $dblRatio : $intRatio);
					}
				}
				if (0 >= $QUANTITY)
					$QUANTITY = 1;
			}
			else
			{
				$strError = GetMessage('B2BS_CATALOG_ERROR2BASKET');
				$successfulAdd = false;
			}
			if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET['ajax_email'] == "Y" && check_bitrix_sessid() && !$USER->IsAuthorized() && isset($_GET['user_mail']))
			{
				$arResultSubscribe["MESSAGE"] = "";
				$arErrors = array();
				$user_mail = trim($_REQUEST['user_mail']);
				$id = IntVal($_REQUEST['id']);
				$user_login = trim($_REQUEST["user_login"]);
				$user_password = trim($_REQUEST["user_password"]);
				$url = trim($_REQUEST["notifyurl"]);
				$arResultSubscribe["STATUS"] = "ERROR";
				if (strlen($user_login) <= 0 && strlen($user_password) <= 0 && strlen($user_mail) <= 0)
					$arResultSubscribe["MESSAGE"] = 'NOTIFY_ERR_NULL';

				if (strlen($user_mail) > 0 && strlen($arResultSubscribe["MESSAGE"]) <= 0)
				{
					$res = CUser::GetList($b, $o, array("=EMAIL" => $user_mail));
					if($res->Fetch())
						$arResultSubscribe["MESSAGE"] = 'NOTIFY_ERR_MAIL_EXIST';
				}

				if (strlen($arResultSubscribe["MESSAGE"]) <= 0)
				{
					if (strlen($user_mail) > 0 && COption::GetOptionString("main", "new_user_registration", "N") == "Y")
					{
						$user_id = CSaleUser::DoAutoRegisterUser($user_mail, array(), SITE_ID, $arErrors);
						if ($user_id > 0)
						{
							$USER->Authorize($user_id);
							if (count($arErrors) > 0)
							{
								$arResultSubscribe["MESSAGE"] = $arErrors[0]["TEXT"];
							}
						}
						else
						{
							$arResultSubscribe["MESSAGE"] = 'NOTIFY_ERR_REG';
							$arResultSubscribe["MESSAGE"] = $arErrors[0]["TEXT"];
						}
					}
					else
					{
						$arAuthResult = $USER->Login($user_login, $user_password, "Y");
						$rs = $APPLICATION->arAuthResult = $arAuthResult;
						if (count($rs) > 0 && $rs["TYPE"] == "ERROR")
							$arResultSubscribe["MESSAGE"] = $rs["MESSAGE"];
					}

					if (strlen($arResultSubscribe["MESSAGE"]) <= 0)
					{
						$arResultSubscribe["STATUS"] = "Y";
					}
				}
				if (strlen($arResultSubscribe["MESSAGE"]) > 0)
				{
					$APPLICATION->RestartBuffer();
					echo CUtil::PhpToJSObject($arResultSubscribe);
					die();
				}

			}
			if ($successfulAdd)
			{
				//$notifyOption = COption::GetOptionString("sale", "subscribe_prod", "");
				//$arNotify = unserialize($notifyOption);
				$default_subscribe = COption::GetOptionString("catalog", "default_subscribe", "");
				$arRewriteFields = array();
				if ($action == "SUBSCRIBE_PRODUCT" && $default_subscribe=="Y"/*$arNotify[SITE_ID]['use'] == 'Y'*/)
				{
					$arRewriteFields["SUBSCRIBE"] = "Y";
					$arRewriteFields["CAN_BUY"] = "N";
				}elseif($action=="DELAY")
				{
					$arRewriteFields["DELAY"] = "Y";
					$arRewriteFields["CAN_BUY"] = "N";
				}
			}

			$arRewriteFields["DETAIL_PAGE_URL"] = $arResult["DETAIL_PAGE_URL"];
			if ($successfulAdd)
			{
				$arRewriteFields["DETAIL_PAGE_URL"] = $arResult["DETAIL_PAGE_URL"];

				if(!Add2BasketByProductID($productID, $QUANTITY, $arRewriteFields, $product_properties))
				{
					if ($ex = $APPLICATION->GetException())
					{
						$strError = $ex->GetString();
					}
					else
					{
						$strError = GetMessage("B2BS_CATALOG_ERROR2BASKET");
					}
					$successfulAdd = false;
				}
			}
			if ($addByAjax)
			{
				if ($successfulAdd)
				{
					$addResult = array('STATUS' => 'OK', 'MESSAGE' => GetMessage('CATALOG_SUCCESSFUL_ADD_TO_BASKET'));
				}
				else
				{
					$addResult = array('STATUS' => 'ERROR', 'MESSAGE' => $strError);
				}
				$APPLICATION->RestartBuffer();
				echo CUtil::PhpToJSObject($addResult);
 				die();
			}
			else
			{
				if ($successfulAdd)
				{
					$pathRedirect = (
						$action == "BUY"
						? $arParams["BASKET_URL"]
						: $APPLICATION->GetCurPageParam("", array(
							$arParams["PRODUCT_ID_VARIABLE"],
							$arParams["ACTION_VARIABLE"],
							$arParams['PRODUCT_QUANTITY_VARIABLE'],
							$arParams['PRODUCT_PROPS_VARIABLE']
						))
					);
					LocalRedirect($pathRedirect);
				}
			}
		}
	}
}
if (isset($_REQUEST["productAction"]))
{
	$arFilter["IBLOCK_ID"] = $arParams["IBLOCK_ID"];
	$arFilter["INCLUDE_SUBSECTIONS"] = "Y";
	$arFilter["ACTIVE"] = "Y";
	$arSort = array($arParams["ELEMENT_SORT_FIELD"]=>$arParams["ELEMENT_SORT_ORDER"]);

	if(isset($_SESSION[$arParams["FILTER_NAME"]."_MS"]))
	{
		$arSectID[] = $arResult["IBLOCK_SECTION_ID"];
		if(isset($arResult["SECTION"]["PATH"]) && !empty($arResult["SECTION"]["PATH"]))
		{
			foreach($arResult["SECTION"]["PATH"] as $arPath)
			{
				$arSectID[] = $arPath["ID"];
			}
		}
		foreach($arSectID as $sectID)
		{
			if(isset($_SESSION[$arParams["FILTER_NAME"]."_MS"][$sectID]) && !empty($_SESSION[$arParams["FILTER_NAME"]."_MS"][$sectID]))
			{
				$arFilter = array_merge($arFilter, $_SESSION[$arParams["FILTER_NAME"]."_MS"][$sectID]);
				$arSort = $_SESSION[$arParams["FILTER_NAME"]."_SORT_MS"][$sectID];
			}
		}
		if(count($arFilter)<=2)
		{
			$arFilter["SECTION_ID"] = $arResult["IBLOCK_SECTION_ID"];
		}
		if(isset($_SESSION[$arParams["FILTER_NAME"]."_MS"][0]))
		{
			unset($arFilter["SECTION_ID"]);
		}
	}
	else
	{
		$arFilter["SECTION_ID"] = $arResult["IBLOCK_SECTION_ID"];
	}

	$APPLICATION->RestartBuffer();
	$arSelect = array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PICTURE", "DETAIL_PAGE_URL", "PROPERTY_".$codeBrand);
	$ID = $arResult["ID"];
	$rsElement = CIBlockElement::GetList($arSort, $arFilter, false, array("nPageSize"=>2, "nElementID"=>$arResult["ID"]), $arSelect);
	$find = -1;
	$prevElement = 0;
	$nextElement = 0;
	$arFind = array();
	$k = 0;
	$bool = false;
	while($arElement = $rsElement->GetNext())
	{
		$arFind[$k] = $arElement;
		if($bool)
		{
			$nextElement = $arElement["ID"];
			break 1;
		}


		if($arElement["ID"]==$ID)
		{
			$bool = true;
			if(isset($arFind[$k-1])) $prevElement = $arFind[$k-1]["ID"];
		}

		$k++;
	}

	array_splice($arFind, $find-1, $find-1);

	if(!$nextElement)
	{
		$rsElement = CIBlockElement::GetList($arSort, $arFilter, false, array("nTopCount"=>1), $arSelect);
		while($arElement = $rsElement->GetNext())
		{
			$arFind[] = $arElement;
			$nextElement = $arElement["ID"];
			break;
		}
	}

	if(!$prevElement)
	{
		foreach($arSort as $i=>$sort)
		{
			$arSortNew[$i] = ($sort=="asc")?"desc":"asc";
		}
		$arSort = $arSortNew;
		$rsElement = CIBlockElement::GetList($arSort, $arFilter, false, array("nTopCount"=>1), $arSelect);
		while($arElement = $rsElement->GetNext())
		{
			$arFind[] = $arElement;
			$prevElement = $arElement["ID"];
		}
	}

	$strPrev = "";
	$strNext = "";

	$arConvertParams = array();
	if ($arParams['CONVERT_CURRENCY'] == 'Y')
	{
		if (!Loader::includeModule('currency'))
		{
			$arParams['CONVERT_CURRENCY'] = 'N';
			$arParams['CURRENCY_ID'] = '';
		}
		else
		{
			$arResultModules['currency'] = true;
			$currencyIterator = CurrencyTable::getList(array(
				'select' => array('CURRENCY'),
				'filter' => array('CURRENCY' => $arParams['CURRENCY_ID'])
			));
			if ($currency = $currencyIterator->fetch())
			{
				$arParams['CURRENCY_ID'] = $currency['CURRENCY'];
				$arConvertParams['CURRENCY_ID'] = $currency['CURRENCY'];
			}
			else
			{
				$arParams['CONVERT_CURRENCY'] = 'N';
				$arParams['CURRENCY_ID'] = '';
			}
			unset($currency, $currencyIterator);
		}
	}
	$imageFromOffer = ($arParams["PICTURE_FROM_OFFER"]=="Y")?1:0;
	$codeOfferMorePhoto = $arParams["MORE_PHOTO_OFFER_PROPS"];
	$arResultPrices = CIBlockPriceTools::GetCatalogPrices($arParams["IBLOCK_ID"], $arParams["PRICE_CODE"]);
	foreach($arFind as &$arF)
	{
		$arF["PREVIEW_PICTURE"] = $arF["PREVIEW_PICTURE"]?$arF["PREVIEW_PICTURE"]:$arF["DETAIL_PICTURE"];
		if($arF["PREVIEW_PICTURE"] && !$imageFromOffer)
		{
			$arF["PREVIEW_PICTURE"] = CFile::ResizeImageGet($arF["PREVIEW_PICTURE"], array('width'=>50, 'height'=>69), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		}
		else 
		{
			unset($arF["PREVIEW_PICTURE"]);
		}

		$arOffers = CIBlockPriceTools::GetOffersArray(
					array(
						'IBLOCK_ID' => $arParams["IBLOCK_ID"],
						'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
					)
					,array($arF["ID"])
					,array(
						$arParams["OFFERS_SORT_FIELD"] => $arParams["OFFERS_SORT_ORDER"],
						$arParams["OFFERS_SORT_FIELD2"] => $arParams["OFFERS_SORT_ORDER2"],
					)
					,$arParams["OFFERS_FIELD_CODE"]
					,$arParams["OFFERS_PROPERTY_CODE"]
					,$arParams["OFFERS_LIMIT"]
					,$arResultPrices
					,$arParams['PRICE_VAT_INCLUDE']
					,$arConvertParams
		);
		if($arOffers)
		{
			$minPrice = 0;
			foreach($arOffers as $arOffer)
			{
				if ($arOffer['CAN_BUY'] && $arOffer["MIN_PRICE"]["DISCOUNT_VALUE"]<$minPrice || $minPrice == 0)
				{
					$intSelected = $keyOffer;
					$arF['MIN_PRICE'] = (isset($arOffer['RATIO_PRICE']) ? $arOffer['RATIO_PRICE'] : $arOffer['MIN_PRICE']);
					$minPrice = $arOffer["MIN_PRICE"]["DISCOUNT_VALUE"];
					$arF["PRICE"] = $arOffer["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"];
				}

				$arOffer["PREVIEW_PICTURE"] = $arOffer["PREVIEW_PICTURE"]?$arOffer["PREVIEW_PICTURE"]:$arOffer["DETAIL_PICTURE"];
				if($arOffer["PREVIEW_PICTURE"] && $imageFromOffer)
				{
					$arF["PREVIEW_PICTURE"] = CFile::ResizeImageGet($arOffer["PREVIEW_PICTURE"], array('width'=>50, 'height'=>69), BX_RESIZE_IMAGE_PROPORTIONAL, true);
				}
				if($imageFromOffer && isset($arOffer["PROPERTIES"][$codeOfferMorePhoto]) && $arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"] && !isset($arF["PREVIEW_PICTURE"]))
				{
					foreach($arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"] as $v)
					{
						$arF["PREVIEW_PICTURE"] = $v;
						$arF["PREVIEW_PICTURE"] = CFile::ResizeImageGet($arF["PREVIEW_PICTURE"], array('width'=>50, 'height'=>69), BX_RESIZE_IMAGE_PROPORTIONAL, true);
						break 1;
					}
				}
			}
		}

		if($arF["ID"]==$prevElement)
		{
			$strPrev = '<span class="next_prev_item">
							<span class="next_prev_item_inner">
								<span class="wrap_img">
									<a href="'.$arF["DETAIL_PAGE_URL"].'"><img class="img-responsive" alt="" title="" src="'.$arF["PREVIEW_PICTURE"]["src"].'" height="'.$arF["PREVIEW_PICTURE"]["src"].'" width="'.$arF["PREVIEW_PICTURE"]["width"].'"></a>
								</span>
								<span class="wrap_text">
									<span class="title">'.$arF["PROPERTY_".$codeBrand."_VALUE"].'</span>
									<span class="title_second">'.$arF["NAME"].'</span>
								</span>
								<span class="price">'.$arF["PRICE"].'</span>
							</span>
							</span>';
			$strHrefPrev = $arF["DETAIL_PAGE_URL"];
		}
		if($arF["ID"]==$nextElement)
		{
			$strNext = '<span class="next_prev_item">
							<span class="next_prev_item_inner">
								<span class="wrap_img">
									<a href="'.$arF["DETAIL_PAGE_URL"].'"><img class="img-responsive" alt="" title="" src="'.$arF["PREVIEW_PICTURE"]["src"].'" height="'.$arF["PREVIEW_PICTURE"]["src"].'" width="'.$arF["PREVIEW_PICTURE"]["width"].'"></a>
								</span>
								<span class="wrap_text">
									<span class="title">'.$arF["PROPERTY_".$codeBrand."_VALUE"].'</span>
									<span class="title_second">'.$arF["NAME"].'</span>
								</span>
								<span class="price">'.$arF["PRICE"].'</span>
							</span>
							</span>';
			$strHrefNext = $arF["DETAIL_PAGE_URL"];
		}
	}
	$strAction = '<ul id="prev_next_product_ajax">
		<li class="wrap_list_left"><a href="'.$strHrefPrev.'" class="list_left"></a>
															'.$strPrev.'
														</li>
														<li class="wrap_list_right"><a href="'.$strHrefNext.'" class="list_right"></a>
															'.$strNext.'
														</li>
													</ul>
													<div class="clear"></div>
												';
	echo $strAction;
	die();
}

?>