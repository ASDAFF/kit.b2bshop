<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;
if(!Loader::includeModule('sotbit.b2bshop'))
{
	return false;
}
$menu = new \Sotbit\B2BShop\Client\Personal\Menu();
?>

<div class="col-sm-19 sm-padding-right-no blank_right-side <?=(!$menu->isOpen()) ? 'blank_right-side_full':''?>" id="blank_right_side">
	<div id="wrapper_blank_resizer" class="wrapper_blank_resizer">
		<div class="blank_resizer">
			<div class="blank_resizer_tool <?=(!$menu->isOpen()) ? 'blank_resizer_tool_open':''?>" ></div>
		</div>
		<div class="personal-right-content">
			<div class="personal_cancel_order">
				<?if(strlen($arResult["ERROR_MESSAGE"])<=0):?>
					<form method="post" action="<?=POST_FORM_ACTION_URI?>">
						<input type="hidden" name="CANCEL" value="Y">
						<?=bitrix_sessid_post()?>
						<input type="hidden" name="ID" value="<?=$arResult["ID"]?>">
						<div class="block_text_title">
							<?=GetMessage("SALE_CANCEL_ORDER1") ?>
							<a href="<?=$arResult["URL_TO_DETAIL"]?>">
								<?=GetMessage("SALE_CANCEL_ORDER2")?> #<?=$arResult["ACCOUNT_NUMBER"]?>
							</a>?
							<b><?= GetMessage("SALE_CANCEL_ORDER3") ?></b>
						</div>
						<div class="wrap_textarea">
							<div class="title">
								<?=GetMessage("SALE_CANCEL_ORDER4")?>:
							</div>
							<textarea name="REASON_CANCELED" maxlength="250"></textarea>
						</div>
						<input class="order_cancel" type="submit" name="action" value="<?=GetMessage("SALE_CANCEL_ORDER_BTN") ?>">
					</form>
				<?else:?>
					<?=ShowError($arResult["ERROR_MESSAGE"]);?>
				<?endif;?>
			</div>
		</div>
	</div>
</div>