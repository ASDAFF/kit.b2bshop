<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$res = CIBlock::GetByID($arParams["IBLOCK_ID"]);
if($ar_res = $res->GetNext())
  $arResult["IBLOCK_NAME"] = $ar_res["NAME"];
  $arResult["IBLOCK_DESCRIPTION"] = $ar_res["DESCRIPTION"];

if($arParams["POPULAR_NEWS_COUNT"] > 9 || empty($arParams["POPULAR_NEWS_COUNT"]) || $arParams["POPULAR_NEWS_COUNT"] == "0" )  {
    $arParams["POPULAR_NEWS_COUNT"] = 9;        
}
?>