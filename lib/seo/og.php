<?php 
namespace Kit\B2BShop\Seo;
class Og extends \B2BSKit
{
	public function __construct(array $fields = array())
	{
		
	}
	public function getImage($MorePhotos = array())
	{
		if($MorePhotos && is_array($MorePhotos))
		{
			$color = reset($MorePhotos);
			if($color['BIG'])
			{
				$picture = reset($color['BIG']);
			}
			if($picture['src'])
			{
				$context = \Bitrix\Main\Application::getInstance()->getContext();
				$server = $context->getServer();
				$this->setField('og:image', ($_SERVER['HTTPS'])?'https://':'http://'.$server->getServerName().$picture['src']);
			}
			unset($color);
			unset($picture);
			unset($MorePhotos);
		}
	}
	public function set($Exceptions = array())
	{
		global $APPLICATION;
		$Properties = $this->getFields();
		foreach($Properties as $name => $value)
		{
			if(!in_array($name,$Exceptions))
			{
				$APPLICATION->SetPageProperty($name, $value);
				\Bitrix\Main\Page\Asset::getInstance()->addString('<meta property="'.$name.'" content="'.$value.'" />');
				unset($this->fields[$name]);
			}
		}
		unset($Properties);
		unset($name);
		unset($value);
	}
	public function generate($metas = array())
	{
		global $APPLICATION;
		if(in_array('og:title',$metas))
		{
			$MetaTitle = $APPLICATION->GetTitle();
			$this->setField('og:title', $MetaTitle);
			unset($MetaTitle);
		}
		if(in_array('og:description',$metas))
		{
			$MetaDescription = $APPLICATION->GetProperty("description");
			$this->setField('og:description', $MetaDescription);
			unset($MetaDescription);
		}
		if(in_array('og:type',$metas))
		{
			$this->setField('og:type', 'website');
		}
		unset($metas);
	}
	public function load($metas = array())
	{
		global $APPLICATION;
		if(in_array('og:title',$metas))
		{
			$this->setField('og:title', $APPLICATION->GetPageProperty('og:title'));
		}
		if(in_array('og:description',$metas))
		{
			
			$this->setField('og:description', $APPLICATION->GetPageProperty('og:description'));
		}
	}
}
?>