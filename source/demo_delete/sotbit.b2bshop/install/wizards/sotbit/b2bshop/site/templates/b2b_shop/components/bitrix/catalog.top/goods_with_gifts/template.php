<?
if (! defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true)
	die();
if (! CModule::IncludeModule( "sotbit.b2bshop" ))
	return false;
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/**
 *
 * @global
 *
 */
$frame = $this->createFrame()->begin();

$countRow = 4;


?>

<script type="text/javascript">
	$(function() {
		if($(".giftmain-detail .giftmain").length) {
			$(".giftmain-detail .giftmain").owlCarousel({
				nav:true,
				smartSpeed:400,
				dots:false,
				 navText:["", ""],
				 responsive:{
						0:{
							items:1
						},
						768:{
							items:3
						},
					},
					onInitialized:function(){
						resizeOwl();
					}
			  });
		}
	});
</script>
<?
$colorImage = ($arParams["COLOR_FROM_IMAGE"]=="Y")?1:0;

if (! empty( $arResult['ITEMS'] ))
{

	$arPoint = $arParams["FLAG_PROPS"];
	$brandElementCode = $arParams["MANUFACTURER_ELEMENT_PROPS"];
	$brandListCode = $arParams["MANUFACTURER_LIST_PROPS"];
	$k = 0;
	$countRow = 4;
	$rand = $arResult["RAND"];
	?>
	<div class="giftmain-product-wrapper row">
		<div class="col-sm-24 col-giftmain-product">
			<div class="description_block block_open">
			<div class="description_title button_js">
				<div class="description_title_in">
					<span class="desc_fly_1_bg"><?=GetMessage("SLB_TPL_TITLE_GIFT")?></span>
				</div>
			</div>
<div class="description_content block_js">


			<div class="wrap-giftmain">
			<div class="giftmain" id="giftmain">


			<?

	foreach ( $arResult['ITEMS'] as $arItem ):


		$countItem = 0;
		$ID = $arItem["ID"];

		$firstColor = $arResult["FIRST_COLOR"][$ID];


		$arPrice = $arItem["MIN_PRICE"];
		$brandName = $arItem["PROPERTIES"][$brandListCode]["VALUE"];
		$brandID = $arItem["PROPERTIES"][$brandElementCode]["VALUE"];
		$brandURL = $arResult["BRANDS"][$brandID]["DETAIL_PAGE_URL"];
		$colorCode = (isset( $arParams["COLOR_IN_PRODUCT"] ) && $arParams["COLOR_IN_PRODUCT"] && isset( $arParams['COLOR_IN_PRODUCT_CODE'] ) && ! empty( $arParams['COLOR_IN_PRODUCT_CODE'] )) ? $arParams['COLOR_IN_PRODUCT_CODE'] : $arParams["OFFER_COLOR_PROP"];
		$propName = "";
		?>




<div class="item block_img_js"  data-id="<?=$arItem["ID"]?>" data-first-color="<?=(is_array($firstColor))?$firstColor[0]:$firstColor?>">



					<div class='buy_now_top'>
						<div class="buy-now-top-inner">

				<?if(count($arResult["MORE_PHOTO_JS"][$ID][$firstColor]["MEDIUM"])>0):
				$firstImg = true;

				foreach($arResult["MORE_PHOTO_JS"][$ID][$firstColor]["MEDIUM"] as $i=>$arMediumImg):
					$arBigImg = $arResult["MORE_PHOTO_JS"][$ID][$firstColor]["BIG"][$i];
					if($firstImg):
					?>
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="img-<?=$k ?>" onclick="return false;" alt="" title="">
						<img class="img-responsive big_img_js" src="<?=$arMediumImg["src"]?>" width="<?=$arMediumImg["width"]?>" height="<?=$arMediumImg["height"]?>" alt="<?=(isset($arResult["MORE_PHOTO_JS"][$ID][$firstColor]['TITLE'][$i]) && !empty($arResult["MORE_PHOTO_JS"][$ID][$firstColor]['TITLE'][$i]))?$arResult["MORE_PHOTO_JS"][$ID][$firstColor]['TITLE'][$i]:$Item["DETAIL_PICTURE"]["ALT"]?>" title="<?=(isset($arResult["MORE_PHOTO_JS"][$ID][$firstColor]['TITLE'][$i]) && !empty($arResult["MORE_PHOTO_JS"][$ID][$firstColor]['TITLE'][$i]))?$arResult["MORE_PHOTO_JS"][$ID][$firstColor]['TITLE'][$i]:$Item["DETAIL_PICTURE"]["TITLE"]?>" />
					</a>
					<?
					endif;
					$firstImg = false;
					endforeach?>
				<?elseif($Item["DETAIL_PICTURE"]):?>
				<a  href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="img-<?=$k ?>" onclick="return false;" alt="" title="" style="display:block">
					<img class="img-responsive big_img_js <?=($i==count($arResult["MORE_PHOTO_JS"][$ID][$firstColor]["MEDIUM"])-1)?'last-image':'' ?>" src="<?=$arResult["DEFAULT_IMAGE"]["MEDIUM"][0]["src"]?>" width="<?=$arResult["DEFAULT_IMAGE"]["MEDIUM"][0]["width"]?>" height="<?=$arResult["DEFAULT_IMAGE"]["MEDIUM"][0]["height"]?>" alt="<?=$Item["DETAIL_PICTURE"]["ALT"]?>" title="<?=$Item["DETAIL_PICTURE"]["TITLE"]?>" />
				</a>
				<?else:
				$noPhoto = true;
				?>
				<div class="img-<?=$k ?>">
				<img class="img-responsive big_img_js " src="/upload/no_photo.jpg" width="<?=$arParams["DETAIL_WIDTH_MEDIUM"]?>" height="<?=$arParams["DETAIL_HEIGHT_MEDIUM"]?>" alt="" title="" />
				</div>
				<?endif;?>
							<?if($arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_PERCENT']):?>
							<span class="item-discount">
								<span class="item-discount-inner">
									-<?=$arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_PERCENT']?>%
								</span>
							</span>
							<?endif;?>
						</div>
					</div>

						<div class='buy_now_bottom buy_now_bottom-close'>
							<div class='buy_now_bottom_inner'>
								<p class="item_name">
									<a onclick="" href="<?=$arResult["BRAND"][$ID]['DETAIL_PAGE_URL']?>" title="<?=$arResult["BRAND"][$ID]['NAME']?>"><?=$arResult["BRAND"][$ID]['NAME']?></a>
								</p>
								<p class="item_second_name">
									<a onclick="" href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>"><i><?=$arItem["NAME"]?></i></a>
								</p>
								<?//$frame = $this->createFrame()->begin();?>

								<?if(isset($arResult["MIN_PRICE"][$ID]) && !empty($arResult["MIN_PRICE"][$ID]) && $arResult["CAN_BUY"][$ID]=='Y'):?>
								<div class="detail_block_price_cont">
									<p class="item_price"><?=isset($arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE'])?$arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE']:$arResult["MIN_PRICE"][$ID]["PRINT_DISCOUNT_VALUE"]?></p>
								<?if((isset($arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE_OLD']) && $arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE']!=$arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE_OLD']) || (!isset($arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE_OLD']) && $arResult["MIN_PRICE"][$ID]["PRINT_DISCOUNT_VALUE"]!=$arResult["MIN_PRICE"][$ID]["PRINT_VALUE"])):?>
									<span class="item_price_big"><?=(isset($arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE_OLD']))?$arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE_OLD']:$arResult["MIN_PRICE"][$ID]["PRINT_VALUE"]?></span>
								<?endif;?>
								</div>
								<?endif;?>
								<?if($default_subscribe == 'Y' && $arParams["AVAILABLE_DELETE"]!="Y" && isset($arResult["OFFER_SUBSCRIBE_URL"][$ID]) && !empty($arResult["OFFER_SUBSCRIBE_URL"][$ID])):?>
								<div class="subscribe_cont" <?if($arResult["CAN_BUY"][$ID]):?>style="display:none"<?else:?>style="display:block"<?endif?>>
									<p class="title"><?=GetMessage("MS_DETAIL_AVAILABLE_TITLE")?></p>
								</div>
								<?endif; ?>
								<?//$frame->end();?>
							</div>
						</div>

					<!---->
					<div class="item_open">


						<div class="buy_now_top_small_img">
							<div class="wrap">
								<?
								$count = count($arResult["MORE_PHOTO_JS"][$ID]);
								if($count>$countRow):
								?>
								<div class="arrow-top" id="swiper_<?=$ID.$rand?>_top"></div>
								<div class="arrow-bottom" id="swiper_<?=$ID.$rand?>_bottom"></div>
								<?endif;?>
								<div class="swiper-container detail_color" id="swiper_<?=$ID.$rand?>">
									<ul class="swiper-wrapper offer-props-giftmain">
									<?
									$style = "";
									if(!isset($arResult["MORE_PHOTO_JS"][$ID]))
										$style = 'style="display:none"';
									foreach($arResult["MORE_PHOTO_JS"][$ID] as $color=>$arMorePhoto):?>
										<?foreach($arMorePhoto["SMALL"] as $arImg):
										if($countItem==0)
										{
											$countSmall = count($arMorePhoto["MEDIUM"]);
											$style = "";
											if($countSmall<=1) $style = 'style="display:none"';
										}
										if($countItem==0 || $countItem%$countRow==0)
										{
											?><div class="swiper-slide"><?
										}
										?>
<?
$li_available = "";
								 if(!isset($arResult["CAN_BUY_OFFERS_ID"][$ID][$colorCode][$color]))
														$li_available = "li-available";
								 ?>





										<li title="<?=isset($arImg["title"])?$arImg["title"]:$arItem["NAME"]?>" class="small_img_js <?if($color==$arResult["FIRST_COLOR"][$ID]):?>li-active<?endif;?> <?=$li_available?>" data-color="<?=$color?>" data-xml="<?=$color?>" data-offer="<?=implode(",", $arResult["OFFERS_ID"][$ID][$colorCode][$color])?>">
											<img data-color="<?=$color?>" class="img-responsive"
											src="<?=$arImg["src"]?>"  width="<?=$arImg["width"]?>" height="<?=$arImg["height"]?>"  title="<?=isset($arImg["title"])?$arImg["title"]:$arItem["NAME"]?>" alt=""/>
										</li>



										<?
										$countItem++;



										if($countItem%$countRow==0 || count($arResult["MORE_PHOTO_JS"][$ID])==$countItem)
										{
											?>

											</div>

											<?
										}
										break 1;
										endforeach?>
									<?endforeach?>
									</ul>
								</div>
							</div>
						</div>


						<noindex>
							<a rel="nofollow" style="width: 193px; height: 341px;" class='buy_now_top' onclick="" href="<?=$arItem["DETAIL_PAGE_URL"]?>"></a>
						</noindex>
						<div class="wrap_item_bnt">
							<span class="bnt_left" <?=$style?>></span>
							<span class="bnt_right" <?=$style?>></span>
							<span class="bnt_center quick_view<?=$rand?>" data-index="<?=$k?>"><?=GetMessage("B2BS_CATALOG_QUICK_SHOW")?></span>
						</div>



						<div class="buy_now_bottom">
								<div class='buy_now_bottom_inner'>
									<p class="item_name">
										<a onclick="" href="<?=$arResult["BRAND"][$ID]['DETAIL_PAGE_URL']?>" title="<?=$arResult["BRAND"][$ID]['NAME']?>"><?=$arResult["BRAND"][$ID]['NAME']?></a>
									</p>
									<p class="item_second_name">
										<a onclick="" href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>"><i><?=$arItem["NAME"]?></i></a>
									</p>
								<?if(isset($arResult["MIN_PRICE"][$ID]) && !empty($arResult["MIN_PRICE"][$ID]) && $arResult["CAN_BUY"][$ID]=='Y'):?>
								<div class="detail_block_price_cont">
									<p class="item_price"><?=isset($arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE'])?$arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE']:$arResult["MIN_PRICE"][$ID]["PRINT_DISCOUNT_VALUE"]?></p>
								<?if((isset($arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE_OLD']) && $arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE']!=$arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE_OLD']) || (!isset($arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE_OLD']) && $arResult["MIN_PRICE"][$ID]["PRINT_DISCOUNT_VALUE"]!=$arResult["MIN_PRICE"][$ID]["PRINT_VALUE"])):?>
									<span class="item_price_big"><?=(isset($arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE_OLD']))?$arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE_OLD']:$arResult["MIN_PRICE"][$ID]["PRINT_VALUE"]?></span>
								<?endif;?>
								</div>
								<?endif;?>
								<?if($default_subscribe == 'Y' && $arParams["AVAILABLE_DELETE"]!="Y" && isset($arResult["OFFER_SUBSCRIBE_URL"][$ID]) && !empty($arResult["OFFER_SUBSCRIBE_URL"][$ID])):?>
								<div class="subscribe_cont" <?if($arResult["CAN_BUY"][$ID]):?>style="display:none"<?else:?>style="display:block"<?endif?>>
									<p class="title"><?=GetMessage("MS_DETAIL_AVAILABLE_TITLE")?></p>
								</div>
								<?endif; ?>

									<?//$frame->end();?>
								</div>

																		<?if(isset($arResult["OFFER_TREE_PROPS"][$ID]) && is_array($arResult["OFFER_TREE_PROPS"][$ID]) && ((count($arResult["OFFER_TREE_PROPS"][$ID])>1 && isset($arResult["OFFER_TREE_PROPS"][$ID][$colorCode])) || (count($arResult["OFFER_TREE_PROPS"][$ID])>0 && !isset($arResult["OFFER_TREE_PROPS"][$ID][$colorCode])))):?>
<div class="js_detail_prop_block">
										<?foreach($arResult["OFFER_TREE_PROPS"][$ID] as $codeProp=>$arProperties):

											//START OFFER_PROPS END in_array
											if($colorCode==$codeProp || !in_array($codeProp,unserialize(COption::GetOptionString("sotbit.b2bshop", "OFFER_TREE_PROPS", "")))) continue;
											//END OFFER_PROPS
											?>
											<div class="detail_size js_detail_prop">
												<span class="detail_prop_title" title="<?=$arResult["OFFER_TREE_PROPS_NAME"][$ID][$codeProp]?>"><?=GetMessage("B2BS_CATALOG_DETAIL_CHANGE")?> <?=$arResult["OFFER_TREE_PROPS_NAME"][$ID][$codeProp]?>:</span>
												<ul class="offer-props-giftmain" id="offer_prop_<?=$codeProp?>" title="<?=$arResult["OFFER_TREE_PROPS_NAME"][$codeProp]?>">
													<?
													//START OFFER_PROPS
													$CntNotAvailable=0;
													foreach($arProperties as $xmlID=>$arProp):
														$arSrav = array_intersect($arResult["OFFERS_ID"][$ID][$codeProp][$xmlID], $arResult["OFFERS_ID"][$ID][$colorCode][$firstColor]);
														if(empty($arSrav)) ++$CntNotAvailable;
													 endforeach;
													//END OFFER_PROPS
													?>

													<?foreach($arProperties as $xmlID=>$arProp):
														?>
														<!-- START OFFER_PROPS was class $li_disable $li_available-->
														<li  title="<?=$arProp["UF_NAME"]?>" class="<?=$arResult['LI'][$ID][$xmlID]?>" data-offer="<?=implode(",", $arResult["OFFERS_ID"][$ID][$codeProp][$xmlID])?>" data-xml="<?=$xmlID?>">
															<!-- END OFFER_PROPS -->
															<span title="<?=$arProp["UF_NAME"]?>"><?=$arProp["UF_NAME"]?></span>
														</li>
														<?endforeach?>
												</ul>
											</div>
											<?endforeach?>
											</div>
										<?endif;?>




<?if(isset($arResult["MIN_PRICE"][$ID]) && !empty($arResult["MIN_PRICE"][$ID]) && $arResult["CAN_BUY"][$ID]=='Y'):?>
<div class="buttons-wrapper detail_block_price_cont">
								<div class="to_basket">
									<span class="btn_add_basket_giftmain"><?=GetMessage("B2BS_CATALOG_DETAIL_IN_CART")?></span>
								</div>
 </div>
<?endif; ?>
<?if($default_subscribe == 'Y' && $arParams["AVAILABLE_DELETE"]!="Y" && isset($arResult["OFFER_SUBSCRIBE_URL"][$ID]) && !empty($arResult["OFFER_SUBSCRIBE_URL"][$ID])):?>
<div class="subscribe_cont" <?if($arResult["CAN_BUY"][$ID]):?>style="display:none"<?else:?>style="display:block"<?endif?>>
								<form class="subscribe_product_form" action="">
									<div class="wrap_input">
										<input type="submit" name="s" value="<?=GetMessage("MS_DETAIL_AVAILABLE_SUBMIT")?>" onsubmit="" onclick="" class="back_call_submit">
									</div>
								</form>
								<div class="subscribe_new">
									<p><?=GetMessage("MS_DETAIL_AVAILABLE_NEW_USER")?></p>
									<form class="subscribe_new_form" action="">
										<?echo bitrix_sessid_post();?>
										<input type="text" name="user_mail" value="" />
										<div class="wrap_input">
											<div class="submit"><?=GetMessage("MS_DETAIL_AVAILABLE_NEW_USER_SUBMIT")?></div>
										</div>
									</form>
								</div>
</div>

<?endif; ?>









						</div>
					</div>
					<!---->
				</div>





			<?
		$k ++;

	endforeach;
	?>

				 </div>
			</div>

	</div>
</div>
</div>
</div>
<?

	if (isset( $arResult["FANCY"] ) && ! empty( $arResult["FANCY"] ))
	{
		foreach ( $arResult["FANCY"] as $arItem )
		{
			$quick_view_id[] = $arItem['ID'];
			$detail_page[] = $arItem["DETAIL_PAGE_URL"];
		}
		$APPLICATION->IncludeComponent( "sotbit:sotbit.quick.view_new", "", Array(
				"ELEMENT_ID" => $quick_view_id,
				"PARAB2BS_CATALOG" => $arParams,
				"ELEMENT_TEMPLATE" => 'preview',
				"DETAIL_PAGE_URL" => $detail_page,
				"RAND" => $arResult["RAND"]
		), false );
	}
}

