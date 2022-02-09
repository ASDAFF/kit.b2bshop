<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
	
	CModule::IncludeModule('fileman');
	$arMenuTypes = GetMenuTypes(WIZARD_SITE_ID);
	
	/*if($wizard->GetVar("templateID") == "store_light"){
	 if($arMenuTypes['top'] && $arMenuTypes['top'] == GetMessage("WIZ_MENU_TOP_DEFAULT"))
	 $arMenuTypes['top'] =  GetMessage("WIZ_MENU_LIGHT_TOP");
	 }
	 else if($wizard->GetVar("changeTemplate") == "Y" && $wizard->GetVar("templateID") == "store_minimal"){
	 if($arMenuTypes['top'] && $arMenuTypes['top'] == GetMessage("WIZ_MENU_LIGHT_TOP"))
	 $arMenuTypes['top'] =  GetMessage("WIZ_MENU_TOP_DEFAULT");
	 }                        */
	 
	 SetMenuTypes($arMenuTypes, WIZARD_SITE_ID);
	 COption::SetOptionInt("fileman", "num_menu_param", 2, false ,WIZARD_SITE_ID);
	 
	 
	 CModule::IncludeModule('fileman');
	 $arRes = array();
	 
	 $menuTypes=array('left'=>GetMessage("WIZ_MENU_left"),'top'=>GetMessage("WIZ_MENU_top"),'top_sub'=>GetMessage("WIZ_MENU_top_sub"),'bottom'=>GetMessage("WIZ_MENU_bottom"),'bottom_inner'=>GetMessage("WIZ_MENU_bottom_inner"),'personal'=>GetMessage("WIZ_MENU_personal"),'personal_inner'=>GetMessage("WIZ_MENU_personal_inner"),'404_menu'=>GetMessage("WIZ_MENU_404_menu"),'left_content'=>GetMessage("WIZ_MENU_left_content"),'left_content_inner'=>GetMessage("WIZ_MENU_left_content_inner"));
	 $armt=array();
	 $armt = GetMenuTypes();
	 foreach($menuTypes as $key=>$name)
	 {
	 	if(!in_array($key,$armt))
	 	{
	 		$tmp=array();
	 		$tmp[$key]=$name;
	 		$armt=array_merge($armt,$tmp);
	 	}
	 	
	 }
	 SetMenuTypes($armt,WIZARD_SITE_ID);
	 ?>