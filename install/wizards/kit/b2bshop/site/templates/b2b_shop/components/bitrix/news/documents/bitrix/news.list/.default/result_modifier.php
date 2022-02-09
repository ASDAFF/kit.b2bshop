<?
use Bitrix\Main\Localization\Loc;
use Kit\B2BShop\Client\Shop\Doc;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
Loc::loadMessages(__FILE__);
$arResult['ROWS'] = [];
$isB2bTab = false;
if(strpos($arParams['DETAIL_URL'], 'b2b') !== false)
{
	$isB2bTab = true;
}

$files = [];

if($arResult['ITEMS'])
{
	$orgs = [];
	foreach ($arResult['ITEMS'] as $item)
	{
		if($item['PROPERTIES']['DOCUMENT']['VALUE'] > 0)
		{
			$files[$item['PROPERTIES']['DOCUMENT']['VALUE']] = \CFile::GetPath($item['PROPERTIES']['DOCUMENT']['VALUE']);
		}
		if($item['PROPERTIES']['ORGANIZATION']['VALUE'])
		{
			$orgs[$item['PROPERTIES']['ORGANIZATION']['VALUE']] = ['INN' => $item['PROPERTIES']['ORGANIZATION']['VALUE']];
		}
	}

	$doc = new Doc();
	$buyers = $doc->getBuyersByInn();
	
	foreach ($arResult['ITEMS'] as $item)
	{
		$orgUrl = ($isB2bTab) ? 'personal/b2b/profile/buyer/' : 'personal/profile/buyer/';
		if($buyers[$item['PROPERTIES']['ORGANIZATION']['VALUE']])
		{
			if($buyers[$item['PROPERTIES']['ORGANIZATION']['VALUE']]['ORG_NAME'])
			{
				$name = $buyers[$item['PROPERTIES']['ORGANIZATION']['VALUE']]['ORG_NAME'].' ('
					.$buyers[$item['PROPERTIES']['ORGANIZATION']['VALUE']]['INN'].')';
			}
			else
			{
				$name = $buyers[$item['PROPERTIES']['ORGANIZATION']['VALUE']]['INN'];
			}
			$org = '<a href="' . SITE_DIR . $orgUrl .'?id='. $buyers[$item['PROPERTIES']['ORGANIZATION']['VALUE']]['BUYER_ID'].'" target="__blank">' .
				$name . '</a>';
		}
		else
		{
			$org = $item['PROPERTIES']['ORGANIZATION']['VALUE'];
		}
		$order = '';
		if($item['PROPERTIES']['ORDER']['VALUE'])
		{
			foreach ($item['PROPERTIES']['ORDER']['VALUE'] as $idOrder)
			{
				$orderUrl = ($isB2bTab) ? 'personal/b2b/order/detail/' . $idOrder . '/' : 'personal/order/detail/' . $idOrder . '/';
				$order .= '<a href="' . SITE_DIR . $orderUrl . '" target="__blank">' . $idOrder . '</a><br>';
			}
		}
		$actions = [];
		$name = $item["NAME"];
		if($files[$item['PROPERTIES']['DOCUMENT']['VALUE']])
		{
			$name = '<a href="'.$files[$item['PROPERTIES']['DOCUMENT']['VALUE']].'" download>'.$item["NAME"]
				.'</a>';
			$actions = [
				[
					"ICONCLASS" => "download",
					"TEXT" => Loc::getMessage('DOC_DOWNLOAD'),
					"ONCLICK" => "jsUtils.Redirect(arguments, '" . $files[$item['PROPERTIES']['DOCUMENT']['VALUE']] . "')",
					"DEFAULT" => true
				]
			];
		}
		$arResult['ROWS'][] = [
			'data' => [
				"ID" => $item['ID'],
				"NAME" => $name,
				'DATE_CREATE' => $item["DATE_CREATE"],
				'DATE_UPDATE' => $item["TIMESTAMP_X"],
				'ORGANIZATION' => $org,
				'ORDER' => $order,
			],
			'actions' => $actions,
			'COLUMNS' => [
				"ID" => $item['ID'],
				"NAME" => $item["NAME"],
				'DATE_CREATE' => $item["DATE_CREATE"],
				'DATE_UPDATE' => $item["TIMESTAMP_X"],
				'ORGANIZATION' => $org,
				'ORDER' => $order,
			],
			'editable' => true,
		];
	}
}
?>