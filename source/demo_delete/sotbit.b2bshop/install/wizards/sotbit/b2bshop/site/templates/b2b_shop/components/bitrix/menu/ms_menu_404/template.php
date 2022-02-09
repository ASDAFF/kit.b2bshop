<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="wrap_btn">
    <div class="row"> 
<?$cnt = 0;
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
    <?$cnt++;
        if ($cnt > 1 && $cnt%2):?>
        </div>
        <div class="row">
    <?endif?>
    <div class="col-sm-12 col-lg-9">
        <a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
    </div>	
<?endforeach?>
    </div>  <?/*end last row*/?>
</div>
<?endif?>