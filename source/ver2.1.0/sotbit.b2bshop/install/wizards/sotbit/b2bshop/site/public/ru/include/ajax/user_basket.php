<?
use Bitrix\Sale;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if($REQUEST_METHOD == "POST" && $_REQUEST['FUSER_ID'] > 0 && $_REQUEST['SITE_ID'])
{
	$Ids= array();
	\Bitrix\Main\Loader::includeModule("sale");
	$basket = Sale\Basket::loadItemsForFUser($_REQUEST['FUSER_ID'], $_REQUEST['SITE_ID']);
	foreach ($basket as $basketItem) 
	{
		if(!isset($Ids[$basketItem->getProductId()]))
		{
			$Ids[$basketItem->getProductId()] = $basketItem->getQuantity();
		}
		else 
		{
			$Ids[$basketItem->getProductId()] += $basketItem->getQuantity();
		}
	}
	echo \Bitrix\Main\Web\Json::encode($Ids);
}