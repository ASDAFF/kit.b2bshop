<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(isset($_REQUEST["ORDER_ID"])) return false;

if(isset($_REQUEST["bxajaxid"]) && !isset($_REQUEST["basket"]) && !isset($_REQUEST["delay"]))
{
	?>
	<script type="text/javascript">
        BX.onCustomEvent('OnBasketChange')
	</script>
	<?php
}
$bxajaxid = CAjax::GetComponentID($this->__component->__name, $this->__name, '');
if(isset($_REQUEST["bxajaxid"]) && !isset($_REQUEST["basket"]) && !isset($_REQUEST["delay"]) && isset($arResult["ITEMS"]["AnDelCanBuy"]) && !empty($arResult["ITEMS"]["AnDelCanBuy"]))
{
	?>
	<script type="text/javascript">
		$(function() {
			submitForm('N');
		});
	</script>
	<?
}elseif(isset($_REQUEST["bxajaxid"]) && !isset($_REQUEST["basket"]) && !isset($_REQUEST["delay"]) && (!isset($arResult["ITEMS"]["AnDelCanBuy"]) || empty($arResult["ITEMS"]["AnDelCanBuy"])))
{
	?>
	<script type="text/javascript">
		window.top.location.reload();
	</script>
	<?
}
?>
<div class="basket_form_content">
<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">
<?
$arUrls = Array(
	"delete" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delete&id=#ID#",
	"delay" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delay&id=#ID#",
	"add" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=add&id=#ID#",
    "new_delay" => '/include/ajax/basket_add_product_and_wish.php?ajax_basket=Y&entity=basket&action=move&s_id=#ID#',
    "new_add" => '/include/ajax/basket_add_product_and_wish.php?ajax_basket=Y&entity=delay&action=move&s_id=#ID#',
);
if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
{
	if (is_array($arResult["WARNING_MESSAGE"]) && !empty($arResult["WARNING_MESSAGE"]))
	{
		foreach ($arResult["WARNING_MESSAGE"] as $v)
			echo ShowError($v);
	}
	$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
	$delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
	$delayClass = $normalClass = "";


	if(isset($_SESSION["ms_delay"]))
	{
		$delayClass = "active";
	}else{
		$normalClass = "active";
	}

	?>
	<div class="col-sm-24  sm-padding-left-no sort_container">
		<div class="wrap_btn">
			<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam("basket=1", array("basket", "delay"))?>" class="basket_toolbar_button button <?=$normalClass?>">
				<?=GetMessage("MS_BASKET_CAN")?>
			</a>
			<?if($delayCount>0):?>
			<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam("delay=1", array("basket", "delay"))?>" class="basket_toolbar_button_delayed button <?=$delayClass?>">
				<?=GetMessage("MS_BASKET_DELAY")?>
			</a>
			<?endif;?>
		</div>
	</div>
	<?
	if($arResult["ITEMS"]["AnDelCanBuy"] && !isset($_SESSION["ms_delay"] ))
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
	if($arResult["ITEMS"]["DelDelCanBuy"] && isset( $_SESSION["ms_delay"] ))
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delay.php");
}
else
{
	ShowError($arResult["ERROR_MESSAGE"]);
}

?>
</form>
</div>
<?if(isset($arResult["ITEMS"]["AnDelCanBuy"]) && !empty($arResult["ITEMS"]["AnDelCanBuy"])):?>
<div class="col-sm-24">
	<div class="row">
		<div class="col-sm-9 col-sm-offset-15 sm-padding-right-no">
			<div class="wrap_basket_order">
				<a rel="nofollow" href="<?=$arParams["PATH_TO_ORDER"]?>" class="basket_order_btn"><?=GetMessage("MS_BASKET_TO_ORDER")?></a>
			</div>
		</div>
	</div>
</div>
<?endif;?>