<?
if (! defined( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true) die();

$this->IncludeLangFile( 'template.php' );
$cartId = $arParams['cartId'];
require (realpath( dirname( __FILE__ ) ) . '/top_template.php');

if ($arParams["SHOW_PRODUCTS"] == "Y" && $arResult['QNT'] > 0)
{
?>
	<div data-role="basket-item-list" class="bx-basket-item-list window-without-bg window_basket">
		<div class='modal-block modal-block_basket'>
			<div class='modal-block-inner'>
                <span class="modal-triangle"></span>
				<span class='close'></span>
				<div id="<?=$cartId?>products" class="bx-basket-item-list-container modal-content">
                    <div class="basket_item_wrapper">
                        <div class="basket-item-img">
                            <div class="basket-item-img-wrap">
                                <img src="/bitrix/templates/b2b_shop/img/basket_okey.png">
                            </div>
                        </div>
                        <div>
                        <div id="basket-products-list"></div>
				<?
				foreach ( $arResult["CATEGORIES"] as $category => $items )
				{
					if (empty( $items ))
					{
						continue;
					}
					foreach ($items as $v)
					{
						if ($v["CAN_BUY"] == "Y" && $v["DELAY"] == "N" && $v['SUBSCRIBE'] == "N")
						{
						?>

                                <div class="bx-basket-item-list-item basket-item item-bg-1" data-prod="<?=$v['ID']?>-<?=$v['QUANTITY']?>">
                                    <div>
                                        <span class="basket_text"><?=GetMessage('TSB1_PRODUCT_L')?></span>
                                        <a href="<?=$v["DETAIL_PAGE_URL"]?>" class="item-tovar" title="<?=($arResult["NAMES"][$v['PRODUCT_ID']])?$arResult["NAMES"][$v['PRODUCT_ID']]:$v['NAME']?>">
                                            <?=($arResult["NAMES"][$v['PRODUCT_ID']])?$arResult["NAMES"][$v['PRODUCT_ID']]:$v['NAME']?>
                                        </a>
                                        <span class="basket_text"><?=GetMessage('TSB1_PRODUCT_OKEY')?></span>
                                    </div>
                                </div>

						<?
						}
					}
				}
				?>
                        <div class="bx-basket-item-list-item-price-summ basket-total">
                            <?=GetMessage("TSB1_QUANTITY")?>
                            <span class="basket-total_bold">
                                        <?=$arResult['QNT']?>&nbsp<?=GetMessage('TSB1_PRODUCT') ?><? if($arResult['QNT'] >= 5) { echo GetMessage('TSB1_WORD_END3'); } elseif ($arResult['QNT'] >1 && $arResult['QNT'] < 5) { echo GetMessage('TSB1_WORD_END2'); } ?>
                                <?=GetMessage("TSB1_BASKET_SUM")?>
                                <?=$arResult["COST"]?>
                                    </span>
                        </div>
                        </div>
                    </div>
				</div>
				<?if ($arParams["PATH_TO_ORDER"] && $arResult["CATEGORIES"]["READY"])
				{?>
					<!--<a href="<?/*=$arParams["PATH_TO_ORDER"]*/?>" class="basket-btn-order">
						<span class="basket-btn-order-inner">
							<?/*=GetMessage("TSB1_2ORDER")*/?>
						</span>
					</a>-->
				<?}?>
			</div>
		</div>
	</div>
<?
}