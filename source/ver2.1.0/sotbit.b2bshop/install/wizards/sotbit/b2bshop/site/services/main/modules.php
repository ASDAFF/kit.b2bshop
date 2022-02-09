<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if (!defined("WIZARD_SITE_ID") || !defined("WIZARD_SITE_DIR"))
    return;
    
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/update_client_partner.php");

$moduleName = 'sotbit.b2bshop';

//START
if (!IsModuleInstalled("sotbit.b2bshop") && file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sotbit.b2bshop/"))
{
    $installFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sotbit.b2bshop/install/index.php";
    if (!file_exists($installFile))
        return false;

    include_once($installFile);

    $moduleIdTmp = str_replace(".", "_", "sotbit.b2bshop");
    if (!class_exists($moduleIdTmp))
        return false;

    $module = new $moduleIdTmp;
    $module->InstallFiles();
    $module->InstallDB();
    $module->InstallAgents();
    RegisterModule("sotbit.b2bshop");               
}
//END


//START


$modulesThear = array(
    'sns.tools1c',
    'shs.parser',
    'shs.onlinebuyers',    
    'sotbit.analog',
    'sotbit.dpd',
    'sotbit.mailing',
    'sotbit.orderphone',    
    'sotbit.postcalc',
    'sotbit.preloader',
    'sotbit.productview', 
    'sotbit.wikimartorders',
    'sotbit.seometa',   
    'sotbit.reviews',
	'sotbit.htmleditoraddition',
	'sotbit.price',
	'sotbit.auth',
	'sotbit.cabinet',
	'sotbit.bill',
	'sotbit.client',
	'sotbit.crmbitrix24',
	'sotbit.regions',
	'sotbit.b24generator'
);

if($moduleName == 'sotbit.b2bshop')
{
	array_push($modulesThear, 'sotbit.checkcompany');
	array_push($modulesThear, 'sotbit.yandex');
}






$modulesStrangers = array(
    'asd.share',
    'coffeediz.schema'
); 



if (!function_exists("installModuleHands")){ 
    
    function installModuleHands($module,$modulesThear) {

         $obModule = CModule::CreateModuleObject($module);
         if(!is_object($obModule)) {
            return false;
         }  

         if(!$obModule->IsInstalled()) { 

            if(in_array($module,array('asd.share'))){
                CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module."/install/components/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components/bitrix/", true, true);
                RegisterModule($module);  
                return true;                   
            }   
                    
            if(in_array($module,array('asd.mailtpl'))){
                $obModule->InstallDB(); 
                return true;                               
            } 
            

            if(in_array($module,array('coffeediz.schema'))){
                CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module."/install/components/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components/", true, true);
                RegisterModule($module);   
                return true;                            
            }            
                  
            if(in_array($module,$modulesThear)){  
                $obModule->InstallFiles();
                $obModule->InstallDB();
                $obModule->InstallEvents(); 

                if(!$obModule->IsInstalled()) { 
                    RegisterModule($module);    
                }  
                return true;                                  
            }          
         }  
    
    }    
}

$modulesNeed =  array_merge($modulesThear,$modulesStrangers);  
foreach($modulesNeed as $module){
    

    $modulesPathDir = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module."/";
    if(!file_exists($modulesPathDir)) {
		$strError = '';
        CUpdateClientPartner::LoadModuleNoDemand($module,$strError,'Y',false);
    }
    
    $module_status = CModule::IncludeModuleEx($module);
    if($module_status==2 || $module_status==0 || $module_status==3) {

         installModuleHands($module,$modulesThear);
    }

}

//END   

?>