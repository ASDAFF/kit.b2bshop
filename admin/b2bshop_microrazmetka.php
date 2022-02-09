<?
use Bitrix\Main\Localization\Loc;
require_once ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
Loc::loadMessages( __FILE__ );

if( $APPLICATION->GetGroupRight( "main" ) < "R" )
{
	$APPLICATION->AuthForm( Loc::getMessage( "ACCESS_DENIED" ) );
}

$module_id = "kit.b2bshop";

require_once ($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $module_id . '/classes/CModuleOptions.php');
require_once ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/" . $module_id . "/include.php");

if( !\Bitrix\Main\Loader::includeModule( 'iblock' ) )
{
	return;
}
$boolCatalog = \Bitrix\Main\Loader::includeModule( 'catalog' );

if( $REQUEST_METHOD == "POST" && strlen( $RestoreDefaults ) > 0 && check_bitrix_sessid() )
{
	COption::RemoveOption( $module_id );
	$z = CGroup::GetList( $v1 = "id", $v2 = "asc", array(
			"ACTIVE" => "Y",
			"ADMIN" => "N" 
	) );
	while ( $zr = $z->Fetch() )
		$APPLICATION->DelGroupRight( $module_id, array(
				$zr["ID"] 
		) );
	
	if( (strlen( $Apply ) > 0) || (strlen( $RestoreDefaults ) > 0) )
		LocalRedirect( 
				$APPLICATION->GetCurPage() . "?lang=" . LANGUAGE_ID . "&mid=" . urlencode( $mid ) . "&tabControl_active_tab=" . urlencode( $_REQUEST["tabControl_active_tab"] ) . "&back_url_settings=" . urlencode( 
						$_REQUEST["back_url_settings"] ) );
	else
		LocalRedirect( $_REQUEST["back_url_settings"] );
}

$arTabs = array(
		array(
				'DIV' => 'edit1',
				'TAB' => Loc::getMessage( $module_id . '_edit1' ),
				'ICON' => '',
				'TITLE' => Loc::getMessage( $module_id . '_edit1' ),
				'SORT' => '10' 
		),
		array(
				'DIV' => 'edit3',
				'TAB' => Loc::getMessage( $module_id . '_edit3' ),
				'ICON' => '',
				'TITLE' => Loc::getMessage( $module_id . '_edit3' ),
				'SORT' => '30' 
		),
		array(
				'DIV' => 'edit4',
				'TAB' => Loc::getMessage( $module_id . '_edit4' ),
				'ICON' => '',
				'TITLE' => Loc::getMessage( $module_id . '_edit4' ),
				'SORT' => '40' 
		) 
);

$arTypes1["REFERENCE_ID"] = array(
		"Organization",
		"Place" 
);
$arTypes1["REFERENCE"] = array(
		Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_ORGANIZATION' ),
		Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_PLACE' ) 
);

if( isset( $_REQUEST["MICRO_ORGANIZATION_TYPE1"] ) && $_REQUEST["MICRO_ORGANIZATION_TYPE1"] )
	$arCurrentValues["MICRO_ORGANIZATION_TYPE1"] = $_REQUEST["MICRO_ORGANIZATION_TYPE1"];
else
	$arCurrentValues["MICRO_ORGANIZATION_TYPE1"] = COption::GetOptionString( $module_id, 'MICRO_ORGANIZATION_TYPE1', '' );
if( isset( $_REQUEST["MICRO_ORGANIZATION_TYPE2"] ) && $_REQUEST["MICRO_ORGANIZATION_TYPE2"] )
	$arCurrentValues["MICRO_ORGANIZATION_TYPE2"] = $_REQUEST["MICRO_ORGANIZATION_TYPE2"];
else
	$arCurrentValues["MICRO_ORGANIZATION_TYPE2"] = COption::GetOptionString( $module_id, 'MICRO_ORGANIZATION_TYPE2', '' );
if( isset( $_REQUEST["MICRO_ORGANIZATION_TYPE3"] ) && $_REQUEST["MICRO_ORGANIZATION_TYPE3"] )
	$arCurrentValues["MICRO_ORGANIZATION_TYPE3"] = $_REQUEST["MICRO_ORGANIZATION_TYPE3"];
else
	$arCurrentValues["MICRO_ORGANIZATION_TYPE3"] = COption::GetOptionString( $module_id, 'MICRO_ORGANIZATION_TYPE3', '' );
if( isset( $_REQUEST["MICRO_ARTICLE_TYPE"] ) && $_REQUEST["MICRO_ARTICLE_TYPE"] )
	$arCurrentValues["MICRO_ARTICLE_TYPE"] = $_REQUEST["MICRO_ARTICLE_TYPE"];
else
	$arCurrentValues["MICRO_ARTICLE_TYPE"] = COption::GetOptionString( $module_id, 'MICRO_ARTICLE_TYPE', '' );
if( isset( $_REQUEST["MICRO_ARTICLE_AUTHOR"] ) && $_REQUEST["MICRO_ARTICLE_AUTHOR"] )
	$arCurrentValues["MICRO_ARTICLE_AUTHOR"] = $_REQUEST["MICRO_ARTICLE_AUTHOR"];
