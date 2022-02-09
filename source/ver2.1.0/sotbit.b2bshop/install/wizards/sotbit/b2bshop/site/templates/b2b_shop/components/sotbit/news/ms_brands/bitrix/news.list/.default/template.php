<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?if (!empty($arResult['BLOCK_ITEMS'])):?>
  
<div class="brand_list">  
    <?foreach($arResult["BLOCK_ITEMS"] as $arBlockItem):?>
    <div class="row">
        <?foreach($arBlockItem as $arItem):?> 
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('NEWS_ELEMENT_DELETE_CONFIRM')));
            ?>            
        <div class="col-xs-12 col-sm-4" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="brand_cart_wrap" onclick="">
                <span class="brand_cart">
                    <span class="brand_cart_inner">
                    <?if($arItem['PREVIEW_PICTURE']['SRC']):?>
                        <img class="img-responsive" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" width="120" title="" alt=""/>
                    <?endif;?>
                    </span>
                </span>
                <span class="brand_name">
                    <?=$arItem["NAME"]?>
                </span>
            </a>
        </div>        
        <?endforeach;?>   
    </div>
    <?endforeach;?>  
</div>    
<?endif;?>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>




