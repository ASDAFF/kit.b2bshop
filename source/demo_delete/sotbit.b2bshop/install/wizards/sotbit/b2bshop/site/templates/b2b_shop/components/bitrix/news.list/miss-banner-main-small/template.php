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
<div class="block_small_banner">
    <div class='container'>
        <div class='row'>
            <?$cnt=0;?>
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?$cnt++;?>
	            <?
	            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	            ?>     
                <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                    <?if($cnt == 1):?>
                        <div class='col-xs-8 sm-padding-left-no xs-padding-right-no'>
                    <?elseif($cnt == 2):?>
                        <div class='col-xs-8 sm-padding-min xs-padding-min'>
                    <?elseif($cnt == 3):?>
                         <div class='col-xs-8 sm-padding-right-no xs-padding-left-no'>
                    <?elseif($cnt == 4): 
                        break;
                    endif;?>
                    <?if($arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]):?>
	                <a class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>" href="<?=htmlspecialcharsEx($arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"])?>">
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
                       <span class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <img
                            class="img-responsive"
                            src="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["SRC"]?>"
                            width="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"]?>"
                            height="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"]?>"
                            alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                            title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                            />
                        </span>                  
                    <?endif?>                    
                    </div>
                <?endif?>
                
            <?endforeach;?>
        </div>
    </div>
</div>
<?endif;?>