else
	$arCurrentValues["MICRO_ARTICLE_AUTHOR"] = COption::GetOptionString( $module_id, 'MICRO_ARTICLE_AUTHOR', '' );

if( $arCurrentValues["MICRO_ORGANIZATION_TYPE1"] )
{
	switch ($arCurrentValues["MICRO_ORGANIZATION_TYPE1"])
	{
		case 'Organization' :
			$arTypes2["REFERENCE_ID"] = array(
					'',
					'EducationalOrganization',
					'LocalBusiness',
					'PerformingGroup',
					'Airline',
					'Corporation',
					'GovernmentOrganization',
					'NGO',
					'SportsOrganization' 
			);
			$arTypes2["REFERENCE"] = array(
					'-',
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_EducationalOrganization' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_LocalBusiness' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_PerformingGroup' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Airline' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Corporation' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_GovernmentOrganization' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_NGO' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_SportsOrganization' ) 
			);
			break;
		case 'Place' :
			$arTypes2["REFERENCE_ID"] = array(
					'',
					'LocalBusiness',
					'CivicStructure',
					'AdministrativeArea',
					'Landform',
					'Residence',
					'LandmarksOrHistoricalBuildings',
					'TouristAttraction' 
			);
			$arTypes2["REFERENCE"] = array(
					'-',
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_LocalBusiness' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_CivicStructure' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_AdministrativeArea' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Landform' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Residence' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_LandmarksOrHistoricalBuildings' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_TouristAttraction' ) 
			);
			break;
		default :
			$arTypes2["REFERENCE_ID"] = array(
					'' 
			);
			$arTypes2["REFERENCE"] = array(
					'-' 
			);
			break;
	}
}

if( $arCurrentValues["MICRO_ORGANIZATION_TYPE2"] )
{
	switch ($arCurrentValues["MICRO_ORGANIZATION_TYPE2"])
	{
		case 'EducationalOrganization' :
			$arTypes3["REFERENCE_ID"] = array(
					'',
					'CollegeOrUniversity',
					'HighSchool',
					'MiddleSchool',
					'ElementarySchool',
					'Preschool',
					'School' 
			);
			$arTypes3["REFERENCE"] = array(
					'-',
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_CollegeOrUniversity' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_HighSchool' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_MiddleSchool' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_ElementarySchool' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Preschool' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_School' ) 
			);
			break;
		case 'LocalBusiness' :
			$arTypes3["REFERENCE_ID"] = array(
					'',
					'AnimalShelter',
					'AutomotiveBusiness',
					'ChildCare',
					'DryCleaningOrLaundry',
					'EmergencyService',
					'EmploymentAgency',
					'EntertainmentBusiness',
					'FinancialService',
					'FoodEstablishment',
					'GovernmentOffice',
					'HealthAndBeautyBusiness',
					'HomeAndConstructionBusiness',
					'InternetCafe',
					'Library',
					'LodgingBusiness',
					'MedicalOrganization',
					'ProfessionalService',
					'RadioStation',
					'RealEstateAgent',
					'RecyclingCenter',
					'SelfStorage',
					'ShoppingCenter',
					'Store',
					'SportsActivityLocation',
					'TelevisionStation',
					'TouristInformationCenter',
					'TravelAgency' 
			);
			$arTypes3["REFERENCE"] = array(
					'-',
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_AnimalShelter' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_AutomotiveBusiness' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_ChildCare' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_DryCleaningOrLaundry' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_EmergencyService' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_EmploymentAgency' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_EntertainmentBusiness' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_FinancialService' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_FoodEstablishment' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_GovernmentOffice' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_HealthAndBeautyBusiness' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_HomeAndConstructionBusiness' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_InternetCafe' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Library' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_LodgingBusiness' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_MedicalOrganization' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_ProfessionalService' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_RadioStation' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_RealEstateAgent' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_RecyclingCenter' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_SelfStorage' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_ShoppingCenter' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Store' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_SportsActivityLocation' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_TelevisionStation' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_TouristInformationCenter' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_TravelAgency' ) 
			);
			break;
		case 'PerformingGroup' :
			$arTypes3["REFERENCE_ID"] = array(
					'',
					'DanceGroup',
					'MusicGroup',
					'TheaterGroup' 
			);
			$arTypes3["REFERENCE"] = array(
					'-',
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_DanceGroup' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_MusicGroup' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_TheaterGroup' ) 
			);
			break;
		case 'SportsOrganization' :
			$arTypes3["REFERENCE_ID"] = array(
					'',
					'SportsTeam' 
			);
			$arTypes3["REFERENCE"] = array(
					'-',
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_SportsTeam' ) 
			);
			break;
		case 'CivicStructure' :
			$arTypes3["REFERENCE_ID"] = array(
					'',
					'Airport',
					'Aquarium',
					'Beach',
					'BusStation',
					'BusStop',
					'Campground',
					'Cemetery',
					'Crematorium',
					'EventVenue',
					'FireStation',
					'GovernmentBuilding',
					'Hospital',
					'MovieTheater',
					'Museum',
					'MusicVenue',
					'Park',
					'ParkingFacility',
					'PerformingArtsTheater',
					'PlaceOfWorship',
					'Playground',
					'PoliceStation',
					'RVPark',
					'StadiumOrArena',
					'SubwayStation',
					'TaxiStand',
					'TrainStation',
					'Zoo' 
			);
			$arTypes3["REFERENCE"] = array(
					'-',
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Airport' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Aquarium' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Beach' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_BusStation' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_BusStop' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Campground' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Cemetery' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Crematorium' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_EventVenue' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_FireStation' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_GovernmentBuilding' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Hospital' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_MovieTheater' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Museum' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_MusicVenue' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Park' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_ParkingFacility' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_PerformingArtsTheater' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_PlaceOfWorship' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Playground' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_PoliceStation' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_RVPark' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_StadiumOrArena' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_SubwayStation' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_TaxiStand' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_TrainStation' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Zoo' ) 
			);
			break;
		case 'AdministrativeArea' :
			$arTypes3["REFERENCE_ID"] = array(
					'',
					'City',
					'State',
					'Country' 
			);
			$arTypes3["REFERENCE"] = array(
					'-',
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_City' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_State' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Country' ) 
			);
			break;
		case 'Landform' :
			$arTypes3["REFERENCE_ID"] = array(
					'',
					'BodyOfWater',
					'Continent',
					'Mountain',
					'Volcano' 
			);
			$arTypes3["REFERENCE"] = array(
					'-',
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_BodyOfWater' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Continent' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Mountain' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Volcano' ) 
			);
			break;
		case 'Residence' :
			$arTypes3["REFERENCE_ID"] = array(
					'',
					'ApartmentComplex',
					'GatedResidenceCommunity',
					'SingleFamilyResidence' 
			);
			$arTypes3["REFERENCE"] = array(
					'-',
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_ApartmentComplex' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_GatedResidenceCommunity' ),
					Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_SingleFamilyResidence' ) 
			);
			break;
		default :
			$arTypes3["REFERENCE_ID"] = array(
					'' 
			);
			$arTypes3["REFERENCE"] = array(
					'-' 
			);
			break;
	}
}

