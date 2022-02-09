<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
global $arrBrandFilter;	 
$arrBrandFilter["PROPERTY_".COption::GetOptionString("sotbit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", "PROIZVODITEL_ATTR_E")] = $arResult["ID"];
?>
<div class="col-sm-6 sm-padding-left-no left-wrap">
	<div class="left-block">
<?   
	$APPLICATION->IncludeComponent(
	"sotbit:catalog.smart.filter.facet",
	"brand", 
	array(
		"IBLOCK_TYPE" => COption::GetOptionString("sotbit.b2bshop", "IBLOCK_TYPE", ""),
		"IBLOCK_ID" => COption::GetOptionString("sotbit.b2bshop", "IBLOCK_ID", ""), 
		"SECTION_ID" => "",
		"FILTER_NAME" => "arrBrandFilter",
		"PRICE_CODE" => ($_SESSION["SOTBIT_REGIONS"]["PRICE_CODE"] && COption::GetOptionString("sotbit.b2bshop","USE_MULTIREGIONS","Y") == 'Y')
			?$_SESSION["SOTBIT_REGIONS"]["PRICE_CODE"]:unserialize(COption::GetOptionString("sotbit.b2bshop","PRICE_CODE","")),
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "0",
		"CACHE_GROUPS" => "N",
		"SAVE_IN_SESSION" => "N",
		"XML_EXPORT" => "Y",
		"SECTION_TITLE" => "NAME",
		"SECTION_DESCRIPTION" => "DESCRIPTION",
		"HIDE_NOT_AVAILABLE" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
		"AJAX_OPTION_HISTORY" => "Y",
		"OFFER_TREE_PROPS" => unserialize(COption::GetOptionString("sotbit.b2bshop", "OFFER_TREE_PROPS", "")),
		"OFFER_COLOR_PROP" => COption::GetOptionString("sotbit.b2bshop", "OFFER_COLOR_PROP", ""),
		"SEF_MODE_FILTER" => "Y",
		"SECTIONS" => "Y",
		"SECTIONS_DEPTH_LEVEL" => "2",
		"FILTER_ITEM_COUNT" => COption::GetOptionString("sotbit.b2bshop", "FILTER_ITEM_COUNT", ""),
		"INSTANT_RELOAD" => "N"
	),
	false,
	array(
		"HIDE_ICONS" => "N"
	)
);
	?>
	</div>
</div>
<div class="col-sm-18">
	<div class="row">
		<div class="col-sm-24 sm-padding-right-no">
		<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "ms_breadcrumb_section", array(
								"START_FROM" => "0",
								"PATH" => "",
								"SITE_ID" => SITE_ID,
							),
							false,
							Array('HIDE_ICONS' => 'N')
							);?>
	   </div>					  
	<?
	//$this->EndViewTarget();
?>
<?/*if(isset($arResult["DETAIL_PICTURE"]) && !empty($arResult["DETAIL_PICTURE"])):?>
<div class="col-sm-24 sm-padding-right-no xs-padding-no">
	<div class="inner_banner_right_top">
			<img width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>" title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" class="img-responsive">
	</div>
</div>
<?endif;*/?>
<?
?>

<div class="col-sm-24 sm-padding-right-no xs-padding-no">
	<div class="banner_descpript">
		<div class="inner_descpript">
			<div class="row">
				<div class="col-sm-5 sm-padding-right-no">
					<?if($arResult["DETAIL_PICTURE"]):?>
					<div class="wrap_img">
						<img width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" title="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]?>" alt="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]?>" class="img-responsive">
					</div>
					<?elseif($arResult["PREVIEW_PICTURE"]):?>
					<div class="wrap_img">
						<img width="<?=$arResult["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arResult["PREVIEW_PICTURE"]["HEIGHT"]?>" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" title="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]?>" alt="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"]?>" class="img-responsive">
					</div>
					<?endif;?>
				</div>
				<?if($arResult["PREVIEW_TEXT"] )?>
				<div class="col-sm-19 sm-padding-right-no">
					<div class="wrap_text"><?=$arResult["PREVIEW_TEXT"]?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?if(CModule::IncludeModule('sotbit.mailing')):?>
