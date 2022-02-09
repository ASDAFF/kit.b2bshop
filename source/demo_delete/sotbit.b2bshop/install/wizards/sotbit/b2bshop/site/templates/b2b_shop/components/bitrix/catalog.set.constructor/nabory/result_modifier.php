<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$smallImg["width"] = $arParams["LIST_WIDTH_SMALL"];
$smallImg["height"] = $arParams["LIST_HEIGHT_SMALL"];
$mediumImg["width"] = $arParams["LIST_WIDTH_MEDIUM"];
$mediumImg["height"] = $arParams["LIST_HEIGHT_MEDIUM"];
$imageFromOffer = ($arParams["PICTURE_FROM_OFFER"]=="Y") ? 1 : 0;
$codeMorePhoto = "MORE_PHOTO";
$brandCode = $arParams["MANUFACTURER_ELEMENT_PROPS"];

$Iblocks=array();

$Iblocks[$arResult['ELEMENT_IBLOCK_ID']][]=$arResult['ELEMENT_ID'];

$RESIZE_MODE=BX_RESIZE_IMAGE_PROPORTIONAL;
if($arParams["IMAGE_RESIZE_MODE"]=="BX_RESIZE_IMAGE_EXACT")
	$RESIZE_MODE=BX_RESIZE_IMAGE_EXACT;
	elseif($arParams["IMAGE_RESIZE_MODE"]=="BX_RESIZE_IMAGE_PROPORTIONAL")
	$RESIZE_MODE=BX_RESIZE_IMAGE_PROPORTIONAL;
	elseif($arParams["IMAGE_RESIZE_MODE"]=="BX_RESIZE_IMAGE_PROPORTIONAL_ALT")
	$RESIZE_MODE=BX_RESIZE_IMAGE_PROPORTIONAL_ALT;

if ($arResult["ELEMENT"]['DETAIL_PICTURE'] || $arResult["ELEMENT"]['PREVIEW_PICTURE'])
{
	$arFileTmp = CFile::ResizeImageGet(
		$arResult["ELEMENT"]['DETAIL_PICTURE'] ? $arResult["ELEMENT"]['DETAIL_PICTURE'] : $arResult["ELEMENT"]['PREVIEW_PICTURE'],
		array("width" => $mediumImg["width"], "height" => $mediumImg["height"]),
		$RESIZE_MODE,
		true
	);
	$arResult["ELEMENT"]['DETAIL_PICTURE'] = $arFileTmp;
}

$arDefaultSetIDs = array($arResult["ELEMENT"]["ID"]);

$arResult['SUM']=0;

if($arResult["ELEMENT"]["PRICE_VALUE"]==$arResult["ELEMENT"]["PRICE_DISCOUNT_VALUE"])
{
	$arResult['SUM']=$arResult["ELEMENT"]["PRICE_VALUE"]*$arResult["ELEMENT"]['BASKET_QUANTITY'];
}
else
{
	$arResult['SUM']=$arResult["ELEMENT"]["PRICE_DISCOUNT_VALUE"]*$arResult["ELEMENT"]['BASKET_QUANTITY'];
}

$Ids=array();

