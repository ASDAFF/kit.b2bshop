<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

if (!empty($arResult["errorMessage"]))
{
	if (!is_array($arResult["errorMessage"]))
	{
		ShowError($arResult["errorMessage"]);
	}
	else
	{
		foreach ($arResult["errorMessage"] as $errorMessage)
		{
			ShowError($errorMessage);
		}
	}
}
else
{
	if ($arParams['REFRESHED_COMPONENT_MODE'] === 'Y')
	{
		$wrapperId = str_shuffle(substr($arResult['SIGNED_PARAMS'],0,10));
		?>
		<div class="bx-sap person_account_content" id="bx-sap<?=$wrapperId?>">
			<?
			if ($arParams['SELL_VALUES_FROM_VAR'] != 'Y')
			{
				if ($arParams['SELL_SHOW_FIXED_VALUES'] === 'Y')
				{
					?>
					<h3 class="sale-acountpay-title"><?= Loc::getMessage("SAP_FIXED_PAYMENT") ?></h3>
					<div class="sale-acountpay-fixedpay-container">
						<div class="sale-acountpay-fixedpay-list">
							<?
							foreach ($arParams["SELL_TOTAL"] as $valueChanging)
							{
								?>
								<div class="sale-acountpay-fixedpay-item">
									<?=CUtil::JSEscape(htmlspecialcharsbx($valueChanging))?>
								</div>
								<?
							}
							?>
						</div>
					</div>
					<?
				}
				?>
					<h3 class="sale-acountpay-title"><?=Loc::getMessage("SAP_SUM")?></h3>
					<div class="sale-acountpay-input-wrapper">
						<div class="form-group" style="margin-bottom: 0;">
							<?
							$inputElement = "
									<input type='text'	placeholder='0.00' 
									class='form-control input-lg sale-acountpay-input' value='0.00' 
									maxlength='9' "
									."name=".CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"]))." "
									.($arParams['SELL_USER_INPUT'] === 'N' ? "disabled" :"").
									">
								";
							$tempCurrencyRow = trim(str_replace("#", "", $arResult['FORMATED_CURRENCY']));
							$labelWrapper = "<label class='control-label input-lg input-lg'>".$tempCurrencyRow."</label>";
							$currencyRow = str_replace($tempCurrencyRow, $labelWrapper, $arResult['FORMATED_CURRENCY']);
							$currencyRow = str_replace("#", $inputElement, $currencyRow);
							echo $currencyRow;
							?>
						</div>
					</div>
			<?
			}
			else
			{
				if ($arParams['SELL_SHOW_RESULT_SUM'] === 'Y')
				{
					?>
					<h3 class="sale-acountpay-title"><?=Loc::getMessage("SAP_SUM")?></h3>
					<h2><?=SaleFormatCurrency($arResult["SELL_VAR_PRICE_VALUE"], $arParams['SELL_CURRENCY'])?></h2>
					<?
				}
				?>
				<div class="row">
					<input type="hidden" name="<?=CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"]))?>"
						class="form-control input-lg sale-acountpay-input"
						value="<?=CUtil::JSEscape(htmlspecialcharsbx($arResult["SELL_VAR_PRICE_VALUE"]))?>">
				</div>
				<?
			}
			?>
			<div class="sale-acountpay-block">
				<h3 class="sale-acountpay-title"><?=Loc::getMessage("SAP_TYPE_PAYMENT_TITLE")?></h3>
				<div>
					<div class="row sale-acountpay-pp-company-wrapper sale-acountpay-pp">
						<?
						foreach ($arResult['PAYSYSTEMS_LIST'] as $key => $paySystem)
						{
							?>
							<div class="sale-acountpay-pp-company col-lg-3 col-sm-4 col-xs-6 <?= ($key == 0) ? 'bx-selected' :""?>">
								<div class="sale-acountpay-pp-company-graf-container">
									<input type="checkbox"
											class="sale-acountpay-pp-company-checkbox"
											name="PAY_SYSTEM_ID"
											value="<?=$paySystem['ID']?>"
											<?= ($key == 0) ? "checked='checked'" :""?>
									>
									<?
									if (isset($paySystem['LOGOTIP']))
									{
										?>
										<div class="sale-acountpay-pp-company-image"
											style="
												background-image: url(<?=$paySystem['LOGOTIP']?>);
												background-image: -webkit-image-set(url(<?=$paySystem['LOGOTIP']?>) 1x, url(<?=$paySystem['LOGOTIP']?>) 2x);">
										</div>
										<?
									}
									?>
								</div>
								<div class="sale-acountpay-pp-company-smalltitle">
									<?=CUtil::JSEscape(htmlspecialcharsbx($paySystem['NAME']))?>
								</div>
							</div>
							<?
						}
						?>
					</div>
				</div>
			</div>
			<div style="clear:both"></div>
			<div class="pay-button">
				<span class="btn_add_basket btn btn-default btn-lg sale-account-pay-button"><?=Loc::getMessage("SAP_BUTTON")?></span>
			</div>
		</div>
		<?
		$javascriptParams = array(
			"alertMessages" => array("wrongInput" => Loc::getMessage('SAP_ERROR_INPUT')),
			"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
			"templateFolder" => CUtil::JSEscape($templateFolder),
			"signedParams" => $arResult['SIGNED_PARAMS'],
			"wrapperId" => $wrapperId
		);
		$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
		?>
		<script>
			var sc = new BX.saleAccountPay(<?=$javascriptParams?>);
		</script>
	<?
	}
	else
	{
		?>
		<h3><?=Loc::getMessage("SAP_BUY_MONEY")?></h3>
		<form method="post" name="buyMoney" action="">
			<?
			foreach($arResult["AMOUNT_TO_SHOW"] as $value)
			{
				?>
				<input type="radio" name="<?=CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"]))?>"
					value="<?=$value["ID"]?>" id="<?=CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"])).$value["ID"]?>">
				<label for="<?=CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"])).$value["ID"]?>"><?=$value["NAME"]?></label>
				<br />
				<?
			}
			?>
			<input type="submit" name="button" value="<?=GetMessage("SAP_BUTTON")?>">
		</form>
		<?
	}
}