$frame->beginStub();
$frame->end();


?>
<?
$mess = array(
	'MS_JS_CATALOG_ADD_BASKET' => GetMessage("MS_JS_CATALOG_ADD_BASKET"),
	'MS_JS_CATALOG_ADD_WISH' => GetMessage("MS_JS_CATALOG_ADD_WISH"),
	'MS_JS_CATALOG_ADD_SUBSCRIBE' => GetMessage("MS_JS_CATALOG_ADD_SUBSCRIBE"),
	'MS_JS_CATALOG_SELECT_PROP' => GetMessage("MS_JS_CATALOG_SELECT_PROP"),
);



?>
<script>

$(function() {
	var msListPV = new msListProduct({
		"arImage" : <? echo CUtil::PhpToJSObject($arResult['MORE_PHOTO_JS'], false, true); ?>,
		"listBlock" : "#giftmain",
		"listItem" : ".item",
		"listItemSmalImg" : ".small_img_js",
		"mainItemImage" : ".big_img_js",
		"listItemOpen" : ".item_open .buy_now_top",
		"btnLeft" : ".bnt_left",
		"btnRight" : ".bnt_right",
	});
})


$(function() {
	var msMainGift = new msGiftMainProduct({
		"SITE_ID" : "<?=$siteID?>",
		"toggle" : ".giftmain-product-wrapper .button_js",
		"OFFER_ID" : <?echo CUtil::PhpToJSObject($arResult["FIRST"], false, true);?>,
		"DETAIL_PAGE_URL" : "<?=$arResult['DETAIL_PAGE_URL']?>",
		"image" : <? echo CUtil::PhpToJSObject($arResult['MORE_PHOTO_JS'], false, true); ?>,
		"TemplatePath" : "<?=SITE_TEMPLATE_PATH?>",
		"main" : ".giftmain",
		"giftmain":".wrap-giftmain",
		"prop_img":".giftmain .small_img_js ",
		"prop" : "ul.offer-props-giftmain",
		"child_prop" : "li",
		"prop_color" : "#offer_prop_<?=$arParams["OFFER_COLOR_PROP"]?>",
		"class_li_active" : ".li-active",
		"class_li_disable" : ".li-disable",
		"class_li_available" : ".li-available",
		"image_container" : ".buy-now-top-inner",
		"price_container" : ".detail_block_price_cont",
		"available_container" : ".subscribe_cont",
		"quantity_input" : ".block_quantity input",
		"add_url" : ".giftmain .btn_add_basket_giftmain",
		"add_wish" : ".giftmain .btn_add_wish_giftmain",
		"js_slider_pic_small":".js_slider_pic_small",
		"add_subscribe" : ".subscribe_product_form .back_call_submit",
		"submit_subscribe" : ".giftmain .subscribe_new_form .submit",
		"basket_url" : <? echo CUtil::PhpToJSObject($arResult['OFFER_ADD_URL'], false, true); ?>,
		"wish_url" : <? echo CUtil::PhpToJSObject($arResult['OFFER_DELAY_URL'], false, true); ?>,
		"subscribe_url" : <? echo CUtil::PhpToJSObject($arResult['OFFER_SUBSCRIBE_URL'], false, true); ?>,
		"props_name" : <? echo CUtil::PhpToJSObject($arResult['OFFER_TREE_PROPS_NAME'], false, true); ?>,
		"offer_available_id" : <? echo CUtil::PhpToJSObject($arResult['OFFER_AVAILABLE_ID'], false, true); ?>,
		"forgot_select_description" : "<?=GetMessage("B2BS_CATALOG_DETAIL_FORGOT_SELECT")?>",



		"contBasket" : ".bx-basket-fixed",
		"basketUrl" : "<?=$APPLICATION->GetCurPage()?>",
		"contPrevNext" : ".detail_page_wrap.no_preview .block_title_list",
		"contPrev" : ".list_left",
		"contNext" : ".list_right",
		"contSelectProps" : ".detail_page_wrap.no_preview .sotbit_order_phone form input:submit",
		"prices" : <? echo CUtil::PhpToJSObject($arResult['PRICES_JS'], false, true); ?>,
		"discountPrice" : ".item_price",
		"oldPrice" : ".item_price_big",
		"download" : "<?=$arResult["IS_DOWNLOAD"]?>",
		"ajax_file" : "<?=$templateFolder?>/ajax.php"

	});

});

BX.message(<?=\Bitrix\Main\Web\Json::encode($mess)?>);


	$(".buy-now-top-inner .img-<?=$k-1 ?> img").load(function(){
			resizeOwl();
});
</script>