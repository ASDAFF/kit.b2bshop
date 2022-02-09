<?php
namespace Sotbit\B2BShop\Base\Personal;
use Bitrix\Main\Loader;

class Tab
{
	/**
	 *
	 * @var int
	 */
	protected $openTab = 1;
	protected $urls = array();


	public function __construct()
	{
		$this->checkOpenTab();
		$this->generateUrls();
	}
	protected function checkOpenTab()
	{
		$page = \Sotbit\B2BShop\Base\Template\Main::getCurPage();
		if(strpos($page,'b2b') !== false)
		{
			$this->setOpen(2);
		}
		else
		{
			$this->setOpen(1);
		}
	}
	protected function generateUrls()
	{
		$page = \Sotbit\B2BShop\Base\Template\Main::getCurPage();
		$pages = array(
				'/personal/' => '/personal/b2b/',
				'/personal/profile/account/' => '/personal/b2b/profile/account/',
				'/personal/order/' => '/personal/b2b/order/',
				'/personal/reviews/' => '/personal/b2b/reviews/',
				'/personal/comments/' => '/personal/b2b/comments/',
				'/personal/questions/' => '/personal/b2b/questions/',
				'/personal/subscribe/' => '/personal/b2b/subscribe/',
				'/personal/support/' => '/personal/b2b/support/',
		);

		$get = '';
		$context = \Bitrix\Main\Application::getInstance()->getContext();
		$request = $context->getRequest();
		$getParams = $request->getQueryList()->toArray();

		if($getParams)
		{
			$get = '?'.http_build_query($getParams);
		}
		if($this->getOpen() == 1)
		{
			$this->urls[1] = SITE_DIR.'personal/'.$get;
			if($pages[$page])
			{
				$this->urls[2] = SITE_DIR.substr($pages[$page],1).$get;
			}
			else
			{
				$this->urls[2] = SITE_DIR.'personal/b2b/'.$get;
			}
		}
		elseif($this->getOpen() == 2)
		{
			$this->urls[2] = SITE_DIR.'personal/b2b/'.$get;
			$personalPage = array_search($page, $pages);
			if($personalPage)
			{
				$this->urls[1] = SITE_DIR.substr($personalPage,1).$get;
			}
			else
			{
				$this->urls[1] = SITE_DIR.'personal/'.$get;
			}
		}
	}

	public function getOpen()
	{
		return $this->openTab;
	}
	public function setOpen($tab = 1)
	{
		$this->openTab = $tab;
	}
	public function getUrl($tab = 1)
	{
		return $this->urls[$tab];
	}
}