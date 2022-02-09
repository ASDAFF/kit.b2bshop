<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;

$BRAND_IBLOCK_TYPE = COption::GetOptionString("kit.b2bshop", "BRAND_IBLOCK_TYPE", "");
$BRAND_IBLOCK_ID = COption::GetOptionString("kit.b2bshop", "BRAND_IBLOCK_ID", "");
$aMenuLinksExt = $APPLICATION->IncludeComponent("kit:menu.elements","",Array(
		"IS_SEF" => "Y",
		"SEF_BASE_URL" => "#SITE_DIR#brands/",
		"SECTION_PAGE_URL" => "#SECTION_CODE#/",
		"DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_CODE#/",
        "IBLOCK_TYPE" => $BRAND_IBLOCK_TYPE,
        "IBLOCK_ID" => $BRAND_IBLOCK_ID,
		"DEPTH_LEVEL" => "1",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
        "SORT_BY" => "name",
        "SORT_ORDER" => "asc"

	)
);

//printr($aMenuLinksExt);
$aMenuLinks = $aMenuLinksExt;
?>