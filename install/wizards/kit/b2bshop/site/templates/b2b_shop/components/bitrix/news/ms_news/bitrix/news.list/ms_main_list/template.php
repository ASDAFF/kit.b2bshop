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

<div class="news_main_list">

<?if($arParams["DISPLAY_TOP_PAGER"] && $arParams["PAGER_MORE_NEWS"] != "Y"):?>
	<?=$arResult["NAV_STRING"]?><br /><br />
<?endif;?>

<div id="<?=$_SERVER['QUERY_STRING'];?>" data-page="1" class="row smi_list_page_<?=$arResult['NAV_RESULT']->NavNum?>">

<?foreach($arResult["ROW"] as $arRowItem):?>
<div class="col-sm-8"> 
<?foreach($arRowItem as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="news_main_one" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
            <h4 class="title">
                <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                    <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
                <?else:?>
                    <?echo $arItem["NAME"]?>
                <?endif;?>
            </h4>
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
    
        <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
            <p class=text><?echo $arItem["PREVIEW_TEXT"];?></p> 
        <?endif;?>
        
        <?if((!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])) && !empty($arParams["LIST_GO_DETAIL_PAGE"])):?>
            <div class="wrap_go_detail">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arParams["LIST_GO_DETAIL_PAGE"]?></a>
            </div>
        <?endif;?>
	</div>
<?endforeach;?>
</div> <?/*end col-sm-8*/?>
<?endforeach;?>
</div>  <?/*end row news_list*/?>

                                                           
<?if($arParams["DISPLAY_BOTTOM_PAGER"] && $arParams["PAGER_MORE_NEWS"] != "Y"):?>
	<br /><?=$arResult["NAV_STRING"]?><br />
<?else:?>
    <div class="item_more smi_item_more_<?=$arResult['NAV_RESULT']->NavNum?>">
        <?if($arResult['NAV_RESULT']->NavPageCount > 1):?>
            <div class="more_news">   <?$next_pagen = ($arResult['NAV_RESULT']->PAGEN +1);?>
                <a class="link" onclick="updateList_<?=$arResult['NAV_RESULT']->NavNum?>(); return false;" href="<?=$APPLICATION->GetCurPageParam("PAGEN_".$arResult['NAV_RESULT']->NavNum."=".$next_pagen, array("PAGEN_".$arResult['NAV_RESULT']->NavNum))?>">
                <?if(!empty($arParams["PAGER_MORE_NEWS_TEXT"])){ echo $arParams["PAGER_MORE_NEWS_TEXT"];  } else { echo GetMessage('CT_BNL_ELEMENT_MORE_NEWS');};?>
                </a>
            </div>
        <?endif;?>
    </div>
<?endif;?>
</div>  <!-- end news_main_list--> 


<script type="text/javascript" language="javascript">
    function updateList_<?=$arResult['NAV_RESULT']->NavNum?>(){
       BX.showWait();
       var querry_string = $(".smi_list_page_<?=$arResult['NAV_RESULT']->NavNum?>").attr("id");
       $(".smi_item_more_<?=$arResult['NAV_RESULT']->NavNum?> .more_news .link").hide();
       var page = $(".smi_list_page_<?=$arResult['NAV_RESULT']->NavNum?>").attr('data-page');
       page++;
       var url_querry_string = "?"+querry_string+"&PAGEN_<?=$arResult['NAV_RESULT']->NavNum?>="+page;

       if (page<=<?=$arResult['NAV_RESULT']->NavPageCount?>) {
        $.ajax({
            url: url_querry_string,
            success: function(data)
            {
                $(data).find(".smi_list_page_<?=$arResult['NAV_RESULT']->NavNum?> > .col-sm-8:eq(0) .news_main_one").appendTo(".smi_list_page_<?=$arResult['NAV_RESULT']->NavNum?> > .col-sm-8:eq(0)");
                $(data).find(".smi_list_page_<?=$arResult['NAV_RESULT']->NavNum?> > .col-sm-8:eq(1) .news_main_one").appendTo(".smi_list_page_<?=$arResult['NAV_RESULT']->NavNum?> > .col-sm-8:eq(1)");
                $(data).find(".smi_list_page_<?=$arResult['NAV_RESULT']->NavNum?> > .col-sm-8:eq(2) .news_main_one").appendTo(".smi_list_page_<?=$arResult['NAV_RESULT']->NavNum?> > .col-sm-8:eq(2)");
                $(".smi_list_page_<?=$arResult['NAV_RESULT']->NavNum?>").attr('data-page', page);
                BX.closeWait();
                var pageNow = <?=$arResult['NAV_RESULT']->NavPageCount?>;
                if(page != pageNow) {
                    page++;
                    var url_querry_next = "<?=$APPLICATION->GetCurPage(true)?>?"+querry_string+"&PAGEN_<?=$arResult['NAV_RESULT']->NavNum?>="+page;
                    $(".smi_item_more_<?=$arResult['NAV_RESULT']->NavNum?> .more_news .link").attr('href', url_querry_next);
                    $(".smi_item_more_<?=$arResult['NAV_RESULT']->NavNum?> .more_news .link").show();
                }

            }
        });
       }
       else {
          BX.closeWait();
       }
    }
</script>