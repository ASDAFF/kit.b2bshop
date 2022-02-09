<?
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

	$AddMenuLinks=unserialize(Option::get("kit.b2bshop", "ADD_MENU_LINKS",'a:0:{}'));


//determine if child selected

$bWasSelected = false;
$arParents = array();
$depth = 1;

foreach($arResult as $i=>$arMenu)
{
	$depth = $arMenu['DEPTH_LEVEL'];

	if($arMenu['IS_PARENT'] == true)
	{
		$arParents[$arMenu['DEPTH_LEVEL']-1] = $i;
	}
	elseif($arMenu['SELECTED'] == true)
	{
		$bWasSelected = true;
		break;
	}
}

if($bWasSelected)
{
	for($i=0; $i<$depth-1; $i++)
		$arResult[$arParents[$i]]['CHILD_SELECTED'] = true;
}


/*foreach($arResult as $key => $arItem)
{
    if($arItem["DEPTH_LEVEL"] > $firstLevel) {
        $COUNT_CHILDREN++;
    } else {
       $arResult[$menu_first_key]["COUNT_CHILDREN"] = $COUNT_CHILDREN;
       $COUNT_CHILDREN = 0;
    }
    if($arItem["DEPTH_LEVEL"] == $firstLevel) {
        $menu_first_key = $key;
    }
}*/

//Cookie


foreach($arResult as $key =>$Item)
{
    if(isset($_COOKIE["kit_filter"][$Item['LINK']]) && !empty($_COOKIE["kit_filter"][$Item['LINK']]))
    {
        $arResult[$key]['OPENS']=$_COOKIE["kit_filter"][$Item['LINK']];
    }
}


if(isset($AddMenuLinks) && is_array($AddMenuLinks) && count($AddMenuLinks)>0){

	foreach($AddMenuLinks as $j=>$AddMenuLink)
	{
		if(!isset($AddMenuLink['ADD_MENU_LINKS_TITLE']) || empty($AddMenuLink['ADD_MENU_LINKS_TITLE']) || !isset($AddMenuLink['ADD_MENU_LINKS_URL']) || empty($AddMenuLink['ADD_MENU_LINKS_URL']))
		{
			continue;
		}
	foreach($arResult as $key => $arItem) {
				if($AddMenuLink['ADD_MENU_LINKS_PARENT_LINK']==$arItem['LINK'])
				{
					if(!$arItem['IS_PARENT'])
					{
						$arResult[$key]['IS_PARENT']=1;
					}
					if($key == count($arResult)-1)
					{
						$arResult[$key+1] = array('TEXT'=>$AddMenuLink['ADD_MENU_LINKS_TITLE'],'LINK'=>$AddMenuLink['ADD_MENU_LINKS_URL'],'SELECTED'=>'','PERMISSION'=>'X','IS_PARENT'=>'','DEPTH_LEVEL'=>$arItem['DEPTH_LEVEL']+1);
					}
					else
					{
					
						if(isset($AddMenuLink['ADD_MENU_LINKS_SORT']) && $AddMenuLink['ADD_MENU_LINKS_SORT']>0)
						{
	
							foreach($arResult as $key2 => $arItem2)
							{
								if($key2>$key)
								{
									if($arItem2['DEPTH_LEVEL']<=$arItem['DEPTH_LEVEL'])
									{
										if($AddMenuLink['ADD_MENU_LINKS_SORT']==1 || $Tmp<$AddMenuLink['ADD_MENU_LINKS_SORT'])
										{
	
											$FirstPart=array_slice($arResult, 0,$key2);
											$SecondPart=array_slice($arResult, $key2,count($arResult)-$key2);
											$arResult=array_merge($FirstPart,array($key2=>array('TEXT'=>$AddMenuLink['ADD_MENU_LINKS_TITLE'],'LINK'=>$AddMenuLink['ADD_MENU_LINKS_URL'],'SELECTED'=>'','PERMISSION'=>'X','IS_PARENT'=>'','DEPTH_LEVEL'=>$arItem['DEPTH_LEVEL']+1)));
											$arResult=array_merge($arResult,$SecondPart);
	
										}
										break;
									}
	
									if($arItem2['DEPTH_LEVEL']==$arItem['DEPTH_LEVEL']+1)
									{
										++$Tmp;
									}
									if($Tmp==$AddMenuLink['ADD_MENU_LINKS_SORT'])
									{
	
										$FirstPart=array_slice($arResult, 0,$key2);
										$SecondPart=array_slice($arResult, $key2,count($arResult)-$key2);
										$arResult=array_merge($FirstPart,array($key2=>array('TEXT'=>$AddMenuLink['ADD_MENU_LINKS_TITLE'],'LINK'=>$AddMenuLink['ADD_MENU_LINKS_URL'],'SELECTED'=>'','PERMISSION'=>'X','IS_PARENT'=>'','DEPTH_LEVEL'=>$arItem['DEPTH_LEVEL']+1)));
										$arResult=array_merge($arResult,$SecondPart);
	
										break;
									}
								}
							}
						break;
						}
						else
						{
							foreach($arResult as $key2 => $arItem2)
							{
								if($key2>$key)
								{
									if($arItem['DEPTH_LEVEL']==$arItem2['DEPTH_LEVEL'])
									{
										$FirstPart=array_slice($arResult, 0,$key2);
										$SecondPart=array_slice($arResult, $key2,count($arResult)-$key2);
										$arResult=array_merge($FirstPart,array($key2=>array('TEXT'=>$AddMenuLink['ADD_MENU_LINKS_TITLE'],'LINK'=>$AddMenuLink['ADD_MENU_LINKS_URL'],'SELECTED'=>'','PERMISSION'=>'X','IS_PARENT'=>'','DEPTH_LEVEL'=>$arItem['DEPTH_LEVEL']+1)));
										$arResult=array_merge($arResult,$SecondPart);
										break;
									}
									else
									{
	
									}
								}
							}
							break;
						}
					}
				}
			}
	}
}

