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

<?$news_first = true;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('NEWS_ELEMENT_DELETE_CONFIRM')));
	
?>
    <?if($news_first):?>
      <?$news_first = false;?>
      <div class="col-sm-9">
        <div class="bl_left" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                <p class="title">
                    <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                        <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
                    <?else:?>
                        <?echo $arItem["NAME"]?>
                    <?endif;?>
                </p>
            <?endif;?>
            
            <?if($arParams["DISPLAY_DATE_FIRST"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                <p class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
            <?endif?>            
            <!--VIDEO START -->
            <!--VIDEO END -->

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
                            alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                            title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                            /></a>
                <?else:?>
                    <span class="wrap_img">
                    <img
                        class="img-responsive"
                        src="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["SRC"]?>"
                        width="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"]?>"
                        height="<?=$arItem["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"]?>"
                        alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                        title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                        />
                     </span>
                <?endif;?>
            <?endif?>
            
            <?if($arParams["DISPLAY_PREVIEW_TEXT_FIRST"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                <p class=text><?echo $arItem["PREVIEW_TEXT"];?></p> 
            <?endif;?>
        </div>
      </div>
      <div class="col-sm-7 col-lg-6">
        <div class="bl_center"> 
    <?else:?>
        <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
            <a class="news_one" href="<?echo $arItem["DETAIL_PAGE_URL"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <?else:?>
            <span class="news_one" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <?endif;?>       
             <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                <p class="title"><?echo $arItem["NAME"]?></p>
            <?endif;?> 
            
            <?if($arParams["DISPLAY_DATE_OTHER"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                <p class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
            <?endif?> 
        <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
            </a>
        <?else:?>
            </span>
        <?endif;?>          
    <?endif;?>
<?endforeach;?>
        </div> <?/*end bl_center*/?>
    </div>   <?/*col-sm-7 col-lg-6*/?>