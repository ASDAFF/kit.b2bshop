<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UserTable;
use Bitrix\Sale\DeliveryStatus;
use Kit\B2BShop\Client\Shop\Doc;
use Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

try
{
	Loader::includeModule('iblock');
	Loader::includeModule('catalog');
	Loader::includeModule('sale');
	Loader::includeModule('support');
}
catch (\Bitrix\Main\LoaderException $e)
{
}


$isB2bTab = false;
if(strpos($arParams['PATH_TO_LIST'], 'b2b') !== false)
{
	$isB2bTab = true;
}

$arCatalog = CCatalogSKU::GetInfoByIBlock($arParams["IBLOCK_ID"]);

$all_quantity = 0;
$all_cost = 0;
$colorCode = $arParams["OFFER_COLOR_PROP"];
$imageFromOffer = ($arParams["PICTURE_FROM_OFFER"] == "Y") ? 1 : 0;;
$codeBrand = $arParams["MANUFACTURER_LIST_PROPS"];
$codeArticle = $arCatalog["SKU_PROPERTY_ID"];
$codeMorePhoto = "MORE_PHOTO";
$codeProductMorePhoto = $arParams["MORE_PHOTO_PRODUCT_PROPS"];
$codeOfferMorePhoto = $arParams["MORE_PHOTO_OFFER_PROPS"];
$arID = $arElementID = [];
$imgWidth = $arParams["IMG_WIDTH"];
$imgHeight = $arParams["IMG_HEIGHT"];
$article_prop = Option::get("kit.b2bshop", "OPT_ARTICUL_PROP", "");
$article_propOffers = Option::get("kit.b2bshop", "OPT_ARTICUL_PROP_OFFER", "");

