<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
if(isset($arParams['IMG_WIDTH']) && $arParams['IMG_WIDTH']>0)
{
	$imgWidth=$arParams['IMG_WIDTH'];
}
else 
{
	$imgWidth = 131;
}
if(isset($arParams['IMG_HEIGHT']) && $arParams['IMG_HEIGHT']>0)
{
	$imgHeight=$arParams['IMG_HEIGHT'];
}
else
{
	$imgHeight = 171;
}

$imageNoPhoto = $_SERVER["DOCUMENT_ROOT"]."/upload/no_photo.jpg";
$imageNoPhoto1 = $_SERVER["DOCUMENT_ROOT"]."/upload/no_photo_small.jpg";

$f1 = CFile::ResizeImageFile(
 $imageNoPhoto,
 $imageNoPhoto1,
 array('width'=>$imgWidth, 'height'=>$imgHeight),
 BX_RESIZE_IMAGE_EXACT
);

$arResult["IS_FANCY"] = ($arParams["IS_FANCY"]=="Y")?true:false;

$imageFromOffer = ($arParams["PICTURE_FROM_OFFER"]=="Y")?1:0;/*�������� �� ������*/
$codeOfferMorePhoto = $arParams["MORE_PHOTO_OFFER_PROPS"];

$arResult["COUNT"] = 0;
foreach($arResult["ITEMS"] as $i=>&$arItem)
{   $arResult["COUNT"]++;
	if($imageFromOffer)
	{
		if(!$arItem["PREVIEW_PICTURE"] && $arItem["DETAIL_PICTURE"])
			$arItem["PREVIEW_PICTURE"] = $arItem["DETAIL_PICTURE"];	
	}else{
		if($arItem["PREVIEW_PICTURE"])
		{
			$arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"] = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_EXACT, true);
		}elseif($arItem["DETAIL_PICTURE"])
		{
			$arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"] = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]["ID"], array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_EXACT, true);
			$arItem["PREVIEW_PICTURE"] = $arItem["DETAIL_PICTURE"];
		}	
	}
	
	$minPrice = 0;
	if(isset($arItem["OFFERS"]) && !empty($arItem["OFFERS"]))
	{
		foreach($arItem["OFFERS"] as $arOffer)
		{
			if (/*empty($arResult['MIN_PRICE']) && */$arOffer['CAN_BUY'] && $arOffer["MIN_PRICE"]["VALUE"]<$minPrice || $minPrice == 0)
			{
				$intSelected = $keyOffer;
				$arResult["ITEMS"][$i]['MIN_PRICE'] = (isset($arOffer['RATIO_PRICE']) ? $arOffer['RATIO_PRICE'] : $arOffer['MIN_PRICE']);
				$minPrice = $arOffer["MIN_PRICE"]["VALUE"];
			}
			
			if($imageFromOffer)
			{
				$img = $arOffer["DETAIL_PICTURE"];
				$img = $arOffer["PREVIEW_PICTURE"]?$arOffer["PREVIEW_PICTURE"]:$img;
				
				if($img)
				{
					$arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"] = CFile::ResizeImageGet($img, array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_EXACT, true);
				}
				if(!isset($arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"]) && $arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"])
				{
					foreach($arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"] as $v)
					{
						$arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"] = CFile::ResizeImageGet($v, array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_EXACT, true);
						break 1;
					}	
				}

			}
			
		}
	}

	if(!isset($arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"]) && $arItem["PREVIEW_PICTURE"])
	{
		$arResult["ITEMS"][$i]["PREVIEW_PICTURE_RESIZE"] = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_EXACT, true);
	}
	//if($arResult["IS_FANCY"])
	{
		$arResult["FANCY"][$i]["ID"] = $arItem["ID"];
		$arResult["FANCY"][$i]["DETAIL_PAGE_URL"] = $arItem["DETAIL_PAGE_URL"];	
	}
	

}

$arResult["RAND"] = $this->randString();
$this->__component->arResultCacheKeys = array_merge($this->__component->arResultCacheKeys, array('FANCY', 'RAND', 'COUNT', 'IS_FANCY'));
?>