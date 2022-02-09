<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
$arBrandID = array();
$colorCode = (isset($arParams["COLOR_IN_PRODUCT"])&&$arParams["COLOR_IN_PRODUCT"]&&isset($arParams['COLOR_IN_PRODUCT_CODE'])&&!empty($arParams['COLOR_IN_PRODUCT_CODE']))?$arParams['COLOR_IN_PRODUCT_CODE']:$arParams["OFFER_COLOR_PROP"];
/*Символьный код цвета*/
$brandCode = $arParams["MANUFACTURER_ELEMENT_PROPS"];
$colorDelete = ($arParams["DELETE_OFFER_NOIMAGE"]=="Y")?1:0;/*Удалять оффер, если нет картинок*/
$imageFromOffer = ($arParams["PICTURE_FROM_OFFER"]=="Y")?1:0;/*Картинки из оффера*/
$codeMorePhoto = "MORE_PHOTO";/*Символьынй код доп. картинок*/
$codeProductMorePhoto = $arParams["MORE_PHOTO_PRODUCT_PROPS"];/*Символьынй код доп. картинок*/
$codeOfferMorePhoto = $arParams["MORE_PHOTO_OFFER_PROPS"];
$smallImg["width"] = $arParams["LIST_WIDTH_SMALL"];
$smallImg["height"] = $arParams["LIST_HEIGHT_SMALL"];
$mediumImg["width"] = $arParams["LIST_WIDTH_MEDIUM"];
$mediumImg["height"] = $arParams["LIST_HEIGHT_MEDIUM"];
$arParams["IBLOCK_TYPE"] = $arParams["OBJECTIVE_IBLOCK_TYPE"];
$arParams["IBLOCK_ID"] = $arParams["OBJECTIVE_IBLOCK_ID"];
$availableDelete = 0;
$RESIZE_MODE=BX_RESIZE_IMAGE_PROPORTIONAL;
if($arParams["IMAGE_RESIZE_MODE"]=="BX_RESIZE_IMAGE_EXACT")
	$RESIZE_MODE=BX_RESIZE_IMAGE_EXACT;
	elseif($arParams["IMAGE_RESIZE_MODE"]=="BX_RESIZE_IMAGE_PROPORTIONAL")
	$RESIZE_MODE=BX_RESIZE_IMAGE_PROPORTIONAL;
	elseif($arParams["IMAGE_RESIZE_MODE"]=="BX_RESIZE_IMAGE_PROPORTIONAL_ALT")
	$RESIZE_MODE=BX_RESIZE_IMAGE_PROPORTIONAL_ALT;

$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['OBJECTIVE_IBLOCK_ID']); //printr($arSKU);
$boolSKU = !empty($arSKU) && is_array($arSKU);
$arParams['OFFER_TREE_PROPS'] = $arParams['OFFER_TREE_PROPS'][$arSKU["IBLOCK_ID"]];
if ($boolSKU && !empty($arParams['OFFER_TREE_PROPS']))
{
        foreach($arParams['OFFER_TREE_PROPS'] as $prop)
        {   
            $rsProp = CIBlockProperty::GetByID($prop, $arSKU["IBLOCK_ID"], false);
            $arProp = $rsProp->GetNext();//printr($arProp);
            if($arProp["USER_TYPE"]=="directory")
            {
                $arResult["PROP_NAME"][$arProp["CODE"]] = $arProp["NAME"];
                $nameTable = $arProp["USER_TYPE_SETTINGS"]["TABLE_NAME"];
                $directorySelect = array("UF_FILE","UF_XML_ID","UF_NAME","UF_DESCRIPTION","UF_LINK","UF_FULL_DESCRIPTION","UF_FILE","UF_DEF");
                $directoryOrder = array();

                $entityGetList = array(
                    'select' => $directorySelect,
                    'order' => $directoryOrder
                );
                $highBlock = \Bitrix\Highloadblock\HighloadBlockTable::getList(array("filter" => array('TABLE_NAME' => $nameTable)))->fetch();
                $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($highBlock);
                $entityDataClass = $entity->getDataClass();
                $propEnums = $entityDataClass::getList($entityGetList);
                while ($oneEnum = $propEnums->fetch())
                {
                    if($oneEnum["UF_FILE"])
                    {
                        $oneEnum["PIC"] = CFile::GetFileArray($oneEnum["UF_FILE"]);
                    }
                    $arResult["LIST_PROPS"][$prop][$oneEnum["UF_XML_ID"]] = $oneEnum;
                    $arResult["LIST_PROPS_NAME"][$prop][mb_strtolower($oneEnum["UF_NAME"])] = $oneEnum;
                }
            }
        }
}
//COLOR IN PRODUCT  START
if(isset($arParams["COLOR_IN_PRODUCT"])&&$arParams["COLOR_IN_PRODUCT"]&&isset($arParams['COLOR_IN_PRODUCT_CODE'])&&!empty($arParams['COLOR_IN_PRODUCT_CODE']))
{

            $rsProp = CIBlockProperty::GetByID($colorCode, $arParams['IBLOCK_ID'], false);
            $arProp = $rsProp->GetNext();
            if($arProp["USER_TYPE"]=="directory")
            {
                $arResult["PROP_NAME"][$arProp["CODE"]] = $arProp["NAME"];
                $nameTable = $arProp["USER_TYPE_SETTINGS"]["TABLE_NAME"];
                $directorySelect = array("*");
                $directoryOrder = array();

                $entityGetList = array(
                    'select' => $directorySelect,
                    'order' => $directoryOrder
                );
                $highBlock = \Bitrix\Highloadblock\HighloadBlockTable::getList(array("filter" => array('TABLE_NAME' => $nameTable)))->fetch();
                $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($highBlock);
                $entityDataClass = $entity->getDataClass();
                $propEnums = $entityDataClass::getList($entityGetList);
                while ($oneEnum = $propEnums->fetch())
                {
                    if($oneEnum["UF_FILE"])
                    {
                        $oneEnum["PIC"] = CFile::GetFileArray($oneEnum["UF_FILE"]);
                    }
                    $arResult["LIST_PROPS"][$colorCode][$oneEnum["UF_XML_ID"]] = $oneEnum;
                    $arResult["LIST_PROPS_NAME"][$colorCode][mb_strtolower($oneEnum["UF_NAME"])] = $oneEnum;
                }
            }
}
//  COLOR IN PRODUCT  END
$AllColors = $arResult["LIST_PROPS"];
$arColorName = $arColorXml = array();

