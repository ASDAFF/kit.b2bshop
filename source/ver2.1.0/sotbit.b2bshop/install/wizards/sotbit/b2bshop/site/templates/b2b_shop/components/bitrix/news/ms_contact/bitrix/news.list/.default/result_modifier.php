<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();


// ������� �������
// START
$arResult["SECTION"] = array();
$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID']); // ������� �������� ��� ����� ����������
$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
while ($arSect = $rsSect->GetNext())
{
    $arResult["SECTION"][$arSect['ID']] = $arSect;
}
// END


// �������� �� ��������
// START
foreach($arResult["ITEMS"] as $arElement)
{
    $arResult["BLOCK_ITEMS"][$arElement["IBLOCK_SECTION_ID"]][] = $arElement;
}
// END

?>