$cp = $this->__component;
if(is_object($cp))
{
	CModule::IncludeModule('iblock');

	if(empty($arResult['ERRORS']['FATAL']))
	{

		$hasDiscount = false;
		$hasProps = false;
		$productSum = 0;
		$basketRefs = [];

		$noPict = [
			'SRC' => $this->GetFolder() . '/images/no_photo.png'
		];

		if(is_readable($nPictFile = $_SERVER['DOCUMENT_ROOT'] . $noPict['SRC']))
		{
			$noPictSize = getimagesize($nPictFile);
			$noPict['WIDTH'] = $noPictSize[0];
			$noPict['HEIGHT'] = $noPictSize[1];
		}

		$prodIds = [];
		$offerIds = [];
		$articles = [];

		foreach ($arResult["BASKET"] as $k => $prod)
		{
			if($prod['PARENT'])
			{
				$prodIds[] = $prod['PARENT']['ID'];
				$offerIds[$prod['PRODUCT_ID']] = $prod['PARENT']['ID'];
			}
			else
			{
				$prodIds[] = $prod['PRODUCT_ID'];
			}
		}

		if($offerIds)
		{
			$articulOffers = Option::get('kit.b2bshop', 'OPT_ARTICUL_PROP_OFFER', '');
			$rs = CIBlockElement::GetList(
				["SORT" => "ASC"],
				['ID' => array_keys($offerIds)],
				false,
				false,
				[
					'ID',
					'IBLOCK_ID',
					'PROPERTY_' . $articulOffers
				]
			);
			while ($offer = $rs->Fetch())
			{
				if($offer['PROPERTY_' . $articulOffers . '_VALUE'])
				{
					$articles[$offer['ID']] = $offer['PROPERTY_' . $articulOffers . '_VALUE'];
				}
			}
		}
		if($prodIds)
		{
			$articulProducts = Option::get('kit.b2bshop', 'OPT_ARTICUL_PROP', '');
			$rs = CIBlockElement::GetList(
				["SORT" => "ASC"],
				['ID' => $prodIds],
				false,
				false,
				[
					'ID',
					'IBLOCK_ID',
					'PROPERTY_' . $articulProducts
				]
			);
			while ($product = $rs->Fetch())
			{
				if($product['PROPERTY_' . $articulProducts . '_VALUE'])
				{
					if($offerIds)
					{
						foreach ($offerIds as $idOffer => $idProd)
						{
							if($product['ID'] == $idProd && !$articles[$idOffer])
							{
								$articles[$idOffer] = $product['PROPERTY_' . $articulProducts . '_VALUE'];
							}
						}
					}
					$articles[$product['ID']] = $product['PROPERTY_' . $articulProducts . '_VALUE'];
				}
			}
		}

		foreach ($arResult["BASKET"] as $k => &$prod)
		{
			$prod['ARTICLE'] = $articles[$prod['PRODUCT_ID']];
			if(floatval($prod['DISCOUNT_PRICE']))
				$hasDiscount = true;
			$arID[$prod["PRODUCT_ID"]] = $prod["PRODUCT_ID"];
			// move iblock props (if any) to basket props to have some kind of consistency
			if(isset($prod['IBLOCK_ID']))
			{
				$iblock = $prod['IBLOCK_ID'];
				if(isset($prod['PARENT']))
					$parentIblock = $prod['PARENT']['IBLOCK_ID'];

				foreach ($arParams['CUSTOM_SELECT_PROPS'] as $prop)
				{
					$key = $prop . '_VALUE';
					if(isset($prod[$key]))
					{
						// in the different iblocks we can have different properties under the same code
						if(isset($arResult['PROPERTY_DESCRIPTION'][$iblock][$prop]))
							$realProp = $arResult['PROPERTY_DESCRIPTION'][$iblock][$prop];
						elseif(isset($arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop]))
							$realProp = $arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop];

						if(!empty($realProp))
							$prod['PROPS'][] = [
								'NAME' => $realProp['NAME'],
								'VALUE' => htmlspecialcharsEx($prod[$key])
							];
					}
				}
			}

			// if we have props, show "properties" column
			if(!empty($prod['PROPS']))
			{
				$hasProps = true;
				foreach ($prod['PROPS'] as $prop)
				{
					$prod["PROPS_CODE"][$prop["CODE"]] = $prop;
				}
			}


			$one_productSum = $prod['PRICE'] * $prod['QUANTITY'];

			$arResult["BASKET"][$k]['FULL_PRICE_FORMATED'] = SaleFormatCurrency($one_productSum, $arResult['CURRENCY']);

			$productSum += $prod['PRICE'] * $prod['QUANTITY'];

			$basketRefs[$prod['PRODUCT_ID']][] =& $arResult["BASKET"][$k];

			if(!isset($prod['PICTURE']))
				$prod['PICTURE'] = $noPict;
		}

		$arResult['HAS_DISCOUNT'] = $hasDiscount;
		$arResult['HAS_PROPS'] = $hasProps;

		$arResult['PRODUCT_SUM_FORMATTED'] = SaleFormatCurrency($productSum, $arResult['CURRENCY']);

		if($img = intval($arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE_ID']))
		{

			$pict = CFile::ResizeImageGet($img, [
				'width' => 150,
				'height' => 90
			], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);

			$arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE'] = $pict;
		}


		if($imageFromOffer)
		{
			if(!empty($arID))
			{
				$rsOffer = CIBlockElement::GetList([], ["=ID" => $arID], false, false, [
					"ID",
					"IBLOCK_ID",
					"PREVIEW_PICTURE",
					"DETAIL_PICTURE",
					"PROPERTY_" . $codeOfferMorePhoto,
					"PROPERTY_" . $codeArticle
				]);
				while ($arOffer = $rsOffer->Fetch())
				{
					$img = $arOffer["PREVIEW_PICTURE"] ? $arOffer["PREVIEW_PICTURE"] : $arOffer["DETAIL_PICTURE"];
					$imgMorePhoto = $arOffer["PROPERTY_" . $codeOfferMorePhoto . "_VALUE"];
					$ID = $arOffer["ID"];

					$productID = $arOffer["PROPERTY_" . $codeArticle . "_VALUE"];
					if($productID)
						$arElementID[$productID] = $productID;

					$arElementOfferID[$arOffer["ID"]] = $productID;
					$arOfferElementID[$id][$arOffer["ID"]] = $arOffer["ID"];


					if(!isset($arResult["MORE_PHOTO"][$ID]) && $img)
					{
						$arResult["MORE_PHOTO"][$ID] = CFile::GetFileArray($img);
					}

					if(!isset($arResult["MORE_PHOTO"][$ID]) && $imgMorePhoto)
						$arResult["MORE_PHOTO"][$ID] = CFile::GetFileArray($imgMorePhoto);
				}

				/*???????? ??? ??????, ? ??????? ??? ????????*/
				if(is_array($arResult["MORE_PHOTO"]))
				{
					foreach ($arResult["MORE_PHOTO"] as $ID => $arImg)
					{
						if(isset($arID[$ID]))
							unset($arID[$ID]);
					}
				}

				/*???????? ???????? ???? ??????? ? ???????*/
				if(isset($arID) && !empty($arID))
				{
					foreach ($arID as $ID)
					{
						$arElementID[] = $arElementOfferID[$ID];
					}
					$rsElement = CIBlockElement::GetList([], ["=ID" => $arElementID], false, false, [
						"ID",
						"IBLOCK_ID",
						"PREVIEW_PICTURE",
						"DETAIL_PICTURE",
						"PROPERTY_" . $codeProductMorePhoto
					]);
					while ($arElement = $rsElement->Fetch())
					{
						$ID = $arElement["ID"];
						if(is_array($arOfferElementID[$ID]))
						{
							foreach ($arOfferElementID[$ID] as $offerID)
							{
								$img = $arOffer["PREVIEW_PICTURE"] ? $arOffer["PREVIEW_PICTURE"] : $arOffer["DETAIL_PICTURE"];
								$imgMorePhoto = $arOffer["PROPERTY_" . $codeProductMorePhoto . "_VALUE"];
								if(!isset($arResult["MORE_PHOTO"][$offerID]) && $img)
								{
									$arResult["MORE_PHOTO"][$offerID] = CFile::GetFileArray($img);
								}

								if(!isset($arResult["MORE_PHOTO"][$offerID]) && $imgMorePhoto)
									$arResult["MORE_PHOTO"][$offerID] = CFile::GetFileArray($imgMorePhoto);
							}
						}
					}
				}

				foreach ($arResult["BASKET"] as &$arBasket)
				{
					//if($arBasket["CAN_BUY"]=="Y" && $arBasket["DELAY"]=="N")
					{
						$id = $arBasket["PRODUCT_ID"];
						if(isset($arResult["MORE_PHOTO"][$id]))
						{
							$arPhoto = $arResult["MORE_PHOTO"][$id];
							$arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, [
								'width' => $imgWidth,
								'height' => $imgHeight
							], BX_RESIZE_IMAGE_PROPORTIONAL, true);
						}

					}
				}

			}
		}
		else
		{
			/*???????? ?? ??????*/
			if(!empty($arID))
			{   /*???????? ??????*/
				$rsOffer = CIBlockElement::GetList([], ["=ID" => $arID], false, false, [
					"ID",
					"IBLOCK_ID",
					"PROPERTY_" . $codeArticle
				]);
				while ($arOffer = $rsOffer->Fetch())
				{
					$id = $arOffer["PROPERTY_" . $codeArticle . "_VALUE"];
					$arElementID[$id] = $id;
					$arOfferElementID[$id][$arOffer["ID"]] = $arOffer["ID"];
				}
				if(!empty($arElementID))
				{   /*???????? ?????? ??????? ? ????????*/
					$rsElement = CIBlockElement::GetList([], ["=ID" => $arElementID], false, false, [
						"ID",
						"IBLOCK_ID",
						"PREVIEW_PICTURE",
						"DETAIL_PICTURE",
						"PROPERTY_" . $codeProductMorePhoto
					]);
					while ($arElement = $rsElement->Fetch())
					{
						if(isset($arOfferElementID[$arElement["ID"]]))
						{
							foreach ($arOfferElementID[$arElement["ID"]] as $ID)
							{
								$img = $arElement["PREVIEW_PICTURE"] ? $arElement["PREVIEW_PICTURE"] : $arElement["DETAIL_PICTURE"];
								$imgMorePhoto = $arElement["PROPERTY_" . $codeProductMorePhoto . "_VALUE"];

								if(!isset($arResult["MORE_PHOTO"][$ID][$img]) && $img)
								{
									$arResult["MORE_PHOTO"][$ID][$img] = CFile::GetFileArray($img);
									$arResult["DEFAULT_MORE_PHOTO"][$ID] = CFile::GetFileArray($img);
								}

								if(!isset($arResult["MORE_PHOTO"][$ID][$imgMorePhoto]) && $imgMorePhoto)
									$arResult["MORE_PHOTO"][$ID][$imgMorePhoto] = CFile::GetFileArray($imgMorePhoto);
							}
						}

					}

				}

				if(isset($arResult["MORE_PHOTO"]) && !empty($arResult["MORE_PHOTO"]))
				{
					foreach ($arResult["MORE_PHOTO"] as $offerID => $arOfferPhoto)
					{
						foreach ($arOfferPhoto as $arPhoto)
						{
							//printr($arPhoto);
							$descr = mb_strtolower($arPhoto["DESCRIPTION"]);
							$arDescr = explode("_", $descr);
							//printr($arDescr);
							$color = $arDescr[0];
							if($descr && isset($arDescr[1]))
							{
								$index = $arDescr[1];
								$arResult["MORE_PHOTO_LOGIC"][$offerID][$color][$index] = $arPhoto;
							}
							elseif(!$descr && isset($arDescr[1]))
							{
								$arResult["MORE_PHOTO_LOGIC"][$offerID][$color][] = $arPhoto;
							}
							else $arResult["MORE_PHOTO_LOGIC"][$offerID][0][] = $arPhoto;
						}

					}

					foreach ($arResult["MORE_PHOTO_LOGIC"] as $offerID => $arColorPhoto)
					{
						foreach ($arColorPhoto as $color => $arOfferPhoto)
						{
							ksort($arResult["MORE_PHOTO_LOGIC"][$offerID][$color]);
							$arResult["MORE_PHOTO_LOGIC"][$offerID][$color] = array_values($arResult["MORE_PHOTO_LOGIC"][$offerID][$color]);
						}
					}
				}

				foreach ($arResult["BASKET"] as &$arBasket)
				{
					//if($arBasket["CAN_BUY"]=="Y" && $arBasket["DELAY"]=="N")
					{
						if(isset($arBasket["PROPS_CODE"][$colorCode]) && $arBasket["PROPS_CODE"][$colorCode]["VALUE"])
						{   //print "COLOR";
							$color = mb_strtolower($arBasket["PROPS_CODE"][$colorCode]["VALUE"]);
							$ID = $arBasket["PRODUCT_ID"];
							if(isset($arResult["MORE_PHOTO_LOGIC"][$ID][$color]))
							{
								$arPhoto = $arResult["MORE_PHOTO_LOGIC"][$ID][$color][0];//printr($arPhoto);
								$arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, [
									'width' => $imgWidth,
									'height' => $imgHeight
								], BX_RESIZE_IMAGE_PROPORTIONAL, true);
							}
							else
							{
								$arPhoto = $arResult["DEFAULT_MORE_PHOTO"][$ID];
								$arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, [
									'width' => $imgWidth,
									'height' => $imgHeight
								], BX_RESIZE_IMAGE_PROPORTIONAL, true);
							}
						}
						else
						{
							//$arPhoto = $arResult["MORE_PHOTO_LOGIC"][$ID][$color][0];
							$arPhoto = $arResult["DEFAULT_MORE_PHOTO"][$ID];
							$arBasket["PICTURE"] = CFile::ResizeImageGet($arPhoto, [
								'width' => $imgWidth,
								'height' => $imgHeight
							], BX_RESIZE_IMAGE_PROPORTIONAL, true);
						}
					}
					$all_quantity += $arBasket['QUANTITY'];
				}

			}
		}

	}
}


