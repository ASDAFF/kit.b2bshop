<?
if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true )
	die();

if( !CModule::IncludeModule( 'sale' ) )
	return;

use Bitrix\Sale\BusinessValue, Bitrix\Sale\OrderStatus, Bitrix\Sale\DeliveryStatus, Bitrix\Main\Localization\Loc, Bitrix\Sale\Internals\BusinessValueTable, Bitrix\Sale\Internals\BusinessValuePersonDomainTable;

$module = 'sotbit.b2bshop';

$saleConverted15 = COption::GetOptionString( "main", "~sale_converted_15", "" ) == "Y";
if( $saleConverted15 )
{
	$BIZVAL_INDIVIDUAL_DOMAIN = BusinessValue::INDIVIDUAL_DOMAIN;
	$BIZVAL_ENTITY_DOMAIN = BusinessValue::ENTITY_DOMAIN;
}
else
{
	$BIZVAL_INDIVIDUAL_DOMAIN = null;
	$BIZVAL_ENTITY_DOMAIN = null;
}

if( COption::GetOptionString( "catalog", "1C_GROUP_PERMISSIONS" ) == "" )
	COption::SetOptionString( "catalog", "1C_GROUP_PERMISSIONS", "1", GetMessage( 'SALE_1C_GROUP_PERMISSIONS' ) );

$arGeneralInfo = Array();

$dbSite = CSite::GetByID( WIZARD_SITE_ID );
if( $arSite = $dbSite->Fetch() )
	$lang = $arSite["LANGUAGE_ID"];
if( strlen( $lang ) <= 0 )
	$lang = "ru";
$bRus = false;
if( $lang == "ru" )
	$bRus = true;

$shopLocalization = $wizard->GetVar( "shopLocalization" );

COption::SetOptionString( "sotbit.b2bshop", "shopLocalization", $shopLocalization, "ru", WIZARD_SITE_ID );
if( $shopLocalization == "kz" || $shopLocalization == "bl" )
	$shopLocalization = "ru";

$defCurrency = "EUR";
if( $lang == "ru" )
{
	if( $shopLocalization == "ua" )
		$defCurrency = "UAH";
	elseif( $shopLocalization == "bl" )
		$defCurrency = "BYR";
	else
		$defCurrency = "RUB";
}
elseif( $lang == "en" )
{
	$defCurrency = "USD";
}

$arLanguages = Array();
$rsLanguage = CLanguage::GetList( $by, $order, array() );
while ( $arLanguage = $rsLanguage->Fetch() )
	$arLanguages[] = $arLanguage["LID"];

WizardServices::IncludeServiceLang( "step1.php", $lang );

