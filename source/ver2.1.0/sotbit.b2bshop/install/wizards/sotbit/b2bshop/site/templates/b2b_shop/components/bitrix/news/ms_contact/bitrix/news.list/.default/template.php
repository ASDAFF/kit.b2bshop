<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if (count($arResult["BLOCK_ITEMS"]) < 1)
	return;
?>


<?foreach($arResult["BLOCK_ITEMS"] as $section_id => $arBlockItem):?>
<div class="block_office">
    <h3 class="block_title"><?=$arResult["SECTION"][$section_id]['NAME']?></h3>
    <?$i=0?>
    <?foreach($arBlockItem as $arItem):?>
    <?
	    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('NEWS_ELEMENT_DELETE_CONFIRM'))); 
    ?>
    <div class="office_contacts <?if($i==0):?>first<?endif;?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    <?foreach($arItem['DISPLAY_PROPERTIES'] as $prop_key => $prop_value):?>
        <?if($prop_key=='PLACEMARKS'):?>
        
        <?elseif($prop_value["MULTIPLE"]=="Y"):?>
        <div class="prop">
            <div class="row">
                <div class="col-sm-24">
                    <span class="name"><?=$prop_value['NAME']?>:</span>
                </div>
                <div class="col-sm-18 col-sm-offset-6 col-md-19 col-md-offset-5 col-lg-17 col-lg-offset-4 sm-padding-left-no">
                <?if(is_array($prop_value['DISPLAY_VALUE'])):?>
                  <?foreach($prop_value['DISPLAY_VALUE'] as $pid=>$arProperty):?>
                    <div> 
                        <span class="name"><?=$arProperty?></span>
                        <?if($prop_value['DESCRIPTION'][$pid]):?>
                            <span class="value">&nbsp;<?=$prop_value['DESCRIPTION'][$pid]?></span> 
                        <?endif;?>
                    </div>   
                  <?endforeach;?>
                <?else:?>
                    <div> 
                        <span class="name"><?=$prop_value['DISPLAY_VALUE']?></span>
                        <span class="value">&nbsp;<?=$prop_value['DESCRIPTION'][0]?></span> 
                    </div>                
                <?endif;?>  
                </div>
            </div>
        </div>
        <?elseif($prop_key=='ADDRESS'):?>
        <div class="prop">
            <div class="row">
                <div class="col-sm-6 col-md-5 col-lg-4">
                    <span class="name"><?=$prop_value['NAME']?>:</span>
                </div>
                <div class="col-sm-18 col-md-19 col-lg-17 sm-padding-left-no">
                    <span class="value"><?=$prop_value['DISPLAY_VALUE']?></span>
                </div>
            </div>
        </div>                     
        <?else:?>
        <div class="prop">
            <div class="row">
                <div class="col-sm-6 col-md-5 col-lg-4">
                    <span class="name"><?=$prop_value['NAME']?>:</span>
                </div>
                <div class="col-sm-18 col-md-19 col-lg-17 sm-padding-left-no">
                    <span class="value"><?=$prop_value['DISPLAY_VALUE']?></span>
                </div>
            </div>
        </div>          
        <?endif;?>

        <?$i++;?>           
    <?endforeach;?>
    <?if($arParams['MAP_PROPERTY_PLACEMARKS'] && $arParams["MAP_NOT_SHOW"] != "Y" && $arItem['DISPLAY_PROPERTIES'][$arParams['MAP_PROPERTY_PLACEMARKS']]):?>
        <div class="prop_wrap_btn" onclick="$('#<?=$arParams["MAP_ID"]?>_<?=$arItem["ID"]?>').click();">
            <div class="wrap_show_map">
                <span><?=GetMessage("NEWS_ELEMENT_SHOW_MAP");?></span>
            </div>
        </div>    
    <?endif;?>
    </div> <!--end office_contacts -->    
    
    <?endforeach;?>

</div>
<?endforeach;?>
                                  

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
