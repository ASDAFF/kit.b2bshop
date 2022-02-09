<?
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
$arCatalog = CCatalogSKU::GetInfoByIBlock($arParams["IBLOCK_ID"]);
$all_quantity = 0;
$all_cost = 0;
$colorCode = $arParams["OFFER_COLOR_PROP"];
$imageFromOffer = ($arParams["PICTURE_FROM_OFFER"] == "Y") ? 1 : 0;
$colorDelete = ($arParams["DELETE_OFFER_NOIMAGE"] == "Y") ? 1 : 0;/*??????? ?????, ???? ??? ????????*/
$codeBrand = $arParams["MANUFACTURER_LIST_PROPS"];
$codeElementBrand = $arParams["MANUFACTURER_ELEMENT_PROPS"];
$codeArticle = $arCatalog["SKU_PROPERTY_ID"];
$codeProductMorePhoto = $arParams["MORE_PHOTO_PRODUCT_PROPS"];/*???????????? ??? ???. ????????*/
$codeOfferMorePhoto = $arParams["MORE_PHOTO_OFFER_PROPS"];
$arID = $arElementID = [];
$imgWidth = $arParams["IMG_WIDTH"];
$imgHeight = $arParams["IMG_HEIGHT"];

$all_quantity = 0;
$all_cost = 0;
$arID = $arElementID = [];
$arFilterProps = [];
$arHighload = [];
$arProductID = [];
$arNoOffer = [];

if(!empty($arParams["OFFER_TREE_PROPS"]))
{
	foreach ($arParams["OFFER_TREE_PROPS"] as $prop)
	{
		$arFilterProps[] = "PROPERTY_" . $prop;
		$arHighload[$prop] = $prop;
	}
}

$isDelay = isset($_REQUEST["delay"]) ? 1 : 0;


if(isset($_REQUEST["delay"]))
{
	$isDelay = 1;
	$_SESSION["ms_delay"] = 1;
}
else
{
	$isDelay = 0;
	if(isset($_REQUEST["basket"]) && isset($_SESSION["ms_delay"]))
		unset($_SESSION["ms_delay"]);
}

if(isset($_SESSION["ms_delay"]))
{
	$isDelay = 1;
	if(empty($arResult["ITEMS"]["DelDelCanBuy"]))
	{
		$isDelay = 0;
		unset($_SESSION["ms_delay"]);
	}
}

if(!isset($arResult["ITEMS"]["AnDelCanBuy"]) || empty($arResult["ITEMS"]["AnDelCanBuy"]) && (isset($arResult["ITEMS"]["DelDelCanBuy"]) && !empty($arResult["ITEMS"]["DelDelCanBuy"])))
{
	$isDelay = 1;
}

if($isDelay)
	$codeBasket = "DelDelCanBuy";
else
	$codeBasket = "AnDelCanBuy";


$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
$boolSKU = !empty($arSKU) && is_array($arSKU);
if($boolSKU && !empty($arHighload))
{
	foreach ($arHighload as $prop)
	{
		$rsProps = CIBlockProperty::GetList(
			[
				'SORT' => 'ASC',
				'ID' => 'ASC'
			],
			[
				"IBLOCK_ID" => $arCatalog["IBLOCK_ID"],
				'CODE' => $prop,
				'ACTIVE' => 'Y'
			]
		);
		while ($arProp = $rsProps->Fetch())
		{
			$nameTable = $arProp["USER_TYPE_SETTINGS"]["TABLE_NAME"];
			$directorySelect = ["*"];
			$directoryOrder = [];

			$entityGetList = [
				'select' => $directorySelect,
				'order' => $directoryOrder
			];
			$highBlock = \Bitrix\Highloadblock\HighloadBlockTable::getList(["filter" => ['TABLE_NAME' => $nameTable]])->fetch();
			$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($highBlock);
			$entityDataClass = $entity->getDataClass();
			$propEnums = $entityDataClass::getList($entityGetList);
			while ($oneEnum = $propEnums->fetch())
			{
				if($oneEnum["UF_FILE"])
				{
					$oneEnum["PIC"] = CFile::GetFileArray($oneEnum["UF_FILE"]);
				}
				$arResult["LIST_PROPS_NAME"][$prop] = $arProp;
				$arResult["LIST_PROPS"][$prop][$oneEnum["UF_XML_ID"]] = $oneEnum;
			}
		}
	}
}

