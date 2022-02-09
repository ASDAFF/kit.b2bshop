<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$urlCart = COption::GetOptionString("sotbit.b2bshop", "URL_CART", "");
$urlOrder = COption::GetOptionString("sotbit.b2bshop", "URL_ORDER", "");
$cartInOrder = COption::GetOptionString("sotbit.b2bshop", "CART_IN_ORDER", "");
 
$dir = $APPLICATION->GetCurDir(); 
$frame = $this->createFrame()->begin();
if(($dir!=$urlCart && $dir!=$urlOrder)):
?>
<script type="text/javascript">
        $(document).ready(function(){
            $('#basket form').msBasketCart({
                "mainClass" : ".window-without-bg",
                "dopClass" : ".window_basket",
                "basketUrl" : "<?=$APPLICATION->GetCurPage()?>",
                "basketItem" : ".basket-item",
                "deleteBasket" : ".delete"
            });
            /*arParams = {
                "mainContainer" : "#basket form",
                "mainClass" : ".window-without-bg",
                "dopClass" : ".window_basket",
                "basketUrl" : "/index.php",
                "basketItem" : ".basket-item",
                "deleteBasket" : ".delete"
            };
            msCart = new msBasketCart(arParams);

            msBasketCart.init();*/
        })
</script>
<?endif;?>
<?
if($cartInOrder=="Y")
{
    $arParams['PATH_TO_BASKET'] = $arParams["PATH_TO_ORDER"];
    $urlCart = $urlOrder;
}
?>
<div id="basket" class="basket">
    <form name="basket">
    <?=bitrix_sessid_post()?>
    <input type="hidden" name="ajax_top_basket" value="Y" />
<?
if ($arResult["READY"]=="Y" || $arResult["DELAY"]=="Y" || $arResult["NOTAVAIL"]=="Y" || $arResult["SUBSCRIBE"]=="Y")
{
	if ($arResult["READY"]=="Y")
	{
        $tovarov2 = GetMessage("TSBS_SALE_BASKET2_2");
        $tovarov3 = GetMessage("TSBS_SALE_BASKET2_3"); 
        $var = BITGetDeclNum($arResult['ALL_QUANTITY'], array('', $tovarov2, $tovarov3));
        $tovarov = GetMessage("TSBS_SALE_BASKET2_1").$var;
        ?>

        <?
	}?>
    <a href="<?=$arParams['PATH_TO_BASKET'];?>" data-class="window_basket" data-href=""><?=GetMessage("TSBS_READY")?></a>
    <span><a href="<?=$arParams['PATH_TO_BASKET'];?>" data-class="window_basket" data-href=""><?=$arResult['ALL_QUANTITY']?>&nbsp;<?=$tovarov;?></a></span>
<?
}
else {
    if(empty($arResult["ITEMS"])):?>
    <?
        $tovarov = GetMessage("TSBS_SALE_BASKET2_1").GetMessage("TSBS_SALE_BASKET2_3");
?>
        <a href="<?=$arParams['PATH_TO_BASKET'];?>" data-class="window_basket" data-href=""><?=GetMessage("TSBS_READY")?></a>
        <span><a href="<?=$arParams['PATH_TO_BASKET'];?>" data-class="window_basket" data-href="">0&nbsp;<?=$tovarov?></a></span>
    <?endif;
}
?>
    </form>
</div>
<?$frame->end();?>