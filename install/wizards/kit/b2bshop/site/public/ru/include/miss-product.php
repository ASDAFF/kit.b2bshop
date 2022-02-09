<?
$FirstColor = $arParams['ITEM']['FIRST_COLOR'];
$countRow = 4;

?>
<div class="one-item block_img_js"
	data-id="<?=$arParams['ITEM']['ID']?>"
	data-first-color="<?=$FirstColor?>">
	<div class="item-top-part">
		<div class="item-top-part-inner">
			<?
			if ($arParams['PHOTOS'][$FirstColor])
			{
				?>
			<a onclick="" href="<?=$arParams['ITEM']["DETAIL_PAGE_URL"]?>">
				<?

				if ($arParams['PARAMS']['LAZY_LOAD'] == "Y")
				{
					?>
					<span class="b-lazy-wrapper" data-width="<?=reset($arParams['PHOTOS'][$FirstColor]['MEDIUM'])["width"]?>" data-height="<?=reset($arParams['PHOTOS'][$FirstColor]['MEDIUM'])["height"]?>" style="background-image:url(<?=$arParams['PARAMS']['PRELOADER']?>);background-repeat:no-repeat;">
				<?}?>
					<img
					class="img-responsive big_img_js <?=($arParams['PARAMS']['LAZY_LOAD']=="Y")?"b-lazy":""?>"
					<?=($arParams['PARAMS']['LAZY_LOAD']!="Y")?"src=\"".reset($arParams['PHOTOS'][$FirstColor]['MEDIUM'])["src"]."\"":"src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== data-src=\"".reset($arParams['PHOTOS'][$FirstColor]['MEDIUM'])["src"]."\""?>
					title="<?=$arParams['ITEM']["PREVIEW_PICTURE"]["TITLE"]?>"
					alt="<?=$arParams['ITEM']["PREVIEW_PICTURE"]["ALT"]?>"
					height="<?=reset($arParams['PHOTOS'][$FirstColor]['MEDIUM'])["height"]?>"
					width="<?=reset($arParams['PHOTOS'][$FirstColor]['MEDIUM'])["width"]?>">
					<?

				if ($arParams['PARAMS']['LAZY_LOAD'] == "Y")
				{
					?>
					</span>
					<?}?>
			</a>
			<?
			}
			else
			{
				?>
							<a onclick="" href="<?=$arParams['ITEM']["DETAIL_PAGE_URL"]?>">
							<?if($arParams['PARAMS']['LAZY_LOAD']=="Y"):?>
								<span class="b-lazy-wrapper" data-width="<?=$arParams['PARAMS']["LIST_HEIGHT_MEDIUM"]?>" data-height="<?=$arParams['PARAMS']["LIST_WIDTH_MEDIUM"]?>" style="background-image:url(<?=$arParams['PARAMS']['PRELOADER']?>);background-repeat:no-repeat;">
							<?endif;?>
							<img
					class="img-responsive big_img_js <?=($arParams['PARAMS']['LAZY_LOAD']=="Y")?"b-lazy":""?>"
					<?=($arParams['PARAMS']['LAZY_LOAD']!="Y")?"src=\"/upload/no_photo.jpg\"":"src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== data-src=\"/upload/no_photo.jpg\""?>
					title="" alt=""
					height="<?=$arParams['PARAMS']["LIST_HEIGHT_MEDIUM"]?>"
					width="<?=$arParams['PARAMS']["LIST_WIDTH_MEDIUM"]?>">
							<?if($arParams['PARAMS']['LAZY_LOAD']=="Y"):?>
								</span>
							<?endif;?>
							</a>
							<?
			}
			?>
							<?if($arParams['ITEM']['MIN_PRICE']["DISCOUNT_DIFF_PERCENT"]){?>
							<span class="item-discount"> <span class="item-discount-inner">
									-<?=$arParams['ITEM']['MIN_PRICE']["DISCOUNT_DIFF_PERCENT"]?>%
								</span>
			</span>
							<?}?>
						</div>
						<?
						if($arParams['PARAMS']['FLAG_PROPS'])
						{
							$k = 0;
							foreach ( $arParams['PARAMS']['FLAG_PROPS'] as $i => $v )
							{

								if (! isset ( $arParams['ITEM']["PROPERTIES"][$v] ))
									continue;
								$val = $arParams['ITEM']["PROPERTIES"][$v]["VALUE"];
								if (($val == "true" || $val == "Y" || $val == GetMessage ( "B2BS_CATALOG_YES" )))
								{
									?>
								<span class="icon_property_wrap" data-index="<?php echo $k;?>">
									<span class="icon_property">
										<span class="icon_property_name"><?=$arParams['ITEM']["PROPERTIES"][$v]["NAME"]?></span>
									</span>
								</span>
								<?
									++$k;
								}
							}
						}
						?>
					</div>
	<div class="item-bottom-part">
		<div class="buy_now_bottom_inner">
		<div class="wrap_price_name">
		<div class="block_name">
			<p class="item_name">
				<a onclick=""
					href="<?=$arParams['BRANDS'][$arParams['ITEM']["PROPERTIES"][$arParams['PARAMS']["MANUFACTURER_ELEMENT_PROPS"]]["VALUE"]]["DETAIL_PAGE_URL"]?>"
					title="<?=$arParams['ITEM']["PROPERTIES"][$arParams['PARAMS']["MANUFACTURER_LIST_PROPS"]]["VALUE"]?>"><?=$arParams['ITEM']["PROPERTIES"][$arParams['PARAMS']["MANUFACTURER_LIST_PROPS"]]["VALUE"]?></a>
			</p>
			<p class="item_second_name">
				<a onclick="" href="<?=$arParams['ITEM']["DETAIL_PAGE_URL"]?>"
					title="<?=$arParams['ITEM']["NAME"]?>"><i><?=$arParams['ITEM']["NAME"]?></i></a>
			</p>
		</div>
			<div class="block_price">
							<?if($arParams['ITEM']['MIN_PRICE']["VALUE"]==$arParams['ITEM']['MIN_PRICE']["DISCOUNT_VALUE"]){?>
								<p class="item_price"><?=$arParams['ITEM']['MIN_PRICE']["PRINT_VALUE"]?></p>
							<?}else{?>
								<p class="item_price"><?=$arParams['ITEM']['MIN_PRICE']["PRINT_DISCOUNT_VALUE"]?></p>
				<p class="item_price_big"><?=$arParams['ITEM']['MIN_PRICE']["PRINT_VALUE"]?></p>
				<?}?>

			</div>
