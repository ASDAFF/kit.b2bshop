<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock") || !CModule::IncludeModule("catalog"))
	return;

if(COption::GetOptionString("kit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
	return;

WizardServices::IncludeServiceLang("catalog.php", 'ru');
    

$iblockCode = "b2bs_catalog-b2bshop_".WIZARD_SITE_ID;
$iblockType = "b2bs_catalog";



$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/ru/ms_catalog.xml";


if(CModule::IncludeModule("kit.b2bshop"))
{
	if($arUpdateList["CLIENT"][0]["@"]['L1'] == 'Small') //small business
	{
		$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/ru/ms_catalog.xml";
	}
	else
	{
		$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/ru/ms_catalog_opt.xml";
	}
}

$rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockCode, "TYPE" => $iblockType));
$IBLOCK_CATALOG_ID = false;
while($arIBlock = $rsIBlock->Fetch())
{ 
    $IBLOCK_CATALOG_ID = $arIBlock["ID"];      
}   

if (WIZARD_INSTALL_DEMO_DATA && $IBLOCK_CATALOG_ID)
{
	$boolFlag = true;
	$arSKU = CCatalogSKU::GetInfoByProductIBlock($IBLOCK_CATALOG_ID);
	if (!empty($arSKU))
	{
		$boolFlag = CCatalog::UnLinkSKUIBlock($IBLOCK_CATALOG_ID);
		if (!$boolFlag)
		{
			$strError = "";
			if ($ex = $APPLICATION->GetException())
			{
				$strError = $ex->GetString();
			}
			else
			{
				$strError = "Couldn't unlink iblocks";
			}
			//die($strError);
		}
		$boolFlag = CIBlock::Delete($arSKU['IBLOCK_ID']);
		if (!$boolFlag)
		{
			$strError = "";
			if ($ex = $APPLICATION->GetException())
			{
				$strError = $ex->GetString();
			}
			else
			{
				$strError = "Couldn't delete offers iblock";
			}
			//die($strError);
		}
	}
	if ($boolFlag)
	{
		$boolFlag = CIBlock::Delete($IBLOCK_CATALOG_ID);
		if (!$boolFlag)
		{
			$strError = "";
			if ($ex = $APPLICATION->GetException())
			{
				$strError = $ex->GetString();
			}
			else
			{
				$strError = "Couldn't delete catalog iblock";
			}
			//die($strError);
		}
	}
	if ($boolFlag)
	{
		$IBLOCK_CATALOG_ID = false;
	}
}



if($IBLOCK_CATALOG_ID == false)
{
	$permissions = Array(
			"1" => "X",
			"2" => "R"
		);
	$dbGroup = CGroup::GetList($by = "", $order = "", Array("STRING_ID" => "sale_administrator"));
	if($arGroup = $dbGroup -> Fetch())
	{
		$permissions[$arGroup["ID"]] = 'W';
	}
	$dbGroup = CGroup::GetList($by = "", $order = "", Array("STRING_ID" => "content_editor"));
	if($arGroup = $dbGroup -> Fetch())
	{
		$permissions[$arGroup["ID"]] = 'W';
	}
	$IBLOCK_CATALOG_ID = WizardServices::ImportIBlockFromXML(
		$iblockXMLFile,
		"b2bs_catalog-b2bshop",
		$iblockType,
		WIZARD_SITE_ID,
		$permissions
	);

	if ($IBLOCK_CATALOG_ID < 1)
		return;
    
	$_SESSION["WIZARD_CATALOG_IBLOCK_ID"] = $IBLOCK_CATALOG_ID;
}
else
{
	$arSites = array();
	$db_res = CIBlock::GetSite($IBLOCK_CATALOG_ID);
	while ($res = $db_res->Fetch())
		$arSites[] = $res["LID"];
	if (!in_array(WIZARD_SITE_ID, $arSites))
	{
		$arSites[] = WIZARD_SITE_ID;
		$iblock = new CIBlock;
		$iblock->Update($IBLOCK_CATALOG_ID, array("LID" => $arSites));
	}
    $_SESSION["WIZARD_CATALOG_IBLOCK_ID"] = $IBLOCK_CATALOG_ID;    
} 


