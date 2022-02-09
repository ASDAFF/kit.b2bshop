<?php
use Bitrix\Main\Config\Option;
global $APPLICATION;
$personalTemplate = new \Kit\B2BShop\Client\Template\Personal();

$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"ms_personal", 
	array(
		"ROOT_MENU_TYPE" => $personalTemplate->getMenuType(),
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => $personalTemplate->getMenuType(true),
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_THEME" => "site",
		"DISPLAY_USER_NANE" => "N",
		"PROFILE_URL" => $personalTemplate->getProfilePath(),
		"CACHE_SELECTED_ITEMS" => false,
		"COMPONENT_TEMPLATE" => "ms_personal"
	),
	false
);
?>