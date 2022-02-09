<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


// ������� �������
// START
$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
$arFilter = Array("TYPE_ID" => "FEEDBACK_FORM", "ACTIVE" => "Y");
if($site !== false)
    $arFilter["LID"] = $site;

$arEvent = Array();
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext())
    $arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];
//END

$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr=$rsProp->Fetch())
{
    $arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "E")))
    {
        $arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    }
}

$arTemplateParameters = array( 
    "FEEDBACK_LEFT_COLUMN" => array(
        "NAME" => GetMessage("FEEDBACK_LEFT_COLUMN_TITLE"),
        "TYPE"=>"CHECKBOX",
        "DEFAULT" => 'N'       
    ),
    "FEEDBACK_EVENT_MESSAGE_ID" => array(
        "NAME" => GetMessage("FEEDBACK_EVENT_MESSAGE_ID_TITLE"),
        "PARENT" => "MISS_SHOP", 
        "TYPE"=>"LIST", 
        "VALUES" => $arEvent,
        "MULTIPLE"=>"Y", 
        "COLS"=>25,           
    ),
    "FEEDBACK_EMAIL_TO" => array(
        "NAME" => GetMessage("FEEDBACK_EMAIL_TO_TITLE"),
        "PARENT" => "MISS_SHOP", 
        "TYPE"=>"TEXT", 
    ),
    "FEEDBACK_USE_CAPTCHA" => array(
        "NAME" => GetMessage("FEEDBACK_USE_CAPTCHA_TITLE"),
        "PARENT" => "MISS_SHOP", 
        "TYPE"=>"CHECKBOX",
        "DEFAULT" => 'N'
    ),
    "MAP_NOT_SHOW" => array(
        "NAME" => GetMessage("MYMS_DONT_SHOW_TITLE"),
        "TYPE"=>"CHECKBOX",
        "DEFAULT" => 'N'       
    ),    
    'INIT_MAP_TYPE' => array(
            'NAME' => GetMessage('MYMS_PARAM_INIT_MAP_TYPE'),
            'TYPE' => 'LIST',
            'VALUES' => array(
                'MAP' => GetMessage('MYMS_PARAM_INIT_MAP_TYPE_MAP'),
                'SATELLITE' => GetMessage('MYMS_PARAM_INIT_MAP_TYPE_SATELLITE'),
                'HYBRID' => GetMessage('MYMS_PARAM_INIT_MAP_TYPE_HYBRID'),
                'PUBLIC' => GetMessage('MYMS_PARAM_INIT_MAP_TYPE_PUBLIC'),
                'PUBLIC_HYBRID' => GetMessage('MYMS_PARAM_INIT_MAP_TYPE_PUBLIC_HYBRID'),
            ),
            'DEFAULT' => 'MAP',
            'ADDITIONAL_VALUES' => 'N',
    ),    
    'MAP_CONTROLS' => array(
        'NAME' => GetMessage('MYMS_PARAM_CONTROLS'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'Y',
        'VALUES' => array(
                'ZOOM' => GetMessage('MYMS_PARAM_CONTROLS_ZOOM'),
                'SMALLZOOM' => GetMessage('MYMS_PARAM_CONTROLS_SMALLZOOM'),
                'MINIMAP' => GetMessage('MYMS_PARAM_CONTROLS_MINIMAP'),
                'TYPECONTROL' => GetMessage('MYMS_PARAM_CONTROLS_TYPECONTROL'),
                'SCALELINE' => GetMessage('MYMS_PARAM_CONTROLS_SCALELINE'),
                'SEARCH' => GetMessage('MYMS_PARAM_CONTROLS_SEARCH'),
        ),

        'DEFAULT' => array('ZOOM', 'TYPECONTROL', 'SCALELINE'),
    ),
    'MAP_OPTIONS' => array(
        'NAME' => GetMessage('MYMS_PARAM_OPTIONS'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'Y',
        'VALUES' => array(
                'ENABLE_SCROLL_ZOOM' => GetMessage('MYMS_PARAM_OPTIONS_ENABLE_SCROLL_ZOOM'),
                'ENABLE_DBLCLICK_ZOOM' => GetMessage('MYMS_PARAM_OPTIONS_ENABLE_DBLCLICK_ZOOM'),
                'ENABLE_RIGHT_MAGNIFIER' => GetMessage('MYMS_PARAM_OPTIONS_ENABLE_RIGHT_MAGNIFIER'),
                'ENABLE_DRAGGING' => GetMessage('MYMS_PARAM_OPTIONS_ENABLE_DRAGGING'),
        ),


        'DEFAULT' => array('ENABLE_SCROLL_ZOOM', 'ENABLE_DBLCLICK_ZOOM', 'ENABLE_DRAGGING'),
    ),                   
    "MAP_YANDEX_LAN" => array(
        "NAME" => GetMessage("MYMS_YANDEX_LAN"),
        "TYPE"=>"TEXT", 
        "DEFAULT" => '55.753526416014644',
    ),     
    "MAP_YANDEX_LON" => array(
        "NAME" => GetMessage("MYMS_YANDEX_LON"),
        "TYPE"=>"TEXT", 
        "DEFAULT" => '37.62241543769838',
    ),
    "MAP_PLACE_CORDINATES" => array(
        "NAME" => GetMessage("MYMS_PLACE_CORDINATES"),
        "TYPE"=>"CHECKBOX", 
        "DEFAULT" => 'Y'
    ),           
    "MAP_SCALE" => array(
        "NAME" => GetMessage("MYMS_PARAM_SCALE"),
        "TYPE"=>"TEXT", 
        "DEFAULT" => 12
    ),                  
    'MAP_WIDTH' => array(
        'NAME' => GetMessage('MYMS_PARAM_MAP_WIDTH'),
        'TYPE' => 'STRING',
        'DEFAULT' => '520',
    ),
    'MAP_HEIGHT' => array(
        'NAME' => GetMessage('MYMS_PARAM_MAP_HEIGHT'),
        'TYPE' => 'STRING',
        'DEFAULT' => '500',
    ),
    "MAP_PROPERTY_PLACEMARKS" => array(
            "NAME" => GetMessage("MYMS_MAP_PROPERTY_PLACEMARKS"),
            "TYPE" => "LIST",
            "MULTIPLE" => "N",
            "VALUES" => $arProperty_LNS,
            "ADDITIONAL_VALUES" => "Y",
    ),
    "MAP_PROPERTY_ICON" => array(
            "NAME" => GetMessage("MYMS_MAP_PROPERTY_ICON"),
            "TYPE" => "LIST",
            "MULTIPLE" => "N",
            "VALUES" => $arProperty_LNS,
            "ADDITIONAL_VALUES" => "Y",
    ), 
    "MAP_PROPERTY_TITLE" => array(
            "NAME" => GetMessage("MYMS_MAP_PROPERTY_TITLE"),
            "TYPE" => "LIST",
            "MULTIPLE" => "N",
            "VALUES" => $arProperty_LNS,
            "ADDITIONAL_VALUES" => "Y",
    ), 
    "MAP_PROPERTY_TEXT" => array(
            "NAME" => GetMessage("MYMS_MAP_PROPERTY_TEXT"),
            "TYPE" => "LIST",
            "MULTIPLE" => "N",
            "VALUES" => $arProperty_LNS,
            "ADDITIONAL_VALUES" => "Y",
    ),            
    'MAP_ID' => array(
        'NAME' => GetMessage('MYMS_PARAM_MAP_ID'),
        'TYPE' => 'STRING',
        'DEFAULT' => 'ms_contact',
    ),                                 
);

$hidden_param = array(
    'USE_SEARCH',
    'USE_RSS',
    'USE_RATING',
    'USE_CATEGORIES',
    'USE_REVIEW',
    'USE_FILTER',
    'SET_TITLE',
    'INCLUDE_IBLOCK_INTO_CHAIN',
    'SET_STATUS_404',
    'SEF_MODE',
    'VARIABLE_ALIASES_SECTION_ID',
    'VARIABLE_ALIASES_ELEMENT_ID',
    'ADD_SECTIONS_CHAIN',
    'SET_TITLE',
    'ADD_ELEMENT_CHAIN',
    'USE_PERMISSIONS',
    //detail
    'DISPLAY_NAME',
    'META_KEYWORDS',
    'META_DESCRIPTION',
    'BROWSER_TITLE',
    'DETAIL_ACTIVE_DATE_FORMAT',
    'DETAIL_FIELD_CODE',
    'DETAIL_PROPERTY_CODE',
    //navigation
    'DETAIL_DISPLAY_TOP_PAGER',
    'DETAIL_DISPLAY_BOTTOM_PAGER',
    'DETAIL_PAGER_TITLE',
    'DETAIL_PAGER_TEMPLATE',
    'DETAIL_PAGER_SHOW_ALL',
    'PAGER_TEMPLATE',
    'DISPLAY_TOP_PAGER',
    'DISPLAY_BOTTOM_PAGER',
    'PAGER_TITLE',
    'PAGER_SHOW_ALWAYS',
    'PAGER_DESC_NUMBERING',
    'PAGER_DESC_NUMBERING_CACHE_TIME',
    'PAGER_SHOW_ALL'
);

foreach($hidden_param as $prop_kit) {
    $arTemplateParameters[$prop_kit]["HIDDEN"] = 'Y';
}

?>
