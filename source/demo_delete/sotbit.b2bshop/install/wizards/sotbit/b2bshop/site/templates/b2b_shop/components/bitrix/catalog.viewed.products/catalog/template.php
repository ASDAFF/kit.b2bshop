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
if (! empty( $arResult['ITEMS'] ))
{
	?>
<script type="text/javascript">
	$(function() {
		if($("#block-you-slider").length) {

			$('#block-you-slider').css({'width': '100%'});
			$('#block-you-slider .item').css({'float': 'none'});
			$("#block-you-slider").owlCarousel({
				nav:true,
				smartSpeed:400,
				dots:false,
				 navText:["", ""],
				 responsive:{
						0:{
							items:2
						},
						768:{
							items:3
						},
						979:{
							items:4
						},
						1199:{
							items:5
						}
					},
					onChanged:function(){
						if($('.b-lazy').length)
						{
							var bLazy = new Blazy({
								selector: '.b-lazy',
								loadInvisible:'true',
								success: function(image){
									var element = $(image);
									if(element.parent().attr('class')=='b-lazy-wrapper')
										element.unwrap();
								}});
							bLazy.revalidate();
						}
					}
			  });

			var MaxHeight=0;
			var MaxItemHeight=0;
			$('#block-you-slider  .item').each(function (index, value) {
			  var BottomHeight=$(this).find('.block_size_color').height();
			  if(BottomHeight>MaxHeight)
			  	MaxHeight=BottomHeight;
			});

			MaxHeight+=10;

			$('#block-you-slider .item').css('padding-bottom',MaxHeight+'px');

			$('#block-you-slider  .item .buy-now-top-inner img').each(function (index, value) {
				var WrapperWidth=$(this).attr('width');
				var WrapperHeight=$(this).attr('height');
				if ( WrapperWidth !== undefined && WrapperWidth !== false && WrapperHeight !== undefined && WrapperHeight !== false )
				{
					var ParentWidth=$(this).parent().width();
					if(ParentWidth<WrapperWidth)
						{var NewWrapperHeight=Math.round((WrapperHeight*ParentWidth)/WrapperWidth);
						$(this).height(NewWrapperHeight);}
				}
				if( NewWrapperHeight>MaxItemHeight)
					MaxItemHeight= NewWrapperHeight;
			  });
			$('#block-you-slider .item .buy_now_top').css('height',MaxItemHeight+'px');


			if($('#block-you-slider .icon_property_wrap').length){
				icon_position('#block-you-slider .icon_property_wrap');
			}

		}
	})
	$(function() {
		var msListPV = new msListProduct({
			"arImage" : <? echo CUtil::PhpToJSObject($arResult['MORE_PHOTO_JS'], false, true); ?>,
			"listBlock" : "#block-you-slider",
			"listItem" : ".item",
			"listItemSmalImg" : ".small_img_js",
			"mainItemImage" : ".big_img_js",
			"listItemOpen" : ".item_open .buy_now_top",
			"btnLeft" : ".bnt_left",
			"btnRight" : ".bnt_right",
		});
	})
	</script>
<?
	$arPoint = $arParams["FLAG_PROPS"];
	$brandElementCode = $arParams["MANUFACTURER_ELEMENT_PROPS"];
	$brandListCode = $arParams["MANUFACTURER_LIST_PROPS"];
	$k = 0;
	$countRow = 4;
	$rand = $arResult["RAND"];
	?>
<div class="col-sm-24 sm-padding-right-no">
	<div class="block_you_look_big">
		<div class="block_you_look_big_bg"></div>
		<h2 class="title"><?=GetMessage("MS_PV_YOU_SEE")?></h2>
		<div class="wrap-block-you-slider">
			<div id="block-you-slider" class="block-you-slider">
			<?

	foreach ( $arResult['ITEMS'] as $arItem )
	:
		$countItem = 0;
		$ID = $arItem["ID"];
		$firstColor = $arItem["FIRST_COLOR"];
		$arPrice = $arItem["MIN_PRICE"];
		$brandName = $arItem["PROPERTIES"][$brandListCode]["VALUE"];
		$brandID = $arItem["PROPERTIES"][$brandElementCode]["VALUE"];
		$brandURL = $arResult["BRANDS"][$brandID]["DETAIL_PAGE_URL"];
		$colorCode = (isset( $arParams["COLOR_IN_PRODUCT"] ) && $arParams["COLOR_IN_PRODUCT"] && isset( $arParams['COLOR_IN_PRODUCT_CODE'] ) && ! empty( $arParams['COLOR_IN_PRODUCT_CODE'] )) ? $arParams['COLOR_IN_PRODUCT_CODE'] : $arParams["OFFER_COLOR_PROP"];
		$propName = "";
		?>
				<div class='item block_img_js'
					data-id="<?=$arItem["ID"]?>"
					data-first-color="<?=(is_array($firstColor))?$firstColor[0]:$firstColor?>">
					<div class='buy_now_top'>
						<div class="buy-now-top-inner">
							<?
		if ((isset( $arItem["PREVIEW_PICTURE_RESIZE"] ) && ! empty( $arItem["PREVIEW_PICTURE_RESIZE"] )))
		{
			?>
							<a onclick=""
								href="<?=$arItem["DETAIL_PAGE_URL"]?>">
							<?if($arParams['LAZY_LOAD']=="Y"):?>
								<span class="b-lazy-wrapper" data-width="<?=$arItem["PREVIEW_PICTURE_RESIZE"]["width"]?>" data-height="<?=$arItem["PREVIEW_PICTURE_RESIZE"]["height"]?>" style="background-image:url(<?=$arParams['PRELOADER']?>)">
							<?endif;?>
							<img
									class="img-responsive big_img_js <?=($arParams['LAZY_LOAD']=="Y")?"b-lazy":""?>"
									<?=($arParams['LAZY_LOAD']!="Y")?"src=\"".$arItem["PREVIEW_PICTURE_RESIZE"]["src"]."\"":"src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== data-src=\"".$arItem["PREVIEW_PICTURE_RESIZE"]["src"]."\""?>
									title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
									alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
									height="<?=$arItem["PREVIEW_PICTURE_RESIZE"]["height"]?>"
									width="<?=$arItem["PREVIEW_PICTURE_RESIZE"]["width"]?>">
							<?if($arParams['LAZY_LOAD']=="Y"):?>
								</span>
							<?endif;?>
								</a>
							<?
		} else
		{
			?>
							<a onclick=""
								href="<?=$arItem["DETAIL_PAGE_URL"]?>">
							<?if($arParams['LAZY_LOAD']=="Y"):?>
								<span class="b-lazy-wrapper" data-width="<?=$arParams["LIST_HEIGHT_MEDIUM"]?>" data-height="<?=$arParams["LIST_WIDTH_MEDIUM"]?>" style="background-image:url(<?=$arParams['PRELOADER']?>)">
							<?endif;?>
							<img
									class="img-responsive big_img_js <?=($arParams['LAZY_LOAD']=="Y")?"b-lazy":""?>"
									<?=($arParams['LAZY_LOAD']!="Y")?"src=\"/upload/no_photo.jpg\"":"src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== data-src=\"/upload/no_photo.jpg\""?>
									title="" alt="" height="<?=$arParams["LIST_WIDTH_MEDIUM"]?>"
									width="<?=$arParams["LIST_HEIGHT_MEDIUM"]?>">
							<?if($arParams['LAZY_LOAD']=="Y"):?>
								</span>
							<?endif;?>
								</a>
							<?
		}
		?>
							<?if($arPrice["DISCOUNT_DIFF_PERCENT"]):?>
							<span class="item-discount"> <span
								class="item-discount-inner">
									-<?=$arPrice["DISCOUNT_DIFF_PERCENT"]?>%
								</span>
							</span>
							<?endif;?>
						</div>
						<?

		foreach ( $arPoint as $v )
		: // print "V".$v;
			if (! isset( $arItem["PROPERTIES"][$v] ))
				continue;
			$val = $arItem["PROPERTIES"][$v]["VALUE"];
			if (($val == "true" || $val == "Y" || $val == GetMessage( "B2BS_CATALOG_YES" )) && $propName == "" && ! empty( $val ))
			:
				$propName = $arItem["PROPERTIES"][$v]["NAME"];
				?>
						<span class="icon_property_wrap"> <span
							class="icon_property"> <span class="icon_property_name"><?=$propName?></span>
						</span>
						</span>



			<?
						endif;
		endforeach
		?>
					</div>

					<div class='buy_now_bottom'>
						<div class='buy_now_bottom_inner'>
							<p class="item_name">
								<a onclick="" href="<?=$brandURL?>" title="<?=$brandName?>"><?=$brandName?></a>
							</p>
							<p class="item_second_name">
								<a onclick="" href="<?=$arItem["DETAIL_PAGE_URL"]?>"
									title="<?=$arItem["NAME"]?>"><i><?=$arItem["NAME"]?></i></a>
							</p>
							<?//$frame = $this->createFrame()->begin();?>
							<div>
							<?if($arPrice["VALUE"]==$arPrice["DISCOUNT_VALUE"]):?>
								<p class="item_price"><?=$arPrice["PRINT_VALUE"]?></p>
							<?else:?>
								<p class="item_price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></p>
								<p class="item_price_big"><?=$arPrice["PRINT_VALUE"]?></p>
							<?endif;?>
							</div>
							<?//$frame->end();?>
						</div>
					</div>
					<!---->
					<div class="item_open">
						<div class="buy_now_top_small_img">
							<div class="wrap">
											<?
		$count = count( $arResult["MORE_PHOTO_JS"][$ID] );
		if ($count > $countRow)
		:
			?>
											<div class="arrow-top"
									id="swiper_<?=$ID.$rand?>_top"></div>
								<div class="arrow-bottom" id="swiper_<?=$ID.$rand?>_bottom"></div>
											<?endif;?>
											<div
									class="swiper-container" id="swiper_<?=$ID.$rand?>">
									<div class="swiper-wrapper">
												<?
		$style = "";
		foreach ( $arResult["MORE_PHOTO_JS"][$ID] as $color => $arMorePhoto )
		:
			?>
													<?

			foreach ( $arMorePhoto["SMALL"] as $arImg )
			:
				if ($countItem == 0)
				{
					$countSmall = count( $arMorePhoto["MEDIUM"] );
					$style = "";
					if ($countSmall <= 1)
						$style = 'style="display:none"';
				}
				if ($countItem == 0 || $countItem % $countRow == 0)
				{
					?><div class="swiper-slide"><?
				}
				?>
<span
												title="<?=isset($arImg["title"])?$arImg["title"]:$arItem["NAME"]?>"
												class="small_img_js" data-color="<?=$color?>">
											<?if($arParams['LAZY_LOAD']=="Y"):?>
											<span class="b-lazy-wrapper" data-width="<?=$arImg["width"]?>" data-height="<?=$arImg["height"]?>" style="background-image:url(<?=$arParams['PRELOADER']?>)">
										<?endif;?>
											<img data-color="<?=$color?>"
													class="img-responsive <?=($arParams['LAZY_LOAD']=="Y")?"b-lazy":""?>"
													<?=($arParams['LAZY_LOAD']!="Y")?"src=\"".$arImg["src"]."\"":"src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== data-src=\"".$arImg["src"]."\""?>
													width="<?=$arImg["width"]?>" height="<?=$arImg["height"]?>"
													title="<?=isset($arImg["title"])?$arImg["title"]:$arItem["NAME"]?>"
													alt="" />
										<?if($arParams['LAZY_LOAD']=="Y"):?>
											</span>
										<?endif;?>
												</span>
													<?
				$countItem ++;
				if ($countItem % $countRow == 0 || count( $arResult["MORE_PHOTO_JS"][$ID] ) == $countItem)
				{
					?>
														</div>
														<?
				}
				break 1;
			endforeach
			?>
												<?endforeach?>
												</div>
								</div>
							</div>
						</div>
						<noindex> <a rel="nofollow" class='buy_now_top' onclick=""
							href="<?=$arItem["DETAIL_PAGE_URL"]?>"></a> <!--big_img_js href-->
						</noindex>
						<div class="wrap_item_bnt">
							<span class="bnt_left" <?=$style?>></span> <span
								class="bnt_right" <?=$style?>></span> <span
								class="bnt_center quick_view<?=$rand?>" data-index="<?=$k?>"><?=GetMessage("B2BS_CATALOG_QUICK_SHOW")?></span>
						</div>
						<div class='buy_now_bottom'>
							<div class='buy_now_bottom_inner'>
								<p class="item_name">
									<a onclick="" href="<?=$brandURL?>" title=""><?=$brandName?></a>
								</p>
								<p class="item_second_name">
									<a onclick="" href="<?=$arItem["DETAIL_PAGE_URL"]?>"
										title="<?=$arItem["NAME"]?>"><i><?=$arItem["NAME"]?></i></a>
								</p>
								<?//$frame = $this->createFrame()->begin();?>
								<div>
								<?if($arPrice["VALUE"]==$arPrice["DISCOUNT_VALUE"]):?>
									<p class="item_price"><?=$arPrice["PRINT_VALUE"]?></p>
								<?else:?>
									<p class="item_price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></p>
									<p class="item_price_big"><?=$arPrice["PRINT_VALUE"]?></p>
								<?endif;?>
								</div>
								<?//$frame->end();?>
								<div class="block_size_color">
								<?if(isset($arItem["OFFER_TREE_PROPS_VALUE"]) && is_array($arItem["OFFER_TREE_PROPS_VALUE"])): ?>
									<?

			foreach ( $arItem["OFFER_TREE_PROPS_VALUE"] as $code => $arProp )
			:
				if ($code == $colorCode)
					continue 1;
				?>
											<p class="name_size"><?=$arResult["PROP_NAME"][$code]?> <?=GetMessage("B2BS_CATALOG_PROP_AVAILABILITY")?></p>
									<p class="item_size">
												<?foreach($arProp as $v):?>
													<span title="<?=$v?>"><?=$v?></span>
												<?endforeach?>
											</p>
									<?endforeach?>
								 <?endif; ?>
									<?if(isset($arItem["OFFER_TREE_PROPS"][$colorCode])):?>
									<p class="name_color"><?=GetMessage("MS_PV_COLOR_AVAILABILITY")?></p>
									<p class="item_color">
										<?

			foreach ( $arItem["OFFER_TREE_PROPS"][$colorCode] as $xmlID => $arColor )
			:
				if (! isset( $arResult["MORE_PHOTO_JS"][$ID][$xmlID] ))
					continue 1;
				?>
										<span title="<?=$arColor["UF_NAME"]?>" style="background: <?if($arColor["UF_FILE"]):?>url(<?=$arColor["PIC"]["SRC"]?>) 50% 50% no-repeat<?else:?><?=$arColor["UF_DESCRIPTION"]?><?endif;?>"></span>
										<?endforeach?>
									</p>
									<?endif;?>
								</div>
							</div>
						</div>
					</div>
					<!---->
				</div>
			<?
		$k ++;
	endforeach
	?>
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
?>
<?

$frame->beginStub();
$frame->end();
?>