$arResult['ALL_QUANTITY'] = $all_quantity;
foreach ($arResult["ORDER_PROPS"] as $prop)
{
	switch ($prop['CODE'])
	{
		case 'UR_ZIP':
			$arResult['LEGAL_ADDRESS']['UR_ZIP'] = $prop;
			break;
		case 'UR_CITY':
			$arResult['LEGAL_ADDRESS']['UR_CITY'] = $prop;
			break;

		case 'EQ_POST':
			$arResult['MAIL_ADDRESS']['EQ_POST'] = $prop;
			break;
		case 'POST_ZIP':
			$arResult['MAIL_ADDRESS']['POST_ZIP'] = $prop;
			break;
		case 'POST_CITY':
			$arResult['MAIL_ADDRESS']['POST_CITY'] = $prop;
			break;
		case 'POST_ADDRESS':
			$arResult['MAIL_ADDRESS']['POST_ADDRESS'] = $prop;
			break;

		case 'COMPANY':
			$arResult['COMPANY']['COMPANY'] = $prop;
			break;
		case 'INN':
			$arResult['COMPANY']['INN'] = $prop;
			break;
		case 'KPP':
			$arResult['COMPANY']['KPP'] = $prop;
			break;

		case 'PHONE':
			$arResult['BUYER']['PHONE'] = $prop;
			break;
		case 'EMAIL':
			$arResult['BUYER']['EMAIL'] = $prop;
			break;
	}
}


