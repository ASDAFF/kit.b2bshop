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

<div class="block_popular">
<?if(!empty($arParams["POPULAR_TITLE"])):?>
    <h2 class="title"><?=$arParams["POPULAR_TITLE"]?></h2> 
<?endif;?>

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="news_one" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <?if($arParams["POPULAR_DISPLAY_SECTION"]!="N" && is_array($arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]])):?>
            <h4 class="title_section"><a href="<?=$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["SECTION_PAGE_URL"]?>"><?=$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["NAME"]?></a></h4> 
        <?endif;?>
        
        <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
            <p class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
        <?endif?>        
    <!--VIDEO START-->
            <?if(isset($arResult["VIDEO"][$arItem["ID"]]) && is_array($arResult["VIDEO"][$arItem["ID"]]) && count($arResult["VIDEO"][$arItem["ID"]])>0):?>
            	<?foreach($arResult["VIDEO"][$arItem["ID"]] as $Video):?>
            		<?=$Video?>
            	<?endforeach;?>
            <?endif;?>
    <!--VIDEO END-->
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
        
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
            <h4 class="name">
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
			<?else:?>
				<?echo $arItem["NAME"]?>
			<?endif;?>
            </h4> 
		<?endif;?>
        

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
	</div>
<?endforeach;?>
</div>
