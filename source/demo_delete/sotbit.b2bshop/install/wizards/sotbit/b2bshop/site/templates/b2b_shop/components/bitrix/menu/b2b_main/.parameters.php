<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Loader;
use Bitrix\Iblock;
    
$arIBlock=array();
$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
{
    $arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}

$arProperty_Catalog = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_CATALOG"]));
while ($arr=$rsProp->Fetch())
{
    $arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "E")))
    {
        $arProperty_Catalog[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    }
}

$arProperty_Banner = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_BANNER"]));
while ($arr=$rsProp->Fetch())
{
    $arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "E")))
    {
        $arProperty_Banner[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    }
}

$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arCurrentValues["IBLOCK_BANNER"], "CODE"=>$arCurrentValues["PROP_BANNER_TYPE"]));
while($enum_fields = $property_enums->Fetch())
{
    $arProperty_Banner_View[$enum_fields["XML_ID"]] = "[".$enum_fields["XML_ID"]."] ".$enum_fields["VALUE"];
}

if (Loader::includeModule('catalog')) {
    $arCurrencyList = array();
    $by = 'SORT';
    $order = 'ASC';
    $rsCurrencies = CCurrency::GetList($by, $order);
    while ($arCurrency = $rsCurrencies->Fetch())
    {
        $arCurrencyList[$arCurrency['CURRENCY']] = $arCurrency['CURRENCY'];
    }
    
    $arPrice = array();
    $rsPrice=CCatalogGroup::GetList($v1="sort", $v2="asc");
    while($arr=$rsPrice->Fetch()) $arPrice[$arr["NAME"]] = "[".$arr["NAME"]."] ".$arr["NAME_LANG"];        
}

$arTemplateParameters = array( 
        "IBLOCK_CATALOG" => array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("MENU_IBLOCK_CATALOG_ID"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlock,
            "REFRESH" => "Y",
            "ADDITIONAL_VALUES" => "Y",
        ),
        "CATALOG_PROP_TEXT" => array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("MENU_CATALOG_PROP_TEXT"),
            "TYPE" => "STRING",
            "DEFAULT" => "UF_SECOND_TITLE",
        ),
        "CATALOG_PROP_BRAND" => array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("MENU_CATALOG_PROP_BRAND"),
            "TYPE" => "STRING",
            "DEFAULT" => "UF_B2BS_BRAND",
        ),                
        "IBLOCK_BRAND" => array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("MENU_IBLOCK_BRAND_ID"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlock,
            "REFRESH" => "Y",
            "ADDITIONAL_VALUES" => "Y",
        ),        
        "IBLOCK_BANNER" => array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("MENU_IBLOCK_BANNER_ID"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlock,
            "REFRESH" => "Y",
            "ADDITIONAL_VALUES" => "Y",
        ),
        "PROP_BANNER_TYPE" => array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("MENU_BANNER_TYPE"),
            "TYPE" => "LIST",
            "MULTIPLE" => "N",
            "VALUES" => $arProperty_Banner,
            "REFRESH" => "Y",
            "ADDITIONAL_VALUES" => "Y",
        ),
        "PROP_BANNER_TYPE_VIEW" => array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("MENU_BANNER_TYPE_VIEW"),
            "TYPE" => "LIST",
            "MULTIPLE" => "N",
            "VALUES" => $arProperty_Banner_View,
            "REFRESH" => "Y",
            "ADDITIONAL_VALUES" => "Y",
        ),
        "HIDE_NOT_AVAILABLE" => array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            'NAME' => GetMessage('MENU_HIDE_NOT_AVAILABLE'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N',
        ),        
        "PRICE_CODE" => array(
            "PARENT" => "PRICES",
            "NAME" => GetMessage("MENU_PRICE_CODE"),
            "TYPE" => "LIST",
            "MULTIPLE" => "Y",
            "VALUES" => $arPrice,
        ),        
        "CURRENCY_ID" => array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            'NAME' => GetMessage('MENU_CURRENCY_ID'),
            'TYPE' => 'LIST',
            'VALUES' => $arCurrencyList,
            'DEFAULT' => CCurrency::GetBaseCurrency(),
            "ADDITIONAL_VALUES" => "Y",
        ),    
);
?>