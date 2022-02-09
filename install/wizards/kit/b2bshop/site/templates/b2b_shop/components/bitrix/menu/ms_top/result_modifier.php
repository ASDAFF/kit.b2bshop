<?
if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true )
	die();
use Bitrix\Main\Config\Option;

$AddMenuLinks = unserialize( Option::get( "kit.b2bshop", "ADD_MENU_LINKS", 'a:0:{}' ) );
$MenuShow = Option::get( "kit.b2bshop", "MENU_ALL", '-1' );
$ShowThird = Option::get( "kit.b2bshop", "MENU_ALL_THIRD_SHOW", '' );

$RESIZE_MODE = BX_RESIZE_IMAGE_PROPORTIONAL;
if( isset( $arParams["IMAGE_RESIZE_MODE"] ) )
{
	$RESIZE_MODE = $arParams["IMAGE_RESIZE_MODE"];
}

$menu = array();
$previousLevel = 1;
$CatalogMenuCnt = 0;

foreach( $arResult as $key => $arItem )
{
	if( $arItem['PARAMS']['FROM_IBLOCK'] && $arItem['DEPTH_LEVEL'] == 1 )
	{
		++$CatalogMenuCnt;
	}
	
	if( $arItem["DEPTH_LEVEL"] <= $previousLevel )
	{
		$menu_first_key = $key;
		$menu[$menu_first_key] = $arItem;
		$previousLevel = $arItem["DEPTH_LEVEL"];
		$k = 0;
	}
	else
	{
		if( $arItem["DEPTH_LEVEL"] == 3 )
		{
			$LastKey = end( array_keys( $menu[$menu_first_key]["INNER_MENU"] ) );
			$menu[$menu_first_key]["INNER_MENU"][$LastKey]["INNER_MENU"][] = $arItem;
		}
		else
		{
			$menu[$menu_first_key]["INNER_MENU"][$k] = $arItem;
		}
		++$k;
	}
	if( $arItem["DEPTH_LEVEL"] == "1" )
	{
		if( $arItem["LINK"] )
		{
			$arLink[$arItem["LINK"]] = $key;
		}
		$arTextLink[$arItem["TEXT"]] = $key;
		if( $arItem["PARAMS"]["FROM_IBLOCK"] != "1" )
		{
			$menu[$menu_first_key]["URL_TEXT_INNER"] = SITE_DIR . "include/topMenu/" . str_replace( array(
					SITE_DIR,
					"\"",
					"/",
					".php",
					".html" 
			), "", $arItem["LINK"] ) . ".php";
		}
	}
}

$arResult = $menu;
unset( $menu );

$UF_SECOND_TITLE = $arParams["CATALOG_PROP_TEXT"];
$UF_B2BS_BRAND = $arParams["CATALOG_PROP_BRAND"];

$BrandIds = array();

$rsSections = CIBlockSection::GetList( array(), array(
		"IBLOCK_ID" => $arParams["IBLOCK_CATALOG"],
		"DEPTH_LEVEL" => "1" 
), false, array(
		"ID",
		"NAME",
		"SECTION_PAGE_URL",
		$UF_B2BS_BRAND,
		$UF_SECOND_TITLE 
) );
while ( $arSection = $rsSections->GetNext() )
{
	$id = $arSection["ID"];
	$url = $arSection["~SECTION_PAGE_URL"];
	
	if( isset( $arLink[$url] ) )
	{
		if( isset( $arSection[$UF_SECOND_TITLE] ) && !empty( $arSection[$UF_SECOND_TITLE] ) )
		{
			$arResult[$arLink[$url]]["SECOND_TITLE"] = $arSection[$UF_SECOND_TITLE];
		}
		$arResult[$arLink[$url]]["SECTION_ID"] = $id;
		
		
		
		if( isset( $arSection[$UF_B2BS_BRAND] ) && !empty( $arSection[$UF_B2BS_BRAND] ) )
		{
			foreach( $arSection[$UF_B2BS_BRAND] as $brand )
			{
				$arResult[$arLink[$url]]["BRANDS_ID"][] = $brand;
				$BrandIds[] = $brand;
			}
		}
	}
}

if( !empty( $arParams["IBLOCK_BRAND"] ) )
{
	$BrandIds = array_unique( $BrandIds );
	$rsBrands = CIBlockElement::GetList( array(), array(
			'ID' => $BrandIds,
			"IBLOCK_ID" => $arParams["IBLOCK_BRAND"],
			"ACTIVE" => "Y" 
	), false, false, array(
			"ID",
			"IBLOCK_ID",
			"NAME",
			"DETAIL_PAGE_URL" 
	) );
	while ( $arBrand = $rsBrands->GetNext() )
	{
		$arRes["BRANDS"][$arBrand["ID"]] = $arBrand;
	}
}

