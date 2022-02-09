<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

foreach($arResult["ORDERS"] as $val)
{
	$arResult["ORDER_BY_STATUS"][$val["ORDER"]["STATUS_ID"]][] = $val;
}

$filterOption = new Bitrix\Main\UI\Filter\Options('ORDER_LIST');
$filterData = $filterOption->getFilter([]);
$arResult['FILTER_STATUS_NAME'] = (isset($filterData['STATUS'])) ? $arResult['INFO']['STATUS'][$filterData['STATUS']]['NAME']: '';

$allowActions = unserialize(Bitrix\Main\Config\Option::get('kit.b2bshop', 'OPT_PERSONAL_ORDER_ACTIONS', 'a:{}'));

if(!is_array($allowActions))
	$allowActions = array();

foreach($arResult['ORDERS'] as $arOrder)
{
	$aActions = Array(
		array("ICONCLASS"=>"detail", "TEXT"=>GetMessage('SPOL_MORE_ABOUT_ORDER'), "ONCLICK"=>"jsUtils.Redirect(arguments, '".$arOrder['ORDER']["URL_TO_DETAIL"]."')", "DEFAULT"=>true),
);

	foreach($allowActions as $licence)
		array_push($aActions, GetAction($licence, $arOrder));

	$payment = current($arOrder['PAYMENT']);
	$shipment = current($arOrder['SHIPMENT']);

	$aCols = array(
		"ID" => $arOrder['ORDER']["ID"],
		"DATE_INSERT" => $arOrder['ORDER']['DATE_INSERT']->toString(),
		'ACCOUNT_NUMBER' => $arOrder['ORDER']['ACCOUNT_NUMBER'],
		"DATE_UPDATE" => $arOrder['ORDER']['DATE_UPDATE']->toString(),
		'STATUS' => $arResult['INFO']['STATUS'][$arOrder['ORDER']['STATUS_ID']]['NAME'],
		'PAYED' => $arOrder["ORDER"]["PAYED"],
		'PAY_SYSTEM_ID' => $arOrder["ORDER"]["PAY_SYSTEM_ID"],
	);

	$items = array();
	$index = 1;
	foreach ($arOrder['BASKET_ITEMS'] as $item)
	{
		array_push($items, $index++.". $item[NAME] - ($item[QUANTITY] $item[MEASURE_TEXT])");
	}

	$arResult['ROWS'][] = array(
		'data' =>array_merge($arOrder['ORDER'], array(
			"SHIPMENT_METHOD" => $arResult["INFO"]["DELIVERY"][$arOrder["ORDER"]["DELIVERY_ID"]]["NAME"],
			"PAYMENT_METHOD" => $arResult["INFO"]["PAY_SYSTEM"][$arOrder["ORDER"]["PAY_SYSTEM_ID"]]["NAME"],
			'ITEMS' => implode('<br>', $items),
			'STATUS' => $arResult['INFO']['STATUS'][$arOrder['ORDER']['STATUS_ID']]['NAME'],
			'PAYED' => GetMessage('SPOL_'.($arOrder["ORDER"]["PAYED"] == "Y" ? 'YES' : 'NO')),
			'PAY_SYSTEM_ID' => $arOrder["ORDER"]["PAY_SYSTEM_ID"],
			'DELIVERY_ID' => $arOrder["ORDER"]["DELIVERY_ID"],
		) ),
		'actions' => $aActions,
		'COLUMNS' => $aCols,
		'editable' => true,
	);
}

function GetAction($key, $arOrder)
{
	$arAction = array(
		'repeat' => array("ICONCLASS"=>"copy", "TEXT"=>GetMessage('SPOL_REPEAT_ORDER'), "ONCLICK"=>"jsUtils.Redirect(arguments, '".$arOrder['ORDER']["URL_TO_COPY"]."')", "DEFAULT"=>true),
		'cancel' => array("ICONCLASS"=>"cancel", "TEXT"=>GetMessage('SPOL_CANCEL_ORDER'), "ONCLICK"=>"if(confirm('".GetMessage('SPOL_CONFIRM_DEL_ORDER')."')) window.location='".$arOrder['ORDER']["URL_TO_CANCEL"]."';"),
	);

	return $arAction[$key];
}