<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бренды");
?><?$APPLICATION->IncludeComponent(
	"kit:news",
	"ms_brands",
	Array(
		"ADD_ELEMENT_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CATEGORY_CODE" => "CATEGORY",
		"CATEGORY_IBLOCK" => "",
		"CATEGORY_ITEMS_COUNT" => "5",
		"CHECK_DATES" => "Y",
		"COLOR_IN_PRODUCT" => COption::GetOptionString("kit.b2bshop","COLOR_IN_PRODUCT",""),
		"COLOR_IN_PRODUCT_CODE" => COption::GetOptionString("kit.b2bshop","COLOR_IN_PRODUCT_CODE",""),
		"COLOR_IN_PRODUCT_LINK" => COption::GetOptionString("kit.b2bshop","COLOR_IN_PRODUCT_LINK",""),
		"COLOR_IN_SECTION_LINK" => COption::GetOptionString("kit.b2bshop","COLOR_IN_SECTION_LINK","1"),
		"COLOR_IN_SECTION_LINK_MAIN" => COption::GetOptionString("kit.b2bshop","COLOR_IN_SECTION_LINK_MAIN",""),
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "Y",
		"DETAIL_FIELD_CODE" => array("PREVIEW_PICTURE",""),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => array("",""),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"FILTER_FIELD_CODE" => array("",""),
		"FILTER_NAME" => "",
		"FILTER_PROPERTY_CODE" => array("",""),
		"FORUM_ID" => "1",
		"GROUP_PERMISSIONS" => array(0=>"1",),
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"IBLOCK_ID" => COption::GetOptionString("kit.b2bshop","BRAND_IBLOCK_ID",""),
		"IBLOCK_ID_CATALOG" => COption::GetOptionString("kit.b2bshop","IBLOCK_TYPE",""),
		"IBLOCK_TYPE" => COption::GetOptionString("kit.b2bshop","BRAND_IBLOCK_TYPE",""),
		"IBLOCK_TYPE_CATALOG" => COption::GetOptionString("kit.b2bshop","IBLOCK_ID",""),
		"IMAGE_RESIZE_MODE" => COption::GetOptionString("kit.b2bshop","IMAGE_RESIZE_MODE","BX_RESIZE_IMAGE_PROPORTIONAL"),
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LAZY_LOAD" => COption::GetOptionString("kit.b2bshop","LAZY_LOAD",""),
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array("",""),
		"LIST_PROPERTY_CODE" => array("",""),
		"MAILING_CATEGORIES_ID" => array(),
		"MAILING_EMAIL_SEND_END" => "<label>Вы подписаны на новинки бренда</label>",
		"MAILING_INFO_TEXT" => "Хотите узнавать о новых поступлениях данного бренда?",
		"MAX_VOTE" => "5",
		"MESSAGES_PER_PAGE" => "10",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => COption::GetOptionString("kit.b2bshop","CATALOG_LIST_COUNT","36"),
		"NUM_DAYS" => "30",
		"NUM_NEWS" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "brand",
		"PAGER_TITLE" => "Новости",
		"PAGE_ELEMENT_COUNT_IN_ROW" => COption::GetOptionString("kit.b2bshop","CATALOG_LIST_COUNT_IN_ROW","4"),
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"POST_FIRST_MESSAGE" => "Y",
		"PRELOADER" => COption::GetOptionString("kit.preloader","IMAGE",""),
		"PREVIEW_TRUNCATE_LEN" => "",
		"PRICE_CODE" => unserialize(COption::GetOptionString("kit.b2bshop","PRICE_CODE","")),
		"REVIEW_AJAX_POST" => "Y",
		"SEF_FOLDER" => "#SITE_DIR#brands/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => Array("detail"=>"#ELEMENT_CODE#/","news"=>"search/","section"=>"rss/"),
		'SEOMETA_TAGS' =>  COption::GetOptionString("kit.b2bshop","SEOMETA_TAGS","BOTTOM"),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SHOW_LINK_TO_FORUM" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"TEL_DELIVERY_ID" => COption::GetOptionString("kit.b2bshop","TEL_DELIVERY_ID",""),
		"TEL_MASK" => COption::GetOptionString("kit.b2bshop","TEL_MASK","+7(999)999-99-99"),
		"TEL_PAY_SYSTEM_ID" => COption::GetOptionString("kit.b2bshop","TEL_PAY_SYSTEM_ID",""),
		"URL_TEMPLATES_READ" => "",
		"USE_CAPTCHA" => "Y",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "Y",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_REVIEW" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"VOTE_NAMES" => array(0=>"0",1=>"1",2=>"2",3=>"3",4=>"4",),
		"YANDEX" => "Y"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>