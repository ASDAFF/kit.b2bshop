<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
Loc::loadMessages(__FILE__);

?>
<div class="mfeedback">
<?if(!empty($arResult["ERROR_MESSAGE"]))
{
	foreach($arResult["ERROR_MESSAGE"] as $v)
	{
		ShowError($v);
	}
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
	?><div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
}
?>
<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
<?=bitrix_sessid_post()?>
	<div class="row">
		<div class="col-sm-8 col-md-7 col-lg-6 sm-padding-right-no">
			<label class="field-title">
			<?=Loc::getMessage("MFT_NAME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?>*<?endif?>
			</label>
		</div>
		<div class="col-sm-16 col-md-17 col-lg-18">
		<input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-md-7 col-lg-6 sm-padding-right-no">
			<label class="field-title">
				<?=Loc::getMessage("MFT_EMAIL")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?>*<?endif?>			
			</label>
		</div>
		<div class="col-sm-16 col-md-17 col-lg-18">
			<input type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>">
		</div>
	</div>	
	<div class="row">
		<div class="col-sm-8 col-md-7 col-lg-6 sm-padding-right-no">
			<label class="field-title">
				<?=Loc::getMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?>*<?endif?>			
			</label>
		</div>
		<div class="col-sm-16 col-md-17 col-lg-18">
			<textarea name="MESSAGE" rows="5" cols="40"><?=$arResult["MESSAGE"]?></textarea>
		</div>
	</div>
	<?php 
	if(Option::get('sotbit.b2bshop', 'SHOW_CONFIDENTIAL_CONTACTS','Y') == 'Y')
	{
		?>
		<div class="row">
			<div class="col-sm-24 confidential-field">
			<input type="checkbox" class="checkbox" name="CONFIDENTIAL" id="CONFIDENTIAL" value="Y" <?php echo ($arResult['CONFIDENTIAL'] == 'Y')?'checked="checked"':''?>>
				<label for="CONFIDENTIAL">
					<?=Loc::getMessage("MFT_CONFIDENTIAL")?>
				</label>
			</div>
		</div>
		<?php 
	}
	else 
	{
		?>
		<input type="hidden" name="CONFIDENTIAL" value="Y">
		<?php
	}
	?>
	<?if($arParams["USE_CAPTCHA"] == "Y")
	{?>
		<div class="row">
			<div class="col-sm-13 col-md-13 col-lg-12 sm-padding-right-no">
				<label class="field-title captcha_label">
					<?=Loc::getMessage("MFT_PRESS_TEXT")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?>*<?endif?>
				</label>
			</div>
			<div class="col-sm-11 col-md-10 col-md-offset-1 col-lg-offset-2">
				<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">   
				<input class="captcha_input" type="text" name="captcha_word" size="30" maxlength="50" value="">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-13 col-md-13 col-lg-12 sm-padding-right-no">
				<img class="captcha_img" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
			</div>
			<div class="col-sm-11 col-md-10 col-md-offset-1 col-lg-offset-2">
				<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>" class="send_form" >
				<input type="submit" name="submit" value="<?=Loc::getMessage("MFT_SUBMIT")?>">   
			</div>
		</div>
	<?}
	else
	{?>
		<div class="row">
			<div class="col-sm-11 col-sm-offset-13 col-md-10 col-md-offset-14">
				<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>" class="send_form" >
				<input type="submit" name="submit" value="<?=Loc::getMessage("MFT_SUBMIT")?>">			
			</div>
		</div>
	<?}?>
</form>
</div>