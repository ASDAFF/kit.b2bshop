<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
\Bitrix\Main\Loader::includeModule("kit.b2bshop");
$Og = $arResult['OG'];
$FirstOffer=$arResult['FIRST_OFFER'];
$colorCode = ($arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams['COLOR_IN_PRODUCT_CODE']) ? $arParams['COLOR_IN_PRODUCT_CODE'] : $arParams["OFFER_COLOR_PROP"];
$codeBrand = $arParams["MANUFACTURER_LIST_PROPS"];
$colorImage = ($arParams["COLOR_FROM_IMAGE"]=="Y")?1:0;

$firstColor = $arResult["FIRST_COLOR"];
$siteID = SITE_ID;
$boolSize = false;
$noPhoto = false;

$showSizeUrl = false;

$APPLICATION->IncludeComponent(
		"coffeediz:schema.org.Product",
		"",
		$arResult['MICRORAZMETKA']
		);
?>
<script type="text/javascript">
	$(function() {
		var msDetail = new msDetailProduct({
			"OffersProps":<? echo CUtil::PhpToJSObject($arResult['OFFERS_PROPS'], false, true); ?>,
			"prices" : <? echo CUtil::PhpToJSObject($arResult['PRICES_JS'], false, true); ?>,
			"offer_available_id" : <? echo CUtil::PhpToJSObject($arResult['OFFER_AVAILABLE_ID'], false, true); ?>,
			"video" : <? echo CUtil::PhpToJSObject($arResult['VIDEO'], false, true); ?>,
			"SubscribeId":".detail_page_wrap.no_preview #subcribe",
			"SITE_ID" : "<?=$siteID?>",
			"COLOR_UL":"#offer_prop_<?=$colorCode?>",
			"COLOR_UL_HOR":<?=$arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"]?>,
			"ModifSizeCol":".modification .sizes-col",
			"PRODUCT_ID" : <?=$arResult["ID"]?>,
			"OFFER_ID" : <?=$FirstOffer?>,
			"DETAIL_PAGE_URL" : "<?=$arResult['DETAIL_PAGE_URL']?>",
			"image" : <? echo CUtil::PhpToJSObject($arResult['MORE_PHOTO_JS'], false, true); ?>,
			"image2" : <? echo CUtil::PhpToJSObject($arResult['MORE_PHOTO_JS2'], false, true); ?>,
			"image2need" : <?=CUtil::PhpToJSObject($arResult['COLOR_OFFER_FROM_IMAGE'])?>,
			"Wrapper":".no_preview",
			"TemplatePath" : "<?=SITE_TEMPLATE_PATH?>",
			"main" : ".detail_page_wrap.no_preview",
			"prop" : ".detail_page_wrap.no_preview ul.offer-props",
			"child_prop" : "li",
			"prop_color" : ".detail_page_wrap.no_preview #offer_prop_<?=$colorCode?>",
			"class_li_active" : ".li-active",
			"class_li_disable" : ".li-disable",
			"class_li_available" : ".li-available",
			"image_container" : ".detail_page_wrap.no_preview .wrap_pic_js",
			"price_container" : ".detail_block_price_cont",
			"available_container" : ".subscribe_cont",
			"quantity_input" : ".block_quantity input",
			"add_url" : ".detail_page_wrap.no_preview .btn_add_basket",
			"add_wish" : ".detail_page_wrap.no_preview .btn_add_wish",
			"js_slider_pic_small":".js_slider_pic_small",
			"add_subscribe" : ".detail_page_wrap.no_preview .subscribe_product_form .back_call_submit",
			"form_subscribe" : ".subscribe_new_form",
			"text_subscribe" : ".subscribe_new_form input[type=text]",
			"submit_subscribe" : ".subscribe_new_form input[type=submit]",
			"basket_url" : <? echo CUtil::PhpToJSObject($arResult['OFFER_ADD_URL'], false, true); ?>,
			"wish_url" : <? echo CUtil::PhpToJSObject($arResult['OFFER_DELAY_URL'], false, true); ?>,
			"subscribe_url" : <? echo CUtil::PhpToJSObject($arResult['OFFER_SUBSCRIBE_URL'], false, true); ?>,
			"props_name" : <? echo CUtil::PhpToJSObject($arResult['OFFER_TREE_PROPS_NAME'], false, true); ?>,

			"forgot_select_description" : "<?=GetMessage("B2BS_CATALOG_DETAIL_FORGOT_SELECT")?>",

			"ModificationToggle" : ".modification .button_js",
			"ModificationTextToggle" : ".modification-under .button_js",
			"ModificationMoreText" : ".modification .more-text",
			"ModificationShowAll" : ".modification .show-all",
			"ModificationMinus" : ".modification .sizes-block-cnt-minus",
			"ModificationPlus" : ".modification .sizes-block-cnt-plus",
			"ModificationAddBasket" : ".modification .basket-botton",

			"PlayVideo" : ".no_preview .detail_pic_small .PlayVideoProduct",
			"CloseVideo" : ".no_preview .detail_pic_small .item",
			"contBasket" : ".bx-basket-fixed",
			"basketUrl" : "<?=$APPLICATION->GetCurPage()?>",
			"contPrevNext" : ".detail_page_wrap.no_preview .block_title_list",
			"contPrev" : ".list_left",
			"contNext" : ".list_right",
			"contSelectProps" : ".detail_page_wrap.no_preview .kit_order_phone form input:submit",

			"discountPrice" : ".discount_price",
			"oldPrice" : ".old_price",
			"download" : "<?=$arResult["IS_DOWNLOAD"]?>",
			"ajax_file" : "<?=$templateFolder?>/ajax.php",

			'btn_basket':'.detail_page_wrap.no_preview .btn_add',
			'btn_class':'btn_add_basket',
			'btn_change_class':'btn-changed',
			'modalUrl' : '<?php echo SITE_DIR.'include/ajax/add_wish_popup.php';?>',
			'modalData' : '<?php echo $arResult['MODAL_DATA'];?>',
			'basketPath' : '<?=(\Bitrix\Main\Config\Option::get('kit.b2bshop','URL_PATH','ORDER') == 'ORDER')
				?\Bitrix\Main\Config\Option::get('kit.b2bshop','URL_ORDER',''):\Bitrix\Main\Config\Option::get('kit.b2bshop','URL_CART','')?>',
			"added_to_basket" : <? echo CUtil::PhpToJSObject($arResult['ADDED_TO_BASKET'], false, true); ?>,
		})
	})
