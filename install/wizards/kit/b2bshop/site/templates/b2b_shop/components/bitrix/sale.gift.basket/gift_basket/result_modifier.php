<?
if(!defined( 'B_PROLOG_INCLUDED' )||B_PROLOG_INCLUDED!==true)
	die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
	 //printr($arResult);

$arResult["IS_DOWNLOAD"] = COption::GetOptionString( "kit.b2bshop", "DOWNLOAD", "" );
$arMainProps = unserialize( COption::GetOptionString( "kit.b2bshop", "MAIN_PROPS", "" ) );

$arResult["SIZE_PROPS"] = $arSizeProps = unserialize( COption::GetOptionString( "kit.b2bshop", "SIZE_PROPS", "" ) );
//START LINK IN PROPS
$FilterProps=array();
$PropsSection=CIBlockSectionPropertyLink::GetArray($arResult['IBLOCK_ID'], $arResult['IBLOCK_SECTION_ID'], $bNewSection = false);

$RESIZE_MODE=BX_RESIZE_IMAGE_PROPORTIONAL;
if($arParams["IMAGE_RESIZE_MODE"]=="BX_RESIZE_IMAGE_EXACT")
	$RESIZE_MODE=BX_RESIZE_IMAGE_EXACT;
	elseif($arParams["IMAGE_RESIZE_MODE"]=="BX_RESIZE_IMAGE_PROPORTIONAL")
	$RESIZE_MODE=BX_RESIZE_IMAGE_PROPORTIONAL;
	elseif($arParams["IMAGE_RESIZE_MODE"]=="BX_RESIZE_IMAGE_PROPORTIONAL_ALT")
	$RESIZE_MODE=BX_RESIZE_IMAGE_PROPORTIONAL_ALT;


 //


$codeBrand = $arParams["MANUFACTURER_ELEMENT_PROPS"];
$brandID=array();
foreach($arResult['ITEMS'] as $Item)
{
	$brandID[$Item['ID']]=$Item["PROPERTIES"][$codeBrand]["VALUE"];
}


//$brandID = $arResult["PROPERTIES"][$codeBrand]["VALUE"];
$colorCode = $arParams["OFFER_COLOR_PROP"];
$colorDelete = ($arParams["DELETE_OFFER_NOIMAGE"]=="Y") ? 1 : 0;
$imageFromOffer = ($arParams["PICTURE_FROM_OFFER"]=="Y") ? 1 : 0;
$codeMorePhoto = "MORE_PHOTO";
$codeProductMorePhoto = $arParams["MORE_PHOTO_PRODUCT_PROPS"];
$codeOfferMorePhoto = $arParams["MORE_PHOTO_OFFER_PROPS"];
$smallImg["width"] = $arParams["DETAIL_WIDTH_SMALL"];
$smallImg["height"] = $arParams["DETAIL_HEIGHT_SMALL"];
$mediumImg["width"] = $arParams["DETAIL_WIDTH_MEDIUM"];
$mediumImg["height"] = $arParams["DETAIL_HEIGHT_MEDIUM"];
$bigImg["width"] = $arParams["DETAIL_WIDTH_BIG"];
$bigImg["height"] = $arParams["DETAIL_HEIGHT_BIG"];
$availableDelete = ($arParams["AVAILABLE_DELETE"]=="Y") ? 1 : 0;

if(count($brandID)>0)
{
	$rsBrand = CIBlockElement::GetList( array(), array(
			"=ID" => $brandID
	), false, false, array(
			"ID",
			"IBLOCK_ID",
			"NAME",
			"DETAIL_PAGE_URL",
			"PREVIEW_PICTURE"
	) );
	while( $arBrand = $rsBrand->GetNext() )
	{
		foreach($brandID as $Product=>$Brand)
		{
			if($arBrand['ID']==$Brand)
				$arResult["BRAND"][$Product] = $arBrand;
		}

	}
}

$arSKU = CCatalogSKU::GetInfoByProductIBlock( $arParams['IBLOCK_ID'] );
$boolSKU = !empty( $arSKU )&&is_array( $arSKU );

if($boolSKU&&!empty( $arParams['OFFER_TREE_PROPS'] ))
{
	if(isset( $colorCode )&&!empty( $colorCode )&&!in_array( $colorCode, $arParams['OFFER_TREE_PROPS'] ))
	{
		array_push( $arParams['OFFER_TREE_PROPS'], $colorCode );
	}
	foreach( reset($arParams['OFFER_TREE_PROPS']) as $prop )
	{

		foreach($arResult['ITEMS'] as $Item)
		{
			$arProp = $Item["OFFERS"][0]["PROPERTIES"][$prop];
			if($arProp["USER_TYPE"]=="directory")
			{
				$nameTable = $arProp["USER_TYPE_SETTINGS"]["TABLE_NAME"];
				$directorySelect = array(
						"*"
				);
				$directoryOrder = array();
				$entityGetList = array(
						'select' => $directorySelect,
						'order' => $directoryOrder
				);
				$highBlock = \Bitrix\Highloadblock\HighloadBlockTable::getList( array(
						"filter" => array(
								'TABLE_NAME' => $nameTable
						)
				) )->fetch();
				$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity( $highBlock );
				$entityDataClass = $entity->getDataClass();
				$propEnums = $entityDataClass::getList( $entityGetList );
				while( $oneEnum = $propEnums->fetch() )
				{
					// printr($oneEnum);
					if($oneEnum["UF_FILE"])
					{
						$oneEnum["PIC"] = CFile::GetFileArray( $oneEnum["UF_FILE"] );
					}
					$arResult["LIST_PROPS"][$prop][$oneEnum["UF_XML_ID"]] = $oneEnum;
					$arResult["LIST_PROPS_NAME"][$prop][mb_strtolower( $oneEnum["UF_NAME"] )] = $oneEnum;
				}
			}

		}
	}
}


$minPrice = 0;
$arColorName = $arColorXml[$ID] = array();
$arResult["DEFAULT_IMAGE"][$ID] = $arResult["DEFAULT_OFFER_IMAGE"][$ID] = array();


