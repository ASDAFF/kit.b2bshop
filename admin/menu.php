<?
IncludeModuleLangFile( __FILE__ );
$module_id = "kit.b2bshop";

if( $APPLICATION->GetGroupRight( $module_id ) != "D" )
{
	$aMenu = array();
	return $aMenu;
}
?>