$user = UserTable::getList(
	[
		'select' => [
			'ID',
			'PERSONAL_PHOTO'
		],
		'filter' => ['ID' => $arResult['USER_ID']],
		'limit' => 1
	]
)->fetch();
$arResult['USER_PERSONAL_PHOTO'] = CFile::ResizeImageGet(
	$user['PERSONAL_PHOTO'],
	[
		'width' => 70,
		'height' => 70

	],
	BX_RESIZE_IMAGE_PROPORTIONAL,
	true
);


/*=========product==========*/
$filterOption = new Bitrix\Main\UI\Filter\Options('PRODUCT_LIST');
$filterData = $filterOption->getFilter([]);

$productFilter = [
	'id',
	'article',
	'name',
	'quantity',
	'sum',
	'date_insert_to',
	'date_insert_from'
];
$filter = [];

foreach ($arResult['BASKET'] as $product)
{
	if($filterData)
	{
		foreach ($filterData as $key => $value)
		{
			if(in_array(strtolower($key), $productFilter))
			{
				$filter[$key] = $value;
			}
		}
	}
	$needContinue = false;
	foreach ($filter as $key => $value)
	{
		$sum = $product['QUANTITY'] * $product['PRICE'];
		$sum = (string)$sum;
		if(in_array(strtolower($key), [
			'date_insert_from',
			'date_insert_to'
		]))
		{
			$date = $product['DATE_INSERT']->getTimestamp();

			$start = $filter['DATE_INSERT_from'];
			$end = $filter['DATE_INSERT_to'];
			if($date < strtotime($start) || $date > strtotime($end))
			{
				$needContinue = true;
				break;
			}
		}
		elseif($key == 'SUM' && $sum != $value)
		{
			$needContinue = true;
			break;
		}
		elseif($key != 'SUM' && $product[$key] != $value)
		{
			$needContinue = true;
			break;
		}
	}

	if($needContinue)
	{
		continue;
	}
	$productCols = [
		'ID' => $product['ID'],
		'ARTICLE' => $product['ARTICLE'],
		'NAME' => $product['NAME'],
		'QUANTITY' => $product['QUANTITY'],
		'SUM' => $product['QUANTITY'] * $product['PRICE']
	];
	$arResult['PRODUCT_ROWS'][] = [
		'data' => [
			'ID' => $product['ID'],
			'ARTICLE' => $product['ARTICLE'],
			'NAME' => $product['NAME'],
			'QUANTITY' => $product['QUANTITY'],
			'SUM' => $product['FORMATED_SUM']
		],
		'actions' => [],
		'COLUMNS' => $productCols,
		'editable' => true,
	];
}


