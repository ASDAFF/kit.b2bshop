<?
use Bitrix\Main\Localization\Loc;
Loc::loadMessages( __FILE__ );
class B2BSKitShop
{
	public function GetValuesFromHL($Table = '', $IblockId = 0, $Code = '')
	{
		$return = array ();
		if (! $Table && $IblockId > 0 && $Code) // need find table
		{
			$Filter = Array (
					"ACTIVE" => "Y",
					'IBLOCK_ID' => $IblockId
					);
			if (is_int( $Code ))
			{
				$Filter['ID'] = $Code;
			}
			else
			{
				$Filter['CODE'] = $Code;
			}
			// Get table name
			$arProp = CIBlockProperty::GetList( Array (
					"sort" => "asc",
					"name" => "asc"
					), $Filter )->fetch();
					unset( $Filter );
					// if not HL continue
					if (isset( $arProp['USER_TYPE'] ) && $arProp['USER_TYPE'] == 'directory' && isset( $arProp["USER_TYPE_SETTINGS"]["TABLE_NAME"] ))
					{
						$Table = $arProp["USER_TYPE_SETTINGS"]["TABLE_NAME"];
					}
					unset( $arProp );
		}
		if ($Table)
		{
			if(is_array($Table))
			{
				$filter = array_values($Table);
			}
			else
			{
				$filter = $Table;
			}
			$HL = \Bitrix\Highloadblock\HighloadBlockTable::getList( array (
					"filter" => array (
							'TABLE_NAME' => $filter
					)
			) );
			while ( $HLBlock = $HL->Fetch() )
			{
				$CODE = $Code;
				if(is_array($Table))
				{
					foreach($Table as $TableCode=>$TableParams)
					{
						if($TableParams == $HLBlock['TABLE_NAME'])
						{
							$CODE = $TableCode;
							break;
						}
					}
				}
				$HLEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity( $HLBlock )->getDataClass();
				$HLProps = $HLEntity::getList( array (
						'select' => array (
								'*'
						),
						'order' => array ()
				) );
				while ( $HLProp = $HLProps->fetch() )
				{
					$return[$CODE][$HLProp['UF_XML_ID']]['UF_NAME'] = $HLProp['UF_NAME'];
					$return[$CODE][$HLProp['UF_XML_ID']]['UF_XML_ID'] = $HLProp['UF_XML_ID'];
					$return[$CODE][$HLProp['UF_XML_ID']]['UF_DESCRIPTION'] = $HLProp['UF_DESCRIPTION'];
					if ($HLProp["UF_FILE"])
					{
						$return[$CODE][$HLProp['UF_XML_ID']]['PIC'] = CFile::GetFileArray( $HLProp["UF_FILE"] );
					}
				}
				unset( $HLProps );
				unset( $HLProp );
				unset( $HLEntity );
			}

			unset( $HL );
		}
		unset( $cntProps );
		return $return;
	}
	public function GetMinPrice($OldPrice = array(), $Price = array())
	{
		$return = 0;
		if (! $OldPrice["VALUE"] || ($Price["VALUE"] && (($OldPrice["VALUE"] > $Price["VALUE"])or($OldPrice["DISCOUNT_VALUE"] > $Price["DISCOUNT_VALUE"]))))
		{
			// if some offers price add from
			if ($OldPrice["VALUE"])
			{
				$return = $Price;
				$return["PRINT_VALUE"] = Loc::getMessage( "B2BS_CATALOG_FROM_PRICE" ) . $Price["PRINT_VALUE"];
			}
			else
			{
				$return = $Price;
			}
		}
		else
		{
			if (! $OldPrice["VALUE"])
			{
				$return = $Price;
			}
			else
			{
				$return = $OldPrice;
			}
		}
		unset( $OldPrice );
		unset( $Price );
		return $return;
	}
	public function GetBrandsNames($arBrandID = array(), $arBrandIblock = 0)
	{
		$return = array ();
		if ($arBrandID && is_array( $arBrandID ) && sizeof( $arBrandID ) > 0 && $arBrandIblock)
		{
			$rsBrand = CIBlockElement::GetList( Array (), array (
					"IBLOCK_ID" => $arBrandIblock,
					"ID" => $arBrandID
			), false, false, array (
					"ID",
					"IBLOCK_ID",
					"NAME",
					"DETAIL_PAGE_URL"
			) );
			while ( $arBrand = $rsBrand->GetNext() )
			{
				$return[$arBrand["ID"]] = $arBrand;
			}
		}
		return $return;
	}
	public function reOneColor($Images = array(), $SmallWidth, $SmallHeight, $MediumWidth, $ResizeMode)
	{
		$return = array ();
		$key = key( $Images );
		$cnt = sizeof( $Images[$key]['MEDIUM'] );
		if ($cnt > 1)
		{
			for($j = 1; $j < $cnt; ++ $j)
			{
				if (isset( $Images[$key]['MEDIUM'][$j]['src'] )) // if not ajax
				{
					$FileName = basename( $Images[$key]['MEDIUM'][$j]['src'] );
					$arFileName = explode( '.', $FileName );
					preg_match( "/resize_cache\/(.*)\/" . $MediumWidth . "/", $Images[$key]['MEDIUM'][$j]['src'], $SubDir );

					if (end( $arFileName ) == 'jpg' || end( $arFileName ) == 'jpeg')
					{
						$MymeType = 'image/jpeg';
					}
					elseif (end( $arFileName ) == 'png')
					{
						$MymeType = 'image/png';
					}
					elseif (end( $arFileName ) == 'gif')
					{
						$MymeType = 'image/gif';
					}
					$Image = array (
							'FILE_NAME' => $FileName,
							'SUBDIR' => $SubDir[1],
							'WIDTH' => $Images[$key]['MEDIUM'][$j]['width'],
							'HEIGHT' => $Images[$key]['MEDIUM'][$j]['height'],
							'CONTENT_TYPE' => $MymeType
					);

					$Images[$key . $j]['SMALL'][0] = CFile::ResizeImageGet( $Image, array (
							'width' => $SmallWidth,
							'height' => $SmallHeight
					), $ResizeMode, true );
				}
				else // if ajax
				{
					$Images[$key . $j]['SMALL'][0] = $Images[$key]['MEDIUM'][$j];
				}
				$Images[$key . $j]['MEDIUM'][0] = $Images[$key]['MEDIUM'][$j];
				unset( $arFileName );
				unset( $FileName );
				unset( $MymeType );
				unset( $Image );
				unset( $Images[$key]['SMALL'][$j] );
				unset( $Images[$key]['MEDIUM'][$j] );
			}
		}
		$return = $Images;
		unset( $SmallWidth );
		unset( $SmallHeight );
		unset( $MediumWidth );
		unset( $ResizeMode );
		unset( $Images );
		unset( $j );
		unset( $key );
		unset( $cnt );

		return $return;
	}
	public function GetImagesIfOffers($OfferPreviewPicture, $OfferDetailPicture, $OfferMorePhoto, $AddPictures = array(), $ItemPreviewPicture, $ItemDetailPicture, $SmallWidth, $SmallHeight, $MediumWidth, $MediumHeight, $BigWidth, $BigHeight, $ResizeMode, $ajax, $IssetArray = array(), $FirstColor, $colorXmlID)
	{
		$return = $IssetArray;
		$BeforeArr = $IssetArray;

		// get if image in more_photos and in anons
		if ($OfferMorePhoto && ($OfferPreviewPicture || $OfferDetailPicture) && (! isset( $IssetArray['SMALL'] ) || $colorXmlID === 0 ))
		{
			$arImg = $OfferDetailPicture ? $OfferDetailPicture : $OfferPreviewPicture;
			if (sizeof( $return["SMALL"] ) == 0 || $BigWidth > 0) {
				if ($ajax != "Y")
				{
					$return["SMALL"][] = CFile::ResizeImageGet( $arImg, array (
						'width' => $SmallWidth,
						'height' => $SmallHeight
					), $ResizeMode, true );
				}
				else
				{
					$return["SMALL"][] = $arImg;
				}
			}

			if ($MediumWidth && $MediumHeight)
			{
				if ($ajax != "Y" || $colorXmlID == $FirstColor)
				{
					$return["MEDIUM"][] = CFile::ResizeImageGet( $arImg, array (
						'width' => $MediumWidth,
						'height' => $MediumHeight
					), $ResizeMode, true );
				}
				else
				{
					$return["MEDIUM"][] = $arImg;
				}
			}
			if ($BigWidth && $BigHeight)
			{
				$return["BIG"][] = CFile::ResizeImageGet( $arImg, array (
					'width' => $BigWidth,
					'height' => $BigHeight
				), $ResizeMode, true );
			}



			for($k = 0; $k < sizeof( $OfferMorePhoto ); ++ $k)
			{
				if (sizeof( $return["SMALL"] ) == 0 || $BigWidth > 0) // big if detail
				{
					if ($ajax != "Y")
					{
						$return["SMALL"][] = CFile::ResizeImageGet( $OfferMorePhoto[$k], array (
							'width' => $SmallWidth,
							'height' => $SmallHeight
						), $ResizeMode, true );
					}
					else
					{
						$return["SMALL"][] = $OfferMorePhoto[$k];
					}
				}
				if ($MediumWidth && $MediumHeight)
				{
					if ($ajax != "Y" || ($colorXmlID == $FirstColor && ! $IssetArray && $k == 0))
					{
						$return["MEDIUM"][] = CFile::ResizeImageGet( $OfferMorePhoto[$k], array (
							'width' => $MediumWidth,
							'height' => $MediumHeight
						), $ResizeMode, true );
					}
					else
					{
						$return["MEDIUM"][] = $OfferMorePhoto[$k];
					}
				}
				if ($BigWidth && $BigHeight)
				{
					$return["BIG"][] = CFile::ResizeImageGet( $OfferMorePhoto[$k], array (
						'width' => $BigWidth,
						'height' => $BigHeight
					), $ResizeMode, true );
				}
			}
			$IssetArray = $return;
			unset( $arImg );
			unset( $k );
		}

		if (($OfferPreviewPicture || $OfferDetailPicture) && ! $IssetArray)
		{
			$arImg = $OfferDetailPicture ? $OfferDetailPicture : $OfferPreviewPicture;
			if ($ajax != "Y")
			{
				$return["SMALL"][] = CFile::ResizeImageGet( $arImg, array (
						'width' => $SmallWidth,
						'height' => $SmallHeight
				), $ResizeMode, true );
			}
			else
			{
				$return["SMALL"][] = $arImg;
			}
			if ($MediumWidth && $MediumHeight)
			{
				if ($ajax != "Y" || $colorXmlID == $FirstColor)
				{
					$return["MEDIUM"][] = CFile::ResizeImageGet( $arImg, array (
							'width' => $MediumWidth,
							'height' => $MediumHeight
					), $ResizeMode, true );
				}
				else
				{
					$return["MEDIUM"][] = $arImg;
				}
			}
			if ($BigWidth && $BigHeight)
			{
				$return["BIG"][] = CFile::ResizeImageGet( $arImg, array (
						'width' => $BigWidth,
						'height' => $BigHeight
				), $ResizeMode, true );
			}
			unset( $arImg );
			$IssetArray = $return;

		}

		// get if image in more_photos and no in anons
		//if ($OfferMorePhoto && $colorXmlID === 0 )
		if ($OfferMorePhoto && (! isset( $IssetArray['SMALL'] ) || $colorXmlID === 0 ))
		{
			for($k = 0; $k < sizeof( $OfferMorePhoto ); ++ $k)
			{
				if (sizeof( $return["SMALL"] ) == 0 || $BigWidth > 0) // big if detail
				{
					if ($ajax != "Y")
					{
						$return["SMALL"][] = CFile::ResizeImageGet( $OfferMorePhoto[$k], array (
								'width' => $SmallWidth,
								'height' => $SmallHeight
						), $ResizeMode, true );
					}
					else
					{
						$return["SMALL"][] = $OfferMorePhoto[$k];
					}

				}
				if ($MediumWidth && $MediumHeight)
				{
					if ($ajax != "Y" || ($colorXmlID == $FirstColor && ! $IssetArray && $k == 0))
					{
						$return["MEDIUM"][] = CFile::ResizeImageGet( $OfferMorePhoto[$k], array (
								'width' => $MediumWidth,
								'height' => $MediumHeight
						), $ResizeMode, true );
					}
					else
					{
						$return["MEDIUM"][] = $OfferMorePhoto[$k];
					}
				}
				if ($BigWidth && $BigHeight)
				{
					$return["BIG"][] = CFile::ResizeImageGet( $OfferMorePhoto[$k], array (
							'width' => $BigWidth,
							'height' => $BigHeight
					), $ResizeMode, true );
				}
			}
			$IssetArray = $return;
			unset( $k );
		}

		// if not images in offers get from anons item
		if (! $IssetArray)
		{
			$arImg = $ItemPreviewPicture ? $ItemPreviewPicture : $ItemDetailPicture;
			if ($arImg)
			{
				if (sizeof( $IssetArray["SMALL"] ) == 0 || $BigWidth > 0) // big if detail
				{
					if ($ajax != "Y")
					{
						$return["SMALL"][] = CFile::ResizeImageGet( $arImg, array (
								'width' => $SmallWidth,
								'height' => $SmallHeight
						), $ResizeMode, true );
					}
					else
					{
						$return["SMALL"][] = $arImg;
					}
				}
				if ($MediumWidth && $MediumHeight)
				{
					if ($ajax != "Y" || $colorXmlID == $FirstColor)
					{
						$return["MEDIUM"][] = CFile::ResizeImageGet( $arImg, array (
								'width' => $MediumWidth,
								'height' => $MediumHeight
						), $ResizeMode, true );
					}
					else
					{
						$return["MEDIUM"][] = $arImg;
					}
				}
				$return["BIG"][] = CFile::ResizeImageGet( $arImg, array (
						'width' => $BigWidth,
						'height' => $BigHeight
				), $ResizeMode, true );
			}
			$IssetArray = $return;
			unset( $arImg );
		}
		// more photos if no description
		if (! $IssetArray)
		{
			if (is_array( $OfferMorePhoto ) && sizeof( $OfferMorePhoto ) > 0)
			{
				for($k = 0; $k < sizeof( $OfferMorePhoto ); ++ $k)
				{
					if (isset( $OfferMorePhoto[$k]['DESCRIPTION'] ))
					{
						continue;
					}
					if (sizeof( $return["SMALL"] ) == 0 || $BigWidth > 0) // big if detail
					{
						if ($ajax != "Y")
						{
							$return["SMALL"][] = CFile::ResizeImageGet( $OfferMorePhoto[$k], array (
									'width' => $SmallWidth,
									'height' => $SmallHeight
							), $ResizeMode, true );
						}
						else
						{
							$return["SMALL"][] = $AddPictures[$k];
						}
					}
					if ($MediumWidth && $MediumHeight)
					{
						if ($ajax != "Y" || ($colorXmlID == $FirstColor && ! $IssetArray && $k == 0))
						{
							$return["MEDIUM"][] = CFile::ResizeImageGet( $OfferMorePhoto[$k], array (
									'width' => $MediumWidth,
									'height' => $MediumHeight
							), $ResizeMode, true );
						}
						else
						{
							$return["MEDIUM"][] = $OfferMorePhoto[$k];
						}
					}
					if ($BigWidth && $BigHeight)
					{
						$return["BIG"][] = CFile::ResizeImageGet( $OfferMorePhoto[$k], array (
								'width' => $BigWidth,
								'height' => $BigHeight
						), $ResizeMode, true );
					}
				}
			}
		}
		// add pictures
		if (! $BeforeArr)
		{
			if (is_array( $AddPictures ) && sizeof( $AddPictures ) > 0)
			{
				for($k = 0; $k < sizeof( $AddPictures ); ++ $k)
				{
					if (sizeof( $return["SMALL"] ) == 0 || $BigWidth > 0) // big if detail
					{
						if ($ajax != "Y")
						{
							$return["SMALL"][] = CFile::ResizeImageGet( $AddPictures[$k], array (
									'width' => $SmallWidth,
									'height' => $SmallHeight
							), $ResizeMode, true );
						}
						else
						{
							$return["SMALL"][] = $AddPictures[$k];
						}
					}
					if ($MediumWidth && $MediumHeight)
					{
						if ($ajax != "Y" || ($colorXmlID == $FirstColor && ! $IssetArray && $k == 0))
						{
							$return["MEDIUM"][] = CFile::ResizeImageGet( $AddPictures[$k], array (
									'width' => $MediumWidth,
									'height' => $MediumHeight
							), $ResizeMode, true );
						}
						else
						{
							$return["MEDIUM"][] = $AddPictures[$k];
						}
					}
					if ($BigWidth && $BigHeight)
					{
						$return["BIG"][] = CFile::ResizeImageGet( $AddPictures[$k], array (
								'width' => $BigWidth,
								'height' => $BigHeight
						), $ResizeMode, true );
					}
				}
			}
		}
		unset( $k );
		unset( $AddPictures );
		unset( $ItemPreviewPicture );
		unset( $ItemDetailPicture );
		unset( $OfferPreviewPicture );
		unset( $OfferDetailPicture );
		unset( $OfferMorePhoto );
		unset( $SmallHeight );
		unset( $MediumWidth );
		unset( $MediumHeight );
		unset( $ResizeMode );
		unset( $ajax );
		unset( $IssetArray );
		unset( $FirstColor );
		unset( $colorXmlID );

		return $return;
	}
	public function ColorLink2($arModelsLinks, $ColorLink, $ColorInProductCode, $colorCode, $SmallWidth,
							   $SmallHeight, $MediumWidth, $MediumHeight, $ResizeMode, $iblockId = '')
	{
		$return = array (
				'COLORS' => array (),
				'PHOTOS' => array ()
		);
		$Select = array (
				"ID",
				"PREVIEW_PICTURE",
				"DETAIL_PICTURE",
				"DETAIL_PAGE_URL",
				'PROPERTY_' . $ColorLink,
				'PROPERTY_MORE_PHOTO'
		);
		if ($ColorInProductCode)
		{
			array_push( $Select, 'PROPERTY_' . $ColorInProductCode );
		}

		$propLinks = array();
		$parentId = array();

		$rsModel = CIBlockElement::GetList( array (
				'SORT' => 'asc'
		), array (
				"IBLOCK_ID" => $iblockId,
				"ACTIVE" => "Y",
				"=PROPERTY_" . $ColorLink => $arModelsLinks
		), false, false, $Select );
		while ( $arModel = $rsModel->GetNext() )
		{
			if($arModel['PROPERTY_'.$ColorLink.'_ENUM_ID'])
			{
				$value = $arModel['PROPERTY_'.$ColorLink.'_ENUM_ID'];
			}
			else
			{
				$value = $arModel['PROPERTY_'.$ColorLink.'_VALUE'];
			}
			$arIds[$arModel['ID']] = $arModel['ID'];
			if(!$parentId[$value])
			{
				$parentId[$value] = array_search($value, $arModelsLinks);
			}

			$return['IDS'][$parentId[$value]][$arModel['ID']] = $arModel['ID'];

			$arModels[$arModel['ID']]['DETAIL_PICTURE'] = $arModel['DETAIL_PICTURE'];
			$arModels[$arModel['ID']]['PREVIEW_PICTURE'] = $arModel['PREVIEW_PICTURE'];
			$arModels[$arModel['ID']]['MORE_PHOTO'][] = $arModel['PROPERTY_MORE_PHOTO_VALUE'];
			$propLinks[$value][$arModel['ID']] = $arModel['ID'];
			$arModels[$arModel['ID']]['URL'] = $arModel['DETAIL_PAGE_URL'];
			if ($arModel['PROPERTY_' . strtoupper( $ColorInProductCode ) . '_VALUE'])
			{
				$arModels[$arModel['ID']]['PRODUCT_COLOR'] = $arModel['PROPERTY_' . strtoupper( $ColorInProductCode ) . '_VALUE'];
			}
		}

		$arIds = array_unique( $arIds );
		$arIds = array_diff( $arIds, array_keys( $arModelsLinks ) );

		if (sizeof( $arIds ) > 0)
		{
			if (! $ColorInProductCode)
			{
				$res = CCatalogSKU::getOffersList(
						$arIds,
						$iblockID = 0,
						$skuFilter = array (),
						$fields = array (),
						$propertyFilter = array (
								'CODE' => array (
										$colorCode
								)
						)
						);
				unset( $arIds );
			}
			$ColorsCodes = array ();
			$ProductsColors = array();

			foreach ( $arModelsLinks as $IdItem => $ItemLinkValue )
			{
				$ColorsArray = array ();
				$propLinks[$ItemLinkValue] = array_unique( $propLinks[$ItemLinkValue] );
				foreach ( $propLinks[$ItemLinkValue] as $key => $modelsId )
				{
					if (! $ColorInProductCode && isset( $res[$modelsId] )) // if offers isset
					{
						$ColorArray = array_shift( $res[$modelsId] );
					}

					if($arModels[$modelsId]['DETAIL_PICTURE'])
					{
						if ($ColorInProductCode)
						{
							$Color = $arModels[$modelsId]['PRODUCT_COLOR'];
						}
						else
						{
							$Color = $ColorArray['PROPERTIES'][$colorCode]['VALUE'];
						}

						if ($arModels[$modelsId]['DETAIL_PICTURE'] && $Color)
						{
							$Photos[$IdItem][$Color]["SMALL"][0] = CFile::ResizeImageGet( $arModels[$modelsId]['DETAIL_PICTURE'], array (
									'width' => $SmallWidth,
									'height' => $SmallHeight
							), $ResizeMode, true );
							if ($MediumWidth && $MediumHeight)
							{
								$Photos[$IdItem][$Color]["MEDIUM"][0] = CFile::ResizeImageGet( $arModels[$modelsId]['DETAIL_PICTURE'], array (
										'width' => $MediumWidth,
										'height' => $MediumHeight
								), $ResizeMode, true );
							}
						}
						elseif($Color)
						{
							$Photos[$IdItem][$Color]["SMALL"][0]['src'] = '/upload/no_photo.jpg';
							$Photos[$IdItem][$Color]["MEDIUM"][0]['src'] = '/upload/no_photo.jpg';
						}

						if($Color)
						{
							$ProductsColors[$modelsId] = $Color;
						}
					}
					if ($MediumWidth && $MediumHeight)
					{
						if (! isset( $arResult["MORE_PHOTO_JS"][$IdItem][$Color]["MEDIUM"] ) || count( $arResult["MORE_PHOTO_JS"][$IdItem][$Color]["MEDIUM"] ) < 2)
						{
							foreach ( $arModels[$modelsId]['MORE_PHOTO'] as $Pic )
							{
								if (isset( $Pic ) && ! empty( $Pic ) && $Color)
								{
									$Photos[$IdItem][$Color]["MEDIUM"][] = CFile::ResizeImageGet( $Pic, array (
											'width' => $MediumWidth,
											'height' => $MediumHeight
									), $ResizeMode, true );
								}
							}
						}
					}
					if (! in_array( $Color, $ColorsCodes[$IdItem] ))
					{
						$ColorsCodes[$IdItem][] = $Color;
					}
					// url for detail
					if ($arModels[$modelsId]['URL'])
					{
						$return['URLS'][$Color] = $arModels[$modelsId]['URL'];
					}
				}
			}

			$return['PRODUCT_COLORS'] = $ProductsColors;
			$return['COLORS'] = $ColorsCodes;
			$return['PHOTOS'] = $Photos;
		}
		return $return;
	}
	public function ImagesFromProduct($ItemPreviewPicture, $ItemMorePhotos, $HL, $FirstColor, $ColorInProduct, $ColorInSectionLink, $ajax, $SmallWidth, $SmallHeight, $MediumWidth, $MediumHeight, $BigWidth, $BigHeight, $ResizeMode, $TreeProps, $colorCode)
	{
		// get images
		$return = array (
				'FIRST_COLOR' => '',
				'PHOTOS' => array (),
				'OFFER_TREE_PROPS' => array ()
		);
		$Images = array ();
		if ($ItemPreviewPicture)
		{
			$Images[0] = $ItemPreviewPicture;
		}
		if ($ItemMorePhotos)
		{
			for($j = 0; $j < sizeof( $ItemMorePhotos ); ++ $j)
			{
				$Images[$j + 1] = $ItemMorePhotos[$j];
			}
			unset( $j );
		}

		$q = 0;

		$Images = array_diff( $Images, array (
				''
		) );
		$Images = array_values( $Images );

		for($j = 0; $j < sizeof( $Images ); ++ $j)
		{
			if (! is_array( $Images[$j] ))
			{
				$Images[$j] = CFile::GetByID( $Images[$j] )->fetch();
			}
			$arDescr = explode( "_", mb_strtolower( $Images[$j]["DESCRIPTION"] ) );

			global $DescColor;
			$DescColor = $arDescr[0];

			if ($HL)
			{
				$arDescColor = array_filter( $HL, function ($innerArray)
				{
					global $DescColor;

					return (strtolower( $innerArray['UF_NAME'] ) == strtolower( $DescColor ) || strtolower( $innerArray['UF_XML_ID'] ) == strtolower( $DescColor ));
				} );

				if (! $arDescColor || (is_array( $arDescColor ) && sizeof( $arDescColor ) == 0))
				{
					$colorXmlID = $FirstColor;
				}
				else
				{
					if($HL[mb_strtoupper( key( $arDescColor ) )])
					{
						$colorXmlID = $HL[mb_strtoupper( key( $arDescColor ) )]["UF_XML_ID"];
					}
					elseif($HL[ key( $arDescColor  )])
					{
						$colorXmlID = $HL[key( $arDescColor ) ]["UF_XML_ID"];
					}
					unset( $FirstColor );
				}
				unset( $arDescColor );
				unset( $DescColor );
			}

			if ($colorXmlID)
			{
				if (! $FirstColor)
				{
					$return["FIRST_COLOR"] = $colorXmlID;
					$FirstColor = $colorXmlID;
				}

				if (isset( $arDescr[1] ) && preg_match( "/[0-9]/", $arDescr[1] ))
				{
					$index = $arDescr[1];
				}
				else
				{
					$index = 0;
				}
				// one section color
				if ($ColorInProduct == 'Y' && $ColorInSectionLink == 1)
				{
					if ($q)
					{
						$colorXmlID = $colorXmlID . $q;
					}
					$index = 0;
					++ $q;
				}

				// if index isset
				if (isset( $return['PHOTOS'][$colorXmlID]["SMALL"][$index] ) && ! isset( $return['PHOTOS'][$colorXmlID]["SMALL"][$j] ))
				{
					$index = $j;
				}

				if (sizeof( $return['PHOTOS'][$colorXmlID]["SMALL"] ) == 0 || $BigWidth) // if element
				{
					if ($ajax != "Y" || $BigWidth)
					{
						$return['PHOTOS'][$colorXmlID]["SMALL"][$index] = CFile::ResizeImageGet( $Images[$j], array (
								'width' => $SmallWidth,
								'height' => $SmallHeight
						), $ResizeMode, true );
					}
					else
					{
						$return['PHOTOS'][$colorXmlID]["SMALL"][$index] = $Images[$j];
					}
				}
				if ($MediumWidth && $MediumHeight)
				{
					if (($ajax != "Y" || $colorXmlID == $FirstColor) && $Images[$j])
					{
						$return['PHOTOS'][$colorXmlID]["MEDIUM"][$index] = CFile::ResizeImageGet( $Images[$j], array (
								'width' => $MediumWidth,
								'height' => $MediumHeight
						), $ResizeMode, true );
					}
					elseif($Images[$j])
					{
						$return['PHOTOS'][$colorXmlID]["MEDIUM"][$index] = $Images[$j];
					}
				}
				if ($BigWidth && $BigHeight)
				{
					$return['PHOTOS'][$colorXmlID]["BIG"][$index] = CFile::ResizeImageGet( $Images[$j], array (
							'width' => $BigWidth,
							'height' => $BigHeight
					), $ResizeMode, true );
				}

				// available colors
				if (array_search( $colorCode, $TreeProps ) !== false && ! $return["OFFER_TREE_PROPS"][$colorCode][$colorXmlID])
				{
					$return["OFFER_TREE_PROPS"][$colorCode][$colorXmlID] = $HL[$colorXmlID];
				}
			}
			else
			{
				if ($ajax != "Y")
				{
					$return['PHOTOS'][0]["SMALL"][$j] = CFile::ResizeImageGet( $Images[$j], array (
							'width' => $SmallWidth,
							'height' => $SmallHeight
					), $ResizeMode, true );
				}
				else
				{
					$return['PHOTOS'][0]["SMALL"][$j] = $Images[$j];
				}
				if ($MediumWidth && $MediumHeight)
				{
					if ($ajax != "Y" || $colorXmlID == $FirstColor)
					{
						$return['PHOTOS'][0]["MEDIUM"][$j] = CFile::ResizeImageGet( $Images[$j], array (
								'width' => $MediumWidth,
								'height' => $MediumHeight
						), $ResizeMode, true );
					}
					else
					{
						$return['PHOTOS'][0]["MEDIUM"][$j] = $Images[$j];
					}
				}
				if($BigWidth && $BigHeight)
				{
					$return['PHOTOS'][0]["BIG"][$j] = CFile::ResizeImageGet ( $Images[$j], array (
							'width' => $BigWidth,
							'height' => $BigHeight
					), $ResizeMode, true );
				}
			}
		}

		unset( $Images );

		// sort color positions
		if ($return['PHOTOS'])
		{
			foreach ( $return['PHOTOS'] as $key => $MorePhoto )
			{
				if ($return['PHOTOS'][$key]['SMALL'])
				{
					ksort( $return['PHOTOS'][$key]['SMALL'] );
					$return['PHOTOS'][$key]['SMALL'] = array_values( $return['PHOTOS'][$key]['SMALL'] );
				}
				if ($return['PHOTOS'][$key]['MEDIUM'])
				{
					ksort( $return['PHOTOS'][$key]['MEDIUM'] );
					$return['PHOTOS'][$key]['MEDIUM'] = array_values( $return['PHOTOS'][$key]['MEDIUM'] );
				}
				if ($return['PHOTOS'][$key]['BIG'])
				{
					ksort( $return['PHOTOS'][$key]['BIG'] );
					$return['PHOTOS'][$key]['BIG'] = array_values( $return['PHOTOS'][$key]['BIG'] );
				}
			}
		}
		unset( $key );
		unset( $MorePhoto );
		unset( $q );

		return $return;
	}

