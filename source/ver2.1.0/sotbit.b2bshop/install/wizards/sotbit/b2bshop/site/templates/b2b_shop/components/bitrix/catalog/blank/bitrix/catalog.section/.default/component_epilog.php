<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadLanguageFile(__FILE__);
$this->setFrameMode(true);
Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("blank");
$availableDelete = ($arParams["AVAILABLE_DELETE"] == "Y") ? true : false;
?>
	<div class="row">
		<?
		$APPLICATION->IncludeFile(SITE_DIR . "include/miss_page_sort_catalog_blank.php",
			[
				$arResult,
				$arParams,
				"top"
			],
			["MODE" => "php"]
		);
		$sum = 0;
		$colorCode = ($arParams["COLOR_IN_PRODUCT"] == 'Y' && isset($arParams['COLOR_IN_PRODUCT_CODE']) && !empty($arParams['COLOR_IN_PRODUCT_CODE'])) ? $arParams['COLOR_IN_PRODUCT_CODE'] : $arParams["OFFER_COLOR_PROP"];
		$ResizeMode = (!empty ($arParams["IMAGE_RESIZE_MODE"]) ? $arParams["IMAGE_RESIZE_MODE"] : BX_RESIZE_IMAGE_PROPORTIONAL);
		?>
	</div>
	<div class="row">
		<div class="col-sm-24">
			<div id="section_list">
				<?
				$rand = $arResult["RAND"];
				?>
				<script type="text/javascript">
					$(function ()
					{
						var msBlank = new msBlankList({
							"ModificationPlus": ".blank-modification .sizes-block-cnt-plus",
							"ModificationMinus": ".blank-modification .sizes-block-cnt-minus",
							"ModificationAddBasket": ".blank-modification .btn_add",
							'btn_basket': '.blank-modification .btn_add',
							'basketPath': '<?=SITE_DIR?>personal/b2b/order/make/',
							'btn_class': 'btn_add',
							'btn_change_class': 'btn-changed',
						});
					})
				</script>
				<div class="row">
					<div class="col-sm-24">
						<div class="blank-modification">
							<div class="blank-modification-in">
								<?
								if(!empty($arResult['BLOCK_ITEMS']))
								{
									?>
									<div class="blank-modification-side blank-modification-left-side">
										<div class="blank-modification-row blank-modification-header">
											<div class="blank-modification-column-name blank-modification-header-cell blank-modification-header-name">
												<?php echo GetMessage('BLANK_MODIFICATION_HEADER_NAME'); ?>
											</div>
											<div class="blank-modification-column-av blank-modification-header-cell blank-modification-header-av">
												<?php echo GetMessage('BLANK_MODIFICATION_HEADER_AVAILABLE'); ?>
											</div>
											<div class="blank-modification-column-articul blank-modification-header-cell blank-modification-header-articul">
												<?php echo GetMessage('BLANK_MODIFICATION_HEADER_ARTICUL'); ?>
											</div>
										</div>
										<?php
										foreach ($arResult["BLOCK_ITEMS"] as $arBlockItem)
										{
											foreach ($arBlockItem as $arItem)
											{
												?>
												<div class="product-wrapper">
													<?php
													$i = 0;
													if($arItem['OFFERS'])
													{
														foreach ($arItem['OFFERS'] as $offer)
														{
															if((($_SESSION["MS_ONLY_AVAILABLE"] == 'Y' && $offer['CAN_BUY']) || ($_SESSION["MS_ONLY_AVAILABLE"] != 'Y' && (!$availableDelete || ($availableDelete && $offer['CAN_BUY'])))) && (!$_SESSION["MS_ONLY_CHECKED"] || ($_SESSION["MS_ONLY_CHECKED"] == 'Y' && in_array($offer['ID'], array_keys($_SESSION["BLANK_IDS"])))))
															{
																?>
																<div class="blank-modification-row blank-modification-row-<?php echo $offer['ID']; ?>">
																	<div class="blank-modification-column-name blank-modification-cell blank-modification-cell-name">
																		<?php if($i == 0): ?>
																			<div class="blank-lupa quick_view<?= $arResult['RAND'] ?>"
																			     data-index="<?= $arItem['COUNTER'] ?>"></div>
																			<div class="text-in-cell">
																				<a href="<?php echo $arItem['DETAIL_PAGE_URL']; ?>"><?php echo $arItem['NAME']; ?></a>
																			</div>
																		<?php endif; ?>
																	</div>
																	<div class="blank-modification-column-av blank-modification-cell blank-modification-cell-av">
																		<?php if($offer['CAN_BUY'])
																		{
																			?>
																			<p class="b2b__header__available">
																				<?=Loc::getMessage('B2B_AVAILABLE');?>
																			</p>
																			<?
																		}
																		else
																		{
																			?>
																			<p class="b2b__header__no_available">
																				<?=Loc::getMessage('B2B_NO_AVAILABLE');?>
																			</p>
																			<?
																		} ?>
																	</div>
																	<div class="blank-modification-column-articul blank-modification-cell blank-modification-cell-articul">
																		<div class="text-in-cell">
																			<?php
																			if($arResult['ARTICLES'][$offer['ID']])
																			{
																				echo $arResult['ARTICLES'][$offer['ID']];
																			}
																			?>
																		</div>
																	</div>
																</div>
																<?php
																++$i;
															}

														}
													}
													else
													{
														if((($_SESSION["MS_ONLY_AVAILABLE"] == 'Y' && $arItem['CAN_BUY']) || ($_SESSION["MS_ONLY_AVAILABLE"] != 'Y')) && (!$_SESSION["MS_ONLY_CHECKED"] || ($_SESSION["MS_ONLY_CHECKED"] == 'Y' && $_SESSION["BLANK_IDS"] && in_array($arItem['ID'], array_keys($_SESSION["BLANK_IDS"])))))
														{
															?>
															<div class="blank-modification-row blank-modification-row-<?php echo $arItem['ID']; ?>">
																<div class="blank-modification-column-name blank-modification-cell blank-modification-cell-name">
																	<?php if($i == 0): ?>
																		<div class="blank-lupa quick_view<?= $arResult['RAND'] ?>"
																		     data-index="<?= $arItem['COUNTER'] ?>"></div>
																		<div class="text-in-cell">
																			<a href="<?php echo $arItem['DETAIL_PAGE_URL']; ?>"><?php echo $arItem['NAME']; ?></a>
																		</div>
																	<?php endif; ?>
																</div>
																<div class="blank-modification-column-av blank-modification-cell blank-modification-cell-av">
																	<?php if($arItem['CAN_BUY'])
																	{
																		?>
																		<p class="b2b__header__available">
																			<?=Loc::getMessage('B2B_AVAILABLE');?>
																		</p>
																		<?
																	}
																	else
																	{
																		?>
																		<p class="b2b__header__availableb2b__header__no_available">
																			<?=Loc::getMessage
																			('B2B_NO_AVAILABLE');?>
																		</p>
																		<?
																	} ?>
																</div>
																<div class="blank-modification-column-articul blank-modification-cell blank-modification-cell-articul">
																	<div class="text-in-cell">
																		<?php
																		if($arResult['ARTICLES'][$arItem['ID']])
																		{
																			echo $arResult['ARTICLES'][$arItem['ID']];
																		} ?>
																	</div>
																</div>
															</div>
															<?php
														}
													}
													?>
												</div>
												<?php

											}
										}
										?>
									</div>
									<div class="blank-modification-side blank-modification-center-side">
										<div class="blank-modification-center-side_in">
											<div class="blank-modification-header blank-modification-row">
												<?php
												if($arResult['MODIFICATION_PROPS'])
												{
													foreach ($arResult['MODIFICATION_PROPS'] as $id => $name)
													{
														?>
														<div class="blank-modification-column-prop blank-modification-header-cell blank-modification-header-prop"><?php echo $name; ?></div>
														<?php
													}
												}
												else
												{
													?>
													<div class="blank-modification-column-prop blank-modification-header-cell blank-modification-header-prop"></div>
													<?php
												}
												?>
											</div>
											<?php
											foreach ($arResult["BLOCK_ITEMS"] as $arBlockItem)
											{
												foreach ($arBlockItem as $arItem)
												{
													?>
													<div class="product-wrapper">
														<?php
														$i = 0;
														if($arItem['OFFERS'])
														{
															foreach ($arItem['OFFERS'] as $offer)
															{
																if((($_SESSION["MS_ONLY_AVAILABLE"] == 'Y' && $offer['CAN_BUY']) || ($_SESSION["MS_ONLY_AVAILABLE"] != 'Y' && (!$availableDelete || ($availableDelete && $offer['CAN_BUY'])))) && (!$_SESSION["MS_ONLY_CHECKED"] || ($_SESSION["MS_ONLY_CHECKED"] == 'Y' && $_SESSION["BLANK_IDS"] && in_array($offer['ID'], array_keys($_SESSION["BLANK_IDS"])))))
																{
																	?>
																	<div class="blank-modification-row blank-modification-row-<?php echo $offer['ID']; ?>">
																		<?php
																		if($arResult['MODIFICATION_PROPS'])
																		{
																			foreach ($arResult['MODIFICATION_PROPS'] as $id => $prop)
																			{
																				?>
																				<div class="blank-modification-column-prop blank-modification-cell blank-modification-cell-prop">
																					<div class="text-in-cell">
																						<?php
																						if($i == 0)
																						{
																							foreach ($arItem['PROPERTIES'] as $itemProp)
																							{
																								if($itemProp['ID'] == $id)
																								{
																									if($arItem['OFFER_TREE_PROPS'][$id][$itemProp['VALUE']]['UF_NAME'])
																									{
																										echo $arItem['OFFER_TREE_PROPS'][$id][$itemProp['VALUE']]['UF_NAME'];
																									}
																									elseif(is_array($itemProp['VALUE']))
																									{
																										echo implode(', ', $itemProp['VALUE']);
																									}
																									else
																									{
																										echo $itemProp['VALUE'];
																									}
																									break;
																								}
																							}
																						}
																						foreach ($offer['PROPERTIES'] as $codeProp => $prop)
																						{
																							if($prop['ID'] == $id)
																							{
																								if($arItem['OFFER_TREE_PROPS'][$id][$offer['PROPERTIES'][$codeProp]['VALUE']]['UF_NAME'])
																								{
																									echo $arItem['OFFER_TREE_PROPS'][$id][$offer['PROPERTIES'][$codeProp]['VALUE']]['UF_NAME'];
																								}
																								elseif(is_array($prop['VALUE']))
																								{
																									echo implode(', ', $prop['VALUE']);
																								}
																								else
																								{
																									echo $prop['VALUE'];
																								}
																								break;
																							}
																						}
																						?>
																					</div>
																				</div>
																				<?php
																			}
																		}
																		else
																		{
																			?>
																			<div class="blank-modification-column-prop blank-modification-cell blank-modification-cell-prop"></div>
																			<?php
																		}
																		?>
																	</div>
																	<?php
																}
																++$i;
															}
														}
														else
														{
															if((($_SESSION["MS_ONLY_AVAILABLE"] == 'Y' && $arItem['CAN_BUY']) || ($_SESSION["MS_ONLY_AVAILABLE"] != 'Y')) && (!$_SESSION["MS_ONLY_CHECKED"] || ($_SESSION["MS_ONLY_CHECKED"] == 'Y' && $_SESSION["BLANK_IDS"] && in_array($arItem['ID'], array_keys($_SESSION["BLANK_IDS"])))))
															{
																?>
																<div class="blank-modification-row blank-modification-row-<?php echo $arItem['ID']; ?>">
																	<?php
																	if($arResult['MODIFICATION_PROPS'])
																	{
																		foreach ($arResult['MODIFICATION_PROPS'] as $id => $prop)
																		{
																			?>
																			<div class="blank-modification-column-prop blank-modification-cell blank-modification-cell-prop">
																				<div class="text-in-cell">
																					<?php
																					foreach ($arItem['PROPERTIES'] as $codeProp => $prop)
																					{
																						if($prop['ID'] == $id)
																						{
																							if($arItem['OFFER_TREE_PROPS'][$id][$prop['VALUE']]['UF_NAME'])
																							{
																								echo $arItem['OFFER_TREE_PROPS'][$id][$prop['VALUE']]['UF_NAME'];
																							}
																							elseif(is_array($prop['VALUE']))
																							{
																								echo implode(', ', $prop['VALUE']);
																							}
																							else
																							{
																								echo $prop['VALUE'];
																							}
																						}
																					}
																					?>
																				</div>
																			</div>
																			<?php
																		}
																	}
																	else
																	{
																		?>
																		<div class="blank-modification-column-prop blank-modification-cell blank-modification-cell-prop">
																		</div>
																		<?php
																	}
																	?>
																</div>
																<?php
															}
														}
														?>
													</div>
													<?php
												}
											}
											?>
										</div>
									</div>
									<div class="blank-modification-side blank-modification-right-side">
										<div class="blank-modification-row blank-modification-header">
											<div class="blank-modification-column-qnt blank-modification-header-cell blank-modification-header-qnt"><?php echo GetMessage('BLANK_MODIFICATION_HEADER_QNT'); ?></div>
											<div class="blank-modification-column-price blank-modification-header-cell blank-modification-header-price"><?php echo GetMessage('BLANK_MODIFICATION_HEADER_PRICE'); ?></div>
										</div>
										<?php
										foreach ($arResult["BLOCK_ITEMS"] as $arBlockItem)
										{
											foreach ($arBlockItem as $arItem)
											{
												?>
												<div class="product-wrapper">
													<?php
													$i = 0;
													if($arItem['OFFERS'])
													{
														foreach ($arItem['OFFERS'] as $offer)
														{
															if((($_SESSION["MS_ONLY_AVAILABLE"] == 'Y' && $offer['CAN_BUY']) || ($_SESSION["MS_ONLY_AVAILABLE"] != 'Y' && (!$availableDelete || ($availableDelete && $offer['CAN_BUY'])))) && (!$_SESSION["MS_ONLY_CHECKED"] || ($_SESSION["MS_ONLY_CHECKED"] == 'Y' && in_array($offer['ID'], array_keys($_SESSION["BLANK_IDS"])))))
															{
																?>
																<div class="blank-modification-row blank-modification-row-<?php echo $offer['ID']; ?>">
																	<div class="blank-modification-column-qnt blank-modification-cell blank-modification-cell-qnt">
																		<?php
																		if($offer['CAN_BUY'])
																		{
																			?>
																			<div class="sizes-block-cnt"
																			     data-price="<?php echo $offer['MIN_PRICE']['DISCOUNT_VALUE']; ?>"
																			     data-id="<?php echo $offer['ID']; ?>"
																			     data-iblock="<?php echo $offer['IBLOCK_ID']; ?>"
																			>
																				<div class="sizes-block-cnt-minus">
																					&ndash;
																				</div>
																				<input
																						type="text"
																						maxlength="4 "
																						class="sizes-block-cnt-value"
																						value="<?= ($_SESSION['BLANK_IDS'][$offer['ID']]['QNT'] > 0) ? $_SESSION['BLANK_IDS'][$offer['ID']]['QNT'] : '0' ?>">
																				<div class="sizes-block-cnt-plus">+
																				</div>
																			</div>
																			<?php
																		} ?>
																	</div>
																	<div class="blank-modification-column-price blank-modification-cell blank-modification-cell-price">
																		<div class="text-in-cell text-in-cell-price">
																			<?php echo $offer['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?>
																		</div>
																	</div>
																</div>
																<?php
															}
														}
													}
													else
													{
														if((($_SESSION["MS_ONLY_AVAILABLE"] == 'Y' && $arItem['CAN_BUY']) || ($_SESSION["MS_ONLY_AVAILABLE"] != 'Y')) && (!$_SESSION["MS_ONLY_CHECKED"] || ($_SESSION["MS_ONLY_CHECKED"] == 'Y' && in_array($arItem['ID'], array_keys($_SESSION["BLANK_IDS"])))))
														{
															?>
															<div class="blank-modification-row blank-modification-row-<?php echo $arItem['ID']; ?>">
																<div class="blank-modification-column-qnt blank-modification-cell blank-modification-cell-qnt">
																	<?php
																	if($arItem['CAN_BUY'])
																	{
																		?>
																		<div class="sizes-block-cnt"
																		     data-price="<?php echo $arItem['MIN_PRICE']['DISCOUNT_VALUE']; ?>"
																		     data-id="<?php echo $arItem['ID']; ?>"
																		     data-iblock="<?php echo $arItem['IBLOCK_ID']; ?>">
																			<div class="sizes-block-cnt-minus">&ndash;
																			</div>
																			<input
																					type="text"
																					maxlength="4 "
																					class="sizes-block-cnt-value"
																					value="<?= ($_SESSION['BLANK_IDS'][$arItem['ID']]['QNT'] > 0) ? $_SESSION['BLANK_IDS'][$arItem['ID']]['QNT'] : '0' ?>">
																			<div class="sizes-block-cnt-plus">+</div>
																		</div>
																	<?php } ?>
																</div>
																<div class="blank-modification-column-price blank-modification-cell blank-modification-cell-price">
																	<div class="text-in-cell text-in-cell-price">
																		<?php echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?>
																	</div>
																</div>
															</div>
															<?php
														}
													}
													?>
												</div>
												<?php

											}
										}
										?>
									</div>
									<?php
								}
								else
								{
									echo GetMessage("B2BS_CATALOG_NOTFOUND");
								}
								?>
							</div>
							<div class="jacor"></div>
							<div class="row row-under-modifications">
								<div class="col-sm-24">
									<div class="row-under-modifications-inner">
										<div class="row">
											<div class="col-sm-12">
												<div class="basket-qnt">
												<span>
													<?= GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_BASKET_QNT") ?>
												</span>
													<span id="modification-basket-qnt">
													<?php
													$qnt = 0;

													if($_SESSION['BLANK_IDS'])
													{
														foreach ($_SESSION['BLANK_IDS'] as $pr)
														{
															$qnt += $pr['QNT'];
														}
													}
													if($qnt < 0)
													{
														$qnt = 0;
													}
													echo $qnt;
													?>
												</span>
												</div>
												<div class="basket-price">
												<span>
													<?= GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_BASKET_SUM") ?>
												</span>
													<span id="modification-basket-price">
													<?php
													$sum = 0;
													if($_SESSION['BLANK_IDS'])
													{
														foreach ($_SESSION['BLANK_IDS'] as $pr)
														{
															$sum += $pr['PRICE'] * $pr['QNT'];
														}
													}
													if($sum < 0 || $qnt == 0)
													{
														$sum = 0;
													}
													echo $sum;
													?>
												</span>
													<?= $arResult['MODIFICATION_CURRENCY'] ?>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="basket-block-wrapper">
													<div class="basket-block">
														<div class="btn_add basket-botton"><?= GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_BASKET_BOTTON") ?></div>
													</div>
													<div class="clearfix"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?

$mess = [
	'MS_JS_CATALOG_SELECT_MODIFICATION' => GetMessage("MS_JS_CATALOG_SELECT_MODIFICATION"),
	'MS_JS_CATALOG_ADD_BASKET' => GetMessage("MS_JS_CATALOG_ADD_BASKET"),
	'MS_JS_CATALOG_ADDED_BASKET' => GetMessage("MS_JS_CATALOG_ADDED_BASKET"),
	'MS_JS_CATALOG_FILTER_HIDE' => GetMessage("MS_JS_CATALOG_FILTER_HIDE"),
	'MS_JS_CATALOG_FILTER_SHOW' => GetMessage("MS_JS_CATALOG_FILTER_SHOW"),
];

$APPLICATION->IncludeFile(SITE_DIR . "include/miss_page_sort_catalog_blank_bottom.php",
	[
		$arResult,
		$arParams,
		"bottom"
	],
	["MODE" => "php"]
);
?>
	<script>

		BX.message(<?=\Bitrix\Main\Web\Json::encode($mess)?>);

		oneColumnWidth();
		oneRowHeight();
		basketWidth();

		var isMobile = navigator.userAgent.match(/iPhone|iPad|iPod|Android|IEMobile/i);

		if ($('.row-under-modifications').length)
		{
			var topPos = $('.row-under-modifications').offset().top;

			var pip = $('.jacor').offset().top;
			var height = $('.row-under-modifications').outerHeight();

			if (pip < height + topPos)
			{
				$('.row-under-modifications').addClass('row-under-modifications-fixed');
			}
		}


		if (!isMobile)
		{
			if ($('.blank-modification-center-side_in').length)
			{
				$('.blank-modification-center-side_in').niceScroll({
					emulatetouch: true,
					bouncescroll: false,
					cursoropacitymin: 1,
					enabletranslate3d: true,
					cursorfixedheight: '16',
					scrollspeed: 25,
					mousescrollstep: 5,
					cursorwidth: '5px',
					horizrailenabled: true,
					cursordragontouch: true
				});
			}
		}


		if (localStorage.getItem('needBlankOut') == 'Y')
		{
			excelOut();
			localStorage.removeItem('needBlankOut');
		}

	</script>
<?

if(isset($arResult["FANCY"]) && !empty($arResult["FANCY"]))
{
	foreach ($arResult["FANCY"] as $arItem)
	{
		$quick_view_id[] = $arItem['ID'];
		$detail_page[] = $arItem["DETAIL_PAGE_URL"];
	}

	$APPLICATION->IncludeComponent(
		"sotbit:sotbit.quick.view_new",
		"",
		[
			"ELEMENT_ID" => $quick_view_id,
			"PARAB2BS_CATALOG" => $arParams,
			"ELEMENT_TEMPLATE" => 'preview',
			"DETAIL_PAGE_URL" => $detail_page,
			"RAND" => $arResult["RAND"]
		],
		false
	);
}

?>