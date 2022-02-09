<?
require ($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$opt = new \Sotbit\B2BShop\Client\Shop\Opt();

try
{
	$hasAccess = $opt->hasAccess();
}
catch (\Bitrix\Main\ArgumentNullException $e)
{
}
catch (\Bitrix\Main\ArgumentOutOfRangeException $e)
{
}
catch (\Bitrix\Main\LoaderException $e)
{
}

if($hasAccess)
{
	$APPLICATION->SetTitle("Бланк заказа");
	try
	{
		$params = $opt->getBlankParams();
	}
	catch (\Bitrix\Main\ArgumentNullException $e)
	{
	}
	catch (\Bitrix\Main\ArgumentOutOfRangeException $e)
	{
	}
	$APPLICATION->IncludeComponent(
		"bitrix:catalog",
		"blank",
		$params
	);
}
require ($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>