<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock"))
	return;

if(COption::GetOptionString("sotbit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
	return;

$module = 'sotbit.b2bshop';

$arTypes = Array(
    Array(
        "ID" => "b2bs_catalog",
        "SECTIONS" => "Y",
        "IN_RSS" => "N",
        "SORT" => 100,
        "LANG" => Array(),
    ),    
	Array(
		"ID" => "b2bs_content",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 200,
		"LANG" => Array(),
	),
	Array(
		"ID" => "b2bs_references",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 300,
		"LANG" => Array(),
	),
);

if($module == 'sotbit.b2bshop')
{
	$arTypes[] = Array(
		"ID" => "b2bs_documents",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 400,
		"LANG" => Array(),
	);
}


$arLanguages = Array();
$rsLanguage = CLanguage::GetList($by, $order, array());
while($arLanguage = $rsLanguage->Fetch())
	$arLanguages[] = $arLanguage["LID"];

$iblockType = new CIBlockType;
foreach($arTypes as $arType)
{
	$dbType = CIBlockType::GetList(Array(),Array("=ID" => $arType["ID"]));
	if($dbType->Fetch()) {
        
        continue;        
    }


	foreach($arLanguages as $languageID)
	{
		WizardServices::IncludeServiceLang("type.php", 'ru');

		$code = strtoupper($arType["ID"]);
		$arType["LANG"][$languageID]["NAME"] = GetMessage($code."_TYPE_NAME");
		$arType["LANG"][$languageID]["ELEMENT_NAME"] = GetMessage($code."_ELEMENT_NAME");

		if ($arType["SECTIONS"] == "Y")
			$arType["LANG"][$languageID]["SECTION_NAME"] = GetMessage($code."_SECTION_NAME");
            
	}


	$d = $iblockType->Add($arType);
    

}



COption::SetOptionString('iblock','combined_list_mode','Y');
?>