<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="top-block__menu-wrapper">
    <div class="top-block__menu-wrapper__title">
        <span>
            <?$APPLICATION->IncludeFile(SITE_DIR."/include/top-block__title.php",
                Array(),
                Array("MODE"=>"html")
            );?>
        </span>
    </div>
    <div class="top-block__menu-wrapper__menu">
        <?if (!empty($arResult)):?>
        <ul class="top-block__wrapper__left-menu left-menu" id="b2b_top_ul">
        <? foreach($arResult as $arItem):
            if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                continue; ?>
            <?if($arItem["SELECTED"]):?>
                <li class="top-block__wrapper__left-menu__item"><a href="<?=$arItem["LINK"]?>" class="selected top-block__wrapper__left-menu__item-href"><?=$arItem["TEXT"]?></a></li>
            <?else:?>
                <li class="top-block__wrapper__left-menu__item"><a href="<?=$arItem["LINK"]?>" class="top-block__wrapper__left-menu__item-href"><?=$arItem["TEXT"]?></a></li>
            <?endif?>
        <?endforeach?>
        </ul>
        <?endif?>
    </div>
</div>
