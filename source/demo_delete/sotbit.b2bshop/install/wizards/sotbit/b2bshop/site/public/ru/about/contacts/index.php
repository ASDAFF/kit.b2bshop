<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?><?$APPLICATION->IncludeComponent(
    "bitrix:news", 
    "ms_contact", 
    array(
        "DISPLAY_DATE" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "SEF_MODE" => "N",
        "AJAX_MODE" => "N",
        "IBLOCK_TYPE" => "b2bs_content",
        "IBLOCK_ID" => "#SHOP_IBLOCK_ID#",
        "NEWS_COUNT" => "20",
        "USE_SEARCH" => "N",
        "USE_RSS" => "N",
        "USE_RATING" => "N",
        "USE_CATEGORIES" => "N",
        "USE_REVIEW" => "N",
        "USE_FILTER" => "N",
        "SORT_BY1" => "SORT",
        "SORT_ORDER1" => "ASC",
        "SORT_BY2" => "NAME",
        "SORT_ORDER2" => "DESC",
        "CHECK_DATES" => "Y",
        "PREVIEW_TRUNCATE_LEN" => "",
        "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "LIST_FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "LIST_PROPERTY_CODE" => array(
            0 => "PHONE",
            1 => "ADDRESS",
            2 => "FAX",
            3 => "POST",
            4 => "EMAIL",
            5 => "TINEWORK",
            6 => "PLACEMARKS",
            7 => "",
        ),
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "DISPLAY_NAME" => "Y",
        "META_KEYWORDS" => "-",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "-",
        "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "DETAIL_FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "DETAIL_PROPERTY_CODE" => array(
            0 => "",
            1 => "",
        ),
        "DETAIL_DISPLAY_TOP_PAGER" => "N",
        "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
        "DETAIL_PAGER_TITLE" => "Страница",
        "DETAIL_PAGER_TEMPLATE" => "",
        "DETAIL_PAGER_SHOW_ALL" => "Y",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "ADD_ELEMENT_CHAIN" => "N",
        "USE_PERMISSIONS" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_NOTES" => "",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "Новости",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "COMPONENT_TEMPLATE" => "ms_contact",
        "FEEDBACK_FORM" => "",
        "FEEDBACK_EVENT_MESSAGE_ID" => array(
        ),
        "FEEDBACK_OK_TEXT" => "Спасибо, ваше сообщение принято.",
        "FEEDBACK_EMAIL_TO" => COption::GetOptionString("main", "email_from"),
        "FEEDBACK_USE_CAPTCHA" => "N",
        "MAP_CONTROLS" => array(
            0 => "ZOOM",
            1 => "TYPECONTROL",
            2 => "SCALELINE",
        ),
        "MAP_OPTIONS" => array(
            0 => "ENABLE_SCROLL_ZOOM",
            1 => "ENABLE_DBLCLICK_ZOOM",
            2 => "ENABLE_DRAGGING",
        ),
        "MAP_WIDTH" => "520",
        "MAP_HEIGHT" => "655",
        "MAP_ID" => "ms_contact",
        "MAP_DATA" => "a:3:{s:10:\"yandex_lat\";N;s:10:\"yandex_lon\";N;s:12:\"yandex_scale\";i:10;}",
        "MAP_SCALE" => "12",
        "MAP_PROPERTY_PLACEMARKS" => "PLACEMARKS",
        "MAP_PROPERTY_ICON" => "PLACEMARKS_ICON",
        "MAP_PROPERTY_TITLE" => "PLACEMARKS_TITLE",
        "MAP_PROPERTY_TEXT" => "PLACEMARKS_TEXT",
        "INIT_MAP_TYPE" => "MAP",
        "MAP_PLACE_CORDINATES" => "Y",
        "MAP_YANDEX_LAN" => "55.753526416014644",
        "MAP_YANDEX_LON" => "37.62241543769838",
        "FEEDBACK_LEFT_COLUMN" => "N",
        "MAP_NOT_SHOW" => "N",
        "VARIABLE_ALIASES" => array(
            "SECTION_ID" => "SECTION_ID",
            "ELEMENT_ID" => "ELEMENT_ID",
        )
    ),
    false
);?>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>