<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

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
	$order = \Bitrix\Sale\Order::loadByAccountNumber($arResult["ORDER_ID"]);
	$paymentCollection = $order->getPaymentCollection();
	
	foreach ($paymentCollection as $arPayment)
	{
		if($arPayment->getField('ACCOUNT_NUMBER') == $arResult['PAYMENT_ID'])
		{
			$payment = $arPayment;
		}
	}
	$psID = $payment->getPaymentSystemId();
		?>
		<div class="row">
			<div class="col-sm-6">
				<p class="prop_name"><?=\Bitrix\Main\Localization\Loc::getMessage('SPOD_PAY_SYSTEM')?>:</p>
			</div>
			<div class="col-sm-11 sm-padding-left-no">
				<p class="prop_text">
					<?php echo $arResult['PAY_SYSTEM_NAME'];
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
						echo \Bitrix\Main\Localization\Loc::getMessage('SPOD_NO');
					?>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-24">
				<div class="sale-order-detail-payment-options-methods-info">
					<div class="row-list-payments"></div>
					<span id="<?=$arResult['PAYMENT_ID']?>" class="sale-order-detail-payment-options-methods-info-change-link"><?=\Bitrix\Main\Localization\Loc::getMessage('SPOD_CHANGE_PAYMENT_TYPE')?></span>
				</div>
				<?
				$service = \Bitrix\Sale\PaySystem\Manager::getObjectById($payment->getPaymentSystemId());
				$service->initiatePay($payment);
				?>
			</div>
		</div>
	<?php 

}
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');
?>