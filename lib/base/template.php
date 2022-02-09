<?php
namespace Kit\B2BShop\Base;
class Template
{
	protected $paths = array(
			"login/index.php",
			"auth/index.php",
			"news/index.php",
			"about/contacts/index.php",
	);
	public function needAddMainBgClass($path = '')
	{
		$return = false;
		$path = substr($path, strlen(SITE_DIR));//remove site dir from path
		if(!in_array($path, $this->paths) && !strpos($path, 'personal'))
		{
			$return = true;
		}
		return $return;
	}
	public function needShowBreadcrumbs($path = '')
	{
		$return = false;
		if(strpos($path, 'personal') !== false)
		{
			$return = true;
		}
		return $return;
	}
	public function getSiteName()
	{
		$return = '';
		$site = \Bitrix\Main\SiteTable::getList(array(
				'select' => array('SITE_NAME'),
				'filter' => array('LID'=>SITE_ID),
				'limit' => 1,
				'cache' => array(
						'ttl' => '36000000'
				)
		))->fetch();
		if(isset($site['SITE_NAME']))
		{
			$return = $site['SITE_NAME'];
		}
		return $return;
	}
}