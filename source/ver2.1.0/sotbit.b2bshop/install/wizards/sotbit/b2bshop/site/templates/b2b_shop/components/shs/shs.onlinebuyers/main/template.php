<?
if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true )
	die();
$this->setFrameMode( true );
if( !CModule::IncludeModule( "sotbit.b2bshop" ) || !B2BSSotbit::getDemo() )
	return false;
$frame = $this->createFrame()
	->begin( "" );
if( $arParams["TYPE_MODE"] == "Y" && isset( $arResult["PRODUCTS"] ) && !empty( $arResult["PRODUCTS"] ) )
{
	global $arOnlineFilter;
	$arOnlineFilter["ID"] = $arResult["PRODUCTS"];
	$arResult["USERS_COUNT_TEXT"] = "";
	if( isset( $arResult["USERS_COUNT"] ) && $arResult["USERS_COUNT"] )
	{
		$client2 = GetMessage( "TSBS_MS_SHS_2" );
		$client3 = GetMessage( "TSBS_MS_SHS_3" );
		$var = BITGetDeclNum( $arResult["USERS_COUNT"], array(
				'',
				$client2,
				$client3 
		) );
		$client = $arResult["USERS_COUNT"] . " " . GetMessage( "TSBS_MS_SHS_1" ) . $var;
		$arResult["USERS_COUNT_TEXT"] = $client;
	}
	
	$Rand = $this->randString();
	
	$APPLICATION->IncludeComponent( "bitrix:catalog.top", "ms_online_buyers", 
			array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"LAZY_LOAD" => $arParams["LAZY_LOAD"],
					"PRELOADER" => $arParams["PRELOADER"],
					"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
					"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
					"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
					"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
					"FILTER_NAME" => "arOnlineFilter",
					"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
					"ELEMENT_COUNT" => $arParams["ELEMENT_COUNT"],
					"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
					"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
					"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
					"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
					"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
					"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
					"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
					"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
					"OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
					"SECTION_URL" => $arParams["SECTION_URL"],
					"DETAIL_URL" => $arParams["DETAIL_URL"],
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
					"IMAGE_RESIZE_MODE" => $arParams["IMAGE_RESIZE_MODE"],
					"RAND" => $Rand 
			), $component );
}
$frame->end();
?>