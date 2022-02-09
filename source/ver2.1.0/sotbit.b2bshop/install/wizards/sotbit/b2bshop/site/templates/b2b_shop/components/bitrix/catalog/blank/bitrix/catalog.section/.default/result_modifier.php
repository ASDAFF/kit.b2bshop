<?
if (! defined ( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true)
	die ();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */



if(Bitrix\Main\Loader::includeModule("sotbit.price"))
{
	$arResult = SotbitPrice::ChangeMinPrice($arResult);
}
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
$n = 0;
$k = 0;

$arResult['MODIFICATION_PROPS'] = array();
$arResult['ARTICLES'] = array();

$cur = 'RUB';
$lists = array();
$listsEl = array();
for($i = 0; $i < $cntItems; ++ $i)
{
	$IdItem = $arResult["ITEMS"][$i]['ID'];

	if($arResult["ITEMS"][$i]['MIN_PRICE']['CURRENCY'])
	{
		$cur = $arResult["ITEMS"][$i]['MIN_PRICE']['CURRENCY'];
	}

	$arResult["ITEMS"][$i]['COUNTER']=$i;
	$arResult["ITEMS"][$i]['COLOR_CODE']=$colorCode;

	$arBrandIblock = $arResult["ITEMS"][$i]["PROPERTIES"][$arParams["MANUFACTURER_ELEMENT_PROPS"]]["LINK_IBLOCK_ID"];

	// need for color link 2
	if ($arParams['COLOR_IN_PRODUCT'] && $arParams["COLOR_IN_SECTION_LINK"] == 2)
	{
		$arModelsLinks[$IdItem] = $arResult["ITEMS"][$i]["PROPERTIES"][$arParams["COLOR_IN_PRODUCT_LINK"]]["VALUE"];
	}
	// Get brands info
	if ($arResult["ITEMS"][$i]["PROPERTIES"][$brandCode]["VALUE"])
	{
		$IblockBrands = $arResult["ITEMS"][$i]["PROPERTIES"][$brandCode]["LINK_IBLOCK_ID"];
		$arBrandID[] = $arResult["ITEMS"][$i]["PROPERTIES"][$arParams["MANUFACTURER_ELEMENT_PROPS"]]["VALUE"];
	}

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
			$arResult["ITEMS"][$i]["OFFER_TREE_PROPS"][$colorCode] = $HLParams[$colorCode];
		}
	}



	if ($arParams['OFFER_TREE_PROPS'])
	{
		for($k = 0; $k < sizeof ( $arParams['OFFER_TREE_PROPS'] ); ++ $k)
		{
			foreach($arResult["ITEMS"][$i]["PROPERTIES"] as $code => $prop)
			{
				if($prop['ID'] == $arParams['OFFER_TREE_PROPS'][$k])
				{
					if($prop['PROPERTY_TYPE'] == 'E' )
					{
						$lists[] = $prop['VALUE'];
						$listsEl[$IdItem][$prop['ID']] = $prop['VALUE'];
					}

					if ($prop['VALUE'] && $prop["USER_TYPE"] == 'directory')
					{
						if (! isset ( $HLParams[$arParams['OFFER_TREE_PROPS'][$k]] ))
						{
							$PropArray = B2BSSotbitShop::GetValuesFromHL (
									$prop['USER_TYPE_SETTINGS']['TABLE_NAME'],
									$arResult['CATALOG']['IBLOCK_ID'],
									$arParams['OFFER_TREE_PROPS'][$k]
									);
							$HLParams[key ( $PropArray )] = $PropArray[key ( $PropArray )];
							unset ( $PropArray );
						}
						$arResult["ITEMS"][$i]["OFFER_TREE_PROPS"][$arParams['OFFER_TREE_PROPS'][$k]][$prop['VALUE']] = $HLParams[$arParams['OFFER_TREE_PROPS'][$k]][$prop['VALUE']];
					}
				}
			}
		}
	}

	if ($arResult["ITEMS"][$i]['OFFERS'])
	{
		$articles = array();
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


				if(!$offerArticulProp)
				{
					foreach($arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"] as $code => $prop)
					{
						if($prop['ID'] == $arParams['OPT_ARTICUL_PROPERTY_OFFER'])
						{
							$offerArticulProp = $code;
							break;
						}
					}
				}


				$articles[$arResult["ITEMS"][$i]['OFFERS'][$j]['ID']] = 0;

				if($arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$offerArticulProp]['VALUE'])
				{
					$articles[$arResult["ITEMS"][$i]['OFFERS'][$j]['ID']] = 1;
					$arResult['ARTICLES'][$arResult["ITEMS"][$i]['OFFERS'][$j]['ID']] = $arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$offerArticulProp]['VALUE'];
				}



				if($arResult["ITEMS"][$i]['OFFERS'][$j]['MIN_PRICE']['CURRENCY'])
				{
					$cur = $arResult["ITEMS"][$i]['OFFERS'][$j]['MIN_PRICE']['CURRENCY'];
				}


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



				if ($arResult["ITEMS"][$i]['OFFERS'][$j]["CAN_BUY"])
				{
					$arResult["OFFER_ADD_URL"][$arResult["ITEMS"][$i]['OFFERS'][$j]["ID"]] = str_replace( $arParams["PRODUCT_ID_VARIABLE"] . "=", "id=", $arResult["ITEMS"][$i]['OFFERS'][$j]["~ADD_URL"] ) . "&ajax_basket=Y";
				}


			// set min price from offers


			$arResult["ITEMS"][$i]['MIN_PRICE'] = B2BSSotbitShop::GetMinPrice ( $arResult["ITEMS"][$i]['MIN_PRICE'], $arResult["ITEMS"][$i]['OFFERS'][$j]["MIN_PRICE"] );
			// available properties
			if ($arParams['OFFER_TREE_PROPS'])
			{
				for($k = 0; $k < sizeof ( $arParams['OFFER_TREE_PROPS'] ); ++ $k)
				{
					foreach($arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"] as $code => $prop)
					{
						if($prop['ID'] == $arParams['OFFER_TREE_PROPS'][$k])
						{
							if($prop['PROPERTY_TYPE'] == 'E' )
							{
								$lists[] = $prop['VALUE'];
								$listsEl[$IdItem][$prop['ID']] = $prop['VALUE'];
							}

							if ($prop['VALUE'] && $prop["USER_TYPE"] == 'directory')
							{
								if (! isset ( $HLParams[$arParams['OFFER_TREE_PROPS'][$k]] ))
								{
									$PropArray = B2BSSotbitShop::GetValuesFromHL (
											$prop['USER_TYPE_SETTINGS']['TABLE_NAME'],
											$arResult['CATALOG']['IBLOCK_ID'],
											$arParams['OFFER_TREE_PROPS'][$k]
											);
									$HLParams[key ( $PropArray )] = $PropArray[key ( $PropArray )];
									unset ( $PropArray );
								}
								$arResult["ITEMS"][$i]["OFFER_TREE_PROPS"][$arParams['OFFER_TREE_PROPS'][$k]][$prop['VALUE']] = $HLParams[$arParams['OFFER_TREE_PROPS'][$k]][$prop['VALUE']];
								$arResult["ITEMS"][$i]["OFFER_TREE_PROPS_VALUE"][$arParams['OFFER_TREE_PROPS'][$k]][$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']] = $HLParams[$arParams['OFFER_TREE_PROPS'][$k]][$arResult["ITEMS"][$i]['OFFERS'][$j]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']]['UF_NAME'];
								// name of property
								$arResult["PROP_NAME"][$arParams['OFFER_TREE_PROPS'][$k]] = $arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$arParams['OFFER_TREE_PROPS'][$k]]['NAME'];
							}
							if ($arResult["ITEMS"][$i]['OFFERS'][$j]["CAN_BUY"])
							{
								if(!in_array($arParams['OFFER_TREE_PROPS'][$k],$arResult['MODIFICATION_PROPS']))
								{
									$arResult['MODIFICATION_PROPS'][$arParams['OFFER_TREE_PROPS'][$k]] = $prop['NAME'];
								}
							}
						}

					}
				}
				unset ( $k );
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
			/*$arResult["MORE_PHOTO_JS"][$IdItem][$colorXmlID] = B2BSSotbitShop::GetImagesIfOffers (
					$arResult["ITEMS"][$i]['OFFERS'][$j]["PREVIEW_PICTURE"],
					$arResult["ITEMS"][$i]['OFFERS'][$j]["DETAIL_PICTURE"],
					$arResult["ITEMS"][$i]['OFFERS'][$j]["PROPERTIES"][$arParams["MORE_PHOTO_OFFER_PROPS"]]["VALUE"],
					$arResult["ITEMS"][$i]['PROPERTIES']['ADD_PICTURES']['VALUE'],
					$arResult["ITEMS"][$i]["PREVIEW_PICTURE"],
					$arResult["ITEMS"][$i]["DETAIL_PICTURE"],
					$arParams["LIST_WIDTH_SMALL"],
					$arParams["LIST_HEIGHT_SMALL"],
					$arParams["LIST_WIDTH_MEDIUM"],
					$arParams["LIST_HEIGHT_MEDIUM"],
					0,
					0,
					$ResizeMode,
					$arParams['AJAX_PRODUCT_LOAD'],
					$arResult["MORE_PHOTO_JS"][$IdItem][$colorXmlID],
					$arResult["ITEMS"][$i]['FIRST_COLOR'],
					$colorXmlID,
					$arResult["ITEMS"][$i]['PROPERTIES']['MORE_PHOTO']['VALUE']
					);*/
		}
		if($articles && !array_search(1,$articles))
		{
			if(!$prodArticulProp)
			{
				foreach($arResult["ITEMS"][$i]["PROPERTIES"] as $code => $prop)
				{
					if($prop['ID'] == $arParams['OPT_ARTICUL_PROPERTY'])
					{
						$prodArticulProp = $code;
						break;
					}
				}
			}

			if($arResult["ITEMS"][$i]["PROPERTIES"][$prodArticulProp]['VALUE'])
			{
				$arResult['ARTICLES'][key($articles)] = $arResult["ITEMS"][$i]["PROPERTIES"][$prodArticulProp]['VALUE'];
			}
		}
		unset ( $j );
	}
	// if not offers
	else
	{
		for($k = 0; $k < sizeof ( $arParams['OFFER_TREE_PROPS'] ); ++ $k)
		{
			if ($arResult["ITEMS"][$i]["CAN_BUY"])
			{
				if(!in_array($arParams['OFFER_TREE_PROPS'][$k],$arResult['MODIFICATION_PROPS']))
				{
					foreach($arResult["ITEMS"][$i]["PROPERTIES"] as $prop)
					{
						if($prop['ID'] == $arParams['OFFER_TREE_PROPS'][$k])
						{
							if($prop['PROPERTY_TYPE'] == 'E' )
							{
								$lists[] = $prop['VALUE'];
								$listsEl[$IdItem][$prop['ID']] = $prop['VALUE'];
							}

							$arResult['MODIFICATION_PROPS'] = array($arParams['OFFER_TREE_PROPS'][$k] => $prop['NAME']) + $arResult['MODIFICATION_PROPS'];
						}
					}

					//$arResult['MODIFICATION_PROPS'][$arParams['OFFER_TREE_PROPS'][$k]] = $arResult["ITEMS"][$i]["PROPERTIES"][$arParams['OFFER_TREE_PROPS'][$k]]['NAME'];
				}
				if($arResult["ITEMS"][$i]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]])
				{
					$arResult["CAN_BUY_OFFERS_ID"][$arResult["ITEMS"][$i]['ID']][$arParams['OFFER_TREE_PROPS'][$k]][$arResult["ITEMS"][$i]['PROPERTIES'][$arParams['OFFER_TREE_PROPS'][$k]]['VALUE']][$arResult["ITEMS"][$i]["ID"]] = $arResult["ITEMS"][$i]["ID"];
				}
			}
		}
		// if images in product
		if ($imageFromOffer)
		{
			/*$arResult["MORE_PHOTO_JS"][$IdItem][0] = B2BSSotbitShop::GetImagesIfOffers (
					$arResult["ITEMS"][$i]["PREVIEW_PICTURE"],
					$arResult["ITEMS"][$i]["DETAIL_PICTURE"],
					$arResult["ITEMS"][$i]['PROPERTIES']['ADD_PICTURES']['VALUE'],
					$arResult["ITEMS"][$i]["PROPERTIES"][$arParams["MORE_PHOTO_PRODUCT_PROPS"]]["VALUE"],
					$arResult["ITEMS"][$i]["PREVIEW_PICTURE"],
					$arResult["ITEMS"][$i]["DETAIL_PICTURE"],
					$arParams["LIST_WIDTH_SMALL"],
					$arParams["LIST_HEIGHT_SMALL"],
					$arParams["LIST_WIDTH_MEDIUM"],
					$arParams["LIST_HEIGHT_MEDIUM"],
					0,
					0,
					$ResizeMode,
					$arParams['AJAX_PRODUCT_LOAD'],
					$arResult["MORE_PHOTO_JS"][$IdItem][0],
					$arResult["ITEMS"][$i]['FIRST_COLOR'],
					0,
					$arResult["ITEMS"][$i]['PROPERTIES']['MORE_PHOTO']['VALUE']);*/
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
		if($ImageFromProduct['OFFER_TREE_PROPS'] && $arResult["ITEMS"][$i]['CAN_BUY'] == 'Y')
		{
			$arResult["ITEMS"][$i]['OFFER_TREE_PROPS'][$colorCode]=$ImageFromProduct['OFFER_TREE_PROPS'][$colorCode];
		}
	}

	// if one color do some colors
	/*if (sizeof ( $arResult["MORE_PHOTO_JS"][$IdItem] ) == 1 && $arParams['COLOR_IN_PRODUCT'] != 'Y')
	{
		$arResult["MORE_PHOTO_JS"][$IdItem] = B2BSSotbitShop::reOneColor ( $arResult["MORE_PHOTO_JS"][$IdItem], $arParams["LIST_WIDTH_SMALL"], $arParams["LIST_HEIGHT_SMALL"], $arParams["LIST_WIDTH_MEDIUM"], $ResizeMode );
	}*/

	// fancy for quick view
	$arResult["FANCY"][$i]["ID"] = $IdItem;
	$arResult["FANCY"][$i]["DETAIL_PAGE_URL"] = $arResult["ITEMS"][$i]["DETAIL_PAGE_URL"];

	// set if not first color
	if (! isset ( $arResult["ITEMS"][$i]["FIRST_COLOR"] ) && $arResult["MORE_PHOTO_JS"][$IdItem])
	{
		$arResult["ITEMS"][$i]["FIRST_COLOR"] = reset ( array_keys ( $arResult["MORE_PHOTO_JS"][$IdItem] ) );
	}

	//first color up of small images
	if($arResult["MORE_PHOTO_JS"][$IdItem])
	{
		if($arResult["ITEMS"][$i]["FIRST_COLOR"]!=reset ( array_keys ( $arResult["MORE_PHOTO_JS"][$IdItem] ) ))
		{
			$Tmp[$arResult["ITEMS"][$i]["FIRST_COLOR"]]=$arResult["MORE_PHOTO_JS"][$IdItem][$arResult["ITEMS"][$i]["FIRST_COLOR"]];
			$Tmp=array_merge($Tmp,$arResult["MORE_PHOTO_JS"][$IdItem]);
			$arResult["MORE_PHOTO_JS"][$IdItem]=$Tmp;
			unset($Tmp);
		}
	}

	$SortPropertyTree = B2BSSotbitShop::SortPropertyTree( $arResult["ITEMS"][$i]["OFFER_TREE_PROPS_VALUE"], $colorCode, '', array(), array());
	$arResult["ITEMS"][$i]["OFFER_TREE_PROPS_VALUE"] = $SortPropertyTree['PROPERTIES'];
	unset( $SortPropertyTree );

	// add item to row
	$arResult["BLOCK_ITEMS"][$n][] = $arResult["ITEMS"][$i];
	if (($i + 1) % $arParams['PAGE_ELEMENT_COUNT_IN_ROW'] == 0)
		$n ++;
}
unset ( $cntItems );
unset ( $IdItem );
unset ( $i );
unset ( $n );

