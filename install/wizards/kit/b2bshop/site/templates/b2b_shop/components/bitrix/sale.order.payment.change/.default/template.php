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
	$wrapperId = rand(0, 10000);
	$order = \Bitrix\Sale\Order::load($arResult['PAYMENT']["ORDER_ID"]);
	$paymentCollection = $order->getPaymentCollection();
	
	foreach ($paymentCollection as $arPayment)
	{
		if($arPayment->getId() == $arResult['PAYMENT']['ID'])
		{
			$payment = $arPayment;
		}
	}
	?>
	<div class="bx-sopc" id="bx-sopc<?=$wrapperId?>">
		<div class="row">
			<div class="col-sm-6">
				<p class="prop_name"><?=\Bitrix\Main\Localization\Loc::getMessage('SPOD_PAY_SYSTEM')?>:</p>
			</div>
			<div class="col-sm-11 sm-padding-left-no">
				<p class="prop_text">
					<?php echo $arResult['PAYMENT']['PAY_SYSTEM_NAME'];
					?>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<p class="prop_name"><?=\Bitrix\Main\Localization\Loc::getMessage('SPOD_ORDER_PAYED')?>:</p>
			</div>
			<div class="col-sm-18 sm-padding-left-no">
				<p class="prop_text">
					<?
					if($arResult['PAYMENT']["PAID"] == "Y")
					{
						echo \Bitrix\Main\Localization\Loc::getMessage('SPOD_YES');
						if(strlen($arResult['PAYMENT']["DATE_PAID"]))
						{
							?>
							(<?php echo \Bitrix\Main\Localization\Loc::getMessage('SPOD_FROM');?>) <?php echo $arResult['PAYMENT']["DATE_PAID"];?>
							<?
						}
					}
					else 
					{
						echo \Bitrix\Main\Localization\Loc::getMessage('SPOD_NO');
					}?>
				</p>
			</div>
		</div>
		<div class="row">
			<?php 
			if($arResult['PAYMENT']["PAID"]!= "Y")
			{
				?>
				<div class="col-sm-24">
					<div class="sale-order-payment-change-pp">
						<div class="sale-order-payment-change-pp-list">
							<div class="row paysystem-list">
							<?
							foreach ($arResult['PAYSYSTEMS_LIST'] as $key => $paySystem)
							{
								?>
								<div class="sale-order-payment-change-pp-company col-lg-3 col-md-4 col-sm-4 col-xs-6">
									<div class="sale-order-payment-change-pp-company-graf-container">
										<input type="hidden"
											class="sale-order-payment-change-pp-company-hidden"
											name="PAY_SYSTEM_ID"
											value="<?=$paySystem['ID']?>"
											<?= ($key == 0) ? "checked='checked'" :""?>
										>
										<?
										
										if (isset($paySystem['LOGOTIP']))
										{
											?>
											<div class="sale-order-payment-change-pp-company-image"
												style="
													background-image: url(<?=$paySystem['LOGOTIP']?>);
													background-image: -webkit-image-set(url(<?=$paySystem['LOGOTIP']?>) 1x, url(<?=$paySystem['LOGOTIP']?>) 2x);
													">
											</div>
											<?
										}
										?>
									</div>
									<div class="sale-order-payment-change-pp-company-smalltitle">
										<?=CUtil::JSEscape(htmlspecialcharsbx($paySystem['NAME']))?>
									</div>
								</div>
								<?
							}
							?>
							</div>
						</div>
						<?php 
						$service = \Bitrix\Sale\PaySystem\Manager::getObjectById($payment->getPaymentSystemId());
						$service->initiatePay($payment);
						?>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?
	$javascriptParams = array(
		"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
		"templateFolder" => CUtil::JSEscape($templateFolder),
		"accountNumber" => $arParams['ACCOUNT_NUMBER'],
		"paymentNumber" => $arParams['PAYMENT_NUMBER'],
		"inner" => $arParams['ALLOW_INNER'],
		"onlyInnerFull" => $arParams['ONLY_INNER_FULL'],
		"wrapperId" => $wrapperId
	);
	$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
	?>
	<script>
		var sc = new BX.Sale.OrderPaymentChange(<?=$javascriptParams?>);
	</script>
	<?
}

