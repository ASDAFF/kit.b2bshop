<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$frame = $this->createFrame()->begin();

global $sotbitSeoMetaH1;
global $sotbitSeoMetaBottomDesc;
global $sotbitSeoMetaTopDesc;
if(isset($sotbitSeoMetaTopDesc) && !empty($sotbitSeoMetaTopDesc))
{
	echo $sotbitSeoMetaTopDesc;
}

$APPLICATION->IncludeFile(SITE_DIR."include/miss_page_sort_catalog.php",
	Array($arResult, $arParams, "top"),
	Array("MODE"=>"php")
);

$arPoint = $arParams["FLAG_PROPS"];
$brandElementCode = $arParams["MANUFACTURER_ELEMENT_PROPS"];
$brandListCode = $arParams["MANUFACTURER_LIST_PROPS"];
?>
<div class="col-sm-24 sm-padding-right-no">
	<div id="section_list">
<?
$countRow = 4;

?>
<script type="text/javascript">
$(function() {
	var msList = new msListProduct({
		"arImage" : <? echo CUtil::PhpToJSObject($arResult['MORE_PHOTO_JS'], false, true); ?>,
		"listBlock" : "#section_list",
		"listItem" : ".one-item",
		"listItemSmalImg" : ".small_img_js",
		"mainItemImage" : ".big_img_js",
		"listItemOpen" : ".item_open .item-top-part",
		"btnLeft" : ".bnt_left",
		"btnRight" : ".bnt_right",
		"sizes":<?=CUtil::PhpToJSObject(array('SMALL'=>array('WIDTH'=>$arParams["LIST_WIDTH_SMALL"],'HEIGHT'=>$arParams["LIST_HEIGHT_SMALL"]),'MEDIUM'=>array('WIDTH'=>$arParams["LIST_WIDTH_MEDIUM"],'HEIGHT'=>$arParams["LIST_HEIGHT_MEDIUM"]),'RESIZE'=>$ResizeMode), false, true); ?>,
		"CntInRow":<?=$arParams['PAGE_ELEMENT_COUNT_IN_ROW']?> ,
	});
})
</script>
<?
$rand = $arResult["RAND"];
?>
<?
if (!empty($arResult['BLOCK_ITEMS']))
{   $k = 0;
	foreach($arResult["BLOCK_ITEMS"] as $arBlockItem):
	?>
		<div class="row">
			<?foreach($arBlockItem as $arItem):
			$countItem = 0;
			$ID = $arItem["ID"];
			$firstColor = $arItem["FIRST_COLOR"];
			$arPrice = $arItem["MIN_PRICE"];
			$brandName = $arItem["PROPERTIES"][$brandListCode]["VALUE"];
			$brandID = $arItem["PROPERTIES"][$brandElementCode]["VALUE"];
			$brandURL = $arResult["BRANDS"][$brandID]["DETAIL_PAGE_URL"];
			$colorCode = (isset($arParams["COLOR_IN_PRODUCT"])&&$arParams["COLOR_IN_PRODUCT"]&&isset($arParams['COLOR_IN_PRODUCT_CODE'])&&!empty($arParams['COLOR_IN_PRODUCT_CODE']))?$arParams['COLOR_IN_PRODUCT_CODE']:$arParams["OFFER_COLOR_PROP"];
			$propName = "";
			?>
			<div class="col-xs-12 col-sm-<?=intval(24/$arParams['PAGE_ELEMENT_COUNT_IN_ROW'])?>">

				<?
				$APPLICATION->IncludeFile(SITE_DIR."include/miss-product.php",
						Array('ITEM'=>$arItem, 'PHOTOS'=>$arResult["MORE_PHOTO_JS"][$ID],'PARAMS'=>$arParams,'BRANDS'=>$arResult["BRANDS"],'RAND'=>$arResult["RAND"],'PROP_NAME'=>$arResult["PROP_NAME"]),
						Array("MODE"=>"php",'SHOW_BORDER'=>false)
						);?>
			</div>
			<?
			$k++;
			endforeach?>
		</div>

	<?
	endforeach;
}else
	echo GetMessage("B2BS_CATALOG_NOTFOUND");
?>
	</div>
</div>
<?
$APPLICATION->IncludeFile(SITE_DIR."include/miss_page_sort_catalog.php",
	Array($arResult, $arParams, "bottom"),
	Array("MODE"=>"php")
);
//SEOMETA START
if($arResult["~DESCRIPTION"] || (isset($sotbitSeoMetaBottomDesc) && !empty($sotbitSeoMetaBottomDesc))):
//SEOMETA END
?>
<div class="col-sm-24 sm-padding-right-no">
	<div class="section_description">
		<?
		//SEOMETA START
		if(!isset($sotbitSeoMetaBottomDesc) || empty($sotbitSeoMetaBottomDesc))
			echo $arResult["~DESCRIPTION"];
		else
			echo $sotbitSeoMetaBottomDesc;
		//SEOMETA END
		?>
	</div>
</div>
<?endif;
?>