/*=========shipment==========*/
$filterOption = new Bitrix\Main\UI\Filter\Options('SHIPMENT_LIST');
$filterData = $filterOption->getFilter([]);


$shipmentFilter = [
	'id',
	'status_id',
	'date_insert_to',
	'date_insert_from'
];
$filter = [];


$byShipment = (isset($_GET['by']) && strpos($_GET['by'], '_SHIPMENT') !== false) ? str_replace('_SHIPMENT', '',
	$_GET['by']) : 'ID';
$orderShipment = isset($_GET['order']) ? strtoupper($_GET['order']) : 'DESC';

$shipments = [];
if($byShipment)
{
	foreach ($arResult['SHIPMENT'] as $i => $shipment)
	{
		if($byShipment == 'NAME')
		{
			$shipments[$i] = $shipment['DELIVERY']['NAME'];
		}
		else
		{
			$shipments[$i] = $shipment[$byShipment];
		}
	}
}
if($shipments && $orderShipment)
{
	if($orderShipment == 'DESC')
	{
		arsort($shipments);
	}
	else
	{
		asort($shipments);
	}
}
foreach ($shipments as $i => $shipment)
{
	$shipments[$i] = $arResult['SHIPMENT'][$i];
}


foreach ($shipments as $shipment)
{
	if($filterData)
	{
		foreach ($filterData as $key => $value)
		{
			if(in_array(strtolower($key), $shipmentFilter))
			{
				$filter[$key] = $value;
			}
		}
	}
	$needContinue = false;
	foreach ($filter as $key => $value)
	{
		if(in_array(strtolower($key), [
			'date_insert_from',
			'date_insert_to'
		]))
		{
			$date = $shipment['DATE_INSERT']->getTimestamp();

			$start = $filter['DATE_INSERT_from'];
			$end = $filter['DATE_INSERT_to'];
			if($date < strtotime($start) || $date > strtotime($end))
			{
				$needContinue = true;
				break;
			}
		}
		elseif($shipment[$key] != $value)
		{
			$needContinue = true;
			break;
		}
	}
	if($needContinue)
	{
		continue;
	}
	$shipmentCols = [
		'ID' => $shipment['ID'],
		'DATE_INSERT' => $shipment['DATE_INSERT'],
		'NAME' => $shipment['DELIVERY']['NAME'],
		'STATUS' => $shipment['STATUS_ID'],
		'PRICE' => $shipment['PRICE_DELIVERY_FORMATED']
	];
	$arResult['SHIPMENT_ROWS'][] = [
		'data' => [
			"ID" => $shipment['ID'],
			'DATE_INSERT' => $shipment['DATE_INSERT']->toString(),
			'NAME' => $shipment['DELIVERY']['NAME'],
			'STATUS' => $shipment['STATUS_NAME'],
			'PRICE' => $shipment['PRICE_DELIVERY_FORMATED']
		],
		'actions' => [],
		'COLUMNS' => $shipmentCols,
		'editable' => true,
	];
}
$arResult['SHIPMENT_LIST'] = DeliveryStatus::getAllStatusesNames();


