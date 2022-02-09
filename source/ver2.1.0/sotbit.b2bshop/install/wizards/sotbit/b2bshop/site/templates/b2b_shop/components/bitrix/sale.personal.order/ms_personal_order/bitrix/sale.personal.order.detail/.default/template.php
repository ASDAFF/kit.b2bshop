<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);
Bitrix\Main\Loader::includeModule("catalog");
Bitrix\Main\Loader::includeModule("sale");

$order = \Bitrix\Sale\Order::load($arResult["ID"]);
$paymentCollection = $order->getPaymentCollection();

if($arParams['GUEST_MODE'] !== 'Y')
{
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/components/bitrix/sale.order.payment.change/.default/script.js");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/components/bitrix/sale.order.payment.change/.default/style.css");
}
CJSCore::Init([
	'clipboard',
	'fx'
]);


if(!Loader::includeModule('sotbit.b2bshop'))
{
	return false;
}
$menu = new \Sotbit\B2BShop\Client\Personal\Menu();
?>
<div class="col-sm-19 sm-padding-right-no blank_right-side <?= (!$menu->isOpen()) ? 'blank_right-side_full' : '' ?>"
     id="blank_right_side">
	<div id="wrapper_blank_resizer" class="wrapper_blank_resizer">
		<div class="blank_resizer">
			<div class="blank_resizer_tool <?= (!$menu->isOpen()) ? 'blank_resizer_tool_open' : '' ?>"></div>
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
						<div class="table_header">
							<div class="row">
								<div class="col-sm-24">
									<h3 class="prop_order_number">
										<?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_ORDER') ?> <?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_NUM_SIGN') ?><?= $arResult["ACCOUNT_NUMBER"] ?>
										<? if(strlen($arResult["DATE_INSERT_FORMATED"])):?>
											<?= \Bitrix\Main\Localization\Loc::getMessage("SPOD_FROM") ?> <?= $arResult["DATE_INSERT_FORMATED"] ?>
										<? endif ?>
									</h3>
								</div>
							</div>
						</div>
						<div class="table_body">
							<div class="wrap_block_text">
								<div class="row">
									<div class="col-sm-17 xs-padding-left-no">
										<div class="wrap_prop">
											<div class="col-sm-9">
												<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_ORDER_STATUS') ?>
													:</p>
											</div>
											<div class="col-sm-15 sm-padding-left-no">
												<p class="prop_text">
													<?= $arResult["STATUS"]["NAME"] ?>
													<? if(strlen($arResult["DATE_STATUS_FORMATED"])):?>
														(<?= \Bitrix\Main\Localization\Loc::getMessage("SPOD_FROM") ?> <?= $arResult["DATE_STATUS_FORMATED"] ?>)
													<? endif ?>
												</p>
											</div>
										</div>
										<div class="wrap_prop">
											<div class="col-sm-9">
												<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_ORDER_PRICE') ?>
													:</p>
											</div>
											<div class="col-sm-15 sm-padding-left-no">
												<p class="prop_text">
													<?= $arResult["PRICE_FORMATED"] ?>
													<? if(floatval($arResult["SUM_PAID"])):?>
														(<?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_ALREADY_PAID') ?>:&nbsp;<?= $arResult["SUM_PAID_FORMATED"] ?>)
													<? endif ?>
												</p>
											</div>
										</div>
										<? if($arResult["CANCELED"] == "Y" || $arResult["CAN_CANCEL"] == "Y"):?>
											<div class="wrap_prop">
												<div class="col-sm-9">
													<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_ORDER_CANCELED') ?>
														:</p>
												</div>
												<div class="col-sm-15 sm-padding-left-no">
													<p class="prop_text">
														<? if($arResult["CANCELED"] == "Y"):?>
															<?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_YES') ?>
															<? if(strlen($arResult["DATE_CANCELED_FORMATED"])):?>
																(<?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_FROM') ?> <?= $arResult["DATE_CANCELED_FORMATED"] ?>)
															<? endif ?>
														<? elseif($arResult["CAN_CANCEL"] == "Y"):?>
															<?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_NO') ?>
														<? endif ?>
													</p>
												</div>
											</div>
										<? endif ?>
									</div>
									<div class="col-sm-7">
										<? if($arResult["CAN_CANCEL"] == "Y"):?>
											<a class="order_cancel"
											   href="<?= $arResult["URL_TO_CANCEL"] ?>"><?= \Bitrix\Main\Localization\Loc::getMessage("SPOD_ORDER_CANCEL") ?></a>
										<? endif ?>
										<a class="order_cancel"
										   href="<?php echo $arResult['URL_TO_COPY'] ?>"><?php echo \Bitrix\Main\Localization\Loc::getMessage("SPOD_ORDER_REPEAT") ?></a>
									</div>
								</div>
							</div>

							<? if(intval($arResult["USER_ID"]))
							{
								?>
								<div class="row">
									<div class="col-sm-24">
										<div class="wrap_block_title">
											<h3 class="block_title"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_ACCOUNT_DATA') ?></h3>
										</div>
									</div>
								</div>
								<div class="wrap_block_text">
									<? if(strlen($arResult["USER_NAME"])):?>
										<div class="row">
											<div class="col-sm-6">
												<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_ACCOUNT') ?>
													:</p>
											</div>
											<div class="col-sm-11 sm-padding-left-no">
												<p class="prop_text"><?= $arResult["USER_NAME"] ?></p>
											</div>
										</div>
									<? endif ?>

									<div class="row">
										<div class="col-sm-6">
											<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_LOGIN') ?>
												:</p>
										</div>
										<div class="col-sm-11 sm-padding-left-no">
											<p class="prop_text"><?= $arResult["USER"]["LOGIN"] ?></p>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_EMAIL') ?>
												:</p>
										</div>
										<div class="col-sm-11 sm-padding-left-no">
											<p class="prop_text"><?= $arResult["USER"]["EMAIL"] ?></p>
										</div>
									</div>
								</div>
							<? } ?>
							<div class="row">
								<div class="col-sm-24">
									<div class="wrap_block_title">
										<h3 class="block_title"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_ORDER_PROPERTIES') ?></h3>
									</div>
								</div>
							</div>
							<div class="wrap_block_text">
								<div class="row">
									<div class="col-sm-6">
										<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_ORDER_PERS_TYPE') ?>
											:</p>
									</div>
									<div class="col-sm-11 sm-padding-left-no">
										<p class="prop_text"><?= $arResult["PERSON_TYPE"]["NAME"] ?></p>
									</div>
								</div>
								<?
								$group = '';
								foreach ($arResult["ORDER_PROPS"] as $prop)
								{
									if($prop['CODE'] == 'CONFIDENTIAL')
									{
										continue;
									}
									if($group != $prop['GROUP_NAME'])
									{
										?>
										<div class="row">
											<div class="col-sm-24">
												<h4 class="block_title_group sm-padding-no"><?= $prop["GROUP_NAME"] ?></h4>
											</div>
										</div>
										<?php
										$group = $prop['GROUP_NAME'];
									}
									?>
									<div class="row">
										<div class="col-sm-6">
											<p class="prop_name"><?= $prop['NAME'] ?>:</p>
										</div>
										<div class="col-sm-11 sm-padding-left-no">
											<p class="prop_text">
												<? if($prop["TYPE"] == "CHECKBOX"):?>
													<?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_' . ($prop["VALUE"] == "Y" ? 'YES' : 'NO')) ?>
												<? else:?>
													<?= $prop["VALUE"] ?>
												<? endif ?>
											</p>
										</div>
									</div>
									<?php
								} ?>
								<? if(!empty($arResult["USER_DESCRIPTION"]))
								{
									?>
									<div class="row">
										<div class="col-sm-24">
											<h4 class="block_title_group sm-padding-no"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_ORDER_USER_COMMENT_GROUP') ?></h4>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_ORDER_USER_COMMENT') ?>
												:</p>
										</div>
										<div class="col-sm-11 sm-padding-left-no">
											<p class="prop_text"><?= $arResult["USER_DESCRIPTION"] ?></p>
										</div>
									</div>
								<? } ?>
							</div>
							<div class="row">
								<div class="col-sm-24">
									<div class="wrap_block_title">
										<h3 class="block_title"><?= \Bitrix\Main\Localization\Loc::getMessage("SPOD_ORDER_PAYMENT") ?></h3>
									</div>
								</div>
							</div>

							<div class="wrap_block_text">
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

									$paymentData[$arResult['PAYMENT'][$key]['ACCOUNT_NUMBER']] = [
										"payment" => $arResult['PAYMENT'][$key]['ACCOUNT_NUMBER'],
										"order" => $arResult['PAYMENT'][$key]['ORDER_ID'],
										"allow_inner" => $arResult['PAYMENT'][$key]['ALLOW_INNER'],
										"only_inner_full" => $arParams['ONLY_INNER_FULL']
									];
									?>
									<div class="payment-wrapper">
										<div class="row">
											<div class="col-sm-6">
												<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_PAY_SYSTEM') ?>
													:</p>
											</div>
											<div class="col-sm-11 sm-padding-left-no">
												<p class="prop_text">
													<?php echo $arResult['PAYMENT'][$key]['PAY_SYSTEM_NAME'];
													?>
												</p>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_ORDER_PAYED') ?>
													:</p>
											</div>
											<div class="col-sm-18 sm-padding-left-no">
												<p class="prop_text">
													<?
													if($payment->isPaid())
													{
														echo \Bitrix\Main\Localization\Loc::getMessage('SPOD_YES');

														if(strlen($arResult['PAYMENT'][$key]["DATE_PAID"]))
														{
															?>
															(<?php echo \Bitrix\Main\Localization\Loc::getMessage('SPOD_FROM'); ?><?php echo $arResult['PAYMENT'][$key]["DATE_PAID"]->format('d.m.Y') ?>)
															<?
														}
													}
													else
													{
														echo \Bitrix\Main\Localization\Loc::getMessage('SPOD_NO');
													} ?>
												</p>
											</div>
										</div>
										<div class="row">
											<?php
											if(!$payment->isPaid() && $arResult['IS_ALLOW_PAY'] == 'Y')
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
															<span id="<?= $arResult['PAYMENT'][$key]['ACCOUNT_NUMBER'] ?>"
															      class="sale-order-detail-payment-options-methods-info-change-link"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_CHANGE_PAYMENT_TYPE') ?></span>
														</div>
														<?
														if($arResult['PAYMENT'][$key]['PAY_SYSTEM']['ACTION_FILE'] == 'billsotbit')
														{
															$PaymentId = $payment->getId();
															?>
															<div class="data_block">
																<div class="row">
																	<div class="col-sm-24">
																		<div class="fild">
																			<p class="name_fild">
																				<?= Loc::getMessage("SHOW_BILL", [
																					'#ORDER_ID#' => $arResult["ID"],
																					'#PAYMENT_ID#' => $PaymentId
																				]) ?>
																			</p>
																			<p class="name_fild">
																				<?= Loc::getMessage("DOWNLOAD_BILL", [
																					'#ORDER_ID#' => $arResult["ID"],
																					'#PAYMENT_ID#' => $PaymentId
																				]) ?>
																			</p>
																		</div>
																	</div>
																</div>
															</div>
															<?php
														}
														else
														{
															$service = \Bitrix\Sale\PaySystem\Manager::getObjectById($payment->getPaymentSystemId());
															$service->initiatePay($payment);
														}
													}
													?>
												</div>
												<?php
											}
											else
											{
												?>
												<div class="col-sm-24">
													<span><?= Loc::getMessage("CAN_PAY_LATER") ?></span>
												</div>
												<?
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
							<?php
							if($arResult['SHIPMENT'])
							{
								?>
								<div class="row">
									<div class="col-sm-24">
										<div class="wrap_block_title">
											<h3 class="block_title"><?= \Bitrix\Main\Localization\Loc::getMessage("SPOD_ORDER_DELIVERY_BLOCK") ?></h3>
										</div>
									</div>
								</div>
								<div class="wrap_block_text">
									<?php
									foreach ($arResult['SHIPMENT'] as $i => $shipment)
									{
										?>
										<div class="row">
											<div class="col-sm-6">
												<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage("SPOD_ORDER_DELIVERY") ?>
													:</p>
											</div>
											<div class="col-sm-11 sm-padding-left-no">
												<p class="prop_text">
													<?php echo $shipment["DELIVERY_NAME"]; ?>
												</p>
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
															<?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_TAKE_FROM_STORE') ?>
															: <b><?= $store['TITLE'] ?></b>
															<?
															if(!empty($store['DESCRIPTION']))
															{
																?>
																<div class="bx_ild_s_desc">
																	<?= $store['DESCRIPTION'] ?>
																</div>
															<?
															} ?>
														</div>
														<?
														if(!empty($store['ADDRESS']))
														{
															?>
															<div class="bx_old_s_row">
																<b><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_STORE_ADDRESS') ?></b>: <?= $store['ADDRESS'] ?>
															</div>
														<?
														} ?>

														<?
														if(!empty($store['SCHEDULE']))
														{
															?>
															<div class="bx_old_s_row">
																<b><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_STORE_WORKTIME') ?></b>: <?= $store['SCHEDULE'] ?>
															</div>
														<?
														} ?>

														<?
														if(!empty($store['PHONE']))
														{
															?>
															<div class="bx_old_s_row">
																<b><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_STORE_PHONE') ?></b>: <?= $store['PHONE'] ?>
															</div>
														<?
														} ?>

														<?
														if(!empty($store['EMAIL']))
														{
															?>
															<div class="bx_old_s_row">
																<b><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_STORE_EMAIL') ?></b>:
																<a href="mailto:<?= $store['EMAIL'] ?>"><?= $store['EMAIL'] ?></a>
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
															[
																"INIT_MAP_TYPE" => "COORDINATES",
																"MAP_DATA" => serialize(
																	[
																		'yandex_lon' => $store['GPS_S'],
																		'yandex_lat' => $store['GPS_N'],
																		'PLACEMARKS' => [
																			[
																				"LON" => $store['GPS_S'],
																				"LAT" => $store['GPS_N'],
																				"TEXT" => $store['TITLE']
																			]
																		]
																	]
																),
																"MAP_WIDTH" => "100%",
																"MAP_HEIGHT" => "300",
																"CONTROLS" => [
																	"ZOOM",
																	"SMALLZOOM",
																	"SCALELINE"
																],
																"OPTIONS" => [
																	"ENABLE_DRAGGING",
																	"ENABLE_SCROLL_ZOOM",
																	"ENABLE_DBLCLICK_ZOOM"
																],
																"MAP_ID" => ""
															]
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
										<div class="row">
											<div class="col-sm-6">
												<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage("SPOD_ORDER_SHIPMENT_STATUS") ?>
													:</p>
											</div>
											<div class="col-sm-11 sm-padding-left-no">
												<p class="prop_text">
													<?php echo htmlspecialcharsbx($shipment['STATUS_NAME']); ?>
												</p>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage("SPOD_SUB_PRICE_DELIVERY") ?>
													:</p>
											</div>
											<div class="col-sm-11 sm-padding-left-no">
												<p class="prop_text">
													<?php echo $shipment['PRICE_DELIVERY_FORMATED']; ?>
												</p>
											</div>
										</div>
										<?php if($shipment['TRACKING_NUMBER'])
									{
										?>
										<div class="row">
											<div class="col-sm-6">
												<p class="prop_name"><?= \Bitrix\Main\Localization\Loc::getMessage("SPOD_ORDER_TRACKING_NUMBER") ?>
													:</p>
											</div>
											<div class="col-sm-11 sm-padding-left-no">
												<p class="prop_text">
													<?php echo $shipment['TRACKING_NUMBER']; ?>
												</p>
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
								<?php
							} ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-24">
							<div class="excel-button" id="excel-button">
								<?= \Bitrix\Main\Localization\Loc::getMessage('EXCEL_BUTTON') ?>
							</div>
						</div>
					</div>
					<div class="personal_order_item">
						<div class="div_table_header">
							<div class="row">
								<div class='col-sm-10'>
									<h3 class="title title_1"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_NAME') ?></h3>
								</div>
								<div class='col-sm-3 sm-padding-left-no'>
									<h3 class="title title_2"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_QUANTITY') ?></h3>
								</div>
								<div class='col-sm-4 sm-padding-right-no'>
									<h3 class="title title_3"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_PRICE') ?></h3>
								</div>
								<div class='col-sm-3'>
									<h3 class="title title_4"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_DISCOUNT') ?></h3>
								</div>
								<div class='col-sm-4 sm-padding-left-no'>
									<h3 class="title title_5"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_SUMMARY') ?></h3>
								</div>
							</div>
						</div>
						<div class="div_table_body">
							<? foreach ($arResult["BASKET"] as $key => $prod)
							{
								?>
								<div id="item_<? echo($key + 1); ?>" class="basket_item">
									<div class="row">
										<? $hasLink = !empty($prod["DETAIL_PAGE_URL"]); ?>
										<div class='col-sm-2 col-md-5'>
											<? if($hasLink)
											{
											?>
											<a class="basket_item_img" href="<?= $prod["DETAIL_PAGE_URL"] ?>"
											   target="_blank">
												<? } ?>
												<? if($prod['PICTURE']['src'])
												{
													?>
													<span class="basket_item_img">
														<img class="img-responsive" src="<?= $prod['PICTURE']['src'] ?>"
														     width="<?= $prod['PICTURE']['width'] ?>"
														     height="<?= $prod['PICTURE']['height'] ?>"
														     alt="<?= $prod['NAME'] ?>"/>
													</span>
												<?
												}
												else
												{
													?>
													<span class="basket_item_img">
														<img class="img-responsive" src="/upload/no_photo.jpg"
														     width="80" height="120" alt="<?= $prod['NAME'] ?>"/>
													</span>
												<? } ?>
												<? if($hasLink)
												{
												?>
											</a>
										<? } ?>
										</div>
										<div class='col-sm-8 col-md-5 sm-padding-left-no'>
											<div class="wrap_title">
												<p class="item_name">
													<? if($hasLink)
													{
													?>
													<a href="<?= $prod["DETAIL_PAGE_URL"] ?>" target="_blank">
														<? } ?>
														<?= htmlspecialcharsEx($prod["NAME"]) ?>
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
												<div class="item_prop">
													<? if($actuallyHasProps)
													{
														?>
														<? foreach ($prod["PROPS"] as $prop)
													{
														?>
														<p><?= $prop["NAME"] ?>: <span
																	class="black"><?= $prop["VALUE"] ?></span></p>
													<? } ?>
													<? } ?>
												</div>
											<? } ?>
										</div>
										<div class='col-sm-3 sm-padding-left-no'>
											<p class="mobile_title"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_QUANTITY') ?>
												:</p>
											<div class="wrap_quantity">
												<p>
													<? echo $prod["QUANTITY"];
													if(strlen($prod['MEASURE_TEXT']))
													{
														echo $prod['MEASURE_TEXT'] . '.';
													}
													else
													{
														echo \Bitrix\Main\Localization\Loc::getMessage('SPOD_DEFAULT_MEASURE');
													} ?>
												</p>
											</div>
										</div>
										<div class='col-sm-4 sm-padding-right-no'>
											<p class="mobile_title"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_PRICE') ?>
												:</p>
											<div class="wrap_price">
												<p class="item_price"><?= $prod["PRICE_FORMATED"] ?></p>
											</div>
										</div>
										<div class='col-sm-3'>
											<? if($arResult['HAS_DISCOUNT'])
											{
												?>
												<p class="mobile_title"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_DISCOUNT') ?>
													:</p>
												<div class="wrap_discount">
													<p><?= $prod["DISCOUNT_PRICE_PERCENT_FORMATED"] ?></p>
												</div>
											<? } ?>
										</div>
										<div class='col-sm-4 sm-padding-left-no'>
											<p class="mobile_title"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_SUMMARY') ?>
												:</p>
											<p class="count_item"><?= $prod["FULL_PRICE_FORMATED"] ?></p>
										</div>
									</div>
								</div>
								<div class="row divider">
									<div class='col-sm-24'>
										<span></span>
									</div>
								</div>
							<? } ?>
						</div>
						<div class="row">
							<div class="col-sm-24 col-md-6 col-lg-7 hidden-sm hidden-xs sm-padding-right-no">
								<a class="personal_order_back" href="<?= $arResult["URL_TO_LIST"] ?>"
								   rel="nofollow"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_GO_BACK') ?></a>
							</div>
							<div class="col-sm-24 col-md-18 col-lg-17">
								<div class="personal_order_count">
									<div class="row">
										<div class="col-sm-7">
											<div class="order_count_title"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_YOU_ORDER'); ?></div>
										</div>
										<div class="col-sm-17 sm-padding-left-no">
											<div class="personal_order_wrap">
												<div class="row">
													<div class="col-sm-6 sm-padding-right-no">
														<p class="order_prop">
															<span><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_TOTAL_WEIGHT') ?>
																:</span>
															<b><?= $arResult['ORDER_WEIGHT_FORMATED'] ?></b></p>
													</div>
													<div class="col-sm-6 sm-padding-left-no">
														<p class="order_prop">
															<span><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_PRODUCT_SUM') ?>
																:</span>
															<b><?= $arResult['PRODUCT_SUM_FORMATTED'] ?></b></p>
													</div>
													<div class="col-sm-6 sm-padding-left-no">
														<? if(strlen($arResult["PRICE_DELIVERY_FORMATED"]))
														{
															?>
															<p class="order_prop">
																<span><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_DELIVERY') ?>
																	:</span>
																<b><?= $arResult["PRICE_DELIVERY_FORMATED"] ?></b></p>
														<? } ?>
													</div>
													<div class="col-sm-6 sm-padding-no">
														<p class="order_prop order_prop_price">
															<span><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_SUMMARY') ?>
																:</span> <b><?= $arResult["PRICE_FORMATED"] ?></b></p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-24 col-md-6 col-lg-8 hidden-md hidden-lg sm-padding-right-no">
								<a class="personal_order_back" href="<?= $arResult["URL_TO_LIST"] ?>"
								   rel="nofollow"><?= \Bitrix\Main\Localization\Loc::getMessage('SPOD_GO_BACK') ?></a>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?
$Headers = [
	'IMAGE' => \Bitrix\Main\Localization\Loc::getMessage('SPOD_IMAGE'),
	'NAME' => \Bitrix\Main\Localization\Loc::getMessage('SPOD_NAME'),
	'QUANTITY' => \Bitrix\Main\Localization\Loc::getMessage('SPOD_QUANTITY'),
	'PRICE' => \Bitrix\Main\Localization\Loc::getMessage('SPOD_PRICE'),
	'DISCOUNT' => \Bitrix\Main\Localization\Loc::getMessage('SPOD_DISCOUNT'),
	'SUMMARY' => \Bitrix\Main\Localization\Loc::getMessage('SPOD_SUMMARY'),
];
$HeadersSum = [
	'TOTAL_WEIGHT' => [
		'TITLE' => \Bitrix\Main\Localization\Loc::getMessage('SPOD_TOTAL_WEIGHT'),
		'VALUE' => $arResult['ORDER_WEIGHT_FORMATED']
	],
	'PRODUCT_SUM' => [
		'TITLE' => \Bitrix\Main\Localization\Loc::getMessage('SPOD_PRODUCT_SUM'),
		'VALUE' => $arResult['PRODUCT_SUM_FORMATTED']
	],
	'DELIVERY' => [
		'TITLE' => \Bitrix\Main\Localization\Loc::getMessage('SPOD_DELIVERY'),
		'VALUE' => $arResult["PRICE_DELIVERY_FORMATED"]
	],
	'SUMMARY' => [
		'TITLE' => \Bitrix\Main\Localization\Loc::getMessage('SPOD_SUMMARY'),
		'VALUE' => $arResult["PRICE_FORMATED"]
	],
];
?>

<script type="text/javascript">
	$(function ()
	{
		var msOrder = new msOrderDetail({
			"ExcelButtonId": "#excel-button",
			'ajaxUrl': '<?php echo CUtil::JSEscape($this->__component->GetPath() . '/ajax.php');?>',
			'changePayment': '.sale-order-detail-payment-options-methods-info-change-link',
			'changePaymentWrapper': '.payment-wrapper',
			"paymentList": <?php echo CUtil::PhpToJSObject($paymentData);?>,
			"arResult":<?=CUtil::PhpToJSObject($arResult['BASKET'], false, true); ?>,
			"TemplateFolder": '<?=$templateFolder?>',
			"OrderId": "<?=$arResult["ID"] ?>",
			"Headers":<?=CUtil::PhpToJSObject($Headers, false, true); ?>,
			"HeadersSum":<?=CUtil::PhpToJSObject($HeadersSum, false, true); ?>,
		});
	})
</script>