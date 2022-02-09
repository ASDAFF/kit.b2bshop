<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock") || !CModule::IncludeModule("catalog"))
	return;

if(COption::GetOptionString("sotbit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
	return;

//update iblocks, demo discount and precet
$shopLocalization = $wizard->GetVar("shopLocalization");


if ($_SESSION["WIZARD_CATALOG_IBLOCK_ID"])
{
	$IBLOCK_CATALOG_ID = $_SESSION["WIZARD_CATALOG_IBLOCK_ID"];
}
if ($_SESSION["WIZARD_OFFERS_IBLOCK_ID"])
{
	$IBLOCK_OFFERS_ID = $_SESSION["WIZARD_OFFERS_IBLOCK_ID"];
}


if ($IBLOCK_OFFERS_ID)
{
	$iblockCodeOffers = "b2bs_catalog-b2bshop_".WIZARD_SITE_ID.'#';
	//IBlock fields
	$iblock = new CIBlock;
	$arFields = Array(
		"ACTIVE" => "Y",
		"FIELDS" => array (
			'IBLOCK_SECTION' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'ACTIVE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'Y', ), 'ACTIVE_FROM' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'ACTIVE_TO' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'SORT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'NAME' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '', ),
			'PREVIEW_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'FROM_DETAIL' => 'N', 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, 'DELETE_WITH_DETAIL' => 'N', 'UPDATE_WITH_DETAIL' => 'N', ), ),
			'PREVIEW_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ), 'PREVIEW_TEXT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'DETAIL_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, ), ),
			'DETAIL_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ),
			'DETAIL_TEXT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'XML_ID' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'CODE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'UNIQUE' => 'Y', 'TRANSLITERATION' => 'Y', 'TRANS_LEN' => 100, 'TRANS_CASE' => 'L', 'TRANS_SPACE' => '_', 'TRANS_OTHER' => '_', 'TRANS_EAT' => 'Y', 'USE_GOOGLE' => 'Y', ), ),
			'TAGS' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'SECTION_NAME' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'SECTION_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'FROM_DETAIL' => 'N', 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, 'DELETE_WITH_DETAIL' => 'N', 'UPDATE_WITH_DETAIL' => 'N', ), ),
			'SECTION_DESCRIPTION_TYPE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => 'text', ),
			'SECTION_DESCRIPTION' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'SECTION_DETAIL_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, ), ),
			'SECTION_XML_ID' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'SECTION_CODE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'UNIQUE' => 'Y', 'TRANSLITERATION' => 'Y', 'TRANS_LEN' => 100, 'TRANS_CASE' => 'L', 'TRANS_SPACE' => '_', 'TRANS_OTHER' => '_', 'TRANS_EAT' => 'Y', 'USE_GOOGLE' => 'Y', ), ), ),
		"CODE" => "b2bs_catalog-b2bshop_".WIZARD_SITE_ID.'#',
		"XML_ID" => $iblockCodeOffers
	);
	$iblock->Update($IBLOCK_OFFERS_ID, $arFields);
}

