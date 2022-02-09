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
<?if(count($arResult["ITEMS"])):?>
<div class="block_banner">
    <div class='container'>
        <div class='row'>
          <div class="col-sm-24 sm-padding-no">
            <div id="main-banner" class="banner-inner" data-width="<?=$arParams['LIST_WIDTH_IMG']?>" data-height="<?=$arParams["LIST_HEIGHT_IMG"]?>">
            <?$item_absolute = false;?>
            <?foreach($arResult["ITEMS"] as $arItem):?>
	            <?
	            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	            ?>
                <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"]) && isset($arItem["PREVIEW_PICTURE"]['ID']) && !empty($arItem["PREVIEW_PICTURE"])):?>         
                   <?if($arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]):?>
	                    <a class="item <?if($item_absolute):?>item_absolute<?endif;?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" href="<?=htmlspecialcharsEx($arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"])?>">
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
                        <a class="item <?if($item_absolute):?>item_absolute<?endif;?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">    
                        <img
                            class="img-responsive"
                            src="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["SRC"]?>"
                            width="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"]?>"
                            height="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"]?>"
                            alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                            title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                            />              
                        </a>
                    <?endif?>
                   <?$item_absolute = true;?>
                <?elseif(isset($arItem["VIDEO"]) && !empty($arItem["VIDEO"])):?>
					<?=$arItem["VIDEO"]?>
                <?endif?>
            <?endforeach;?>
            </div>
          </div>    
        </div>
    </div>
</div>
<?endif;?>
