<?
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult['URL_TO_ADD'] = SITE_DIR.'personal/b2b/profile/buyer/?add=Y';
$arResult['URL_TO_LIST'] =  SITE_DIR.'personal/b2b/profile/buyer/';
$arResult['URL_TO_DELETE'] =  SITE_DIR.'personal/b2b/profile/buyer/?delete='.$arResult['ID'];

$isB2bTab = false;
if(strpos($arParams['PATH_TO_DETAIL'], 'b2b') !== false)
{
	$isB2bTab = true;
}


try
{
	$inns = unserialize(Option::get('sotbit.b2bshop', 'DOCUMENT_ORG'));
	if(!is_array($inns))
	{
		$inns = [];
	}
	if($inns)
	{
		foreach($inns as $inn)
		{
			if($arResult['ORDER_PROPS_VALUES']['ORDER_PROP_'.$inn])
			{
				$buyerInn = $arResult['ORDER_PROPS_VALUES']['ORDER_PROP_'.$inn];
			}
		}
	}
	$docIblock = Option::get('sotbit.b2bshop', 'DOCUMENT_IBLOCK_ID');
	if($docIblock > 0 && $buyerInn)
	{
		$filter = [
			'ACTIVE' => 'Y',
			'PROPERTY_ORGANIZATION' => $buyerInn
		];
		$filterOption = new Bitrix\Main\UI\Filter\Options('DOCUMENTS_LIST');
		$filterData = $filterOption->getFilter([]);

		foreach ($filterData as $key => $value)
		{
			if(in_array($key, [
				'ID',
				'NAME',
				'DATE_CREATE_from',
				'DATE_CREATE_to',
				'DATE_UPDATE_from',
				'DATE_UPDATE_to'
			]))
			{
				switch ($key)
				{
					case 'DATE_CREATE_from':
						{
							$filter['>=DATE_CREATE'] = $value;
							break;
						}
					case 'DATE_CREATE_to':
						{
							$filter['<=DATE_CREATE'] = $value;
							break;
						}
					case 'DATE_UPDATE_from':
						{
							$filter['>=TIMESTAMP_X'] = $value;
							break;
						}
					case 'DATE_UPDATE_to':
						{
							$filter['<=TIMESTAMP_X'] = $value;
							break;
						}
					default:
						{
							$filter[$key] = $value;
						}
				}
			}
		}

		$by = isset($_GET['by']) ?  $_GET['by'] : 'ID';
		$order = isset($_GET['order']) ? strtoupper($_GET['order']) : 'DESC';

		if($by == 'DATE_UPDATE')
		{
			$by = 'TIMESTAMP_X';
		}

		$els = [];
		$rs = \CIBlockElement::GetList([$by => $order], $filter, false, false, [
			'ID',
			'NAME',
			'DATE_CREATE',
			'TIMESTAMP_X',
			'PROPERTY_ORDER',
			'PROPERTY_DOCUMENT'
		]);
		while ($el = $rs->Fetch())
		{
			if(!$els[$el['ID']])
			{
				$els[$el['ID']] = $el;
				$els[$el['ID']]['ORDERS'] = [];
			}
			if($el['PROPERTY_ORDER_VALUE'])
			{
				$els[$el['ID']]['ORDERS'][] = $el['PROPERTY_ORDER_VALUE'];
			}
		}
		if($els)
		{
			foreach($els as $el)
			{
				$actions = [];
				$name = $el["NAME"];
				if($el['PROPERTY_DOCUMENT_VALUE'])
				{
					$file = \CFile::GetPath($el['PROPERTY_DOCUMENT_VALUE']);
					$name = '<a href="' . $file . '" download>' . $el["NAME"]
						. '</a>';
					$actions = [
						[
							"ICONCLASS" => "download",
							"TEXT" => Loc::getMessage('DOC_DOWNLOAD'),
							"ONCLICK" => "jsUtils.Redirect(arguments, '" . $file . "')",
							"DEFAULT" => true
						]
					];
				}
				$order = '';
				if($el['ORDERS'])
				{
					foreach ($el['ORDERS'] as $idOrder)
					{
						$orderUrl = ($isB2bTab) ? 'personal/b2b/order/detail/' . $idOrder . '/' : 'personal/order/detail/' . $idOrder . '/';
						$order .= '<a href="' . SITE_DIR . $orderUrl . '" target="__blank">' . $idOrder . '</a><br>';
					}
				}
				$arResult['ROWS'][] = [
					'data' => [
						"ID" => $el['ID'],
						"NAME" => $name,
						'DATE_CREATE' => $el["DATE_CREATE"],
						'DATE_UPDATE' => $el["TIMESTAMP_X"],
						'ORDER' => $order,
					],
					'actions' => $actions,
					'COLUMNS' => [
						"ID" => $el['ID'],
						"NAME" => $el["NAME"],
						'DATE_CREATE' => $el["DATE_CREATE"],
						'DATE_UPDATE' => $el["TIMESTAMP_X"],
						'ORDER' => $order,
					],
					'editable' => true,
				];
			}
		}
	}
}
catch (\Bitrix\Main\ArgumentNullException $e)
{
}
catch (\Bitrix\Main\ArgumentOutOfRangeException $e)
{
}
?>