<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
			<?if(!empty($arResult['ERRORS']['FATAL'])):?>

				<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
					<?=ShowError($error)?>
				<?endforeach?>

			<?else:?>

			<?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

				<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
					<?=ShowError($error)?>
				<?endforeach?>

			<?endif?>

			<?if(!empty($arResult['ORDERS'])):?>

				<?foreach($arResult["ORDER_BY_STATUS"] as $key => $group):?>
					<div class="personal_list_order">
					<?foreach($group as $k => $order):?>

						<?if(!$k):?>

								<div class="title"><?=GetMessage("SPOL_STATUS")?> "<?=$arResult["INFO"]["STATUS"][$key]["NAME"] ?>"</div>
								<p class="title_text"><?=$arResult["INFO"]["STATUS"][$key]["DESCRIPTION"] ?></p>

						<?endif?>

						<div class="table_one_order">
							<div class="table_header">
								<div class="row">
									<div class="col-sm-14">
										<h3 class="prop_order_number">
											<?=GetMessage('SPOL_ORDER')?> <?=GetMessage('SPOL_NUM_SIGN')?><?=$order["ORDER"]["ACCOUNT_NUMBER"]?>
											<?if(strlen($order["ORDER"]["DATE_INSERT_FORMATED"])):?>
												<?=GetMessage('SPOL_FROM')?> <?=$order["ORDER"]["DATE_INSERT_FORMATED"];?>
											<?endif?>
										</h3>
									</div>
									<div class="col-sm-10">
										<a class="prop_order_detail" href="<?=$order["ORDER"]["URL_TO_DETAIL"]?>"><?=GetMessage('SPOL_ORDER_DETAIL')?></a>
									</div>
								</div>
							</div>
							<div class="table_body">
								<div class="row">
									<div class="col-sm-14">
										<p class="prop_order"><b><?=GetMessage('SPOL_PAY_SUM')?>:</b> <?=$order["ORDER"]["FORMATED_PRICE"]?></p>
										<p class="prop_order"><b><?=GetMessage('SPOL_PAYED')?>:</b> <?=GetMessage('SPOL_'.($order["ORDER"]["PAYED"] == "Y" ? 'YES' : 'NO'))?></p>
										<?if(intval($order["ORDER"]["PAY_SYSTEM_ID"])):?>
											<p class="prop_order"><b><?=GetMessage('SPOL_PAYSYSTEM')?>:</b> <?=$arResult["INFO"]["PAY_SYSTEM"][$order["ORDER"]["PAY_SYSTEM_ID"]]["NAME"]?></p>
										<?endif?>
										<?if($order['HAS_DELIVERY']):?>
											<p class="prop_order"><b><?=GetMessage('SPOL_DELIVERY')?>:</b>
												<?if(intval($order["ORDER"]["DELIVERY_ID"])):?>

													<?=$arResult["INFO"]["DELIVERY"][$order["ORDER"]["DELIVERY_ID"]]["NAME"]?> <br />

												<?elseif(strpos($order["ORDER"]["DELIVERY_ID"], ":") !== false):?>

													<?$arId = explode(":", $order["ORDER"]["DELIVERY_ID"])?>
													<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["NAME"]?> (<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["PROFILES"][$arId[1]]["TITLE"]?>) <br />

												<?endif?>
											</p>
										<?endif?>
										<p class="prop_order"><b><?=GetMessage('SPOL_BASKET')?>:</b>
											<ol class="prop_item_list">
												<?foreach ($order["BASKET_ITEMS"] as $item):?>

													<li>
														<?if(strlen($item["DETAIL_PAGE_URL"])):?>
															<a href="<?=$item["DETAIL_PAGE_URL"]?>" target="_blank">
														<?endif?>
															<?=$item['NAME']?>
														<?if(strlen($item["DETAIL_PAGE_URL"])):?>
															</a>
														<?endif?>
														<span>&nbsp;&mdash; <?=$item['QUANTITY']?> <?=(isset($item["MEASURE_NAME"]) ? $item["MEASURE_NAME"] : GetMessage('SPOL_SHT'))?></span>
													</li>
												<?endforeach?>
											</ol>
										</p>
									</div>
									<div class="col-sm-10">
										<p class="prop_date"><?=$order["ORDER"]["DATE_STATUS_FORMATED"];?></p>
										<div class="prop_status <?=$arResult["INFO"]["STATUS"][$key]['COLOR']?>"><?=$arResult["INFO"]["STATUS"][$key]["NAME"]?></div>
										<div class="prop_btn">
											<?if($order["ORDER"]["CANCELED"] != "Y"):?>
												<a class="prop_order_cancel" href="<?=$order["ORDER"]["URL_TO_CANCEL"]?>" rel="nofollow"><?=GetMessage('SPOL_CANCEL_ORDER')?></a>
											<?endif?>
											<a class="prop_order_repeat"  href="<?=$order["ORDER"]["URL_TO_COPY"]?>" rel="nofollow"><?=GetMessage('SPOL_REPEAT_ORDER')?></a>
										</div>
									</div>
								</div>
							</div>
						</div>

					<?endforeach?>
					</div>
				<?endforeach?>

				<?if(strlen($arResult['NAV_STRING'])):?>
					<div class="wrap_order_pagination">
						<?=$arResult['NAV_STRING']?>
					</div>
				<?endif?>

			<?else:?>
				<?=GetMessage('SPOL_NO_ORDERS')?>
			<?endif?>

		<?endif?>
		</div>
	</div>
</div>