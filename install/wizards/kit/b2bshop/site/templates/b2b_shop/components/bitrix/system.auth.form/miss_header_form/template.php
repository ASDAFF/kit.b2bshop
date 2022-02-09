<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
$this->setFrameMode(true);
$frame = $this->createFrame()->begin("");
if ($arResult["FORM_TYPE"] == "login")
{
	?>
	<div class="header-login">
		<?if($arResult["NEW_USER_REGISTRATION"] == "Y")
		{?>
			<a href="<?=$arResult["AUTH_REGISTER_URL"]?>">
				<?=Loc::getMessage("AUTH_REGISTER")?>
			</a>
		<?}?>
		<a
			class="<?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>black<?endif;?> open-modal-login"
			onclick="OpenModal('<?php echo $arResult['AUTH_AJAX_LOGIN_URL'];?>', '<?php echo $arResult["AUTH_AJAX_PARAMS"] ?>','login_enter');return false;"
			href="<?=$arResult['AUTH_AJAX_LOGIN_URL']?>"
			rel="nofollow">
				<?=Loc::getMessage("AUTH_LOGIN")?>
		</a>
	</div>
	<?
}
else
{
	$name = trim( $USER->GetFullName() );
	if (strlen( $name ) <= 0)
	{
		$name = $USER->GetLogin();
	}
	?>
	<div class="header-login enter">
		<a href="<?=$arResult['PROFILE_URL']?>">
			<?php echo htmlspecialcharsEx($name);?>
		</a>
		<a class="black" href="<?php echo $APPLICATION->GetCurPageParam("logout=yes", array("logout"));?>">
			<?php echo Loc::getMessage("AUTH_LOGOUT");?>
		</a>
	</div>
	<?
}
$frame->end();
?>