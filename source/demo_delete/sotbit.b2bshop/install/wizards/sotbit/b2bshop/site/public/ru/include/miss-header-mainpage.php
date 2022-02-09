<?
use Bitrix\Main\Config\Option;
global $BRAND_PROP;
global $BRAND_IBLOCK_ID;
global $BRAND_IBLOCK_TYPE;
$BANNER_IBLOCK_TYPE = Option::get( "sotbit.b2bshop", "BANNER_IBLOCK_TYPE", "" );
$BANNER_IBLOCK_ID = Option::get( "sotbit.b2bshop", "BANNER_IBLOCK_ID", "" );

$APPLICATION->IncludeComponent( "bitrix:news.list", "miss-banner-main-big", 
		array(
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"ADD_SECTIONS_CHAIN" => "N",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "N",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"CHECK_DATES" => "N",
				"COMPONENT_TEMPLATE" => "miss-banner-main-big",
				"DETAIL_URL" => "",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"DISPLAY_DATE" => "N",
				"DISPLAY_NAME" => "N",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "N",
				"DISPLAY_TOP_PAGER" => "N",
				"FIELD_CODE" => array(
						0 => "",
						1 => "" 
				),
				"FILTER_NAME" => "",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"IBLOCK_ID" => $BANNER_IBLOCK_ID,
				"IBLOCK_TYPE" => $BANNER_IBLOCK_TYPE,
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"INCLUDE_SUBSECTIONS" => "N",
				"LIST_HEIGHT_IMG" => "674",
				"LIST_WIDTH_IMG" => "1170",
				"NEWS_COUNT" => "10",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "main-banner",
				"PREVIEW_TRUNCATE_LEN" => "",
				"PROPERTY_CODE" => array(
						0 => "LINK",
						1 => "VIDEO" 
				),
				"SET_BROWSER_TITLE" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "N",
				"SORT_BY1" => "SORT",
				"SORT_BY2" => "ACTIVE_FROM",
				"SORT_ORDER1" => "ASC",
				"SORT_ORDER2" => "DESC" 
		), false );
/* End main banner */
?>
<div class="main-center-block">
<?
/* Small banner */
$APPLICATION->IncludeComponent( "bitrix:news.list", "miss-banner-main-small", 
		array(
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"ADD_SECTIONS_CHAIN" => "N",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "N",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"CHECK_DATES" => "N",
				"COMPONENT_TEMPLATE" => "miss-banner-main-small",
				"DETAIL_URL" => "",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"DISPLAY_DATE" => "N",
				"DISPLAY_NAME" => "N",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "N",
				"DISPLAY_TOP_PAGER" => "N",
				"FIELD_CODE" => array(
						0 => "",
						1 => "" 
				),
				"FILTER_NAME" => "",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"IBLOCK_ID" => $BANNER_IBLOCK_ID,
				"IBLOCK_TYPE" => $BANNER_IBLOCK_TYPE,
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"INCLUDE_SUBSECTIONS" => "N",
				"LIST_HEIGHT_IMG" => "226",
				"LIST_WIDTH_IMG" => "370",
				"NEWS_COUNT" => "3",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "bannery-na-glavnoy-pod-slayderom",
				"PREVIEW_TRUNCATE_LEN" => "",
				"PROPERTY_CODE" => array(
						0 => "",
						1 => "LINK",
						2 => "" 
				),
				"SET_BROWSER_TITLE" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "N",
				"SORT_BY1" => "SORT",
				"SORT_BY2" => "SORT",
				"SORT_ORDER1" => "ASC",
				"SORT_ORDER2" => "ASC" 
		), false );

