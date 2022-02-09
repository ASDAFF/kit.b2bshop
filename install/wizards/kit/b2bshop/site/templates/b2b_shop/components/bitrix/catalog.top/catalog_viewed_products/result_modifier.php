<?
if( !defined( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true )
	die();

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

$Cook = array_unique( array_reverse( $_COOKIE['ms_viewed_products'] ) );
$SortItems = array();
$NumbKeys = array_flip( array_keys( $Cook ) );
$colorXmlIDs = array();
for($i = 0; $i < $cntItems; ++$i)
{
	$IdItem = $arResult["ITEMS"][$i]['ID'];

	$arResult["ITEMS"][$i]['COUNTER'] = $i;
	$arResult["ITEMS"][$i]['COLOR_CODE'] = $colorCode;

	$arBrandIblock = $arResult["ITEMS"][$i]["PROPERTIES"][$arParams["MANUFACTURER_ELEMENT_PROPS"]]["LINK_IBLOCK_ID"];

	// need for color link 2
	if( $arParams['COLOR_IN_PRODUCT'] && $arParams["COLOR_IN_SECTION_LINK"] == 2 )
	{
		$arModelsLinks[$IdItem] = $arResult["ITEMS"][$i]["PROPERTIES"][$arParams["COLOR_IN_PRODUCT_LINK"]]["VALUE"];
	}
	// Get brands info
	if( $arResult["ITEMS"][$i]["PROPERTIES"][$brandCode]["VALUE"] )
	{
		$IblockBrands = $arResult["ITEMS"][$i]["PROPERTIES"][$brandCode]["LINK_IBLOCK_ID"];
		$arBrandID[] = $arResult["ITEMS"][$i]["PROPERTIES"][$arParams["MANUFACTURER_ELEMENT_PROPS"]]["VALUE"];
	}

	// if color in product
	if( $arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams['COLOR_IN_PRODUCT_CODE'] )
	{
		if( $arResult["ITEMS"][$i]["PROPERTIES"][$colorCode]["VALUE"] )
		{
			if( !isset( $HLParams[$colorCode] ) )
			{
				$PropArray = B2BSKitShop::GetValuesFromHL( $arResult["ITEMS"][$i]['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'],
						$arResult['CATALOG']['IBLOCK_ID'], $colorCode );
				$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
			}
			$arResult["ITEMS"][$i]["OFFER_TREE_PROPS"][$colorCode][$HLParams[$colorCode][$arResult["ITEMS"][$i]["PROPERTIES"][$colorCode]["VALUE"]]['UF_XML_ID']] = $HLParams[$colorCode][$arResult["ITEMS"][$i]["PROPERTIES"][$colorCode]["VALUE"]];
		}
	}

	if( $arResult["ITEMS"][$i]['OFFERS'] )
	{
		for($j = 0; $j < sizeof( $arResult["ITEMS"][$i]['OFFERS'] ); ++$j)
		{
			if( !isset( $HLParams[$colorCode] ) )
			{
				$PropArray = B2BSKitShop::GetValuesFromHL(
						$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'],
						$arResult['CATALOG']['IBLOCK_ID'], $colorCode );
				$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
			}

			$colorXmlID = $arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$colorCode]["VALUE"];

			$HLColor = $HLParams[$colorCode][$colorXmlID];
			if( !$colorXmlID )
				$colorXmlID = 0;

			if( $availableDelete && !$arResult["ITEMS"][$i]['OFFERS'][$j]["CAN_BUY"] )
				continue 1;

				$colorXmlIDs[$arResult["ITEMS"][$i]['ID']][] = $colorXmlID;
			// if isset color in filter
			if( $arParams['FILTER_CHECKED_FIRST_COLOR'] )
			{
				if( in_array( $colorXmlID, $arParams['FILTER_CHECKED_FIRST_COLOR'] ) && !$arResult["ITEMS"][$i]['FIRST_COLOR'] )
				{
					$arResult["ITEMS"][$i]['FIRST_COLOR'] = $colorXmlID;
				}
			}
			elseif( !$arResult["ITEMS"][$i]['FIRST_COLOR'] )
			{
				$arResult["ITEMS"][$i]['FIRST_COLOR'] = $colorXmlID;
			}

			// set min price from offers
			$arResult["ITEMS"][$i]['MIN_PRICE'] = B2BSKitShop::GetMinPrice( $arResult["ITEMS"][$i]['MIN_PRICE'],
					$arResult["ITEMS"][$i]['OFFERS'][$j]["MIN_PRICE"] );
			// available properties
			if( $arParams['OFFER_TREE_PROPS'] )
			{
				for($k = 0; $k < sizeof( $arParams['OFFER_TREE_PROPS'] ); ++$k)
				{
					if( $arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE'] && $arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]["USER_TYPE"] == 'directory' )
					{
						if( !isset( $HLParams[$arParams['OFFER_TREE_PROPS'][$k]] ) )
						{
							$PropArray = B2BSKitShop::GetValuesFromHL(
									$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['USER_TYPE_SETTINGS']['TABLE_NAME'],
									$arResult['CATALOG']['IBLOCK_ID'], $arParams['OFFER_TREE_PROPS'][$k] );
							$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
							unset( $PropArray );
						}
						$arResult["ITEMS"][$i]["OFFER_TREE_PROPS"][$arParams['OFFER_TREE_PROPS'][$k]][$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']] = $HLParams[$arParams['OFFER_TREE_PROPS'][$k]][$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']];
						$arResult["ITEMS"][$i]["OFFER_TREE_PROPS_VALUE"][$arParams['OFFER_TREE_PROPS'][$k]][$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']] = $HLParams[$arParams['OFFER_TREE_PROPS'][$k]][$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']]['UF_NAME'];
						// name of property
						$arResult["PROP_NAME"][$arParams['OFFER_TREE_PROPS'][$k]] = $arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$arParams['OFFER_TREE_PROPS'][$k]]['NAME'];
					}
				}
				unset( $k );
			}

			// if images in product
			if( !$imageFromOffer )
				continue;
			// if isset color in offer
			if( $colorXmlID && $arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$colorCode]["USER_TYPE"] == "directory" )
			{
				// delete offer if not color and need delete
				if( !($arResult["ITEMS"][$i]['OFFERS'][$j]["PREVIEW_PICTURE"] || $arResult["ITEMS"][$i]['OFFERS'][$j]["DETAIL_PICTURE"] || $arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$arParams["MORE_PHOTO_OFFER_PROPS"]]["VALUE"]) && $colorDelete )
				{
					unset( $arResult["ITEMS"][$i]['OFFERS'][$j] );
				}
			}
			// get photos from offers
			$arResult["MORE_PHOTO_JS"][$IdItem][$colorXmlID] = B2BSKitShop::GetImagesIfOffers(
					$arResult["ITEMS"][$i]['OFFERS'][$j]["PREVIEW_PICTURE"], $arResult["ITEMS"][$i]['OFFERS'][$j]["DETAIL_PICTURE"],
					$arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$arParams["MORE_PHOTO_OFFER_PROPS"]]["VALUE"],
					$arResult["ITEMS"][$i]['PROPERTIES']['ADD_PICTURES']['VALUE'], $arResult["ITEMS"][$i]["PREVIEW_PICTURE"],
					$arResult["ITEMS"][$i]["DETAIL_PICTURE"], $arParams["LIST_WIDTH_SMALL"], $arParams["LIST_HEIGHT_SMALL"],
					$arParams["LIST_WIDTH_MEDIUM"], $arParams["LIST_HEIGHT_MEDIUM"], 0, 0, $ResizeMode, $arParams['AJAX_PRODUCT_LOAD'],
					$arResult["MORE_PHOTO_JS"][$IdItem][$colorXmlID], $arResult["ITEMS"][$i]['FIRST_COLOR'], $colorXmlID );
		}
		unset( $j );
	}
	// if not offers
	else
	{
		// if images in product
		if( $imageFromOffer )
		{
			$arResult["MORE_PHOTO_JS"][$IdItem][0] = B2BSKitShop::GetImagesIfOffers( $arResult["ITEMS"][$i]["PREVIEW_PICTURE"],
					$arResult["ITEMS"][$i]["DETAIL_PICTURE"], $arResult["ITEMS"][$i]['PROPERTIES']['ADD_PICTURES']['VALUE'],
					$arResult["ITEMS"][$i]["PROPERTIES"][$arParams["MORE_PHOTO_PRODUCT_PROPS"]]["VALUE"], $arResult["ITEMS"][$i]["PREVIEW_PICTURE"],
					$arResult["ITEMS"][$i]["DETAIL_PICTURE"], $arParams["LIST_WIDTH_SMALL"], $arParams["LIST_HEIGHT_SMALL"],
					$arParams["LIST_WIDTH_MEDIUM"], $arParams["LIST_HEIGHT_MEDIUM"], 0, 0, $ResizeMode, $arParams['AJAX_PRODUCT_LOAD'],
					$arResult["MORE_PHOTO_JS"][$IdItem][0], $arResult["ITEMS"][$i]['FIRST_COLOR'], 0 );
		}
	}

	// color from product
	if( !$imageFromOffer )
	{
		if( !isset( $HLParams[$colorCode] ) )
		{
			$PropArray = B2BSKitShop::GetValuesFromHL( $arResult["ITEMS"][$i]['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'],
					$arResult['CATALOG']['IBLOCK_ID'], $colorCode );
			$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
		}

		$DetailPhoto = ($arResult["ITEMS"][$i]["PREVIEW_PICTURE"]) ? $arResult["ITEMS"][$i]["PREVIEW_PICTURE"] : $arResult["ITEMS"][$i]["DETAIL_PICTURE"];
		$ImageFromProduct = B2BSKitShop::ImagesFromProduct( $DetailPhoto, $arResult["ITEMS"][$i]['PROPERTIES']["MORE_PHOTO"]['VALUE'],
				$HLParams[$colorCode], $arResult["ITEMS"][$i]["FIRST_COLOR"], $arParams['COLOR_IN_PRODUCT'], $arParams["COLOR_IN_SECTION_LINK"],
				$arParams['AJAX_PRODUCT_LOAD'], $arParams["LIST_WIDTH_SMALL"], $arParams["LIST_HEIGHT_SMALL"], $arParams["LIST_WIDTH_MEDIUM"],
				$arParams["LIST_HEIGHT_MEDIUM"], 0, 0, $ResizeMode, $arParams['OFFER_TREE_PROPS'], $colorCode );
		if( $ImageFromProduct['FIRST_COLOR'] )
		{
			$arResult["ITEMS"][$i]['FIRST_COLOR'] = $ImageFromProduct['FIRST_COLOR'];
		}
		if( $ImageFromProduct['PHOTOS'] )
		{
			$arResult["MORE_PHOTO_JS"][$IdItem] = $ImageFromProduct['PHOTOS'];
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

		if( $ImageFromProduct['OFFER_TREE_PROPS'] && $arResult["ITEMS"][$i]['CAN_BUY'] == 'Y')
		{
			$arResult["ITEMS"][$i]['OFFER_TREE_PROPS'][$colorCode] = $ImageFromProduct['OFFER_TREE_PROPS'][$colorCode];
		}
	}

	// if one color do some colors
	if( sizeof( $arResult["MORE_PHOTO_JS"][$IdItem] ) == 1 && $arParams['COLOR_IN_PRODUCT'] != 'Y' )
	{
		$arResult["MORE_PHOTO_JS"][$IdItem] = B2BSKitShop::reOneColor( $arResult["MORE_PHOTO_JS"][$IdItem], $arParams["LIST_WIDTH_SMALL"],
				$arParams["LIST_HEIGHT_SMALL"], $arParams["LIST_WIDTH_MEDIUM"], $ResizeMode );
	}

	// fancy for quick view
	$arResult["FANCY"][$i]["ID"] = $IdItem;
	$arResult["FANCY"][$i]["DETAIL_PAGE_URL"] = $arResult["ITEMS"][$i]["DETAIL_PAGE_URL"];

	// set if not first color
	if( !isset( $arResult["ITEMS"][$i]["FIRST_COLOR"] ) && $arResult["MORE_PHOTO_JS"][$IdItem] )
	{
		$arResult["ITEMS"][$i]["FIRST_COLOR"] = reset( array_keys( $arResult["MORE_PHOTO_JS"][$IdItem] ) );
	}

	// first color up of small images
	if( $arResult["MORE_PHOTO_JS"][$IdItem] )
	{
		if( $arResult["ITEMS"][$i]["FIRST_COLOR"] != reset( array_keys( $arResult["MORE_PHOTO_JS"][$IdItem] ) ) )
		{
			$Tmp[$arResult["ITEMS"][$i]["FIRST_COLOR"]] = $arResult["MORE_PHOTO_JS"][$IdItem][$arResult["ITEMS"][$i]["FIRST_COLOR"]];
			$Tmp = array_merge( $Tmp, $arResult["MORE_PHOTO_JS"][$IdItem] );
			$arResult["MORE_PHOTO_JS"][$IdItem] = $Tmp;
			unset( $Tmp );
		}
	}

	$SortPropertyTree = B2BSKitShop::SortPropertyTree( $arResult["ITEMS"][$i]["OFFER_TREE_PROPS_VALUE"], $colorCode, '', array(), array());
	$arResult["ITEMS"][$i]["OFFER_TREE_PROPS_VALUE"] = $SortPropertyTree['PROPERTIES'];
	unset( $SortPropertyTree );


	$CookKey = array_search( $arResult["ITEMS"][$i]['ID'], $Cook );
	$SortItems[$NumbKeys[$CookKey]] = $arResult["ITEMS"][$i];
	unset( $CookKey );

}
unset( $NumbKeys );
unset( $cntItems );
unset( $IdItem );
unset( $i );
unset( $n );

ksort( $SortItems );

$arResult["ITEMS"] = $SortItems;
unset( $SortItems );

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

$this->__component->arResultCacheKeys = array_merge( $this->__component->arResultCacheKeys, array(
		'FANCY',
		'RAND'
) );
?>