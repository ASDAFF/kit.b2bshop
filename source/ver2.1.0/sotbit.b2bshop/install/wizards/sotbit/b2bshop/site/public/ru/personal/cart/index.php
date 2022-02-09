<?
use Bitrix\Main\Loader;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:sale.basket.basket", 
	(Loader::includeModule('sotbit.b2bshop')?"b2b_basket":"ms_basket"), 
    array(
        "OFFERS_PROPS" => unserialize(COption::GetOptionString("sotbit.b2bshop", "OFFER_TREE_PROPS", "")),
        /*array(
            0 => "RAZMER_ATTR_S_DIRECTORY",
            1 => "TSVET_ATTR_S_DIRECTORY",
        ),*/
        "PATH_TO_ORDER" => COption::GetOptionString("sotbit.b2bshop", "URL_ORDER", ""),
        "HIDE_COUPON" => "N",
        "COLUMNS_LIST" => array(
            0 => "NAME",
            1 => "DISCOUNT",
            2 => "WEIGHT",
            3 => "DELETE",
            4 => "DELAY",
            5 => "TYPE",
            6 => "PRICE",
            7 => "QUANTITY",
        ),
        "PRICE_VAT_SHOW_VALUE" => "Y",
        "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
        "USE_PREPAYMENT" => "N",
        "QUANTITY_FLOAT" => "N",
        "SET_TITLE" => "Y",
        "ACTION_VARIABLE" => "action",
        "AJAX_MODE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "IBLOCK_TYPE" => COption::GetOptionString("sotbit.b2bshop", "IBLOCK_TYPE", ""),
        "IBLOCK_ID" => COption::GetOptionString("sotbit.b2bshop", "IBLOCK_ID", ""),
        "OFFER_TREE_PROPS" => unserialize(COption::GetOptionString("sotbit.b2bshop", "OFFER_TREE_PROPS", "")),
        "OFFER_COLOR_PROP" => COption::GetOptionString("sotbit.b2bshop", "OFFER_COLOR_PROP", ""),
        "MANUFACTURER_ELEMENT_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", ""),
        "MANUFACTURER_LIST_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MANUFACTURER_LIST_PROPS", ""),
        "PICTURE_FROM_OFFER" => COption::GetOptionString("sotbit.b2bshop", "PICTURE_FROM_OFFER", ""),
        "MORE_PHOTO_PRODUCT_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MORE_PHOTO_PRODUCT_PROPS", ""),
        "MORE_PHOTO_OFFER_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MORE_PHOTO_OFFER_PROPS", ""),
        "IMG_WIDTH" => COption::GetOptionString("sotbit.b2bshop", "CART_IMG_WIDTH", ""),
        "IMG_HEIGHT" => COption::GetOptionString("sotbit.b2bshop", "CART_IMG_HEIGHT", "")
    ),
    false
);?>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>