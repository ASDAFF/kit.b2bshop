<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<div class="block_third_right">
<?
if($arResult['ERROR_MESSAGE'])
	ShowMessage($arResult['ERROR_MESSAGE']);
?>
<?
$arServices = $arResult["AUTH_SERVICES_ICONS"];
if(!empty($arResult["AUTH_SERVICES"]))
{
	?>

	<div class="block_third_right_text">
	    <?=GetMessage("SS_GET_COMPONENT_INFO")?>
	</div>
    <div class="social_split">
	<?
	$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "ms_modal_def",
		array(
			"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
			"CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
			"AUTH_URL"=>$arResult['CURRENTURL'],
			"POST"=>$arResult["POST"],
			"SHOW_TITLES"=>'N',
			"FOR_SPLIT"=>'Y',
			"AUTH_LINE"=>'N',
		),
		$component,
		array("HIDE_ICONS"=>"Y")
	);
	?>
    </div>
	<?
}

if(isset($arResult["DB_SOCSERV_USER"]) && $arParams["SHOW_PROFILES"] != 'N')
{
	?>
    <div class="block_third_right_content">
	<p class="block_content_text">
		<?=GetMessage("SS_YOUR_ACCOUNTS");?>
	</p>
    <div class="block_third_serv_accounts">
        <?foreach($arResult["DB_SOCSERV_USER"] as $key => $arUser):?>
            <div class="item_serv">
                <i class="icon_split <?=$arUser['EXTERNAL_AUTH_ID']?>"></i>
                <?if ($arUser["PERSONAL_LINK"] != ''):?>
                    <a class="item_serv_link" target="_blank" href="<?=$arUser["PERSONAL_LINK"]?>">
                <?else:?>
                    <span class="item_serv_link">
                <?endif;?>
                   <?=$arUser["VIEW_NAME"]?>
                <?if ($arUser["PERSONAL_LINK"] != ''):?>
                    </a>
                <?else:?>
                    </span>
                <?endif;?>
                <?if (in_array($arUser["ID"], $arResult["ALLOW_DELETE_ID"])):?>
                        <a class="item_serv_delete" href="<?=htmlspecialcharsbx($arUser["DELETE_LINK"])?>" onclick="return confirm('<?=GetMessage("SS_PROFILE_DELETE_CONFIRM")?>')" title=<?=GetMessage("SS_DELETE")?>></a>
                <?endif;?>
            </div>
        <?endforeach;?>
    </div>
    </div>
	<?
}
?>
</div>