if( isset( $arRes["BRANDS"] ) && !empty( $arRes["BRANDS"] ) )
{
	$nBrand = Option::get( "kit.b2bshop", "COUNT_BRAND_MENU", "10" );
	foreach( $arRes["BRANDS"] as $brand => $arBrand )
	{
		foreach( $arResult as $key => $arItem )
		{
			if( is_array( $arItem["BRANDS_ID"] ) )
			{
				foreach( $arItem["BRANDS_ID"] as $brand1 )
				{
					if( $brand == $brand1 && count( $arResult[$key]["BRANDS"] ) < $nBrand )
					{
						$arResult[$key]["BRANDS"][] = $arRes["BRANDS"][$brand];
					}
				}
			}
		}
	}
}

if( !empty( $arParams["IBLOCK_BANNER"] ) )
{
	$banner_type = CIBlockPropertyEnum::GetList( Array(), Array(
			"IBLOCK_ID" => $arParams["IBLOCK_BANNER"],
			"XML_ID" => $arParams["PROP_BANNER_TYPE_VIEW"] 
	) );
	$banner_type_fields = $banner_type->fetch();
	
	$arSelectBanner = array(
			"ID",
			"IBLOCK_ID",
			"NAME",
			"CODE",
			"PREVIEW_PICTURE",
			"PROPERTY_LINK",
			"PROPERTY_ELEMENT_FOR_MENU",
			"PROPERTY_BANNER_ADD_TEXT",
			"PROPERTY_BANNER_LEFT_TITLE",
			"PROPERTY_BANNER_LEFT_TEXT",
			"PROPERTY_BANNER_DOP_SECTION",
			"PROPERTY_BANNER_DOP_SECTION_TITLE",
	);
	
	$rsBanners = CIBlockElement::GetList( array(), array(
			"IBLOCK_ID" => $arParams["IBLOCK_BANNER"],
			"PROPERTY_" . $arParams["PROP_BANNER_TYPE"] => $banner_type_fields["ID"],
			"ACTIVE" => "Y" 
	), false, false, $arSelectBanner );
	while ( $arBanners = $rsBanners->Fetch() )
	{
		$ID = $arBanners["ID"];
			if( $arBanners["PROPERTY_BANNER_DOP_SECTION_VALUE"] )
			{
				$arBanners["DOP_SECTION"] = $arBanners["PROPERTY_BANNER_DOP_SECTION_VALUE"]["TEXT"];
			}
			unset( $arBanners["PROPERTY_BANNER_DOP_SECTION_VALUE"], $arBanners["PROPERTY_BANNER_DOP_SECTION_VALUE_ID"] );
			
			if( $arBanners["PROPERTY_BANNER_DOP_SECTION_TITLE_VALUE"] )
			{
				$arBanners["DOP_SECTION_TITLE"] = $arBanners["PROPERTY_BANNER_DOP_SECTION_TITLE_VALUE"];
			}
			unset( $arBanners["PROPERTY_BANNER_DOP_SECTION_TITLE_VALUE"], $arBanners["PROPERTY_BANNER_DOP_SECTION_TITLE_VALUE_ID"] );
			
			if( $arBanners["PROPERTY_LINK_VALUE"] )
			{
				$arBanners["LINK"] = $arBanners["PROPERTY_LINK_VALUE"];
			}
			unset( $arBanners["PROPERTY_LINK_VALUE"], $arBanners["PROPERTY_LINK_VALUE_ID"] );
			
			if( $arBanners["PROPERTY_BANNER_ADD_TEXT_VALUE"] == "Y" )
			{
				$arBanners["ADD_LEFT_TEXT"] = $arBanners["PROPERTY_BANNER_ADD_TEXT_VALUE"];
				if( $arBanners["PROPERTY_BANNER_LEFT_TITLE_VALUE"] )
				{
					$arBanners["LEFT_TITLE"] = $arBanners["PROPERTY_BANNER_LEFT_TITLE_VALUE"];
				}
				if( $arBanners["PROPERTY_BANNER_LEFT_TEXT_VALUE"] )
				{
					$arBanners["LEFT_TEXT"] = $arBanners["PROPERTY_BANNER_LEFT_TEXT_VALUE"];
				}
			}
			unset( $arBanners["PROPERTY_BANNER_LEFT_TITLE_VALUE"], $arBanners["PROPERTY_BANNER_LEFT_TEXT_VALUE"], $arBanners["PROPERTY_BANNER_LEFT_TITLE_VALUE_ID"], $arBanners["PROPERTY_BANNER_LEFT_TEXT_VALUE_ID"] );
			unset( $arBanners["PROPERTY_BANNER_ADD_TEXT_VALUE"], $arBanners["PROPERTY_BANNER_ADD_TEXT_ENUM_ID"], $arBanners["PROPERTY_BANNER_ADD_TEXT_VALUE_ID"] );
			
			if( is_array( $arBanners["PROPERTY_ELEMENT_FOR_MENU_VALUE"] ) )
			{
				$arBanners["CATALOG_ELEMENT_ID"] = $arBanners["PROPERTY_ELEMENT_FOR_MENU_VALUE"];
			}
			elseif( !empty( $arBanners["PROPERTY_ELEMENT_FOR_MENU_VALUE"] ) )
			{
				$arBanners["CATALOG_ELEMENT_ID"][] = $arBanners["PROPERTY_ELEMENT_FOR_MENU_VALUE"];
			}
			unset( $arBanners["PROPERTY_ELEMENT_FOR_MENU_VALUE"], $arBanners["PROPERTY_ELEMENT_FOR_MENU_DESCRIPTION"], $arBanners["PROPERTY_ELEMENT_FOR_MENU_PROPERTY_VALUE_ID"] );
			
			if( $arBanners["CATALOG_ELEMENT_ID"]["0"] && $arBanners["ADD_LEFT_TEXT"] == "Y" && (isset( $arLink[$arBanners["CODE"]] ) || isset( $arTextLink[$arBanners["NAME"]] )) )
			{
				if( !isset( $arRes["BANNER"][$ID] ) )
				{
					$arRes["BANNER"][$ID] = $arBanners;
				}
				elseif( isset( $arRes["BANNER"][$ID]['CATALOG_ELEMENT_ID'] ) )
				{
					$arRes["BANNER"][$ID]['CATALOG_ELEMENT_ID'][] = $arBanners["CATALOG_ELEMENT_ID"]["0"];
				}
				foreach( $arBanners["CATALOG_ELEMENT_ID"] as $item_id )
				{
					$arElementsBannerId[] = $item_id;
				}
				$arRes["BANNER"][$ID]["PREVIEW_PICTURE"] = CFile::GetFileArray( $arBanners["PREVIEW_PICTURE"] );
				if( $arRes["BANNER"][$ID]["ADD_LEFT_TEXT"] == "Y" && ($arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["WIDTH"] > 391 || $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["HEIGHT"] > 354) )
				{
					$previewPic = CFile::ResizeImageGet( $arRes["BANNER"][$ID]["PREVIEW_PICTURE"], array(
							'width' => 391,
							'height' => 354
					), BX_RESIZE_IMAGE_PROPORTIONAL, true );
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"] = $previewPic["height"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"] = $previewPic["width"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["SRC"] = $previewPic["src"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["FILE_SIZE"] = $previewPic["size"];
				}
				elseif( $arRes["BANNER"][$ID]["ADD_LEFT_TEXT"] != "Y" && ($arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["WIDTH"] > 582 || $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["HEIGHT"] > 363) )
				{
					$previewPic = CFile::ResizeImageGet( $arRes["BANNER"][$ID]["PREVIEW_PICTURE"], array(
							'width' => 582,
							'height' => 363
					), BX_RESIZE_IMAGE_PROPORTIONAL, true );
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"] = $previewPic["height"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"] = $previewPic["width"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["SRC"] = $previewPic["src"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["FILE_SIZE"] = $previewPic["size"];
				}
				else
				{
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"] = $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["HEIGHT"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"] = $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["WIDTH"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["SRC"] = $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["SRC"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["FILE_SIZE"] = $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["FILE_SIZE"];
				}
			}
			elseif( $arBanners["PREVIEW_PICTURE"] && (isset( $arLink[$arBanners["CODE"]] ) || isset( $arTextLink[$arBanners["NAME"]] )) )
			{
				$arRes["BANNER"][$ID] = $arBanners;
				$arRes["BANNER"][$ID]["PREVIEW_PICTURE"] = CFile::GetFileArray( $arBanners["PREVIEW_PICTURE"] );
				$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues( $arBanners["IBLOCK_ID"], $arBanners["ID"] );
				$arRes["BANNER"][$ID]["IPROPERTY_VALUES"] = $ipropValues->getValues();
				
				$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["ALT"] = $arRes["BANNER"]["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"];
				if( $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["ALT"] == "" )
				{
					if( $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["DESCRIPTION"] )
					{
						$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["ALT"] = $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["DESCRIPTION"];
					}
					else
					{
						$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["ALT"] = $arBanners["NAME"];
					}
				}
				
				$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["TITLE"] = $arRes["BRAND"]["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"];
				if( $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["TITLE"] == "" )
				{
					if( $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["DESCRIPTION"] )
					{
						$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["TITLE"] = $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["DESCRIPTION"];
					}
					else
					{
						$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["TITLE"] = $arBanners["NAME"];
					}
				}
				
				if( $arRes["BANNER"][$ID]["ADD_LEFT_TEXT"] == "Y" && ($arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["WIDTH"] > 391 || $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["HEIGHT"] > 354) )
				{
					$previewPic = CFile::ResizeImageGet( $arRes["BANNER"][$ID]["PREVIEW_PICTURE"], array(
							'width' => 391,
							'height' => 354 
					), BX_RESIZE_IMAGE_PROPORTIONAL, true );
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"] = $previewPic["height"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"] = $previewPic["width"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["SRC"] = $previewPic["src"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["FILE_SIZE"] = $previewPic["size"];
				}
				elseif( $arRes["BANNER"][$ID]["ADD_LEFT_TEXT"] != "Y" && ($arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["WIDTH"] > 582 || $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["HEIGHT"] > 363) )
				{
					$previewPic = CFile::ResizeImageGet( $arRes["BANNER"][$ID]["PREVIEW_PICTURE"], array(
							'width' => 582,
							'height' => 363 
					), BX_RESIZE_IMAGE_PROPORTIONAL, true );
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"] = $previewPic["height"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"] = $previewPic["width"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["SRC"] = $previewPic["src"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["FILE_SIZE"] = $previewPic["size"];
				}
				else
				{
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"] = $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["HEIGHT"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"] = $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["WIDTH"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["SRC"] = $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["SRC"];
					$arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["RESIZE"]["FILE_SIZE"] = $arRes["BANNER"][$ID]["PREVIEW_PICTURE"]["FILE_SIZE"];
				}
			}
		
	}
	
	//products in banner
	if( is_array( $arElementsBannerId ) )
	{
		$rsItem = CIBlockElement::GetList( array(), array(
				"IBLOCK_ID" => $arParams["IBLOCK_CATALOG"],
				"ID" => $arElementsBannerId 
		), false, false, array(
				"ID",
				"IBLOCK_ID",
				"NAME",
				"DETAIL_PAGE_URL",
				"PREVIEW_PICTURE",
				"DETAIL_PICTURE",
				"PROPERTY_MORE_PHOTO",
				"PROPERTY_MINIMUM_PRICE",
				"PROPERTY_CML2_MANUFACTURER" 
		) );
		while ( $arItem = $rsItem->GetNext() )
		{
			unset( $pic_id );
			if( $arItem["PREVIEW_PICTURE"] )
			{
				$pic_id = $arItem["PREVIEW_PICTURE"];
			}
			elseif( $arItem["DETAIL_PICTURE"] )
			{
				$pic_id = $arItem["DETAIL_PICTURE"];
			}
			elseif( $arItem["PROPERTY_MORE_PHOTO_VALUE"] )
			{
				$pic_id = $arItem["PROPERTY_MORE_PHOTO_VALUE"];
			}
			
			if( $pic_id )
			{
				$arItem["PICTURE"] = CFile::GetFileArray( $pic_id );
			}
			
			if( $arItem["PICTURE"]["ALT"] == "" )
			{
				$arItem["PICTURE"]["ALT"] = $arItem["NAME"];
			}
			
			if( $arItem["PICTURE"]["TITLE"] == "" )
			{
				$arItem["PICTURE"]["TITLE"] = $arItem["NAME"];
			}
			
			if( $arItem["PICTURE"]["HEIGHT"] > 310 || $arItem["PICTURE"]["WIDTH"] > 185 )
			{
				
				$previewPic = CFile::ResizeImageGet( $arItem["PICTURE"], array(
						'width' => 185,
						'height' => 309 
				), $RESIZE_MODE, true );
				$arItem["PICTURE"]["RESIZE"]["HEIGHT"] = $previewPic["height"];
				$arItem["PICTURE"]["RESIZE"]["WIDTH"] = $previewPic["width"];
				$arItem["PICTURE"]["RESIZE"]["SRC"] = $previewPic["src"];
				$arItem["PICTURE"]["RESIZE"]["FILE_SIZE"] = $previewPic["size"];
			}
			else
			{
				$arItem["PICTURE"]["RESIZE"]["HEIGHT"] = $arItem["PICTURE"]["HEIGHT"];
				$arItem["PICTURE"]["RESIZE"]["WIDTH"] = $arItem["PICTURE"]["WIDTH"];
				$arItem["PICTURE"]["RESIZE"]["SRC"] = $arItem["PICTURE"]["SRC"];
				$arItem["PICTURE"]["RESIZE"]["FILE_SIZE"] = $arItem["PICTURE"]["FILE_SIZE"];
			}
			$arItem["BRAND"] = $arItem["PROPERTY_CML2_MANUFACTURER_VALUE"];
			
			$allBannerCatalog[$arItem["ID"]] = $arItem;
		}
		
		if( is_array( $arParams["PRICE_CODE"] ) )
		{
			$typePrice = $arParams["PRICE_CODE"];
		}
		else
		{
			$typePrice = array(
					'BASE' 
			);
		}

		$idUserGroups = [];
		$userPriceCode = [];
		$rs = CCatalogGroup::GetGroupsList(array("GROUP_ID"=>$USER->GetGroups(), "BUY"=>"Y"));
		while($group = $rs->Fetch())
		{
			$idUserGroups[$group['CATALOG_GROUP_ID']] = $group['CATALOG_GROUP_ID'];
		}
		if($idUserGroups)
		{
			$rs = \Bitrix\Catalog\GroupTable::getList(['filter' => ['ID' => $idUserGroups],'select' => ['NAME']]);
			while($group = $rs->fetch())
			{
				$userPriceCode[] = $group['NAME'];
			}
		}
		if(!$userPriceCode)
		{
			$userPriceCode = $typePrice;
		}

		$resPrice = CIBlockPriceTools::GetCatalogPrices( $arParams["IBLOCK_CATALOG"], $userPriceCode );
		$arMinPrice = array();
		if( $arParams["MENU_CACHE_TYPE"] != "N" )
		{
			$cache_id = md5( serialize( $arParams ) );
			$cache_dir = "/top_menu";
			
			$obCache = new CPHPCache();
			if( $obCache->InitCache( $arParams["MENU_CACHE_TIME"], $cache_id, $cache_dir ) )
			{
				$arMinPrice = $obCache->GetVars();
			}
			elseif( $obCache->StartDataCache() )
			{
				// find offers iblock
				$mxResult = CCatalogSKU::GetInfoByProductIBlock( $arParams["IBLOCK_CATALOG"] );
				
				$Sort = array();
				$PricesIds = array();
				foreach( $resPrice as $Price )
				{
					if( $Price['CAN_BUY'] && $Price['CAN_VIEW'] )
					{
						$Sort['CATALOG_PRICE_SCALE_' . $Price['ID']] = 'ASC';
						$PricesIds[] = $Price['ID'];
					}
				}
				
				if( is_array( $mxResult ) )
				{
					$rsOffers = CIBlockElement::GetList( $Sort, array(
							'IBLOCK_ID' => $mxResult['IBLOCK_ID'],
							'PROPERTY_' . $mxResult['SKU_PROPERTY_ID'] => $arElementsBannerId 
					), false, false, array(
							'ID',
							'PROPERTY_' . $mxResult['SKU_PROPERTY_ID'] 
					) );
					$PrevProd = 0;
					while ( $arOffer = $rsOffers->fetch() )
					{
						if( $PrevProd != $arOffer['PROPERTY_' . $mxResult['SKU_PROPERTY_ID'] . '_VALUE'] )
						{
							$idUserGroups = [];
							$rs = CCatalogGroup::GetGroupsList(array("GROUP_ID"=>$USER->GetGroups(), "BUY"=>"Y"));
							while($group = $rs->Fetch())
							{
								$idUserGroups[$group['CATALOG_GROUP_ID']] = $group['CATALOG_GROUP_ID'];
							}

							$ar_price = GetCatalogProductPriceList( $arOffer["ID"], 'PRICE', 'ASC' );
							
							foreach( $ar_price as $Price )
							{
								if(!in_array($Price['CATALOG_GROUP_ID'],$idUserGroups))
									continue;

								if( !isset( $MinPrice ) || (isset( $Price['PRICE'] ) && $Price['PRICE'] < $MinPrice) )
								{
									
									$arDiscounts = CCatalogDiscount::GetDiscountByPrice( $Price["ID"], $USER->GetUserGroupArray(), "N", SITE_ID );
									$discountPrice = CCatalogProduct::CountPriceWithDiscount( $Price["PRICE"], $Price["CURRENCY"], $arDiscounts );
									$Price["DISCOUNT_PRICE"] = $discountPrice;
									
									$Price['PRINT_DISCOUNT_VALUE'] = CurrencyFormat( $Price["DISCOUNT_PRICE"], $Price['CURRENCY'] );
									$Price['PRINT_VALUE'] = CurrencyFormat( $Price["PRICE"], $Price['CURRENCY'] );
									
									$arMinPrice[$arOffer['PROPERTY_' . $mxResult['SKU_PROPERTY_ID'] . '_VALUE']] = $Price;
									$MinPrice = $Price['PRICE'];
								}
							}
							unset( $MinPrice );
							$PrevProd = $arOffer['PROPERTY_' . $mxResult['SKU_PROPERTY_ID'] . '_VALUE'];
							$key = array_search( $arOffer['PROPERTY_' . $mxResult['SKU_PROPERTY_ID'] . '_VALUE'], $arElementsBannerId );
							unset( $arElementsBannerId[$key] );
						}
					}
				}
				// if product without offers
				if( isset( $arElementsBannerId ) )
				{
					foreach( $arElementsBannerId as $ProductId )
					{
						$ar_price = GetCatalogProductPriceList( $ProductId, 'PRICE', 'ASC' );
						$idUserGroups = [];
						$rs = CCatalogGroup::GetGroupsList(array("GROUP_ID"=>$USER->GetGroups(), "BUY"=>"Y"));
						while($group = $rs->Fetch())
						{
							$idUserGroups[$group['CATALOG_GROUP_ID']] = $group['CATALOG_GROUP_ID'];
						}

						foreach( $ar_price as $Price )
						{
							if(!in_array($Price['CATALOG_GROUP_ID'],$idUserGroups))
								continue;

							if( !isset( $MinPrice ) || (isset( $Price['PRICE'] ) && $Price['PRICE'] < $MinPrice) )
							{
								
								$arDiscounts = CCatalogDiscount::GetDiscountByPrice( $Price["ID"], $USER->GetUserGroupArray(), "N", SITE_ID );
								$discountPrice = CCatalogProduct::CountPriceWithDiscount( $Price["PRICE"], $Price["CURRENCY"], $arDiscounts );
								$Price["DISCOUNT_PRICE"] = $discountPrice;
								
								$Price['PRINT_DISCOUNT_VALUE'] = CurrencyFormat( $Price["DISCOUNT_PRICE"], $Price['CURRENCY'] );
								$Price['PRINT_VALUE'] = CurrencyFormat( $Price["PRICE"], $Price['CURRENCY'] );
								
								$arMinPrice[$ProductId] = $Price;
								$MinPrice = $Price['PRICE'];
							}
						}
					}
				}
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache( $cache_dir );
				foreach( $arMinPrice as $key => $MinPrice )
				{
					$CACHE_MANAGER->RegisterTag( "iblock_id_" . $key );
				}
				$CACHE_MANAGER->RegisterTag( "iblock_id_new" );
				$CACHE_MANAGER->EndTagCache();
				
				$obCache->EndDataCache( $arMinPrice );
			}
			else
			{
				$arMinPrice = array();
			}
		}
		else
		{
			// find offers iblock
			$mxResult = CCatalogSKU::GetInfoByProductIBlock( $arParams["IBLOCK_CATALOG"] );
			
			$Sort = array();
			$PricesIds = array();
			foreach( $resPrice as $Price )
			{
				if( $Price['CAN_BUY'] && $Price['CAN_VIEW'] )
				{
					$Sort['CATALOG_PRICE_SCALE_' . $Price['ID']] = 'ASC';
					$PricesIds[] = $Price['ID'];
				}
			}
			
			if( is_array( $mxResult ) )
			{
				$rsOffers = CIBlockElement::GetList( $Sort, array(
						'IBLOCK_ID' => $mxResult['IBLOCK_ID'],
						'PROPERTY_' . $mxResult['SKU_PROPERTY_ID'] => $arElementsBannerId 
				), false, false, array(
						'ID',
						'PROPERTY_' . $mxResult['SKU_PROPERTY_ID'] 
				) );
				$PrevProd = 0;
				while ( $arOffer = $rsOffers->fetch() )
				{
					if( $PrevProd != $arOffer['PROPERTY_' . $mxResult['SKU_PROPERTY_ID'] . '_VALUE'] )
					{
						$ar_price = GetCatalogProductPriceList( $arOffer["ID"], 'PRICE', 'ASC' );

						$idUserGroups = [];
						$rs = CCatalogGroup::GetGroupsList(array("GROUP_ID"=>$USER->GetGroups(), "BUY"=>"Y"));
						while($group = $rs->Fetch())
						{
							$idUserGroups[$group['CATALOG_GROUP_ID']] = $group['CATALOG_GROUP_ID'];
						}

						foreach( $ar_price as $Price )
						{
							if(!in_array($Price['CATALOG_GROUP_ID'],$idUserGroups))
								continue;
							
							if( !isset( $MinPrice ) || (isset( $Price['PRICE'] ) && $Price['PRICE'] < $MinPrice) )
							{
								
								$arDiscounts = CCatalogDiscount::GetDiscountByPrice( $Price["ID"], $USER->GetUserGroupArray(), "N", SITE_ID );
								$discountPrice = CCatalogProduct::CountPriceWithDiscount( $Price["PRICE"], $Price["CURRENCY"], $arDiscounts );
								$Price["DISCOUNT_PRICE"] = $discountPrice;
								
								$Price['PRINT_DISCOUNT_VALUE'] = CurrencyFormat( $Price["DISCOUNT_PRICE"], $Price['CURRENCY'] );
								$Price['PRINT_VALUE'] = CurrencyFormat( $Price["PRICE"], $Price['CURRENCY'] );
								
								$arMinPrice[$arOffer['PROPERTY_' . $mxResult['SKU_PROPERTY_ID'] . '_VALUE']] = $Price;
								$MinPrice = $Price['PRICE'];
							}
						}
						unset( $MinPrice );
						$PrevProd = $arOffer['PROPERTY_' . $mxResult['SKU_PROPERTY_ID'] . '_VALUE'];
						$key = array_search( $arOffer['PROPERTY_' . $mxResult['SKU_PROPERTY_ID'] . '_VALUE'], $arElementsBannerId );
						unset( $arElementsBannerId[$key] );
					}
				}
			}
			// if product without offers
			if( isset( $arElementsBannerId ) )
			{
				foreach( $arElementsBannerId as $ProductId )
				{
					$ar_price = GetCatalogProductPriceList( $ProductId, 'PRICE', 'ASC' );
					foreach( $ar_price as $Price )
					{
						if( !isset( $MinPrice ) || (isset( $Price['PRICE'] ) && $Price['PRICE'] < $MinPrice) )
						{
							
							$arDiscounts = CCatalogDiscount::GetDiscountByPrice( $Price["ID"], $USER->GetUserGroupArray(), "N", SITE_ID );
							$discountPrice = CCatalogProduct::CountPriceWithDiscount( $Price["PRICE"], $Price["CURRENCY"], $arDiscounts );
							$Price["DISCOUNT_PRICE"] = $discountPrice;
							
							$Price['PRINT_DISCOUNT_VALUE'] = CurrencyFormat( $Price["DISCOUNT_PRICE"], $Price['CURRENCY'] );
							$Price['PRINT_VALUE'] = CurrencyFormat( $Price["PRICE"], $Price['CURRENCY'] );
							
							$arMinPrice[$ProductId] = $Price;
							$MinPrice = $Price['PRICE'];
						}
					}
				}
			}
		}
		
		foreach( $arMinPrice as $ProductId => $MinPrice )
		{
			if( $MinPrice['PRICE'] )
			{
				$allBannerCatalog[$ProductId]["MIN_PRICE"]["VALUE"] = $MinPrice['PRICE'];
				$allBannerCatalog[$ProductId]["MIN_PRICE"]["PRINT_VALUE"] = $MinPrice['PRINT_VALUE'];
			}
			if( $MinPrice['DISCOUNT_PRICE'] && $MinPrice['DISCOUNT_PRICE'] != $MinPrice['PRICE'] )
			{
				$allBannerCatalog[$ProductId]["MIN_PRICE"]["DISCOUNT_VALUE"] = $MinPrice['DISCOUNT_PRICE'];
				$allBannerCatalog[$ProductId]["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"] = $MinPrice['PRINT_DISCOUNT_VALUE'];
			}
		}
		unset( $arMinPrice );
	}

	
	foreach( $arRes["BANNER"] as $key_Banner => $Banner )
	{
		if( $Banner["CATALOG_ELEMENT_ID"]["0"] )
		{
			foreach( $Banner["CATALOG_ELEMENT_ID"] as $key => $item_id )
			{
				$Banner["CATALOG_ELEMENT"][$key] = $allBannerCatalog[$item_id];
			}
		}
		
		if( isset( $arLink[$Banner["CODE"]] ) )
		{
			$item_key = $arLink[$Banner["CODE"]];
		}
		elseif( isset( $arTextLink[$Banner["NAME"]] ) )
		{
			$item_key = $arTextLink[$Banner["NAME"]];
		}
		
		$arResult[$item_key]["BANNER"] = $Banner;
	}
}





if( isset( $AddMenuLinks ) && is_array( $AddMenuLinks ) && count( $AddMenuLinks ) > 0 )
{
	foreach( $arResult as $key => $arItem )
	{
		foreach( $AddMenuLinks as $j => $AddMenuLink )
		{
			if( !isset( $AddMenuLink['ADD_MENU_LINKS_TITLE'] ) || empty( $AddMenuLink['ADD_MENU_LINKS_TITLE'] ) || !isset( $AddMenuLink['ADD_MENU_LINKS_URL'] ) || empty( $AddMenuLink['ADD_MENU_LINKS_URL'] ) )
			{
				continue;
			}
			if( $AddMenuLink['ADD_MENU_LINKS_PARENT_LINK'] == $arItem['LINK'] )
			{
				if( isset( $AddMenuLink['ADD_MENU_LINKS_SORT'] ) && $AddMenuLink['ADD_MENU_LINKS_SORT'] > 0 )
				{
					if( $AddMenuLink['ADD_MENU_LINKS_SORT'] < count( $arItem['INNER_MENU'] ) )
					{
						$TmpMenu = $arResult[$key]['INNER_MENU'];
						$FirstPart = array_slice( $TmpMenu, 0, $AddMenuLink['ADD_MENU_LINKS_SORT'] - 1 );
						
						$SecondPart = array_slice( $TmpMenu, $AddMenuLink['ADD_MENU_LINKS_SORT'] - 1, count( $TmpMenu ) - $AddMenuLink['ADD_MENU_LINKS_SORT'] + 1 );
						$arResult[$key]['INNER_MENU'] = $FirstPart;
						
						if( !isset( $arResult[$key]['INNER_MENU'] ) || count( $arResult[$key]['INNER_MENU'] ) == 0 )
						{
							$max = 0;
						}
						else
							$max = max( array_keys( $arResult[$key]['INNER_MENU'] ) );
						if( isset( $arResult[$key]['INNER_MENU'][$max + 1] ) )
							$arResult[$key]['INNER_MENU'][$max + 2] = array(
									'TEXT' => $AddMenuLink['ADD_MENU_LINKS_TITLE'],
									'LINK' => $AddMenuLink['ADD_MENU_LINKS_URL'],
									'SELECTED' => 0 
							);
						else
							$arResult[$key]['INNER_MENU'][$max + 1] = array(
									'TEXT' => $AddMenuLink['ADD_MENU_LINKS_TITLE'],
									'LINK' => $AddMenuLink['ADD_MENU_LINKS_URL'],
									'SELECTED' => 0 
							);
						
						$arResult[$key]['INNER_MENU'] = array_merge( $arResult[$key]['INNER_MENU'], $SecondPart );
						unset( $AddMenuLinks[$j] );
						unset( $TmpMenu );
						unset( $FirstPart );
						unset( $SecondPart );
						unset( $max );
					}
					else
					{
						if( !isset( $arResult[$key]['INNER_MENU'] ) || count( $arResult[$key]['INNER_MENU'] ) == 0 )
						{
							$max = 0;
						}
						else
							$max = max( array_keys( $arResult[$key]['INNER_MENU'] ) );
						
						$arResult[$key]['INNER_MENU'][$max + 1] = array(
								'TEXT' => $AddMenuLink['ADD_MENU_LINKS_TITLE'],
								'LINK' => $AddMenuLink['ADD_MENU_LINKS_URL'],
								'SELECTED' => 0 
						);
						unset( $AddMenuLinks[$j] );
					}
				}
				else
				{
					if( !isset( $arResult[$key]['INNER_MENU'] ) || count( $arResult[$key]['INNER_MENU'] ) == 0 )
					{
						$max = 0;
					}
					else
						$max = max( array_keys( $arResult[$key]['INNER_MENU'] ) );
					$arResult[$key]['INNER_MENU'][$max + 1] = array(
							'TEXT' => $AddMenuLink['ADD_MENU_LINKS_TITLE'],
							'LINK' => $AddMenuLink['ADD_MENU_LINKS_URL'],
							'SELECTED' => 0 
					);
					unset( $AddMenuLinks[$j] );
				}
			}
		}
	}

	// third level
	foreach( $arResult as $key => $arItem )
	{
		if( isset( $arItem['INNER_MENU'] ) && is_array( $arItem['INNER_MENU'] ) && count( $arItem['INNER_MENU'] ) > 0 )
		{
			foreach( $arItem['INNER_MENU'] as $key3 => $arItem3 )
			{
				foreach( $AddMenuLinks as $j => $AddMenuLink )
				{
					if( !isset( $AddMenuLink['ADD_MENU_LINKS_TITLE'] ) || empty( $AddMenuLink['ADD_MENU_LINKS_TITLE'] ) || !isset( $AddMenuLink['ADD_MENU_LINKS_URL'] ) || empty( $AddMenuLink['ADD_MENU_LINKS_URL'] ) )
					{
						continue;
					}
					if( $AddMenuLink['ADD_MENU_LINKS_PARENT_LINK'] == $arItem3['LINK'] )
					{
						if( isset( $AddMenuLink['ADD_MENU_LINKS_SORT'] ) && $AddMenuLink['ADD_MENU_LINKS_SORT'] > 0 )
						{
							if( $AddMenuLink['ADD_MENU_LINKS_SORT'] < count( $arItem3['INNER_MENU'] ) )
							{
								$TmpMenu = $arItem3['INNER_MENU'];
								$FirstPart = array_slice( $TmpMenu, 0, $AddMenuLink['ADD_MENU_LINKS_SORT'] - 1 );
								$SecondPart = array_slice( $TmpMenu, $AddMenuLink['ADD_MENU_LINKS_SORT'] - 1, count( $TmpMenu ) - $AddMenuLink['ADD_MENU_LINKS_SORT'] );
								$arResult[$key]['INNER_MENU'][$key3]['INNER_MENU'] = $FirstPart;
								array_push( $arResult[$key]['INNER_MENU'][$key3]['INNER_MENU'], array(
										'TEXT' => $AddMenuLink['ADD_MENU_LINKS_TITLE'],
										'LINK' => $AddMenuLink['ADD_MENU_LINKS_URL'],
										'SELECTED' => 0 
								) );
								$arResult[$key]['INNER_MENU'][$key3]['INNER_MENU'] = array_merge( $arResult[$key]['INNER_MENU'][$key3]['INNER_MENU'], $SecondPart );
								unset( $AddMenuLinks[$j] );
								unset( $TmpMenu );
								unset( $FirstPart );
								unset( $SecondPart );
							}
							else
							{
								if( !isset( $arItem3['INNER_MENU'] ) || count( $arItem3['INNER_MENU'] ) == 0 )
								{
									$max = 0;
								}
								else
								{
									$max = max( array_keys( $arItem3['INNER_MENU'] ) );
								}
								$arResult[$key]['INNER_MENU'][$key3]['INNER_MENU'][$max + 1] = array(
										'TEXT' => $AddMenuLink['ADD_MENU_LINKS_TITLE'],
										'LINK' => $AddMenuLink['ADD_MENU_LINKS_URL'],
										'SELECTED' => 0 
								);
								unset( $AddMenuLinks[$j] );
								unset( $max );
							}
						}
						else
						{
							if( !isset( $arItem3['INNER_MENU'] ) || count( $arItem3['INNER_MENU'] ) == 0 )
							{
								$max = 0;
							}
							else
							{
								$max = max( array_keys( $arItem3['INNER_MENU'] ) );
							}
							$arResult[$key]['INNER_MENU'][$key3]['INNER_MENU'][$max + 1] = array(
									'TEXT' => $AddMenuLink['ADD_MENU_LINKS_TITLE'],
									'LINK' => $AddMenuLink['ADD_MENU_LINKS_URL'],
									'SELECTED' => 0 
							);
							unset( $AddMenuLinks[$j] );
							unset( $max );
						}
					}
				}
			}
		}
	}
}

// for third level
array_unshift( $arResult, array(
		'MENU_SHOW' => $MenuShow,
		'CATALOG_MENU_CNT' => $CatalogMenuCnt,
		'SHOW_THIRD' => $ShowThird 
) );


unset( $allBannerCatalog );
unset( $arRes );



?>