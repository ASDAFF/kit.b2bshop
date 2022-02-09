<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("highloadblock");

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

foreach($arResult["ITEMS"] as &$arItem)
{
    if($arItem["USER_TYPE"]=="directory")
    {
        $nameTable = $arItem["USER_TYPE_SETTINGS"]["TABLE_NAME"];
        //printr(array($nameTable));
        $highBlock = \Bitrix\Highloadblock\HighloadBlockTable::getList(array("filter" => array('TABLE_NAME' => $nameTable)))->fetch();
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($highBlock);
        foreach($arItem["VALUES"] as $xmlID=>&$arValue)
        {
            $main_query = new Entity\Query($entity);
            $main_query->setSelect(array('*'));
            $main_query->setFilter(array('=UF_XML_ID' => $xmlID));
            $result = $main_query->exec();
            $result = new CDBResult($result);
            $row = $result->Fetch();
            if($row["UF_FILE"])
            {
                $row["PIC"] = CFile::GetFileArray($row["UF_FILE"]);
            }//printr($row);
            $arValue["DEFAULT"] = $row;
            unset($main_query);
        }
    }
}

//printr($arResult["ITEMS"]);
?>