foreach (array("DEFAULT", "OTHER") as $type)
{
	foreach ($arResult["SET_ITEMS"][$type] as $key=>$arItem)
	{
		$arElement = array(
			"ID"=>$arItem["ID"],
			"NAME" =>$arItem["NAME"],
			"DETAIL_PAGE_URL"=>$arItem["DETAIL_PAGE_URL"],
			"DETAIL_PICTURE"=>$arItem["DETAIL_PICTURE"],
			"PREVIEW_PICTURE"=> $arItem["PREVIEW_PICTURE"],
			"PRICE_CURRENCY" => $arItem["PRICE_CURRENCY"],
			"PRICE_DISCOUNT_VALUE" => $arItem["PRICE_DISCOUNT_VALUE"],
			"PRICE_PRINT_DISCOUNT_VALUE" => $arItem["PRICE_PRINT_DISCOUNT_VALUE"],
			"PRICE_VALUE" => $arItem["PRICE_VALUE"],
			"PRICE_PRINT_VALUE" => $arItem["PRICE_PRINT_VALUE"],
			"PRICE_DISCOUNT_DIFFERENCE_VALUE" => $arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"],
			"PRICE_DISCOUNT_DIFFERENCE" => $arItem["PRICE_DISCOUNT_DIFFERENCE"],
			"CAN_BUY" => $arItem['CAN_BUY'],
			"SET_QUANTITY" => $arItem['SET_QUANTITY'],
			"MEASURE_RATIO" => $arItem['MEASURE_RATIO'],
			"BASKET_QUANTITY" => $arItem['BASKET_QUANTITY'],
			"MEASURE" => $arItem['MEASURE']
		);
		if ($arItem["PRICE_CONVERT_DISCOUNT_VALUE"])
			$arElement["PRICE_CONVERT_DISCOUNT_VALUE"] = $arItem["PRICE_CONVERT_DISCOUNT_VALUE"];
		if ($arItem["PRICE_CONVERT_VALUE"])
			$arElement["PRICE_CONVERT_VALUE"] = $arItem["PRICE_CONVERT_VALUE"];
		if ($arItem["PRICE_CONVERT_DISCOUNT_DIFFERENCE_VALUE"])
			$arElement["PRICE_CONVERT_DISCOUNT_DIFFERENCE_VALUE"] = $arItem["PRICE_CONVERT_DISCOUNT_DIFFERENCE_VALUE"];
		if ($arItem["PRICE_DISCOUNT_PERCENT"])
			$arElement["PRICE_DISCOUNT_PERCENT"] = $arItem["PRICE_DISCOUNT_PERCENT"];




		$Ids[]=$arItem["ID"];

		$Iblocks[$arItem['IBLOCK_ID']][]=$arItem["ID"];


			$arDefaultSetIDs[] = $arItem["ID"];

			if ($arItem['DETAIL_PICTURE'] || $arItem['PREVIEW_PICTURE'])
			{
				$arFileTmp = CFile::ResizeImageGet(
						$arItem['DETAIL_PICTURE'] ? $arItem['DETAIL_PICTURE'] : $arItem['PREVIEW_PICTURE'],
						array("width" => $mediumImg["width"], "height" => $mediumImg["height"]),
						$RESIZE_MODE,
						true
						);
				$arElement['DETAIL_PICTURE'] = $arFileTmp;
			}


		$arResult["SET_ITEMS"][$type][$key] = $arElement;

		if($arElement["PRICE_VALUE"]==$arElement["PRICE_DISCOUNT_VALUE"])
		{
			$arResult['SUM']+=$arElement["PRICE_VALUE"]*$arElement["BASKET_QUANTITY"];
		}
		else
		{
			$arResult['SUM']+=$arElement["PRICE_DISCOUNT_VALUE"]*$arElement["BASKET_QUANTITY"];
		}
	}
}
$arResult["DEFAULT_SET_IDS"] = $arDefaultSetIDs;


$arResult["SET_ITEMS"]["DEFAULT"]=array_merge($arResult["SET_ITEMS"]["DEFAULT"],$arResult["SET_ITEMS"]["OTHER"]);
$arResult["SET_ITEMS"]["OTHER"]=array();

//Images
$arImages=array();