$priceCurrencies["REFERENCE_ID"] = array(
		'USD',
		'EUR',
		'RUB',
		'UAH' 
);
$priceCurrencies["REFERENCE"] = array(
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PRICE_CURRENCY_USD' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PRICE_CURRENCY_EUR' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PRICE_CURRENCY_RUB' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PRICE_CURRENCY_UAH' ) 
);

$tovarAvailability["REFERENCE_ID"] = array(
		'InStock',
		'LimitedAvailability',
		'OnlineOnly',
		'PreOrder',
		'InStoreOnly',
		'SoldOut',
		'OutOfStock',
		'Discontinued' 
);
$tovarAvailability["REFERENCE"] = array(
		Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_AVAILABILITY_InStock' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_AVAILABILITY_LimitedAvailability' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_AVAILABILITY_OnlineOnly' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_AVAILABILITY_PreOrder' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_AVAILABILITY_InStoreOnly' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_AVAILABILITY_SoldOut' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_AVAILABILITY_OutOfStock' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_AVAILABILITY_Discontinued' ) 
);

$tovarCondition["REFERENCE_ID"] = array(
		'NewCondition',
		'UsedCondition',
		'DamagedCondition',
		'RefurbishedCondition' 
);
$tovarCondition["REFERENCE"] = array(
		Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_CONDITION_NewCondition' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_CONDITION_UsedCondition' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_CONDITION_DamagedCondition' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_CONDITION_RefurbishedCondition' ) 
);

$tovarPayment["REFERENCE_ID"] = array(
		'VISA',
		'MasterCard',
		'AmericanExpress',
		'ByBankTransferInAdvance',
		'ByInvoice',
		'Cash',
		'CheckInAdvance',
		'COD',
		'DirectDebit',
		'GoogleCheckout',
		'PayPal',
		'PaySwarm' 
);
$tovarPayment["REFERENCE"] = array(
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PAYMENT_METHOD_VISA' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PAYMENT_METHOD_MasterCard' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PAYMENT_METHOD_AmericanExpress' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PAYMENT_METHOD_ByBankTransferInAdvance' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PAYMENT_METHOD_ByInvoice' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PAYMENT_METHOD_Cash' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PAYMENT_METHOD_CheckInAdvance' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PAYMENT_METHOD_COD' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PAYMENT_METHOD_DirectDebit' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PAYMENT_METHOD_GoogleCheckout' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PAYMENT_METHOD_PayPal' ),
		Loc::getMessage( $module_id . '_MICRO_TOVAR_PAYMENT_METHOD_PaySwarm' ) 
);