if( $BRAND_IBLOCK_ID && $BRAND_IBLOCK_TYPE)
{
	global $arFilterPage;
	$arFilterPage["PROPERTY_MAIN_PAGE_SHOW_VALUE"] = "Y";
	$APPLICATION->IncludeComponent( "bitrix:news.list", "ms_brand_slide_main", 
			array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"ADD_SECTIONS_CHAIN" => "N",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "N",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "N",
					"CACHE_NOTES" => "",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"CHECK_DATES" => "N",
					"COMPONENT_TEMPLATE" => "ms_brand_slide_main",
					"DETAIL_URL" => "",
					"DISPLAY_BLOCK_TITLE_TEXT" => "",
					"DISPLAY_BLOCK_TITLE_TEXT_SECOND" => GetMessage( "HEADER_BRAND_TITLE_TEXT" ),
					"DISPLAY_BOTTOM_PAGER" => "N",
					"DISPLAY_DATE" => "N",
					"DISPLAY_NAME" => "N",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "N",
					"DISPLAY_TOP_PAGER" => "N",
					"FIELD_CODE" => array(
							0 => "",
							1 => "" 
					),
					"FILTER_NAME" => "arFilterPage",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"IBLOCK_ID" => $BRAND_IBLOCK_ID,
					"IBLOCK_TYPE" => $BRAND_IBLOCK_TYPE,
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"INCLUDE_SUBSECTIONS" => "N",
					"NEWS_COUNT" => "20",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => ".default",
					"PAGER_TITLE" => "",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"PREVIEW_TRUNCATE_LEN" => "",
					"PROPERTY_CODE" => array(
							0 => "",
							1 => "" 
					),
					"SET_BROWSER_TITLE" => "N",
					"SET_META_DESCRIPTION" => "N",
					"SET_META_KEYWORDS" => "N",
					"SET_STATUS_404" => "N",
					"SET_TITLE" => "N",
					"SORT_BY1" => "SORT",
					"SORT_BY2" => "SORT",
					"SORT_ORDER1" => "ASC",
					"SORT_ORDER2" => "ASC" 
			), false );
}
?>
</div>
<?

$PriceCode = ($_SESSION["SOTBIT_REGIONS"]["PRICE_CODE"] & COption::GetOptionString("sotbit.b2bshop","USE_MULTIREGIONS","Y") == 'Y')
	?$_SESSION["SOTBIT_REGIONS"]["PRICE_CODE"]:unserialize(COption::GetOptionString("sotbit.b2bshop","PRICE_CODE",""));
