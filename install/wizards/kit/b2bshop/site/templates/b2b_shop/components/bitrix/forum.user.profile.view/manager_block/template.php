<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="col-sm-24 sm-padding-left">
    <div class="manager-container  news-item">
        <div class="manager-left-photo">
            <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult['USER']['PERSONAL_PHOTO_FILE'])):?>
                <img
                        class="preview_picture"
                        border="0"
                        src="<?=$arResult['USER']['PERSONAL_PHOTO_FILE']["SRC"]?>"
                        width="<?=$arResult['USER']['PERSONAL_PHOTO_FILE']["WIDTH"]?>"
                        height="<?=$arResult['USER']['PERSONAL_PHOTO_FILE']["HEIGHT"]?>"
                        alt="<?=$arResult['USER']['PERSONAL_PHOTO_FILE']["ALT"]?>"
                        title="<?=$arResult['USER']['PERSONAL_PHOTO_FILE']["TITLE"]?>"
                        style="float:left"
                />
            <?else:?>
                <img src="<?=SITE_TEMPLATE_PATH.'/img/manager.png';?>" >
            <?endif?>
        </div>

        <div class="manager-right-container">

            <span class="manager-post"><?=$arResult["USER"]["WORK_POSITION"]?></span>
            <span class="manager-right-container-name"> <?=$arResult["SHOW_NAME"];?></span>

            <span class="manager-right-container-phone"> <span><?=GetMessage('F_PHONE')?></span> <b><?=$arResult["USER"]["WORK_PHONE"]?></b></span>
            <div class="manager-right-container-button">
                <span class="order-phone open-modal-login black" ><?=GetMessage('F_BUTTON_NAME')?></span>
            </div>

        </div>

    </div>
</div>
<?
$APPLICATION->IncludeComponent(
    "bitrix:form",
    "phone",
    array(
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHAIN_ITEM_LINK" => "",
        "CHAIN_ITEM_TEXT" => "",
        "COMPONENT_TEMPLATE" => "phone",
        "EDIT_ADDITIONAL" => "N",
        "EDIT_STATUS" => "N",
        "TEL_MASK" => COption::GetOptionString("kit.b2bshop","TEL_MASK","+7(999)999-99-99"),
        "IGNORE_CUSTOM_TEMPLATE" => "N",
        "NOT_SHOW_FILTER" => array(
            0 => "",
            1 => "",
        ),
        "NOT_SHOW_TABLE" => array(
            0 => "",
            1 => "",
        ),
        "RESULT_ID" => $_REQUEST[RESULT_ID],
        "SEF_MODE" => "N",
        "SHOW_ADDITIONAL" => "N",
        "SHOW_ANSWER_VALUE" => "N",
        "SHOW_EDIT_PAGE" => "N",
        "SHOW_LIST_PAGE" => "N",
        "SHOW_STATUS" => "N",
        "SHOW_VIEW_PAGE" => "Y",
        "START_PAGE" => "new",
        "SUCCESS_URL" => "",
        "USE_EXTENDED_ERRORS" => "N",
        "WEB_FORM_ID" => COption::GetOptionString("kit.b2bshop","FORM_MANAGER_CALLBACK", 1),
        "VARIABLE_ALIASES" => array(
            "action" => "action",
        )
    ),
    false
);
?>
