<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<div class="col-sm-18 sm-padding-right-no">
<div class="personal_block_title">
    <h1 class="text"><?=GetMessage('PROFILE_WATCH_TITLE') ?></h1>
</div>


<div class="personal_block_third">

<div class="title"><?=GetMessage('REG_MAIN_TITLE');?></div>
<div class="wrap_content">
    <div class="row">
        <div class="col-sm-12">

                             
<div class="block_third_left">
    <h3 class="left_title"><?=GetMessage("REG_SHOW_HIDE")?></h3> 
    <div class="block_third_left_content">

    
<?if($arResult["arUser"]["NAME"]):?>    
<div class="prop">
    <span><?=GetMessage('NAME_')?></span>
    <?=$arResult["arUser"]["NAME"]?>
</div>
<?endif;?>

<?if($arResult["arUser"]["LAST_NAME"]):?>    
<div class="prop">
    <span><?=GetMessage('LAST_NAME')?></span>
    <?=$arResult["arUser"]["LAST_NAME"]?>
</div>
<?endif;?>

<?if($arResult["arUser"]["SECOND_NAME"]):?>    
<div class="prop">
    <span><?=GetMessage('SECOND_NAME')?></span>
    <?=$arResult["arUser"]["SECOND_NAME"]?>
</div>
<?endif;?>
<?if($arResult["arUser"]["LOGIN"] != $arResult["arUser"]["EMAIL"]):?>
   <?if($arResult["arUser"]["LOGIN"]):?>
        <div class="prop_bg">
            <span><?=GetMessage('LOGIN')?></span>
            <?=$arResult["arUser"]["LOGIN"]?>
        </div>
    <?endif;?>
    
    <?if($arResult["arUser"]["EMAIL"]):?>
        <div class="prop_bg">
            <span><?=GetMessage('EMAIL')?></span>
            <?echo $arResult["arUser"]["EMAIL"];?>
        </div>
    <?endif;?>
<?else:?>
    <?if($arResult["arUser"]["EMAIL"]):?>
        <div class="prop_bg">
            <span><?=GetMessage('EMAIL_LOGIN')?></span>
            <?echo $arResult["arUser"]["EMAIL"];?>
        </div>
    <?endif;?>
<?endif;?>

<?php $arField = array("NAME", "LAST_NAME", "SECOND_NAME", "LOGIN", "EMAIL", "PERSONAL_WWW", "PERSONAL_PHOTO_INPUT", "PERSONAL_PHOTO", "PERSONAL_PHOTO_HTML", "XML_ID", "EXTERNAL_AUTH_ID", "ID", "TIMESTAMP_X", "LAST_LOGIN", "PASSWORD", "CHECKWORD", "ACTIVE", "LID", "DATE_REGISTER", "CHECKWORD_TIME", "IS_ONLINE", "WORK_LOGO_INPUT", "BX_USER_ID",'LANGUAGE_ID','UF_CONFIDENTIAL');?>    
<?foreach($arResult["arUser"] as $key => $field):?>
    <?$check_result = strpos($key, "~")?>
    <?if(!in_array($key, $arField) && !empty($field) && $check_result === false):?>
        <div class="prop_bg">
            <span><?=GetMessage($key)?></span>
            <?=$field?>
        </div>       
    <?endif;?>
<?endforeach;?>
    
  


<?if($arResult["arUser"]["USER_PHONE"]):?>    
<div class="prop_bg">
    <span><?=GetMessage('USER_PHONE')?></span>
    <?=$arResult["arUser"]["PERSONAL_PHONE"]?>"
</div>
<?endif;?>

<?// ********************* User properties ***************************************************?>
<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
		<?$first = true;?>
		<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
            <div class="prop_bg">
                <span><?=$arUserField["EDIT_FORM_LABEL"]?></span>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:system.field.edit",
                    $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                    array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS"=>"Y"));?>
            </div>        
		<?endforeach;?>
	<?endif;?>
<?// ******************** /User properties ***************************************************?>
                </div><?/*end block_third_left_content*/?>
            </div>  <?/*end block_third_left*/?>
        </div> <!--end col-sm-12 -->
        <div class="col-sm-12">         
            <?if($arResult["SOCSERV_ENABLED"])
            {
                $APPLICATION->IncludeComponent("bitrix:socserv.auth.split", "ms_personal_page", Array(
	"SHOW_PROFILES" => "Y",	// ���������� ������������ �������
		"ALLOW_DELETE" => "Y",	// ��������� ������� ������������ �������
	),
	false
);
            }
            ?>
        </div>
    </div>
</div> <!--wrap_content-->    
</div>

<?/*echo "<pre>";print_r($arResult);echo "</pre>";*/?>
</div> <!--end col-sm-18 -->
