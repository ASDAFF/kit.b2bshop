<?

if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true )
	die();

$arDefaultVariableAliases = array();

$arComponentVariables = array(
		"id",
		'add'
);

$arVariableAliases = CComponentEngine::makeComponentVariableAliases( $arDefaultVariableAliases, $arParams["VARIABLE_ALIASES"] );
CComponentEngine::initComponentVariables( false, $arComponentVariables, $arVariableAliases, $arVariables );

$componentPage = "";

if($arVariables['add'] == 'Y')
{
	$componentPage = "add";
}
elseif($arVariables['id'] > 0)
{
	$arParams['ID'] = $arVariables['id'];
	$componentPage = "edit";
}
else
{
	$arResult['PATH_TO_ADD'] = $arParams['PATH'].$arParams['PATH_TO_ADD'];
	$componentPage = "list";
}

$this->includeComponentTemplate( $componentPage );