<?

use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Internals\PersonTypeTable;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
Loc::loadMessages(__FILE__);
if($APPLICATION->GetGroupRight("main") < "R")
{
	$APPLICATION->AuthForm(Loc::getMessage("ACCESS_DENIED"));
}
$module_id = "sotbit.b2bshop";
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $module_id . '/classes/CModuleOptions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/" . $module_id . "/include.php");
if(!\Bitrix\Main\Loader::includeModule('iblock'))
{
	return;
}
$boolCatalog = \Bitrix\Main\Loader::includeModule('catalog');
$categoriesList = [];
if(\Bitrix\Main\Loader::includeModule('sotbit.mailing'))
{
	$categoriesLi = CSotbitMailingHelp::GetCategoriesInfo();
	foreach ($categoriesLi as $v)
	{
		$categoriesList["REFERENCE_ID"][] = $v['ID'];
		$categoriesList["REFERENCE"][] = '[' . $v['ID'] . '] ' . $v['NAME'];
	}
}
if($REQUEST_METHOD == "POST" && strlen($RestoreDefaults) > 0 && check_bitrix_sessid())
{
	COption::RemoveOption($module_id);
	$z = CGroup::GetList($v1 = "id", $v2 = "asc", [
		"ACTIVE" => "Y",
		"ADMIN" => "N"
	]);
	while ($zr = $z->Fetch())
	{
		$APPLICATION->DelGroupRight($module_id, [
			$zr["ID"]
		]);
	}
	if((strlen($Apply) > 0) || (strlen($RestoreDefaults) > 0))
	{
		LocalRedirect($APPLICATION->GetCurPage() . "?lang=" . LANGUAGE_ID . "&mid=" . urlencode($mid) . "&tabControl_active_tab=" . urlencode($_REQUEST["tabControl_active_tab"]) . "&back_url_settings=" . urlencode($_REQUEST["back_url_settings"]));
	}
	else
	{
		LocalRedirect($_REQUEST["back_url_settings"]);
	}
}
$arTabs = [
	[
		'DIV' => 'edit1',
		'TAB' => Loc::getMessage($module_id . '_edit1'),
		'ICON' => '',
		'TITLE' => Loc::getMessage($module_id . '_edit1'),
		'SORT' => '10'
	],
	[
		'DIV' => 'edit2',
		'TAB' => Loc::getMessage($module_id . '_edit2'),
		'ICON' => '',
		'TITLE' => Loc::getMessage($module_id . '_edit2'),
		'SORT' => '15'
	],
	[
		'DIV' => 'edit3',
		'TAB' => Loc::getMessage($module_id . '_edit3'),
		'ICON' => '',
		'TITLE' => Loc::getMessage($module_id . '_edit3'),
		'SORT' => '20'
	],
	[
		'DIV' => 'edit4',
		'TAB' => Loc::getMessage($module_id . '_edit4'),
		'ICON' => '',
		'TITLE' => Loc::getMessage($module_id . '_edit4'),
		'SORT' => '25'
	],
	[
		'DIV' => 'edit5',
		'TAB' => Loc::getMessage($module_id . '_edit5'),
		'ICON' => '',
		'TITLE' => Loc::getMessage($module_id . '_edit5'),
		'SORT' => '30'
	],
	[
		'DIV' => 'edit6',
		'TAB' => Loc::getMessage($module_id . '_edit6'),
		'ICON' => '',
		'TITLE' => Loc::getMessage($module_id . '_edit6'),
		'SORT' => '40'
	],
	[
		'DIV' => 'edit65',
		'TAB' => Loc::getMessage($module_id . '_edit65'),
		'ICON' => '',
		'TITLE' => Loc::getMessage($module_id . '_edit65'),
		'SORT' => '40'
	],
	[
		'DIV' => 'edit7',
		'TAB' => Loc::getMessage($module_id . '_edit7'),
		'ICON' => '',
		'TITLE' => Loc::getMessage($module_id . '_edit8'),
		'SORT' => '55'
	],
	[
		'DIV' => 'edit8',
		'TAB' => Loc::getMessage($module_id . '_edit8'),
		'ICON' => '',
		'TITLE' => Loc::getMessage($module_id . '_edit8'),
		'SORT' => '60'
	],
	[
		'DIV' => 'edit9',
		'TAB' => Loc::getMessage($module_id . '_edit9'),
		'ICON' => '',
		'TITLE' => Loc::getMessage($module_id . '_edit9'),
		'SORT' => '75'
	],
];
$arSKU = false;
$boolSKU = false;
$arIBlockType = CIBlockParameters::GetIBlockTypes();
if(isset($_REQUEST["IBLOCK_TYPE"]) && $_REQUEST["IBLOCK_TYPE"])
{
	$arCurrentValues["IBLOCK_TYPE"] = $_REQUEST["IBLOCK_TYPE"];
}
else
{
	$arCurrentValues["IBLOCK_TYPE"] = COption::GetOptionString($module_id, "IBLOCK_TYPE", "");
}
if(isset($_REQUEST["BRAND_IBLOCK_TYPE"]) && $_REQUEST["BRAND_IBLOCK_TYPE"])
{
	$arCurrentValues["BRAND_IBLOCK_TYPE"] = $_REQUEST["BRAND_IBLOCK_TYPE"];
}
else
{
	$arCurrentValues["BRAND_IBLOCK_TYPE"] = COption::GetOptionString($module_id, "BRAND_IBLOCK_TYPE", "");
}
if(isset($_REQUEST["BRAND_IBLOCK_ID"]) && $_REQUEST["BRAND_IBLOCK_ID"])
{
	$arCurrentValues["BRAND_IBLOCK_ID"] = $_REQUEST["BRAND_IBLOCK_ID"];
}
else
{
	$arCurrentValues["BRAND_IBLOCK_ID"] = COption::GetOptionString($module_id, "BRAND_IBLOCK_ID", "");
}
if(isset($_REQUEST["DOCUMENT_IBLOCK_TYPE"]) && $_REQUEST["DOCUMENT_IBLOCK_TYPE"])
{
	$arCurrentValues["DOCUMENT_IBLOCK_TYPE"] = $_REQUEST["DOCUMENT_IBLOCK_TYPE"];
}
else
{
	$arCurrentValues["DOCUMENT_IBLOCK_TYPE"] = COption::GetOptionString($module_id, "DOCUMENT_IBLOCK_TYPE", "");
}
if(isset($_REQUEST["IBLOCK_ID"]) && $_REQUEST["IBLOCK_ID"])
{
	$arCurrentValues["IBLOCK_ID"] = $_REQUEST["IBLOCK_ID"];
}
else
{
	$arCurrentValues["IBLOCK_ID"] = COption::GetOptionString($module_id, "IBLOCK_ID", "");
}
if(isset($_REQUEST["BANNER_IBLOCK_TYPE"]) && $_REQUEST["BANNER_IBLOCK_TYPE"])
{
	$arCurrentValues["BANNER_IBLOCK_TYPE"] = $_REQUEST["BANNER_IBLOCK_TYPE"];
}
else
{
	$arCurrentValues["BANNER_IBLOCK_TYPE"] = COption::GetOptionString($module_id, "BANNER_IBLOCK_TYPE", "");
}
if(isset($_REQUEST["BANNER_IBLOCK_ID"]) && $_REQUEST["BANNER_IBLOCK_ID"])
{
	$arCurrentValues["BANNER_IBLOCK_ID"] = $_REQUEST["BANNER_IBLOCK_ID"];
}
else
{
	$arCurrentValues["BANNER_IBLOCK_ID"] = COption::GetOptionString($module_id, "BANNER_IBLOCK_ID", "");
}
if(isset($_REQUEST["NEWS_IBLOCK_TYPE"]) && $_REQUEST["NEWS_IBLOCK_TYPE"])
{
	$arCurrentValues["NEWS_IBLOCK_TYPE"] = $_REQUEST["NEWS_IBLOCK_TYPE"];
}
else
{
	$arCurrentValues["NEWS_IBLOCK_TYPE"] = COption::GetOptionString($module_id, "NEWS_IBLOCK_TYPE", "");
}
if(isset($_REQUEST["NEWS_IBLOCK_ID"]) && $_REQUEST["NEWS_IBLOCK_ID"])
{
	$arCurrentValues["NEWS_IBLOCK_ID"] = $_REQUEST["NEWS_IBLOCK_ID"];
}
else
{
	$arCurrentValues["NEWS_IBLOCK_ID"] = COption::GetOptionString($module_id, "NEWS_IBLOCK_ID", "");
}
if(isset($_REQUEST["COLOR_IN_SECTION_LINK"]) && $_REQUEST["COLOR_IN_SECTION_LINK"])
{
	$arCurrentValues["COLOR_IN_SECTION_LINK"] = $_REQUEST["COLOR_IN_SECTION_LINK"];
}
else
{
	$arCurrentValues["COLOR_IN_SECTION_LINK"] = COption::GetOptionString($module_id, "COLOR_IN_SECTION_LINK", "1");
}
$arIBlock = [];
if($arCurrentValues["IBLOCK_TYPE"])
{
	$rsIBlock = CIBlock::GetList([
		"sort" => "asc"
	], [
		"TYPE" => $arCurrentValues["IBLOCK_TYPE"],
		"ACTIVE" => "Y"
	]);
	while ($arr = $rsIBlock->Fetch())
	{
		$arIBlockSel["REFERENCE_ID"][] = $arr["ID"];
		$arIBlockSel["REFERENCE"][] = "[" . $arr["ID"] . "] " . $arr["NAME"];
	}
}
if($arCurrentValues["BRAND_IBLOCK_TYPE"])
{
	$rsIBlock = CIBlock::GetList([
		"sort" => "asc"
	], [
		"TYPE" => $arCurrentValues["BRAND_IBLOCK_TYPE"],
		"ACTIVE" => "Y"
	]);
	while ($arr = $rsIBlock->Fetch())
	{
		$arBrandIBlockSel["REFERENCE_ID"][] = $arr["ID"];
		$arBrandIBlockSel["REFERENCE"][] = "[" . $arr["ID"] . "] " . $arr["NAME"];
	}
}
if($arCurrentValues["BANNER_IBLOCK_TYPE"])
{
	$rsIBlock = CIBlock::GetList([
		"sort" => "asc"
	], [
		"TYPE" => $arCurrentValues["BANNER_IBLOCK_TYPE"],
		"ACTIVE" => "Y"
	]);
	while ($arr = $rsIBlock->Fetch())
	{
		$arIBlockSelB["REFERENCE_ID"][] = $arr["ID"];
		$arIBlockSelB["REFERENCE"][] = "[" . $arr["ID"] . "] " . $arr["NAME"];
	}
}
if($arCurrentValues["DOCUMENT_IBLOCK_TYPE"])
{
	$rsIBlock = CIBlock::GetList([
		"sort" => "asc"
	], [
		"TYPE" => $arCurrentValues["DOCUMENT_IBLOCK_TYPE"],
		"ACTIVE" => "Y"
	]);
	while ($arr = $rsIBlock->Fetch())
	{
		$arDocumentIBlockSel["REFERENCE_ID"][] = $arr["ID"];
		$arDocumentIBlockSel["REFERENCE"][] = "[" . $arr["ID"] . "] " . $arr["NAME"];
	}
}
if($arCurrentValues["NEWS_IBLOCK_TYPE"])
{
	$rsIBlock = CIBlock::GetList([
		"sort" => "asc"
	], [
		"TYPE" => $arCurrentValues["NEWS_IBLOCK_TYPE"],
		"ACTIVE" => "Y"
	]);
	while ($arr = $rsIBlock->Fetch())
	{
		$arIBlockSelNews["REFERENCE_ID"][] = $arr["ID"];
		$arIBlockSelNews["REFERENCE"][] = "[" . $arr["ID"] . "] " . $arr["NAME"];
	}
}
if(isset($arCurrentValues['IBLOCK_ID']) && 0 < intval($arCurrentValues['IBLOCK_ID']))
{
	$arAllPropList = [];
	$arAllPropList["REFERENCE_ID"][] = "";
	$arAllPropList["REFERENCE"][] = "";
	$arFilePropList["REFERENCE_ID"][] = "";
	$arFilePropList["REFERENCE"][] = "";
	$arListPropList["REFERENCE_ID"][] = "";
	$arListPropList["REFERENCE"][] = "";
	$arElementPropList["REFERENCE_ID"][] = "";
	$arElementPropList["REFERENCE"][] = "";
	$arStringPropList["REFERENCE_ID"][] = "";
	$arStringPropList["REFERENCE"][] = "";
	$arHighloadPropList["REFERENCE_ID"][] = "";
	$arHighloadPropList["REFERENCE"][] = "";
	if($boolCatalog && (isset($arCurrentValues['IBLOCK_ID']) && 0 < intval($arCurrentValues['IBLOCK_ID'])))
	{
		$arSKU = CCatalogSKU::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
		$boolSKU = !empty($arSKU) && is_array($arSKU);
		if($boolSKU)
		{
			COption::SetOptionString($module_id, "OFFER_IBLOCK_ID", $arSKU["IBLOCK_ID"]);
		}
	}
	$rsProps = CIBlockProperty::GetList([
		'SORT' => 'ASC',
		'ID' => 'ASC'
	], [
		'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'],
		'ACTIVE' => 'Y'
	]);
	while ($arProp = $rsProps->Fetch())
	{
		$strPropName = '[' . $arProp['ID'] . ']' . ('' != $arProp['CODE'] ? '[' . $arProp['CODE'] . ']' : '') . ' ' . $arProp['NAME'];
		if('' == $arProp['CODE'])
			$arProp['CODE'] = $arProp['ID'];
		$arAllPropList["REFERENCE_ID"][] = $arProp['CODE'];
		$arAllPropList["REFERENCE"][] = $strPropName;
		if('F' == $arProp['PROPERTY_TYPE'])
		{
			$arFilePropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arFilePropList["REFERENCE"][] = $strPropName;
		}
		if('L' == $arProp['PROPERTY_TYPE'])
		{
			$arListPropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arListPropList["REFERENCE"][] = $strPropName;
			$arAllProps["REFERENCE_ID"][] = $arProp['CODE'];
			$arAllProps["REFERENCE"][] = $strPropName;
		}
		if('E' == $arProp['PROPERTY_TYPE'])
		{
			$arElementPropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arElementPropList["REFERENCE"][] = $strPropName;
			$arAllProps["REFERENCE_ID"][] = $arProp['CODE'];
			$arAllProps["REFERENCE"][] = $strPropName;
			$arDopProps[$arProp['CODE']] = $arProp;
		}
		if('S' == $arProp['PROPERTY_TYPE'] && 'directory' != $arProp['USER_TYPE'])
		{
			$arStringPropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arStringPropList["REFERENCE"][] = $strPropName;
			$arAllProps["REFERENCE_ID"][] = $arProp['CODE'];
			$arAllProps["REFERENCE"][] = $strPropName;
		}

		if('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
		{
			$arHighloadPropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arHighloadPropList["REFERENCE"][] = $strPropName;
			$arAllProps["REFERENCE_ID"][] = $arProp['CODE'];
			$arAllProps["REFERENCE"][] = $strPropName;
		}
		if('N' == $arProp['PROPERTY_TYPE'])
		{
			$arHighloadPropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arHighloadPropList["REFERENCE"][] = $strPropName;
			$arAllProps["REFERENCE_ID"][] = $arProp['CODE'];
			$arAllProps["REFERENCE"][] = $strPropName;
		}
	}
	$arAllPropsColorLink = $arAllProps;
	if($boolSKU)
	{
		$arAllOfferPropList = [];
		$arAllOfferPropList["REFERENCE_ID"][] = "";
		$arAllOfferPropList["REFERENCE"][] = "";
		$arFileOfferPropList["REFERENCE_ID"][] = "";
		$arFileOfferPropList["REFERENCE"][] = "";
		$arTreeOfferPropList["REFERENCE_ID"][] = "";
		$arTreeOfferPropList["REFERENCE"][] = "";

		$rsProps = CIBlockProperty::GetList([
			'SORT' => 'ASC',
			'ID' => 'ASC'
		], [
			'IBLOCK_ID' => $arSKU['IBLOCK_ID'],
			'ACTIVE' => 'Y'
		]);
		while ($arProp = $rsProps->Fetch())
		{
			if($arProp['ID'] == $arSKU['SKU_PROPERTY_ID'])
			{
				continue;
			}
			$arProp['USER_TYPE'] = ( string )$arProp['USER_TYPE'];
			$strPropName = '[' . $arProp['ID'] . ']' . ('' != $arProp['CODE'] ? '[' . $arProp['CODE'] . ']' : '') . ' ' . $arProp['NAME'];
			if('' == $arProp['CODE'])
			{
				$arProp['CODE'] = $arProp['ID'];
			}
			$arAllOfferPropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arAllOfferPropList["REFERENCE"][] = $strPropName;
			if('F' == $arProp['PROPERTY_TYPE'])
			{
				$arFileOfferPropList["REFERENCE_ID"][] = $arProp['CODE'];
				$arFileOfferPropList["REFERENCE"][] = $strPropName;
			}
			if('N' != $arProp['MULTIPLE'])
			{
				continue;
			}
			if(
			('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp)))
			{
				$arTreeOfferPropList["REFERENCE_ID"][] = $arProp['CODE'];
				$arTreeOfferPropList["REFERENCE"][] = $strPropName;
				$arColorTreeOfferPropList["REFERENCE_ID"][] = $arProp['CODE'];
				$arColorTreeOfferPropList["REFERENCE"][] = $strPropName;
			}
		}
	}
	$arPrice = [];
	$arSort = CIBlockParameters::GetElementSortFields([
		'SHOWS',
		'SORT',
		'TIMESTAMP_X',
		'NAME',
		'ID',
		'ACTIVE_FROM',
		'ACTIVE_TO'
	], [
		'KEY_LOWERCASE' => 'Y'
	]);
	$arSort = array_merge($arSort, CCatalogIBlockParameters::GetCatalogSortFields());
	$rsPrice = CCatalogGroup::GetList($v1 = "sort", $v2 = "asc");
	while ($arr = $rsPrice->Fetch())
	{
		$arPrice["REFERENCE_ID"][] = $arr["NAME"];
		$arPrice["REFERENCE"][] = "[" . $arr["NAME"] . "] " . $arr["NAME_LANG"];

		$arPriceSection["REFERENCE_ID"][] = $arr["ID"];
		$arPriceSection["REFERENCE"][] = "[" . $arr["NAME"] . "] " . $arr["NAME_LANG"];
	}
}
if(!empty($arIBlockType))
{
	$arIBlockTypeSel["REFERENCE_ID"][] = "";
	$arIBlockTypeSel["REFERENCE"][] = "";
	foreach ($arIBlockType as $code => $val)
	{
		$arIBlockTypeSel["REFERENCE_ID"][] = $code;
		$arIBlockTypeSel["REFERENCE"][] = $val;
	}
}
$arStyle["REFERENCE_ID"] = [
	"default",
	"min"
];
$arStyle["REFERENCE"] = [
	Loc::getMessage($module_id . '_style_default'),
	Loc::getMessage($module_id . '_style_min')
];

$arElementTemplate["REFERENCE_ID"] = [
	".default",
	"big_photo",
	"without_properties",
	"analog_products_under",
	"other"
];
$arElementTemplate["REFERENCE"] = [
	Loc::getMessage($module_id . '_element_template_default'),
	Loc::getMessage($module_id . '_element_template_big_photo'),
	Loc::getMessage($module_id . '_element_template_without_properties'),
	Loc::getMessage($module_id . '_element_template_analog_products_under'),
	Loc::getMessage($module_id . '_element_template_other')
];


$arElementTemplate["REFERENCE_ID"] = [
	".default",
	"big_photo",
	"without_properties",
	"analog_products_under",
	"other"
];
$arElementTemplate["REFERENCE"] = [
	Loc::getMessage($module_id . '_element_template_default'),
	Loc::getMessage($module_id . '_element_template_big_photo'),
	Loc::getMessage($module_id . '_element_template_without_properties'),
	Loc::getMessage($module_id . '_element_template_analog_products_under'),
	Loc::getMessage($module_id . '_element_template_other'),
];
$arOfferElementPropList["REFERENCE_ID"] = [
	'NAME',
	'PREVIEW_TEXT',
	'DETAIL_TEXT',
	'TAGS'
];
$arOfferElementPropList["REFERENCE"] = [
	Loc::getMessage($module_id . '_OFFERS_ELEMENT_TITLE'),
	Loc::getMessage($module_id . '_OFFERS_ELEMENT_ANONS'),
	Loc::getMessage($module_id . '_OFFERS_ELEMENT_DESCRIPTION'),
	Loc::getMessage($module_id . '_OFFERS_ELEMENT_TAGS')
];
$arOfferElementParamsList["REFERENCE_ID"] = array_diff($arAllOfferPropList["REFERENCE_ID"], $arFileOfferPropList["REFERENCE_ID"]);
$arOfferElementParamsList["REFERENCE"] = array_diff($arAllOfferPropList["REFERENCE"], $arFileOfferPropList["REFERENCE"]);

if(\Bitrix\Main\Loader::includeModule('sale'))
{
	$Deliveries = [];
	$rsDelivery = \Bitrix\Sale\Delivery\Services\Table::getList(
		[
			'select' => [
				'ID',
				'NAME'
			],
			'filter' => [
				'ACTIVE' => 'Y',
				'PARENT_ID' => 0
			]
		]
	);
	while ($delivery = $rsDelivery->fetch())
	{
		$Deliveries["REFERENCE_ID"][] = $delivery['ID'];
		$Deliveries["REFERENCE"][] = '[' . $delivery['ID'] . '] ' . $delivery['NAME'];
	}
	unset($rsDelivery, $delivery);
	$Payments = [];
	$rsPayment = \Bitrix\Sale\Internals\PaySystemActionTable::getList([
		'select' => [
			'ID',
			'NAME'
		],
		'filter' => ['ACTIVE' => 'Y']
	]);
	while ($payment = $rsPayment->Fetch())
	{
		$Payments["REFERENCE_ID"][] = $payment['ID'];
		$Payments["REFERENCE"][] = '[' . $payment['ID'] . '] ' . $payment['NAME'];
	}
	unset($rsPayment, $payment);
}
else
{
	$Deliveries = [
		"REFERENCE_ID" => 0,
		"REFERENCE" => ""
	];
	$Payments = [
		"REFERENCE_ID" => 0,
		"REFERENCE" => ""
	];
}

$arCountInRow["REFERENCE_ID"] = [
	4,
	3,
	2,
	6
];
$arCountInRow["REFERENCE"] = [
	4,
	3,
	2,
	6
];

$arAllPropsColorLinkSection["REFERENCE_ID"] = [
	1,
	2
];
$arAllPropsColorLinkSection["REFERENCE"] = [
	Loc::getMessage($module_id . '_COLOR_IN_SECTION_LINK_1'),
	Loc::getMessage($module_id . '_COLOR_IN_SECTION_LINK_2')
];
if(isset($arCurrentValues["COLOR_IN_SECTION_LINK"]) && $arCurrentValues["COLOR_IN_SECTION_LINK"] == 2)
{
	$arAllPropsColorLinkSectionMain = [
		'REFERENCE_ID' => [0],
		'REFERENCE' => ['-']
	];
	if($arAllPropsColorLink)
	{

		foreach ($arAllPropsColorLink['REFERENCE_ID'] as $val)
		{
			$arAllPropsColorLinkSectionMain['REFERENCE_ID'][] = $val;
		}
		foreach ($arAllPropsColorLink['REFERENCE'] as $val)
		{
			$arAllPropsColorLinkSectionMain['REFERENCE'][] = $val;
		}
	}
}
else
{
	$arAllPropsColorLinkSectionMain = [];
}
$arFlags["REFERENCE_ID"] = array_merge($arListPropList["REFERENCE_ID"], $arStringPropList["REFERENCE_ID"]);
$arFlags["REFERENCE"] = array_merge($arListPropList["REFERENCE"], $arStringPropList["REFERENCE"]);
$arResizeImages["REFERENCE_ID"] = [
	BX_RESIZE_IMAGE_PROPORTIONAL,
	BX_RESIZE_IMAGE_EXACT,
	BX_RESIZE_IMAGE_PROPORTIONAL_ALT
];
$arResizeImages["REFERENCE"] = [
	Loc::getMessage($module_id . '_BX_RESIZE_IMAGE_PROPORTIONAL'),
	Loc::getMessage($module_id . '_BX_RESIZE_IMAGE_EXACT'),
	Loc::getMessage($module_id . '_BX_RESIZE_IMAGE_PROPORTIONAL_ALT')
];

$MenuAll["REFERENCE_ID"][] = -1;
$MenuAll["REFERENCE_ID"][] = 0;
$MenuAll["REFERENCE"][] = Loc::getMessage($module_id . '_MENU_ALL_HIDE');
$MenuAll["REFERENCE"][] = Loc::getMessage($module_id . '_MENU_ALL_SHOW');

$AllSect = [];
$arFilter = [
	'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'],
	'GLOBAL_ACTIVE' => 'Y',
	'DEPTH_LEVEL' => 1
];
$rsSect = CIBlockSection::GetList([
	'NAME' => 'asc'
], $arFilter);
$i = 1;
while ($arSect = $rsSect->GetNext())
{
	$MenuAll["REFERENCE_ID"][] = $i;
	$MenuAll["REFERENCE"][] = Loc::getMessage($module_id . '_MENU_ALL_') . $i;
	++$i;
}

$AddMenuFieldsValue = unserialize(COption::GetOptionString($module_id, 'ADD_MENU_LINKS', 'a:0:{}'));

$AllSect = [];
$arFilter = [
	'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'],
	'GLOBAL_ACTIVE' => 'Y'
];
$rsSect = CIBlockSection::GetList([
	'NAME' => 'asc'
], $arFilter);
while ($arSect = $rsSect->GetNext())
{
	$AllSect[$arSect['SECTION_PAGE_URL']] = '[' . $arSect['ID'] . '] ' . $arSect['NAME'];
}

