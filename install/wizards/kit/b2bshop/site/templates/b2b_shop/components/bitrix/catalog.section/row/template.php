<?

use Bitrix\Main\Loader;

if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true )
	die();

global $kitSeoMetaH1;
global $kitSeoMetaBottomDesc;


$colorCode = ($arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams['COLOR_IN_PRODUCT_CODE']) ? $arParams['COLOR_IN_PRODUCT_CODE'] : $arParams["OFFER_COLOR_PROP"];

if( isset( $arResult["NAME"] ) && $arResult["NAME"] )
{
	?>
	<div class="col-sm-24 sm-padding-right-no">
		<div class="inner_title_brand">
			<h1 class="text">
				<?
				if( $kitSeoMetaH1 )
				{
					echo $kitSeoMetaH1;
				}
				elseif( $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'] )
				{
					echo $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'];
				}
				else
				{
					echo $arResult["NAME"];
				}
				?>
			</h1>
		</div>
		<?
		global $kitSeoMetaTopDesc;
		if( isset( $kitSeoMetaTopDesc ) && !empty( $kitSeoMetaTopDesc ) )
		{
			echo $kitSeoMetaTopDesc;
		}
		?>
	</div>
	<?
}

if( $arParams['SEOMETA_TAGS'] == 'TOP' || $arParams['SEOMETA_TAGS'] == 'ALL' )
{
	$APPLICATION->IncludeComponent( "kit:seo.meta.tags", "",
			Array(
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"CNT_TAGS" => "",
					"IBLOCK_ID" => $arParams['IBLOCK_ID'],
					"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
					"INCLUDE_SUBSECTIONS" => $arParams['INCLUDE_SUBSECTIONS'],
					"SECTION_ID" => $arResult['ID'],
					"SORT" => "CONDITIONS",
					"SORT_ORDER" => "asc"
			)
	);
}

if(Loader::includeModule('kit.b2bshop'))
{
	$APPLICATION->IncludeFile( SITE_DIR . "include/b2b_page_sort_catalog.php", Array(
			$arResult,
			$arParams,
			"top",
			$templateName,
			), Array(
					"MODE" => "php"
					) );
}
else
{
	$APPLICATION->IncludeFile( SITE_DIR . "include/miss_page_sort_catalog.php", Array(
			$arResult,
			$arParams,
			"top"
	), Array(
			"MODE" => "php"
	) );
}

$colorCode = ($arParams["COLOR_IN_PRODUCT"] == 'Y' && isset( $arParams['COLOR_IN_PRODUCT_CODE'] ) && !empty( $arParams['COLOR_IN_PRODUCT_CODE'] )) ? $arParams['COLOR_IN_PRODUCT_CODE'] : $arParams["OFFER_COLOR_PROP"];
?>
<div class="col-sm-24 sm-padding-right-no">
	<div id="section_list">
		<?
		$rand = $arResult["RAND"];
		?>
		<script type="text/javascript">
		$(function() {
			var msList = new msListProduct({
				"arImage" : <?=CUtil::PhpToJSObject($arResult['MORE_PHOTO_JS'], false, true); ?>,
				"listBlock" : "#section_list",
				"listItem" : ".one-item",
				"articles" : <?=CUtil::PhpToJSObject($arResult['ARTICLES'], false, true); ?>,
				"currentOffers" : <?=CUtil::PhpToJSObject($arResult['FIRST_OFFERS'], false, true); ?>,
				"basket_url" : <? echo CUtil::PhpToJSObject($arResult['OFFER_ADD_URL'], false, true); ?>,
				"listItemSmalImg" : ".small_img_js",
				"mainItemImage" : ".big_img_js",
				"prop" : "ul.offer-props",
				"child_prop" : "li",
				"basket":".b2b__add-cart",
				"offer_available_id" : <? echo CUtil::PhpToJSObject($arResult['OFFER_AVAILABLE_ID'], false, true); ?>,
				"prices" : <? echo CUtil::PhpToJSObject($arResult['PRICES_JS'], false, true); ?>,
				"prop_color" : ".offer_prop_<?=$colorCode?>",
				"class_li_active" : ".li-active",
				"class_li_disable" : ".li-disable",
				"class_li_available" : ".li-available",
				"sizes":<?=CUtil::PhpToJSObject(array('SMALL'=>array('WIDTH'=>$arParams["LIST_WIDTH_SMALL"],'HEIGHT'=>$arParams["LIST_HEIGHT_SMALL"]),'MEDIUM'=>array('WIDTH'=>$arParams["LIST_WIDTH_MEDIUM"],'HEIGHT'=>$arParams["LIST_HEIGHT_MEDIUM"]),'RESIZE'=>$ResizeMode), false, true); ?>,
				"listItemOpen" : ".item_open .item-top-part",
				"items":<?=CUtil::PhpToJSObject($arResult['ITEMS_AJAX'], false, true); ?>,
				"openItem":"#section_list .item",
				"btnLeft" : ".bnt_left",
				"btnRight" : ".bnt_right",
				"quantityInput":".b2b__quantity__input",
				"SiteDir":"<?=SITE_DIR?> ?>",
				"basketWrapper":".wrap-basket",
				"FilterClose":".block_form_filter .filter_block",
				"ajax_filter_path":"include/ajax/filter.php",
				"Url":"<?=$APPLICATION->GetCurPage()?>",
				'bigData': <?=CUtil::PhpToJSObject($arResult['BIG_DATA'])?>,
				'quantity':<?=CUtil::PhpToJSObject($arResult['QUANTITY'], false, true); ?>,
			});
		})
		</script>
		<?
		if( !empty( $arResult["ITEMS"] ) )
		{
			$k = 0;
			$strElementEdit = CIBlock::GetArrayByID( $arParams["IBLOCK_ID"], "ELEMENT_EDIT" );
			$strElementDelete = CIBlock::GetArrayByID( $arParams["IBLOCK_ID"], "ELEMENT_DELETE" );
			$arElementDeleteParams = array(
					"CONFIRM" => GetMessage( 'CT_BCS_TPL_ELEMENT_DELETE_CONFIRM' )
			);
			?>
			<div class="b2b__catalog">
				<div class="b2b__header__name">
					<div class="b2b__header__title">
						<p class="b2b__header__title_text">
							<?=GetMessage('B2B_NAME')?>
						</p>
					</div>
					<?
					foreach( $arResult["ITEMS"] as $arItem )
					{
						$countItem = 0;
						$ID = $arItem["ID"];
						$firstColor = $arItem["FIRST_COLOR"];
						$item['MIN_PRICE'] = $arItem["MIN_PRICE"];
						$this->AddEditAction( $arBlockItem['ID'], $arBlockItem['EDIT_LINK'], $strElementEdit );
						$this->AddDeleteAction( $arBlockItem['ID'], $arBlockItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams );
						$strMainID = $this->GetEditAreaId( $arItem['ID'] );
						$article = $arResult['ARTICLES'][$arResult['FIRST_OFFERS'][$ID]];

						?>
						<div class="b2b__header__name__value" id="<?= $strMainID; ?>">
							<div class="b2b__header__name__value_wrap b2b__header__name__<?=$arItem['ID']?>">
								<a onclick="" href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="b2b__header__name__value__name">
									<?=$arItem['NAME'] ?>
								</a>
								<span class="b2b_quick_view quick_view<?=$arResult['RAND']?>" data-index="<?=$arItem['COUNTER']?>"></span>
								<p class="b2b__header__name__article">
									<span class="b2b__header__name__article_art" style="<?=($article)?'':'display:none'?>">
										<?=GetMessage('B2B_ARTICLE')?>
									</span>
									<span class="b2b__header__name__article_artval">
										<?=$article?>
									</span>
								</p>
								<p class="b2b__header__available" style="<?=(!in_array($arResult['FIRST_OFFERS'][$ID],$arResult['OFFER_AVAILABLE_ID']))?'':'display:none'?>">
									<?=GetMessage('B2B_AVAILABLE')?>
									<span class="b2b__header__available__quantity">
										<?=($arResult['QUANTITY'][$arResult['FIRST_OFFERS'][$ID]])?' ('.GetMessage('B2B_QUANTITY').' '.$arResult['QUANTITY'][$arResult['FIRST_OFFERS'][$ID]].')':''?>
									</span>
								</p>
								<p class="b2b__header__available b2b__header__no_available" style="<?=(!in_array($arResult['FIRST_OFFERS'][$ID],$arResult['OFFER_AVAILABLE_ID']))?'display:none':''?>">
									<?=GetMessage('B2B_NO_AVAILABLE')?>
								</p>
							</div>
						</div>
						<?
					}
					?>
				</div>
				<div class="b2b__header__props">
					<div class="viewport">
						<div class="b2b__header__row-title">
							<?php
							if($arParams['OFFER_TREE_PROPS'])
							{
							?>
								<div class="b2b__header__props__params">
									<div class="b2b__header__title">
										<p class="b2b__header__title_text">
											<?=GetMessage('B2B_PROPS')?>
										</p>
									</div>
								</div>
							<?php
							}
							foreach ($arResult['PRICE_NAMES'] as $key=>$price)
							{
								?>
								<div class="b2b__header__props__prices <?=($key == $arResult['MIN_PRICE'])?'b2b__header__props__prices__active':''?>">
									<div class="b2b__header__title">
										<p class="b2b__header__title_text b2b__header__title_text-price">
											<?=$price?>
										</p>
									</div>
								</div>
								<?php
							}
							?>
						</div>
						<div class="b2b__header__row-props">
							<?
							foreach( $arResult['ITEMS'] as $arItem )
							{
								$countItem = 0;
								$ID = $arItem["ID"];
								$firstColor = $arItem["FIRST_COLOR"];
								$item['MIN_PRICE'] = $arItem["MIN_PRICE"];
								$this->AddEditAction( $arBlockItem['ID'], $arBlockItem['EDIT_LINK'], $strElementEdit );
								$this->AddDeleteAction( $arBlockItem['ID'], $arBlockItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams );
								$strMainID = $this->GetEditAreaId( $arItem['ID'] );
								?>
								<div class="b2b__header__row-props__one-item" data-id="<?=$arItem['ID']?>">
									<div class="b2b__header__props__params">
										<?php
										if($arParams['OFFER_TREE_PROPS'])
										{
										?>
											<div class="b2b__header__props__value b2b__header__params__props__value" id="<?= $strMainID; ?>">
												<?
												if( isset( $arItem["OFFER_TREE_PROPS"] ) && is_array( $arItem["OFFER_TREE_PROPS"] ) )
												{
													foreach( $arItem["OFFER_TREE_PROPS"] as $codeProp => $arProperties )
													{
														if( $arProperties )
														{
															if( $codeProp == $colorCode )
															{
																$ClassBlock = 'detail_color';
															}
															else
															{
																$ClassBlock = 'detail_size';
															}
															?>
															<div class="<?=$ClassBlock ?> js_detail_prop">
																<?
																if( isset( $arResult["PROP_NAME"][$codeProp] ) )
																{
																?>
																	<span class="detail_prop_title" title="<?=$arResult["PROP_NAME"][$codeProp]?>">
																		<?=GetMessage("B2BS_CATALOG_DETAIL_CHANGE")?> <?=$arResult["PROP_NAME"][$codeProp]?>:
																	</span>
																<?} ?>
																<ul class="offer-props offer_prop_<?=$codeProp?>" title="<?=$arResult["PROP_NAME"][$codeProp]?>">
																	<?
																	$i = 1;
																	foreach( $arProperties as $xmlID => $arProp )
																	{
																		if( $codeProp == $colorCode)
																		{
																			if( $arProp["PIC"] )
																			{
																				$style = 'background: url(' . $arProp["PIC"]["SRC"] . ') 50% 50% no-repeat';
																			}
																			else
																			{
																				$style = 'background:' . $arProp["UF_DESCRIPTION"];
																			}
																			$content = "";
																			$class = "item";
																		}
																		else
																		{
																			$style = "";
																			$class = "item";
																			$content = $arProp["UF_NAME"];
																		}
																		?>
																		<li
																			title="<?=$arProp["UF_NAME"]?>"
																			data-offer="<?=implode(",", $arItem["OFFERS_ID"][$codeProp][$xmlID])?>"
																			data-xml="<?=$xmlID?>"
																			class="<?=$class ?> <?=$arItem['LI'][$xmlID] ?>"
																		>
																			<span title="<?=$arProp["UF_NAME"]?>" style="<?=$style ?>">
																				<?=$content ?>
																			</span>
																		</li>
																		<?
																		++$i;
																	}
																	?>
																</ul>
															</div>
														<?
														}
													}
												}
												?>
											</div>
										<?}?>
									</div>
									<?php
									foreach ($arResult['PRICE_NAMES'] as $key=>$price)
									{
										?>
										<div class="b2b__header__props__prices <?=($arResult['MIN_PRICE'] == $key)?'b2b__header__props__prices__active':''?>">
											<div class="b2b__header__props__value">
												<p class="b2b-catalog__price price-code-<?=$key?>">
													<?=$arResult['PRICES_JS'][$arItem['FIRST_OFFER']][$key]['TEXT']?>
												</p>
											</div>
										</div>
										<?php
									}
									?>
								</div>
							<?}?>
						</div>
					</div>
				</div>
				<div class="b2b__header__quantity">
					<div class="b2b__header__title">
						<p class="b2b__header__title_text"><?=GetMessage('B2B_QUANTITY')?></p>
					</div>
					<?
					foreach( $arResult["ITEMS"] as $arItem )
					{
						$countItem = 0;
						$ID = $arItem["ID"];
						$firstColor = $arItem["FIRST_COLOR"];
						$item['MIN_PRICE'] = $arItem["MIN_PRICE"];
						$this->AddEditAction( $arBlockItem['ID'], $arBlockItem['EDIT_LINK'], $strElementEdit );
						$this->AddDeleteAction( $arBlockItem['ID'], $arBlockItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams );
						$strMainID = $this->GetEditAreaId( $arItem['ID'] );
						$article = $arItem["PROPERTIES"]["CML2_ARTICLE"]['VALUE'];
						?>
						<div class="b2b__header__quantity__value" id="<?= $strMainID; ?>">
							<div class="wrap-basket wrap-basket-<?=$arItem['ID']?>" data-id="<?=$arItem['ID']?>" style="<?=(!in_array($arResult['FIRST_OFFERS'][$ID],$arResult['OFFER_AVAILABLE_ID']))?'':'display:none'?>">
								<div class="wrap_input">
									<span class="minus">
										&ndash;
									</span>
                                    <input
                                            class="b2b__quantity__input"
                                            id="QUANTITY_<?=$arItem["ID"]?>" type="text" placeholder=""
                                            name="QUANTITY_<?=$arItem["ID"]?>"
                                            value="<?=($_SESSION['BLANK_IDS'][$arItem['FIRST_OFFER']] > 0)?$_SESSION['BLANK_IDS'][$arItem['FIRST_OFFER']]['QNT']:1?>"
                                            maxlength="4"
                                    >
									<span class="plus">
										+
									</span>
								</div>
								<span class="b2b__add-cart"></span>
							</div>
						</div>
						<?
					}?>
				</div>
			</div>
		<?
}
		else
		{
			echo GetMessage( "B2BS_CATALOG_NOTFOUND" );
		}
		?>
	</div>
</div>



<?
if(Loader::includeModule('kit.b2bshop'))
{
	$APPLICATION->IncludeFile(SITE_DIR."include/b2b_page_sort_catalog_bottom.php",
			Array($arResult, $arParams, "bottom"),
			Array("MODE"=>"php")
			);
}
else
{
	$APPLICATION->IncludeFile(SITE_DIR."include/miss_page_sort_catalog.php",
			Array($arResult, $arParams, "bottom"),
			Array("MODE"=>"php")
			);
}
// SEOMETA START
if( $arResult["~DESCRIPTION"] || (isset( $kitSeoMetaBottomDesc ) && !empty( $kitSeoMetaBottomDesc )) )
{
	?>
<div class="col-sm-24 sm-padding-right-no">
	<div class="section_description">
		<?
	if( !isset( $kitSeoMetaBottomDesc ) || empty( $kitSeoMetaBottomDesc ) )
	{
		echo $arResult["~DESCRIPTION"];
	}
	else
	{
		echo $kitSeoMetaBottomDesc;
	}
	?>
	</div>
</div>
<?

}

if( $arParams['SEOMETA_TAGS'] == 'BOTTOM' || $arParams['SEOMETA_TAGS'] == 'ALL' )
{
	$APPLICATION->IncludeComponent( "kit:seo.meta.tags", "",
			Array(
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"CNT_TAGS" => "",
					"IBLOCK_ID" => $arParams['IBLOCK_ID'],
					"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
					"INCLUDE_SUBSECTIONS" => $arParams['INCLUDE_SUBSECTIONS'],
					"SECTION_ID" => $arResult['ID'],
					"SORT" => "CONDITIONS",
					"SORT_ORDER" => "asc"
			) );
}
$mess = array(
	'B2B_QUANTITY' => GetMessage("B2B_QUANTITY"),
);
?>
<script type="text/javascript">
	BX.message(<?=\Bitrix\Main\Web\Json::encode($mess)?>);
height_catalog_row();
height_catalog_title();
	$('.b2b__catalog .viewport').niceScroll({cursorcolor: '#ced0d3' ,emulatetouch: true, cursoropacitymax:1,cursoropacitymin:1,  cursorfixedheight: '100', enabletranslate3d: true, scrollspeed: 25, mousescrollstep: 10, cursordragontouch: true});
</script>