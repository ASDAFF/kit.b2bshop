<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Web\Json;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
if(!$USER->IsAuthorized())
{
	?>
	<div class="personal_block_title personal_block_title_blank">
		<h1 class="text"><?
			$APPLICATION->ShowTitle(false); ?></h1>
	</div>
	<?php
	$APPLICATION->AuthForm('', false, false, 'N', false);
}
else
{
	?>
	<div class="personal_block_title personal_block_title_personal">
		<h1 class="text"><?$APPLICATION->ShowTitle(false);?></h1>
	</div>

	<?php
	if(!Loader::includeModule('sotbit.b2bshop'))
	{
		return false;
	}

	$opt = new \Sotbit\B2BShop\Client\Shop\Opt();
	$menu = new \Sotbit\B2BShop\Client\Personal\Menu();
	?>
	<div class="personal-wrapper personal-blank-wrapper personal-blank-wrapper-opt <?=($opt->hasAccess())?'personal-wrapper-access':''?>">
		<?php
		$Template = new \Sotbit\B2BShop\Client\Template\Main();
		$Template->includeBlock('template/personal/tabs.php');
		?>
		<div class="row border-profile border-profile-blank border-profile-blank-opt">
			<?
			$Template->includeBlock('template/personal/leftblock.php');
			?>

			<div class="col-sm-19 sm-padding-right-no blank_right-side <?= (!$menu->isOpen()) ? 'blank_right-side_full' : '' ?>" id="blank_right_side" >
				<div id="wrapper_blank_resizer" class="wrapper_blank_resizer">
					<div class="blank_resizer">
						<div class="blank_resizer_tool <?= (!$menu->isOpen()) ? 'blank_resizer_tool_open':''?>" ></div>
					</div>
					<div class="personal-right-content">
						<div class="blank_filter_block">
							<?php

							$intSectionID = 0;
							$additionalFilter=array();

							global ${$arParams["FILTER_NAME"]};

							if(isset($_POST["count"])) $_SESSION["MS_COUNT"] = $_POST["count"];
							if(isset($_POST["sort"])) $_SESSION["MS_SORT"] = $_POST["sort"];

							if(isset($_POST["articul"])) $_SESSION["MS_ARTICUL"] = $_POST["articul"];

							if(isset($_POST["only_available"]))
							{
								$_SESSION["MS_ONLY_AVAILABLE"] = $_POST["only_available"];
							}
							elseif($_POST['save_only_available'] == 'Y')
							{
								unset($_SESSION["MS_ONLY_AVAILABLE"]);
							}


							if(isset($_POST["only_checked"]))
							{
								$_SESSION["MS_ONLY_CHECKED"] = $_POST["only_checked"];
							}
							elseif($_POST['save_only_checked'] == 'Y')
							{
								unset($_SESSION["MS_ONLY_CHECKED"]);
							}

							if(isset($_POST["sections"]))
							{
								$_SESSION["MS_SECTIONS"] = $_POST["sections"];
							}
							elseif($_POST['save_kategorii'] == 'Y')
							{
								unset($_SESSION["MS_SECTIONS"]);
							}
							global ${$arParams["FILTER_NAME"]};

							if($_SESSION['MS_ARTICUL'])
							{
								$fil = array();
								if($arParams['OPT_ARTICUL_PROPERTY'] > 0)
								{
									$fil[0]['PROPERTY_'.$arParams['OPT_ARTICUL_PROPERTY']] = $_SESSION['MS_ARTICUL'].'%';
									//${$arParams["FILTER_NAME"]}['PROPERTY_'.$arParams['OPT_ARTICUL_PROPERTY']] = $_SESSION['MS_ARTICUL'].'%';
								}
								if($arParams['OPT_ARTICUL_PROPERTY_OFFER'] > 0)
								{
									$fil[1]['OFFERS']['PROPERTY_'.$arParams['OPT_ARTICUL_PROPERTY_OFFER']] = $_SESSION['MS_ARTICUL'].'%';
									//${$arParams["FILTER_NAME"]}['OFFERS']['PROPERTY_'.$arParams['OPT_ARTICUL_PROPERTY_OFFER']] = $_SESSION['MS_ARTICUL'].'%';
								}
								$additionalFilter['ARTICUL'] = $_SESSION['MS_ARTICUL'];
								global ${$arParams["FILTER_NAME"]};
								if(count($fil) == 2)
								{
									$art = array();
									$mxResult = CCatalogSKU::GetInfoByProductIBlock(
											$arParams['IBLOCK_ID']
											);
									if (is_array($mxResult))
									{
										$rs = CIBlockElement::GetList(
												array(),
												array(
														"IBLOCK_ID" => $mxResult['IBLOCK_ID'],
														'PROPERTY_'.$arParams['OPT_ARTICUL_PROPERTY_OFFER'] => $fil[1]['OFFERS']['PROPERTY_'.$arParams['OPT_ARTICUL_PROPERTY_OFFER']],
														'ACTIVE' => 'Y'
												),
												false,
												false,
												array("ID",'PROPERTY_'.$mxResult['SKU_PROPERTY_ID'])
												);
										while($offer = $rs->fetch())
										{
											$art[] = $offer['PROPERTY_'.$mxResult['SKU_PROPERTY_ID'].'_VALUE'];
										}
									}

									$rs = CIBlockElement::GetList(
											array(),
											array(
													"IBLOCK_ID" => $arParams['IBLOCK_ID'],
													'PROPERTY_'.$arParams['OPT_ARTICUL_PROPERTY'] => $fil[0]['PROPERTY_'.$arParams['OPT_ARTICUL_PROPERTY']],
													'ACTIVE' => 'Y'
											),
											false,
											false,
											array("ID")
											);
									while($el = $rs->fetch())
									{
										$art[] = $el['ID'];
									}

									if($art)
									{
										${$arParams["FILTER_NAME"]}['ID'] = $art;
									}
									else
									{
										${$arParams["FILTER_NAME"]}['ID'] = 0;
									}

									//${$arParams["FILTER_NAME"]}[] = array('LOGIC' => 'OR', 0 => reset($fil), 1 => end($fil));
								}
								elseif(count($fil) == 1)
								{
									$f = reset($fil);
									${$arParams["FILTER_NAME"]}[key($f)] = reset($f);
								}
							}

							if($_SESSION['MS_ONLY_CHECKED'] == 'Y')
							{
								global ${$arParams["FILTER_NAME"]};
								$fil2 = array();
								if($_SESSION['BLANK_IDS'])
								{
									$ids = array_keys($_SESSION['BLANK_IDS']);
								}
								else
								{
									$ids = array();
								}
								$fil2 = array( 'ID' => array());
								if($ids)
								{
									$offersIds = array();
									$ofIblock = 0;
									$result = \Bitrix\Iblock\ElementTable::getList(array(
										'select' => array('ID','IBLOCK_ID'),
										'filter' => array('ID' => $ids)
									));
									while ($Element = $result->fetch())
									{
										if($Element['IBLOCK_ID'] == $arParams['IBLOCK_ID'])
										{
											$fil2['ID'][] = $Element['ID'];
										}
										else
										{
											$offersIds[] = $Element['ID'];
											$ofIblock = $Element['IBLOCK_ID'];
										}
									}


									if($offersIds)
									{
										$prods = CCatalogSKU::getProductList($offersIds, $ofIblock);
										if($prods)
										{
											foreach($prods as $prod)
											{
												$fil2['ID'][] = $prod['ID'];
											}
										}
									}
								}

								if($fil2['ID'])
								{
									if(${$arParams["FILTER_NAME"]}['ID'])
									{
										${$arParams["FILTER_NAME"]}['ID'] = array_intersect(${$arParams["FILTER_NAME"]}['ID'], $fil2['ID']);
									}
									else
									{
										${$arParams["FILTER_NAME"]}['ID'] = $fil2['ID'];
									}
								}
								else
								{
									${$arParams["FILTER_NAME"]}['ID'] = array(0);
								}

							}

							$params= array();
							
							$arFilter = array(
									'ACTIVE' => 'Y',
									'IBLOCK_ID' => $arParams['IBLOCK_ID'],
									'GLOBAL_ACTIVE'=>'Y',
							);
							$arSelect = array('IBLOCK_ID','ID','NAME','DEPTH_LEVEL','IBLOCK_SECTION_ID');
							$arOrder = array('DEPTH_LEVEL'=>'ASC','SORT'=>'ASC');
							$rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);
							$sectionLinc = array();
							$arResult['ROOT'] = array();
							$sectionLinc[0] = &$params['ROOT'];
							while($arSection = $rsSections->GetNext())
							{
								$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']] = $arSection;
								$sectionLinc[$arSection['ID']] = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
							}
							unset($sectionLinc);
							
							
							$sections = '';

							if($_SESSION['MS_SECTIONS'])
							{
								$additionalFilter['SECTIONS'] = $_SESSION['MS_SECTIONS'];
								$sections = $_SESSION['MS_SECTIONS'];
								${$arParams["FILTER_NAME"]}['SECTION_ID'] = treeFilter($params['ROOT']['CHILD'],$_SESSION['MS_SECTIONS']);
							}



							$params['ADDITIONAL_FILTER'] = $additionalFilter;


							$ids = array();
							if($arParams["OPT_ARTICUL_PROPERTY"])
							{
								$ids[] = $arParams["OPT_ARTICUL_PROPERTY"];
							}
							if($arParams["OPT_ARTICUL_PROPERTY_OFFER"])
							{
								$ids[] = $arParams["OPT_ARTICUL_PROPERTY_OFFER"];
							}

							if($ids)
							{
								$rs = PropertyTable::getList(array('filter' => array('ID' => $ids),'select' => array('ID','CODE')));
								while($prop = $rs->fetch())
								{
									if($prop['ID'] == $arParams["OPT_ARTICUL_PROPERTY_OFFER"])
									{
										$arParams["LIST_OFFERS_PROPERTY_CODE"][] = $prop['CODE'];
									}
								}
							}

							$APPLICATION->IncludeFile(SITE_DIR."include/blank_search.php",
									Array($params, $arParams),
									Array("MODE"=>"php")
									);
							$APPLICATION->IncludeComponent(
									"sotbit:catalog.smart.filter.facet",
									"blank",
									Array(
											"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
											"IBLOCK_ID" => $arParams["IBLOCK_ID"],
											"SECTION_ID" => $sections,
											"FILTER_NAME" => $arParams["FILTER_NAME"],
											"PRICE_CODE" => $arParams["PRICE_CODE"],
											"CACHE_TYPE" => $arParams["CACHE_TYPE"],
											"CACHE_TIME" => $arParams["CACHE_TIME"],
											"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
											"SAVE_IN_SESSION" => "N",
											"XML_EXPORT" => "Y",
											"SECTION_TITLE" => "NAME",
											"SECTION_DESCRIPTION" => "DESCRIPTION",
											'HIDE_NOT_AVAILABLE' => ($_SESSION["MS_ONLY_AVAILABLE"] == 'Y')?'Y':'N',
											"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
											"AJAX_MODE" => $arParams["AJAX_MODE"],
											"AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
											"AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
											"AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
											"OFFER_TREE_PROPS" => $arParams['OFFER_TREE_PROPS'],
											"OFFER_COLOR_PROP" => $arParams["OFFER_COLOR_PROP"],
											"SEF_MODE_FILTER" => "Y",
											"SECTIONS" => "N",

											"SEF_MODE" => \Bitrix\Main\Config\Option::get("sotbit.b2bshop", "CATALOG_FILTER","N"),
											"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
											"SECTIONS_DEPTH_LEVEL" => "2",
											"FILTER_ITEM_COUNT" => $arParams["FILTER_ITEM_COUNT"]
											),
									$component,
									array('HIDE_ICONS' => 'Y')
									);

							?>
						</div>
						<?

						$arAvailableSortSotbit = array(
							"name_0" => Array("name", "desc"),
							"name_1" => Array("name", "asc"),
							"price_0" => Array('PROPERTY_MINIMUM_PRICE', "desc"),
							"price_1" => Array('PROPERTY_MINIMUM_PRICE', "asc"),
							"date_0" => Array('DATE_CREATE', "desc"),
							"date_1" => Array('DATE_CREATE', "asc"),
							"articul_0" => Array('ARTICUL', "desc"),
							"articul_1" => Array('ARTICUL', "asc"),

						);
						if(isset($_SESSION["MS_SORT"]))
						{
							$arSort = $arAvailableSortSotbit[$_SESSION["MS_SORT"]];

							if($arSort[0] == 'ARTICUL')
							{
								$sort_field = 'PROPERTY_'.$arParams['OPT_ARTICUL_PROPERTY'];
								$sort_order = $arSort[1];
								if($arParams['OPT_ARTICUL_PROPERTY_OFFER'])
								{
									$sort_field_offer = 'PROPERTY_'.$arParams['OPT_ARTICUL_PROPERTY_OFFER'];
									$sort_order_offer = $arSort[1];
								}
							}
							else
							{
								$sort_field = $arSort[0];
								$sort_order = $arSort[1];
							}
						}
						elseif(empty($_SESSION["MS_SORT"]) && $arAvailableSortSotbit[$arParams["ELEMENT_SORT_FIELD"]])
						{
							$arSort = $arAvailableSortSotbit[$arParams["ELEMENT_SORT_FIELD"]];
							$sort_field = $arSort[0];
							$sort_order = $arSort[1];
						}

						if($_SESSION['MS_SECTIONS'])
						{
							${$arParams["FILTER_NAME"]}['SECTION_ID'] = $_SESSION['MS_SECTIONS'];
						}


						$res = CIBlock::GetByID($arParams["IBLOCK_ID"]);
						if($ar_res = $res->GetNext())
						{
							$arResult["FOLDER"] = str_replace('#SITE_DIR#',SITE_DIR,$ar_res['LIST_PAGE_URL']);
						}
						$this->SetViewTarget("blank_excel_out_filter");
						?>
						<div class="col-sm-6 sm-padding-left-no">
							<div id="blank_excel_out" class="blank_excel_out blank_excel" data-params='<?php echo Json::encode($arParams);?>' data-filter='<?php echo Json::encode(${$arParams['FILTER_NAME']});?>'>
								<div class="blank_excel_out_text blank_excel_text"><div class="blank_excel_out_img blank_excel_img"></div><?=Loc::getMessage('EXPORT_TO')?></div>
							</div>
						</div>
						<?php
						$this->EndViewTarget();

						$intSectionID = $APPLICATION->IncludeComponent(
							"bitrix:catalog.section",
							"",
							array(
								"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
								"ELEMENT_SORT_FIELD" => $sort_field?$sort_field:$arParams["ELEMENT_SORT_FIELD"],
								"ELEMENT_SORT_ORDER" => $sort_order?$sort_order:$arParams["ELEMENT_SORT_ORDER"],
								"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
								"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
								"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
								"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
								"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
								"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
								"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
								"BASKET_URL" => $arParams["BASKET_URL"],
								"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
								"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
								"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
								"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
								"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
								"FILTER_NAME" => $arParams["FILTER_NAME"],
								"CACHE_TYPE" => $arParams["CACHE_TYPE"],
								"CACHE_TIME" => $arParams["CACHE_TIME"],
								"CACHE_FILTER" => $arParams["CACHE_FILTER"],
								"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
								"SET_TITLE" => $arParams["SET_TITLE"],
								"SET_STATUS_404" => $arParams["SET_STATUS_404"],
								"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
								"PAGE_ELEMENT_COUNT" => $_SESSION["MS_COUNT"]?$_SESSION["MS_COUNT"]:$arParams["PAGE_ELEMENT_COUNT"],
								"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
								"PRICE_CODE" => $arParams["PRICE_CODE"],
								"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
								"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
								"IMAGE_RESIZE_MODE" => $arParams["IMAGE_RESIZE_MODE"],

								"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
								"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
								"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
								"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
								"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

								"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
								"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
								"PAGER_TITLE" => $arParams["PAGER_TITLE"],
								"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
								"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
								"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
								"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
								"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

								"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
								"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
								"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
								"OFFERS_SORT_FIELD" => $sort_field_offer?$sort_field_offer:$arParams["OFFERS_SORT_FIELD"],
								"OFFERS_SORT_ORDER" => $sort_order_offer?$sort_order_offer:$arParams["OFFERS_SORT_ORDER"],
								"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
								"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
								"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

								"SECTION_ID" => '',
								"SECTION_CODE" => '',
								"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
								"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'CURRENCY_ID' => $arParams['CURRENCY_ID'],
								'HIDE_NOT_AVAILABLE' => ($_SESSION["MS_ONLY_AVAILABLE"] == 'Y')?'Y':'N',

								'LABEL_PROP' => $arParams['LABEL_PROP'],
								'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
								'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

								'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
								'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
								'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
								'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
								'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
								'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
								'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
								'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
								'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
								'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

								'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
								"ADD_SECTIONS_CHAIN" => "N",
								"AJAX_MODE" => $arParams["AJAX_MODE"],
								"AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
								"AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
								"AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
								"BY_LINK" => "Y",
								"OFFER_COLOR_PROP" => $arParams["OFFER_COLOR_PROP"],
								"MANUFACTURER_ELEMENT_PROPS" => $arParams["MANUFACTURER_ELEMENT_PROPS"],
								"MANUFACTURER_LIST_PROPS" => $arParams["MANUFACTURER_LIST_PROPS"],
								"FLAG_PROPS" => $arParams["FLAG_PROPS"],
								"DELETE_OFFER_NOIMAGE" => $arParams["DELETE_OFFER_NOIMAGE"],
								"PICTURE_FROM_OFFER" => $arParams["PICTURE_FROM_OFFER"],
								"MORE_PHOTO_PRODUCT_PROPS" => $arParams["MORE_PHOTO_PRODUCT_PROPS"],
								"MORE_PHOTO_OFFER_PROPS" => $arParams["MORE_PHOTO_OFFER_PROPS"],
								"AVAILABLE_DELETE" => $arParams["AVAILABLE_DELETE"],
								"LIST_WIDTH_SMALL" => $arParams["LIST_WIDTH_SMALL"],
								"LIST_HEIGHT_SMALL" => $arParams["LIST_HEIGHT_SMALL"],
								"LIST_WIDTH_MEDIUM" => $arParams["LIST_WIDTH_MEDIUM"],
								"LIST_HEIGHT_MEDIUM" => $arParams["LIST_HEIGHT_MEDIUM"],
								"DETAIL_PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
								"DETAIL_WIDTH_SMALL" => $arParams["DETAIL_WIDTH_SMALL"],
								"DETAIL_HEIGHT_SMALL" => $arParams["DETAIL_HEIGHT_SMALL"],
								"DETAIL_WIDTH_MEDIUM" => $arParams["DETAIL_WIDTH_MEDIUM"],
								"DETAIL_HEIGHT_MEDIUM" => $arParams["DETAIL_HEIGHT_MEDIUM"],
								"DETAIL_WIDTH_BIG" => $arParams["DETAIL_WIDTH_BIG"],
								"DETAIL_HEIGHT_BIG" => $arParams["DETAIL_HEIGHT_BIG"],
								"PAGE_ELEMENT_COUNT_IN_ROW"=>$arParams["PAGE_ELEMENT_COUNT_IN_ROW"],
								"FILTER_CHECKED_FIRST_COLOR" => $arResult["FILTER_CHECKED_FIRST_COLOR"],
								"LAZY_LOAD" => $arParams["LAZY_LOAD"],
								"PRELOADER" => $arParams["PRELOADER"],
								"IMAGE_RESIZE_MODE" => $arParams["IMAGE_RESIZE_MODE"],
								"COLOR_IN_PRODUCT"=>$arParams["COLOR_IN_PRODUCT"],
								"COLOR_IN_PRODUCT_CODE" => $arParams["COLOR_IN_PRODUCT_CODE"],
								"COLOR_IN_PRODUCT_LINK"=>$arParams["COLOR_IN_PRODUCT_LINK"],
								"COLOR_IN_SECTION_LINK"=>$arParams["COLOR_IN_SECTION_LINK"],
								"COLOR_IN_SECTION_LINK_MAIN"=>$arParams["COLOR_IN_SECTION_LINK_MAIN"],
								"AJAX_PRODUCT_LOAD" => $arParams["AJAX_PRODUCT_LOAD"],

								'OPT_ARTICUL_PROPERTY' => $arParams["OPT_ARTICUL_PROPERTY"],
								'OPT_ARTICUL_PROPERTY_OFFER' => $arParams["OPT_ARTICUL_PROPERTY_OFFER"],
							),
							$component
								);

						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
function treeFilter($parent, $checked = array())
{
	foreach($parent as $child)
	{
		if(in_array($child['ID'], $checked))
		{
			$checked[]=$child['ID'];
			if($child['CHILD'])
			{
				foreach($child['CHILD'] as $childChild)
				{
					$checked[] = $childChild['ID'];
				}
				$checked=treeFilter($child['CHILD'], $checked);
			}
		}
	}
	$checked = array_unique($checked);
	return $checked;
}
?>