<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Web\Json;

Loc::loadMessages(__FILE__);
Loader::includeModule("catalog");
Loader::includeModule("sale");

$order = \Bitrix\Sale\Order::load($arResult["ID"]);
$paymentCollection = $order->getPaymentCollection();

if($arParams['GUEST_MODE'] !== 'Y')
{
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/components/bitrix/sale.order.payment.change/.default/script.js");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/components/bitrix/sale.order.payment.change/.default/style.css");
}
CJSCore::Init(array(
	'clipboard',
	'fx'
));


if(!Loader::includeModule('kit.b2bshop'))
{
	return false;
}

$menu = new \Kit\B2BShop\Client\Personal\Menu();

?>
<div class="col-sm-19 sm-padding-right-no blank_right-side <?=(!$menu->isOpen()) ? 'blank_right-side_full' : '' ?>"
	 id="blank_right_side">
	<div id="wrapper_blank_resizer" class="wrapper_blank_resizer">
		<div class="blank_resizer">
			<div class="blank_resizer_tool <?=(!$menu->isOpen()) ? 'blank_resizer_tool_open' : '' ?>"></div>
		</div>
		<div class="personal-right-content">
			<div class="personal_detail_order">
				<?
				if(!empty($arResult['ERRORS']['FATAL']))
				{
					foreach ($arResult['ERRORS']['FATAL'] as $error)
					{
						ShowError($error);
					}

					$component = $this->__component;

					if($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
					{
						$APPLICATION->AuthForm('', false, false, 'N', false);
					}
				}
				else
				{
					?>
					<div class="table_detail_order">
						<div class="b2b_detail_order__second__tab b2b_detail_order__second__tab--absolute">
							<a href="<?=$arResult["URL_TO_LIST"] ?>" class="b2b_detail_order__second__tab__backlink">
								<?=Loc::getMessage('SPOD_GO_BACK') ?>
							</a>
							<div class="b2b_detail_order__second__tab__btn">
								<span class="b2b_detail_order__second__tab__btn__text">
									<?=Loc::getMessage('SPOD_SECOND_TAB_TITLE') ?>
								</span>
								<i class="fa fa-angle-down" aria-hidden="true"></i>
							</div>
							<div class="b2b_detail_order__second__tab__btn__block b2b_detail_order__second__tab__btn__block-hide">
								<? if($arResult["CAN_CANCEL"] == "Y"): ?>
									<a class="order_cancel" href="<?=$arResult["URL_TO_CANCEL"] ?>">
										<?=Loc::getMessage("SPOD_ORDER_CANCEL") ?>
									</a>
								<? endif ?>
								<a class="order_cancel" href="<?php echo $arResult['URL_TO_COPY'] ?>">
									<?php echo Loc::getMessage("SPOD_ORDER_REPEAT") ?>
								</a>
							</div>
						</div>
						<div class="table_header">
							<div>
								<ul class="nav nav-tabs b2b_detail_order__nav_ul__block" role="tablist"
									id="b2b_detail_order__nav_ul">
									<li role="presentation" class="b2b_detail_order__nav_li active">
										<a href="#b2b_detail_order__tab_block_1"
										   aria-controls="b2b_detail_order__tab_block_1" role="tab" data-toggle="tab"
										   class="b2b_detail_order__nav__link">
											<?=Loc::getMessage("B2B_NAV_TITLE_1") ?>
										</a>
									</li>
									<li role="presentation" class="b2b_detail_order__nav_li">
										<a href="#b2b_detail_order__tab_block_2"
										   aria-controls="b2b_detail_order__tab_block_2" role="tab" data-toggle="tab"
										   class="b2b_detail_order__nav__link b2b_detail_order__nav__link_onecolumn">
											<?=Loc::getMessage("B2B_NAV_TITLE_2") ?>
										</a>
									</li>
									<li role="presentation" class="b2b_detail_order__nav_li">
										<a href="#b2b_detail_order__tab_block_3"
										   aria-controls="b2b_detail_order__tab_block_3" role="tab" data-toggle="tab"
										   class="b2b_detail_order__nav__link">
											<?=Loc::getMessage("B2B_NAV_TITLE_3") ?>
										</a>
									</li>
									<li role="presentation" class="b2b_detail_order__nav_li">
										<a href="#b2b_detail_order__tab_block_4"
										   aria-controls="b2b_detail_order__tab_block_4" role="tab" data-toggle="tab"
										   class="b2b_detail_order__nav__link">
											<?=Loc::getMessage("B2B_NAV_TITLE_4") ?>
										</a>
									</li>
									<li role="presentation" class="b2b_detail_order__nav_li">
										<a href="#b2b_detail_order__tab_block_5"
										   aria-controls="b2b_detail_order__tab_block_5" role="tab" data-toggle="tab"
										   class="b2b_detail_order__nav__link">
											<?=Loc::getMessage("B2B_NAV_TITLE_5") ?>
										</a>
									</li>
									<!--<li role="presentation" class="b2b_detail_order__nav_li">
										<a href="#b2b_detail_order__tab_block_6"
										   aria-controls="b2b_detail_order__tab_block_6" role="tab" data-toggle="tab"
										   class="b2b_detail_order__nav__link">
											<?=Loc::getMessage("B2B_NAV_TITLE_6") ?>
										</a>
									</li>-->
									<li role="presentation" class="b2b_detail_order__nav_li">
										<a href="#b2b_detail_order__tab_block_7"
										   aria-controls="b2b_detail_order__tab_block_7" role="tab" data-toggle="tab"
										   class="b2b_detail_order__nav__link b2b_detail_order__nav__link_onecolumn">
											<?=Loc::getMessage("B2B_NAV_TITLE_7") ?>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="table_body">
							<div class="tab-content b2b_detail_order__tab-content">
								<div role="tabpanel" class="tab-pane b2b_detail_order__tab-pane active"
									 id="b2b_detail_order__tab_block_1">
									<div class="b2b-detail-order__flex-wrapper">
										<li class="b2b-detail-order__block__li">
											<div class="b2b-detail-order__block">
												<div class="b2b-detail-order__block__title-wrap">
													<h3 class="b2b-detail-order__block__title">
														<?=Loc::getMessage('SPOD_ORDER') ?> <?=Loc::getMessage('SPOD_NUM_SIGN') ?><?=$arResult["ACCOUNT_NUMBER"] ?>
														<? if(strlen($arResult["DATE_INSERT_FORMATED"])): ?>
															<?=Loc::getMessage("SPOD_FROM") ?> <?=$arResult["DATE_INSERT_FORMATED"] ?>
														<? endif ?>
													</h3>
												</div>
												<div class="b2b-detail-order__block__text-wrap">
													<div class="b2b-detail-order__block__text">
														<div class="b2b-detail-order__block__prop-wrap">
															<div class="b2b-detail-order__block__prop__title-wrap">
														<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage('SPOD_ORDER_STATUS') ?>
															:</span>
															</div>
															<div class="b2b-detail-order__block__prop__text-wrap">
															<span class="b2b-detail-order__block__prop__text">
																<?=$arResult["STATUS"]["NAME"] ?>
																<? if(strlen($arResult["DATE_STATUS_FORMATED"])): ?>
																	(<?=Loc::getMessage("SPOD_FROM") ?> <?=$arResult["DATE_STATUS_FORMATED"] ?>)
																<? endif ?>
															</span>
															</div>
														</div>
														<div class="b2b-detail-order__block__prop-wrap">
															<div class="b2b-detail-order__block__prop__title-wrap">
														<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage('SPOD_ORDER_PRICE') ?>
															:</span>
															</div>
															<div class="b2b-detail-order__block__prop__text-wrap">
															<span class="b2b-detail-order__block__prop__text">
																<?=$arResult["PRICE_FORMATED"] ?>
																<? if(floatval($arResult["SUM_PAID"])): ?>
																	(<?=Loc::getMessage('SPOD_ALREADY_PAID') ?>:&nbsp;<?=$arResult["SUM_PAID_FORMATED"] ?>)
																<? endif ?>
															</span>
															</div>
														</div>
														<? if($arResult["CANCELED"] == "Y" || $arResult["CAN_CANCEL"] == "Y"): ?>
															<div class="b2b-detail-order__block__prop-wrap">
																<div class="b2b-detail-order__block__prop__title-wrap">
															<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage('SPOD_ORDER_CANCELED') ?>
																:</span>
																</div>
																<div class="b2b-detail-order__block__prop__text-wrap">
																<span class="b2b-detail-order__block__prop__text">
																	<? if($arResult["CANCELED"] == "Y"): ?>
																		<?=Loc::getMessage('SPOD_YES') ?>
																		<? if(strlen($arResult["DATE_CANCELED_FORMATED"])): ?>
																			(<?=Loc::getMessage('SPOD_FROM') ?> <?=$arResult["DATE_CANCELED_FORMATED"] ?>)
																		<? endif ?>
																	<? elseif($arResult["CAN_CANCEL"] == "Y"): ?>
																		<?=Loc::getMessage('SPOD_NO') ?>
																	<? endif ?>
																</span>
																</div>
															</div>
														<? endif ?>
													</div>
												</div>
											</div>
										</li>
										<? if(intval($arResult["USER_ID"]))
										{
											?>
											<li class="b2b-detail-order__block__li">
												<div class="b2b-detail-order__block">
													<div class="b2b-detail-order__block__title-wrap">
														<h3 class="b2b-detail-order__block__title"><?=Loc::getMessage('SPOD_ACCOUNT_DATA') ?></h3>
													</div>
													<div class="b2b-detail-order__block__text-wrap b2b-detail-order__block__user_info-wrap">
														<div class="b2b-detail-order__block__avatar-wrap">
															<? if($arResult['USER_PERSONAL_PHOTO']): ?>
																<img src="<?=$arResult['USER_PERSONAL_PHOTO']['src'] ?>"
																	 alt=""
																	 title="">
															<?
															else:
																?>
																<img src="<?=SITE_TEMPLATE_PATH ?>/site_files/img/grey_sq.png"
																	 alt=""
																	 title="">
															<? endif; ?>
														</div>
														<div class="b2b-detail-order__block__pers_block-wrap">
															<? if(strlen($arResult["USER_NAME"])): ?>
																<div class="b2b-detail-order__block__prop-wrap">
																	<div class="b2b-detail-order__block__prop__text-wrap">
																		<span class="b2b-detail-order__block__prop__text"><?=$arResult["USER_NAME"] ?></span>
																	</div>
																</div>
															<? endif ?>
															<div class="b2b-detail-order__block__prop-wrap">
																<div class="b2b-detail-order__block__prop__title-wrap">
																	<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage('SPOD_ORDER_PERS_TYPE') ?>
																		:</span>
																</div>
																<div class="b2b-detail-order__block__prop__text-wrap">
																	<span class="b2b-detail-order__block__prop__text"><?=$arResult["PERSON_TYPE"]["NAME"] ?></span>
																</div>
															</div>
															<? foreach ($arResult['BUYER'] as $buyer_prop) { ?>
																<div class="b2b-detail-order__block__prop-wrap">
																	<div class="b2b-detail-order__block__prop__title-wrap">
																		<span class="b2b-detail-order__block__prop__title"><?=$buyer_prop["NAME"] ?>
																			:</span>
																	</div>
																	<div class="b2b-detail-order__block__prop__text-wrap">
																		<span class="b2b-detail-order__block__prop__text b2b-detail-order__block__prop__text-underline"><?=$buyer_prop["VALUE"] ?></span>
																	</div>
																</div>
															<? } ?>
														</div>
													</div>
												</div>
											</li>
										<? } ?>

										<? if($arResult['COMPANY'])
										{
											?>
											<li class="b2b-detail-order__block__li">
												<div class="b2b-detail-order__block">
													<div class="b2b-detail-order__block__title-wrap">
														<h3 class="b2b-detail-order__block__title"><?=Loc::getMessage('SPOD_ORDER_COMPANY_TITLE') ?></h3>
													</div>
													<div class="b2b-detail-order__block__text-wrap">
														<? foreach ($arResult['COMPANY'] as $company_prop) { ?>
															<div class="b2b-detail-order__block__prop-wrap">
																<div class="b2b-detail-order__block__prop__title-wrap">
														<span class="b2b-detail-order__block__prop__title">
															<?=$company_prop['NAME'] ?>
														</span>
																</div>
																<div class="b2b-detail-order__block__prop__text-wrap">
														<span class="b2b-detail-order__block__prop__text">
															<?=$company_prop["VALUE"] ?>
														</span>
																</div>
															</div>
														<? } ?>
													</div>
												</div>
											</li>
										<? } ?>
										<? if($arResult['MAIL_ADDRESS'])
										{
											?>
											<li class="b2b-detail-order__block__li">
												<div class="b2b-detail-order__block">
													<div class="b2b-detail-order__block__title-wrap">
														<h3 class="b2b-detail-order__block__title"><?=Loc::getMessage('SPOD_ORDER_MAIL_ADDRESS_TITLE') ?></h3>
													</div>
													<div class="b2b-detail-order__block__text-wrap">
														<? foreach ($arResult['MAIL_ADDRESS'] as $mail_prop)
														{

															if($mail_prop['CODE'] == 'EQ_POST')
															{
																continue;
															}
															?>
															<div class="b2b-detail-order__block__prop-wrap">
																<div class="b2b-detail-order__block__prop__title-wrap">
														<span class="b2b-detail-order__block__prop__title">
															<?=$mail_prop['NAME'] ?>
														</span>
																</div>
																<div class="b2b-detail-order__block__prop__text-wrap">
														<span class="b2b-detail-order__block__prop__text">
															<? if($mail_prop["TYPE"] == "CHECKBOX"): ?>
																<?=Loc::getMessage('SPOD_' . ($mail_prop["VALUE"] == "Y" ? 'YES' : 'NO')) ?>
															<? else: ?>
																<?=$mail_prop["VALUE"] ?>
															<? endif ?>
														</span>
																</div>
															</div>
														<? } ?>
													</div>
												</div>
											</li>
										<? } ?>
										<? if($arResult['LEGAL_ADDRESS'])
										{
											?>
											<li class="b2b-detail-order__block__li">
												<div class="b2b-detail-order__block">
													<div class="b2b-detail-order__block__title-wrap">
														<h3 class="b2b-detail-order__block__title"><?=Loc::getMessage('SPOD_ORDER_ADDRESS_TITLE') ?></h3>
													</div>
													<div class="b2b-detail-order__block__text-wrap">
														<? foreach ($arResult['LEGAL_ADDRESS'] as $legal_prop) { ?>
															<div class="b2b-detail-order__block__prop-wrap">
																<div class="b2b-detail-order__block__prop__title-wrap">
														<span class="b2b-detail-order__block__prop__title">
															<?=$legal_prop['NAME'] ?>
														</span>
																</div>
																<div class="b2b-detail-order__block__prop__text-wrap">
														<span class="b2b-detail-order__block__prop__text">
															<?=$legal_prop["VALUE"] ?>
														</span>
																</div>
															</div>
														<? } ?>
													</div>
												</div>
											</li>
										<? } ?>


										<li class="b2b-detail-order__block__li">
											<div class="b2b-detail-order__block">
												<div class="b2b-detail-order__block__title-wrap">
													<h3 class="b2b-detail-order__block__title"><?=Loc::getMessage("SPOD_ORDER_PAYMENT") ?></h3>
												</div>

												<div class="b2b-detail-order__block__text-wrap">
													<?
													foreach ($paymentCollection as $i => $payment)
													{
														$id = $payment->getField('ID');

														foreach ($arResult['PAYMENT'] as $k => $pay)
														{
															if($pay['ID'] == $id)
															{
																$key = $k;
																break;
															}
														}

														$paymentData[$arResult['PAYMENT'][$key]['ACCOUNT_NUMBER']] = array(
															"payment" => $arResult['PAYMENT'][$key]['ACCOUNT_NUMBER'],
															"order" => $arResult['PAYMENT'][$key]['ORDER_ID'],
															"allow_inner" => $arResult['PAYMENT'][$key]['ALLOW_INNER'],
															"only_inner_full" => $arParams['ONLY_INNER_FULL']
														);
														?>
														<div class="payment-wrapper">
															<div class="b2b-detail-order__block__prop-wrap">
																<div class="b2b-detail-order__block__prop__title-wrap">
															<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage('SPOD_PAY_SYSTEM') ?>
																:</span>
																</div>
																<div class="b2b-detail-order__block__prop__text-wrap">
																<span class="b2b-detail-order__block__prop__text">
																	<?php echo $arResult['PAYMENT'][$key]['PAY_SYSTEM_NAME'];
																	?>
																</span>
																</div>
															</div>
															<div class="b2b-detail-order__block__prop-wrap">
																<div class="b2b-detail-order__block__prop__title-wrap">
															<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage('SPOD_ORDER_PAYED') ?>
																:</span>
																</div>
																<div class="b2b-detail-order__block__prop__text-wrap">
																<span class="b2b-detail-order__block__prop__text">
																	<?
																	if($payment->isPaid())
																	{
																		echo Loc::getMessage('SPOD_YES');

																		if(strlen($arResult['PAYMENT'][$key]["DATE_PAID"]))
																		{
																			?>
																			(<?php echo Loc::getMessage('SPOD_FROM'); ?><?php echo $arResult['PAYMENT'][$key]["DATE_PAID"]->format('d.m.Y') ?>)
																			<?
																		}
																	}
																	else
																	{
																		echo Loc::getMessage('SPOD_NO');
																	} ?>
																</span>
																</div>
															</div>
															<div class="row">
																<?php
																if(!$payment->isPaid())
																{
																	?>
																	<div class="col-sm-24">
																		<?php

																		if(
																			$arResult['PAYMENT'][$key]['PAID'] !== 'Y'
																			&& $arResult['CANCELED'] !== 'Y'
																			&& $arParams['GUEST_MODE'] !== 'Y'
																			&& $arResult['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'
																		)
																		{
																			?>
																			<div class="sale-order-detail-payment-options-methods-info">
																				<div class="row-list-payments"></div>
																				<span id="<?=$arResult['PAYMENT'][$key]['ACCOUNT_NUMBER'] ?>"
																					  class="sale-order-detail-payment-options-methods-info-change-link"><?=Loc::getMessage('SPOD_CHANGE_PAYMENT_TYPE') ?></span>
																			</div>
																			<?
																			if($arResult['PAYMENT'][$key]['PAY_SYSTEM']['ACTION_FILE'] == 'billkit' || $arResult['PAYMENT'][$key]['PAY_SYSTEM']['ACTION_FILE'] == 'bill')
																			{
																				$PaymentId = $payment->getId();
																				?>
																				<div class="data_block">
																					<div class="row">
																						<div class="col-sm-24">

																							<div class="b2b-detail-order__block__prop-wrap">
																								<div class="b2b-detail-order__block__prop__title-wrap">
																									<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage("SHOW_BILL_TITLE") ?></span>
																								</div>
																								<div class="b2b-detail-order__block__prop__text-wrap">
																								<span class="b2b-detail-order__block__prop__text b2b-detail-order__block__payment__bill-wrap">
																									<?=Loc::getMessage("SHOW_BILL", array(
																										'#ORDER_ID#' => $arResult["ID"],
																										'#PAYMENT_ID#' => $PaymentId,
																										'#DATE#' =>	date('d.m.Y', strtotime($arResult['PAYMENT'][$key]['DATE_BILL']->toString()))
																									)) ?>
																								 </span>
																								</div>
																							</div>
																							<div class="b2b-detail-order__block__prop-wrap">
																								<div class="b2b-detail-order__block__prop__title-wrap">
																									<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage("DOWNLOAD_BILL_TITLE") ?></span>
																								</div>
																								<div class="b2b-detail-order__block__prop__text-wrap">
																								<span class="b2b-detail-order__block__prop__text b2b-detail-order__block__payment__bill-wrap">
																									<?=Loc::getMessage("DOWNLOAD_BILL", array(
																										'#ORDER_ID#' => $arResult["ID"],
																										'#PAYMENT_ID#' => $PaymentId,
																										'#DATE#' =>	date('d.m.Y', strtotime($arResult['PAYMENT'][$key]['DATE_BILL']->toString()))
																									)) ?>
																								 </span>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																				<?php
																			}

																			else
																			{ ?>
																				<div class="" id="bitrix__bill">
																					<div class="bitrix__bill-wrapper">
																						<?
																						$service = \Bitrix\Sale\PaySystem\Manager::getObjectById($payment->getPaymentSystemId());
																						$service->initiatePay($payment);
																						?>
																					</div>

																				</div>
																			<? }
																		}
																		?>
																	</div>
																	<?php
																}
																else
																{
																	if
																	($arResult['PAYMENT'][$key]['PAY_SYSTEM']['ACTION_FILE']
																		== 'billkit' || $arResult['PAYMENT'][$key]['PAY_SYSTEM']['ACTION_FILE'] == 'bill')
																	{
																		$PaymentId = $payment->getId();
																		?>
																		<div class="col-sm-24">
																			<div class="data_block">
																				<div class="row">
																					<div class="col-sm-24">
																						<div class="b2b-detail-order__block__prop-wrap">
																							<div class="b2b-detail-order__block__prop__title-wrap">
																								<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage("SHOW_BILL_TITLE") ?></span>
																							</div>
																							<div class="b2b-detail-order__block__prop__text-wrap">
																								<span class="b2b-detail-order__block__prop__text b2b-detail-order__block__payment__bill-wrap">
																									<?=Loc::getMessage("SHOW_BILL", array(
																										'#ORDER_ID#' => $arResult["ID"],
																										'#PAYMENT_ID#' => $PaymentId,
																										'#DATE#' =>	date('d.m.Y', strtotime($arResult['PAYMENT'][$key]['DATE_BILL']->toString()))
																									)) ?>
																								 </span>
																							</div>
																						</div>
																						<div class="b2b-detail-order__block__prop-wrap">
																							<div class="b2b-detail-order__block__prop__title-wrap">
																								<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage("DOWNLOAD_BILL_TITLE") ?></span>
																							</div>
																							<div class="b2b-detail-order__block__prop__text-wrap">
																								<span class="b2b-detail-order__block__prop__text b2b-detail-order__block__payment__bill-wrap">
																									<?=Loc::getMessage("DOWNLOAD_BILL", array(
																										'#ORDER_ID#' => $arResult["ID"],
																										'#PAYMENT_ID#' => $PaymentId,
																										'#DATE#' =>	date('d.m.Y', strtotime($arResult['PAYMENT'][$key]['DATE_BILL']->toString()))
																									)) ?>
																								 </span>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<?php
																	}
																}
																?>
															</div>
														</div>
														<?php
														if($i < sizeof($arResult['PAYMENT']) - 1)
														{
															?>
															<div class="row">
																<div class="col-sm-24">
																	<div class="detail_payment_border"></div>
																</div>
															</div>
															<?php
														}
													} ?>
												</div>
											</div>
										</li>
										<?php
										if($arResult['SHIPMENT'])
										{
											?>
											<li class="b2b-detail-order__block__li">
												<div class="b2b-detail-order__block">
													<div class="b2b-detail-order__block__title-wrap">
														<h3 class="b2b-detail-order__block__title"><?=Loc::getMessage("SPOD_ORDER_DELIVERY_BLOCK") ?></h3>
													</div>
													<div class="b2b-detail-order__block__text-wrap">
														<?php
														foreach ($arResult['SHIPMENT'] as $i => $shipment)
														{
														?>
														<div class="b2b-detail-order__block__prop-wrap">
															<div class="b2b-detail-order__block__prop__title-wrap">
																	<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage("SPOD_ORDER_DELIVERY") ?>
																		:</span>
															</div>
															<div class="b2b-detail-order__block__prop__text-wrap">
																	<span class="b2b-detail-order__block__prop__text">
																		<?php echo $shipment["DELIVERY_NAME"]; ?>
																	</span>
															</div>
														</div>
														<?php
														$store = $arResult['DELIVERY']['STORE_LIST'][$shipment['STORE_ID']];
														if(isset($store))
														{
															?>
															<div class="row">
																<div class="col-sm-6">
																	<div class="bx_ol_store">
																		<div class="bx_old_s_row_title">
																			<?=Loc::getMessage('SPOD_TAKE_FROM_STORE') ?>
																			:
																			<b><?=$store['TITLE'] ?></b>
																			<?
																			if(!empty($store['DESCRIPTION']))
																			{
																				?>
																				<div class="bx_ild_s_desc">
																					<?=$store['DESCRIPTION'] ?>
																				</div>
																				<?
																			} ?>
																		</div>
																		<?
																		if(!empty($store['ADDRESS']))
																		{
																			?>
																			<div class="bx_old_s_row">
																				<b><?=Loc::getMessage('SPOD_STORE_ADDRESS') ?></b>: <?=$store['ADDRESS'] ?>
																			</div>
																			<?
																		} ?>

																		<?
																		if(!empty($store['SCHEDULE']))
																		{
																			?>
																			<div class="bx_old_s_row">
																				<b><?=Loc::getMessage('SPOD_STORE_WORKTIME') ?></b>: <?=$store['SCHEDULE'] ?>
																			</div>
																			<?
																		} ?>

																		<?
																		if(!empty($store['PHONE']))
																		{
																			?>
																			<div class="bx_old_s_row">
																				<b><?=Loc::getMessage('SPOD_STORE_PHONE') ?></b>: <?=$store['PHONE'] ?>
																			</div>
																			<?
																		} ?>

																		<?
																		if(!empty($store['EMAIL']))
																		{
																			?>
																			<div class="bx_old_s_row">
																				<b><?=Loc::getMessage('SPOD_STORE_EMAIL') ?></b>:
																				<a href="mailto:<?=$store['EMAIL'] ?>"><?=$store['EMAIL'] ?></a>
																			</div>
																			<?
																		} ?>
																	</div>
																</div>
																<?php
																if($store['GPS_S'] && $store['GPS_N'])
																{
																	?>
																	<div class="col-sm-11 sm-padding-left-no">
																		<?php
																		$APPLICATION->IncludeComponent(
																			"bitrix:map.yandex.view",
																			"",
																			Array(
																				"INIT_MAP_TYPE" => "COORDINATES",
																				"MAP_DATA" => serialize(
																					array(
																						'yandex_lon' => $store['GPS_S'],
																						'yandex_lat' => $store['GPS_N'],
																						'PLACEMARKS' => array(
																							array(
																								"LON" => $store['GPS_S'],
																								"LAT" => $store['GPS_N'],
																								"TEXT" => $store['TITLE']
																							)
																						)
																					)
																				),
																				"MAP_WIDTH" => "100%",
																				"MAP_HEIGHT" => "300",
																				"CONTROLS" => array(
																					"ZOOM",
																					"SMALLZOOM",
																					"SCALELINE"
																				),
																				"OPTIONS" => array(
																					"ENABLE_DRAGGING",
																					"ENABLE_SCROLL_ZOOM",
																					"ENABLE_DBLCLICK_ZOOM"
																				),
																				"MAP_ID" => ""
																			)
																		);
																		?>
																	</div>
																	<?php
																}
																?>
															</div>
															<?php
														}
														?>
														<div class="b2b-detail-order__block__prop-wrap">
															<div class="b2b-detail-order__block__prop__title-wrap">
																	<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage("SPOD_ORDER_SHIPMENT_STATUS") ?>
																		:</span>
															</div>
															<div class="b2b-detail-order__block__prop__text-wrap>
																	<span class=" b2b-detail-order__block__prop__text
															">
															<?php echo htmlspecialcharsbx($shipment['STATUS_NAME']); ?>
															</span>
														</div>
													</div>
													<div class="b2b-detail-order__block__prop-wrap">
														<div class="b2b-detail-order__block__prop__title-wrap">
															<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage("SPOD_SUB_PRICE_DELIVERY") ?></span>
														</div>
														<div class="b2b-detail-order__block__prop__text-wrap">
																	<span class="b2b-detail-order__block__prop__text">
																		<?php echo $shipment['PRICE_DELIVERY_FORMATED']; ?>
																	</span>
														</div>
													</div>
													<?php if($shipment['TRACKING_NUMBER'])
													{
														?>
														<div class="b2b-detail-order__block__prop-wrap">
															<div class="b2b-detail-order__block__prop__title-wrap">
																	<span class="b2b-detail-order__block__prop__title"><?=Loc::getMessage("SPOD_ORDER_TRACKING_NUMBER") ?>
																		:</span>
															</div>
															<div class="b2b-detail-order__block__prop__text-wrap">
																	<span class="b2b-detail-order__block__prop__text">
																		<?php echo $shipment['TRACKING_NUMBER']; ?>
																	</span>
															</div>
														</div>
														<?php
													}
													if($i < sizeof($arResult['SHIPMENT']) - 1)
													{
														?>
														<div class="detail_payment_border"></div>
														<?php
													}
													}
													?>
												</div>
											</li>
											<?php
										} ?>
									</div>
									<div class="row">
										<div class="col-sm-24">
											<div class="b2b_detail_order__items_title">
												<div class="b2b_detail_order__items_title-wrap">
														<span class="b2b_detail_order__items_title__text">
															<?=Loc::getMessage('ITEMS_TITLE') ?>
														</span>
												</div>
												<div class="excel-button" id="excel-button">
														<span class="b2b_detail_order__items_title__excel_btn">
															<?=Loc::getMessage('EXCEL_BUTTON') ?>
														</span>
												</div>
											</div>
										</div>
									</div>
									<div class="personal_order_item">
										<div class="div_table_header">
											<div class="div_table__name">
												<h4 class="div_table_header__title"><?=Loc::getMessage('SPOD_NAME') ?></h4>
											</div>
											<div class="div_table__article">
												<h4 class="div_table_header__title"><?=Loc::getMessage('SPOD_ARTICLE') ?></h4>
											</div>
											<div class="div_table__quantity">
												<h4 class="div_table_header__title"><?=Loc::getMessage('SPOD_QUANTITY') ?></h4>
											</div>
											<div class="div_table__price">
												<h4 class="div_table_header__title"><?=Loc::getMessage('SPOD_PRICE') ?></h4>
											</div>
											<div class="div_table__discount">
												<h4 class="div_table_header__title"><?=Loc::getMessage('SPOD_DISCOUNT') ?></h4>
											</div>
											<div class="div_table__summ">
												<h4 class="div_table_header__title"><?=Loc::getMessage('SPOD_SUMMARY') ?></h4>
											</div>
										</div>
										<div class="div_table_body">
											<? foreach ($arResult["BASKET"] as $key => $prod)
											{
												?>
												<div id="item_<? echo($key + 1); ?>" class="basket_item">
													<div class="div_table__name">
														<? $hasLink = !empty($prod["DETAIL_PAGE_URL"]); ?>
														<div class="div_table__name-wrap">
															<p class="div_table__name__item_name">
																<? if($hasLink)
																{
																?>
																<a href="<?=$prod["DETAIL_PAGE_URL"] ?>"
																   target="_blank">
																	<? } ?>
																	<?=htmlspecialcharsEx($prod["NAME"]) ?>
																	<? if($hasLink)
																	{
																	?>
																</a>
															<? } ?>
															</p>
														</div>
														<? if($arResult['HAS_PROPS'])
														{
															?>
															<? $actuallyHasProps = is_array($prod["PROPS"]) && !empty($prod["PROPS"]); ?>
															<div class="div_table__name__prop-wrap">
																<? if($actuallyHasProps)
																{
																	?>
																	<? foreach ($prod["PROPS"] as $prop)
																{
																	?>
																	<p class="div_table__name__prop"><?=$prop["NAME"] ?>
																		:
																		<span class="black"><?=$prop["VALUE"] ?></span>
																	</p>
																<? } ?>
																<? } ?>
															</div>
														<? } ?>
													</div>
													<div class="div_table__article">
														<p class="div_table__article__item__media_title">
															<?=Loc::getMessage('SPOD_ARTICLE') ?>
														</p>
														<p class="div_table__article__item_article">
															<?=$prod['ARTICLE'] ?>
														</p>
													</div>
													<div class="div_table__quantity">
														<p class="div_table__article__item__media_title">
															<?=Loc::getMessage('SPOD_QUANTITY') ?>
														</p>
														<p class="div_table__quantity__item_quantity">
															<? echo $prod["QUANTITY"] . ' ';
															if(strlen($prod['MEASURE_TEXT']))
															{
																echo $prod['MEASURE_TEXT'] . '.';
															}
															else
															{
																echo Loc::getMessage('SPOD_DEFAULT_MEASURE');
															} ?>
														</p>
													</div>
													<div class="div_table__price">
														<p class="div_table__article__item__media_title">
															<?=Loc::getMessage('SPOD_PRICE') ?>
														</p>
														<p class="div_table__price__item_price"><?=$prod["PRICE_FORMATED"] ?></p>
													</div>
													<div class="div_table__discount">
														<? if($arResult['HAS_DISCOUNT'])
														{
															?>
															<p class="div_table__article__item__media_title">
																<?=Loc::getMessage('SPOD_DISCOUNT') ?>
															</p>
															<p class="div_table__discount__item_discount"><?=$prod["DISCOUNT_PRICE_PERCENT_FORMATED"] ?></p>
														<? } ?>
													</div>
													<div class="div_table__summ">
														<p class="div_table__article__item__media_title">
															<?=Loc::getMessage('SPOD_SUMMARY') ?>
														</p>
														<p class="div_table__summ__item_summ"><?=$prod["FULL_PRICE_FORMATED"] ?></p>
													</div>
												</div>
											<? } ?>
										</div>
										<div class="personal_order__summary_block">
											<div class="personal_order__block_order_count_title">
												<span><?=Loc::getMessage('SPOD_YOU_ORDER'); ?></span>
											</div>
											<div class="personal_order__block_order_count">
												<div class="personal_order__block_order_count__one_block">
													<p class="personal_order__order_prop__title">
														<span><?=Loc::getMessage('SPOD_PRODUCT_QUANTITY') ?></span>
													</p>
													<p class="personal_order__order_prop">
														<span><?=$arResult["ALL_QUANTITY"] ?></span>
													</p>
												</div>
												<div class="personal_order__block_order_count__one_block">
													<p class="personal_order__order_prop__title">
														<span><?=Loc::getMessage('SPOD_PRODUCT_SUM') ?></span>
													</p>
													<p class="personal_order__order_prop">
														<span><?=$arResult['PRODUCT_SUM_FORMATTED'] ?></span>
													</p>
												</div>
												<div class="personal_order__block_order_count__one_block">
													<p class="personal_order__order_prop__title">
														<span><?=Loc::getMessage('SPOD_PRODUCT_NDS') ?></span>
													</p>
													<p class="personal_order__order_prop">
														<span><?=$arResult['TAX_VALUE_FORMATED'] ?></span>
													</p>
												</div>
												<div class="personal_order__block_order_count__one_block">
													<p class="personal_order__order_prop__title">
														<span><?=Loc::getMessage('SPOD_TOTAL_WEIGHT') ?></span>
													</p>
													<p class="personal_order__order_prop">
														<span><?=$arResult['ORDER_WEIGHT_FORMATED'] ?></span>
													</p>
												</div>

												<div class="personal_order__block_order_count__one_block">
													<p class="personal_order__order_prop__title">
														<span><?=Loc::getMessage('SPOD_DELIVERY') ?></span>
													</p>
													<p class="personal_order__order_prop">
														<span><?=$arResult['PRICE_DELIVERY_FORMATED'] ?></span>
													</p>
												</div>
												<div class="personal_order__block_order_count__one_block">
													<p class="personal_order__order_prop__title">
														<span><?=Loc::getMessage('SPOD_SUMMARY') ?></span>
													</p>
													<p class="personal_order__order_prop">
														<span><?=$arResult['PRICE_FORMATED'] ?></span>
													</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane b2b_detail_order__tab-pane"
									 id="b2b_detail_order__tab_block_2">
									<div class="main-ui-filter-search-wrapper">
										<?
										$APPLICATION->IncludeComponent('bitrix:main.ui.filter', 'ms_personal_order', [
											'FILTER_ID' => 'PRODUCT_LIST',
											'GRID_ID' => 'PRODUCT_LIST',
											'FILTER' => [
												[
													'id' => 'NAME',
													'name' =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_NAME'),
													'type' => 'string'
												],
												[
													'id' => 'ARTICLE',
													'name' =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_ARTICLE'),
													'type' => 'string'
												],
												[
													'id' => 'QUANTITY',
													'name' =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_QUANTITY'),
													'type' => 'string'
												],
												[
													'id' => 'SUM',
													'name' =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_SUM2'),
													'type' => 'string'
												],
											],
											'ENABLE_LIVE_SEARCH' => true,
											'ENABLE_LABEL' => true
										]);
										?>
									</div>
									<?
									$APPLICATION->IncludeComponent(
										'bitrix:main.ui.grid',
										'',
										array(
											'GRID_ID' => 'PRODUCT_LIST',
											'HEADERS' => array(
												array(
													"id" => "NAME",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_NAME'),
													"sort" => "NAME",
													"default" => true
												),
												array(
													"id" => "ARTICLE",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_ARTICLE'),
													"sort" => "ARTICLE",
													"default" => true
												),
												array(
													"id" => "QUANTITY",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_QUANTITY'),
													"sort" => "QUANTITY",
													"default" => true
												),
												array(
													"id" => "SUM",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_SUM2'),
													"sort" => "SUM",
													"default" => true
												),
											),
											'ROWS' => $arResult['PRODUCT_ROWS'],
											'FILTER_STATUS_NAME' => '',
											'AJAX_MODE' => 'Y',
											"AJAX_OPTION_JUMP" => "N",
											"AJAX_OPTION_STYLE" => "N",
											"AJAX_OPTION_HISTORY" => "N",

											"ALLOW_COLUMNS_SORT" => true,
											"ALLOW_ROWS_SORT" => array(),
											"ALLOW_COLUMNS_RESIZE" => true,
											"ALLOW_HORIZONTAL_SCROLL" => true,
											"ALLOW_SORT" => false,
											"ALLOW_PIN_HEADER" => true,
											"ACTION_PANEL" => array(),

											"SHOW_CHECK_ALL_CHECKBOXES" => false,
											"SHOW_ROW_CHECKBOXES" => false,
											"SHOW_ROW_ACTIONS_MENU" => true,
											"SHOW_GRID_SETTINGS_MENU" => true,
											"SHOW_NAVIGATION_PANEL" => true,
											"SHOW_PAGINATION" => true,
											"SHOW_SELECTED_COUNTER" => false,
											"SHOW_TOTAL_COUNTER" => true,
											"SHOW_PAGESIZE" => true,
											"SHOW_ACTION_PANEL" => true,

											"ENABLE_COLLAPSIBLE_ROWS" => true,
											'ALLOW_SAVE_ROWS_STATE' => true,

											"SHOW_MORE_BUTTON" => false,
											'~NAV_PARAMS' => $arResult['GET_LIST_PARAMS']['NAV_PARAMS'],
											'NAV_OBJECT' => $arResult['NAV_OBJECT'],
											'NAV_STRING' => $arResult['NAV_STRING'],
											"TOTAL_ROWS_COUNT" => count($arResult['PAYMENT_ROWS']),
											"CURRENT_PAGE" => $arResult['CURRENT_PAGE'],
											"PAGE_SIZES" => 20,
											"DEFAULT_PAGE_SIZE" => 50
										),
										$component,
										array('HIDE_ICONS' => 'Y')
									);
									?>
								</div>
								<div role="tabpanel" class="tab-pane b2b_detail_order__tab-pane"
									 id="b2b_detail_order__tab_block_3">
									<div class="main-ui-filter-search-wrapper">
										<?
										$APPLICATION->IncludeComponent('bitrix:main.ui.filter', 'ms_personal_order', [
											'FILTER_ID' => 'DOCUMENTS_LIST',
											'GRID_ID' => 'DOCUMENTS_LIST',
											'FILTER' => [
												['id' => 'ID', 'name' => Loc::getMessage('DOC_ID'), 'type' => 'string'],
												['id' => 'NAME', 'name' => Loc::getMessage('DOC_NAME'), 'type' => 'string'],
												['id' => 'DATE_CREATE', 'name' => Loc::getMessage('DOC_DATE_CREATE'), 'type' => 'date'],
												['id' => 'DATE_UPDATE', 'name' => Loc::getMessage('DOC_DATE_UPDATE'), 'type' => 'date'],
											],
											'ENABLE_LIVE_SEARCH' => true,
											'ENABLE_LABEL' =>  true
										]);
										?>
									</div>
									<?
									$APPLICATION->IncludeComponent(
										'bitrix:main.ui.grid',
										'',
										array(
											'GRID_ID'   => 'DOCUMENTS_LIST',
											'HEADERS' => array(
												array("id"=>"ID", "name"=>Loc::getMessage('DOC_ID'), "sort"=>"ID", "default"=>true, "editable"=>false),
												array("id"=>"NAME", "name"=>Loc::getMessage('DOC_NAME'), "sort"=>"NAME", "default"=>true, "editable"=>false),
												array("id"=>"DATE_CREATE", "name"=>Loc::getMessage('DOC_DATE_CREATE'), "sort"=>"DATE_CREATE", "default"=>true, "editable"=>false),
												array("id"=>"DATE_UPDATE", "name"=>Loc::getMessage('DOC_DATE_UPDATE'), "sort"=>"DATE_UPDATE", "default"=>true, "editable"=>false),
												array("id"=>"ORGANIZATION", "name"=>Loc::getMessage('DOC_ORGANIZATION'),  "default"=>true, "editable"=>false),
											),
											'ROWS'      => $arResult['ROWS'],
											'AJAX_MODE'           => 'Y',

											"AJAX_OPTION_JUMP"    => "N",
											"AJAX_OPTION_STYLE"   => "N",
											"AJAX_OPTION_HISTORY" => "N",

											"ALLOW_COLUMNS_SORT"      => true,
											"ALLOW_ROWS_SORT"         => ['ID','NAME','DATE_CREATE','DATE_UPDATE'],
											"ALLOW_COLUMNS_RESIZE"    => true,
											"ALLOW_HORIZONTAL_SCROLL" => true,
											"ALLOW_SORT"              => true,
											"ALLOW_PIN_HEADER"        => true,
											"ACTION_PANEL"            => [],

											"SHOW_CHECK_ALL_CHECKBOXES" => false,
											"SHOW_ROW_CHECKBOXES"       => false,
											"SHOW_ROW_ACTIONS_MENU"     => true,
											"SHOW_GRID_SETTINGS_MENU"   => true,
											"SHOW_NAVIGATION_PANEL"     => true,
											"SHOW_PAGINATION"           => true,
											"SHOW_SELECTED_COUNTER"     => false,
											"SHOW_TOTAL_COUNTER"        => true,
											"SHOW_PAGESIZE"             => true,
											"SHOW_ACTION_PANEL"         => true,

											"ENABLE_COLLAPSIBLE_ROWS" => true,
											'ALLOW_SAVE_ROWS_STATE'=>true,

											"SHOW_MORE_BUTTON" => false,
											'~NAV_PARAMS'       => $arResult['GET_LIST_PARAMS']['NAV_PARAMS'],
											'NAV_OBJECT'       => $arResult['NAV_OBJECT'],
											'NAV_STRING'       => $arResult['NAV_STRING'],
											"TOTAL_ROWS_COUNT"  => count($arResult['ROWS']),
											"CURRENT_PAGE" => $arResult[ 'CURRENT_PAGE' ],
											"PAGE_SIZES" => $arParams['ORDERS_PER_PAGE'],
											"DEFAULT_PAGE_SIZE" => 50
										),
										$component,
										array('HIDE_ICONS' => 'Y')
									);
									?>
								</div>
								<div role="tabpanel" class="tab-pane b2b_detail_order__tab-pane"
									 id="b2b_detail_order__tab_block_4">
									<div class="main-ui-filter-search-wrapper">
										<?
										$APPLICATION->IncludeComponent('bitrix:main.ui.filter', 'ms_personal_order', [
											'FILTER_ID' => 'PAYMENT_LIST',
											'GRID_ID' => 'PAYMENT_LIST',
											'FILTER' => [
												[
													'id' => 'ID',
													'name' =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_ID'),
													'type' => 'string'
												],
												[
													'id' => 'DATE_BILL',
													'name' =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_DATE'),
													'type' => 'date'
												],
												[
													'id' => 'PAID',
													'name' =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_PAID'),
													'type' => 'list',
													'items' => [
														'' =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_ANY'),
														'Y' =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_PAYED_Y'),
														'N' =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_PAYED_N')
													]
												]
											],
											'ENABLE_LIVE_SEARCH' => true,
											'ENABLE_LABEL' => true
										]);
										?>
									</div>
									<?
									$APPLICATION->IncludeComponent(
										'bitrix:main.ui.grid',
										'',
										array(
											'GRID_ID' => 'PAYMENT_LIST',
											'HEADERS' => array(
												array(
													"id" => "ID",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_ID'),
													"sort" => "ID",
													"default" => true,
													"editable" => false
												),
												array(
													"id" => "DATE_BILL",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_DATE'),
													"sort" => "DATE_BILL",
													"default" => true,
													"editable" => false
												),
												array(
													"id" => "PAID",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_PAID_HEADER'),
													"sort" => "PAID",
													"default" => true
												),
												array(
													"id" => "PAYMENT_METHOD",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_PAYMENT_METHOD'),
													"sort" => "PAYMENT_METHOD",
													"default" => true
												),
												array(
													"id" => "SUM",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_SUM'),
													"sort" => "SUM",
													"default" => true
												),
											),
											'ROWS' => $arResult['PAYMENT_ROWS'],
											'FILTER_STATUS_NAME' => $arResult['FILTER_STATUS_NAME'],
											'AJAX_MODE' => 'Y',
											"AJAX_OPTION_JUMP" => "N",
											"AJAX_OPTION_STYLE" => "N",
											"AJAX_OPTION_HISTORY" => "N",

											"ALLOW_COLUMNS_SORT" => true,
											"ALLOW_ROWS_SORT" => array(
												'ID',
												'PAID',
												'PAYMENT_METHOD',
												'SUM'
											),
											"ALLOW_COLUMNS_RESIZE" => true,
											"ALLOW_HORIZONTAL_SCROLL" => true,
											"ALLOW_SORT" => false,
											"ALLOW_PIN_HEADER" => true,
											"ACTION_PANEL" => array(),

											"SHOW_CHECK_ALL_CHECKBOXES" => false,
											"SHOW_ROW_CHECKBOXES" => false,
											"SHOW_ROW_ACTIONS_MENU" => true,
											"SHOW_GRID_SETTINGS_MENU" => true,
											"SHOW_NAVIGATION_PANEL" => true,
											"SHOW_PAGINATION" => true,
											"SHOW_SELECTED_COUNTER" => false,
											"SHOW_TOTAL_COUNTER" => true,
											"SHOW_PAGESIZE" => true,
											"SHOW_ACTION_PANEL" => true,

											"ENABLE_COLLAPSIBLE_ROWS" => true,
											'ALLOW_SAVE_ROWS_STATE' => true,

											"SHOW_MORE_BUTTON" => false,
											'~NAV_PARAMS' => $arResult['GET_LIST_PARAMS']['NAV_PARAMS'],
											'NAV_OBJECT' => $arResult['NAV_OBJECT'],
											'NAV_STRING' => $arResult['NAV_STRING'],
											"TOTAL_ROWS_COUNT" => count($arResult['PAYMENT_ROWS']),
											"CURRENT_PAGE" => $arResult['CURRENT_PAGE'],
											"PAGE_SIZES" => 20,
											"DEFAULT_PAGE_SIZE" => 50
										),
										$component,
										array('HIDE_ICONS' => 'Y')
									);
									?>
								</div>
								<div role="tabpanel" class="tab-pane b2b_detail_order__tab-pane"
										 id="b2b_detail_order__tab_block_5">
									<div class="main-ui-filter-search-wrapper">
										<?
										$APPLICATION->IncludeComponent('bitrix:main.ui.filter', 'ms_personal_order', [
											'FILTER_ID' => 'SHIPMENT_LIST',
											'GRID_ID' => 'SHIPMENT_LIST',
											'FILTER' => [
												[
													'id' => 'ID_SHIPMENT',
													'name' =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_ID'),
													'type' => 'string'
												],
												[
													'id' => 'DATE_INSERT',
													'name' =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_DATE'),
													'type' => 'date'
												],
												[
													'id' => 'STATUS_ID',
													'name' =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_STATUS'),
													'type' => 'list',
													'items'  => $arResult['SHIPMENT_LIST'],
												],
											],
											'ENABLE_LIVE_SEARCH' => true,
											'ENABLE_LABEL' => true
										]);
										?>
									</div>
									<?
									$APPLICATION->IncludeComponent(
										'bitrix:main.ui.grid',
										'',
										array(
											'GRID_ID' => 'SHIPMENT_LIST',
											'HEADERS' => array(
												array(
													"id" => "ID",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_ID'),
													"sort" => "ID",
													"default" => true,
													"editable" => false
												),
												array(
													"id" => "DATE_INSERT",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_DATE'),
													"sort" => "DATE_INSERT",
													"default" => true,
													"editable" => false
												),
												array(
													"id" => "NAME",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_NAME'),
													"sort" => "NAME",
													"default" => true
												),
												array(
													"id" => "STATUS",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_STATUS'),
													"sort" => "STATUS",
													"default" => true
												),
												array(
													"id" => "PRICE",
													"name" =>Loc::getMessage('SPOL_ORDER_FIELD_NAME_SUM'),
													"sort" => "PRICE",
													"default" => true
												),
											),
											'ROWS' => $arResult['SHIPMENT_ROWS'],
											'FILTER_STATUS_NAME' => '',
											'AJAX_MODE' => 'Y',
											"AJAX_OPTION_JUMP" => "N",
											"AJAX_OPTION_STYLE" => "N",
											"AJAX_OPTION_HISTORY" => "N",

											"ALLOW_COLUMNS_SORT" => false,
											"ALLOW_ROWS_SORT" => array(	),
											"ALLOW_COLUMNS_RESIZE" => true,
											"ALLOW_HORIZONTAL_SCROLL" => true,
											"ALLOW_SORT" => false,
											"ALLOW_PIN_HEADER" => true,
											"ACTION_PANEL" => array(),

											"SHOW_CHECK_ALL_CHECKBOXES" => false,
											"SHOW_ROW_CHECKBOXES" => false,
											"SHOW_ROW_ACTIONS_MENU" => true,
											"SHOW_GRID_SETTINGS_MENU" => true,
											"SHOW_NAVIGATION_PANEL" => true,
											"SHOW_PAGINATION" => true,
											"SHOW_SELECTED_COUNTER" => false,
											"SHOW_TOTAL_COUNTER" => true,
											"SHOW_PAGESIZE" => true,
											"SHOW_ACTION_PANEL" => true,

											"ENABLE_COLLAPSIBLE_ROWS" => true,
											'ALLOW_SAVE_ROWS_STATE' => true,

											"SHOW_MORE_BUTTON" => false,
											'~NAV_PARAMS' => $arResult['GET_LIST_PARAMS']['NAV_PARAMS'],
											'NAV_OBJECT' => $arResult['NAV_OBJECT'],
											'NAV_STRING' => $arResult['NAV_STRING'],
											"TOTAL_ROWS_COUNT" => count($arResult['PAYMENT_ROWS']),
											"CURRENT_PAGE" => $arResult['CURRENT_PAGE'],
											"PAGE_SIZES" => 20,
											"DEFAULT_PAGE_SIZE" => 50
										),
										$component,
										array('HIDE_ICONS' => 'Y')
									);
									?>
								</div>
								<div role="tabpanel" class="tab-pane b2b_detail_order__tab-pane"
									 id="b2b_detail_order__tab_block_6">6
								</div>
								<div role="tabpanel" class="tab-pane b2b_detail_order__tab-pane"
									 id="b2b_detail_order__tab_block_7">
									<?
									$APPLICATION->IncludeComponent(
										"bitrix:support.ticket.edit",
										"",
										Array(
											"ID" => $arResult['TICKET']['ID'],
											"MESSAGES_PER_PAGE" => "20",
											"MESSAGE_MAX_LENGTH" => "70",
											"MESSAGE_SORT_ORDER" => "asc",
											"SET_PAGE_TITLE" => "N",
											"SHOW_COUPON_FIELD" => "N",
											'TICKET_EDIT_TEMPLATE' => '#',
											"TICKET_LIST_URL" => "ticket_list.php",
											'ORDER_ID' => $arResult['ID']
										)
									);
									?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function ()
	{
		var msOrder = new msOrderDetail({
			"ExcelButtonId": "#excel-button",
			'ajaxUrl': '<?php echo CUtil::JSEscape($this->__component->GetPath() . '/ajax.php');?>',
			'changePayment': '.sale-order-detail-payment-options-methods-info-change-link',
			'changePaymentWrapper': '.payment-wrapper',
			"paymentList": <?php echo CUtil::PhpToJSObject($paymentData);?>,
			"arParams":<?=Json::encode($arResult['PARAMS']); ?>,
			'filter':<?=Json::encode($arResult['FILTER_EXCEL']);?>,
			'qnts':<?=Json::encode($arResult['QNTS']);?>,
			"arResult":<?=CUtil::PhpToJSObject($arResult['BASKET'], false, true); ?>,
			"TemplateFolder": '<?=$templateFolder?>',
			"OrderId": "<?=$arResult["ID"] ?>",
			"Headers":<?=CUtil::PhpToJSObject($Headers, false, true); ?>,
			"HeadersSum":<?=CUtil::PhpToJSObject($HeadersSum, false, true); ?>,
		});
	})
	$('.b2b_detail_order__second__tab__btn').on('click', function ()
	{
		$('.b2b_detail_order__second__tab__btn__block').toggle();
	});

	$('.b2b_detail_order__nav_ul__block a').click(function (e)
	{
		e.preventDefault();
		$(this).tab('show');
	})
</script>