$articleType["REFERENCE_ID"] = array(
		'',
		'BlogPosting',
		'NewsArticle',
		'ScholarlyArticle',
		'MedicalScholarlyArticle' 
);
$articleType["REFERENCE"] = array(
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_TYPE_Statia' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_TYPE_BlogPosting' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_TYPE_NewsArticle' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_TYPE_ScholarlyArticle' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_TYPE_MedicalScholarlyArticle' ) 
);

$articleMaterial["REFERENCE_ID"] = array(
		'',
		'AcademicThesis',
		'BookReport',
		'Coursework',
		'Dissertation',
		'Examination',
		'StudentEssay',
		'StudentLaboratoryWork',
		'StudentReport',
		'StudentSummary' 
);
$articleMaterial["REFERENCE"] = array(
		'-',
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_MATERIAL_AcademicThesis' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_MATERIAL_BookReport' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_MATERIAL_Coursework' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_MATERIAL_Dissertation' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_MATERIAL_Examination' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_MATERIAL_StudentEssay' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_MATERIAL_StudentLaboratoryWork' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_MATERIAL_StudentReport' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_MATERIAL_StudentSummary' ) 
);

$articleLanguage["REFERENCE_ID"] = array(
		'',
		'ru',
		'en',
		'fr',
		'de',
		'es' 
);
$articleLanguage["REFERENCE"] = array(
		'-',
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_LANGUAGE_ru' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_LANGUAGE_en' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_LANGUAGE_fr' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_LANGUAGE_de' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_LANGUAGE_es' ) 
);

$articleAuthor["REFERENCE_ID"] = array(
		'',
		'Text',
		'Person',
		'Organization' 
);
$articleAuthor["REFERENCE"] = array(
		'-',
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_AUTHOR_Text' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_AUTHOR_Person' ),
		Loc::getMessage( $module_id . '_MICRO_ARTICLE_AUTHOR_Organization' ) 
);
// ������ ����� ����� � �����
$arGroups = array(
		'GROUP_ORGANIZATION_CONTACTS' => array(
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_GROUP_ORGANIZATION_CONTACTS' ),
				'TAB' => 0 
		),
		'GROUP_ORGANIZATION_ADDRESS' => array(
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_GROUP_ORGANIZATION_ADDRESS' ),
				'TAB' => 0 
		),
		'GROUP_ORGANIZATION_LOGO' => array(
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_GROUP_ORGANIZATION_LOGO' ),
				'TAB' => 0 
		),
		'GROUP_ORGANIZATION_ADDPARAMS' => array(
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_GROUP_ORGANIZATION_ADDPARAMS' ),
				'TAB' => 0 
		),
		'GROUP_TOVAR_MAINPARAMS' => array(
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_GROUP_TOVAR_MAINPARAMS' ),
				'TAB' => 2 
		),
		'GROUP_TOVAR_PREDLOGENIE' => array(
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_GROUP_TOVAR_PREDLOGENIE' ),
				'TAB' => 2 
		),
		'GROUP_TOVAR_AGGREGATEOFFER' => array(
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_GROUP_TOVAR_AGGREGATEOFFER' ),
				'TAB' => 2 
		),
		'GROUP_TOVAR_ADDPARAMS' => array(
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_GROUP_TOVAR_ADDPARAMS' ),
				'TAB' => 2 
		),
		'GROUP_ARTICLE_MAINPARAMS' => array(
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_GROUP_ARTICLE_MAINPARAMS' ),
				'TAB' => 3 
		),
		'GROUP_ARTICLE_ADDPARAMS' => array(
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_GROUP_ARTICLE_ADDPARAMS' ),
				'TAB' => 3 
		),
		'GROUP_ARTICLE_TYPE' => array(
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_GROUP_ARTICLE_TYPE' ),
				'TAB' => 3 
		),
		'GROUP_ARTICLE_PERSON' => array(
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_GROUP_ARTICLE_PERSON' ),
				'TAB' => 3 
		) 
);