/*=========payment==========*/
$filterOption = new Bitrix\Main\UI\Filter\Options('PAYMENT_LIST');
$filterData = $filterOption->getFilter([]);


$paymentFilter = [
	'id',
	'paid',
	'date_bill_to',
	'date_bill_from'
];
$filter = [];


$byPayment = isset($_GET['by']) ? $_GET['by'] : 'ID';
$orderPayment = isset($_GET['order']) ? strtoupper($_GET['order']) : 'DESC';


$payments = [];
if($byPayment)
{
	foreach ($arResult['PAYMENT'] as $i => $payment)
	{
		if($byPayment == 'PAYMENT_METHOD')
		{
			$payments[$i] = $payment['PAY_SYSTEM']['NAME'];
		}
		else
		{
			$payments[$i] = $payment[$byPayment];
		}
	}
}
if($payments && $orderPayment)
{
	if($orderPayment == 'DESC')
	{
		arsort($payments);
	}
	else
	{
		asort($payments);
	}
}
foreach ($payments as $i => $payment)
{
	$payments[$i] = $arResult['PAYMENT'][$i];
}

foreach ($payments as $payment)
{
	if($filterData)
	{
		foreach ($filterData as $key => $value)
		{
			if(in_array(strtolower($key), $paymentFilter))
			{
				$filter[$key] = $value;
			}
		}
	}
	$needContinue = false;
	foreach ($filter as $key => $value)
	{
		if(in_array(strtolower($key), [
			'date_bill_from',
			'date_bill_to'
		]))
		{
			$date = $payment['DATE_BILL']->getTimestamp();

			$start = $filter['DATE_BILL_from'];
			$end = $filter['DATE_BILL_to'];
			if($date < strtotime($start) || $date > strtotime($end))
			{
				$needContinue = true;
				break;
			}
		}
		elseif($payment[$key] != $value)
		{
			$needContinue = true;
			break;
		}
	}
	if($needContinue)
	{
		continue;
	}
	$paymentCols = [
		'ID' => $payment['ID'],
		'DATE_BILL' => $payment['DATE_BILL'],
		'PAID' => $payment['PAID'],
		'PAYMENT_METHOD' => $payment['PAY_SYSTEM']['NAME'],
		'SUM' => $payment['SUM']
	];
	$arResult['PAYMENT_ROWS'][] = [
		'data' => [
			"ID" => $payment['ID'],
			'DATE_BILL' => $payment['DATE_BILL']->toString(),
			'PAID' => GetMessage('SPOL_' . ($payment['PAID'] == "Y" ? 'YES' : 'NO')),
			'PAYMENT_METHOD' => $payment['PAY_SYSTEM']['NAME'],
			'SUM' => $payment['PRICE_FORMATED']
		],
		'actions' => [],
		'COLUMNS' => $paymentCols,
		'editable' => true,
	];
}

