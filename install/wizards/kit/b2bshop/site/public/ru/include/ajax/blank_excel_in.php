<?
define('STOP_STATISTICS', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $USER;
$file = array();

$unProp = COption::GetOptionString("kit.b2bshop","OPT_UNIQUE_PROP","CODE");

if($_FILES['files']['name'][0])
{
	$file = $_FILES['files'];
	$file['name'] = $file['name'][0];
	$file['type'] = $file['type'][0];
	$file['tmp_name'] = $file['tmp_name'][0];
}
elseif($_FILES['file']['name'])
{
	$file = $_FILES['file'];
}

if(strpos($file['name'],'.xlsx') !== false)
{
	if(\Bitrix\Main\Loader::includeModule("kit.b2bshop"))
	{
		$path = $_SERVER['DOCUMENT_ROOT'].'/bitrix/tmp/'. $file['name'];
		move_uploaded_file($file['tmp_name'], $path);

		$objPHPExcel = PHPExcel_IOFactory::load($path);

		$objPHPExcel->setActiveSheetIndex(0);
		$aSheet = $objPHPExcel->getActiveSheet();

		$eq = array();
		$elems = array();

		$colQnt = 0;

		foreach($aSheet->getRowIterator() as $i=>$row)
		{

			if($i == 1)
			{
				$cellIterator = $row->getCellIterator();
				foreach($cellIterator as $k=>$cell)
				{
					if($cell->getCalculatedValue() == 'Количество')
					{
						$colQnt = $k;
						break;
					}
				}

				if(!$colQnt)
				{
					$props = unserialize(COption::GetOptionString("kit.b2bshop","OPT_OFFER_TREE_PROPS",""));
					if(!is_array($props))
					{

					}
					else
					{
						$alfavit = array(
								0 => 'A',
								1 => 'B',
								2 => 'C',
								3 => 'D',
								4 => 'E',
								5 => 'F',
								6 => 'G',
								7 => 'H',
								8 => 'I',
								9 => 'J',
								10 => 'K',
								11 => 'L',
								12 => 'M',
								13 => 'N',
								14 => 'O',
								15 => 'P',
								16 => 'Q',
								17 => 'R',
								18 => 'S',
								19 => 'T',
								20 => 'U',
								21 => 'V',
								22 => 'W',
								23 => 'X',
								24 => 'Y',
								25 => 'Z',
						);
						$colQnt = $alfavit[count($props) + 3];
					}
				}
			}
			if($i > 1)
			{
				$cellIterator = $row->getCellIterator();
				foreach($cellIterator as $k=>$cell)
				{
					if($k == 'B')
					{
						if($cell->getCalculatedValue())
						{
							$eq[] = $cell->getCalculatedValue();
							$elems[$i]['EQ'] = $cell->getCalculatedValue();
						}
					}
					if($colQnt && $k == $colQnt)
					{
						if($cell->getCalculatedValue() > 0 && $elems[$i]['EQ'])
						{
							$elems[$i]['QNT'] = $cell->getCalculatedValue();
						}
					}
				}
			}
		}

		if($eq)
		{

			$elements = array();


			$iblock = COption::GetOptionString("kit.b2bshop","OPT_IBLOCK_ID","");
			if($iblock > 0)
			{
				$mxResult = CCatalogSKU::GetInfoByProductIBlock(
						$iblock
						);
				if (is_array($mxResult))
				{
					$arFilter = array('IBLOCK_ID' => array($iblock,$mxResult['IBLOCK_ID']), $unProp => $eq);
				}
				else
				{
					$arFilter = array('IBLOCK_ID' => array($iblock), $unProp => $eq);
				}
			}
			else
			{
				$arFilter = array('IBLOCK_ID' => array($iblock), $unProp => $eq);
			}


			//$arFilter['PROPERTY_'.COption::GetOptionString("kit.b2bshop","OPT_ARTICUL_PROP","")] = $articles;


			$idPrices = array();

			//get prices codes
			$dbPriceType = CCatalogGroup::GetList(
					array("SORT" => "ASC"),
					array()
					);
			while ($arPriceType = $dbPriceType->Fetch())
			{
				$idPrices[$arPriceType['ID']] = $arPriceType['NAME'];
			}


			$Prices = array();
			$ids = array();

			$rs = CIBlockElement::GetList(array(),$arFilter,false,false,array('ID','CODE','XML_ID','IBLOCK_ID','IBLOCK_SECTION_ID'));
			while($elem = $rs->fetch())
			{
				$Prices['ITEMS'][$elem['ID']] = $elem;
				foreach($elems as $el)
				{
					if($el['EQ'] == $elem[$unProp])
					{

						if($el['QNT'] > 0)
						{
							$ids[] = $elem['ID'];
							$_SESSION['BLANK_IDS'][$elem['ID']] = array('QNT' => $el['QNT']);
						}
						else
						{
							unset($_SESSION['BLANK_IDS'][$elem['ID']]);
						}
					}
				}
			}
			if($ids)
			{
				$priceIds = array();
				$dbPriceType = CCatalogGroup::GetList(
						array("SORT" => "ASC"),
						array("CAN_ACCESS" => "Y",'CODE' => unserialize(COption::GetOptionString("kit.b2bshop","PRICE_CODE","")))
						);
				while ($arPriceType = $dbPriceType->Fetch())
				{
					$priceIds[] = $arPriceType["ID"];
				}


				$Prices['ITEMS'] = array();
				$r = \Bitrix\Catalog\PriceTable::getList(
						array(
								'filter' => array(
										'PRODUCT_ID' => $ids,
										'CATALOG_GROUP_ID' => $priceIds
								),
								'select' => array('ID','PRODUCT_ID','CATALOG_GROUP_ID','PRICE','CURRENCY')
						));
				while($price = $r->fetch())
				{

					$arDiscounts = CCatalogDiscount::GetDiscountByPrice(
							$price["ID"],
							$USER->GetUserGroupArray(),
							"N"
							);
					$discountPrice = CCatalogProduct::CountPriceWithDiscount(
							$price["PRICE"],
							$price["CURRENCY"],
							$arDiscounts
							);

					$Prices['ITEMS'][$price['PRODUCT_ID']]['PRICES'][$idPrices[$price['CATALOG_GROUP_ID']]] = array(
							'PRICE_ID' => $price['CATALOG_GROUP_ID'],
							'ID' => $price['ID'],
							'CURRENCY' => $price['CURRENCY'],
							'VALUE' => $price['PRICE'],
							'DISCOUNT_VALUE' => $discountPrice
					);
				}
				foreach($Prices['ITEMS'] as $x=>$product)
				{

					foreach($product['PRICES'] as $l => $price)
					{
						if(!$min || $price['DISCOUNT_VALUE'] < $min)
						{
							$min = $price['DISCOUNT_VALUE'];
							$key = $l;
						}
					}
					if($key)
					{
						$Prices['ITEMS'][$x]['PRICES'][$key]['MIN_PRICE'] = 'Y';
						$Prices['ITEMS'][$x]['MIN_PRICE'] = $Prices['ITEMS'][$x]['PRICES'][$key];
					}
					unset($key);
					unset($min);
				}
			}

			if(Bitrix\Main\Loader::includeModule("kit.price"))
			{
				$Prices = KitPrice::ChangeMinPrice($Prices);
			}

			foreach($_SESSION['BLANK_IDS'] as $id => $blank)
			{
				if(!isset($blank['PRICE']) && $Prices['ITEMS'][$id]['MIN_PRICE'])
				{
					$_SESSION['BLANK_IDS'][$id]['PRICE'] = $Prices['ITEMS'][$id]['MIN_PRICE']['DISCOUNT_VALUE'];
				}
			}
		}
		unlink($path);
	}
}
else
{
	echo 'Неверный формат файла';
}
?>