</div>
		</div>
	</div>
	<div class="item_open">
		<div class="buy_now_top_small_img">
			<div class="wrap">
								<?
								$count = count ( $arParams['PHOTOS'] );
								if ($count > $countRow)
								{
									?>
								<div class="arrow-top"
					id="swiper_<?=$arParams['ITEM']['ID'].$arParams['RAND']?>_top"></div>
				<div class="arrow-bottom"
					id="swiper_<?=$arParams['ITEM']['ID'].$arParams['RAND']?>_bottom"></div>
								<?}?>
								<div class="swiper-container"
					id="swiper_<?=$arParams['ITEM']['ID'].$arParams['RAND']?>">
					<div class="swiper-wrapper">
									<?
									$style = "";
									$OpenTag = false;
									foreach ( $arParams['PHOTOS'] as $color => $arMorePhoto )
									{
										if($arMorePhoto["SMALL"])
										{
											foreach ( $arMorePhoto["SMALL"] as $arImg )
											{
												if ($countItem == 0)
												{
													$countSmall = count ( $arMorePhoto["MEDIUM"] );
													$style = "";
													if ($countSmall <= 1)
														$style = 'style="display:none"';
												}

												if ($countItem == 0 || $countItem % $countRow == 0)
												{
													$OpenTag = true;
													?><div class="swiper-slide"><?
												}
												?>
											<span
									title="<?=isset($arImg["title"])?$arImg["title"]:$arParams['ITEM']["NAME"]?>"
									class="small_img_js" data-color="<?=$color?>">
											<?

												if ($arParams['PARAMS']['AJAX_PRODUCT_LOAD'] != "Y")
												{
													?>
											<?if($arParams['PARAMS']['LAZY_LOAD']=="Y"){?>
												<span class="b-lazy-wrapper" data-width="<?=$arImg["width"]?>" data-height="<?=$arImg["height"]?>" style="background-image:url(<?=$arParams['PARAMS']['PRELOADER']?>);background-repeat:no-repeat;">
											<?}?>
												<img data-color="<?=$color?>"
										class="img-responsive <?=($arParams['PARAMS']['LAZY_LOAD']=="Y")?"b-lazy":""?>"
										<?=($arParams['PARAMS']['LAZY_LOAD']!="Y")?"src=\"".$arImg["src"]."\"":"src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== data-src=\"".$arImg["src"]."\""?>
										width="<?=$arImg["width"]?>" height="<?=$arImg["height"]?>"
										title="<?=isset($arImg["title"])?$arImg["title"]:$arParams['PARAMS']["NAME"]?>"
										alt="" />
											<?if($arParams['PARAMS']['LAZY_LOAD']=="Y"){?>
												</span>
											<?
													}
												}
												else
												{
													?>
												<div class="<?=$color ?>-replace" style="background:url(<?=$arParams['PARAMS']['PRELOADER']?>) center center no-repeat;"></div>
												<?
												}
												?>

											</span>
											<?
												$countItem ++;
												if ($countItem % $countRow == 0 || count ( $arParams['PHOTOS'] ) == $countItem)
												{
													$OpenTag = false;
													?>
												</div>
												<?
												}
												break 1;
											}
										}
									}
									if($OpenTag)
									{
										?>
										</div>
										<?
									}
									?>
									</div>
				</div>
			</div>
		</div>
		<noindex> <a rel="nofollow" style="width: 193px; height: 341px;"
			class="item-top-part" onclick=""
			href="<?=$arParams['ITEM']["DETAIL_PAGE_URL"]?>"></a> </noindex>
		<div class="wrap_item_bnt">
			<span class="bnt_left" <?=$style?>></span> <span class="bnt_right"
				<?=$style?>></span> <span
				class="bnt_center quick_view<?=$arParams['RAND']?>"
				data-index="<?=$arParams['ITEM']['COUNTER']?>"><?=GetMessage("B2BS_CATALOG_QUICK_SHOW")?></span>
		</div>
		<div class="item-bottom-part">
			<div class="buy_now_bottom_inner">
			<div class="wrap_price_name">
				<div class="block_name">
					<p class="item_name">
						<a onclick=""
							href="<?=$arParams['BRANDS'][$arParams['ITEM']["PROPERTIES"][$arParams['PARAMS']["MANUFACTURER_ELEMENT_PROPS"]]["VALUE"]]["DETAIL_PAGE_URL"]?>"><?=$arParams['ITEM']["PROPERTIES"][$arParams['PARAMS']["MANUFACTURER_LIST_PROPS"]]["VALUE"]?></a>
					</p>
					<p class="item_second_name">
						<a onclick="" href="<?=$arParams['ITEM']["DETAIL_PAGE_URL"]?>"><i><?=$arParams['ITEM']["NAME"]?></i></a>
					</p>
				</div>

				<div class="block_price">
							<?if($arParams['ITEM']['MIN_PRICE']["VALUE"]==$arParams['ITEM']['MIN_PRICE']["DISCOUNT_VALUE"]){?>
								<p class="item_price"><?=$arParams['ITEM']['MIN_PRICE']["PRINT_VALUE"]?></p>
							<?}else{?>
								<p class="item_price"><?=$arParams['ITEM']['MIN_PRICE']["PRINT_DISCOUNT_VALUE"]?></p>
					<p class="item_price_big"><?=$arParams['ITEM']['MIN_PRICE']["PRINT_VALUE"]?></p>
							<?}?>
				</div>
			</div>
				<div class="block_size_color">
								<?
