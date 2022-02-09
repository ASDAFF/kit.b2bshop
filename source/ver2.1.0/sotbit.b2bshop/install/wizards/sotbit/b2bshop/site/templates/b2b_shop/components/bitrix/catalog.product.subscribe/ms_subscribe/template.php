<?

if (! defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true)
	die();
/** @var array $arParams */
/** @var array $arResult */
/**
 *
 * @global
 */
/**
 *
 * @global
 */
/**
 *
 * @global
 */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<div class="wrap_subscribe">
	<div class="already_subscribe" id="already_subscribe">
		<?=Loc::getMessage("ALREADY_SUBSCRIBED_TEXT") ?>
	</div>
	<div class="subscribe_product_form">
		<div class="wrap_input">
			<div class="back_call_submit"><?=GetMessage("MS_DETAIL_AVAILABLE_SUBMIT")?></div>
		</div>
	</div>
	<div class="subscribe_new">
		<p class="error" style="display:none;">
		<p><?=GetMessage("MS_DETAIL_AVAILABLE_NEW_USER")?></p>
		<div class="subscribe_new_form_wrapper">
			<form class="subscribe_new_form" action="">
				<?echo bitrix_sessid_post();?>
				<input type="text" name="contact[1][user]" value="" />
				<input name="manyContact" type="hidden" value="N">
				<input name="itemId" type="hidden" value="<?=$arResult['PRODUCT_ID'] ?>">
				<input name="siteId" type="hidden" value="<?=SITE_ID ?>">
				<input name="contactFormSubmit" type="hidden" value="Y">
				<input type="submit" class="wrap_input" value="<?=GetMessage("MS_DETAIL_AVAILABLE_NEW_USER_SUBMIT")?>">
			</form>
		</div>
	</div>
	<span id="<?=htmlspecialcharsbx($arResult['BUTTON_ID'])?>"
	class="<?=htmlspecialcharsbx($arResult['BUTTON_CLASS'])?>"
	data-item="<?=htmlspecialcharsbx($arResult['PRODUCT_ID'])?>"
	style="display: none;">
		<?=Loc::getMessage('CPST_SUBSCRIBE_BUTTON_NAME')?>
</span>
</div>


<script type="text/javascript">
	$(function() {
		var msSubcribe = new msSubcribeProduct({
			"SubscribeIdHidden":"#<?=$arResult['BUTTON_ID'] ?>",
			"SubscribeNoAuth":".subscribe_product_form .back_call_submit",
			"AlreadySubscribe":".already_subscribe",
			"WrapSubscribe":".wrap_subscribe",
			"SubscribeProductForm":".subscribe_product_form",
			"SubscribeProductEmailForm":".subscribe_new_form",
			"SubscribeProductEmail":".subscribe_new",
			"SubscribeProductEmailFormWrapper":".subscribe_new_form_wrapper",
			"SubscribeProductEmailFormSubmit":".subscribe_new_form .wrap_input",
		})
	})
</script>