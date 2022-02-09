<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Config\Option;
if(!CModule::IncludeModule("sotbit.b2bshop") || !B2BSSotbit::getDemo()) return false;
$this->setFrameMode(true);
if ($arParams['USE_FILTER'] == 'Y')
{
	?>
<div class="col-sm-6 sm-padding-left-no left-wrap">
	<div class="left-block">
	<?
	$APPLICATION->IncludeComponent(
		"sotbit:catalog.smart.filter.facet",
		"catalog",
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
</div>
<div class="col-sm-18">
	<div class="row">
		<div class="col-sm-24 sm-padding-right-no">
		<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "ms_breadcrumb_section", array(
								"START_FROM" => "0",
								"PATH" => "",
								"SITE_ID" => SITE_ID,
								"SSB_CODE_BACKGROUND" => "#fff",
								"SSB_CODE_BORDER" => "#000"
							),
							false,
							Array('HIDE_ICONS' => 'N')
							);?>
							<?
   								 //????????????? breadcrumb #START
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
	//$this->EndViewTarget();
}
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"ms_img",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_FIELDS" => array("PICTURE"),
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
	),
	$component
);?>


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
elseif(empty($_SESSION["MS_SORT"]) && $arAvailableSortSotbit[$arParams["ELEMENT_SORT_FIELD"]]) {
	$arSort = $arAvailableSortSotbit[$arParams["ELEMENT_SORT_FIELD"]];
	$sort_field = $arSort[0];
	$sort_order = $arSort[1];
}
global ${$arParams["FILTER_NAME"]};
if(
		$arParams['COLOR_IN_PRODUCT'] == 'Y' &&
		$arParams['COLOR_IN_SECTION_LINK'] == 2 &&
		$arParams['COLOR_IN_SECTION_LINK_MAIN'] )
{
	if(empty( ${$arParams["FILTER_NAME"]}['OFFERS'] ))
	{
		$arFilter = array(
				'IBLOCK_ID' => $arParams['IBLOCK_ID'],
				'ACTIVE'=>'Y',
				'CODE'=>$arParams["COLOR_IN_SECTION_LINK_MAIN"]
		);

		$Property = CIBlockProperty::GetList(
				array(),
				$arFilter
				)->Fetch();

				if(isset($Property))
				{
					if($Property['PROPERTY_TYPE'] == 'L') //list
					{
						${$arParams["FILTER_NAME"]}['=PROPERTY_'.$arParams["COLOR_IN_SECTION_LINK_MAIN"]."_VALUE"] = array(

								'true',
								'TRUE',
								'Y',
								'y',
								\Bitrix\Main\Localization\Loc::getMessage("COLOR_IN_SECTION_YES_1"),
								\Bitrix\Main\Localization\Loc::getMessage("COLOR_IN_SECTION_YES_2"),
								\Bitrix\Main\Localization\Loc::getMessage("COLOR_IN_SECTION_YES_3"),
						);
					}
					else
					{
						${$arParams["FILTER_NAME"]}['=PROPERTY_'.$arParams["COLOR_IN_SECTION_LINK_MAIN"]] = array(
								'true',
								'TRUE',
								'Y',
								'y',
								\Bitrix\Main\Localization\Loc::getMessage("COLOR_IN_SECTION_YES_1"),
								\Bitrix\Main\Localization\Loc::getMessage("COLOR_IN_SECTION_YES_2"),
								\Bitrix\Main\Localization\Loc::getMessage("COLOR_IN_SECTION_YES_3"),
						);
					}
				}
	}
}

$sectionTemplate = new \Sotbit\B2BShop\Client\Template\Section();
$template = $sectionTemplate->identifySectionView(0);
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
	),
	$component
);
//printr($arResult);

$arCurSection['ID'] = 0;

unset($_SESSION[$arParams["FILTER_NAME"]."_MS"]);

/*if(isset($_SESSION[$arParams["FILTER_NAME"]."_MS"]))
{
	foreach($_SESSION[$arParams["FILTER_NAME"]."_MS"] as &$sParam)
	{
		unset($sParam);
	}

	foreach($_SESSION[$arParams["FILTER_NAME"]."_SORT_MS"] as &$sSort)
	{
		unset($sSort);
	}
}*/

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

if(isset($_REQUEST["bxajaxid"])) return false;