foreach($arResult["ITEMS"] as $i=>&$arItem)
{
    $minPrice = 0;
    $arResult["FANCY"][$i]["ID"] = $arItem["ID"];
    $arResult["FANCY"][$i]["DETAIL_PAGE_URL"] = $arItem["DETAIL_PAGE_URL"];
    /*if($arItem["PREVIEW_PICTURE"] || $arItem["DETAIL_PICTURE"])
    {
        $arImg = $arItem["PREVIEW_PICTURE"]?$arItem["PREVIEW_PICTURE"]:$arItem["DETAIL_PICTURE"];
        $arResult["ITEMS"][$i]["DEFAULT_IMAGE"]["SMALL"][] = CFile::ResizeImageGet($arImg, array('width'=>120, 'height'=>150), $RESIZE_MODE, true);
        $arResult["ITEMS"][$i]$arResult["DEFAULT_IMAGE"]["MEDIUM"][] = CFile::ResizeImageGet($arImg, array('width'=>320, 'height'=>390), $RESIZE_MODE, true);
        $arResult["ITEMS"][$i]$arResult["DEFAULT_IMAGE"]["BIG"][] = CFile::ResizeImageGet($arImg, array('width'=>1500, 'height'=>1500), $RESIZE_MODE, true);
    }*/
    $iblockBrand = $arItem["PROPERTIES"][$brandCode]["LINK_IBLOCK_ID"];
    if(isset($arItem["PROPERTIES"][$brandCode]["VALUE"]) && $arItem["PROPERTIES"][$brandCode]["VALUE"]>0)
    {
        $arBrandID[] = $arItem["PROPERTIES"][$brandCode]["VALUE"];
        $arBrandIblock[$iblockBrand] = $iblockBrand;
    }

    $arItem["PREVIEW_PICTURE"] = $arItem["PREVIEW_PICTURE"]?$arItem["PREVIEW_PICTURE"]:$arItem["DETAIL_PICTURE"];
    $minPrice = 0;
    $arColorName = $arColorXml = array();
    $arItem["FIRST_COLOR"] = 0;
    $arHasImg = Array();
    $ID = $arItem["ID"];
    if($arItem["PREVIEW_PICTURE"] || $arItem["DETAIL_PICTURE"])
    {
        $arImg = $arItem["PREVIEW_PICTURE"]?$arItem["PREVIEW_PICTURE"]:$arItem["DETAIL_PICTURE"];
        $arItem["DEFAULT_IMAGE"]["SMALL"][] = CFile::ResizeImageGet($arImg, array('width'=>$smallImg["width"], 'height'=>$smallImg["height"]), $RESIZE_MODE, true);
        $arItem["DEFAULT_IMAGE"]["MEDIUM"][] = CFile::ResizeImageGet($arImg, array('width'=>$mediumImg["width"], 'height'=>$mediumImg["height"]), $RESIZE_MODE, true);
    }

    if(!isset($arItem[$codeMorePhoto]))
    {
        if(isset($arItem["PROPERTIES"][$codeProductMorePhoto]["VALUE"]) && !empty($arItem["PROPERTIES"][$codeProductMorePhoto]["VALUE"]))
        foreach($arItem["PROPERTIES"][$codeProductMorePhoto]["VALUE"] as $v)
        {
            $arItem[$codeMorePhoto][] = CFile::GetFileArray($v);
        }
    }

    if($imageFromOffer)
    {
        
    /*Картинки из офферов*/
        $arItem["DEFAULT_OFFER_IMAGE"]["SMALL"] = array();
        $arItem["DEFAULT_OFFER_IMAGE"]["MEDIUM"] = array();
        {
            if(isset($arItem["PROPERTIES"][$codeProductMorePhoto]["VALUE"]) && !empty($arItem["PROPERTIES"][$codeProductMorePhoto]["VALUE"]))
            foreach($arItem["PROPERTIES"][$codeProductMorePhoto]["VALUE"] as $v)
            {
                $arItem["DEFAULT_OFFER_IMAGE"]["SMALL"][] = CFile::ResizeImageGet($v, array('width'=>$smallImg["width"], 'height'=>$smallImg["height"]), $RESIZE_MODE, true);
                $arItem["DEFAULT_OFFER_IMAGE"]["MEDIUM"][] = CFile::ResizeImageGet($v, array('width'=>$mediumImg["width"], 'height'=>$mediumImg["height"]), $RESIZE_MODE, true);
            }
        }
        
        if(isset($arItem["OFFERS"]) && !empty($arItem["OFFERS"]))
        {
            foreach($arItem["OFFERS"] as $in=>$arOffer)
            {
                foreach($arOffer["PROPERTIES"] as $code=>$arProps)
                {   
                    $boolImg = false;
                    if($arOffer["PREVIEW_PICTURE"] || $arOffer["DETAIL_PICTURE"] || $arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"])
                    {
                        $boolImg = true;
                    }

                    if($availableDelete && !$arOffer["CAN_BUY"])
                        continue 1;

                    if($arProps["VALUE"] && $code==$colorCode)
                    {
                        if($arProps["USER_TYPE"]=="directory")
                        {
                            $arDirVal = $arResult["LIST_PROPS"][$code][$arProps["VALUE"]];
                            if(!$boolImg && $colorDelete)
                            {
                                unset($arItem["OFFERS"][$in]);
                            }else{  
                                $arColorXml[$ID][$arProps["VALUE"]] = $arDirVal;
                                if($arOffer["CAN_BUY"] && (!isset($arItem["FIRST_COLOR"]) || !$arItem["FIRST_COLOR"]))$arItem["FIRST_COLOR"] = $arProps["VALUE"];
                            }
                        }
                    }
                }
            }
            
            foreach($arItem["OFFERS"] as $arOffer)
            {
                foreach($arOffer["PROPERTIES"] as $code=>$arProps)
                {
                    if($availableDelete && !$arOffer["CAN_BUY"])
                        continue 1;
                    if(in_array($code, $arParams['OFFER_TREE_PROPS']) && $arProps["VALUE"])
                    {
                        if($arProps["USER_TYPE"]=="directory")
                        {
                            $arDirVal = $arResult["LIST_PROPS"][$code][$arProps["VALUE"]];
                            if($arOffer["CAN_BUY"])
                            	$arItem["OFFER_TREE_PROPS"][$code][$arProps["VALUE"]] = $arDirVal;
                            $arItem["OFFERS_ID"][$code][$arProps["VALUE"]][$arOffer["ID"]] = $arOffer["ID"];
                        }


                    }
                }
                if($availableDelete && !$arOffer["CAN_BUY"])
                    continue 1;
                if (/*empty($arResult['MIN_PRICE']) && */($arOffer["MIN_PRICE"]["VALUE"]<$minPrice || $minPrice == 0) && (!empty($arOffer['MIN_PRICE']) || !empty($arOffer['RATIO_PRICE'])))
                {
                    $intSelected = $keyOffer;
                    $arItem['MIN_PRICE'] = $arOffer['MIN_PRICE']; 
                    $minPrice = $arOffer["MIN_PRICE"]["VALUE"];
                }
                $textFrom = GetMessage("B2BS_CATALOG_FROM_PRICE");
                if($minPrice!=0 && $minPrice!=$arOffer["MIN_PRICE"]["VALUE"] && $textFrom)
                {
                    $arItem['MIN_PRICE']["PRINT_VALUE"] = str_replace($textFrom, "", $arItem['MIN_PRICE']["PRINT_VALUE"]);
                    $arItem['MIN_PRICE']["PRINT_VALUE"] = $textFrom.$arItem['MIN_PRICE']["PRINT_VALUE"];
                }
            }
            
            foreach($arItem["OFFERS"] as $arOffer)
            {
                if($availableDelete && !$arOffer["CAN_BUY"])
                    continue 1;
                //if($arOffer["CAN_BUY"])
                {
                    $colorXmlID = $arOffer["PROPERTIES"][$colorCode]["VALUE"];
                    if(!$colorXmlID)
                        $colorXmlID = 0;
                    $arImg = false;
                    {
                        if(($arOffer["PREVIEW_PICTURE"] || $arOffer["DETAIL_PICTURE"]) && !isset($arItem["MORE_PHOTO_JS"][$colorXmlID]))
                        {
                            $arImg = $arOffer["PREVIEW_PICTURE"]?$arOffer["PREVIEW_PICTURE"]:$arOffer["DETAIL_PICTURE"];
                            if(!isset($arHasImg[$arImg]))
                            {
                                if(!isset($arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"]))
                                    $arImgSmall = CFile::ResizeImageGet($arImg, array('width'=>$smallImg["width"], 'height'=>$smallImg["height"]), $RESIZE_MODE, true);
                                $arImgMedium = CFile::ResizeImageGet($arImg, array('width'=>$mediumImg["width"], 'height'=>$mediumImg["height"]), $RESIZE_MODE, true);
                                $colorVal = $arResult["LIST_PROPS"][$colorCode][$colorXmlID]["UF_NAME"];
                                $arImgSmall["title"] = $arImgMedium["title"] = $colorVal;
                                if(!isset($arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"]))
                                    $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][] = $arImgSmall;
                                $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][] = $arImgMedium;
                                $arHasImg[$arImg] = $arImg;
                                if($arOffer["CAN_BUY"] && isset($arColorXml[$ID][$colorXmlID]))$arItem["FIRST_COLOR"] = $colorXmlID;
                            }
                            
                        }
                        
                        if($arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"] && (!isset($arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]) || ($arImg && count($arResult["MORE_PHOTO_JS"][$ID][$colorXmlID])==1)))
                        {   
                            foreach($arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"] as $v)
                            {
                                if(!isset($arHasImg[$v]))
                                {
                                    $arImgSmall = CFile::ResizeImageGet($v, array('width'=>$smallImg["width"], 'height'=>$smallImg["height"]), $RESIZE_MODE, true);
                                    $arImgMedium = CFile::ResizeImageGet($v, array('width'=>$mediumImg["width"], 'height'=>$mediumImg["height"]), $RESIZE_MODE, true);
                                
                                    if($arImgSmall && $arImgMedium)
                                    {
                                        $colorVal = $arResult["LIST_PROPS"][$colorCode][$colorXmlID]["UF_NAME"];
                                        $arImgSmall["title"] = $arImgMedium["title"] = $colorVal;
                                        $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][] = $arImgSmall;
                                        $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][] = $arImgMedium;
                                            
                                    }
                                    $arHasImg[$v] = $v;    
                                }
                            }
                        }
                        elseif(isset( $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID] ))
                        {
                        
                        	if(count($arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"])>1)
                        		foreach( $arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"] as $j=>$v )
                        		{
                        			if($j!=0){
                        				$arImgMedium = CFile::ResizeImageGet( $v, array(
                        						'width' => $mediumImg["width"],
                        						'height' => $mediumImg["height"]
                        				), $arParams["IMAGE_RESIZE_MODE"], true );
                        				$put=true;
                        				foreach($arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"] as $i=>$val)
                        				{
                        					if($arImgMedium['src']==$val['src'])
                        						$put=false;
                        				}
                        				if($put)
                        					$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][] = $arImgMedium;
                        			}
                        		}
                        }
                        if(!isset($arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]))
                        {   
                            $colorVal = $arResult["LIST_PROPS"][$colorCode][$colorXmlID]["UF_NAME"];
                            $arItem["DEFAULT_IMAGE"]["SMALL"][0]["title"] = $colorVal;
                            $arItem["DEFAULT_IMAGE"]["MEDIUM"][0]["title"] = $colorVal;
                            $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID] = $arItem["DEFAULT_IMAGE"];
                        }
                    }/*else{
                        $arResult["MORE_PHOTO_JS"][$ID][0] = $arItem["DEFAULT_IMAGE"];
                    }*/
                }
            }
        }else{
        	if(isset($arItem["DEFAULT_IMAGE"]))
            	$arResult["MORE_PHOTO_JS"][$ID][0] = $arItem["DEFAULT_IMAGE"];
            if(isset($arResult["MORE_PHOTO_JS"][$ID][0]["SMALL"]) && is_array($arResult["MORE_PHOTO_JS"][$ID][0]["SMALL"]) && isset($arItem["DEFAULT_OFFER_IMAGE"]["SMALL"]) && is_array($arItem["DEFAULT_OFFER_IMAGE"]["SMALL"]))
            	$arResult["MORE_PHOTO_JS"][$ID][0]["SMALL"] = array_merge($arResult["MORE_PHOTO_JS"][$ID][0]["SMALL"], $arItem["DEFAULT_OFFER_IMAGE"]["SMALL"]);
            if(isset($arResult["MORE_PHOTO_JS"][$ID][0]["MEDIUM"]) && is_array($arResult["MORE_PHOTO_JS"][$ID][0]["MEDIUM"]) && isset($arItem["DEFAULT_OFFER_IMAGE"]["MEDIUM"]) && is_array($arItem["DEFAULT_OFFER_IMAGE"]["MEDIUM"]))
            	$arResult["MORE_PHOTO_JS"][$ID][0]["MEDIUM"] = array_merge($arResult["MORE_PHOTO_JS"][$ID][0]["MEDIUM"], $arItem["DEFAULT_OFFER_IMAGE"]["MEDIUM"]);
            if(isset($arResult["MORE_PHOTO_JS"][$ID][0]["BIG"]) && is_array($arResult["MORE_PHOTO_JS"][$ID][0]["BIG"]) && isset($arItem["DEFAULT_OFFER_IMAGE"]["BIG"]) && is_array($arItem["DEFAULT_OFFER_IMAGE"]["BIG"]))
            	$arResult["MORE_PHOTO_JS"][$ID][0]["BIG"] = array_merge($arResult["MORE_PHOTO_JS"][$ID][0]["BIG"], $arItem["DEFAULT_OFFER_IMAGE"]["BIG"]);
        }

        $firstColor = $arItem["FIRST_COLOR"];
        if((isset($arResult["MORE_PHOTO_JS"][$ID][$firstColor]["MEDIUM"]) && !empty($arResult["MORE_PHOTO_JS"][$ID][$firstColor]["MEDIUM"])))
        {
            $arTmp = $arResult["MORE_PHOTO_JS"][$ID][$firstColor];
            unset($arResult["MORE_PHOTO_JS"][$ID][$firstColor]);
            $arResult["MORE_PHOTO_JS"][$ID] = array($firstColor=>$arTmp) + $arResult["MORE_PHOTO_JS"][$ID];
            unset($arTmp);
            foreach($arResult["MORE_PHOTO_JS"][$ID][$firstColor]["MEDIUM"] as $arPreviewPicture)
            {
                $arItem["PREVIEW_PICTURE_RESIZE"] = $arPreviewPicture;
                break 1;
            }
        }elseif(count($arResult["MORE_PHOTO_JS"][$ID])>0 && $firstColor==0)
        {
            foreach($arResult["MORE_PHOTO_JS"][$ID] as $arPreviewColor)
            {
                foreach($arPreviewColor["MEDIUM"] as $arPreviewPicture)
                {
                    $arItem["PREVIEW_PICTURE_RESIZE"] = $arPreviewPicture;
                    break 1;
                }
                break 1;
            }
        }elseif(isset($arItem["DEFAULT_IMAGE"]["MEDIUM"]) && !empty($arItem["DEFAULT_IMAGE"]["MEDIUM"]))
        {
            $arItem["PREVIEW_PICTURE_RESIZE"] = $arItem["DEFAULT_IMAGE"]["MEDIUM"][0];
        }
    
    }else{
        /*Картинки из каталога*/
        if($arItem["PREVIEW_PICTURE"])
        {
            $arImg = $arItem["PREVIEW_PICTURE"];
            $descr = mb_strtolower($arImg["DESCRIPTION"]);
            $arDescr = explode("_", $descr);
            $color = $arDescr[0];
            if($color)$arItem["BASE_IMG_COLOR"][$color] = $color;
        }


        if($arItem[$codeMorePhoto])
        {
            foreach($arItem[$codeMorePhoto] as $arPhoto)
            {
                $descr = mb_strtolower($arPhoto["DESCRIPTION"]);
                $arDescr = explode("_", $descr);
                $color = $arDescr[0];
                if($color)$arItem["BASE_IMG_COLOR"][$color] = $color;
            }
        }

        foreach($arItem["OFFERS"] as $in=>$arOffer)
        {
            foreach($arOffer["PROPERTIES"] as $code=>$arProps)
            {
                if($availableDelete && !$arOffer["CAN_BUY"])
                    continue 1;
                if($arProps["VALUE"] && $code==$colorCode)
                {
                    if($arProps["USER_TYPE"]=="directory")
                    {
                        $arDirVal = $arResult["LIST_PROPS"][$code][$arProps["VALUE"]];
                        $color = mb_strtolower($arDirVal["UF_NAME"]);
                        $arColorNameAvaible[mb_strtolower($arDirVal["UF_NAME"])] = $arDirVal;
                        if(!isset($arItem["BASE_IMG_COLOR"][$color]) && $colorDelete)
                        {
                            unset($arItem["OFFERS"][$in]);
                        }else{
                            
                            $arColorName[mb_strtolower($arDirVal["UF_NAME"])] = $arDirVal;
                            $arColorXml[$ID][$arProps["VALUE"]] = $arDirVal; //if($ID==807) //printr($arColorXml[807]);
                            if($arOffer["CAN_BUY"] && (!isset($arItem["FIRST_COLOR"]) || !$arItem["FIRST_COLOR"]))$arItem["FIRST_COLOR"] = $arProps["VALUE"];
                            
                        }

                    }
                }
            }
        }

        foreach($arItem["OFFERS"] as $arOffer)
        {
            foreach($arOffer["PROPERTIES"] as $code=>$arProps)
            {
                if($availableDelete && !$arOffer["CAN_BUY"])
                    continue 1;
                if(in_array($code, $arParams['OFFER_TREE_PROPS']) && $arProps["VALUE"])
                {
                    if($arProps["USER_TYPE"]=="directory")
                    {
                        $arDirVal = $arResult["LIST_PROPS"][$code][$arProps["VALUE"]];
                        if($arOffer["CAN_BUY"])
                            $arItem["OFFER_TREE_PROPS"][$code][$arProps["VALUE"]] = $arDirVal;
                        $arItem["OFFERS_ID"][$code][$arProps["VALUE"]][$arOffer["ID"]] = $arOffer["ID"];
                    }
                }
            }
            if($availableDelete && !$arOffer["CAN_BUY"])
                continue 1;
            if (/*empty($arResult['MIN_PRICE']) && */($arOffer["MIN_PRICE"]["VALUE"]<$minPrice || $minPrice == 0) && (!empty($arOffer['MIN_PRICE']) || !empty($arOffer['RATIO_PRICE'])))
            {
                $intSelected = $keyOffer;
                $arItem['MIN_PRICE'] = $arOffer["MIN_PRICE"];
                $minPrice = $arOffer["MIN_PRICE"]["VALUE"];
            }
            $textFrom = GetMessage("B2BS_CATALOG_FROM_PRICE");
            if($minPrice!=0 && $minPrice!=$arOffer["MIN_PRICE"]["VALUE"] && $textFrom)
            {
                $arItem['MIN_PRICE']["PRINT_VALUE"] = str_replace($textFrom, "", $arItem['MIN_PRICE']["PRINT_VALUE"]);
                $arItem['MIN_PRICE']["PRINT_VALUE"] = $textFrom.$arItem['MIN_PRICE']["PRINT_VALUE"];
            }
        }

        if($arItem["PREVIEW_PICTURE"])
        {
            $arImg = $arItem["PREVIEW_PICTURE"];
            $descr = mb_strtolower($arImg["DESCRIPTION"]);
            $arDescr = explode("_", $descr);
            $color = $arDescr[0];
            if(isset($arColorXml[$ID]) && !empty($arColorXml[$ID]))
            {
                $colorXmlID = $arResult["LIST_PROPS_NAME"][$colorCode][mb_strtolower($color)]["UF_XML_ID"];
                if(isset($arColorName[mb_strtolower($color)]))$arItem["FIRST_COLOR"] = $colorXmlID;
                if(isset($arDescr[1]) && preg_match("/[0-9]/", $arDescr[1]))
                {
                    $index = $arDescr[1];
                }else $index = 0;
                $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][$index] = CFile::ResizeImageGet($arImg, array('width'=>$smallImg["width"], 'height'=>$smallImg["height"]), $RESIZE_MODE, true);
                $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][$index] = CFile::ResizeImageGet($arImg, array('width'=>$mediumImg["width"], 'height'=>$mediumImg["height"]), $RESIZE_MODE, true);
                $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][$index]["title"] = mb_strtolower($color); 
            }else{
                $index = 0;
                $colorXmlID = 0;
                $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][$index] = CFile::ResizeImageGet($arImg, array('width'=>$smallImg["width"], 'height'=>$smallImg["height"]), $RESIZE_MODE, true);
                $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][$index] = CFile::ResizeImageGet($arImg, array('width'=>$mediumImg["width"], 'height'=>$mediumImg["height"]), $RESIZE_MODE, true);
            }
        }
        if($arItem[$codeMorePhoto])
        {
            foreach($arItem[$codeMorePhoto] as $arPhoto)
            {   
                $descr = mb_strtolower($arPhoto["DESCRIPTION"]);
                $arDescr = explode("_", $descr);
                $color = $arDescr[0];
                if(isset($arColorXml[$ID]) && !empty($arColorXml[$ID]))
                {
                    $colorXmlID = $arResult["LIST_PROPS_NAME"][$colorCode][mb_strtolower($color)]["UF_XML_ID"];
                    if(isset($arDescr[1]) && preg_match("/[0-9]/", $arDescr[1]))
                    {
                        $index = $arDescr[1];
                        $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][$index] = CFile::ResizeImageGet($arPhoto, array('width'=>$smallImg["width"], 'height'=>$smallImg["height"]), $RESIZE_MODE, true);
                        $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][$index] = CFile::ResizeImageGet($arPhoto, array('width'=>$mediumImg["width"], 'height'=>$mediumImg["height"]), $RESIZE_MODE, true);
                        $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][$index]["title"] = mb_strtolower($color);
                    }else{
                        $arImgSmall = CFile::ResizeImageGet($arPhoto, array('width'=>$smallImg["width"], 'height'=>$smallImg["height"]), $RESIZE_MODE, true);
                        $arImgMedium = CFile::ResizeImageGet($arPhoto, array('width'=>$mediumImg["width"], 'height'=>$mediumImg["height"]), $RESIZE_MODE, true);
                        $arImgSmall["title"] = $arImgMedium["title"] = $color;
                        
                        $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][] = $arImgSmall;
                        $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][] = $arImgMedium;
                    }
                }else{
                    $colorXmlID = 0;
                    $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][] = CFile::ResizeImageGet($arPhoto, array('width'=>$smallImg["width"], 'height'=>$smallImg["height"]), $RESIZE_MODE, true);
                    $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][] = CFile::ResizeImageGet($arPhoto, array('width'=>$mediumImg["width"], 'height'=>$mediumImg["height"]), $RESIZE_MODE, true);
                }
            }
        }

        foreach($arResult["MORE_PHOTO_JS"][$ID] as $key=>$arVal)
        {
            ksort($arResult["MORE_PHOTO_JS"][$ID][$key]["SMALL"]);
            ksort($arResult["MORE_PHOTO_JS"][$ID][$key]["MEDIUM"]);
        }
        $arMorePhotoID = array();
        foreach($arResult["MORE_PHOTO_JS"][$ID] as $key=>$arKey)
        {
            if($arItem["FIRST_COLOR"]==$key)
            {
                $arMorePhotoID[$key] = $arKey;
                unset($arResult["MORE_PHOTO_JS"][$ID][$key]);
            }
        }


        $arResult["MORE_PHOTO_JS"][$ID] = array_merge($arMorePhotoID, $arResult["MORE_PHOTO_JS"][$ID]);

        $firstColor = $arItem["FIRST_COLOR"];
        if((isset($arResult["MORE_PHOTO_JS"][$ID][$firstColor]["MEDIUM"]) && !empty($arResult["MORE_PHOTO_JS"][$ID][$firstColor]["MEDIUM"])))
        {
            $arTmp = $arResult["MORE_PHOTO_JS"][$ID][$firstColor];
            unset($arResult["MORE_PHOTO_JS"][$ID][$firstColor]);
            $arResult["MORE_PHOTO_JS"][$ID] = array($firstColor=>$arTmp) + $arResult["MORE_PHOTO_JS"][$ID];
            unset($arTmp);
            foreach($arResult["MORE_PHOTO_JS"][$ID][$firstColor]["MEDIUM"] as $arPreviewPicture)
            {
                $arItem["PREVIEW_PICTURE_RESIZE"] = $arPreviewPicture;
                break 1;
            }
        }elseif(count($arResult["MORE_PHOTO_JS"][$ID])>0 && $firstColor==0)
        {
            foreach($arResult["MORE_PHOTO_JS"][$ID] as $arPreviewColor)
            {
                foreach($arPreviewColor["MEDIUM"] as $arPreviewPicture)
                {
                    $arItem["PREVIEW_PICTURE_RESIZE"] = $arPreviewPicture;
                    break 1;
                }
                break 1;
            }
        }elseif(isset($arItem["DEFAULT_IMAGE"]["MEDIUM"]) && !empty($arItem["DEFAULT_IMAGE"]["MEDIUM"]))
        {
            $arItem["PREVIEW_PICTURE_RESIZE"] = $arItem["DEFAULT_IMAGE"]["MEDIUM"][0];
        }

        /*if(isset($arColorXml))
        {
            foreach($arColorXml as $xmlID=>$arV)
            {
                if(!isset($arResult["MORE_PHOTO_JS"][$ID][$xmlID]))
                    $arResult["MORE_PHOTO_JS"][$ID][$xmlID] = $arItem["DEFAULT_IMAGE"];
            }
        }*/
    }
    
    if(isset($arColorXml[$ID]))
    {   
        foreach($arColorXml[$ID] as $xmlID=>$arV)
        {   
            if(!isset($arResult["MORE_PHOTO_JS"][$ID][$xmlID]))
            {
                $arItem["DEFAULT_IMAGE"]["SMALL"][0]["title"] = $arV["UF_NAME"];
                $arItem["DEFAULT_IMAGE"]["MEDIUM"][0]["title"] = $arV["UF_NAME"];
                $arResult["MORE_PHOTO_JS"][$ID][$xmlID] = $arItem["DEFAULT_IMAGE"];    
            }
                
        }
    }
    
    if(isset($arItem["OFFER_TREE_PROPS"]) && !empty($arItem["OFFER_TREE_PROPS"]))
    {
        foreach($arItem["OFFER_TREE_PROPS"] as $code=>$arPropert)
        {
            foreach($arPropert as $xmlID=>$arPropValue)
            {
                $arItem["OFFER_TREE_PROPS_VALUE"][$code][$xmlID] = $arPropValue["UF_NAME"];
            }
            asort($arItem["OFFER_TREE_PROPS_VALUE"][$code]);
        }
    }

}

