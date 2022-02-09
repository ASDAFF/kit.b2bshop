<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Config\Option;
if(!CModule::IncludeModule("kit.orderphone") || isset($_REQUEST["ORDER_ID"])) return;
global $APPLICATION;

//$APPLICATION->AddHeadScript($templateFolder."/js/jquery.maskedinput.min.js");
?>
<div class="col-sm-24 block_order_call">
	<div class="row">
		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-15">
					<h1 class="title"><?=GetMessage("MS_PHONE_BASKET")?></h1>
				</div>
				<div class="col-sm-9 sm-padding-no">
					<p class="name_call"><?=GetMessage("MS_PHONE_TITLE")?></p>
				</div>
			</div>
		</div>
		<div class="col-sm-16">
			<form class="form-order-call">
				<input type="hidden" name="SITE_ID" value="<?=SITE_ID?>" />
			<?foreach($arParams as $param=>$val):
			if(strpos($param, "~")!==false || is_array($val) || empty($val)) continue;
			?>
			<input type="hidden" name="<?=$param?>" value="<?=$val?>" />
			<?endforeach?>

			<?
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

				<div class="row">
					<div class="col-sm-14 sm-padding-right-no">
						<div class="block_order_call_center">
							<label><?=$arParams["TEXT_TOP"]?></label>
							<input  class="" type="text" title="" name="order_phone" maxlength="16" size="" value="">
						</div>
					</div>
					<div class="col-sm-10 sm-padding-left-no">
						<div class="block_order_call_right">
							<div class="wrap_input">
								<input type="submit" value="<?=$arParams["SUBMIT_VALUE"]?>" name="s">
							</div>
						</div>
					</div>
				</div>
				<?
				if(Option::get('kit.b2bshop','SHOW_CONFIDENTIAL_PHONE','Y') == 'Y')
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
			</form>
		</div>
	</div>
</div>