<?php

namespace Sotbit\B2BShop\Base\Shop;

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Config\Option;

/**
 *
 * @author Sergey Danilkin < s.danilkin@sotbit.ru >
 *
 */
class Doc
{
	/**
	 * @return array
	 */
	public function getBuyersByInn()
	{
		try
		{
			$return = [];
			global $USER;

			$inn = unserialize(Option::get('sotbit.b2bshop', 'DOCUMENT_ORG'));
			$names = unserialize(Option::get('sotbit.b2bshop', 'DOCUMENT_ORG_NAME'));
			if(!is_array($inn))
			{
				$inn = [];
			}
			if(!is_array($names))
			{
				$names = [];
			}
			if($inn)
			{
				$buyers = [];
				$rs = \CSaleOrderUserProps::GetList(
					["DATE_UPDATE" => "DESC"],
					["USER_ID" => $USER->GetID()]
				);
				while ($buyer = $rs->Fetch())
				{
					$buyers[$buyer['ID']]['BUYER_ID'] = $buyer['ID'];
				}
				if($buyers)
				{
					$rs = \CSaleOrderUserPropsValue::GetList(["ID" => "ASC"], ["USER_PROPS_ID" => array_keys($buyers)]);
					while ($buyerProp = $rs->Fetch())
					{
						if(in_array($buyerProp['ORDER_PROPS_ID'], $names))
						{
							$buyers[$buyerProp['USER_PROPS_ID']]['ORG_NAME'] = $buyerProp['VALUE'];
						}
						if(in_array($buyerProp['ORDER_PROPS_ID'], $inn))
						{
							$buyers[$buyerProp['USER_PROPS_ID']]['INN'] = $buyerProp['VALUE'];
						}
					}
				}
				foreach ($buyers as $idBuyer => $buyer)
				{
					if($buyer['INN'])
					{
						$return[$buyer['INN']] = $buyer;
					}
				}
			}
			return $return;
		}
		catch (ArgumentNullException $e)
		{
		}
		catch (ArgumentOutOfRangeException $e)
		{
		}
	}
}