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
$colorCode = $arParams["OFFER_COLOR_PROP"];
CJSCore::Init(array("fx"));
?>
<h2 class="title"><?=GetMessage("MS_FILTER_CATALOG")?></h2>
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
                    "ALLOW_MULTI_SELECT" => "N"
                ),
                false
);?>

<div id="block_filter_js" class="block_form_filter">
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
            <?if($arItem["PROPERTY_TYPE"] == "N" ):?>
			    <? 
				if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
				    continue;
				?>
                <div class="filter_block filter_price block_open">
                    <span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
                    <div class="inner_filter_block" style="display: block;">
                        <div id="price-slider<?=$key?>" class="price-slider"></div>
                        <div class="inner_filter_block_2">
                            <div class="inner_filter_block_2_1">
                                <label><?=GetMessage("MS_FILTER_NUMBER_FROM")?></label>
                                <input
                                <?/*?>name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"<?*/?>
                                name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["CONTROL_NAME_SEF"]:$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["HTML_VALUE"]:$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                 id="value-min-input<?=$key?>"
                                 type="text"
                                 placeholder="<?echo $arItem["VALUES"]["MIN"]["VALUE"]?>"
                                 <?/*?>onkeyup="smartFilter.keyup(this)"
                                 value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"<?*/?>>
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
                    <script type="text/javascript">
                        $("#price-slider<?=$key?>").noUiSlider({
                            start: [<?=(isset($arItem["VALUES"]["MIN"]["HTML_VALUE"]) && $arItem["VALUES"]["MIN"]["HTML_VALUE"])?$arItem["VALUES"]["MIN"]["HTML_VALUE"]:$arItem["VALUES"]["MIN"]["VALUE"]?>, <?=(isset($arItem["VALUES"]["MAX"]["HTML_VALUE"]) && $arItem["VALUES"]["MAX"]["HTML_VALUE"])?$arItem["VALUES"]["MAX"]["HTML_VALUE"]:$arItem["VALUES"]["MAX"]["VALUE"]?>],
                            step: 10,
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
                        <?if(!isset($arItem["VALUES"]["MIN"]["SET_FILTER"])):?>
                        $("#price-slider<?=$key?>").next().find("input[type=text]").eq(0).val("");
                        <?endif;?>

                        <?if(!isset($arItem["VALUES"]["MAX"]["SET_FILTER"])):?>
                        $("#price-slider<?=$key?>").next().find("input[type=text]").eq(1).val("");
                        <?endif;?>
                        $("#price-slider<?=$key?>").on({
	                        set: function(){
		                        $(".smartfilter").submit();
	                        }
                        });
                    </script>
                </div>
            <?elseif(!empty($arItem["VALUES"]) && $arItem["CODE"]!=$colorCode && in_array($arItem["CODE"], $arParams["OFFER_TREE_PROPS"])):?>
            <div class="filter_block filter_size block_open">
                <span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
                <div class="inner_filter_block" style="display: block;">
                    <ul>
                    <?foreach($arItem["VALUES"] as $val => $ar):?>
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
                            <label class="<?echo $ar["DISABLED"] ? 'label-disable': ''?>" for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label>
                        </li>
                    <?endforeach?>
                    </ul>
                </div>
            </div>
            <?elseif(!empty($arItem["VALUES"]) && $arItem["CODE"]==$colorCode):?>
            <div class="filter_block filter_color block_open">
                <span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
                <div class="inner_filter_block" style="display: block;">
                    <ul>
                    <?foreach($arItem["VALUES"] as $val => $ar)://printr($ar);?>
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
                    <?endforeach?>
                    </ul>
                </div>
            </div>
            <?elseif(!empty($arItem["VALUES"]) && !isset($arItem["PRICE"])):?>
            <div class="filter_block block_open">
                <span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
                <div class="inner_filter_block scrollbarY" style="display: block;">
                    <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                    <div class="viewport">
                        <ul class="overview">
                        <?foreach($arItem["VALUES"] as $val => $ar):?>
                            <li class="li-first-open">
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
                                <label class="<?echo $ar["DISABLED"] ? 'label-disable': ''?>" for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?> <?if(!$ar["CHECKED"]):?>(<?=$ar["CNT"]?>)<?endif;?></label>
                            </li>
                        <?endforeach?>
                        </ul>
                    </div>
                </div>
            </div>
            <?endif;?>
        <?endforeach?>
        <?foreach($arResult["ITEMS"] as $key=>$arItem):
            $key = md5($key); //break;
        ?>
            <?if(isset($arItem["PRICE"])):?>
                <?
				if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
				    continue;
				//printr($arItem);
                ?>
                <div class="filter_block filter_price block_open">
                    <span class="block_name" onclick="open_close_filter(this, '.inner_filter_block', '.filter_block');"><?=$arItem["NAME"]?></span>
                    <div class="inner_filter_block" style="display: block;">
                        <div id="price-slider<?=$arItem["CODE_SEF"]?>" class="price-slider"></div>
                        <div class="inner_filter_block_2">
                            <div class="inner_filter_block_2_1">
                                <label><?=GetMessage("MS_FILTER_NUMBER_FROM")?></label>
                                <input <?/*?>name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"<?*/?>
                                    name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["CONTROL_NAME_SEF"]:$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                    value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MIN"]["HTML_VALUE"]:$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                    placeholder="<?echo $arItem["VALUES"]["MIN"]["VALUE"]?>"
                                 id="value-min-input" type="text" <?/*?>onkeyup="smartFilter.keyup(this)" value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"<?*/?>>
                            </div>
                            <div class="inner_filter_block_2_1">
                                <label><?=GetMessage("MS_FILTER_NUMBER_TO")?></label>
                                <input <?/*?>name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"<?*/?>
                                    name="<?=($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MAX"]["CONTROL_NAME_SEF"]:$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                    value="<?echo ($arParams["SEF_MODE_FILTER"]=="Y")?$arItem["VALUES"]["MAX"]["HTML_VALUE"]:$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                    placeholder="<?echo $arItem["VALUES"]["MAX"]["VALUE"]?>"
                                 id="value-max-input" type="text"<?/*?> onkeyup="smartFilter.keyup(this)" value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"<?*/?>>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $("#price-slider<?=$arItem['CODE_SEF']?>").noUiSlider({
                            start: [<?=(isset($arItem["VALUES"]["MIN"]["HTML_VALUE"]) && $arItem["VALUES"]["MIN"]["HTML_VALUE"])?$arItem["VALUES"]["MIN"]["HTML_VALUE"]:$arItem["VALUES"]["MIN"]["VALUE"]?>, <?=(isset($arItem["VALUES"]["MAX"]["HTML_VALUE"]) && $arItem["VALUES"]["MAX"]["HTML_VALUE"])?$arItem["VALUES"]["MAX"]["HTML_VALUE"]:$arItem["VALUES"]["MAX"]["VALUE"]?>],
                            step: 10,
                            connect: true,
                            behaviour: 'tap-drag',
                            range: {
                                'min': <?=$arItem["VALUES"]["MIN"]["VALUE"]?>,
                                'max': <?=$arItem["VALUES"]["MAX"]["VALUE"]?>
                            },
                            serialization: {
                                lower: [
                                    new Link({
                                        target: $("#value-min-input")
                                    })
                                ],
                                upper: [
                                    new Link({
                                        target: $("#value-max-input"),
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
        <?/*?>
        <div class="bx_filter_control_section">
				<span class="icon"></span><input class="bx_filter_search_button" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
				<input class="bx_filter_search_button" type="submit" id="del_filter" name="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" />
				<div class="bx_filter_popup_result left" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
					<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
					<span class="arrow"></span>
					<a href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
				</div>

		</div>
        <?*/?>
    </form>
</div>
</div>