// ����
$arOptions = array(
		'MICRO_ORGANIZATION_NAME' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_NAME' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '10' 
		),
		'MICRO_ORGANIZATION_TYPE1' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_TYPE1' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'Y',
				'VALUES' => $arTypes1,
				'SORT' => '20' 
		),
		'MICRO_ORGANIZATION_TYPE2' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_TYPE2' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'Y',
				'VALUES' => $arTypes2,
				'SORT' => '30' 
		),
		'MICRO_ORGANIZATION_TYPE3' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_TYPE3' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'N',
				'VALUES' => $arTypes3,
				'SORT' => '40' 
		),
		'MICRO_ORGANIZATION_DESCRIPTION' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_DESCRIPTION' ),
				'TYPE' => 'TEXT',
				'REFRESH' => 'N',
				'SORT' => '50' 
		),
		'MICRO_ORGANIZATION_FAX' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_FAX' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '60' 
		),
		'MICRO_ORGANIZATION_PHONE' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_PHONE' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'MULTI' => 'Y',
				'SIZE' => '60',
				'SORT' => '70' 
		),
		'MICRO_ORGANIZATION_EMAIL' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_EMAIL' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'MULTI' => 'Y',
				'SIZE' => '60',
				'SORT' => '80' 
		),
		'MICRO_ORGANIZATION_SITE' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_SITE' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '90' 
		),
		'MICRO_ORGANIZATION_TAXID' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_TAXID' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '100' 
		),
		'MICRO_ORGANIZATION_STRANA' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_STRANA' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '110' 
		),
		'MICRO_ORGANIZATION_REGION' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_REGION' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '120' 
		),
		'MICRO_ORGANIZATION_CITY' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_CITY' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '130' 
		),
		'MICRO_ORGANIZATION_ADDRESS' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_ADDRESS' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '140' 
		),
		'MICRO_ORGANIZATION_POSTCODE' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_POSTCODE' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '150' 
		),
		'MICRO_ORGANIZATION_IMAGE' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_IMAGE' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '160' 
		),
		'MICRO_ORGANIZATION_PRICE_RANGE' => array(
				'GROUP' => 'GROUP_ORGANIZATION_CONTACTS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_PRICE_RANGE' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '170' 
		),
		'MICRO_ORGANIZATION_LOGO' => array(
				'GROUP' => 'GROUP_ORGANIZATION_LOGO',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_LOGO' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '10' 
		),
		'MICRO_ORGANIZATION_LOGO_NAME' => array(
				'GROUP' => 'GROUP_ORGANIZATION_LOGO',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_LOGO_NAME' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '20' 
		),
		'MICRO_ORGANIZATION_LOGO_WIDTH' => array(
				'GROUP' => 'GROUP_ORGANIZATION_LOGO',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_LOGO_WIDTH' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '30' 
		),
		'MICRO_ORGANIZATION_LOGO_HEIGHT' => array(
				'GROUP' => 'GROUP_ORGANIZATION_LOGO',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_LOGO_HEIGHT' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '40' 
		),
		'MICRO_ORGANIZATION_LOGO_CAPTION' => array(
				'GROUP' => 'GROUP_ORGANIZATION_LOGO',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_LOGO_CAPTION' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '50' 
		),
		'MICRO_ORGANIZATION_LOGO_DESCRIPTION' => array(
				'GROUP' => 'GROUP_ORGANIZATION_LOGO',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_LOGO_DESCRIPTION' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '60' 
		),
		'MICRO_ORGANIZATION_LOGO_THUMBNAIL_CONTENT_URL' => array(
				'GROUP' => 'GROUP_ORGANIZATION_LOGO',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_LOGO_THUMBNAIL_CONTENT_URL' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '70' 
		),
		'MICRO_TOVAR_NAME' => array(
				'GROUP' => 'GROUP_TOVAR_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_TOVAR_NAME' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'DEFAULT' => '#NAME#',
				'SORT' => '10' 
		),
		'MICRO_TOVAR_DESCRIPTION' => array(
				'GROUP' => 'GROUP_TOVAR_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_TOVAR_DESCRIPTION' ),
				'TYPE' => 'TEXT',
				'REFRESH' => 'N',
				'DEFAULT' => '#IPROPERTY_VALUES||ELEMENT_META_DESCRIPTION#',
				'SORT' => '20' 
		),
		'MICRO_TOVAR_PRICE' => array(
				'GROUP' => 'GROUP_TOVAR_PREDLOGENIE',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_TOVAR_PRICE' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'DEFAULT' => '#PRICES||BASE||VALUE#',
				'SORT' => '30' 
		),
		'MICRO_TOVAR_PRICE_CURRENCY' => array(
				'GROUP' => 'GROUP_TOVAR_PREDLOGENIE',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_TOVAR_PRICE_CURRENCY' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'DEFAULT' => '#CONVERT_CURRENCY||CURRENCY_ID#',
				'SORT' => '40' 
		),
		'MICRO_TOVAR_ITEM_AVAILABILITY_TRUE' => array(
				'GROUP' => 'GROUP_TOVAR_PREDLOGENIE',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_AVAILABILITY_TRUE' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'N',
				'VALUES' => $tovarAvailability,
				'SORT' => '50' 
		),
		'MICRO_TOVAR_ITEM_AVAILABILITY_FALSE' => array(
				'GROUP' => 'GROUP_TOVAR_PREDLOGENIE',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_AVAILABILITY_FALSE' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'N',
				'VALUES' => $tovarAvailability,
				'SORT' => '60' 
		),
		'MICRO_TOVAR_ITEM_CONDITION' => array(
				'GROUP' => 'GROUP_TOVAR_PREDLOGENIE',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_TOVAR_ITEM_CONDITION' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'N',
				'VALUES' => $tovarCondition,
				'SORT' => '70' 
		),
		'MICRO_TOVAR_PAYMENT_METHOD' => array(
				'GROUP' => 'GROUP_TOVAR_PREDLOGENIE',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_TOVAR_PAYMENT_METHOD' ),
				'TYPE' => 'MSELECT',
				'REFRESH' => 'N',
				'VALUES' => $tovarPayment,
				'NOTES' => Loc::getMessage( 'kit_ms_help_tovars' ),
				'SORT' => '80' 
		),
		'MICRO_ARTICLE_NAME' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_NAME' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'DEFAULT' => '#NAME#',
				'SIZE' => '60',
				'SORT' => '10' 
		),
		'MICRO_ARTICLE_DESCRIPTION' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_DESCRIPTION' ),
				'TYPE' => 'TEXT',
				'REFRESH' => 'N',
				'DEFAULT' => '#PREVIEW_TEXT#',
				'SORT' => '20' 
		),
		'MICRO_ARTICLE_KRATKOE_OPISANIE' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_KRATKOE_OPISANIE' ),
				'TYPE' => 'TEXT',
				'REFRESH' => 'N',
				'SORT' => '30' 
		),
		'MICRO_ARTICLE_TYPE' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_TYPE' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'Y',
				'VALUES' => $articleType,
				'SORT' => '40' 
		),
		'MICRO_ARTICLE_MATERIAL' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_MATERIAL' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'N',
				'VALUES' => $articleMaterial,
				'SORT' => '50' 
		),
		'MICRO_ARTICLE_GANR' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_GANR' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'SIZE' => '60',
				'SORT' => '60' 
		),
		'MICRO_ARTICLE_RUBRIKA' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_RUBRIKA' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'MULTI' => 'Y',
				'SIZE' => '60',
				'SORT' => '70' 
		),
		'MICRO_ARTICLE_KEYWORDS' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_KEYWORDS' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'DEFAULT' => '#IPROPERTY_VALUES||ELEMENT_META_KEYWORDS#',
				'SIZE' => '60',
				'SORT' => '80' 
		),
		'MICRO_ARTICLE_LANGUAGE' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_LANGUAGE' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'N',
				'VALUES' => $articleLanguage,
				'SORT' => '90' 
		),
		'MICRO_ARTICLE_IMAGE' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_IMAGE' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'DEFAULT' => '#DETAIL_PICTURE||RESIZE||SRC#',
				'SIZE' => '60',
				'SORT' => '100' 
		),
		'MICRO_ARTICLE_IMAGE_CAPTION' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_IMAGE_CAPTION' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'DEFAULT' => '#DETAIL_PICTURE||RESIZE||ALT#',
				'SIZE' => '60',
				'SORT' => '110' 
		),
		'MICRO_ARTICLE_IMAGE_NAME' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_IMAGE_NAME' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'DEFAULT' => '#DETAIL_PICTURE||RESIZE||TITLE#',
				'SIZE' => '60',
				'SORT' => '120' 
		),
		'MICRO_ARTICLE_IMAGE_DESCRIPTION' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_IMAGE_DESCRIPTION' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'DEFAULT' => '#DETAIL_PICTURE||DESCRIPTION#',
				'SIZE' => '60',
				'SORT' => '130' 
		),
		'MICRO_ARTICLE_IMAGE_HEIGHT' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_IMAGE_HEIGHT' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'DEFAULT' => '#DETAIL_PICTURE||RESIZE||HEIGHT#',
				'SIZE' => '60',
				'SORT' => '140' 
		),
		'MICRO_ARTICLE_IMAGE_WIDTH' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_IMAGE_WIDTH' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'DEFAULT' => '#DETAIL_PICTURE||RESIZE||WIDTH#',
				'SIZE' => '60',
				'SORT' => '150' 
		),
		'MICRO_ARTICLE_IMAGE_TRUMBNAIL_CONTENTURL' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_IMAGE_TRUMBNAIL_CONTENTURL' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'DEFAULT' => '',
				'SIZE' => '60',
				'SORT' => '160' 
		),
		'MICRO_CANON_URL' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_CANON_URL' ),
				'TYPE' => 'STRING',
				'REFRESH' => 'N',
				'DEFAULT' => '#DISPLAY_PROPERTIES||FIRST||VALUE#',
				'SIZE' => '60',
				'SORT' => '170' 
		),
		'MICRO_ARTICLE_AUTHOR' => array(
				'GROUP' => 'GROUP_ARTICLE_MAINPARAMS',
				'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_AUTHOR' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'Y',
				'VALUES' => $articleAuthor,
				'NOTES' => Loc::getMessage( 'kit_ms_help_articles' ),
				'SORT' => '180' 
		) 
);