foreach($arResult['ITEMS'] as $Item)
{

	$minPrice = 0;
	$arColorName = $arColorXml[$ID] = array();
	$arResult["DEFAULT_IMAGE"][$ID] = $arResult["DEFAULT_OFFER_IMAGE"][$ID] = array();
	if($Item["DETAIL_PICTURE"])
	{
		$arResult["DEFAULT_IMAGE"][$Item['ID']]["SMALL"][] = CFile::ResizeImageGet( $Item["DETAIL_PICTURE"], array(
				'width' => $smallImg["width"],
				'height' => $smallImg["height"]
		), $RESIZE_MODE, true );
		$arResult["DEFAULT_IMAGE"][$Item['ID']]["MEDIUM"][] = CFile::ResizeImageGet( $Item["DETAIL_PICTURE"], array(
				'width' => $mediumImg["width"],
				'height' => $mediumImg["height"]
		), $RESIZE_MODE, true );
		$arResult["DEFAULT_IMAGE"][$Item['ID']]["BIG"][] = CFile::ResizeImageGet( $Item["DETAIL_PICTURE"], array(
				'width' => $bigImg["width"],
				'height' => $bigImg["height"]
		), $RESIZE_MODE, true );
	}


	if(!$Item[$codeMorePhoto]&&isset( $Item["PROPERTIES"][$codeProductMorePhoto] )&&!empty( $Item["PROPERTIES"][$codeProductMorePhoto]["VALUE"] ))
	{
		foreach( $Item["PROPERTIES"][$codeProductMorePhoto]["VALUE"] as $v )
		{
			$arResult[$codeMorePhoto][$Item['ID']][] = CFile::GetFileArray( $v );
		}
	}
}

