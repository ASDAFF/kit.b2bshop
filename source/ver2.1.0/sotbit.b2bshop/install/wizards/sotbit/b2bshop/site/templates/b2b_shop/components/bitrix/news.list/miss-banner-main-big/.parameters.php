<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_NAME" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PREVIEW_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
    "LIST_HEIGHT_IMG" => array(
        "NAME" => GetMessage("T_IBLOCK_LIST_HEIGHT_IMG"),
        "TYPE" => "STRING",
        "DEFAULT" => "674",
    ),
    "LIST_WIDTH_IMG" => array(
        "NAME" => GetMessage("T_IBLOCK_LIST_WIDTH_IMG"),
        "TYPE" => "STRING",
        "DEFAULT" => "1170",
    ),
    "PAGER_TEMPLATE" => Array(
        "HIDDEN" => 'Y',
    ),
    "DISPLAY_TOP_PAGER" => Array(
        "HIDDEN" => 'Y',
    ),
    "DISPLAY_BOTTOM_PAGER" => Array(
        "HIDDEN" => 'Y',
    ),
    "PAGER_TITLE" => Array(
        "HIDDEN" => 'Y',
    ),
    "PAGER_SHOW_ALWAYS" => Array(
        "HIDDEN" => 'Y',
    ),
    "PAGER_DESC_NUMBERING" => Array(
        "HIDDEN" => 'Y',
    ),
    "PAGER_DESC_NUMBERING_CACHE_TIME" => Array(
        "HIDDEN" => 'Y',
    ),
    "PAGER_SHOW_ALL" => Array(
        "HIDDEN" => 'Y',
    ),                 
);
?>