if( $arCurrentValues["MICRO_ARTICLE_TYPE"] == "ScholarlyArticle" || $arCurrentValues["MICRO_ARTICLE_TYPE"] == "MedicalScholarlyArticle" )
{
	$articleSource["REFERENCE_ID"] = array(
			'SOURCE_TYPE_URL',
			'SOURCE_TYPE_TEXT' 
	);
	$articleSource["REFERENCE"] = array(
			Loc::getMessage( $module_id . '_MICRO_ARTICLE_TYPE_SOURCE_URL' ),
			Loc::getMessage( $module_id . '_MICRO_ARTICLE_TYPE_SOURCE_TEXT' ) 
	);
	$arOptions2 = array(
			'MICRO_ARTICLE_TYPE_SOURCE' => array(
					'GROUP' => 'GROUP_ARTICLE_TYPE',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_TYPE_SOURCE' ),
					'TYPE' => 'SELECT',
					'SORT' => '10',
					'VALUES' => $articleSource 
			),
			'MICRO_ARTICLE_TYPE_URL_ORIG' => array(
					'GROUP' => 'GROUP_ARTICLE_TYPE',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_TYPE_URL_ORIG' ),
					'TYPE' => 'STRING',
					'SIZE' => '60',
					'SORT' => '20' 
			),
			'MICRO_ARTICLE_TYPE_TEXT_ORIG' => array(
					'GROUP' => 'GROUP_ARTICLE_TYPE',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_TYPE_TEXT_ORIG' ),
					'TYPE' => 'STRING',
					'SIZE' => '60',
					'SORT' => '30' 
			),
			'MICRO_ARTICLE_TYPE_URL_TEXT_ORIG_ONLINE' => array(
					'GROUP' => 'GROUP_ARTICLE_TYPE',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_TYPE_URL_TEXT_ORIG_ONLINE' ),
					'TYPE' => 'STRING',
					'MULTI' => 'Y',
					'SORT' => '40' 
			),
			'MICRO_ARTICLE_TYPE_URL_TEXT_ORIG_OFFLINE' => array(
					'GROUP' => 'GROUP_ARTICLE_TYPE',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_ARTICLE_TYPE_URL_TEXT_ORIG_OFFLINE' ),
					'TYPE' => 'STRING',
					'MULTI' => 'Y',
					'SIZE' => '60',
					'SORT' => '50' 
			) 
	);
	$arOptions = array_merge( $arOptions, $arOptions2 );
}

