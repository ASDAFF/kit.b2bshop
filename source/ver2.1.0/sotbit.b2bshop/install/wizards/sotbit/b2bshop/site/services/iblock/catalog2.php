<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("catalog"))
	return;

if(COption::GetOptionString("sotbit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
	return;

//offers iblock import    


$iblockCode = "b2bs_catalog-b2bshop_".WIZARD_SITE_ID.'#';
$iblockType = "b2bs_catalog"; 



$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/ru/ms_offer.xml";


if(CModule::IncludeModule("sotbit.b2bshop"))
{
	if($arUpdateList["CLIENT"][0]["@"]['L1'] == 'Small') //small business
	{
		$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/ru/ms_offer.xml";
	}
	else
	{
		$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/ru/ms_offer_opt.xml";
	}
}




$rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockCode, "TYPE" => $iblockType));
$IBLOCK_OFFERS_ID = false;
while($arIBlock = $rsIBlock->Fetch())
{
    $IBLOCK_OFFERS_ID = $arIBlock["ID"];
}  
//--offers

if($IBLOCK_OFFERS_ID == false)
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

	$IBLOCK_OFFERS_ID = WizardServices::ImportIBlockFromXML(
		$iblockXMLFile,
		"b2bs_catalog-b2bshop#",
		$iblockType,
		WIZARD_SITE_ID,
		$permissions
	);

	if ($IBLOCK_OFFERS_ID < 1)
		return;
        
        
    //��������� ��������� ���������� � ������
    //START
    if(CModule::IncludeModule("iblock") && $IBLOCK_OFFERS_ID && $_SESSION["WIZARD_CATALOG_IBLOCK_ID"]){

        $photo_product = array();    
        $arSelect = Array(
            "ID", 
            "IBLOCK_ID", 
            "PROPERTY_MORE_PHOTO",    
            "PROPERTY_CML2_LINK",
        );     
        $res = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>$IBLOCK_OFFERS_ID), false, false, $arSelect);              
        while($ob = $res->Fetch()){ 
            if(empty($photo_product[$ob['PROPERTY_CML2_LINK_VALUE']])){
                $photo_product[$ob['PROPERTY_CML2_LINK_VALUE']] = $ob['PROPERTY_MORE_PHOTO_VALUE'];    
            }        
        }


        $arSelect = Array(
            "ID", 
            "DETAIL_PICTURE",    
        );     
        $res = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>$_SESSION["WIZARD_CATALOG_IBLOCK_ID"]), false, false, $arSelect);              
        while($ob = $res->Fetch()){ 
            
            if($photo_product[$ob['ID']] && empty($ob['DETAIL_PICTURE'])){
                $el = new CIBlockElement;
                $arrFileds = array(
                    'DETAIL_PICTURE'  => CFile::MakeFileArray($photo_product[$ob['ID']])   
                );
                $re = $el->Update($ob['ID'], $arrFileds);      
            }        
        }   
        
    }  
    //END    
        
        
    
	$_SESSION["WIZARD_OFFERS_IBLOCK_ID"] = $IBLOCK_OFFERS_ID;
}
else
{
	$arSites = array();
	$db_res = CIBlock::GetSite($IBLOCK_OFFERS_ID);
	while ($res = $db_res->Fetch())
		$arSites[] = $res["LID"];
	if (!in_array(WIZARD_SITE_ID, $arSites))
	{
		$arSites[] = WIZARD_SITE_ID;
		$iblock = new CIBlock;
		$iblock->Update($IBLOCK_OFFERS_ID, array("LID" => $arSites));
	}
    $_SESSION["WIZARD_OFFERS_IBLOCK_ID"] = $IBLOCK_OFFERS_ID;
}



if($IBLOCK_OFFERS_ID){
    COption::SetOptionString("sotbit.b2bshop",'OFFER_IBLOCK_ID',$IBLOCK_OFFERS_ID);    
}
?>