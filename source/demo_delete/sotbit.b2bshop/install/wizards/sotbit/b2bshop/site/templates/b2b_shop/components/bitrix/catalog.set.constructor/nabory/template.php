<?
if (!defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true)
	die();
$this->setFrameMode( true );

$templateData = array(
		'CURRENCIES' => CUtil::PhpToJSObject( $arResult['CURRENCIES'], false, true, true )
);

$curJsId = $this->randString();

?>

<script type="text/javascript">
$(function() {
	var msDetNabor = new msDetailNabor({
		"jsId" : "<?=$curJsId?>",
		"currencies":<?=$templateData['CURRENCIES']?>,
		"parentContId" : "#bx-set-const-<?=$curJsId?>",
		"ajaxPath" : "<?=$this->GetFolder() . '/ajax.php'?>",
		"currency" : "<?=$arResult["ELEMENT"]["PRICE_CURRENCY"]?>",
		"mainElementPrice" : "<?=$arResult["ELEMENT"]["PRICE_DISCOUNT_VALUE"]?>",
		"mainElementOldPrice" : "<?=$arResult["ELEMENT"]["PRICE_VALUE"]?>",
		"mainElementDiffPrice" : "<?=$arResult["ELEMENT"]["PRICE_DISCOUNT_DIFFERENCE_VALUE"]?>",
		"mainElementBasketQuantity" : "<?=$arResult["ELEMENT"]["BASKET_QUANTITY"]?>",
		"lid" : "<?=SITE_ID?>",
		"iblockId" : "<?=$arParams["IBLOCK_ID"]?>",
		"basketUrl" : "<?=$arParams["BASKET_URL"]?>",
		"setIds" : <?=CUtil::PhpToJSObject($arResult["DEFAULT_SET_IDS"], false, true, true)?>,
		"offersCartProps" : <?=CUtil::PhpToJSObject($arParams["OFFERS_CART_PROPERTIES"], false, true, true)?>,
		"itemsRatio" : <?=CUtil::PhpToJSObject($arResult["BASKET_QUANTITY"], false, true, true)?>,
		"toggle" : "#bx-set-const-<?=$curJsId?> .button_js",
		"nabor_add_basket":".nabor-wrapper .basket-botton"
    })
});
</script>

<div id="bx-set-const-<?=$curJsId?>" class="nabor-wrapper row">
	<div class="col-sm-24 col-nabor">
		<div class="description_block block_open">
			<div class="description_title button_js">
				<div class="description_title_in">
					<span class="desc_fly_1_bg"><?=GetMessage("CATALOG_SET_BUY_SET")?></span>
				</div>
			</div>
			<div class="description_content block_js">
				<div class="row nabor">
					<div class="col-sm-24 nabor-inner">
					<div class="nabor-main">
						<div class="one-item block_img_js">
							<div class="item-top-part">
								<div class="item-top-part-inner">
                            <?
							if ((isset( $arResult["ELEMENT"]["DETAIL_PICTURE"]["src"] ) && !empty( $arResult["ELEMENT"]["DETAIL_PICTURE"]["src"] )))
							{
							?>
                            <img class="img-responsive big_img_js"
										src="<?=$arResult["ELEMENT"]["DETAIL_PICTURE"]["src"]?>"
										title="<?=$arResult["ELEMENT"]["NAME"]?>"
										alt="<?=$arResult["ELEMENT"]["NAME"]?>"
										height="<?=$arResult["ELEMENT"]["DETAIL_PICTURE"]["height"]?>"
										width="<?=$arResult["ELEMENT"]["DETAIL_PICTURE"]["width"]?>">
                            <?
																												}
																												else
																												{
																													?>

                            <img class="img-responsive big_img_js"
										src="/upload/no_photo.jpg"
										title="<?=$arResult["ELEMENT"]["NAME"]?>"
										alt="<?=$arResult["ELEMENT"]["NAME"]?>"
										height="<?=$arParams["LIST_WIDTH_MEDIUM"]?>"
										width="<?=$arParams["LIST_HEIGHT_MEDIUM"]?>">

                            <?
																												}
																												?>
                   </div>
							</div>
							<div class="item-bottom-part">
								<div class="buy_now_bottom_inner">
								<?if(isset($arResult['BRANDS'][$arResult['ELEMENT_ID']])): ?>
									<p class="item_name brand-nabor">
										<a onclick=""
											href="<?=$arResult['BRANDS'][$arResult['ELEMENT_ID']]['DETAIL_PAGE_URL']?>"
											title="<?=$arResult['BRANDS'][$arResult['ELEMENT_ID']]['NAME']?>"><?=$arResult['BRANDS'][$arResult['ELEMENT_ID']]['NAME']?></a>
									</p>
								<?endif; ?>

									<p class="item_second_name">
										<i><?=$arResult["ELEMENT"]["NAME"]?></i>
									</p>
                            <?$frame = $this->createFrame()->begin("");?>
                            <div>
                            <?if($arResult["ELEMENT"]["PRICE_VALUE"]==$arResult["ELEMENT"]["PRICE_DISCOUNT_VALUE"]):?>
                                <p class="item_price"><?=$arResult["ELEMENT"]["PRICE_PRINT_VALUE"]?></p>
                            <?else:?>
                                <p class="item_price"><?=$arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"]?></p>
										<p class="item_price_big"><?=$arResult["ELEMENT"]["PRICE_PRINT_VALUE"]?></p>
                            <?endif;?>
                            </div>
                            <?$frame->end();?>
                        </div>
							</div>
						</div>

					</div>

