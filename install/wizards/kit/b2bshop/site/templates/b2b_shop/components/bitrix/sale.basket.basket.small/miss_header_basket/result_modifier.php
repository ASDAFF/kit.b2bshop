<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$codeProductMorePhoto = $arParams["MORE_PHOTO_PRODUCT_PROPS"];/*Символьынй код доп. картинок*/
$codeOfferMorePhoto = $arParams["MORE_PHOTO_OFFER_PROPS"];
$arID = $arElementID = array();
$imgWidth = $arParams["IMG_WIDTH"];
$imgHeight = $arParams["IMG_HEIGHT"];


if(!empty($arResult["ITEMS"])):
    foreach ($arResult["ITEMS"] as &$arItem):
        if ($arItem["CAN_BUY"]=="Y" && $arItem["DELAY"]=="N"):
            $arID[$arItem["PRODUCT_ID"]] = $arItem["PRODUCT_ID"];
            $dbProp = CSaleBasket::GetPropsList(
				array("SORT" => "ASC", "ID" => "ASC"),
				array("BASKET_ID" => $arItem["ID"], "!CODE" => array("CATALOG.XML_ID", "PRODUCT.XML_ID"))
			);
			while ($arProp = $dbProp->GetNext())
				$arItem["PROPS"][$arProp["CODE"]] = $arProp;

            $arItem["NAME"] = preg_replace("/\((.*)\)/", "", $arItem["NAME"]);

            $all_quantity = $all_quantity + $arItem['QUANTITY'];
            $all_cost = $all_cost + ($arItem['PRICE']*$arItem['QUANTITY']);
            $currency = $arItem["CURRENCY"];
        endif;
    endforeach;
        $arResult['ALL_QUANTITY'] = $all_quantity;
        $arResult['ALL_COST'] = SaleFormatCurrency($all_cost, $currency);

    /*Картинки из офферов*/
    if($imageFromOffer && isset($_REQUEST["ajax_top_basket"]) && $_REQUEST["ajax_top_basket"]=="Y")
    {
        if(!empty($arID))
        {
            $rsOffer = CIBlockElement::GetList(array(), array("=ID"=>$arID), false, false, array("ID", "IBLOCK_ID", "PREVIEW_PICTURE", "DETAIL_PICTURE", "PROPERTY_".$codeOfferMorePhoto,  "PROPERTY_".$codeArticle, "PROPERTY_".$colorCode));
            while($arOffer = $rsOffer->Fetch())
            {
                if($arOffer["IBLOCK_ID"]==$arParams["IBLOCK_ID"])
                {
                    
                }else{
                    
                }
                
                
                $img = $arOffer["PREVIEW_PICTURE"]?$arOffer["PREVIEW_PICTURE"]:$arOffer["DETAIL_PICTURE"];
                $imgMorePhoto = $arOffer["PROPERTY_".$codeOfferMorePhoto."_VALUE"];
                $color = $arOffer["PROPERTY_".$colorCode."_VALUE"];
                $ID = $arOffer["ID"];
                
                $productID = $arOffer["PROPERTY_".$codeArticle."_VALUE"];
                if($productID)
                {
                    $arElementID[$productID] = $productID;
                    $arElementOfferID[$arOffer["ID"]] = $productID;
                    $arOfferElementID[$productID][$arOffer["ID"]] = $arOffer["ID"];    
                }

                if(!$color && $productID) continue 1;
                if(!isset($arResult["MORE_PHOTO"][$ID]) && $img)
                {
                    $arResult["MORE_PHOTO"][$ID] = CFile::GetFileArray($img);
                }

                if(!isset($arResult["MORE_PHOTO"][$ID]) && $imgMorePhoto)
                    $arResult["MORE_PHOTO"][$ID] = CFile::GetFileArray($imgMorePhoto);
            }

            foreach($arResult["ITEMS"] as &$arBasket)
            {
                if($arBasket["CAN_BUY"]=="Y" && $arBasket["DELAY"]=="N")
                {
                    $id = $arBasket["PRODUCT_ID"];
                    if(isset($arResult["MORE_PHOTO"][$id]))
                    {
                        $arPhoto = $arResult["MORE_PHOTO"][$id];
                        $arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                    }

                }
            }
            /*Выбираем все офферы, у которых нет картинок*/
            foreach($arResult["MORE_PHOTO"] as $ID=>$arImg)
            {
                if(isset($arID[$ID]))
                    unset($arID[$ID]);
            }
            /*Выбираем картинки этих офферов у товаров*/
            if(isset($arID) && !empty($arID))
            {
                foreach($arID as $ID)
                {
                    if(isset($arElementOfferID[$ID]))
                        $arElementID[] = $arElementOfferID[$ID];
                }
                $rsElement = CIBlockElement::GetList(array(), array("=ID"=>$arElementID), false, false, array("ID", "IBLOCK_ID", "PREVIEW_PICTURE", "DETAIL_PICTURE", "PROPERTY_".$codeProductMorePhoto));
                while($arElement = $rsElement->Fetch())
                {
                    $ID = $arElement["ID"];
                    foreach($arOfferElementID[$ID] as $offerID)
                    {
                        $img = $arElement["PREVIEW_PICTURE"]?$arElement["PREVIEW_PICTURE"]:$arElement["DETAIL_PICTURE"];
                        $imgMorePhoto = $arElement["PROPERTY_".$codeProductMorePhoto."_VALUE"];
                        if(!isset($arResult["MORE_PHOTO"][$offerID]) && $img)
                        {
                            $arResult["MORE_PHOTO"][$offerID] = CFile::GetFileArray($img);
                        }

                        if(!isset($arResult["MORE_PHOTO"][$offerID]) && $imgMorePhoto)
                            $arResult["MORE_PHOTO"][$offerID] = CFile::GetFileArray($imgMorePhoto);
                    }

                }
            }
            
            foreach($arResult["ITEMS"] as &$arBasket)
            {
                if($arBasket["CAN_BUY"]=="Y" && $arBasket["DELAY"]=="N")
                {
                    $id = $arBasket["PRODUCT_ID"];
                    if(isset($arResult["MORE_PHOTO"][$id]) && !isset($arBasket["PICTURE"]))
                    {
                        $arPhoto = $arResult["MORE_PHOTO"][$id];
                        if($arPhoto)
                            $arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                    }

                }
            }

        }
    }elseif(isset($_REQUEST["ajax_top_basket"]) && $_REQUEST["ajax_top_basket"]=="Y"){
        /*Картинки из товара*/
        if(!empty($arID))
        {   /*Выбираем офферы*/
            $rsOffer = CIBlockElement::GetList(array(), array("=ID"=>$arID), false, false, array("ID", "IBLOCK_ID", "PROPERTY_".$codeArticle));
            while($arOffer = $rsOffer->Fetch())
            {
                if($arOffer["IBLOCK_ID"]==$arParams["IBLOCK_ID"])
                {
                    $arElementID[$arOffer["ID"]] = $arOffer["ID"];
                    $arOfferElementID[$arOffer["ID"]][$arOffer["ID"]] = $arOffer["ID"];
                    $arElementOfferID[$arOffer["ID"]] = $arOffer["ID"];
                            
                }else{
                    $id = $arOffer["PROPERTY_".$codeArticle."_VALUE"];
                    $arElementID[$id] = $id;
                    $arOfferElementID[$id][$arOffer["ID"]] = $arOffer["ID"];
                
                    $arElementOfferID[$arOffer["ID"]] = $id;    
                }
                
                
            }
            if(!empty($arElementID))
            {   /*Выбираем товары офферов и картинки*/
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
                        $descr = mb_strtolower($arPhoto["DESCRIPTION"]);
                        $arDescr = explode("_", $descr);
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

            foreach($arResult["ITEMS"] as &$arBasket)
            {
                if($arBasket["CAN_BUY"]=="Y" && $arBasket["DELAY"]=="N")
                {
                    $ID = $arBasket["PRODUCT_ID"];
                    if(isset($arBasket["PROPS"][$colorCode]) && $arBasket["PROPS"][$colorCode]["VALUE"])
                    {
                        $color = mb_strtolower($arBasket["PROPS"][$colorCode]["VALUE"]);
                        
                        if(isset($arResult["MORE_PHOTO_LOGIC"][$ID][$color]))
                        {
                            $arPhoto = $arResult["MORE_PHOTO_LOGIC"][$ID][$color][0];
                            $arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                        }else{
                            $arPhoto = $arResult["DEFAULT_MORE_PHOTO"][$ID];
                            $arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                        }
                    }else{
                        $arPhoto = $arResult["DEFAULT_MORE_PHOTO"][$ID];
                        $arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, array('width'=>$imgWidth, 'height'=>$imgHeight), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                    }
                }
            }
            
            

        }
    }
    
    /*Поиск брендов*/
    if($codeBrand && isset($_REQUEST["ajax_top_basket"]) && $_REQUEST["ajax_top_basket"]=="Y" && $arElementID)
    {
        $rsElement = CIBlockElement::GetList(array(), array("=ID"=>$arElementID), false, false, array("ID", "IBLOCK_ID", "PROPERTY_".$codeBrand));
        while($arElement = $rsElement->Fetch())
        {
            $arResult["BRANDS"][$arElement["ID"]] = $arElement["PROPERTY_".$codeBrand."_VALUE"];
            $arOfferElementID[$id][$arOffer["ID"]] = $arOffer["ID"];
                
        }
        
        foreach($arResult["ITEMS"] as &$arBasket)
        {
            if($arBasket["CAN_BUY"]=="Y" && $arBasket["DELAY"]=="N")
            {
                $ID = $arBasket["PRODUCT_ID"];
                $productID = $arElementOfferID[$ID];
                
                if(isset($arResult["BRANDS"][$productID]))
                    $arBasket["BRAND"] = $arResult["BRANDS"][$productID];
            }    
        }
    }

endif;

if(!function_exists('BITGetDeclNum'))
{
    /**
     * Возврат окончания слова при склонении
     *
     * Функция возвращает окончание слова, в зависимости от примененного к ней числа
     * Например: 5 товаров, 1 товар, 3 товара
     *
     * @param int $value - число, к которому необходимо применить склонение
     * @param array $status - массив возможных окончаний
     * @return mixed
     */
    function BITGetDeclNum($value=1, $status)
    {
     $array =array(2,0,1,1,1,2);
     return $status[($value%100>4 && $value%100<20)? 2 : $array[($value%10<5)?$value%10:5]];
    }
}
?>