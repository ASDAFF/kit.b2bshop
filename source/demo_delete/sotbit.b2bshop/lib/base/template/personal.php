<?php
namespace Sotbit\B2BShop\Base\Template;
class Personal
{
	protected $displayUserName = false;
	protected $profilePath = '';

	public function __construct()
	{
		$Template = new \Sotbit\B2BShop\Client\Template\Main();
		$page = $Template::getCurPage();
		//if(!in_array($page,array('/personal/','/personal/b2b/')))
		if(false)
		{
			$this->displayUserName = true;
		}

		if($this->isDisplayUserName())
		{
			if(strpos($page,'b2b') !== false)
			{
				$this->profilePath = SITE_DIR.'personal/b2b/';
			}
			else
			{
				$this->profilePath = SITE_DIR.'personal/';
			}
		}
	}
	public function getMenuType($child = false)
	{
		$return = '';
		$Template = new \Sotbit\B2BShop\Client\Template\Main();
		$page = $Template::getCurPage();
		if(strpos($page,'b2b') !== false)
		{
			if($child)
			{
				$return = 'personal_inner_opt';
			}
			else
			{
				$return = 'personal_opt';
			}
		}
		else
		{
			$return = 'personal';
			if($child)
			{
				$return.='_inner';
			}
		}
		return $return;
	}

	public function isDisplayUserName()
	{
		return $this->displayUserName;
	}
	public function getProfilePath()
	{
		return $this->profilePath;
	}
}
?>