if(!empty($arBrandID))
{
    $rsBrand = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>$arBrandIblock, "ID"=>$arBrandID), false, false, array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL"));
    while($arBrand = $rsBrand->GetNext())
    {
        $arResult["BRANDS"][$arBrand["ID"]] = $arBrand;
    }
}

$arResult["RAND"] = $this->randString();
// START LINK COLOR
$k = 0;
if(isset( $arParams["COLOR_IN_PRODUCT"] )&&$arParams["COLOR_IN_PRODUCT"]=="Y"&&isset( $arParams["COLOR_IN_PRODUCT_LINK"] )&&!empty( $arParams["COLOR_IN_PRODUCT_LINK"] ))
{
	if($arParams["COLOR_IN_SECTION_LINK"]==1)
	{
		foreach( $arResult["ITEMS"] as $i => $arElement )
		{
			foreach( $arResult["MORE_PHOTO_JS"][$arElement['ID']] as $color => $arMorePhoto )
			{
				$i = 1;
				if(count( $arMorePhoto["SMALL"] )==count( $arMorePhoto["MEDIUM"] ))
				{
					foreach( $arMorePhoto["SMALL"] as $arImg )
					{
						if($i==1)
						{
							$arResult["MORE_PHOTO_JS_NEW"][$arElement['ID']][$color]['SMALL'][] = $arImg;
							$arResult["MORE_PHOTO_JS_NEW"][$arElement['ID']][$color]['MEDIUM'][] = $arMorePhoto["MEDIUM"][$i];
						}
						else
						{
							$arResult["MORE_PHOTO_JS_NEW"][$arElement['ID']][$color.$i]['SMALL'][] = $arImg;
							$arResult["MORE_PHOTO_JS_NEW"][$arElement['ID']][$color.$i]['MEDIUM'][] = $arMorePhoto["MEDIUM"][$i];
						}
						++$i;
					}
				}
				elseif(count( $arMorePhoto["SMALL"] )<count( $arMorePhoto["MEDIUM"] ))
				{
					foreach( $arMorePhoto["MEDIUM"] as $arImg )
					{
						if($i==1)
						{
							$arResult["MORE_PHOTO_JS_NEW"][$arElement['ID']][$color]['SMALL'][] = $arImg;
							$arResult["MORE_PHOTO_JS_NEW"][$arElement['ID']][$color]['MEDIUM'][] = $arImg;
						}
						else
						{
							$arResult["MORE_PHOTO_JS_NEW"][$arElement['ID']][$color.$i]['SMALL'][] = $arImg;
							$arResult["MORE_PHOTO_JS_NEW"][$arElement['ID']][$color.$i]['MEDIUM'][] = $arImg;
						}
						++$i;
					}
				}
				elseif(count( $arMorePhoto["SMALL"] )>count( $arMorePhoto["MEDIUM"] ))
				{
					foreach( $arMorePhoto["SMALL"] as $arImg )
					{
						if($i==1)
						{
							$arResult["MORE_PHOTO_JS_NEW"][$arElement['ID']][$color]['SMALL'][] = $arImg;
							$arResult["MORE_PHOTO_JS_NEW"][$arElement['ID']][$color]['MEDIUM'][] = $arImg;
						}
						else
						{
							$arResult["MORE_PHOTO_JS_NEW"][$arElement['ID']][$color.$i]['SMALL'][] = $arImg;
							$arResult["MORE_PHOTO_JS_NEW"][$arElement['ID']][$color.$i]['MEDIUM'][] = $arImg;
						}
						++$i;
					}
				}
			}
		}
		$arResult["MORE_PHOTO_JS"] = $arResult["MORE_PHOTO_JS_NEW"];
	}
	if($arParams["COLOR_IN_SECTION_LINK"]==2)
	{
		foreach( $arResult["ITEMS"] as $i => $arElement )
		{
			$arModelsItems[$arElement['ID']] = $arElement["PROPERTIES"][$arParams["COLOR_IN_PRODUCT_LINK"]]["VALUE"];
			$arModelsItems['LINK_VALUE'][] = $arElement["PROPERTIES"][$arParams["COLOR_IN_PRODUCT_LINK"]]["VALUE"];
		}
		$rsModel = CIBlockElement::GetList( array(), array(
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"ACTIVE" => "Y",
				"=PROPERTY_".$arParams["COLOR_IN_PRODUCT_LINK"] => $arModelsItems['LINK_VALUE'] 
		), false, false, array(
				"ID",
				"PREVIEW_PICTURE",
				"DETAIL_PICTURE",
				'PROPERTY_'.$arParams["COLOR_IN_PRODUCT_LINK"],
				'PROPERTY_'.$codeMorePhoto 
		) );
		$i = 0;
		$arIds = array();
		unset( $arModelsItems['LINK_VALUE'] );
		while( $arModel = $rsModel->GetNext() )
		{
			$arModels[$arModel['PROPERTY_'.$arParams["COLOR_IN_PRODUCT_LINK"].'_VALUE']]['ID'][] = $arModel['ID'];
			$arModels[$arModel['ID']]['DETAIL_PICTURE'][] = $arModel['DETAIL_PICTURE'];
			$arModels[$arModel['ID']]['PREVIEW_PICTURE'][] = $arModel['PREVIEW_PICTURE'];
			$arModels[$arModel['ID']]['MORE_PHOTO'][] = $arModel['PROPERTY_'.$codeMorePhoto.'_VALUE'];
			$arIds[] = $arModel['ID'];
			++$i;
		}
		$res = CCatalogSKU::getOffersList( $arIds, $iblockID = 0, $skuFilter = array(), $fields = array(), $propertyFilter = array(
				'CODE' => array(
						$colorCode 
				) 
		) );
		unset( $arIds );
		$arResult["MORE_PHOTO_JS"] = array();
		$ColorsCodes = array();
		foreach( $arModelsItems as $IdItem => $ItemLinkValue )
		{
			$ColorsArray = array();
			foreach( $arModels[$ItemLinkValue]['ID'] as $key => $modelsId )
			{
				$ColorArray = array_shift( $res[$modelsId] );
				foreach( $arModels[$modelsId]['DETAIL_PICTURE'] as $Pic )
				{
					if(isset( $Pic )&&!empty( $Pic )&&isset( $ColorArray['PROPERTIES'][$colorCode]['VALUE'] )&&!empty( $ColorArray['PROPERTIES'][$colorCode]['VALUE'] ))
					{
						$arResult["MORE_PHOTO_JS"][$IdItem][$ColorArray['PROPERTIES'][$colorCode]['VALUE']]["SMALL"][0] = CFile::ResizeImageGet( $Pic, array(
								'width' => $smallImg["width"],
								'height' => $smallImg["height"] 
						), $arParams["IMAGE_RESIZE_MODE"], true );
						$arResult["MORE_PHOTO_JS"][$IdItem][$ColorArray['PROPERTIES'][$colorCode]['VALUE']]["MEDIUM"][0] = CFile::ResizeImageGet( $Pic, array(
								'width' => $mediumImg["width"],
								'height' => $mediumImg["height"] 
						), $arParams["IMAGE_RESIZE_MODE"], true );
					}
				}
				if(!isset( $arResult["MORE_PHOTO_JS"][$IdItem][$ColorArray['PROPERTIES'][$colorCode]['VALUE']]["MEDIUM"] )||count( $arResult["MORE_PHOTO_JS"][$IdItem][$ColorArray['PROPERTIES'][$colorCode]['VALUE']]["MEDIUM"] )<2)
					foreach( $arModels[$modelsId]['MORE_PHOTO'] as $Pic )
					{
						if(isset( $Pic )&&!empty( $Pic )&&isset( $ColorArray['PROPERTIES'][$colorCode]['VALUE'] )&&!empty( $ColorArray['PROPERTIES'][$colorCode]['VALUE'] ))
						{
							$arResult["MORE_PHOTO_JS"][$IdItem][$ColorArray['PROPERTIES'][$colorCode]['VALUE']]["MEDIUM"][] = CFile::ResizeImageGet( $Pic, array(
									'width' => $mediumImg["width"],
									'height' => $mediumImg["height"] 
							), $arParams["IMAGE_RESIZE_MODE"], true );
						}
					}
				$ColorsCodes[$IdItem][] = $ColorArray['PROPERTIES'][$colorCode]['VALUE'];
			}
		}
		foreach( $arResult["ITEMS"] as $key => $arItem )
			foreach( $ColorsCodes[$arItem['ID']] as $i => $ColorCodeItem )
				$arResult["ITEMS"][$key]["OFFER_TREE_PROPS"][$colorCode] = array_merge( $arResult["ITEMS"][$key]["OFFER_TREE_PROPS"][$colorCode], $AllColors[$colorCode] );
	}
}
foreach( $arResult["MORE_PHOTO_JS"] as $IDEl => $Colors )
{
	foreach( $Colors as $ColorCode => $ColVals )
	{
		$arResult["MORE_PHOTO_JS"][$IDEl][$ColorCode]["SMALL"] = array_values( $ColVals["SMALL"] );
		$arResult["MORE_PHOTO_JS"][$IDEl][$ColorCode]["MEDIUM"] = array_values( $ColVals["MEDIUM"] );
	}
}
// END LINK COLOR


  //START COLOR IN TOVAR
  
  
  if(isset($arParams["COLOR_IN_PRODUCT"])&&$arParams["COLOR_IN_PRODUCT"]&&isset($arParams['COLOR_IN_PRODUCT_CODE'])&&!empty($arParams['COLOR_IN_PRODUCT_CODE']))
  {
  	  
	   foreach( $arResult["ITEMS"] as $i => $arElement )
	   {
            foreach($arElement["PROPERTIES"] as $code=>$arProps)
            {
                if($availableDelete && !$arOffer["CAN_BUY"])
                    continue 1;
                if($arProps["VALUE"] && $code==$colorCode)
                {
                    if($arProps["USER_TYPE"]=="directory")
                    {
                        $arDirVal = $arResult["LIST_PROPS"][$code][$arProps["VALUE"]];
                        $arResult["MORE_PHOTO_JS"][$arElement['ID']][strtolower($arDirVal['UF_NAME'])]=$arResult["MORE_PHOTO_JS"][$arElement['ID']][0];
                        unset($arResult["MORE_PHOTO_JS"][$arElement['ID']][0]);
                        $arResult["ITEMS"][$i]["OFFER_TREE_PROPS"][$colorCode]=$arResult["LIST_PROPS_NAME"][$colorCode];
                    }
                }
            }
	   }
  }
  
  
  //END COLOR IN TOVAR