$context = \Bitrix\Main\Application::getInstance()->getContext();
$server = $context->getServer();
if(\Bitrix\Main\Config\Option::get("sotbit.b2bshop", "SHOW_BIG_DATA_SECTION_UNDER","Y") == 'Y' && \Bitrix\Main\Config\Option::get("main", "gather_catalog_stat","N") == 'Y' && is_dir($server->getDocumentRoot().$server->getPersonalRoot().'/components/bitrix/catalog.bigdata.products'))
{
	if( !defined( 'ERROR_404' ) )
	{
		$mxResult = CCatalogSKU::GetInfoByProductIBlock( Option::get( "sotbit.b2bshop", "IBLOCK_ID", "" ));
		if( is_array( $mxResult ) )
		{
			$offersIblock = $mxResult['IBLOCK_ID'];
		}
		unset($mxResult);
		$this->SetViewTarget( 'ms_big_data' );


		$idUserGroups = [];
		$userPriceCode = [];
		$rs = CCatalogGroup::GetGroupsList(array("GROUP_ID"=>$USER->GetGroups(), "BUY"=>"Y"));
		while($group = $rs->Fetch())
		{
			$idUserGroups[$group['CATALOG_GROUP_ID']] = $group['CATALOG_GROUP_ID'];
		}
		if($idUserGroups)
		{
			$rs = \Bitrix\Catalog\GroupTable::getList(['filter' => ['ID' => $idUserGroups],'select' => ['NAME']]);
			while($group = $rs->fetch())
			{
				$userPriceCode[] = $group['NAME'];
			}
		}
		if(!$userPriceCode)
		{
			$userPriceCode = $arParams['PRICE_CODE'];
		}



		$APPLICATION->IncludeComponent( 'bitrix:catalog.bigdata.products', 'section',
				Array(
						'ACTION_VARIABLE' => 'action_cbdp',
						'ADD_PROPERTIES_TO_BASKET' => "Y",
						'AJAX_PRODUCT_LOAD' => Option::get( "sotbit.b2bshop", "AJAX_PRODUCT_LOAD", "" ),
						'AVAILABLE_DELETE' => Option::get( "sotbit.b2bshop", "AVAILABLE_DELETE", "N" ),
						'BASKET_URL' => Option::get( "sotbit.b2bshop", "URL_CART", "" ),
						'CACHE_GROUPS' => "Y",
						'CACHE_TIME' => '36000000',
						'CACHE_TYPE' => 'A',
						"COLOR_IN_PRODUCT" => Option::get( "sotbit.b2bshop", "COLOR_IN_PRODUCT", "" ),
						"COLOR_IN_PRODUCT_CODE" => Option::get( "sotbit.b2bshop", "COLOR_IN_PRODUCT_CODE", "" ),
						"COLOR_IN_PRODUCT_LINK" => Option::get( "sotbit.b2bshop", "COLOR_IN_PRODUCT_LINK", "" ),
						"COLOR_IN_SECTION_LINK" => Option::get( "sotbit.b2bshop", "COLOR_IN_SECTION_LINK", "1" ),
						'CONVERT_CURRENCY' => 'Y',
						'CURRENCY_ID' => '',
						'DELETE_OFFER_NOIMAGE' => Option::get( "sotbit.b2bshop", "DELETE_OFFER_NOIMAGE", "" ),
						"DETAIL_HEIGHT_BIG" => Option::get( "sotbit.b2bshop", "DETAIL_HEIGHT_BIG", "" ),
						"DETAIL_HEIGHT_MEDIUM" => Option::get( "sotbit.b2bshop", "DETAIL_HEIGHT_MEDIUM", "" ),
						"DETAIL_HEIGHT_SMALL" => Option::get( "sotbit.b2bshop", "DETAIL_HEIGHT_SMALL", "" ),
						"DETAIL_PROPERTY_CODE" => unserialize( Option::get( "sotbit.b2bshop", "ALL_PROPS", "" ) ),
						'DEPTH' => '2',
						'DETAIL_URL' => '',
						'FLAG_PROPS' => unserialize( Option::get( "sotbit.b2bshop", "FLAG_PROPS", "" ) ),
						'HIDE_NOT_AVAILABLE' => "N",
						"IBLOCK_ID" => Option::get( "sotbit.b2bshop", "IBLOCK_ID", "" ),
						"IBLOCK_TYPE" => Option::get( "sotbit.b2bshop", "IBLOCK_TYPE", "" ),
						"IMAGE_RESIZE_MODE" => Option::get( "sotbit.b2bshop", "IMAGE_RESIZE_MODE", BX_RESIZE_IMAGE_PROPORTIONAL ),
						'LAZY_LOAD' => Option::get( "sotbit.b2bshop", "LAZY_LOAD", "" ),
						"LIST_HEIGHT_MEDIUM" => "455",
						"LIST_HEIGHT_SMALL" => "150",
						"LIST_WIDTH_MEDIUM" => "255",
						"LIST_WIDTH_SMALL" => "90",
						"MANUFACTURER_ELEMENT_PROPS" => Option::get( "sotbit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", "" ),
						"MANUFACTURER_LIST_PROPS" => Option::get( "sotbit.b2bshop", "MANUFACTURER_LIST_PROPS", "" ),
						'MESS_BTN_BUY' => '',
						'MESS_BTN_DETAIL' => '',
						'MESS_BTN_SUBSCRIBE' => '',
						"MORE_PHOTO_OFFER_PROPS" => Option::get( "sotbit.b2bshop", "MORE_PHOTO_OFFER_PROPS", "" ),
						"MORE_PHOTO_PRODUCT_PROPS" => Option::get( "sotbit.b2bshop", "MORE_PHOTO_PRODUCT_PROPS", "" ),
						"OFFER_COLOR_PROP" => Option::get( "sotbit.b2bshop", "OFFER_COLOR_PROP", "" ),
						"OFFERS_PROPERTY_CODE" => unserialize( Option::get( "sotbit.b2bshop", "OFFER_TREE_PROPS", "" ) ),
						'OFFER_TREE_PROPS_' . $offersIblock => unserialize( Option::get( "sotbit.b2bshop", "OFFER_TREE_PROPS", "" ) ),
						'PAGE_ELEMENT_COUNT' => '30',
						'PARTIAL_PRODUCT_PROPERTIES' => "N",
						"PICTURE_FROM_OFFER" => Option::get( "sotbit.b2bshop", "PICTURE_FROM_OFFER", "" ),
						"PRELOADER" => Option::get( "sotbit.preloader", "IMAGE", "" ),
						"PRICE_CODE" => $userPriceCode,
						'PRICE_VAT_INCLUDE' => "Y",
						'PROPERTY_CODE_' . Option::get( "sotbit.b2bshop", "IBLOCK_ID", "" ) => array(),
						'PROPERTY_CODE_' . $offersIblock => unserialize( Option::get( "sotbit.b2bshop", "OFFER_TREE_PROPS", "" ) ),
						'PRODUCT_ID_VARIABLE' => 'id',
						'PRODUCT_PROPS_VARIABLE' => 'prop',
						'PRODUCT_QUANTITY_VARIABLE' => 'quantity',
						'PRODUCT_SUBSCRIPTION' => '',
						'RCM_TYPE' => 'personal',
						'SECTION_CODE' => '',
						'SECTION_ELEMENT_CODE' => '',
						'SECTION_ELEMENT_ID' => '',
						'SECTION_ID' => '',
						'SHOW_DISCOUNT_PERCENT' => 'Y',
						'SHOW_FROM_SECTION' => 'N',
						'SHOW_IMAGE' => 'Y',
						'SHOW_NAME' => 'Y',
						'SHOW_OLD_PRICE' => 'N',
						'SHOW_PRICE_COUNT' => '1',
						'SHOW_PRODUCTS_' . Option::get( "sotbit.b2bshop", "IBLOCK_ID", "" ) => 'Y',
						'USE_PRODUCT_QUANTITY' => "N"
						) );
		$this->EndViewTarget();
		unset($context, $server);
	}
}

