<?php

namespace Kit\B2BShop\Base\Template;

use \Kit\B2BShop;
use Bitrix\Main\Application;

class Section
{
	private $sectionView = '';
	private $views = array(
			'block',
			'row'
	);
	private $uri;

	public function identifySectionView($sectionLevel = 0)
	{
		$request = Application::getInstance()->getContext()->getRequest();
		$view = htmlspecialchars($request->getQuery("view"));
		$viewCookie = Application::getInstance()->getContext()->getRequest()->getCookie("kit_section_view");;

		if($view && in_array($view, $this->views))
		{
			$cookie = new \Bitrix\Main\Web\Cookie("kit_section_view", $view);
			Application::getInstance()->getContext()->getResponse()->addCookie($cookie);
			$this->setSectionView($view);
		}
		elseif(isset($viewCookie) && in_array($viewCookie, $this->views))
		{
			$this->setSectionView($viewCookie);
		}
		else
		{
			$this->setSectionView(\Bitrix\Main\Config\Option::get('kit.b2bshop','SECTION_VIEW','block'));
		}

		if( \Bitrix\Main\Config\Option::get("kit.b2bshop","SHOW_BRICKS","N") == 'Y '&& $sectionLevel == 1)
		{
			$this->setSectionView('bricks');
		}
		return $this->getSectionView();
	}

	public function getViewPath($view = '')
	{
		$return = '';
		if(!isset($this->uri))
		{
			$request = Application::getInstance()->getContext()->getRequest();
			$uriString = $request->getRequestUri();
			$this->uri = new \Bitrix\Main\Web\Uri($uriString);
		}
		if($this->uri instanceof \Bitrix\Main\Web\Uri)
		{
			$this->uri->addParams(array("view" => $view));
			$this->uri->deleteParams(array("bxajaxid"));
			$return = $this->uri->getUri();
		}
		return $return;
	}


	public function getSectionView()
	{
		return $this->sectionView;
	}
	public function setSectionView($view = '')
	{
		$this->sectionView = $view;
	}
}
?>