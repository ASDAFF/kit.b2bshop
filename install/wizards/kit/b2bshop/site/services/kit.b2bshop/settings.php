<?
if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true )
	die();

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

$module = 'kit.b2bshop';
CModule::includeModule('sale');
$arPersonTypeNames = array();
$dbPerson = CSalePersonType::GetList( array(), array(
		"LID" => WIZARD_SITE_ID
) );
while ( $arPerson = $dbPerson->Fetch() )
{
	$arPersonTypeNames[$arPerson["ID"]] = $arPerson["NAME"];
}


$idFiz = array_search( GetMessage( "WZD_PERSON_TYPE_FIZ" ), $arPersonTypeNames );
$idUr = array_search( GetMessage( "WZD_PERSON_TYPE_UR" ), $arPersonTypeNames );
$idIp = array_search( GetMessage( "WZD_PERSON_TYPE_IP" ), $arPersonTypeNames );


Option::set($module, "PERSONAL_PERSON_TYPE", $idFiz);
Option::set($module,'SECTION_VIEW','block');

if($module == 'kit.b2bshop')
{
	$UrPersonTypes = array();
	if($idUr > 0)
	{
		array_push($UrPersonTypes, $idUr);
	}
	if($idIp > 0)
	{
		array_push($UrPersonTypes, $idIp);
	}
	if($UrPersonTypes)
	{
		Option::set("kit.b2bshop", "BUYER_PERSONAL_TYPE", serialize($UrPersonTypes));
		Option::set("kit.b2bshop", "SHOW_PERSON_TYPE_BUYERS", serialize($UrPersonTypes));
	}
	Option::set("kit.b2bshop", "SECTION_VIEW_ACCESS", serialize(array('block','row')));
	Option::set("kit.b2bshop", "OPT_PERSONAL_ORDER_ACTIONS", serialize(array('repeat','cancel')));
	Option::set($module,'SECTION_VIEW','row');
	$prices = array();
	$dbPriceType = CCatalogGroup::GetList(
        array("SORT" => "ASC"),
        array("NAME" => array("BASE","OPT1","OPT2"))
    );
	while ($arPriceType = $dbPriceType->Fetch())
	{
		array_push($prices, $arPriceType['NAME']);
	}

	Option::set("kit.b2bshop",'PRICE_CODE_SECTION',serialize($prices));
	if($UrPersonTypes)
	{
		$user = \Bitrix\Main\UserTable::getById(1)->fetch();
		$values = array(
			'COMPANY' => $wizard->GetVar( "shopOfName" ),
			'INN' => $wizard->GetVar( "shopINN" ),
			'KPP' => $wizard->GetVar( "shopKPP" ),
			'UR_ZIP' => 101000,
			'UR_CITY' => $wizard->GetVar( "shopLocation" ),
			'UR_ADDRESS' => $wizard->GetVar( "shopAdr" ),
			'EQ_POST' => 'Y',
			'POST_ZIP' => 101000,
			'POST_CITY' => $wizard->GetVar( "shopLocation" ),
			'POST_ADDRESS' => $wizard->GetVar( "shopAdr" ),
			'PHONE' => '+79211111111',
			'EMAIL' => $wizard->GetVar( "shopEmail" ),
			'LAST_NAME' => 'admin',
			'NAME' => 'admin',
		);
		foreach($UrPersonTypes as $personType)
		{
			$saleProps = new \CSaleOrderUserProps;
			$idProfile = $saleProps->Add(
				array(
					'NAME' => $values['INN'],
					'USER_ID' => 1,
					'PERSON_TYPE_ID' => $personType
				)
			);
			if ($idProfile > 0)
			{
				$saleOrderUserPropertiesValue = new \CSaleOrderUserPropsValue;
				$orderPropertiesList = \CSaleOrderProps::GetList(
					array("SORT" => "ASC", "NAME" => "ASC"),
					array(
						"PERSON_TYPE_ID" => $personType,
						"USER_PROPS" => "Y", "ACTIVE" => "Y", "UTIL" => "N"
					),
					false,
					false,
					array("ID", "NAME", "TYPE", "REQUIED", "MULTIPLE", "IS_LOCATION", "PROPS_GROUP_ID", "IS_EMAIL", "IS_PROFILE_NAME", "IS_PAYER", "IS_LOCATION4TAX", "CODE", "SORT")
				);

				while ($orderProperty = $orderPropertiesList->GetNext())
				{
					$saleOrderUserPropertiesValue->Add(
						array(
							'USER_PROPS_ID' => $idProfile,
							'ORDER_PROPS_ID' => $orderProperty['ID'],
							'NAME' => $orderProperty['NAME'],
							'VALUE' => $values[$orderProperty['CODE']]
						)
					);
				}
			}
		}
	}
	
	
	$oUserTypeEntity    = new \CUserTypeEntity();
	
	$aUserFields    = array(
			'ENTITY_ID'         => 'USER',
			'FIELD_NAME'        => 'UF_ORGANIZATION',
			'USER_TYPE_ID'      => 'integer',
			'XML_ID'            => 'UF_ORGANIZATION',
			'SORT'              => 500,
			'MULTIPLE'          => 'N',
			'MANDATORY'         => 'N',
			'SHOW_FILTER'       => 'N',
			'SHOW_IN_LIST'      => '',
			'EDIT_IN_LIST'      => 'Y',
			'IS_SEARCHABLE'     => 'N',
			'SETTINGS'          => array(
					'DEFAULT_VALUE' => '',
					'SIZE'          => '20',
					'ROWS'          => '1',
					'MIN_LENGTH'    => '0',
					'MAX_LENGTH'    => '0',
					'REGEXP'        => '',
			),
			'EDIT_FORM_LABEL'   => array(
					'ru'    => Loc::getMessage('WZD_UF_ORGANIZATION'),
					'en'    => Loc::getMessage('WZD_UF_ORGANIZATION'),
			),
			'LIST_COLUMN_LABEL' => array(
					'ru'    => Loc::getMessage('WZD_UF_ORGANIZATION'),
					'en'    => Loc::getMessage('WZD_UF_ORGANIZATION'),
			),
			'LIST_FILTER_LABEL' => array(
					'ru'    => Loc::getMessage('WZD_UF_ORGANIZATION'),
					'en'    => Loc::getMessage('WZD_UF_ORGANIZATION'),
			),
			'ERROR_MESSAGE'     => array(
					'ru'    => Loc::getMessage('WZD_UF_ORGANIZATION'),
					'en'    => Loc::getMessage('WZD_UF_ORGANIZATION'),
			),
			'HELP_MESSAGE'      => array(
					'ru'    => Loc::getMessage('WZD_UF_ORGANIZATION'),
					'en'    => Loc::getMessage('WZD_UF_ORGANIZATION'),
			),
	);
	
	$iUserFieldId   = $oUserTypeEntity->Add( $aUserFields );
	
	
	\Bitrix\Main\Loader::includeModule('sale');
	
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