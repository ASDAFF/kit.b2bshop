<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"DISPLAY_PICTURE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
    "DISPLAY_BLOCK_TITLE_TEXT" => Array(
        "NAME" => GetMessage("T_IBLOCK_DISPLAY_BLOCK_TITLE"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ),
    "DISPLAY_BLOCK_TITLE_TEXT_SECOND" => Array(
        "NAME" => GetMessage("T_IBLOCK_DISPLAY_BLOCK_TITLE_SECOND"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
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
