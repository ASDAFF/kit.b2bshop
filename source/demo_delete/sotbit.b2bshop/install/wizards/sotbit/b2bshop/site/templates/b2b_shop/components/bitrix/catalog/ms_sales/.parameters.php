<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!\Bitrix\Main\Loader::includeModule('iblock'))
	return;
$boolCatalog = \Bitrix\Main\Loader::includeModule('catalog');

$arSKU = false;
$boolSKU = false;
if ($boolCatalog && (isset($arCurrentValues['IBLOCK_ID']) && 0 < intval($arCurrentValues['IBLOCK_ID'])))
{
	$arSKU = CCatalogSKU::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
	$boolSKU = !empty($arSKU) && is_array($arSKU);
}

if (isset($arCurrentValues['IBLOCK_ID']) && 0 < intval($arCurrentValues['IBLOCK_ID']))
{
	$arAllPropList = array();
	$arFilePropList = array(
		'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$arListPropList = array(
		'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$arHighloadPropList = array(
		'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
	);
    $arElementPropList = array(
		'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$rsProps = CIBlockProperty::GetList(
		array('SORT' => 'ASC', 'ID' => 'ASC'),
		array('IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], 'ACTIVE' => 'Y')
	);
	while ($arProp = $rsProps->Fetch())
	{
		$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
		if ('' == $arProp['CODE'])
			$arProp['CODE'] = $arProp['ID'];
		$arAllPropList[$arProp['CODE']] = $strPropName;
		if ('F' == $arProp['PROPERTY_TYPE'])
			$arFilePropList[$arProp['CODE']] = $strPropName;
		if ('L' == $arProp['PROPERTY_TYPE'])
			$arListPropList[$arProp['CODE']] = $strPropName;
        if ('E' == $arProp['PROPERTY_TYPE'])
			$arElementPropList[$arProp['CODE']] = $strPropName;
        if('S' == $arProp['PROPERTY_TYPE'] && 'directory' != $arProp['USER_TYPE'])
            $arStringPropList[$arProp['CODE']] = $strPropName;
		if ('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
			$arHighloadPropList[$arProp['CODE']] = $strPropName;
	}
}

if($boolSKU)
{
    $arAllOfferPropList = array();
	$arFileOfferPropList = array(
			'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$arTreeOfferPropList = array(
			'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$rsProps = CIBlockProperty::GetList(
			array('SORT' => 'ASC', 'ID' => 'ASC'),
			array('IBLOCK_ID' => $arSKU['IBLOCK_ID'], 'ACTIVE' => 'Y')
	);
	while ($arProp = $rsProps->Fetch())
	{
	    if ($arProp['ID'] == $arSKU['SKU_PROPERTY_ID'])
				continue;
		$arProp['USER_TYPE'] = (string)$arProp['USER_TYPE'];
		$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
		if ('' == $arProp['CODE'])
		    $arProp['CODE'] = $arProp['ID'];
		$arAllOfferPropList[$arProp['CODE']] = $strPropName;
		if ('F' == $arProp['PROPERTY_TYPE'])
		    $arFileOfferPropList[$arProp['CODE']] = $strPropName;
		if ('N' != $arProp['MULTIPLE'])
		    continue;
		if (
				//'L' == $arProp['PROPERTY_TYPE']
				//|| 'E' == $arProp['PROPERTY_TYPE']
				/*||*/ ('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
		)
		$arTreeOfferPropList[$arProp['CODE']] = $strPropName;


	}
}

$arTemplateParameters['OFFER_TREE_PROPS'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('CP_BC_TPL_OFFER_TREE_PROPS'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arTreeOfferPropList
);

$arTemplateParameters['OFFER_COLOR_PROP'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_OFFER_COLOR_PROP'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arTreeOfferPropList
);
$arTemplateParameters['MANUFACTURER_ELEMENT_PROPS'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_OFFER_MANUFACTURER_ELEMENT_PROPS'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arElementPropList
);
$arTemplateParameters['MANUFACTURER_LIST_PROPS'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_OFFER_MANUFACTURER_LIST_PROPS'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => array_merge($arListPropList, $arStringPropList)
);
$arTemplateParameters['FLAG_PROPS'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_FLAG_PROPS'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => array_merge($arListPropList, $arStringPropList)
);

$arTemplateParameters["DELETE_OFFER_NOIMAGE"] = array(
		"PARENT" => "MISS_SHOP",
		"NAME" => GetMessage('MS_TPL_DELETE_OFFER_NOIMAGE'),
		"TYPE" => "CHECKBOX",
        'REFRESH' => 'N',
		"DEFAULT" => "N"
);

$arTemplateParameters["PICTURE_FROM_OFFER"] = array(
		"PARENT" => "MISS_SHOP",
		"NAME" => GetMessage('MS_TPL_MORE_PHOTO_PICTURE_FROM_OFFER'),
		"TYPE" => "CHECKBOX",
        'REFRESH' => 'Y',
		"DEFAULT" => "N"
);

$arTemplateParameters['MORE_PHOTO_PRODUCT_PROPS'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_MORE_PHOTO_PRODUCT_PROPS'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arFilePropList
);

if (isset($arCurrentValues['PICTURE_FROM_OFFER']) && $arCurrentValues['PICTURE_FROM_OFFER']=="Y")
{
    $arTemplateParameters['MORE_PHOTO_OFFER_PROPS'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_MORE_PHOTO_OFFER_PROPS'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arFileOfferPropList
    );
}

$arTemplateParameters["AVAILABLE_DELETE"] = array(
		"PARENT" => "MISS_SHOP",
		"NAME" => GetMessage('MS_TPL_AVAILABLE_DELETE'),
		"TYPE" => "CHECKBOX",
        'REFRESH' => 'N',
		"DEFAULT" => "N"
);

$arTemplateParameters['LIST_WIDTH_SMALL'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_LIST_WIDTH_SMALL'),
			'TYPE' => 'STRING',
			'DEFAULT' => '80'
);
$arTemplateParameters['LIST_HEIGHT_SMALL'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_LIST_HEIGHT_SMALL'),
			'TYPE' => 'STRING',
			'DEFAULT' => '120'
);
$arTemplateParameters['LIST_WIDTH_MEDIUM'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_LIST_WIDTH_MEDIUM'),
			'TYPE' => 'STRING',
			'DEFAULT' => '180'
);
$arTemplateParameters['LIST_HEIGHT_MEDIUM'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_LIST_HEIGHT_MEDIUM'),
			'TYPE' => 'STRING',
			'DEFAULT' => '320'
);

$arTemplateParameters['DETAIL_WIDTH_SMALL'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_DETAIL_WIDTH_SMALL'),
			'TYPE' => 'STRING',
			'DEFAULT' => '50'
);
$arTemplateParameters['DETAIL_HEIGHT_SMALL'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_DETAIL_HEIGHT_SMALL'),
			'TYPE' => 'STRING',
			'DEFAULT' => '75'
);
$arTemplateParameters['DETAIL_WIDTH_MEDIUM'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_DETAIL_WIDTH_MEDIUM'),
			'TYPE' => 'STRING',
			'DEFAULT' => '300'
);
$arTemplateParameters['DETAIL_HEIGHT_MEDIUM'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_DETAIL_HEIGHT_MEDIUM'),
			'TYPE' => 'STRING',
			'DEFAULT' => '448'
);
$arTemplateParameters['DETAIL_WIDTH_BIG'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_DETAIL_WIDTH_BIG'),
			'TYPE' => 'STRING',
			'DEFAULT' => '2000'
);
$arTemplateParameters['DETAIL_HEIGHT_BIG'] = array(
			'PARENT' => 'MISS_SHOP',
			'NAME' => GetMessage('MS_TPL_DETAIL_HEIGHT_BIG'),
			'TYPE' => 'STRING',
			'DEFAULT' => '2000'
);
$arTemplateParameters["IS_FANCY"] = array(
        "PARENT" => "MISS_SHOP",
        "NAME" => GetMessage('MS_TPL_IS_FANCY'),
        "TYPE" => "CHECKBOX",
        'REFRESH' => 'N',
        "DEFAULT" => "N"
);



if(CModule::IncludeModule('sotbit.mailing')){
    // выберем категории подписок
    // START
    $categoriesList = array();
    $categoriesLi = CSotbitMailingHelp::GetCategoriesInfo();
    foreach($categoriesLi as $v) { 
        $categoriesList[$v['ID']] = '['.$v['ID'].'] '.$v['NAME'];
    }  
    // END 
    $arTemplateParameters['MAILING_INFO_TEXT'] = array(
        'PARENT' => 'MISS_SHOP',
        "NAME" => GetMessage("MAILING_INFO_TEXT_TITLE"),
        "TYPE" => "TEXT",
        "DEFAULT" => GetMessage("MAILING_INFO_TEXT_DEFAULT"),
    );       
    $arTemplateParameters['MAILING_EMAIL_SEND_END'] = array(
        'PARENT' => 'MISS_SHOP',
        "NAME" => GetMessage("MAILING_EMAIL_SEND_END_TITLE"),
        "TYPE" => "TEXT",
        "DEFAULT" => GetMessage("MAILING_EMAIL_SEND_END_DEFAULT"),
    );    
    $arTemplateParameters['MAILING_CATEGORIES_ID'] = array(
        'PARENT' => 'MISS_SHOP',
        "NAME" => GetMessage("MAILING_CATEGORIES_ID_TITLE"),
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "VALUES" => $categoriesList,
    );   
    
    
}
?>