if( $bRus || COption::GetOptionString( "sotbit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID ) != "Y" || WIZARD_INSTALL_DEMO_DATA )
{
	$personType = $wizard->GetVar( "personType" );
	$paysystem = $wizard->GetVar( "paysystem" );

	if( $shopLocalization == "ru" )
	{
		if( CSaleLang::GetByID( WIZARD_SITE_ID ) )
			CSaleLang::Update( WIZARD_SITE_ID, array(
					"LID" => WIZARD_SITE_ID,
					"CURRENCY" => "RUB"
			) );
		else
			CSaleLang::Add( array(
					"LID" => WIZARD_SITE_ID,
					"CURRENCY" => "RUB"
			) );

		$shopLocation = $wizard->GetVar( "shopLocation" );
		COption::SetOptionString( "sotbit.b2bshop", "shopLocation", $shopLocation, false, WIZARD_SITE_ID );
		$shopOfName = $wizard->GetVar( "shopOfName" );
		COption::SetOptionString( "sotbit.b2bshop", "shopOfName", $shopOfName, false, WIZARD_SITE_ID );
		$shopAdr = $wizard->GetVar( "shopAdr" );
		COption::SetOptionString( "sotbit.b2bshop", "shopAdr", $shopAdr, false, WIZARD_SITE_ID );

		$shopINN = $wizard->GetVar( "shopINN" );
		COption::SetOptionString( "sotbit.b2bshop", "shopINN", $shopINN, false, WIZARD_SITE_ID );
		$shopKPP = $wizard->GetVar( "shopKPP" );
		COption::SetOptionString( "sotbit.b2bshop", "shopKPP", $shopKPP, false, WIZARD_SITE_ID );
		$shopNS = $wizard->GetVar( "shopNS" );
		COption::SetOptionString( "sotbit.b2bshop", "shopNS", $shopNS, false, WIZARD_SITE_ID );
		$shopBANK = $wizard->GetVar( "shopBANK" );
		COption::SetOptionString( "sotbit.b2bshop", "shopBANK", $shopBANK, false, WIZARD_SITE_ID );
		$shopBANKREKV = $wizard->GetVar( "shopBANKREKV" );
		COption::SetOptionString( "sotbit.b2bshop", "shopBANKREKV", $shopBANKREKV, false, WIZARD_SITE_ID );
		$shopKS = $wizard->GetVar( "shopKS" );
		COption::SetOptionString( "sotbit.b2bshop", "shopKS", $shopKS, false, WIZARD_SITE_ID );
		$siteStamp = $wizard->GetVar( "siteStamp" );
		if( $siteStamp == "" )
			$siteStamp = COption::GetOptionString( "sotbit.b2bshop", "siteStamp", "", WIZARD_SITE_ID );
	}
	elseif( $shopLocalization == "ua" )
	{
		if( CSaleLang::GetByID( WIZARD_SITE_ID ) )
			CSaleLang::Update( WIZARD_SITE_ID, array(
					"LID" => WIZARD_SITE_ID,
					"CURRENCY" => "UAH"
			) );
		else
			CSaleLang::Add( array(
					"LID" => WIZARD_SITE_ID,
					"CURRENCY" => "UAH"
			) );

		$shopLocation = $wizard->GetVar( "shopLocation_ua" );
		COption::SetOptionString( "sotbit.b2bshop", "shopLocation_ua", $shopLocation, false, WIZARD_SITE_ID );
		$shopOfName = $wizard->GetVar( "shopOfName_ua" );
		COption::SetOptionString( "sotbit.b2bshop", "shopOfName_ua", $shopOfName, false, WIZARD_SITE_ID );
		$shopAdr = $wizard->GetVar( "shopAdr_ua" );
		COption::SetOptionString( "sotbit.b2bshop", "shopAdr_ua", $shopAdr, false, WIZARD_SITE_ID );

		$shopEGRPU_ua = $wizard->GetVar( "shopEGRPU_ua" );
		COption::SetOptionString( "sotbit.b2bshop", "shopEGRPU_ua", $shopEGRPU_ua, false, WIZARD_SITE_ID );
		$shopINN_ua = $wizard->GetVar( "shopINN_ua" );
		COption::SetOptionString( "sotbit.b2bshop", "shopINN_ua", $shopINN_ua, false, WIZARD_SITE_ID );
		$shopNDS_ua = $wizard->GetVar( "shopNDS_ua" );
		COption::SetOptionString( "sotbit.b2bshop", "shopNDS_ua", $shopNDS_ua, false, WIZARD_SITE_ID );
		$shopNS_ua = $wizard->GetVar( "shopNS_ua" );
		COption::SetOptionString( "sotbit.b2bshop", "shopNS_ua", $shopNS_ua, false, WIZARD_SITE_ID );
		$shopBank_ua = $wizard->GetVar( "shopBank_ua" );
		COption::SetOptionString( "sotbit.b2bshop", "shopBank_ua", $shopBank_ua, false, WIZARD_SITE_ID );
		$shopMFO_ua = $wizard->GetVar( "shopMFO_ua" );
		COption::SetOptionString( "sotbit.b2bshop", "shopMFO_ua", $shopMFO_ua, false, WIZARD_SITE_ID );
		$shopPlace_ua = $wizard->GetVar( "shopPlace_ua" );
		COption::SetOptionString( "sotbit.b2bshop", "shopPlace_ua", $shopPlace_ua, false, WIZARD_SITE_ID );
		$shopFIO_ua = $wizard->GetVar( "shopFIO_ua" );
		COption::SetOptionString( "sotbit.b2bshop", "shopFIO_ua", $shopFIO_ua, false, WIZARD_SITE_ID );
		$shopTax_ua = $wizard->GetVar( "shopTax_ua" );
		COption::SetOptionString( "sotbit.b2bshop", "shopTax_ua", $shopTax_ua, false, WIZARD_SITE_ID );
	}

	$siteTelephone = $wizard->GetVar( "siteTelephone" );
	COption::SetOptionString( "sotbit.b2bshop", "siteTelephone", $siteTelephone, false, WIZARD_SITE_ID );
	$shopEmail = $wizard->GetVar( "shopEmail" );
	COption::SetOptionString( "sotbit.b2bshop", "shopEmail", $shopEmail, false, WIZARD_SITE_ID );
	$siteName = $wizard->GetVar( "siteName" );
	COption::SetOptionString( "sotbit.b2bshop", "siteName", $siteName, false, WIZARD_SITE_ID );

	$obSite = new CSite();
	$obSite->Update( WIZARD_SITE_ID, Array(
			"EMAIL" => $shopEmail,
			"SITE_NAME" => $siteName,
			"SERVER_NAME" => $_SERVER["SERVER_NAME"]
	) );

	if( strlen( $siteStamp ) > 0 )
	{
		if( IntVal( $siteStamp ) > 0 )
		{
			$ff = CFile::GetByID( $siteStamp );
			if( $zr = $ff->Fetch() )
			{
				$strOldFile = str_replace( "//", "/", WIZARD_SITE_ROOT_PATH . "/" . (COption::GetOptionString( "main", "upload_dir", "upload" )) . "/" . $zr["SUBDIR"] . "/" . $zr["FILE_NAME"] );
				@copy( $strOldFile, WIZARD_SITE_PATH . "include/stamp.gif" );
				CFile::Delete( $zr["ID"] );
				$siteStamp = WIZARD_SITE_DIR . "include/stamp.gif";
				COption::SetOptionString( "sotbit.b2bshop", "siteStamp", $siteStamp, false, WIZARD_SITE_ID );
			}
		}
	}
	else
	{
		$siteStamp = "/bitrix/templates/" . WIZARD_TEMPLATE_ID . "_" . WIZARD_THEME_ID . "/images/pechat.gif";
	}

	$arPersonTypeNames = array();
	$dbPerson = CSalePersonType::GetList( array(), array(
			"LID" => WIZARD_SITE_ID
	) );
	// if(!$dbPerson->Fetch())//if there are no data in module
	// {
	while ( $arPerson = $dbPerson->Fetch() )
	{
		$arPersonTypeNames[$arPerson["ID"]] = $arPerson["NAME"];
	}
	// Person Types
	if( !$bRus )
	{
		$personType["fiz"] = "Y";
		$personType["ur"] = "N";
	}

	$fizExist = in_array( GetMessage( "SALE_WIZARD_PERSON_1" ), $arPersonTypeNames );
	$urExist = in_array( GetMessage( "SALE_WIZARD_PERSON_2" ), $arPersonTypeNames );
	$ipExist = in_array( GetMessage( "SALE_WIZARD_PERSON_4" ), $arPersonTypeNames );
	$fizUaExist = in_array( GetMessage( "SALE_WIZARD_PERSON_3" ), $arPersonTypeNames );

	$personTypeFiz = (isset( $personType["fiz"] ) && $personType["fiz"] == "Y" ? "Y" : "N");
	COption::SetOptionString( "sotbit.b2bshop", "personTypeFiz", $personTypeFiz, false, WIZARD_SITE_ID );
	$personTypeUr = (isset( $personType["ur"] ) && $personType["ur"] == "Y" ? "Y" : "N");
	COption::SetOptionString( "sotbit.b2bshop", "personTypeUr", $personTypeUr, false, WIZARD_SITE_ID );
	$personTypeIp = (isset( $personType["ip"] ) && $personType["ip"] == "Y" ? "Y" : "N");
	COption::SetOptionString( "sotbit.b2bshop", "personTypeIp", $personTypeIp, false, WIZARD_SITE_ID );

	if( in_array( GetMessage( "SALE_WIZARD_PERSON_1" ), $arPersonTypeNames ) )
	{
		$arGeneralInfo["personType"]["fiz"] = array_search( GetMessage( "SALE_WIZARD_PERSON_1" ), $arPersonTypeNames );
		CSalePersonType::Update( array_search( GetMessage( "SALE_WIZARD_PERSON_1" ), $arPersonTypeNames ), Array(
				"ACTIVE" => $personTypeFiz
		) );
	}
	elseif( $personTypeFiz == "Y" )
	{
		$arGeneralInfo["personType"]["fiz"] = CSalePersonType::Add( Array(
				"LID" => WIZARD_SITE_ID,
				"NAME" => GetMessage( "SALE_WIZARD_PERSON_1" ),
				"SORT" => "100"
		) );
	}

	if( in_array( GetMessage( "SALE_WIZARD_PERSON_2" ), $arPersonTypeNames ) )
	{
		$arGeneralInfo["personType"]["ur"] = array_search( GetMessage( "SALE_WIZARD_PERSON_2" ), $arPersonTypeNames );
		CSalePersonType::Update( array_search( GetMessage( "SALE_WIZARD_PERSON_2" ), $arPersonTypeNames ), Array(
				"ACTIVE" => $personTypeUr
		) );
	}
	elseif( $personTypeUr == "Y" )
	{
		$arGeneralInfo["personType"]["ur"] = CSalePersonType::Add( Array(
				"LID" => WIZARD_SITE_ID,
				"NAME" => GetMessage( "SALE_WIZARD_PERSON_2" ),
				"SORT" => "150"
		) );
	}

	if( in_array( GetMessage( "SALE_WIZARD_PERSON_4" ), $arPersonTypeNames ) )
	{
		$arGeneralInfo["personType"]["ip"] = array_search( GetMessage( "SALE_WIZARD_PERSON_4" ), $arPersonTypeNames );
		CSalePersonType::Update( array_search( GetMessage( "SALE_WIZARD_PERSON_4" ), $arPersonTypeNames ), Array(
				"ACTIVE" => $personTypeIp
		) );
	}
	elseif( $personTypeIp == "Y" )
	{
		$arGeneralInfo["personType"]["ip"] = CSalePersonType::Add( Array(
				"LID" => WIZARD_SITE_ID,
				"NAME" => GetMessage( "SALE_WIZARD_PERSON_4" ),
				"SORT" => "200"
		) );
	}

	if( $shopLocalization == "ua" )
	{
		$personTypeFizUa = (isset( $personType["fiz_ua"] ) && $personType["fiz_ua"] == "Y" ? "Y" : "N");
		COption::SetOptionString( "sotbit.b2bshop", "personTypeFizUa", $personTypeFizUa, false, WIZARD_SITE_ID );

		if( in_array( GetMessage( "SALE_WIZARD_PERSON_3" ), $arPersonTypeNames ) )
		{
			$arGeneralInfo["personType"]["fiz_ua"] = array_search( GetMessage( "SALE_WIZARD_PERSON_3" ), $arPersonTypeNames );
			CSalePersonType::Update( array_search( GetMessage( "SALE_WIZARD_PERSON_3" ), $arPersonTypeNames ), Array(
					"ACTIVE" => $personTypeFizUa
			) );
		}
		elseif( $personTypeFizUa == "Y" )
		{
			$arGeneralInfo["personType"]["fiz_ua"] = CSalePersonType::Add( Array(
					"LID" => WIZARD_SITE_ID,
					"NAME" => GetMessage( "SALE_WIZARD_PERSON_3" ),
					"SORT" => "100"
			) );
		}
	}

	if( COption::GetOptionString( "sotbit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID ) != "Y" || WIZARD_INSTALL_DEMO_DATA )
	{
		// Set options
		COption::SetOptionString( 'sale', 'default_currency', $defCurrency );
		COption::SetOptionString( 'sale', 'delete_after', '30' );
		COption::SetOptionString( 'sale', 'order_list_date', '30' );
		COption::SetOptionString( 'sale', 'MAX_LOCK_TIME', '30' );
		COption::SetOptionString( 'sale', 'GRAPH_WEIGHT', '600' );
		COption::SetOptionString( 'sale', 'GRAPH_HEIGHT', '600' );
		COption::SetOptionString( 'sale', 'path2user_ps_files', '/bitrix/php_interface/include/sale_payment/' );
		COption::SetOptionString( 'sale', 'lock_catalog', 'Y' );
		COption::SetOptionString( 'sale', 'order_list_fields', 'ID,USER,PAY_SYSTEM,PRICE,STATUS,PAYED,PS_STATUS,CANCELED,BASKET' );
		COption::SetOptionString( 'sale', 'GROUP_DEFAULT_RIGHT', 'D' );
		COption::SetOptionString( 'sale', 'affiliate_param_name', 'partner' );
		COption::SetOptionString( 'sale', 'show_order_sum', 'N' );
		COption::SetOptionString( 'sale', 'show_order_product_xml_id', 'N' );
		COption::SetOptionString( 'sale', 'show_paysystem_action_id', 'N' );
		COption::SetOptionString( 'sale', 'affiliate_plan_type', 'N' );
		if( $bRus )
		{
			COption::SetOptionString( 'sale', '1C_SALE_SITE_LIST', WIZARD_SITE_ID );
			COption::SetOptionString( 'sale', '1C_EXPORT_PAYED_ORDERS', 'N' );
			COption::SetOptionString( 'sale', '1C_EXPORT_ALLOW_DELIVERY_ORDERS', 'N' );
			COption::SetOptionString( 'sale', '1C_EXPORT_FINAL_ORDERS', '' );
			COption::SetOptionString( 'sale', '1C_FINAL_STATUS_ON_DELIVERY', 'F' );
			COption::SetOptionString( 'sale', '1C_REPLACE_CURRENCY', GetMessage( "SALE_WIZARD_PS_BILL_RUB" ) );
			COption::SetOptionString( 'sale', '1C_SALE_USE_ZIP', 'Y' );
		}
		COption::SetOptionString( 'sale', 'weight_unit', GetMessage( "SALE_WIZARD_WEIGHT_UNIT" ), false, WIZARD_SITE_ID );
		COption::SetOptionString( 'sale', 'WEIGHT_different_set', 'N', false, WIZARD_SITE_ID );
		COption::SetOptionString( 'sale', 'ADDRESS_different_set', 'N' );
		COption::SetOptionString( 'sale', 'measurement_path', '/bitrix/modules/sale/measurements.php' );
		COption::SetOptionString( 'sale', 'delivery_handles_custom_path', '/bitrix/php_interface/include/sale_delivery/' );
		if( $bRus )
			COption::SetOptionString( 'sale', 'location_zip', '101000' );
		COption::SetOptionString( 'sale', 'weight_koef', '1000', false, WIZARD_SITE_ID );

		COption::SetOptionString( 'sale', 'recalc_product_list', 'Y' );
		COption::SetOptionString( 'sale', 'recalc_product_list_period', '4' );
		COption::SetOptionString( 'sale', 'order_email', $shopEmail );
		COption::SetOptionString( 'sale', 'encode_fuser_id', 'Y' );

		if( !$bRus )
			$shopLocation = GetMessage( "WIZ_CITY" );

		if( \Bitrix\Main\Config\Option::get( 'sale', 'sale_locationpro_migrated', '' ) == 'Y' )
		{
			$location = '';

			if( strlen( $shopLocation ) )
			{
				// get city with name equal to $shopLocation
				$item = \Bitrix\Sale\Location\LocationTable::getList( array(
						'filter' => array(
								'=NAME.LANGUAGE_ID' => $lang,
								'=NAME.NAME' => $shopLocation,
								'=TYPE.CODE' => 'CITY'
						),
						'select' => array(
								'CODE'
						)
				) )->fetch();

				if( $item )
					$location = $item['CODE']; // city found, simply take it`s code an proceed with it
				else
				{
					// city were not found, create it

					require ($_SERVER['DOCUMENT_ROOT'] . WIZARD_SERVICE_RELATIVE_PATH . "/locations/pro/country_codes.php");

					// due to some reasons, $shopLocalization is being changed at the beginning of the step,
					// but here we want to have real country selected, so introduce a new variable
					$shopCountry = $wizard->GetVar( "shopLocalization" );

					$countryCode = $LOCALIZATION_COUNTRY_CODE_MAP[$shopCountry];
					$countryId = false;

					if( strlen( $countryCode ) )
					{
						// get country which matches the current localization
						$countryId = 0;
						$item = \Bitrix\Sale\Location\LocationTable::getList( array(
								'filter' => array(
										'=CODE' => $countryCode,
										'=TYPE.CODE' => 'COUNTRY'
								),
								'select' => array(
										'ID'
								)
						) )->fetch();

						// country found
						if( $item )
							$countryId = $item['ID'];
					}

					// at this point types must exist
					$types = array();
					$res = \Bitrix\Sale\Location\TypeTable::getList();
					while ( $item = $res->fetch() )
						$types[$item['CODE']] = $item['ID'];

					if( isset( $types['COUNTRY'] ) && isset( $types['CITY'] ) )
					{
						if( !$countryId )
						{
							// such country were not found, create it

							$data = array(
									'CODE' => 'demo_country_' . WIZARD_SITE_ID,
									'TYPE_ID' => $types['COUNTRY'],
									'NAME' => array()
							);
							foreach( $arLanguages as $langID )
							{
								$data["NAME"][$langID] = array(
										'NAME' => GetMessage( "WIZ_COUNTRY_" . ToUpper( $shopCountry ) )
								);
							}

							$res = \Bitrix\Sale\Location\LocationTable::add( $data );
							if( $res->isSuccess() )
								$countryId = $res->getId();
						}

						if( $countryId )
						{
							// ok, so country were created, now create demo-city

							$data = array(
									'CODE' => 'demo_city_' . WIZARD_SITE_ID,
									'TYPE_ID' => $types['CITY'],
									'NAME' => array(),
									'PARENT_ID' => $countryId
							);
							foreach( $arLanguages as $langID )
							{
								$data["NAME"][$langID] = array(
										'NAME' => $shopLocation
								);
							}

							$res = \Bitrix\Sale\Location\LocationTable::add( $data );
							if( $res->isSuccess() )
								$location = 'demo_city_' . WIZARD_SITE_ID;
						}
					}
				}
			}
		}
		else
		{
			$location = 0;
			$dbLocation = CSaleLocation::GetList( Array(
					"ID" => "ASC"
			), Array(
					"LID" => $lang,
					"CITY_NAME" => $shopLocation
			) );
			if( $arLocation = $dbLocation->Fetch() ) // if there are no data in module
			{
				$location = $arLocation["ID"];
			}
			if( IntVal( $location ) <= 0 )
			{
				$CurCountryID = 0;
				$db_contList = CSaleLocation::GetList( Array(), Array(
						"COUNTRY_NAME" => GetMessage( "WIZ_COUNTRY_" . ToUpper( $shopLocalization ) ),
						"LID" => $lang
				) );
				if( $arContList = $db_contList->Fetch() )
				{
					$LLL = IntVal( $arContList["ID"] );
					$CurCountryID = IntVal( $arContList["COUNTRY_ID"] );
				}

				if( IntVal( $CurCountryID ) <= 0 )
				{
					$arArrayTmp = Array();
					$arArrayTmp["NAME"] = GetMessage( "WIZ_COUNTRY_" . ToUpper( $shopLocalization ) );
					foreach( $arLanguages as $langID )
					{
						WizardServices::IncludeServiceLang( "step1.php", $langID );
						$arArrayTmp[$langID] = array(
								"LID" => $langID,
								"NAME" => GetMessage( "WIZ_COUNTRY_" . ToUpper( $shopLocalization ) )
						);
					}
					$CurCountryID = CSaleLocation::AddCountry( $arArrayTmp );
				}

				$arArrayTmp = Array();
				$arArrayTmp["NAME"] = $shopLocation;
				foreach( $arLanguages as $langID )
				{
					$arArrayTmp[$langID] = array(
							"LID" => $langID,
							"NAME" => $shopLocation
					);
				}
				$city_id = CSaleLocation::AddCity( $arArrayTmp );

				$location = CSaleLocation::AddLocation( array(
						"COUNTRY_ID" => $CurCountryID,
						"CITY_ID" => $city_id
				) );
				if( $bRus )
					CSaleLocation::AddLocationZIP( $location, "101000" );

				WizardServices::IncludeServiceLang( "step1.php", $lang );
			}
		}

		COption::SetOptionString( 'sale', 'location', $location );
	}
	// Order Prop Group
	if( $fizExist )
	{
		$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList( Array(), Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_FIZ1" )
		), false, false, array(
				"ID"
		) );
		if( $arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext() )
			$arGeneralInfo["propGroup"]["user_fiz"] = $arSaleOrderPropsGroup["ID"];

		$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList( Array(), Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_FIZ2" )
		), false, false, array(
				"ID"
		) );
		if( $arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext() )
			$arGeneralInfo["propGroup"]["adres_fiz"] = $arSaleOrderPropsGroup["ID"];
	}
	elseif( $personType["fiz"] == "Y" )
	{
		$arGeneralInfo["propGroup"]["user_fiz"] = CSaleOrderPropsGroup::Add( Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_FIZ1" ),
				"SORT" => 100
		) );
		$arGeneralInfo["propGroup"]["adres_fiz"] = CSaleOrderPropsGroup::Add( Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_FIZ2" ),
				"SORT" => 200
		) );
	}

	if( $urExist )
	{
		$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList( Array(), Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_UR1" )
		), false, false, array(
				"ID"
		) );
		if( $arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext() )
			$arGeneralInfo["propGroup"]["company_ur"] = $arSaleOrderPropsGroup["ID"];
		else
		{
			$arGeneralInfo["propGroup"]["company_ur"] = CSaleOrderPropsGroup::Add( Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_UR1" ),
					"SORT" => 300
			) );
		}
		$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList( Array(), Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_UR2" )
		), false, false, array(
				"ID"
		) );
		if( $arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext() )
			$arGeneralInfo["propGroup"]["uradres_ur"] = $arSaleOrderPropsGroup["ID"];
		else
		{
			$arGeneralInfo["propGroup"]["uradres_ur"] = CSaleOrderPropsGroup::Add( Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_UR2" ),
					"SORT" => 400
			) );
		}

		$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList( Array(), Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_UR3" )
		), false, false, array(
				"ID"
		) );
		if( $arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext() )
			$arGeneralInfo["propGroup"]["postadres_ur"] = $arSaleOrderPropsGroup["ID"];
		else
		{
			$arGeneralInfo["propGroup"]["postadres_ur"] = CSaleOrderPropsGroup::Add( Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_UR3" ),
					"SORT" => 400
			) );
		}

		$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList( Array(), Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_UR4" )
		), false, false, array(
				"ID"
		) );
		if( $arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext() )
			$arGeneralInfo["propGroup"]["user_ur"] = $arSaleOrderPropsGroup["ID"];
		else
		{
			$arGeneralInfo["propGroup"]["user_ur"] = CSaleOrderPropsGroup::Add( Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_UR4" ),
					"SORT" => 400
			) );
		}
	}
	elseif( $personType["ur"] == "Y" )
	{
		$arGeneralInfo["propGroup"]["company_ur"] = CSaleOrderPropsGroup::Add( Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_UR1" ),
				"SORT" => 300
		) );
		$arGeneralInfo["propGroup"]["uradres_ur"] = CSaleOrderPropsGroup::Add( Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_UR2" ),
				"SORT" => 400
		) );
		$arGeneralInfo["propGroup"]["postadres_ur"] = CSaleOrderPropsGroup::Add( Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_UR3" ),
				"SORT" => 400
		) );
		$arGeneralInfo["propGroup"]["user_ur"] = CSaleOrderPropsGroup::Add( Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_UR4" ),
				"SORT" => 400
		) );
	}
	if( $ipExist )
	{
		$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList( Array(), Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_IP1" )
		), false, false, array(
				"ID"
		) );
		if( $arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext() )
			$arGeneralInfo["propGroup"]["company_ip"] = $arSaleOrderPropsGroup["ID"];
		else
		{
			$arGeneralInfo["propGroup"]["company_ip"] = CSaleOrderPropsGroup::Add( Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_IP1" ),
					"SORT" => 300
			) );
		}
		$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList( Array(), Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_IP2" )
		), false, false, array(
				"ID"
		) );
		if( $arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext() )
			$arGeneralInfo["propGroup"]["uradres_ip"] = $arSaleOrderPropsGroup["ID"];
		else
		{
			$arGeneralInfo["propGroup"]["uradres_ip"] = CSaleOrderPropsGroup::Add( Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_IP2" ),
					"SORT" => 400
			) );
		}
		$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList( Array(), Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_IP3" )
		), false, false, array(
				"ID"
		) );
		if( $arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext() )
			$arGeneralInfo["propGroup"]["postadres_ip"] = $arSaleOrderPropsGroup["ID"];
		else
		{
			$arGeneralInfo["propGroup"]["postadres_ip"] = CSaleOrderPropsGroup::Add( Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_IP3" ),
					"SORT" => 400
			) );
		}
		$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList( Array(), Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_IP4" )
		), false, false, array(
				"ID"
		) );
		if( $arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext() )
			$arGeneralInfo["propGroup"]["user_ip"] = $arSaleOrderPropsGroup["ID"];
		else
		{
			$arGeneralInfo["propGroup"]["user_ip"] = CSaleOrderPropsGroup::Add( Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_IP4" ),
					"SORT" => 400
			) );
		}
	}
	elseif( $personType["ip"] == "Y" )
	{
		$arGeneralInfo["propGroup"]["company_ip"] = CSaleOrderPropsGroup::Add( Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_IP1" ),
				"SORT" => 300
		) );
		$arGeneralInfo["propGroup"]["uradres_ip"] = CSaleOrderPropsGroup::Add( Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_IP2" ),
				"SORT" => 400
		) );
		$arGeneralInfo["propGroup"]["postadres_ip"] = CSaleOrderPropsGroup::Add( Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_IP3" ),
				"SORT" => 400
		) );
		$arGeneralInfo["propGroup"]["user_ip"] = CSaleOrderPropsGroup::Add( Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_IP4" ),
				"SORT" => 400
		) );
	}

	if( $shopLocalization == "ua" )
	{
		if( $fizUaExist )
		{
			$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList( Array(), Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_FIZ1" )
			), false, false, array(
					"ID"
			) );
			if( $arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext() )
				$arGeneralInfo["propGroup"]["user_fiz_ua"] = $arSaleOrderPropsGroup["ID"];

			$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList( Array(), Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_FIZ2" )
			), false, false, array(
					"ID"
			) );
			if( $arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext() )
				$arGeneralInfo["propGroup"]["adres_fiz_ua"] = $arSaleOrderPropsGroup["ID"];
		}
		elseif( $personType["fiz_ua"] == "Y" )
		{
			$arGeneralInfo["propGroup"]["user_fiz_ua"] = CSaleOrderPropsGroup::Add( Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_FIZ1" ),
					"SORT" => 100
			) );
			$arGeneralInfo["propGroup"]["adres_fiz_ua"] = CSaleOrderPropsGroup::Add( Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_GROUP_FIZ2" ),
					"SORT" => 200
			) );
		}
	}

	$businessValuePersonDomain = array();

	$businessValueGroups = array(
			'COMPANY' => array(
					'SORT' => 100
			),
			'CLIENT' => array(
					'SORT' => 200
			),
			'CLIENT_COMPANY' => array(
					'SORT' => 300
			)
	);

	$businessValueCodes = array();

	$arProps = Array();

	if( $personType["fiz"] == "Y" )
	{
		$businessValuePersonDomain[$arGeneralInfo["personType"]["fiz"]] = $BIZVAL_INDIVIDUAL_DOMAIN;

		$businessValueCodes['CLIENT_NAME'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 100,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_6" ),
				"TYPE" => "TEXT",
				"REQUIED" => "Y",
				"DEFAULT_VALUE" => "",
				"SORT" => 100,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_fiz"],
				"SIZE1" => 40,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "Y",
				"IS_PAYER" => "Y",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "FIO",
				"IS_FILTERED" => "Y"
		);

		$businessValueCodes['CLIENT_EMAIL'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 110,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
				"NAME" => "E-Mail",
				"TYPE" => "TEXT",
				"REQUIED" => "Y",
				"DEFAULT_VALUE" => "",
				"SORT" => 110,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_fiz"],
				"SIZE1" => 40,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "Y",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "EMAIL",
				"IS_FILTERED" => "Y"
		);

		$businessValueCodes['CLIENT_PHONE'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 120,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_9" ),
				"TYPE" => "TEXT",
				"REQUIED" => "Y",
				"DEFAULT_VALUE" => "",
				"SORT" => 120,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_fiz"],
				"SIZE1" => 0,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "PHONE",
				"IS_PHONE" => "Y",
				"IS_FILTERED" => "N"
		);

		$businessValueCodes['CLIENT_ZIP'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 130,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_4" ),
				"TYPE" => "TEXT",
				"REQUIED" => "N",
				"DEFAULT_VALUE" => "101000",
				"SORT" => 130,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["adres_fiz"],
				"SIZE1" => 8,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "ZIP",
				"IS_FILTERED" => "N",
				"IS_ZIP" => "Y"
		);

		$businessValueCodes['CLIENT_CITY'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 145,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_21" ),
				"TYPE" => "TEXT",
				"REQUIED" => "N",
				"DEFAULT_VALUE" => $shopLocation,
				"SORT" => 145,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["adres_fiz"],
				"SIZE1" => 40,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "CITY",
				"IS_FILTERED" => "Y"
		);

		$businessValueCodes['CLIENT_LOCATION'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 140,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_2" ),
				"TYPE" => "LOCATION",
				"REQUIED" => "Y",
				"DEFAULT_VALUE" => $location,
				"SORT" => 140,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "Y",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["adres_fiz"],
				"SIZE1" => 40,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "LOCATION",
				"IS_FILTERED" => "N",
				"INPUT_FIELD_LOCATION" => ""
		);

		$businessValueCodes['CLIENT_ADDRESS'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 150,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_5" ),
				"TYPE" => "TEXTAREA",
				"REQUIED" => "Y",
				"DEFAULT_VALUE" => "",
				"SORT" => 150,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["adres_fiz"],
				"SIZE1" => 30,
				"SIZE2" => 3,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "ADDRESS",
				"IS_FILTERED" => "N"
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_55" ),
				"TYPE" => "Y/N",
				"REQUIED" => "Y",
				"DEFAULT_VALUE" => "Y",
				"SORT" => 160,
				"USER_PROPS" => "N",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_fiz"],
				"SIZE1" => 0,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "CONFIDENTIAL",
				"IS_FILTERED" => "N"
		);
	}

	if( $personType["ur"] == "Y" )
	{
		$businessValuePersonDomain[$arGeneralInfo["personType"]["ur"]] = $BIZVAL_ENTITY_DOMAIN;

		if( $shopLocalization != "ua" )
		{
			$businessValueCodes['COMPANY_NAME'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 200,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_8" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 200,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["company_ur"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "Y",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "COMPANY",
					"IS_FILTERED" => "Y"
			);

			$businessValueCodes['COMPANY_INN'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 210,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_13" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 210,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["company_ur"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "Y",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "INN",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_KPP'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 220,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_14" ),
					"TYPE" => "TEXT",
					"REQUIED" => "N",
					"DEFAULT_VALUE" => "",
					"SORT" => 220,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["company_ur"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "KPP",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_OGRN'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 230,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_141" ),
					"TYPE" => "TEXT",
					"REQUIED" => "N",
					"DEFAULT_VALUE" => "",
					"SORT" => 230,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["company_ur"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "OGRN",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_UR_ZIP'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 240,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_4" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "101000",
					"SORT" => 240,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["uradres_ur"],
					"SIZE1" => 8,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "UR_ZIP",
					"IS_FILTERED" => "N",
					"IS_ZIP" => "N"
			);
			$businessValueCodes['COMPANY_UR_CITY'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 250,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_21" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => $shopLocation,
					"SORT" => 250,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["uradres_ur"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "UR_CITY",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_UR_ADDRESS'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 260,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_7" ),
					"TYPE" => "TEXTAREA",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 260,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["uradres_ur"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "UR_ADDRESS",
					"IS_FILTERED" => "N"
			);

			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_56" ),
					"TYPE" => "Y/N",
					"REQUIED" => "N",
					"DEFAULT_VALUE" => "Y",
					"SORT" => 270,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["postadres_ur"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "EQ_POST",
					"IS_FILTERED" => "N"
			);

			$businessValueCodes['COMPANY_POST_ZIP'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 280,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_4" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "101000",
					"SORT" => 280,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["postadres_ur"],
					"SIZE1" => 8,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "POST_ZIP",
					"IS_FILTERED" => "N",
					"IS_ZIP" => "Y"
			);
			$businessValueCodes['COMPANY_POST_CITY'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 290,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_21" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => $shopLocation,
					"SORT" => 290,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["postadres_ur"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "POST_CITY",
					"IS_FILTERED" => "Y"
			);
			$businessValueCodes['COMPANY_POST_ADDRESS'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 300,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_7" ),
					"TYPE" => "TEXTAREA",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 300,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["postadres_ur"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "POST_ADDRESS",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_PHONE'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 300,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_9" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 300,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_ur"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"IS_PHONE" => "Y",
					"CODE" => "PHONE",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_EMAIL'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 310,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => "E-Mail",
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 310,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_ur"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "Y",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "EMAIL",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_CONTACT_LAST_NAME'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 320,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_10" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 320,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_ur"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "Y",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "LAST_NAME",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_CONTACT_NAME'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 330,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_101" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 330,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_ur"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "Y",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "NAME",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_CONTACT_SECOND_NAME'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 340,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_102" ),
					"TYPE" => "TEXT",
					"REQUIED" => "N",
					"DEFAULT_VALUE" => "",
					"SORT" => 340,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_ur"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "Y",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "SECOND_NAME",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_CONFIDENTIAL'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 350,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_55" ),
					"TYPE" => "Y/N",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "Y",
					"SORT" => 350,
					"USER_PROPS" => "N",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_ur"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "CONFIDENTIAL",
					"IS_FILTERED" => "N"
			);
		}
	}
	if( $personType["ip"] == "Y" )
	{
		$businessValuePersonDomain[$arGeneralInfo["personType"]["ip"]] = $BIZVAL_ENTITY_DOMAIN;

		if( $shopLocalization != "ua" )
		{
			$businessValueCodes['COMPANY_NAME'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 200,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_8" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 200,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["company_ip"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "Y",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "COMPANY",
					"IS_FILTERED" => "Y"
			);

			$businessValueCodes['COMPANY_INN'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 210,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_13" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 210,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["company_ip"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "Y",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "INN",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_KPP'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 220,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_14" ),
					"TYPE" => "TEXT",
					"REQUIED" => "N",
					"DEFAULT_VALUE" => "",
					"SORT" => 220,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["company_ip"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "KPP",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_OGRN'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 230,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_141" ),
					"TYPE" => "TEXT",
					"REQUIED" => "N",
					"DEFAULT_VALUE" => "",
					"SORT" => 230,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["company_ip"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "OGRN",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_UR_ZIP'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 240,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_4" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "101000",
					"SORT" => 240,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["uradres_ip"],
					"SIZE1" => 8,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "UR_ZIP",
					"IS_FILTERED" => "N",
					"IS_ZIP" => "N"
			);
			$businessValueCodes['COMPANY_UR_CITY'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 250,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_21" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => $shopLocation,
					"SORT" => 250,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["uradres_ip"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "UR_CITY",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_UR_ADDRESS'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 260,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_7" ),
					"TYPE" => "TEXTAREA",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 260,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["uradres_ip"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "UR_ADDRESS",
					"IS_FILTERED" => "N"
			);

			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_56" ),
					"TYPE" => "Y/N",
					"REQUIED" => "N",
					"DEFAULT_VALUE" => "Y",
					"SORT" => 270,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["postadres_ip"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "EQ_POST",
					"IS_FILTERED" => "N"
			);

			$businessValueCodes['COMPANY_POST_ZIP'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 280,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_4" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "101000",
					"SORT" => 280,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["postadres_ip"],
					"SIZE1" => 8,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "POST_ZIP",
					"IS_FILTERED" => "N",
					"IS_ZIP" => "Y"
			);
			$businessValueCodes['COMPANY_POST_CITY'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 290,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_21" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => $shopLocation,
					"SORT" => 290,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["postadres_ip"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "POST_CITY",
					"IS_FILTERED" => "Y"
			);
			$businessValueCodes['COMPANY_POST_ADDRESS'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 300,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_7" ),
					"TYPE" => "TEXTAREA",
					"REQUIED" => "N",
					"DEFAULT_VALUE" => "",
					"SORT" => 300,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["postadres_ip"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "POST_ADDRESS",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_PHONE'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 300,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_9" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 300,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_ip"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"IS_PHONE" => "Y",
					"CODE" => "PHONE",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_EMAIL'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 310,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => "E-Mail",
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 310,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_ip"],
					"SIZE1" => 40,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "Y",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "EMAIL",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_CONTACT_LAST_NAME'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 320,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_10" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 320,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_ip"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "Y",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "LAST_NAME",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_CONTACT_NAME'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 330,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_101" ),
					"TYPE" => "TEXT",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "",
					"SORT" => 330,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_ip"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "Y",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "NAME",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_CONTACT_SECOND_NAME'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 340,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_102" ),
					"TYPE" => "TEXT",
					"REQUIED" => "N",
					"DEFAULT_VALUE" => "",
					"SORT" => 340,
					"USER_PROPS" => "Y",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_ip"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "Y",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "SECOND_NAME",
					"IS_FILTERED" => "N"
			);
			$businessValueCodes['COMPANY_CONFIDENTIAL'] = array(
					'GROUP' => 'COMPANY',
					'SORT' => 350,
					'DOMAIN' => $BIZVAL_ENTITY_DOMAIN
			);
			$arProps[] = Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"NAME" => GetMessage( "SALE_WIZARD_PROP_55" ),
					"TYPE" => "Y/N",
					"REQUIED" => "Y",
					"DEFAULT_VALUE" => "Y",
					"SORT" => 350,
					"USER_PROPS" => "N",
					"IS_LOCATION" => "N",
					"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_ip"],
					"SIZE1" => 0,
					"SIZE2" => 0,
					"DESCRIPTION" => "",
					"IS_EMAIL" => "N",
					"IS_PROFILE_NAME" => "N",
					"IS_PAYER" => "N",
					"IS_LOCATION4TAX" => "N",
					"CODE" => "CONFIDENTIAL",
					"IS_FILTERED" => "N"
			);
		}
	}

	if( $shopLocalization == "ua" && $personType["fiz_ua"] == "Y" )
	{
		/*
		 * $businessValueCodes['CLIENT_NAME'] = array('GROUP' => 'CLIENT', 'SORT' => 100, 'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN);
		 * $arProps[] = Array(
		 * "PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
		 * "NAME" => GetMessage("SALE_WIZARD_PROP_31"),
		 * "TYPE" => "TEXT",
		 * "REQUIED" => "Y",
		 * "DEFAULT_VALUE" => "",
		 * "SORT" => 100,
		 * "USER_PROPS" => "Y",
		 * "IS_LOCATION" => "N",
		 * "PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_fiz_ua"],
		 * "SIZE1" => 40,
		 * "SIZE2" => 0,
		 * "DESCRIPTION" => "",
		 * "IS_EMAIL" => "N",
		 * "IS_PROFILE_NAME" => "Y",
		 * "IS_PAYER" => "Y",
		 * "IS_LOCATION4TAX" => "N",
		 * "CODE" => "FIO",
		 * "IS_FILTERED" => "Y",
		 * );
		 */

		$businessValuePersonDomain[$arGeneralInfo["personType"]["fiz_ua"]] = $BIZVAL_INDIVIDUAL_DOMAIN;

		$businessValueCodes['CLIENT_EMAIL'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 110,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
				"NAME" => "E-Mail",
				"TYPE" => "TEXT",
				"REQUIED" => "Y",
				"DEFAULT_VALUE" => "",
				"SORT" => 110,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_fiz_ua"],
				"SIZE1" => 40,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "Y",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "EMAIL",
				"IS_FILTERED" => "Y"
		);

		$businessValueCodes['CLIENT_NAME'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 130,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_30" ),
				"TYPE" => "TEXT",
				"REQUIED" => "Y",
				"DEFAULT_VALUE" => "",
				"SORT" => 130,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_fiz_ua"],
				"SIZE1" => 40,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "Y",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "FIO",
				"IS_FILTERED" => "Y"
		);

		$businessValueCodes['CLIENT_COMPANY_ADDRESS'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 140,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_37" ),
				"TYPE" => "TEXTAREA",
				"REQUIED" => "Y",
				"DEFAULT_VALUE" => "",
				"SORT" => 140,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_fiz_ua"],
				"SIZE1" => 40,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "COMPANY_ADR",
				"IS_FILTERED" => "N"
		);

		$businessValueCodes['CLIENT_EGRPU'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 150,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_38" ),
				"TYPE" => "TEXT",
				"REQUIED" => "Y",
				"DEFAULT_VALUE" => "",
				"SORT" => 150,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["adres_fiz_ua"],
				"SIZE1" => 30,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "EGRPU",
				"IS_FILTERED" => "N"
		);

		/*
		 * $businessValueCodes['CLIENT_INN'] = array('GROUP' => 'CLIENT', 'SORT' => 160, 'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN);
		 * $arProps[] = Array(
		 * "PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
		 * "NAME" => GetMessage("SALE_WIZARD_PROP_39"),
		 * "TYPE" => "TEXT",
		 * "REQUIED" => "N",
		 * "DEFAULT_VALUE" => "",
		 * "SORT" => 160,
		 * "USER_PROPS" => "Y",
		 * "IS_LOCATION" => "N",
		 * "PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["adres_fiz_ua"],
		 * "SIZE1" => 30,
		 * "SIZE2" => 0,
		 * "DESCRIPTION" => "",
		 * "IS_EMAIL" => "N",
		 * "IS_PROFILE_NAME" => "N",
		 * "IS_PAYER" => "N",
		 * "IS_LOCATION4TAX" => "N",
		 * "CODE" => "INN",
		 * "IS_FILTERED" => "N",
		 * );
		 */

		$businessValueCodes['CLIENT_NDS'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 170,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_36" ),
				"TYPE" => "TEXT",
				"REQUIED" => "N",
				"DEFAULT_VALUE" => "",
				"SORT" => 170,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["adres_fiz_ua"],
				"SIZE1" => 30,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "NDS",
				"IS_FILTERED" => "N"
		);

		$businessValueCodes['CLIENT_ZIP'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 180,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_34" ),
				"TYPE" => "TEXT",
				"REQUIED" => "N",
				"DEFAULT_VALUE" => "",
				"SORT" => 180,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["adres_fiz_ua"],
				"SIZE1" => 8,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "ZIP",
				"IS_FILTERED" => "N",
				"IS_ZIP" => "Y"
		);

		$businessValueCodes['CLIENT_CITY'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 190,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_33" ),
				"TYPE" => "TEXT",
				"REQUIED" => "Y",
				"DEFAULT_VALUE" => $shopLocation,
				"SORT" => 190,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["adres_fiz_ua"],
				"SIZE1" => 30,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "CITY",
				"IS_FILTERED" => "Y"
		);

		$businessValueCodes['CLIENT_ADDRESS'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 200,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_32" ),
				"TYPE" => "TEXTAREA",
				"REQUIED" => "Y",
				"DEFAULT_VALUE" => "",
				"SORT" => 200,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["adres_fiz_ua"],
				"SIZE1" => 30,
				"SIZE2" => 3,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "ADDRESS",
				"IS_FILTERED" => "N"
		);

		$businessValueCodes['CLIENT_PHONE'] = array(
				'GROUP' => 'CLIENT',
				'SORT' => 210,
				'DOMAIN' => $BIZVAL_INDIVIDUAL_DOMAIN
		);
		$arProps[] = Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz_ua"],
				"NAME" => GetMessage( "SALE_WIZARD_PROP_35" ),
				"TYPE" => "TEXT",
				"REQUIED" => "Y",
				"DEFAULT_VALUE" => "",
				"SORT" => 210,
				"USER_PROPS" => "Y",
				"IS_LOCATION" => "N",
				"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["adres_fiz_ua"],
				"SIZE1" => 30,
				"SIZE2" => 0,
				"DESCRIPTION" => "",
				"IS_EMAIL" => "N",
				"IS_PROFILE_NAME" => "N",
				"IS_PAYER" => "N",
				"IS_LOCATION4TAX" => "N",
				"CODE" => "PHONE",
				"IS_PHONE" => "Y",
				"IS_FILTERED" => "N"
		);
	}

	$propCityId = 0;
	reset( $businessValueCodes );

	foreach( $arProps as $prop )
	{
		$variants = Array();
		if( !empty( $prop["VARIANTS"] ) )
		{
			$variants = $prop["VARIANTS"];
			unset( $prop["VARIANTS"] );
		}

		if( $prop["CODE"] == "LOCATION" && $propCityId > 0 )
		{
			$prop["INPUT_FIELD_LOCATION"] = $propCityId;
			$propCityId = 0;
		}

		$dbSaleOrderProps = CSaleOrderProps::GetList( array(), array(
				"PERSON_TYPE_ID" => $prop["PERSON_TYPE_ID"],
				"CODE" => $prop["CODE"]
		) );
		if( $arSaleOrderProps = $dbSaleOrderProps->GetNext() )
			$id = $arSaleOrderProps["ID"];
		else
			$id = CSaleOrderProps::Add( $prop );

		if( $prop["CODE"] == "CITY" )
		{
			$propCityId = $id;
		}
		if( strlen( $prop["CODE"] ) > 0 )
		{
			// $arGeneralInfo["propCode"][$prop["CODE"]] = $prop["CODE"];
			$arGeneralInfo["propCodeID"][$prop["CODE"]] = $id;
			$arGeneralInfo["properies"][$prop["PERSON_TYPE_ID"]][$prop["CODE"]] = $prop;
			$arGeneralInfo["properies"][$prop["PERSON_TYPE_ID"]][$prop["CODE"]]["ID"] = $id;
		}

		if( !empty( $variants ) )
		{
			foreach( $variants as $val )
			{
				$val["ORDER_PROPS_ID"] = $id;
				CSaleOrderPropsVariant::Add( $val );
			}
		}

		// add business value mapping to property
		$businessValueCodes[key( $businessValueCodes )]['MAP'] = array(
				$prop['PERSON_TYPE_ID'] => array(
						'PROPERTY',
						$id
				)
		);
		next( $businessValueCodes );
	}

	/*
	 * $propReplace = "";
	 * foreach($arGeneralInfo["properies"] as $key => $val)
	 * {
	 * if(IntVal($val["LOCATION"]["ID"]) > 0)
	 * $propReplace .= '"PROP_'.$key.'" => Array(0 => "'.$val["LOCATION"]["ID"].'"), ';
	 * }
	 * WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."personal/order/", Array("PROPS" => $propReplace));
	 */
	// 1C export
	if( $personTypeFiz )
	{

		$personTypeId = $arGeneralInfo["personType"]["fiz"];
		if( $personTypeId > 0 )
		{
			$val = Array(
					"AGENT_NAME" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz"]]["FIO"]["ID"]
					),
					"FULL_NAME" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz"]]["FIO"]["ID"]
					),
					"SURNAME" => Array(
							"TYPE" => "USER",
							"VALUE" => "LAST_NAME"
					),
					"NAME" => Array(
							"TYPE" => "USER",
							"VALUE" => "NAME"
					),
					"ADDRESS_FULL" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz"]]["ADDRESS"]["ID"]
					),
					"INDEX" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz"]]["ZIP"]["ID"]
					),
					"COUNTRY" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz"]]["LOCATION"]["ID"] . "_COUNTRY"
					),
					"CITY" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz"]]["LOCATION"]["ID"] . "_CITY"
					),
					"STREET" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz"]]["ADDRESS"]["ID"]
					),
					"EMAIL" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz"]]["EMAIL"]["ID"]
					),
					"IS_FIZ" => "Y"
			);

			$arExport = CSaleExport::GetList( array(), array(
					'PERSON_TYPE_ID' => $personTypeId
			) )->Fetch();
			// 1c exist
			if( $arExport['ID'] > 0 )
			{
				$vars = unserialize( $arExport['VARS'] );
				if( is_Array( $vars ) )
				{
					foreach( $vars as $key => $value )
					{
						if( $key == 'IS_FIZ' )
						{
							continue;
						}
						if( !$key )
						{
							unset( $vars[$key] );
							continue;
						}
						if( in_array( $key, array_keys( $val ) ) && $value['VALUE'] == '' )
						{
							$vars[$key] = $val[$key];
						}
					}
				}
			}
			else
			{
				$vars = $val;
			}

			if( $vars && is_array( $vars ) )
			{
				$vars = serialize( $vars );
			}

			$allPersonTypes = BusinessValue::getPersonTypes( true );

			$domain = BusinessValue::INDIVIDUAL_DOMAIN;

			if( isset( $allPersonTypes[$personTypeId]['DOMAIN'] ) )
			{
				$deletePersonDomainResult = BusinessValuePersonDomainTable::delete( array(
						'PERSON_TYPE_ID' => $personTypeId,
						'DOMAIN' => $allPersonTypes[$personTypeId]['DOMAIN']
				) );

				if( $deletePersonDomainResult->isSuccess() )
				{
					$result = BusinessValueTable::getList( array(
							'select' => array(
									'CODE_KEY',
									'CONSUMER_KEY',
									'PERSON_TYPE_ID'
							),
							'filter' => array(
									'=PERSON_TYPE_ID' => $personTypeId
							)
					) );

					while ( $row = $result->fetch() )
					{
						// TODO remove save_data_modification hack
						if( !$row['CONSUMER_KEY'] )
							$row['CONSUMER_KEY'] = BusinessValueTable::COMMON_CONSUMER_KEY;

						BusinessValueTable::delete( $row ); // TODO errors
					}

					$allPersonTypes[$personTypeId]['DOMAIN'] = null;
				}
			}
			if( !isset( $allPersonTypes[$personTypeId]['DOMAIN'] ) )
			{
				$r = Bitrix\Sale\Internals\BusinessValuePersonDomainTable::add( array(
						'PERSON_TYPE_ID' => $personTypeId,
						'DOMAIN' => $domain
				) );
				if( $r->isSuccess() )
				{
					$allPersonTypes[$personTypeId]['DOMAIN'] = $domain;
					BusinessValue::getPersonTypes( true, $allPersonTypes );
				}
			}

			CSaleExport::Add( Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
					"VARS" => $vars
			) );
		}
	}
	if( $personTypeUr )
	{

		$personTypeId = $arGeneralInfo["personType"]["ur"];
		if( $personTypeId > 0 )
		{
			$val = Array(
					"AGENT_NAME" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ur"]]["COMPANY"]["ID"]
					),
					"FULL_NAME" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ur"]]["COMPANY"]["ID"]
					),
					"ADDRESS_FULL" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ur"]]["UR_ADDRESS"]["ID"]
					),
					"CITY" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ur"]]["UR_CITY"]["ID"]
					),
					"INN" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ur"]]["INN"]["ID"]
					),
					"KPP" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ur"]]["KPP"]["ID"]
					),
					"PHONE" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ur"]]["PHONE"]["ID"]
					),
					"EMAIL" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ur"]]["EMAIL"]["ID"]
					),
					"CONTACT_PERSON" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ur"]]["NAME"]["ID"]
					),
					"F_ADDRESS_FULL" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ur"]]["POST_ADDRESS"]["ID"]
					),
					"F_CITY" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ur"]]["POST_CITY"]["ID"]
					),
					"F_INDEX" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ur"]]["POST_ZIP"]["ID"]
					),
					"IS_FIZ" => "N"
			);

			$arExport = CSaleExport::GetList( array(), array(
					'PERSON_TYPE_ID' => $personTypeId
			) )->Fetch();
			// 1c exist
			if( $arExport['ID'] > 0 )
			{
				$vars = unserialize( $arExport['VARS'] );
				if( is_Array( $vars ) )
				{
					foreach( $vars as $key => $value )
					{
						if( $key == 'IS_FIZ' )
						{
							continue;
						}
						if( !$key )
						{
							unset( $vars[$key] );
							continue;
						}

						if( in_array( $key, array_keys( $val ) ) && $value['VALUE'] == '' )
						{
							$vars[$key] = $val[$key];
						}
					}
				}
			}
			else
			{
				$vars = $val;
			}

			if( $vars && is_array( $vars ) )
			{
				$vars = serialize( $vars );
			}

			$allPersonTypes = BusinessValue::getPersonTypes( true );

			$domain = BusinessValue::ENTITY_DOMAIN;

			if( isset( $allPersonTypes[$personTypeId]['DOMAIN'] ) )
			{
				$deletePersonDomainResult = BusinessValuePersonDomainTable::delete( array(
						'PERSON_TYPE_ID' => $personTypeId,
						'DOMAIN' => $allPersonTypes[$personTypeId]['DOMAIN']
				) );

				if( $deletePersonDomainResult->isSuccess() )
				{
					$result = BusinessValueTable::getList( array(
							'select' => array(
									'CODE_KEY',
									'CONSUMER_KEY',
									'PERSON_TYPE_ID'
							),
							'filter' => array(
									'=PERSON_TYPE_ID' => $personTypeId
							)
					) );

					while ( $row = $result->fetch() )
					{
						// TODO remove save_data_modification hack
						if( !$row['CONSUMER_KEY'] )
							$row['CONSUMER_KEY'] = BusinessValueTable::COMMON_CONSUMER_KEY;

						BusinessValueTable::delete( $row ); // TODO errors
					}

					$allPersonTypes[$personTypeId]['DOMAIN'] = null;
				}
			}
			if( !isset( $allPersonTypes[$personTypeId]['DOMAIN'] ) )
			{
				$r = Bitrix\Sale\Internals\BusinessValuePersonDomainTable::add( array(
						'PERSON_TYPE_ID' => $personTypeId,
						'DOMAIN' => $domain
				) );
				if( $r->isSuccess() )
				{
					$allPersonTypes[$personTypeId]['DOMAIN'] = $domain;
					BusinessValue::getPersonTypes( true, $allPersonTypes );
				}
			}

			CSaleExport::Add( Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ur"],
					"VARS" => $vars
			) );
		}
	}
	if( $personTypeIp )
	{

		$personTypeId = $arGeneralInfo["personType"]["ip"];
		if( $personTypeId > 0 )
		{
			$val = Array(
					"AGENT_NAME" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ip"]]["COMPANY"]["ID"]
					),
					"FULL_NAME" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ip"]]["COMPANY"]["ID"]
					),
					"ADDRESS_FULL" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ip"]]["UR_ADDRESS"]["ID"]
					),
					"CITY" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ip"]]["UR_CITY"]["ID"]
					),
					"INN" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ip"]]["INN"]["ID"]
					),
					"KPP" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ip"]]["KPP"]["ID"]
					),
					"PHONE" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ip"]]["PHONE"]["ID"]
					),
					"EMAIL" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ip"]]["EMAIL"]["ID"]
					),
					"CONTACT_PERSON" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ip"]]["NAME"]["ID"]
					),
					"F_ADDRESS_FULL" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ip"]]["POST_ADDRESS"]["ID"]
					),
					"F_CITY" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ip"]]["POST_CITY"]["ID"]
					),
					"F_INDEX" => Array(
							"TYPE" => "PROPERTY",
							"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["ip"]]["POST_ZIP"]["ID"]
					),
					"IS_FIZ" => "N"
			);

			$arExport = CSaleExport::GetList( array(), array(
					'PERSON_TYPE_ID' => $personTypeId
			) )->Fetch();
			// 1c exist
			if( $arExport['ID'] > 0 )
			{
				$vars = unserialize( $arExport['VARS'] );
				if( is_Array( $vars ) )
				{
					foreach( $vars as $key => $value )
					{
						if( $key == 'IS_FIZ' )
						{
							continue;
						}

						if( !$key )
						{
							unset( $vars[$key] );
							continue;
						}

						if( in_array( $key, array_keys( $val ) ) && $value['VALUE'] == '' )
						{
							$vars[$key] = $val[$key];
						}
					}
				}
			}
			else
			{
				$vars = $val;
			}

			if( $vars && is_array( $vars ) )
			{
				$vars = serialize( $vars );
			}

			$allPersonTypes = BusinessValue::getPersonTypes( true );

			$domain = BusinessValue::ENTITY_DOMAIN;

			if( isset( $allPersonTypes[$personTypeId]['DOMAIN'] ) )
			{
				$deletePersonDomainResult = BusinessValuePersonDomainTable::delete( array(
						'PERSON_TYPE_ID' => $personTypeId,
						'DOMAIN' => $allPersonTypes[$personTypeId]['DOMAIN']
				) );

				if( $deletePersonDomainResult->isSuccess() )
				{
					$result = BusinessValueTable::getList( array(
							'select' => array(
									'CODE_KEY',
									'CONSUMER_KEY',
									'PERSON_TYPE_ID'
							),
							'filter' => array(
									'=PERSON_TYPE_ID' => $personTypeId
							)
					) );

					while ( $row = $result->fetch() )
					{
						// TODO remove save_data_modification hack
						if( !$row['CONSUMER_KEY'] )
							$row['CONSUMER_KEY'] = BusinessValueTable::COMMON_CONSUMER_KEY;

						BusinessValueTable::delete( $row ); // TODO errors
					}

					$allPersonTypes[$personTypeId]['DOMAIN'] = null;
				}
			}
			if( !isset( $allPersonTypes[$personTypeId]['DOMAIN'] ) )
			{
				$r = Bitrix\Sale\Internals\BusinessValuePersonDomainTable::add( array(
						'PERSON_TYPE_ID' => $personTypeId,
						'DOMAIN' => $domain
				) );
				if( $r->isSuccess() )
				{
					$allPersonTypes[$personTypeId]['DOMAIN'] = $domain;
					BusinessValue::getPersonTypes( true, $allPersonTypes );
				}
			}

			CSaleExport::Add( Array(
					"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["ip"],
					"VARS" => $vars
			) );
		}
	}
	if( $shopLocalization == "ua" && !$fizUaExist )
	{
		$val = serialize( 
				Array(
						"AGENT_NAME" => Array(
								"TYPE" => "PROPERTY",
								"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz_ua"]]["FIO"]["ID"]
						),
						"FULL_NAME" => Array(
								"TYPE" => "PROPERTY",
								"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz_ua"]]["FIO"]["ID"]
						),
						"SURNAME" => Array(
								"TYPE" => "USER",
								"VALUE" => "LAST_NAME"
						),
						"NAME" => Array(
								"TYPE" => "USER",
								"VALUE" => "NAME"
						),
						"ADDRESS_FULL" => Array(
								"TYPE" => "PROPERTY",
								"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz_ua"]]["ADDRESS"]["ID"]
						),
						"INDEX" => Array(
								"TYPE" => "PROPERTY",
								"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz_ua"]]["ZIP"]["ID"]
						),
						"COUNTRY" => Array(
								"TYPE" => "PROPERTY",
								"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz_ua"]]["LOCATION"]["ID"] . "_COUNTRY"
						),
						"CITY" => Array(
								"TYPE" => "PROPERTY",
								"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz_ua"]]["LOCATION"]["ID"] . "_CITY"
						),
						"STREET" => Array(
								"TYPE" => "PROPERTY",
								"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz_ua"]]["ADDRESS"]["ID"]
						),
						"EMAIL" => Array(
								"TYPE" => "PROPERTY",
								"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz_ua"]]["EMAIL"]["ID"]
						),
						"CONTACT_PERSON" => Array(
								"TYPE" => "PROPERTY",
								"VALUE" => $arGeneralInfo["properies"][$arGeneralInfo["personType"]["fiz_ua"]]["CONTACT_PERSON"]["ID"]
						),
						"IS_FIZ" => "Y"
				) );
		CSaleExport::Add( Array(
				"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
				"VARS" => $val
		) );
	}

	// PaySystem
	$arPaySystems = Array();
	if( $paysystem["cash"] == "Y" )
	{
		$arPaySystems[] = array(
				'PAYSYSTEM' => array(
						"NAME" => GetMessage( "SALE_WIZARD_PS_CASH" ),
						"PSA_NAME" => GetMessage( "SALE_WIZARD_PS_CASH" ),
						"SORT" => 80,
						"ACTIVE" => "Y",
						"DESCRIPTION" => GetMessage( "SALE_WIZARD_PS_CASH_DESCR" ),
						"ACTION_FILE" => "cash",
						"RESULT_FILE" => "",
						"NEW_WINDOW" => "N",
						"PARAMS" => "",
						"HAVE_PAYMENT" => "Y",
						"HAVE_ACTION" => "N",
						"HAVE_RESULT" => "N",
						"HAVE_PREPAY" => "N",
						"HAVE_RESULT_RECEIVE" => "N"
				),
				'PERSON_TYPE' => array(
						$arGeneralInfo["personType"]["fiz"]
				)
		);
		if( $module == 'sotbit.b2bshop' )
		{
			$last_key = end( array_keys( $arPaySystems ) );
			$logo = $_SERVER["DOCUMENT_ROOT"] . WIZARD_SERVICE_RELATIVE_PATH . "/images/cash.png";
			$arPicture = CFile::MakeFileArray( $logo );
			$arPaySystems[$last_key]['PAYSYSTEM']['LOGOTIP'] = $arPicture;
		}
	}
	if( $paysystem["collect"] == "Y" )
	{
		$arPaySystems[] = array(
				'PAYSYSTEM' => array(
						"NAME" => GetMessage( "SALE_WIZARD_PS_COLLECT" ),
						"SORT" => 110,
						"ACTIVE" => "Y",
						"DESCRIPTION" => GetMessage( "SALE_WIZARD_PS_COLLECT_DESCR" ),
						"PSA_NAME" => GetMessage( "SALE_WIZARD_PS_COLLECT" ),
						"ACTION_FILE" => "cashondeliverycalc",
						"RESULT_FILE" => "",
						"NEW_WINDOW" => "N",
						"HAVE_PAYMENT" => "Y",
						"HAVE_ACTION" => "N",
						"HAVE_RESULT" => "N",
						"HAVE_PREPAY" => "N",
						"HAVE_RESULT_RECEIVE" => "N"
				),
				'PERSON_TYPE' => array(
						$arGeneralInfo["personType"]["fiz"],
						$arGeneralInfo["personType"]["ur"]
				)
		);
	}
	if( $personType["fiz"] == "Y" && $shopLocalization != "ua" )
	{
		if( $bRus )
		{
			$arPaySystems[] = array(
					'PAYSYSTEM' => array(
							"NAME" => GetMessage( "SALE_WIZARD_YMoney" ),
							"SORT" => 50,
							"DESCRIPTION" => GetMessage( "SALE_WIZARD_YMoney_DESC" ),
							"PSA_NAME" => GetMessage( "SALE_WIZARD_YMoney" ),
							"ACTION_FILE" => "yandex",
							"RESULT_FILE" => "",
							"NEW_WINDOW" => "N",
							"PS_MODE" => "PC",
							"HAVE_PAYMENT" => "Y",
							"HAVE_ACTION" => "N",
							"HAVE_RESULT" => "N",
							"HAVE_PREPAY" => "N",
							"HAVE_RESULT_RECEIVE" => "Y"
					),
					'PERSON_TYPE' => array(
							$arGeneralInfo["personType"]["fiz"]
					),
					"BIZVAL" => array(
							'' => array(
									"PAYMENT_ID" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "ID"
									),
									"PAYMENT_DATE_INSERT" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "DATE_BILL"
									),
									"PAYMENT_SHOULD_PAY" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "SUM"
									),
									"PS_IS_TEST" => array(
											"VALUE" => "Y"
									),
									"PS_CHANGE_STATUS_PAY" => array(
											"VALUE" => "Y"
									),
									"YANDEX_SHOP_ID" => array(
											"TYPE" => "",
											"VALUE" => ""
									),
									"YANDEX_SCID" => array(
											"TYPE" => "",
											"VALUE" => ""
									),
									"YANDEX_SHOP_KEY" => array(
											"TYPE" => "",
											"VALUE" => ""
									)
							)
					)
			);

			$logo = $_SERVER["DOCUMENT_ROOT"] . WIZARD_SERVICE_RELATIVE_PATH . "/images/yandex_cards.png";
			$arPicture = CFile::MakeFileArray( $logo );
			$arPaySystems[] = array(
					'PAYSYSTEM' => array(
							"NAME" => GetMessage( "SALE_WIZARD_YCards" ),
							"SORT" => 60,
							"DESCRIPTION" => GetMessage( "SALE_WIZARD_YCards_DESC" ),
							"PSA_NAME" => GetMessage( "SALE_WIZARD_YCards" ),
							"ACTION_FILE" => "yandex",
							"RESULT_FILE" => "",
							"NEW_WINDOW" => "N",
							"HAVE_PAYMENT" => "Y",
							"HAVE_ACTION" => "N",
							"HAVE_RESULT" => "N",
							"HAVE_PREPAY" => "N",
							"HAVE_RESULT_RECEIVE" => "Y",
							"PS_MODE" => "AC",
							"LOGOTIP" => $arPicture
					),
					"BIZVAL" => array(
							'' => array(
									"PAYMENT_ID" => array(
											"TYPE" => "ORDER",
											"VALUE" => "ID"
									),
									"PAYMENT_DATE_INSERT" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "DATE_BILL"
									),
									"PAYMENT_SHOULD_PAY" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "SUM"
									),
									"PS_IS_TEST" => array(
											"VALUE" => "Y"
									),
									"PS_CHANGE_STATUS_PAY" => array(
											"VALUE" => "Y"
									),
									"YANDEX_SHOP_ID" => array(
											"TYPE" => "",
											"VALUE" => ""
									),
									"YANDEX_SCID" => array(
											"TYPE" => "",
											"VALUE" => ""
									),
									"YANDEX_SHOP_KEY" => array(
											"TYPE" => "",
											"VALUE" => ""
									)
							)
					),
					"PERSON_TYPE" => array(
							$arGeneralInfo["personType"]["fiz"]
					)
			);
			$logo = $_SERVER["DOCUMENT_ROOT"] . WIZARD_SERVICE_RELATIVE_PATH . "/images/yandex_terminals.png";
			$arPicture = CFile::MakeFileArray( $logo );
			$arPaySystems[] = array(
					'PAYSYSTEM' => array(
							"NAME" => GetMessage( "SALE_WIZARD_YTerminals" ),
							"SORT" => 70,
							"DESCRIPTION" => GetMessage( "SALE_WIZARD_YTerminals_DESC" ),
							"PSA_NAME" => GetMessage( "SALE_WIZARD_YTerminals" ),
							"ACTION_FILE" => "yandex",
							"RESULT_FILE" => "",
							"NEW_WINDOW" => "N",
							"HAVE_PAYMENT" => "Y",
							"HAVE_ACTION" => "N",
							"HAVE_RESULT" => "N",
							"HAVE_PREPAY" => "N",
							"HAVE_RESULT_RECEIVE" => "Y",
							"LOGOTIP" => $arPicture
					),
					"BIZVAL" => array(
							'' => array(
									"PAYMENT_ID" => array(
											"TYPE" => "ORDER",
											"VALUE" => "ID"
									),
									"PAYMENT_DATE_INSERT" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "DATE_BILL"
									),
									"PAYMENT_SHOULD_PAY" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "SUM"
									),
									"PS_IS_TEST" => array(
											"VALUE" => "Y"
									),
									"PS_CHANGE_STATUS_PAY" => array(
											"VALUE" => "Y"
									),
									"YANDEX_SHOP_ID" => array(
											"TYPE" => "",
											"VALUE" => ""
									),
									"YANDEX_SCID" => array(
											"TYPE" => "",
											"VALUE" => ""
									),
									"YANDEX_SHOP_KEY" => array(
											"TYPE" => "",
											"VALUE" => ""
									)
							)
					),
					"PERSON_TYPE" => array(
							$arGeneralInfo["personType"]["fiz"]
					)
			);
			$arPaySystems[] = array(
					'PAYSYSTEM' => array(
							"NAME" => GetMessage( "SALE_WIZARD_PS_WM" ),
							"SORT" => 90,
							"ACTIVE" => "N",
							"DESCRIPTION" => GetMessage( "SALE_WIZARD_PS_WM_DESCR" ),
							"PSA_NAME" => GetMessage( "SALE_WIZARD_PS_WM" ),
							"ACTION_FILE" => "webmoney",
							"RESULT_FILE" => "",
							"NEW_WINDOW" => "Y",
							"PARAMS" => "",
							"HAVE_PAYMENT" => "Y",
							"HAVE_ACTION" => "N",
							"HAVE_RESULT" => "Y",
							"HAVE_PREPAY" => "N",
							"HAVE_RESULT_RECEIVE" => "N"
					),
					"PERSON_TYPE" => array(
							$arGeneralInfo["personType"]["fiz"]
					)
			);

			if( $paysystem["sber"] == "Y" )
			{
				$arPaySystems[] = array(
						'PAYSYSTEM' => array(
								"NAME" => GetMessage( "SALE_WIZARD_PS_SB" ),
								"SORT" => 110,
								"DESCRIPTION" => GetMessage( "SALE_WIZARD_PS_SB_DESCR" ),
								"PSA_NAME" => GetMessage( "SALE_WIZARD_PS_SB" ),
								"ACTION_FILE" => "sberbank",
								"RESULT_FILE" => "",
								"NEW_WINDOW" => "Y",
								"HAVE_PAYMENT" => "Y",
								"HAVE_ACTION" => "N",
								"HAVE_RESULT" => "N",
								"HAVE_PREPAY" => "N",
								"HAVE_RESULT_RECEIVE" => "N"
						),
						"PERSON_TYPE" => array(
								$arGeneralInfo["personType"]["fiz"]
						),
						"BIZVAL" => array(
								'' => array(
										"SELLER_COMPANY_NAME" => array(
												"TYPE" => "",
												"VALUE" => $shopOfName
										),
										"SELLER_COMPANY_INN" => array(
												"TYPE" => "",
												"VALUE" => $shopINN
										),
										"SELLER_COMPANY_KPP" => array(
												"TYPE" => "",
												"VALUE" => $shopKPP
										),
										"SELLER_COMPANY_BANK_ACCOUNT" => array(
												"TYPE" => "",
												"VALUE" => $shopNS
										),
										"SELLER_COMPANY_BANK_NAME" => array(
												"TYPE" => "",
												"VALUE" => $shopBANK
										),
										"SELLER_COMPANY_BANK_BIC" => array(
												"TYPE" => "",
												"VALUE" => $shopBANKREKV
										),
										"SELLER_COMPANY_BANK_ACCOUNT_CORR" => array(
												"TYPE" => "",
												"VALUE" => $shopKS
										),
										"PAYMENT_ID" => array(
												"TYPE" => "PAYMENT",
												"VALUE" => "ACCOUNT_NUMBER"
										),
										"PAYMENT_DATE_INSERT" => array(
												"TYPE" => "PAYMENT",
												"VALUE" => "DATE_INSERT_DATE"
										),
										"BUYER_PERSON_FIO" => array(
												"TYPE" => "PROPERTY",
												"VALUE" => "FIO"
										),
										"BUYER_PERSON_ZIP" => array(
												"TYPE" => "PROPERTY",
												"VALUE" => "ZIP"
										),
										"BUYER_PERSON_COUNTRY" => array(
												"TYPE" => "PROPERTY",
												"VALUE" => "LOCATION_COUNTRY"
										),
										"BUYER_PERSON_REGION" => array(
												"TYPE" => "PROPERTY",
												"VALUE" => "LOCATION_REGION"
										),
										"BUYER_PERSON_CITY" => array(
												"TYPE" => "PROPERTY",
												"VALUE" => "LOCATION_CITY"
										),
										"BUYER_PERSON_ADDRESS_FACT" => array(
												"TYPE" => "PROPERTY",
												"VALUE" => "ADDRESS"
										),
										"PAYMENT_SHOULD_PAY" => array(
												"TYPE" => "PAYMENT",
												"VALUE" => "SUM"
										)
								)
						)
				);
			}
		}
		else
		{
			$arPaySystems[] = array(
					'PAYSYSTEM' => array(
							"NAME" => "PayPal",
							"SORT" => 90,
							"DESCRIPTION" => "",
							"PSA_NAME" => "PayPal",
							"ACTION_FILE" => "paypal",
							"RESULT_FILE" => "",
							"NEW_WINDOW" => "N",
							"HAVE_PAYMENT" => "Y",
							"HAVE_ACTION" => "N",
							"HAVE_RESULT" => "N",
							"HAVE_PREPAY" => "N",
							"HAVE_RESULT_RECEIVE" => "Y"
					),
					"BIZVAL" => array(
							'' => array(
									"PAYMENT_ID" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "ID"
									),
									"PAYMENT_DATE_INSERT" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "DATE_BILL_DATE"
									),
									"PAYMENT_SHOULD_PAY" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "SUM"
									),
									"PAYMENT_CURRENCY" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "CURRENCY"
									)
							)
					),
					"PERSON_TYPE" => array(
							$arGeneralInfo["personType"]["fiz"]
					)
			);
		}
	}

	if( $personType["ur"] == "Y" && $paysystem["sb"] == "Y" && $shopLocalization != "ua" )
	{
		$arPaySystems[] = array(
				'PAYSYSTEM' => array(
						"NAME" => GetMessage( "SALE_WIZARD_PS_SOTBIT_BILL" ),
						"SORT" => 100,
						"DESCRIPTION" => "",
						"PSA_NAME" => GetMessage( "SALE_WIZARD_PS_SOTBIT_BILL" ),
						"ACTION_FILE" => "billsotbit",
						"RESULT_FILE" => "",
						"NEW_WINDOW" => "Y",
						"HAVE_PAYMENT" => "Y",
						"HAVE_ACTION" => "N",
						"HAVE_RESULT" => "N",
						"HAVE_PREPAY" => "N",
						"HAVE_RESULT_RECEIVE" => "N"
				),
				"PERSON_TYPE" => array(
						$arGeneralInfo["personType"]["ur"]
				),
				"BIZVAL" => array(
						$arGeneralInfo["personType"]["ur"] => array(
								"PAYMENT_DATE_INSERT_SOTBIT" => Array(
										"TYPE" => "PAYMENT",
										"VALUE" => "DATE_BILL_DATE"
								),
								"SELLER_COMPANY_NAME_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopOfName
								),
								"SELLER_COMPANY_ADDRESS_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopAdr
								),
								"SELLER_COMPANY_PHONE_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $siteTelephone
								),
								"SELLER_COMPANY_INN_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopINN
								),
								"SELLER_COMPANY_KPP_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopKPP
								),
								"SELLER_COMPANY_BANK_ACCOUNT_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopNS
								),
								"SELLER_COMPANY_BANK_ACCOUNT_CORR_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopKS
								),
								"SELLER_COMPANY_BANK_BIC_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopBANKREKV
								),
								"BUYER_PERSON_COMPANY_NAME_SOTBIT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "COMPANY_NAME"
								),
								"BUYER_PERSON_COMPANY_INN_SOTBIT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "INN"
								),
								"BUYER_PERSON_COMPANY_ADDRESS_SOTBIT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "COMPANY_ADR"
								),
								"BUYER_PERSON_COMPANY_PHONE_SOTBIT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "PHONE"
								),
								"BUYER_PERSON_COMPANY_FAX_SOTBIT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "FAX"
								),
								"BUYER_PERSON_COMPANY_NAME_CONTACT_SOTBIT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "CONTACT_PERSON"
								),
								"BILL_PATH_TO_STAMP_SOTBIT" => Array(
										"TYPE" => "FILE",
										"VALUE" => $siteStamp
								)
						)
				)
		);
	}

	if( $personType["ip"] == "Y" && $paysystem["sb"] == "Y" && $shopLocalization != "ua" )
	{
		$arPaySystems[] = array(
				'PAYSYSTEM' => array(
						"NAME" => GetMessage( "SALE_WIZARD_PS_SOTBIT_BILL" ),
						"SORT" => 100,
						"DESCRIPTION" => "",
						"PSA_NAME" => GetMessage( "SALE_WIZARD_PS_SOTBIT_BILL" ),
						"ACTION_FILE" => "billsotbit",
						"RESULT_FILE" => "",
						"NEW_WINDOW" => "Y",
						"HAVE_PAYMENT" => "Y",
						"HAVE_ACTION" => "N",
						"HAVE_RESULT" => "N",
						"HAVE_PREPAY" => "N",
						"HAVE_RESULT_RECEIVE" => "N"
				),
				"PERSON_TYPE" => array(
						$arGeneralInfo["personType"]["ip"]
				),
				"BIZVAL" => array(
						$arGeneralInfo["personType"]["ip"] => array(
								"PAYMENT_DATE_INSERT_SOTBIT" => Array(
										"TYPE" => "PAYMENT",
										"VALUE" => "DATE_BILL_DATE"
								),
								"SELLER_COMPANY_NAME_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopOfName
								),
								"SELLER_COMPANY_ADDRESS_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopAdr
								),
								"SELLER_COMPANY_PHONE_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $siteTelephone
								),
								"SELLER_COMPANY_INN_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopINN
								),
								"SELLER_COMPANY_KPP_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopKPP
								),
								"SELLER_COMPANY_BANK_ACCOUNT_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopNS
								),
								"SELLER_COMPANY_BANK_ACCOUNT_CORR_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopKS
								),
								"SELLER_COMPANY_BANK_BIC_SOTBIT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopBANKREKV
								),
								"BUYER_PERSON_COMPANY_NAME_SOTBIT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "COMPANY_NAME"
								),
								"BUYER_PERSON_COMPANY_INN_SOTBIT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "INN"
								),
								"BUYER_PERSON_COMPANY_ADDRESS_SOTBIT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "COMPANY_ADR"
								),
								"BUYER_PERSON_COMPANY_PHONE_SOTBIT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "PHONE"
								),
								"BUYER_PERSON_COMPANY_FAX_SOTBIT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "FAX"
								),
								"BUYER_PERSON_COMPANY_NAME_CONTACT_SOTBIT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "CONTACT_PERSON"
								),
								"BILL_PATH_TO_STAMP_SOTBIT" => Array(
										"TYPE" => "FILE",
										"VALUE" => $siteStamp
								)
						)
				)
		);
	}

	if( $personType["ur"] == "Y" && $paysystem["bill"] == "Y" && $shopLocalization != "ua" )
	{
		$arPaySystems[] = array(
				'PAYSYSTEM' => array(
						"NAME" => GetMessage( "SALE_WIZARD_PS_BILL" ),
						"SORT" => 100,
						"DESCRIPTION" => "",
						"PSA_NAME" => GetMessage( "SALE_WIZARD_PS_BILL" ),
						"ACTION_FILE" => "bill",
						"RESULT_FILE" => "",
						"NEW_WINDOW" => "Y",
						"HAVE_PAYMENT" => "Y",
						"HAVE_ACTION" => "N",
						"HAVE_RESULT" => "N",
						"HAVE_PREPAY" => "N",
						"HAVE_RESULT_RECEIVE" => "N"
				),
				"PERSON_TYPE" => array(
						$arGeneralInfo["personType"]["ur"]
				),
				"BIZVAL" => array(
						$arGeneralInfo["personType"]["ur"] => array(
								"PAYMENT_DATE_INSERT" => Array(
										"TYPE" => "PAYMENT",
										"VALUE" => "DATE_BILL_DATE"
								),
								"SELLER_COMPANY_NAME" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopOfName
								),
								"SELLER_COMPANY_ADDRESS" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopAdr
								),
								"SELLER_COMPANY_PHONE" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $siteTelephone
								),
								"SELLER_COMPANY_INN" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopINN
								),
								"SELLER_COMPANY_KPP" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopKPP
								),
								"SELLER_COMPANY_BANK_ACCOUNT" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopNS
								),
								"SELLER_COMPANY_BANK_ACCOUNT_CORR" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopKS
								),
								"SELLER_COMPANY_BANK_BIC" => Array(
										"TYPE" => "VALUE",
										"VALUE" => $shopBANKREKV
								),
								"BUYER_PERSON_COMPANY_NAME" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "COMPANY_NAME"
								),
								"BUYER_PERSON_COMPANY_INN" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "INN"
								),
								"BUYER_PERSON_COMPANY_ADDRESS" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "COMPANY_ADR"
								),
								"BUYER_PERSON_COMPANY_PHONE" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "PHONE"
								),
								"BUYER_PERSON_COMPANY_FAX" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "FAX"
								),
								"BUYER_PERSON_COMPANY_NAME_CONTACT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "CONTACT_PERSON"
								),
								"BILL_PATH_TO_STAMP" => Array(
										"TYPE" => "FILE",
										"VALUE" => $siteStamp
								)
						)
				)
		);
		if( $module == 'sotbit.b2bshop' )
		{
			$last_key = end( array_keys( $arPaySystems ) );
			$logo = $_SERVER["DOCUMENT_ROOT"] . WIZARD_SERVICE_RELATIVE_PATH . "/images/bill.png";
			$arPicture = CFile::MakeFileArray( $logo );
			$arPaySystems[$last_key]['PAYSYSTEM']['LOGOTIP'] = $arPicture;
		}
	}

	if( $personType["ip"] == "Y" && $paysystem["bill"] == "Y" && $shopLocalization != "ua" )
	{
		$arPaySystems[] = array(
				'PAYSYSTEM' => array(
						"NAME" => GetMessage( "SALE_WIZARD_PS_BILL" ),
						"SORT" => 100,
						"DESCRIPTION" => "",
						"PSA_NAME" => GetMessage( "SALE_WIZARD_PS_BILL" ),
						"ACTION_FILE" => "bill",
						"RESULT_FILE" => "",
						"NEW_WINDOW" => "Y",
						"HAVE_PAYMENT" => "Y",
						"HAVE_ACTION" => "N",
						"HAVE_RESULT" => "N",
						"HAVE_PREPAY" => "N",
						"HAVE_RESULT_RECEIVE" => "N"
				),
				"PERSON_TYPE" => array(
						$arGeneralInfo["personType"]["ip"]
				),
				"BIZVAL" => array(
						'' => array(
								"PAYMENT_DATE_INSERT" => Array(
										"TYPE" => "PAYMENT",
										"VALUE" => "DATE_BILL_DATE"
								),
								"SELLER_COMPANY_NAME" => Array(
										"TYPE" => "",
										"VALUE" => $shopOfName
								),
								"SELLER_COMPANY_ADDRESS" => Array(
										"TYPE" => "",
										"VALUE" => $shopAdr
								),
								"SELLER_COMPANY_PHONE" => Array(
										"TYPE" => "",
										"VALUE" => $siteTelephone
								),
								"SELLER_COMPANY_INN" => Array(
										"TYPE" => "",
										"VALUE" => $shopINN
								),
								"SELLER_COMPANY_KPP" => Array(
										"TYPE" => "",
										"VALUE" => $shopKPP
								),
								"SELLER_COMPANY_BANK_ACCOUNT" => Array(
										"TYPE" => "",
										"VALUE" => $shopNS
								),
								"SELLER_COMPANY_BANK_ACCOUNT_CORR" => Array(
										"TYPE" => "",
										"VALUE" => $shopKS
								),
								"SELLER_COMPANY_BANK_BIC" => Array(
										"TYPE" => "",
										"VALUE" => $shopBANKREKV
								),
								"BUYER_PERSON_COMPANY_NAME" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "COMPANY_NAME"
								),
								"BUYER_PERSON_COMPANY_INN" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "INN"
								),
								"BUYER_PERSON_COMPANY_ADDRESS" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "COMPANY_ADR"
								),
								"BUYER_PERSON_COMPANY_PHONE" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "PHONE"
								),
								"BUYER_PERSON_COMPANY_FAX" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "FAX"
								),
								"BUYER_PERSON_COMPANY_NAME_CONTACT" => Array(
										"TYPE" => "PROPERTY",
										"VALUE" => "CONTACT_PERSON"
								),
								"BILL_PATH_TO_STAMP" => Array(
										"TYPE" => "",
										"VALUE" => $siteStamp
								)
						)
				)
		);
		if( $module == 'sotbit.b2bshop' )
		{
			$last_key = end( array_keys( $arPaySystems ) );
			$logo = $_SERVER["DOCUMENT_ROOT"] . WIZARD_SERVICE_RELATIVE_PATH . "/images/bill.png";
			$arPicture = CFile::MakeFileArray( $logo );
			$arPaySystems[$last_key]['PAYSYSTEM']['LOGOTIP'] = $arPicture;
		}
	}

	// Ukraine
	if( $shopLocalization == "ua" )
	{
		// oshadbank
		if( ($personType["fiz"] == "Y" || $personType["fiz_ua"] == "Y") && $paysystem["oshad"] == "Y" )
		{
			$arPaySystems[] = array(
					'PAYSYSTEM' => array(
							"NAME" => GetMessage( "SALE_WIZARD_PS_OS" ),
							"SORT" => 90,
							"DESCRIPTION" => GetMessage( "SALE_WIZARD_PS_OS_DESCR" ),
							"PSA_NAME" => GetMessage( "SALE_WIZARD_PS_OS" ),
							"ACTION_FILE" => "/bitrix/modules/sale/payment/oshadbank",
							"RESULT_FILE" => "",
							"NEW_WINDOW" => "Y",
							"HAVE_PAYMENT" => "Y",
							"HAVE_ACTION" => "N",
							"HAVE_RESULT" => "N",
							"HAVE_PREPAY" => "N",
							"HAVE_RESULT_RECEIVE" => "N"
					),
					"PERSON_TYPE" => array(
							$arGeneralInfo["personType"]["fiz"],
							$arGeneralInfo["personType"]["fiz_ua"]
					),
					"BIZVAL" => array(
							'' => array(
									"RECIPIENT_NAME" => array(
											"TYPE" => "",
											"VALUE" => $shopOfName
									),
									"RECIPIENT_ID" => array(
											"TYPE" => "",
											"VALUE" => $shopEGRPU_ua
									),
									"RECIPIENT_NUMBER" => array(
											"TYPE" => "",
											"VALUE" => $shopNS_ua
									),
									"RECIPIENT_BANK" => array(
											"TYPE" => "",
											"VALUE" => $shopBank_ua
									),
									"RECIPIENT_CODE_BANK" => array(
											"TYPE" => "",
											"VALUE" => $shopMFO_ua
									),
									"PAYER_FIO" => array(
											"TYPE" => "PROPERTY",
											"VALUE" => "FIO"
									),
									"PAYER_ADRES" => array(
											"TYPE" => "PROPERTY",
											"VALUE" => "ADDRESS"
									),
									"ORDER_ID" => array(
											"TYPE" => "ORDER",
											"VALUE" => "ID"
									),
									"DATE_INSERT" => array(
											"TYPE" => "ORDER",
											"VALUE" => "DATE_INSERT_DATE"
									),
									"PAYER_CONTACT_PERSON" => array(
											"TYPE" => "PROPERTY",
											"VALUE" => "FIO"
									),
									"PAYER_INDEX" => array(
											"TYPE" => "PROPERTY",
											"VALUE" => "ZIP"
									),
									"PAYER_COUNTRY" => array(
											"TYPE" => "PROPERTY",
											"VALUE" => "LOCATION_COUNTRY"
									),
									"PAYER_TOWN" => array(
											"TYPE" => "PROPERTY",
											"VALUE" => "LOCATION_CITY"
									),
									"SHOULD_PAY" => array(
											"TYPE" => "ORDER",
											"VALUE" => "PRICE"
									)
							)
					)
			);
		}
		if( $personType["fiz"] == "Y" )
		{
			$arPaySystems[] = array(
					'PAYSYSTEM' => array(
							"NAME" => GetMessage( "SALE_WIZARD_YMoney" ),
							"SORT" => 60,
							"DESCRIPTION" => GetMessage( "SALE_WIZARD_YMoney_DESC" ),
							"PSA_NAME" => GetMessage( "SALE_WIZARD_YMoney" ),
							"ACTION_FILE" => "yandex",
							"RESULT_FILE" => "",
							"NEW_WINDOW" => "N",
							"PS_MODE" => "PC",
							"HAVE_PAYMENT" => "Y",
							"HAVE_ACTION" => "N",
							"HAVE_RESULT" => "N",
							"HAVE_PREPAY" => "N",
							"HAVE_RESULT_RECEIVE" => "Y"
					),
					"PERSON_TYPE" => array(
							$arGeneralInfo["personType"]["fiz"]
					),
					"PARAMS" => array(
							'' => array(
									"PAYMENT_ID" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "ID"
									),
									"PAYMENT_DATE_INSERT" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "DATE_BILL"
									),
									"PAYMENT_SHOULD_PAY" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "SUM"
									)
							)
					)
			);
			$arPaySystems[] = array(
					'PAYSYSTEM' => array(
							"NAME" => GetMessage( "SALE_WIZARD_YCards" ),
							"SORT" => 70,
							"DESCRIPTION" => GetMessage( "SALE_WIZARD_YCards_DESC" ),
							"PSA_NAME" => GetMessage( "SALE_WIZARD_YCards" ),
							"ACTION_FILE" => "yandex",
							"RESULT_FILE" => "",
							"NEW_WINDOW" => "N",
							"PS_MODE" => "AC",
							"HAVE_PAYMENT" => "Y",
							"HAVE_ACTION" => "N",
							"HAVE_RESULT" => "N",
							"HAVE_PREPAY" => "N",
							"HAVE_RESULT_RECEIVE" => "Y"
					),
					"PERSON_TYPE" => array(
							$arGeneralInfo["personType"]["fiz"]
					),
					"BIZVAL" => array(
							'' => array(
									"PAYMENT_ID" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "ID"
									),
									"PAYMENT_DATE_INSERT" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "DATE_BILL"
									),
									"PAYMENT_SHOULD_PAY" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "SUM"
									)
							)
					)
			);
			if( $module == 'sotbit.b2bshop' )
			{
				$last_key = end( array_keys( $arPaySystems ) );
				$logo = $_SERVER["DOCUMENT_ROOT"] . WIZARD_SERVICE_RELATIVE_PATH . "/images/card.png";
				$arPicture = CFile::MakeFileArray( $logo );
				$arPaySystems[$last_key]['PAYSYSTEM']['LOGOTIP'] = $arPicture;
			}
			$arPaySystems[] = array(
					'PAYSYSTEM' => array(
							"NAME" => GetMessage( "SALE_WIZARD_YTerminals" ),
							"SORT" => 80,
							"DESCRIPTION" => GetMessage( "SALE_WIZARD_YTerminals_DESC" ),
							"PSA_NAME" => GetMessage( "SALE_WIZARD_YTerminals" ),
							"ACTION_FILE" => "yandex",
							"RESULT_FILE" => "",
							"NEW_WINDOW" => "N",
							"HAVE_PAYMENT" => "Y",
							"HAVE_ACTION" => "N",
							"HAVE_RESULT" => "N",
							"HAVE_PREPAY" => "N",
							"HAVE_RESULT_RECEIVE" => "Y",
							"PS_MODE" => "GP"
					),
					"PERSON_TYPE" => array(
							$arGeneralInfo["personType"]["fiz"]
					),
					"BIZVAL" => array(
							'' => array(
									"PAYMENT_ID" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "ID"
									),
									"PAYMENT_DATE_INSERT" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "DATE_BILL"
									),
									"PAYMENT_SHOULD_PAY" => array(
											"TYPE" => "PAYMENT",
											"VALUE" => "SUM"
									)
							)
					)
			);
			if( $module == 'sotbit.b2bshop' )
			{
				$last_key = end( array_keys( $arPaySystems ) );
				$logo = $_SERVER["DOCUMENT_ROOT"] . WIZARD_SERVICE_RELATIVE_PATH . "/images/card.png";
				$arPicture = CFile::MakeFileArray( $logo );
				$arPaySystems[$last_key]['PAYSYSTEM']['LOGOTIP'] = $arPicture;
			}
		}
		// bill
		if( $paysystem["bill"] == "Y" )
		{
			$arPaySystem['PAYSYSTEM'] = array(
					"NAME" => GetMessage( "SALE_WIZARD_PS_BILL" ),
					"PSA_NAME" => GetMessage( "SALE_WIZARD_PS_BILL" ),
					"ACTION_FILE" => "billua",
					"RESULT_FILE" => "",
					"NEW_WINDOW" => "Y",
					"HAVE_PAYMENT" => "Y",
					"HAVE_ACTION" => "N",
					"HAVE_RESULT" => "N",
					"HAVE_PREPAY" => "N",
					"HAVE_RESULT_RECEIVE" => "N"
			);

			$arPaySystem['PERSON_TYPE'] = array();
			$arPaySystem['BIZVAL'] = array();

			if( $personType["ur"] == "Y" )
			{
				$arPaySystem['PERSON_TYPE'][] = $arGeneralInfo["personType"]["ur"];
				$arPaySystem['BIZVAL'][$arGeneralInfo["personType"]["ur"]] = array(
						"PAYMENT_DATE_INSERT" => array(
								"TYPE" => "ORDER",
								"VALUE" => "DATE_INSERT_DATE"
						),
						"SELLER_COMPANY_NAME" => array(
								"TYPE" => "",
								"VALUE" => $shopOfName
						),
						"SELLER_COMPANY_ADDRESS" => array(
								"TYPE" => "",
								"VALUE" => $shopAdr
						),
						"SELLER_COMPANY_PHONE" => array(
								"TYPE" => "",
								"VALUE" => $siteTelephone
						),
						"SELLER_COMPANY_IPN" => array(
								"TYPE" => "",
								"VALUE" => $shopINN_ua
						),
						"SELLER_COMPANY_EDRPOY" => array(
								"TYPE" => "",
								"VALUE" => $shopEGRPU_ua
						),
						"SELLER_COMPANY_BANK_ACCOUNT" => array(
								"TYPE" => "",
								"VALUE" => $shopNS_ua
						),
						"SELLER_COMPANY_BANK_NAME" => array(
								"TYPE" => "",
								"VALUE" => $shopBank_ua
						),
						"SELLER_COMPANY_MFO" => array(
								"TYPE" => "",
								"VALUE" => $shopMFO_ua
						),
						"SELLER_COMPANY_PDV" => array(
								"TYPE" => "",
								"VALUE" => $shopNDS_ua
						),
						"PAYMENT_ID" => array(
								"TYPE" => "ORDER",
								"VALUE" => "ID"
						),
						"SELLER_COMPANY_SYS" => array(
								"TYPE" => "",
								"VALUE" => $shopTax_ua
						),
						"BUYER_PERSON_COMPANY_NAME" => array(
								"TYPE" => "PROPERTY",
								"VALUE" => "COMPANY_NAME"
						),
						"BUYER_PERSON_COMPANY_ADDRESS" => array(
								"TYPE" => "PROPERTY",
								"VALUE" => "COMPANY_ADR"
						),
						"BUYER_PERSON_COMPANY_PHONE" => array(
								"TYPE" => "PROPERTY",
								"VALUE" => "PHONE"
						),
						"BUYER_PERSON_COMPANY_FAX" => array(
								"TYPE" => "PROPERTY",
								"VALUE" => "FAX"
						),
						"BILLUA_PATH_TO_STAMP" => array(
								"TYPE" => "",
								"VALUE" => $siteStamp
						)
				);
			}

			if( $personType["fiz"] == "Y" )
			{
				$arPaySystem['PERSON_TYPE'][] = $arGeneralInfo["personType"]["fiz"];
				$arPaySystem['BIZVAL'][$arGeneralInfo["personType"]["fiz"]] = array(
						"PAYMENT_DATE_INSERT" => array(
								"TYPE" => "ORDER",
								"VALUE" => "DATE_INSERT_DATE"
						),
						"SELLER_COMPANY_NAME" => array(
								"TYPE" => "",
								"VALUE" => $shopOfName
						),
						"SELLER_COMPANY_ADDRESS" => array(
								"TYPE" => "",
								"VALUE" => $shopAdr
						),
						"SELLER_COMPANY_PHONE" => array(
								"TYPE" => "",
								"VALUE" => $siteTelephone
						),
						"SELLER_COMPANY_IPN" => array(
								"TYPE" => "",
								"VALUE" => $shopINN_ua
						),
						"SELLER_COMPANY_EDRPOY" => array(
								"TYPE" => "",
								"VALUE" => $shopEGRPU_ua
						),
						"SELLER_COMPANY_BANK_ACCOUNT" => array(
								"TYPE" => "",
								"VALUE" => $shopNS_ua
						),
						"SELLER_COMPANY_BANK_NAME" => array(
								"TYPE" => "",
								"VALUE" => $shopBank_ua
						),
						"SELLER_COMPANY_MFO" => array(
								"TYPE" => "",
								"VALUE" => $shopMFO_ua
						),
						"SELLER_COMPANY_PDV" => array(
								"TYPE" => "",
								"VALUE" => $shopNDS_ua
						),
						"PAYMENT_ID" => array(
								"TYPE" => "ORDER",
								"VALUE" => "ID"
						),
						"SELLER_COMPANY_SYS" => array(
								"TYPE" => "",
								"VALUE" => $shopTax_ua
						),
						"BUYER_PERSON_COMPANY_NAME" => array(
								"TYPE" => "PROPERTY",
								"VALUE" => "FIO"
						),
						"BUYER_PERSON_COMPANY_ADDRESS" => array(
								"TYPE" => "PROPERTY",
								"VALUE" => "ADDRESS"
						),
						"BUYER_PERSON_COMPANY_PHONE" => array(
								"TYPE" => "PROPERTY",
								"VALUE" => "PHONE"
						),
						"BUYER_PERSON_COMPANY_FAX" => array(
								"TYPE" => "PROPERTY",
								"VALUE" => "FAX"
						),
						"BILLUA_PATH_TO_STAMP" => array(
								"TYPE" => "",
								"VALUE" => $siteStamp
						)
				);
			}

			if( $personType["fiz_ua"] == "Y" )
			{
				$arPaySystem['PERSON_TYPE'][] = $arGeneralInfo["personType"]["fiz_ua"];
				$arPaySystem['BIZVAL'][$arGeneralInfo["personType"]["fiz_ua"]] = array(
						"PAYMENT_DATE_INSERT" => array(
								"TYPE" => "ORDER",
								"VALUE" => "DATE_INSERT_DATE"
						),
						"SELLER_COMPANY_NAME" => array(
								"TYPE" => "",
								"VALUE" => $shopOfName
						),
						"SELLER_COMPANY_ADDRESS" => array(
								"TYPE" => "",
								"VALUE" => $shopAdr
						),
						"SELLER_COMPANY_PHONE" => array(
								"TYPE" => "",
								"VALUE" => $siteTelephone
						),
						"SELLER_COMPANY_IPN" => array(
								"TYPE" => "",
								"VALUE" => $shopINN_ua
						),
						"SELLER_COMPANY_EDRPOY" => array(
								"TYPE" => "",
								"VALUE" => $shopEGRPU_ua
						),
						"SELLER_COMPANY_BANK_ACCOUNT" => array(
								"TYPE" => "",
								"VALUE" => $shopNS_ua
						),
						"SELLER_COMPANY_BANK_NAME" => array(
								"TYPE" => "",
								"VALUE" => $shopBank_ua
						),
						"SELLER_COMPANY_MFO" => array(
								"TYPE" => "",
								"VALUE" => $shopMFO_ua
						),
						"SELLER_COMPANY_PDV" => array(
								"TYPE" => "",
								"VALUE" => $shopNDS_ua
						),
						"PAYMENT_ID" => array(
								"TYPE" => "ORDER",
								"VALUE" => "ID"
						),
						"SELLER_COMPANY_SYS" => array(
								"TYPE" => "",
								"VALUE" => $shopTax_ua
						),
						"BUYER_PERSON_COMPANY_NAME" => array(
								"TYPE" => "PROPERTY",
								"VALUE" => "FIO"
						),
						"BUYER_PERSON_COMPANY_ADDRESS" => array(
								"TYPE" => "PROPERTY",
								"VALUE" => "COMPANY_ADR"
						),
						"BUYER_PERSON_COMPANY_PHONE" => array(
								"TYPE" => "PROPERTY",
								"VALUE" => "PHONE"
						),
						"BUYER_PERSON_COMPANY_FAX" => array(
								"TYPE" => "PROPERTY",
								"VALUE" => "FAX"
						),
						"BILLUA_PATH_TO_STAMP" => array(
								"TYPE" => "",
								"VALUE" => $siteStamp
						)
				);
			}

			$arPaySystems[] = $arPaySystem;
		}
	}
	// }

	foreach( $arPaySystems as $arPaySystem )
	{
		$updateFields = array();

		$val = $arPaySystem['PAYSYSTEM'];
		if( array_key_exists( 'LOGOTIP', $val ) && is_array( $val['LOGOTIP'] ) )
		{
			$updateFields['LOGOTIP'] = $val['LOGOTIP'];
			unset( $val['LOGOTIP'] );
		}

		$dbRes = \Bitrix\Sale\PaySystem\Manager::getList( array(
				'select' => array(
						"ID",
						"NAME"
				),
				'filter' => array(
						"NAME" => $val["NAME"]
				)
		) );
		$tmpPaySystem = $dbRes->fetch();
		if( !$tmpPaySystem )
		{
			$resultAdd = \Bitrix\Sale\Internals\PaySystemActionTable::add( $val );
			if( $resultAdd->isSuccess() )
			{
				$id = $resultAdd->getId();

				if( array_key_exists( 'BIZVAL', $arPaySystem ) && $arPaySystem['BIZVAL'] )
				{
					$arGeneralInfo["paySystem"][$arPaySystem["ACTION_FILE"]] = $id;
					foreach( $arPaySystem['BIZVAL'] as $personType => $codes )
					{
						foreach( $codes as $code => $map )
							\Bitrix\Sale\BusinessValue::setMapping( $code, 'PAYSYSTEM_' . $id, $personType, array(
									'PROVIDER_KEY' => $map['TYPE'],
									'PROVIDER_VALUE' => $map['VALUE']
							), true );
					}
				}

				if( $arPaySystem['PERSON_TYPE'] )
				{
					$params = array(
							'filter' => array(
									"SERVICE_ID" => $id,
									"SERVICE_TYPE" => \Bitrix\Sale\Services\PaySystem\Restrictions\Manager::SERVICE_TYPE_PAYMENT,
									"=CLASS_NAME" => '\Bitrix\Sale\Services\PaySystem\Restrictions\PersonType'
							)
					);

					$dbRes = \Bitrix\Sale\Internals\ServiceRestrictionTable::getList( $params );
					if( !$dbRes->fetch() )
					{
						$fields = array(
								"SERVICE_ID" => $id,
								"SERVICE_TYPE" => \Bitrix\Sale\Services\PaySystem\Restrictions\Manager::SERVICE_TYPE_PAYMENT,
								"SORT" => 100,
								"PARAMS" => array(
										'PERSON_TYPE_ID' => $arPaySystem['PERSON_TYPE']
								)
						);
						\Bitrix\Sale\Services\PaySystem\Restrictions\PersonType::save( $fields );
					}
				}

				$updateFields['PARAMS'] = serialize( array(
						'BX_PAY_SYSTEM_ID' => $id
				) );
				$updateFields['PAY_SYSTEM_ID'] = $id;

				$image = '/bitrix/modules/sale/install/images/sale_payments/' . $val['ACTION_FILE'] . '.png';
				if( (!array_key_exists( 'LOGOTIP', $updateFields ) || !is_array( $updateFields['LOGOTIP'] )) && \Bitrix\Main\IO\File::isFileExists( $_SERVER['DOCUMENT_ROOT'] . $image ) )
				{
					$updateFields['LOGOTIP'] = CFile::MakeFileArray( $image );
					$updateFields['LOGOTIP']['MODULE_ID'] = "sale";
				}

				CFile::SaveForDB( $updateFields, 'LOGOTIP', 'sale/paysystem/logotip' );
				\Bitrix\Sale\Internals\PaySystemActionTable::update( $id, $updateFields );
			}
		}
		else
		{
			$flag = false;

			$params = array(
					'filter' => array(
							"SERVICE_ID" => $tmpPaySystem['ID'],
							"SERVICE_TYPE" => \Bitrix\Sale\Services\PaySystem\Restrictions\Manager::SERVICE_TYPE_PAYMENT,
							"=CLASS_NAME" => '\Bitrix\Sale\Services\PaySystem\Restrictions\PersonType'
					)
			);

			$dbRes = \Bitrix\Sale\Internals\ServiceRestrictionTable::getList( $params );
			$restriction = $dbRes->fetch();

			if( $restriction )
			{
				foreach( $restriction['PARAMS']['PERSON_TYPE_ID'] as $personTypeId )
				{
					if( array_search( $personTypeId, $arPaySystem['PERSON_TYPE'] ) === false )
					{
						$arPaySystem['PERSON_TYPE'][] = $personTypeId;
						$flag = true;
					}
				}

				$restrictionId = $restriction['ID'];
			}

			if( $flag )
			{
				$fields = array(
						"SERVICE_ID" => $restrictionId,
						"SERVICE_TYPE" => \Bitrix\Sale\Services\PaySystem\Restrictions\Manager::SERVICE_TYPE_PAYMENT,
						"SORT" => 100,
						"PARAMS" => array(
								'PERSON_TYPE_ID' => $arPaySystem['PERSON_TYPE']
						)
				);

				\Bitrix\Sale\Services\PaySystem\Restrictions\PersonType::save( $fields, $restrictionId );
			}
		}
	}

	if( COption::GetOptionString( "sotbit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID ) != "Y" || WIZARD_INSTALL_DEMO_DATA )
	{
		if( $saleConverted15 )
		{
			$orderPaidStatus = 'P';
			$deliveryAssembleStatus = 'DA';
			$deliveryGoodsStatus = 'DG';
			$deliveryTransportStatus = 'DT';
			$deliveryShipmentStatus = 'DS';

			$statusIds = array(
					$orderPaidStatus,
					$deliveryAssembleStatus,
					$deliveryGoodsStatus,
					$deliveryTransportStatus,
					$deliveryShipmentStatus
			);

			$statusLanguages = array();

			foreach( $arLanguages as $langID )
			{
				Loc::loadLanguageFile( $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/sale/lib/status.php', $langID );

				foreach( $statusIds as $statusId )
				{
					if( $statusName = Loc::getMessage( "SALE_STATUS_{$statusId}" ) )
					{
						$statusLanguages[$statusId][] = array(
								'LID' => $langID,
								'NAME' => $statusName,
								'DESCRIPTION' => Loc::getMessage( "SALE_STATUS_{$statusId}_DESCR" )
						);
					}
				}
			}

			OrderStatus::install( array(
					'ID' => $orderPaidStatus,
					'SORT' => 150,
					'NOTIFY' => 'Y',
					'LANG' => $statusLanguages[$orderPaidStatus]
			) );
			CSaleStatus::CreateMailTemplate( $orderPaidStatus );

			DeliveryStatus::install( array(
					'ID' => $deliveryAssembleStatus,
					'SORT' => 310,
					'NOTIFY' => 'Y',
					'LANG' => $statusLanguages[$deliveryAssembleStatus]
			) );

			DeliveryStatus::install( array(
					'ID' => $deliveryGoodsStatus,
					'SORT' => 320,
					'NOTIFY' => 'Y',
					'LANG' => $statusLanguages[$deliveryGoodsStatus]
			) );

			DeliveryStatus::install( array(
					'ID' => $deliveryTransportStatus,
					'SORT' => 330,
					'NOTIFY' => 'Y',
					'LANG' => $statusLanguages[$deliveryTransportStatus]
			) );

			DeliveryStatus::install( array(
					'ID' => $deliveryShipmentStatus,
					'SORT' => 340,
					'NOTIFY' => 'Y',
					'LANG' => $statusLanguages[$deliveryShipmentStatus]
			) );
		}
		else
		{
			$bStatusP = false;
			$dbStatus = CSaleStatus::GetList( Array(
					"SORT" => "ASC"
			) );
			while ( $arStatus = $dbStatus->Fetch() )
			{
				$arFields = Array();
				foreach( $arLanguages as $langID )
				{
					WizardServices::IncludeServiceLang( "step1.php", $langID );
					$arFields["LANG"][] = Array(
							"LID" => $langID,
							"NAME" => GetMessage( "WIZ_SALE_STATUS_" . $arStatus["ID"] ),
							"DESCRIPTION" => GetMessage( "WIZ_SALE_STATUS_DESCRIPTION_" . $arStatus["ID"] )
					);
				}
				$arFields["ID"] = $arStatus["ID"];
				CSaleStatus::Update( $arStatus["ID"], $arFields );
				if( $arStatus["ID"] == "P" )
					$bStatusP = true;
			}
			if( !$bStatusP )
			{
				$arFields = Array(
						"ID" => "P",
						"SORT" => 150
				);
				foreach( $arLanguages as $langID )
				{
					WizardServices::IncludeServiceLang( "step1.php", $langID );
					$arFields["LANG"][] = Array(
							"LID" => $langID,
							"NAME" => GetMessage( "WIZ_SALE_STATUS_P" ),
							"DESCRIPTION" => GetMessage( "WIZ_SALE_STATUS_DESCRIPTION_P" )
					);
				}

				$ID = CSaleStatus::Add( $arFields );
				if( $ID !== '' )
				{
					CSaleStatus::CreateMailTemplate( $ID );
				}
			}
		}

		if( CModule::IncludeModule( "currency" ) )
		{
			$dbCur = CCurrency::GetList( $by = "currency", $o = "asc" );
			while ( $arCur = $dbCur->Fetch() )
			{
				if( $lang == "ru" )
					CCurrencyLang::Update( $arCur["CURRENCY"], $lang, array(
							"DECIMALS" => 2,
							"HIDE_ZERO" => "Y"
					) );
				elseif( $arCur["CURRENCY"] == "EUR" )
					CCurrencyLang::Update( $arCur["CURRENCY"], $lang, array(
							"DECIMALS" => 2,
							"FORMAT_STRING" => "&euro;#"
					) );
			}
		}
		WizardServices::IncludeServiceLang( "step1.php", $lang );

		if( CModule::IncludeModule( "catalog" ) )
		{
			$dbVat = CCatalogVat::GetListEx( array(), array(
					'RATE' => 0
			), false, false, array(
					'ID',
					'RATE'
			) );
			if( !($dbVat->Fetch()) )
			{
				$arF = array(
						"ACTIVE" => "Y",
						"SORT" => "100",
						"NAME" => GetMessage( "WIZ_VAT_1" ),
						"RATE" => 0
				);
				CCatalogVat::Add( $arF );
			}
			$dbVat = CCatalogVat::GetListEx( array(), array(
					'RATE' => GetMessage( "WIZ_VAT_2_VALUE" )
			), false, false, array(
					'ID',
					'RATE'
			) );
			if( !($dbVat->Fetch()) )
			{
				$arF = array(
						"ACTIVE" => "Y",
						"SORT" => "200",
						"NAME" => GetMessage( "WIZ_VAT_2" ),
						"RATE" => GetMessage( "WIZ_VAT_2_VALUE" )
				);
				CCatalogVat::Add( $arF );
			}
			$dbResultList = CCatalogGroup::GetList( array(), array(
					"CODE" => "BASE"
			) );
			if( $arRes = $dbResultList->Fetch() )
			{
				$arFields = Array();
				foreach( $arLanguages as $langID )
				{
					WizardServices::IncludeServiceLang( "step1.php", $langID );
					$arFields["USER_LANG"][$langID] = GetMessage( "WIZ_PRICE_NAME" );
				}
				$arFields["BASE"] = "Y";
				if( $wizard->GetVar( "installPriceBASE" ) == "Y" )
				{
					$db_res = CCatalogGroup::GetGroupsList( array(
							"CATALOG_GROUP_ID" => '1',
							"BUY" => "Y"
					) );
					if( $ar_res = $db_res->Fetch() )
					{
						$wizGroupId[] = $ar_res['GROUP_ID'];
					}
					$wizGroupId[] = 1;
					$wizGroupId[] = 2;
					$arFields["USER_GROUP"] = $wizGroupId;
					$arFields["USER_GROUP_BUY"] = $wizGroupId;
				}
				CCatalogGroup::Update( $arRes["ID"], $arFields );
			}
		}

		// making orders
		function __MakeOrder($prdCnt = 1, $arData = Array())
		{
			global $APPLICATION, $USER, $DB;
			CModule::IncludeModule( "iblock" );
			CModule::IncludeModule( "sale" );
			CModule::IncludeModule( "catalog" );
			$arPrd = Array();

			$ibl = COption::GetOptionString( 'sotbit.b2bshop', 'IBLOCK_ID' );
			$oIbl = CCatalogSKU::GetInfoByProductIBlock( $ibl );
			if( $oIbl )
			{
				$oIbl = $oIbl['IBLOCK_ID'];
			}

			if( !$oIbl )
			{
				return false;
			}

			$dbItem = CIBlockElement::GetList( Array(), Array(
					"IBLOCK_ID" => $oIbl
			), false, Array(
					"nTopCount" => 100
			), Array(
					"ID",
					"IBLOCK_ID",
					"XML_ID",
					"NAME",
					"DETAIL_PAGE_URL",
					"IBLOCK_XML_ID"
			) );
			while ( $arItem = $dbItem->GetNext() )
				$arPrd[] = $arItem;

			if( !empty( $arPrd ) )
			{
				$arOrder = Array(
						"LID" => $arData["SITE_ID"],
						"PERSON_TYPE_ID" => $arData["PERSON_TYPE_ID"],
						"PAYED" => "N",
						"CANCELED" => "N",
						"STATUS_ID" => "N",
						"PRICE" => 1,
						"CURRENCY" => $arData["CURRENCY"],
						"USER_ID" => $arData["USER_ID"],
						"PAY_SYSTEM_ID" => $arData["PAY_SYSTEM_ID"]
					// "PRICE_DELIVERY" => $arData["PRICE_DELIVERY"],
					// "DELIVERY_ID" => $arData["DELIVERY_ID"],
				);

				$fuserID = 0;
				$dbFUserListTmp = CSaleUser::GetList( array(
						"USER_ID" => $arData["USER_ID"]
				) );
				if( empty( $dbFUserListTmp ) )
				{
					$arFields = array(
							"=DATE_INSERT" => $DB->GetNowFunction(),
							"=DATE_UPDATE" => $DB->GetNowFunction(),
							"USER_ID" => $arData["USER_ID"]
					);

					$fuserID = CSaleUser::_Add( $arFields );
				}
				else
				{
					$fuserID = $dbFUserListTmp['ID'];
				}

				$orderID = CSaleOrder::Add( $arOrder );

				CCatalogProduct::setPriceVatIncludeMode( true );
				CCatalogProduct::setUsedCurrency( CSaleLang::GetLangCurrency( WIZARD_SITE_ID ) );
				CCatalogProduct::setUseDiscount( true );
				for($i = 0; $i < $prdCnt; $i++)
				{
					$prdID = $arPrd[mt_rand( 20, 99 )];
					$arProduct = CCatalogProduct::GetByID( $prdID["ID"] );
					$arPrice = CCatalogProduct::GetOptimalPrice( $prdID["ID"], 1, array(
							2
					), 'N', array(), WIZARD_SITE_ID, array() );

					$arFields = array(
							"IGNORE_CALLBACK_FUNC" => "Y",
							"PRODUCT_ID" => $prdID["ID"],
							"PRODUCT_PRICE_ID" => $arPrice['PRICE']['ID'],
							"BASE_PRICE" => $arPrice['RESULT_PRICE']['BASE_PRICE'],
							"PRICE" => $arPrice['RESULT_PRICE']['DISCOUNT_PRICE'],
							"VAT_RATE" => $arPrice['PRICE']['VAT_RATE'],
							"CURRENCY" => $arPrice['RESULT_PRICE']['CURRENCY'],
							"WEIGHT" => $arProduct["WEIGHT"],
							"DIMENSIONS" => serialize( array(
									"WIDTH" => $arProduct["WIDTH"],
									"HEIGHT" => $arProduct["HEIGHT"],
									"LENGTH" => $arProduct["LENGTH"]
							) ),
							"QUANTITY" => 1,
							"LID" => WIZARD_SITE_ID,
							"DELAY" => "N",
							"CAN_BUY" => "Y",
							"NAME" => $prdID["NAME"],
							"CALLBACK_FUNC" => "",
							"MODULE" => "catalog",
							"PRODUCT_PROVIDER_CLASS" => "CCatalogProductProvider",
							"ORDER_CALLBACK_FUNC" => "",
							"CANCEL_CALLBACK_FUNC" => "",
							"PAY_CALLBACK_FUNC" => "",
							"DETAIL_PAGE_URL" => $prdID["DETAIL_PAGE_URL"],
							"CATALOG_XML_ID" => $prdID["IBLOCK_XML_ID"],
							"PRODUCT_XML_ID" => $prdID["XML_ID"],
							"NOTES" => $arPrice["PRICE"]["CATALOG_GROUP_NAME"],
							"FUSER_ID" => $fuserID,
							"ORDER_ID" => $orderID
					);
					$addres = CSaleBasket::Add( $arFields );
				}
				$dbBasketItems = CSaleBasket::GetList( array(), array(
						"ORDER_ID" => $orderID
				), false, false, array(
						"ID",
						"QUANTITY",
						"PRICE"
				) );
				$ORDER_PRICE = 0;
				while ( $arBasketItems = $dbBasketItems->GetNext() )
				{
					$ORDER_PRICE += roundEx( $arBasketItems["PRICE"], SALE_VALUE_PRECISION ) * DoubleVal( $arBasketItems["QUANTITY"] );
				}

				$totalOrderPrice = $ORDER_PRICE + $arData["PRICE_DELIVERY"];
				CSaleOrder::Update( $orderID, Array(
						"PRICE" => $totalOrderPrice
				) );
				foreach( $arData["PROPS"] as $val )
				{
					$arFields = Array(
							"ORDER_ID" => $orderID,
							"ORDER_PROPS_ID" => $val["ID"],
							"NAME" => $val["NAME"],
							"CODE" => $val["CODE"],
							"VALUE" => $val["VALUE"]
					);
					CSaleOrderPropsValue::Add( $arFields );
				}
				return $orderID;
			}
		}

		$personType = $arGeneralInfo["personType"]["ur"];
		if($module != 'sotbit.b2bshop')
		{
			if( IntVal( $arGeneralInfo["personType"]["fiz"] ) > 0 )
				$personType = $arGeneralInfo["personType"]["fiz"];
		}
		if( IntVal( $personType ) <= 0 )
		{
			$dbPerson = CSalePersonType::GetList( array(), Array(
					"LID" => WIZARD_SITE_ID
			) );
			if( $arPerson = $dbPerson->Fetch() )
			{
				$personType = $arPerson["ID"];
			}
		}
		if( IntVal( $arGeneralInfo["paySystem"]["cash"][$personType] ) > 0 )
			$paySystem = $arGeneralInfo["paySystem"]["cash"][$personType];
		elseif( IntVal( $arGeneralInfo["paySystem"]["bill"][$personType] ) > 0 )
			$paySystem = $arGeneralInfo["paySystem"]["bill"][$personType];
		elseif( IntVal( $arGeneralInfo["paySystem"]["bill"][$personType] ) > 0 )
			$paySystem = $arGeneralInfo["paySystem"]["sber"][$personType];
		elseif( IntVal( $arGeneralInfo["paySystem"]["paypal"][$personType] ) > 0 )
			$paySystem = $arGeneralInfo["paySystem"]["paypal"][$personType];
		else
		{
			$dbPS = CSalePaySystem::GetList( Array(), Array(
					"LID" => WIZARD_SITE_ID
			) );
			if( $arPS = $dbPS->Fetch() )
				$paySystem = $arPS["ID"];
		}

		if($module == 'sotbit.b2bshop')
		{
			$dbRes = \Bitrix\Sale\PaySystem\Manager::getList( array(
					'filter' => ['ACTION_FILE' => 'billsotbit']
			) );
			if($arPS = $dbRes->Fetch() )
			{
				$paySystem2 = $arPS["ID"];
			}
		}
		
		
		if( \Bitrix\Main\Config\Option::get( 'sale', 'sale_locationpro_migrated', '' ) == 'Y' )
		{
			if( !strlen( $location ) )
			{
				// get first found
				$item = \Bitrix\Sale\Location\LocationTable::getList( array(
						'limit' => 1,
						'select' => array(
								'CODE'
						)
				) )->fetch();
				if( $item )
					$location = $item['CODE'];
			}
		}
		else
		{
			if( IntVal( $location ) <= 0 )
			{
				$dbLocation = CSaleLocation::GetList( Array(
						"ID" => "ASC"
				), Array(
						"LID" => $lang
				) );
				if( $arLocation = $dbLocation->Fetch() )
				{
					$location = $arLocation["ID"];
				}
			}
		}

		if( empty( $arGeneralInfo["properies"][$personType] ) )
		{
			$dbProp = CSaleOrderProps::GetList( array(), Array(
					"PERSON_TYPE_ID" => $personType
			) );
			while ( $arProp = $dbProp->Fetch() )
				$arGeneralInfo["properies"][$personType][$arProp["CODE"]] = $arProp;
		}

		$LeaveOrders = $wizard->GetVar( "LEAVE_ORDERS" );

		if( $LeaveOrders != 'Y' )
		{

			$db_sales = CSaleOrder::GetList( array(
					"DATE_INSERT" => "ASC"
			), array(
					"LID" => WIZARD_SITE_ID
			), false, false, array(
					"ID"
			) );
			while ( $ar_sales = $db_sales->Fetch() )
			{
				CSaleOrder::Delete( $ar_sales["ID"] );
			}
		}

		$arData = Array(
				"SITE_ID" => WIZARD_SITE_ID,
				"PERSON_TYPE_ID" => $personType,
				"CURRENCY" => $defCurrency,
				"USER_ID" => 1,
				"PAY_SYSTEM_ID" => $paySystem,
				// "PRICE_DELIVERY" => "0",
				// "DELIVERY_ID" => "",
				"PROPS" => Array()
		);
		foreach( $arGeneralInfo["properies"][$personType] as $key => $val )
		{
			$arProp = Array(
					"ID" => $val["ID"],
					"NAME" => $val["NAME"],
					"CODE" => $val["CODE"],
					"VALUE" => ""
			);

			if( $key == "FIO" || $key == "CONTACT_PERSON" )
				$arProp["VALUE"] = GetMessage( "WIZ_ORD_FIO" );
			elseif( $key == "ADDRESS" || $key == "COMPANY_ADR" )
				$arProp["VALUE"] = GetMessage( "WIZ_ORD_ADR" );
			elseif( $key == "EMAIL" )
				$arProp["VALUE"] = "example@example.com";
			elseif( $key == "PHONE" )
				$arProp["VALUE"] = "8 495 2312121";
			elseif( $key == "ZIP" )
				$arProp["VALUE"] = "101000";
			elseif( $key == "LOCATION" )
				$arProp["VALUE"] = $location;
			elseif( $key == "CITY" )
				$arProp["VALUE"] = $shopLocation;
			$arData["PROPS"][] = $arProp;
		}
		$orderID = __MakeOrder( 3, $arData );
		CSaleOrder::DeliverOrder( $orderID, "Y" );
		CSaleOrder::PayOrder( $orderID, "Y" );
		CSaleOrder::StatusOrder( $orderID, "F" );
		$orderID = __MakeOrder( 4, $arData );
		CSaleOrder::DeliverOrder( $orderID, "Y" );
		CSaleOrder::PayOrder( $orderID, "Y" );
		CSaleOrder::StatusOrder( $orderID, "F" );
		$orderID = __MakeOrder( 2, $arData );
		CSaleOrder::PayOrder( $orderID, "Y" );
		CSaleOrder::StatusOrder( $orderID, "P" );
		$orderID = __MakeOrder( 1, $arData );
		$orderID = __MakeOrder( 3, $arData );
		CSaleOrder::CancelOrder( $orderID, "Y" );
		if($module == 'sotbit.b2bshop')
		{
			$arData['PAY_SYSTEM_ID'] = ($paySystem2)?$paySystem2:$paySystem;
			$orderID = __MakeOrder( 10, $arData );
		}
		CAgent::RemoveAgent( "CSaleProduct::RefreshProductList();", "sale" );
		CAgent::AddAgent( "CSaleProduct::RefreshProductList();", "sale", "N", 60 * 60 * 24 * 4, "", "Y" );
	}
}
return true;
?>