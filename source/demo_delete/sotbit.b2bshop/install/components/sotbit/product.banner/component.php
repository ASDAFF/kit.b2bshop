<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Catalog\CatalogViewedProductTable as CatalogViewedProductTable;
/** @global CDatabase $DB */
global $DB;
/** @global CUser $USER */
global $USER;
/** @global CMain $APPLICATION */
global $APPLICATION;
if (!CModule::IncludeModule("iblock") || !CModule::IncludeModule("catalog") || !CModule::IncludeModule("sale"))
{
	return;
}

$arParams["ID"] = IntVal($arParams["ID"]);
$arParams["SECTION_ID"] = IntVal($arParams["SECTION_ID"]);

if($arParams["ID"] <= 0 && $arParams["SECTION_ID"]<=0)
	return;
$arrFilter = array();

if($this->StartResultCache(false, array($arrFilter, ($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups()))))
{

    if($arParams["ID"])
    {
        $arFilter = array();
        $arFilter["IBLOCK_ID"] = $arParams["BANNER_IBLOCK_ID"];
        $arFilter["ACTIVE"] = "Y";
        $arFilter["SECTION_CODE"] = "banner-v-kartochki-tovara";
        $arFilter["PROPERTY_ELEMENT"] = $arParams["ID"];
        $arBanner = CIBlockElement::GetList(array("rand"=>"rand"), $arFilter, false, array("nTopCount"=>1), array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "PROPERTY_LINK"))->Fetch();
    }
    if((!isset($arBanner) || !$arBanner) && $arParams["SECTION_ID"]>0)
    {
        $arFilter = array();
        $arFilter["IBLOCK_ID"] = $arParams["BANNER_IBLOCK_ID"];
        $arFilter["ACTIVE"] = "Y";
        $arFilter["SECTION_CODE"] = "banner-v-kartochki-tovara";
        $arFilter["PROPERTY_SECTION"] = $arParams["SECTION_ID"];
        $arBanner = CIBlockElement::GetList(array("rand"=>"rand"), $arFilter, false, array("nTopCount"=>1), array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "PROPERTY_LINK"))->Fetch();
    }
    $arResult = $arBanner;
    if(isset($arBanner["PREVIEW_PICTURE"]) && $arBanner["PREVIEW_PICTURE"]>0)
    {
        $arResult["PICTURE"] = CFile::GetFileArray($arBanner["PREVIEW_PICTURE"]);
        $ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($arBanner["IBLOCK_ID"], $arBanner["ID"]);
        $arResult["PICTURE"]["IPROPERTY_VALUES"] = $ipropValues->getValues();
        $arResult["PICTURE"]["ALT"] = $arResult["PICTURE"]["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"];
		if ($arResult["PICTURE"]["ALT"] == "")
		    $arResult["PICTURE"]["ALT"] = $arBanner["NAME"];
		$arResult["PICTURE"]["TITLE"] = $arResult["PICTURE"]["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"];
		if ($arResult["PICTURE"]["TITLE"] == "")
		    $arResult["PICTURE"]["TITLE"] = $arBanner["NAME"];
    }else{
        $this->AbortResultCache();
        return 0;
    }


    $this->IncludeComponentTemplate();
} 

?>