// Get brands names

$arResult["BRANDS"] = B2BSSotbitShop::GetBrandsNames (  $arBrandID, $arBrandIblock );

unset ( $arBrandID );
unset ( $arBrandIblock );

$arResult["RAND"] = $this->randString ();

// color link 2
if ($arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams["COLOR_IN_SECTION_LINK"] == 2 && $arParams["COLOR_IN_PRODUCT_LINK"])
{
	// del empty values
	$arIds = array ();
	$arModelsLinks = array_diff ( $arModelsLinks, array (
			''
	) );
	if (sizeof ( $arModelsLinks ) > 0)
	{
		$ColorLink2 = B2BSSotbitShop::ColorLink2($arModelsLinks,$arParams["COLOR_IN_PRODUCT_LINK"],$arParams['COLOR_IN_PRODUCT_CODE'],$colorCode,$arParams["LIST_WIDTH_SMALL"],$arParams["LIST_HEIGHT_MEDIUM"],$arParams["LIST_WIDTH_MEDIUM"],$arParams["LIST_HEIGHT_MEDIUM"],$ResizeMode);

		if($ColorLink2['PHOTOS'][$Product])
		{
			foreach($arResult["MORE_PHOTO_JS"] as $Product=>$Photos)
			{
				$arResult["MORE_PHOTO_JS"][$Product]=array_merge($arResult["MORE_PHOTO_JS"][$Product],$ColorLink2['PHOTOS'][$Product]);
			}
		}

		foreach ( $arResult["BLOCK_ITEMS"] as $key => $arBlockItem )
		{
			foreach ( $arBlockItem as $key2 => $arItem )
			{
				foreach ( $ColorLink2['COLORS'][$arItem['ID']] as $i => $ColorCodeItem )
				{
					$arResult["BLOCK_ITEMS"][$key][$key2]["OFFER_TREE_PROPS"][$colorCode][$ColorCodeItem] = $HLParams[$colorCode][$ColorCodeItem];
				}
			}
		}
	}
}