if ($IBLOCK_CATALOG_ID)
{
	$iblockCode = "b2bs_catalog-b2bshop_".WIZARD_SITE_ID;
	//IBlock fields
	$iblock = new CIBlock;
	$arFields = Array(
		"ACTIVE" => "Y",
		"FIELDS" => array ('IBLOCK_SECTION' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '', ), 'ACTIVE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'Y', ), 'ACTIVE_FROM' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'ACTIVE_TO' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'SORT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'NAME' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '', ), 'PREVIEW_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'FROM_DETAIL' => 'N', 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, 'DELETE_WITH_DETAIL' => 'N', 'UPDATE_WITH_DETAIL' => 'N', ), ), 'PREVIEW_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ), 'PREVIEW_TEXT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'DETAIL_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, ), ), 'DETAIL_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ), 'DETAIL_TEXT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'XML_ID' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'CODE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => array ( 'UNIQUE' => 'Y', 'TRANSLITERATION' => 'Y', 'TRANS_LEN' => 100, 'TRANS_CASE' => 'L', 'TRANS_SPACE' => '_', 'TRANS_OTHER' => '_', 'TRANS_EAT' => 'Y', 'USE_GOOGLE' => 'Y', ), ), 'TAGS' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'SECTION_NAME' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '', ), 'SECTION_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'FROM_DETAIL' => 'N', 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, 'DELETE_WITH_DETAIL' => 'N', 'UPDATE_WITH_DETAIL' => 'N', ), ), 'SECTION_DESCRIPTION_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ), 'SECTION_DESCRIPTION' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'SECTION_DETAIL_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, ), ), 'SECTION_XML_ID' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'SECTION_CODE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => array ( 'UNIQUE' => 'Y', 'TRANSLITERATION' => 'Y', 'TRANS_LEN' => 100, 'TRANS_CASE' => 'L', 'TRANS_SPACE' => '_', 'TRANS_OTHER' => '_', 'TRANS_EAT' => 'Y', 'USE_GOOGLE' => 'Y', ), ), ),
        "CODE" => "b2bs_catalog-b2bshop_".WIZARD_SITE_ID,
		"XML_ID" => $iblockCode
	);
	$iblock->Update($IBLOCK_CATALOG_ID, $arFields);

	if ($IBLOCK_OFFERS_ID)
	{
		$ID_SKU = CCatalog::LinkSKUIBlock($IBLOCK_CATALOG_ID, $IBLOCK_OFFERS_ID);

		$rsCatalogs = CCatalog::GetList(
			array(),
			array('IBLOCK_ID' => $IBLOCK_OFFERS_ID),
			false,
			false,
			array('IBLOCK_ID')
		);
		if ($arCatalog = $rsCatalogs->Fetch())
		{
			CCatalog::Update($IBLOCK_OFFERS_ID,array('PRODUCT_IBLOCK_ID' => $IBLOCK_CATALOG_ID,'SKU_PROPERTY_ID' => $ID_SKU));
		}
		else
		{
			CCatalog::Add(array('IBLOCK_ID' => $IBLOCK_OFFERS_ID, 'PRODUCT_IBLOCK_ID' => $IBLOCK_CATALOG_ID, 'SKU_PROPERTY_ID' => $ID_SKU));
		}
	}


//demo discount
	$dbDiscount = CCatalogDiscount::GetList(array(), Array("SITE_ID" => WIZARD_SITE_ID));
	if(!($dbDiscount->Fetch()))
	{
		if (CModule::IncludeModule("iblock"))
		{
			$dbSect = CIBlockSection::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_CATALOG_ID, "CODE" => "vechernie_platya", "IBLOCK_SITE_ID" => WIZARD_SITE_ID));
			if ($arSect = $dbSect->Fetch())
				$sofasSectId = $arSect["ID"];
		}
		$dbSite = CSite::GetByID(WIZARD_SITE_ID);
		if($arSite = $dbSite -> Fetch())
			$lang = $arSite["LANGUAGE_ID"];
		$defCurrency = "EUR";
		if($lang == "ru")
			$defCurrency = "RUB";
		elseif($lang == "en")
			$defCurrency = "USD";
		
			if (\Bitrix\Main\Config\Option::get( 'sale', 'use_sale_discount_only', 'N' ) == 'Y' && CModule::IncludeModule("sale"))
			{
				$arF = Array (
						'LID' => WIZARD_SITE_ID,
						'NAME' => GetMessage("WIZ_DISCOUNT"),
						'CURRENCY' => $defCurrency,
						'ACTIVE_FROM' => '',
						'ACTIVE_TO' => '',
						'ACTIVE' => 'Y',
						'SORT' => '100',
						'PRIORITY' => '1',
						'LAST_DISCOUNT' => 'Y',
						'LAST_LEVEL_DISCOUNT' => 'N',
						'XML_ID' => '',
						'USER_GROUPS' => Array (
								'0' => 2
								),
						'CONDITIONS' => Array (
								'CLASS_ID' => 'CondGroup',
								'DATA' => Array (
										'All' => 'AND',
										'True' => 'True'
										),
								'CHILDREN' => Array (
										'0' => Array (
												'CLASS_ID' => 'CondBsktProductGroup',
												'DATA' => Array (
														'Found' => 'Found',
														'All' => 'OR'
														),
												'CHILDREN' => Array (
														'0' => Array (
																'CLASS_ID' => 'CondIBSection',
																'DATA' => Array (
																		'logic' => 'Equal',
																		'value' => $sofasSectId
																		)
																)
														)
												)
										)
								),
						'ACTIONS' => Array (
								'CLASS_ID' => 'CondGroup',
								'DATA' => Array (
										'All' => 'AND'
										),
								'CHILDREN' => Array (
										'0' => Array (
												'CLASS_ID' => 'ActSaleBsktGrp',
												'DATA' => Array (
														'Type' => 'Discount',
														'Value' => 20,
														'Unit' => 'Perc',
														'Max' => 0,
														'All' => 'OR',
														'True' => 'True'
														),
												'CHILDREN' => Array (
														'0' => Array (
																'CLASS_ID' => 'ActSaleSubGrp',
																'DATA' => Array (
																		'All' => 'OR',
																		'True' => 'True'
																		),
																	
																'CHILDREN' => Array (
																		'0' => Array (
																				'CLASS_ID' => 'CondIBSection',
																				'DATA' => Array (
																						'logic' => 'Equal',
																						'value' => $sofasSectId
																						)
																				)
																		)
																),
														'1' => Array ()
														)
												)
										)
								),
						'PRESET_ID' => 'Sale\Handlers\DiscountPreset\SimpleProduct'
						);
				CSaleDiscount::Add($arF);
			}