if(!empty($arResult["ITEMS"][$codeBasket]))
{
	if($isDelay)
	{
		foreach ($arResult["ITEMS"][$codeBasket] as &$arItem)
		{
			if($arItem["CAN_BUY"] == "Y" && $arItem["DELAY"] == "Y")
			{
				$arItem["NAME"] = preg_replace("/\((.*)\)/", "", $arItem["NAME"]);
				$arItem["SKU_PRODUCT"] = [];
				$all_quantity = $all_quantity + $arItem['QUANTITY'];
				$all_cost = $all_cost + ($arItem['PRICE'] * $arItem['QUANTITY']);
				$currency = $arItem["CURRENCY"];
				$arItem["PRICE_ALL_FORMATED"] = SaleFormatCurrency($arItem['QUANTITY'] * $arItem['PRICE'], $currency);

				$arOfferID[$arItem["PRODUCT_ID"]] = $arItem["PRODUCT_ID"];

				$arResult["PRODUCTS"][$codeBasket][$arItem["PRODUCT_ID"]] = $arItem["PRODUCT_ID"];

				if(!empty($arItem["PROPS"]))
				{
					foreach ($arItem["PROPS"] as $arProp)
					{
						$arItem["PROPS_CODE"][$arProp["CODE"]] = $arProp;
					}
				}
			}
		}

        $arResult['allSum_delay'] = $all_cost;
        $arResult['allSum_delay_FORMATED'] = CurrencyFormat($all_cost, $arResult['CURRENCY']);
	}
	else
	{
		foreach ($arResult["ITEMS"][$codeBasket] as &$arItem)
		{
			if($arItem["CAN_BUY"] == "Y" && $arItem["DELAY"] == "N")
			{
				$arItem["NAME"] = preg_replace("/\((.*)\)/", "", $arItem["NAME"]);
				$arItem["SKU_PRODUCT"] = [];
				$all_quantity = $all_quantity + $arItem['QUANTITY'];
				$all_cost = $all_cost + ($arItem['PRICE'] * $arItem['QUANTITY']);
				$currency = $arItem["CURRENCY"];
				$arItem["PRICE_ALL_FORMATED"] = SaleFormatCurrency($arItem['QUANTITY'] * $arItem['PRICE'], $currency);

				$arOfferID[$arItem["PRODUCT_ID"]] = $arItem["PRODUCT_ID"];

				$arResult["PRODUCTS"][$codeBasket][$arItem["PRODUCT_ID"]] = $arItem["PRODUCT_ID"];

				if(!empty($arItem["PROPS"]))
				{
					foreach ($arItem["PROPS"] as $arProp)
					{
						$arItem["PROPS_CODE"][$arProp["CODE"]] = $arProp;
					}
				}
			}
		}
	}


	$arCatalog = CCatalogSKU::GetInfoByIBlock($arParams["IBLOCK_ID"]);
	$OFFER_IBLOCK_ID = $arCatalog["IBLOCK_ID"];
	$PROPERTY_ID = $arCatalog["SKU_PROPERTY_ID"];

	$arSelect = [
		"ID",
		"IBLOCK_ID",
		"PROPERTY_" . $PROPERTY_ID
	];

	//if($imageFromOffer)
	{
		$arSelect = array_merge($arSelect, [
			"PREVIEW_PICTURE",
			"DETAIL_PICTURE",
			"PROPERTY_" . $codeOfferMorePhoto,
			"PROPERTY_" . $codeElementBrand
		], $arFilterProps);
	}




	if($arParams["IBLOCK_ID"] > 0)
	{
		$rsElements = CIBlockElement::GetList([], ["=ID" => $arOfferID,'IBLOCK_ID' => $arParams["IBLOCK_ID"]], false, false, $arSelect);
		while ($arElements = $rsElements->Fetch())
		{
			$ID = $arElements["ID"];

			if(!empty($arHighload))
			{
				foreach ($arHighload as $high)
				{
					if(isset($arElements["PROPERTY_" . $high . "_VALUE"]) && !empty($arElements["PROPERTY_" . $high . "_VALUE"]) && !isset($arItem["PROPS_CODE"][$high]))
					{
						$arResult["PROPS_CODE_DOP"][$ID][$high]["VALUE"] = $arResult["LIST_PROPS"][$high][$arElements["PROPERTY_" . $high . "_VALUE"]]["UF_NAME"];
						$arResult["PROPS_CODE_DOP"][$ID][$high]["CODE"] = $high;
					}
				}
			}

			$color = $arElements["PROPERTY_" . $colorCode . "_VALUE"];

			$photoID = $arElements["PREVIEW_PICTURE"] ? $arElements["PREVIEW_PICTURE"] : $arElements["DETAIL_PICTURE"];
			$arResult["MORE_PHOTO"][$ID] = $photoID;
			$brandElementID = $arElements["PROPERTY_" . $codeElementBrand . "_VALUE"];
			if($brandElementID)
			{
				$arBrandElements[$brandElementID] = $brandElementID;
				$arBrandOffer[$brandElementID][$ID] = $ID;
			}
			$arNoOffer[$ID] = $ID;
		}
	}

	if($OFFER_IBLOCK_ID > 0)
	{
		$rsElements = CIBlockElement::GetList([], ["=ID" => $arOfferID,'IBLOCK_ID' => $OFFER_IBLOCK_ID], false, false, $arSelect);

		while ($arElements = $rsElements->Fetch())
		{
			$ID = $arElements["ID"];

			if(!empty($arHighload))
			{
				foreach ($arHighload as $high)
				{
					if(isset($arElements["PROPERTY_" . $high . "_VALUE"]) && !empty($arElements["PROPERTY_" . $high . "_VALUE"]) && !isset($arItem["PROPS_CODE"][$high]))
					{
						$arResult["PROPS_CODE_DOP"][$ID][$high]["VALUE"] = $arResult["LIST_PROPS"][$high][$arElements["PROPERTY_" . $high . "_VALUE"]]["UF_NAME"];
						$arResult["PROPS_CODE_DOP"][$ID][$high]["CODE"] = $high;
					}
				}
			}

			$color = $arElements["PROPERTY_" . $colorCode . "_VALUE"];

			$productID = $arElements["PROPERTY_" . $PROPERTY_ID . "_VALUE"];
			$arFromOfferToProduct[$ID] = $productID;
			$arFromProductToOffer[$productID][$ID] = $ID;

			$arProductID[$productID] = $productID;

			$photoID = $arElements["PREVIEW_PICTURE"] ? $arElements["PREVIEW_PICTURE"] : $arElements["DETAIL_PICTURE"];
			if($imageFromOffer && $photoID && !isset($arResult["MORE_PHOTO"][$ID]) && $color)
			{
				$arResult["MORE_PHOTO"][$ID] = $photoID;
			}
			elseif($imageFromOffer && !$photoID && !isset($arResult["MORE_PHOTO"][$ID]) && $color)
			{
				$photoID = $arElements["PROPERTY_" . $codeOfferMorePhoto . "_VALUE"];
				if($photoID)
					$arResult["MORE_PHOTO"][$ID] = $photoID;
			}
		}
	}

	if(!empty($arProductID))
	{
		$rsElements = CIBlockElement::GetList([], [
			"IBLOCK_ID" => $OFFER_IBLOCK_ID,
			"PROPERTY_" . $PROPERTY_ID => $arProductID,
			"ACTIVE" => "Y",
			"CATALOG_AVAILABLE" => "Y"
		], false, false, array_merge([
			"ID",
			"IBLOCK_ID",
			"PROPERTY_" . $PROPERTY_ID
		], $arFilterProps));
		while ($arElements = $rsElements->Fetch())
		{
			$arOfferAll[] = $arElements["ID"];

			foreach ($arHighload as $code)
			{
				$value = $arElements["PROPERTY_" . $code . "_VALUE"];
				$productID = $arElements["PROPERTY_" . $PROPERTY_ID . "_VALUE"];
				if($value)
					$arResult["OFFERS_ID"][$productID][$code][$value][$arElements["ID"]] = $arElements["ID"];
			}
		}
	}

	/*??????? ????? ??????? ????????? ??? ??????????? ????????*/
	if(!empty($arProductID))
	{
		$rsElements = CIBlockElement::GetList([], [
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"=ID" => $arProductID
		], false, false, [
			"ID",
			"IBLOCK_ID",
			"PREVIEW_PICTURE",
			"DETAIL_PICTURE",
			"PROPERTY_" . $codeProductMorePhoto,
			"PROPERTY_" . $codeElementBrand
		]);

		while ($arElements = $rsElements->Fetch())
		{
			$offID = $arFromProductToOffer[$arElements["ID"]];
			$brandElementID = $arElements["PROPERTY_" . $codeElementBrand . "_VALUE"];
			if(!empty($offID))
			{
				foreach ($offID as $ID)
				{
					if($imageFromOffer && !isset($arResult["MORE_PHOTO"][$ID]))
						$arResult["MORE_PHOTO"][$ID] = $arElements["PREVIEW_PICTURE"] ? $arElements["PREVIEW_PICTURE"] : $arElements["DETAIL_PICTURE"];

					if($imageFromOffer && !isset($arResult["DEFAULT_MORE_PHOTO"][$ID]))
						$arResult["DEFAULT_MORE_PHOTO"][$ID] = $arElements["PREVIEW_PICTURE"] ? $arElements["PREVIEW_PICTURE"] : $arElements["DETAIL_PICTURE"];

					if(!$imageFromOffer)
					{
						$img = $arElements["PREVIEW_PICTURE"] ? $arElements["PREVIEW_PICTURE"] : $arElements["DETAIL_PICTURE"];
						if($img)
						{
							$arResult["MORE_PHOTO"][$ID][$img] = CFile::GetFileArray($img);
							$arResult["DEFAULT_MORE_PHOTO"][$ID] = $img;
						}

						$morePhoto = $arElements["PROPERTY_" . $codeProductMorePhoto . "_VALUE"];
						if($morePhoto)
							$arResult["MORE_PHOTO"][$ID][$morePhoto] = CFile::GetFileArray($morePhoto);
					}

					$arBrandOffer[$brandElementID][$ID] = $ID;
				}
			}

			if($brandElementID)
			{
				$arBrandElements[$brandElementID] = $brandElementID;
			}
		}
	}
	/*????? ???????*/
	if(isset($arBrandElements))
	{
		$rsBrands = CIBlockElement::GetList([], ["=ID" => $arBrandElements], false, false, [
			"ID",
			"IBLOCK_ID",
			"NAME",
			"DETAIL_PAGE_URL"
		]);

		while ($arBrand = $rsBrands->GetNext())
		{
			if(isset($arBrandOffer[$arBrand["ID"]]))
			{
				foreach ($arBrandOffer[$arBrand["ID"]] as $offerID)
				{
					$arResult["BRANDS"][$offerID] = $arBrand;
				}
			}

		}
	}
	if($imageFromOffer && !empty($arResult["MORE_PHOTO"]))
	{
		foreach ($arResult["ITEMS"][$codeBasket] as &$arItem)
		{
			$ID = $arItem["PRODUCT_ID"];

			if(isset($arResult["PROPS_CODE_DOP"][$ID]))
			{
				if(isset($arItem["PROPS_CODE"]) && !empty($arItem["PROPS_CODE"]))
					$arItem["PROPS_CODE"] = array_merge($arItem["PROPS_CODE"], $arResult["PROPS_CODE_DOP"][$ID]);
				else $arItem["PROPS_CODE"] = $arResult["PROPS_CODE_DOP"][$ID];
			}
			$photoID = $arResult["MORE_PHOTO"][$ID];
			if($photoID)
				$arItem["PICTURE"] = CFile::ResizeImageGet($photoID, [
					'width' => $imgWidth,
					'height' => $imgHeight
				], BX_RESIZE_IMAGE_PROPORTIONAL, true);

			$arItem["BRAND"] = $arResult["BRANDS"][$ID];
			$photoID = $arResult["DEFAULT_MORE_PHOTO"][$ID];
			if(!$arItem["PICTURE"] && $photoID)
				$arItem["PICTURE"] = CFile::ResizeImageGet($photoID, [
					'width' => $imgWidth,
					'height' => $imgHeight
				], BX_RESIZE_IMAGE_PROPORTIONAL, true);
		}
	}

	if(!$imageFromOffer && !empty($arResult["MORE_PHOTO"]))
	{
		foreach ($arResult["MORE_PHOTO"] as $ID => $arOfferPhoto)
		{
			foreach ($arOfferPhoto as $arPhoto)
			{
				$descr = mb_strtolower($arPhoto["DESCRIPTION"]);
				$arDescr = explode("_", $descr);
				$color = $arDescr[0];
				if($descr && isset($arDescr[1]))
				{
					$index = $arDescr[1];
					$arResult["MORE_PHOTO_LOGIC"][$ID][$color][$index] = $arPhoto;
				}
				elseif($descr && !isset($arDescr[1]))
				{
					$arResult["MORE_PHOTO_LOGIC"][$ID][$color][] = $arPhoto;
				}
				else $arResult["MORE_PHOTO_LOGIC"][$ID][0][] = $arPhoto;

			}
		}

		foreach ($arResult["MORE_PHOTO_LOGIC"] as $offerID => $arColorPhoto)
		{
			foreach ($arColorPhoto as $color => $arOfferPhoto)
			{
				ksort($arResult["MORE_PHOTO_LOGIC"][$offerID][$color]);
				$arResult["MORE_PHOTO_LOGIC"][$offerID][$color] = array_values($arResult["MORE_PHOTO_LOGIC"][$offerID][$color]);
			}
		}
		foreach ($arResult["ITEMS"][$codeBasket] as $c => &$arBasket)
		{
			$ID = $arBasket["PRODUCT_ID"];
			$arBasket["BRAND"] = $arResult["BRANDS"][$ID];
			if($arBasket["CAN_BUY"] == "Y")
			{
				if(isset($arNoOffer[$ID]))
				{
					$photoID = $arResult["MORE_PHOTO"][$ID];
					if($photoID)
						$arBasket["PICTURE"] = CFile::ResizeImageGet($photoID, [
							'width' => $imgWidth,
							'height' => $imgHeight
						], BX_RESIZE_IMAGE_PROPORTIONAL, true);

					continue 1;
				}

				if(isset($arBasket["PROPS_CODE"][$colorCode]) && $arBasket["PROPS_CODE"][$colorCode]["VALUE"])
				{
					$color = mb_strtolower($arBasket["PROPS_CODE"][$colorCode]["VALUE"]);

					if(isset($arResult["MORE_PHOTO_LOGIC"][$ID][$color]))
					{
						$arPhoto = $arResult["MORE_PHOTO_LOGIC"][$ID][$color][0];//printr($arPhoto);
						$arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, [
							'width' => $imgWidth,
							'height' => $imgHeight
						], BX_RESIZE_IMAGE_PROPORTIONAL, true);
					}
					elseif(isset($arResult["MORE_PHOTO_LOGIC"][$ID][0]))
					{
						$arPhoto = $arResult["MORE_PHOTO_LOGIC"][$ID][0][0];//printr($arPhoto);
						$arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, [
							'width' => $imgWidth,
							'height' => $imgHeight
						], BX_RESIZE_IMAGE_PROPORTIONAL, true);
					}
					else
					{
						$arPhoto = $arResult["DEFAULT_MORE_PHOTO"][$ID];
						$arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, [
							'width' => $imgWidth,
							'height' => $imgHeight
						], BX_RESIZE_IMAGE_PROPORTIONAL, true);
					}
				}
				else
				{
					$arPhoto = $arResult["DEFAULT_MORE_PHOTO"][$ID];
					$arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, [
						'width' => $imgWidth,
						'height' => $imgHeight
					], BX_RESIZE_IMAGE_PROPORTIONAL, true);
				}

			}
		}

	}
}