foreach($arResult['ITEMS'] as $i=>$Item)
{
	$ID=$Item['ID'];

	if(isset($Item['MIN_PRICE']))
		$arResult['MIN_PRICE'][$ID]=$Item['MIN_PRICE'];
	if(isset($Item['CAN_BUY']))
	{
		$arResult['CAN_BUY'][$ID]=$Item['CAN_BUY'];
							if($Item["CAN_BUY"])
						{
							$Item["ADD_URL"] = str_replace( $arParams["PRODUCT_ID_VARIABLE"]."=", "id=", $Item["~ADD_URL"] );
							$arResult["OFFER_ADD_URL"][$Item["ID"]] = $Item["ADD_URL"]."&ajax_basket=Y";



							$arResult["OFFER_DELAY_URL"][$Item["ID"]] = str_replace( $arParams["ACTION_VARIABLE"]."=BUY", $arParams["ACTION_VARIABLE"]."=DELAY", $arResult["OFFER_ADD_URL"][$Item["ID"]] );


							$arResult["OFFER_DELAY_URL"][$Item["ID"]] = str_replace( 'id=','s_id=', $arResult["OFFER_DELAY_URL"][$Item["ID"]]);
							if(count( $arResult["OFFER_TREE_PROPS"][$ID] )==0)
							{
								$arResult["FIRST_OFFER_ID"][$ID] = $Item["ID"];
							}
						}
						else
						{
							$Item["SUBSCRIBE_URL"] = str_replace( $arParams["PRODUCT_ID_VARIABLE"]."=", "id=", $Item["~SUBSCRIBE_URL"] );
							$arResult["OFFER_SUBSCRIBE_URL"][$ID] = $Item["SUBSCRIBE_URL"]."&ajax_basket=Y";
							$arResult["OFFER_SUBSCRIBE_URL"][$Item["ID"]] = $Item["SUBSCRIBE_URL"]."&ajax_basket=Y";
							$arResult["OFFER_AVAILABLE_ID"][$Item["ID"]] = $Item["ID"];
							if(count( $arResult["OFFER_TREE_PROPS"][$ID] )==0)
								$arResult["FIRST_OFFER_ID"][$ID] = $Item["ID"];
						}
	}








	if($imageFromOffer)
	{

		$arResult["DEFAULT_OFFER_IMAGE"][$ID]["SMALL"] = array();
		$arResult["DEFAULT_OFFER_IMAGE"][$ID]["MEDIUM"] = array();
		$arResult["DEFAULT_OFFER_IMAGE"][$ID]["BIG"] = array();

		if(isset( $Item["PROPERTIES"][$codeProductMorePhoto] )&&!empty( $Item["PROPERTIES"][$codeProductMorePhoto]["VALUE"] ))
		{

			foreach( $Item["PROPERTIES"][$codeProductMorePhoto]["VALUE"] as $v )
			{
				$arImgSmall = CFile::ResizeImageGet( $v, array(
						'width' => $smallImg["width"],
						'height' => $smallImg["height"]
				), $RESIZE_MODE, true );
				$arImgMedium = CFile::ResizeImageGet( $v, array(
						'width' => $mediumImg["width"],
						'height' => $mediumImg["height"]
				), $RESIZE_MODE, true );
				$arImgBig = CFile::ResizeImageGet( $v, array(
						'width' => $bigImg["width"],
						'height' => $bigImg["height"]
				), $RESIZE_MODE, true );
				if($arImgSmall&&$arImgMedium&&$arImgBig)
				{
					$arResult["DEFAULT_OFFER_IMAGE"][$ID]["SMALL"][$v] = $arImgSmall;
					$arResult["DEFAULT_OFFER_IMAGE"][$ID]["MEDIUM"][$v] = $arImgMedium;
					$arResult["DEFAULT_OFFER_IMAGE"][$ID]["BIG"][$v] = $arImgBig;
				}
			}
		}




		if(isset( $Item["OFFERS"] )&&!empty( $Item["OFFERS"] ))
		{
			$arResult["CAN_BUY"][$ID] = false;



			foreach( $Item["OFFERS"] as $in => $arOffer )
			{
				if(!$arResult["CAN_BUY"][$ID]&&$arOffer["CAN_BUY"])
					$arResult["CAN_BUY"][$ID] = "Y";
				foreach( $arOffer["PROPERTIES"] as $code => $arProps )
				{
					$boolImg = false;
					if($arOffer["DETAIL_PICTURE"]||$arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"])
					{
						$boolImg = true;
					}
					if($availableDelete&&!$arOffer["CAN_BUY"])
						continue 1;
					if($arProps["VALUE"]&&$code==$colorCode)
					{
						if($arProps["USER_TYPE"]=="directory")
						{
							$arDirVal = $arResult["LIST_PROPS"][$code][$arProps["VALUE"]];
							if(!$boolImg&&$colorDelete)
							{
								unset( $arResult["OFFERS"][$in] );
							}
							else
							{
								$arColorXml[$ID][$arProps["VALUE"]] = $arDirVal;

								if($arOffer["CAN_BUY"]&&(!isset( $arResult["FIRST_COLOR"][$ID] )||!$arResult["FIRST_COLOR"][$ID]))
									$arResult["FIRST_COLOR"][$ID] = $arProps["VALUE"];
							}
						}
					}
				}
			}


			foreach( $Item["OFFERS"] as $arOffer )
			{
				foreach( $arOffer["PROPERTIES"] as $code => $arProps )
				{
					if(!$arOffer["CAN_BUY"]&&$availableDelete)
						continue 1;



					if(in_array( $code, reset($arParams['OFFER_TREE_PROPS']) )&&$arProps["VALUE"])
					{
						if($arProps["USER_TYPE"]=="directory")
						{
							$arDirVal = $arResult["LIST_PROPS"][$code][$arProps["VALUE"]];
							$arResult["OFFER_TREE_PROPS"][$ID][$code][$arProps["VALUE"]] = $arDirVal;
							$arResult["OFFERS_ID"][$ID][$code][$arProps["VALUE"]][$arOffer["ID"]] = $arOffer["ID"];
							if($arOffer["CAN_BUY"])
							{
								$arResult["CAN_BUY_OFFERS_ID"][$ID][$code][$arProps["VALUE"]][$arOffer["ID"]] = $arOffer["ID"];
							}

						}
					}
				}

				$arResult["PRICES_JS"][$arOffer["ID"]]["DISCOUNT_PRICE"] = $arOffer["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"];
				$arResult["PRICES_JS"][$arOffer["ID"]]["OLD_PRICE"] = $arOffer["MIN_PRICE"]["PRINT_VALUE"];
				$arResult["PRICES_JS"][$arOffer["ID"]]["OLD_PRICE_PERCENT"] = $arOffer["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"];
				if(!$arOffer["CAN_BUY"]&&$availableDelete)
					continue 1;

				if (($arOffer["MIN_PRICE"]["VALUE"]<$minPrice||$minPrice==0)&&(!empty( $arOffer['MIN_PRICE'] )||!empty( $arOffer['RATIO_PRICE'] )))
				{
					$intSelected = $keyOffer;
					$arResult['MIN_PRICE'][$ID] = (isset( $arOffer['RATIO_PRICE'] ) ? $arOffer['RATIO_PRICE'] : $arOffer['MIN_PRICE']);
					$minPrice = $arOffer["MIN_PRICE"]["VALUE"];
				}
			}

			foreach( $Item["OFFERS"] as $arOffer )
			{
				$boolImg = false;
				if(!$arOffer["CAN_BUY"]&&$availableDelete)
					continue 1;
					// if($availableDelete && $arOffer["CAN_BUY"])
				{
					$colorXmlID = $arOffer["PROPERTIES"][$colorCode]["VALUE"];
					if(!$colorXmlID)
						$colorXmlID = 0;
					{
						if($arOffer["DETAIL_PICTURE"]&&!isset( $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID] ))
						{
							if(is_array($arOffer["DETAIL_PICTURE"])){
	                            $DETAIL_PICTURE_ID = $arOffer["DETAIL_PICTURE"]['ID'];
	                        } else{
	                            $DETAIL_PICTURE_ID = $arOffer["DETAIL_PICTURE"];
	                        }
							$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][$DETAIL_PICTURE_ID] = CFile::ResizeImageGet( $arOffer["DETAIL_PICTURE"], array(
									'width' => $smallImg["width"],
									'height' => $smallImg["height"]
							), $RESIZE_MODE, true );
							$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][$DETAIL_PICTURE_ID] = CFile::ResizeImageGet( $arOffer["DETAIL_PICTURE"], array(
									'width' => $mediumImg["width"],
									'height' => $mediumImg["height"]
							), $RESIZE_MODE, true );
							$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["BIG"][$DETAIL_PICTURE_ID] = CFile::ResizeImageGet( $arOffer["DETAIL_PICTURE"], array(
									'width' => $bigImg["width"],
									'height' => $bigImg["height"]
							), $RESIZE_MODE, true );
							if($arOffer["CAN_BUY"]&&isset( $arColorXml[$ID][$colorXmlID] ))
								$arResult["FIRST_COLOR"][$ID] = $colorXmlID;
							$boolImg = true;
						}




						if($arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"]&&(($boolImg&&count( $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"] )==1)||(!$boolImg&&!isset( $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID] ))))
						{
							foreach( $arOffer["PROPERTIES"][$codeOfferMorePhoto]["VALUE"] as $v )
							{
								$arImgSmall = CFile::ResizeImageGet( $v, array(
										'width' => $smallImg["width"],
										'height' => $smallImg["height"]
								), $RESIZE_MODE, true );
								$arImgMedium = CFile::ResizeImageGet( $v, array(
										'width' => $mediumImg["width"],
										'height' => $mediumImg["height"]
								), $RESIZE_MODE, true );
								$arImgBig = CFile::ResizeImageGet( $v, array(
										'width' => $bigImg["width"],
										'height' => $bigImg["height"]
								), $RESIZE_MODE, true );
								if($arImgSmall&&$arImgMedium&&$arImgBig)
								{
									$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][$v] = $arImgSmall;
									$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][$v] = $arImgMedium;
									$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["BIG"][$v] = $arImgBig;
								}
							}
						}
						if(!isset( $arResult["MORE_PHOTO_JS"][$ID][$colorXmlID] ))
						{
							if(isset($Item["DETAIL_PICTURE"]['ID']) && $Item["DETAIL_PICTURE"]['ID']>0)
							{
								$Img=$Item["DETAIL_PICTURE"];
							}
							elseif(isset($Item["PREIVEW_PICTURE"]['ID']) && $Item["PREVIEW_PICTURE"]['ID']>0)
							{
								$Img=$Item["PREVIEW_PICTURE"];
							}

							if(isset($Img))
							{
								$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][$Img['ID']] = CFile::ResizeImageGet( $Img, array(
										'width' => $smallImg["width"],
										'height' => $smallImg["height"]
								), $RESIZE_MODE, true );
								$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][$Img['ID']] = CFile::ResizeImageGet( $Img, array(
										'width' => $mediumImg["width"],
										'height' => $mediumImg["height"]
								), $RESIZE_MODE, true );
								$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["BIG"][$Img['ID']] = CFile::ResizeImageGet( $Img, array(
										'width' => $bigImg["width"],
										'height' => $bigImg["height"]
								), $RESIZE_MODE, true );
								//$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID] = $Item["DETAIL_PICTURE"];
							}

						}




					}
				}
			}

		}
		else
		{

			if(isset( $arResult["DEFAULT_IMAGE"][$ID] ))
			{
				$arResult["MORE_PHOTO_JS"][$ID][0] = $arResult["DEFAULT_IMAGE"][$ID];
				$arResult["FIRST_COLOR"][$ID]=0;
			}
			if(isset( $arResult["MORE_PHOTO_JS"][$ID][0]["SMALL"] )&&is_array( $arResult["MORE_PHOTO_JS"][$ID][0]["SMALL"] )&&isset( $arItem["DEFAULT_OFFER_IMAGE"]["SMALL"] )&&is_array( $arItem["DEFAULT_OFFER_IMAGE"]["SMALL"] ))
				$arResult["MORE_PHOTO_JS"][$ID][0]["SMALL"] = array_merge( $arResult["MORE_PHOTO_JS"][$ID][0]["SMALL"], $arItem["DEFAULT_OFFER_IMAGE"]["SMALL"] );
			if(isset( $arResult["MORE_PHOTO_JS"][$ID][0]["MEDIUM"] )&&is_array( $arResult["MORE_PHOTO_JS"][$ID][0]["MEDIUM"] )&&isset( $arItem["DEFAULT_OFFER_IMAGE"]["MEDIUM"] )&&is_array( $arItem["DEFAULT_OFFER_IMAGE"]["MEDIUM"] ))
				$arResult["MORE_PHOTO_JS"][$ID][0]["MEDIUM"] = array_merge( $arResult["MORE_PHOTO_JS"][$ID][0]["MEDIUM"], $arItem["DEFAULT_OFFER_IMAGE"]["MEDIUM"] );
			if(isset( $arResult["MORE_PHOTO_JS"][$ID][0]["BIG"] )&&is_array( $arResult["MORE_PHOTO_JS"][$ID][0]["BIG"] )&&isset( $arItem["DEFAULT_OFFER_IMAGE"]["BIG"] )&&is_array( $arItem["DEFAULT_OFFER_IMAGE"]["BIG"] ))
				$arResult["MORE_PHOTO_JS"][$ID][0]["BIG"] = array_merge( $arResult["MORE_PHOTO_JS"][$ID][0]["BIG"], $arItem["DEFAULT_OFFER_IMAGE"]["BIG"] );


		}

		if(isset( $arColorXml[$ID] ))
		{
			foreach( $arColorXml[$ID] as $xmlID => $arV )
			{
				if(!isset( $arResult["MORE_PHOTO_JS"][$ID][$xmlID] ))
					$arResult["MORE_PHOTO_JS"][$ID][$xmlID] = $arResult["DEFAULT_IMAGE"][$ID];
			}
		}
	}
	else
	{
		if($Item["DETAIL_PICTURE"])
		{
			$descr = mb_strtolower( $Item["DETAIL_PICTURE"]["DESCRIPTION"] );
			$arDescr = explode( "_", $descr );
			$color = $arDescr[0];
			if($color)
				$arResult["BASE_IMG_COLOR"][$ID][$color] = $color;
		}
		if($Item[$codeMorePhoto])
		{
			foreach( $Item[$codeMorePhoto] as $arPhoto )
			{
				$descr = mb_strtolower( $arPhoto["DESCRIPTION"] );
				$arDescr = explode( "_", $descr );
				$color = $arDescr[0];
				if($color)
					$arResult["BASE_IMG_COLOR"][$ID][$color] = $color;
			}
		}
		if(isset( $Item["OFFERS"] )&&!empty( $Item["OFFERS"] ))
		{
			$arResult["CAN_BUY"][$ID] = false;
			/* �������� �� ������� �������� � ������ */
			foreach( $Item["OFFERS"] as $in => $arOffer )
			{
				if(!$arResult["CAN_BUY"][$ID]&&$arOffer["CAN_BUY"])
					$arResult["CAN_BUY"][$ID] = "Y";
				foreach( $arOffer["PROPERTIES"] as $code => $arProps )
				{
					if(!$arOffer["CAN_BUY"]&&$availableDelete)
						continue 1;
					if($arProps["VALUE"]&&$code==$colorCode)
					{
						if($arProps["USER_TYPE"]=="directory")
						{
							$arDirVal = $arResult["LIST_PROPS"][$code][$arProps["VALUE"]];
							$color = mb_strtolower( $arDirVal["UF_NAME"] );
							$arColorNameAvaible[mb_strtolower( $arDirVal["UF_NAME"] )] = $arDirVal;
							if(!isset( $arResult["BASE_IMG_COLOR"][$ID][$color] )&&$colorDelete)
							{
								unset( $arResult["OFFERS"][$ID][$in] );
							}
							else
							{
								$arColorName[mb_strtolower( $arDirVal["UF_NAME"] )] = $arDirVal;
								$arColorXml[$ID][$arProps["VALUE"]] = $arDirVal;
								if($arOffer["CAN_BUY"]&&(!isset( $arResult["FIRST_COLOR"][$ID] )||!$arResult["FIRST_COLOR"][$ID]))
									$arResult["FIRST_COLOR"][$ID] = $arProps["VALUE"];
							}
						}
					}
				}
			}
			//

			foreach( $Item["OFFERS"] as $arOffer )
			{
				foreach( $arOffer["PROPERTIES"] as $code => $arProps )
				{
					if(!$arOffer["CAN_BUY"]&&$availableDelete)
						continue 1;
					if(in_array( $code, reset($arParams['OFFER_TREE_PROPS']) )&&$arProps["VALUE"])
					{
						if($arProps["USER_TYPE"]=="directory")
						{
							$arDirVal = $arResult["LIST_PROPS"][$code][$arProps["VALUE"]];
							$arResult["OFFER_TREE_PROPS"][$ID][$code][$arProps["VALUE"]] = $arDirVal;
							$arResult["OFFERS_ID"][$ID][$code][$arProps["VALUE"]][$arOffer["ID"]] = $arOffer["ID"];
							if($arOffer["CAN_BUY"])
								$arResult["CAN_BUY_OFFERS_ID"][$ID][$code][$arProps["VALUE"]][$arOffer["ID"]] = $arOffer["ID"];
						}
					}
				}


				$arResult["PRICES_JS"][$arOffer["ID"]]["DISCOUNT_PRICE"] = $arOffer["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"];
				$arResult["PRICES_JS"][$arOffer["ID"]]["OLD_PRICE"] = $arOffer["MIN_PRICE"]["PRINT_VALUE"];
				$arResult["PRICES_JS"][$arOffer["ID"]]["OLD_PRICE_PERCENT"] = $arOffer["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"];
				if(!$arOffer["CAN_BUY"]&&$availableDelete)
					continue 1;
				if (($arOffer["MIN_PRICE"]["VALUE"]<$minPrice||$minPrice==0)&&(!empty( $arOffer['MIN_PRICE'] )||!empty( $arOffer['RATIO_PRICE'] )))
				{
					$intSelected = $keyOffer;
					$arResult['MIN_PRICE'][$ID] = (isset( $arOffer['RATIO_PRICE'] ) ? $arOffer['RATIO_PRICE'] : $arOffer['MIN_PRICE']);
					$minPrice = $arOffer["MIN_PRICE"]["VALUE"];
				}
			}
		}
		if($Item["DETAIL_PICTURE"])
		{
			$descr = mb_strtolower( $Item["DETAIL_PICTURE"]["DESCRIPTION"] );
			$arDescr = explode( "_", $descr );
			$color = $arDescr[0];
			if(isset( $arColorName )&&!empty( $arColorName ))
			{
				$colorXmlID = $arResult["LIST_PROPS_NAME"][$colorCode][mb_strtolower( $color )]["UF_XML_ID"];
				if(!isset( $colorXmlID )||empty( $colorXmlID ))
					$colorXmlID = $arResult["FIRST_COLOR"][$ID];
				if(isset( $colorXmlID )&&!empty( $colorXmlID ))
				{
					if(isset( $arColorName[mb_strtolower( $color )] ))
						$arResult["FIRST_COLOR"][$ID] = $colorXmlID;
					if(isset( $arDescr[1] )&&preg_match( "/[0-9]/", $arDescr[1] ))
					{
						$index = $arDescr[1];
					}
					else
						$index = 0;
					$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][$index] = CFile::ResizeImageGet( $Item["DETAIL_PICTURE"], array(
							'width' => $smallImg["width"],
							'height' => $smallImg["height"]
					), $RESIZE_MODE, true );
					$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][$index] = CFile::ResizeImageGet( $Item["DETAIL_PICTURE"], array(
							'width' => $mediumImg["width"],
							'height' => $mediumImg["height"]
					), $RESIZE_MODE, true );
					$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["BIG"][$index] = CFile::ResizeImageGet( $Item["DETAIL_PICTURE"], array(
							'width' => $bigImg["width"],
							'height' => $bigImg["height"]
					), $RESIZE_MODE, true );
				}
			}
			else
			{
				$index = 0;
				$colorXmlID = 0;
				$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][$index] = CFile::ResizeImageGet( $Item["DETAIL_PICTURE"], array(
						'width' => $smallImg["width"],
						'height' => $smallImg["height"]
				), $RESIZE_MODE, true );
				$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][$index] = CFile::ResizeImageGet( $Item["DETAIL_PICTURE"], array(
						'width' => $mediumImg["width"],
						'height' => $mediumImg["height"]
				), $RESIZE_MODE, true );
				$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["BIG"][$index] = CFile::ResizeImageGet( $Item["DETAIL_PICTURE"], array(
						'width' => $bigImg["width"],
						'height' => $bigImg["height"]
				), $RESIZE_MODE, true );
			}
		}
		if($Item[$codeMorePhoto])
		{
			foreach( $Item[$codeMorePhoto] as $arPhoto )
			{
				$descr = mb_strtolower( $arPhoto["DESCRIPTION"] );
				$arDescr = explode( "_", $descr );
				$color = $arDescr[0];
				if(isset( $arColorName )&&!empty( $arColorName ))
				{
					$colorXmlID = $arResult["LIST_PROPS_NAME"][$colorCode][mb_strtolower( $color )]["UF_XML_ID"];
					if(!isset( $colorXmlID )||empty( $colorXmlID ))
						$colorXmlID = $arResult["FIRST_COLOR"][$ID];
					if(isset( $colorXmlID )&&!empty( $colorXmlID ))
					{
						if(isset( $arDescr[1] )&&preg_match( "/[0-9]/", $arDescr[1] ))
						{
							$index = $arDescr[1];
							$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][$index] = CFile::ResizeImageGet( $arPhoto, array(
									'width' => $smallImg["width"],
									'height' => $smallImg["height"]
							), $RESIZE_MODE, true );
							$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][$index] = CFile::ResizeImageGet( $arPhoto, array(
									'width' => $mediumImg["width"],
									'height' => $mediumImg["height"]
							), $RESIZE_MODE, true );
							$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["BIG"][$index] = CFile::ResizeImageGet( $arPhoto, array(
									'width' => $bigImg["width"],
									'height' => $bigImg["height"]
							), $RESIZE_MODE, true );
						}
						else
						{
							$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][] = CFile::ResizeImageGet( $arPhoto, array(
									'width' => $smallImg["width"],
									'height' => $smallImg["height"]
							), $RESIZE_MODE, true );
							$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][] = CFile::ResizeImageGet( $arPhoto, array(
									'width' => $mediumImg["width"],
									'height' => $mediumImg["height"]
							), $RESIZE_MODE, true );
							$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["BIG"][] = CFile::ResizeImageGet( $arPhoto, array(
									'width' => $bigImg["width"],
									'height' => $bigImg["height"]
							), $RESIZE_MODE, true );
						}
					}
				}
				else
				{
					$colorXmlID = 0;
					$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["SMALL"][] = CFile::ResizeImageGet( $arPhoto, array(
							'width' => $smallImg["width"],
							'height' => $smallImg["height"]
					), $RESIZE_MODE, true );
					$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["MEDIUM"][] = CFile::ResizeImageGet( $arPhoto, array(
							'width' => $mediumImg["width"],
							'height' => $mediumImg["height"]
					), $RESIZE_MODE, true );
					$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["BIG"][] = CFile::ResizeImageGet( $arPhoto, array(
							'width' => $bigImg["width"],
							'height' => $bigImg["height"]
					), $RESIZE_MODE, true );
					end($arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["BIG"]);
					$key = key($arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]["BIG"]);
					$arResult["MORE_PHOTO_JS"][$ID][$colorXmlID]['TITLE'][$key]=$arPhoto["DESCRIPTION"];
				}
			}
			foreach( $arResult["MORE_PHOTO_JS"][$ID] as $key => $arVal )
			{
				ksort( $arResult["MORE_PHOTO_JS"][$ID][$key]["SMALL"] );
				ksort( $arResult["MORE_PHOTO_JS"][$ID][$key]["MEDIUM"] );
				ksort( $arResult["MORE_PHOTO_JS"][$ID][$key]["BIG"] );
			}
			if(isset( $arColorXml[$ID] ))
			{
				foreach( $arColorXml[$ID] as $xmlID => $arV )
				{
					if(!isset( $arResult["MORE_PHOTO_JS"][$ID][$xmlID] ))
						$arResult["MORE_PHOTO_JS"][$ID][$xmlID] = $arResult["DEFAULT_IMAGE"][$ID];

				}
			}
		}
	}

	if(isset( $arResult["OFFER_TREE_PROPS"][$ID] )&&!empty( $arResult["OFFER_TREE_PROPS"][$ID] ))
	{
		$arResult["DEFAULT_OFFER_TREE_PROPS"][$ID] = $arResult["OFFER_TREE_PROPS"][$ID];
		foreach( $arResult["OFFER_TREE_PROPS"][$ID] as $code => $arPropert )
		{
			foreach( $arPropert as $xmlID => $arPropValue )
			{
				$arResult["OFFER_TREE_PROPS_VALUE"][$ID][$code][$xmlID] = $arPropValue["UF_NAME"];
			}
			asort( $arResult["OFFER_TREE_PROPS_VALUE"][$ID][$code] );
		}
		unset( $arResult["OFFER_TREE_PROPS"][$ID] );
		foreach( $arResult["OFFER_TREE_PROPS_VALUE"][$ID] as $code => $arPropert )
		{
			foreach( $arPropert as $xmlID => $propValue )
			{
				$arResult["OFFER_TREE_PROPS"][$ID][$code][$xmlID] = $arResult["DEFAULT_OFFER_TREE_PROPS"][$ID][$code][$xmlID];
			}
		}
	}


	if(count( $arResult["OFFER_TREE_PROPS"][$ID] )==1&&isset( $arResult["OFFER_TREE_PROPS"][$ID][$colorCode] )&&isset( $arColorXml[$ID] ))
	{
		$arResult["FIRST_OFFER_ID"][$ID][$ID] = implode( ",", $arResult["OFFERS_ID"][$ID][$colorCode][$arResult["FIRST_COLOR"][$ID]] );
	}
	elseif(count( $arResult["OFFER_TREE_PROPS"][$ID] )==0&&count( $Item["OFFERS"] )==0)
	{
		if($arResult["CAN_BUY"][$ID])
		{
			$arResult["ADD_URL"][$ID] = str_replace( $arParams["PRODUCT_ID_VARIABLE"]."=", "id=", $arResult["~ADD_URL"] );
			$arResult["OFFER_ADD_URL"][$arResult["ID"]] = $arResult["ADD_URL"]."&ajax_basket=Y";
			$arResult["OFFER_DELAY_URL"][$arResult["ID"]] = str_replace( $arParams["ACTION_VARIABLE"]."=ADD2BASKET", $arParams["ACTION_VARIABLE"]."=DELAY", $arResult["OFFER_ADD_URL"][$arResult["ID"]] );
			$arResult["OFFER_DELAY_URL"][$arResult["ID"]] = str_replace( 'id=','s_id=', $arResult["OFFER_DELAY_URL"][$arResult["ID"]]);

			if(isset($arResult["PRODUCT_PROPS_VALUE"]))
				foreach($arResult["PRODUCT_PROPS_VALUE"] as $Prop=>$Value)
				{
					$arResult["OFFER_ADD_URL"][$arResult["ID"]].='&prop'.urlencode('[').$Prop.urlencode(']').'='.$Value;
					$arResult["OFFER_DELAY_URL"][$arResult["ID"]].='&prop'.urlencode('[').$Prop.urlencode(']').'='.$Value;
				}


			$arResult["FIRST_OFFER_ID"][$ID] = $arResult["ID"];
		}
		else
		{
			$arResult["SUBSCRIBE_URL"] = str_replace( $arParams["PRODUCT_ID_VARIABLE"]."=", "id=", $arResult["~SUBSCRIBE_URL"] );
			$arResult["OFFER_SUBSCRIBE_URL"][$ID] = $arResult["SUBSCRIBE_URL"]."&ajax_basket=Y";
			$arResult["OFFER_SUBSCRIBE_URL"][$arResult["ID"]] = $arResult["SUBSCRIBE_URL"]."&ajax_basket=Y";
			$arResult["OFFER_AVAILABLE_ID"][$arResult["ID"]] = $arResult["ID"];
			if(isset($arResult["PRODUCT_PROPS_VALUE"]))
				foreach($arResult["PRODUCT_PROPS_VALUE"] as $Prop=>$Value)
				{
					$arResult["OFFER_DELAY_URL"][$arResult["ID"]].='&'.$Prop.'='.$Value;
				}

			$arResult["FIRST_OFFER_ID"][$ID] = $arResult["ID"];
		}
	}


	// START OFFER_PROPS
	$arOfferProps = unserialize( COption::GetOptionString( "kit.b2bshop", "OFFER_ELEMENT_PROPS", "" ) );
	$arOfferParams = unserialize( COption::GetOptionString( "kit.b2bshop", "OFFER_ELEMENT_PARAMS", "" ) );
	// END OFFER_PROPS


	foreach( $Item["OFFERS"] as $arOffer )
	{

		// START OFFER_PROPS
						if(!isset( $arResult["OFFER_PROPS"][$ID]['FIRST'] )&&$arOffer['CAN_BUY']&&$arOffer['PROPERTIES'][$arParams["OFFER_COLOR_PROP"]]['VALUE']==$arResult["FIRST_COLOR"][$ID])
						{
							$arResult["OFFER_PROPS"][$ID]['FIRST'] = $arOffer['ID'];
							$arResult['FIRST'][$ID] = $arOffer['ID'];
							$arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE'] = $arOffer['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
							$arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE_OLD'] = $arOffer['MIN_PRICE']['PRINT_VALUE'];
							$arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_PERCENT'] = $arOffer['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
						}
						// END OFFER_PROPS



						if($arOffer["CAN_BUY"])
						{
							$arOffer["ADD_URL"] = str_replace( $arParams["PRODUCT_ID_VARIABLE"]."=", "id=", $arOffer["~ADD_URL"] );
							$arResult["OFFER_ADD_URL"][$arOffer["ID"]] = $arOffer["ADD_URL"]."&ajax_basket=Y";



							$arResult["OFFER_DELAY_URL"][$arOffer["ID"]] = str_replace( $arParams["ACTION_VARIABLE"]."=BUY", $arParams["ACTION_VARIABLE"]."=DELAY", $arResult["OFFER_ADD_URL"][$arOffer["ID"]] );


							$arResult["OFFER_DELAY_URL"][$arOffer["ID"]] = str_replace( 'id=','s_id=', $arResult["OFFER_DELAY_URL"][$arOffer["ID"]]);
							if(count( $arResult["OFFER_TREE_PROPS"][$ID] )==0)
							{
								$arResult["FIRST_OFFER_ID"][$ID] = $arOffer["ID"];
							}
						}
						else
						{
							$arOffer["SUBSCRIBE_URL"] = str_replace( $arParams["PRODUCT_ID_VARIABLE"]."=", "id=", $arOffer["~SUBSCRIBE_URL"] );
							$arResult["OFFER_SUBSCRIBE_URL"][$ID] = $arOffer["SUBSCRIBE_URL"]."&ajax_basket=Y";
							$arResult["OFFER_SUBSCRIBE_URL"][$arOffer["ID"]] = $arOffer["SUBSCRIBE_URL"]."&ajax_basket=Y";
							$arResult["OFFER_AVAILABLE_ID"][$arOffer["ID"]] = $arOffer["ID"];
							if(count( $arResult["OFFER_TREE_PROPS"][$ID] )==0)
								$arResult["FIRST_OFFER_ID"][$ID] = $arOffer["ID"];
						}
						$arProps = $arOffer;


						foreach( $arOffer["PROPERTIES"] as $code => $arProp )
						{
							// START OFFER_PROPS
							if(in_array( $code, $arOfferParams ))
							{
								if(isset( $arResult["LIST_PROPS"][$code][$arProp['VALUE']] )&&!empty( $arResult["LIST_PROPS"][$code][$arProp['VALUE']] ))
									$arResult["OFFER_PROPS"][$ID][$arOffer['ID']]['PROPERTIES'][$code]['VALUE'] = $arResult["LIST_PROPS"][$code][$arProp['VALUE']]['UF_NAME'];
									else
									{
										if(is_array( $arProp['VALUE'] ))
											foreach( $arProp['VALUE'] as $key => $value )
											{
												$arResult["OFFER_PROPS"][$ID][$arOffer['ID']]['PROPERTIES'][$code]['VALUE'] .= $value.' ';
											}
										else
											$arResult["OFFER_PROPS"][$ID][$arOffer['ID']]['PROPERTIES'][$code]['VALUE'] = $arProp['VALUE'];
									}
									$arResult["OFFER_PROPS"][$ID][$arOffer['ID']]['PROPERTIES'][$code]['NAME'] = $arProp['NAME'];
									$arResult["OFFER_PROPS"][$ID][$arOffer['ID']]['PROPERTIES'][$code]['VALUE'] = trim( $arResult["OFFER_PROPS"][$ID][$arOffer['ID']]['PROPERTIES'][$code]['VALUE'] );
							}



							if(!isset( $arResult["OFFER_PROPS"][$ID]['FIRST_PARAM'][$code] )&&$arOffer['CAN_BUY']=="Y"&&$arResult["OFFER_PROPS"][$ID]['FIRST']==$arOffer['ID'])
							{
								$arResult["OFFER_PROPS"][$ID]['FIRST_PARAM'][$code] = $arProp['VALUE'];
							}
							// END OFFER_PROPS
							$arResult["OFFER_TREE_PROPS_NAME"][$ID][$code] = $arProp["NAME"];
						}
	}



	$firstColor = $arResult["FIRST_COLOR"][$ID];
	if(count( $arResult["MORE_PHOTO_JS"][$ID] )>0&&$firstColor===0)
	{
		foreach( $arResult["MORE_PHOTO_JS"][$ID] as $color => $arPreviewColor )
		{
			$arResult["FIRST_COLOR"][$ID] = $color;
			break 1;
		}
	}

	// START OFFER_PROPS
	// IF NO BUY OFFERS
	if((!isset( $arResult["OFFER_PROPS"][$ID]['FIRST'] )||empty( $arResult["OFFER_PROPS"][$ID]['FIRST'] ))&&count( $Item["OFFERS"] )>0)
	{
		foreach( $Item["OFFERS"] as $arOffer )
		{

							if(!isset( $arResult["OFFER_PROPS"][$ID]['FIRST'] )&&$arOffer['PROPERTIES'][$arParams["OFFER_COLOR_PROP"]]['VALUE']==$arResult["FIRST_COLOR"][$ID])
							{



								$arResult["OFFER_PROPS"][$ID]['FIRST'] = $arOffer['ID'];
								$arResult['FIRST'][$ID] = $arOffer['ID'];
								$arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE'] = $arOffer['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
								$arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_VALUE_OLD'] = $arOffer['MIN_PRICE']['PRINT_VALUE'];
								$arResult["OFFER_PROPS"][$ID]['FIRST_PRINT_DISCOUNT_PERCENT'] = $arOffer['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
							}

							if(isset( $arResult["OFFER_PROPS"][$ID]['FIRST'] )&&!empty( $arResult["OFFER_PROPS"][$ID]['FIRST'] ))
								break;
		}
	}
	if(!isset( $arResult["OFFER_PROPS"][$ID]['FIRST'] )||empty( $arResult["OFFER_PROPS"][$ID]['FIRST'] ))
	{
		$arResult["OFFER_PROPS"][$ID]['FIRST'] = 0;
		$arResult['FIRST'][$ID] = 0;
	}
	
	if(!isset($arResult['FIRST_COLOR'][$ID]))
	{
		if(isset($arResult['MORE_PHOTO_JS'][$ID]))
		{
			$arResult['FIRST_COLOR'][$ID] = key($arResult['MORE_PHOTO_JS'][$ID]);
		}
	}
	
	
	$firstColor = $arResult["FIRST_COLOR"][$ID];
	$colorCode = $arParams["OFFER_COLOR_PROP"];





	if(isset( $arResult["OFFER_TREE_PROPS"][$ID] )&&is_array( $arResult["OFFER_TREE_PROPS"][$ID] ))
		foreach( $arResult["OFFER_TREE_PROPS"][$ID] as $codeProp => $arProperties ):


		if($colorCode==$codeProp||!in_array( $codeProp, unserialize( COption::GetOptionString( "kit.b2bshop", "OFFER_TREE_PROPS", "" ) ) ))
			continue;


			$CntNotAvailable = 0;
			foreach( $arProperties as $xmlID => $arProp ):

			if(isset($arResult["OFFERS_ID"][$ID][$codeProp][$xmlID]) && is_array($arResult["OFFERS_ID"][$ID][$codeProp][$xmlID]))
				$arSrav = array_intersect( $arResult["OFFERS_ID"][$ID][$codeProp][$xmlID], $arResult["OFFERS_ID"][$ID][$colorCode][$firstColor] );


			if(empty( $arSrav ))
				++$CntNotAvailable;
			endforeach;

				foreach( $arProperties as $xmlID => $arProp ):
				$li = "";

				if($arResult["OFFER_TREE_PROPS"][$ID][$colorCode]&&$firstColor)
				{

					$arSrav = array_intersect( $arResult["OFFERS_ID"][$ID][$codeProp][$xmlID], $arResult["OFFERS_ID"][$ID][$colorCode][$firstColor] );
					if(empty( $arSrav ))
						$li = "li-disable";
				}
				if(isset( $arResult["CAN_BUY_OFFERS_ID"][$ID][$codeProp][$xmlID] )&&$li!="li-disable"&&$firstColor)
				{
					$arCanBuy = array_intersect( $arResult["OFFERS_ID"][$ID][$codeProp][$xmlID], $arResult["CAN_BUY_OFFERS_ID"][$ID][$colorCode][$firstColor] );
					if(empty( $arCanBuy ))
						$li = "li-available";
				}
				elseif($li!="li-disable"&&!$firstColor)
				{
					$arCanBuy = array_intersect( $arResult["CAN_BUY_OFFERS_ID"][$ID][$codeProp][$xmlID], $arResult["OFFERS_ID"][$ID][$codeProp][$xmlID] );
					if(empty( $arCanBuy ))
						$li = "li-available";
				}
				elseif($li!="li-disable")
				{

					$li = "li-available";
				}
				if(count( $arProperties )-$CntNotAvailable==1&&($li!='li-disable')):
					$li = 'li-active';

					endif;

					if(in_array( $arProp['UF_XML_ID'], $arResult["OFFER_PROPS"][$ID]['FIRST_PARAM'] )&&$li!='li-disable'):
					$li = 'li-active';
					endif;
					$arResult['LI'][$ID][$xmlID] = $li;
					endforeach;
					endforeach;
					// END OFFER_PROPS


					// COLOR LINK START
					if(isset( $arParams["COLOR_IN_PRODUCT"] )&&$arParams["COLOR_IN_PRODUCT"]=="Y"&&isset( $arParams["COLOR_IN_PRODUCT_LINK"] )&&!empty( $arParams["COLOR_IN_PRODUCT_LINK"] ))
					{
						$modelID = $arResult["PROPERTIES"][$arParams["COLOR_IN_PRODUCT_LINK"]]["VALUE"];
						$rsModel = CIBlockElement::GetList( array(), array(
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
								"ACTIVE" => "Y",
								"=PROPERTY_".$arParams["COLOR_IN_PRODUCT_LINK"] => $modelID
						), false, false, array(
								"ID",
								"IBLOCK_ID",
								"NAME",
								"DETAIL_PAGE_URL",
								"PREVIEW_PICTURE",
								"DETAIL_PICTURE"
						) );
						while( $arModel = $rsModel->GetNext() )
						{
							$img = $arModel["PREVIEW_PICTURE"] ? $arModel["PREVIEW_PICTURE"] : $arModel["DETAIL_PICTURE"];
							if($img)
							{
								$arModel["PICTURE"] = CFile::ResizeImageGet( $img, array(
										'width' => $smallImg["width"],
										'height' => $smallImg["height"]
								), $RESIZE_MODE, true );
								//$arModel["PICTURE"] = CFile::GetFileArray( $img );
							}
							$arResult["MODELS"][] = $arModel;
						}
					}
					// COLOR LINK END


					$mxResult = CCatalogSKU::GetInfoByProductIBlock(
							$arParams['IBLOCK_ID']
							);
					if (is_array($mxResult))
					{
						$arResult['OFFERS_IBLOCK']=$mxResult['IBLOCK_ID'];
					}


					$arResult["FANCY"][$i]["ID"] = $Item["ID"];
					$arResult["FANCY"][$i]["DETAIL_PAGE_URL"] = $Item["DETAIL_PAGE_URL"];

					unset($minPrice);

					if(!isset($arResult['MIN_PRICE'][$ID]))
						$arResult['MIN_PRICE'][$ID]=$Item['MIN_PRICE'];


						unset($minPrice);

}

$arResult["RAND"] = $this->randString();
$this->__component->arResultCacheKeys = array_merge( $this->__component->arResultCacheKeys, array(
		'RAND'
) );


?>