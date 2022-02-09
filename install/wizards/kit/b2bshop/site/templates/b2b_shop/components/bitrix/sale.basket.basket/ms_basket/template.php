<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(isset($_REQUEST["ORDER_ID"])) return false;
if(isset($_REQUEST["bxajaxid"]) && !isset($_REQUEST["basket"]) && !isset($_REQUEST["delay"]))
{
	?>
	<script type="text/javascript">
        BX.onCustomEvent('OnBasketChange')
	</script>
	<?php
}
$bxajaxid = CAjax::GetComponentID($this->__component->__name, $this->__name, '');
?>
<div class="basket_form_content">
<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">
<?
$arUrls = Array(
    "delete" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delete&id=#ID#",
    "delay" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delay&id=#ID#",
    "add" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=add&id=#ID#",
    "new_delay" => '/include/ajax/basket_add_product_and_wish.php?ajax_basket=Y&entity=basket&action=move&s_id=#ID#',
    "new_add" => '/include/ajax/basket_add_product_and_wish.php?ajax_basket=Y&entity=delay&action=move&s_id=#ID#',
);
if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
{
    if (is_array($arResult["WARNING_MESSAGE"]) && !empty($arResult["WARNING_MESSAGE"]))
    {
        foreach ($arResult["WARNING_MESSAGE"] as $v)
            echo ShowError($v);
    }
    $normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
    $delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
    $delayClass = $normalClass = "";

    if(isset($_SESSION["ms_delay"]) || isset($_REQUEST['delay']))
    {
        $delayClass = "active";
    }else{
        $normalClass = "active";
    }

//    if(!isset($arResult["ITEMS"]["AnDelCanBuy"]) || empty($arResult["ITEMS"]["AnDelCanBuy"]) && isset($arResult["ITEMS"]["DelDelCanBuy"]) && !empty($arResult["ITEMS"]["DelDelCanBuy"]))
//    {
//        $delayClass = "active";
//        $normalClass = "";
//    }

    ?>

    <div class="col-sm-24  sm-padding-left-no sort_container">
        <div class="wrap_btn">
            <a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam("basket=1", array("basket", "delay"))?>" class="basket_toolbar_button button <?=$normalClass?>">
                <?=GetMessage("MS_BASKET_CAN")?>
            </a>
            <?if($delayCount>0):?>
            <a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam("delay=1", array("basket", "delay"))?>" class="basket_toolbar_button_delayed button <?=$delayClass?>">
                <?=GetMessage("MS_BASKET_DELAY")?>
            </a>
            <?endif;?>
        </div>
    </div>
    <?
    if(/*isset($arResult["PRODUCTS"]["AnDelCanBuy"]) && !empty($arResult["PRODUCTS"]["AnDelCanBuy"]) &&*/ isset($arResult["ITEMS"]["AnDelCanBuy"]) && empty($delayClass)/* && !empty($arResult["ITEMS"]["AnDelCanBuy"])*/)
        include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
    else
    if(isset($arResult["PRODUCTS"]["DelDelCanBuy"]) && !empty($arResult["PRODUCTS"]["DelDelCanBuy"]))
        include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delay.php");
}
else
{
    ShowError($arResult["ERROR_MESSAGE"]);
}

?>
</form>
</div>
<?

