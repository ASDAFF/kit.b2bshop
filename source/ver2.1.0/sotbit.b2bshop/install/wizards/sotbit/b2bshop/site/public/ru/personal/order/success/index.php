<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");

if(isset($_REQUEST["ORDER_ID"]))
{
   ?>
   <p>Вами оформлен заказ по телефону. В ближайшее время с вами свяжется наш менеджер.</p>
   <?
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>