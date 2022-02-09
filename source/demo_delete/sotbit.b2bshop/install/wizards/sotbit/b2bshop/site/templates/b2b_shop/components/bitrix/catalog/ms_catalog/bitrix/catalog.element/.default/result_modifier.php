<?
use Bitrix\Main\Config\Option;
use Bitrix\Main\Web\Json;

if (! defined( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true)
	die();


if (Bitrix\Main\Loader::includeModule( "sotbit.price" ))
{
	$arResult = SotbitPrice::ChangeMinPrice( $arResult );
}
if (Bitrix\Main\Loader::includeModule( "sotbit.regions" ) && class_exists('\Sotbit\Regions\Sale\Price'))
{
	$arResult = \Sotbit\Regions\Sale\Price::change( $arResult );
}

$arResult["IS_DOWNLOAD"] = \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "DOWNLOAD", "" );
$arMainProps = unserialize( \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "MAIN_PROPS", "" ) );
$arDopProps = unserialize( \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "DOP_PROPS", "" ) );
$arResult["SIZE_PROPS"] = unserialize( \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "SIZE_PROPS", "" ) );
$arResult["TABLE_SIZE_URL"] = \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "TABLE_SIZE_URL", "" );
$arOfferProps = unserialize( \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "OFFER_ELEMENT_PROPS", "" ) );
$arOfferParams = unserialize( \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "OFFER_ELEMENT_PARAMS", "" ) );
$ResizeMode = (! empty( $arParams["IMAGE_RESIZE_MODE"] ) ? $arParams["IMAGE_RESIZE_MODE"] : BX_RESIZE_IMAGE_PROPORTIONAL);
$colorCode = ($arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams['COLOR_IN_PRODUCT_CODE'] && $arResult["PROPERTIES"][$arParams["COLOR_IN_PRODUCT_LINK"]]["VALUE"]) ? $arParams['COLOR_IN_PRODUCT_CODE'] : $arParams["OFFER_COLOR_PROP"];
$availableDelete = ($arParams["AVAILABLE_DELETE"] == "Y") ? 1 : 0;
$imageFromOffer = ($arParams["PICTURE_FROM_OFFER"] == "Y") ? 1 : 0;
$colorDelete = ($arParams["DELETE_OFFER_NOIMAGE"] == "Y") ? 1 : 0;
$arResult['ADDED_TO_BASKET'] = array();
$colorXmlIDs = array();
$minPrice = 0;
$arColorName = $arColorXml = array ();


$arResult['MORE_PHOTO_JS2'] = [];

$arResult['COLOR_OFFER_FROM_IMAGE'] = unserialize(\Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "COLOR_OFFER_FROM_IMAGE",	"" ));

if(!is_array($arResult['COLOR_OFFER_FROM_IMAGE']))
{
	$arResult['COLOR_OFFER_FROM_IMAGE'] = [];
}

if(in_array($colorCode,$arResult['COLOR_OFFER_FROM_IMAGE'] ))
{
	unset($arResult['COLOR_OFFER_FROM_IMAGE'][array_search($colorCode,$arResult['COLOR_OFFER_FROM_IMAGE'])]);
}

// get offers iblock
$arSKU = CCatalogSKU::GetInfoByProductIBlock( $arParams['IBLOCK_ID'] );
$arResult['OFFERS_IBLOCK'] = $arSKU['IBLOCK_ID'];//need for gifts

