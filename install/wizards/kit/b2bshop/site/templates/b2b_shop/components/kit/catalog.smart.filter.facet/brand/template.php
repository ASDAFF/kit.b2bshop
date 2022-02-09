<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule("kit.b2bshop")) return false;
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
$colorCode = (isset($arParams["COLOR_IN_PRODUCT"])&&$arParams["COLOR_IN_PRODUCT"]&&isset($arParams['COLOR_IN_PRODUCT_CODE'])&&!empty($arParams['COLOR_IN_PRODUCT_CODE']))?$arParams['COLOR_IN_PRODUCT_CODE']:$arParams["OFFER_COLOR_PROP"];$defOpenLi = $arParams["FILTER_ITEM_COUNT"];
$defOpenLi = $arParams["FILTER_ITEM_COUNT"];
$defLiHight = $defOpenLi*23;
CJSCore::Init(array("fx"));
?>
<div id="block_menu_filter" class="left-block-inner">
<?
$APPLICATION->IncludeComponent("bitrix:menu", "ms_filter", array(
					"ROOT_MENU_TYPE" => "left",
					"MENU_CACHE_TYPE" => "A",
					"MENU_CACHE_TIME" => "36000000",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"MENU_CACHE_GET_VARS" => array(
					),
					"MAX_LEVEL" => "2",
					"CHILD_MENU_TYPE" => "left",
					"USE_EXT" => "Y",
					"DELAY" => "N",
					"ALLOW_MULTI_SELECT" => "N",
					"DEF_SHOW_POINTS" =>  $defOpenLi,
	'CACHE_SELECTED_ITEMS' => false
				),
				false
);?>
<div id="block_filter_js" class="block_form_filter" data-site-url="<?=$APPLICATION->GetCurPage()?>" data-site-dir="<?=$_SERVER['DOCUMENT_ROOT'].SITE_DIR?>">
	<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
		<?foreach($arResult["HIDDEN"] as $arItem):?>

			<input
				type="hidden"
				name="<?echo $arItem["CONTROL_NAME"]?>"
				id="<?echo $arItem["CONTROL_ID"]?>"
				value="<?echo $arItem["HTML_VALUE"]?>"
			/>
		<?endforeach;?>

		<?foreach($arResult["ITEMS"] as $key=>$arItem):?>
		<?if($arItem['ID']=='SECTION_ID')
			continue;?>
		<?if(isset($arItem['VALUES']) && is_array($arItem['VALUES'])&& count($arItem['VALUES'])>0 && !($arItem['PRICE'])):?>
		<?switch ($arItem["DISPLAY_TYPE"])
		{

			case "G"://CHECKBOXES_WITH_PICTURES
			?>
			<div class="filter_block filter_color <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'block_open':'' ?>" data-code="<?=$arItem["CODE"]?>">
				<span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
				<div class="inner_filter_block" <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'style="display:block"':'style="display:none"' ?>>
					<ul>
					<?foreach($arItem["VALUES"] as $val => $ar)://printr($ar);?>
						 <?if(isset($ar["VALUE"]) && $ar["VALUE"]!=""):?>
						<li>
							<input
									type="checkbox"
									<?echo $ar["DISABLED"] ? 'disabled="disabled"': ''?>
									<?/*?>value="<?echo $ar["HTML_VALUE"]?>"
									name="<?echo $ar["CONTROL_NAME"]?>"<?*/?>
									name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["CODE_SEF"]:$ar["CONTROL_NAME"]?>"
									value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$ar["CONTROL_NAME_SEF"]:$ar["HTML_VALUE"]?>"
									id="<?echo $ar["CONTROL_ID"]?>"
									<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
									<?/*?>onclick="smartFilter.click(this)"<?*/?>
							/>
						<?if($ar["DEFAULT"]["UF_FILE"]):?>
							<label class="<?echo $ar["DISABLED"] ? 'label-disable': ''?>" for="<?echo $ar["CONTROL_ID"]?>"><span title="<?=$ar["VALUE"]?>" style="background: url(<?=$ar["DEFAULT"]["PIC"]["SRC"]?>) 50% 50% no-repeat"></span></label>
						<?else:?>
							<label class="<?echo $ar["DISABLED"] ? 'label-disable': ''?>" for="<?echo $ar["CONTROL_ID"]?>"><span title="<?=$ar["VALUE"]?>" style="background: <?=$ar["DEFAULT"]["UF_DESCRIPTION"]?>"><?if(!$ar["DEFAULT"]["UF_DESCRIPTION"]):?><?=$ar["VALUE"]?><?endif;?></span></label>
						<?endif;?>
						</li>

						<?endif;?>
					<?endforeach?>
					</ul>
				</div>
			</div>
			<?
			break;
			case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
			?>
			<div class="filter_block filter_size <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'block_open':'' ?>" data-code="<?=$arItem["CODE"]?>">
				<span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
				<div class="inner_filter_block" <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'style="display:block"':'style="display:none"' ?>>
					<ul>
					<?foreach($arItem["VALUES"] as $val => $ar)://printr($ar);?>
					<?if(isset($ar["VALUE"]) && $ar["VALUE"]!=""):?>
						<li>
							<input
									type="checkbox"
									<?echo $ar["DISABLED"] ? 'disabled="disabled"': ''?>
									<?/*?>value="<?echo $ar["HTML_VALUE"]?>"
									name="<?echo $ar["CONTROL_NAME"]?>"<?*/?>
									name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["CODE_SEF"]:$ar["CONTROL_NAME"]?>"
									value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$ar["CONTROL_NAME_SEF"]:$ar["HTML_VALUE"]?>"
									id="<?echo $ar["CONTROL_ID"]?>"
									<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
									<?/*?>onclick="smartFilter.click(this)"<?*/?>
							/>
							<label class="<?echo $ar["DISABLED"] ? 'label-disable': ''?>" for="<?echo $ar["CONTROL_ID"]?>"><?=$ar["VALUE"]?></label>
						</li>
						<?endif;?>
					<?endforeach?>
					</ul>
				</div>
			</div>
			<?
			break;
			case "K"://RADIO_BUTTONS
			?>
			<div class="filter_block <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'block_open':'' ?>" data-code="<?=$arItem["CODE"]?>">
				<span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
				<div class="inner_filter_block <?if(count($arItem["VALUES"]) > $defOpenLi):?>scrollbarY<?endif;?>" style="<?php echo (isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'display:block;':'display:none;';?>">
						<ul class="overview" style="<?php echo (count($arItem["VALUES"]) > $defOpenLi)?'height: '.$defLiHight.'px;':'';?>">
						<?$indexValue = 0;?>
						<?foreach($arItem["VALUES"] as $val => $ar):?>
						<?if(isset($ar["VALUE"]) && $ar["VALUE"]!=""):?>
							<?$indexValue++;?>
							<li <?if($indexValue <= $defOpenLi):?>class="li-first-open"<?endif;?>>
								<input
									type="radio"
									<?echo $ar["DISABLED"] ? 'disabled="disabled"': ''?>
									<?/*?>value="<?echo $ar["HTML_VALUE"]?>"
									name="<?echo $ar["CONTROL_NAME"]?>"<?*/?>
									name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["CODE_SEF"]:$ar["CONTROL_NAME"]?>"
									value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$ar["CONTROL_NAME_SEF"]:$ar["HTML_VALUE"]?>"
									id="<?echo $ar["CONTROL_ID"]?>"
									<?echo $ar["CHECKED"]? 'checked="checked"': ''?>

								/>
								<label class="radio <?echo $ar["DISABLED"] ? 'label-disable': ''?>" for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?> <?if(!$ar["CHECKED"] && isset($ar["CNT"])):?>(<?=$ar["CNT"]?>)<?endif;?></label>
							</li>
							<?endif;?>
						<?endforeach?>
						</ul>

				</div>
			</div>
			<?
			break;
			case "P"://SELECT
			?>
			<div class="filter_block <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'block_open':'' ?>" data-code="<?=$arItem["CODE"]?>">
				<span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
				<div class="inner_filter_block <?if(count($arItem["VALUES"]) > $defOpenLi):?>scrollbarY<?endif;?>" style="<?php echo (isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'display:block;':'display:none;';?>">
						<div class="overview" style="<?php echo (count($arItem["VALUES"]) > $defOpenLi)?'height: '.$defLiHight.'px;':'';?>">
					<div class="li-first-open">
						<select name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["CODE_SEF"]:$ar["CONTROL_NAME"]?> " id="<?echo $ar["CONTROL_ID"]?>">
						 <option value="">
						 	<?=GetMessage("MS_FILTER_ALL")?>
						 </option>
						 <?foreach($arItem["VALUES"] as $val => $ar):?>
						 <?if(isset($ar["VALUE"]) && $ar["VALUE"]!=""):?>
						 <option <?=($ar['DISABLED'])?"disabled ":""?>value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$ar["CONTROL_NAME_SEF"]:$ar["HTML_VALUE"]?>" <?=(isset($ar["CHECKED"])&&$ar["CHECKED"]=="Y")?"selected":""?>>
						 	<?=$ar["VALUE"]?>
						 </option>
						 <?endif;?>
						 <?endforeach?>

						</select>
						</div>
					</div>
				</div>
			</div>
			<?
			break;
			case "R"://SELECT WITH IMAGES
			?>
			<div class="filter_block <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'block_open':'' ?>" data-code="<?=$arItem["CODE"]?>">
				<span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
				<div class="inner_filter_block <?if(count($arItem["VALUES"]) > $defOpenLi):?>scrollbarY<?endif;?>" style="<?php echo (isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'display:block;':'display:none;';?>">
						<div class="overview" style="<?php echo (count($arItem["VALUES"]) > $defOpenLi)?'height: '.$defLiHight.'px;':'';?>">
					<div class="li-first-open">
						<select name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["CODE_SEF"]:$ar["CONTROL_NAME"]?> " id="<?echo $ar["CONTROL_ID"]?>">
						 <option value="">
						 	<?=GetMessage("MS_FILTER_ALL")?>
						 </option>
						 <?foreach($arItem["VALUES"] as $val => $ar):?>
						 <?if(isset($ar["VALUE"]) && $ar["VALUE"]!=""):?>
						 <option <?=($ar['DISABLED'])?"disabled ":""?>value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$ar["CONTROL_NAME_SEF"]:$ar["HTML_VALUE"]?>" <?=(isset($ar["CHECKED"])&&$ar["CHECKED"]=="Y")?"selected":""?>>
						 <?if($ar["DEFAULT"]["UF_FILE"]):?>
							<div  style="background: url(<?=$ar["DEFAULT"]["PIC"]["SRC"]?>) 50% 50% no-repeat"></div><?=$ar["VALUE"]?>
						<?else:?>
							<div  style="background: <?=$ar["DEFAULT"]["UF_DESCRIPTION"]?>"></div><?=$ar["VALUE"]?>
						<?endif;?>
						 </option>
						 <?endif;?>
						 <?endforeach?>
						</select>
				</div>
					</div>
				</div>
			</div>
			<?
			break;
			case "A"://INT WITH SLIDER
				if($arItem["VALUES"]["MIN"]["VALUE"] && $arItem["VALUES"]["MAX"]["VALUE"])
				{
					?>
					<div id="filter_price_<?=$arItem["CODE"]?>" class="filter_block filter_price <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'block_open':'' ?>" data-code="<?=$arItem["CODE"]?>">
						<span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
						<div class="inner_filter_block" <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'style="display:block"':'style="display:none"' ?>>
							<div id="price-slider<?=$arItem["CODE_SEF"]?>" class="price-slider"></div>
							<div class="inner_filter_block_2">
								<div class="inner_filter_block_2_1">
									<label><?=GetMessage("MS_FILTER_NUMBER_FROM")?></label>
									<input <?/*?>name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"<?*/?>
										name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["CONTROL_NAME_SEF"]:$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
										value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["HTML_VALUE"]:$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
										placeholder="<?echo $arItem["VALUES"]["MIN"]["VALUE"]?>"
									 id="value-min-input<?=$key?>" type="text" <?/*?>onkeyup="smartFilter.keyup(this)" value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"<?*/?>>
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
						</div>
						<script type="text/javascript">
							$("#price-slider<?=$arItem['CODE_SEF']?>").noUiSlider({
								start: [<?=(isset($arItem["VALUES"]["MIN"]["HTML_VALUE"]) && $arItem["VALUES"]["MIN"]["HTML_VALUE"])?$arItem["VALUES"]["MIN"]["HTML_VALUE"]:$arItem["VALUES"]["MIN"]["VALUE"]?>, <?=(isset($arItem["VALUES"]["MAX"]["HTML_VALUE"]) && $arItem["VALUES"]["MAX"]["HTML_VALUE"])?$arItem["VALUES"]["MAX"]["HTML_VALUE"]:$arItem["VALUES"]["MAX"]["VALUE"]?>],
								step: 1,
								connect: true,
								behaviour: 'tap-drag',
								range: {
									'min': <?=$arItem["VALUES"]["MIN"]["VALUE"]?>,
									'max': <?=$arItem["VALUES"]["MAX"]["VALUE"]?>
								},
								serialization: {
									lower: [
										new Link({
											target: $("#value-min-input<?=$key?>")
										})
									],
									upper: [
										new Link({
											target: $("#value-max-input<?=$key?>"),
										})
									],
									format: {
										mark: ',',
										decimals: 0
									}
								}
							});
							$('#price-slider<?=$arItem["CODE_SEF"]?>').on({
								set: function(){
									$(".smartfilter").submit();
								}
							});
							<?if(!isset($arItem["VALUES"]["MIN"]["SET_FILTER"])):?>
							$("#price-slider<?=$arItem['CODE_SEF']?>").next().find("input[type=text]").eq(0).val("");
							<?endif;?>

							<?if(!isset($arItem["VALUES"]["MAX"]["SET_FILTER"])):?>
							$("#price-slider<?=$arItem['CODE_SEF']?>").next().find("input[type=text]").eq(1).val("");
							<?endif;?>
						</script>
					</div>
					<?
				}
			break;
			case "B"://INT WITHOUT SLIDER
			?>
				<div id="filter_price_<?=$arItem["CODE"]?>" class="filter_block filter_price <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'block_open':'' ?>" data-code="<?=$arItem["CODE"]?>">
					<span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
					<div class="inner_filter_block" <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'style="display:block"':'style="display:none"' ?>>
						<div class="inner_filter_block_2">
							<div class="inner_filter_block_2_1">
								<label><?=GetMessage("MS_FILTER_NUMBER_FROM")?></label>
								<input <?/*?>name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"<?*/?>
									name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["CONTROL_NAME_SEF"]:$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
									value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["HTML_VALUE"]:$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
									placeholder="<?echo $arItem["VALUES"]["MIN"]["VALUE"]?>"
								 id="value-min-input<?=$key?>" type="text" <?/*?>onkeyup="smartFilter.keyup(this)" value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"<?*/?>>
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
					</div>
					<?
						?>
				</div>
			<?
			break;
			default:
			?>
			<div class="filter_block <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'block_open':'' ?>" data-code="<?=$arItem["CODE"]?>">
				<span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
				<div class="inner_filter_block <?if(count($arItem["VALUES"]) > $defOpenLi):?>scrollbarY<?endif;?>" style="<?php echo (isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'display:block;':'display:none;';?>">
						<ul class="overview" style="<?php echo (count($arItem["VALUES"]) > $defOpenLi)?'height: '.$defLiHight.'px;':'';?>">
						<?$indexValue = 0;?>
						<?foreach($arItem["VALUES"] as $val => $ar):?>
						<?if(isset($ar["VALUE"]) && $ar["VALUE"]!=""):?>
							<?$indexValue++;?>
							<li <?if($indexValue <= $defOpenLi):?>class="li-first-open"<?endif;?>>
								<input
									type="checkbox"
									<?echo $ar["DISABLED"] ? 'disabled="disabled"': ''?>
									<?/*?>value="<?echo $ar["HTML_VALUE"]?>"
									name="<?echo $ar["CONTROL_NAME"]?>"<?*/?>
									name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["CODE_SEF"]:$ar["CONTROL_NAME"]?>"
									value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$ar["CONTROL_NAME_SEF"]:$ar["HTML_VALUE"]?>"
									id="<?echo $ar["CONTROL_ID"]?>"
									<?echo $ar["CHECKED"]? 'checked="checked"': ''?>

								/>
								<label class="check <?echo $ar["DISABLED"] ? 'label-disable': ''?>" for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?> <?if(!$ar["CHECKED"] && isset($ar["CNT"])):?>(<?=$ar["CNT"]?>)<?endif;?></label>
							</li>
							<?endif;?>
						<?endforeach?>
						</ul>
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
				<div id="filter_price_<?=$arItem["CODE"]?>" class="filter_block filter_price <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'block_open':'' ?>" data-code="<?=$arItem["CODE"]?>">
					<span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
					<div class="inner_filter_block" <?=(isset($arResult['OPENS'][$arItem['CODE']]) && $arResult['OPENS'][$arItem['CODE']]=='Y')?'style="display:block"':'style="display:none"' ?>>
						<div id="price-slider<?=$arItem["CODE_SEF"]?>" class="price-slider"></div>
						<div class="inner_filter_block_2">
							<div class="inner_filter_block_2_1">
								<label><?=GetMessage("MS_FILTER_NUMBER_FROM")?></label>
								<input <?/*?>name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"<?*/?>
									name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["CONTROL_NAME_SEF"]:$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
									value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["HTML_VALUE"]:$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
									placeholder="<?echo $arItem["VALUES"]["MIN"]["VALUE"]?>"
								 id="value-min-input<?=$key?>" type="text" <?/*?>onkeyup="smartFilter.keyup(this)" value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"<?*/?>>
							</div>
							<div class="inner_filter_block_2_1">
								<label><?=GetMessage("MS_FILTER_NUMBER_TO")?></label>
								<input <?/*?>name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"<?*/?>
									name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MAX"]["CONTROL_NAME_SEF"]:$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
									value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MAX"]["HTML_VALUE"]:$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
									placeholder="<?echo $arItem["VALUES"]["MAX"]["VALUE"]?>"
								 id="value-max-input<?=$key?>" type="text"<?/*?> onkeyup="smartFilter.keyup(this)" value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"<?*/?>>
							</div>
						</div>
					</div>
					<script>
					var Link = $.noUiSlider.Link;
						$("#price-slider<?=$arItem['CODE_SEF']?>").noUiSlider({
							start: [<?=(isset($arItem["VALUES"]["MIN"]["HTML_VALUE"]) && $arItem["VALUES"]["MIN"]["HTML_VALUE"])?$arItem["VALUES"]["MIN"]["HTML_VALUE"]:$arItem["VALUES"]["MIN"]["VALUE"]?>, <?=(isset($arItem["VALUES"]["MAX"]["HTML_VALUE"]) && $arItem["VALUES"]["MAX"]["HTML_VALUE"])?$arItem["VALUES"]["MAX"]["HTML_VALUE"]:$arItem["VALUES"]["MAX"]["VALUE"]?>],
							step: 1,
							connect: true,
							behaviour: 'tap-drag',
							range: {
								'min': <?=$arItem["VALUES"]["MIN"]["VALUE"]?>,
								'max': <?=$arItem["VALUES"]["MAX"]["VALUE"]?>
							},
							serialization: {
								lower: [
									new Link({
										target: $("#value-min-input<?=$key?>")
									})
								],
								upper: [
									new Link({
										target: $("#value-max-input<?=$key?>"),
									})
								],
								format: {
									mark: ',',
									decimals: 0
								}
							}
						});
						$('#price-slider<?=$arItem["CODE_SEF"]?>').on({
							set: function(){
								$(".smartfilter").submit();
							}
						});
						<?if(!isset($arItem["VALUES"]["MIN"]["SET_FILTER"])):?>
						$("#price-slider<?=$arItem['CODE_SEF']?>").next().find("input[type=text]").eq(0).val("");
						<?endif;?>

						<?if(!isset($arItem["VALUES"]["MAX"]["SET_FILTER"])):?>
						$("#price-slider<?=$arItem['CODE_SEF']?>").next().find("input[type=text]").eq(1).val("");
						<?endif;?>
					</script>
				</div>
			<?endif;?>
		<?endforeach?>
		<input type="hidden" name="set_filter" value="Y" />
		<div class="wrap_del_form_filter">
			<input type="button" name="del_filter" value="<?=GetMessage("MS_FILTER_DELETE_SUBMIT")?>" class="del_form_filter">
		</div>
	</form>
</div>
</div>