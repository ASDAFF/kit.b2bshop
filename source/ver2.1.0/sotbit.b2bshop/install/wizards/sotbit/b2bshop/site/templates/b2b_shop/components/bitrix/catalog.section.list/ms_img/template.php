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
if(isset($arResult["SECTION"]["PICTURE"]) && !empty($arResult["SECTION"]["PICTURE"])):
?>
<div class="col-sm-24 sm-padding-right-no xs-padding-no">
    <div class="inner_banner_right_top">
        <?/*?><a href="#"><?*/?>
            <img width="<?=$arResult["PICTURE"]["WIDTH"]?>" height="<?=$arResult["PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["PICTURE"]["ALT"]?>" title="<?=$arResult["PICTURE"]["TITLE"]?>" src="<?=$arResult["PICTURE"]["SRC"]?>" class="img-responsive">
        <?/*?></a><?*/?>
    </div>
</div>
<?
endif;
?>