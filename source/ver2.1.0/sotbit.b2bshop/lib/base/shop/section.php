<?php

namespace Sotbit\B2BShop\Base\Shop;

use \Sotbit\B2BShop;
use Bitrix\Main\Application;

class Section extends \Sotbit\B2BShop\Client\Shop\Catalog
{
	protected $elements;
	public function __construct(
			$arResult = array(),
			$arParams = array(),
			$settings = array()
	)
	{
		$catalog = parent::getCatalog();
		$this->elements = new B2BShop\Collection();
		if($arResult['ITEMS'])
		{
			foreach($arResult['ITEMS'] as $item)
			{
				$itemElement = new B2BShop\Client\Shop\Element($item, $arParams, $settings);
				$this->elements->addItem($itemElement);
			}
		}
	}
	public function setElements($arResult)
	{
		if($arResult['ITEMS'])
		{
			foreach($arResult['ITEMS'] as $item)
			{
				$this->elements->addItem(new \Sotbit\B2BShop\Client\Shop\Element($item));
			}
		}
	}
	public function getElements()
	{
		return $this->elements;
	}
}
?>