if (isset ( $arParams['ITEM']["OFFER_TREE_PROPS_VALUE"] ) && is_array ( $arParams['ITEM']["OFFER_TREE_PROPS_VALUE"] ))
								{
									foreach ( $arParams['ITEM']["OFFER_TREE_PROPS_VALUE"] as $code => $arProp )
									{
										if ($code == $arParams['ITEM']['COLOR_CODE'])
											continue 1;
										?>
									<p class="name_size"><?=$arParams["PROP_NAME"][$code]?><?=GetMessage("B2BS_CATALOG_PROP_AVAILABILITY")?></p>
					<p class="item_size">
										<?

foreach ( $arProp as $v )
										{
											?>
										<span title="<?=$v?>"><?=$v?></span>
										<?}?>
									</p>
<?
}
								}
								if (isset ( $arParams['ITEM']["OFFER_TREE_PROPS"][$arParams['ITEM']['COLOR_CODE']] ))
								{
									?>
									<p class="name_color"><?=GetMessage("B2BS_CATALOG_COLOR_AVAILABILITY")?></p>
					<p class="item_color">

										<?

									foreach ( $arParams['ITEM']["OFFER_TREE_PROPS"][$arParams['ITEM']['COLOR_CODE']] as $xmlID => $arColor )
									{
										?>
										<span title="<?=$arColor["UF_NAME"]?>" style="background: <?if($arColor["PIC"]):?>url(<?=$arColor["PIC"]["SRC"]?>) 50% 50% no-repeat<?else:?><?=$arColor["UF_DESCRIPTION"]?><?endif;?>"></span>
										<?}?>
									</p>
									<?}?>
								</div>
			</div>
		</div>
	</div>
</div>