// ONE COLOR
foreach( $arResult["MORE_PHOTO_JS"] as $IdElx => $Colors )
{
	if(count( $Colors )==1)
	{
		foreach( $Colors as $ColorCode => $ColVals )
		{
			if(count( $ColVals["SMALL"] )==count( $ColVals["MEDIUM"] ))
			{
				foreach( $ColVals["SMALL"] as $key => $SmallVars )
				{
					if($key!=0)
					{
						$arResult["MORE_PHOTO_JS"][$IdElx][$ColorCode.$key]["SMALL"][0] = $SmallVars;
						unset( $arResult["MORE_PHOTO_JS"][$IdElx][$ColorCode]["SMALL"][$key] );
					}
				}
				foreach( $ColVals["MEDIUM"] as $key => $SmallVars )
				{
					if($key!=0)
					{
						$arResult["MORE_PHOTO_JS"][$IdElx][$ColorCode.$key]["MEDIUM"][0] = $SmallVars;
						unset( $arResult["MORE_PHOTO_JS"][$IdElx][$ColorCode]["MEDIUM"][$key] );
					}
				}
			}
			elseif(count( $ColVals["SMALL"] )<count( $ColVals["MEDIUM"] ))
			{
				foreach( $ColVals["MEDIUM"] as $key => $SmallVars )
				{
					if($key!=0)
					{
						$arResult["MORE_PHOTO_JS"][$IdElx][$ColorCode.$key]["MEDIUM"][0] = $SmallVars;
						$arResult["MORE_PHOTO_JS"][$IdElx][$ColorCode.$key]["SMALL"][0] = $SmallVars;
						unset( $arResult["MORE_PHOTO_JS"][$IdElx][$ColorCode]["MEDIUM"][$key] );
					}
				}
			}
			elseif(count( $ColVals["SMALL"] )>count( $ColVals["MEDIUM"] ))
			{
				foreach( $ColVals["SMALL"] as $key => $SmallVars )
				{
					if($key!=0)
					{
						$arResult["MORE_PHOTO_JS"][$IdElx][$ColorCode.$key]["MEDIUM"][0] = $SmallVars;
						$arResult["MORE_PHOTO_JS"][$IdElx][$ColorCode.$key]["SMALL"][0] = $SmallVars;
						unset( $arResult["MORE_PHOTO_JS"][$IdElx][$ColorCode]["SMALL"][$key] );
					}
				}
			}
			break;
		}
	}
}
// END ONE COLOR
$this->__component->arResultCacheKeys = array_merge($this->__component->arResultCacheKeys, array('FANCY', 'RAND'));
?>