$arResult['FILTER_EXCEL'] = [];
$arResult['QNTS'] = [];
if($arResult['BASKET'])
{
	foreach ($arResult['BASKET'] as $basket)
	{
		if(!isset($arResult['FILTER_EXCEL']['ID']))
		{
			$arResult['FILTER_EXCEL']['ID'] = [];
		}
		if($basket['PARENT']['ID'] > 0)
		{
			$arResult['FILTER_EXCEL']['ID'][] = $basket['PARENT']['ID'];
			$arResult['FILTER_EXCEL']['OFFERS_IDS'][] = $basket['PRODUCT_ID'];

		}
		else
		{
			$arResult['FILTER_EXCEL']['ID'][] = $basket['PRODUCT_ID'];
		}
		$arResult['QNTS'][$basket['PRODUCT_ID']] = $basket['QUANTITY'];
	}
}

$opt = new \Kit\B2BShop\Client\Shop\Opt();
try
{
	$params = $opt->getBlankParams();
	if($params["OPT_ARTICUL_PROPERTY"])
	{
		$ids[] = $params["OPT_ARTICUL_PROPERTY"];
	}
	if($params["OPT_ARTICUL_PROPERTY_OFFER"])
	{
		$ids[] = $params["OPT_ARTICUL_PROPERTY_OFFER"];
	}
	if($ids)
	{
		$rs = PropertyTable::getList([
			'filter' => ['ID' => $ids],
			'select' => [
				'ID',
				'CODE'
			]
		]);
		while ($prop = $rs->fetch())
		{
			if($prop['ID'] == $params["OPT_ARTICUL_PROPERTY_OFFER"])
			{
				$params["LIST_OFFERS_PROPERTY_CODE"][] = $prop['CODE'];
			}
		}
	}
	$arResult['PARAMS'] = $params;
} catch (\Bitrix\Main\ArgumentNullException $e)
{
} catch (\Bitrix\Main\ArgumentOutOfRangeException $e)
{
}

