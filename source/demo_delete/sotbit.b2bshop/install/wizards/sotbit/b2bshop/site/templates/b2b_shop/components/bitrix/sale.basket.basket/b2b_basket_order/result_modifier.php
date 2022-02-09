<?
use Bitrix\Main\Config\Option;

$all_quantity = 0;
$all_cost = 0;

$arResult['PROPS'] = array();

$isDelay = isset( $_REQUEST["delay"] ) ? 1 : 0;


$colorCode = Option::get('sotbit.b2bshop','OFFER_COLOR_PROP','');

if( isset( $_REQUEST["delay"] ) )
{
	$isDelay = 1;
	$_SESSION["ms_delay"] = 1;
}
else
{
	$isDelay = 0;
	if( isset( $_REQUEST["basket"] ) && isset( $_SESSION["ms_delay"] ) )
	{
		unset( $_SESSION["ms_delay"] );
	}
}

if( isset( $_SESSION["ms_delay"] ) )
{
	$isDelay = 1;
	if( empty( $arResult["ITEMS"]["DelDelCanBuy"] ) )
	{
		$isDelay = 0;
		unset( $_SESSION["ms_delay"] );
	}
}

if( $isDelay )
{
	$codeBasket = "DelDelCanBuy";
}
else
{
	$codeBasket = "AnDelCanBuy";
}

$products = array();
$offers = array();
$offersIblock = 0;
if( !empty( $arResult["ITEMS"][$codeBasket] ) )
{
	foreach( $arResult["ITEMS"][$codeBasket] as &$arItem )
	{
		if($arItem["CAN_BUY"] != "Y" || ($isDelay && $arItem["DELAY"] != "Y") || (!$isDelay && $arItem["DELAY"] != "N"))
		{
			continue;
		}
		if($arItem['PROPS'])
		{
			foreach($arItem['PROPS'] as $prop)
			{
				if($prop['VALUE'] && $prop['CODE'] != $colorCode)
				{
					$arResult['PROPS'][$prop['CODE']] = $prop['NAME'];
				}
			}
		}
		$product=CCatalogSku::GetProductInfo($arItem['PRODUCT_ID']);
		if($product)
		{
			$offersIblock = $product['OFFER_IBLOCK_ID'];
			$offers[] = $arItem['PRODUCT_ID'];
			$products[$arItem['PRODUCT_ID']] = $product['ID'];
		}
		else
		{
			$products[$arItem['PRODUCT_ID']] = $arItem['PRODUCT_ID'];
		}
		$arItem["NAME"] = preg_replace( "/\((.*)\)/", "", $arItem["NAME"] );
		$all_quantity = $all_quantity + $arItem['QUANTITY'];
		$all_cost = $all_cost + ($arItem['PRICE'] * $arItem['QUANTITY']);
		$currency = $arItem["CURRENCY"];
		$arItem["PRICE_ALL_FORMATED"] = SaleFormatCurrency( $arItem['QUANTITY'] * $arItem['PRICE'], $currency );
	}

    $arResult['allSum_delay'] = $all_cost;
    $arResult['allSum_delay_FORMATED'] = SaleFormatCurrency($all_cost, $arResult['CURRENCY']);
}

$articles = array();

if($offers)
{
	$propArticul = Option::get('sotbit.b2bshop','OPT_ARTICUL_PROP_OFFER','');
	if($propArticul)
	{

		$rs = CIblockElement::GetList(array(),array('ID' => $offers),false,false,array('ID','PROPERTY_'.$propArticul));
		while($offer = $rs->Fetch())
		{
			$articles[$offer['ID']] = $offer['PROPERTY_'.$propArticul.'_VALUE'];
		}
	}
}

if($products)
{
	$propArticul = Option::get('sotbit.b2bshop','OPT_ARTICUL_PROP','');
	if($propArticul)
	{
		$rs = CIblockElement::GetList(array(),array('ID' => $products),false,false,array('ID','PROPERTY_'.$propArticul));
		while($product = $rs->Fetch())
		{
			$articles[$product['ID']] = $product['PROPERTY_'.$propArticul.'_VALUE'];
		}
	}
}

if($offers)
{
	foreach($offers as $offer)
	{
		if(!$articles[$offer] && $articles[$products[$offer]])
		{
			$articles[$offer] = $articles[$products[$offer]];
		}
	}
}

if($articles)
{
	foreach( $arResult["ITEMS"][$codeBasket] as &$arItem )
	{
		$arItem['ARTICLE'] = $articles[$arItem['PRODUCT_ID']];
	}
}
?>