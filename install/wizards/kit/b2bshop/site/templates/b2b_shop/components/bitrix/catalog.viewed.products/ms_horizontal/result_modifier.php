<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$imgWidth = 131;
$imgHeight = 171;

$RESIZE_MODE=BX_RESIZE_IMAGE_PROPORTIONAL;
if($arParams["IMAGE_RESIZE_MODE"]=="BX_RESIZE_IMAGE_EXACT")
	$RESIZE_MODE=BX_RESIZE_IMAGE_EXACT;
	elseif($arParams["IMAGE_RESIZE_MODE"]=="BX_RESIZE_IMAGE_PROPORTIONAL")
	$RESIZE_MODE=BX_RESIZE_IMAGE_PROPORTIONAL;
	elseif($arParams["IMAGE_RESIZE_MODE"]=="BX_RESIZE_IMAGE_PROPORTIONAL_ALT")
	$RESIZE_MODE=BX_RESIZE_IMAGE_PROPORTIONAL_ALT;

$imageNoPhoto = $_SERVER["DOCUMENT_ROOT"]."/upload/no_photo.jpg";
$imageNoPhoto1 = $_SERVER["DOCUMENT_ROOT"]."/upload/no_photo_small.jpg";

$f1 = CFile::ResizeImageFile(
 $imageNoPhoto,
 $imageNoPhoto1,
 array('width'=>$imgWidth, 'height'=>$imgHeight),
 $RESIZE_MODE
);

$imageFromOffer = ($arParams["PICTURE_FROM_OFFER"]=="Y")?1:0;/*�������� �� ������*/
$codeOfferMorePhoto = $arParams["MORE_PHOTO_OFFER_PROPS"];

foreach($arResult["ITEMS"] as $i=>&$arItem)
{
    $arResult["FANCY"][$i]["ID"] = $arItem["ID"];
    $arResult["FANCY"][$i]["DETAIL_PAGE_URL"] = $arItem["DETAIL_PAGE_URL"];
    
    if($imageFromOffer)
    {
        if(!$arItem["PREVIEW_PICTURE"] && $arItem["DETAIL_PICTURE"])
            $arItem["PREVIEW_PICTURE"] = $arItem["DETAIL_PICTURE"];
    }else{
        if($arItem["PREVIEW_PICTURE"])
        {
            $arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"] = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>$imgWidth, 'height'=>$imgHeight), $RESIZE_MODE, true);
        }elseif($arItem["DETAIL_PICTURE"])
        {
            $arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"] = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]["ID"], array('width'=>$imgWidth, 'height'=>$imgHeight), $RESIZE_MODE, true);
            $arItem["PREVIEW_PICTURE"] = $arItem["DETAIL_PICTURE"];
        }    
    }
    if($imageFromOffer)
    {
        if(isset($arItem["OFFERS"]) && !empty($arItem["OFFERS"]))
        {
            foreach($arItem["OFFERS"] as $arOffer)
            {
                $img = $arOffer["DETAIL_PICTURE"];
                $img = $arOffer["PREVIEW_PICTURE"]?$arOffer["PREVIEW_PICTURE"]:$img;
                
                if($img)
                {
                    $arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"] = CFile::ResizeImageGet($img, array('width'=>$imgWidth, 'height'=>$imgHeight), $RESIZE_MODE, true);
                }
                if(!isset($arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"]) && $arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"])
                {
                    foreach($arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"] as $v)
                    {
                        $arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"] = CFile::ResizeImageGet($v, array('width'=>$imgWidth, 'height'=>$imgHeight), $RESIZE_MODE, true);
                        break 1;
                    }
                }
            }

        }

        if(!isset($arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"]) && $arItem["PREVIEW_PICTURE"])
        {
            $arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"] = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width'=>$imgWidth, 'height'=>$imgHeight), $RESIZE_MODE, true);;
        }
    }
    

}
$arResult["RAND"] = $this->randString();
$this->__component->arResultCacheKeys = array_merge($this->__component->arResultCacheKeys, array('FANCY', 'RAND'));
?>