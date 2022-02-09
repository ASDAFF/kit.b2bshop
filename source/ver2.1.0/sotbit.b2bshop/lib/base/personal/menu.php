<?php
namespace Sotbit\B2BShop\Base\Personal;

/**
 * 
 * @author Sergey Danilkin < s.danilkin@sotbit.ru >
 *
 */
class Menu
{
	protected $open = false;
	public function __construct()
	{
		$this->checkOpen();
	}
	protected function checkOpen()
	{
		$blankSide = \Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getCookieRaw('blank_side');
		if($blankSide == 'Y' || is_null($blankSide))
		{
			$this->open = true;
		}
	}
	public function isOpen()
	{
		return $this->open;
	}
}