<?
use Bitrix\Catalog\PriceTable;

if( !defined( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true )
	die();
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
$n = 0;
$k = 0;
$ids = array();
$vats = array();

$arResult['QUANTITY'] = [];

$articleElementId = \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "OPT_ARTICUL_PROP", "" );
$articleOfferId = \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "OPT_ARTICUL_PROP_OFFER", "" );
$articleElementCode = '';
$articleOfferCode = '';

$arResult['ARTICLES'] = array();
$arResult["OFFER_AVAILABLE_ID"] = array();
$arResult['MIN_PRICE'] = 0;

$arResult['FIRST_OFFERS'] = array();

$arResult['PRICE_NAMES'] = array();

for($i = 0; $i < $cntItems; ++$i)
{
	$IdItem = $arResult["ITEMS"][$i]['ID'];

	if( $arResult["ITEMS"][$i]['CATALOG_VAT'] && $arResult["ITEMS"][$i]['CATALOG_VAT_INCLUDED'] == 'N' )
	{
		$vats[$arResult["ITEMS"][$i]['ID']] = $arResult["ITEMS"][$i]['CATALOG_VAT'];
	}

	if( !$articleElementCode )
	{
		foreach( $arResult["ITEMS"][$i]["PROPERTIES"] as $code => $prop )
		{
			if( $prop['ID'] == $articleElementId )
			{
				$articleElementCode = $code;
			}
		}
	}

	$arResult['ARTICLES'][$IdItem] = $arResult["ITEMS"][$i]["PROPERTIES"][$articleElementCode]['VALUE'];

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
				$PropArray = B2BSSotbitShop::GetValuesFromHL( $arResult["ITEMS"][$i]['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'], $arResult['CATALOG']['IBLOCK_ID'], $colorCode );
				$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
			}
			$arResult["ITEMS"][$i]["OFFER_TREE_PROPS"][$colorCode][$HLParams[$colorCode][$arResult["ITEMS"][$i]["PROPERTIES"][$colorCode]["VALUE"]]['UF_XML_ID']] = $HLParams[$colorCode][$arResult["ITEMS"][$i]["PROPERTIES"][$colorCode]["VALUE"]];
		}
	}

	if( $arResult["ITEMS"][$i]['OFFERS'] )
	{
		for($j = 0; $j < sizeof( $arResult["ITEMS"][$i]['OFFERS'] ); ++$j)
		{

			if( !$arResult['MIN_PRICE'] && $arResult["ITEMS"][$i]['OFFERS'][$j]['MIN_PRICE']['PRICE_ID'] )
			{
				$arResult['MIN_PRICE'] = $arResult["ITEMS"][$i]['OFFERS'][$j]['MIN_PRICE']['PRICE_ID'];
			}

			if( !$articleOfferCode )
			{
				foreach( $arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"] as $code => $prop )
				{
					if( $prop['ID'] == $articleOfferId )
					{
						$articleOfferCode = $code;
					}
				}
			}

			$arResult['ARTICLES'][$arResult["ITEMS"][$i]['OFFERS'][$j]['ID']] = $arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$articleOfferCode]['VALUE'];

			if( !isset( $HLParams[$colorCode] ) )
			{
				$PropArray = B2BSSotbitShop::GetValuesFromHL( $arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'], $arResult['CATALOG']['IBLOCK_ID'], $colorCode );
				$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
			}

			$colorXmlID = $arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$colorCode]["VALUE"];

			$HLColor = $HLParams[$colorCode][$colorXmlID];
			if( !$colorXmlID )
				$colorXmlID = 0;

			if( $availableDelete && !$arResult["ITEMS"][$i]['OFFERS'][$j]["CAN_BUY"] )
				continue 1;

			if( $arResult["ITEMS"][$i]['OFFERS'][$j]['CATALOG_VAT'] && $arResult["ITEMS"][$i]['OFFERS'][$j]['CATALOG_VAT_INCLUDED'] == 'N' )
			{
				$vats[$arResult["ITEMS"][$i]['OFFERS'][$j]['ID']] = $arResult["ITEMS"][$i]['OFFERS'][$j]['CATALOG_VAT'];
			}

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
			// $arResult["ITEMS"][$i]['MIN_PRICE'] = B2BSSotbitShop::GetMinPrice ( $arResult["ITEMS"][$i]['MIN_PRICE'], $arResult["ITEMS"][$i]['OFFERS'][$j]["MIN_PRICE"] );
			// available properties


			foreach($arResult["ITEMS"][$i]['OFFERS'][$j]['PRICES'] as $price)
			{
				if($price['CAN_ACCESS'] == 'Y')
				{
					$arResult['PRICE_NAMES'][$price['PRICE_ID']] = $price['PRICE_ID'];
					$arResult["PRICES_JS"][$arResult["ITEMS"][$i]['OFFERS'][$j]['ID']][$price['PRICE_ID']]['VALUE'] =
						$price['VALUE'];
					$arResult["PRICES_JS"][$arResult["ITEMS"][$i]['OFFERS'][$j]['ID']][$price['PRICE_ID']]['TEXT'] = $price['PRINT_VALUE'];
				}
			}

			if( $arParams['OFFER_TREE_PROPS'] )
			{
				for($k = 0; $k < sizeof( $arParams['OFFER_TREE_PROPS'] ); ++$k)
				{
					if( $arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE'] && $arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]["USER_TYPE"] == 'directory' )
					{
						if( !isset( $HLParams[$arParams['OFFER_TREE_PROPS'][$k]] ) )
						{
							$PropArray = B2BSSotbitShop::GetValuesFromHL( $arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['USER_TYPE_SETTINGS']['TABLE_NAME'], $arResult['CATALOG']['IBLOCK_ID'], $arParams['OFFER_TREE_PROPS'][$k] );
							$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
							unset( $PropArray );
						}

						$arResult["ITEMS"][$i]["OFFER_TREE_PROPS"][$arParams['OFFER_TREE_PROPS'][$k]][$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']] = $HLParams[$arParams['OFFER_TREE_PROPS'][$k]][$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']];
						$arResult["ITEMS"][$i]["OFFER_TREE_PROPS_VALUE"][$arParams['OFFER_TREE_PROPS'][$k]][$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']] = $HLParams[$arParams['OFFER_TREE_PROPS'][$k]][$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']]['UF_NAME'];

						$arResult["ITEMS"][$i]["OFFERS_ID"][$arParams['OFFER_TREE_PROPS'][$k]][$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']][$arResult["ITEMS"][$i]['OFFERS'][$j]["ID"]] = $arResult["ITEMS"][$i]['OFFERS'][$j]["ID"];

						if( $arParams['COLOR_IN_PRODUCT'] && $arParams["COLOR_IN_SECTION_LINK"] == 2 )
						{
							$arResult["ITEMS"][$i]["OFFERS_ID"][$colorCode][$arResult["ITEMS"][$i]['PROPERTIES'][$colorCode]['VALUE']][$arResult["ITEMS"][$i]['OFFERS'][$j]["ID"]] = $arResult["ITEMS"][$i]['OFFERS'][$j]["ID"];
						}

						if( $arResult["ITEMS"][$i]['OFFERS'][$j]["CAN_BUY"] )
						{
							$arResult["ITEMS"][$i]["CAN_BUY_OFFERS_ID"][$arParams['OFFER_TREE_PROPS'][$k]][$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']][$arResult["ITEMS"][$i]['OFFERS'][$j]["ID"]] = $arResult["ITEMS"][$i]['OFFERS'][$j]["ID"];
							$arResult["ITEMS"][$i]["CAN_BUY_OFFERS_ID"][$colorCode][$arResult["ITEMS"][$i]['PROPERTIES'][$colorCode]['VALUE']][$arResult["ITEMS"][$i]['OFFERS'][$j]["ID"]] = $arResult["ITEMS"][$i]['OFFERS'][$j]["ID"];
						}

						// name of property
						$arResult["PROP_NAME"][$arParams['OFFER_TREE_PROPS'][$k]] = $arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$arParams['OFFER_TREE_PROPS'][$k]]['NAME'];
					}
				}
				unset( $k );
			}

			if( !$arResult["ITEMS"][$i]['FIRST_OFFER'] && $arResult["ITEMS"][$i]['OFFERS'][$j]['CAN_BUY'] == "Y" )
			{
				$arResult["ITEMS"][$i]['FIRST_OFFER'] = $arResult["ITEMS"][$i]['OFFERS'][$j]['ID'];
				$arResult["ITEMS"][$i]['CAN_BUY_FIRST_OFFER'] = $arResult["ITEMS"][$i]['OFFERS'][$j]['CAN_BUY'];
			}

			$ids[$arResult["ITEMS"][$i]['OFFERS'][$j]["ID"]]['IBLOCK_ID'] = $arResult["ITEMS"][$i]['OFFERS'][$j]["IBLOCK_ID"];

			if( $arResult["ITEMS"][$i]['OFFERS'][$j]["CAN_BUY"] )
			{
				$arResult['ADDED_TO_BASKET'][$arResult["ITEMS"][$i]['OFFERS'][$j]["ID"]] = 0;
				$arResult["OFFER_ADD_URL"][$arResult["ITEMS"][$i]['OFFERS'][$j]["ID"]] = str_replace( $arParams["PRODUCT_ID_VARIABLE"] . "=", "id=", $arResult["ITEMS"][$i]['OFFERS'][$j]["~ADD_URL"] ) . "&ajax_basket=Y";
			}
			else
			{
				$arResult["OFFER_AVAILABLE_ID"][$arResult["ITEMS"][$i]['OFFERS'][$j]["ID"]] = $arResult["ITEMS"][$i]['OFFERS'][$j]["ID"];
			}

			if($arResult["ITEMS"][$i]['OFFERS'][$j]["CAN_BUY"])
			{
				$arResult['QUANTITY'][$arResult["ITEMS"][$i]['OFFERS'][$j]['ID']] =
					$arResult["ITEMS"][$i]['OFFERS'][$j]['CATALOG_QUANTITY'];
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
			/*
			 * $arResult["MORE_PHOTO_JS"][$IdItem][$colorXmlID] = B2BSSotbitShop::GetImagesIfOffers (
			 * $arResult["ITEMS"][$i]['OFFERS'][$j]["PREVIEW_PICTURE"],
			 * $arResult["ITEMS"][$i]['OFFERS'][$j]["DETAIL_PICTURE"],
			 * $arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$arParams["MORE_PHOTO_OFFER_PROPS"]]["VALUE"],
			 * $arResult["ITEMS"][$i]['PROPERTIES']['ADD_PICTURES']['VALUE'],
			 * $arResult["ITEMS"][$i]["PREVIEW_PICTURE"],
			 * $arResult["ITEMS"][$i]["DETAIL_PICTURE"],
			 * $arParams["LIST_WIDTH_SMALL"],
			 * $arParams["LIST_HEIGHT_SMALL"],
			 * $arParams["LIST_WIDTH_MEDIUM"],
			 * $arParams["LIST_HEIGHT_MEDIUM"],
			 * 0,
			 * 0,
			 * $ResizeMode,
			 * $arParams['AJAX_PRODUCT_LOAD'],
			 * $arResult["MORE_PHOTO_JS"][$IdItem][$colorXmlID],
			 * $arResult["ITEMS"][$i]['FIRST_COLOR'],
			 * $colorXmlID,
			 * $arResult["ITEMS"][$i]['PROPERTIES']['MORE_PHOTO']['VALUE']
			 * );
			 */
		}
		unset( $j );
		// set first offer if no
		if( !$arResult["ITEMS"][$i]['FIRST_OFFER'] )
		{
			$arResult["ITEMS"][$i]['FIRST_OFFER'] = $arResult["ITEMS"][$i]['OFFERS'][0]['ID'];
			$arResult["ITEMS"][$i]['CAN_BUY_FIRST_OFFER'] = $arResult["ITEMS"][$i]['OFFERS'][0]['CAN_BUY'];
		}
	}
	// if not offers
	else
	{


		foreach($arResult["ITEMS"][$i]['PRICES'] as $price)
		{
			if($price['CAN_ACCESS'] == 'Y')
			{
				$arResult['PRICE_NAMES'][$price['PRICE_ID']] = $price['PRICE_ID'];
				$arResult["PRICES_JS"][$arResult["ITEMS"][$i]['ID']][$price['PRICE_ID']]['VALUE'] =
					$price['VALUE'];
				$arResult["PRICES_JS"][$arResult["ITEMS"][$i]['ID']][$price['PRICE_ID']]['TEXT'] = $price['PRINT_VALUE'];
			}
		}


		if( !$arResult['MIN_PRICE'] && $arResult["ITEMS"][$i]['MIN_PRICE']['PRICE_ID'] )
		{
			$arResult['MIN_PRICE'] = $arResult["ITEMS"][$i]['MIN_PRICE']['PRICE_ID'];
		}

		$arResult["ITEMS"][$i]['FIRST_OFFER'] = $arResult["ITEMS"][$i]['ID'];
		$arResult["ITEMS"][$i]['FIRST_COLOR'] = 0;

		$ids[$arResult["ITEMS"][$i]["ID"]]['IBLOCK_ID'] = $arResult["ITEMS"][$i]["IBLOCK_ID"];
		/*
		 * foreach($arResult["ITEMS"][$i]['PRICES'] as $code => $price)
		 * {
		 * $arResult["PRICES_JS"][$arResult["ITEMS"][$i]["ID"]][$code]['VALUE'] = $price['DISCOUNT_VALUE'];
		 * $arResult["PRICES_JS"][$arResult["ITEMS"][$i]["ID"]][$code]['TEXT'] = $price['PRINT_DISCOUNT_VALUE'];
		 * }
		 */

		if($arResult["ITEMS"][$i]['CAN_BUY'])
		{
			$arResult['QUANTITY'][$arResult["ITEMS"][$i]['ID']] =
				$arResult["ITEMS"][$i]['CATALOG_QUANTITY'];
		}


		$arResult["ITEMS"][$i]["CAN_BUY_FIRST_OFFER"] = $arResult["ITEMS"][$i]['CAN_BUY'];
		if( $arResult["ITEMS"][$i]["CAN_BUY_FIRST_OFFER"] )
		{
			$arResult['ADDED_TO_BASKET'][$arResult["ITEMS"][$i]['ID']] = 0;
			$arResult["OFFER_ADD_URL"][$arResult["ITEMS"][$i]['ID']] = str_replace( $arParams["PRODUCT_ID_VARIABLE"] . "=", "id=", $arResult["ITEMS"][$i]["~ADD_URL"] ) . "&ajax_basket=Y";
		}
		else
		{
			$arResult["OFFER_AVAILABLE_ID"][$arResult["ITEMS"][$i]['ID']] = $arResult["ITEMS"][$i]['ID'];
		}

		// if images in product
		if( $imageFromOffer )
		{
			/*
			 * $arResult["MORE_PHOTO_JS"][$IdItem][0] = B2BSSotbitShop::GetImagesIfOffers (
			 * $arResult["ITEMS"][$i]["PREVIEW_PICTURE"],
			 * $arResult["ITEMS"][$i]["DETAIL_PICTURE"],
			 * $arResult["ITEMS"][$i]['PROPERTIES']['ADD_PICTURES']['VALUE'],
			 * $arResult["ITEMS"][$i]["PROPERTIES"][$arParams["MORE_PHOTO_PRODUCT_PROPS"]]["VALUE"],
			 * $arResult["ITEMS"][$i]["PREVIEW_PICTURE"],
			 * $arResult["ITEMS"][$i]["DETAIL_PICTURE"],
			 * $arParams["LIST_WIDTH_SMALL"],
			 * $arParams["LIST_HEIGHT_SMALL"],
			 * $arParams["LIST_WIDTH_MEDIUM"],
			 * $arParams["LIST_HEIGHT_MEDIUM"],
			 * 0,
			 * 0,
			 * $ResizeMode,
			 * $arParams['AJAX_PRODUCT_LOAD'],
			 * $arResult["MORE_PHOTO_JS"][$IdItem][0],
			 * $arResult["ITEMS"][$i]['FIRST_COLOR'],
			 * 0,
			 * $arResult["ITEMS"][$i]['PROPERTIES']['MORE_PHOTO']['VALUE']);
			 */
		}
	}

	$arResult['FIRST_OFFERS'][$arResult["ITEMS"][$i]['ID']] = $arResult["ITEMS"][$i]['FIRST_OFFER'];

	// color from product
	if( !$imageFromOffer )
	{
		if( !isset( $HLParams[$colorCode] ) )
		{
			$PropArray = B2BSSotbitShop::GetValuesFromHL( $arResult["ITEMS"][$i]['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'], $arResult['CATALOG']['IBLOCK_ID'], $colorCode );
			$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
		}

		$DetailPhoto = ($arResult["ITEMS"][$i]["PREVIEW_PICTURE"]) ? $arResult["ITEMS"][$i]["PREVIEW_PICTURE"] : $arResult["ITEMS"][$i]["DETAIL_PICTURE"];

		// $ImageFromProduct = B2BSSotbitShop::ImagesFromProduct($DetailPhoto,$arResult["ITEMS"][$i]['PROPERTIES']["MORE_PHOTO"]['VALUE'],$HLParams[$colorCode],$arResult["ITEMS"][$i]["FIRST_COLOR"],$arParams['COLOR_IN_PRODUCT'],$arParams["COLOR_IN_SECTION_LINK"],$arParams['AJAX_PRODUCT_LOAD'],$arParams["LIST_WIDTH_SMALL"], $arParams["LIST_HEIGHT_SMALL"], $arParams["LIST_WIDTH_MEDIUM"], $arParams["LIST_HEIGHT_MEDIUM"],0,0, $ResizeMode,$arParams['OFFER_TREE_PROPS'],$colorCode);
		if( $ImageFromProduct['FIRST_COLOR'] )
		{
			$arResult["ITEMS"][$i]['FIRST_COLOR'] = $ImageFromProduct['FIRST_COLOR'];
		}
		if( $ImageFromProduct['PHOTOS'] )
		{
			$arResult["MORE_PHOTO_JS"][$IdItem] = $ImageFromProduct['PHOTOS'];
		}
		if( $ImageFromProduct['OFFER_TREE_PROPS'] && $arResult["ITEMS"][$i]['CAN_BUY'] == 'Y' )
		{
			$arResult["ITEMS"][$i]['OFFER_TREE_PROPS'][$colorCode] = $ImageFromProduct['OFFER_TREE_PROPS'][$colorCode];
		}
	}

	// if one color do some colors
	/*
	 * if (sizeof ( $arResult["MORE_PHOTO_JS"][$IdItem] ) == 1 && $arParams['COLOR_IN_PRODUCT'] != 'Y')
	 * {
	 * $arResult["MORE_PHOTO_JS"][$IdItem] = B2BSSotbitShop::reOneColor ( $arResult["MORE_PHOTO_JS"][$IdItem], $arParams["LIST_WIDTH_SMALL"], $arParams["LIST_HEIGHT_SMALL"], $arParams["LIST_WIDTH_MEDIUM"], $ResizeMode );
	 * }
	 */

	// fancy for quick view
	$arResult["FANCY"][$i]["ID"] = $IdItem;
	$arResult["FANCY"][$i]["DETAIL_PAGE_URL"] = $arResult["ITEMS"][$i]["DETAIL_PAGE_URL"];

	$SortPropertyTree = B2BSSotbitShop::SortPropertyTree( $arResult["ITEMS"][$i]["OFFER_TREE_PROPS"], $colorCode, $arResult["ITEMS"][$i]['FIRST_OFFER'], $arResult["ITEMS"][$i]['OFFERS_ID'], $arResult["ITEMS"][$i]['CAN_BUY_OFFERS_ID'] );

	$arResult["ITEMS"][$i]['FIRST_OFFER'] = $SortPropertyTree['FIRST_OFFER'];
	$arResult["ITEMS"][$i]["OFFER_TREE_PROPS"] = $SortPropertyTree['PROPERTIES'];

	$arResult["ITEMS"][$i]['LI'] = B2BSSotbitShop::GenerateLiClasses( $arResult["ITEMS"][$i]["OFFER_TREE_PROPS"], $arResult["ITEMS"][$i]['OFFERS_ID'], $arResult["ITEMS"][$i]['CAN_BUY_OFFERS_ID'], $arResult["ITEMS"][$i]['FIRST_OFFER'] );

	unset( $SortPropertyTree );

	// add item to row
	/*
	 * $arResult["BLOCK_ITEMS"][$n][] = $arResult["ITEMS"][$i];
	 * if (($i + 1) % $arParams['PAGE_ELEMENT_COUNT_IN_ROW'] == 0)
	 * $n ++;
	 */
}
unset( $cntItems );
unset( $IdItem );
unset( $i );
unset( $n );

