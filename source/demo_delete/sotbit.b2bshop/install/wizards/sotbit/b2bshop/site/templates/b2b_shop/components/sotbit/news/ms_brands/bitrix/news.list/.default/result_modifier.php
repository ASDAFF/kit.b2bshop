<?
$k = 0;
foreach($arResult["ITEMS"] as $i=>$arElement)
{
    $arResult["BLOCK_ITEMS"][$k][] = $arElement;
    if(($i+1)%6==0) $k++;
}

if(empty($arItem['PREVIEW_PICTURE'])){
    $arItem['PREVIEW_PICTURE'] = $arItem['DETAIL_PICTURE'];    
}
?>