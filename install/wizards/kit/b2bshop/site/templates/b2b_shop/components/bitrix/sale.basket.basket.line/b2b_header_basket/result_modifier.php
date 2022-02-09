<?
if(!defined( "B_PROLOG_INCLUDED" )||B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Config\Option;
$COLOR_IN_PRODUCT=Option::get( "kit.b2bshop", "COLOR_IN_PRODUCT", "" );
$BrandProperty = Option::get( "kit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", "" );
$arResult["IMG_WIDTH"] = Option::get( "kit.b2bshop", "LIST_WIDTH_SMALL", "69" );
$arResult["IMG_HEIGHT"] = Option::get( "kit.b2bshop", "LIST_HEIGHT_SMALL", "116" );
$imageFromOffer = (Option::get("kit.b2bshop", "PICTURE_FROM_OFFER", "")=="Y")?1:0;
$ProductsId = array();
$Offers = array();
$arResult["PROPS"] = array();
$arResult['COST'] = 0;
$arResult['QNT'] = 0;
$currency = "RUB";
$BasketIds = array();
$ProductIds = array();
$OffersIds = array();
$codeMorePhoto = "MORE_PHOTO";
// find products
foreach( $arResult['CATEGORIES'] as $CategoryCode => $Category )
{
	foreach( $Category as $Product )
	{
		if($Product["CAN_BUY"]=="Y"&&$Product["DELAY"]=="N"&&$Product['SUBSCRIBE']=="N")
		{
			if($Product['CAN_BUY'])
			{
				$arResult['QNT'] += $Product['QUANTITY'];
				$arResult['COST'] += $Product['PRICE']*$Product['QUANTITY'];
				$currency = $Product['CURRENCY'];
				$OffersIds[] = $Product['PRODUCT_ID'];
				$BasketIds[] = $Product['ID'];
				$arResult['NAMES'][$Product['PRODUCT_ID']]=$Product['NAME'];
			}
		}
	}
}
unset($Category);
unset($CategoryCode);
unset($Product);
if(sizeof($BasketIds) > 0)
{
	//get properties
	$dbProp = CSaleBasket::GetPropsList( array(
			"SORT" => "ASC",
			"ID" => "ASC"
	), array(
			"BASKET_ID" => $BasketIds,
			"!CODE" => array(
					"CATALOG.XML_ID",
					"PRODUCT.XML_ID"
			)
	),false,false,array('BASKET_ID','NAME','VALUE','CODE') );
	while( $arProp = $dbProp->fetch() )
	{
		$arResult["PROPS"][$arProp["BASKET_ID"]][$arProp["CODE"]] = $arProp;
	}
	unset($dbProp);
	unset($arProp);
	unset($BasketIds);
}
if(is_array($OffersIds) && count($OffersIds)>0)
{
	// find images
	$ImagesIds=array();
	$arProdOfferIds=array();
	if($COLOR_IN_PRODUCT=="Y")
	{
		$Products=CCatalogSKU::getProductList($OffersIds,0);
		foreach($Products as $key=>$Product)
		{
			$ImagesIds[]=$Product['ID'];
			$ProductIds[]=$Product['ID'];
			$arProdOfferIds[$key]=$Product['ID'];
		}
	}
	elseif($imageFromOffer)
	{
		$Products=CCatalogSKU::getProductList($OffersIds,0);
		foreach($Products as $key=>$Product)
		{
			$ProductIds[]=$Product['ID'];
		}
		$ImagesIds=$OffersIds;
	}
	else
	{
		$Products=CCatalogSKU::getProductList($OffersIds,0);
		foreach($Products as $key=>$Product)
		{
			$ImagesIds[]=$Product['ID'];
			$ProductIds[]=$Product['ID'];
			$arProdOfferIds[$key]=$Product['ID'];
		}
	}
	$ProductIds = array_unique($ProductIds);

	$arIds = $ImagesIds;
	if(is_array($ProductIds))
	{
		$arIds = array_merge($ImagesIds,$ProductIds);
		$arIds = array_unique($arIds);
	}
	
	$rsElement = CIBlockElement::GetList( array(), array(
			"=ID" => $arIds
	), false, false, array(
			"ID",
			"NAME",
			"PREVIEW_PICTURE",
			"DETAIL_PICTURE",
			"PROPERTY_".$codeMorePhoto,
			'PROPERTY_'.$BrandProperty
	) );
	while( $arElement = $rsElement->Fetch() )
	{
		if(in_array($arElement['ID'],$ImagesIds)) //get images
		{
			if($COLOR_IN_PRODUCT=="Y")
			{
				$ID=array_search($arElement['ID'], $arProdOfferIds);
				unset($arProdOfferIds[$ID]);
			}
			elseif($imageFromOffer)
			{
				$ID=$arElement['ID'];
			}
			else
			{
				$ID=array_search($arElement['ID'], $arProdOfferIds);
				unset($arProdOfferIds[$ID]);
			}
			if(isset( $arResult["PICTURE"][$ID] )&&!empty( $arResult["PICTURE"][$ID] ))
			{
				continue;
			}
			if(isset( $arElement['PREVIEW_PICTURE'] )&&!empty( $arElement['PREVIEW_PICTURE'] ))
			{
				$arResult["PICTURE"][$ID] = CFile::ResizeImageGet( $arElement['PREVIEW_PICTURE'], array(
						'width' => $arResult["IMG_WIDTH"],
						'height' => $arResult["IMG_HEIGHT"]
				), BX_RESIZE_IMAGE_PROPORTIONAL, true );
			}
			elseif(isset( $arElement['DETAIL_PICTURE'] )&&!empty( $arElement['DETAIL_PICTURE'] ))
			{
				$arResult["PICTURE"][$ID] = CFile::ResizeImageGet( $arElement['DETAIL_PICTURE'], array(
						'width' => $arResult["IMG_WIDTH"],
						'height' => $arResult["IMG_HEIGHT"]
				), BX_RESIZE_IMAGE_PROPORTIONAL, true );
			}
			elseif(isset( $arElement["PROPERTY_".$codeMorePhoto."_VALUE"] )&&!empty( $arElement["PROPERTY_".$codeMorePhoto."_VALUE"] ))
			{
				$arResult["PICTURE"][$ID] = CFile::ResizeImageGet( $arElement["PROPERTY_".$codeMorePhoto."_VALUE"], array(
						'width' => $arResult["IMG_WIDTH"],
						'height' => $arResult["IMG_HEIGHT"]
				), BX_RESIZE_IMAGE_PROPORTIONAL, true );
			}
		}
		elseif(in_array($arElement['ID'],$ProductIds)) //get brands
		{
			if($arElement['PROPERTY_'.$BrandProperty.'_VALUE'])
			{
				$BrandsIds[] = $arElement['PROPERTY_'.$BrandProperty.'_VALUE'];
				$Brands[$arElement['ID']]=$arElement['PROPERTY_'.$BrandProperty.'_VALUE'];
			}
		}
	}
	//get brands name
	$result = \Bitrix\Iblock\ElementTable::getList(array(
			'select' => array('ID','NAME'),
			'filter' => array("ID" => $BrandsIds,"ACTIVE" => "Y")
	));
	while ($Brand = $result->fetch())
	{
		foreach($Brands as $ProductId=>$BrandId)
		{
			if($BrandId==$Brand['ID'])
			{
				$Brands[$ProductId] = $Brand['NAME'];
			}
		}
	}
	
	foreach($Products as $OfferId=>$Product)
	{
		if($Brands[$Product['ID']])
		{
			$arResult['BRANDS'][$OfferId]=$Brands[$Product['ID']];
		}
	}

	// sum cost
	$arResult['COST'] = SaleFormatCurrency( $arResult['COST'], $currency );
	// tovarov okonchnie
	$arResult['OKONCHANIE'] = '';
	$words = array(
			GetMessage( "TSB1_WORD_END1" ),
			GetMessage( "TSB1_WORD_END2" ),
			GetMessage( "TSB1_WORD_END3" )
	);
	$num = $arResult['QNT'];
	$num = $num%100;
	if($num>19)
	{
		$num = $num%10;
	}
	switch($num)
	{
		case 1 :
			{
				$productS = $words[0];
				break;
			}
		case 2 :
		case 3 :
		case 4 :
			{
				$productS = $words[1];
				break;
			}
		default :
			{
				$productS = $words[2];
			}
	}
	$arResult['PRODUCT_QNT'] = $productS;
}