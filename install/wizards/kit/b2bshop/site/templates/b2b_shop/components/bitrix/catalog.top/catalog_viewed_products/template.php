<?
if (! defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true)
	die();
if (! CModule::IncludeModule( "kit.b2bshop" ))
	return false;
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
			}
		})
		$(function() {
			var msListPV = new msListProduct({
				"arImage" : <? echo CUtil::PhpToJSObject($arResult['MORE_PHOTO_JS'], false, true); ?>,
				"listBlock" : "#block-you-slider",
				"listItem" : ".one-item",
				"listItemSmalImg" : ".small_img_js",
				"mainItemImage" : ".big_img_js",
				"listItemOpen" : ".item_open .buy_now_top",
				"btnLeft" : ".bnt_left",
				"btnRight" : ".bnt_right",
				"sizes":<?=CUtil::PhpToJSObject(array('SMALL'=>array('WIDTH'=>$arParams["LIST_WIDTH_SMALL"],'HEIGHT'=>$arParams["LIST_HEIGHT_SMALL"]),'MEDIUM'=>array('WIDTH'=>$arParams["LIST_WIDTH_MEDIUM"],'HEIGHT'=>$arParams["LIST_HEIGHT_MEDIUM"]),'RESIZE'=>$ResizeMode), false, true); ?>,
			});
		})
	</script>
	<div class="col-sm-24 sm-padding-right-no">
		<div class="block_you_look_big">
			<div class="block_you_look_big_bg"></div>
			<h2 class="title"><?=GetMessage("MS_PV_YOU_SEE")?></h2>
			<div class="wrap-block-you-slider">
				<div id="block-you-slider" class="block-you-slider">
					<?
						foreach ( $arResult['ITEMS'] as $arItem )
						{
							$ID = $arItem["ID"];
							$APPLICATION->IncludeFile(SITE_DIR."include/miss-product.php",
									Array('ITEM'=>$arItem, 'PHOTOS'=>$arResult["MORE_PHOTO_JS"][$ID],'PARAMS'=>$arParams,'BRANDS'=>$arResult["BRANDS"],'RAND'=>$arResult["RAND"],'PROP_NAME'=>$arResult["PROP_NAME"]),
									Array("MODE"=>"php",'SHOW_BORDER'=>false)
									);
						}
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
		$APPLICATION->IncludeComponent( "kit:kit.quick.view_new", "", Array(
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