$this->SetViewTarget("ms_product_view");

if(isset($_COOKIE['ms_viewed_products']) && sizeof($_COOKIE['ms_viewed_products'])>0)
{
	if( !defined( 'ERROR_404' ) )
	{
		global $ViewedProducts;

		$Cook = array_reverse($_COOKIE['ms_viewed_products']);
		$Cook = array_unique($Cook);

		$ElementCnt = 30;
		$Cook = array_slice($Cook, 0, $ElementCnt);

		$ViewedProducts=array('ID'=>$Cook);

		$APPLICATION->IncludeComponent( "bitrix:catalog.top", "catalog_viewed_products", array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"LAZY_LOAD" => $arParams["LAZY_LOAD"],
				"PRELOADER" => $arParams["PRELOADER"],
				"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
				"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
				"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
				"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
				"FILTER_NAME" => "ViewedProducts",
				"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
				"ELEMENT_COUNT" => $ElementCnt,
				"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
				"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
				"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
				"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
				"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
				"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
				"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
				"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
				"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
				"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
				"CACHE_FILTER" => $arParams["CACHE_FILTER"],
				"PRICE_CODE" => $arParams["PRICE_CODE"],
				"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
				"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
				"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
				"CURRENCY_ID" => $arParams["CURRENCY_ID"],
				"BASKET_URL" => $arParams["BASKET_URL"],
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
				"ADD_PROPERTIES_TO_BASKET" => $arParams["ADD_PROPERTIES_TO_BASKET"],
				"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
				"PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
				"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
				"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
				"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
				"USERS_COUNT" => $arResult["USERS_COUNT"],
				"OFFER_TREE_PROPS" => $arParams["OFFER_TREE_PROPS"],
				"OFFER_COLOR_PROP" => $arParams["OFFER_COLOR_PROP"],
				"MANUFACTURER_ELEMENT_PROPS" => $arParams["MANUFACTURER_ELEMENT_PROPS"],
				"MANUFACTURER_LIST_PROPS" => $arParams["MANUFACTURER_LIST_PROPS"],
				"FLAG_PROPS" => $arParams["FLAG_PROPS"],
				"DELETE_OFFER_NOIMAGE" => $arParams["DELETE_OFFER_NOIMAGE"],
				"PICTURE_FROM_OFFER" => $arParams["PICTURE_FROM_OFFER"],
				"MORE_PHOTO_PRODUCT_PROPS" => $arParams["MORE_PHOTO_PRODUCT_PROPS"],
				"MORE_PHOTO_OFFER_PROPS" => $arParams["MORE_PHOTO_OFFER_PROPS"],
				"LIST_WIDTH_SMALL" => $arParams["LIST_WIDTH_SMALL"],
				"LIST_HEIGHT_SMALL" => $arParams["LIST_HEIGHT_SMALL"],
				"LIST_WIDTH_MEDIUM" => $arParams["LIST_WIDTH_MEDIUM"],
				"LIST_HEIGHT_MEDIUM" => $arParams["LIST_HEIGHT_MEDIUM"],
				"DETAIL_WIDTH_SMALL" => $arParams["DETAIL_WIDTH_SMALL"],
				"DETAIL_HEIGHT_SMALL" => $arParams["DETAIL_HEIGHT_SMALL"],
				"DETAIL_WIDTH_MEDIUM" => $arParams["DETAIL_WIDTH_MEDIUM"],
				"COLOR_IN_PRODUCT" => $arParams["COLOR_IN_PRODUCT"],
				"COLOR_IN_PRODUCT_CODE" => $arParams["COLOR_IN_PRODUCT_CODE"],
				"COLOR_IN_PRODUCT_LINK" => $arParams["COLOR_IN_PRODUCT_LINK"],
				"COLOR_IN_SECTION_LINK" => $arParams["COLOR_IN_SECTION_LINK"],
				"DETAIL_HEIGHT_MEDIUM" => $arParams["DETAIL_HEIGHT_MEDIUM"],
				"DETAIL_WIDTH_BIG" => $arParams["DETAIL_WIDTH_BIG"],
				"DETAIL_HEIGHT_BIG" => $arParams["DETAIL_HEIGHT_BIG"],
				"DETAIL_PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
				"USERS_COUNT_TEXT" => $arResult["USERS_COUNT_TEXT"],
				"AVAILABLE_DELETE" => $arParams["AVAILABLE_DELETE"],
				"AJAX_PRODUCT_LOAD" => $arParams["AJAX_PRODUCT_LOAD"],
				"IMAGE_RESIZE_MODE" => $arParams["IMAGE_RESIZE_MODE"]
		));
	}
}
?>
<?$this->EndViewTarget();?>
	</div>
</div>