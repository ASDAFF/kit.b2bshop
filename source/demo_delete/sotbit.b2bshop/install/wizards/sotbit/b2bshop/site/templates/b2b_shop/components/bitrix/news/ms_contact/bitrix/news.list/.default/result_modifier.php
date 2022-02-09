<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();


// получим разделы
// START
$arResult["SECTION"] = array();
$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID']); // выберет потомков без учета активности
$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
while ($arSect = $rsSect->GetNext())
{
    $arResult["SECTION"][$arSect['ID']] = $arSect;
}
// END


// –азделим по разделам
// START
foreach($arResult["ITEMS"] as $arElement)
{
    $arResult["BLOCK_ITEMS"][$arElement["IBLOCK_SECTION_ID"]][] = $arElement;
}
// END

?>