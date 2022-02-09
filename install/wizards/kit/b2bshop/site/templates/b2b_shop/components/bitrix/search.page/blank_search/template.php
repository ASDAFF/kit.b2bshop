<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<form action="" method="get">
	<input type="submit" name="subtitle" style="display:none" />
	<input type="text" class="blank_articul" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" />
	<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
</form>