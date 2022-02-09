<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (!defined("WIZARD_SITE_ID") || !defined("WIZARD_SITE_DIR"))
	return;

WizardServices::IncludeServiceLang("files.php", 'ru');

function ___writeToAreasFile($path, $text)
{
	//if(file_exists($fn) && !is_writable($abs_path) && defined("BX_FILE_PERMISSIONS"))
	//	@chmod($abs_path, BX_FILE_PERMISSIONS);

	$fd = @fopen($path, "wb");
	if(!$fd)
		return false;

	if(false === fwrite($fd, $text))
	{
		fclose($fd);
		return false;
	}

	fclose($fd);

	if(defined("BX_FILE_PERMISSIONS"))
		@chmod($path, BX_FILE_PERMISSIONS);
}

if (COption::GetOptionString("main", "upload_dir") == "")
	COption::SetOptionString("main", "upload_dir", "upload");

$module = 'kit.b2bshop';

if(COption::GetOptionString("kit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "N" || WIZARD_INSTALL_DEMO_DATA)
{
	if(file_exists(WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/"))
	{
		CopyDirFiles(
			WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/",
			WIZARD_SITE_PATH,
			$rewrite = true,
			$recursive = true,
			$delete_after_copy = false
		);
	}

    if(file_exists(WIZARD_ABSOLUTE_PATH."/site/public/upload/"))
    {
        CopyDirFiles(
            WIZARD_ABSOLUTE_PATH."/site/public/upload/",
            $_SERVER["DOCUMENT_ROOT"].'/upload/',
            $rewrite = true,
            $recursive = true,
            $delete_after_copy = false
        );
    }


    COption::SetOptionString("kit.b2bshop",'TEL',$wizard->GetVar("siteTelephone"));
    COption::SetOptionString("kit.b2bshop",'COPYRIGHT',$wizard->GetVar("siteCopy"));
    COption::SetOptionString("kit.b2bshop",'EMAIL',$wizard->GetVar("shopEmail"));



    COption::SetOptionString("kit.b2bshop",'URL_CART',WIZARD_SITE_DIR.'personal/cart/');
    COption::SetOptionString("kit.b2bshop",'URL_ORDER',WIZARD_SITE_DIR.'personal/order/make/');
    COption::SetOptionString("kit.b2bshop",'URL_PERSONAL',WIZARD_SITE_DIR.'personal/');
    COption::SetOptionString("kit.b2bshop",'URL_PAYMENT',WIZARD_SITE_DIR.'personal/order/payment/');
    COption::SetOptionString("kit.b2bshop",'URL_PAGE_ORDER',WIZARD_SITE_DIR.'personal/order/');
    COption::SetOptionString("kit.b2bshop",'TABLE_SIZE_URL',WIZARD_SITE_DIR.'clients/table_sizes/#table');
    COption::SetOptionString("kit.b2bshop", 'DETAIL_TEXT_INCLUDE', GetMessage('DETAIL_TEXT_INCLUDE', array('#SITE_DIR#' => WIZARD_SITE_DIR)));

}


$wizard =& $this->GetWizard();
/*
___writeToAreasFile(WIZARD_SITE_PATH."include/miss-footer-copyright.php", $wizard->GetVar("siteCopy"));
___writeToAreasFile(WIZARD_SITE_PATH."include/miss-header-phone.php", $wizard->GetVar("siteTelephone"));
___writeToAreasFile(WIZARD_SITE_PATH."include/miss-footer-email.php", $wizard->GetVar("shopEmail"));
*/





if(COption::GetOptionString("kit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
	return;

WizardServices::PatchHtaccess(WIZARD_SITE_PATH);

WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."auth/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."brands/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."catalog/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."clients/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."help/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."include/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."login/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."news/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."personal/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."sales/", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_search.php", Array("SITE_DIR" => WIZARD_SITE_DIR));



CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".404_menu.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".bottom.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".left.menu_ext.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".left_content.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".left_content.menu_ext.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".top.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".top.menu_ext.php", Array("SITE_DIR" => WIZARD_SITE_DIR));


WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/", Array("SALE_EMAIL" => $wizard->GetVar("shopEmail")));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/delivery/", Array("SALE_PHONE" => $wizard->GetVar("siteTelephone")));

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.section.php", array("SITE_DESCRIPTION" => htmlspecialcharsbx($wizard->GetVar("siteMetaDescription"))));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.section.php", array("SITE_KEYWORDS" => htmlspecialcharsbx($wizard->GetVar("siteMetaKeywords"))));

copy(WIZARD_THEME_ABSOLUTE_PATH."/favicon.ico", WIZARD_SITE_PATH."favicon.ico");

$arUrlRewrite = array();
if (file_exists(WIZARD_SITE_ROOT_PATH."/urlrewrite.php"))
{
	include(WIZARD_SITE_ROOT_PATH."/urlrewrite.php");
}

$arNewUrlRewrite = array(
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."news/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	 WIZARD_SITE_DIR."news/index.php",
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."catalog/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:catalog",
		"PATH"	=>	 WIZARD_SITE_DIR."catalog/index.php",
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."personal/order/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:sale.personal.order",
		"PATH"	=>	 WIZARD_SITE_DIR."personal/order/index.php",
	),
    array(
        "CONDITION" => "#^".WIZARD_SITE_DIR."brands/#",
        "RULE" => "",
        "ID" => "bitrix:news",
        "PATH" => WIZARD_SITE_DIR."brands/index.php",
    ),
    array(
        "CONDITION" => "#^".WIZARD_SITE_DIR."sales/#",
        "RULE" => "",
        "ID" => "bitrix:catalog",
        "PATH" => WIZARD_SITE_DIR."sales/index.php",
    ),
);

if($module == 'kit.b2bshop')
{
	$arNewUrlRewrite[] = array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."personal/b2b/blank_zakaza/#",
			"RULE" => "",
			"ID" => "bitrix:catalog",
			"PATH" => WIZARD_SITE_DIR."personal/b2b/blank_zakaza/index.php",
	);
	$arNewUrlRewrite[] = array(
			"CONDITION"	=>	"#^".WIZARD_SITE_DIR."personal/b2b/order/#",
			"RULE"	=>	"",
			"ID"	=>	"bitrix:sale.personal.order",
			"PATH"	=>	 WIZARD_SITE_DIR."personal/b2b/order/index.php",
	);
	$arNewUrlRewrite[] = array(
			"CONDITION"	=>	"#^".WIZARD_SITE_DIR."personal/b2b/documents/#",
			"RULE"	=>	"",
			"ID"	=>	"bitrix:news",
			"PATH"	=>	 WIZARD_SITE_DIR."personal/b2b/documents/index.php",
	);
}

foreach ($arNewUrlRewrite as $arUrl)
{
	if (!in_array($arUrl, $arUrlRewrite))
	{
		CUrlRewriter::Add($arUrl);
	}
}
?>