$context = \Bitrix\Main\Application::getInstance()->getContext();
$server = $context->getServer();
if( \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "SHOW_BIG_DATA_MAINPAGE", "Y" ) == 'Y' && \Bitrix\Main\Config\Option::get( "main", "gather_catalog_stat", "N" ) == 'Y' && is_dir( 
		$server->getDocumentRoot() . $server->getPersonalRoot() . '/components/bitrix/catalog.bigdata.products' ) )
{
	$mxResult = CCatalogSKU::GetInfoByProductIBlock( Option::get( "sotbit.b2bshop", "IBLOCK_ID", "" ) );
	if( is_array( $mxResult ) )
	{
		$offersIblock = $mxResult['IBLOCK_ID'];
	}

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
		$userPriceCode = $PriceCode;
	}

	$APPLICATION->IncludeComponent( 'bitrix:catalog.bigdata.products', 'mainpage', 
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
					"HIDE_NOT_AVAILABLE" => COption::GetOptionString("sotbit.b2bshop","HIDE_NOT_AVAILABLE","L"),
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
}
if( \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "SHOW_BUYING_MAINPAGE", "Y" ) == 'Y')
{
	$APPLICATION->IncludeComponent( "shs:shs.onlinebuyers", "main", 
			array(
					'AJAX_PRODUCT_LOAD' => Option::get( "sotbit.b2bshop", "AJAX_PRODUCT_LOAD", "" ),
					"ACTION_VARIABLE" => "action",
					"ADD_PROPERTIES_TO_BASKET" => "Y",
					"AVAILABLE_DELETE" => Option::get( "sotbit.b2bshop", "AVAILABLE_DELETE", "N" ),
					"BASKET_URL" => Option::get( "sotbit.b2bshop", "URL_CART", "" ),
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"COLOR_IN_PRODUCT" => Option::get( "sotbit.b2bshop", "COLOR_IN_PRODUCT", "" ),
					"COLOR_IN_PRODUCT_CODE" => Option::get( "sotbit.b2bshop", "COLOR_IN_PRODUCT_CODE", "" ),
					"COLOR_IN_PRODUCT_LINK" => Option::get( "sotbit.b2bshop", "COLOR_IN_PRODUCT_LINK", "" ),
					"COLOR_IN_SECTION_LINK" => Option::get( "sotbit.b2bshop", "COLOR_IN_SECTION_LINK", "1" ),
					"COMPONENT_TEMPLATE" => "main",
					"CONVERT_CURRENCY" => "Y",
					"CURRENCY_ID" => "",
					"DELETE_OFFER_NOIMAGE" => Option::get( "sotbit.b2bshop", "DELETE_OFFER_NOIMAGE", "" ),
					"DETAIL_HEIGHT_BIG" => Option::get( "sotbit.b2bshop", "DETAIL_HEIGHT_BIG", "" ),
					"DETAIL_HEIGHT_MEDIUM" => Option::get( "sotbit.b2bshop", "DETAIL_HEIGHT_MEDIUM", "" ),
					"DETAIL_HEIGHT_SMALL" => Option::get( "sotbit.b2bshop", "DETAIL_HEIGHT_SMALL", "" ),
					"DETAIL_PROPERTY_CODE" => unserialize( Option::get( "sotbit.b2bshop", "ALL_PROPS", "" ) ),
					"DETAIL_URL" => "",
					"DETAIL_WIDTH_BIG" => Option::get( "sotbit.b2bshop", "DETAIL_WIDTH_BIG", "" ),
					"DETAIL_WIDTH_MEDIUM" => Option::get( "sotbit.b2bshop", "DETAIL_WIDTH_MEDIUM", "" ),
					"DETAIL_WIDTH_SMALL" => Option::get( "sotbit.b2bshop", "DETAIL_WIDTH_SMALL", "" ),
					"DISPLAY_COMPARE" => "N",
					"ELEMENT_COUNT" => "20",
					"ELEMENT_SORT_FIELD" => "sort",
					"ELEMENT_SORT_FIELD2" => "id",
					"ELEMENT_SORT_ORDER" => "asc",
					"ELEMENT_SORT_ORDER2" => "desc",
					"FILTER_NAME" => "",
					"FLAG_PROPS" => unserialize( Option::get( "sotbit.b2bshop", "FLAG_PROPS", "" ) ),
					"HIDE_NOT_AVAILABLE" => COption::GetOptionString("sotbit.b2bshop","HIDE_NOT_AVAILABLE","L"),
					"IBLOCK_ID" => Option::get( "sotbit.b2bshop", "IBLOCK_ID", "" ),
					"IBLOCK_TYPE" => Option::get( "sotbit.b2bshop", "IBLOCK_TYPE", "" ),
					"IMAGE_HEIGHT" => "448",
					"IMAGE_RESIZE_MODE" => Option::get( "sotbit.b2bshop", "IMAGE_RESIZE_MODE", BX_RESIZE_IMAGE_PROPORTIONAL ),
					"IMAGE_WIDTH" => "255",
					"JQUERY" => "N",
					"LAZY_LOAD" => Option::get( "sotbit.b2bshop", "LAZY_LOAD", "" ),
					"LINE_ELEMENT_COUNT" => "3",
					"LIST_HEIGHT_MEDIUM" => "455",
					"LIST_HEIGHT_SMALL" => "150",
					"LIST_WIDTH_MEDIUM" => "255",
					"LIST_WIDTH_SMALL" => "90",
					"MANUFACTURER_ELEMENT_PROPS" => Option::get( "sotbit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", "" ),
					"MANUFACTURER_LIST_PROPS" => Option::get( "sotbit.b2bshop", "MANUFACTURER_LIST_PROPS", "" ),
					"MORE_PHOTO_OFFER_PROPS" => Option::get( "sotbit.b2bshop", "MORE_PHOTO_OFFER_PROPS", "" ),
					"MORE_PHOTO_PRODUCT_PROPS" => Option::get( "sotbit.b2bshop", "MORE_PHOTO_PRODUCT_PROPS", "" ),
					"OFFERS_CART_PROPERTIES" => array(
							0 => "" 
					),
					"OFFERS_FIELD_CODE" => array(
							0 => "",
							1 => "" 
					),
					"OFFERS_LIMIT" => "100",
					"OFFERS_PROPERTY_CODE" => unserialize( Option::get( "sotbit.b2bshop", "OFFER_TREE_PROPS", "" ) ),
					"OFFERS_SORT_FIELD" => "sort",
					"OFFERS_SORT_FIELD2" => "id",
					"OFFERS_SORT_ORDER" => "asc",
					"OFFERS_SORT_ORDER2" => "desc",
					"OFFER_COLOR_PROP" => Option::get( "sotbit.b2bshop", "OFFER_COLOR_PROP", "" ),
					"OFFER_TREE_PROPS" => unserialize( Option::get( "sotbit.b2bshop", "OFFER_TREE_PROPS", "" ) ),
					"ONLINE_TYPE" => "0",
					"PARTIAL_PRODUCT_PROPERTIES" => "N",
					"PICTURE_FROM_OFFER" => Option::get( "sotbit.b2bshop", "PICTURE_FROM_OFFER", "" ),
					"PRELOADER" => Option::get( "sotbit.preloader", "IMAGE", "" ),
					"PRICE_CODE" => $PriceCode,
					"PRICE_VAT_INCLUDE" => "Y",
					"PRODUCT_ID_VARIABLE" => "id",
					"PRODUCT_PROPERTIES" => array(),
					"PRODUCT_PROPS_VARIABLE" => "prop",
					"PRODUCT_QUANTITY_VARIABLE" => "quantity",
					"PROPERTY_CODE" => array(
							0 => Option::get( "sotbit.b2bshop", "MORE_PHOTO_PRODUCT_PROPS", "" ),
					),
					"SECTION_ID_VARIABLE" => "SECTION_ID",
					"SECTION_URL" => "",
					"SHOW_CITY" => "N",
					"SHOW_COUNT_BUYERS" => "Y",
					"SHOW_NAME" => "0",
					"SHOW_PRICE_COUNT" => "1",
					"SITE" => SITE_ID,
					"TYPE_COUNT_BUYERS" => "1",
					"TYPE_COUNT_BUYERS_MAX" => "20",
					"TYPE_COUNT_BUYERS_MIN" => "10",
					"TYPE_MODE" => "Y",
					"USE_PRICE_COUNT" => "N",
					"USE_PRODUCT_QUANTITY" => "N" 
			), false );
}
$NEWS_IBLOCK_TYPE = Option::get( "sotbit.b2bshop", "NEWS_IBLOCK_TYPE", "" );
$NEWS_IBLOCK_ID = Option::get( "sotbit.b2bshop", "NEWS_IBLOCK_ID", "" );
if( $NEWS_IBLOCK_TYPE && $NEWS_IBLOCK_ID )
{
	$APPLICATION->IncludeComponent( "bitrix:news", "ms_news_main_page", 
			array(
					"ADD_ELEMENT_CHAIN" => "N",
					"ADD_SECTIONS_CHAIN" => "N",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "N",
					"BROWSER_TITLE" => "-",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "N",
					"CACHE_NOTES" => "",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"CHECK_DATES" => "N",
					"COMPONENT_TEMPLATE" => "ms_news_main_page",
					"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
					"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
					"DETAIL_DISPLAY_TOP_PAGER" => "N",
					"DETAIL_FIELD_CODE" => "",
					"DETAIL_PAGER_SHOW_ALL" => "N",
					"DETAIL_PAGER_TEMPLATE" => "",
					"DETAIL_PAGER_TITLE" => "",
					"DETAIL_PROPERTY_CODE" => "",
					"DISPLAY_BLOCK_TITLE_TEXT" => "",
					"DISPLAY_BLOCK_TITLE_TEXT_SECOND" => GetMessage( "HEADER_NEWS_ONLINE" ),
					"DISPLAY_BOTTOM_PAGER" => "N",
					"DISPLAY_DATE_FIRST" => "Y",
					"DISPLAY_DATE_OTHER" => "Y",
					"DISPLAY_NAME" => "N",
					"DISPLAY_PICTURE" => "N",
					"DISPLAY_PICTURE_FIRST" => "Y",
					"DISPLAY_PICTURE_OTHER" => "N",
					"DISPLAY_PREVIEW_TEXT" => "N",
					"DISPLAY_PREVIEW_TEXT_FIRST" => "Y",
					"DISPLAY_TOP_PAGER" => "N",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"IBLOCK_ID" => $NEWS_IBLOCK_ID,
					"IBLOCK_TYPE" => $NEWS_IBLOCK_TYPE,
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"LIST_ACTIVE_DATE_FORMAT" => "j F Y",
					"LIST_FIELD_CODE" => array(
							0 => "",
							1 => "" 
					),
					"LIST_HEIGHT_IMG_FIRST" => "362",
					"LIST_PROPERTY_CODE" => array(
							0 => "VIDEO",
							1 => "" 
					),
					"LIST_WIDTH_IMG_FIRST" => "394",
					"META_DESCRIPTION" => "-",
					"META_KEYWORDS" => "-",
					"NEWS_COUNT" => "6",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => ".default",
					"POPULAR_DISPLAY_DATE" => "Y",
					"POPULAR_DISPLAY_PICTURE" => "Y",
					"POPULAR_DISPLAY_PREVIEW_TEXT" => "Y",
					"POPULAR_DISPLAY_SECTION" => "Y",
					"POPULAR_GO_DETAIL_PAGE" => GetMessage( "HEADER_NEWS_DETAIL_PAGE" ),
					"POPULAR_HEIGHT_IMG" => "338",
					"POPULAR_NEWS_COUNT" => "3",
					"POPULAR_SORT_BY1" => "SHOW_COUNTER",
					"POPULAR_SORT_BY2" => "SORT",
					"POPULAR_SORT_ORDER1" => "DESC",
					"POPULAR_SORT_ORDER2" => "ASC",
					"POPULAR_TRUNCATE_LEN" => "",
					"POPULAR_WIDTH_IMG" => "342",
					"PREVIEW_TRUNCATE_LEN" => "",
					"SEF_FOLDER" => "",
					"SEF_MODE" => "N",
					"SET_STATUS_404" => "N",
					"SET_TITLE" => "N",
					"SORT_BY1" => "ACTIVE_FROM",
					"SORT_BY2" => "SORT",
					"SORT_ORDER1" => "DESC",
					"SORT_ORDER2" => "ASC",
					"USE_CATEGORIES" => "N",
					"USE_FILTER" => "N",
					"USE_PERMISSIONS" => "N",
					"USE_RATING" => "N",
					"USE_REVIEW" => "N",
					"USE_RSS" => "N",
					"USE_SEARCH" => "N",
					"DISPLAY_DATE" => "N" 
			), false );
}
?>
<div class="block_seo">
	<div class='container'>
		<div class='row'>
			<div class='col-sm-24 sm-padding-no'>
				<?
				$APPLICATION->IncludeFile( SITE_DIR . "include/miss-header-text.php", Array(), Array(
						"MODE" => "html" 
				) );
				?>
			</div>
		</div>
	</div>
</div>