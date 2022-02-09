<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

foreach($arResult["ITEMS"] as $key => &$arItem) {
    if($arItem["PREVIEW_PICTURE"]["WIDTH"] > $arParams["LIST_WIDTH_IMG"] || $arItem["PREVIEW_PICTURE"]["HEIGHT"] > $arParams["LIST_HEIGHT_IMG"]) {
        $previewPic = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width'=> $arParams["LIST_WIDTH_IMG"], 'height'=> $arParams["LIST_HEIGHT_IMG"]), BX_RESIZE_IMAGE_PROPORTIONAL, true);
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
}
?>