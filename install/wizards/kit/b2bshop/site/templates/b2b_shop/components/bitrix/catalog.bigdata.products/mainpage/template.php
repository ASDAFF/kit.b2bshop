<?
if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true )
	die();

$frame = $this->createFrame()->begin( "" );

$injectId = $arParams['UNIQ_COMPONENT_ID'];

if( isset( $arResult['REQUEST_ITEMS'] ) )
{
	// code to receive recommendations from the cloud
	CJSCore::Init( array(
			'ajax'
	) );

	// component parameters
	$signer = new \Bitrix\Main\Security\Sign\Signer();
	$signedParameters = $signer->sign( base64_encode( serialize( $arResult['_ORIGINAL_PARAMS'] ) ), 'bx.bd.products.recommendation' );
	$signedTemplate = $signer->sign( $arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation' );

	?>

<span id="<?=$injectId?>"></span>

<script type="text/javascript">
		BX.ready(function(){
			bx_rcm_get_from_cloud(
				'<?=CUtil::JSEscape($injectId)?>',
				<?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
				{
					'parameters':'<?=CUtil::JSEscape($signedParameters)?>',
					'template': '<?=CUtil::JSEscape($signedTemplate)?>',
					'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
					'rcm': 'yes'
				}
			);
		});
	</script>
<?
	$frame->end();
	return;

	// \ end of the code to receive recommendations from the cloud
}

// regular template then
// if customized template, for better js performance don't forget to frame content with <span id="{$injectId}_items">...</span>

if( !empty( $arResult['ITEMS'] ) )
{
	?>
	<script type="text/javascript">
		$(function() {
			if($(".block-bigdata-mainpage").length) {

				$('.block-bigdata-mainpage').css({'width': '100%'});
				$('.block-bigdata-mainpage .item').css({'float': 'none'});
				$(".block-bigdata-mainpage").owlCarousel({
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
								items:4
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
			var msListBD = new msListProduct({
				"arImage" : <? echo CUtil::PhpToJSObject($arResult['MORE_PHOTO_JS'], false, true); ?>,
				"listBlock" : "#buy-now-slider",
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
	<div class="block_buy_now">
		<span id="<?=$injectId?>_items">
			<div class='container'>
				<div class='row'>
					<div class="col-sm-24 sm-padding-no">
						<div class="block-bigdata-mainpage-wrapper">
							<h2 class="title"><?=GetMessage("MS_PV_BIG_DATA_SECTION")?></h2>
							<div class="wrap-buy-now-slider">
								<div id="buy-now-slider" class="block-bigdata-mainpage">
									<?
									foreach( $arResult['ITEMS'] as $key => $arItem )
									{
										$ID = $arItem["ID"];
										$APPLICATION->IncludeFile( SITE_DIR . "include/miss-product.php",
												Array(
														'ITEM' => $arItem,
														'PHOTOS' => $arResult["MORE_PHOTO_JS"][$ID],
														'PARAMS' => $arParams,
														'BRANDS' => $arResult["BRANDS"],
														'RAND' => $arResult["RAND"],
														'PROP_NAME' => $arResult["PROP_NAME"]
												), Array(
														"MODE" => "php",
														'SHOW_BORDER' => false
												) );
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</span>
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

$frame->end();