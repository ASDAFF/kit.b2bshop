<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(false);
?>
<?
$this->SetViewTarget("catalog_search");

$arElements = $APPLICATION->IncludeComponent(
	"bitrix:search.page",
	"ms_search",
	Array(
		"RESTART" => "Y",
		"NO_WORD_LOGIC" => "Y",
		"USE_LANGUAGE_GUESS" => "Y",
		"CHECK_DATES" => "Y",
		"arrFILTER" => array("iblock_".$arParams["IBLOCK_TYPE"]),
		"arrFILTER_iblock_".$arParams["IBLOCK_TYPE"] => array($arParams["IBLOCK_ID"]),
		"USE_TITLE_RANK" => "N",
		"DEFAULT_SORT" => "rank",
		"FILTER_NAME" => "",
		"SHOW_WHERE" => "N",
		"arrWHERE" => array(),
		"SHOW_WHEN" => "N",
		"PAGE_RESULT_COUNT" => 50,
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => GetMessage("SEARCH_TITLE"),
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "N",

	),
	$component
);
$this->EndViewTarget();

if(\CModule::includeModule('sotbit.seosearch'))
    $APPLICATION->IncludeComponent(
        "sotbit:seo.search",
        "",
        Array(
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
        )
    );

if (!empty($arElements) && is_array($arElements))
{
	global ${$arParams["FILTER_NAME"]};
	${$arParams["FILTER_NAME"]} = array(
		"ID" => $arElements,
	);
}

if ($arParams['USE_FILTER'] == 'Y')
{


	?>
<div class="col-sm-6 sm-padding-left-no left-wrap">
	<div class="left-block">
	<?
	$APPLICATION->IncludeComponent(
		"sotbit:catalog.smart.filter.facet",
		"brand",
		Array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"SECTION_ID" => "",
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SAVE_IN_SESSION" => "N",
			"XML_EXPORT" => "Y",
			"SECTION_TITLE" => "NAME",
			"SECTION_DESCRIPTION" => "DESCRIPTION",
			'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
			"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
			"AJAX_MODE" => $arParams["AJAX_MODE"],
			"AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
			"AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
			"AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
			"OFFER_TREE_PROPS" => $arParams['OFFER_TREE_PROPS'],
			"OFFER_COLOR_PROP" => $arParams["OFFER_COLOR_PROP"],
			"SEF_MODE_FILTER" => "N",
			"SECTIONS" => "Y",
			"SECTIONS_DEPTH_LEVEL" => "2",
			"FILTER_ITEM_COUNT" => $arParams["FILTER_ITEM_COUNT"]
		),
		$component,
		array('HIDE_ICONS' => 'Y')
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
			"SITE_ID" => "s1",
			"SSB_CODE_BACKGROUND" => "#fff",
			"SSB_CODE_BORDER" => "#000"
			),
			false,
			Array('HIDE_ICONS' => 'N')
			);?>
		<?
		$APPLICATION->IncludeComponent(
		"coffeediz:breadcrumb",
		"coffeediz.schema.org",
		Array(
			"COMPONENT_TEMPLATE" => "coffeediz.schema.org",
			"PATH" => "",
			"SHOW" => "Y",
			"SITE_ID" => SITE_ID,
			"START_FROM" => "0",
			)
		);
		?>
		</div>
	<?
}
?>
<?$APPLICATION->ShowViewContent("catalog_search");?>
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
global ${$arParams["FILTER_NAME"]};


$sectionTemplate = new \Sotbit\B2BShop\Client\Template\Section();
$template = $sectionTemplate->identifySectionView(0);

if (!empty($arElements) && is_array($arElements))
{
	$intSectionID = $APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	$template,
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
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
		"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

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
			// START PRODUCTS LINK
			"COLOR_IN_PRODUCT" => $arParams["COLOR_IN_PRODUCT"],
			"COLOR_IN_PRODUCT_LINK" => $arParams["COLOR_IN_PRODUCT_LINK"],
			"COLOR_IN_SECTION_LINK" => $arParams["COLOR_IN_SECTION_LINK"],
			// END PRODUCTS LINK
			"LAZY_LOAD" => $arParams["LAZY_LOAD"],
			"PRELOADER" => $arParams["PRELOADER"],
			// START FILTER COLOR FOR SECTION
			"FILTER_CHECKED_FIRST_COLOR" => $arResult["FILTER_CHECKED_FIRST_COLOR"] ,
			"IMAGE_RESIZE_MODE" => $arParams["IMAGE_RESIZE_MODE"],

	),
	$component
	);

	$arCurSection['ID'] = 0;

	unset($_SESSION[$arParams["FILTER_NAME"]."_MS"]);

    if(\CModule::includeModule('sotbit.seosearch'))
        $APPLICATION->IncludeComponent(
            "sotbit:seo.search.tags",
            ".default",
            Array(
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CNT_TAGS" => "",
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                "SORT" => "NAME",
                "SORT_ORDER" => "desc",
                "COMPONENT_TEMPLATE" => ".default",
            )
        );
    
	if(!empty(${$arParams["FILTER_NAME"]}))
	{
		if($arResult["VARIABLES"]["SECTION_ID"])
		{
			$keyID = $arCurSection['ID'];
			${$arParams["FILTER_NAME"]}["SECTION_ID"] = $keyID;
			$_SESSION[$arParams["FILTER_NAME"]."_MS"][$keyID] = ${$arParams["FILTER_NAME"]};
			$_SESSION[$arParams["FILTER_NAME"]."_SORT_MS"][$keyID] = array($sort_field?$sort_field:$arParams["ELEMENT_SORT_FIELD"]=>$sort_order?$sort_order:$arParams["ELEMENT_SORT_ORDER"]);

		}
	}else{
		$keyID = $arCurSection['ID'];
		unset($_SESSION[$arParams["FILTER_NAME"]."_MS"][$keyID]);
		$_SESSION[$arParams["FILTER_NAME"]."_MS"][$keyID]["SECTION_ID"] = $keyID;
		$_SESSION[$arParams["FILTER_NAME"]."_SORT_MS"][$keyID] = array($sort_field?$sort_field:$arParams["ELEMENT_SORT_FIELD"]=>$sort_order?$sort_order:$arParams["ELEMENT_SORT_ORDER"]);

	}

}
?>
	</div>
</div>