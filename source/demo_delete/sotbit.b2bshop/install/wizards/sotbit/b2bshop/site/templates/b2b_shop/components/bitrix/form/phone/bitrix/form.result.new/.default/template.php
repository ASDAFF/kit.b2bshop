<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>

<div class="overlay"></div>
<!--    <a href="#form-successful"></a>-->
<?if ($arResult["FORM_NOTE"]):?>
    <div class="overlaySuccessful"></div>
    <div class="form-container form-successful" id='form-successful'>


        <div class="form-successful-content">
            <div class="form-successful-logo">
            </div>
            <div class="form-successful-content-ok"><span><?=GetMessage('FORM_DATA_SUCCESS_SAVE');?></span></div>
            <span class="form-successful-content-call"><?=GetMessage('FORM_MANAGER_CALL_YOU');?></span>
            <div class="button-close successful-close"></div>
        </div>
    </div>
<? endif;?>

<?if ($arResult["isFormNote"] != "Y") {
    ?>
    <?= $arResult["FORM_HEADER"] ?>
    
    <?
    /***********************************************************************************
     * form questions
     ***********************************************************************************/
    ?>

    <!--<pre><?/*print_r();*/
    ?></pre>-->
    
    <?
    if($USER->getId()) {
        $rsUser = CUser::GetByID($USER->getId());
        $arUser = $rsUser->Fetch();
        
    }
    ?>

    <div class="form-container ">
        <span class="form-title"><?=$arResult["FORM_TITLE"]?></span>
        <?foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion):?>
            <?if ($arQuestion["REQUIRED"] == "Y"):?>
                <span><?=$arResult["REQUIRED_SIGN"];?> <?=$arQuestion['CAPTION']?></span>
                <div class="form-table-item" valid="true" type="<?=$arQuestion["CAPTION"]?>">
                    <?=$arQuestion["HTML_CODE"]?>
                </div>
            <?else:?>
                <?=$arQuestion['CAPTION']?>
                <div class="form-table-item" valid="false"  type="<?=$arQuestion["CAPTION"]?>">
                    
                    <?=$arQuestion["HTML_CODE"]?>
                </div>
            
            <?endif;?>
        <? endforeach?>
        <input class="form-button" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
        <div class="button-close"></div>
        <div class="fild">
            <input name="TEL_MASKS1" value="<?=$arParams["TEL_MASK"]?>" type="hidden">
        </div>
        
        
        <?
        if($arResult["isUseCaptcha"] == "Y")
        {
            ?>
            <tr>
                <th colspan="2"><b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b></th>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /></td>
            </tr>
            <tr>
                <td><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></td>
                <td><input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /></td>
            </tr>
            <?
        } // isUseCaptcha
        ?>
    </div>
    <?=$arResult["FORM_FOOTER"]?>
    <?
} //endif (isFormNote)
?>
