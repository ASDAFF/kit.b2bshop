<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$colorCode = $arParams["OFFER_COLOR_PROP"];
?>
<?if(!isset($_REQUEST["msCalculateBasket"]) && !isset($_REQUEST["bxajaxid"])):?>
<script>
	$(document).ready(function(){
		$(document).msCalculateBasketOrder({
			"containerMain" : ".item_prop",
			"contProps" : ".js_detail_prop ul",
			"contItemProps" : "li",
			"contItemActive" : ".li-active",
			"attrItemProps" : "data-xml",
			"attrItemID" :  "data-id",
			"attrItemProperty" :  "data-property",
			"itemActive" : ".li-active",
			"nameProps" : "props",
			"nameMainVar" : "msCalculateBasket",
			"basketUrl" : "<?=$APPLICATION->GetCurPage()?>"

		})
	})
</script>
<?endif;?>
<div class="col-sm-24 sm-padding-no block_basket block_order_basket">
	<?echo ShowError($arResult["ERROR_MESSAGE"]);?>
	<div class="div_table">
		<div class="div_table_header">
			<div class='div_table__name'>
				<?=GetMessage("MS_BASKET_PRODUCT")?>
			</div>
			<div class='div_table__article'>
				<?=GetMessage("MS_BASKET_ARTICLE")?>
			</div>
			<?php
			foreach($arResult['PROPS'] as $code => $name)
			{
				?>
				<div class='div_table__size'>
					<?=$name?>
				</div>
				<?php
			}
			?>
			<div class='div_table__quantity'>
				<?=GetMessage("MS_BASKET_QUANTITY")?>
			</div>
			<div class='div_table__summ'>
				<?=GetMessage("MS_BASKET_ITOGO")?>
			</div>
			<div class='div_table__delete'>
			</div>
		</div>
		<div class="div_table_body">
		<?foreach($arResult["ITEMS"]["DelDelCanBuy"] as $arItem):
			$productID = $arItem["PARENT_PRODUCT_ID"];
			$arOffersProps = array();
			if(($kk%2) == 0) {
				$color = 'grey_bg';
			}
			else {
				$color ='';
			}
		?>
			<div id="item_<?=$arItem["ID"]?>" class="basket_item <?=$color?>">
				<div class='div_table__name'>
					<div class="wrap_title">
						<p class="item_second_name"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?><img alt="<?=$arItem["NAME"]?>" src="/bitrix/templates/b2b_shop/img/zoom_mail.png"></a></p>
					</div>
				</div>
				<div class='div_table__article'>
					<p class="mobile_title"><?=GetMessage("MS_BASKET_ARTICLE")?>:</p>
					<p class="item_article">
						<?=$arItem['ARTICLE']?>
					</p>
				</div>
				<?
				foreach($arResult['PROPS'] as $code => $name)
				{
					?>
					<div class='div_table__size'>
						<p class="mobile_title"><?=$name?>:</p>
						<div class="item_prop">
							<?php
							if($arItem["PROPS"])
							{
								foreach($arItem["PROPS"] as $arProp)
								{
									if($arProp["CODE"] == $code)
									{
										?>
										<span class="black"><?=$arProp["VALUE"]?></span>
										<?php
									}
								}
							}
							?>
						</div>
					</div>
					<?php
				}
				?>
				<div class='div_table__quantity'>
					<p class="mobile_title"><?=GetMessage("MS_BASKET_QUANTITY")?>:</p>
					<?
					$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
					$max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
					$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
					$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
					?>
					<?
					if (!isset($arItem["MEASURE_RATIO"]))
					{
						$arItem["MEASURE_RATIO"] = 1;
					}
					?>
					<div class="wrap_input">
                        <span class="minus" onclick="minus_quantity('#QUANTITY_<?=$arItem["ID"]?>');BX.ajax.submitComponentForm(BX('basket_form'), 'basket_form_content', true);BX.submit(BX('basket_form'));BX.closeWait();">&dash;</span>
						<input class="basket_item_input" readonly id="QUANTITY_<?=$arItem["ID"]?>" value="<?=$arItem["QUANTITY"]?>" type="text" placeholder=""name="QUANTITY_<?=$arItem["ID"]?>" value="1" maxlength="4" onchange="BX.ajax.submitComponentForm(BX('basket_form'), 'basket_form_content', true);BX.submit(BX('basket_form'));BX.closeWait();" >
                        <span class="plus" onclick="pluc_quantity('#QUANTITY_<?=$arItem["ID"]?>');BX.ajax.submitComponentForm(BX('basket_form'), 'basket_form_content', true);BX.submit(BX('basket_form'));BX.closeWait();" href="javascript:void(0)">+</span>
					</div>
				</div>
				<div class='div_table__summ'>
					<p class="mobile_title"><?=GetMessage("MS_BASKET_ITOGO")?>:</p>
					<p class="count_item"><?=$arItem["PRICE_ALL_FORMATED"]?></p>
				</div>
				<div class='div_table__delete'>
					<div class="wrap_del_change">
						<p class="cart-add-item"><a title="<?=GetMessage("MS_BASKET_TO_BASKET")?>" href="<?=str_replace("#ID#", $arItem["PRODUCT_ID"], $arUrls["new_add"])?>" onclick="BX.ajax.insertToNode('<?=str_replace("#ID#", $arItem["PRODUCT_ID"], $arUrls["new_add"])?>&bxajaxid=<?=$bxajaxid?>', 'comp_<?=$bxajaxid;?>'); return false;" rel="nofollow"></a></p>
                        <p class="cart-delete-item"><a title="<?=GetMessage("MS_BASKET_TO_BASKET")?>" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>" rel="nofollow"></a></p>
					</div>
				</div>
			</div>
			<? $kk++; ?>
		<?endforeach;?>
		</div>
	</div> <!--end div_table-->
	<div class="block_basket_count_wrap">
		<div class="block_basket_count">
			<?
			if ($arParams["HIDE_COUPON"] != "Y"):

				$couponClass = "";
				if (array_key_exists('VALID_COUPON', $arResult))
				{
					$couponClass = ($arResult["VALID_COUPON"] === true) ? "good" : "bad";
				}
				elseif (array_key_exists('COUPON', $arResult) && !empty($arResult["COUPON"]))
				{
					$couponClass = "good";
				}

				?>
				<div class="coupon__block">
					<div class="coupon__block__title">
						<span class="block_promo_title"><?=GetMessage("MS_BASKET_PROMO")?></span>
						<span class="block_promo_text"><?=GetMessage("MS_BASKET_PROMO_TEXT")?></span>
					</div>
					<div class="coupon__block__input">
						<input class="input_coupon <?=$couponClass?>" type="text" id="coupon" name="COUPON" value="<?=$arResult["COUPON"]?>" onchange="">
						<input class="basket_refresh" type="submit" name="BasketRefresh" value="<?=GetMessage("MS_BASKET_SAVE")?>" onclick="">
					</div>
				</div>
			<?else:?>
				&nbsp;
			<?endif;?>

			<div class="basket_count__block">
				<p class="basket_count"><?=GetMessage("MS_BASKET_ITOGO")?>: <span><?=str_replace(" ", "&nbsp;", $arResult["allSum_delay_FORMATED"])?></span></p>
			</div>
		</div>
	</div>
</div>


<input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
<input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFER_TREE_PROPS"], ","))?>" />
<input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
<input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
<input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
<input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
<input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
<input type="hidden" id="coupon_approved" value="N" />
<input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />
<input type="hidden" name="BasketRefresh" value="1">