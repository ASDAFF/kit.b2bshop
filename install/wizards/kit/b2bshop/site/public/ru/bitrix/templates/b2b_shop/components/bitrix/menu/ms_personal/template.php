<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die(); ?>

<?
$menu = new \Kit\B2BShop\Client\Personal\Menu();
if(!empty($arResult)):?>

<div class="blank_left_side"
     id="blank_left_side" <?=(!$menu->isOpen()) ? 'style="display:none"' : 'style="display:block"'?>>
    <div class="col-sm-5 sm-padding-left-no blank_left_side_inner">
        <div class="personal_left_wrap">
            <? if($arParams['DISPLAY_USER_NANE'] == "Y" && $GLOBALS["USER"]->IsAuthorized()) {
                $name = trim($USER->GetFullName());
                if(strlen($name) <= 0)
                    $name = $USER->GetLogin();
                $aHref = "/personal/";
                if($arParams['PROFILE_URL']) {
                    $aHref = $arParams['PROFILE_URL'];
                } ?>
                <a class="nik_name" href="<?=$aHref?>"><?=$name;?></a>
                <?
            }
            else if(!$GLOBALS["USER"]->IsAuthorized()) { ?>
                <?
                $name = GetMessage('AUTH_TITLE_PERSONAL'); ?>
                <span class="nik_name"><?=$name;?></span>
                <?
            }
            $previousLevel = 0;
            foreach($arResult
            
            as $arItem): ?>
            <? if($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
                <?=str_repeat("</div>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
            <? endif ?>
            <? if($arItem["IS_PARENT"]): ?>
            <? if($arItem["DEPTH_LEVEL"] == 1): ?>
            <div class="left_block_general<? if($arItem["SELECTED"]):?> block_active<? endif ?>">
                <div class="block_title">
                    <a href="<?=$arItem["LINK"]?>" class="block_title_in"><span
                            <? if($arItem["PARAMS"]["add_fly"]): ?>class="desc_fly_1_bg"<? endif;
                        ?>><?=$arItem["TEXT"]?></span></a>
                </div>
                <? endif ?>
                <? else:?>
                    <? if($arItem["PERMISSION"] > "D"):?>
                        <? if($arItem["DEPTH_LEVEL"] == 1):?>
                            <div class="left_block_general<? if($arItem["SELECTED"]):?> block_active<? endif ?>">
                                <div class="block_title">
                                    <a href="<?=$arItem["LINK"]?>"
                                       class="block_title_in"><span><?=$arItem["TEXT"]?></span></a>
                                </div>
                            </div>
                        <? else:?>
                            <a href="<?=$arItem["LINK"]?>" <? if($arItem["SELECTED"]):?> class="a_active"<? endif ?>><?=$arItem["TEXT"]?></a>
                        <? endif ?>
                    <? else:?>
                        <? if($arItem["DEPTH_LEVEL"] == 1):?>
                            <div class="left_block_general<? if($arItem["SELECTED"]):?> block_active<? endif ?>">
                                <div class="block_title">
                                    <a href="" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"
                                       class="block_title_in"><span><?=$arItem["TEXT"]?></span></a>
                                </div>
                            </div>
                        <? else:?>
                            <a href=""
                               title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>" <? if($arItem["SELECTED"]):?> class="a_active"<? endif ?>><?=$arItem["TEXT"]?></a>
                        <? endif ?>
                    <? endif ?>
                <? endif ?>
                <? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>
                <? endforeach ?>
                <?$enableManagerBlock = COption::GetOptionString("kit.b2bshop", "BLOCK_MANAGER_ENABLE", 'N');
                
                if($enableManagerBlock == 'Y') { ?>
                    <div class="manager-title-container">
                        <div class="manager-title"><?=GetMessage('YOUR_MANAGER');?></div>
                    </div>
                    
                    <?
                    $APPLICATION->IncludeFile("/include/template/personal/manager.php", Array(), Array(
                        "MODE" => "php",
                    ));
                }
                ?>
                
                
                <? if($previousLevel > 1)://close last item tags
                    ?>
                    <?=str_repeat("</div>", ($previousLevel - 1));?>
                <? endif ?>
            </div>
        </div>
    </div>
<? endif ?>