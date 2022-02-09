<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

foreach($arResult["ITEMS"] as $key => &$arItem) {
    if($arItem["PREVIEW_PICTURE"]["WIDTH"] > $arParams["LIST_WIDTH_IMG"] || $arItem["PREVIEW_PICTURE"]["HEIGHT"] > $arParams["LIST_HEIGHT_IMG"]) {
        $previewPic = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width'=> $arParams["LIST_WIDTH_IMG"], 'height'=> $arParams["LIST_HEIGHT_IMG"]), BX_RESIZE_IMAGE_EXACT, true);
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
    if(isset($arItem["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"]) && !empty($arItem["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"])):
			//YOUTUBE
			if(strpos($arItem["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"],"youtube.com"))
			{
				
				$arItem["VIDEO"]='
				<div class="item-video">
					<a class="owl-video" href="'.$arItem["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"].'"></a>
				</div>
				';
			}
			//VIMEO
			elseif(strpos($arItem["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"],"vimeo.com"))
			{
				$arItem["VIDEO"]='
				<div class="item-video">
					<a class="owl-video" href="'.$arItem["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"].'"></a>
				</div>
				';
			}
			else
			{
				$arItem["VIDEO"]='
				<div class="item">
					<video src="'.$arItem["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"].'" controls/>
				</div>
				';
			}
endif;
}


?>