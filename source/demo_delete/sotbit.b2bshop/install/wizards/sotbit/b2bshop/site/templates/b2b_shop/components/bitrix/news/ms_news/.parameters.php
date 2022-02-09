<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$arSorts = Array("ASC"=>GetMessage("T_IBLOCK_POPULAR_DESC_ASC"), "DESC"=>GetMessage("T_IBLOCK_POPULAR_DESC_DESC"));
$arSortFields = Array(
        "ID"=>GetMessage("T_IBLOCK_POPULAR_DESC_FID"),
        "NAME"=>GetMessage("T_IBLOCK_POPULAR_DESC_FNAME"),
        "ACTIVE_FROM"=>GetMessage("T_IBLOCK_POPULAR_DESC_FACT"),
        "SORT"=>GetMessage("T_IBLOCK_POPULAR_DESC_FSORT"),
        "TIMESTAMP_X"=>GetMessage("T_IBLOCK_POPULAR_DESC_FTSAMP")
    );


$arTemplateParameters = array(
	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
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
    "DISPLAY_PREVIEW_TEXT" => Array(
        "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "DISPLAY_PAGE_TITLE_TEXT" => Array(
        "NAME" => GetMessage("T_IBLOCK_DISPLAY_PAGE_TITLE"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ),
    "DISPLAY_PAGE_TITLE_TEXT_SECOND" => Array(
        "NAME" => GetMessage("T_IBLOCK_DISPLAY_PAGE_TITLE_SECOND"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ),        
    "LIST_GO_DETAIL_PAGE" => array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_LIST_GO_DETAIL_PAGE"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("T_IBLOCK_LIST_GO_DETAIL_PAGE_DEFAULT"),
    ),   
    "LIST_HEIGHT_IMG" => array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_LIST_HEIGHT_IMG"),
        "TYPE" => "STRING",
        "DEFAULT" => "220",
    ),
    "LIST_WIDTH_IMG" => array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_LIST_WIDTH_IMG"),
        "TYPE" => "STRING",
        "DEFAULT" => "340",
    ),
    "DETAIL_HEIGHT_IMG" => array(
        "PARENT" => "DETAIL_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_DETAIL_HEIGHT_IMG"),
        "TYPE" => "STRING",
        "DEFAULT" => "600",
    ),
    "DETAIL_WIDTH_IMG" => array(
        "PARENT" => "DETAIL_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_DETAIL_WIDTH_IMG"),
        "TYPE" => "STRING",
        "DEFAULT" => "820",
    ),
    "DETAIL_BACK_LIST_TEXT" => array(
        "PARENT" => "DETAIL_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_DETAIL_BACK_LIST_TEXT"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ),    
    "PAGER_MORE_NEWS" => array(
        "PARENT" => "PAGER_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_PAGER_MORE_NEWS"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "PAGER_MORE_NEWS_TEXT" => array(
        "PARENT" => "PAGER_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_PAGER_MORE_NEWS_TEXT"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ),
    
    "POPULAR_NEWS_COUNT" => array(
        "PARENT" => "DETAIL_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_POPULAR_NEWS_COUNT"),
        "TYPE" => "STRING",
        "DEFAULT" => "3",
    ),
    "POPULAR_SORT_BY1" => Array(
        "PARENT" => "DETAIL_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DESC_IBORD1"),
        "TYPE" => "LIST",
        "DEFAULT" => "ACTIVE_FROM",
        "VALUES" => $arSortFields,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "POPULAR_SORT_ORDER1" => Array(
        "PARENT" => "DETAIL_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DESC_IBBY1"),
        "TYPE" => "LIST",
        "DEFAULT" => "DESC",
        "VALUES" => $arSorts,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "POPULAR_SORT_BY2" => Array(
        "PARENT" => "DETAIL_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DESC_IBORD2"),
        "TYPE" => "LIST",
        "DEFAULT" => "SORT",
        "VALUES" => $arSortFields,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "POPULAR_SORT_ORDER2" => Array(
        "PARENT" => "DETAIL_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DESC_IBBY2"),
        "TYPE" => "LIST",
        "DEFAULT" => "ASC",
        "VALUES" => $arSorts,
        "ADDITIONAL_VALUES" => "Y",
    ),    
    "POPULAR_DISPLAY_SECTION" => Array(
        "PARENT" => "DETAIL_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DISPLAY_SECTION"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),    
    "POPULAR_DISPLAY_DATE" => Array(
        "PARENT" => "DETAIL_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DISPLAY_DATE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "POPULAR_DISPLAY_PICTURE" => Array(
        "PARENT" => "DETAIL_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DISPLAY_PICTURE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "POPULAR_HEIGHT_IMG" => array(
        "PARENT" => "DETAIL_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_POPULAR_HEIGHT_IMG"),
        "TYPE" => "STRING",
        "DEFAULT" => "400",
    ),
    "POPULAR_WIDTH_IMG" => array(
        "PARENT" => "DETAIL_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_POPULAR_WIDTH_IMG"),
        "TYPE" => "STRING",
        "DEFAULT" => "270",
    ),
    "POPULAR_DISPLAY_PREVIEW_TEXT" => Array(
        "PARENT" => "DETAIL_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DISPLAY_PREVIEW_TEXT"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "POPULAR_TRUNCATE_LEN" => array(
        "PARENT" => "DETAIL_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_POPULAR_TRUNCATE_LEN"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ),      
    "POPULAR_GO_DETAIL_PAGE" => array(
        "PARENT" => "DETAIL_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_POPULAR_GO_DETAIL_PAGE"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("T_IBLOCK_POPULAR_GO_DETAIL_PAGE_DEFAULT"),
    ),          
    "POPULAR_GO_DETAIL_PAGE" => array(
        "PARENT" => "DETAIL_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_POPULAR_GO_DETAIL_PAGE"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("T_IBLOCK_POPULAR_GO_DETAIL_PAGE_DEFAULT"),
    ),     
    "USE_FILTER" => Array(
        "HIDDEN" => 'Y',
    ),
    "USE_REVIEW" => Array(
        "HIDDEN" => 'Y',
    ),
    "USE_SEARCH" => Array(
        "HIDDEN" => 'Y',
    ),
    "USE_RSS" => Array(
        "HIDDEN" => 'Y',
    ),
    "USE_RATING" => Array(
        "HIDDEN" => 'Y',
    ), 
    "USE_CATEGORIES" => Array(
        "HIDDEN" => 'Y',
    ),            
);
?>
