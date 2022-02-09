<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

if (count($arResult["ITEMS"]) > 0){
	$arItem = &$arResult["ITEMS"]["0"];
	if($arItem["PREVIEW_PICTURE"]["WIDTH"] > $arParams["LIST_WIDTH_IMG_FIRST"] || $arItem["PREVIEW_PICTURE"]["HEIGHT"] > $arParams["LIST_HEIGHT_IMG_FIRST"]) {
		$previewPic = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width'=> $arParams["LIST_WIDTH_IMG_FIRST"], 'height'=> $arParams["LIST_HEIGHT_IMG_FIRST"]), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		$arItem["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"] = $previewPic["width"];
		$arItem["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"] = $previewPic["height"];
		$arItem["PREVIEW_PICTURE"]["RESIZE"]["SRC"] = $previewPic["src"];
		$arItem["PREVIEW_PICTURE"]["RESIZE"]["FILE_SIZE"] = $previewPic["size"]; 
	} else {
		$arItem["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"] = $arItem["PREVIEW_PICTURE"]["WIDTH"];
		$arItem["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"] = $arItem["PREVIEW_PICTURE"]["HEIGHT"];
		$arItem["PREVIEW_PICTURE"]["RESIZE"]["SRC"] = $arItem["PREVIEW_PICTURE"]["SRC"];
		$arItem["PREVIEW_PICTURE"]["RESIZE"]["FILE_SIZE"] = $arItem["PREVIEW_PICTURE"]["FILE_SIZE"]; 
	}        
	//VIDEO START
foreach($arResult["ITEMS"] as $Item)
{
	if(isset($Item["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"]) && is_array($Item["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"]) && count($Item["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"])>0)
	{
		foreach($Item["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"] as $Video)
		{
			//YOUTUBE
			if(strpos($Video,"youtube.com"))
			{
				$VideoPath=explode('?v=',$Video);
				$VideoNumber=$VideoPath[count($VideoPath)-1];
				$arResult["VIDEO"][$Item["ID"]][]='<iframe src="https://www.youtube.com/embed/'.$VideoNumber.'" frameborder="0" allowfullscreen></iframe>';
			}
			//VIMEO
			elseif(strpos($Video,"vimeo.com"))
			{
				$VideoPath=explode('/',$Video);
				$VideoNumber=$VideoPath[count($VideoPath)-1];
				$arResult["VIDEO"][$Item["ID"]][]='<iframe src="https://player.vimeo.com/video/'.$VideoNumber.'"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			}
			//HTML5
			else
			{
				$arResult["VIDEO"][$Item["ID"]][]='<video src="'.$Video.'"  controls autobuffer preload></video>';
			}
		}
	}
}
//VIDEO END
}
?>