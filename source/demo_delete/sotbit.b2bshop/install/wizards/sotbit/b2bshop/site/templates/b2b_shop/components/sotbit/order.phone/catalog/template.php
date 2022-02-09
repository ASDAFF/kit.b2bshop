<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Config\Option;
$this->setFrameMode(true);
if(!CModule::IncludeModule("sotbit.orderphone")) return;
global $APPLICATION;
?>
<script src="<?=CUtil::GetAdditionalFileURL($templateFolder.'/script.js', true)?>" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {
		msPhoneDetail = new msOrderPhoneDetail();
	})
</script>
<div class="detail_block_back_call sotbit_order_phone">
	<form action="" class="sotbit_order_phone_form">
		<input type="hidden" name="SITE_ID" value="<?=SITE_ID?>" />
	<?foreach($arParams as $param=>$val)
	{
		if(strpos($param, "~")!==false || is_array($val))
			continue;
		?>
		<input type="hidden" name="<?=$param?>" value="<?=$val?>" />
	<?
}
	if(isset($arParams["PRODUCT_PROPS"]) && !empty($arParams["PRODUCT_PROPS"]))
	{
		foreach($arParams["PRODUCT_PROPS"] as $val)
		{
			?>
			<input type="hidden" name="PRODUCT_PROPS[]" value="<?=$val?>" />
			<?
		}
	}
	if(isset($arParams["PRODUCT_PROPS_VALUE"]) && !empty($arParams["PRODUCT_PROPS_VALUE"]))
	{
		foreach($arParams["PRODUCT_PROPS_VALUE"] as $code=>$val)
		{
			?>
			<input type="hidden" name="PRODUCT_PROPS_VALUE[<?=$code?>]" value="<?=$val?>" />
			<?
		}
	}
	if(isset($arParams["OFFERS_PROPS"]) && !empty($arParams["OFFERS_PROPS"]))
	{
		foreach($arParams["OFFERS_PROPS"] as $val)
		{
			?>
			<input type="hidden" name="OFFERS_PROPS[]" value="<?=$val?>" />
			<?
		}
	}
	?>
		<div class="wrap_back_call">
			<p class="title"><?=GetMessage("MS_PHONE_TITLE")?></p>
			<label><?=$arParams["TEXT_TOP"]?></label>
			<input  class="" type="text" title="" name="order_phone" maxlength="16" size="" value="">
			<?
			if(Option::get('sotbit.b2bshop','SHOW_CONFIDENTIAL_PHONE','Y') == 'Y')
			{
				?>
				<div class="confidential-field">
					<input type="checkbox" id="UF_CONFIDENTIAL" name="UF_CONFIDENTIAL" class="checkbox"
					       checked="checked"
					       required>
					<label for="UF_CONFIDENTIAL" class="label-active">
						<?=GetMessage("AUTH_UF_CONFIDENTIAL");?>
					</label>
				</div>
				<?
			}
			?>
		</div>
		<div class="wrap_input">
			<input class="back_call back_call_submit" type="submit" onclick="" onsubmit="" value="<?=$arParams["SUBMIT_VALUE"]?>" name="s">
		</div>
	</form>
</div>