// Get brands names

// $arResult["BRANDS"] = B2BSSotbitShop::GetBrandsNames ( $arBrandID, $arBrandIblock );

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

		$ColorLink2 = B2BSSotbitShop::ColorLink2( $arModelsLinks, $arParams["COLOR_IN_PRODUCT_LINK"], $arParams['COLOR_IN_PRODUCT_CODE'], $colorCode, 0, 0, 0, 0, $ResizeMode, $arParams['IBLOCK_ID'] );

		$addIds = array();
		$pIds = array();
		if( $ColorLink2['IDS'] )
		{
			foreach( $ColorLink2['IDS'] as $ids1 )
			{
				$addIds = array_merge( $addIds, $ids1 );
			}
		}


		if( $addIds )
		{
			$offers = CCatalogSKU::getOffersList( $addIds, 0, array(
				'ACTIVE' => 'Y',
				'ACTIVE_DATE' => 'Y'
			), array(
				'ID',
				'IBLOCK_ID',
				'CATALOG_TYPE'
			), array(
				'CODE' => $arParams['OFFER_TREE_PROPS']
			) );


			$pIds = $addIds;
			foreach($addIds as $addId)
			{

				if($offers[$addId])
				{
					$pIds = array_merge($pIds, array_keys($offers[$addId]));
				}
			}
		}

		foreach( $arResult["ITEMS"] as $i => $arItem )
		{
			if( $ColorLink2['IDS'][$arItem['ID']] )
			{
				foreach( $ColorLink2['IDS'][$arItem['ID']] as $id )
				{
					if( $offers[$id] )
					{
						foreach( $offers[$id] as $idOffer => $offer )
						{
							$arResult["ITEMS"][$i]["OFFERS_ID"][$colorCode][$ColorLink2['PRODUCT_COLORS'][$id]][$idOffer] = $idOffer;
							$arResult["ITEMS"][$i]["OFFER_TREE_PROPS"][$colorCode][$ColorLink2['PRODUCT_COLORS'][$id]] = $HLParams[$colorCode][$ColorLink2['PRODUCT_COLORS'][$id]];

							if( $offer['CATALOG_AVAILABLE'] == 'Y' )
							{
								$arResult["ITEMS"][$i]["CAN_BUY_OFFERS_ID"][$colorCode][$ColorLink2['PRODUCT_COLORS'][$id]][$idOffer] = $idOffer;
							}
							else
							{
								$arResult["OFFER_AVAILABLE_ID"][$idOffer] = $idOffer;
							}
							$arResult["OFFER_ADD_URL"][$idOffer] = $APPLICATION->GetCurPage() . '?action=ADD2BASKET&id=' . $idOffer . '&ajax_basket=Y';

							$ids[$offer['ID']] = array(
								'IBLOCK_ID' => $offer['IBLOCK_ID']
							);

							foreach( $arParams['OFFER_TREE_PROPS'] as $prop )
							{
								$arResult["ITEMS"][$i]["OFFERS_ID"][$prop][$offer['PROPERTIES'][$prop]['VALUE']][$idOffer] = $idOffer;
								$arResult["ITEMS"][$i]["OFFER_TREE_PROPS"][$prop][$offer['PROPERTIES'][$prop]['VALUE']] = $HLParams[$prop][$offer['PROPERTIES'][$prop]['VALUE']];
							}
						}
					}
				}
				$arResult["ITEMS"][$i]['LI'] = B2BSSotbitShop::GenerateLiClasses( $arResult["ITEMS"][$i]["OFFER_TREE_PROPS"], $arResult["ITEMS"][$i]['OFFERS_ID'], $arResult["ITEMS"][$i]['CAN_BUY_OFFERS_ID'], $arResult["ITEMS"][$i]['FIRST_OFFER'] );
			}
		}
		if($pIds)
		{
			$db_res = CPrice::GetList(($by="CATALOG_GROUP_ID"), ($order="ASC"), array("PRODUCT_ID"=>$pIds,'CAN_ACCESS' => 'Y' ));
			while($price = $db_res->fetch())
			{
				$arResult['PRICE_NAMES'][$price['CATALOG_GROUP_ID']] = $price['CATALOG_GROUP_ID'];
				$arResult["PRICES_JS"][$price['PRODUCT_ID']][$price['CATALOG_GROUP_ID']]['VALUE'] =
					CCurrencyRates::ConvertCurrency($price['PRICE'], $price["CURRENCY"], "RUB");
				$arResult["PRICES_JS"][$price['PRODUCT_ID']][$price['CATALOG_GROUP_ID']]['TEXT'] = CurrencyFormat($price['PRICE'], $price["CURRENCY"]);
			}
		}
	}
}







