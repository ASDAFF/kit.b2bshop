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
<?if (count($arResult["ITEMS"]) < 1)return;?>

<div class="bl_right">
    <div class="news_slide">
        <ul class="slides">
<?$item_absolute = false;?>        
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<li class="item <?if($item_absolute):?>item_absolute<?endif;?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    
    
    
    <!--VIDEO START-->
            <?if(isset($arResult["VIDEO"][$arItem["ID"]]) && is_array($arResult["VIDEO"][$arItem["ID"]]) && count($arResult["VIDEO"][$arItem["ID"]])>0):?>
            	<?foreach($arResult["VIDEO"][$arItem["ID"]] as $Video):?>
            		<?=$Video?>
            	<?endforeach;?>
            <?endif;?>
    <!--VIDEO END-->
    
        <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
            <p class="title">
            <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
            <?else:?>
                <?echo $arItem["NAME"]?>
            <?endif;?>
            </p> 
        <?endif;?>
    
        <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
            <p class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
        <?endif?>        
            <!--VIDEO START -->
            <?if(isset($arItem["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"]) && is_array($arItem["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"]) && count($arItem["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"])>0):?>
            <?foreach($arItem["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"] as $Video):?>
           		 <?//YOUTUBE?>
            	<?if(strpos($Video,"youtube.com")):?>
					<iframe src="<?=$Video?>" frameborder="0" allowfullscreen></iframe>
                <?endif;?>
            <?endforeach;?>
            <?endif;?>
            <!--VIDEO END -->
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<a class="wrap_img" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img
						class="img-responsive"
						src="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["SRC"]?>"
						width="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"]?>"
						height="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"]?>"
						alt="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["ALT"]?>"
						title="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["TITLE"]?>"
						/></a>
			<?else:?>
                <span class="wrap_img">
				<img
					class="img-responsive"
					src="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["SRC"]?>"
					width="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"]?>"
					height="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"]?>"
					alt="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["ALT"]?>"
					title="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["TITLE"]?>"
					/>
                 </span>   
			<?endif;?>
		<?endif?>
        

		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
            <p class=text>
			    <?echo $arItem["PREVIEW_TEXT"];?>
            </p>
		<?endif;?>

        <?if((!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])) && !empty($arParams["LIST_GO_DETAIL_PAGE"])):?>
            <div class="wrap_go_detail">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arParams["LIST_GO_DETAIL_PAGE"]?></a>
            </div>
        <?endif;?>
	</li>
    <?$item_absolute = true;?>
<?endforeach;?>
        </ul> 
    </div>
</div>  <!--end bl_right_wrap -->