if ($arResult['OFFERS'])
{
	if( $arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams['COLOR_IN_PRODUCT_CODE'] && $arResult["PROPERTIES"][$arParams["COLOR_IN_PRODUCT_LINK"]]["VALUE"])
	{
		if( $arResult["PROPERTIES"][$colorCode]["VALUE"] )
		{
			if( !isset( $HLParams[$colorCode] ) )
			{
				$PropArray = B2BSSotbitShop::GetValuesFromHL( $arResult['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'],
						$arResult['CATALOG']['IBLOCK_ID'], $colorCode );
				$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
			}
			$arResult["OFFER_TREE_PROPS"][$colorCode][$HLParams[$colorCode][$arResult["PROPERTIES"][$colorCode]["VALUE"]]['UF_XML_ID']] = $HLParams[$colorCode][$arResult["PROPERTIES"][$colorCode]["VALUE"]];
		}
	}
	for($j = 0; $j < sizeof( $arResult['OFFERS'] ); ++ $j)
	{
		$colorXmlID = $arResult['OFFERS'][$j]["PROPERTIES"][$colorCode]["VALUE"];

		$HLColor = $HLParams[$colorCode][$colorXmlID];
		if (! $colorXmlID)
			$colorXmlID = 0;

		if ($availableDelete && ! $arResult['OFFERS'][$j]["CAN_BUY"])
			continue 1;
			$colorXmlIDs[] = $colorXmlID;
			if (! $arResult['FIRST_COLOR'])
			{
				$arResult['FIRST_COLOR'] = $colorXmlID;
			}

			// generate basket
		if ($arResult['OFFERS'][$j]["CAN_BUY"])
		{
			$arResult['ADDED_TO_BASKET'][$arResult['OFFERS'][$j]["ID"]] = 0;
			$arResult["OFFER_ADD_URL"][$arResult['OFFERS'][$j]["ID"]] = str_replace( $arParams["PRODUCT_ID_VARIABLE"] . "=", "id=", $arResult['OFFERS'][$j]["~ADD_URL"] ) . "&ajax_basket=Y";
//			$arResult["OFFER_DELAY_URL"][$arResult['OFFERS'][$j]["ID"]] = str_replace( $arParams["ACTION_VARIABLE"] . "=ADD2BASKET", $arParams["ACTION_VARIABLE"] . "=DELAY", $arResult["OFFER_ADD_URL"][$arResult['OFFERS'][$j]["ID"]] );
//			$arResult["OFFER_DELAY_URL"][$arResult['OFFERS'][$j]["ID"]] = str_replace( 'id=', 's_id=', $arResult["OFFER_DELAY_URL"][$arResult['OFFERS'][$j]["ID"]] );

            $arResult["OFFER_ADD_URL"][$arResult['OFFERS'][$j]["ID"]] = '/include/ajax/basket_add_product_and_wish.php?ajax_basket=Y&entity=basket&action=add&s_id='.$arResult['OFFERS'][$j]["ID"].'&props='.implode(',', $arParams['OFFERS_CART_PROPERTIES']);
            $arResult["OFFER_DELAY_URL"][$arResult['OFFERS'][$j]["ID"]] = '/include/ajax/basket_add_product_and_wish.php?ajax_basket=Y&entity=delay&action=add&s_id='.$arResult['OFFERS'][$j]["ID"].'&props='.implode(',', $arParams['OFFERS_CART_PROPERTIES']);
		}
		else
		{
			$arResult["OFFER_SUBSCRIBE_URL"][$arResult['OFFERS'][$j]["ID"]] = str_replace( $arParams["PRODUCT_ID_VARIABLE"] . "=", "id=", $arResult['OFFERS'][$j]["~SUBSCRIBE_URL"] ) . "&ajax_basket=Y";
			$arResult["OFFER_AVAILABLE_ID"][$arResult['OFFERS'][$j]["ID"]] = $arResult['OFFERS'][$j]["ID"];
		}

		if ($arParams['OFFER_TREE_PROPS'])
		{
			$Tables = array ();
			for($k = 0; $k < sizeof( $arParams['OFFER_TREE_PROPS'] ); ++ $k)
			{
				if ($arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE'] && $arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]["USER_TYPE"] == 'directory')
				{
					if (! $HLParams)
					{
						$Tables[$arParams['OFFER_TREE_PROPS'][$k]] = $arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['USER_TYPE_SETTINGS']['TABLE_NAME'];
					}
				}
			}
			if (sizeof( $Tables ) > 0)
			{
				$HLParams = B2BSSotbitShop::GetValuesFromHL( $Tables );
			}
			for($k = 0; $k < sizeof( $arParams['OFFER_TREE_PROPS'] ); ++ $k)
			{
				if ($arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE'] && $arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]["USER_TYPE"] == 'directory')
				{
					if (! isset( $HLParams[$arParams['OFFER_TREE_PROPS'][$k]] ))
					{
						$PropArray = B2BSSotbitShop::GetValuesFromHL( $arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['USER_TYPE_SETTINGS']['TABLE_NAME'], $arSKU['IBLOCK_ID'], $arParams['OFFER_TREE_PROPS'][$k] );
						$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
						unset( $PropArray );
					}
					$arResult["OFFER_TREE_PROPS"][$arParams['OFFER_TREE_PROPS'][$k]][$arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']] = $HLParams[$arParams['OFFER_TREE_PROPS'][$k]][$arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']];
					$arResult["OFFER_TREE_PROPS_VALUE"][$arParams['OFFER_TREE_PROPS'][$k]][$arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']] = $HLParams[$arParams['OFFER_TREE_PROPS'][$k]][$arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']]['UF_NAME'];
					// available properties
					$arResult["OFFERS_ID"][$arParams['OFFER_TREE_PROPS'][$k]][$arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']][$arResult['OFFERS'][$j]["ID"]] = $arResult['OFFERS'][$j]["ID"];
					if ($arResult['OFFERS'][$j]["CAN_BUY"])
					{
						$arResult["CAN_BUY_OFFERS_ID"][$arParams['OFFER_TREE_PROPS'][$k]][$arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']][$arResult['OFFERS'][$j]["ID"]] = $arResult['OFFERS'][$j]["ID"];
					}
					elseif($arResult['OFFERS'][$j]['CATALOG_SUBSCRIBE'] == 'N')
					{
						unset($arResult["OFFERS_ID"][$arParams['OFFER_TREE_PROPS'][$k]][$arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']][$arResult['OFFERS'][$j]["ID"]]);
					}
					// name of property
					$arResult["PROP_NAME"][$arParams['OFFER_TREE_PROPS'][$k]] = $arResult['OFFERS'][$j]["PROPERTIES"][$arParams['OFFER_TREE_PROPS'][$k]]['NAME'];
				}
			}
			if( $arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams['COLOR_IN_PRODUCT_CODE'] && $arResult["PROPERTIES"][$colorCode]["VALUE"])
			{
				if( !isset( $HLParams[$colorCode] ) )
				{
					$PropArray = B2BSSotbitShop::GetValuesFromHL( $arResult['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'],
						$arResult['CATALOG']['IBLOCK_ID'], $colorCode );
					$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
				}

				$arResult["OFFERS_ID"][$colorCode][$arResult["PROPERTIES"][$colorCode]["VALUE"]][$arResult['OFFERS'][$j]["ID"]] = $arResult['OFFERS'][$j]["ID"];
				if ($arResult['OFFERS'][$j]["CAN_BUY"])
				{
					$arResult["CAN_BUY_OFFERS_ID"][$colorCode][$arResult["PROPERTIES"][$colorCode]["VALUE"]][$arResult['OFFERS'][$j]["ID"]] = $arResult['OFFERS'][$j]["ID"];
				}
				elseif($arResult['OFFERS'][$j]['CATALOG_SUBSCRIBE'] == 'N')
				{
					unset($arResult["OFFERS_ID"][$colorCode][$arResult["PROPERTIES"][$colorCode]["VALUE"]][$arResult['OFFERS'][$j]["ID"]]);
				}

			}
		}

		// set first offer
		if (! $arResult['FIRST_OFFER'] && $arResult['OFFERS'][$j]['CAN_BUY'] == "Y")
		{
			$arResult['FIRST_OFFER'] = $arResult['OFFERS'][$j]['ID'];
			$arResult['CAN_BUY_FIRST_OFFER'] = $arResult['OFFERS'][$j]['CAN_BUY'];
		}

		// Prices
		if ($arResult['OFFERS'][$j]["CAN_BUY"])
		{
			$arResult['MIN_PRICE'] = B2BSSotbitShop::GetMinPrice( $arResult['MIN_PRICE'], $arResult['OFFERS'][$j]["MIN_PRICE"] );
			$arResult["PRICES_JS"][$arResult['OFFERS'][$j]["ID"]]["DISCOUNT_PRICE"] = $arResult['OFFERS'][$j]["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"];
			$arResult["PRICES_JS"][$arResult['OFFERS'][$j]["ID"]]["OLD_PRICE"] = $arResult['OFFERS'][$j]["MIN_PRICE"]["PRINT_VALUE"];
		}
		// set microrazmetka
		$arResult['MICRORAZMETKA']['AGGREGATEOFFER_PRICE'][] = ($arResult['OFFERS'][$j]["MIN_PRICE"]['DISCOUNT_VALUE']) ? $arResult['OFFERS'][$j]["MIN_PRICE"]['DISCOUNT_VALUE'] : $arResult['OFFERS'][$j]["MIN_PRICE"]['VALUE'];
		$arResult['MICRORAZMETKA']['AGGREGATEOFFER_PRICECURRENCY'][] = $arResult['OFFERS'][$j]["MIN_PRICE"]['CURRENCY'];
		// Offer props
		if ($arOfferProps)
		{
			for($k = 0; $k < sizeof( $arOfferProps ); ++ $k)
			{
				if ($arResult['OFFERS'][$j][$arOfferProps[$k]])
				{
					$arResult['OFFERS_PROPS'][$arResult['OFFERS'][$j]['ID']][$arOfferProps[$k]] = $arResult['OFFERS'][$j][$arOfferProps[$k]];
					$arResult["PROP_NAME"][$arOfferProps[$k]] = \Bitrix\Main\Localization\Loc::getMessage( "B2BS_CATALOG_DETAIL_OFFER_" . $arOfferProps[$k] );
				}
			}
		}
		unset( $k );

		// Offer props 2
		if ($arOfferParams)
		{
			for($k = 0; $k < sizeof( $arOfferParams ); ++ $k)
			{
				if ($arResult['OFFERS'][$j]['PROPERTIES'][$arOfferParams[$k]]['VALUE'])
				{
					if (! isset( $HLParams[$arOfferParams[$k]] ))
					{
						$PropArray = B2BSSotbitShop::GetValuesFromHL( $arResult['OFFERS'][$j]['PROPERTIES'][$arOfferParams[$k]]['USER_TYPE_SETTINGS']['TABLE_NAME'], $arSKU['IBLOCK_ID'], $arOfferParams[$k] );
						$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
						unset( $PropArray );
					}
					if ($arResult['OFFERS'][$j]['PROPERTIES'][$arOfferParams[$k]])
					{
						if ($HLParams[$arOfferParams[$k]])
						{
							$arResult['OFFERS_PROPS'][$arResult['OFFERS'][$j]['ID']][$arOfferParams[$k]] = $HLParams[$arOfferParams[$k]][$arResult['OFFERS'][$j]['PROPERTIES'][$arOfferParams[$k]]['VALUE']]['UF_NAME'];
						}
						else
						{
							$arResult['OFFERS_PROPS'][$arResult['OFFERS'][$j]['ID']][$arOfferParams[$k]] = $arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE'];
						}
						$arResult["PROP_NAME"][$arOfferParams[$k]] = $arResult['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['NAME'];
					}
				}
			}
		}

		if (! $imageFromOffer)
			continue;

		if ($colorXmlID && $arResult['OFFERS'][$j]['PROPERTIES'][$colorCode]["USER_TYPE"] == "directory")
		{
			// delete offer if not color and need delete
			if (! ($arResult['OFFERS'][$j]["PREVIEW_PICTURE"] || $arResult['OFFERS'][$j]["DETAIL_PICTURE"] || $arResult['OFFERS'][$j]["PROPERTIES"][$arParams["MORE_PHOTO_OFFER_PROPS"]]["VALUE"]) && $colorDelete)
			{
				unset( $arResult['OFFERS'][$j] );
			}
		}

			if(count($arResult['COLOR_OFFER_FROM_IMAGE']) > 0)
			{
				$arResult["MORE_PHOTO_JS2"][$arResult['OFFERS'][$j]['ID']] = B2BSSotbitShop::GetImagesIfOffers( $arResult['OFFERS'][$j]["PREVIEW_PICTURE"], $arResult['OFFERS'][$j]["DETAIL_PICTURE"], $arResult['OFFERS'][$j]["PROPERTIES"][$arParams["MORE_PHOTO_OFFER_PROPS"]]["VALUE"],
					$arResult['PROPERTIES']['ADD_PICTURES']['VALUE'], $arResult["PREVIEW_PICTURE"], $arResult["DETAIL_PICTURE"], $arParams["DETAIL_WIDTH_SMALL"], $arParams["DETAIL_HEIGHT_SMALL"], $arParams["DETAIL_WIDTH_MEDIUM"], $arParams["DETAIL_HEIGHT_MEDIUM"], $arParams["DETAIL_WIDTH_BIG"],
					$arParams["DETAIL_HEIGHT_BIG"], $ResizeMode, 'N', [], $arResult['FIRST_COLOR'], $colorXmlID, $arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] );
				if(!$arResult["MORE_PHOTO_JS"][$colorXmlID])
				{
					$arResult["MORE_PHOTO_JS"][$colorXmlID] = $arResult["MORE_PHOTO_JS2"][$arResult['OFFERS'][$j]['ID']];
				}
			}
			else
			{
				$arResult["MORE_PHOTO_JS"][$colorXmlID] = B2BSSotbitShop::GetImagesIfOffers( $arResult['OFFERS'][$j]["PREVIEW_PICTURE"], $arResult['OFFERS'][$j]["DETAIL_PICTURE"], $arResult['OFFERS'][$j]["PROPERTIES"][$arParams["MORE_PHOTO_OFFER_PROPS"]]["VALUE"],
					$arResult['PROPERTIES']['ADD_PICTURES']['VALUE'], $arResult["PREVIEW_PICTURE"], $arResult["DETAIL_PICTURE"], $arParams["DETAIL_WIDTH_SMALL"], $arParams["DETAIL_HEIGHT_SMALL"], $arParams["DETAIL_WIDTH_MEDIUM"], $arParams["DETAIL_HEIGHT_MEDIUM"], $arParams["DETAIL_WIDTH_BIG"],
					$arParams["DETAIL_HEIGHT_BIG"], $ResizeMode, 'N', $arResult["MORE_PHOTO_JS"][$colorXmlID], $arResult['FIRST_COLOR'], $colorXmlID, $arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] );;
			}
	}

	// set first offer if no
	if (! $arResult['FIRST_OFFER'])
	{
		$arResult['FIRST_OFFER'] = $arResult['OFFERS'][0]['ID'];
		$arResult['CAN_BUY_FIRST_OFFER'] = $arResult['OFFERS'][0]['CAN_BUY'];
	}

}
else
{
	// if images in product
	if ($imageFromOffer)
	{


		if(count($arResult['COLOR_OFFER_FROM_IMAGE']) > 0)
		{
			$arResult["MORE_PHOTO_JS2"][$arResult['ID']] = B2BSSotbitShop::GetImagesIfOffers($arResult["PREVIEW_PICTURE"], $arResult["DETAIL_PICTURE"], $arResult["PROPERTIES"][$arParams["MORE_PHOTO_PRODUCT_PROPS"]]["VALUE"], $arResult['PROPERTIES']['ADD_PICTURES']['VALUE'], $arResult["PREVIEW_PICTURE"],
				$arResult["DETAIL_PICTURE"], $arParams["DETAIL_WIDTH_SMALL"], $arParams["DETAIL_HEIGHT_SMALL"],
				$arParams["DETAIL_WIDTH_MEDIUM"], $arParams["DETAIL_HEIGHT_MEDIUM"], $arParams["DETAIL_WIDTH_BIG"], $arParams["DETAIL_HEIGHT_BIG"], $ResizeMode, 'N', [],
				$arResult['FIRST_COLOR'], 0, $arResult['PROPERTIES']['MORE_PHOTO']['VALUE']);
			if(!$arResult["MORE_PHOTO_JS"][0])
			{
				$arResult["MORE_PHOTO_JS"][0] = $arResult["MORE_PHOTO_JS2"][$arResult['ID']];
			}
		}
		else
		{
			$arResult["MORE_PHOTO_JS"][0] = B2BSSotbitShop::GetImagesIfOffers( $arResult["PREVIEW_PICTURE"], $arResult["DETAIL_PICTURE"], $arResult["PROPERTIES"][$arParams["MORE_PHOTO_PRODUCT_PROPS"]]["VALUE"], $arResult['PROPERTIES']['ADD_PICTURES']['VALUE'], $arResult["PREVIEW_PICTURE"],
				$arResult["DETAIL_PICTURE"], $arParams["DETAIL_WIDTH_SMALL"], $arParams["DETAIL_HEIGHT_SMALL"], $arParams["DETAIL_WIDTH_MEDIUM"], $arParams["DETAIL_HEIGHT_MEDIUM"], $arParams["DETAIL_WIDTH_BIG"], $arParams["DETAIL_HEIGHT_BIG"], $ResizeMode, 'N', $arResult["MORE_PHOTO_JS"][0],
				$arResult['FIRST_COLOR'], 0, $arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] );
		}

		$arResult['FIRST_OFFER'] = $arResult['ID'];
		$arResult['FIRST_COLOR'] = 0;
		$arResult["PRICES_JS"][$arResult['ID']]['DISCOUNT_PRICE'] = $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
		$arResult["PRICES_JS"][$arResult['ID']]['OLD_PRICE'] = $arResult['MIN_PRICE']['PRINT_VALUE'];
		$arResult["CAN_BUY_FIRST_OFFER"] = $arResult['CAN_BUY'];
		if ($arResult["CAN_BUY_FIRST_OFFER"])
		{
			$arResult['ADDED_TO_BASKET'][$arResult['ID']] = 0;
			$arResult["OFFER_ADD_URL"][$arResult['ID']] = str_replace( $arParams["PRODUCT_ID_VARIABLE"] . "=", "id=", $arResult["~ADD_URL"] ) . "&ajax_basket=Y";
//			$arResult["OFFER_DELAY_URL"][$arResult['ID']] = str_replace( $arParams["ACTION_VARIABLE"] . "=ADD2BASKET", $arParams["ACTION_VARIABLE"] . "=DELAY", $arResult["OFFER_ADD_URL"][$arResult['ID']] );
//			$arResult["OFFER_DELAY_URL"][$arResult['ID']]= str_replace( 'id=', 's_id=', $arResult["OFFER_DELAY_URL"][$arResult['ID']]);
            $arResult["OFFER_ADD_URL"][$arResult["ID"]] = '/include/ajax/basket_add_product_and_wish.php?ajax_basket=Y&entity=basket&action=add&s_id='.$arResult['ID'].'&props='.implode(',', $arParams['OFFERS_CART_PROPERTIES']);
            $arResult["OFFER_DELAY_URL"][$arResult["ID"]] = '/include/ajax/basket_add_product_and_wish.php?ajax_basket=Y&entity=delay&action=add&s_id='.$arResult['ID'].'&props='.implode(',', $arParams['OFFERS_CART_PROPERTIES']);
		}
		else
		{
			$arResult["OFFER_SUBSCRIBE_URL"][$arResult['ID']] = str_replace( $arParams["PRODUCT_ID_VARIABLE"] . "=", "id=", $arResult["~SUBSCRIBE_URL"] ) . "&ajax_basket=Y";
			$arResult["OFFER_AVAILABLE_ID"][$arResult['ID']] = $arResult['ID'];
		}
	}

	// set microrazmetka
	$arResult['MICRORAZMETKA']['PRICE'] = ( int ) B2BSSotbit::ExpandStringWithMacros( COption::GetOptionString( "sotbit.b2bshop", "MICRO_TOVAR_PRICE", "" ), $arResult );
	$arResult['MICRORAZMETKA']['HIGHPRICE'] = $arResult['MICRORAZMETKA']['PRICE'];
	$arResult['MICRORAZMETKA']['LOWPRICE'] = $arResult['MICRORAZMETKA']['PRICE'];
	$arResult['MICRORAZMETKA']['AGGREGATEOFFER_PRICE'] = array (
			$MicroOffers['PRICE']
	);
}
unset( $arOfferProps );
unset( $arOfferParams );

// color from product
if (! $imageFromOffer)
{
	if ($arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams['COLOR_IN_PRODUCT_CODE'])
	{
		if ($arResult["PROPERTIES"][$colorCode]["VALUE"])
		{
			if (! isset( $HLParams[$colorCode] ))
			{
				$PropArray = B2BSSotbitShop::GetValuesFromHL( $arResult["ITEMS"][$i]['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'], $arResult['CATALOG']['IBLOCK_ID'], $colorCode );
				$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
			}
			$arResult['FIRST_COLOR'] = $arResult["PROPERTIES"][$colorCode]["VALUE"];
			$colorXmlIDs[] = $arResult["PROPERTIES"][$colorCode]["VALUE"];
		}
	}
	else
	{

		if (! isset( $HLParams[$colorCode] ))
		{
			$PropArray = B2BSSotbitShop::GetValuesFromHL( $arResult['PROPERTIES'][$colorCode]['USER_TYPE_SETTINGS']['TABLE_NAME'], $arSKU['IBLOCK_ID'], $colorCode );
			$HLParams[key( $PropArray )] = $PropArray[key( $PropArray )];
		}
	}

	$DetailPhoto = ( $arResult["DETAIL_PICTURE"]) ? $arResult["DETAIL_PICTURE"] : $arResult["PREVIEW_PICTURE"];

	$ImageFromProduct = B2BSSotbitShop::ImagesFromProduct( $DetailPhoto, $arResult["MORE_PHOTO"], $HLParams[$colorCode], $arResult["FIRST_COLOR"], $arParams['COLOR_IN_PRODUCT'], $arParams["COLOR_IN_SECTION_LINK"], 'N', $arParams["DETAIL_WIDTH_SMALL"], $arParams["DETAIL_HEIGHT_SMALL"],
			$arParams["DETAIL_WIDTH_MEDIUM"], $arParams["DETAIL_HEIGHT_MEDIUM"], $arParams["DETAIL_WIDTH_BIG"], $arParams["DETAIL_HEIGHT_BIG"], $ResizeMode, $arParams['OFFER_TREE_PROPS'], $colorCode );
	if ($ImageFromProduct['FIRST_COLOR'])
	{
		$arResult['FIRST_COLOR'] = $ImageFromProduct['FIRST_COLOR'];
	}
	if ($ImageFromProduct['PHOTOS'])
	{
		$arResult["MORE_PHOTO_JS"] = $ImageFromProduct['PHOTOS'];
	}

	foreach ($arResult["MORE_PHOTO_JS"] as $color => $images)
	{
		if($colorXmlIDs && !in_array($color,$colorXmlIDs))
		{
			unset($arResult["MORE_PHOTO_JS"][$color]);
		}
	}

	if(count($arResult["MORE_PHOTO_JS"]) > 0 && !in_array($arResult['FIRST_COLOR'],array_keys($arResult["MORE_PHOTO_JS"])))
	{
		$arResult['FIRST_COLOR'] = reset(array_keys($arResult["MORE_PHOTO_JS"]));
	}


	if(!$arResult['OFFERS']) {
		if ($ImageFromProduct['OFFER_TREE_PROPS'])
		{
			$arResult['OFFER_TREE_PROPS'][$colorCode] = $ImageFromProduct['OFFER_TREE_PROPS'][$colorCode];
		}

		$arResult["PRICES_JS"][$arResult['ID']]['DISCOUNT_PRICE'] = $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
		$arResult["PRICES_JS"][$arResult['ID']]['OLD_PRICE'] = $arResult['MIN_PRICE']['PRINT_VALUE'];
		$arResult["CAN_BUY_FIRST_OFFER"] = $arResult['CAN_BUY'];
		if ($arResult["CAN_BUY_FIRST_OFFER"]) {
			$arResult['ADDED_TO_BASKET'][$arResult['ID']] = 0;
			$arResult["OFFER_ADD_URL"][$arResult['ID']] = str_replace($arParams["PRODUCT_ID_VARIABLE"] . "=", "id=", $arResult["~ADD_URL"]) . "&ajax_basket=Y";
//			$arResult["OFFER_DELAY_URL"][$arResult['ID']] = str_replace($arParams["ACTION_VARIABLE"] . "=ADD2BASKET", $arParams["ACTION_VARIABLE"] . "=DELAY", $arResult["OFFER_ADD_URL"][$arResult['ID']]);
//			$arResult["OFFER_DELAY_URL"][$arResult['ID']] = str_replace('id=', 's_id=', $arResult["OFFER_DELAY_URL"][$arResult['ID']]);
            $arResult["OFFER_ADD_URL"][$arResult["ID"]] = '/include/ajax/basket_add_product_and_wish.php?ajax_basket=Y&entity=basket&action=add&s_id='.$arResult['ID'].'&props='.implode(',', $arParams['OFFERS_CART_PROPERTIES']);
            $arResult["OFFER_DELAY_URL"][$arResult["ID"]] = '/include/ajax/basket_add_product_and_wish.php?ajax_basket=Y&entity=delay&action=add&s_id='.$arResult['ID'].'&props='.implode(',', $arParams['OFFERS_CART_PROPERTIES']);
		} else {
			$arResult["OFFER_SUBSCRIBE_URL"][$arResult['ID']] = str_replace($arParams["PRODUCT_ID_VARIABLE"] . "=", "id=", $arResult["~SUBSCRIBE_URL"]) . "&ajax_basket=Y";
			$arResult["OFFER_AVAILABLE_ID"][$arResult['ID']] = $arResult['ID'];
		}
		if (!$arResult['FIRST_OFFER']) {
			$arResult['FIRST_OFFER'] = $arResult['ID'];
		}
	}
}

// get brand info
$arResult["BRAND"] = B2BSSotbitShop::GetBrandInfo( $arResult["PROPERTIES"][$arParams["MANUFACTURER_ELEMENT_PROPS"]]["VALUE"], $ResizeMode );

// block characteristics
$arResult["DOP_PROPS"] = B2BSSotbitShop::GetCharacteristics( $arResult['IBLOCK_ID'], $arResult['IBLOCK_SECTION_ID'], $arResult['DISPLAY_PROPERTIES'], $arDopProps );
// block main props under offers props
$arResult["MAIN_PROPS"] = B2BSSotbitShop::GetCharacteristics( $arResult['IBLOCK_ID'], $arResult['IBLOCK_SECTION_ID'], $arResult['DISPLAY_PROPERTIES'], $arMainProps );

// Generate microrazmetka
$arResult['MICRORAZMETKA']['COMPONENT_TEMPLATE'] = ".default";
$arResult['MICRORAZMETKA']['NAME'] = B2BSSotbit::ExpandStringWithMacros( \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "MICRO_TOVAR_NAME", "" ), $arResult );
$arResult['MICRORAZMETKA']['DESCRIPTION'] = B2BSSotbit::ExpandStringWithMacros( \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "MICRO_TOVAR_DESCRIPTION", "" ), $arResult );
$arResult['MICRORAZMETKA']['ITEMCONDITION'] = \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "MICRO_TOVAR_ITEM_CONDITION", "" );
$arResult['MICRORAZMETKA']['PARAM_RATING_SHOW'] = "N";
$arResult['MICRORAZMETKA']['PAYMENTMETHOD'] = unserialize( \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "MICRO_TOVAR_PAYMENT_METHOD", "" ) );
$arResult['MICRORAZMETKA']['PRICECURRENCY'] = B2BSSotbit::ExpandStringWithMacros( \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "MICRO_TOVAR_PRICE_CURRENCY", "" ), $arResult );
$arResult['MICRORAZMETKA']['SHOW'] = "Y";
$arResult['MICRORAZMETKA']['AGGREGATEOFFER'] = "Y";
$arResult['MICRORAZMETKA']['ITEMAVAILABILITY'] = \Bitrix\Main\Config\Option::get( "sotbit.b2bshop", "MICRO_TOVAR_ITEM_AVAILABILITY_TRUE", "" );
foreach ( $arResult['MORE_PHOTO_JS'] as $MorePhotoColor => $MorePhoto )
{
	if (isset( $MorePhoto['BIG'] ) && is_array( $MorePhoto['BIG'] ) && count( $MorePhoto['BIG'] ) > 0)
	{
		foreach ( $MorePhoto['BIG'] as $BigPhoto )
		{
			if (isset( $BigPhoto['src'] ) && ! empty( $BigPhoto['src'] ))
				$arResult['MICRORAZMETKA']['IMAGES'][] = $BigPhoto['src'];
		}
	}
}
if (! $arResult['MICRORAZMETKA']['HIGHPRICE'])
	$arResult['MICRORAZMETKA']['HIGHPRICE'] = max( $arResult['MICRORAZMETKA']['AGGREGATEOFFER_PRICE'] );