$Level=array(1=>'',2=>'',3=>'');
foreach($arResult as $key => $arItem)
{
	$arResult[$key]["COUNT_CHILDREN"]=0;
	$Level[$arItem["DEPTH_LEVEL"]]=$key;
	
	if(isset($arResult[$Level[$arItem["DEPTH_LEVEL"]-1]]))
	{
		++$arResult[$Level[$arItem["DEPTH_LEVEL"]-1]]["COUNT_CHILDREN"];
		$arResult[$key]['PARENT']=$Level[$arItem["DEPTH_LEVEL"]-1];
	}
}
unset($Level);


if(Loader::includeModule('kit.seometa'))
{
	$uri = \Bitrix\Main\Context::getCurrent()->getRequest()->getRequestUri();
	if($uri)
	{
		$seometaWorking = \Kit\Seometa\SeometaUrlTable::getList(
				array(
						'filter' => array(
								'ACTIVE' => 'Y',
								'REAL_URL' => $uri
						),
						'select' => array(
								'ID'
						),
						'limit' => 1
				)
		)->fetch();
		if($seometaWorking['ID'])
		{
			$selectedKeys = array();
			$needSelect = false;
			foreach($arResult as $key => $arItem)
			{
				if($arItem['SELECTED'])
				{
					$selectedKeys[] = $key;
				}
				if($arItem['LINK'] == $uri && !$arItem['SELECTED'])
				{
					$needSelect = true;
					$selectKey = $key;
				}
			}
			if($needSelect)
			{
				foreach($selectedKeys as $key)
				{
					$arResult[$key]['SELECTED'] = '';
				}
				$arResult[$selectKey]['SELECTED'] = 1;
				if($arResult[$selectKey]['DEPTH_LEVEL'] > 1)
				{
					$arResult = changeSelect($arResult, $selectKey, $arResult[$selectKey]['DEPTH_LEVEL']);
				}
			}
		}

	}
}

function changeSelect($arResult, $key, $level)
{
	while($level > 0)
	{
		for($i=$key; $i>=0; --$i)
		{
			if($arResult[$i]['DEPTH_LEVEL'] == $level - 1)
			{
				$arResult[$i]['SELECTED'] = 1;
				if($level > 1)
				{
					$arResult = changeSelect($arResult, $i, $level - 1);
				}
				break;
			}
		}
		if($i<=0)
		{
			break;
		}
	}
}

?>
