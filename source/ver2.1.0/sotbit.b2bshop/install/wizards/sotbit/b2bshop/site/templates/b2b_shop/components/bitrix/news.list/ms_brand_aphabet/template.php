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
<?if(is_array($arResult["ITEMS"]) && count($arResult["ITEMS"])>0):?>

<div class="main-top-block hidden-xs">
    <div class="container">
        <div class='row'>
            <div class="col-sm-4 col-md-4 col-lg-3 sm-padding-no">
                <span><?=GetMessage("CT_BNL_BRAND_ALPHA");?></span>
            </div>
                    <div class="col-sm-18 col-md-18 col-lg-19 sm-padding-no">
                        <div class="block_alpha">
                        <?if(is_array($arResult['ITEMS_APHABET']['ENG'])):?>
                            <ul id="alpha_eng" class="main-top-center">
                                <?foreach($arResult['ITEMS_APHABET']['ENG'] as $alpha => $arItems):?>
                                  <li><span class="alpha"><?=$alpha?></span> 
                                    <div class="alpha_inner">
                                        <div class='row'>                            
                                            <div class="col-sm-6">
                                                <div class="alpha_banner">
                                                    <?=$alpha?>
                                                </div>
                                            </div>                            
                                            <div class="col-sm-18 col-md-17">
                                                <ul>
                                                    <?foreach($arItems as $arItem):?>
                                                        <?
                                                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                                                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                                                        ?>                                                
                                                        <li id="<?=$this->GetEditAreaId($arItem['ID']);?>"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></li>
                                                    <?endforeach;?>
                                                </ul>
                                            </div>                                                                        
                                        </div>
                                    </div>                            
                                <?endforeach;?>
                            </ul>
                        <?endif;?>
                        <?if(is_array($arResult['ITEMS_APHABET']['RUS'])):?>
                            <ul id="alpha_rus" class="main-top-center" <?=(count($arResult['ITEMS_APHABET']['ENG'])!=0)?'style="display: none;"':'' ?>>
                                <?foreach($arResult['ITEMS_APHABET']['RUS'] as $alpha => $arItems):?>
                                  <li><span class="alpha"><?=$alpha?></span> 
                                    <div class="alpha_inner">
                                        <div class='row'>                            
                                            <div class="col-sm-6">
                                                <div class="alpha_banner">
                                                    <?=$alpha?>
                                                </div>
                                            </div>                            
                                            <div class="col-sm-18 col-md-17">
                                                <ul>
                                                    <?foreach($arItems as $arItem):?>
                                                        <?
                                                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                                                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                                                        ?>                                                
                                                        <li id="<?=$this->GetEditAreaId($arItem['ID']);?>"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></li>
                                                    <?endforeach;?>
                                                </ul>
                                            </div>                                                                        
                                        </div>
                                    </div>                            
                                <?endforeach;?>
                            </ul>
                        <?endif;?>
                        </div> <?/*end block_alpha*/?>                                           
                    </div>
                    
                    <div class="col-sm-2 col-md-2 col-lg-2 sm-padding-right-no">
                        <div class="main-top-right">
                            <?if(is_array($arResult['ITEMS_APHABET']['RUS']) && is_array($arResult['ITEMS_APHABET']['ENG'])):?>
                            <a href="#" id="toggle_alpha" class="left">
                              <span><?=GetMessage("CT_BNL_BRAND_RUS");?></span>
                              <span style="display: none;"><?=GetMessage("CT_BNL_BRAND_ENG");?></span>
                            </a>
                            <?endif;?>
                            <a href="<?=$arResult["LIST_PAGE_URL_"]?>"><?=GetMessage("CT_BNL_BRAND_ALL");?></a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
<?endif;?>