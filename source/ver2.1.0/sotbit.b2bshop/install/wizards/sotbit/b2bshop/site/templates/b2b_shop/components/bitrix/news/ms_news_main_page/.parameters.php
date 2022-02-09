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
    "DISPLAY_BLOCK_TITLE_TEXT" => Array(
        "NAME" => GetMessage("T_IBLOCK_DISPLAY_PAGE_TITLE"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ),
    "DISPLAY_BLOCK_TITLE_TEXT_SECOND" => Array(
        "NAME" => GetMessage("T_IBLOCK_DISPLAY_PAGE_TITLE_SECOND"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ), 
	"DISPLAY_DATE_FIRST" => Array(
        "PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE_FIRST"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE_FIRST" => Array(
        "PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE_FIRST"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
    "LIST_HEIGHT_IMG_FIRST" => array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_LIST_HEIGHT_IMG_FIRST"),
        "TYPE" => "STRING",
        "DEFAULT" => "394",
    ),
    "LIST_WIDTH_IMG_FIRST" => array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_LIST_WIDTH_IMG_FIRST"),
        "TYPE" => "STRING",
        "DEFAULT" => "362",
    ), 
    "DISPLAY_PREVIEW_TEXT_FIRST" => Array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT_FIRST"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),           
    "DISPLAY_DATE_OTHER" => Array(
        "PARENT" => "LIST_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE_OTHER"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),        
    
    "POPULAR_NEWS_COUNT" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("T_IBLOCK_POPULAR_NEWS_COUNT"),
        "TYPE" => "STRING",
        "DEFAULT" => "3",
    ),
    "POPULAR_SORT_BY1" => Array(
        "PARENT" => "LIST_SETTINGS", 
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DESC_IBORD1"),
        "TYPE" => "LIST",
        "DEFAULT" => "ACTIVE_FROM",
        "VALUES" => $arSortFields,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "POPULAR_SORT_ORDER1" => Array(
        "PARENT" => "LIST_SETTINGS",     
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DESC_IBBY1"),
        "TYPE" => "LIST",
        "DEFAULT" => "DESC",
        "VALUES" => $arSorts,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "POPULAR_SORT_BY2" => Array(
        "PARENT" => "LIST_SETTINGS",     
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DESC_IBORD2"),
        "TYPE" => "LIST",
        "DEFAULT" => "SORT",
        "VALUES" => $arSortFields,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "POPULAR_SORT_ORDER2" => Array(
        "PARENT" => "LIST_SETTINGS",  
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DESC_IBBY2"),
        "TYPE" => "LIST",
        "DEFAULT" => "ASC",
        "VALUES" => $arSorts,
        "ADDITIONAL_VALUES" => "Y",
    ),      
    "POPULAR_DISPLAY_DATE" => Array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DISPLAY_DATE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "POPULAR_DISPLAY_PICTURE" => Array(
        "PARENT" => "LIST_SETTINGS",     
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DISPLAY_PICTURE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "POPULAR_HEIGHT_IMG" => array(
        "PARENT" => "LIST_SETTINGS",     
        "NAME" => GetMessage("T_IBLOCK_POPULAR_HEIGHT_IMG"),
        "TYPE" => "STRING",
        "DEFAULT" => "338",
    ),
    "POPULAR_WIDTH_IMG" => array(
        "PARENT" => "LIST_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_POPULAR_WIDTH_IMG"),
        "TYPE" => "STRING",
        "DEFAULT" => "342",
    ),
    "POPULAR_DISPLAY_PREVIEW_TEXT" => Array(
        "PARENT" => "LIST_SETTINGS",     
        "NAME" => GetMessage("T_IBLOCK_POPULAR_DISPLAY_PREVIEW_TEXT"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "POPULAR_TRUNCATE_LEN" => array(
        "PARENT" => "LIST_SETTINGS",    
        "NAME" => GetMessage("T_IBLOCK_POPULAR_TRUNCATE_LEN"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ),      
    "POPULAR_GO_DETAIL_PAGE" => array(
        "PARENT" => "LIST_SETTINGS",     
        "NAME" => GetMessage("T_IBLOCK_POPULAR_GO_DETAIL_PAGE"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("T_IBLOCK_POPULAR_GO_DETAIL_PAGE_DEFAULT"),
    ),          
    "POPULAR_GO_DETAIL_PAGE" => array(
        "PARENT" => "LIST_SETTINGS",    
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
    "SEF_MODE" => Array(

    ),   
    "VARIABLE_ALIASES" => Array(

    ),
    "VARIABLE_ALIASES_ELEMENT_ID" => Array(
        "HIDDEN" => 'Y',
    ),        
    "DISPLAY_NAME" => Array(
        "HIDDEN" => 'Y',
    ),
    "META_KEYWORDS" => Array(
        "HIDDEN" => 'Y',
    ),
    "META_DESCRIPTION" => Array(
        "HIDDEN" => 'Y',
    ),  
    "META_KEYWORDS" => Array(
        "HIDDEN" => 'Y',
    ),  
    "BROWSER_TITLE" => Array(
        "HIDDEN" => 'Y',
    ),
    "LIST_FIELD_CODE" => Array(
        "HIDDEN" => 'Y',
    ), 
    "LIST_FIELD_CODE" => Array(
        "HIDDEN" => 'Y',
    ), 
    "LIST_PROPERTY_CODE" => Array(
        "HIDDEN" => 'Y',
    ),         
    "DETAIL_ACTIVE_DATE_FORMAT" => Array(
        "HIDDEN" => 'Y',
    ),  
    "DETAIL_FIELD_CODE" => Array(
        "HIDDEN" => 'Y',
    ),  
    "DETAIL_PROPERTY_CODE" => Array(
        "HIDDEN" => 'Y',
    ),
    "DETAIL_DISPLAY_TOP_PAGER" => Array(
        "HIDDEN" => 'Y',
    ),
    "DETAIL_DISPLAY_BOTTOM_PAGER" => Array(
        "HIDDEN" => 'Y',
    ),  
    "DETAIL_PAGER_TITLE" => Array(
        "HIDDEN" => 'Y',
    ),  
    "DETAIL_PAGER_TEMPLATE" => Array(
        "HIDDEN" => 'Y',
    ),
    "DETAIL_PAGER_SHOW_ALL" => Array(
        "HIDDEN" => 'Y',
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