if (! $arResult['MICRORAZMETKA']['LOWPRICE'])
	$arResult['MICRORAZMETKA']['LOWPRICE'] = min( $arResult['MICRORAZMETKA']['AGGREGATEOFFER_PRICE'] );
$arResult['MICRORAZMETKA']['OFFERCOUNT'] = count( $arResult['MICRORAZMETKA']['AGGREGATEOFFER_PRICE'] );

// check if color not first
if (isset( $arResult["OFFER_TREE_PROPS"] ) && is_array( $arResult["OFFER_TREE_PROPS"] ) && ! empty( $colorCode ))
{
	if (key( $arResult["OFFER_TREE_PROPS"] ) != $colorCode)
	{
		$Tmp[$colorCode] = $arResult["OFFER_TREE_PROPS"][$colorCode];
		unset( $arResult["OFFER_TREE_PROPS"][$colorCode] );
		$arResult["OFFER_TREE_PROPS"] = array_merge( $Tmp, $arResult["OFFER_TREE_PROPS"] );
		unset( $Tmp );
	}
}

// video
$arResult["VIDEO"] = B2BSSotbitShop::GetVideo( $arResult['PROPERTIES']['VIDEO']['VALUE'] );

// link color
if ($arParams['COLOR_IN_PRODUCT'] == 'Y' && $arResult["PROPERTIES"][$arParams["COLOR_IN_PRODUCT_LINK"]]["VALUE"])
{
	$arModelsLinks = array (
			$arResult['ID'] => $arResult["PROPERTIES"][$arParams["COLOR_IN_PRODUCT_LINK"]]["VALUE"]
	);
	if (sizeof( $arModelsLinks ) > 0)
	{
		$ColorLink2 = B2BSSotbitShop::ColorLink2( $arModelsLinks, $arParams["COLOR_IN_PRODUCT_LINK"], $arParams['COLOR_IN_PRODUCT_CODE'], $colorCode, $arParams["ELEMENT_WIDTH_SMALL"], $arParams["ELEMENT_HEIGHT_SMALL"], 0, 0, $ResizeMode,$arParams['IBLOCK_ID'] );

		if ($ColorLink2['PHOTOS'][$arResult['ID']] )
		{
			foreach ( $ColorLink2['PHOTOS'][$arResult['ID']] as $Color => $ColorPhotos )
			{
				if (! isset( $arResult["MORE_PHOTO_JS"][$Color] ))
				{

					$arResult["MORE_PHOTO_JS"][$Color] = $ColorPhotos;
				}
			}
		}
		if (isset( $ColorLink2['URLS'] ))
		{
			$arResult['COLORS_URLS'] = $ColorLink2['URLS'];
		}

		if($ColorLink2['COLORS'][$arResult['ID']])
		{
			foreach($ColorLink2['COLORS'][$arResult['ID']] as $color)
			{
				if($HLParams[$colorCode][$color])
				{
					$arResult["OFFER_TREE_PROPS"][$colorCode][$color] = $HLParams[$colorCode][$color];
				}

				foreach($arResult['OFFERS'] as $offer)
				{
					$arResult["OFFERS_ID"][$colorCode][$color][$offer["ID"]] = 1;
					$arResult["CAN_BUY_OFFERS_ID"][$colorCode][$color][$offer["ID"]] = 1;
				}
			}
		}

		if($arResult['OFFERS'])
		{
		}
		else
		{
			$arResult['FIRST_OFFER'] = $arResult['ID'];
		}
	}
}





