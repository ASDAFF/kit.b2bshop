<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<?if (!empty($arResult)):?>
<div class="wrap_footer_menu">
<ul class="footer_menu">

<?
$first = true;
$previousLevel = 0;
foreach($arResult as $arItem):?>

     <?if($arItem["PARAMS"]["url_icon"]) {
         $way_template = SITE_TEMPLATE_PATH;
         $arItem["PARAMS"]["url_icon"] = str_replace("SITE_TEMPLATE_PATH", $way_template, $arItem["PARAMS"]["url_icon"]);
     }?>

	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li class="<?if ($arItem["SELECTED"]):?>li-active<?endif?><?if($first):?> li-first<?endif;?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
				<ul>
		<?else:?>
			<li<?if ($arItem["SELECTED"]):?> class="li-active-2"<?endif?>><a href="<?=$arItem["LINK"]?>"><?if($arItem["PARAMS"]["url_icon"]):?><i><img src='<?=$arItem["PARAMS"]["url_icon"]?>' width="10" height="10" title="" alt=""/></i><?endif?><?=$arItem["TEXT"]?></a>
				<ul>
		<?endif?>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li class="<?if ($arItem["SELECTED"]):?>li-active<?endif?><?if($first):?> li-first<?endif;?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<li<?if ($arItem["SELECTED"]):?> class="li-active-2"<?endif?>><a href="<?=$arItem["LINK"]?>"><?if($arItem["PARAMS"]["url_icon"]):?><i><img src='<?=$arItem["PARAMS"]["url_icon"]?>' width="10" height="10" title="" alt=""/></i><?endif?><?=$arItem["TEXT"]?></a></li>
			<?endif?>

		<?else:?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li class="<?if ($arItem["SELECTED"]):?>li-active<?endif?><?if($first):?> li-first<?endif;?>"><a href="" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<li <?if ($arItem["SELECTED"]):?> class="li-active-2"<?endif?>><a href="" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?if($arItem["PARAMS"]["url_icon"]):?><i><img src='<?=$arItem["PARAMS"]["url_icon"]?>' width="10" height="10" title="" alt=""/></i><?endif?><?=$arItem["TEXT"]?></a></li>
			<?endif?>

		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>
    <?$first = false;?>
<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
</div>
<?endif?>