<div id="nabor-scroll">
<div class="nabor-scroll-inner">
<div class="viewport">
<div class="overview wrap-nabor-items" data-role="set-items">

	<?foreach($arResult["SET_ITEMS"]["DEFAULT"] as $key => $arItem):?>

			<div class="nabor-item ibuy"
								data-id="<?=$arItem["ID"]?>"
								data-price="<?=$arItem["PRICE_DISCOUNT_VALUE"]?>"
								data-old-price="<?=$arItem["PRICE_VALUE"]?>"
								data-diff-price="<?=$arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"]?>"
								data-quantity="<?=$arItem["BASKET_QUANTITY"]; ?>">

								<div class="nabor-item-inner">

								<div class="item-top-part">

							<?if($arItem['PRICE_DISCOUNT_PERCENT']):?>
                            <span class="item-discount">
                                <span class="item-discount-inner">
                                    -<?=$arItem['PRICE_DISCOUNT_PERCENT']?>%
                                </span>
                            </span>
                            <?endif;?>


									<div class="item-top-part-inner">
										<div class="item-wrap-img">
										<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>">
								<?if ($arItem["DETAIL_PICTURE"]["src"]):?>
									<img src="<?=$arItem["DETAIL_PICTURE"]["src"]?>"
												class="img-responsive" alt="">
								<?else:?>
									<img src="/upload/no_photo.jpg"
												class="img-responsive" alt="">
								<?endif;?>
								</a>
							</div>
									</div>




								</div>

								<div class="item-bottom-part">
									<div class="buy_now_bottom_inner">
									<?if(isset($arResult['BRANDS'][$arItem["ID"]])): ?>
										<p class="item_name brand-item-nabor">
											<a onclick=""
												href="<?=$arResult['BRANDS'][$arItem["ID"]]['DETAIL_PAGE_URL']?>"
												title="<?=$arResult['BRANDS'][$arItem["ID"]]['NAME']?>"><?=$arResult['BRANDS'][$arItem["ID"]]['NAME']?></a>
										</p>
									<?endif; ?>
										<p class="item_second_name">
											<a class="item-title" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><i><?=$arItem["NAME"]?></i></a>
										</p>
                            <?$frame = $this->createFrame()->begin("");?>
                            <div>

                            <?if($arItem["PRICE_VALUE"]==$arItem["PRICE_DISCOUNT_VALUE"]):?>
                                <p class="item_price"><?=$arItem["PRICE_PRINT_VALUE"]?></p>
                            <?else:?>
                                <p class="item_price"><?=$arItem["PRICE_PRINT_DISCOUNT_VALUE"]?></p>
											<p class="item_price_big"><?=$arItem["PRICE_PRINT_VALUE"]?></p>
                            <?endif;?>
                            </div>
										<div class="cnt">
								<?=$arItem["BASKET_QUANTITY"]; ?> <span><?=$arItem["MEASURE"]["SYMBOL_RUS"]; ?></span>
										</div>
										<div class="check">
											<div class="checking"></div>
										</div>
                            <?$frame->end();?>
                        </div>
                        </div>
								</div>
							</div>

					<?endforeach?>

					</div>
					</div>
			     </div>
            </div>



            		<div class="basket-block">
            		<div class="basket-block-inner">
		                <div class="basket-price">
		                	<span><?=GetMessage("B2BS_CATALOG_NABOR_SUM")?></span>
		                	<div id="nabor-basket-price" data-role="set-price"><span><?=$arResult['SUM']?></span><?=$arResult['CUR']?></div>
		                </div>
		                <div class="nabor-basket-botton"><?=GetMessage("B2BS_CATALOG_NABOR_BASKET")?>
</div>
		                </div>
		            </div>



</div>

</div>

				</div>
			</div>
		</div>
</div>
<script type="text/javascript">
 BX.ready(function(){
		$('.viewport').niceScroll({emulatetouch: true, bouncescroll: false, cursoropacitymin: 1, enabletranslate3d: true, cursorfixedheight: '100', scrollspeed: 25, mousescrollstep: 10,  cursorwidth: '8px', horizrailenabled: true, cursordragontouch: true});
 });
</script>