$SortPropertyTree = B2BSSotbitShop::SortPropertyTree( $arResult["OFFER_TREE_PROPS"], $colorCode, $arResult['FIRST_OFFER'], $arResult["OFFERS_ID"], $arResult["CAN_BUY_OFFERS_ID"] );

$arResult["OFFER_TREE_PROPS"] = $SortPropertyTree['PROPERTIES'];
$arResult['FIRST_OFFER'] = $SortPropertyTree['FIRST_OFFER'];
unset( $SortPropertyTree );

$arResult['LI'] = B2BSSotbitShop::GenerateLiClasses( $arResult["OFFER_TREE_PROPS"], $arResult['OFFERS_ID'], $arResult['CAN_BUY_OFFERS_ID'], $arResult['FIRST_OFFER'] );

// Modification
$arResult['MODIFICATION'] = B2BSSotbitShop::GetModifications( $arResult['CAN_BUY_OFFERS_ID'], $colorCode, $arResult['MIN_PRICE']['CURRENCY'], $arParams["MODIFICATION_COUNT"] );

if(!$arResult['FIRST_OFFER'])
{
	if($arResult['OFFERS'][0]['ID'])
	{
		$arResult['FIRST_OFFER'] = $arResult['OFFERS'][0]['ID'];
	}
	else
	{
		$arResult['FIRST_OFFER'] = $arResult['ID'];
	}
}