$dbPriceType = CCatalogGroup::GetList( array(
	'ID' => 'asc'
), array(
	'ID' => array_keys($arResult['PRICE_NAMES'])
) );
while ( $arPriceType = $dbPriceType->Fetch() )
{
	if($arResult['PRICE_NAMES'][$arPriceType['ID']])
	{
		$arResult['PRICE_NAMES'][$arPriceType['ID']] = ($arPriceType['NAME_LANG']) ? $arPriceType['NAME_LANG'] : $arPriceType['NAME'];
	}
}

/*
$priceIds = unserialize( \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "PRICE_CODE_SECTION", "" ) );

if( !is_array( $priceIds ) )
{
	$priceIds = array();
}



$forSotbitPrice = array();







if( $ids && $priceIds )
{
	$dbPriceType = CCatalogGroup::GetList( array(
			'ID' => 'asc'
	), array(
			'ID' => $priceIds
	) );
	while ( $arPriceType = $dbPriceType->Fetch() )
	{
		$arResult['PRICE_NAMES'][$arPriceType['ID']] = ($arPriceType['NAME_LANG']) ? $arPriceType['NAME_LANG'] : $arPriceType['NAME'];
	}

	$rsPrices = PriceTable::getList(
			array(
					'order' => array(
							'CATALOG_GROUP_ID' => 'asc'
					),
					'filter' => array(
							'PRODUCT_ID' => array_keys( $ids ),
							'CATALOG_GROUP_ID' => $priceIds
					),
					'select' => array(
							'PRODUCT_ID',
							'CURRENCY',
							'PRICE',
							'CATALOG_GROUP_ID'
					)
			) );

	while ( $arPrice = $rsPrices->Fetch() )
	{

		if( $vats[$arPrice['PRODUCT_ID']] )
		{
			$vatRate = ( float ) $vats[$arPrice['PRODUCT_ID']];
			$percentVat = $vatRate * 0.01;
			$percentPriceWithVat = 1 + $percentVat;
			$arPrice['PRICE'] *= $percentPriceWithVat;
		}
		$ids[$arPrice['PRODUCT_ID']]['PRICES'][$arPrice['CATALOG_GROUP_ID']]['PRICE'] = $arPrice['PRICE'];
		$ids[$arPrice['PRODUCT_ID']]['PRICES'][$arPrice['CATALOG_GROUP_ID']]['CURRENCY'] = $arPrice['CURRENCY'];
	}

	foreach( $ids as $id => $val )
	{
		foreach( $val['PRICES'] as $idPrice => $price )
		{
			$forSotbitPrice[$idPrice]['ITEMS'][$id]['ID'] = $id;
			$forSotbitPrice[$idPrice]['ITEMS'][$id]['IBLOCK_ID'] = $val['IBLOCK_ID'];
			$discounts = array();

			if( \CIBlockPriceTools::isEnabledCalculationDiscounts() )
			{
				\CCatalogDiscountSave::Disable();
				$discounts = \CCatalogDiscount::GetDiscount( $id, $val['IBLOCK_ID'], array(
						$idPrice
				), array(), 'N', SITE_ID, array() );
				\CCatalogDiscountSave::Enable();
			}
			$forSotbitPrice[$idPrice]['ITEMS'][$id]['PRICES'] = array();
			$forSotbitPrice[$idPrice]['ITEMS'][$id]['MIN_PRICE'] = array();
			$discountPrice = \CCatalogProduct::CountPriceWithDiscount( $price['PRICE'], $price['CURRENCY'], $discounts );

			$forSotbitPrice[$idPrice]['ITEMS'][$id]['PRICES'][$idPrice] = array(
					'ID' => $idPrice,
					'VALUE' => $discountPrice,
					'PRINT_VALUE' => CurrencyFormat( $discountPrice, $price['CURRENCY'] ),
					'CURRENCY' => $price['CURRENCY']
			);
			$forSotbitPrice[$idPrice]['ITEMS'][$id]['MIN_PRICE'] = $forSotbitPrice[$idPrice]['ITEMS'][$id]['PRICES'][$idPrice];
		}
	}

	if( $forSotbitPrice )
	{
		foreach( $forSotbitPrice as $idPrice => $items )
		{
			if( Bitrix\Main\Loader::includeModule( "sotbit.price" ) )
			{
				$items = SotbitPrice::ChangeMinPrice( $items );
			}
			foreach( $items['ITEMS'] as $id => $price )
			{
				$arResult["PRICES_JS"][$id][$idPrice]['VALUE'] = $price['MIN_PRICE']['VALUE'];
				$arResult["PRICES_JS"][$id][$idPrice]['TEXT'] = $price['MIN_PRICE']['PRINT_VALUE'];
			}
		}
	}
}
*/


$this->__component->arResultCacheKeys = array_merge( $this->__component->arResultCacheKeys, array(
	'FANCY',
	'RAND'
) );
?>