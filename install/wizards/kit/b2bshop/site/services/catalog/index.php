<?
if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true )
	die();

$module = 'kit.b2bshop';

use Bitrix\Main\Config\Option;

$catalogSubscribe = $wizard->GetVar( "catalogSubscribe" );
$curSiteSubscribe = ($catalogSubscribe == "Y") ? array(
		"use" => "Y",
		"del_after" => "100"
) : array(
		"del_after" => "100"
);
$subscribe = COption::GetOptionString( "sale", "subscribe_prod", "" );
$arSubscribe = unserialize( $subscribe );
$arSubscribe[WIZARD_SITE_ID] = $curSiteSubscribe;
COption::SetOptionString( "sale", "subscribe_prod", serialize( $arSubscribe ) );

$catalogView = $wizard->GetVar( "catalogView" );
if( !in_array( $catalogView, array(
		"bar",
		"list",
		"price_list"
) ) )
	$catalogView = "list";
COption::SetOptionString( "kit.b2bshop", "catalogView", $catalogView, false, WIZARD_SITE_ID );

$useStoreControl = $wizard->GetVar( "useStoreControl" );
$useStoreControl = ($useStoreControl == "Y") ? "Y" : "N";
$curUseStoreControl = COption::GetOptionString( "catalog", "default_use_store_control", "N" );
COption::SetOptionString( "catalog", "default_use_store_control", $useStoreControl );

$productReserveCondition = $wizard->GetVar( "productReserveCondition" );
$productReserveCondition = (in_array( $productReserveCondition, array(
		"O",
		"P",
		"D",
		"S"
) )) ? $productReserveCondition : "P";
COption::SetOptionString( "sale", "product_reserve_condition", $productReserveCondition );

if( CModule::IncludeModule( "catalog" ) )
{
	if( $useStoreControl == "Y" && $curUseStoreControl == "N" )
	{
		$dbStores = CCatalogStore::GetList( array(), array(
				"ACTIVE" => 'Y'
		) );
		if( !$dbStores->Fetch() )
		{
			$arStoreFields = array(
					"TITLE" => GetMessage( "CAT_STORE_NAME" ),
					"ADDRESS" => GetMessage( "STORE_ADR_1" ),
					"DESCRIPTION" => GetMessage( "STORE_DESCR_1" ),
					"GPS_N" => GetMessage( "STORE_GPS_N_1" ),
					"GPS_S" => GetMessage( "STORE_GPS_S_1" ),
					"PHONE" => GetMessage( "STORE_PHONE_1" ),
					"SCHEDULE" => GetMessage( "STORE_PHONE_SCHEDULE" )
			);
			$newStoreId = CCatalogStore::Add( $arStoreFields );
			if( $newStoreId )
			{
				CCatalogDocs::synchronizeStockQuantity( $newStoreId );
			}
		}
	}
}