if(isset($_REQUEST['ADD_MENU_LINKS_PARENT_LINK']) && $_REQUEST['ADD_MENU_LINKS_TITLE'] && $_REQUEST['ADD_MENU_LINKS_URL'] && $_REQUEST['ADD_MENU_LINKS_SORT'])
{
	foreach ($_REQUEST['ADD_MENU_LINKS_PARENT_LINK'] as $i => $Link)
	{
		$AddMenuFieldsValue[$i]['ADD_MENU_LINKS_PARENT_LINK'] = $Link;
		$AddMenuFieldsValue[$i]['ADD_MENU_LINKS_TITLE'] = $_REQUEST['ADD_MENU_LINKS_TITLE'][$i];
		$AddMenuFieldsValue[$i]['ADD_MENU_LINKS_URL'] = $_REQUEST['ADD_MENU_LINKS_URL'][$i];
		$AddMenuFieldsValue[$i]['ADD_MENU_LINKS_SORT'] = $_REQUEST['ADD_MENU_LINKS_SORT'][$i];
	}
}
else
{
	$AddMenuFieldsValue = unserialize(COption::GetOptionString($module_id, 'ADD_MENU_LINKS', 'a:0:{}'));
}

$AddMenuFields = '<div id="AddMenuLinks">';
if(count($AddMenuFieldsValue) > 0 && is_array($AddMenuFieldsValue))
{
	foreach ($AddMenuFieldsValue as $i => $vals)
	{
		$AddMenuFields .= '<div style="border:1px solid #e0e8ea;padding:5px;margin-bottom:10px;"><table><tr><td>' . Loc::getMessage($module_id . '_ADD_MENU_LINKS_PARENT') . '</td><td><select name="ADD_MENU_LINKS_PARENT_LINK[]">';
		foreach ($AllSect as $key => $Sect)
		{
			$AddMenuFields .= '<option value="' . $key . '" ';
			if($key == $vals['ADD_MENU_LINKS_PARENT_LINK'])
				$AddMenuFields .= 'selected';
			$AddMenuFields .= '>';
			$AddMenuFields .= $Sect;
			$AddMenuFields .= '</option>';
		}

		$AddMenuFields .= '</select></td></tr>';
		$AddMenuFields .= '<tr><td>' . Loc::getMessage($module_id . '_ADD_MENU_LINKS_TITLE') . '</td><td><input type="text" name="ADD_MENU_LINKS_TITLE[]" value="' . $vals['ADD_MENU_LINKS_TITLE'] . '"></td></tr>';
		$AddMenuFields .= '<tr><td>' . Loc::getMessage($module_id . '_ADD_MENU_LINKS_URL') . '</td><td><input type="text" name="ADD_MENU_LINKS_URL[]" value="' . $vals['ADD_MENU_LINKS_URL'] . '"></td></tr>';
		$AddMenuFields .= '<tr><td>' . Loc::getMessage($module_id . '_ADD_MENU_LINKS_SORT') . '</td><td><input type="text" name="ADD_MENU_LINKS_SORT[]" value="' . $vals['ADD_MENU_LINKS_SORT'] . '"></td></tr>';
		$AddMenuFields .= '</table></div>';
	}
}
else
{
	$AddMenuFields .= '<div style="border:1px solid #e0e8ea;padding:5px;margin-bottom:10px;"><table><tr><td>' . Loc::getMessage($module_id . '_ADD_MENU_LINKS_PARENT') . '</td><td><select name="ADD_MENU_LINKS_PARENT_LINK[]">';
	foreach ($AllSect as $key => $Sect)
	{
		$AddMenuFields .= '<option value="' . $key . '" ';
		$AddMenuFields .= '>';
		$AddMenuFields .= $Sect;
		$AddMenuFields .= '</option>';
	}

	$AddMenuFields .= '</select></td></tr>';
	$AddMenuFields .= '<tr><td>' . Loc::getMessage($module_id . '_ADD_MENU_LINKS_TITLE') . '</td><td><input type="text" name="ADD_MENU_LINKS_TITLE[]" value=""></td></tr>';
	$AddMenuFields .= '<tr><td>' . Loc::getMessage($module_id . '_ADD_MENU_LINKS_URL') . '</td><td><input type="text" name="ADD_MENU_LINKS_URL[]" value=""></td></tr>';
	$AddMenuFields .= '<tr><td>' . Loc::getMessage($module_id . '_ADD_MENU_LINKS_SORT') . '</td><td><input type="text" name="ADD_MENU_LINKS_SORT[]" value=""></td></tr>';
	$AddMenuFields .= '</table></div>';
}

