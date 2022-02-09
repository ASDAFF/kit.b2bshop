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
?>
<div class="main_block_news">
    <div class='container'>
        <div class="row">
            <div class="col-sm-24 sm-padding-no">
            <h3 class="block_title">
                <?if($arParams["DISPLAY_BLOCK_TITLE_TEXT"]){
                    echo $arParams["DISPLAY_BLOCK_TITLE_TEXT"]; 
                }  else {
                    echo $arResult["IBLOCK_NAME"];  
                }
                
                if($arParams["DISPLAY_BLOCK_TITLE_TEXT_SECOND"]){
                    echo " <span>".$arParams["DISPLAY_BLOCK_TITLE_TEXT_SECOND"]."</span>";  
                }?>
            </h3>
            <div class="wrap_news">
            <div class="row">            
            
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"",
	Array(
		"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
		"NEWS_COUNT"	=>	$arParams["NEWS_COUNT"],
		"SORT_BY1"	=>	$arParams["SORT_BY1"],
		"SORT_ORDER1"	=>	$arParams["SORT_ORDER1"],
		"SORT_BY2"	=>	$arParams["SORT_BY2"],
		"SORT_ORDER2"	=>	$arParams["SORT_ORDER2"],
		"FIELD_CODE"	=>	$arParams["LIST_FIELD_CODE"],
		"PROPERTY_CODE"	=>	$arParams["LIST_PROPERTY_CODE"],
		"DETAIL_URL"	=>	"",   /*$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"]*/
		"DISPLAY_PANEL"	=>	$arParams["DISPLAY_PANEL"],
		"SET_TITLE"	=>	$arParams["SET_TITLE"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"INCLUDE_IBLOCK_INTO_CHAIN"	=>	$arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
		"CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
		"CACHE_TIME"	=>	$arParams["CACHE_TIME"],
		"CACHE_FILTER"	=>	$arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"DISPLAY_TOP_PAGER"	=>	"N",
		"DISPLAY_BOTTOM_PAGER"	=>	"N",
		"PAGER_TITLE"	=>	$arParams["PAGER_TITLE"],
		"PAGER_TEMPLATE"	=>	$arParams["PAGER_TEMPLATE"],
		"PAGER_SHOW_ALWAYS"	=>	$arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_DESC_NUMBERING"	=>	$arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME"	=>	$arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
		"DISPLAY_DATE_FIRST"	=>	$arParams["DISPLAY_DATE_FIRST"],
		"DISPLAY_NAME"	=>	"Y",
		"DISPLAY_PICTURE_FIRST"	=>	$arParams["DISPLAY_PICTURE_FIRST"],
		"DISPLAY_PREVIEW_TEXT_FIRST"	=>	$arParams["DISPLAY_PREVIEW_TEXT_FIRST"],
        "DISPLAY_DATE_OTHER"    =>    $arParams["DISPLAY_DATE_OTHER"],        
		"PREVIEW_TRUNCATE_LEN"	=>	$arParams["PREVIEW_TRUNCATE_LEN"],
		"ACTIVE_DATE_FORMAT"	=>	$arParams["LIST_ACTIVE_DATE_FORMAT"],
		"USE_PERMISSIONS"	=>	$arParams["USE_PERMISSIONS"],
		"GROUP_PERMISSIONS"	=>	$arParams["GROUP_PERMISSIONS"],
		"FILTER_NAME"	=>	$arParams["FILTER_NAME"],
		"HIDE_LINK_WHEN_NO_DETAIL"	=>	$arParams["HIDE_LINK_WHEN_NO_DETAIL"],
		"CHECK_DATES"	=>	$arParams["CHECK_DATES"],
        "LIST_HEIGHT_IMG_FIRST" => $arParams["LIST_HEIGHT_IMG_FIRST"],
        "LIST_WIDTH_IMG_FIRST" =>  $arParams["LIST_WIDTH_IMG_FIRST"],
        
	),
	$component
);?>


            <div class="col-sm-8 col-lg-offset-1">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "ms_slide",
                    Array(
                        "IBLOCK_TYPE"    =>    $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID"    =>    $arParams["IBLOCK_ID"],
                        "NEWS_COUNT"    =>    $arParams["POPULAR_NEWS_COUNT"],
                        "SORT_BY1"    =>    $arParams["POPULAR_SORT_BY1"],
                        "SORT_ORDER1"    =>    $arParams["POPULAR_SORT_ORDER1"],
                        "SORT_BY2"    =>    $arParams["POPULAR_SORT_BY2"],
                        "SORT_ORDER2"    =>    $arParams["POPULAR_SORT_ORDER2"],
                        "FIELD_CODE"    =>    "",   /*$arParams["LIST_FIELD_CODE"]*/
                        "PROPERTY_CODE"	=>	$arParams["LIST_PROPERTY_CODE"],
                        "DETAIL_URL"    =>    "",   /*$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"]*/
                        "DISPLAY_PANEL"    =>    $arParams["DISPLAY_PANEL"],
                        "SET_TITLE"    =>    "N",
                        "SET_STATUS_404" => "N",
                        "INCLUDE_IBLOCK_INTO_CHAIN"    =>    "N",
                        "CACHE_TYPE"    =>    $arParams["CACHE_TYPE"],
                        "CACHE_TIME"    =>    $arParams["CACHE_TIME"],
                        "CACHE_FILTER"    =>    $arParams["CACHE_FILTER"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "DISPLAY_TOP_PAGER"    =>    "N",
                        "DISPLAY_BOTTOM_PAGER"    =>    'N',
                        "PAGER_TITLE"    =>    $arParams["PAGER_TITLE"],
                        "PAGER_TEMPLATE"    =>    $arParams["PAGER_TEMPLATE"],
                        "PAGER_SHOW_ALWAYS"    =>    $arParams["PAGER_SHOW_ALWAYS"],
                        "PAGER_DESC_NUMBERING"    =>    $arParams["PAGER_DESC_NUMBERING"],
                        "PAGER_DESC_NUMBERING_CACHE_TIME"    =>    $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                        "ACTIVE_DATE_FORMAT"    =>    $arParams["LIST_ACTIVE_DATE_FORMAT"],
                        "USE_PERMISSIONS"    =>    $arParams["USE_PERMISSIONS"],
                        "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],                    
                        "FILTER_NAME"    =>    $arParams["FILTER_NAME"],
                        "HIDE_LINK_WHEN_NO_DETAIL"    =>    $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                        "CHECK_DATES"    =>    $arParams["CHECK_DATES"],
                        "LIST_GO_DETAIL_PAGE" =>  $arParams["POPULAR_GO_DETAIL_PAGE"],
                        "DISPLAY_DATE"    =>    $arParams["POPULAR_DISPLAY_DATE"],
                        "DISPLAY_NAME"    =>    'Y',
                        "DISPLAY_PICTURE"    =>    $arParams["POPULAR_DISPLAY_PICTURE"],
                        "POPULAR_HEIGHT_IMG" => $arParams["POPULAR_HEIGHT_IMG"],
                        "POPULAR_WIDTH_IMG" =>  $arParams["POPULAR_WIDTH_IMG"],                    
                        "DISPLAY_PREVIEW_TEXT"    =>    $arParams["POPULAR_DISPLAY_PREVIEW_TEXT"],
                        "PREVIEW_TRUNCATE_LEN"    =>    $arParams["POPULAR_TRUNCATE_LEN"],
                        
                    ),
                    $component
                );?>   
            </div>

            </div>  <?/*end row*/?>
            </div>  <?/*end wrap_news*/?>
            </div>  <?/*end col-sm-24 sm-padding-no*/?>
        </div>   <?/*end container*/?>
    </div>   <?/*end row*/?>
</div>  <?/*end main_block_news*/?>