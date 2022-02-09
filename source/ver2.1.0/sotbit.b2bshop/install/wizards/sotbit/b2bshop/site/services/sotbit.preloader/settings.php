<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("sotbit.preloader"))
    return;     
    
if(COption::GetOptionString("sotbit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
    return;


    
    
COption::SetOptionString('sotbit.preloader','ACTIVE','Y');
COption::SetOptionString('sotbit.preloader','IMAGE','/upload/pr_10.gif');
COption::SetOptionString('sotbit.preloader','BACKGROUND','rgba(255,255,255,0.6)');
COption::SetOptionString('sotbit.preloader','WIDTH','100%');
COption::SetOptionString('sotbit.preloader','HEIGHT','100%');
COption::SetOptionString('sotbit.preloader','POSITION','left-top');


CopyDirFiles(
    WIZARD_ABSOLUTE_PATH."/site/services/sotbit.preloader/files/themes/",
    $_SERVER['DOCUMENT_ROOT'].'/bitrix/themes/',
    $rewrite = true,
    $recursive = true,
    $delete_after_copy = false
);
?>