</script>
<div class="col-sm-8 sm-padding-left-no">
	<div class="wrap_pic_js">
		<div class="detail_big_pic" data-rnd="<?=$arResult["RAND"]?>">
			<?if(isset($arResult['VIDEO']) && is_array($arResult['VIDEO']) && count($arResult['VIDEO'])>0)
			{
				foreach($arResult['VIDEO'] as $Video)
				{
				?>
					<div class="detail_big_video" style="position:absolute;display:none;width: 100%;height: 100%;">
						<?=$Video?>
					</div>
				<?}
			}
			?>
			<?if(count($arResult["MORE_PHOTO_JS"][$firstColor]["MEDIUM"])>0)
			{
				$firstImg = true;
				foreach($arResult["MORE_PHOTO_JS"][$firstColor]["MEDIUM"] as $i=>$arMediumImg)
				{
					$arBigImg = $arResult["MORE_PHOTO_JS"][$firstColor]["BIG"][$i];
					?>
					<a class="big_foto item" href="<?=$arBigImg["src"]?>" onclick="return false;" alt="" title="" style="display:<?if($firstImg):?>block<?else:?>none<?endif;?>">
						<img class="img-responsive" src="<?=$arMediumImg["src"]?>" width="<?=$arMediumImg["width"]?>" height="<?=$arMediumImg["height"]?>" alt="<?=(isset($arResult["MORE_PHOTO_JS"][$firstColor]['TITLE'][$i]) && !empty($arResult["MORE_PHOTO_JS"][$firstColor]['TITLE'][$i]))?$arResult["MORE_PHOTO_JS"][$firstColor]['TITLE'][$i]:$arResult["DETAIL_PICTURE"]["ALT"]?>" title="<?=(isset($arResult["MORE_PHOTO_JS"][$firstColor]['TITLE'][$i]) && !empty($arResult["MORE_PHOTO_JS"][$firstColor]['TITLE'][$i]))?$arResult["MORE_PHOTO_JS"][$firstColor]['TITLE'][$i]:$arResult["DETAIL_PICTURE"]["TITLE"]?>" />
					</a>
					<?
					$firstImg = false;
				}
			}
			else
			{
				$noPhoto = true;
				?>
				<img class="img-responsive" src="/upload/no_photo.jpg" width="<?=$arParams["DETAIL_WIDTH_MEDIUM"]?>" height="<?=$arParams["DETAIL_HEIGHT_MEDIUM"]?>" alt="" title="" />
			<?}?>
			<?if($arResult["IS_DOWNLOAD"]=="Y" && !$noPhoto):?>
				<a class="download_pic" href="#" title="<?=GetMessage("B2BS_CATALOG_DETAIL_DOWNLOAD")?>" onclick="download_img(this);" target="_blank"></a>
			<?endif;?>
		</div>
			<?
			if(count($arResult["MORE_PHOTO_JS"][$firstColor]["SMALL"])>1||count($arResult['PROPERTIES']['VIDEO']['VALUE'])>0||count($arResult['ADD_PICTURES'])>0)
			{
			$firstImg = true;
			?>
				<div class="wrap_detail_pic_small">
					<div class="js_slider_pic_small detail_pic_small">
						<?if(isset($arResult['VIDEO']) && is_array($arResult['VIDEO']) && count($arResult['VIDEO'])>0)
						{?>
							<?foreach($arResult['VIDEO'] as $key=>$Video)
							{?>
								<div class="item-video">
									<img class="img-responsive PlayVideoProduct" src="<?=SITE_TEMPLATE_PATH?>/site_files/img/miss_video-play.jpg" width="<?=$arParams["DETAIL_WIDTH_SMALL"]?>" height="<?=$arParams["DETAIL_HEIGHT_SMALL"]?>" data-key="<?=$key?>"/>
								</div>
							<?}
						}
						if(sizeof($arResult["MORE_PHOTO_JS"][$firstColor]["SMALL"])>1)
						{
							foreach($arResult["MORE_PHOTO_JS"][$firstColor]["SMALL"] as $i=>$arSmallImg)
							{
								$arMediumImg = $arResult["MORE_PHOTO_JS"][$firstColor]["MEDIUM"][$i];
								$arBigImg = $arResult["MORE_PHOTO_JS"][$firstColor]["BIG"][$i];
								?>
								<a class="item fancybox_little_img <?if($firstImg):?>item_active<?endif?>" rel="gallery_no_preview" onclick="" href="<?=$arBigImg['src']?>" title="">
									<img class="img-responsive" src="<?=$arSmallImg["src"]?>" width="<?=$arSmallImg["width"]?>" height="<?=$arSmallImg["height"]?>" title="" alt=""/>
								</a>
								<?
								$firstImg = false;
							}
						}
						?>
					</div>
				</div>
			<?}?>
	</div>
