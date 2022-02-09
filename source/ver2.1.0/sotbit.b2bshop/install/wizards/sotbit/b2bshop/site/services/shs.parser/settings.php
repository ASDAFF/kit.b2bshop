<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("shs.parser") || !CModule::IncludeModule("catalog") || !CModule::IncludeModule("iblock"))
    return;

if(COption::GetOptionString("sotbit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
    return;

WizardServices::IncludeServiceLang("settings.php", 'ru');

$parser = new ShsParserContent();
if($_SESSION["WIZARD_NEWS_IBLOCK_ID"])
{
    $rsSections = CIBlockSection::GetList(array(), array("IBLOCK_ID"=>$_SESSION["WIZARD_NEWS_IBLOCK_ID"]), false, array("ID", "CODE"));
    while($arSections = $rsSections->Fetch())
    {
        $arSect[$arSections["CODE"]] = $arSections["ID"];
    }

}


$arFields = Array
(
    "NAME" => GetMessage("MS_WIZ_PARSER_NAME_1"),
    "TYPE" => "page",
    "RSS" => "http://www.spletnik.ru/look/newsmoda",
    "SORT" => 100,
    "ACTIVE" => "Y",
    "IBLOCK_ID" => $_SESSION["WIZARD_NEWS_IBLOCK_ID"],
    "SECTION_ID" => $arSect["moda"],
    "SELECTOR" => ".content",
    "FIRST_URL" => "www.spletnik.ru",
    "ENCODING" => "utf-8",
    "PREVIEW_TEXT_TYPE" => "html",
    "DETAIL_TEXT_TYPE" => "html",
    "PREVIEW_DELETE_TAG" => "",
    "DETAIL_DELETE_TAG" => "",
    "PREVIEW_FIRST_IMG" => "Y",
    "DETAIL_FIRST_IMG" => "Y",
    "PREVIEW_SAVE_IMG" => "Y",
    "DETAIL_SAVE_IMG" => "Y",
    "BOOL_PREVIEW_DELETE_TAG" => "Y",
    "BOOL_DETAIL_DELETE_TAG" => "N",
    "PREVIEW_DELETE_ELEMENT" => ".category, .date, .small-round, .views, .comments",
    "DETAIL_DELETE_ELEMENT" => "script, .author-caption, .external_banner, .buzzplayer-stage, .article-preview_author",
    "PREVIEW_DELETE_ATTRIBUTE" => "a[href]",
    "DETAIL_DELETE_ATTRIBUTE" => "a[href]",
    "INDEX_ELEMENT" => "Y",
    "CODE_ELEMENT" => "Y",
    "RESIZE_IMAGE" => "Y",
    "CREATE_SITEMAP" => "N",
    "DATE_ACTIVE" => "NOW",
    "DATE_PUBLIC" => "N" ,
    "FIRST_TITLE" => "FIRST",
    "META_TITLE" => "N",
    "META_DESCRIPTION" => "N",
    "META_KEYWORDS" => "N",
    "START_AGENT" => "N",
    "TIME_AGENT" => 0,
    "ACTIVE_ELEMENT" => "Y",
    "SETTINGS" => "YToyOntzOjQ6InBhZ2UiO2E6Njp7czo4OiJzZWxlY3RvciI7czoyMToiLmFydGljbGUtcHJldmlld19taW5pIjtzOjQ6ImhyZWYiO3M6OToiLnJlbGF0aXZlIjtzOjQ6Im5hbWUiO3M6MTg6Ii50ZXh0LXdyYXBwZXIgaDMgYSI7czo0OiJ1bmlxIjtzOjQ6Im5hbWUiO3M6NToic2xlZXAiO3M6MDoiIjtzOjU6InByb3h5IjtzOjA6IiI7fXM6MzoibG9jIjthOjE6e3M6NDoidHlwZSI7czowOiIiO319"
);


$cData = new ShsParserContent;
$rsData = $cData->GetList(array(), array("NAME"=>GetMessage("MS_WIZ_PARSER_NAME_1")));

if(!$arData = $rsData->Fetch())
    $ID = $parser->Add($arFields);
unset($cData);

$arFields = Array
(
    "NAME" => GetMessage("MS_WIZ_PARSER_NAME_2"),
    "TYPE" => "page",
    "RSS" => "http://www.elle.ru/moda/novosty/",
    "SORT" => "100",
    "ACTIVE" => "Y",
    "IBLOCK_ID" => $_SESSION["WIZARD_NEWS_IBLOCK_ID"],
    "SECTION_ID" => $arSect["moda"],
    "SELECTOR" => ".articleContainer",
    "FIRST_URL" => "www.elle.ru",
    "ENCODING" => "utf-8",
    "PREVIEW_TEXT_TYPE" => "html",
    "DETAIL_TEXT_TYPE" => "html",
    "PREVIEW_DELETE_TAG" => "",
    "DETAIL_DELETE_TAG" => "",
    "PREVIEW_FIRST_IMG" => "Y",
    "DETAIL_FIRST_IMG" => "N",
    "PREVIEW_SAVE_IMG" => "Y",
    "DETAIL_SAVE_IMG" => "Y",
    "BOOL_PREVIEW_DELETE_TAG" => "Y",
    "BOOL_DETAIL_DELETE_TAG" => "N",
    "PREVIEW_DELETE_ELEMENT" => ".newsItem__shareList",
    "DETAIL_DELETE_ELEMENT" => "",
    "PREVIEW_DELETE_ATTRIBUTE" => "a[href]",
    "DETAIL_DELETE_ATTRIBUTE" => "a[href]",
    "INDEX_ELEMENT" => "Y",
    "CODE_ELEMENT" => "Y",
    "RESIZE_IMAGE" => "Y",
    "CREATE_SITEMAP" => "N",
    "DATE_ACTIVE" => "NOW",
    "DATE_PUBLIC" => "N",
    "FIRST_TITLE" => "FIRST",
    "META_TITLE" => "N",
    "META_DESCRIPTION" => "N",
    "META_KEYWORDS" => "N",
    "START_AGENT" => "N",
    "TIME_AGENT" => 0,
    "ACTIVE_ELEMENT" => "Y",
    "SETTINGS" => "YToyOntzOjQ6InBhZ2UiO2E6Njp7czo4OiJzZWxlY3RvciI7czo5OiIubmV3c0l0ZW0iO3M6NDoiaHJlZiI7czoyMDoiLm5ld3NJdGVtX19uZXdzVGl0bGUiO3M6NDoibmFtZSI7czoyMDoiLm5ld3NJdGVtX19uZXdzVGl0bGUiO3M6NDoidW5pcSI7czo0OiJuYW1lIjtzOjU6InNsZWVwIjtzOjA6IiI7czo1OiJwcm94eSI7czowOiIiO31zOjM6ImxvYyI7YToxOntzOjQ6InR5cGUiO3M6MDoiIjt9fQ=="
);

$cData = new ShsParserContent;
$rsData = $cData->GetList(array(), array("NAME"=>GetMessage("MS_WIZ_PARSER_NAME_2")));

if(!$arData = $rsData->Fetch())
    $ID = $parser->Add($arFields);
unset($cData);

$arFields = Array
(
    "NAME" => GetMessage("MS_WIZ_PARSER_NAME_3"),
    "TYPE" => "page",
    "RSS" => "http://www.elle.ru/krasota/novosty/",
    "SORT" => 100,
    "ACTIVE" => "Y",
    "IBLOCK_ID" => $_SESSION["WIZARD_NEWS_IBLOCK_ID"],
    "SECTION_ID" => $arSect["krasota"],
    "SELECTOR" => ".articleContainer",
    "FIRST_URL" => "www.elle.ru",
    "ENCODING" => "utf-8",
    "PREVIEW_TEXT_TYPE" => "html",
    "DETAIL_TEXT_TYPE" => "html",
    "PREVIEW_DELETE_TAG" => "",
    "DETAIL_DELETE_TAG" => "",
    "PREVIEW_FIRST_IMG" => "Y",
    "DETAIL_FIRST_IMG" => "Y",
    "PREVIEW_SAVE_IMG" => "Y",
    "DETAIL_SAVE_IMG" => "Y",
    "BOOL_PREVIEW_DELETE_TAG" => "Y",
    "BOOL_DETAIL_DELETE_TAG" => "N",
    "PREVIEW_DELETE_ELEMENT" => ".newsItem__shareList",
    "DETAIL_DELETE_ELEMENT" => "",
    "PREVIEW_DELETE_ATTRIBUTE" => "a[href]",
    "DETAIL_DELETE_ATTRIBUTE" => "a[href]",
    "INDEX_ELEMENT" => "Y",
    "CODE_ELEMENT" => "Y",
    "RESIZE_IMAGE" => "Y",
    "CREATE_SITEMAP" => "N",
    "DATE_ACTIVE" => "NOW",
    "DATE_PUBLIC" => "N",
    "FIRST_TITLE" => "FIRST",
    "META_TITLE" => "N",
    "META_DESCRIPTION" => "N",
    "META_KEYWORDS" => "N",
    "START_AGENT" => "N",
    "TIME_AGENT" => 0,
    "ACTIVE_ELEMENT" => "Y",
    "SETTINGS" => "YToyOntzOjQ6InBhZ2UiO2E6Njp7czo4OiJzZWxlY3RvciI7czo5OiIubmV3c0l0ZW0iO3M6NDoiaHJlZiI7czoyMDoiLm5ld3NJdGVtX19uZXdzVGl0bGUiO3M6NDoibmFtZSI7czoyMDoiLm5ld3NJdGVtX19uZXdzVGl0bGUiO3M6NDoidW5pcSI7czo0OiJuYW1lIjtzOjU6InNsZWVwIjtzOjA6IiI7czo1OiJwcm94eSI7czowOiIiO31zOjM6ImxvYyI7YToxOntzOjQ6InR5cGUiO3M6MDoiIjt9fQ=="
);

$cData = new ShsParserContent;
$rsData = $cData->GetList(array(), array("NAME"=>GetMessage("MS_WIZ_PARSER_NAME_3")));

if(!$arData = $rsData->Fetch())
    $ID = $parser->Add($arFields);
unset($cData);

$arFields = Array
(
    "NAME" => GetMessage("MS_WIZ_PARSER_NAME_4"),
    "TYPE" => "page",
    "RSS" => "http://www.elle.ru/krasota/celebrities-beauty-secrets/",
    "SORT" => 100,
    "ACTIVE" => "Y",
    "IBLOCK_ID" => $_SESSION["WIZARD_NEWS_IBLOCK_ID"],
    "SECTION_ID" => $arSect["krasota"],
    "SELECTOR" => ".articleContainer",
    "FIRST_URL" => "www.elle.ru",
    "ENCODING" => "utf-8",
    "PREVIEW_TEXT_TYPE" => "html",
    "DETAIL_TEXT_TYPE" => "html",
    "PREVIEW_DELETE_TAG" => "Y",
    "DETAIL_DELETE_TAG" => "",
    "PREVIEW_FIRST_IMG" => "Y",
    "DETAIL_FIRST_IMG" => "Y",
    "PREVIEW_SAVE_IMG" => "Y",
    "DETAIL_SAVE_IMG" => "Y",
    "BOOL_PREVIEW_DELETE_TAG" => "Y",
    "BOOL_DETAIL_DELETE_TAG" => "N",
    "PREVIEW_DELETE_ELEMENT" => ".newsItem__shareList",
    "DETAIL_DELETE_ELEMENT" => "",
    "PREVIEW_DELETE_ATTRIBUTE" => "a[href]",
    "DETAIL_DELETE_ATTRIBUTE" => "a[href]",
    "INDEX_ELEMENT" => "Y",
    "CODE_ELEMENT" => "Y",
    "RESIZE_IMAGE" => "Y",
    "CREATE_SITEMAP" => "N",
    "DATE_ACTIVE" => "NOW",
    "DATE_PUBLIC" => "N",
    "FIRST_TITLE" => "FIRST",
    "META_TITLE" => "N",
    "META_DESCRIPTION" => "N",
    "META_KEYWORDS" => "N",
    "START_AGENT" => "N",
    "TIME_AGENT" => 0,
    "ACTIVE_ELEMENT" => "Y",
    "SETTINGS" => "YToyOntzOjQ6InBhZ2UiO2E6Njp7czo4OiJzZWxlY3RvciI7czo5OiIubmV3c0l0ZW0iO3M6NDoiaHJlZiI7czoyMDoiLm5ld3NJdGVtX19uZXdzVGl0bGUiO3M6NDoibmFtZSI7czoyMDoiLm5ld3NJdGVtX19uZXdzVGl0bGUiO3M6NDoidW5pcSI7czo0OiJuYW1lIjtzOjU6InNsZWVwIjtzOjA6IiI7czo1OiJwcm94eSI7czowOiIiO31zOjM6ImxvYyI7YToxOntzOjQ6InR5cGUiO3M6MDoiIjt9fQ=="
);

$cData = new ShsParserContent;
$rsData = $cData->GetList(array(), array("NAME"=>GetMessage("MS_WIZ_PARSER_NAME_4")));

if(!$arData = $rsData->Fetch())
    $ID = $parser->Add($arFields);
unset($cData);

$arFields = Array
(
    "NAME" => GetMessage("MS_WIZ_PARSER_NAME_5"),
    "TYPE" => "page",
    "RSS" => "http://www.elle.ru/krasota/trendy/",
    "SORT" => 100,
    "ACTIVE" => "Y",
    "IBLOCK_ID" => $_SESSION["WIZARD_NEWS_IBLOCK_ID"],
    "SECTION_ID" => $arSect["shopping"],
    "SELECTOR" => ".articleContainer",
    "FIRST_URL" => "www.elle.ru",
    "ENCODING" => "utf-8",
    "PREVIEW_TEXT_TYPE" => "html",
    "DETAIL_TEXT_TYPE" => "html",
    "PREVIEW_DELETE_TAG" => "Y",
    "DETAIL_DELETE_TAG" => "",
    "PREVIEW_FIRST_IMG" => "Y",
    "DETAIL_FIRST_IMG" => "Y",
    "PREVIEW_SAVE_IMG" => "Y",
    "DETAIL_SAVE_IMG" => "Y",
    "BOOL_PREVIEW_DELETE_TAG" => "Y",
    "BOOL_DETAIL_DELETE_TAG" => "N",
    "PREVIEW_DELETE_ELEMENT" => ".newsItem__shareList",
    "DETAIL_DELETE_ELEMENT" => "",
    "PREVIEW_DELETE_ATTRIBUTE" => "a[href]",
    "DETAIL_DELETE_ATTRIBUTE" => "a[href]",
    "INDEX_ELEMENT" => "Y",
    "CODE_ELEMENT" => "Y",
    "RESIZE_IMAGE" => "Y",
    "CREATE_SITEMAP" => "N",
    "DATE_ACTIVE" => "NOW",
    "DATE_PUBLIC" => "N",
    "FIRST_TITLE" => "FIRST",
    "META_TITLE" => "N",
    "META_DESCRIPTION" => "N",
    "META_KEYWORDS" => "N",
    "START_AGENT" => "N",
    "TIME_AGENT" => 0,
    "ACTIVE_ELEMENT" => "Y",
    "SETTINGS" => "YToyOntzOjQ6InBhZ2UiO2E6Njp7czo4OiJzZWxlY3RvciI7czo5OiIubmV3c0l0ZW0iO3M6NDoiaHJlZiI7czoyMDoiLm5ld3NJdGVtX19uZXdzVGl0bGUiO3M6NDoibmFtZSI7czoyMDoiLm5ld3NJdGVtX19uZXdzVGl0bGUiO3M6NDoidW5pcSI7czo0OiJuYW1lIjtzOjU6InNsZWVwIjtzOjA6IiI7czo1OiJwcm94eSI7czowOiIiO31zOjM6ImxvYyI7YToxOntzOjQ6InR5cGUiO3M6MDoiIjt9fQ=="
);

$cData = new ShsParserContent;
$rsData = $cData->GetList(array(), array("NAME"=>GetMessage("MS_WIZ_PARSER_NAME_5")));

if(!$arData = $rsData->Fetch())
    $ID = $parser->Add($arFields);
unset($cData);

$arFields = Array
(
    "NAME" => GetMessage("MS_WIZ_PARSER_NAME_6"),
    "TYPE" => "page",
    "RSS" => "http://www.elle.ru/celebrities/",
    "SORT" => 100,
    "ACTIVE" => "Y",
    "IBLOCK_ID" => $_SESSION["WIZARD_NEWS_IBLOCK_ID"],
    "SECTION_ID" => $arSect["zvezdy"],
    "SELECTOR" => ".articleContainer",
    "FIRST_URL" => "www.elle.ru",
    "ENCODING" => "utf-8",
    "PREVIEW_TEXT_TYPE" => "html",
    "DETAIL_TEXT_TYPE" => "html",
    "PREVIEW_DELETE_TAG" => "Y",
    "DETAIL_DELETE_TAG" => "",
    "PREVIEW_FIRST_IMG" => "Y",
    "DETAIL_FIRST_IMG" => "Y",
    "PREVIEW_SAVE_IMG" => "Y",
    "DETAIL_SAVE_IMG" => "Y",
    "BOOL_PREVIEW_DELETE_TAG" => "Y",
    "BOOL_DETAIL_DELETE_TAG" => "N",
    "PREVIEW_DELETE_ELEMENT" => ".newsItem__shareList",
    "DETAIL_DELETE_ELEMENT" => "",
    "PREVIEW_DELETE_ATTRIBUTE" => "a[href]",
    "DETAIL_DELETE_ATTRIBUTE" => "a[href]",
    "INDEX_ELEMENT" => "Y",
    "CODE_ELEMENT" => "Y",
    "RESIZE_IMAGE" => "Y",
    "CREATE_SITEMAP" => "N",
    "DATE_ACTIVE" => "NOW",
    "DATE_PUBLIC" => "N",
    "FIRST_TITLE" => "FIRST",
    "META_TITLE" => "N",
    "META_DESCRIPTION" => "N",
    "META_KEYWORDS" => "N",
    "START_AGENT" => "N",
    "TIME_AGENT" => 0,
    "ACTIVE_ELEMENT" => "Y",
    "SETTINGS" => "YToyOntzOjQ6InBhZ2UiO2E6Njp7czo4OiJzZWxlY3RvciI7czo5OiIubmV3c0l0ZW0iO3M6NDoiaHJlZiI7czoyMDoiLm5ld3NJdGVtX19uZXdzVGl0bGUiO3M6NDoibmFtZSI7czoyMDoiLm5ld3NJdGVtX19uZXdzVGl0bGUiO3M6NDoidW5pcSI7czo0OiJuYW1lIjtzOjU6InNsZWVwIjtzOjA6IiI7czo1OiJwcm94eSI7czowOiIiO31zOjM6ImxvYyI7YToxOntzOjQ6InR5cGUiO3M6MDoiIjt9fQ=="
);

$cData = new ShsParserContent;
$rsData = $cData->GetList(array(), array("NAME"=>GetMessage("MS_WIZ_PARSER_NAME_6")));

if(!$arData = $rsData->Fetch())
    $ID = $parser->Add($arFields);
unset($cData);


$arFields = Array
(
    "NAME" => GetMessage("MS_WIZ_PARSER_NAME_7"),
    "TYPE" => "page",
    "RSS" => "http://www.spletnik.ru/buzz/showbiz",
    "SORT" => 100,
    "ACTIVE" => "Y",
    "IBLOCK_ID" => $_SESSION["WIZARD_NEWS_IBLOCK_ID"],
    "SECTION_ID" => $arSect["zvezdy"],
    "SELECTOR" => ".content",
    "FIRST_URL" => "www.spletnik.ru",
    "ENCODING" => "utf-8",
    "PREVIEW_TEXT_TYPE" => "html",
    "DETAIL_TEXT_TYPE" => "html",
    "PREVIEW_DELETE_TAG" => "Y",
    "DETAIL_DELETE_TAG" => "",
    "PREVIEW_FIRST_IMG" => "Y",
    "DETAIL_FIRST_IMG" => "Y",
    "PREVIEW_SAVE_IMG" => "Y",
    "DETAIL_SAVE_IMG" => "Y",
    "BOOL_PREVIEW_DELETE_TAG" => "Y",
    "BOOL_DETAIL_DELETE_TAG" => "N",
    "PREVIEW_DELETE_ELEMENT" => ".category, .date, .small-round, .views, .comments",
    "DETAIL_DELETE_ELEMENT" => "script, .author-caption, .external_banner, .buzzplayer-stage, .article-preview_author",
    "PREVIEW_DELETE_ATTRIBUTE" => "a[href], a[onclick]",
    "DETAIL_DELETE_ATTRIBUTE" => "a[href]",
    "INDEX_ELEMENT" => "Y",
    "CODE_ELEMENT" => "Y",
    "RESIZE_IMAGE" => "Y",
    "CREATE_SITEMAP" => "N",
    "DATE_ACTIVE" => "NOW",
    "DATE_PUBLIC" => "N",
    "FIRST_TITLE" => "FIRST",
    "META_TITLE" => "N",
    "META_DESCRIPTION" => "N",
    "META_KEYWORDS" => "N",
    "START_AGENT" => "N",
    "TIME_AGENT" => 0 ,
    "ACTIVE_ELEMENT" => "Y",
    "SETTINGS" => "YToyOntzOjQ6InBhZ2UiO2E6Njp7czo4OiJzZWxlY3RvciI7czoyMToiLmFydGljbGUtcHJldmlld19taW5pIjtzOjQ6ImhyZWYiO3M6OToiLnJlbGF0aXZlIjtzOjQ6Im5hbWUiO3M6MTg6Ii50ZXh0LXdyYXBwZXIgaDMgYSI7czo0OiJ1bmlxIjtzOjQ6Im5hbWUiO3M6NToic2xlZXAiO3M6MDoiIjtzOjU6InByb3h5IjtzOjA6IiI7fXM6MzoibG9jIjthOjE6e3M6NDoidHlwZSI7czowOiIiO319"
);

$cData = new ShsParserContent;
$rsData = $cData->GetList(array(), array("NAME"=>GetMessage("MS_WIZ_PARSER_NAME_7")));

if(!$arData = $rsData->Fetch())
    $ID = $parser->Add($arFields);

unset($cData);

?>