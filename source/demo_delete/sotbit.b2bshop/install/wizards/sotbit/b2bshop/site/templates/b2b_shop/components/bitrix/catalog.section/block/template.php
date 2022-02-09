<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;

global $sotbitSeoMetaH1;
global $sotbitSeoMetaBottomDesc;

if(isset($arResult["NAME"]) && $arResult["NAME"])
{?>
<div class="col-sm-24 sm-padding-right-no">
	<div class="inner_title_brand">
		<h1 class="text">
			<?if($sotbitSeoMetaH1)
			{
				echo $sotbitSeoMetaH1;
			}
			elseif($arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'])
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
	global $sotbitSeoMetaTopDesc;
	if(isset($sotbitSeoMetaTopDesc) && !empty($sotbitSeoMetaTopDesc))
	{
		echo $sotbitSeoMetaTopDesc;
	}
	?>
</div>
<?}

if($arParams['SEOMETA_TAGS'] == 'TOP' || $arParams['SEOMETA_TAGS'] == 'ALL')
{
	$APPLICATION->IncludeComponent(
			"sotbit:seo.meta.tags",
			"",
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

if(Loader::includeModule('sotbit.b2bshop'))
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
	$APPLICATION->IncludeFile(SITE_DIR."include/miss_page_sort_catalog.php",
		Array($arResult, $arParams, "top"),
		Array("MODE"=>"php")
	);
}
$brandElementCode = $arParams["MANUFACTURER_ELEMENT_PROPS"];

$colorCode = ($arParams["COLOR_IN_PRODUCT"]=='Y'&&isset($arParams['COLOR_IN_PRODUCT_CODE'])&&!empty($arParams['COLOR_IN_PRODUCT_CODE']))?$arParams['COLOR_IN_PRODUCT_CODE']:$arParams["OFFER_COLOR_PROP"];
$ResizeMode = (! empty ( $arParams["IMAGE_RESIZE_MODE"] ) ? $arParams["IMAGE_RESIZE_MODE"] : BX_RESIZE_IMAGE_PROPORTIONAL);
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
		"listItemSmalImg" : ".small_img_js",
		"mainItemImage" : ".big_img_js",
		"sizes":<?=CUtil::PhpToJSObject(array('SMALL'=>array('WIDTH'=>$arParams["LIST_WIDTH_SMALL"],'HEIGHT'=>$arParams["LIST_HEIGHT_SMALL"]),'MEDIUM'=>array('WIDTH'=>$arParams["LIST_WIDTH_MEDIUM"],'HEIGHT'=>$arParams["LIST_HEIGHT_MEDIUM"]),'RESIZE'=>$ResizeMode), false, true); ?>,
		"listItemOpen" : ".item_open .item-top-part",
		"items":<?=CUtil::PhpToJSObject($arResult['ITEMS_AJAX'], false, true); ?>,
		"openItem":"#section_list .item",
		"btnLeft" : ".bnt_left",
		"btnRight" : ".bnt_right",
		"SiteDir":"<?=SITE_DIR?> ?>",
		"FilterClose":".block_form_filter .filter_block",
		"ajax_filter_path":"include/ajax/filter.php",
		"Url":"<?=$APPLICATION->GetCurPage()?>",
		'bigData': <?=CUtil::PhpToJSObject($arResult['BIG_DATA'])?>,
	});
})
</script>

<?

if (!empty($arResult['BLOCK_ITEMS']))
{
	$k = 0;
	$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
	$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
	$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
	foreach($arResult["BLOCK_ITEMS"] as $arBlockItem)
	{
	?>
		<div class="row">
			<?foreach($arBlockItem as $arItem)
			{
				$countItem = 0;
				$ID = $arItem["ID"];
				$firstColor = $arItem["FIRST_COLOR"];
				$item['MIN_PRICE'] = $arItem["MIN_PRICE"];
				$brandName = $arItem["PROPERTIES"][$brandListCode]["VALUE"];
				$brandID = $arItem["PROPERTIES"][$brandElementCode]["VALUE"];
				//$brandURL = $arResult["BRANDS"][$brandID]["DETAIL_PAGE_URL"];
				$this->AddEditAction($arBlockItem['ID'], $arBlockItem['EDIT_LINK'], $strElementEdit);
				$this->AddDeleteAction($arBlockItem['ID'], $arBlockItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
				$strMainID = $this->GetEditAreaId($arItem['ID']);
				?>
				<div class="col-xs-12 col-sm-<?=intval(24/$arParams['PAGE_ELEMENT_COUNT_IN_ROW'])?>"  id="<?= $strMainID; ?>">
					<?
					$APPLICATION->IncludeFile(SITE_DIR."include/miss-product.php",
							Array('ITEM'=>$arItem, 'PHOTOS'=>$arResult["MORE_PHOTO_JS"][$ID],'PARAMS'=>$arParams,'BRANDS'=>$arResult["BRANDS"],'RAND'=>$arResult["RAND"],'PROP_NAME'=>$arResult["PROP_NAME"]),
							Array("MODE"=>"php",'SHOW_BORDER'=>false)
							);?>
				</div>
				<?
				$k++;
			}?>
		</div>
	<?
	}
}else
	echo GetMessage("B2BS_CATALOG_NOTFOUND");
?>
	</div>
</div>



<?
if(Loader::includeModule('sotbit.b2bshop'))
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
//SEOMETA START
if($arResult["~DESCRIPTION"] || (isset($sotbitSeoMetaBottomDesc) && !empty($sotbitSeoMetaBottomDesc)))
{
?>
<div class="col-sm-24 sm-padding-right-no">
	<div class="section_description">
		<?
		if(!isset($sotbitSeoMetaBottomDesc) || empty($sotbitSeoMetaBottomDesc))
		{
			echo $arResult["~DESCRIPTION"];
		}
		else
		{
			echo $sotbitSeoMetaBottomDesc;
		}
		?>
	</div>
</div>
<?}

if($arParams['SEOMETA_TAGS'] == 'BOTTOM' || $arParams['SEOMETA_TAGS'] == 'ALL')
{
	$APPLICATION->IncludeComponent(
			"sotbit:seo.meta.tags",
			"",
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