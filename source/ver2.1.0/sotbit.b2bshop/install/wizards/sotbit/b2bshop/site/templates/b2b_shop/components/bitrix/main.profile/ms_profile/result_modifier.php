<?
if (! defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true)
	die();

if(!empty($arResult["arUser"]["PERSONAL_PHOTO"]))
{
	$arResult['arUser']['PERSONAL_PHOTO_IMG'] = CFile::ResizeImageGet($arResult["arUser"]["PERSONAL_PHOTO"], array('width'=>116, 'height'=>116), BX_RESIZE_IMAGE_EXACT, true);
}
?>