	// //for element
	public function GetCharacteristics($IblockId, $SectionId, $DisplayProperties, $arDopProps)
	{
		$return = array ();
		// get all filter props
		$FilterProps = array ();
		$PropsSection = CIBlockSectionPropertyLink::GetArray( $IblockId, $SectionId, $bNewSection = false );
		foreach ( $PropsSection as $PropSection )
		{
			if ($PropSection['SMART_FILTER'] == "Y")
				$FilterProps[] = $PropSection['PROPERTY_ID'];
		}
		unset( $PropSection );
		// get section url
		$res = CIBlockSection::GetByID( $SectionId );
		if ($ar_res = $res->GetNext())
		{
			$SectionUrl = $ar_res['SECTION_PAGE_URL'];
		}
		unset( $res );
		unset( $ar_res );
		$BitrixCHPU = \Bitrix\Main\Config\Option::get("kit.b2bshop", "CATALOG_FILTER","N");
		foreach ( $DisplayProperties as $code => $arOneProp )
		{
			if (in_array( $code, $arDopProps ))
			{
				$return[$code] = $arOneProp;
				if (in_array( $arOneProp['ID'], $FilterProps ))
				{
					if (is_array( $arOneProp['DISPLAY_VALUE'] ))
					{
						$return[$code]['DISPLAY_VALUE'] = '';
						foreach ( $arOneProp['DISPLAY_VALUE'] as $DisplayKey => $DisplayValue )
						{
							if($BitrixCHPU == 'Y')
							{
								if($arOneProp['PROPERTY_TYPE'] == 'L') // list
								{
									$return[$code]['DISPLAY_VALUE'] = '<a onclick="" href="' .$SectionUrl .  'filter/' . strtolower( $code ) .'-is-'. toLower($arOneProp['XML_ID']) . '/apply/'.'">' . $DisplayValue . '</a>';
								}
								else
								{
									$return[$code]['DISPLAY_VALUE'] = '<a onclick="" href="' .$SectionUrl .  'filter/' . strtolower( $code ) .'-is-'. str_replace('%','%25',urlencode(toLower($arOneProp['DISPLAY_VALUE']))) . '/apply/'.'">' . $DisplayValue . '</a>';
								}
							}
							else
							{
								$return[$code]['DISPLAY_VALUE'] .= '<a onclick="" href="' . $SectionUrl . 'filter/' . strtolower( $code ) . '-' . Cutil::translit( $DisplayValue, "ru", array (
										"replace_space" => "_",
										"replace_other" => "_"
								) ) . '/apply/">' . $DisplayValue . '</a> / ';
							}
						}
						if (substr( $arResult["DOP_PROPS"][$code]['DISPLAY_VALUE'], - 3 ) == ' / ')
						{
							$return[$code]['DISPLAY_VALUE'] = substr( $arResult["DOP_PROPS"][$code]['DISPLAY_VALUE'], 0, - 3 );
						}
					}
					else
					{
						if($BitrixCHPU == 'Y')
						{
							if($arOneProp['PROPERTY_TYPE'] == 'L') // list
							{
								$return[$code]['DISPLAY_VALUE'] = '<a onclick="" href="' .$SectionUrl .  'filter/' . strtolower( $code ) .'-is-'. toLower($arOneProp['XML_ID']) . '/apply/'.'">' . $arOneProp['DISPLAY_VALUE'] . '</a>';
							}
							else
							{
								$return[$code]['DISPLAY_VALUE'] = '<a onclick="" href="' .$SectionUrl .  'filter/' . strtolower( $code ) .'-is-'. str_replace('%','%25',urlencode(toLower($arOneProp['DISPLAY_VALUE']))) . '/apply/'.'">' . $arOneProp['DISPLAY_VALUE'] . '</a>';
							}
						}
						else
						{
							$return[$code]['DISPLAY_VALUE'] = '<a onclick="" href="' . $SectionUrl . 'filter/' . strtolower( $code ) . '-' . Cutil::translit( $arOneProp['DISPLAY_VALUE'], "ru", array (
									"replace_space" => "_",
									"replace_other" => "_"
							) ) . '/apply/">' . $arOneProp['DISPLAY_VALUE'] . '</a>';
						}
					}
				}
			}
		}
		unset( $IblockId );
		unset( $SectionId );
		unset( $DisplayProperties );
		unset( $arDopProps );
		return $return;
	}
	public function GetBrandInfo($brandID = "", $ResizeMode)
	{
		$return = array ();
		if ($brandID)
		{
			$rsBrand = CIBlockElement::GetList( array (), array (
					"=ID" => $brandID
			), false, false, array (
					"ID",
					"IBLOCK_ID",
					"NAME",
					"DETAIL_PAGE_URL",
					"PREVIEW_PICTURE"
			) );
			if ($arBrand = $rsBrand->GetNext())
			{
				$return = $arBrand;
				if ($arBrand["PREVIEW_PICTURE"])
				{
					$return["PIC"] = CFile::ResizeImageGet( $arBrand["PREVIEW_PICTURE"], array (
							'width' => 220,
							'height' => 60
					), $ResizeMode, true );
					$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues( $arBrand["IBLOCK_ID"], $arBrand["ID"] );
					$return["IPROPERTY_VALUES"] = $ipropValues->getValues();
					$return["PIC"]["ALT"] = $return["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"];
					if ($return["PIC"]["ALT"] == "")
					{
						$return["PIC"]["ALT"] = $arBrand["NAME"];
					}
					$return["PIC"]["TITLE"] = $return["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"];
					if ($return["PIC"]["TITLE"] == "")
					{
						$return["PIC"]["TITLE"] = $arBrand["NAME"];
					}
				}
			}
			unset( $arBrand );
			unset( $rsBrand );
			unset( $brandID );
		}
		return $return;
	}
	public function GetVideo($Videos = array())
	{
		$return = array ();
		if (is_array( $Videos ) && sizeof( $Videos ) > 0)
		{
			foreach ( $Videos as $Video )
			{
				// YOUTUBE
				if (preg_match( '/[http|https]+:\/\/(?:www\.|)youtube\.com\/watch\?(?:.*)?v=([a-zA-Z0-9_\-]+)/i', $Video, $matches ) || preg_match( '/[http|https]+:\/\/(?:www\.|)youtube\.com\/embed\/([a-zA-Z0-9_\-]+)/i', $Video, $matches ) || preg_match(
						'/[http|https]+:\/\/(?:www\.|)youtu\.be\/([a-zA-Z0-9_\-]+)/i', $Video, $matches ))
				{
					$VideoPath = explode( '?v=', $Video );
					$VideoNumber = $VideoPath[count( $VideoPath ) - 1];
					$return[] = '<iframe src="http://www.youtube.com/embed/' . $matches[1] . '" frameborder="0" allowfullscreen></iframe>';
				}
				// VIMEO
				elseif (strpos( $Video, "vimeo.com" ))
				{
					$VideoPath = explode( '/', $Video );
					$VideoNumber = $VideoPath[count( $VideoPath ) - 1];
					$return[] = '<iframe src="https://player.vimeo.com/video/' . $VideoNumber . '"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
				}
				// HTML5
				else
				{
					$return[] = '<video src="' . $Video . '"  controls  />';
				}
			}
		}
		return $return;
	}
	public function GetModifications($CanBuyOffersId, $colorCode, $Currency, $CntVisibleRows)
	{
		$return = array ();
		$Razmery = $CanBuyOffersId;
		unset( $Razmery[$colorCode] );
		if (isset( $Razmery ))
		{
			foreach ( $Razmery as $key => $Vals )
			{
				$Razmer[$key] = array_keys( $Vals );
			}
		}
		unset( $Razmery );
		$return['MODIFICATION_RAZMERY'] = array ();
		if (isset( $Razmer ) && is_array( $Razmer ))
			while ( list ( $key, $values ) = each( $Razmer ) )
			{
				if (empty( $values ))
				{
					continue;
				}
				if (empty( $return['MODIFICATION_RAZMERY'] ))
				{
					foreach ( $values as $value )
					{
						$return['MODIFICATION_RAZMERY'][] = array (
								$key => $value
						);
					}
				}
				else
				{
					$append = array ();
					foreach ( $return['MODIFICATION_RAZMERY'] as &$product )
					{
						$product[$key] = array_shift( $values );
						$copy = $product;
						foreach ( $values as $item )
						{
							$copy[$key] = $item;
							$append[] = $copy;
						}
						array_unshift( $values, $product[$key] );
					}
					$return['MODIFICATION_RAZMERY'] = array_merge( $return['MODIFICATION_RAZMERY'], $append );
				}
			}
		// currency sum price
		$cur = CCurrencyLang::GetByID( $Currency, LANGUAGE_ID );
		$return['MODIFICATION_CURRENCY'] = str_replace( '#', '', $cur['FORMAT_STRING'] );
		if($CntVisibleRows)
		{
			if ((sizeof( $CanBuyOffersId[$colorCode] ) - $CntVisibleRows) % 10 == 1)
			{
				$return['OKONCHANIE'] = GetMessage( "B2BS_CATALOG_DETAIL_MODIFICATION_MORE2_1" );
				$return['OKONCHANIE2'] = GetMessage( "B2BS_CATALOG_DETAIL_MODIFICATION_HIDE2_1" );
			}
			elseif ((sizeof( $CanBuyOffersId[$colorCode] ) - $CntVisibleRows) % 10 == 2 || (sizeof( $CanBuyOffersId[$colorCode] ) - $CntVisibleRows) % 10 == 3 || (sizeof( $CanBuyOffersId[$colorCode] ) - $CntVisibleRows) % 10 == 4)
			{
				$return['OKONCHANIE'] = GetMessage( "B2BS_CATALOG_DETAIL_MODIFICATION_MORE2_2" );
				$return['OKONCHANIE2'] = GetMessage( "B2BS_CATALOG_DETAIL_MODIFICATION_MORE2_2" );
			}
			else
			{
				$return['OKONCHANIE'] = GetMessage( "B2BS_CATALOG_DETAIL_MODIFICATION_MORE2_2" );
				$return['OKONCHANIE2'] = GetMessage( "B2BS_CATALOG_DETAIL_MODIFICATION_MORE2_2" );
			}
		}
		return $return;
	}
	public function SortPropertyTree($TreeProps, $colorCode, $FirstOffer, $IdOffers, $CanBuyOffers = array())
	{
		$return['PROPERTIES'] = $TreeProps;
		$return['FIRST_OFFER'] = $FirstOffer;
		$Sizes = array (
				'XS',
				'S',
				'M',
				'L',
				'XL',
				'XXL',
				'XXL2',
				'XXL3',
				'XXXL',
				'BXL',
				'BXXL',
				'BXXXL'
		);

		if (isset( $IdOffers[$colorCode] ))
		{
			foreach ( $IdOffers[$colorCode] as $Color => $Ids )
			{
				if (in_array( $FirstOffer, $Ids ))
				{
					$IDS = $Ids;
					break;
				}
			}
		}

		if (isset( $TreeProps ))
		{
			foreach ( $TreeProps as $Prop => $TreeProp )
			{
				if ($Prop != $colorCode)
				{
					$TreePropKeys = array_keys( $TreeProp );
					$arSizes = array_intersect( $TreePropKeys, $Sizes );
					if (sizeof( $arSizes ) == sizeof( $TreePropKeys ))
					{
						$TreePropSizes = array ();
						for($i = 0; $i < sizeof( $Sizes ); ++ $i)
						{
							if (isset( $TreeProp[$Sizes[$i]] ))
							{
								$TreePropSizes[$Sizes[$i]] = $TreeProp[$Sizes[$i]];
							}
						}
						$TreeProp = $TreePropSizes;
						unset( $TreePropSizes );
					}
					else
					{
						ksort( $TreeProp );
					}

					unset( $arSizes );
					unset( $TreePropKeys );

					$return['PROPERTIES'][$Prop] = $TreeProp;
					foreach ( $TreeProp as $SortPropKey => $SortPropValue )
					{
						if (! isset( $IDS ))
						{
							$ArSr = $CanBuyOffers[$Prop][$SortPropKey];
						}
						else
						{
							if(!$CanBuyOffers[$Prop][$SortPropKey])
							{
								$CanBuyOffers[$Prop][$SortPropKey] = [];
							}
							$ArSr = array_intersect( $CanBuyOffers[$Prop][$SortPropKey], $IDS );
						}

						if (sizeof( $ArSr ) > 0)
						{
							$IDS = $ArSr;
						}

						if (sizeof( $IDS ) == 1 && reset( $IDS ) > 0)
						{
							$return['FIRST_OFFER'] = reset( $IDS );
						}
					}
				}
			}
		}
		unset( $IDS );
		unset( $TreeProps );
		unset( $Prop );
		unset( $TreeProp );
		unset( $colorCode );
		unset( $i );
		unset( $ArSr );
		unset( $Sizes );
		unset( $IdOffers );
		unset( $CanBuyOffers );
		unset( $FirstOffer );

		return $return;
	}
	public function GenerateLiClasses($OfferTreeProps, $OffersId, $CanBuyOffers, $FirstOffer)
	{
		 $return = array ();
		 if (isset( $OfferTreeProps ) && is_array( $OfferTreeProps ))
		 {
		 	foreach ( $OfferTreeProps as $codeProp => $arProperties )
		 	{
		 		foreach ( $arProperties as $xmlID => $arProp )
		 		{
		 			// if first step
		 			if (! isset( $Ids ))
		 			{
		 				if (! isset( $OffersId[$codeProp][$xmlID] ) || count($OffersId[$codeProp][$xmlID]) == 0)
		 				{
		 					$return[$xmlID][] = 'li-disable';
		 				}
		 				if ((! isset( $CanBuyOffers[$codeProp][$xmlID] ) || sizeof( array_intersect( $OffersId[$codeProp][$xmlID], $CanBuyOffers[$codeProp][$xmlID] ) ) == 0) && isset( $OffersId[$codeProp][$xmlID] ))
		 				{
		 					$return[$xmlID][] = 'li-available';
		 				}
		 			}
		 			else
		 			{
		 				if (sizeof( array_intersect( $Ids, $OffersId[$codeProp][$xmlID] ) ) == 0)
		 				{
		 					$return[$xmlID][] = 'li-disable';
		 				}
		 				if(!$CanBuyOffers[$codeProp][$xmlID])
						{
							$CanBuyOffers[$codeProp][$xmlID] = [];
						}
		 				if (sizeof( array_intersect( $Ids, $CanBuyOffers[$codeProp][$xmlID] ) ) == 0 && empty( $arResult['LI'][$xmlID] ))
		 				{
		 					$return[$xmlID][] = 'li-available';
		 				}
		 			}

		 			if (in_array( $FirstOffer, $OffersId[$codeProp][$xmlID] ))
		 			{
		 				$return[$xmlID][] = 'li-active';
		 				if (isset( $Ids ))
		 				{
		 					$IdsTmp = array_intersect( $Ids, $OffersId[$codeProp][$xmlID] );
		 				}
		 				else
		 				{
		 					$IdsTmp = $OffersId[$codeProp][$xmlID];
		 				}
		 			}
		 			if (is_array( $return[$xmlID] ))
		 			{
		 				if (in_array( 'li-disable', $return[$xmlID] ))
		 				{
		 					$return[$xmlID] = 'li-disable';
		 				}
		 				else
		 				{
		 					$return[$xmlID] = implode( ' ', $return[$xmlID] );
		 				}
		 			}
		 		}
		 		$Ids = $IdsTmp;
		 	}
		 }
		 return $return;
	}
}
?>