unset( $arResult["ITEMS"] );

if($lists)
{
	$result = \Bitrix\Iblock\ElementTable::getList(array(
		'select' => array('ID','NAME'),
		'filter' => array('ID' => $lists)
	));
	while ($Element = $result->fetch())
	{
		foreach ( $arResult["BLOCK_ITEMS"] as $key => $arBlockItem )
		{
			foreach ( $arBlockItem as $key2 => $arItem )
			{
				if($listsEl[$arItem['ID']])
				{
					foreach($listsEl[$arItem['ID']] as $propId => $propVal)
					{
						if($propVal == $Element['ID'])
						{
							$arResult["BLOCK_ITEMS"][$key][$key2]["OFFER_TREE_PROPS"][$propId][$propVal]['UF_NAME'] = $Element['NAME'];
						}
					}
				}
			}
		}
	}
}

global ${$arParams['FILTER_NAME']};
$filter = ${$arParams['FILTER_NAME']};

if($filter)
{
	$filterKeys = array_keys($filter);
	foreach ( $arResult["BLOCK_ITEMS"] as $key => $arBlockItem )
	{
		foreach ( $arBlockItem as $key2 => $arItem )
		{
			foreach($arItem['OFFERS'] as $j=>$offer)
			{
				foreach($filterKeys as $filterKey)
				{
					if($filterKey == 'OFFERS')
					{
						foreach ($arItem['OFFERS'][$j]["PROPERTIES"] as $code => $prop)
						{
							if($filter['OFFERS']['=PROPERTY_' . $prop['ID']])
							{
								if(!in_array($prop['VALUE'], $filter['OFFERS']['=PROPERTY_' . $prop['ID']]))
								{
									unset($arResult["BLOCK_ITEMS"][$key][$key2]['OFFERS'][$j]);
								}
							}
						}
					}
				}
			}
		}
	}
}

$cur = CCurrencyLang::GetByID($cur, LANGUAGE_ID );

if(!$cur['FORMAT_STRING'])
{
	$cur = CCurrencyLang::GetByID('RUB', LANGUAGE_ID );
}
$arResult['MODIFICATION_CURRENCY'] = str_replace( '#', '', $cur['FORMAT_STRING'] );


if(!is_array($arResult['BLANK_IDS']))
{
	$arResult['BLANK_IDS'] = array();
}



$this->__component->arResultCacheKeys = array_merge ( $this->__component->arResultCacheKeys, array (
		'FANCY',
		'RAND',
		'BLOCK_ITEMS',
		'MODIFICATION_PROPS',
		'MODIFICATION_CURRENCY',
		'NAV_RESULT',
		'PRICE_NAME',
		'ARTICLES'
) );
?>