<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule("sotbit.b2bshop") || !B2BSSotbit::getDemo()) return false;
$this->setFrameMode(true);
global $arAnalogFilter, $msAnalogDeleteID;
$arAnalogFilter = $arResult;
if(isset($msAnalogDeleteID) && !empty($msAnalogDeleteID))
{
    $msAnalogDeleteID[] = $arAnalogFilter['!ID'];
    $arAnalogFilter['!ID'] = $msAnalogDeleteID;
}

if(!empty($arResult))
{
	$APPLICATION->IncludeComponent("bitrix:catalog.top", "ms_right_vertical_img", array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ELEMENT_SORT_FIELD" => "rand",
	    "ELEMENT_SORT_ORDER" => "rand",
	    "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
	    "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
	    "FILTER_NAME" => "arAnalogFilter",
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
        "TITLE" => (isset($arParams["TITLE"]) && $arParams["TITLE"])?$arParams["TITLE"]:GetMessage("SBT_ANALOG_TITLE"),
        "IS_FANCY" => $arParams["IS_FANCY"],
        "PICTURE_FROM_OFFER" => $arParams["PICTURE_FROM_OFFER"],
        "MORE_PHOTO_OFFER_PROPS" => $arParams["MORE_PHOTO_OFFER_PROPS"],
		"IMG_WIDTH"=>$arParams["IMG_WIDTH"],
		"IMG_HEIGHT"=>$arParams["IMG_HEIGHT"],
			
        //"DETAIL_PARAMS" => $arParams["DETAIL_PARAMS"]

		),
		$component
	);
}
?>