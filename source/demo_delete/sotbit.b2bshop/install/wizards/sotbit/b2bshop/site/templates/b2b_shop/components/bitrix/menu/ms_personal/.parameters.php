<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "DISPLAY_USER_NANE" => Array(
        "NAME" => GetMessage("T_MENU_USER_NANE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "PROFILE_URL" => array(
            "NAME" => GetMessage("COMP_AUTH_FORM_PROFILE_URL"), 
            "TYPE" => "STRING",
            "DEFAULT" => "",
    )
);
?>