else 
{
	$arF = Array (
			"SITE_ID" => WIZARD_SITE_ID,
			"ACTIVE" => "Y",
			"RENEWAL" => "N",
			"NAME" => GetMessage("WIZ_DISCOUNT"),
			"SORT" => 100,
			"MAX_DISCOUNT" => 0,
			"VALUE_TYPE" => "P",
			"VALUE" => 20,
			"CURRENCY" => $defCurrency,
			"CONDITIONS" => Array (
					"CLASS_ID" => "CondGroup",
					"DATA" => Array("All" => "OR", "True" => "True"),
					"CHILDREN" => Array(Array("CLASS_ID" => "CondIBSection", "DATA" => Array("logic" => "Equal", "value" => $sofasSectId)))
					)
			);
	CCatalogDiscount::Add($arF);
}

	}
    
  
    //precet
	$dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_CATALOG_ID, "CODE"=>"SEZON"));
	$arFields = array();
	while($arProperty = $dbProperty->GetNext())
	{
		$arFields["find_el_property_".$arProperty["ID"]] = "";
	}
	$dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_CATALOG_ID, "CODE"=>"CML2_MANUFACTURER"));
	while($arProperty = $dbProperty->GetNext())
	{
		$arFields["find_el_property_".$arProperty["ID"]] = "";
	}
	$dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_CATALOG_ID, "CODE"=>"VYREZ_GORLOVINY"));
	while($arProperty = $dbProperty->GetNext())
	{
		$arFields["find_el_property_".$arProperty["ID"]] = "";
	}
    $dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_CATALOG_ID, "CODE"=>"POKROY"));
    while($arProperty = $dbProperty->GetNext())
    {
        $arFields["find_el_property_".$arProperty["ID"]] = "";
    } 
    $dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_CATALOG_ID, "CODE"=>"VID_ZASTEZHKI"));
    while($arProperty = $dbProperty->GetNext())
    {
        $arFields["find_el_property_".$arProperty["ID"]] = "";
    }    
    $dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_CATALOG_ID, "CODE"=>"FAKTURA_MATERIALA"));
    while($arProperty = $dbProperty->GetNext())
    {
        $arFields["find_el_property_".$arProperty["ID"]] = "";
    }                  
    //offers porps  
    $dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_OFFERS_ID, "CODE"=>"COLOR"));
    while($arProperty = $dbProperty->GetNext())
    {
        $arFields["find_el_property_".$arProperty["ID"]] = "";
    }        
    $dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_OFFERS_ID, "CODE"=>"RAZMER"));
    while($arProperty = $dbProperty->GetNext())
    {
        $arFields["find_el_property_".$arProperty["ID"]] = "";
    }    
    $dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_OFFERS_ID, "CODE"=>"OG"));
    while($arProperty = $dbProperty->GetNext())
    {
        $arFields["find_el_property_".$arProperty["ID"]] = "";
    } 
    $dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_OFFERS_ID, "CODE"=>"CHASHECHKI"));
    while($arProperty = $dbProperty->GetNext())
    {
        $arFields["find_el_property_".$arProperty["ID"]] = "";
    }     
                  
    
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/interface/admin_lib.php");
	CAdminFilter::AddPresetToBase( array(
			"NAME" => GetMessage("WIZ_PRECET"),
			"FILTER_ID" => "tbl_product_admin_".md5($iblockType.".".$IBLOCK_CATALOG_ID)."_filter",
			"LANGUAGE_ID" => $lang,
			"FIELDS" => $arFields
		)
	);
	CUserOptions::SetOption("filter", "tbl_product_admin_".md5($iblockType.".".$IBLOCK_CATALOG_ID)."_filter", array("rows" => "find_el_name, find_el_active, find_el_timestamp_from, find_el_timestamp_to"), true);

	CAdminFilter::SetDefaultRowsOption("tbl_product_admin_".md5($iblockType.".".$IBLOCK_CATALOG_ID)."_filter", array("miss-0","IBEL_A_F_PARENT"));

    

    CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID.'/header.php' , array("CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID, "OFFERS_IBLOCK_ID" => $IBLOCK_OFFERS_ID)); 
    

	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/catalog/index.php", array("CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.left.menu_ext.php", array("CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.top.menu_ext.php", array("CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/brands/index.php", array("CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/personal/order/index.php", array("CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/personal/order/make/index.php", array("CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID));
    
    
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/_index.php", array("CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID, "OFFERS_IBLOCK_ID" => $IBLOCK_OFFERS_ID));           
           
            
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/sect_inc.php", array("CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/_index.php", array("CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID, "OFFERS_IBLOCK_ID" => $IBLOCK_OFFERS_ID));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/catalog/sect_sidebar.php.php", array("CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/include/viewed_product.php", array("CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID, "OFFERS_IBLOCK_ID" => $IBLOCK_OFFERS_ID));   
}
//set filter
$ColorCode=COption::GetOptionString( "sotbit.b2bshop", "OFFER_COLOR_PROP", "" );
CModule::IncludeModule('iblock');
$res = CIBlock::GetList(
   Array(), 
   Array(
      'TYPE'=>'b2bs_catalog', 
      'ACTIVE'=>'Y', 
   ), true
);
while($ar_res = $res->Fetch())
{
$rsProps = CIBlockProperty::GetList( array(
				'SORT' => 'ASC',
				'ID' => 'ASC' 
		), array(
				'IBLOCK_ID' => $ar_res['ID'],
				'ACTIVE' => 'Y',
'CODE'=>$ColorCode 
		) );
		if( $arProp = $rsProps->Fetch() )
		{
$ColorId=$arProp['ID'];
}
$properties=CIBlockSectionPropertyLink::GetArray($ar_res['ID'], $SECTION_ID = 0, $bNewSection = false);
foreach($properties as $key=>$prop)
{
	if($prop['PROPERTY_TYPE']=='S' && $prop['USER_TYPE']=='directory')
	{
		if($prop['PROPERTY_ID']!=$ColorId)
			CIBlockSectionPropertyLink::Set(0, $prop['PROPERTY_ID'],array('DISPLAY_TYPE'=>'H'));
		else
			CIBlockSectionPropertyLink::Set(0, $prop['PROPERTY_ID'],array('DISPLAY_TYPE'=>'G'));
	}
}
}
?>