$AddMenuFields .= '</div>
		 <input type="button" value="+" onclick="new_row()">
			<input type="button" value="-" onclick="delete_row()">
		 <script type="text/javascript">
		 function new_row(){
		 var div = document.createElement("div");
		 div.innerHTML = \'<div style="border:1px solid #e0e8ea;padding:5px;margin-bottom:10px;"><table><tr><td>' . Loc::getMessage($module_id . '_ADD_MENU_LINKS_PARENT') . '</td><td><select name="ADD_MENU_LINKS_PARENT_LINK[]">';
foreach ($AllSect as $key => $Sect)
{
	$AddMenuFields .= '<option value="' . $key . '" ';
	$AddMenuFields .= '>';
	$AddMenuFields .= $Sect;
	$AddMenuFields .= '</option>';
}

$AddMenuFields .= '</select></td></tr>';
$AddMenuFields .= '<tr><td>' . Loc::getMessage($module_id . '_ADD_MENU_LINKS_TITLE') . '</td><td><input type="text" name="ADD_MENU_LINKS_TITLE[]" value=""></td></tr>';
$AddMenuFields .= '<tr><td>' . Loc::getMessage($module_id . '_ADD_MENU_LINKS_URL') . '</td><td><input type="text" name="ADD_MENU_LINKS_URL[]" value=""></td></tr>';
$AddMenuFields .= '<tr><td>' . Loc::getMessage($module_id . '_ADD_MENU_LINKS_SORT') . '</td><td><input type="text" name="ADD_MENU_LINKS_SORT[]" value=""></td></tr>';
$AddMenuFields .= '</table></div>\'';
$AddMenuFields .= '
		 document.getElementById("AddMenuLinks").appendChild(div);
		 }
			function delete_row()
				{
					var ElCnt=document.getElementById("AddMenuLinks").getElementsByTagName("div").length;
					if(ElCnt>1)
					{
						var children = document.getElementById("AddMenuLinks").childNodes;
						document.getElementById("AddMenuLinks").removeChild(children[children.length-1]);
					}
				}
		 </script>';