if($arParams['USE_GIFTS'] === 'Y')
{
	$OFFER_ELEMENT_PARAMS=unserialize(COption::GetOptionString("kit.b2bshop","OFFER_ELEMENT_PARAMS",""));
	$OFFER_TREE_PROPS=unserialize(COption::GetOptionString("kit.b2bshop","OFFER_TREE_PROPS",""));
	?>
		<? $APPLICATION->IncludeComponent(
			"bitrix:sale.gift.basket",
			"gift_basket",
			array(


					"COLOR_IN_PRODUCT" => COption::GetOptionString("kit.b2bshop","COLOR_IN_PRODUCT",""),
					"COLOR_IN_PRODUCT_CODE" => COption::GetOptionString("kit.b2bshop","COLOR_IN_PRODUCT_CODE",""),
					"COLOR_IN_PRODUCT_LINK" => COption::GetOptionString("kit.b2bshop","COLOR_IN_PRODUCT_LINK",""),
					"OFFER_COLOR_PROP" => COption::GetOptionString("kit.b2bshop","OFFER_COLOR_PROP",""),
					"MANUFACTURER_ELEMENT_PROPS" => COption::GetOptionString("kit.b2bshop","MANUFACTURER_ELEMENT_PROPS",""),
					"DELETE_OFFER_NOIMAGE" => COption::GetOptionString("kit.b2bshop","DELETE_OFFER_NOIMAGE",""),
					"PICTURE_FROM_OFFER" => COption::GetOptionString("kit.b2bshop","PICTURE_FROM_OFFER",""),
					"MORE_PHOTO_PRODUCT_PROPS" => COption::GetOptionString("kit.b2bshop","MORE_PHOTO_PRODUCT_PROPS",""),
					"MORE_PHOTO_OFFER_PROPS" => COption::GetOptionString("kit.b2bshop","MORE_PHOTO_OFFER_PROPS",""),
					"DETAIL_WIDTH_MEDIUM" => COption::GetOptionString("kit.b2bshop","DETAIL_WIDTH_MEDIUM",""),
					"DETAIL_WIDTH_SMALL" => COption::GetOptionString("kit.b2bshop","DETAIL_WIDTH_SMALL",""),
					"DETAIL_HEIGHT_MEDIUM" => COption::GetOptionString("kit.b2bshop","DETAIL_HEIGHT_MEDIUM",""),
					"DETAIL_HEIGHT_SMALL" => COption::GetOptionString("kit.b2bshop","DETAIL_HEIGHT_SMALL",""),
					"DETAIL_WIDTH_BIG" => COption::GetOptionString("kit.b2bshop","DETAIL_WIDTH_BIG",""),
					"DETAIL_HEIGHT_BIG" => COption::GetOptionString("kit.b2bshop","DETAIL_HEIGHT_BIG",""),
					"AVAILABLE_DELETE" => COption::GetOptionString("kit.b2bshop","AVAILABLE_DELETE","N"),
					"IBLOCK_ID" => COption::GetOptionString("kit.b2bshop","IBLOCK_ID",""),
					"IMAGE_RESIZE_MODE" => COption::GetOptionString("kit.b2bshop","IMAGE_RESIZE_MODE","BX_RESIZE_IMAGE_PROPORTIONAL"),
					"FLAG_PROPS" => unserialize(COption::GetOptionString("kit.b2bshop","FLAG_PROPS","")),
					"OFFER_TREE_PROPS"	=>(is_array( $OFFER_ELEMENT_PARAMS )) ? $OFFER_TREE_PROPS+$OFFER_ELEMENT_PARAMS : $OFFER_TREE_PROPS,
					"COLOR_FROM_IMAGE" => COption::GetOptionString("kit.b2bshop","COLOR_FROM_IMAGE","Y"),
					"PRODUCT_PROPERTIES" => array(0=>"CML2_MANUFACTURER"),




				"SHOW_PRICE_COUNT" => 1,
				"PRODUCT_SUBSCRIPTION" => 'N',
				'PRODUCT_ID_VARIABLE' => 'id',
				"PARTIAL_PRODUCT_PROPERTIES" => 'N',
				"USE_PRODUCT_QUANTITY" => 'N',
				"ACTION_VARIABLE" => "actionGift",
				"ADD_PROPERTIES_TO_BASKET" => "Y",

				"BASKET_URL" => $APPLICATION->GetCurPage(),
				"APPLIED_DISCOUNT_LIST" => $arResult["APPLIED_DISCOUNT_LIST"],
				"FULL_DISCOUNT_LIST" => $arResult["FULL_DISCOUNT_LIST"],

				"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_SHOW_VALUE"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

				'BLOCK_TITLE' => $arParams['GIFTS_BLOCK_TITLE'],
				'HIDE_BLOCK_TITLE' => $arParams['GIFTS_HIDE_BLOCK_TITLE'],
				'TEXT_LABEL_GIFT' => $arParams['GIFTS_TEXT_LABEL_GIFT'],
				'PRODUCT_QUANTITY_VARIABLE' => $arParams['GIFTS_PRODUCT_QUANTITY_VARIABLE'],
				'PRODUCT_PROPS_VARIABLE' => $arParams['GIFTS_PRODUCT_PROPS_VARIABLE'],
				'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
				'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
				'SHOW_NAME' => $arParams['GIFTS_SHOW_NAME'],
				'SHOW_IMAGE' => $arParams['GIFTS_SHOW_IMAGE'],
				'MESS_BTN_BUY' => $arParams['GIFTS_MESS_BTN_BUY'],
				'MESS_BTN_DETAIL' => $arParams['GIFTS_MESS_BTN_DETAIL'],
				'PAGE_ELEMENT_COUNT' => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],
				'CONVERT_CURRENCY' => $arParams['GIFTS_CONVERT_CURRENCY'],
				'HIDE_NOT_AVAILABLE' => $arParams['GIFTS_HIDE_NOT_AVAILABLE'],

				"LINE_ELEMENT_COUNT" => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],
			),
			false
		); ?>
<?
	}

if(isset($arResult["PRODUCTS"]["AnDelCanBuy"]) && !empty($arResult["PRODUCTS"]["AnDelCanBuy"])):?>
<div class="col-sm-24">
    <div class="row">
        <div class="col-sm-9 col-sm-offset-15 sm-padding-right-no">
            <div class="wrap_basket_order">
                <a class="basket_order_btn" href="<?=$arParams["PATH_TO_ORDER"]?>" rel=nofollow><?=GetMessage("MS_BASKET_TO_ORDER")?></a>
            </div>
        </div>
    </div>
</div>
<?endif;
