<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;
if(!CModule::IncludeModule("sotbit.b2bshop") || !B2BSSotbit::getDemo()) return false;
$this->setFrameMode(true);
$frame = $this->createFrame('ms_online_buyers')->begin();
if (!empty($arResult['ITEMS']))
{
	?>
		<script type="text/javascript">
		$(function() {
			var msListOnline = new msListProduct({
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
		<?
	$arPoint = $arParams["FLAG_PROPS"];
	$brandElementCode = $arParams["MANUFACTURER_ELEMENT_PROPS"];
	$brandListCode = $arParams["MANUFACTURER_LIST_PROPS"];
	$countRow = 4;

	$rand = $arResult["RAND"];
	
	?>
	<div class="block_buy_now">
		<div class='container'>
			<div class='row'>
				<div class='col-sm-14 sm-padding-left-no'>
					<h3 class="block_title"><?=GetMessage("SHS_ONLINE_NOW_BUY")?> <span><?=GetMessage("MS_SHS_ONLINE_NOW_BUY")?></span></h3>
				</div>
				<?if($arParams["USERS_COUNT_TEXT"]):?>
				<div class='col-sm-10 sm-padding-right-no'>		 
					<h3 class="wrap_online">  
						<span class="block_online"><span><?=$arParams["USERS_COUNT_TEXT"]?> online</span></span>
					</h3>			   
				</div>
				<?endif;?>
			</div>
			
			<div class='row'>
				<div class="wrap-buy-now-slider">
				<div id="buy-now-slider">
					<?foreach($arResult["ITEMS"] as $k=>$arItem):
					$ID = $arItem["ID"];
					?>
					<?
					$APPLICATION->IncludeFile(SITE_DIR."include/miss-product.php",
							Array('ITEM'=>$arItem, 'PHOTOS'=>$arResult["MORE_PHOTO_JS"][$ID],'PARAMS'=>$arParams,'BRANDS'=>$arResult["BRANDS"],'RAND'=>$arResult["RAND"],'PROP_NAME'=>$arResult["PROP_NAME"]),
							Array("MODE"=>"php",'SHOW_BORDER'=>false)
							);?>
					<?endforeach?>
				</div>
				</div>
			</div>
		</div>
	</div>
	<?
}
$frame->end();
?>
