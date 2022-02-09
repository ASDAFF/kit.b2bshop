<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock"))
	return;

if(COption::GetOptionString("kit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
	return;

WizardServices::IncludeServiceLang("documents.php", 'ru');

$module = 'kit.b2bshop';

if($module == 'kit.b2bshop')
{
	$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/ru/documents.xml";
	$iblockCode = "documents_".WIZARD_SITE_ID;
	$iblockType = "b2bs_documents";

	$rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockCode, "TYPE" => $iblockType));
	$IBLOCK_DOCUMENT_ID = false;
	if ($arIBlock = $rsIBlock->Fetch())
	{
		$IBLOCK_DOCUMENT_ID = $arIBlock["ID"];
		if (WIZARD_INSTALL_DEMO_DATA)
		{
			CIBlock::Delete($arIBlock["ID"]);
			$IBLOCK_DOCUMENT_ID = false;
		}
	}

	if($IBLOCK_DOCUMENT_ID == false)
	{
		$permissions = [
			"1" => "X",
			"2" => "R"
		];
		$dbGroup = CGroup::GetList($by = "", $order = "", ["STRING_ID" => "content_editor"]);
		if($arGroup = $dbGroup->Fetch())
		{
			$permissions[$arGroup["ID"]] = 'W';
		};
		$IBLOCK_DOCUMENT_ID = WizardServices::ImportIBlockFromXML(
			$iblockXMLFile,
		    $iblockCode,
			$iblockType,
			WIZARD_SITE_ID,
			$permissions
		);

		if($IBLOCK_DOCUMENT_ID < 1)
			return;


		if($IBLOCK_DOCUMENT_ID)
		{
			COption::SetOptionString("kit.b2bshop", 'DOCUMENT_IBLOCK_TYPE', $iblockType);
			COption::SetOptionString("kit.b2bshop", 'DOCUMENT_IBLOCK_ID', $IBLOCK_DOCUMENT_ID);
		}
	}
}
?>