try
{
	$docIblock = Option::get('kit.b2bshop', 'DOCUMENT_IBLOCK_ID');
	if($docIblock > 0)
	{
		$doc = new Doc();
		$buyers = $doc->getBuyersByInn();

		$filter = [
			'ACTIVE' => 'Y',
			'PROPERTY_ORDER' => $arResult['ID']
		];
		$filterOption = new Bitrix\Main\UI\Filter\Options('DOCUMENTS_LIST');
		$filterData = $filterOption->getFilter([]);

		foreach ($filterData as $key => $value)
		{
			if(in_array($key, [
				'ID',
				'NAME',
				'DATE_CREATE_from',
				'DATE_CREATE_to',
				'DATE_UPDATE_from',
				'DATE_UPDATE_to'
			]))
			{
				switch ($key)
				{
					case 'DATE_CREATE_from':
						{
							$filter['>=DATE_CREATE'] = $value;
							break;
						}
					case 'DATE_CREATE_to':
						{
							$filter['<=DATE_CREATE'] = $value;
							break;
						}
					case 'DATE_UPDATE_from':
						{
							$filter['>=TIMESTAMP_X'] = $value;
							break;
						}
					case 'DATE_UPDATE_to':
						{
							$filter['<=TIMESTAMP_X'] = $value;
							break;
						}
					default:
						{
							$filter[$key] = $value;
						}
				}
			}
		}

		$by = isset($_GET['by']) ?  $_GET['by'] : 'ID';
		$order = isset($_GET['order']) ? strtoupper($_GET['order']) : 'DESC';

		if($by == 'DATE_UPDATE')
		{
			$by = 'TIMESTAMP_X';
		}

		$rs = \CIBlockElement::GetList([$by => $order], $filter, false, false, [
			'ID',
			'NAME',
			'DATE_CREATE',
			'TIMESTAMP_X',
			'PROPERTY_ORGANIZATION',
			'PROPERTY_DOCUMENT'
		]);
		while ($el = $rs->Fetch())
		{
			$orgUrl = ($isB2bTab) ? 'personal/b2b/profile/buyer/' : 'personal/profile/buyer/';
			if($buyers[$el['PROPERTY_ORGANIZATION_VALUE']])
			{
				if($buyers[$el['PROPERTY_ORGANIZATION_VALUE']]['ORG_NAME'])
				{
					$name = $buyers[$el['PROPERTY_ORGANIZATION_VALUE']]['ORG_NAME'] . ' ('
						. $buyers[$el['PROPERTY_ORGANIZATION_VALUE']]['INN'] . ')';
				}
				else
				{
					$name = $buyers[$el['PROPERTY_ORGANIZATION_VALUE']]['INN'];
				}
				$org = '<a href="' . SITE_DIR . $orgUrl . '?id=' . $buyers[$el['PROPERTY_ORGANIZATION_VALUE']]['BUYER_ID'] . '" target="__blank">' .
					$name . '</a>';
			}
			else
			{
				$org = $el['PROPERTY_ORGANIZATION_VALUE'];
			}
			$actions = [];
			$name = $el["NAME"];
			if($el['PROPERTY_DOCUMENT_VALUE'])
			{
				$file = \CFile::GetPath($el['PROPERTY_DOCUMENT_VALUE']);
				$name = '<a href="' . $file . '" download>' . $el["NAME"]
					. '</a>';
				$actions = [
					[
						"ICONCLASS" => "download",
						"TEXT" => Loc::getMessage('DOC_DOWNLOAD'),
						"ONCLICK" => "jsUtils.Redirect(arguments, '" . $file . "')",
						"DEFAULT" => true
					]
				];
			}
			$arResult['ROWS'][] = [
				'data' => [
					"ID" => $el['ID'],
					"NAME" => $name,
					'DATE_CREATE' => $el["DATE_CREATE"],
					'DATE_UPDATE' => $el["TIMESTAMP_X"],
					'ORGANIZATION' => $org,
				],
				'actions' => $actions,
				'COLUMNS' => [
					"ID" => $el['ID'],
					"NAME" => $el["NAME"],
					'DATE_CREATE' => $el["DATE_CREATE"],
					'DATE_UPDATE' => $el["TIMESTAMP_X"],
					'ORGANIZATION' => $org,
				],
				'editable' => true,
			];
		}
	}

	$arResult['TICKET'] = \CTicket::GetList(
		$by="ID",
		$order="asc",
		array('UF_ORDER' => $arResult['ID'],'CREATED_BY' => $USER->GetID()),
		$isFiltered,
		"Y",
		"Y",
		"Y",
		SITE_ID,
		array()
	)->Fetch();
}
catch (\Bitrix\Main\ArgumentNullException $e)
{
}
catch (\Bitrix\Main\ArgumentOutOfRangeException $e)
{
}
?>