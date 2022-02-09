<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();








if(!CModule::IncludeModule("iblock"))
    return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();
$arIBlockCatalog =array();
$rsIBlockCatalog = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["CATALOG_IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlockCatalog->Fetch())
{
    $arIBlockCatalog[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}


$arTemplateParameters = array(

    "IBLOCK_TYPE_CATALOG" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("IBLOCK_TYPE_CATALOG"),
        "TYPE" => "LIST",
        "VALUES" => $arIBlockType,
        "REFRESH" => "Y",
    ),
    "IBLOCK_ID_CATALOG" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("IBLOCK_ID_CATALOG"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arIBlockCatalog
    ),

  
  
);


if(CModule::IncludeModule('kit.mailing')){
    // ������� ��������� ��������
    // START
    $categoriesList = array();
    $categoriesLi = CKitMailingHelp::GetCategoriesInfo();
    foreach($categoriesLi as $v) { 
        $categoriesList[$v['ID']] = '['.$v['ID'].'] '.$v['NAME'];            
    }  
    // END 
    $arTemplateParameters['MAILING_INFO_TEXT'] = array(
        "NAME" => GetMessage("MAILING_INFO_TEXT_TITLE"),
        "TYPE" => "TEXT",
        "DEFAULT" => GetMessage("MAILING_INFO_TEXT_DEFAULT"),
    );       
    $arTemplateParameters['MAILING_EMAIL_SEND_END'] = array(
        "NAME" => GetMessage("MAILING_EMAIL_SEND_END_TITLE"),
        "TYPE" => "TEXT",
        "DEFAULT" => GetMessage("MAILING_EMAIL_SEND_END_DEFAULT"),
    );    
    $arTemplateParameters['MAILING_CATEGORIES_ID'] = array(
        "NAME" => GetMessage("MAILING_CATEGORIES_ID_TITLE"),
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "VALUES" => $categoriesList,
    );   
    
    
}



?>
