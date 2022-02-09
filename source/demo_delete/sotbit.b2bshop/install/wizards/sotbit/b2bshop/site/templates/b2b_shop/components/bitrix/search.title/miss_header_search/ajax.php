<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (empty($arResult["CATEGORIES"]))
	return;
?>
<div class="miss_search bootstrap_style">
<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
	<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
		<?if(isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):
			$arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];?>
			<a class="bx_item_block" href="<?echo $arItem["URL"]?>">
				<?if (is_array($arElement["PICTURE"])):?>
				<span class="bx_img_element">
                    <?if($arElement["PICTURE"]["src"]):?>
                        <img class="img-responsive" src="<?echo $arElement["PICTURE"]["src"]?>" width="<?echo $arElement["PICTURE"]["width"]?>" height="<?echo $arElement["PICTURE"]["height"]?>" title="<?echo $arItem["NAME"]?>" alt=""/>
				    <?endif;?>
                </span>
				<?endif;?>
				<span class="bx_item_element">
					<span class="bx_item_name"><?echo $arItem["NAME"]?></span>
					<?
					foreach($arElement["PRICES"] as $code=>$arPrice)
					{
						if ($arPrice["MIN_PRICE"] != "Y")
							continue;

						if($arPrice["CAN_ACCESS"])
						{
							if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
								<div class="bx_price">
									<?=$arPrice["PRINT_DISCOUNT_VALUE"]?>
									<span class="old"><?=$arPrice["PRINT_VALUE"]?></span>
								</div>
							<?else:?>
								<div class="bx_price"><?=$arPrice["PRINT_VALUE"]?></div>
							<?endif;
						}
						if ($arPrice["MIN_PRICE"] == "Y")
							break;
					}
					?>
				</span>
				<span style="clear:both; display: block;"></span>
			</a>          
		<?elseif($category_id !== "all" && !isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):?>
            <?$item_other_url = $arItem["URL"];
            $item_other_name = $arItem["NAME"];
            ?>
        <?elseif($category_id === "all"):?>
            <div class="bx_item_block all_result">
                <div class="bx_img_element"></div>
                <div class="bx_item_element">
                    <?if($item_other_url):?>
                        <a class="all_others" href="<?echo $item_other_url?>"><?echo $item_other_name?></a>
                    <?endif;?>
                    <a class="all_result_title" href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a>
                    <span class="all_result_l"></span>
                    <span class="all_result_r"></span>
                </div>
                <div style="clear:both;"></div>
            </div>              
		<?endif;?>
	<?endforeach;?>
<?endforeach;?>
</div>