<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("highloadblock");
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
global $kitFilterResult;
$arTables=array();
$arxmlID=array();
$DefaultValues=array();
foreach($arResult["ITEMS"] as $arItem)
{
    if($arItem["USER_TYPE"]=="directory")
    {
    	$arTables[]=$arItem["USER_TYPE_SETTINGS"]["TABLE_NAME"];
    	foreach($arItem["VALUES"] as $xmlID=>$arValue)
    	{
			$arxmlID[$arItem["USER_TYPE_SETTINGS"]["TABLE_NAME"]][]=$xmlID;
    	}
    }
}
        $highBlock = \Bitrix\Highloadblock\HighloadBlockTable::getList(array("filter" => array('TABLE_NAME' => $arTables)));
        while($HLBlock=$highBlock->Fetch())
        {
        	$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($HLBlock);
        	$main_query = new Entity\Query($entity);
            $main_query->setSelect(array("*"));
            $main_query->setFilter(array('=UF_XML_ID' => $arxmlID[$HLBlock['TABLE_NAME']]));
            $result = $main_query->exec();
            $result = new CDBResult($result);
            while($row = $result->Fetch())
				{
					$DefaultValues[$row['UF_XML_ID']]=$row;
					if($row["UF_FILE"])
						$DefaultValues[$row['UF_XML_ID']]['PIC']=CFile::GetFileArray($row["UF_FILE"]);
				}
        }
        unset($arTables);
        unset($arxmlID);
foreach($arResult["ITEMS"] as &$arItem)
{
    if($arItem["USER_TYPE"]=="directory")
    {
        foreach($arItem["VALUES"] as $xmlID=>&$arValue)
        {
            $arValue["DEFAULT"] = $DefaultValues[$xmlID];
        }
    }
}


//Cookie
$arResult['OPENS']=array();
foreach($arResult["ITEMS"] as $Item)
{
    if(isset($_COOKIE["kit_filter"][$Item['CODE']]) && !empty($_COOKIE["kit_filter"][$Item['CODE']]))
    {
        $arResult['OPENS'][$Item['CODE']]=$_COOKIE["kit_filter"][$Item['CODE']];
    }
    else
    {
    	if($Item["DISPLAY_EXPANDED"] == 'Y')
    	{
    		$arResult['OPENS'][$Item['CODE']]=$Item["DISPLAY_EXPANDED"];
    	}
    	else
    	{
    		$arResult['OPENS'][$Item['CODE']]="N";
    	}
    }
}

$kitFilterResult=$arResult;
?>