$personalTypes = [];
$rs = PersonTypeTable::getList(
	[
		'select' => [
			'ID',
			'NAME'
		],
		'filter' => ['ACTIVE' => 'Y']
	]);
while ($personalType = $rs->fetch())
{
	$personalTypes['REFERENCE_ID'][] = $personalType['ID'];
	$personalTypes['REFERENCE'][] = '[' . $personalType['ID'] . '] ' . $personalType['NAME'];
}

$userFields = [
	'REFERENCE_ID' => [
		'EMAIL',
		'TITLE',
		'NAME',
		'SECOND_NAME',
		'LAST_NAME',
		'PERSONAL_PROFESSION',
		'PERSONAL_WWW',
		'PERSONAL_ICQ',
		'PERSONAL_GENDER',
		'PERSONAL_BIRTHDAY',
		'PERSONAL_PHOTO',
		'PERSONAL_PHONE',
		'PERSONAL_FAX',
		'PERSONAL_MOBILE',
		'PERSONAL_PAGER',
		'PERSONAL_STREET',
		'PERSONAL_MAILBOX',
		'PERSONAL_CITY',
		'PERSONAL_STATE',
		'PERSONAL_ZIP',
		'PERSONAL_COUNTRY',
		'PERSONAL_NOTES',
		'WORK_COMPANY',
		'WORK_DEPARTMENT',
		'WORK_POSITION',
		'WORK_WWW',
		'WORK_PHONE',
		'WORK_FAX',
		'WORK_PAGER',
		'WORK_STREET',
		'WORK_MAILBOX',
		'WORK_CITY',
		'WORK_STATE',
		'WORK_ZIP',
		'WORK_COUNTRY',
		'WORK_PROFILE',
		'WORK_LOGO',
		'WORK_NOTES',
	],
	'REFERENCE' => [
		'[EMAIL] ' . Loc::getMessage($module_id . '_USER_FIELD_EMAIL'),
		'[TITLE] ' . Loc::getMessage($module_id . '_USER_FIELD_TITLE'),
		'[NAME] ' . Loc::getMessage($module_id . '_USER_FIELD_NAME'),
		'[SECOND_NAME] ' . Loc::getMessage($module_id . '_USER_FIELD_SECOND_NAME'),
		'[LAST_NAME] ' . Loc::getMessage($module_id . '_USER_FIELD_LAST_NAME'),
		'[PERSONAL_PROFESSION] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_PROFESSION'),
		'[PERSONAL_WWW] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_WWW'),
		'[PERSONAL_ICQ] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_ICQ'),
		'[PERSONAL_GENDER] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_GENDER'),
		'[PERSONAL_BIRTHDAY] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_BIRTHDAY'),
		'[PERSONAL_PHOTO] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_PHOTO'),
		'[PERSONAL_PHONE] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_PHONE'),
		'[PERSONAL_FAX] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_FAX'),
		'[PERSONAL_MOBILE] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_MOBILE'),
		'[PERSONAL_PAGER] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_PAGER'),
		'[PERSONAL_STREET] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_STREET'),
		'[PERSONAL_MAILBOX] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_MAILBOX'),
		'[PERSONAL_CITY] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_CITY'),
		'[PERSONAL_STATE] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_STATE'),
		'[PERSONAL_ZIP] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_ZIP'),
		'[PERSONAL_COUNTRY] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_COUNTRY'),
		'[PERSONAL_NOTES] ' . Loc::getMessage($module_id . '_USER_FIELD_PERSONAL_NOTES'),
		'[WORK_COMPANY] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_COMPANY'),
		'[WORK_DEPARTMENT] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_DEPARTMENT'),
		'[WORK_POSITION] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_POSITION'),
		'[WORK_WWW] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_WWW'),
		'[WORK_PHONE] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_PHONE'),
		'[WORK_FAX] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_FAX'),
		'[WORK_PAGER] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_PAGER'),
		'[WORK_STREET] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_STREET'),
		'[WORK_MAILBOX] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_MAILBOX'),
		'[WORK_CITY] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_CITY'),
		'[WORK_STATE] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_STATE'),
		'[WORK_ZIP] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_ZIP'),
		'[WORK_COUNTRY] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_COUNTRY'),
		'[WORK_PROFILE] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_PROFILE'),
		'[WORK_LOGO] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_LOGO'),
		'[WORK_NOTES] ' . Loc::getMessage($module_id . '_USER_FIELD_WORK_NOTES')
	]
];

$orderFields = [];
$orderFieldsIds = [];
$rs = \Bitrix\Sale\Internals\OrderPropsTable::getList([
	'filter' => [
		'ACTIVE' => 'Y',
	],
	'select' => [
		'ID',
		'CODE',
		'NAME'
	]
]);
while ($property = $rs->fetch())
{
	$orderFields['REFERENCE_ID'][$property['CODE']] = $property['CODE'];
	$orderFields['REFERENCE'][$property['CODE']] = "[" . $property['CODE'] . "] " . $property['NAME'];

	$orderFieldsIds['REFERENCE_ID'][$property['ID']] = $property['ID'];
	$orderFieldsIds['REFERENCE'][$property['ID']] = "[" . $property['ID'] . "][" . $property['CODE'] . "] " . $property['NAME'];
}


$optFilterFields = [];
$optArticul = [];
$optArticulOffer = [];

if($arCurrentValues['IBLOCK_ID'] > 0)
{
	$rsProps = CIBlockProperty::GetList([
		'SORT' => 'ASC',
		'ID' => 'ASC'
	], [
		'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'],
		'ACTIVE' => 'Y',
		'PROPERTY_TYPE' => 'S'
	]);
	while ($opt1 = $rsProps->fetch())
	{
		$optArticul['REFERENCE_ID'][] = $opt1['ID'];
		$optArticul['REFERENCE'][] = '[' . $opt1['ID'] . '][' . $opt1['CODE'] . '] ' . $opt1['NAME'];
	}

	$props = CIBlockSectionPropertyLink::GetArray($arCurrentValues['IBLOCK_ID'], $SECTION_ID = 0, $bNewSection = false);
	foreach ($props as $prop)
	{
		if($prop['SMART_FILTER'] == 'Y')
		{
			$arPropx = CIBlockProperty::GetByID($prop['PROPERTY_ID'])->fetch();
			$optFilterFields['REFERENCE_ID'][] = $arPropx['CODE'];
			$optFilterFields['REFERENCE'][] = '[' . $arPropx['CODE'] . '] ' . $arPropx['NAME'];
		}
	}
	$catalog = CCatalogSku::GetInfoByIBlock($arCurrentValues['IBLOCK_ID']);
	if($catalog['IBLOCK_ID'])
	{
		$rsProps = CIBlockProperty::GetList([
			'SORT' => 'ASC',
			'ID' => 'ASC'
		], [
			'IBLOCK_ID' => $catalog['IBLOCK_ID'],
			'ACTIVE' => 'Y',
			'PROPERTY_TYPE' => 'S'
		]);
		while ($opt2 = $rsProps->fetch())
		{
			$optArticulOffer['REFERENCE_ID'][] = $opt2['ID'];
			$optArticulOffer['REFERENCE'][] = '[' . $opt2['ID'] . '][' . $opt2['CODE'] . '] ' . $opt2['NAME'];
		}

		$props = CIBlockSectionPropertyLink::GetArray($catalog['IBLOCK_ID'], $SECTION_ID = 0, $bNewSection = false);
		foreach ($props as $prop)
		{
			if($prop['SMART_FILTER'] == 'Y')
			{
				$arPropx = CIBlockProperty::GetByID($prop['PROPERTY_ID'])->fetch();
				$optFilterFields['REFERENCE_ID'][] = $arPropx['CODE'];
				$optFilterFields['REFERENCE'][] = '[' . $arPropx['CODE'] . '] ' . $arPropx['NAME'];
			}
		}
	}
}