$prevOffer = $currentOffer = [];

if(!empty($arResult["ITEMS"][$codeBasket]))
{
	foreach ($arResult["ITEMS"][$codeBasket] as $c => &$arBasket)
	{
		$productID = $arFromOfferToProduct[$arBasket["PRODUCT_ID"]];
		$arBasket["PARENT_PRODUCT_ID"] = $productID;
		$prevOffer = $currentOffer = [];
		if(isset($arResult["OFFERS_ID"][$productID]))
			foreach ($arResult["OFFERS_ID"][$productID] as $prop => $arProp)
			{

				$arBasket["SKU_PRODUCT"][$prop] = $arResult["LIST_PROPS_NAME"][$prop];
				foreach ($arProp as $xmlID => $arOffers)
				{
					$color = mb_strtolower($arResult["LIST_PROPS"][$prop][$xmlID]["UF_NAME"]);
					if($colorDelete && $prop == $colorCode && !$arResult["MORE_PHOTO_LOGIC"][$arBasket["PRODUCT_ID"]][$color])
					{
						continue 1;
					}

					$arBasket["SKU_PRODUCT"][$prop]["VALUES"][$xmlID] = $arResult["LIST_PROPS"][$prop][$xmlID];
					$arBasket["SKU_PRODUCT"][$prop]["VALUES"][$xmlID]["OFFERS_ID"] = implode(",", $arOffers);
					foreach ($arBasket["PROPS_CODE"] as $arBasketProp)
					{

						$ufName = $arBasket["SKU_PRODUCT"][$prop]["VALUES"][$xmlID]["UF_NAME"];
						if($arBasketProp["CODE"] == $prop && $arBasketProp["VALUE"] == $ufName)
						{
							$arBasket["SKU_PRODUCT"][$prop]["VALUES"][$xmlID]["ACTIVE"] = "Y";
							$arBasket["SKU_PRODUCT_ACTIVE"][$prop] = $currentOffer = $arOffers;
						}

					}

				}
				if(!empty($prevOffer))
				{
					if(isset($arBasket["SKU_PRODUCT_ACTIVE"][$prop]))
					{
						foreach ($arProp as $xmlID => $arOffers)
						{
							$arEmpty = array_intersect($arOffers, $prevOffer);
							if(empty($arEmpty))
							{
								$arBasket["SKU_PRODUCT"][$prop]["VALUES"][$xmlID]["DISABLE"] = "Y";
							}
						}
					}
				}
				if(empty($prevOffer)) $prevOffer = $currentOffer;
				else $prevOffer = array_intersect($prevOffer, $currentOffer);

			}
		foreach ($arResult["ITEMS"][$codeBasket] as &$arItem)
		{
			$photoID = $arItem["PREVIEW_PICTURE"] ? $arItem["PREVIEW_PICTURE"] : $arItem["DETAIL_PICTURE"];

			$db_props = CIBlockElement::GetProperty($arItem['IBLOCK_ID'], $arItem['PRODUCT_ID'], ["sort" => "asc"], ["CODE" => "MORE_PHOTO"]);
			if($ar_props = $db_props->Fetch())
			{
				$photoID = $ar_props['VALUE'];
			}
			if(!$arItem['PICTURE'] && $photoID)
			{
				$arItem['PICTURE'] = CFile::ResizeImageGet($photoID, [
					'width' => $imgWidth,
					'height' => $imgHeight
				], BX_RESIZE_IMAGE_PROPORTIONAL, true);
			}
		}
	}
}
?>