<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("IBLOCK_ELEMENT_TEMPLATE_NAME"),
	"DESCRIPTION" => GetMessage("IBLOCK_ELEMENT_TEMPLATE_DESCRIPTION"),
	"ICON" => "/images/cat_detail.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 40,
	"PATH" => array(
		"ID" => "sotbit",
		"NAME" => GetMessage("SECTION_NAME")
	),
);

?>