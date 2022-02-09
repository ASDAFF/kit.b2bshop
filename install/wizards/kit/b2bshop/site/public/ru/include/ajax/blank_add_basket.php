<?php
define('STOP_STATISTICS', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if($_SESSION['BLANK_IDS'])
{
	$iblocks = [];
	$props = [];
	$offerProps = unserialize(COption::GetOptionString("kit.b2bshop", "OFFER_TREE_PROPS", ""));
	foreach ($_SESSION['BLANK_IDS'] as $id => $param)
	{
		if($param['IBLOCK_ID'] > 0)
		{
			if(!isset($iblocks[$param['IBLOCK_ID']]))
			{
				$iblocks[$param['IBLOCK_ID']] = \CCatalogSku::GetInfoByIBlock($param['IBLOCK_ID']);
				if(!empty($iblocks[$param['IBLOCK_ID']]) && $iblocks[$param['IBLOCK_ID']]['CATALOG_TYPE'] == \CCatalogSku::TYPE_PRODUCT)
				{
					$iblocks[$param['IBLOCK_ID']] = false;
				}
			}
			$iblock = $iblocks[$param['IBLOCK_ID']];
			if($iblock)
			{
				$productIblockId = ($iblock['CATALOG_TYPE'] == \CCatalogSku::TYPE_CATALOG ? $iblock['IBLOCK_ID'] :
					$iblock['PRODUCT_IBLOCK_ID']
				);
				if($iblock['CATALOG_TYPE'] !== \CCatalogSku::TYPE_OFFERS)
				{

				}
				else
				{
					$props = \CIBlockPriceTools::GetOfferProperties(
						intval($id),
						$productIblockId,
						$offerProps,
						''
					);
				}
			}
		}
		if($param['QNT'] > 0)
		{
			Add2BasketByProductID(
				intval($id),
				$param['QNT'],
				[],
				$props
			);
		}
	}
	unset($_SESSION['BLANK_IDS']);
	echo 'TRUE';
}
else
{
	echo 'EMPTY';
}
?>