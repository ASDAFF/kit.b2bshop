<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//printr($arResult);
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
$arCatalog = CCatalogSKU::GetInfoByIBlock($arParams["IBLOCK_ID"]);

$all_quantity = 0;
$all_cost = 0;
$colorCode = $arParams["OFFER_COLOR_PROP"];
$imageFromOffer = ($arParams["PICTURE_FROM_OFFER"]=="Y")?1:0;;
$codeBrand = $arParams["MANUFACTURER_LIST_PROPS"];
$codeArticle = $arCatalog["SKU_PROPERTY_ID"];
$codeMorePhoto = "MORE_PHOTO";
$codeProductMorePhoto = $arParams["MORE_PHOTO_PRODUCT_PROPS"];/*?????????? ??? ???. ????????*/
$codeOfferMorePhoto = $arParams["MORE_PHOTO_OFFER_PROPS"];
$arID = $arElementID = array();
$imgWidth = $arParams["IMG_WIDTH"];
$imgHeight = $arParams["IMG_HEIGHT"];

//printr($arParams);
$cp = $this->__component;
if (is_object($cp))
{
	CModule::IncludeModule('iblock');

	if(empty($arResult['ERRORS']['FATAL']))
	{

		$hasDiscount = false;
		$hasProps = false;
		$productSum = 0;
		$basketRefs = array();

		$noPict = array(
			'SRC' => $this->GetFolder().'/images/no_photo.png'
		);

		if(is_readable($nPictFile = $_SERVER['DOCUMENT_ROOT'].$noPict['SRC']))
		{
			$noPictSize = getimagesize($nPictFile);
			$noPict['WIDTH'] = $noPictSize[0];
			$noPict['HEIGHT'] = $noPictSize[1];
		}
        //printr($arResult["BASKET"]);
		foreach($arResult["BASKET"] as $k => &$prod)
		{
			if(floatval($prod['DISCOUNT_PRICE']))
				$hasDiscount = true;
            $arID[$prod["PRODUCT_ID"]] = $prod["PRODUCT_ID"];
			// move iblock props (if any) to basket props to have some kind of consistency
			if(isset($prod['IBLOCK_ID']))
			{
				$iblock = $prod['IBLOCK_ID'];
				if(isset($prod['PARENT']))
					$parentIblock = $prod['PARENT']['IBLOCK_ID'];

				foreach($arParams['CUSTOM_SELECT_PROPS'] as $prop)
				{
					$key = $prop.'_VALUE';
					if(isset($prod[$key]))
					{
						// in the different iblocks we can have different properties under the same code
						if(isset($arResult['PROPERTY_DESCRIPTION'][$iblock][$prop]))
							$realProp = $arResult['PROPERTY_DESCRIPTION'][$iblock][$prop];
						elseif(isset($arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop]))
							$realProp = $arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop];
						
						if(!empty($realProp))
							$prod['PROPS'][] = array(
								'NAME' => $realProp['NAME'], 
								'VALUE' => htmlspecialcharsEx($prod[$key])
							);
					}
				}
			}

			// if we have props, show "properties" column
			if(!empty($prod['PROPS']))
            {
                $hasProps = true;
                foreach($prod['PROPS'] as $prop)
                {
                    $prod["PROPS_CODE"][$prop["CODE"]] = $prop;        
                }    
            }
				
                
            $one_productSum = $prod['PRICE'] * $prod['QUANTITY'];
            
            $arResult["BASKET"][$k]['FULL_PRICE_FORMATED'] = SaleFormatCurrency($one_productSum, $arResult['CURRENCY']);
            
			$productSum += $prod['PRICE'] * $prod['QUANTITY'];

			$basketRefs[$prod['PRODUCT_ID']][] =& $arResult["BASKET"][$k];

			if(!isset($prod['PICTURE']))
				$prod['PICTURE'] = $noPict;
		}

		$arResult['HAS_DISCOUNT'] = $hasDiscount;
		$arResult['HAS_PROPS'] = $hasProps;

		$arResult['PRODUCT_SUM_FORMATTED'] = SaleFormatCurrency($productSum, $arResult['CURRENCY']);

		if($img = intval($arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE_ID']))
		{

			$pict = CFile::ResizeImageGet($img, array(
				'width' => 150,
				'height' => 90
			), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);

			if(strlen($pict['src']))
				$pict = array_change_key_case($pict, CASE_UPPER);

			$arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE'] = $pict;
		}
        
        
        if($imageFromOffer)
        {
            if(!empty($arID))
            {
                $rsOffer = CIBlockElement::GetList(array(), array("=ID"=>$arID), false, false, array("ID", "IBLOCK_ID", "PREVIEW_PICTURE", "DETAIL_PICTURE", "PROPERTY_".$codeOfferMorePhoto,  "PROPERTY_".$codeArticle));
                while($arOffer = $rsOffer->Fetch())
                {
                    $img = $arOffer["PREVIEW_PICTURE"]?$arOffer["PREVIEW_PICTURE"]:$arOffer["DETAIL_PICTURE"];
                    $imgMorePhoto = $arOffer["PROPERTY_".$codeOfferMorePhoto."_VALUE"];
                    $ID = $arOffer["ID"];

                    $productID = $arOffer["PROPERTY_".$codeArticle."_VALUE"];
                    if($productID)
                        $arElementID[$productID] = $productID;

                    $arElementOfferID[$arOffer["ID"]] = $productID;
                    $arOfferElementID[$id][$arOffer["ID"]] = $arOffer["ID"];


                    if(!isset($arResult["MORE_PHOTO"][$ID]) && $img)
                    {
                        $arResult["MORE_PHOTO"][$ID] = CFile::GetFileArray($img);
                    }

                    if(!isset($arResult["MORE_PHOTO"][$ID]) && $imgMorePhoto)
                        $arResult["MORE_PHOTO"][$ID] = CFile::GetFileArray($imgMorePhoto);
                }

                /*???????? ??? ??????, ? ??????? ??? ????????*/
                if(is_array($arResult["MORE_PHOTO"])) {
                    foreach($arResult["MORE_PHOTO"] as $ID=>$arImg)
                    {
                        if(isset($arID[$ID]))
                            unset($arID[$ID]);
                    }   
                }

                /*???????? ???????? ???? ??????? ? ???????*/
                if(isset($arID) && !empty($arID))
                {
                    foreach($arID as $ID)
                    {
                        $arElementID[] = $arElementOfferID[$ID];
                    }
                    $rsElement = CIBlockElement::GetList(array(), array("=ID"=>$arElementID), false, false, array("ID", "IBLOCK_ID", "PREVIEW_PICTURE", "DETAIL_PICTURE", "PROPERTY_".$codeProductMorePhoto));
                    while($arElement = $rsElement->Fetch())
                    {
                        $ID = $arElement["ID"];
                        if(is_array($arOfferElementID[$ID])) {
                            foreach($arOfferElementID[$ID] as $offerID)
                            {
                                $img = $arOffer["PREVIEW_PICTURE"]?$arOffer["PREVIEW_PICTURE"]:$arOffer["DETAIL_PICTURE"];
                                $imgMorePhoto = $arOffer["PROPERTY_".$codeProductMorePhoto."_VALUE"];
                                if(!isset($arResult["MORE_PHOTO"][$offerID]) && $img)
                                {
                                    $arResult["MORE_PHOTO"][$offerID] = CFile::GetFileArray($img);
                                }

                                if(!isset($arResult["MORE_PHOTO"][$offerID]) && $imgMorePhoto)
                                    $arResult["MORE_PHOTO"][$offerID] = CFile::GetFileArray($imgMorePhoto);
                            }     
                        }
                    }
                }

                foreach($arResult["BASKET"] as &$arBasket)
                {
                    //if($arBasket["CAN_BUY"]=="Y" && $arBasket["DELAY"]=="N")
                    {
                        $id = $arBasket["PRODUCT_ID"];
                        if(isset($arResult["MORE_PHOTO"][$id]))
                        {
                            $arPhoto = $arResult["MORE_PHOTO"][$id];
                            $arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                        }

                    }
                }

            }    
        }else{
        /*???????? ?? ??????*/
        if(!empty($arID))
        {   /*???????? ??????*/
            $rsOffer = CIBlockElement::GetList(array(), array("=ID"=>$arID), false, false, array("ID", "IBLOCK_ID", "PROPERTY_".$codeArticle));
            while($arOffer = $rsOffer->Fetch())
            {
                $id = $arOffer["PROPERTY_".$codeArticle."_VALUE"];
                $arElementID[$id] = $id;
                $arOfferElementID[$id][$arOffer["ID"]] = $arOffer["ID"];
            }
            if(!empty($arElementID))
            {   /*???????? ?????? ??????? ? ????????*/
                $rsElement = CIBlockElement::GetList(array(), array("=ID"=>$arElementID), false, false, array("ID", "IBLOCK_ID", "PREVIEW_PICTURE", "DETAIL_PICTURE", "PROPERTY_".$codeProductMorePhoto));
                while($arElement = $rsElement->Fetch())
                {
                    if(isset($arOfferElementID[$arElement["ID"]]))
                    {
                        foreach($arOfferElementID[$arElement["ID"]] as $ID)
                        {
                            $img = $arElement["PREVIEW_PICTURE"]?$arElement["PREVIEW_PICTURE"]:$arElement["DETAIL_PICTURE"];
                            $imgMorePhoto = $arElement["PROPERTY_".$codeProductMorePhoto."_VALUE"];

                            if(!isset($arResult["MORE_PHOTO"][$ID][$img]) && $img)
                            {
                                $arResult["MORE_PHOTO"][$ID][$img] = CFile::GetFileArray($img);
                                $arResult["DEFAULT_MORE_PHOTO"][$ID] = CFile::GetFileArray($img);
                            }

                            if(!isset($arResult["MORE_PHOTO"][$ID][$imgMorePhoto]) && $imgMorePhoto)
                                $arResult["MORE_PHOTO"][$ID][$imgMorePhoto] = CFile::GetFileArray($imgMorePhoto);
                        }
                    }
                }
            }

            if(isset($arResult["MORE_PHOTO"]) && !empty($arResult["MORE_PHOTO"]))
            {
                foreach($arResult["MORE_PHOTO"] as $offerID=>$arOfferPhoto)
                {
                    foreach($arOfferPhoto as $arPhoto)
                    {
                        //printr($arPhoto);
                        $descr = mb_strtolower($arPhoto["DESCRIPTION"]);
                        $arDescr = explode("_", $descr);
                        //printr($arDescr);
                        $color = $arDescr[0];
                        if($descr && isset($arDescr[1]))
                        {
                            $index = $arDescr[1];
                            $arResult["MORE_PHOTO_LOGIC"][$offerID][$color][$index] = $arPhoto;
                        }elseif(!$descr && isset($arDescr[1]))
                        {
                            $arResult["MORE_PHOTO_LOGIC"][$offerID][$color][] = $arPhoto;
                        }else $arResult["MORE_PHOTO_LOGIC"][$offerID][0][] = $arPhoto;
                    }

                }

                foreach($arResult["MORE_PHOTO_LOGIC"] as $offerID=>$arColorPhoto)
                {
                    foreach($arColorPhoto as $color=>$arOfferPhoto)
                    {
                        ksort($arResult["MORE_PHOTO_LOGIC"][$offerID][$color]);
                        $arResult["MORE_PHOTO_LOGIC"][$offerID][$color] = array_values($arResult["MORE_PHOTO_LOGIC"][$offerID][$color]);
                    }
                }
            }

            foreach($arResult["BASKET"] as &$arBasket)
            {   //printr($arBasket);
                //if($arBasket["CAN_BUY"]=="Y" && $arBasket["DELAY"]=="N")
                {
                    if(isset($arBasket["PROPS_CODE"][$colorCode]) && $arBasket["PROPS_CODE"][$colorCode]["VALUE"])
                    {   //print "COLOR";
                        $color = mb_strtolower($arBasket["PROPS_CODE"][$colorCode]["VALUE"]);
                        $ID = $arBasket["PRODUCT_ID"];
                        if(isset($arResult["MORE_PHOTO_LOGIC"][$ID][$color]))
                        {
                            $arPhoto = $arResult["MORE_PHOTO_LOGIC"][$ID][$color][0];//printr($arPhoto);
                            $arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                        }else{
                            $arPhoto = $arResult["DEFAULT_MORE_PHOTO"][$ID];
                            $arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                        }
                    }else{
                        //$arPhoto = $arResult["MORE_PHOTO_LOGIC"][$ID][$color][0];
                        $arPhoto = $arResult["DEFAULT_MORE_PHOTO"][$ID];
                        $arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                    }
                }
            }

        }
    }

	}
}


?>