$arGroups = [
	'OPTION_5' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_5'),
		'TAB' => 1
	],
	'OPTION_10' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_10'),
		'TAB' => 1
	],
	'OPTION_15' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_15'),
		'TAB' => 1
	],
	'OPTION_20' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_20'),
		'TAB' => 1
	],
	'OPTION_25' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_25'),
		'TAB' => 1
	],
	'OPTION_27' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_27'),
		'TAB' => 1
	],
	'OPTION_30' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_30'),
		'TAB' => 1
	],
	'OPTION_32' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_32'),
		'TAB' => 1
	],
	'OPTION_35' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_35'),
		'TAB' => 2
	],
	'OPTION_40' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_40'),
		'TAB' => 2
	],
	'OPTION_45' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_45'),
		'TAB' => 2
	],
	'OPTION_50' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_50'),
		'TAB' => 3
	],
	'OPTION_55' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_55'),
		'TAB' => 4
	],
	'OPTION_60' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_60'),
		'TAB' => 5
	],
	'OPTION_65' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_65'),
		'TAB' => 6
	],
	'OPTION_67' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_67'),
		'TAB' => 7
	],
	'OPTION_70' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_70'),
		'TAB' => 8
	],
	'OPTION_75' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_75'),
		'TAB' => 9
	],
	'OPTION_80' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_80'),
		'TAB' => 10
	],
	'OPTION_85' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_85'),
		'TAB' => 10
	],
	'OPTION_100' => [
		'TITLE' => Loc::getMessage($module_id . '_OPTION_100'),
		'TAB' => 11
	],


];
$arOptions = [
	'STYLE' => [
		'GROUP' => 'OPTION_5',
		'TITLE' => Loc::getMessage($module_id . '_STYLE'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '10',
		'VALUES' => $arStyle
	],
	'ELEMENT_TEMPLATE' => [
		'GROUP' => 'OPTION_5',
		'TITLE' => GetMessage($module_id . '_ELEMENT_TEMPLATE'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '20',
		'VALUES' => $arElementTemplate,
		'OTHER' => 'Y'
	],
	'IBLOCK_TYPE' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_IBLOCK_TYPE'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'Y',
		'SORT' => '10',
		'VALUES' => $arIBlockTypeSel
	],
	'IBLOCK_ID' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_IBLOCK_ID'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'Y',
		'SORT' => '20',
		'VALUES' => $arIBlockSel
	],
	"PRICE_CODE" => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_PRICE_CODE'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '23',
		'VALUES' => $arPrice
	],
	'OFFER_TREE_PROPS' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_OFFER_TREE_PROPS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '25',
		'VALUES' => $arTreeOfferPropList
	],
	'OFFER_COLOR_PROP' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_OFFER_COLOR_PROP'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '30',
		'VALUES' => $arTreeOfferPropList
	],
	'MANUFACTURER_ELEMENT_PROPS' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_MANUFACTURER_ELEMENT_PROPS'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '40',
		'VALUES' => $arElementPropList
	],
	'MANUFACTURER_LIST_PROPS' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_MANUFACTURER_LIST_PROPS'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '50',
		'VALUES' => $arFlags
	],
	'MANUFACTURER_LIST_PROPS' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_MANUFACTURER_LIST_PROPS'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '50',
		'VALUES' => $arFlags
	],
	'MAIN_PROPS' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_MAIN_PROPS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '54',
		'VALUES' => $arAllProps
	],
	'DOP_PROPS' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_DOP_PROPS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '55',
		'VALUES' => $arAllProps
	],
	'FLAG_PROPS' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_FLAG_PROPS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '60',
		'VALUES' => $arFlags
	],
	'DELETE_OFFER_NOIMAGE' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_DELETE_OFFER_NOIMAGE'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '70',
		'DEFAULT' => "N"
	],
	'PICTURE_FROM_OFFER' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_PICTURE_FROM_OFFER'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '80',
		'DEFAULT' => 'N'
	],
	'MORE_PHOTO_PRODUCT_PROPS' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => GetMessage($module_id . '_MORE_PHOTO_PRODUCT_PROPS'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '90',
		'VALUES' => $arFilePropList
	],
	'ELEMENT_TEMPLATE' => [
		'GROUP' => 'OPTION_5',
		'TITLE' => Loc::getMessage($module_id . '_ELEMENT_TEMPLATE'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '20',
		'VALUES' => $arElementTemplate,
		'OTHER' => 'Y'
	],
	'IMAGE_RESIZE_MODE' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => Loc::getMessage($module_id . '_IMAGE_RESIZE_MODE'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '110',
		'VALUES' => $arResizeImages
	],
	'LAZY_LOAD' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => Loc::getMessage($module_id . '_LAZY_LOAD'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '120',
		'DEFAULT' => 'N'
	],
	'AJAX_PRODUCT_LOAD' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => Loc::getMessage($module_id . '_AJAX_PRODUCT_LOAD'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '130',
		'DEFAULT' => 'N'
	],
	'REPLACE_COMPONENT_PARAMS' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => Loc::getMessage($module_id . '_REPLACE_COMPONENT_PARAMS'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '140',
		'DEFAULT' => 'Y',
		'NOTES' => Loc::getMessage($module_id . '_REPLACE_COMPONENT_PARAMS_NOTE')
	],
	'IS_FANCY' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => Loc::getMessage($module_id . '_IS_FANCY'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'DEFAULT' => 'N',
		'SORT' => '150'
	],
	'ORDER_ORDERPHONE' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => Loc::getMessage($module_id . '_ORDER_ORDERPHONE'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'DEFAULT' => 'Y',
		'SORT' => '160'
	],
	'SHOW_PHONES' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_PHONES'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'DEFAULT' => 'Y',
		'SORT' => '155'
	],
	'USE_MULTIREGIONS' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => Loc::getMessage($module_id . '_USE_MULTIREGIONS'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'DEFAULT' => 'Y',
		'SORT' => '168'
	],
	'ADD_FILES' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => Loc::getMessage($module_id . '_ADD_FILES'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'MULTI' => 'Y',
		'SIZE' => '60',
		'SORT' => '170'
	],
	'HIDE_NOT_AVAILABLE' => [
		'GROUP' => 'OPTION_10',
		'TITLE' => Loc::getMessage($module_id . '_HIDE_NOT_AVAILABLE'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'VALUES' => [
			'REFERENCE_ID' => [
				'L',
				'Y',
				'N'
			],
			'REFERENCE' => [
				Loc::getMessage($module_id . '_HIDE_NOT_AVAILABLE_L'),
				Loc::getMessage($module_id . '_HIDE_NOT_AVAILABLE_Y'),
				Loc::getMessage($module_id . '_HIDE_NOT_AVAILABLE_N'),
			]
		],
		'SORT' => '180'
	],
	'SHOW_BIG_DATA_MAINPAGE' => [
		'GROUP' => 'OPTION_15',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_BIG_DATA_MAINPAGE'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '10',
		'DEFAULT' => 'Y'
	],
	'SHOW_BUYING_MAINPAGE' => [
		'GROUP' => 'OPTION_15',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_BUYING_MAINPAGE'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '20',
		'DEFAULT' => 'Y'
	],

	'LIST_WIDTH_SMALL' => [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_LIST_WIDTH_SMALL'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '10'
	],
	'LIST_HEIGHT_SMALL' => [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_LIST_HEIGHT_SMALL'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '20'
	],
	'LIST_WIDTH_MEDIUM' => [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_LIST_WIDTH_MEDIUM'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '30'
	],
	'LIST_HEIGHT_MEDIUM' => [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_LIST_HEIGHT_MEDIUM'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '40'
	],
	'FILTER_ITEM_COUNT' => [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_FILTER_ITEM_COUNT'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '50'
	],
	'CATALOG_LIST_COUNT' => [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_CATALOG_LIST_COUNT'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'DEFAULT' => "12",
		'SORT' => '60'
	],
	'CATALOG_LIST_COUNT_IN_ROW' => [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_CATALOG_LIST_COUNT_IN_ROW'),
		'VALUES' => $arCountInRow,
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '70'
	],
	'CATALOG_FILTER' => [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_CATALOG_FILTER'),
		'VALUES' => [
			'REFERENCE_ID' => [
				'N',
				'Y'
			],
			'REFERENCE' => [
				Loc::getMessage($module_id . '_CATALOG_FILTER_OUR'),
				Loc::getMessage($module_id . '_CATALOG_FILTER_BITRIX')
			]
		],
		'TYPE' => 'SELECT',
		'TITLE' => GetMessage($module_id . '_CATALOG_FILTER'),
		'VALUES' => [
			'REFERENCE_ID' => [
				'N',
				'Y'
			],
			'REFERENCE' => [
				GetMessage($module_id . '_CATALOG_FILTER_OUR'),
				GetMessage($module_id . '_CATALOG_FILTER_BITRIX')
			]
		],
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '80'
	],

	'SHOW_BRICKS' => [
		'GROUP' => 'OPTION_20',
		'TITLE' => GetMessage($module_id . '_SHOW_BRICKS'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'VALUES' => [
			'REFERENCE_ID' => [
				'N',
				'Y'
			],
			'REFERENCE' => [
				GetMessage($module_id . '_SHOW_BRICKS_1'),
				GetMessage($module_id . '_SHOW_BRICKS_2')
			]
		],
		'SORT' => '85'
	],

	'DETAIL_WIDTH_SMALL' => [
		'GROUP' => 'OPTION_30',
		'TITLE' => GetMessage($module_id . '_DETAIL_WIDTH_SMALL'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '80'
	],

	'SHOW_BRICKS' => [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_BRICKS'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'VALUES' => [
			'REFERENCE_ID' => [
				'N',
				'Y'
			],
			'REFERENCE' => [
				Loc::getMessage($module_id . '_SHOW_BRICKS_1'),
				Loc::getMessage($module_id . '_SHOW_BRICKS_2')
			]
		],
		'SORT' => '85'
	],
	'SEOMETA_TAGS' => [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_SEOMETA_TAGS'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'VALUES' => [
			'REFERENCE_ID' => [
				'NO',
				'TOP',
				'BOTTOM',
				'ALL'
			],
			'REFERENCE' => [
				Loc::getMessage($module_id . '_SEOMETA_TAGS_NO'),
				Loc::getMessage($module_id . '_SEOMETA_TAGS_TOP'),
				Loc::getMessage($module_id . '_SEOMETA_TAGS_BOTTOM'),
				Loc::getMessage($module_id . '_SEOMETA_TAGS_ALL')
			]
		],
		'SORT' => '90'
	],
	'SHOW_BIG_DATA_SECTION_UNDER' => [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_BIG_DATA_SECTION_UNDER'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '100',
		'DEFAULT' => 'Y'
	],
	'SHOW_YOU_LOOK_SECTION_UNDER' => [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_YOU_LOOK_SECTION_UNDER'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '110',
		'DEFAULT' => 'Y'
	],
	'DETAIL_WIDTH_SMALL' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_DETAIL_WIDTH_SMALL'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '10'
	],
	'DETAIL_HEIGHT_SMALL' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_DETAIL_HEIGHT_SMALL'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '20'
	],
	'DETAIL_WIDTH_MEDIUM' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_DETAIL_WIDTH_MEDIUM'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '30'
	],
	'DETAIL_HEIGHT_MEDIUM' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_DETAIL_HEIGHT_MEDIUM'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '40'
	],
	'DETAIL_WIDTH_BIG' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_DETAIL_WIDTH_BIG'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '50'
	],
	'DETAIL_HEIGHT_BIG' => [
		'GROUP' => 'OPTION_30',
		'TITLE' => Loc::getMessage($module_id . '_DETAIL_HEIGHT_BIG'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '60'
	],
	'DOWNLOAD' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_DOWNLOAD'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'DEFAULT' => 'N',
		'SORT' => '75'
	],
	'DETAIL_ORDERPHONE' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_DETAIL_ORDERPHONE'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'DEFAULT' => 'Y',
		'SORT' => '76'
	],
	'COLOR_FROM_IMAGE' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_COLOR_FROM_IMAGE'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'DEFAULT' => 'Y',
		'SORT' => '77'
	],
	'COLOR_OFFER_FROM_IMAGE' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_COLOR_OFFER_FROM_IMAGE'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'DEFAULT' => 'N',
		'SORT' => '78',
		'VALUES' => $arTreeOfferPropList
	],
	'COLOR_IMAGE_WIDTH' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_COLOR_IMAGE_WIDTH'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'DEFAULT' => '37',
		'SORT' => '79'
	],
	'COLOR_SLIDER_COUNT_IMAGES_HOR' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_COLOR_SLIDER_COUNT_IMAGES_HOR'),
		'TYPE' => 'INT',
		'REFRESH' => 'N',
		'DEFAULT' => '4',
		'SORT' => '80'
	],
	'COLOR_SLIDER_COUNT_IMAGES_VER' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_COLOR_SLIDER_COUNT_IMAGES_VER'),
		'TYPE' => 'INT',
		'REFRESH' => 'N',
		'DEFAULT' => '2',
		'SORT' => '81'
	],
	'COLOR_IMAGE_HEIGHT' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_COLOR_IMAGE_HEIGHT'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'DEFAULT' => '100',
		'SORT' => '82'
	],
	'DETAIL_TEXT_INCLUDE' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_DETAIL_TEXT_INCLUDE'),
		'TYPE' => 'TEXT',
		'DEFAULT' => "",
		"ROWS" => 30,
		"COLS" => 50,
		'SORT' => '83'
	],
	// START
	'OFFER_ELEMENT_PROPS' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_OFFER_ELEMENT_PROPS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '85',
		'VALUES' => $arOfferElementPropList
	],
	'OFFER_ELEMENT_PARAMS' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_OFFER_ELEMENT_PARAMS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '90',
		'VALUES' => $arOfferElementParamsList
	],
	'TEL_MASK' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_TEL_MASK'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '95',
		'DEFAULT' => "+7(999)999-99-99"
	],
	'TEL_DELIVERY_ID' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_TEL_DELIVERY_ID'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '100',
		'VALUES' => $Deliveries
	],
	'TEL_PAY_SYSTEM_ID' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_TEL_PAY_SYSTEM_ID'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '105',
		'VALUES' => $Payments
	],
	'MODIFICATION' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_MODIFICATION'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'DEFAULT' => 'N',
		'SORT' => '110'
	],
	'MODIFICATION_COUNT' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_MODIFICATION_COUNT'),
		'TYPE' => 'INT',
		'REFRESH' => 'N',
		'DEFAULT' => '4',
		'SORT' => '115'
	],
	'FULL_WIDTH_DESCRIPTION' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_FULL_WIDTH_DESCRIPTION'),
		'TITLE' => GetMessage($module_id . '_FULL_WIDTH_DESCRIPTION'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'DEFAULT' => 'N',
		'SORT' => '120'
	],
	'SHOW_BIG_DATA_ELEMENT_UNDER' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_BIG_DATA_ELEMENT_UNDER'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '130',
		'DEFAULT' => 'Y'
	],
	'SHOW_BIG_DATA_ELEMENT_RIGHT' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_BIG_DATA_ELEMENT_RIGHT'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '140',
		'DEFAULT' => 'Y'
	],
	'SHOW_YOU_LOOK_ELEMENT_UNDER' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_YOU_LOOK_ELEMENT_UNDER'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '160',
		'DEFAULT' => 'Y'
	],
	'SHOW_LOOKING_ELEMENT' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_LOOKING_ELEMENT'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '190',
		'DEFAULT' => 'Y'
	],
	'SHOW_ANALOG_PRODUCTS_ELEMENT' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_ANALOG_PRODUCTS_ELEMENT'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '210',
		'DEFAULT' => 'Y'
	],
	'SHOW_BRAND_PRODUCT_ELEMENT' => [
		'GROUP' => 'OPTION_25',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_BRAND_PRODUCT_ELEMENT'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '230',
		'DEFAULT' => 'Y'
	],
	'SHOW_CONFIDENTIAL_CONTACTS' => [
		'GROUP' => 'OPTION_27',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_CONFIDENTIAL_CONTACTS'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '10',
		'DEFAULT' => 'Y'
	],
	'SHOW_CONFIDENTIAL_REGISTRATION' => [
		'GROUP' => 'OPTION_27',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_CONFIDENTIAL_REGISTRATION'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '20',
		'DEFAULT' => 'Y'
	],
	'SHOW_CONFIDENTIAL_ORDER' => [
		'GROUP' => 'OPTION_27',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_CONFIDENTIAL_ORDER'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '30',
		'DEFAULT' => 'Y'
	],
	'SHOW_CONFIDENTIAL_SUBSCRIBE' => [
		'GROUP' => 'OPTION_27',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_CONFIDENTIAL_SUBSCRIBE'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '32',
		'DEFAULT' => 'Y'
	],
	'SHOW_CONFIDENTIAL_PHONE' => [
		'GROUP' => 'OPTION_27',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_CONFIDENTIAL_PHONE'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '34',
		'DEFAULT' => 'Y'
	],
	'CONFIDENTIAL_CHECKED' => [
		'GROUP' => 'OPTION_27',
		'TITLE' => Loc::getMessage($module_id . '_CONFIDENTIAL_CHECKED'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '40',
		'DEFAULT' => 'Y'
	],
	'CONFIDENTIAL_URL' => [
		'GROUP' => 'OPTION_27',
		'TITLE' => Loc::getMessage($module_id . '_CONFIDENTIAL_URL'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '50',
		'DEFAULT' => '/help/confidentiality/'
	],
	'URL_CART' => [
		'GROUP' => 'OPTION_30',
		'TITLE' => Loc::getMessage($module_id . '_URL_CART'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '10'
	],
	'URL_ORDER' => [
		'GROUP' => 'OPTION_30',
		'TITLE' => Loc::getMessage($module_id . '_URL_ORDER'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '20'
	],
	'URL_PERSONAL' => [
		'GROUP' => 'OPTION_30',
		'TITLE' => Loc::getMessage($module_id . '_URL_PERSONAL'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '30'
	],
	'URL_PAYMENT' => [
		'GROUP' => 'OPTION_30',
		'TITLE' => Loc::getMessage($module_id . '_URL_PAYMENT'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '40'
	],
	'URL_PAGE_ORDER' => [
		'GROUP' => 'OPTION_30',
		'TITLE' => Loc::getMessage($module_id . '_URL_PAGE_ORDER'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '45'
	],
	'URL_PATH' => [
		'GROUP' => 'OPTION_30',
		'TITLE' => Loc::getMessage($module_id . '_URL_PATH'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'VALUES' => [
			'REFERENCE_ID' => [
				'ORDER',
				'BASKET'
			],
			'REFERENCE' => [
				Loc::getMessage($module_id . '_URL_PATH_ORDER'),
				Loc::getMessage($module_id . '_URL_PATH_BASKET'),
			]
		],
		'SORT' => '50'
	],
	'CART_IMG_WIDTH' => [
		'GROUP' => 'OPTION_30',
		'TITLE' => Loc::getMessage($module_id . '_CART_IMG_WIDTH'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '50'
	],
	'CART_IMG_HEIGHT' => [
		'GROUP' => 'OPTION_30',
		'TITLE' => Loc::getMessage($module_id . '_CART_IMG_HEIGHT'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '60'
	],
	'CART_IN_ORDER' => [
		'GROUP' => 'OPTION_30',
		'TITLE' => Loc::getMessage($module_id . '_CART_IN_ORDER'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'DEFAULT' => 'Y',
		'SORT' => '65'
	],
	'MASK_ORDER_PROPS' => [
		'GROUP' => 'OPTION_30',
		'TITLE' => Loc::getMessage($module_id . '_MASK_ORDER_PROPS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'VALUES' => $orderFieldsIds,
		'SORT' => '70',
	],
	'SHOW_PERSON_TYPE_BUYERS' => [
		'GROUP' => 'OPTION_32',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_PERSON_TYPE_BUYERS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'VALUES' => $personalTypes,
		'SORT' => '10',
		'NOTES' => Loc::getMessage($module_id . '_SHOW_PERSON_TYPE_BUYERS_NOTES'),
	],
	'PERSONAL_PERSON_TYPE' => [
		'GROUP' => 'OPTION_32',
		'TITLE' => Loc::getMessage($module_id . '_PERSONAL_PERSON_TYPE'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'VALUES' => $personalTypes,
		'SORT' => '10',
		'NOTES' => Loc::getMessage($module_id . '_PERSONAL_PERSON_TYPE_NOTES'),
	],
    'BLOCK_MANAGER_ENABLE' => [
        'GROUP' => 'OPTION_32',
        'TITLE' => Loc::getMessage($module_id . '_BLOCK_MANAGER_ENABLE'),
        'TYPE' => 'CHECKBOX',
        'REFRESH' => 'N',
        //        'VALUES' => $personalTypes,
        'SORT' => '5',
        'NOTES' => Loc::getMessage($module_id . '_BLOCK_MANAGER_ENABLE_NOTES'),
    ],
    'DEFAUL_MANAGER_ID' => [
        'GROUP' => 'OPTION_32',
        'TITLE' => Loc::getMessage($module_id . '_DEFAUL_MANAGER_ID'),
        'TYPE' => 'INT',
        'REFRESH' => 'N',
//        'VALUES' => $personalTypes,
        'SORT' => '10',
        'NOTES' => Loc::getMessage($module_id . '_DEFAUL_MANAGER_ID_NOTES'),
    ],
	'ORDER_ITEM_SHOW_COUNT' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_ORDER_ITEM_SHOW_COUNT'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'DEFAULT' => '5',
		'SORT' => '67'
	],
	'IBLOCK_TYPE' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_IBLOCK_TYPE'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'Y',
		'SORT' => '15',
		'VALUES' => $arIBlockTypeSel
	],
	'IBLOCK_ID' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_IBLOCK_ID'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'Y',
		'SORT' => '20',
		'VALUES' => $arIBlockSel
	],
	"PRICE_CODE" => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_PRICE_CODE'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '23',
		'VALUES' => $arPrice
	],
	'OFFER_TREE_PROPS' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_OFFER_TREE_PROPS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '25',
		'VALUES' => $arTreeOfferPropList
	],
	'OFFER_COLOR_PROP' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_OFFER_COLOR_PROP'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '35',
		'VALUES' => $arTreeOfferPropList
	],
	'MANUFACTURER_ELEMENT_PROPS' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_MANUFACTURER_ELEMENT_PROPS'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '40',
		'VALUES' => $arElementPropList
	],

	'MANUFACTURER_LIST_PROPS' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_MANUFACTURER_LIST_PROPS'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '50',
		'VALUES' => $arFlags
	],
	'MANUFACTURER_LIST_PROPS' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_MANUFACTURER_LIST_PROPS'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '50',
		'VALUES' => $arFlags
	],
	'MAIN_PROPS' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_MAIN_PROPS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '54',
		'VALUES' => $arAllProps
	],
	'DOP_PROPS' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_DOP_PROPS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '55',
		'VALUES' => $arAllProps
	],
	'FLAG_PROPS' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_FLAG_PROPS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '60',
		'VALUES' => $arFlags
	],
	'DELETE_OFFER_NOIMAGE' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_DELETE_OFFER_NOIMAGE'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '70',
		'DEFAULT' => "N"
	],
	'PICTURE_FROM_OFFER' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_PICTURE_FROM_OFFER'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '80',
		'DEFAULT' => 'N'
	],
	'MORE_PHOTO_PRODUCT_PROPS' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_MORE_PHOTO_PRODUCT_PROPS'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '90',
		'VALUES' => $arFilePropList
	],
	'MORE_PHOTO_OFFER_PROPS' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_MORE_PHOTO_OFFER_PROPS'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '90',
		'VALUES' => $arFileOfferPropList
	],
	'MAILING_CATEGORIES_ID' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_MAILING_CATEGORIES_ID'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '95',
		'VALUES' => $categoriesList
	],
	'AVAILABLE_DELETE' => [
		'GROUP' => 'OPTION_35',
		'TITLE' => Loc::getMessage($module_id . '_AVAILABLE_DELETE'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '100',
		'DEFAULT' => 'N',
		'NOTES' => Loc::getMessage($module_id . '_AVAILABLE_DELETE_DESCR')
	],
	'COLOR_IN_PRODUCT' => [
		'GROUP' => 'OPTION_40',
		'TITLE' => Loc::getMessage($module_id . '_COLOR_IN_PRODUCT'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'DEFAULT' => 'N',
		'SORT' => '10',
		'NOTES' => Loc::getMessage($module_id . '_COLOR_IN_PRODUCT_NOTE')
	],
	'COLOR_IN_PRODUCT_CODE' => [
		'GROUP' => 'OPTION_40',
		'TITLE' => Loc::getMessage($module_id . '_COLOR_IN_PRODUCT_CODE'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'VALUES' => $arHighloadPropList,
		'SORT' => '15'
	],
	'COLOR_IN_SECTION_LINK' => [
		'GROUP' => 'OPTION_40',
		'TITLE' => Loc::getMessage($module_id . '_COLOR_IN_SECTION_LINK'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'Y',
		'VALUES' => $arAllPropsColorLinkSection,
		'SORT' => '20'
	],
	'COLOR_IN_SECTION_LINK_MAIN' => [
		'GROUP' => 'OPTION_40',
		'TITLE' => Loc::getMessage($module_id . '_COLOR_IN_SECTION_LINK_MAIN'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'VALUES' => $arAllPropsColorLinkSectionMain,
		'SORT' => '25',
		'NOTES' => Loc::getMessage($module_id . '_COLOR_IN_SECTION_LINK_MAIN_NOTE')
	],
	'COLOR_IN_PRODUCT_LINK' => [
		'GROUP' => 'OPTION_40',
		'TITLE' => Loc::getMessage($module_id . '_COLOR_IN_PRODUCT_LINK'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'VALUES' => $arAllPropsColorLink,
		'DEFAULT' => 'Y',
		'SORT' => '30',
		'NOTES' => Loc::getMessage($module_id . '_COLOR_IN_PRODUCT_LINK_NOTE')
	],
	'SIZE_PROPS' => [
		'GROUP' => 'OPTION_45',
		'TITLE' => Loc::getMessage($module_id . '_SIZE_PROPS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '10',
		'VALUES' => $arTreeOfferPropList
	],
	'TABLE_SIZE_URL' => [
		'GROUP' => 'OPTION_45',
		'TITLE' => Loc::getMessage($module_id . '_TABLE_SIZE_URL'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '20'
	],
	'COUNT_BRAND_MENU' => [
		'GROUP' => 'OPTION_50',
		'TITLE' => Loc::getMessage($module_id . '_COUNT_BRAND_MENU'),
		'TYPE' => 'STRING',
		'DEFAULT' => '10',
		'SORT' => '41'
	],
	'MENU_ALL' => [
		'GROUP' => 'OPTION_50',
		'TITLE' => Loc::getMessage($module_id . '_MENU_ALL'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '70',
		'VALUES' => $MenuAll,
		'NOTES' => Loc::getMessage($module_id . '_MENU_ALL_NOTE')
	],
	'MENU_ALL_THIRD_SHOW' => [
		'GROUP' => 'OPTION_50',
		'TITLE' => Loc::getMessage($module_id . '_MENU_ALL_THIRD_SHOW'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'SORT' => '80',
		'DEFAULT' => 'N'
	],
	'ADD_MENU_LINKS' => [
		'GROUP' => 'OPTION_50',
		'TITLE' => Loc::getMessage($module_id . '_ADD_MENU_LINKS'),
		'TYPE' => 'CUSTOM',
		'REFRESH' => 'Y',
		'VALUE' => $AddMenuFields,
		'SORT' => '100'
	],
	'LEFT_MENU_CNT_VISIBLE_LI' => [
		'GROUP' => 'OPTION_50',
		'TITLE' => Loc::getMessage($module_id . '_LEFT_MENU_CNT_VISIBLE_LI'),
		'TYPE' => 'INT',
		'REFRESH' => 'N',
		'DEFAULT' => '0',
		'MIN' => '0',
		'SORT' => '120'
	],
	'LEFT_MENU_CNT_VISIBLE_LI' => [
		'GROUP' => 'OPTION_50',
		'TITLE' => Loc::getMessage($module_id . '_LEFT_MENU_CNT_VISIBLE_LI'),
		'TYPE' => 'INT',
		'REFRESH' => 'N',
		'DEFAULT' => '0',
		'MIN' => '0',
		'SORT' => '120'
	],
	'BRAND_IBLOCK_TYPE' => [
		'GROUP' => 'OPTION_55',
		'TITLE' => Loc::getMessage($module_id . '_BRAND_IBLOCK_TYPE'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'Y',
		'SORT' => '10',
		'VALUES' => $arIBlockTypeSel
	],
	'BRAND_IBLOCK_ID' => [
		'GROUP' => 'OPTION_55',
		'TITLE' => Loc::getMessage($module_id . '_BRAND_IBLOCK_ID'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'Y',
		'SORT' => '20',
		'VALUES' => $arBrandIBlockSel
	],
	'BANNER_IBLOCK_TYPE' => [
		'GROUP' => 'OPTION_60',
		'TITLE' => Loc::getMessage($module_id . '_IBLOCK_TYPE'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'Y',
		'SORT' => '10',
		'VALUES' => $arIBlockTypeSel
	],
	'BANNER_IBLOCK_ID' => [
		'GROUP' => 'OPTION_60',
		'TITLE' => Loc::getMessage($module_id . '_IBLOCK_ID'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'Y',
		'SORT' => '20',
		'VALUES' => $arIBlockSelB
	],
	'NEWS_IBLOCK_TYPE' => [
		'GROUP' => 'OPTION_65',
		'TITLE' => Loc::getMessage($module_id . '_IBLOCK_TYPE'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'Y',
		'SORT' => '10',
		'VALUES' => $arIBlockTypeSel
	],
	'NEWS_IBLOCK_ID' => [
		'GROUP' => 'OPTION_65',
		'TITLE' => Loc::getMessage($module_id . '_IBLOCK_ID'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'Y',
		'SORT' => '20',
		'VALUES' => $arIBlockSelNews
	],
	'LOGO' => [
		'GROUP' => 'OPTION_70',
		'TITLE' => Loc::getMessage($module_id . '_LOGO'),
		'TYPE' => 'FILE',
		'REFRESH' => 'N',
		'SORT' => '10'
	],
	'EMAIL' => [
		'GROUP' => 'OPTION_70',
		'TITLE' => Loc::getMessage($module_id . '_EMAIL'),
		'TYPE' => 'STRING',
		'DEFAULT' => COption::GetOptionString("main", "email_from"),
		'SORT' => '20'
	],
	'TEL' => [
		'GROUP' => 'OPTION_70',
		'TITLE' => Loc::getMessage($module_id . '_TEL'),
		'TYPE' => 'TEXT',
		'DEFAULT' => "",
		'SORT' => '30'
	],
	'COPYRIGHT' => [
		'GROUP' => 'OPTION_70',
		'TITLE' => Loc::getMessage($module_id . '_COPYRIGHT'),
		'TYPE' => 'TEXT',
		'DEFAULT' => "",
		'SORT' => '40'
	],
	'LINK_VK' => [
		'GROUP' => 'OPTION_75',
		'TITLE' => Loc::getMessage($module_id . '_LINK_VK'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '10'
	],
	'LINK_FB' => [
		'GROUP' => 'OPTION_75',
		'TITLE' => Loc::getMessage($module_id . '_LINK_FB'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '20'
	],
	'LINK_TW' => [
		'GROUP' => 'OPTION_75',
		'TITLE' => Loc::getMessage($module_id . '_LINK_TW'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '30'
	],
	'LINK_GL' => [
		'GROUP' => 'OPTION_75',
		'TITLE' => Loc::getMessage($module_id . '_LINK_GL'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '40'
	],
	'LINK_INSTAGRAM' => [
		'GROUP' => 'OPTION_75',
		'TITLE' => Loc::getMessage($module_id . '_LINK_INSTAGRAM'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '50'
	],
	'LINK_OK' => [
		'GROUP' => 'OPTION_75',
		'TITLE' => Loc::getMessage($module_id . '_LINK_OK'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'SORT' => '60'
	],
	'YANDEX' => [
		'GROUP' => 'OPTION_80',
		'TITLE' => Loc::getMessage($module_id . '_YANDEX'),
		'TYPE' => 'TEXT',
		'DEFAULT' => "",
		"ROWS" => 30,
		"COLS" => 50,
		'SORT' => '80'
	],
	'GOOGLE' => [
		'GROUP' => 'OPTION_85',
		'TITLE' => Loc::getMessage($module_id . '_GOOGLE'),
		'TYPE' => 'TEXT',
		'DEFAULT' => "",
		"ROWS" => 30,
		"COLS" => 50,
		'SORT' => '90'
	],
];


if(in_array($module_id, [
	'sotbit.b2bshop',
	'sotbit.b2bshop'
]))
{
	unset($arOptions['STYLE']);
}


if(in_array($module_id, ['sotbit.b2bshop']))
{
	$arOptions["SECTION_VIEW_ACCESS"] = [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_SECTION_VIEW_ACCESS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'SORT' => '88',
		'VALUES' => [
			'REFERENCE_ID' => [
				'block',
				'row'
			],
			'REFERENCE' => [
				Loc::getMessage($module_id . '_SECTION_VIEW_BLOCK'),
				Loc::getMessage($module_id . '_SECTION_VIEW_ROW'),
			]
		]
	];
	$arOptions["SECTION_VIEW"] = [
		'GROUP' => 'OPTION_20',
		'TITLE' => Loc::getMessage($module_id . '_SECTION_VIEW'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'N',
		'SORT' => '90',
		'VALUES' => [
			'REFERENCE_ID' => [
				'block',
				'row'
			],
			'REFERENCE' => [
				Loc::getMessage($module_id . '_SECTION_VIEW_BLOCK'),
				Loc::getMessage($module_id . '_SECTION_VIEW_ROW'),
			]
		]
	];
	$arOptions['SHOW_PERSON_TYPE_BUYERS'] = [
		'GROUP' => 'OPTION_32',
		'TITLE' => Loc::getMessage($module_id . '_SHOW_PERSON_TYPE_BUYERS'),
		'TYPE' => 'MSELECT',
		'REFRESH' => 'N',
		'VALUES' => $personalTypes,
		'SORT' => '10',
		'NOTES' => Loc::getMessage($module_id . '_SHOW_PERSON_TYPE_BUYERS_NOTES'),
	];
	$arOptions['DOCUMENT_IBLOCK_TYPE'] = [
		'GROUP' => 'OPTION_67',
		'TITLE' => Loc::getMessage($module_id . '_DOCUMENT_IBLOCK_TYPE'),
		'TYPE' => 'SELECT',
		'REFRESH' => 'Y',
		'SORT' => '10',
		'VALUES' => $arIBlockTypeSel
	];
	$arOptions['DOCUMENT_IBLOCK_ID'] = [
		'GROUP' => 'OPTION_67',
		'TITLE' => Loc::getMessage($module_id . '_DOCUMENT_IBLOCK_ID'),
		'TYPE' => 'SELECT',
		'SORT' => '20',
		'VALUES' => $arDocumentIBlockSel
	];
	$arOptions['DOCUMENT_ORG'] = [
		'GROUP' => 'OPTION_67',
		'TITLE' => Loc::getMessage($module_id . '_DOCUMENT_ORG'),
		'TYPE' => 'MSELECT',
		'SORT' => '30',
		'VALUES' => $orderFieldsIds
	];
	$arOptions['DOCUMENT_ORG_NAME'] = [
		'GROUP' => 'OPTION_67',
		'TITLE' => Loc::getMessage($module_id . '_DOCUMENT_ORG_NAME'),
		'TYPE' => 'MSELECT',
		'SORT' => '30',
		'VALUES' => $orderFieldsIds
	];
}

$RIGHT = $APPLICATION->GetGroupRight($module_id);
if($RIGHT != "D")
{
	if(B2BSSotbit::getStatus() == 2)
	{
		?>
		<div class="adm-info-message-wrap adm-info-message-red">
			<div class="adm-info-message">
				<div class="adm-info-message-title"><?= Loc::getMessage("sotbit_ms_demo") ?></div>

				<div class="adm-info-message-icon"></div>
			</div>
		</div>
		<?
	}
	?>
	<div class="notes">
		<table cellspacing="0" cellpadding="0" border="0" class="notes">
			<tbody>
			<tr class="top">
				<td class="left">
					<div class="empty"></div>
				</td>
				<td>
					<div class="empty"></div>
				</td>
				<td class="right">
					<div class="empty"></div>
				</td>
			</tr>
			<tr>
				<td class="left">
					<div class="empty"></div>
				</td>
				<td class="content">
					<?= Loc::getMessage("sotbit_ms_parameters") ?>
				</td>
				<td class="right">
					<div class="empty"></div>
				</td>
			</tr>
			<tr class="bottom">
				<td class="left">
					<div class="empty"></div>
				</td>
				<td>
					<div class="empty"></div>
				</td>
				<td class="right">
					<div class="empty"></div>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
	<?
	$showRightsTab = false;
	$opt = new CModuleOptions($module_id, $arTabs, $arGroups, $arOptions, $showRightsTab);
	$opt->ShowHTML();
}
if($REQUEST_METHOD == "POST" && strlen($save) > 0 && check_bitrix_sessid())
{
	if(isset($_REQUEST["MAIN_PROPS"]) || isset($_REQUEST["DOP_PROPS"]))
	{
		if(!isset($_REQUEST["MAIN_PROPS"]) || !$_REQUEST["MAIN_PROPS"])
			$_REQUEST["MAIN_PROPS"] = [];
		if(!isset($_REQUEST["DOP_PROPS"]) || !$_REQUEST["DOP_PROPS"])
			$_REQUEST["DOP_PROPS"] = [];
		$_REQUEST["ALL_PROPS"] = array_merge($_REQUEST["MAIN_PROPS"], $_REQUEST["DOP_PROPS"]);
		if(isset($_REQUEST["ALL_PROPS"]) && !empty($_REQUEST["ALL_PROPS"]))
		{
			$allProps = serialize($_REQUEST["ALL_PROPS"]);
			COption::SetOptionString($module_id, "ALL_PROPS", $allProps);
		}
	}
	if((strlen($save) > 0) || (strlen($RestoreDefaults) > 0))
	{
		LocalRedirect($APPLICATION->GetCurPage() . "?lang=" . LANGUAGE_ID . "&mid=" . urlencode($mid) . "&tabControl_active_tab=" . urlencode($_REQUEST["tabControl_active_tab"]) . "&back_url_settings=" . urlencode($_REQUEST["back_url_settings"]));
	}
	else
	{
		LocalRedirect($_REQUEST["back_url_settings"]);
	}
}
$APPLICATION->SetTitle(Loc::getMessage($module_id . '_TITLE_SETTINGS'));
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");
?>