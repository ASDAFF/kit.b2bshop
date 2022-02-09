<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(check_bitrix_sessid() && isset($_REQUEST["ajax_top_basket"]) && $_REQUEST["ajax_top_basket"]=="Y")
{
    $APPLICATION->RestartBuffer(); 
    ?>
    <?=bitrix_sessid_post()?>
    <input type="hidden" name="ajax_top_basket" value="Y" />
    <?
    $cartInOrder = COption::GetOptionString("kit.b2bshop", "CART_IN_ORDER", "");
    if($cartInOrder=="Y")
    {
        $arParams['PATH_TO_BASKET'] = $arParams["PATH_TO_ORDER"];
        $urlCart = $urlOrder;
    }

    if ($arResult["READY"]=="Y" || $arResult["DELAY"]=="Y" || $arResult["NOTAVAIL"]=="Y" || $arResult["SUBSCRIBE"]=="Y")
    {
	    if ($arResult["READY"]=="Y")
	    {
            $tovarov2 = GetMessage("TSBS_SALE_BASKET2_2");
            $tovarov3 = GetMessage("TSBS_SALE_BASKET2_3"); 
            $var = BITGetDeclNum($arResult['ALL_QUANTITY'], array('', $tovarov2, $tovarov3));
            $tovarov = GetMessage("TSBS_SALE_BASKET2_1").$var;

	    }?>
        <a href="<?=$arParams['PATH_TO_BASKET'];?>" data-class="window_basket" data-href=""><?=GetMessage("TSBS_READY")?></a>
        <span><a href="<?=$arParams['PATH_TO_BASKET'];?>" data-class="window_basket" data-href=""><?=$arResult['ALL_QUANTITY']?>&nbsp;<?=$tovarov;?></a></span>
    <?
    }
    else {
        if(empty($arResult["ITEMS"])):?>
            <?$tovarov = GetMessage("TSBS_SALE_BASKET2_1").GetMessage("TSBS_SALE_BASKET2_3");?>
            <a href="<?=$arParams['PATH_TO_BASKET'];?>" data-class="window_basket" data-href=""><?=GetMessage("TSBS_READY")?></a>
            <span><a href="<?=$arParams['PATH_TO_BASKET'];?>" data-class="window_basket" data-href="">0&nbsp;<?=$tovarov?></a></span>
        <?endif;
    }
?>
    <?if(count($arResult["ITEMS"])>0 && !isset($_REQUEST["preview"])):
    ?>

    <div class='window-without-bg window_basket'>
        <div class='modal-block'>
            <div class='modal-block-inner'><span class='close'></span><div class='modal-content'>
    <?
    foreach($arResult["ITEMS"] as $arItem)
    {
        if($arItem["CAN_BUY"])
        {
        ?>
        <div class="basket-item item-bg-1"  data-id="<?=$arItem["ID"]?>" <?if(isset($_REQUEST["offerID"]) && $arItem["PRODUCT_ID"]!=$_REQUEST["offerID"]):?>style="display:none"<?endif;?>>
            <a href="#" rel="nofollow" class="delete"></a>
            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="item-tovar" title="<?=$arItem["NAME"]?>">
                <span class="wrap-img">
                    <?if(isset($arItem["PICTURE"]["src"])):?>
                    <img class="img-responsive" src="<?=$arItem["PICTURE"]["src"]?>" width="<?=$arItem["PICTURE"]["width"]?>" height="<?=$arItem["PICTURE"]["height"]?>" title="<?=$arItem["NAME"]?>" alt="<?=$arItem["NAME"]?>"/>
                    <?else:?>
                    <img class="img-responsive" src="/upload/no_photo.jpg" width="<?=$arParams["IMG_WIDTH"]?>" height="<?=$arParams["IMG_HEIGHT"]?>" title="<?=$arItem["NAME"]?>" alt="<?=$arItem["NAME"]?>"/>
                    <?endif;?>
                </span>
                <span class="characteristics">
                    <span class="item-name"><?=$arItem["BRAND"]?></span>
                    <span class="item-second-name"><i><?=$arItem["NAME"]?></i></span>
                    <?foreach($arItem["PROPS"] as $prop): ?>
                    <span class="item-size"><?=$prop["NAME"]?>: <b><?=$prop["VALUE"]?></b></span>
                    <?endforeach?>
                </span>
                <span class="item-price">
                    <span class="item-count"><?=GetMessage("MS_BASKET_QUANT")?> <span><?=intval($arItem["QUANTITY"])?></span></span>
                    <span class="price"><?=$arItem["PRICE_FORMATED"]?></span>
                </span>
            </a>
        </div>
        <?
        }
        ?>

        <?
    }
    ?>
        <div class="basket-total">
            <div class="quantity"><?=GetMessage("MS_BASKET_QUANTITY")?> <b><?=$arResult["ALL_QUANTITY"]?></b></div>
            <div class="total-price"><?=GetMessage("MS_BASKET_ITOGO")?> <b><?=$arResult["ALL_COST"]?></b></div>
        </div>
        <a href="<?=$arParams["PATH_TO_ORDER"]?>" class="basket-btn-order">
            <span class="basket-btn-order-inner"><?=GetMessage("MS_BASKET_ORDER")?></span>
            <span class='basket-btn-order-l'></span>
            <span class='basket-btn-order-r'></span>
        </a>
        </div></div></div></div>
    <?
    endif;
    die();
}elseif(isset($_REQUEST["ajax_top_basket"]) && $_REQUEST["ajax_top_basket"]=="Y")
{
    $APPLICATION->RestartBuffer();
    die();
}
?>