</div>
<div class="col-sm-16">
	<div class="row">
		<div class="col-sm-24 sm-padding-no js-title">
			<div class="detail_block_title">
				<div class="row">
					<div class="col-sm-16">
						<div class="block_title_left">
							<h1 class="detail_title">
							<?if($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
							{
								echo $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'];
							}
							else
							{
								echo $arResult["NAME"];
							}
							?>
							</h1>
							<h3 class="detail_title_second">
								<?=$arResult["BRAND"]["NAME"]?>
							</h3>
						</div>
					</div>
					<div class="col-sm-5 sm-padding-left-no hidden-xs">
						<?
						$APPLICATION->IncludeComponent(
							"bitrix:asd.share.buttons",
							"ms_catalog",
							array(
								"ASD_ID" => "",
								"ASD_TITLE" => $arResult["NAME"],
								"ASD_URL" => $arResult["DETAIL_PAGE_URL"],
								"ASD_PICTURE" => $Og->getField('og:image'),
								"ASD_TEXT" => $Og->getField('og:description'),
								"ASD_LINK_TITLE" => "Share in #SERVICE#",
								"ASD_SITE_NAME" => "Miss-Shop",
								"ASD_INCLUDE_SCRIPTS" => array(
								),
								"SCRIPT_IN_HEAD" => "N"
							),
							false
						);?>
					</div>
					<div class="col-sm-3 sm-padding-left-no">
						<div class="block_title_list" id="prev_next_product">
							<ul>
								<li class="wrap_list_left"><span class="list_left"></span></li>
								<li class="wrap_list_right"><span class="list_right"></span></li>
							</ul>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-16 sm-padding-no">
			<div class="detail_block_buy">
				<div class="row">
					<div class="col-sm-12">
						<div class="detail_block_property">
							<?if(isset($arResult["BRAND"]["PIC"]) && $arResult["BRAND"]["PIC"]):?>
								<div class="detail_block_brand">
									<a href="<?=$arResult["BRAND"]["DETAIL_PAGE_URL"]?>" title="<?=$arResult["BRAND"]["NAME"]?>">
										<img class="img-responsive" src="<?=$arResult["BRAND"]["PIC"]["src"]?>" width="<?=$arResult["BRAND"]["PIC"]["width"]?>" height="<?=$arResult["BRAND"]["PIC"]["height"]?>" title="<?=$arResult["BRAND"]["PIC"]["TITLE"]?>" alt="<?=$arResult["BRAND"]["PIC"]["ALT"]?>"/>
										<span class="img_hover"></span>
									</a>
								</div>
								<?endif?>
							<div class="detail_sect">
								<a onclick="" href="<?=$arResult["BRAND"]["DETAIL_PAGE_URL"]?>" title="<?=$arResult["BRAND"]["NAME"]?>"><?=GetMessage("B2BS_CATALOG_DETAIL_ALL_MODELS")?> <?=$arResult["BRAND"]["NAME"]?></a>
								<a onclick="" href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>" title="<?=$arResult["SECTION"]["NAME"]?>"><?=GetMessage("B2BS_CATALOG_DETAIL_ALL")?> <?=$arResult["SECTION"]["NAME"]?></a>
							</div>
							<div class="detail_prop offer-props">
							<?
							if($arResult['MAIN_PROPS'])
							{
								foreach ($arResult['MAIN_PROPS'] as $arProp)
								{?>
									<span>
										<?=$arProp["NAME"]?>: <span class="black"><?echo is_array($arProp['DISPLAY_VALUE'])?implode(' / ', $arProp['DISPLAY_VALUE']):$arProp['DISPLAY_VALUE']?></span>
									</span>
								<?}
							}
							if($arResult['OFFERS_PROPS'][$FirstOffer])
							{
								foreach($arResult['OFFERS_PROPS'][$FirstOffer] as $OfferPropCode=>$Value)
								{
									?>
										<span style="display:<?=($Value=="")?'none':'block' ?>;">
											<?=$arResult["PROP_NAME"][$OfferPropCode]?>:
											<span class="black" data-prop="<?=$OfferPropCode ?>">
												<?=$Value?>
											</span>
										</span>
									<?
								}
							}?>
							</div>
							<div class="js_detail_prop_block">

							<?if(isset($arResult["OFFER_TREE_PROPS"]) && is_array($arResult["OFFER_TREE_PROPS"]))
							{
								foreach($arResult["OFFER_TREE_PROPS"] as $codeProp=>$arProperties)
								{
									if($arProperties)
									{
										$ClassBlock = '';
										if($codeProp==$colorCode)
										{
											$ClassBlock.='detail_color detail_color1';
										}
										elseif(in_array($codeProp,$arResult['COLOR_OFFER_FROM_IMAGE']))
										{
											$ClassBlock.='detail_color detail_color2';
										}
										else
										{
											$ClassBlock='detail_size';
										}
										?>
										<div class="<?=$ClassBlock ?> js_detail_prop">
											<?
											if(isset($arResult["PROP_NAME"][$codeProp]))
											{?>
												<span class="detail_prop_title" title="<?=$arResult["PROP_NAME"][$codeProp]?>"><?=GetMessage("B2BS_CATALOG_DETAIL_CHANGE")?> <?=strtolower($arResult["PROP_NAME"][$codeProp])?>:</span>
											<?} ?>
											<ul class="offer-props" id="offer_prop_<?=$codeProp?>"
											   title="<?=$arResult["PROP_NAME"][$codeProp]?>">
												<?php
												$i=1;
												foreach($arProperties as $xmlID=>$arProp)
												{
													if($codeProp==$colorCode && !$colorImage) //colors li
													{
														if($arProp["PIC"])
														{
															$style='background: url('.$arProp["PIC"]["SRC"].') 50% 50% no-repeat';
														}
														else
														{
															$style='background:'.$arProp["UF_DESCRIPTION"];
														}
														$content="";
														$class="item";
													}
													elseif($codeProp==$colorCode && $colorImage)//color images
													{
														$class="color_img";
														$style="";
														$img = '<img src="'.$arResult["MORE_PHOTO_JS"][$xmlID]["SMALL"][0]['src'].'" alt="'.$arProp["UF_NAME"].'" title="'.$arProp["UF_NAME"].'" width="'.$arParams["COLOR_IMAGE_WIDTH"].'" height="'.$arParams["COLOR_IMAGE_HEIGHT"].'" />';
														if($arResult['COLORS_URLS'][$xmlID] && $xmlID!=$firstColor)
														{
															$content = '<a href="'.$arResult['COLORS_URLS'][$xmlID].'">'.$img.'</a>';
														}
														else
														{
															$content = $img;
														}
														unset($img);
														//owl
														if(
														$arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"] &&
														$arParams["COLOR_SLIDER_COUNT_IMAGES_VER"] &&
														$arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"]*$arParams["COLOR_SLIDER_COUNT_IMAGES_VER"]<count($arResult["OFFER_TREE_PROPS"][$codeProp]) &&
														($i%$arParams["COLOR_SLIDER_COUNT_IMAGES_VER"]==1 || $arParams["COLOR_SLIDER_COUNT_IMAGES_VER"]==1 || count($arResult["OFFER_TREE_PROPS"][$codeProp])<$arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"]))
														{?>
															<ol>
														<?}
													}
													elseif(in_array($codeProp,$arResult['COLOR_OFFER_FROM_IMAGE']))
													{
														//owl
														if(
														$arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"] &&
														$arParams["COLOR_SLIDER_COUNT_IMAGES_VER"] &&
														$arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"]*$arParams["COLOR_SLIDER_COUNT_IMAGES_VER"]<count($arResult["OFFER_TREE_PROPS"][$codeProp]) &&
														($i%$arParams["COLOR_SLIDER_COUNT_IMAGES_VER"]==1 || $arParams["COLOR_SLIDER_COUNT_IMAGES_VER"]==1 || count($arResult["OFFER_TREE_PROPS"][$codeProp])<$arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"]))
														{?>
																<ol>
																	<?}
														$photoId = key(array_intersect
														($arResult["OFFERS_ID"][$colorCode][$arResult['FIRST_COLOR']],$arResult["OFFERS_ID"][$codeProp][$xmlID]));
														if($arResult['MORE_PHOTO_JS2'][$photoId]['SMALL'][0])
														{
															$img = '<img src="'.$arResult['MORE_PHOTO_JS2'][$photoId]['SMALL'][0]['src'].'" alt="'.$arProp["UF_NAME"].'" title="'.$arProp["UF_NAME"].'" width="'.$arParams["COLOR_IMAGE_WIDTH"].'" height="'.$arParams["COLOR_IMAGE_HEIGHT"].'" />';
														}
														else
														{
															$img = '<img src="/upload/no_photo.jpg" alt="'.$arProp["UF_NAME"].'" title="'.$arProp["UF_NAME"].'" width="'.$arParams["COLOR_IMAGE_WIDTH"].'" height="'.$arParams["COLOR_IMAGE_HEIGHT"].'" />';
														}
														$content = $img;
													}
													else
													{
														$style="";
														$class="item";
														$content = $arProp["UF_NAME"];
													}
													?>
													<li title="<?=$arProp["UF_NAME"]?>" data-offer="<?=implode(",", $arResult["OFFERS_ID"][$codeProp][$xmlID])?>" data-xml="<?=$xmlID?>" class="<?=$class ?> <?=$arResult['LI'][$xmlID] ?>">
														<span title="<?=$arProp["UF_NAME"]?>" style="<?=$style ?>"><?=$content ?></span>
													</li>
													<?
													if(
														(($codeProp==$colorCode && $colorImage) ||
															in_array($codeProp,$arResult['COLOR_OFFER_FROM_IMAGE'])) &&
														$arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"] &&
														$arParams["COLOR_SLIDER_COUNT_IMAGES_VER"] &&
														$arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"]*$arParams["COLOR_SLIDER_COUNT_IMAGES_VER"]<count($arResult["OFFER_TREE_PROPS"][$colorCode]) &&
														($i%$arParams["COLOR_SLIDER_COUNT_IMAGES_VER"]==0 || count($arResult["OFFER_TREE_PROPS"][$codeProp])<$arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"]))
													{?>
														</ol>
													<?}
													++$i;
												}
												?>
												</ol>
											</div>
										<?
										if(is_array($arResult["SIZE_PROPS"]) && in_array($codeProp,$arResult["SIZE_PROPS"]))
										{
											$showSizeUrl = true;
										}
									}
								}
							}
							if($arResult["TABLE_SIZE_URL"] && $showSizeUrl)
							{?>
								<div class="wrap_table_size" >
									<a href="#" onclick="window.open('<?=$arResult["TABLE_SIZE_URL"]?>','tableSize','width=500,height=700,scrollbars=1');return false;" class="table_size"><?=GetMessage("B2BS_CATALOG_DETAIL_TABLE_SIZE")?></a>
								</div>
							<?} ?>
							</div>
						</div>
					</div>
					<?$frame = $this->createFrame()->begin();?>
					<?if(isset($arResult["PRICES_JS"][$FirstOffer]) && $arResult["CAN_BUY_FIRST_OFFER"])
					{?>
						<div class="col-sm-12 detail_block_price_cont">
							<div class="detail_block_price">
								<div class="discount-block_price-inner">
									<span class="discount_price"><?=$arResult["PRICES_JS"][$FirstOffer]['DISCOUNT_PRICE']?></span>
									<?if($arResult["PRICES_JS"][$FirstOffer]['OLD_PRICE'] && $arResult["PRICES_JS"][$FirstOffer]['OLD_PRICE']!=$arResult["PRICES_JS"][$FirstOffer]['DISCOUNT_PRICE']):?>
										<span class="old_price"><?=$arResult["PRICES_JS"][$FirstOffer]['OLD_PRICE']?></span>
									<?endif;?>
								</div>
								<div class="block_quantity">
									<label>
										<?=GetMessage("B2BS_CATALOG_QUANTITY")?>&nbsp;
										<input name="quantity" value="1" maxlength="4"/>
									</label>
								</div>
								<span class="btn_add btn_add_basket"><?=GetMessage("B2BS_CATALOG_DETAIL_IN_CART")?></span>
								<span class="btn_add_wish"><?=GetMessage("B2BS_CATALOG_DETAIL_IN_DELAY")?></span>
							</div>
							<?
							$isPhone = COption::GetOptionString("kit.b2bshop", "DETAIL_ORDERPHONE", "Y");
							if($isPhone=="Y")
							{
								$APPLICATION->IncludeComponent("kit:order.phone", "catalog", array(
									"PRODUCT_ID" => $FirstOffer,
									"IBLOCK_ID" => $arParams["IBLOCK_ID"],
									"SELECT_USER" => "new",
									"USER_GROUP" => "0",
									"STATUS_ORDER" => "N",
									"PERSON_TYPE" => "1",
									"ORDER_TEL_PROP" => "3",
									"ORDER_PROPS" => array(
									),
									"PAY_SYSTEM_ID" => $arParams["TEL_PAY_SYSTEM_ID"],
									"DELIVERY_ID" => $arParams["TEL_DELIVERY_ID"],
									"LOCAL_REDIRECT" => "",
									"ORDER_ID" => "ORDER_ID",
									"TEL_MASK" => $arParams['TEL_MASK'],
									"SUCCESS_TEXT" => GetMessage("MS_PHONE_SUCCESS_TEXT"),
									"SUBMIT_VALUE" => GetMessage("MS_PHONE_SUBMIT_VALUE"),
									"SEND_EVENT" => "Y",
									"TEXT_TOP" => GetMessage("MS_PHONE_TEXT_TOP"),
									"TEXT_BOTTOM" => GetMessage("MS_PHONE_TEXT_BOTTOM"),
									"ERROR_TEXT" => GetMessage("MS_PHONE_ERROR_TEXT"),
									"OFFERS_PROPS" => $arParams["OFFERS_CART_PROPERTIES"]
									),
									false
								);
							}
							?>
						</div>
					<?}
					$default_subscribe = \Bitrix\Main\Config\Option::get("catalog", "default_subscribe", "");
					if($default_subscribe == 'Y' && $arParams["AVAILABLE_DELETE"]!="Y" && isset($arResult["OFFER_SUBSCRIBE_URL"]))
					{
						?>
						<div class="col-sm-12 subscribe_cont" <?=(isset($arResult["OFFER_SUBSCRIBE_URL"][$FirstOffer]))?'style="display:block"':'style="display:none"'?>>
							<div class="">
								<div class="detail_available_title">
									<p class="title"><?=GetMessage("MS_DETAIL_AVAILABLE_TITLE")?></p>
									<p><?=GetMessage("MS_DETAIL_AVAILABLE_TEXT")?></p>
								</div>
							</div>
							<?
							$context = \Bitrix\Main\Application::getInstance()->getContext();
							$server = $context->getServer();
							if(is_dir($server->getDocumentRoot().$server->getPersonalRoot().'/components/bitrix/catalog.product.subscribe'))
							{
								$APPLICATION->includeComponent('bitrix:catalog.product.subscribe','ms_subscribe',
										array(
												'PRODUCT_ID' => $arResult['ID'],
												'BUTTON_ID' => 'subscribe',
												'BUTTON_CLASS' => '',
												'DEFAULT_DISPLAY' => '',
										),
										$component, array('HIDE_ICONS' => 'Y')
										);
							}
							unset($context, $server);
							?>
						</div>
					<?}?>
					<?$frame->end();?>
				</div>
			</div>
			<?=\Bitrix\Main\Config\Option::get("kit.b2bshop", "DETAIL_TEXT_INCLUDE");?>
			<?if($arParams['FULL_WIDTH_DESCRIPTION'] != 'Y')
			{?>
				<?if(isset($arResult["DOP_PROPS"]) && !empty($arResult["DOP_PROPS"]))
				{?>
					<div class="detail_description">
						<div class="description_block block_open">
							<div class="description_title button_js">
								<div class="description_title_in">
									<span class="desc_fly_2_bg"><?=GetMessage("B2BS_CATALOG_DOP_PROPS")?></span>
								</div>
							</div>
							<div class="description_content block_js">
								<?foreach ($arResult['DOP_PROPS'] as &$arOneProp)
								{?>
									<p class="desc_prop"><span><?=$arOneProp["NAME"]?>:</span> <?echo is_array($arOneProp['DISPLAY_VALUE'])?implode(' / ', $arOneProp['DISPLAY_VALUE']):$arOneProp['DISPLAY_VALUE']?></p>
								<?}?>
							</div>
						</div>
					</div>
				<?}?>
				<?if($arResult["DETAIL_TEXT"] || $arResult["PREVIEW_TEXT"])
				{?>
					<div class="detail_description">
						<div class="description_block block_open">
							<div class="description_title button_js">
								<div class="description_title_in">
									<span class="desc_fly_1_bg"><?=GetMessage("B2BS_CATALOG_DETAIL_DESCRIPTION")?></span>
								</div>
							</div>
							<div class="description_content block_js">
								<?
								if($arResult["DETAIL_TEXT"])
								{
									echo $arResult["~DETAIL_TEXT"];
								}
								elseif($arResult["PREVIEW_TEXT"])
								{
									echo $arResult["PREVIEW_TEXT"];
								}
								?>
							</div>
						</div>
					</div>
				<?}?>
		<?} ?>
		</div>
		<div class="col-sm-8 sm-padding-no">
			<div class="detail-right-block-wrap">
			<?$frame = $this->createFrame()->begin();?>
				<?
				unset($arParams["ELEMENT_ID"]);
				unset($arParams["ELEMENT_CODE"]);
				if(\Bitrix\Main\Config\Option::get("kit.b2bshop", "SHOW_LOOKING_ELEMENT","Y") == 'Y')
				{
					$APPLICATION->IncludeComponent("kit:product.view", "ms_vertical", array(
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"ID" => $arResult["ID"],
						"DATE_FROM" => 60,
						"LIMIT" => 4,
						"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
						"META_KEYWORDS" => $arParams["META_KEYWORDS"],
						"META_DESCRIPTION" => $arParams["DETAIL_META_DESCRIPTION"],
						"BROWSER_TITLE" => $arParams["DETAIL_BROWSER_TITLE"],
						"BASKET_URL" => $arParams["BASKET_URL"],
						"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
						"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
						"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
						"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
						"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"SET_TITLE" => $arParams["SET_TITLE"],
						"PRICE_CODE" => $arParams["PRICE_CODE"],
						"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
						"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
						"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
						"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
						"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
						"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
						"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
						"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
						"LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
						"LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
						"LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
						"LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],

						"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
						"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
						"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
						"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
						"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
						"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
						"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
						"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
						"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
						'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
						'CURRENCY_ID' => $arParams['CURRENCY_ID'],
						'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
						'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
						"ELEMENT_COUNT" => "4",
						"IS_FANCY" => $arParams["IS_FANCY"],
						"PICTURE_FROM_OFFER" => $arParams["PICTURE_FROM_OFFER"],
						"MORE_PHOTO_OFFER_PROPS" => $arParams["MORE_PHOTO_OFFER_PROPS"],
						),
						false
					);
				}
				if(\Bitrix\Main\Config\Option::get("kit.b2bshop", "SHOW_ANALOG_PRODUCTS_ELEMENT","Y") == 'Y')
				{
					$APPLICATION->IncludeComponent("kit:analog.products", "ms_vertical", array(
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"ID" => $arResult["ID"],
						"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
						"BASKET_URL" => $arParams["BASKET_URL"],
						"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
						"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
						"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
						"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
						"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"SET_TITLE" => $arParams["SET_TITLE"],
						"PRICE_CODE" => $arParams["PRICE_CODE"],
						"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
						"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
						"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
						"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
						"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
						"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
						"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
						"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
						"LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
						"LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
						"LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
						"LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],

						"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
						"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
						"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
						"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
						"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
						"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
						"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
						"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
						"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
						'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
						'CURRENCY_ID' => $arParams['CURRENCY_ID'],
						'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
						'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
						"MODE" => "PRODUCT",
						"ELEMENT_COUNT" => 4,
						"IS_FANCY" => $arParams["IS_FANCY"],
						"DETAIL_PROPS_ANALOG" => array(
							0 => "SECTION_ID",
							1 => "",
						),
						"PICTURE_FROM_OFFER" => $arParams["PICTURE_FROM_OFFER"],
						"MORE_PHOTO_OFFER_PROPS" => $arParams["MORE_PHOTO_OFFER_PROPS"],
						),
						false
					);
				}
				global $sMSRightBlockCount;
				if($sMSRightBlockCount<2 && \Bitrix\Main\Config\Option::get("kit.b2bshop", "SHOW_BRAND_PRODUCT_ELEMENT","Y") == 'Y')
				{
					$APPLICATION->IncludeComponent("kit:analog.products", "ms_vertical", array(
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"ID" => $arResult["ID"],
						"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
						"BASKET_URL" => $arParams["BASKET_URL"],
						"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
						"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
						"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
						"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
						"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"SET_TITLE" => $arParams["SET_TITLE"],
						"PRICE_CODE" => $arParams["PRICE_CODE"],
						"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
						"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
						"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
						"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
						"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
						"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
						"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
						"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
						"LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
						"LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
						"LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
						"LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],

						"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
						"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
						"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
						"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
						"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
						"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
						"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
						"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
						"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
						'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
						'CURRENCY_ID' => $arParams['CURRENCY_ID'],
						'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
						'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
						"MODE" => "PRODUCT",
						"ELEMENT_COUNT" => 2,
						"IS_FANCY" => $arParams["IS_FANCY"],
						"TITLE" => GetMessage("MS_ANALOG_BRAND_TITLE"),
						"DETAIL_PROPS_ANALOG" => array(
							0 => "PROPERTY_".$arParams["MANUFACTURER_LIST_PROPS"],
							1 => "",
						),
						"PICTURE_FROM_OFFER" => $arParams["PICTURE_FROM_OFFER"],
						"MORE_PHOTO_OFFER_PROPS" => $arParams["MORE_PHOTO_OFFER_PROPS"],
						),
						false
					);
				}
				$context = \Bitrix\Main\Application::getInstance()->getContext();
				$server = $context->getServer();
				if(\Bitrix\Main\Config\Option::get("kit.b2bshop", "SHOW_BIG_DATA_ELEMENT_RIGHT","Y") == 'Y' && \Bitrix\Main\Config\Option::get("main", "gather_catalog_stat","N") == 'Y' && is_dir($server->getDocumentRoot().$server->getPersonalRoot().'/components/bitrix/catalog.bigdata.products'))
				{
					$mxResult = CCatalogSKU::GetInfoByProductIBlock( $arParams['IBLOCK_ID'] );
					if( is_array( $mxResult ) )
					{
						$offersIblock = $mxResult['IBLOCK_ID'];
					}
					unset($mxResult);

					$idUserGroups = [];
					$userPriceCode = [];
					$rs = CCatalogGroup::GetGroupsList(array("GROUP_ID"=>$USER->GetGroups(), "BUY"=>"Y"));
					while($group = $rs->Fetch())
					{
						$idUserGroups[$group['CATALOG_GROUP_ID']] = $group['CATALOG_GROUP_ID'];
					}
					if($idUserGroups)
					{
						$rs = \Bitrix\Catalog\GroupTable::getList(['filter' => ['ID' => $idUserGroups],'select' => ['NAME']]);
						while($group = $rs->fetch())
						{
							$userPriceCode[] = $group['NAME'];
						}
					}
					if(!$userPriceCode)
					{
						$userPriceCode = $arParams['PRICE_CODE'];
					}


					$APPLICATION->IncludeComponent( 'bitrix:catalog.bigdata.products', 'vertical',
							Array(
									'ACTION_VARIABLE' => 'action_cbdp',
									'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
									'AJAX_PRODUCT_LOAD' => $arParams['AJAX_PRODUCT_LOAD'],
									'AVAILABLE_DELETE' => $arParams['AVAILABLE_DELETE'],
									'BASKET_URL' => $arParams['BASKET_URL'],
									'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
									'CACHE_TIME' => $arParams['CACHE_TIME'],
									'CACHE_TYPE' => $arParams['CACHE_TYPE'],
									'COLOR_IN_PRODUCT' => $arParams['COLOR_IN_PRODUCT'],
									'COLOR_IN_PRODUCT_CODE' => $arParams['COLOR_IN_PRODUCT_CODE'],
									'COLOR_IN_PRODUCT_LINK' => $arParams['COLOR_IN_PRODUCT_LINK'],
									'COLOR_IN_SECTION_LINK' => $arParams['COLOR_IN_SECTION_LINK'],
									'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
									'CURRENCY_ID' => $arParams['CURRENCY_ID'],
									'DELETE_OFFER_NOIMAGE' => $arParams['DELETE_OFFER_NOIMAGE'],
									'DETAIL_HEIGHT_BIG' => $arParams['DETAIL_HEIGHT_BIG'],
									'DETAIL_HEIGHT_MEDIUM' => $arParams['DETAIL_HEIGHT_MEDIUM'],
									'DETAIL_HEIGHT_SMALL' => 171,
									'DETAIL_PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
									'DEPTH' => '2',
									'DETAIL_URL' => $arParams['DETAIL_URL'],
									'FLAG_PROPS' => $arParams['FLAG_PROPS'],
									'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
									'IBLOCK_ID' => $arParams['IBLOCK_ID'],
									'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
									"ID" => $arResult['ID'],
									'IMAGE_RESIZE_MODE' => BX_RESIZE_IMAGE_EXACT,
									'LAZY_LOAD' => $arParams['LAZY_LOAD'],
									'LIST_HEIGHT_MEDIUM' => 171,
									'LIST_HEIGHT_SMALL' => 171,
									'LIST_WIDTH_MEDIUM' => 131,
									'LIST_WIDTH_SMALL' => 131,
									'MANUFACTURER_ELEMENT_PROPS' => $arParams['MANUFACTURER_ELEMENT_PROPS'],
									'MANUFACTURER_LIST_PROPS' => $arParams['MANUFACTURER_LIST_PROPS'],
									'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
									'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
									'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
									'MORE_PHOTO_PRODUCT_PROPS' => $arParams['MORE_PHOTO_PRODUCT_PROPS'],
									'MORE_PHOTO_OFFER_PROPS' => $arParams['MORE_PHOTO_OFFER_PROPS'],
									'OFFER_COLOR_PROP' => $arParams['OFFER_COLOR_PROP'],
									'OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
									'OFFER_TREE_PROPS_' . $offersIblock => $arParams['OFFER_TREE_PROPS'],
									'PAGE_ELEMENT_COUNT' => '4',
									'PARTIAL_PRODUCT_PROPERTIES' => (isset( $arParams['PARTIAL_PRODUCT_PROPERTIES'] ) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
									'PICTURE_FROM_OFFER' => $arParams['PICTURE_FROM_OFFER'],
									"PRELOADER" => $arParams['PRELOADER'],
									'PRICE_CODE' => $userPriceCode,
									'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
									'PROPERTY_CODE_' . $arParams['IBLOCK_ID'] => $arParams['PRODUCT_PROPERTIES'],
									'PROPERTY_CODE_' . $offersIblock => $arParams['OFFER_TREE_PROPS'],
									'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
									'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
									'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
									'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
									'RCM_TYPE' => 'personal',
									'SECTION_CODE' => '',
									'SECTION_ELEMENT_CODE' => '',
									'SECTION_ELEMENT_ID' => '',
									'SECTION_ID' => $arResult['IBLOCK_SECTION_ID'],
									'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
									'SHOW_FROM_SECTION' => 'N',
									'SHOW_IMAGE' => 'Y',
									'SHOW_NAME' => 'Y',
									'SHOW_OLD_PRICE' => 'N',
									'SHOW_PRICE_COUNT' => '1',
									'SHOW_PRODUCTS_' . $arParams['IBLOCK_ID'] => 'Y',
									'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY']
									) );
				}
				$frame->end();
				unset($context, $server);
				?>
			</div>
		</div>
	</div>
</div>
</div>
			<?
			$NeedLeft = false;

			if($arParams['FULL_WIDTH_DESCRIPTION'] == 'Y')
			{?>
				<div class="row full-width-description detail_page_wrap no_preview">
				<?if(isset($arResult["DOP_PROPS"]) && !empty($arResult["DOP_PROPS"])):
				$NeedLeft = true;
				?>
				<div class="col-sm-8 sm-padding-left-no" id="left">
					<div class="detail_description">
						<div class="description_block block_open">
							<div class="description_title button_js">
								<div class="description_title_in">
									<span class="desc_fly_2_bg"><?=GetMessage("B2BS_CATALOG_DOP_PROPS")?></span>
								</div>
							</div>
							<div class="description_content block_js">
								<?foreach ($arResult['DOP_PROPS'] as &$arOneProp):?>
									<p class="desc_prop"><span><?=$arOneProp["NAME"]?>:</span> <?echo is_array($arOneProp['DISPLAY_VALUE'])?implode(' / ', $arOneProp['DISPLAY_VALUE']):$arOneProp['DISPLAY_VALUE']?></p>
									<?endforeach?>
							</div>
						</div>
					</div>
				</div>
				<?endif;?>
				<?if($arResult["DETAIL_TEXT"] || $arResult["PREVIEW_TEXT"])
				{?>
				<div class="col-sm-<?=($NeedLeft)?'16':'24'?> sm-padding-right-no" id = "right">
					<div class="detail_description">
						<div class="description_block block_open">
							<div class="description_title button_js">
								<div class="description_title_in">
									<span class="desc_fly_1_bg"><?=GetMessage("B2BS_CATALOG_DETAIL_DESCRIPTION")?></span>
								</div>
							</div>
							<div class="description_content block_js">
								<?
								if($arResult["DETAIL_TEXT"])
								{
									echo $arResult["~DETAIL_TEXT"];
								}
								elseif($arResult["PREVIEW_TEXT"])
								{
									echo $arResult["PREVIEW_TEXT"];
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<?}?>
			</div>
		<?}

if($arParams["MODIFICATION"]=="Y" && isset($arResult['CAN_BUY_OFFERS_ID'][$colorCode]) && count($arResult['CAN_BUY_OFFERS_ID'][$colorCode])>0 && isset($arResult['MODIFICATION']['MODIFICATION_RAZMERY']) && count($arResult['MODIFICATION']['MODIFICATION_RAZMERY'])>0)
{
?>
<div class="modification row">
	<div class="col-sm-24 col-modification">
		<div class="col-mod-in">
			<div class="description_block block_open">
				<div class="description_title button_js">
					<div class="description_title_in">
						<span class="desc_fly_1_bg"><?=GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION")?></span>
					</div>
				</div>
				<div class="description_content block_js">
					<div class="row modification-inner">
						<div class="col-sm-8 fixed-block">
							<?if(isset($arResult['CAN_BUY_OFFERS_ID'][$colorCode]) && is_array($arResult['CAN_BUY_OFFERS_ID'][$colorCode]))
							{?>
								<?$k=1;?>
								<?foreach($arResult['CAN_BUY_OFFERS_ID'][$colorCode] as $Color=>$ColorIds)
								{?>
									<?if(is_array($ColorIds) && count($ColorIds)>0)
									{?>
										<div <?=($k<=$arParams["MODIFICATION_COUNT"])?'class="row item-row" style="display:table"':'style="display:none" class="row item-row item-row-hide"'?>>
											<div class="col-sm-6 image">
											<?
											if(isset($arResult['MORE_PHOTO_JS'][$Color]['SMALL']) && is_array($arResult['MORE_PHOTO_JS'][$Color]['SMALL']) && count($arResult['MORE_PHOTO_JS'][$Color]['SMALL'])>0)
											{?>
												<img src="<?=$arResult['MORE_PHOTO_JS'][$Color]['SMALL'][0]['src']?>" width="37" height="61" />
											<?}?>
											</div>
											<div class="col-sm-6 col-md-8 color-name">
												<div class="color-name-inner">
													<?=$arResult['OFFER_TREE_PROPS'][$colorCode][$Color]['UF_NAME']?>
												</div>
											</div>
											<div class="col-sm-12 col-md-10 params-name">
												<div class="row params-name-row params-name-row-size">
													<div class="col-sm-24 params-name-size">
														<?=GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_SIZE")?>
													</div>
												</div>
												<div class="row params-name-row params-name-row-kol">
													<div class="col-sm-24 params-name-kol">
														<?=GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_KOL")?>
													</div>
												</div>
												<div class="row params-name-row params-name-row-price">
													<div class="col-sm-24 params-name-price">
														<?=GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_PRICE")?>
													</div>
												</div>
											</div>
										</div>
									<?}?>
								<?++$k;?>
								<?}?>
							<?}?>
							<div class="empty-bottom"></div>
						</div>
						<div class="col-sm-16 sizes-col">
							<div class="viewport">
								<div class="overview sizes">
									<div class="">
										<?if(isset($arResult['CAN_BUY_OFFERS_ID'][$colorCode]) && is_array($arResult['CAN_BUY_OFFERS_ID'][$colorCode]))
										{?>
											<?$k=1;?>
											<?foreach($arResult['CAN_BUY_OFFERS_ID'][$colorCode] as $Color=>$ColorIds)
											{?>
												<?if(is_array($ColorIds) && count($ColorIds)>0)
												{?>
													<div <?=($k<=$arParams["MODIFICATION_COUNT"])?'class="row size-row" style="display:table-row"':'style="display:none" class="row size-row size-row-hide"'?>>
														<?if(isset($arResult['MODIFICATION']['MODIFICATION_RAZMERY']) && is_array($arResult['MODIFICATION']['MODIFICATION_RAZMERY']) && count($arResult['MODIFICATION']['MODIFICATION_RAZMERY']>0))
														{
															foreach($arResult['MODIFICATION']['MODIFICATION_RAZMERY'] as $key=>$ids)
															{
																if(is_array($ids))
																{
																	$AddItems=$ColorIds;
																	foreach($ids as $IdKey=>$GroupVal)
																	{
																		$AddItems=array_intersect($AddItems,$arResult['CAN_BUY_OFFERS_ID'][$IdKey][$GroupVal]);
																	}
																	$idsTmp=array();
																	foreach($ids as $idsKey=>$idsValue)
																	{
																		$idsTmp[$idsKey]=$arResult['OFFER_TREE_PROPS'][$idsKey][$idsValue]['UF_NAME'];
																	}
																	?>
																	<div class="col-sm-3 size">
																		<div class="row size-row-inner size-row-inner-name">
																			<div class="col-sm-24 size-item-row">
																				<?$i=1;?>
																				<?foreach($idsTmp as $id)
																				{?>
																					<?=$id?>
																					<?if($i!=count($idsTmp))
																					{?>
																					/
																					<?
																					++$i;
																					}
																				}?>
																			</div>
																		</div>
																		<div class="row size-row-inner size-row-inner-cnt">
																			<div class="col-sm-24 size-item-row-cnt">
																				<?if(isset($AddItems) && is_array($AddItems) && count($AddItems)>0){?>
																					<div class="sizes-block-cnt">
																						<div class="sizes-block-cnt-minus">-</div>
																						<div class="sizes-block-cnt-value">0</div>
																						<div class="sizes-block-cnt-plus">+</div>
																					</div>
																				<?}?>
																			</div>
																		</div>
																		<div class="row size-row-inner size-row-inner-price">
																			<div class="col-sm-24 size-item-row-price">
																				<?if(isset($AddItems) && is_array($AddItems) && count($AddItems)>0){
																				$IdItem=array_shift($AddItems);?>
																					<?foreach($arResult['OFFERS'] as $Offer)
																					{?>
																						<?if($Offer['ID']==$IdItem)
																						{?>
																							<div data-offer-id="<?=$Offer['ID']?>" data-offer-price="<?=$Offer['MIN_PRICE']['DISCOUNT_VALUE']?>"><?=$Offer['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div>
																						<?}?>
																					<?}?>
																				<?}?>
																			</div>
																		</div>
																	</div>
																<?}?>
															<?}?>
														<?}?>
													</div>
												<?}?>
												<?++$k;?>
											<?}?>
										<?}?>
									</div>
								</div>
							</div>
							<div class="scrollbar">

							</div>
						</div>
					</div>
					<div class="row row-under-modifications">
						<div class="col-sm-12">
						<?if(count($arResult['CAN_BUY_OFFERS_ID'][$colorCode])>$arParams["MODIFICATION_COUNT"])
						{?>
							<p class="more-text" data-hide="<?=GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_HIDE1")?> <?=count($arResult['CAN_BUY_OFFERS_ID'][$colorCode])-$arParams["MODIFICATION_COUNT"]?> <?=$arResult['MODIFICATION']['OKONCHANIE2']?>" data-show="<?=GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_MORE1")?> <?=count($arResult['CAN_BUY_OFFERS_ID'][$colorCode])-$arParams["MODIFICATION_COUNT"]?> <?=$arResult['MODIFICATION']['OKONCHANIE']?>"><?=GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_MORE1")?> <?=count($arResult['CAN_BUY_OFFERS_ID'][$colorCode])-$arParams["MODIFICATION_COUNT"]?> <?=$arResult['MODIFICATION']['OKONCHANIE']?></p>
							<div class="show-all" data-show="<?=GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_SHOW_ALL")?>" data-hide="<?=GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_HIDE_ALL")?>"><?=GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_SHOW_ALL")?></div>
						<?}?>
						</div>
						<div class="col-sm-12">
							<div class="basket-block">
								<div class="basket-price">
									<span>
										<?=GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_BASKET_SUM")?>
									</span>
									<div id="modification-basket-price">0</div>
									<?=$arResult['MODIFICATION']['MODIFICATION_CURRENCY']?>
								</div>
								<div class="basket-botton"><?=GetMessage("B2BS_CATALOG_DETAIL_MODIFICATION_BASKET_BOTTON")?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?}
$mess = array(
	'MS_JS_CATALOG_ADD_BASKET' => GetMessage("MS_JS_CATALOG_ADD_BASKET"),
	'MS_JS_CATALOG_ADDED_BASKET' => GetMessage("MS_JS_CATALOG_ADDED_BASKET"),
	'MS_JS_CATALOG_ADD_WISH' => GetMessage("MS_JS_CATALOG_ADD_WISH"),
	'MS_JS_CATALOG_ADD_SUBSCRIBE' => GetMessage("MS_JS_CATALOG_ADD_SUBSCRIBE"),
	'MS_JS_CATALOG_SELECT_PROP' => GetMessage("MS_JS_CATALOG_SELECT_PROP"),
	'MS_JS_CATALOG_SELECT_MODIFICATION' => GetMessage("MS_JS_CATALOG_SELECT_MODIFICATION"),
	'B2BS_CATALOG_DETAIL_IN_CART' => GetMessage("B2BS_CATALOG_DETAIL_IN_CART"),
);
?>
<script type="text/javascript">
BX.ready(function(){

		if($('.modification .viewport').width()<$('.modification .sizes').width())
		{
			$('.modification .empty-bottom').show();
			$('.modification .viewport').css('border-right','1px solid #d3d3d3');
			$('.viewport').niceScroll({emulatetouch: true, bouncescroll: false, cursoropacitymin: 1, enabletranslate3d: true, cursorfixedheight: '100', scrollspeed: 25, mousescrollstep: 10,  cursorwidth: '8px', horizrailenabled: true, cursordragontouch: true});

		}
		else
		{
			 $(".modification .scrollbar").hide();

			var CntEmpty=Math.floor(($('.modification .viewport').width()-$('.modification .sizes').width())/$('.modification .size').width());
			for(var i=0;i<CntEmpty;++i)
			{
				$(".modification .size-row").append('<div class="col-sm-3 size"><div class="row size-row-inner size-row-inner-name"><div class="col-sm-24 size-item-row"></div></div><div class="row size-row-inner size-row-inner-cnt"><div class="col-sm-24 size-item-row-cnt"></div></div><div class="row size-row-inner size-row-inner-price"><div class="col-sm-24 size-item-row-price"></div></div></div>');
			}
			NewWidth=Math.round($('.modification .viewport').width()/$(".size-row:first .size").length);
			$('.modification .size').width(NewWidth);
		}



<?if(($arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"]>0 && $arParams["COLOR_SLIDER_COUNT_IMAGES_VER"]>0) && ($arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"]*$arParams["COLOR_SLIDER_COUNT_IMAGES_VER"]<count($arResult["OFFER_TREE_PROPS"][$colorCode]) || (isset($arParams["COLOR_IN_PRODUCT"]) && $arParams["COLOR_IN_PRODUCT"]=="Y" && isset($arParams["COLOR_IN_PRODUCT_LINK"]) && !empty($arParams["COLOR_IN_PRODUCT_LINK"]) && $arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"]*$arParams["COLOR_SLIDER_COUNT_IMAGES_VER"]<count($arResult["MODELS"])))):?>
	<?if(count($arResult['COLOR_OFFER_FROM_IMAGE']) > 0)
	{
		foreach($arResult['COLOR_OFFER_FROM_IMAGE'] as $prop)
		{
			?>
			$(".detail_page_wrap.no_preview #offer_prop_<?=$prop?>").owlCarousel({
				nav: true,
				mouseDrag:true,
				touchDrag:true,
				pullDrag:true,
				responsive:{
					0:{
						items:<?=$arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"]?>
					}
				},
				navText:["", ""]

			});
			<?
		}
	}?>
	$(".detail_page_wrap.no_preview #offer_prop_<?=$colorCode?>").owlCarousel({
			nav: true,
			mouseDrag:true,
			touchDrag:true,
			pullDrag:true,
			responsive:{
				0:{
					items:<?=$arParams["COLOR_SLIDER_COUNT_IMAGES_HOR"]?>
				}
			},
			navText:["", ""]
	});


<?endif;?>
});

			if($('.preview .js_slider_pic_small').find('owl-stage-outer').length>0)
			{
				$(".js_slider_pic_small .cloned:not .fancybox_little_img").fancybox({
					});
			}
			else
			{
				$(".js_slider_pic_small .fancybox_little_img").fancybox({
					});
			}

BX.message(<?=\Bitrix\Main\Web\Json::encode($mess)?>);
</script>

<div class="nabor-detail">
<?


if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'] && $arResult['OFFER_GROUP']))
{
	foreach ($arResult['OFFER_GROUP_VALUES'] as $offerId)
	{
		$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
			"nabory",
			array(
				"LIST_WIDTH_SMALL" => $arParams["LIST_WIDTH_SMALL"],
				"LIST_HEIGHT_SMALL" => $arParams["LIST_HEIGHT_SMALL"],
				"LIST_WIDTH_MEDIUM" => $arParams["LIST_WIDTH_MEDIUM"],
				"LIST_HEIGHT_MEDIUM" => $arParams["LIST_HEIGHT_MEDIUM"],
				"IMAGE_RESIZE_MODE" => $arParams["IMAGE_RESIZE_MODE"],
				"MANUFACTURER_ELEMENT_PROPS" => $arParams["MANUFACTURER_ELEMENT_PROPS"],
				"PICTURE_FROM_OFFER" => $arParams["PICTURE_FROM_OFFER"],
				"IBLOCK_ID" => $arResult["OFFERS_IBLOCK"],
				"ELEMENT_ID" => $offerId,
				"PRICE_CODE" => $arParams["PRICE_CODE"],
				"BASKET_URL" => $arParams["BASKET_URL"],
				"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME'],
				"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
				"CURRENCY_ID" => $arParams["CURRENCY_ID"]
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);
	}
}
else
{
	if ($arResult['MODULES']['catalog'])
	{
		$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
				"nabory",
				array(
						"LIST_WIDTH_SMALL" => $arParams["LIST_WIDTH_SMALL"],
						"LIST_HEIGHT_SMALL" => $arParams["LIST_HEIGHT_SMALL"],
						"LIST_WIDTH_MEDIUM" => $arParams["LIST_WIDTH_MEDIUM"],
						"LIST_HEIGHT_MEDIUM" => $arParams["LIST_HEIGHT_MEDIUM"],
						"IMAGE_RESIZE_MODE" => $arParams["IMAGE_RESIZE_MODE"],
						"MANUFACTURER_ELEMENT_PROPS" => $arParams["MANUFACTURER_ELEMENT_PROPS"],
						"PICTURE_FROM_OFFER" => $arParams["PICTURE_FROM_OFFER"],

						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"ELEMENT_ID" => $arResult["ID"],
						"PRICE_CODE" => $arParams["PRICE_CODE"],
						"BASKET_URL" => $arParams["BASKET_URL"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME'],
						"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
						"CURRENCY_ID" => $arParams["CURRENCY_ID"]
				),
			$component,
			array("HIDE_ICONS" => "Y")
		);
	}
}?>
</div>
<div class="gift-detail">
<?if ($arParams['USE_GIFTS_DETAIL'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled("sale") && file_exists($_SERVER["DOCUMENT_ROOT"].'/bitrix/components/bitrix/sale.gift.product'))
{
	$APPLICATION->IncludeComponent("bitrix:sale.gift.product", "gifts_for_products", array(
		"COLOR_IN_PRODUCT" => $arParams["COLOR_IN_PRODUCT"],
		"COLOR_IN_PRODUCT_CODE" => $arParams["COLOR_IN_PRODUCT_CODE"],
		"COLOR_IN_PRODUCT_LINK" => $arParams["COLOR_IN_PRODUCT_LINK"],
		"OFFER_COLOR_PROP" => $arParams["OFFER_COLOR_PROP"],
		"MANUFACTURER_ELEMENT_PROPS" => $arParams["MANUFACTURER_ELEMENT_PROPS"],
		"DELETE_OFFER_NOIMAGE" => $arParams["DELETE_OFFER_NOIMAGE"],
		"PICTURE_FROM_OFFER" => $arParams["PICTURE_FROM_OFFER"],
		"MORE_PHOTO_PRODUCT_PROPS" => $arParams["MORE_PHOTO_PRODUCT_PROPS"],
		"MORE_PHOTO_OFFER_PROPS" => $arParams["MORE_PHOTO_OFFER_PROPS"],
		"DETAIL_WIDTH_SMALL" => $arParams["DETAIL_WIDTH_SMALL"],
		"DETAIL_HEIGHT_SMALL" => $arParams["DETAIL_HEIGHT_SMALL"],
		"DETAIL_WIDTH_MEDIUM" => $arParams["DETAIL_WIDTH_MEDIUM"],
		"DETAIL_HEIGHT_MEDIUM" => $arParams["DETAIL_HEIGHT_MEDIUM"],
		"DETAIL_WIDTH_BIG" => $arParams["DETAIL_WIDTH_BIG"],
		"DETAIL_HEIGHT_BIG" => $arParams["DETAIL_HEIGHT_BIG"],
		"AVAILABLE_DELETE" => $arParams["AVAILABLE_DELETE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"IMAGE_RESIZE_MODE" => $arParams["IMAGE_RESIZE_MODE"],
		"FLAG_PROPS" => unserialize( COption::GetOptionString( "kit.b2bshop", "FLAG_PROPS", "" ) ),
		"OFFER_TREE_PROPS"	=>$arParams["OFFER_TREE_PROPS"],
		"COLOR_FROM_IMAGE" => $arParams["COLOR_FROM_IMAGE"],
		"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

		'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
		'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
		'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE'],
		'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
		'SUBSCRIBE_URL_TEMPLATE' => $arResult['~SUBSCRIBE_URL_TEMPLATE'],
		'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],

		"SHOW_DISCOUNT_PERCENT" => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
		"SHOW_OLD_PRICE" => $arParams['GIFTS_SHOW_OLD_PRICE'],
		"PAGE_ELEMENT_COUNT" => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
		"LINE_ELEMENT_COUNT" => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
		"HIDE_BLOCK_TITLE" => $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'],
		"TEXT_LABEL_GIFT" => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],
		"SHOW_NAME" => $arParams['GIFTS_SHOW_NAME'],
		"SHOW_IMAGE" => $arParams['GIFTS_SHOW_IMAGE'],
		"MESS_BTN_BUY" => $arParams['GIFTS_MESS_BTN_BUY'],

		"SHOW_PRODUCTS_{$arParams['IBLOCK_ID']}" => "Y",
		"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
		"PRODUCT_SUBSCRIPTION" => $arParams["PRODUCT_SUBSCRIPTION"],
		"MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
		"MESS_BTN_SUBSCRIBE" => $arParams["MESS_BTN_SUBSCRIBE"],
		"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
		"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
		"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ADD_PROPERTIES_TO_BASKET" => $arParams["ADD_PROPERTIES_TO_BASKET"],
		"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
		"PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
		"USE_PRODUCT_QUANTITY" => 'N',
		"OFFER_TREE_PROPS_{$arResult['OFFERS_IBLOCK']}" => $arParams['OFFER_TREE_PROPS'],
		"CART_PROPERTIES_{$arResult['OFFERS_IBLOCK']}" => $arParams['OFFERS_CART_PROPERTIES'],
		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"POTENTIAL_PRODUCT_TO_BUY" => array(
			'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
			'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
			'PRODUCT_PROVIDER_CLASS' => isset($arResult['PRODUCT_PROVIDER_CLASS']) ? $arResult['PRODUCT_PROVIDER_CLASS'] : 'CCatalogProductProvider',
			'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
			'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

			'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][0]['ID']) ? $arResult['OFFERS'][0]['ID'] : null,
			'SECTION' => array(
				'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
				'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
				'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
				'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
			),
		)
	), $component, array("HIDE_ICONS" => "Y"));
}
?>
</div>
<div class="giftmain-detail">
<?
if ($arParams['USE_GIFTS_MAIN_PR_SECTION_LIST'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled("sale")  && file_exists($_SERVER["DOCUMENT_ROOT"].'/bitrix/components/bitrix/sale.gift.main.products'))
{
	$APPLICATION->IncludeComponent(
			"bitrix:sale.gift.main.products",
			"gift_products",
			array(

					"COLOR_IN_PRODUCT" => $arParams["COLOR_IN_PRODUCT"],
					"COLOR_IN_PRODUCT_CODE" => $arParams["COLOR_IN_PRODUCT_CODE"],
					"COLOR_IN_PRODUCT_LINK" => $arParams["COLOR_IN_PRODUCT_LINK"],
					"OFFER_COLOR_PROP" => $arParams["OFFER_COLOR_PROP"],
					"MANUFACTURER_ELEMENT_PROPS" => $arParams["MANUFACTURER_ELEMENT_PROPS"],
					"DELETE_OFFER_NOIMAGE" => $arParams["DELETE_OFFER_NOIMAGE"],
					"PICTURE_FROM_OFFER" => $arParams["PICTURE_FROM_OFFER"],
					"MORE_PHOTO_PRODUCT_PROPS" => $arParams["MORE_PHOTO_PRODUCT_PROPS"],
					"MORE_PHOTO_OFFER_PROPS" => $arParams["MORE_PHOTO_OFFER_PROPS"],
					"DETAIL_WIDTH_SMALL" => $arParams["DETAIL_WIDTH_SMALL"],
					"DETAIL_HEIGHT_SMALL" => $arParams["DETAIL_HEIGHT_SMALL"],
					"DETAIL_WIDTH_MEDIUM" => $arParams["DETAIL_WIDTH_MEDIUM"],
					"DETAIL_HEIGHT_MEDIUM" => $arParams["DETAIL_HEIGHT_MEDIUM"],
					"DETAIL_WIDTH_BIG" => $arParams["DETAIL_WIDTH_BIG"],
					"DETAIL_HEIGHT_BIG" => $arParams["DETAIL_HEIGHT_BIG"],
					"AVAILABLE_DELETE" => $arParams["AVAILABLE_DELETE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"IMAGE_RESIZE_MODE" => $arParams["IMAGE_RESIZE_MODE"],
					"FLAG_PROPS" => unserialize( COption::GetOptionString( "kit.b2bshop", "FLAG_PROPS", "" ) ),
					"OFFER_TREE_PROPS"	=>$arParams["OFFER_TREE_PROPS"],
					"COLOR_FROM_IMAGE" => $arParams["COLOR_FROM_IMAGE"],
					"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],


				"PAGE_ELEMENT_COUNT" => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
				"BLOCK_TITLE" => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],

				"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
				"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],

				"AJAX_MODE" => $arParams["AJAX_MODE"],
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],

				"ELEMENT_SORT_FIELD" => 'ID',
				"ELEMENT_SORT_ORDER" => 'DESC',

				"FILTER_NAME" => 'searchFilter',
				"SECTION_URL" => $arParams["SECTION_URL"],
				"DETAIL_URL" => $arParams["DETAIL_URL"],
				"BASKET_URL" => $arParams["BASKET_URL"],
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],

				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],

				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"SET_TITLE" => $arParams["SET_TITLE"],
				"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
				"PRICE_CODE" => $arParams["PRICE_CODE"],
				"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
				"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
				"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
				"CURRENCY_ID" => $arParams["CURRENCY_ID"],
				"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
				"TEMPLATE_THEME" => (isset($arParams["TEMPLATE_THEME"]) ? $arParams["TEMPLATE_THEME"] : ""),

				"ADD_PICT_PROP" => (isset($arParams["ADD_PICT_PROP"]) ? $arParams["ADD_PICT_PROP"] : ""),

				"LABEL_PROP" => (isset($arParams["LABEL_PROP"]) ? $arParams["LABEL_PROP"] : ""),
				"OFFER_ADD_PICT_PROP" => (isset($arParams["OFFER_ADD_PICT_PROP"]) ? $arParams["OFFER_ADD_PICT_PROP"] : ""),
				"OFFER_TREE_PROPS" => (isset($arParams["OFFER_TREE_PROPS"]) ? $arParams["OFFER_TREE_PROPS"] : ""),
				"SHOW_DISCOUNT_PERCENT" => (isset($arParams["SHOW_DISCOUNT_PERCENT"]) ? $arParams["SHOW_DISCOUNT_PERCENT"] : ""),
				"SHOW_OLD_PRICE" => (isset($arParams["SHOW_OLD_PRICE"]) ? $arParams["SHOW_OLD_PRICE"] : ""),
				"MESS_BTN_BUY" => (isset($arParams["MESS_BTN_BUY"]) ? $arParams["MESS_BTN_BUY"] : ""),
				"MESS_BTN_ADD_TO_BASKET" => (isset($arParams["MESS_BTN_ADD_TO_BASKET"]) ? $arParams["MESS_BTN_ADD_TO_BASKET"] : ""),
				"MESS_BTN_DETAIL" => (isset($arParams["MESS_BTN_DETAIL"]) ? $arParams["MESS_BTN_DETAIL"] : ""),
				"MESS_NOT_AVAILABLE" => (isset($arParams["MESS_NOT_AVAILABLE"]) ? $arParams["MESS_NOT_AVAILABLE"] : ""),
				'ADD_TO_BASKET_ACTION' => (isset($arParams["ADD_TO_BASKET_ACTION"]) ? $arParams["ADD_TO_BASKET_ACTION"] : ""),
				'SHOW_CLOSE_POPUP' => (isset($arParams["SHOW_CLOSE_POPUP"]) ? $arParams["SHOW_CLOSE_POPUP"] : ""),
				'DISPLAY_COMPARE' => (isset($arParams['DISPLAY_COMPARE']) ? $arParams['DISPLAY_COMPARE'] : ''),
				'COMPARE_PATH' => (isset($arParams['COMPARE_PATH']) ? $arParams['COMPARE_PATH'] : ''),
			)
			+ array(
				'OFFER_ID' => empty($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID']) ? $arResult['ID'] : $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'],
				'SECTION_ID' => $arResult['SECTION']['ID'],
				'ELEMENT_ID' => $arResult['ID'],
			),
			$component,
			array("HIDE_ICONS" => "Y")
	);

}

?>

</div>