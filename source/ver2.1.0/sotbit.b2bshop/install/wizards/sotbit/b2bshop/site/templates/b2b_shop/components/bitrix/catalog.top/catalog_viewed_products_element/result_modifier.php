<?
if (! defined ( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true)
	die ();

	$arBrandID = array ();
	$arModelsLinks = array ();
	$IblockBrands = 0;
	$brandCode = $arParams["MANUFACTURER_ELEMENT_PROPS"];
	$cntItems = sizeof ( $arResult["ITEMS"] );
	$imageFromOffer = ($arParams["PICTURE_FROM_OFFER"] == "Y") ? true : false;
	$availableDelete = ($arParams["AVAILABLE_DELETE"] == "Y") ? true : false;
	$colorCode = ($arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams['COLOR_IN_PRODUCT_CODE']) ? $arParams['COLOR_IN_PRODUCT_CODE'] : $arParams["OFFER_COLOR_PROP"];
	$colorDelete = ($arParams["DELETE_OFFER_NOIMAGE"] == "Y") ? true : false;
	$ResizeMode = (! empty ( $arParams["IMAGE_RESIZE_MODE"] ) ? $arParams["IMAGE_RESIZE_MODE"] : BX_RESIZE_IMAGE_PROPORTIONAL);
	$k = 0;

	$Cook = array_unique(array_reverse($_COOKIE['ms_viewed_products']));
	$SortItems=array();
	$Fancy = array();
	$NumbKeys=array_flip(array_keys($Cook));
	$colorXmlIDs = array();
	for($i = 0; $i < $cntItems; ++ $i)
	{
		$IdItem = $arResult["ITEMS"][$i]['ID'];

		$arResult["ITEMS"][$i]['COUNTER']=$i;
		$arResult["ITEMS"][$i]['COLOR_CODE']=$colorCode;

		$arBrandIblock = $arResult["ITEMS"][$i]["PROPERTIES"][$arParams["MANUFACTURER_ELEMENT_PROPS"]]["LINK_IBLOCK_ID"];

		// if color in product
		if ($arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams['COLOR_IN_PRODUCT_CODE'])
		{
			if ($arResult["ITEMS"][$i]["PROPERTIES"][$colorCode]["VALUE"])
			{
				if (! isset ( $HLParams[$colorCode] ))
				{
					$PropArray = B2BSSotbitShop::GetValuesFromHL (
							$arResult["ITEMS"][$i]['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'],
							$arResult['CATALOG']['IBLOCK_ID'],
							$colorCode
							);
					$HLParams[key ( $PropArray )] = $PropArray[key ( $PropArray )];
				}
			}
		}

		if ($arResult["ITEMS"][$i]['OFFERS'])
		{
			for($j = 0; $j < sizeof ( $arResult["ITEMS"][$i]['OFFERS'] ); ++ $j)
			{
				if (! isset ( $HLParams[$colorCode] ))
				{
					$PropArray = B2BSSotbitShop::GetValuesFromHL (
							$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'],
							$arResult['CATALOG']['IBLOCK_ID'],
							$colorCode
							);
					$HLParams[key ( $PropArray )] = $PropArray[key ( $PropArray )];
				}

				$colorXmlID = $arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$colorCode]["VALUE"];

				$HLColor = $HLParams[$colorCode][$colorXmlID];
				if (! $colorXmlID)
					$colorXmlID = 0;


					if ($availableDelete && ! $arResult["ITEMS"][$i]['OFFERS'][$j]["CAN_BUY"])
						continue 1;
						$colorXmlIDs[$arResult["ITEMS"][$i]['ID']][] = $colorXmlID;
						// if isset color in filter
						if ($arParams['FILTER_CHECKED_FIRST_COLOR'])
						{
							if(in_array($colorXmlID,$arParams['FILTER_CHECKED_FIRST_COLOR']) && !$arResult["ITEMS"][$i]['FIRST_COLOR'])
							{
								$arResult["ITEMS"][$i]['FIRST_COLOR'] = $colorXmlID;
							}
						}
						elseif(!$arResult["ITEMS"][$i]['FIRST_COLOR'])
						{
							$arResult["ITEMS"][$i]['FIRST_COLOR'] = $colorXmlID;
						}

						// if images in product
						if (! $imageFromOffer)
							continue;
							// if isset color in offer
							if ($colorXmlID && $arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$colorCode]["USER_TYPE"] == "directory")
							{
								// delete offer if not color and need delete
								if (! ($arResult["ITEMS"][$i]['OFFERS'][$j]["PREVIEW_PICTURE"] || $arResult["ITEMS"][$i]['OFFERS'][$j]["DETAIL_PICTURE"] || $arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$arParams["MORE_PHOTO_OFFER_PROPS"]]["VALUE"]) && $colorDelete)
								{
									unset ( $arResult["ITEMS"][$i]['OFFERS'][$j] );
								}
							}
							// get photos from offers
							$arResult["MORE_PHOTO_JS"][$IdItem][$colorXmlID] = B2BSSotbitShop::GetImagesIfOffers (
									$arResult["ITEMS"][$i]['OFFERS'][$j]["PREVIEW_PICTURE"],
									$arResult["ITEMS"][$i]['OFFERS'][$j]["DETAIL_PICTURE"],
									$arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$arParams["MORE_PHOTO_OFFER_PROPS"]]["VALUE"],
									$arResult["ITEMS"][$i]['PROPERTIES']['ADD_PICTURES']['VALUE'],
									$arResult["ITEMS"][$i]["PREVIEW_PICTURE"],
									$arResult["ITEMS"][$i]["DETAIL_PICTURE"],
									$arParams["LIST_WIDTH_SMALL"],
									$arParams["LIST_HEIGHT_SMALL"],
									0,
									0,
									0,
									0,
									$ResizeMode,
									'N',
									$arResult["MORE_PHOTO_JS"][$IdItem][$colorXmlID],
									$arResult["ITEMS"][$i]['FIRST_COLOR'],
									$colorXmlID
									);
			}
			unset ( $j );
		}
		// if not offers
		else
		{
			// if images in product
			if ($imageFromOffer)
			{
				$arResult["MORE_PHOTO_JS"][$IdItem][0] = B2BSSotbitShop::GetImagesIfOffers (
						$arResult["ITEMS"][$i]["PREVIEW_PICTURE"],
						$arResult["ITEMS"][$i]["DETAIL_PICTURE"],
						$arResult["ITEMS"][$i]['PROPERTIES']['ADD_PICTURES']['VALUE'],
						$arResult["ITEMS"][$i]["PROPERTIES"][$arParams["MORE_PHOTO_PRODUCT_PROPS"]]["VALUE"],
						$arResult["ITEMS"][$i]["PREVIEW_PICTURE"],
						$arResult["ITEMS"][$i]["DETAIL_PICTURE"],
						$arParams["LIST_WIDTH_SMALL"],
						$arParams["LIST_HEIGHT_SMALL"],
						0,
						0,
						0,
						0,
						$ResizeMode,
						'N',
						$arResult["MORE_PHOTO_JS"][$IdItem][0],
						$arResult["ITEMS"][$i]['FIRST_COLOR'],
						0);
			}
		}

		// color from product
		if (! $imageFromOffer)
		{
			if (! isset ( $HLParams[$colorCode] ))
			{
				$PropArray = B2BSSotbitShop::GetValuesFromHL (
						$arResult["ITEMS"][$i]['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'],
						$arResult['CATALOG']['IBLOCK_ID'],
						$colorCode
						);
				$HLParams[key ( $PropArray )] = $PropArray[key ( $PropArray )];
			}

			$DetailPhoto = ($arResult["ITEMS"][$i]["PREVIEW_PICTURE"])?$arResult["ITEMS"][$i]["PREVIEW_PICTURE"]:$arResult["ITEMS"][$i]["DETAIL_PICTURE"];
			$ImageFromProduct = B2BSSotbitShop::ImagesFromProduct($DetailPhoto,$arResult["ITEMS"][$i]['PROPERTIES']["MORE_PHOTO"]['VALUE'],$HLParams[$colorCode],$arResult["ITEMS"][$i]["FIRST_COLOR"],$arParams['COLOR_IN_PRODUCT'],$arParams["COLOR_IN_SECTION_LINK"],$arParams['AJAX_PRODUCT_LOAD'],$arParams["LIST_WIDTH_SMALL"], $arParams["LIST_HEIGHT_SMALL"], $arParams["LIST_WIDTH_MEDIUM"], $arParams["LIST_HEIGHT_MEDIUM"],0,0, $ResizeMode,$arParams['OFFER_TREE_PROPS'],$colorCode);
			if($ImageFromProduct['FIRST_COLOR'])
			{
				$arResult["ITEMS"][$i]['FIRST_COLOR']=$ImageFromProduct['FIRST_COLOR'];
			}
			if($ImageFromProduct['PHOTOS'])
			{
				$arResult["MORE_PHOTO_JS"][$IdItem]=$ImageFromProduct['PHOTOS'];
			}
			
			foreach ($arResult["MORE_PHOTO_JS"][$IdItem] as $color => $images)
			{
				if($colorXmlIDs[$IdItem] && !in_array($color,$colorXmlIDs[$IdItem]))
				{
					unset($arResult["MORE_PHOTO_JS"][$IdItem][$color]);
				}
			}
			
			if(count($arResult["MORE_PHOTO_JS"][$IdItem]) > 0 && !in_array($arResult["ITEMS"][$i]['FIRST_COLOR'],array_keys($arResult["MORE_PHOTO_JS"][$IdItem])))
			{
				$arResult["ITEMS"][$i]['FIRST_COLOR'] = reset(array_keys($arResult["MORE_PHOTO_JS"][$IdItem]));
			}
			
			
			if($ImageFromProduct['OFFER_TREE_PROPS'])
			{
				$arResult["ITEMS"][$i]['OFFER_TREE_PROPS'][$colorCode]=$ImageFromProduct['OFFER_TREE_PROPS'][$colorCode];
			}
		}

		// set if not first color
		if (! isset ( $arResult["ITEMS"][$i]["FIRST_COLOR"] ) && $arResult["MORE_PHOTO_JS"][$IdItem])
		{
			$arResult["ITEMS"][$i]["FIRST_COLOR"] = reset ( array_keys ( $arResult["MORE_PHOTO_JS"][$IdItem] ) );
		}



		$CookKey = array_search($arResult["ITEMS"][$i]['ID'],$Cook);
		$SortItems[$NumbKeys[$CookKey]]=$arResult["ITEMS"][$i];

		$arResult["FANCY"][$NumbKeys[$CookKey]]["ID"] = $IdItem;
		$arResult["FANCY"][$NumbKeys[$CookKey]]["DETAIL_PAGE_URL"] = $arResult["ITEMS"][$i]["DETAIL_PAGE_URL"];
		//$Fancy[$NumbKeys[$CookKey]]=$arResult["ITEMS"][$i];
		unset($CookKey);
	}


	unset($NumbKeys);
	unset ( $cntItems );
	unset ( $IdItem );
	unset ( $i );

	ksort($SortItems);
	ksort($arResult["FANCY"]);

	$arResult["ITEMS"]=$SortItems;
	unset($SortItems);


	$arResult["RAND"] = $this->randString ();

	$this->__component->arResultCacheKeys = array_merge ( $this->__component->arResultCacheKeys, array (
			'FANCY',
			'RAND'
	) );
	?>