if($imageFromOffer)
{
	$arSelect = Array("ID", "DETAIL_PICTURE", "PREVIEW_PICTURE","PROPERTY_".$codeMorePhoto);
	$arFilter = Array("ID"=>$Ids );
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($arFields = $res->Fetch())
	{

		if(isset($arImages[$arFields['ID']]))
			continue;

		if(isset($arFields['PROPERTY_'.$codeMorePhoto.'_VALUE']) && !empty($arFields['PROPERTY_'.$codeMorePhoto.'_VALUE']))
		{
			$arImages[$arFields['ID']]=$arFields['PROPERTY_'.$codeMorePhoto.'_VALUE'];
		}
		elseif(isset($arFields['DETAIL_PICTURE']) && !empty($arFields['DETAIL_PICTURE']))
		{
			$arImages[$arFields['ID']]=$arFields['DETAIL_PICTURE'];
		}
		elseif(isset($arFields['PREVIEW_PICTURE']) && !empty($arFields['PREVIEW_PICTURE']))
		{
			$arImages[$arFields['ID']]=$arFields['PREVIEW_PICTURE'];
		}
	}
	foreach($arResult["SET_ITEMS"]["DEFAULT"] as $k=>$Elem)
	{
		if(isset($arImages[$Elem['ID']]) && !empty($arImages[$Elem['ID']]))
		{
			$arFile = CFile::GetFileArray($arImages[$Elem['ID']]);
			$arFileTmp = CFile::ResizeImageGet(
					$arFile,
					array("width" => $mediumImg["width"], "height" => $mediumImg["height"]),
					$RESIZE_MODE,
					true
					);

			$arResult["SET_ITEMS"]["DEFAULT"][$k]['DETAIL_PICTURE'] = $arFileTmp;
		}
	}
}

/*brands*/
$arIblockProducts=0;
$arIblockOffers=0;
$arIblocks=array();
foreach($Iblocks as $Iblock=>$Elem)
{
	if(!in_array($Iblock,$arIblocks))
	{
		$arIblocks[]=$Iblock;
		$mxResult = CCatalogSKU::GetInfoByOfferIBlock(
				$Iblock
				);

		if (!is_array($mxResult))
		{
			$arIblockProducts=$Iblock;
		}
		else
		{
			$arIblockOffers=$Iblock;
		}
	}
}
$Prods=array();
$ProdOffers=array();
if($arIblockOffers>0)
{
	$Prods=CCatalogSKU::getProductList(
			$Iblocks[$arIblockOffers],
			$arIblockOffers
			);

	foreach($Prods as $IdOffer=>$IdProduct)
	{
		$Iblocks[$arIblockProducts][]=$IdProduct['ID'];
		$ProdOffers[$IdOffer]=$IdProduct['ID'];
	}

	$Iblocks[$arIblockProducts]=array_unique($Iblocks[$arIblockProducts]);
}

	$arBrands=array();
	$Brands=array();
	$arSelect = Array("ID",'LINK_IBLOCK_ID',"PROPERTY_".$brandCode);
	$arFilter = Array("ID"=>$Iblocks[$arIblockProducts] );
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($arFields = $res->Fetch())
	{
		if($arFields['PROPERTY_'.$brandCode.'_VALUE']>0)
		{
			$arBrands[$arFields['ID']]=$arFields['PROPERTY_'.$brandCode.'_VALUE'];
			$Brands[]=$arFields['PROPERTY_'.$brandCode.'_VALUE'];
		}
	}

	$arResult['BRANDS']=array();

	$rsBrand = CIBlockElement::GetList( Array(), array(
			"ID" => $Brands
	), false, false, array(
			"ID",
			"NAME",
			"DETAIL_PAGE_URL"
	) );
	while( $arBrand = $rsBrand->GetNext() )
	{
		foreach($arBrands as $IdProduct=>$IdBrand)
		{
			$Offers=array();
			foreach($ProdOffers as $IdOffer=>$IdProd)
			{
				if($IdProd==$IdProduct)
				{
					$Offers[]=$IdOffer;
				}
			}
			if(count($Offers)>0)
			{
				foreach($Offers as $Offer)
				{
					if($arBrand['ID']==$IdBrand)
						$arResult['BRANDS'][$Offer]=$arBrand;
				}
			}
			else
			{
				if($arBrand['ID']==$IdBrand)
					$arResult['BRANDS'][$IdProduct]=$arBrand;
			}
		}

	}
	if(isset($arResult['CURRENCIES'][0]['CURRENCY']) && $arResult['CURRENCIES'][0]['CURRENCY']!='')
	{
		$cur=CCurrencyLang::GetByID($arResult['CURRENCIES'][0]['CURRENCY'], LANGUAGE_ID);
		$arResult['CUR']=str_replace('#','',$cur['FORMAT_STRING']);
	}
//Currency
//$arResult['SUM']=CurrencyFormat($arResult['SUM'], $arResult['CURRENCIES'][0]['CURRENCY']);

