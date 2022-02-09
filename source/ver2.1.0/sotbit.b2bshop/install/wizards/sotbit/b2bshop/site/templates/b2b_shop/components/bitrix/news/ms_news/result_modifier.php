<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$res = CIBlock::GetByID($arParams["IBLOCK_ID"]);
if($ar_res = $res->GetNext())
  $arResult["IBLOCK_NAME"] = $ar_res["NAME"];

$arFilter = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], 'GLOBAL_ACTIVE'=>'Y');
$arSelect = Array('ID', 'NAME', 'SECTION_PAGE_URL', 'CODE');
$db_list = CIBlockSection::GetList(Array(sort=>asc), $arFilter, false, $arSelect);
  while($ar_result = $db_list->GetNext())
  {
    $arResult["ALL_SECTION"][] = $ar_result;
  }
?>