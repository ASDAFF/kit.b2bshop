<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Kit\Techno\Internals\BlockTable;
use Bitrix\Main\Context;

class KitBlockIncludeComponent extends \CBitrixComponent
{
	/**
	 * @var boolean
	 */
	private $canModify = false;
	public function onPrepareComponentParams($arParams)
	{
		return $arParams;
	}
	public function executeComponent()
	{
		if(!Loader::includeModule('kit.techno'))
		{
			return false;
		}
		global $APPLICATION;
		$right = $APPLICATION->GetUserRight(\KitTechno::moduleId);
		if($right == 'W')
		{
			$this->setCanModify(true);
		}

		$filter = ['PART' => $this->arParams['PART']];

		$blockCollection = new \Kit\Techno\BlockCollection();

		$blocks = [];
		$request = Context::getCurrent()->getRequest();

		$rs = BlockTable::getList(['filter' => $filter]);
		while($block = $rs->fetch() )
		{
			$blocks = new \Kit\Techno\Block($block, $request);
		}



		$blockCollection = new \Kit\Techno\BlockCollection($blocks);

		$blockCollection->show();

		//$blockCollection->fillContent($request);

		if($this->isCanModify())
		{
			$this->arResult['AVAILABLE_BLOCKS'] = $this->getAvailableBlocks();
		}
		else
		{

		}


		$this->includeComponentTemplate();
	}

	public function getAvailableBlocks()
	{
		$return = [];
		$dir = $_SERVER['DOCUMENT_ROOT'].\KitTechno::blockDir;
		if(is_dir($dir))
		{
			$avBlocks = scandir($dir);
			foreach($avBlocks as $avBlock)
			{
				if(is_dir($dir.'/'.$avBlock) && !in_array($avBlock,['.','..']))
				{
					$block['CONTENT'] = file_get_contents($dir.'/'.$avBlock.'/content.php');
					$block['PREVIEW'] = file_get_contents($dir.'/'.$avBlock.'/preview.jpg');
					$block['SETTINGS'] = include $dir.'/'.$avBlock.'/settings.php';
					$return[] = $block;
				}
			}
		}
		return $return;
	}

	/**
	 * @return bool
	 */
	public function isCanModify()
	{
		return $this->canModify;
	}

	/**
	 * @param bool $canModify
	 */
	public function setCanModify($canModify)
	{
		$this->canModify = $canModify;
	}
}
?>