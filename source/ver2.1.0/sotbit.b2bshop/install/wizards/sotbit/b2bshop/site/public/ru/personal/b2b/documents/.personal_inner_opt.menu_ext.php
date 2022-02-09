<?
use Bitrix\Main\Config\Option;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent("bitrix:menu.sections","",Array(
		"IS_SEF" => "Y",
		"SEF_BASE_URL" => "/personal/b2b/documents/",
		"SECTION_PAGE_URL" => "#SECTION_CODE#/",
		"DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_CODE#/",
		"IBLOCK_TYPE" => Option::get("sotbit.b2bshop", "DOCUMENT_IBLOCK_TYPE", ""),
		"IBLOCK_ID" => Option::get("sotbit.b2bshop", "DOCUMENT_IBLOCK_ID", ""),
		"DEPTH_LEVEL" => "2",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	)
);
$aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);

?>