<div class="col-sm-24 hidden-xs">
		<?$APPLICATION->IncludeComponent(
			"sotbit:sotbit.mailing.email.get",
			"ms_field_brand",
			Array(
				"TYPE" => "PROPERTY",
				"PARAM_2:PROPERTY" => COption::GetOptionString("sotbit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", "PROIZVODITEL_ATTR_E"),
				"PARAM_3:PROPERTY" => $arrBrandFilter["PROPERTY_".COption::GetOptionString("sotbit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", "PROIZVODITEL_ATTR_E")],
				"INFO_TEXT" => htmlspecialcharsBack($arParams['~MAILING_INFO_TEXT']),
				"EMAIL_SEND_END" => htmlspecialcharsBack($arParams['~MAILING_EMAIL_SEND_END']),
				"COLOR_BUTTON" => "6e7278",
				"DISPLAY_IF_ADMIN" => "Y",
				"DISPLAY_NO_AUTH" => "Y",
				"CATEGORIES_ID" => $arParams['MAILING_CATEGORIES_ID'],
			),
		false
		);
		?>
</div>
<?endif;?>
<?
$intSectionID = 0;
?><?

if(isset($_POST["count"])) $_SESSION["MS_COUNT"] = $_POST["count"];
if(isset($_POST["sort"])) $_SESSION["MS_SORT"] = $_POST["sort"];

$arAvailableSortSotbit = array(
	"name_0" => Array("name", "desc"),
	"name_1" => Array("name", "asc"),
	"price_0" => Array('PROPERTY_MINIMUM_PRICE', "desc"),
	"price_1" => Array('PROPERTY_MINIMUM_PRICE', "asc"),
	"date_0" => Array('DATE_CREATE', "desc"),
	"date_1" => Array('DATE_CREATE', "asc"),

);
if(isset($_SESSION["MS_SORT"]))
{
	$arSort = $arAvailableSortSotbit[$_SESSION["MS_SORT"]];
	$sort_field = $arSort[0];
	$sort_order = $arSort[1];
}
?>
<div class="col-sm-24 sm-padding-right-no">
	<div class="inner_title_brand">
		<h1 class="text"><?=$arResult["NAME"]?></h1>
	</div>
