<?
$imgWidth = 131;
$imgHeight = 171;

foreach($arResult["ITEMS"] as $i=>&$arItem)
{
	if($arItem["PREVIEW_PICTURE"])
	{
		$arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"] = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_EXACT, true);
	}elseif($arItem["DETAIL_PICTURE"])
	{
		$arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"] = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]["ID"], array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_EXACT, true);
		$arItem["PREVIEW_PICTURE"] = $arItem["DETAIL_PICTURE"];
	}
}
?>