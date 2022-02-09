<?php
namespace Kit\B2BShop\Base\Personal;
use Bitrix\Main\Loader;

class Widget
{
	/**
	 * 
	 * @var int
	 */
	protected $openTab = 1;
	
	
	public function __construct()
	{
		$this->checkOpenTab();
	}
	
	
	/**
	 * @return array
	 */
	public function getBuyOrderOrgProps()
	{
		$return = array();
		
		$props = array();
		if(Loader::includeModule('kit.b2bshop') && Loader::includeModule('sale'))
		{
			$rs = \Bitrix\Sale\Internals\OrderPropsTable::getList(array(
					'filter' => array(
							'ACTIVE' => 'Y',
							'CODE' => array('COMPANY'),
					),
					'select' => array(
							'ID',
							'CODE',
					)
			));
			while ($property = $rs->fetch())
			{
				array_push($property['ID'],$return);
			}
		}
		
		return $return;
	}
	
	/**
	 * 
	 */
	protected function checkOpenTab()
	{
		if(!Loader::includeModule('kit.b2bshop'))
		{
			if(\Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getCookieRaw('kit_personal_widgets_tab') == 2)
			{
				$this->openTab = 2;
			}
		}
	}
	
	public function getOpenTab()
	{
		return $this->openTab;
	}
}