if( $arCurrentValues["MICRO_ARTICLE_AUTHOR"] == "Text" )
{
	$arOptions2 = array(
			'MICRO_PERSON_TEXT' => array(
					'GROUP' => 'GROUP_ARTICLE_PERSON',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_PERSON_TEXT' ),
					'TYPE' => 'STRING',
					'SIZE' => '60',
					'SORT' => '10' 
			) 
	);
	$arOptions = array_merge( $arOptions, $arOptions2 );
}

if( $arCurrentValues["MICRO_ARTICLE_AUTHOR"] == "Person" )
{
	$arTypes["REFERENCE_ID"] = array(
			'',
			'CollegeOrUniversity',
			'HighSchool',
			'MiddleSchool',
			'ElementarySchool',
			'Preschool',
			'School' 
	);
	$arTypes["REFERENCE"] = array(
			'-',
			Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_CollegeOrUniversity' ),
			Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_HighSchool' ),
			Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_MiddleSchool' ),
			Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_ElementarySchool' ),
			Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_Preschool' ),
			Loc::getMessage( $module_id . '_MICRO_ORGANIZATION_School' ) 
	);
	$arOptions2 = array(
			'MICRO_PERSON_NAME' => array(
					'GROUP' => 'GROUP_ARTICLE_PERSON',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_PERSON_NAME' ),
					'TYPE' => 'STRING',
					'SIZE' => '60',
					'SORT' => '10' 
			),
			'MICRO_PERSON_OTCHESTVO' => array(
					'GROUP' => 'GROUP_ARTICLE_PERSON',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_PERSON_OTCHESTVO' ),
					'TYPE' => 'STRING',
					'SIZE' => '60',
					'SORT' => '20' 
			),
			'MICRO_PERSON_FAMILIYA' => array(
					'GROUP' => 'GROUP_ARTICLE_PERSON',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_PERSON_FAMILIYA' ),
					'TYPE' => 'STRING',
					'SIZE' => '60',
					'SORT' => '30' 
			),
			'MICRO_PERSON_DOLGNOST' => array(
					'GROUP' => 'GROUP_ARTICLE_PERSON',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_PERSON_DOLGNOST' ),
					'TYPE' => 'STRING',
					'SIZE' => '60',
					'SORT' => '40' 
			),
			'MICRO_PERSON_URL_PHOTO' => array(
					'GROUP' => 'GROUP_ARTICLE_PERSON',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_PERSON_URL_PHOTO' ),
					'TYPE' => 'STRING',
					'SIZE' => '60',
					'SORT' => '50' 
			),
			'MICRO_PERSON_URL_OF_STRANIC' => array(
					'GROUP' => 'GROUP_ARTICLE_PERSON',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_PERSON_URL_OF_STRANIC' ),
					'TYPE' => 'STRING',
					'SIZE' => '60',
					'MULTI' => 'Y',
					'SORT' => '60' 
			),
			'MICRO_PERSON_URL_STRANIC' => array(
					'GROUP' => 'GROUP_ARTICLE_PERSON',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_PERSON_URL_STRANIC' ),
					'TYPE' => 'STRING',
					'SIZE' => '60',
					'MULTI' => 'Y',
					'SORT' => '70' 
			),
			'MICRO_PERSON_PHONE' => array(
					'GROUP' => 'GROUP_ARTICLE_PERSON',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_PERSON_PHONE' ),
					'TYPE' => 'STRING',
					'SIZE' => '60',
					'MULTI' => 'Y',
					'SORT' => '80' 
			),
			'MICRO_PERSON_EMAIL' => array(
					'GROUP' => 'GROUP_ARTICLE_PERSON',
					'TITLE' => Loc::getMessage( $module_id . '_MICRO_PERSON_EMAIL' ),
					'TYPE' => 'STRING',
					'SIZE' => '60',
					'MULTI' => 'Y',
					'SORT' => '90' 
			) 
	);
	$arOptions = array_merge( $arOptions, $arOptions2 );
}
$RIGHT = $APPLICATION->GetGroupRight( $module_id );
if( $RIGHT != "D" )
{
	/*
	 * if($RIGHT >= "W") {
	 * $showRightsTab = true;
	 * }
	 */
	if( B2BSKit::getStatus() == 2 )
	:
		?>
<div class="adm-info-message-wrap adm-info-message-red">
	<div class="adm-info-message">
		<div class="adm-info-message-title"><?=Loc::getMessage("kit_ms_demo")?></div>

		<div class="adm-info-message-icon"></div>
	</div>
</div>
<?
			endif;
	
	?>
<div class="notes">
	<table cellspacing="0" cellpadding="0" border="0" class="notes">
		<tbody>
			<tr class="top">
				<td class="left"><div class="empty"></div></td>
				<td><div class="empty"></div></td>
				<td class="right"><div class="empty"></div></td>
			</tr>
			<tr>
				<td class="left"><div class="empty"></div></td>
				<td class="content">
					<?=Loc::getMessage("kit_ms_parameters")?>
						</td>
				<td class="right"><div class="empty"></div></td>
			</tr>
			<tr class="bottom">
				<td class="left"><div class="empty"></div></td>
				<td><div class="empty"></div></td>
				<td class="right"><div class="empty"></div></td>
			</tr>
		</tbody>
	</table>
</div>

<?
	$showRightsTab = false;
	$opt = new CModuleOptions( $module_id, $arTabs, $arGroups, $arOptions, $showRightsTab );
	$opt->ShowHTML();
}
if( $REQUEST_METHOD == "POST" && strlen( $save ) > 0 && check_bitrix_sessid() )
{
	if( isset( $_REQUEST["MAIN_PROPS"] ) || isset( $_REQUEST["DOP_PROPS"] ) )
	{
		if( !isset( $_REQUEST["MAIN_PROPS"] ) || !$_REQUEST["MAIN_PROPS"] )
			$_REQUEST["MAIN_PROPS"] = array();
		
		if( !isset( $_REQUEST["DOP_PROPS"] ) || !$_REQUEST["DOP_PROPS"] )
			$_REQUEST["DOP_PROPS"] = array();
		
		$_REQUEST["ALL_PROPS"] = array_merge( $_REQUEST["MAIN_PROPS"], $_REQUEST["DOP_PROPS"] );
		
		if( isset( $_REQUEST["ALL_PROPS"] ) && !empty( $_REQUEST["ALL_PROPS"] ) )
		{
			$allProps = serialize( $_REQUEST["ALL_PROPS"] );
			COption::SetOptionString( $module_id, "ALL_PROPS", $allProps );
		}
		
		if( $_REQUEST["MANUFACTURER_ELEMENT_PROPS"] && isset( $arDopProps ) && !empty( $arDopProps ) )
		{
			$brandIblockID = $arDopProps[$_REQUEST["MANUFACTURER_ELEMENT_PROPS"]]["LINK_IBLOCK_ID"];
			$res = CIBlock::GetByID( $brandIblockID );
			
			if( $ar_res = $res->GetNext() )
			{
				$brandIblockType = $ar_res["IBLOCK_TYPE_ID"];
			}
			if( $brandIblockID )
				COption::SetOptionString( $module_id, "BRAND_IBLOCK_ID", $brandIblockID );
			if( $brandIblockType )
				COption::SetOptionString( $module_id, "BRAND_IBLOCK_TYPE", $brandIblockType );
		}
		else
		{
			COption::SetOptionString( $module_id, "BRAND_IBLOCK_ID", "" );
			COption::SetOptionString( $module_id, "BRAND_IBLOCK_TYPE", "" );
		}
	}
	if( (strlen( $save ) > 0) || (strlen( $RestoreDefaults ) > 0) )
		LocalRedirect( 
				$APPLICATION->GetCurPage() . "?lang=" . LANGUAGE_ID . "&mid=" . urlencode( $mid ) . "&tabControl_active_tab=" . urlencode( $_REQUEST["tabControl_active_tab"] ) . "&back_url_settings=" . urlencode( 
						$_REQUEST["back_url_settings"] ) );
	else
		LocalRedirect( $_REQUEST["back_url_settings"] );
}
$APPLICATION->SetTitle( Loc::getMessage( $module_id . '_TITLE_MICRO_RAZMETKA' ) );
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>