</div>
<?
$intSectionID = $APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"brands", 
	array(
		"IBLOCK_TYPE" => COption::GetOptionString("sotbit.b2bshop", "IBLOCK_TYPE", ""),
		"IBLOCK_ID" => COption::GetOptionString("sotbit.b2bshop", "IBLOCK_ID", ""),
		"ELEMENT_SORT_FIELD" => $sort_field?$sort_field:"NAME",
		"ELEMENT_SORT_ORDER" => $sort_order?$sort_order:"desc",
		"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
		"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
		"PROPERTY_CODE" => array(
			0 => COption::GetOptionString("sotbit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", "PROIZVODITEL_ATTR_E"),
		),
		"META_KEYWORDS" => "",
		"META_DESCRIPTION" => "",
		"BROWSER_TITLE" => "-",
		"INCLUDE_SUBSECTIONS" => "Y",
		"BASKET_URL" => "",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"SECTION_ID_VARIABLE" => "",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"FILTER_NAME" => "arrBrandFilter",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"DISPLAY_COMPARE" => "N",
		"PAGE_ELEMENT_COUNT" => $_SESSION["MS_COUNT"]?$_SESSION["MS_COUNT"]:$arParams["NEWS_COUNT"],
		"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
		"PRICE_CODE" => ($_SESSION["SOTBIT_REGIONS"]["PRICE_CODE"] && COption::GetOptionString("sotbit.b2bshop","USE_MULTIREGIONS","Y") == 'Y')
			?$_SESSION["SOTBIT_REGIONS"]["PRICE_CODE"]:unserialize(COption::GetOptionString("sotbit.b2bshop","PRICE_CODE","")),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
			0 => "CML2_MANUFACTURER",
		),
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "catalog",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "",
		"PAGER_SHOW_ALL" => "N",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "RAZMER_ATTR_S_DIRECTORY",
			1 => "TSVET_ATTR_S_DIRECTORY",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
		),
		"OFFERS_PROPERTY_CODE" => unserialize(COption::GetOptionString("sotbit.b2bshop", "OFFER_TREE_PROPS", "")),
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
		"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"CONVERT_CURRENCY" => "N",
		"CURRENCY_ID" => "RUB",
		"HIDE_NOT_AVAILABLE" => "N",
		"LABEL_PROP" => $arParams["LABEL_PROP"],
		"ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
		"PRODUCT_DISPLAY_MODE" => $arParams["PRODUCT_DISPLAY_MODE"],
		"OFFER_ADD_PICT_PROP" => $arParams["OFFER_ADD_PICT_PROP"],
		"OFFER_TREE_PROPS" => unserialize(COption::GetOptionString("sotbit.b2bshop", "OFFER_TREE_PROPS", "")),
		"PRODUCT_SUBSCRIPTION" => $arParams["PRODUCT_SUBSCRIPTION"],
		"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
		"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
		"MESS_BTN_BUY" => $arParams["MESS_BTN_BUY"],
		"MESS_BTN_ADD_TO_BASKET" => $arParams["MESS_BTN_ADD_TO_BASKET"],
		"MESS_BTN_SUBSCRIBE" => $arParams["MESS_BTN_SUBSCRIBE"],
		"MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
		"MESS_NOT_AVAILABLE" => $arParams["MESS_NOT_AVAILABLE"],
		"TEMPLATE_THEME" => (isset($arParams["TEMPLATE_THEME"])?$arParams["TEMPLATE_THEME"]:""),
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "Y",
		"BY_LINK" => "Y",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SHOW_ALL_WO_SECTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"BY_LINK" => "Y",
		"OFFER_COLOR_PROP" => COption::GetOptionString("sotbit.b2bshop", "OFFER_COLOR_PROP", ""),
		"MANUFACTURER_ELEMENT_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", ""),
		"MANUFACTURER_LIST_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MANUFACTURER_LIST_PROPS", ""),
		"FLAG_PROPS" => unserialize(COption::GetOptionString("sotbit.b2bshop", "FLAG_PROPS", "")),
		"DELETE_OFFER_NOIMAGE" => COption::GetOptionString("sotbit.b2bshop", "DELETE_OFFER_NOIMAGE", ""),
		"PICTURE_FROM_OFFER" => COption::GetOptionString("sotbit.b2bshop", "PICTURE_FROM_OFFER", ""),
		"MORE_PHOTO_PRODUCT_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MORE_PHOTO_PRODUCT_PROPS", ""),
		"MORE_PHOTO_OFFER_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MORE_PHOTO_OFFER_PROPS", ""),
		"AVAILABLE_DELETE" => COption::GetOptionString("sotbit.b2bshop", "AVAILABLE_DELETE", "N"),
		"LIST_WIDTH_SMALL" => COption::GetOptionString("sotbit.b2bshop", "LIST_WIDTH_SMALL", ""),
		"LIST_HEIGHT_SMALL" => COption::GetOptionString("sotbit.b2bshop", "LIST_HEIGHT_SMALL", ""),
		"LIST_WIDTH_MEDIUM" => COption::GetOptionString("sotbit.b2bshop", "LIST_WIDTH_MEDIUM", ""),
		"LIST_HEIGHT_MEDIUM" => COption::GetOptionString("sotbit.b2bshop", "LIST_HEIGHT_MEDIUM", ""),
		"DETAIL_PROPERTY_CODE" => unserialize(COption::GetOptionString("sotbit.b2bshop", "ALL_PROPS", "")),
		"DETAIL_WIDTH_SMALL" => COption::GetOptionString("sotbit.b2bshop", "DETAIL_WIDTH_SMALL", ""),
		"DETAIL_HEIGHT_SMALL" => COption::GetOptionString("sotbit.b2bshop", "DETAIL_HEIGHT_SMALL", ""),
		"DETAIL_WIDTH_MEDIUM" => COption::GetOptionString("sotbit.b2bshop", "DETAIL_WIDTH_MEDIUM", ""),
		"DETAIL_HEIGHT_MEDIUM" => COption::GetOptionString("sotbit.b2bshop", "DETAIL_HEIGHT_MEDIUM", ""),
		"DETAIL_WIDTH_BIG" => COption::GetOptionString("sotbit.b2bshop", "DETAIL_WIDTH_BIG", ""),
		"DETAIL_HEIGHT_BIG" => COption::GetOptionString("sotbit.b2bshop", "DETAIL_HEIGHT_BIG", ""),
	),
	false
);
if($arResult["~DETAIL_TEXT"]):
?>
<div class="col-sm-24 sm-padding-right-no">
	<div class="section_description">
		<h2 class="title"><?=$arResult["NAME"]?></h2>
		<?=$arResult["~DETAIL_TEXT"]?>
	</div>
