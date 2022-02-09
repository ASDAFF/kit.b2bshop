<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule("sotbit.b2bshop") || !B2BSSotbit::getDemo()) return false;

$this->setFrameMode(true);
$colorCode = (isset($arParams["COLOR_IN_PRODUCT"])&&$arParams["COLOR_IN_PRODUCT"]&&isset($arParams['COLOR_IN_PRODUCT_CODE'])&&!empty($arParams['COLOR_IN_PRODUCT_CODE']))?$arParams['COLOR_IN_PRODUCT_CODE']:$arParams["OFFER_COLOR_PROP"];$defOpenLi = $arParams["FILTER_ITEM_COUNT"];
$defOpenLi = $arParams["FILTER_ITEM_COUNT"];
$defLiHight = $defOpenLi*23;


$fields = unserialize(\Bitrix\Main\Config\Option::get("sotbit.b2bshop", "OPT_FILTER_FIELDS",""));
if(!is_array($fields))
{
	$fields = array();
}
CJSCore::Init(array("fx"));
?>
 
<div id="block_filter_js" class="block_form_filter blank_filter" data-site-url="<?=$APPLICATION->GetCurPage()?>" data-site-dir="<?=$_SERVER['DOCUMENT_ROOT'].SITE_DIR?>">

	<div class="filter-title-wrapper">
		<div class="filter-title"><?=GetMessage('CT_BCSF_FILTER_TITLE1')?></div>
		<div id="hide_blank_filter" class="hide_blank_filter <?=($_SESSION['BLANK_HIDE_FILTER'] == 'Y')?'blank_filter_open':''?>"><span>+</span><div class="hide_blank_filter_text"><?=($_SESSION['BLANK_HIDE_FILTER'] == 'Y')?GetMessage('CT_BCSF_FILTER_SHOW'):GetMessage('CT_BCSF_FILTER_HIDE')?></div></div>
	</div>
	<div class="filter-form-wrapper" id="filter-form-wrapper"  style="<?=($_SESSION['BLANK_HIDE_FILTER'] == 'Y')?'display:none;':'display:block;'?>">
		<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
			<?foreach($arResult["HIDDEN"] as $arItem):?>
				<input
					type="hidden"
					name="<?echo $arItem["CONTROL_NAME"]?>"
					id="<?echo $arItem["CONTROL_ID"]?>"
					value="<?echo $arItem["HTML_VALUE"]?>"
				/>
			<?endforeach;?>

			<?foreach($arResult["ITEMS"] as $key=>$arItem):


			if(!in_array($arItem['CODE'], $fields))
			{
				continue;
			}

			?>


			<?if(isset($arItem['VALUES']) && is_array($arItem['VALUES'])&& count($arItem['VALUES'])>0 && !($arItem['PRICE'])):?>
			<?
			switch ($arItem["DISPLAY_TYPE"])
			{
				case "A"://INT WITH SLIDER
					if($arItem["VALUES"]["MIN"]["VALUE"] && $arItem["VALUES"]["MAX"]["VALUE"])
					{
						?>
						<div class="filter_block filter_price" data-code="<?=$arItem["CODE"]?>">
							<span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block', true);"><?=$arItem["NAME"]?></span>
							<div class="inner_filter_block" style="display:none">
								<div id="price-slider<?=$arItem["CODE_SEF"]?>" class="price-slider"></div>
								<div class="inner_filter_block_2">
									<div class="inner_filter_block_2_1">
										<input <?/*?>name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"<?*/?>
											name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["CONTROL_NAME_SEF"]:$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
											value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["HTML_VALUE"]:$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
											placeholder="<?=GetMessage('CT_BCSF_FILTER_MIN')?> <?echo strtolower($arItem["NAME"]);?>"
										 id="value-min-input<?=$key?>" type="text" <?/*?>onkeyup="smartFilter.keyup(this)" value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"<?*/?>>
									</div>
									<div class="inner_filter_block_2_1">
										<input
											name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MAX"]["CONTROL_NAME_SEF"]:$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
											value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MAX"]["HTML_VALUE"]:$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
											placeholder="<?=GetMessage('CT_BCSF_FILTER_MAX')?> <?echo strtolower($arItem["NAME"]);?>"
										 id="value-max-input<?=$key?>" type="text">
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="button_filter_block"><?php echo GetMessage('CT_BCSF_FILTER_APPLY');?></div>
							</div>
						</div>
						<?
					}
				break;
				case "B"://INT WITHOUT SLIDER
				?>
					<div class="filter_block filter_price" data-code="<?=$arItem["CODE"]?>">
						<span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block', true);"><?=$arItem["NAME"]?></span>
						<div class="inner_filter_block" style="display:none">
							<div class="inner_filter_block_2">
								<div class="inner_filter_block_2_1">
									<label><?=GetMessage("MS_FILTER_NUMBER_FROM")?></label>
									<input <?/*?>name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"<?*/?>
										name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["CONTROL_NAME_SEF"]:$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
										value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["HTML_VALUE"]:$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
										placeholder="<?echo $arItem["VALUES"]["MIN"]["VALUE"]?>"
									 id="value-min-input<?=$key?>" type="text">
								</div>
								<div class="inner_filter_block_2_1">
									<label><?=GetMessage("MS_FILTER_NUMBER_TO")?></label>
									<input
										name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MAX"]["CONTROL_NAME_SEF"]:$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
										value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MAX"]["HTML_VALUE"]:$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
										placeholder="<?echo $arItem["VALUES"]["MAX"]["VALUE"]?>"
									 id="value-max-input<?=$key?>" type="text">
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="button_filter_block"><?php echo GetMessage('CT_BCSF_FILTER_APPLY');?></div>
						</div>
						<?
							?>
					</div>
				<?
				break;
				default:
				?>
				<div class="filter_block" data-code="<?=$arItem["CODE"]?>">
					<span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block', true);"><?=$arItem["NAME"]?></span>
					<div class="inner_filter_block <?if(count($arItem["VALUES"]) > $defOpenLi):?>scrollbarY<?endif;?>" style="display:none;">
							<input id="filter_list_input_<?php echo $arItem["CODE"];?>" type="text" class="find_property_value" placeholder="<?=GetMessage('CT_BCSF_FILTER_FIND')?> <?php echo strtolower($arItem['NAME']);?>">
							<div class="blank_ul_wrapper">
								<ul id="filter_list_<?php echo $arItem["CODE"];?>" class="overview" style="<?php echo (count($arItem["VALUES"]) > $defOpenLi)?'height: '.$defLiHight.'px;':'';?>">
								<?$indexValue = 0;?>
								<?foreach($arItem["VALUES"] as $val => $ar):?>
								<?if(isset($ar["VALUE"]) && $ar["VALUE"]!=""):?>
									<?$indexValue++;?>
									<li <?if($indexValue <= $defOpenLi):?>class="li-first-open"<?endif;?>>
										<input
											type="checkbox"
											<?echo $ar["DISABLED"] ? 'disabled="disabled"': ''?>
											name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["CODE_SEF"]:$ar["CONTROL_NAME"]?>"
											value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$ar["CONTROL_NAME_SEF"]:$ar["HTML_VALUE"]?>"
											id="<?echo $ar["CONTROL_ID"]?>"
											<?echo $ar["CHECKED"]? 'checked="checked"': ''?>

										/>
										<label class="check <?echo $ar["DISABLED"] ? 'label-disable': ''?>" for="<?echo $ar["CONTROL_ID"]?>">

											<?php
											if($arItem["CODE"] == COption::GetOptionString("sotbit.b2bshop","OFFER_COLOR_PROP",""))
											{
												?>
												<?if($ar["DEFAULT"]["UF_FILE"]):?>
													<span title="<?=$ar["VALUE"]?>" style="background: url(<?=$ar["DEFAULT"]["PIC"]["SRC"]?>) 50% 50% no-repeat"></span>
												<?else:?>
													<span title="<?=$ar["VALUE"]?>" style="background: <?=$ar["DEFAULT"]["UF_DESCRIPTION"]?>"></span>
												<?endif;?>
												<?php
											}
											?>
											<?echo $ar["VALUE"];?> <?if(!$ar["CHECKED"] && isset($ar["CNT"])):?>(<?=$ar["CNT"]?>)<?endif;?>
										</label>
									</li>
									<?endif;?>
								<?endforeach?>
								</ul>
							</div>
							<div class="button_filter_block"><?php echo GetMessage('CT_BCSF_FILTER_APPLY');?></div>
					</div>
				</div>
				<?
			}?>
			<?endif;?>
			<?endforeach?>
			<?foreach($arResult["ITEMS"] as $key=>$arItem):
				$key = md5($key);
			?>
				<?if(isset($arItem["PRICE"])):?>
					<?

					if ($arItem["VALUES"]["MIN"]["VALUE"]<0 || $arItem["VALUES"]["MAX"]["VALUE"]<0 || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
						continue;
					?>
					<div class="filter_block filter_price <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'block_open':'' ?>" data-code="<?=$arItem["CODE"]?>">
						<span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block', true);"><?=$arItem["NAME"]?></span>
						<div class="inner_filter_block" <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'style="display:block"':'style="display:none"' ?>>
							<div id="price-slider<?=$arItem["CODE_SEF"]?>" class="price-slider"></div>
							<div class="inner_filter_block_2">
								<div class="inner_filter_block_2_1">
									<input <?/*?>name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"<?*/?>
										name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["CONTROL_NAME_SEF"]:$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
										value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["HTML_VALUE"]:$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
										placeholder="<?=GetMessage('CT_BCSF_FILTER_MIN')?> <?echo strtolower($arItem["NAME"]);?>"
									 id="value-min-input<?=$key?>" type="text">
								</div>
								<div class="inner_filter_block_2_1">
									<input
										name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MAX"]["CONTROL_NAME_SEF"]:$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
										value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MAX"]["HTML_VALUE"]:$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
										placeholder="<?=GetMessage('CT_BCSF_FILTER_MAX')?> <?echo strtolower($arItem["NAME"]);?>"
									 id="value-max-input<?=$key?>" type="text">
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="button_filter_block"><?php echo GetMessage('CT_BCSF_FILTER_APPLY');?></div>
						</div>
					</div>
				<?endif;?>
			<?endforeach?>

			<div class="clearfix"></div>
			<div class="wrapper_blank_filter_checked">
				<?php foreach($arResult['CHECKED'] as $key=>$check)
				{
					if($check['QNT'] > 0)
					{
						?>
						<div class="blank_filter_checked" data-code="<?php echo $key;?>">
							<?php echo $check['NAME'],': ',$check['QNT'];?>
						</div>
						<?php
					}
				}?>
			</div>
			<div class="clearfix"></div>


			<input type="hidden" name="set_filter" value="Y" />
			<div class="wrap_del_form_filter">
				<input type="button" name="del_filter" value="<?=GetMessage("MS_FILTER_DELETE_SUBMIT")?>" class="del_form_filter">
			</div>
		</form>

		<form method="POST" action="" onsubmit="">
			<div class="only_available outer_checkbox" id="only_available">
				<input class="checkbox" type="checkbox" name="only_available" value="Y" id="only_available_filter" <?php if($_SESSION["MS_ONLY_AVAILABLE"] == 'Y') echo 'checked="checked"';?>>
				<label class="check blank_checkbox_filter_outer" for="only_available_filter">
					<?=GetMessage('CT_BCSF_FILTER_AVAILABLE')?>
				</label>
				<input type="submit" name="sub_only_available" style="display:none" />
			</div>
		</form>

	</div>
	<div class="clearfix"></div>
</div>

<form method="POST" action="" onsubmit="">
	<div class="only_checked outer_checkbox" id="only_checked">
		<input class="checkbox" type="checkbox" name="only_checked" value="Y" id="only_checked_filter" <?php if($_SESSION["MS_ONLY_CHECKED"] == 'Y') echo 'checked="checked"';?>>
		<label class="check blank_checkbox_filter_outer" for="only_checked_filter">
			<?=GetMessage('CT_BCSF_FILTER_CHECKED')?>
		</label>
		<input type="submit" name="sub_only_checked" style="display:none" />
	</div>
</form>

<script>


$('.filter_block').each(function(i, v)
{
	if($(this).find('.find_property_value'))
	{
		filterList($(this).find('.find_property_value'), $(this).find('.overview'));
	}
});


</script>