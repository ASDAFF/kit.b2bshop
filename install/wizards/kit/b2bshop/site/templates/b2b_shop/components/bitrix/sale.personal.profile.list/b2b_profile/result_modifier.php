<?

use Bitrix\Main\Config\Option;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$needProfiles = unserialize(Option::get('kit.b2bshop', 'SHOW_PERSON_TYPE_BUYERS', ''));
if(!is_array($needProfiles))
{
	$needProfiles = [];
}

$arFilter = [
	'USER_PROPS' => 'Y',
	'ACTIVE' => 'Y',
	'UTIL' => 'N',
];
$orderPropertiesList = CSaleOrderProps::GetList(
	[
		"SORT" => "ASC",
		"NAME" => "ASC"
	],
	$arFilter,
	false,
	false,
	[
		"ID",
		"PERSON_TYPE_ID",
		"NAME",
		"TYPE",
		"CODE",
		"PROPS_GROUP_ID",
		'USER_PROPS',
		'ACTIVE',
		'CODE'
	]
);
$arOrderPropertyList = [];

while ($orderProperty = $orderPropertiesList->GetNext())
{
	if(!in_array($orderProperty['PERSON_TYPE_ID'], $needProfiles))
		continue;
	$arOrderPropertyList[$orderProperty['ID']] = $orderProperty;
	if(!in_array($orderProperty['CODE'], [
		'ID',
		'NAME',
		'DATE_UPDATE',
		'PERSON_TYPE_NAME',
		'UR_ZIP',
		'POST_CITY',
		'POST_ZIP',
		'EQ_POST'
	]))
		array_push($arParams['GRID_HEADER'], [
			'id' => $orderProperty['CODE'],
			'name' => $orderProperty['NAME'],
			'sort' => $orderProperty['CODE'],
			'default' => false,
			'editable' => false
		]);
}

foreach ($arResult["PROFILES"] as $key => $val)
{
	if(!in_array($val['PERSON_TYPE_ID'], $needProfiles))
	{
		unset($arResult["PROFILES"][$key]);
	}
}
$arResult['ROWS'] = [];

foreach ($arResult["PROFILES"] as $val)
{
	$aActions = [
		[
			"ICONCLASS" => "detail",
			"TEXT" => GetMessage('SPOL_CHANGE_PROFIL'),
			"ONCLICK" => "jsUtils.Redirect(arguments, '" . $val["URL_TO_DETAIL"] . "')",
			"DEFAULT" => true
		],
		/*["SEPARATOR" => true],
		[
			"ICONCLASS" => "delete",
			"TEXT" => GetMessage('SPOL_DELETE_PROFIL'),
			"ONCLICK" => "if(confirm('" . GetMessage('SPOL_DELETE_CONFIRM_PROFIL') . "')) window.location='" . $val["URL_TO_DETELE"] . "';"
		],*/
	];

	$aCols = $val;

	$userProperties = CSaleOrderUserPropsValue::GetList(
		["ID" => "ASC"],
		[
			"USER_PROPS_ID" => $val['ID'],
			'PROP_ID' => array_keys($arOrderPropertyList)
		],
		false,
		false,
		[
			'ID',
			'ORDER_PROPS_ID',
			'VALUE',
			'PROP_CODE',
			'PROP_NAME',
			"USER_PROPS_ID"
		]
	);

	while ($userOrderProperties = $userProperties->fetch())
	{
		if($userOrderProperties['PROP_CODE'] != 'NAME')
		{
			$val[$userOrderProperties['PROP_CODE']] = $userOrderProperties['VALUE'];
		}
		if($userOrderProperties['PROP_CODE'] == 'COMPANY')
		{
			$val['NAME'] = $userOrderProperties['VALUE'];
		}
	}

	array_push($arResult['ROWS'], [
		'data' => array_merge($val, [
			'PERSON_TYPE_NAME' => $val['PERSON_TYPE']['NAME']
		]),
		'actions' => $aActions,
		'COLUMNS' => $aCols,
		'editable' => true,
	]);
}

if(isset($_GET['by']) && !in_array($_GET['by'], [
		'ID',
		'NAME',
		'DATE_UPDATE',
		'PERSON_TYPE_NAME'
	]))
{
	$by = $_GET['by'];
	$order = in_array($_GET['order'], [
		'asc',
		'ASC',
		'desc',
		'DESC'
	]) ? strtolower($_GET['order']) : 'asc';

	for ($i = 0; $i < count($arResult['ROWS']); $i++)
	{
		for ($j = 0; $j < count($arResult['ROWS']) - 1; $j++)
		{
			$change = false;
			$t = [];

			if($order == 'desc' && strcmp($arResult['ROWS'][$i]['data'][$by], $arResult['ROWS'][$j]['data'][$by]) > 0)
			{
				$change = true;
			}
			elseif($order == 'asc' && strcmp($arResult['ROWS'][$i]['data'][$by], $arResult['ROWS'][$j]['data'][$by]) < 0)
			{
				$change = true;
			}

			if($change)
			{
				$t = $arResult['ROWS'][$j];
				$arResult['ROWS'][$j] = $arResult['ROWS'][$i];
				$arResult['ROWS'][$i] = $t;
			}

		}
	}
}