</div>
<?endif;?>
<?

if(!empty($arrBrandFilter))
{
	if($arResult["VARIABLES"]["SECTION_ID"])
	{
		$arrBrandFilter["PROPERTY_PROIZVODITEL_ATTR_E"] = $arResult["ID"];
		$_SESSION["arrBrandFilter_MS"] = $arrBrandFilter;
	}
}else{
	unset($_SESSION["arrBrandFilter_MS"]);
	$_SESSION["arrBrandFilter_MS"]["PROPERTY_PROIZVODITEL_ATTR_E"] = $arResult["ID"];
}
if(isset($_REQUEST["bxajaxid"])) return false;
$ID = COption::GetOptionString("sotbit.b2bshop", "IBLOCK_ID", "");
$OFFER_IBLOCK_ID = COption::GetOptionString("sotbit.b2bshop", "OFFER_IBLOCK_ID", "");
$this->__template->SetViewTarget("ms_product_view");
$APPLICATION->IncludeComponent("bitrix:catalog.viewed.products", "catalog", array(
	"SHOW_FROM_SECTION" => "N",
	"HIDE_NOT_AVAILABLE" => "N",
	"SHOW_DISCOUNT_PERCENT" => "Y",
	"PRODUCT_SUBSCRIPTION" => "N",
	"SHOW_NAME" => "Y",
	"SHOW_IMAGE" => "Y",
	"MESS_BTN_BUY" => "??????",
	"MESS_BTN_DETAIL" => "?????????",
	"MESS_BTN_SUBSCRIBE" => "???????????",
	"PAGE_ELEMENT_COUNT" => "30",
	"DETAIL_URL" => "",
	"SHOW_OLD_PRICE" => "N",
	'OFFER_TREE_PROPS_'.$ID => unserialize(COption::GetOptionString("sotbit.b2bshop", "OFFER_TREE_PROPS", "")),
	"PRICE_CODE" => unserialize(COption::GetOptionString("sotbit.b2bshop", "PRICE_CODE", "")),
	"IBLOCK_TYPE" => COption::GetOptionString("sotbit.b2bshop", "IBLOCK_TYPE", ""),
	"IBLOCK_ID" => COption::GetOptionString("sotbit.b2bshop", "IBLOCK_ID", ""),
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "Y",
	"CONVERT_CURRENCY" => "N",
	"BASKET_URL" => "/personal/basket.php",
	"ACTION_VARIABLE" => "action",
	"PRODUCT_ID_VARIABLE" => "id",
	"ADD_PROPERTIES_TO_BASKET" => "Y",
	"PRODUCT_PROPS_VARIABLE" => "prop",
	"PARTIAL_PRODUCT_PROPERTIES" => "N",
	"USE_PRODUCT_QUANTITY" => "N",
	"SHOW_PRODUCTS_2" => "N",
	"SHOW_PRODUCTS_3" => "N",
	"SHOW_PRODUCTS_".$ID => "Y",
	"PROPERTY_CODE_".$ID => array(
		0 => "",
		1 => "",
	),
	"OFFER_TREE_PROPS_".$OFFER_IBLOCK_ID => unserialize(COption::GetOptionString("sotbit.b2bshop", "OFFER_TREE_PROPS", "")),
	"CART_PROPERTIES_".$ID => array(
		0 => "",
		1 => "",
	),
	"ADDITIONAL_PICT_PROP_".$ID => COption::GetOptionString("sotbit.b2bshop", "MORE_PHOTO_PRODUCT_PROPS", ""),
	"LABEL_PROP_70" => "-",
	"PROPERTY_CODE_77" => array(
		0 => "RAZMER_ATTR_S",
		1 => "",
	),
	"CART_PROPERTIES_".$OFFER_IBLOCK_ID => array(
		0 => "",
		1 => "RAZMER_ATTR_L",
		2 => "TSVET_ATTR_L",
		3 => "",
	),
	"ADDITIONAL_PICT_PROP_".$OFFER_IBLOCK_ID => "MORE_PHOTO",
	"SECTION_ID" => "",
	"SECTION_CODE" => "",
	"PRODUCT_QUANTITY_VARIABLE" => "quantity",
	"PROPERTY_CODE_2" => array(
		0 => "",
		1 => "",
	),
	"CART_PROPERTIES_2" => array(
		0 => "",
		1 => "",
	),
	"ADDITIONAL_PICT_PROP_2" => "MORE_PHOTO",
	"LABEL_PROP_2" => "-",
	"PROPERTY_CODE_3" => array(
		0 => "",
		1 => "",
	),
	"CART_PROPERTIES_3" => array(
		0 => "",
		1 => "",
	),
	"ADDITIONAL_PICT_PROP_3" => "MORE_PHOTO",
	"LABEL_PROP_3" => "-",
	"OBJECTIVE_IBLOCK_TYPE" => COption::GetOptionString("sotbit.b2bshop", "IBLOCK_TYPE", ""),
	"OBJECTIVE_IBLOCK_ID" => COption::GetOptionString("sotbit.b2bshop", "IBLOCK_ID", ""),
	"OFFER_COLOR_PROP" => COption::GetOptionString("sotbit.b2bshop", "OFFER_COLOR_PROP", ""),
	"MANUFACTURER_ELEMENT_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", ""),
	"MANUFACTURER_LIST_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MANUFACTURER_LIST_PROPS", ""),
	"FLAG_PROPS" => unserialize(COption::GetOptionString("sotbit.b2bshop", "FLAG_PROPS", "")),
	"DELETE_OFFER_NOIMAGE" => COption::GetOptionString("sotbit.b2bshop", "DELETE_OFFER_NOIMAGE", ""),
	"PICTURE_FROM_OFFER" => COption::GetOptionString("sotbit.b2bshop", "PICTURE_FROM_OFFER", ""),
	"MORE_PHOTO_PRODUCT_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MORE_PHOTO_PRODUCT_PROPS", ""),
	"MORE_PHOTO_OFFER_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MORE_PHOTO_OFFER_PROPS", ""),
	"AVAILABLE_DELETE" => COption::GetOptionString("sotbit.b2bshop", "AVAILABLE_DELETE", "N"),
	"LIST_WIDTH_SMALL" => COption::GetOptionString("sotbit.b2bshop", "LIST_WIDTH_SMALL", ""),
	"LIST_HEIGHT_SMALL" => COption::GetOptionString("sotbit.b2bshop", "LIST_HEIGHT_SMALL", ""),
	"LIST_WIDTH_MEDIUM" => COption::GetOptionString("sotbit.b2bshop", "LIST_WIDTH_MEDIUM", ""),
	"LIST_HEIGHT_MEDIUM" => COption::GetOptionString("sotbit.b2bshop", "LIST_HEIGHT_MEDIUM", ""),
	),
	false
);

$this->__template->EndViewTarget();?>  
	</div>
</div>