if( COption::GetOptionString( "kit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID ) == "Y" && !WIZARD_INSTALL_DEMO_DATA )
	return;

COption::SetOptionString( "catalog", "allow_negative_amount", "Y" );
COption::SetOptionString( "catalog", "default_can_buy_zero", "Y" );
COption::SetOptionString( "catalog", "default_quantity_trace", "Y" );

$catalogSubscribe = $wizard->GetVar( "catalogSubscribe" );
$curSiteSubscribe = ($catalogSubscribe == "Y") ? array(
		"use" => "Y",
		"del_after" => "100"
) : array(
		"del_after" => "100"
);
$subscribe = COption::GetOptionString( "sale", "subscribe_prod", "" );
$arSubscribe = unserialize( $subscribe );
$arSubscribe[WIZARD_SITE_ID] = $curSiteSubscribe;
COption::SetOptionString( "sale", "subscribe_prod", serialize( $arSubscribe ) );

$catalogView = $wizard->GetVar( "catalogView" );
if( !in_array( $catalogView, array(
		"bar",
		"list",
		"price_list"
) ) )
	$catalogView = "list";
COption::SetOptionString( "kit.b2bshop", "catalogView", $catalogView, false, WIZARD_SITE_ID );

$useStoreControl = $wizard->GetVar( "useStoreControl" );
$useStoreControl = ($useStoreControl == "Y") ? "Y" : "N";
$curUseStoreControl = COption::GetOptionString( "catalog", "default_use_store_control", "N" );
COption::SetOptionString( "catalog", "default_use_store_control", $useStoreControl );

$productReserveCondition = $wizard->GetVar( "productReserveCondition" );
$productReserveCondition = (in_array( $productReserveCondition, array(
		"O",
		"P",
		"D",
		"S"
) )) ? $productReserveCondition : "P";
COption::SetOptionString( "sale", "product_reserve_condition", $productReserveCondition );

if( CModule::IncludeModule( "catalog" ) )
{
	if( $useStoreControl == "Y" && $curUseStoreControl == "N" )
	{
		$dbStores = CCatalogStore::GetList( array(), array(
				"ACTIVE" => 'Y'
		) );
		if( !$dbStores->Fetch() )
		{
			$arStoreFields = array(
					"TITLE" => GetMessage( "CAT_STORE_NAME" ),
					"ADDRESS" => GetMessage( "STORE_ADR_1" ),
					"DESCRIPTION" => GetMessage( "STORE_DESCR_1" ),
					"GPS_N" => GetMessage( "STORE_GPS_N_1" ),
					"GPS_S" => GetMessage( "STORE_GPS_S_1" ),
					"PHONE" => GetMessage( "STORE_PHONE_1" ),
					"SCHEDULE" => GetMessage( "STORE_PHONE_SCHEDULE" )
			);
			$newStoreId = CCatalogStore::Add( $arStoreFields );
			if( $newStoreId )
			{
				CCatalogDocs::synchronizeStockQuantity( $newStoreId );
			}
		}
	}
}

if( COption::GetOptionString( "kit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID ) == "Y" && !WIZARD_INSTALL_DEMO_DATA )
	return;


COption::SetOptionString( "catalog", "allow_negative_amount", "Y" );
COption::SetOptionString( "catalog", "default_can_buy_zero", "Y" );
COption::SetOptionString( "catalog", "default_quantity_trace", "Y" );

\Bitrix\Main\Loader::includeModule( "iblock" );
$oUserTypeEntity = new CUserTypeEntity();

$aUserFields = array(
		'ENTITY_ID' => 'USER',
		'FIELD_NAME' => 'UF_CONFIDENTIAL',
		'USER_TYPE_ID' => 'boolean',
		'XML_ID' => 'UF_CONFIDENTIAL',
		'SORT' => 100,
		'MULTIPLE' => 'N',
		'MANDATORY' => 'Y',
		'SHOW_FILTER' => 'N',
		'SHOW_IN_LIST' => '',
		'EDIT_IN_LIST' => '',
		'IS_SEARCHABLE' => 'N',
		'SETTINGS' => array(
				'DEFAULT_VALUE' => '1',
				'DISPLAY' => 'CHECKBOX'
		),
		'EDIT_FORM_LABEL' => array(
				'ru' => GetMessage( "CONFIDENTIAL" )
		),
		'LIST_COLUMN_LABEL' => array(
				'ru' => GetMessage( "CONFIDENTIAL" )
		),
		'LIST_FILTER_LABEL' => array(
				'ru' => GetMessage( "CONFIDENTIAL" )
		),
		'ERROR_MESSAGE' => array(
				'ru' => GetMessage( "CONFIDENTIAL" )
		),
		'HELP_MESSAGE' => array(
				'ru' => GetMessage( "CONFIDENTIAL" )
		)
);

$iUserFieldId = $oUserTypeEntity->Add( $aUserFields );

if( $module == 'kit.b2bshop' )
{

	$personTypeFiz = COption::SetOptionString( "kit.b2bshop", "personTypeFiz", '', false, WIZARD_SITE_ID );
	$personTypeUr = COption::SetOptionString( "kit.b2bshop", "personTypeUr", '', false, WIZARD_SITE_ID );
	$personTypeIp = COption::SetOptionString( "kit.b2bshop", "personTypeIp", '', false, WIZARD_SITE_ID );

	if( $personTypeUr == 'Y' || $personTypeIp == 'Y' )
	{
		$iblockId = COption::GetOptionString( "kit.b2bshop", "IBLOCK_ID", "" );
		$iblockType = COption::GetOptionString( "kit.b2bshop", "IBLOCK_TYPE", "" );
		if( $iblockId > 0 )
		{
			COption::SetOptionString( "kit.b2bshop", "OPT_IBLOCK_ID", $iblockId );
			COption::SetOptionString( "kit.b2bshop", "OPT_IBLOCK_TYPE", $iblockType );

			$optFilterFields = array();
			$props = CIBlockSectionPropertyLink::GetArray( $iblockId, $SECTION_ID = 0, $bNewSection = false );
			foreach( $props as $prop )
			{
				if( $prop['SMART_FILTER'] == 'Y' )
				{
					$arPropx = CIBlockProperty::GetByID( $prop['PROPERTY_ID'] )->fetch();
					$optFilterFields[] = $arPropx['CODE'];
				}
			}

			COption::SetOptionString( "kit.b2bshop", "OPT_BLANK_GROUPS", serialize( array(
					1
			) ) );

			$properties = CIBlockProperty::GetList( Array(
					"sort" => "asc",
					"name" => "asc"
			), Array(
					"ACTIVE" => "Y",
					"IBLOCK_ID" => $iblockId
			) );
			while ( $prop_fields = $properties->GetNext() )
			{
				if( $prop_fields["CODE"] == 'CML2_ARTICLE' )
				{
					COption::SetOptionString( "kit.b2bshop", "OPT_ARTICUL_PROP", $prop_fields['ID'] );
					break;
				}
			}
			\Bitrix\Main\Loader::includeModule( "catalog" );
			$mxResult = CCatalogSKU::GetInfoByProductIBlock( $iblockId );
			$props = array();
			if( is_array( $mxResult ) && $mxResult['IBLOCK_ID'] > 0 )
			{
				$properties = CIBlockProperty::GetList( Array(
						"sort" => "asc",
						"name" => "asc"
				), Array(
						"ACTIVE" => "Y",
						"IBLOCK_ID" => $mxResult['IBLOCK_ID']
				) );
				while ( $prop_fields = $properties->GetNext() )
				{
					if( in_array( $prop_fields["CODE"], array(
							'RAZMER',
							'COLOR'
					) ) )
					{
						$props[] = $prop_fields['ID'];
					}
					if( $prop_fields["CODE"] == 'CML2_ARTICLE' )
					{
						COption::SetOptionString( "kit.b2bshop", "OPT_ARTICUL_PROP_OFFER", $prop_fields['ID'] );
					}
				}

				$propsx = CIBlockSectionPropertyLink::GetArray( $mxResult['IBLOCK_ID'], $SECTION_ID = 0, $bNewSection = false );
				foreach( $propsx as $prop )
				{
					if( $prop['SMART_FILTER'] == 'Y' )
					{
						$arPropx = CIBlockProperty::GetByID( $prop['PROPERTY_ID'] )->fetch();
						$optFilterFields[] = $arPropx['CODE'];
					}
				}
			}
			COption::SetOptionString( "kit.b2bshop", "OPT_PROPS", serialize( $props ) );

			COption::SetOptionString( "kit.b2bshop", "OPT_FILTER_FIELDS", serialize( $optFilterFields ) );
		}
	}

	// ///////

	$OPT1_GROUP_ID = 0;
	$Group = CGroup::GetList( ($by = "c_sort"), ($order = "desc"), array(
			'STRING_ID' => 'OPT1'
	) )->fetch();
	if( !$Group['ID'] )
	{
		$group = new CGroup();
		$arFields = Array(
				"ACTIVE" => "Y",
				"C_SORT" => 100,
				"NAME" => GetMessage( "GROUP_OPT1" ),
				"DESCRIPTION" => "",
				"USER_ID" => array(),
				"STRING_ID" => "OPT1"
		);
		$OPT1_GROUP_ID = $group->Add( $arFields );
	}
	else
	{
		$OPT1_GROUP_ID = $Group['ID'];
	}
	$OPT2_GROUP_ID = 0;
	$Group = CGroup::GetList( ($by = "c_sort"), ($order = "desc"), array(
			'STRING_ID' => 'OPT2'
	) )->fetch();
	if( !$Group['ID'] )
	{
		$group = new CGroup();
		$arFields = Array(
				"ACTIVE" => "Y",
				"C_SORT" => 100,
				"NAME" => GetMessage( "GROUP_OPT2" ),
				"DESCRIPTION" => "",
				"USER_ID" => array(),
				"STRING_ID" => "OPT2"
		);
		$OPT2_GROUP_ID = $group->Add( $arFields );
	}
	else
	{
		$OPT2_GROUP_ID = $Group['ID'];
	}

	$dbPriceType = CCatalogGroup::GetList();
	while ( $arPriceType = $dbPriceType->Fetch() )
	{
		if( $arPriceType['NAME'] == 'OPT1' && $arPriceType['NAME_LANG'] == 'OPT1' && $OPT1_GROUP_ID > 0 )
		{
			CCatalogGroup::Update( $arPriceType['ID'], array(
					'USER_LANG' => array(
							'ru' => GetMessage( "PRICE_OPT1" )
					),
					'USER_GROUP' => array(
							$OPT1_GROUP_ID
					),
					'USER_GROUP_BUY' => array(
							$OPT1_GROUP_ID
					)
			) );
		}

		if( $arPriceType['NAME'] == 'OPT2' && $arPriceType['NAME_LANG'] == 'OPT2' && $OPT2_GROUP_ID > 0 )
		{
			CCatalogGroup::Update( $arPriceType['ID'], array(
					'USER_LANG' => array(
							'ru' => GetMessage( "PRICE_OPT2" )
					),
					'USER_GROUP' => array(
							$OPT2_GROUP_ID
					),
					'USER_GROUP_BUY' => array(
							$OPT2_GROUP_ID
					)
			) );
		}
	}

	// COption::SetOptionString("main", "auth_components_template", "");

	$optGroups = unserialize( COption::GetOptionString( "kit.b2bshop", "OPT_BLANK_GROUPS", "" ) );

	if( !is_array( $optGroups ) )
	{
		$optGroups = array();
	}

	if( $OPT1_GROUP_ID > 0 )
	{
		array_push( $optGroups, $OPT1_GROUP_ID );
	}
	if( $OPT2_GROUP_ID > 0 )
	{
		array_push( $optGroups, $OPT2_GROUP_ID );
	}
	COption::SetOptionString( "kit.b2bshop", "OPT_BLANK_GROUPS", serialize( $optGroups ) );

	$result = \Bitrix\Main\SiteTable::getList( array() );
	while ( $Site = $result->fetch() )
	{
		if( $OPT1_GROUP_ID > 0 )
		{
			COption::SetOptionString( "kit.auth", "WHOLESALERS_GROUP", $OPT1_GROUP_ID, '', $Site['LID'] );
		}
	}

	$props = array();
	CModule::IncludeModule( "sale" );
	$inn = \Bitrix\Sale\Internals\OrderPropsTable::getList( array(
			'filter' => array(
					'ACTIVE' => 'Y',
					'CODE' => array(
							'INN',
							'COMPANY'
					)
			),
			'select' => array(
					'ID',
					'CODE',
					'NAME'
			)
	) );
	while ( $code = $inn->fetch() )
	{
		array_push( $props, $code['CODE'] );
	}

	COption::SetOptionString( "kit.b2bshop", "OPT_REGISTER_ORDER_FIELDS", serialize( $props ) );

	COption::SetOptionString( "kit.b2bshop", "OPT_REGISTER_FIELDS", serialize( array(
			'EMAIL',
			'NAME',
			'LAST_NAME'
	) ) );

	$prices = array();
	$rsPrice = CCatalogGroup::GetList( $v1 = "sort", $v2 = "asc" );
	while ( $arr = $rsPrice->Fetch() )
	{
		array_push( $prices, $arr["NAME"] );
	}

	COption::SetOptionString( "kit.b2bshop", "PRICE_CODE", serialize( $prices ) );
}
// ///////
if( COption::GetOptionString( "kit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID ) == "Y" && !WIZARD_INSTALL_DEMO_DATA )
	return;
CModule::IncludeModule( "iblock" );


$IBLOCK_CATALOG_ID = 0;
if (isset($_SESSION["WIZARD_CATALOG_IBLOCK_ID"]))
{
	$IBLOCK_CATALOG_ID = (int)$_SESSION["WIZARD_CATALOG_IBLOCK_ID"];
	unset($_SESSION["WIZARD_CATALOG_IBLOCK_ID"]);
}
$IBLOCK_OFFERS_ID = 0;
if (isset($_SESSION["WIZARD_OFFERS_IBLOCK_ID"]))
{
	$IBLOCK_OFFERS_ID = (int)$_SESSION["WIZARD_OFFERS_IBLOCK_ID"];
	unset($_SESSION["WIZARD_OFFERS_IBLOCK_ID"]);
}

if ($IBLOCK_CATALOG_ID > 0)
{
	$index = \Bitrix\Iblock\PropertyIndex\Manager::createIndexer($IBLOCK_CATALOG_ID);
	$index->startIndex();
	$index->continueIndex(0);
	$index->endIndex();
}

if ($IBLOCK_OFFERS_ID > 0)
{
	$index = \Bitrix\Iblock\PropertyIndex\Manager::createIndexer($IBLOCK_OFFERS_ID);
	$index->startIndex();
	$index->continueIndex(0);
	$index->endIndex();
}

if ($IBLOCK_OFFERS_ID > 0)
{
	$count = \Bitrix\Iblock\ElementTable::getCount(array(
		'=IBLOCK_ID' => $IBLOCK_OFFERS_ID,
		'=WF_PARENT_ELEMENT_ID' => null
	));
	if ($count > 0)
	{
		$catalogReindex = new CCatalogProductAvailable('', 0, 0);
		$catalogReindex->initStep($count, 0, 0);
		$catalogReindex->setParams(array('IBLOCK_ID' => $IBLOCK_OFFERS_ID));
		$catalogReindex->run();
		unset($catalogReindex);
	}
}
/*
if ($IBLOCK_OFFERS_ID > 0)
{
	$iterator = \Bitrix\Catalog\ProductTable::getList(array(
		'select' => array('ID'),
		'filter' => array('=IBLOCK_ELEMENT.IBLOCK_ID' => $IBLOCK_OFFERS_ID),
		'order' => array('ID' => 'ASC')
	));
	while ($row = $iterator->fetch())
	{
		$result = \Bitrix\Catalog\MeasureRatioTable::add(array(
			'PRODUCT_ID' => $row['ID'],
			'RATIO' => 1
		));
		unset($result);
	}
	unset($row, $iterator);
}
*/
if ($IBLOCK_CATALOG_ID > 0)
{
	$count = \Bitrix\Iblock\ElementTable::getCount(array(
		'=IBLOCK_ID' => $IBLOCK_CATALOG_ID,
		'=WF_PARENT_ELEMENT_ID' => null
	));
	if ($count > 0)
	{
		$catalogReindex = new CCatalogProductAvailable('', 0, 0);
		$catalogReindex->initStep($count, 0, 0);
		$catalogReindex->setParams(array('IBLOCK_ID' => $IBLOCK_CATALOG_ID));
		$catalogReindex->run();
		unset($catalogReindex);
	}
}

?>