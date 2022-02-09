<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("kit.preloader"))
    return;     
    
if(COption::GetOptionString("kit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
    return;


    
    
COption::SetOptionString('kit.preloader','ACTIVE','Y');
COption::SetOptionString('kit.preloader','IMAGE','/upload/pr_10.gif');
COption::SetOptionString('kit.preloader','BACKGROUND','rgba(255,255,255,0.6)');
COption::SetOptionString('kit.preloader','WIDTH','100%');
COption::SetOptionString('kit.preloader','HEIGHT','100%');
COption::SetOptionString('kit.preloader','POSITION','left-top');


CopyDirFiles(
    WIZARD_ABSOLUTE_PATH."/site/services/kit.preloader/files/themes/",
    $_SERVER['DOCUMENT_ROOT'].'/bitrix/themes/',
    $rewrite = true,
    $recursive = true,
    $delete_after_copy = false
);
?>