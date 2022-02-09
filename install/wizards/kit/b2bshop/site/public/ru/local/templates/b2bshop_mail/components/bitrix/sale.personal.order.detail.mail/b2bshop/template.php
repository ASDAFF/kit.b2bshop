<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(strlen($arResult["ERROR_MESSAGE"])):?>
    <?=ShowError($arResult["ERROR_MESSAGE"]);?>
<?else:?>
    <?if($arParams["SHOW_ORDER_BASE"]=='Y' || $arParams["SHOW_ORDER_USER"]=='Y' || $arParams["SHOW_ORDER_PARAMS"]=='Y' || $arParams["SHOW_ORDER_BUYER"]=='Y' || $arParams["SHOW_ORDER_DELIVERY"]=='Y' || $arParams["SHOW_ORDER_PAYMENT"]=='Y'):?>
        <table class="bx_order_list_table" width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #d3d3d3;border-bottom:none;margin:0; padding:0 14px;">
        <!--<thead>
				<tr>
					<td colspan="2">
						<?/*=GetMessage('SPOD_ORDER')*/?> <?/*=GetMessage('SPOD_NUM_SIGN')*/?><?/*=$arResult["ACCOUNT_NUMBER"]*/?>
						<?/*if(strlen($arResult["DATE_INSERT_FORMATED"])):*/?>
							<?/*=GetMessage("SPOD_FROM")*/?> <?/*=$arResult["DATE_INSERT_FORMATED"]*/?>
						<?/*endif*/?>
					</td>
				</tr>
			</thead>-->
        <tbody>
        <?if($arParams["SHOW_ORDER_BASE"]=='Y'):?>
            <tr>
                <td>
                    <?=GetMessage('SPOD_ORDER_STATUS')?>:
                </td>
                <td>
                    <?=htmlspecialcharsbx($arResult["STATUS"]["NAME"])?>
                    <?if(strlen($arResult["DATE_STATUS_FORMATED"])):?>
                        (<?=GetMessage("SPOD_FROM")?> <?=$arResult["DATE_STATUS_FORMATED"]?>)
                    <?endif?>
                </td>
            </tr>
            <tr>
                <td>
                    <?=GetMessage('SPOD_ORDER_PRICE')?>:
                </td>
                <td>
                    <?=$arResult["PRICE_FORMATED"]?>
                    <?if(floatval($arResult["SUM_PAID"])):?>
                        (<?=GetMessage('SPOD_ALREADY_PAID')?>:&nbsp;<?=$arResult["SUM_PAID_FORMATED"]?>)
                    <?endif?>
                </td>
            </tr>

            <?if($arResult["CANCELED"] == "Y" || $arResult["CAN_CANCEL"] == "Y"):?>
                <tr>
                    <td><?=GetMessage('SPOD_ORDER_CANCELED')?>:</td>
                    <td>
                        <?if($arResult["CANCELED"] == "Y"):?>
                            <?=GetMessage('SPOD_YES')?>
                            <?if(strlen($arResult["DATE_CANCELED_FORMATED"])):?>
                                (<?=GetMessage('SPOD_FROM')?> <?=$arResult["DATE_CANCELED_FORMATED"]?>)
                            <?endif?>
                        <?elseif($arResult["CAN_CANCEL"] == "Y"):?>
                            <?=GetMessage('SPOD_NO')?>&nbsp;&nbsp;&nbsp;[<a href="<?=$arResult["URL_TO_CANCEL"]?>"><?=GetMessage("SPOD_ORDER_CANCEL")?></a>]
                        <?endif?>
                    </td>
                </tr>
            <?endif?>
            <tr><td><br></td><td></td></tr>
        <?endif?>

        <?if($arParams["SHOW_ORDER_USER"]=='Y'):?>
            <?if(intval($arResult["USER_ID"])):?>

                <tr>
                    <td colspan="2"><?=GetMessage('SPOD_ACCOUNT_DATA')?></td>
                </tr>
                <?if(strlen($arResult["USER_NAME"])):?>
                    <tr>
                        <td><?=GetMessage('SPOD_ACCOUNT')?>:</td>
                        <td><span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px;display: block; -webkit-text-size-adjust:none;"><?=htmlspecialcharsbx($arResult["USER_NAME"])?></span></td>
                    </tr>
                <?endif?>
                <tr>
                    <td><?=GetMessage('SPOD_LOGIN')?>:</td>
                    <td><span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px;display: block; -webkit-text-size-adjust:none;"><?=htmlspecialcharsbx($arResult["USER"]["LOGIN"])?></span></td>
                </tr>
                <tr>
                    <td><?=GetMessage('SPOD_EMAIL')?>:</td>
                    <td><span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px;display: block; -webkit-text-size-adjust:none;"><a href="mailto:<?=htmlspecialcharsbx($arResult["USER"]["EMAIL"])?>"><?=$arResult["USER"]["EMAIL"]?></a></span></td>
                </tr>

                <tr><td><br></td><td></td></tr>

            <?endif?>
        <?endif?>

        <?if($arParams["SHOW_ORDER_PARAMS"]=='Y'):?>
            <tr>
                <td colspan="2"><?=GetMessage('SPOD_ORDER_PROPERTIES')?></td>
            </tr>
            <tr>
                <td><?=GetMessage('SPOD_ORDER_PERS_TYPE')?>:</td>
                <td><span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px;display: block; -webkit-text-size-adjust:none;"><?=htmlspecialcharsbx($arResult["PERSON_TYPE"]["NAME"])?></span></td>
            </tr>
        <?endif?>

        <?if($arParams["SHOW_ORDER_BUYER"]=='Y'):?>
            <?foreach($arResult["ORDER_PROPS"] as $prop):?>

                <?if($prop["SHOW_GROUP_NAME"] == "Y"):?>

                    <tr style="">
                        <td><br></td>
                    </tr>


                <?endif?>

                <? if($prop['CODE'] == 'LAST_NAME' || $prop['CODE'] == 'NAME' || $prop['CODE'] == 'SECOND_NAME') {
                    if ($prop['CODE'] == 'LAST_NAME') {
                        ?>
                        <tr>
                            <td>
                                <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #797e81;line-height:26px;display: block; -webkit-text-size-adjust:none;"><?= getMessage('FIO') ?></span>
                            </td>
                            <td>
                            <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px;display: block; -webkit-text-size-adjust:none;">
                                <?= $arResult['FULL_NAME'] ?>
                            </span>
                            </td>
                        </tr>
                        <tr>
                            <td><span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #797e81;line-height:26px;display: block; -webkit-text-size-adjust:none;"><?=$arResult['EMAIL']['NAME']?>:</span></td>
                            <td>
                            <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px;display: block; -webkit-text-size-adjust:none;">
								<?=htmlspecialcharsbx($arResult['EMAIL']["VALUE"])?>
                            </span>
                            </td>
                        </tr>
                        <tr>
                            <td><span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #797e81;line-height:26px;display: block; -webkit-text-size-adjust:none;"><?=$arResult['PHONE']['NAME']?>:</span></td>
                            <td>
                            <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px;display: block; -webkit-text-size-adjust:none;">
                                <?=htmlspecialcharsbx($arResult['PHONE']["VALUE"])?>
                            </span>
                            </td>
                        </tr>
                    <? }
                } elseif($prop['CODE'] == 'POST_ZIP' || $prop['CODE'] == 'POST_CITY' || $prop['CODE'] == 'POST_ADDRESS') {
                    if ($prop['CODE'] == 'POST_ZIP') {
                        ?>
                        <tr>
                            <td>
                                <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #797e81;line-height:26px;display: block; -webkit-text-size-adjust:none;"><?= getMessage('FULL_ADDRESS') ?></span>
                            </td>
                            <td>
                            <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px;display: block; -webkit-text-size-adjust:none;">
                                <?=$arResult['FULL_ADDRESS'] ?>
                            </span>
                            </td>
                        </tr>
                    <? }
                } else { ?>
                    <tr>
                        <td><span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #797e81;line-height:26px;display: block; -webkit-text-size-adjust:none;"><?=$prop['NAME']?>:</span></td>
                        <td>
                            <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px;display: block; -webkit-text-size-adjust:none;">
							<?if($prop["TYPE"] == "CHECKBOX"):?>
                                <?=GetMessage('SPOD_'.($prop["VALUE"] == "Y" ? 'YES' : 'NO'))?>
                            <?else:?>
                                <?=htmlspecialcharsbx($prop["VALUE"])?>
                            <?endif?>
                            </span>
                        </td>
                    </tr>
                <? } ?>
            <?endforeach?>


            <?if(!empty($arResult["USER_DESCRIPTION"])):?>

                <tr>
                    <td><?=GetMessage('SPOD_ORDER_USER_COMMENT')?>:</td>
                    <td><span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px;display: block; -webkit-text-size-adjust:none;"><?=$arResult["USER_DESCRIPTION"]?></span></td>
                </tr>

            <?endif?>

            <tr><td><br></td><td></td></tr>
        <?endif?>

        <?if($arParams["SHOW_ORDER_PAYMENT"]=='Y') { ?>
            </tbody>
            </table>
            <table bgcolor="#f7f8fa" width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #d3d3d3;border-top:none;margin:0; padding:17px 14px;">
                <tbody>
                <tr>
                    <td>
                                <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #2e3031;line-height:24px; -webkit-text-size-adjust:none;">
                                <?if($arResult["PAYED"] == "Y"):?>
                                    <?=GetMessage('SPOD_YES')?>
                                    <?if(strlen($arResult["DATE_PAYED_FORMATED"])):?>
                                        (<?=GetMessage('SPOD_FROM')?> <?=$arResult["DATE_PAYED_FORMATED"]?>)
                                    <?endif?>
                                <?else:?>
                                    <?if($arResult["CAN_REPAY"]=="Y" && $arResult["PAY_SYSTEM"]["PSA_NEW_WINDOW"] == "Y"):?>
                                        <?=GetMessage('SPOD_NO')?>
                                    <?endif?>
                                <?endif?>
                                </span>

                        <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:24px; -webkit-text-size-adjust:none;">
                                <?if(intval($arResult["PAY_SYSTEM_ID"])):?>
                                    <?=htmlspecialcharsbx($arResult["PAY_SYSTEM"]["NAME"]) . '.' ?>
                                <?else:?>
                                    <?=GetMessage("SPOD_NONE"). '.'?>
                                <?endif?>
                                </span>
                        <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:24px;display: block; -webkit-text-size-adjust:none;">
                                <?if(strpos($arResult["DELIVERY_ID"], ":") !== false || intval($arResult["DELIVERY_ID"])):?>
                                    <? if(!isset($arResult["DELIVERY"]['NAME']) && isset($arResult["DELIVERY"]['STORE'])) { ?>
                                        <?=GetMessage('PICK_UP'). '.'?>
                                    <? } else { ?>
                                        <?=htmlspecialcharsbx($arResult["DELIVERY"]["NAME"]). '.'?>
                                    <? } ?>
                                    <?if(intval($arResult['STORE_ID']) && !empty($arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']])):?>

                                        <?$store = $arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']];?>
                                        <div class="bx_ol_store">
                                            <div class="bx_old_s_row_title">
                                                <?=GetMessage('SPOD_TAKE_FROM_STORE')?>: <b><?=$store['TITLE']?></b>

                                                <?if(!empty($store['DESCRIPTION'])):?>
                                                    <div class="bx_ild_s_desc">
                                                        <?=$store['DESCRIPTION']?>
                                                    </div>
                                                <?endif?>

                                            </div>

                                            <?if(!empty($store['ADDRESS'])):?>
                                                <div class="bx_old_s_row">
                                                    <b><?=GetMessage('SPOD_STORE_ADDRESS')?></b>: <?=$store['ADDRESS']?>
                                                </div>
                                            <?endif?>

                                            <?if(!empty($store['SCHEDULE'])):?>
                                                <div class="bx_old_s_row">
                                                    <b><?=GetMessage('SPOD_STORE_WORKTIME')?></b>: <?=$store['SCHEDULE']?>
                                                </div>
                                            <?endif?>

                                            <?if(!empty($store['PHONE'])):?>
                                                <div class="bx_old_s_row">
                                                    <b><?=GetMessage('SPOD_STORE_PHONE')?></b>: <?=$store['PHONE']?>
                                                </div>
                                            <?endif?>

                                            <?if(!empty($store['EMAIL'])):?>
                                                <div class="bx_old_s_row">
                                                    <b><?=GetMessage('SPOD_STORE_EMAIL')?></b>: <a href="mailto:<?=$store['EMAIL']?>"><?=$store['EMAIL']?></a>
                                                </div>
                                            <?endif?>
                                        </div>

                                    <?endif?>

                                <?else:?>
                                    <?=GetMessage("SPOD_NONE")?>
                                <?endif?>
                                </span>
                    </td>
                    <? if($arParams['SHOW_PAYMENT_BUTTON'] == 'Y') { ?>
                        <?if($arResult["PAYED"] !== "Y" && $arResult["CAN_REPAY"]=="Y" && $arResult["PAY_SYSTEM"]["PSA_NEW_WINDOW"] == "Y"):?>
                            <td>
                                <a style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;text-transform:uppercase;text-decoration: none;line-height:30px;display: block;float: right;max-width:204px; width: 100%; text-align: center;border: 1px solid #d3d3d3; -webkit-text-size-adjust:none;" href="<?=$arResult["PAY_SYSTEM"]["PSA_ACTION_FILE"]?>" target="_blank"><?=GetMessage('SPOD_REPEAT_PAY')?></a>
                            </td>
                        <?endif?>
                    <? } ?>
                </tr>


                <?if($arResult["TRACKING_NUMBER"]):?>

                    <tr>
                        <td><?=GetMessage('SPOD_ORDER_TRACKING_NUMBER')?>:</td>
                        <td><?=$arResult["TRACKING_NUMBER"]?></td>
                    </tr>

                    <tr><td><br></td><td></td></tr>

                <?endif?>
                </tbody>
            </table>
        <? } else {?>
            </tbody>
            </table>
        <? } ?>

        <?if($arParams["SHOW_ORDER_BASKET"]=='Y'):?>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:43px 0 0 0;">
                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                    <td width="100%">
                        <span style="font: 22px 'Proxima Nova', Arial, sans-serif;font-weight: bold;color: #000000;line-height:20px;display: block; -webkit-text-size-adjust:none;"><?=GetMessage('SPOD_ORDER_BASKET')?></span>
                    </td>
                </tr>
            </table>
        <?endif?>
    <?endif?>


    <?if($arParams["SHOW_ORDER_SUM"]=='Y'):?>
        <table class="bx_ordercart_order_sum" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding: 22px 0px;">
            <tbody>
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding: 0px;">
                        <tr>
                            <td class="custom_t1">
                                <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #999999;line-height:26px; -webkit-text-size-adjust:none;"><?=GetMessage('SPOD_ALL_QUANTITY')?>:</span>
                                <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px; -webkit-text-size-adjust:none;"><?=$arResult['ALL_QUANTITY']?></span>
                            </td>
                        </tr>
                        <? ///// WEIGHT ?>
                        <?if(floatval($arResult["ORDER_WEIGHT"])):?>
                            <tr>
                                <td class="custom_t1">
                                    <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #999999;line-height:26px; -webkit-text-size-adjust:none;"><?=GetMessage('SPOD_TOTAL_WEIGHT')?>:</span>
                                    <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px; -webkit-text-size-adjust:none;"><?=$arResult['ORDER_WEIGHT_FORMATED']?></span>
                                </td>
                            </tr>
                        <?endif?>

                        <? ///// PRICE SUM ?>
                        <tr>
                            <td class="custom_t1">
                                <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #999999;line-height:26px;-webkit-text-size-adjust:none;"><?=GetMessage('SPOD_PRODUCT_PRICE')?>:</span>
                                <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px; -webkit-text-size-adjust:none;"><?=CCurrencyLang::CurrencyFormat($arResult['PRODUCT_SUM'], CCurrency::GetBaseCurrency())?></span>
                            </td>
                        </tr>

                        <? ///// DELIVERY PRICE: print even equals 2 zero ?>
                        <?if(strlen($arResult["PRICE_DELIVERY_FORMATED"])):?>
                            <tr>
                                <td class="custom_t1">
                                    <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #999999;line-height:26px; -webkit-text-size-adjust:none;"><?=GetMessage('SPOD_DELIVERY')?>:</span>
                                    <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px; -webkit-text-size-adjust:none;"><?=$arResult["PRICE_DELIVERY_FORMATED"]?></span>
                                </td>
                            </tr>
                        <?endif?>

                        <? ///// TAXES DETAIL ?>
                        <?foreach($arResult["TAX_LIST"] as $tax):?>
                            <tr>
                                <td class="custom_t1">
                                    <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #999999;line-height:26px; -webkit-text-size-adjust:none;"><?=$tax["TAX_NAME"]?>:</span>
                                    <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px; -webkit-text-size-adjust:none;"><?=$tax["VALUE_MONEY_FORMATED"]?></span>
                                </td>
                            </tr>
                        <?endforeach?>

                        <? ///// TAX SUM ?>
                        <?if(floatval($arResult["TAX_VALUE"])):?>
                            <tr>
                                <td class="custom_t1">
                                    <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #999999;line-height:26px; -webkit-text-size-adjust:none;"><?=GetMessage('SPOD_TAX')?>:</span>
                                    <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px; -webkit-text-size-adjust:none;"><?=$arResult["TAX_VALUE_FORMATED"]?></span>
                                </td>
                            </tr>
                        <?endif?>

                        <? ///// DISCOUNT ?>
                        <?if(floatval($arResult["DISCOUNT_VALUE"])):?>
                            <tr>
                                <td class="custom_t1">
                                    <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #999999;line-height:26px; -webkit-text-size-adjust:none;"><?=GetMessage('SPOD_DISCOUNT')?>:</span>
                                    <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px; -webkit-text-size-adjust:none;"><?=$arResult["DISCOUNT_VALUE_FORMATED"]?></span>
                                </td>
                            </tr>
                        <?endif?>
                    </table>
                </td>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding: 0px;">
                        <tr>
                            <td class="custom_t1 fwb" style="text-align: right;">
                                <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px; -webkit-text-size-adjust:none;"><?=GetMessage('SPOD_SUMMARY')?>:</span>
                                <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:26px; -webkit-text-size-adjust:none;"><?=$arResult["PRICE_FORMATED"]?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="custom_t1 fwb" style="text-align: right;padding: 7px 0 0 0;">
                                <? if($arResult['PAYMENT_IS_CACHE_TYPE'] == 'N') { ?>
                                    <a href="<?=$_SERVER['SERVER_NAME']?>/personal/order/payment/?ORDER_ID=<?=$arResult['ID']?>&pdf=1&DOWNLOAD=Y" target="_blank" style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #ffffff;text-transform:uppercase;text-decoration: none;line-height:30px;display: block;float: right;max-width:163px; width: 100%; text-align: center;background-color: #000000; -webkit-text-size-adjust:none;">
                                        <?=GetMessage('PAYMENT_IS_CACHE_N')?>
                                    </a>
                                <? } elseif ($arResult['PAYMENT_IS_CACHE_TYPE'] == 'A') { ?>
                                    <a href="<?=$_SERVER['SERVER_NAME']?>/personal/order/payment/?ORDER_ID=<?=$arResult['ID']?>&pdf=1&DOWNLOAD=Y" target="_blank" style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #ffffff;text-transform:uppercase;text-decoration: none;line-height:30px;display: block;float: right;max-width:163px; width: 100%; text-align: center;background-color: #000000; -webkit-text-size-adjust:none;">
                                        <?=GetMessage('PAYMENT_IS_CACHE_A')?>
                                    </a>
                                <? } ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    <?endif?>

    <?if($arParams["SHOW_ORDER_BASKET"]=='Y'):?>
        <table class="bx_order_list_table_order" width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #d3d3d3;margin:0; padding:0px;">
            <thead>
            <tr>
                <? $y = 1;
                foreach ($arParams["CUSTOM_SELECT_PROPS"] as $headerId):

                    if($y == 1) {
                        $align = 'left';
                        $style = 'padding:0 0 0 14px;';
                        $width = 'width="50%"';
                    }
                    else {
                        $align = 'center';
                        $style = '';
                        $width = '';
                    }
                    if($headerId == 'PICTURE' && in_array('NAME', $arParams["CUSTOM_SELECT_PROPS"]))
                        continue;

                    $colspan = "";
                    if($headerId == 'NAME' && in_array('PICTURE', $arParams["CUSTOM_SELECT_PROPS"]))
                        $colspan = 'colspan="2"';

                    $headerName = GetMessage('SPOD_'.$headerId);
                    if(strlen($headerName)<=0)
                    {
                        foreach(array_values($arResult['PROPERTY_DESCRIPTION']) as $prop_head_desc):
                            if(array_key_exists($headerId, $prop_head_desc))
                                $headerName = $prop_head_desc[$headerId]['NAME'];
                        endforeach;
                    }
                    ?><td <?=$colspan?> align="<?=$align?>" <?=$width?> style="<?=$style?>"><span style="font: 13px 'Proxima Nova', Arial, sans-serif;color: #999999;line-height:20px;padding: 12px 0;display: block; -webkit-text-size-adjust:none;"><?=$headerName?></span></td><?
                    $y++;
                endforeach;
                ?>
            </tr>
            </thead>
            <tbody>
            <? $i_color = 2;
            foreach($arResult["BASKET"] as $prod):
                if(($i_color%2) == 0 ) {
                    $tr_bg_color = 'background:#f7f8fa;';
                }
                else {
                    $tr_bg_color='';
                }
                ?><tr style="<?=$tr_bg_color?> "><?

                $hasLink = !empty($prod["DETAIL_PAGE_URL"]);
                
                $actuallyHasProps = is_array($prod["PROPS"]) && !empty($prod["PROPS"]);
                $i = 1;
                foreach ($arParams["CUSTOM_SELECT_PROPS"] as $headerId):
                    if($i == 1) {
                        $align = 'left';
                        $style = 'padding:0 0 0 14px;';
                        $width = 'width="50%"';
                    }
                    else {
                        $align = 'center';
                        $style = '';
                        $width = '';
                    }
                    ?><td class="custom" align="<?=$align?>" <?=$width?> style="<?=$style?>">
                    <span style="font: 13px 'Proxima Nova', Arial, sans-serif;color: #000000;padding: 12px 0;text-decoration: none;line-height:24px;display: block; -webkit-text-size-adjust:none;"><?

                        if($headerId == "NAME"):

                            if($hasLink):
                            ?><a href="<?=$prod["DETAIL_PAGE_URL"].$arParams['UTM']?>" target="_blank" style="font: 13px 'Proxima Nova', Arial, sans-serif;color: #000000;text-decoration: none;line-height:24px;display: block; -webkit-text-size-adjust:none;"><?
                            endif;
                            ?>   <font color="#000000" size="2" face="Proxima Nova, Arial, sans-serif"><?=$prod["NAME"]?></font> <img alt="" src="/bitrix/templates/b2b_shop/img/zoom_mail.png"
                                                                                                                                      border="0" width="12" height="12" style="padding-left: 6px;"><?
                            if($hasLink):
                                ?></a><?
                            endif;

                        elseif($headerId == "PICTURE"):

                            if($hasLink):
                            ?><a href="<?=$prod["DETAIL_PAGE_URL"].$arParams['UTM']?>" target="_blank" ><?
                            endif;
                            if($prod['PICTURE']['SRC']):
                                ?><img src="<?=$prod['PICTURE']['SRC']?>" width="<?=$prod['PICTURE']['WIDTH']?>" height="<?=$prod['PICTURE']['HEIGHT']?>" alt="<?=$prod['NAME']?>" /><?
                            endif;
                            if($hasLink):
                                ?></a><?
                            endif;

                        elseif($headerId == "PROPS" && $arResult['HAS_PROPS'] && $actuallyHasProps):

                            ?>
                            <table cellspacing="0" class="bx_ol_sku_prop">
								<?foreach($prod["PROPS"] as $prop):?>
                                    <tr>
										<td><nobr><?=htmlspecialcharsbx($prop["NAME"])?>:</nobr></td>
										<td style="padding-left: 10px !important"><b><?=htmlspecialcharsbx($prop["VALUE"])?></b></td>
									</tr>
                                <?endforeach?>
							</table>
                            <?

                        elseif($headerId == "QUANTITY"):

                            ?>
                            <?=$prod["QUANTITY"]?>
                            <?/*if(strlen($prod['MEASURE_TEXT'])):*/?><!--
								<?/*=$prod['MEASURE_TEXT']*/?>
							<?/*else:*/?>
								<?/*=GetMessage('SPOD_DEFAULT_MEASURE')*/?>
							--><?/*endif*/?>
                            <?

                        else:

                            ?><?=$prod[(strpos($headerId, 'PROPERTY_')===0 ? $headerId."_VALUE" : $headerId)]?><?

                        endif;

                        ?></span></td><?
                    $i++;
                endforeach;

                ?></tr><?
                $i_color++;
            endforeach;
            ?>
            </tbody>
        </table>
    <?endif?>


<?endif?>