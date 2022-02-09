<?
if( !defined( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true )
	die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
if( $arResult['ITEMS'] )
{
	$mxResult = CCatalogSKU::GetInfoByProductIBlock(
			$arParams["IBLOCK_ID"]
			);
	if (is_array($mxResult))
	{
		$offersIblock = $mxResult['IBLOCK_ID'];
		if($arParams['OFFER_TREE_PROPS'][$offersIblock])
		{
			$arParams['OFFER_TREE_PROPS'] = $arParams['OFFER_TREE_PROPS'][$offersIblock];
		}
	}
	if( Bitrix\Main\Loader::includeModule( "kit.price" ) )
	{
		$arResult = KitPrice::ChangeMinPrice( $arResult );
	}
	if (Bitrix\Main\Loader::includeModule( "kit.regions" ) && function_exists('\Kit\Regions\Sale\Price::change'))
	{
		$arResult = \Kit\Regions\Sale\Price::change( $arResult );
	}

	$arBrandID = array();
	$arModelsLinks = array();
	$IblockBrands = 0;
	$brandCode = $arParams["MANUFACTURER_ELEMENT_PROPS"];
	$cntItems = sizeof( $arResult["ITEMS"] );
	$imageFromOffer = ($arParams["PICTURE_FROM_OFFER"] == "Y") ? true : false;
	$availableDelete = ($arParams["AVAILABLE_DELETE"] == "Y") ? true : false;
	$colorCode = ($arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams['COLOR_IN_PRODUCT_CODE']) ? $arParams['COLOR_IN_PRODUCT_CODE'] : $arParams["OFFER_COLOR_PROP"];
	$colorDelete = ($arParams["DELETE_OFFER_NOIMAGE"] == "Y") ? true : false;
	$ResizeMode = (!empty( $arParams["IMAGE_RESIZE_MODE"] ) ? $arParams["IMAGE_RESIZE_MODE"] : BX_RESIZE_IMAGE_PROPORTIONAL);
	$k = 0;
	$i = 0;

	$colorXmlIDs = array();

	foreach($arResult['ITEMS'] as $idItem => $Item)
	{
		$arResult["ITEMS"][$idItem]['COUNTER']=$i;//for quick view
		$arResult["ITEMS"][$idItem]['COLOR_CODE']=$colorCode;
		$arBrandIblock = $Item["PROPERTIES"][$arParams["MANUFACTURER_ELEMENT_PROPS"]]["LINK_IBLOCK_ID"];

		// need for color link 2
		if( $arParams['COLOR_IN_PRODUCT'] && $arParams["COLOR_IN_SECTION_LINK"] == 2 )
		{
			$arModelsLinks[$idItem] = $Item["PROPERTIES"][$arParams["COLOR_IN_PRODUCT_LINK"]]["VALUE"];
		}
		// Get brands info
		if( $Item["PROPERTIES"][$brandCode]["VALUE"] )
		{
			$IblockBrands = $Item["PROPERTIES"][$brandCode]["LINK_IBLOCK_ID"];
			$arBrandID[] = $Item["PROPERTIES"][$arParams["MANUFACTURER_ELEMENT_PROPS"]]["VALUE"];
		}

		// if color in product
		if( $arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams['COLOR_IN_PRODUCT_CODE'] )
		{
			if( $Item["PROPERTIES"][$colorCode]["VALUE"] )
			{
				if( !isset( $HLParams[$colorCode] ) )
				{
					$PropArray = B2BSKitShop::GetValuesFromHL( $Item['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'],
							$arResult['_ORIGINAL_PARAMS']['IBLOCK_ID'], $colorCode );
					$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
				}
				$arResult["ITEMS"][$i]["OFFER_TREE_PROPS"][$colorCode][$HLParams[$colorCode][$arResult["ITEMS"][$i]["PROPERTIES"][$colorCode]["VALUE"]]['UF_XML_ID']] = $HLParams[$colorCode][$arResult["ITEMS"][$i]["PROPERTIES"][$colorCode]["VALUE"]];
			}
		}

		if( $Item['OFFERS'] )
		{
			for($j = 0; $j < sizeof( $Item['OFFERS'] ); ++$j)
			{
				if( !isset( $HLParams[$colorCode] ) )
				{
					$PropArray = B2BSKitShop::GetValuesFromHL(
							$Item['OFFERS'][$j]['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'],
							$arResult['_ORIGINAL_PARAMS']['IBLOCK_ID'], $colorCode );
					$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
				}
				$colorXmlID = $Item['OFFERS'][$j]["PROPERTIES"][$colorCode]["VALUE"];

				$HLColor = $HLParams[$colorCode][$colorXmlID];
				if( !$colorXmlID )
					$colorXmlID = 0;

					if( !$Item['FIRST_COLOR'] )
				{
					$arResult["ITEMS"][$idItem]['FIRST_COLOR'] = $colorXmlID;
				}
				if( $availableDelete && !$Item['OFFERS'][$j]["CAN_BUY"] )
					continue 1;
					$colorXmlIDs[$arResult["ITEMS"][$i]['ID']][] = $colorXmlID;
				// set min price from offers
					$arResult["ITEMS"][$idItem]['MIN_PRICE'] = B2BSKitShop::GetMinPrice( $Item['MIN_PRICE'],
							$Item['OFFERS'][$j]["MIN_PRICE"] );
				// available properties
				if( $arParams['OFFER_TREE_PROPS'] )
				{
					for($k = 0; $k < sizeof( $arParams['OFFER_TREE_PROPS'] ); ++$k)
					{
						if($Item['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE'] && $Item['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]["USER_TYPE"] == 'directory' )
						{
							if( !isset( $HLParams[$arParams['OFFER_TREE_PROPS'][$k]] ) )
							{
								$PropArray = B2BSKitShop::GetValuesFromHL(
										$Item['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['USER_TYPE_SETTINGS']['TABLE_NAME'],
										$arResult['_ORIGINAL_PARAMS']['IBLOCK_ID'], $arParams['OFFER_TREE_PROPS'][$k] );
								$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
								unset( $PropArray );
							}

							$arResult["ITEMS"][$idItem]["OFFER_TREE_PROPS"][$arParams['OFFER_TREE_PROPS'][$k]][$Item['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']] = $HLParams[$arParams['OFFER_TREE_PROPS'][$k]][$Item['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']];
							$arResult["ITEMS"][$idItem]["OFFER_TREE_PROPS_VALUE"][$arParams['OFFER_TREE_PROPS'][$k]][$Item['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']] = $HLParams[$arParams['OFFER_TREE_PROPS'][$k]][$Item['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']]['UF_NAME'];
							// name of property
							$arResult["PROP_NAME"][$arParams['OFFER_TREE_PROPS'][$k]] = $Item['OFFERS'][$j]["PROPERTIES"][$arParams['OFFER_TREE_PROPS'][$k]]['NAME'];
						}
					}
					unset( $k );
				}

				// if images in product
				if( !$imageFromOffer )
					continue;
				// if isset color in offer
				if( $colorXmlID && $Item['OFFERS'][$j]['PROPERTIES'][$colorCode]["USER_TYPE"] == "directory" )
				{
					// delete offer if not color and need delete
					if( !($Item['OFFERS'][$j]["PREVIEW_PICTURE"] || $Item['OFFERS'][$j]["DETAIL_PICTURE"] || $Item['OFFERS'][$j]["PROPERTIES"][$arParams["MORE_PHOTO_OFFER_PROPS"]]["VALUE"]) && $colorDelete )
					{
						unset( $arResult["ITEMS"][$idItem]['OFFERS'][$j] );
					}
				}
				// get photos from offers
				$arResult["MORE_PHOTO_JS"][$idItem][$colorXmlID] = B2BSKitShop::GetImagesIfOffers(
						$Item['OFFERS'][$j]["PREVIEW_PICTURE"], $Item['OFFERS'][$j]["DETAIL_PICTURE"],
						$Item['OFFERS'][$j]["PROPERTIES"][$arParams["MORE_PHOTO_OFFER_PROPS"]]["VALUE"],
						$Item['PROPERTIES']['ADD_PICTURES']['VALUE'], $Item["PREVIEW_PICTURE"],
						$Item["DETAIL_PICTURE"], $arParams["LIST_WIDTH_SMALL"], $arParams["LIST_HEIGHT_SMALL"],
						$arParams["LIST_WIDTH_MEDIUM"], $arParams["LIST_HEIGHT_MEDIUM"], 0, 0, $ResizeMode, 'N',
						$arResult["MORE_PHOTO_JS"][$idItem][$colorXmlID], $Item['FIRST_COLOR'], $colorXmlID );
			}
			unset( $j );
		}
		// if not offers
		else
		{
			// if images in product
			if( $imageFromOffer )
			{
				$arResult["MORE_PHOTO_JS"][$idItem][0] = B2BSKitShop::GetImagesIfOffers( $Item["PREVIEW_PICTURE"],
						$Item["DETAIL_PICTURE"], $Item['PROPERTIES']['ADD_PICTURES']['VALUE'],
						$Item["PROPERTIES"][$arParams["MORE_PHOTO_PRODUCT_PROPS"]]["VALUE"],
						$Item["PREVIEW_PICTURE"], $Item["DETAIL_PICTURE"], $arParams["LIST_WIDTH_SMALL"],
						$arParams["LIST_HEIGHT_SMALL"], $arParams["LIST_WIDTH_MEDIUM"], $arParams["LIST_HEIGHT_MEDIUM"], 0, 0, $ResizeMode,
					'N', $arResult["MORE_PHOTO_JS"][$idItem][0], $Item['FIRST_COLOR'], 0 );
			}
		}

		// color from product
		if( !$imageFromOffer )
		{
			if( !isset( $HLParams[$colorCode] ) )
			{
				$PropArray = B2BSKitShop::GetValuesFromHL( $Item['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'],
						$arResult['_ORIGINAL_PARAMS']['IBLOCK_ID'], $colorCode );
				$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
			}

			$DetailPhoto = ($Item["PREVIEW_PICTURE"]) ? $Item["PREVIEW_PICTURE"] : $Item["DETAIL_PICTURE"];
			$ImageFromProduct = B2BSKitShop::ImagesFromProduct( $DetailPhoto, $Item['PROPERTIES']["MORE_PHOTO"]['VALUE'],
					$HLParams[$colorCode], $Item["FIRST_COLOR"], $arParams['COLOR_IN_PRODUCT'], $arParams["COLOR_IN_SECTION_LINK"],
				'N', $arParams["LIST_WIDTH_SMALL"], $arParams["LIST_HEIGHT_SMALL"], $arParams["LIST_WIDTH_MEDIUM"],
					$arParams["LIST_HEIGHT_MEDIUM"], 0, 0, $ResizeMode, $arParams['OFFER_TREE_PROPS'], $colorCode );
			if( $ImageFromProduct['FIRST_COLOR'] )
			{
				$arResult["ITEMS"][$idItem]['FIRST_COLOR'] = $ImageFromProduct['FIRST_COLOR'];
			}
			if( $ImageFromProduct['PHOTOS'] )
			{
				$arResult["MORE_PHOTO_JS"][$idItem] = $ImageFromProduct['PHOTOS'];
			}

			foreach ($arResult["MORE_PHOTO_JS"][$idItem] as $color => $images)
			{
				if($colorXmlIDs[$idItem] && !in_array($color,$colorXmlIDs[$IdItem]))
				{
					unset($arResult["MORE_PHOTO_JS"][$idItem][$color]);
				}
			}

			if(count($arResult["MORE_PHOTO_JS"][$idItem]) > 0 && !in_array($arResult["ITEMS"][$idItem]['FIRST_COLOR'],array_keys($arResult["MORE_PHOTO_JS"][$idItem])))
			{
				$arResult["ITEMS"][$idItem]['FIRST_COLOR'] = reset(array_keys($arResult["MORE_PHOTO_JS"][$idItem]));
			}

			if( $ImageFromProduct['OFFER_TREE_PROPS'] && $arResult["ITEMS"][$idItem]['CAN_BUY'] == 'Y')
			{
				$arResult["ITEMS"][$idItem]['OFFER_TREE_PROPS'][$colorCode] = $ImageFromProduct['OFFER_TREE_PROPS'][$colorCode];
			}
		}

		// if one color do some colors
		if( sizeof( $arResult["MORE_PHOTO_JS"][$idItem] ) == 1 && $arParams['COLOR_IN_PRODUCT'] != 'Y' )
		{
			$arResult["MORE_PHOTO_JS"][$idItem] = B2BSKitShop::reOneColor( $arResult["MORE_PHOTO_JS"][$idItem], $arParams["LIST_WIDTH_SMALL"],
					$arParams["LIST_HEIGHT_SMALL"], $arParams["LIST_WIDTH_MEDIUM"], $ResizeMode );
		}

		// fancy for quick view
		$arResult["FANCY"][$idItem]["ID"] = $idItem;
		$arResult["FANCY"][$idItem]["DETAIL_PAGE_URL"] = $Item["DETAIL_PAGE_URL"];

		// set if not first color
		if( !isset( $Item["FIRST_COLOR"] ) && $arResult["MORE_PHOTO_JS"][$idItem] )
		{
			$arResult["ITEMS"][$idItem]["FIRST_COLOR"] = reset( array_keys( $arResult["MORE_PHOTO_JS"][$idItem] ) );
		}

		// first color up of small images
		if( $arResult["MORE_PHOTO_JS"][$idItem] )
		{
			if( $Item["FIRST_COLOR"] && $Item["FIRST_COLOR"] != reset( array_keys( $arResult["MORE_PHOTO_JS"][$idItem] ) ) )
			{
				$Tmp[$Item["FIRST_COLOR"]] = $arResult["MORE_PHOTO_JS"][$idItem][$Item["FIRST_COLOR"]];
				$Tmp = array_merge( $Tmp, $arResult["MORE_PHOTO_JS"][$idItem] );
				$arResult["MORE_PHOTO_JS"][$idItem] = $Tmp;
				unset( $Tmp );
			}
		}
		$SortPropertyTree = B2BSKitShop::SortPropertyTree( $arResult["ITEMS"][$idItem]["OFFER_TREE_PROPS_VALUE"], $colorCode, '', array(), array());
		$arResult["ITEMS"][$idItem]["OFFER_TREE_PROPS_VALUE"] = $SortPropertyTree['PROPERTIES'];
		unset( $SortPropertyTree );
		++$i;
	}
	unset( $cntItems );
	unset( $idItem );
	unset( $Item);
	unset( $n );
	unset( $i );

	// Get brands names

	$arResult["BRANDS"] = B2BSKitShop::GetBrandsNames( $arBrandID, $arBrandIblock );

	unset( $arBrandID );
	unset( $arBrandIblock );

	$arResult["RAND"] = $this->randString();

	// color link 2
	if( $arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams["COLOR_IN_SECTION_LINK"] == 2 && $arParams["COLOR_IN_PRODUCT_LINK"] )
	{
		// del empty values
		$arIds = array();
		$arModelsLinks = array_diff( $arModelsLinks, array(
				''
		) );
		if( sizeof( $arModelsLinks ) > 0 )
		{
			$ColorLink2 = B2BSKitShop::ColorLink2( $arModelsLinks, $arParams["COLOR_IN_PRODUCT_LINK"], $arParams['COLOR_IN_PRODUCT_CODE'], $colorCode,
					$arParams["LIST_WIDTH_SMALL"], $arParams["LIST_HEIGHT_MEDIUM"], $arParams["LIST_WIDTH_MEDIUM"], $arParams["LIST_HEIGHT_MEDIUM"],
					$ResizeMode, $arParams['IBLOCK_ID'] );

			if($ColorLink2['PHOTOS'])
			{
				foreach($ColorLink2['PHOTOS'] as $idProduct => $colors)
				{
					foreach($arResult["MORE_PHOTO_JS"] as $Product=>$Photos)
					{
						if($Product == $idProduct)
						{
							$arResult["MORE_PHOTO_JS"][$Product] = array_merge($arResult["MORE_PHOTO_JS"][$Product], $ColorLink2['PHOTOS'][$idProduct]);
						}
					}
				}
			}

			foreach ( $arResult["ITEMS"] as $key => $arItem )
			{
				foreach ( $ColorLink2['COLORS'][$arItem['ID']] as $i => $ColorCodeItem )
				{
					$arResult["ITEMS"][$key]["OFFER_TREE_PROPS"][$colorCode][$ColorCodeItem] = $HLParams[$colorCode][$ColorCodeItem];
				}
			}
		}
	}
}

if(!is_array($this->__component->arResultCacheKeys))
{
	$this->__component->arResultCacheKeys = array();
}

$this->__component->arResultCacheKeys = array_merge( $this->__component->arResultCacheKeys, array(
		'FANCY',
		'RAND'
) );
?>