if(!$arResult['FIRST_COLOR'])
{
	$arResult['FIRST_COLOR'] = reset(array_keys($arResult["MORE_PHOTO_JS"]));
}

$arResult['MODAL_DATA'] = array(
		'basket_url' => Option::get('sotbit.b2bshop','URL_CART','/personal/cart/'),
		'add_wish' => 'Y',
);
$arResult['MODAL_DATA'] = Json::encode($arResult['MODAL_DATA']);

if($arResult["OFFERS_ID"][$colorCode])
{
	foreach($arResult["OFFERS_ID"][$colorCode] as $color => $offer)
	{
		if(in_array($arResult['FIRST_OFFER'],$offer) && $color != $arResult['FIRST_COLOR'])
		{
			$arResult['FIRST_COLOR'] = $color;
			break;
		}
	}
}
if($arResult['MICRORAZMETKA']['OFFERCOUNT'] == 0)
{
	if(!$arResult['MICRORAZMETKA']['LOWPRICE'])
		$arResult['MICRORAZMETKA']['LOWPRICE'] = 1;
	if(!$arResult['MICRORAZMETKA']['HIGHPRICE'])
		$arResult['MICRORAZMETKA']['HIGHPRICE'] = 1;
}

if(\Bitrix\Main\Loader::includeModule("sotbit.b2bshop"))
{
	$Og = new Sotbit\B2BShop\Seo\Og();
	$Og->getImage($arResult["MORE_PHOTO_JS"]);
	$Og->setField('og:description', str_replace('"','\'',$arResult["~PREVIEW_TEXT"]?$arResult["~PREVIEW_TEXT"]:$arResult["~DETAIL_TEXT"]));
	$arResult['OG'] = $Og;
}


$arResult["RAND"] = $this->randString();
$this->__component->arResultCacheKeys = array_merge( $this->__component->arResultCacheKeys, array (
		'DETAIL_PAGE_URL',
		"PREVIEW_PICTURE",
		"DETAIL_PICTURE",
		"~DETAIL_TEXT",
		"~PREVIEW_TEXT",
		'OG',
) );
?>