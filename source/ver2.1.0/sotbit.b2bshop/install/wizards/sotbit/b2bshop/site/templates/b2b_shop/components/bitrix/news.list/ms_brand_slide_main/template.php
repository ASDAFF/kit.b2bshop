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

<div id="block_brand" class="block_brand hidden-xs"> 
<div class='container'>
    <div class='row'>
        <div class='col-sm-24 sm-padding-no'>
            <h3 class="block_title">
                <?if($arParams["DISPLAY_BLOCK_TITLE_TEXT"]){
                    echo $arParams["DISPLAY_BLOCK_TITLE_TEXT"]; 
                }  else {
                    echo $arResult["NAME"];  
                }
                if($arParams["DISPLAY_BLOCK_TITLE_TEXT_SECOND"]){
                    echo " <span>".$arParams["DISPLAY_BLOCK_TITLE_TEXT_SECOND"]."</span>";  
                }?>
            </h3>
        </div>
    </div>
    
    <div class='row'>
        <div class="block_brand_wrap">
            <div class="block_brand_inner">
                <div class="block_wrap_carousel">
                <div class="block_carousel">    
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                        <img
                            class="img-responsive"
                            src="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["SRC"]?>"
                            width="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"]?>"
                            height="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"]?>"
                            alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                            title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                            /> 
                </a>
			<?else:?>
                        <img
                            class="img-responsive"
                            src="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["SRC"]?>"
                            width="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"]?>"
                            height="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"]?>"
                            alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                            title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                            /> 
			<?endif;?>
		<?endif?>
	</div>
<?endforeach;?>
        </div>  <?/*end block_carousel*/?>
        <div class='clear'></div>
        </div> <?/*end block_wrap_carousel*/?>
        </div>  <?/*end block_brand_inner*/?>
    </div>   <?/*end block_brand_wrap*/?>   
    </div>  <?/*end row*/?>
</div>  <?/*end container*/?>
</div>  <?/*end block_brand*/?>