        <?/*Main banner*/
       /* global $arBannerFilter;
        //$arBannerFilter["PROPERTY_TYPE_XML_ID"] = "main";
        $arBannerFilter["PROPERTY_TYPE"] = "435";  */
        ?>
        <?  
        global $BRAND_PROP;
        global $BRAND_IBLOCK_ID;
        global $BRAND_IBLOCK_TYPE;
        
        $BANNER_IBLOCK_TYPE = COption::GetOptionString("kit.b2bshop", "BANNER_IBLOCK_TYPE", "");
        $BANNER_IBLOCK_ID = COption::GetOptionString("kit.b2bshop", "BANNER_IBLOCK_ID", "");
        $APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"miss-banner-main-big", 
	array(
		"IBLOCK_TYPE" => "-",
		"IBLOCK_ID" => $BANNER_IBLOCK_ID,
		"NEWS_COUNT" => "10",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER2" => "DESC",
		"FILTER_NAME" => "arBannerFilter",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "LINK",
			1 => "VIDEO",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION_CODE" => "main-banner",
		"INCLUDE_SUBSECTIONS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"PARENT_SECTION" => "",
		"COMPONENT_TEMPLATE" => "miss-banner-main-big",
		"LIST_HEIGHT_IMG" => "674",
		"LIST_WIDTH_IMG" => "1170"
	),
	false
);?>
        <?/*End main banner*/?>

        <div class="main-center-block">
            <?/*Small banner*/
           /* global $arBannerFilter;
            //$arBannerFilter["PROPERTY_TYPE_ENUM_ID"] = "dop";
            $arBannerFilter["PROPERTY_TYPE"] = "436";   */
            ?>
            <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"miss-banner-main-small", 
	array(
		"IBLOCK_TYPE" => "-",
		"IBLOCK_ID" => $BANNER_IBLOCK_ID,
		"NEWS_COUNT" => "3",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "arBannerFilter",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "LINK",
			2 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION_CODE" => "bannery-na-glavnoy-pod-slayderom",
		"INCLUDE_SUBSECTIONS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "miss-banner-main-small",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"PARENT_SECTION" => "",
		"LIST_HEIGHT_IMG" => "226",
		"LIST_WIDTH_IMG" => "370"
	),
	false
);?>
            <?/*End small banner*/?>
            
         <?/*block slide brand*/?>
         <?
         if($BRAND_PROP && $BRAND_IBLOCK_ID && $BRAND_IBLOCK_TYPE)
         {
         $arFilterPage["PROPERTY_MAIN_PAGE_SHOW_VALUE"] = "Y";
         ?>   
        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list", 
            "ms_brand_slide_main", 
            array(
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "N",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "AJAX_MODE" => "N",
                "IBLOCK_TYPE" => $BRAND_IBLOCK_TYPE,
                "IBLOCK_ID" => $BRAND_IBLOCK_ID,
                "NEWS_COUNT" => "20",
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_BY2" => "SORT",
                "SORT_ORDER2" => "ASC",
                "FILTER_NAME" => "arFilterPage",
                "FIELD_CODE" => array(
                    0 => "",
                    1 => "",
                ),
                "PROPERTY_CODE" => array(
                    0 => "",
                    1 => "",
                ),
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "SET_TITLE" => "N",
                "SET_BROWSER_TITLE" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_STATUS_404" => "N",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "ADD_SECTIONS_CHAIN" => "N",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "INCLUDE_SUBSECTIONS" => "Y",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_NOTES" => "",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "PAGER_TEMPLATE" => ".default",
                "DISPLAY_TOP_PAGER" => "N",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "PAGER_TITLE" => "Р В РЎСљР В РЎвЂўР В Р вЂ Р В РЎвЂўР РЋР С“Р РЋРІР‚С™Р В РЎвЂ�",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "COMPONENT_TEMPLATE" => "ms_brand_slide_main",
                "DISPLAY_BLOCK_TITLE_TEXT" => "",
                "DISPLAY_BLOCK_TITLE_TEXT_SECOND" => GetMessage("HEADER_BRAND_TITLE_TEXT")
            ),
            false
        );
        }
        ?> 
        <?/*end block slide brand*/?> 
        
        </div>  <?/*end main-center-block*/?>
        <?
        $PriceCode=unserialize(COption::GetOptionString("kit.b2bshop", "PRICE_CODE", ""));
        $APPLICATION->IncludeComponent(
	"shs:shs.onlinebuyers", 
	"main", 
	array(
		"ONLINE_TYPE" => "0",
		"IMAGE_WIDTH" => "255",
		"IMAGE_HEIGHT" => "448",
		"SHOW_NAME" => "0",
		"SHOW_COUNT_BUYERS" => "Y",
		"SHOW_CITY" => "N",
		"TYPE_COUNT_BUYERS" => "1",
		"TYPE_COUNT_BUYERS_MIN" => "10",
		"TYPE_COUNT_BUYERS_MAX" => "20",
		"PRICE_CODE" => $PriceCode[0],//unserialize(COption::GetOptionString("kit.b2bshop", "PRICE_CODE", "")),
		"CONVERT_CURRENCY" => "Y",
        "CURRENCY_ID" => "RUB",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"SITE" => SITE_ID,
		"ELEMENT_COUNT" => "20",
		"JQUERY" => "N",
		"BASKET_URL" => COption::GetOptionString("kit.b2bshop","URL_CART",""),
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"OFFERS_CART_PROPERTIES" => array(
			0 => "RAZMER_ATTR_S_DIRECTORY",
			1 => "TSVET_ATTR_S_DIRECTORY",
			2 => "CML2_MANUFACTURER",
		),
		"OFFER_TREE_PROPS" => unserialize(COption::GetOptionString("kit.b2bshop", "OFFER_TREE_PROPS", "")),
		"TYPE_MODE" => "Y",
		"IBLOCK_TYPE" => COption::GetOptionString("kit.b2bshop","IBLOCK_TYPE",""),
		"IBLOCK_ID" => COption::GetOptionString("kit.b2bshop","IBLOCK_ID",""),
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "",
		"HIDE_NOT_AVAILABLE" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "PROIZVODITEL_ATTR_E",
			2 => "",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => unserialize(COption::GetOptionString("kit.b2bshop", "OFFER_TREE_PROPS", "")),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_LIMIT" => "100",
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"CACHE_GROUPS" => "Y",
		"DISPLAY_COMPARE" => "N",
		"CACHE_FILTER" => "N",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
        
        "OFFER_COLOR_PROP" => COption::GetOptionString("kit.b2bshop", "OFFER_COLOR_PROP", ""),
        "MANUFACTURER_ELEMENT_PROPS" => COption::GetOptionString("kit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", ""),
        "MANUFACTURER_LIST_PROPS" => COption::GetOptionString("kit.b2bshop", "MANUFACTURER_LIST_PROPS", ""),
        "FLAG_PROPS" => unserialize(COption::GetOptionString("kit.b2bshop", "FLAG_PROPS", "")),
        "DELETE_OFFER_NOIMAGE" => COption::GetOptionString("kit.b2bshop", "DELETE_OFFER_NOIMAGE", ""),
        "PICTURE_FROM_OFFER" => COption::GetOptionString("kit.b2bshop", "PICTURE_FROM_OFFER", ""),
        "MORE_PHOTO_PRODUCT_PROPS" => COption::GetOptionString("kit.b2bshop", "MORE_PHOTO_PRODUCT_PROPS", ""),
        "MORE_PHOTO_OFFER_PROPS" => COption::GetOptionString("kit.b2bshop", "MORE_PHOTO_OFFER_PROPS", ""),
        "AVAILABLE_DELETE" => COption::GetOptionString("kit.b2bshop", "AVAILABLE_DELETE", "N"),
		"LIST_WIDTH_SMALL" => "90",
		"LIST_HEIGHT_SMALL" => "150",
		"LIST_WIDTH_MEDIUM" => "255",
		"LIST_HEIGHT_MEDIUM" => "455",
		"DETAIL_WIDTH_SMALL" => COption::GetOptionString("kit.b2bshop","DETAIL_WIDTH_SMALL",""),
		"DETAIL_HEIGHT_SMALL" => COption::GetOptionString("kit.b2bshop","DETAIL_HEIGHT_SMALL",""),
		"DETAIL_WIDTH_MEDIUM" => COption::GetOptionString("kit.b2bshop","DETAIL_WIDTH_MEDIUM",""),
		"DETAIL_HEIGHT_MEDIUM" => COption::GetOptionString("kit.b2bshop","DETAIL_HEIGHT_MEDIUM",""),
		"DETAIL_WIDTH_BIG" => COption::GetOptionString("kit.b2bshop","DETAIL_WIDTH_BIG",""),
		"DETAIL_HEIGHT_BIG" => COption::GetOptionString("kit.b2bshop","DETAIL_HEIGHT_BIG",""),
		"DETAIL_PROPERTY_CODE" => unserialize(COption::GetOptionString("kit.b2bshop", "ALL_PROPS", "")),
		"COMPONENT_TEMPLATE" => "main"
	),
	false
);?>

         <?/*start block news*/
        $NEWS_IBLOCK_TYPE = COption::GetOptionString("kit.b2bshop", "NEWS_IBLOCK_TYPE", "");
        $NEWS_IBLOCK_ID = COption::GetOptionString("kit.b2bshop", "NEWS_IBLOCK_ID", "");
         ?>
         <?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"ms_news_main_page", 
	array(
		"DISPLAY_DATE" => "N",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"SEF_MODE" => "N",
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => $NEWS_IBLOCK_TYPE,
		"IBLOCK_ID" => $NEWS_IBLOCK_ID,
		"NEWS_COUNT" => "6",
		"USE_SEARCH" => "N",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "N",
		"USE_REVIEW" => "N",
		"USE_FILTER" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"CHECK_DATES" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"LIST_ACTIVE_DATE_FORMAT" => "j F Y",
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "VIDEO",
			1 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_NAME" => "Y",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_FIELD_CODE" => "",
		"DETAIL_PROPERTY_CODE" => "",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "Р В Р Р‹Р РЋРІР‚С™Р РЋР вЂљР В Р’В°Р В Р вЂ¦Р В РЎвЂ�Р РЋРІР‚В Р В Р’В°",
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
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "ms_news_main_page",
		"SEF_FOLDER" => "",
		"DISPLAY_PICTURE_OTHER" => "N",
		"DISPLAY_PICTURE_FIRST" => "Y",
		"DISPLAY_PREVIEW_TEXT_FIRST" => "Y",
		"DISPLAY_DATE_FIRST" => "Y",
		"DISPLAY_DATE_OTHER" => "Y",
		"LIST_HEIGHT_IMG_FIRST" => "362",
		"LIST_WIDTH_IMG_FIRST" => "394",
		"POPULAR_NEWS_COUNT" => "3",
		"POPULAR_SORT_BY1" => "SHOW_COUNTER",
		"POPULAR_SORT_ORDER1" => "DESC",
		"POPULAR_SORT_BY2" => "SORT",
		"POPULAR_SORT_ORDER2" => "ASC",
		"POPULAR_DISPLAY_SECTION" => "Y",
		"POPULAR_DISPLAY_DATE" => "Y",
		"POPULAR_DISPLAY_PICTURE" => "Y",
		"POPULAR_HEIGHT_IMG" => "338",
		"POPULAR_WIDTH_IMG" => "342",
		"POPULAR_DISPLAY_PREVIEW_TEXT" => "Y",
		"POPULAR_TRUNCATE_LEN" => "",
		"POPULAR_GO_DETAIL_PAGE" => GetMessage("HEADER_NEWS_DETAIL_PAGE"),
		"DISPLAY_BLOCK_TITLE_TEXT" => "",
		"DISPLAY_BLOCK_TITLE_TEXT_SECOND" => GetMessage("HEADER_NEWS_ONLINE")
	),
	false
);?>      
        <?/*end block news*/?>
        
        
        
        <div class="block_seo">
          <div class='container'>
            <div class='row'>
                <div class='col-sm-24 sm-padding-no'> 
                  <?$APPLICATION->IncludeFile(SITE_DIR."include/miss-header-text.php",
                    Array(),
                    Array("MODE"=>"html")
                  );?>
                </div>
            </div>
          </div>
        </div>