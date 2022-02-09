<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

WizardServices::IncludeServiceLang("settings.php", 'ru');

$module = 'kit.b2bshop';
if($module == 'kit.b2bshop' && \Bitrix\Main\Loader::includeModule('sale'))
{
	$propsInn = [];
	$propsCompany = [];
	$rs = \Bitrix\Sale\Internals\OrderPropsTable::getList([
		'filter' => [
			'CODE' => [
				'INN',
				'COMPANY'
			]
		]
	]);
	while ($prop = $rs->fetch())
	{
		if($prop['CODE'] == 'INN')
		{
			$propsInn[] = $prop['ID'];
		}
		if($prop['CODE'] == 'COMPANY')
		{
			$propsCompany[] = $prop['ID'];
		}
	}

	if($propsInn)
	{
		\Bitrix\Main\Config\Option::set('kit.b2bshop', 'DOCUMENT_ORG', serialize($propsInn));
	}
	if($propsCompany)
	{
		\Bitrix\Main\Config\Option::set('kit.b2bshop', 'DOCUMENT_ORG_NAME', serialize($propsCompany));
	}

	$personTypes = [];
	$rs = CSalePersonType::GetList([], [
		"LID" => WIZARD_SITE_ID
	]);
	while ($person = $rs->Fetch())
	{
		$personTypes[$person["ID"]] = $person["NAME"];
	}
	$idUr = array_search(GetMessage("WZD_PERSON_TYPE_UR"), $personTypes);
	$idIp = array_search(GetMessage("WZD_PERSON_TYPE_IP"), $personTypes);

	$personTypes = [];

	if($idUr > 0)
	{
		$personTypes[] = $idUr;
	}
	if($idIp > 0)
	{
		$personTypes[] = $idIp;
	}

	if($personTypes)
	{
		$orders = [];
		$rs = \Bitrix\Sale\Internals\OrderTable::getList([
			'filter' => [
				'USER_ID' => 1,
				'LID' => WIZARD_SITE_ID,
				'PERSON_TYPE_ID' => $personTypes
			],
			'select' => ['ID']
		]);
		while ($order = $rs->fetch())
		{
			$orders[] = $order['ID'];
		}
		$iblock = \Bitrix\Main\Config\Option::get('kit.b2bshop','DOCUMENT_IBLOCK_ID');
		$els = [];
		$rs = \CIBlockElement::GetList([],['IBLOCK_ID' => $iblock]);
		while($el = $rs->Fetch())
		{
			$els[] = $el['ID'];
		}
		if($orders && $iblock > 0)
		{
			foreach($els as $el)
			{
				\CIBlockElement::SetPropertyValuesEx($el, $iblock, array('ORDER' => $orders[array_rand($orders)]));
			}
		}
		$buyers = [];

		$rs = CSaleOrderUserProps::GetList([],['USER_ID' => 1,'PERSON_TYPE_ID' => $personTypes]);
		while($buyer = $rs->Fetch())
		{
			$buyers[] = $buyer['ID'];
		}
		if($buyers)
		{
			$inns = [];
			$rs = CSaleOrderUserPropsValue::GetList([],['ORDER_PROPS_ID' => $propsInn,'USER_PROPS_ID' => $buyers]);
			while($buyerProp = $rs->Fetch())
			{
				$inns[] = $buyerProp['VALUE'];
			}
			if($inns)
			{
				foreach($els as $el)
				{
					\CIBlockElement::SetPropertyValuesEx($el, $iblock, array('ORGANIZATION' => $inns[array_rand($inns)]));
				}
			}
		}

	}
}
?>