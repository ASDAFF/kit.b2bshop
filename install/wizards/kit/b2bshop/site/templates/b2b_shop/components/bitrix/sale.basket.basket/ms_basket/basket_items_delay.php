<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$colorCode = $arParams["OFFER_COLOR_PROP"];
?>
<?if(!isset($_REQUEST["msCalculateBasket"]) && !isset($_REQUEST["bxajaxid"])):?>
<script>
    $(document).ready(function(){
        $(document).msCalculateBasketOrder({
            "containerMain" : ".item_prop",
            "contProps" : ".js_detail_prop ul",
            "contItemProps" : "li",
            "contItemActive" : ".li-active",
            "attrItemProps" : "data-xml",
            "attrItemID" :  "data-id",
            "attrItemProperty" :  "data-property",
            "itemActive" : ".li-active",
            "nameProps" : "props",
            "nameMainVar" : "msCalculateBasket",
            "basketUrl" : "<?=$APPLICATION->GetCurPage()?>"

        })
    })
</script>
<?endif;?>
<div class="col-sm-24 block_basket">
    <?echo ShowError($arResult["ERROR_MESSAGE"]);?>
    <div class="div_table">
        <div class="div_table_header">
            <div class="row">
                <div class='col-sm-10'>
                    <?=GetMessage("MS_BASKET_PRODUCT")?>
                </div>
                <div class='col-sm-3 sm-padding-left-no'>
                    <?=GetMessage("MS_BASKET_QUANTITY")?>
                </div>
                <div class='col-sm-3'>
                    <?=GetMessage("MS_BASKET_PRICE")?>
                </div>
                <div class='col-sm-3'>
                    <?=GetMessage("MS_BASKET_DISCOUNT")?>
                </div>
                <div class='col-sm-3'>
                    <?=GetMessage("MS_BASKET_ITOGO")?>
                </div>
                <div class='col-sm-2'>

                </div>
            </div>
        </div>
        <div class="div_table_body">
        <?foreach($arResult["ITEMS"]["DelDelCanBuy"] as $arItem):
            $productID = $arItem["PARENT_PRODUCT_ID"];
            $arOffersProps = array();
        ?>
            <div id="item_<?=$arItem["ID"]?>" class="basket_item">
                <div class="row">
                    <div class='col-sm-4'>
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="basket_item_img">
                            <?if(isset($arItem["PICTURE"]["src"])):?>
                            <img class="img-responsive"  src="<?=$arItem["PICTURE"]["src"]?>" width="<?=$arItem["PICTURE"]["width"]?>" height="<?=$arItem["PICTURE"]["height"]?>" title="<?=$arItem["NAME"]?>" alt="<?=$arItem["NAME"]?>" />
                            <?else:?>
                            <img class="img-responsive"  src="/upload/no_photo.jpg" width="<?=$arParams["IMG_WIDTH"]?>" height="<?=$arParams["IMG_HEIGHT"]?>" title="<?=$arItem["NAME"]?>" alt="<?=$arItem["NAME"]?>" />
                            <?endif;?>                        </a>
                    </div>
                    <div class='col-sm-6 sm-padding-left-no'>
                        <div class="wrap_title">
                            <p class="item_name"><a href="<?=$arItem["BRAND"]["DETAIL_PAGE_URL"]?>"><?=$arItem["BRAND"]["NAME"]?></a></p>
                            <p class="item_second_name"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><i><?=$arItem["NAME"]?></i></a></p>
                        </div>
                        <div class="item_prop">
                            <?
                            if(!empty($arItem["SKU_PRODUCT"]))
                            {
                                foreach($arItem["SKU_PRODUCT"] as $arSkuData)
                                {
                                    if($colorCode!=$arSkuData["CODE"] || !isset($arSkuData["VALUES"]) || empty($arSkuData["VALUES"])) continue 1;
                                    ?>
                                    <div class="detail_color js_detail_prop">
                                        <span class="detail_prop_title" title="<?=$arResult["OFFER_TREE_PROPS_NAME"][$colorCode]?>"><?=$arSkuData["NAME"]?>:</span>
                                        <ul class="offer-props" id="offer_prop_<?=$colorCode?>">
                                        <?foreach($arSkuData["VALUES"] as $arProp): //printr($arProp);
                                        $li_active = "";
                                        if(isset($arProp["ACTIVE"]))
                                        {
                                            $li_active = "li-active";
                                            $firstProp = $arSkuData["CODE"];
                                            $firstPropValue = $arProp["UF_XML_ID"];
                                            $arOffersProps = $arResult["OFFERS_ID"][$productID][$firstProp][$firstPropValue];    
                                        }
                                        ?>
                                        <li data-xml="<?=$arProp["UF_XML_ID"]?>" data-entity="delay" data-offer="<?=$arProp["OFFERS_ID"]?>" class="<?=$li_active?>" data-id="<?=$arItem["ID"]?>" data-property="<?=$arSkuData["CODE"]?>" data-ajax="<?=$arParams["AJAX_ID"]?>">
                                            <span title="<?=$arProp["UF_NAME"]?>" style="background: <?if($arProp["UF_FILE"]):?>url(<?=$arProp["PIC"]["SRC"]?>) 50% 50% no-repeat<?else:?><?=$arProp["UF_DESCRIPTION"]?><?endif;?>"></span>
                                        </li>
                                        <?endforeach;?>
                                        </ul>
                                    </div>
                                    <?
                                }
                            }
                            $arSrav = array();
                            if(!empty($arItem["SKU_PRODUCT"]))
                            {
                                foreach($arItem["SKU_PRODUCT"] as $arSkuData)
                                {
                                    if($colorCode==$arSkuData["CODE"]) continue 1;
                                    
                                    $codeProp = $arSkuData["CODE"];
                                    ?>
                                    <div class="detail_size js_detail_prop">
                                        <span class="detail_prop_title" title=""><?=$arSkuData["NAME"]?>:</span>
                                        <ul class="offer-props" id="offer_prop_<?=$arSkuData["CODE"]?>">
                                        <?foreach($arSkuData["VALUES"] as $xmlID=>$arProp):
                                        $li_active = "";
                                        $li_disable = "";
                                        if(isset($arProp["ACTIVE"]))
                                        {
                                            $firstPropValue = $arProp["UF_XML_ID"];
                                            $firstProp = $arSkuData["CODE"];
                                            $li_active = "li-active";    
                                        }

                                        {
                                            $arSrav = array_intersect($arResult["OFFERS_ID"][$productID][$codeProp][$xmlID], $arOffersProps);
                                            if(empty($arSrav)) $li_disable = "li-disable";
                                        }    
                                            
                                        ?>
                                        <li class="<?=$li_active?> <?=$li_disable?>" data-entity="delay" data-xml="<?=$arProp["UF_XML_ID"]?>" data-offer="<?=$arProp["OFFERS_ID"]?>" data-id="<?=$arItem["ID"]?>" data-property="<?=$arSkuData["CODE"]?>" data-ajax="<?=$arParams["AJAX_ID"]?>">
                                            <span><?=$arProp["UF_NAME"]?></span>
                                        </li>
                                        <?endforeach?>
                                        </ul>
                                    </div>
                                    <?
                                    $arOffersProps = array_merge($arOffersProps, $arResult["OFFERS_ID"][$productID][$firstProp][$firstPropValue]);
                                }        
                            }
                            ?>
                            <?
                            if(!empty($arItem["PROPS"]))
                            {
                                foreach($arItem["PROPS"] as $arProp)
                                {
                                    if(in_array($arProp["CODE"], $arParams['OFFER_TREE_PROPS'])) continue 1;
                                    ?>
                                    <p><?=$arProp["NAME"]?>: <span class="black"><?=$arProp["VALUE"]?></span></p>
                                    <?    
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <??>
                    <div class='col-sm-3 sm-padding-left-no'>
                        <p class="mobile_title"><?=GetMessage("MS_BASKET_QUANTITY")?>:</p>
                        <?
                        $ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
                        $max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
                        $useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
                        $useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
                        ?>
                        <?
                        if (!isset($arItem["MEASURE_RATIO"]))
                        {
                            $arItem["MEASURE_RATIO"] = 1;
                        }
                        ?>
                        <div class="wrap_input">
                            <span class="minus" onclick="minus_quantity('#QUANTITY_<?=$arItem["ID"]?>');BX.ajax.submitComponentForm(BX('basket_form'), 'basket_form_content', true);BX.submit(BX('basket_form'));BX.closeWait();">-</span>
                            <input class="basket_item_input" id="QUANTITY_<?=$arItem["ID"]?>" value="<?=$arItem["QUANTITY"]?>" type="text" placeholder=""name="QUANTITY_<?=$arItem["ID"]?>" value="1" maxlength="4" onchange="BX.ajax.submitComponentForm(BX('basket_form'), 'basket_form_content', true);BX.submit(BX('basket_form'));BX.closeWait();" >
                            <span class="plus" onclick="pluc_quantity('#QUANTITY_<?=$arItem["ID"]?>');BX.ajax.submitComponentForm(BX('basket_form'), 'basket_form_content', true);BX.submit(BX('basket_form'));BX.closeWait();" href="javascript:void(0)">+</span>
                        </div>

                    </div><??>
                    <div class='col-sm-3'>
                        <p class="mobile_title"><?=GetMessage("MS_BASKET_PRICE")?>:</p>
                        <div class="wrap_price">
                            <p class="item_price"><?=$arItem["PRICE_FORMATED"]?></p>
                            <?if($arItem["DISCOUNT_PRICE"]>0):?><p class="item_old_price"><?=$arItem["FULL_PRICE_FORMATED"]?></p><?endif;?>
                        </div>
                    </div>
                    <div class='col-sm-3'>
                        <p class="mobile_title"><?=GetMessage("MS_BASKET_DISCOUNT")?>:</p>
                        <div class="wrap_price">
                            <p class="item_price"><?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></p>
                        </div>
                    </div>
                    <div class='col-sm-3'>
                        <p class="mobile_title"><?=GetMessage("MS_BASKET_ITOGO")?>:</p>
                        <p class="count_item"><?=$arItem["PRICE_ALL_FORMATED"]?></p>
                    </div>
                    <div class='col-sm-2'>
                        <div class="wrap_del_change">
                            <p class="cart-delete-item"><a title="<?=GetMessage("MS_BASKET_DELETE")?>" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>&delay=1" rel="nofollow"><?=GetMessage("MS_BASKET_DELETE")?></a></p>
                            <p class="cart-delete-item"><a title="<?=GetMessage("MS_BASKET_TO_BASKET")?>" href="<?=str_replace("#ID#", $arItem["PRODUCT_ID"], $arUrls["new_add"])?>" onclick="BX.ajax.insertToNode('<?=str_replace("#ID#", $arItem["PRODUCT_ID"], $arUrls["new_add"])?>&bxajaxid=<?=$bxajaxid?>', 'comp_<?=$bxajaxid;?>'); return false;" rel="nofollow"><?=GetMessage("MS_BASKET_TO_BASKET")?></a></p>
                        </div>
                    </div>
                </div>
                <div class="row divider">
                    <div class='col-sm-24 xs-padding-no'>
                        <span></span>
                    </div>
                </div>
            </div>
        <?endforeach;?>
        </div>
    </div> <!--end div_table-->
</div>
<div class="col-sm-24 sm-padding-no">
    <div class="block_basket_count_wrap">
        <div class="block_basket_count">
            <div class="row">
                <div class="col-sm-6">
                    <a class="back_catalog" href="/catalog/"><?=GetMessage("MS_BASKET_RETURN_CATALOG")?></a>
                </div>
                <?
                if ($arParams["HIDE_COUPON"] != "Y"):

                    $couponClass = "";
                    if (array_key_exists('VALID_COUPON', $arResult))
                    {
                        $couponClass = ($arResult["VALID_COUPON"] === true) ? "good" : "bad";
                    }
                    elseif (array_key_exists('COUPON', $arResult) && !empty($arResult["COUPON"]))
                    {
                        $couponClass = "good";
                    }

                ?>
                    <div class="col-sm-4 sm-padding-no">
                        <span class="block_promo_title"><?=GetMessage("MS_BASKET_PROMO")?></span>
                    </div>
                    <div class="col-sm-4">
                        <input class="input_coupon <?=$couponClass?>" type="text" id="coupon" name="COUPON" value="<?=$arResult["COUPON"]?>" onchange="return false;">
                    </div>
                <?else:?>
                    &nbsp;
                <?endif;?>

                <div class="col-sm-7 col-sm-push-3">
                    <p class="basket_count"><?=GetMessage("MS_BASKET_ITOGO")?>: <span><?=str_replace(" ", "&nbsp;", $arResult["allSum_delay_FORMATED"])?></span></p>
                </div>
                <div class="col-sm-3 col-sm-pull-7 sm-padding-left-no">
                    <input class="basket_refresh" type="submit" name="BasketRefresh" value="<?=GetMessage("MS_BASKET_SAVE")?>" onclick="return false;">
                </div>
            </div>
        </div>
    </div>
</div> <!--end col-sm-24-->
<input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
<input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFER_TREE_PROPS"], ","))?>" />
<input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
<input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
<input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
<input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
<input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
<input type="hidden" id="coupon_approved" value="N" />
<input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />
<input type="hidden" name="BasketRefresh" value="1">