if($IBLOCK_CATALOG_ID){
    COption::SetOptionString('kit.b2bshop','IBLOCK_ID',$IBLOCK_CATALOG_ID);
    //�������� ��� ������ � �������� ������
    $MAIN_PROPS = array(
        'SOSTAV',
        'CML2_ARTICLE',
        'RISUNOK_'
    );
    COption::SetOptionString("kit.b2bshop", "MAIN_PROPS", serialize($MAIN_PROPS));
    
    
    
    $DOP_PROPS = array(
        'SEZON',
        'STRANA_PROIZVODITEL',
        'CML2_MANUFACTURER',
        'POL',
        'VYREZ_GORLOVINY',
        'TIP_RUKAVA',
        'GABARITY_PREDMETOV',
        'DLINA_RUKAVA',
        'DEKORATIVNYE_ELEMENTY',
        'SHIRINA_RUKAVA',
        'POKROY',
        'STIL',
        'OSOBENNOSTI_TKANI',
        'VID_ZASTEZHKI',
        'FAKTURA_MATERIALA',
        'VOROTNIK',
        'TIP_KARMANOV',
        'KONSTRUKTIVNYE_ELEMENTY',
        'PO_NAZNACHENIYU',
        'MATERIAL_PODKLADKI',
        'RISUNOK_',
        'VYSOTA_KABLUKA',
        'VYSOTA_PLATFORMY',
        'MATERIAL_VERKHA',
        'MATERIAL_PODOSHVY',
        'FORMA_MYSKA',
        'FORMA_KABLUKA',
        'OSOBENNOST_MATERIALA_VERKHA',
        'MATERIAL_STELKI',
        'GOLENISHCHE',
        'FORMA_RUKAVA',
        'RUKAV',
        'VID_BRETELEK'
    ); 
    COption::SetOptionString("kit.b2bshop", "DOP_PROPS", serialize($DOP_PROPS));
  
    $ALL_PROPS = array_merge($MAIN_PROPS, $DOP_PROPS);
    COption::SetOptionString("kit.b2bshop", "ALL_PROPS", serialize($ALL_PROPS));
    //������� 
    $SIZE_PROPS = array(
        'RAZMER',
    );
    COption::SetOptionString("kit.b2bshop", "SIZE_PROPS", serialize($SIZE_PROPS));

    
    COption::SetOptionString("kit.b2bshop", "PICTURE_FROM_OFFER", "Y");
    COption::SetOptionString("kit.b2bshop", "DOWNLOAD", "Y");
    
    
    CModule::IncludeModule("kit.b2bshop");
    B2BSKit::agentSectionsBrands();
    
    
    
    
    //�������� ��������� ��� UF �����
    //START 
    $dbHblockproper = CUserTypeEntity::GetList(array(),array('ENTITY_ID' => 'IBLOCK_'.$IBLOCK_CATALOG_ID.'_SECTION'));  
    while($arHblockproper = $dbHblockproper->Fetch()) {  
        $arFields = array();
        $obUserField = new CUserTypeEntity();     
        if($arHblockproper['FIELD_NAME'] == 'UF_B2BS_BRAND'){
            
            $arFields = array(
                'SETTINGS' => array(
                    'IBLOCK_ID' => $_SESSION["WIZARD_BRAND_IBLOCK_ID"],
                    'LIST_HEIGHT' => 10             
                )    
            );
            $arFields["EDIT_FORM_LABEL"]['ru'] = GetMessage('UF_B2BS_BRAND_NAME');
            $arFields["LIST_COLUMN_LABEL"]['ru'] = GetMessage('UF_B2BS_BRAND_NAME');
            $arFields["LIST_FILTER_LABEL"]['ru'] = GetMessage('UF_B2BS_BRAND_NAME');
            $obUserField->Update($arHblockproper['ID'],$arFields);             
        }
        
        if($arHblockproper['FIELD_NAME'] == 'UF_SECOND_TITLE'){
            $arFields["EDIT_FORM_LABEL"]['ru'] = GetMessage('UF_SECOND_TITLE_NAME');
            $arFields["LIST_COLUMN_LABEL"]['ru'] = GetMessage('UF_SECOND_TITLE_NAME');
            $arFields["LIST_FILTER_LABEL"]['ru'] = GetMessage('UF_SECOND_TITLE_NAME');
            $obUserField->Update($arHblockproper['ID'],$arFields);              
        }
        
        if($arHblockproper['FIELD_NAME'] == 'UF_BRICK_SORT'){
        	$arFields["EDIT_FORM_LABEL"]['ru'] = GetMessage('UF_BRICK_SORT');
        	$arFields["LIST_COLUMN_LABEL"]['ru'] = GetMessage('UF_BRICK_SORT');
        	$arFields["LIST_FILTER_LABEL"]['ru'] = GetMessage('UF_BRICK_SORT');
        	$obUserField->Update($arHblockproper['ID'],$arFields);
        }
        
    }    
    //END
     
    
      
}


?>