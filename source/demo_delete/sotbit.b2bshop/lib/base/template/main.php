<?php
namespace Sotbit\B2BShop\Base\Template;
use Bitrix\Main\Loader;
class Main
{
	protected static $curPage;
	protected static $siteName;
	protected static $isB2B = null;
	protected $paths = array(
			"/login",
			"/auth",
			"/news",
			"/about/contacts",
	);
	public function __construct()
	{
		$this->setB2B();
	}
	public function getCurPage()
	{
		if(!self::$curPage)
		{
			if($_SERVER["REAL_FILE_PATH"])
			{
				$page = $_SERVER["REAL_FILE_PATH"];
			}
			else
			{
				$page = $_SERVER["SCRIPT_NAME"];
			}
			$page = str_replace('index.php','',$page);
			$page = substr($page, strlen(SITE_DIR));
			if($page != '/')
			{
				$page = '/'.$page;
			}
			self::$curPage = $page;
		}
		return self::$curPage;
	}

	public function needAddMainBgClass()
	{
		$return = false;
		if(!in_array(self::getCurPage(), $this->paths) && !strpos(self::getCurPage(), 'personal'))
		{
			$return = true;
		}
		return $return;
	}
	public function needShowBreadcrumbs()
	{
		$return = false;
		if(strpos(self::getCurPage(), 'personal') !== false)
		{
			$return = true;
		}
		return $return;
	}
	public function getSiteName()
	{
		if(!self::$siteName)
		{
			$site = \Bitrix\Main\SiteTable::getList(array(
					'select' => array('SITE_NAME'),
					'filter' => array('LID'=>SITE_ID),
					'limit' => 1,
					'cache' => array(
							'ttl' => '36000000'
					)
			))->fetch();
			self::$siteName = $site['SITE_NAME'];
		}
		return self::$siteName;
	}
	public function includeBlock($path = '')
	{
		if(self::$isB2B && file_exists($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/client/b2b/'.$path))
		{
			include($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/client/b2b/'.$path);
		}
		elseif(self::$isB2B && file_exists($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/b2b/'.$path))
		{
			include($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/b2b/'.$path);
		}
		elseif(file_exists($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/client/'.$path))
		{
			include($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/client/'.$path);
		}
		elseif(file_exists($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/'.$path))
		{
			include($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/'.$path);
		}
	}
	protected function setB2B()
	{
		if(is_null(self::$isB2B))
		{
			if(Loader::includeModule('sotbit.b2bshop'))
			{
				self::$isB2B = true;
			}
			else
			{
				self::$isB2B = false;
			}
		}
	}
}