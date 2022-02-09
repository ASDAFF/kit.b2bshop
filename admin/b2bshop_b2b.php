<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Internals\PersonTypeTable;
use Bitrix\Main\GroupTable;
require_once ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
Loc::loadMessages( __FILE__ );
if( $APPLICATION->GetGroupRight( "main" ) < "R" )
{
	$APPLICATION->AuthForm( Loc::getMessage( "ACCESS_DENIED" ) );
}
$module_id = "kit.b2bshop";
require_once ($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $module_id . '/classes/CModuleOptions.php');
require_once ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/" . $module_id . "/include.php");
if( !\Bitrix\Main\Loader::includeModule( 'iblock' ) )
{
	return;
}


$orderProps = ['REFERENCE_ID' => [],'REFERENCE' => []];

$rs = \Bitrix\Sale\Internals\OrderPropsTable::getList();
while($prop = $rs->fetch())
{
	$orderProps['REFERENCE_ID'][] = $prop['ID'];
	$orderProps['REFERENCE'][] = '['.$prop['ID'].']'.'['.$prop['CODE'].'] '.$prop['NAME'];
}


$boolCatalog = \Bitrix\Main\Loader::includeModule( 'catalog' );
$categoriesList = array();
if( \Bitrix\Main\Loader::includeModule( 'kit.mailing' ) )
{
	$categoriesLi = CKitMailingHelp::GetCategoriesInfo();
	foreach( $categoriesLi as $v )
	{
		$categoriesList["REFERENCE_ID"][] = $v['ID'];
		$categoriesList["REFERENCE"][] = '[' . $v['ID'] . '] ' . $v['NAME'];
	}
}
if( $REQUEST_METHOD == "POST" && strlen( $RestoreDefaults ) > 0 && check_bitrix_sessid() )
{
	COption::RemoveOption( $module_id );
	$z = CGroup::GetList( $v1 = "id", $v2 = "asc", array(
			"ACTIVE" => "Y",
			"ADMIN" => "N"
	) );
	while ( $zr = $z->Fetch() )
	{
		$APPLICATION->DelGroupRight( $module_id, array(
				$zr["ID"]
		) );
	}
	if( (strlen( $Apply ) > 0) || (strlen( $RestoreDefaults ) > 0) )
	{
		LocalRedirect( $APPLICATION->GetCurPage() . "?lang=" . LANGUAGE_ID . "&mid=" . urlencode( $mid ) . "&tabControl_active_tab=" . urlencode( $_REQUEST["tabControl_active_tab"] ) . "&back_url_settings=" . urlencode( $_REQUEST["back_url_settings"] ) );
	}
	else
	{
		LocalRedirect( $_REQUEST["back_url_settings"] );
	}
}
$arTabs = array(
		array(
				'DIV' => 'edit1',
				'TAB' => Loc::getMessage( $module_id . '_edit1' ),
				'ICON' => '',
				'TITLE' => Loc::getMessage( $module_id . '_edit1' ),
				'SORT' => '10'
		),
		array(
				'DIV' => 'edit2',
				'TAB' => Loc::getMessage( $module_id . '_edit2' ),
				'ICON' => '',
				'TITLE' => Loc::getMessage( $module_id . '_edit2' ),
				'SORT' => '20'
		),
);
$arSKU = false;
$boolSKU = false;
$arIBlockType = CIBlockParameters::GetIBlockTypes();
if( isset( $_REQUEST["IBLOCK_TYPE"] ) && $_REQUEST["IBLOCK_TYPE"] )
{
	$arCurrentValues["IBLOCK_TYPE"] = $_REQUEST["IBLOCK_TYPE"];
}
else
{
	$arCurrentValues["IBLOCK_TYPE"] = COption::GetOptionString( $module_id, "IBLOCK_TYPE", "" );
}
if( isset( $_REQUEST["OPT_IBLOCK_ID"] ) && $_REQUEST["OPT_IBLOCK_ID"] )
{
	$arCurrentValues["OPT_IBLOCK_ID"] = $_REQUEST["OPT_IBLOCK_ID"];
}
else
{
	$arCurrentValues["OPT_IBLOCK_ID"] = COption::GetOptionString( $module_id, "OPT_IBLOCK_ID", "" );
}
$arIBlock = array();
if( $arCurrentValues["IBLOCK_TYPE"] )
{
	$rsIBlock = CIBlock::GetList( array(
			"sort" => "asc"
	), array(
			"TYPE" => $arCurrentValues["IBLOCK_TYPE"],
			"ACTIVE" => "Y"
	) );
	while ( $arr = $rsIBlock->Fetch() )
	{
		$arIBlockSel["REFERENCE_ID"][] = $arr["ID"];
		$arIBlockSel["REFERENCE"][] = "[" . $arr["ID"] . "] " . $arr["NAME"];
	}
}
if( $arCurrentValues["BRAND_IBLOCK_TYPE"] )
{
	$rsIBlock = CIBlock::GetList( array(
			"sort" => "asc"
	), array(
			"TYPE" => $arCurrentValues["BRAND_IBLOCK_TYPE"],
			"ACTIVE" => "Y"
	) );
	while ( $arr = $rsIBlock->Fetch() )
	{
		$arBrandIBlockSel["REFERENCE_ID"][] = $arr["ID"];
		$arBrandIBlockSel["REFERENCE"][] = "[" . $arr["ID"] . "] " . $arr["NAME"];
	}
}
if( $arCurrentValues["BANNER_IBLOCK_TYPE"] )
{
	$rsIBlock = CIBlock::GetList( array(
			"sort" => "asc"
	), array(
			"TYPE" => $arCurrentValues["BANNER_IBLOCK_TYPE"],
			"ACTIVE" => "Y"
	) );
	while ( $arr = $rsIBlock->Fetch() )
	{
		$arIBlockSelB["REFERENCE_ID"][] = $arr["ID"];
		$arIBlockSelB["REFERENCE"][] = "[" . $arr["ID"] . "] " . $arr["NAME"];
	}
}
if( $arCurrentValues["NEWS_IBLOCK_TYPE"] )
{
	$rsIBlock = CIBlock::GetList( array(
			"sort" => "asc"
	), array(
			"TYPE" => $arCurrentValues["NEWS_IBLOCK_TYPE"],
			"ACTIVE" => "Y"
	) );
	while ( $arr = $rsIBlock->Fetch() )
	{
		$arIBlockSelNews["REFERENCE_ID"][] = $arr["ID"];
		$arIBlockSelNews["REFERENCE"][] = "[" . $arr["ID"] . "] " . $arr["NAME"];
	}
}
if( isset( $arCurrentValues['OPT_IBLOCK_ID'] ) && 0 < intval( $arCurrentValues['OPT_IBLOCK_ID'] ) )
{
	$arAllPropList = array();
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
	if( $boolCatalog && (isset( $arCurrentValues['OPT_IBLOCK_ID'] ) && 0 < intval( $arCurrentValues['OPT_IBLOCK_ID'] )) )
	{
		$arSKU = CCatalogSKU::GetInfoByProductIBlock( $arCurrentValues['OPT_IBLOCK_ID'] );
		$boolSKU = !empty( $arSKU ) && is_array( $arSKU );
		if( $boolSKU )
		{
			COption::SetOptionString( $module_id, "OFFER_IBLOCK_ID", $arSKU["IBLOCK_ID"] );
		}
	}
	$rsProps = CIBlockProperty::GetList( array(
			'SORT' => 'ASC',
			'ID' => 'ASC'
	), array(
			'IBLOCK_ID' => $arCurrentValues['OPT_IBLOCK_ID'],
			'ACTIVE' => 'Y'
	) );
	while ( $arProp = $rsProps->Fetch() )
	{
		$strPropName = '[' . $arProp['ID'] . ']' . ('' != $arProp['CODE'] ? '[' . $arProp['CODE'] . ']' : '') . ' ' . $arProp['NAME'];
		if( '' == $arProp['CODE'] )
			$arProp['CODE'] = $arProp['ID'];
		$arAllPropList["REFERENCE_ID"][] = $arProp['CODE'];
		$arAllPropList["REFERENCE"][] = $strPropName;
		if( 'F' == $arProp['PROPERTY_TYPE'] )
		{
			$arFilePropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arFilePropList["REFERENCE"][] = $strPropName;
		}
		if( 'L' == $arProp['PROPERTY_TYPE'] )
		{
			$arListPropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arListPropList["REFERENCE"][] = $strPropName;
			$arAllProps["REFERENCE_ID"][] = $arProp['ID'];
			$arAllProps["REFERENCE"][] = $strPropName;
		}
		if( 'E' == $arProp['PROPERTY_TYPE'] )
		{
			$arElementPropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arElementPropList["REFERENCE"][] = $strPropName;
			$arAllProps["REFERENCE_ID"][] = $arProp['ID'];
			$arAllProps["REFERENCE"][] = $strPropName;
			$arDopProps[$arProp['CODE']] = $arProp;
		}
		if( 'S' == $arProp['PROPERTY_TYPE'] && 'directory' != $arProp['USER_TYPE'] )
		{
			$arStringPropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arStringPropList["REFERENCE"][] = $strPropName;
			$arAllProps["REFERENCE_ID"][] = $arProp['ID'];
			$arAllProps["REFERENCE"][] = $strPropName;
		}

		if( 'S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory( $arProp ) )
		{
			$arHighloadPropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arHighloadPropList["REFERENCE"][] = $strPropName;
			$arAllProps["REFERENCE_ID"][] = $arProp['ID'];
			$arAllProps["REFERENCE"][] = $strPropName;
		}
		if( 'N' == $arProp['PROPERTY_TYPE'] )
		{
			$arHighloadPropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arHighloadPropList["REFERENCE"][] = $strPropName;
			$arAllProps["REFERENCE_ID"][] = $arProp['ID'];
			$arAllProps["REFERENCE"][] = $strPropName;
		}
	}
	$arAllPropsColorLink = $arAllProps;
	if( $boolSKU )
	{
		$arAllOfferPropList = array();
		$arAllOfferPropList["REFERENCE_ID"][] = "";
		$arAllOfferPropList["REFERENCE"][] = "";
		$arFileOfferPropList["REFERENCE_ID"][] = "";
		$arFileOfferPropList["REFERENCE"][] = "";
		$arTreeOfferPropList["REFERENCE_ID"][] = "";
		$arTreeOfferPropList["REFERENCE"][] = "";

		$rsProps = CIBlockProperty::GetList( array(
				'SORT' => 'ASC',
				'ID' => 'ASC'
		), array(
				'IBLOCK_ID' => $arSKU['IBLOCK_ID'],
				'ACTIVE' => 'Y'
		) );
		while ( $arProp = $rsProps->Fetch() )
		{
			if( $arProp['ID'] == $arSKU['SKU_PROPERTY_ID'] )
			{
				continue;
			}





			$arProp['USER_TYPE'] = ( string ) $arProp['USER_TYPE'];
			$strPropName = '[' . $arProp['ID'] . ']' . ('' != $arProp['CODE'] ? '[' . $arProp['CODE'] . ']' : '') . ' ' . $arProp['NAME'];
			if( '' == $arProp['CODE'] )
			{
				$arProp['CODE'] = $arProp['ID'];
			}


			$arAllProps["REFERENCE_ID"][] = $arProp['ID'];
			$arAllProps["REFERENCE"][] = $strPropName;


			$arAllOfferPropList["REFERENCE_ID"][] = $arProp['CODE'];
			$arAllOfferPropList["REFERENCE"][] = $strPropName;
			if( 'F' == $arProp['PROPERTY_TYPE'] )
			{
				$arFileOfferPropList["REFERENCE_ID"][] = $arProp['CODE'];
				$arFileOfferPropList["REFERENCE"][] = $strPropName;
			}
			if( 'N' != $arProp['MULTIPLE'] )
			{
				continue;
			}
			if(
			('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory( $arProp )) )
			{
				$arTreeOfferPropList["REFERENCE_ID"][] = $arProp['CODE'];
				$arTreeOfferPropList["REFERENCE"][] = $strPropName;
			}
		}
	}
	$arPrice = array();
	$arSort = CIBlockParameters::GetElementSortFields( array(
			'SHOWS',
			'SORT',
			'TIMESTAMP_X',
			'NAME',
			'ID',
			'ACTIVE_FROM',
			'ACTIVE_TO'
	), array(
			'KEY_LOWERCASE' => 'Y'
	) );
	$arSort = array_merge( $arSort, CCatalogIBlockParameters::GetCatalogSortFields() );
	$rsPrice = CCatalogGroup::GetList( $v1 = "sort", $v2 = "asc" );
	while ( $arr = $rsPrice->Fetch() )
	{
		$arPrice["REFERENCE_ID"][] = $arr["NAME"];
		$arPrice["REFERENCE"][] = "[" . $arr["NAME"] . "] " . $arr["NAME_LANG"];
	}
}
if( !empty( $arIBlockType ) )
{
	$arIBlockTypeSel["REFERENCE_ID"][] = "";
	$arIBlockTypeSel["REFERENCE"][] = "";
	foreach( $arIBlockType as $code => $val )
	{
		$arIBlockTypeSel["REFERENCE_ID"][] = $code;
		$arIBlockTypeSel["REFERENCE"][] = $val;
	}
}
$arStyle["REFERENCE_ID"] = array(
		"default",
		"min"
);
$arStyle["REFERENCE"] = array(
		Loc::getMessage( $module_id . '_style_default' ),
		Loc::getMessage( $module_id . '_style_min' )
);

$arElementTemplate["REFERENCE_ID"] = array(
		".default",
		"big_photo",
		"without_properties",
		"analog_products_under",
		"other"
);
$arElementTemplate["REFERENCE"] = array(
		Loc::getMessage( $module_id . '_element_template_default' ),
		Loc::getMessage( $module_id . '_element_template_big_photo' ),
		Loc::getMessage( $module_id . '_element_template_without_properties' ),
		Loc::getMessage( $module_id . '_element_template_analog_products_under' ),
		Loc::getMessage( $module_id . '_element_template_other' )
);


$arElementTemplate["REFERENCE_ID"] = array(
		".default",
		"big_photo",
		"without_properties",
		"analog_products_under",
		"other"
);
$arElementTemplate["REFERENCE"] = array(
		Loc::getMessage( $module_id.'_element_template_default' ),
		Loc::getMessage( $module_id.'_element_template_big_photo' ),
		Loc::getMessage( $module_id.'_element_template_without_properties' ),
		Loc::getMessage( $module_id.'_element_template_analog_products_under' ),
		Loc::getMessage( $module_id.'_element_template_other' ),
);
$arOfferElementPropList["REFERENCE_ID"] = array(
		'NAME',
		'PREVIEW_TEXT',
		'DETAIL_TEXT',
		'TAGS'
);
$arOfferElementPropList["REFERENCE"] = array(
		Loc::getMessage( $module_id . '_OFFERS_ELEMENT_TITLE' ),
		Loc::getMessage( $module_id . '_OFFERS_ELEMENT_ANONS' ),
		Loc::getMessage( $module_id . '_OFFERS_ELEMENT_DESCRIPTION' ),
		Loc::getMessage( $module_id . '_OFFERS_ELEMENT_TAGS' )
);
$arOfferElementParamsList["REFERENCE_ID"] = array_diff( $arAllOfferPropList["REFERENCE_ID"], $arFileOfferPropList["REFERENCE_ID"] );
$arOfferElementParamsList["REFERENCE"] = array_diff( $arAllOfferPropList["REFERENCE"], $arFileOfferPropList["REFERENCE"] );

if( \Bitrix\Main\Loader::includeModule( 'sale' ) )
{
	$Deliveries = array();
	$rsDelivery = \Bitrix\Sale\Delivery\Services\Table::getList(
			array(
					'select' => array(
							'ID',
							'NAME'
					),
					'filter' => array(
							'ACTIVE' => 'Y',
							'PARENT_ID' => 0
					)
			)
	);
	while($delivery = $rsDelivery->fetch())
	{
		$Deliveries["REFERENCE_ID"][] = $delivery['ID'];
		$Deliveries["REFERENCE"][] = '['.$delivery['ID'].'] '.$delivery['NAME'];
	}
	unset($rsDelivery, $delivery);
	$Payments = array();
	$rsPayment = \Bitrix\Sale\Internals\PaySystemActionTable::getList(array(
			'select' => array('ID','NAME'),
			'filter' => array('ACTIVE' => 'Y')
	));
	while ( $payment = $rsPayment->Fetch() )
	{
		$Payments["REFERENCE_ID"][] = $payment['ID'];
		$Payments["REFERENCE"][] = '['.$payment['ID'].'] '.$payment['NAME'];
	}
	unset($rsPayment, $payment);
}
else
{
	$Deliveries= array(
			"REFERENCE_ID" => 0,
			"REFERENCE" => ""
	);
	$Payments= array(
			"REFERENCE_ID" => 0,
			"REFERENCE" => ""
	);
}

$arCountInRow["REFERENCE_ID"] = array(
		4,
		3,
		2,
		6
);
$arCountInRow["REFERENCE"] = array(
		4,
		3,
		2,
		6
);

$arAllPropsColorLinkSection["REFERENCE_ID"] = array(
		1,
		2
);
$arAllPropsColorLinkSection["REFERENCE"] = array(
		Loc::getMessage( $module_id . '_COLOR_IN_SECTION_LINK_1' ),
		Loc::getMessage( $module_id . '_COLOR_IN_SECTION_LINK_2' )
);
if( isset( $arCurrentValues["COLOR_IN_SECTION_LINK"] ) && $arCurrentValues["COLOR_IN_SECTION_LINK"] == 2 )
{
	$arAllPropsColorLinkSectionMain = $arAllPropsColorLink;
}
else
{
	$arAllPropsColorLinkSectionMain = array();
}
$arFlags["REFERENCE_ID"] = array_merge( $arListPropList["REFERENCE_ID"], $arStringPropList["REFERENCE_ID"] );
$arFlags["REFERENCE"] = array_merge( $arListPropList["REFERENCE"], $arStringPropList["REFERENCE"] );
$arResizeImages["REFERENCE_ID"] = array(
		BX_RESIZE_IMAGE_PROPORTIONAL,
		BX_RESIZE_IMAGE_EXACT,
		BX_RESIZE_IMAGE_PROPORTIONAL_ALT
);
$arResizeImages["REFERENCE"] = array(
		Loc::getMessage( $module_id . '_BX_RESIZE_IMAGE_PROPORTIONAL' ),
		Loc::getMessage( $module_id . '_BX_RESIZE_IMAGE_EXACT' ),
		Loc::getMessage( $module_id . '_BX_RESIZE_IMAGE_PROPORTIONAL_ALT' )
);

$MenuAll["REFERENCE_ID"][] = -1;
$MenuAll["REFERENCE_ID"][] = 0;
$MenuAll["REFERENCE"][] = Loc::getMessage( $module_id . '_MENU_ALL_HIDE' );
$MenuAll["REFERENCE"][] = Loc::getMessage( $module_id . '_MENU_ALL_SHOW' );

$AllSect = array();
$arFilter = array(
		'IBLOCK_ID' => $arCurrentValues['OPT_IBLOCK_ID'],
		'GLOBAL_ACTIVE' => 'Y',
		'DEPTH_LEVEL' => 1
);
$rsSect = CIBlockSection::GetList( array(
		'NAME' => 'asc'
), $arFilter );
$i = 1;
while ( $arSect = $rsSect->GetNext() )
{
	$MenuAll["REFERENCE_ID"][] = $i;
	$MenuAll["REFERENCE"][] = Loc::getMessage( $module_id . '_MENU_ALL_' ) . $i;
	++$i;
}

$AddMenuFieldsValue = unserialize( COption::GetOptionString( $module_id, 'ADD_MENU_LINKS', 'a:0:{}' ) );

$AllSect = array();
$arFilter = array(
		'IBLOCK_ID' => $arCurrentValues['OPT_IBLOCK_ID'],
		'GLOBAL_ACTIVE' => 'Y'
);
$rsSect = CIBlockSection::GetList( array(
		'NAME' => 'asc'
), $arFilter );
while ( $arSect = $rsSect->GetNext() )
{
	$AllSect[$arSect['SECTION_PAGE_URL']] = '[' . $arSect['ID'] . '] ' . $arSect['NAME'];
}

if( isset( $_REQUEST['ADD_MENU_LINKS_PARENT_LINK'] ) && $_REQUEST['ADD_MENU_LINKS_TITLE'] && $_REQUEST['ADD_MENU_LINKS_URL'] && $_REQUEST['ADD_MENU_LINKS_SORT'] )
{
	foreach( $_REQUEST['ADD_MENU_LINKS_PARENT_LINK'] as $i => $Link )
	{
		$AddMenuFieldsValue[$i]['ADD_MENU_LINKS_PARENT_LINK'] = $Link;
		$AddMenuFieldsValue[$i]['ADD_MENU_LINKS_TITLE'] = $_REQUEST['ADD_MENU_LINKS_TITLE'][$i];
		$AddMenuFieldsValue[$i]['ADD_MENU_LINKS_URL'] = $_REQUEST['ADD_MENU_LINKS_URL'][$i];
		$AddMenuFieldsValue[$i]['ADD_MENU_LINKS_SORT'] = $_REQUEST['ADD_MENU_LINKS_SORT'][$i];
	}
}
else
{
	$AddMenuFieldsValue = unserialize( COption::GetOptionString( $module_id, 'ADD_MENU_LINKS', 'a:0:{}' ) );
}

$AddMenuFields = '<div id="AddMenuLinks">';
if( count( $AddMenuFieldsValue ) > 0 && is_array( $AddMenuFieldsValue ) )
{
	foreach( $AddMenuFieldsValue as $i => $vals )
	{
		$AddMenuFields .= '<div style="border:1px solid #e0e8ea;padding:5px;margin-bottom:10px;"><table><tr><td>' . Loc::getMessage( $module_id . '_ADD_MENU_LINKS_PARENT' ) . '</td><td><select name="ADD_MENU_LINKS_PARENT_LINK[]">';
		foreach( $AllSect as $key => $Sect )
		{
			$AddMenuFields .= '<option value="' . $key . '" ';
			if( $key == $vals['ADD_MENU_LINKS_PARENT_LINK'] )
				$AddMenuFields .= 'selected';
			$AddMenuFields .= '>';
			$AddMenuFields .= $Sect;
			$AddMenuFields .= '</option>';
		}

		$AddMenuFields .= '</select></td></tr>';
		$AddMenuFields .= '<tr><td>' . Loc::getMessage( $module_id . '_ADD_MENU_LINKS_TITLE' ) . '</td><td><input type="text" name="ADD_MENU_LINKS_TITLE[]" value="' . $vals['ADD_MENU_LINKS_TITLE'] . '"></td></tr>';
		$AddMenuFields .= '<tr><td>' . Loc::getMessage( $module_id . '_ADD_MENU_LINKS_URL' ) . '</td><td><input type="text" name="ADD_MENU_LINKS_URL[]" value="' . $vals['ADD_MENU_LINKS_URL'] . '"></td></tr>';
		$AddMenuFields .= '<tr><td>' . Loc::getMessage( $module_id . '_ADD_MENU_LINKS_SORT' ) . '</td><td><input type="text" name="ADD_MENU_LINKS_SORT[]" value="' . $vals['ADD_MENU_LINKS_SORT'] . '"></td></tr>';
		$AddMenuFields .= '</table></div>';
	}
}
else
{
	$AddMenuFields .= '<div style="border:1px solid #e0e8ea;padding:5px;margin-bottom:10px;"><table><tr><td>' . Loc::getMessage( $module_id . '_ADD_MENU_LINKS_PARENT' ) . '</td><td><select name="ADD_MENU_LINKS_PARENT_LINK[]">';
	foreach( $AllSect as $key => $Sect )
	{
		$AddMenuFields .= '<option value="' . $key . '" ';
		$AddMenuFields .= '>';
		$AddMenuFields .= $Sect;
		$AddMenuFields .= '</option>';
	}

	$AddMenuFields .= '</select></td></tr>';
	$AddMenuFields .= '<tr><td>' . Loc::getMessage( $module_id . '_ADD_MENU_LINKS_TITLE' ) . '</td><td><input type="text" name="ADD_MENU_LINKS_TITLE[]" value=""></td></tr>';
	$AddMenuFields .= '<tr><td>' . Loc::getMessage( $module_id . '_ADD_MENU_LINKS_URL' ) . '</td><td><input type="text" name="ADD_MENU_LINKS_URL[]" value=""></td></tr>';
	$AddMenuFields .= '<tr><td>' . Loc::getMessage( $module_id . '_ADD_MENU_LINKS_SORT' ) . '</td><td><input type="text" name="ADD_MENU_LINKS_SORT[]" value=""></td></tr>';
	$AddMenuFields .= '</table></div>';
}

$AddMenuFields .= '</div>
		 <input type="button" value="+" onclick="new_row()">
			<input type="button" value="-" onclick="delete_row()">
		 <script type="text/javascript">
		 function new_row(){
		 var div = document.createElement("div");
		 div.innerHTML = \'<div style="border:1px solid #e0e8ea;padding:5px;margin-bottom:10px;"><table><tr><td>' . Loc::getMessage( $module_id . '_ADD_MENU_LINKS_PARENT' ) . '</td><td><select name="ADD_MENU_LINKS_PARENT_LINK[]">';
foreach( $AllSect as $key => $Sect )
{
	$AddMenuFields .= '<option value="' . $key . '" ';
	$AddMenuFields .= '>';
	$AddMenuFields .= $Sect;
	$AddMenuFields .= '</option>';
}

$AddMenuFields .= '</select></td></tr>';
$AddMenuFields .= '<tr><td>' . Loc::getMessage( $module_id . '_ADD_MENU_LINKS_TITLE' ) . '</td><td><input type="text" name="ADD_MENU_LINKS_TITLE[]" value=""></td></tr>';
$AddMenuFields .= '<tr><td>' . Loc::getMessage( $module_id . '_ADD_MENU_LINKS_URL' ) . '</td><td><input type="text" name="ADD_MENU_LINKS_URL[]" value=""></td></tr>';
$AddMenuFields .= '<tr><td>' . Loc::getMessage( $module_id . '_ADD_MENU_LINKS_SORT' ) . '</td><td><input type="text" name="ADD_MENU_LINKS_SORT[]" value=""></td></tr>';
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

$personalTypes = array();
$rs = PersonTypeTable::getList(
		array(
				'select' => array(
						'ID',
						'NAME'
				),
				'filter' => array('ACTIVE' => 'Y')
		));
while($personalType = $rs->fetch())
{
	$personalTypes['REFERENCE_ID'][] = $personalType['ID'];
	$personalTypes['REFERENCE'][] = '['.$personalType['ID'].'] '.$personalType['NAME'];
}

$userFields= array(
		'REFERENCE_ID' => array(
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
		),
		'REFERENCE' => array(
				'[EMAIL] '.Loc::getMessage( $module_id . '_USER_FIELD_EMAIL'),
				'[TITLE] '.Loc::getMessage( $module_id . '_USER_FIELD_TITLE'),
				'[NAME] '.Loc::getMessage( $module_id . '_USER_FIELD_NAME'),
				'[SECOND_NAME] '.Loc::getMessage( $module_id . '_USER_FIELD_SECOND_NAME'),
				'[LAST_NAME] '.Loc::getMessage( $module_id . '_USER_FIELD_LAST_NAME'),
				'[PERSONAL_PROFESSION] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_PROFESSION'),
				'[PERSONAL_WWW] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_WWW'),
				'[PERSONAL_ICQ] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_ICQ'),
				'[PERSONAL_GENDER] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_GENDER'),
				'[PERSONAL_BIRTHDAY] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_BIRTHDAY'),
				'[PERSONAL_PHOTO] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_PHOTO'),
				'[PERSONAL_PHONE] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_PHONE'),
				'[PERSONAL_FAX] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_FAX'),
				'[PERSONAL_MOBILE] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_MOBILE'),
				'[PERSONAL_PAGER] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_PAGER'),
				'[PERSONAL_STREET] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_STREET'),
				'[PERSONAL_MAILBOX] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_MAILBOX'),
				'[PERSONAL_CITY] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_CITY'),
				'[PERSONAL_STATE] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_STATE'),
				'[PERSONAL_ZIP] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_ZIP'),
				'[PERSONAL_COUNTRY] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_COUNTRY'),
				'[PERSONAL_NOTES] '.Loc::getMessage( $module_id . '_USER_FIELD_PERSONAL_NOTES'),
				'[WORK_COMPANY] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_COMPANY'),
				'[WORK_DEPARTMENT] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_DEPARTMENT'),
				'[WORK_POSITION] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_POSITION'),
				'[WORK_WWW] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_WWW'),
				'[WORK_PHONE] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_PHONE'),
				'[WORK_FAX] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_FAX'),
				'[WORK_PAGER] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_PAGER'),
				'[WORK_STREET] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_STREET'),
				'[WORK_MAILBOX] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_MAILBOX'),
				'[WORK_CITY] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_CITY'),
				'[WORK_STATE] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_STATE'),
				'[WORK_ZIP] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_ZIP'),
				'[WORK_COUNTRY] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_COUNTRY'),
				'[WORK_PROFILE] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_PROFILE'),
				'[WORK_LOGO] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_LOGO'),
				'[WORK_NOTES] '.Loc::getMessage( $module_id . '_USER_FIELD_WORK_NOTES')
		)
);

$orderFields = array();
$orderFieldsIds = array();
$rs = \Bitrix\Sale\Internals\OrderPropsTable::getList( array(
		'filter' => array(
				'ACTIVE' => 'Y',
		),
		'select' => array('ID','CODE','NAME')
) );
while($property = $rs->fetch())
{
	$orderFields['REFERENCE_ID'][$property['CODE']] = $property['CODE'];
	$orderFields['REFERENCE'][$property['CODE']] = "[".$property['CODE']."] " .$property['NAME'];

	$orderFieldsIds['REFERENCE_ID'][$property['ID']] = $property['ID'];
	$orderFieldsIds['REFERENCE'][$property['ID']] = "[".$property['ID']."][".$property['CODE']."] " .$property['NAME'];
}




$optFilterFields = array();
$optArticul = array();
$optArticulOffer = array();

if($arCurrentValues['OPT_IBLOCK_ID'] > 0)
{
	$rsProps = CIBlockProperty::GetList( array(
			'SORT' => 'ASC',
			'ID' => 'ASC'
	), array(
			'IBLOCK_ID' => $arCurrentValues['OPT_IBLOCK_ID'],
			'ACTIVE' => 'Y',
			'PROPERTY_TYPE' => 'S'
	) );
	while($opt1 = $rsProps->fetch())
	{
		$optArticul['REFERENCE_ID'][] = $opt1['ID'];
		$optArticul['REFERENCE'][] = '['.$opt1['ID'].']['.$opt1['CODE'].'] '.$opt1['NAME'];
	}

	$props = CIBlockSectionPropertyLink::GetArray($arCurrentValues['OPT_IBLOCK_ID'], $SECTION_ID = 0, $bNewSection = false);
	foreach($props as $prop)
	{
		if($prop['SMART_FILTER'] == 'Y')
		{
			$arPropx = CIBlockProperty::GetByID($prop['PROPERTY_ID'])->fetch();
			$optFilterFields['REFERENCE_ID'][] = $arPropx['CODE'];
			$optFilterFields['REFERENCE'][] = '['.$arPropx['CODE'].'] '.$arPropx['NAME'];
		}
	}
	$catalog = CCatalogSku::GetInfoByIBlock($arCurrentValues['OPT_IBLOCK_ID']);

	if($catalog['IBLOCK_ID'] && $catalog['PRODUCT_IBLOCK_ID'])
	{
		$rsProps = CIBlockProperty::GetList( array(
				'SORT' => 'ASC',
				'ID' => 'ASC'
		), array(
				'IBLOCK_ID' => $catalog['IBLOCK_ID'],
				'ACTIVE' => 'Y',
				'PROPERTY_TYPE' => 'S'
		) );
		while($opt2 = $rsProps->fetch())
		{
			$optArticulOffer['REFERENCE_ID'][] = $opt2['ID'];
			$optArticulOffer['REFERENCE'][] = '['.$opt2['ID'].']['.$opt2['CODE'].'] '.$opt2['NAME'];
		}

		$props = CIBlockSectionPropertyLink::GetArray($catalog['IBLOCK_ID'], $SECTION_ID = 0, $bNewSection = false);
		foreach($props as $prop)
		{
			if($prop['SMART_FILTER'] == 'Y')
			{
				$arPropx = CIBlockProperty::GetByID($prop['PROPERTY_ID'])->fetch();
				$optFilterFields['REFERENCE_ID'][] = $arPropx['CODE'];
				$optFilterFields['REFERENCE'][] = '['.$arPropx['CODE'].'] '.$arPropx['NAME'];
			}
		}
	}
}


$groups = array();
$rs = GroupTable::getList();
while($group = $rs->fetch())
{
	$groups['REFERENCE_ID'][] = $group['ID'];
	$groups['REFERENCE'][] = '['.$group['ID'].'] '.$group['NAME'];
}



$arGroups = array(
		'OPTION_5' => array(
				'TITLE' => Loc::getMessage( $module_id . '_OPTION_5' ),
				'TAB' => 1
		),
		'OPTION_105' => array(
				'TITLE' => Loc::getMessage( $module_id . '_OPTION_105' ),
				'TAB' => 2
		),
);
$arOptions = array(
		'OPT_IBLOCK_TYPE' => array(
				'GROUP' => 'OPTION_105',
				'TITLE' => GetMessage( $module_id.'_OPT_IBLOCK_TYPE' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'Y',
				'SORT' => '10',
				'VALUES' => $arIBlockTypeSel
		),
		'OPT_IBLOCK_ID' => array(
				'GROUP' => 'OPTION_105',
				'TITLE' => GetMessage( $module_id.'_OPT_IBLOCK_ID' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'Y',
				'SORT' => '20',
				'VALUES' => $arIBlockSel
		),
		'OPT_BLANK_GROUPS' => array(
				'GROUP' => 'OPTION_5',
				'TITLE' => GetMessage( $module_id.'_OPT_BLANK_GROUPS' ),
				'TYPE' => 'MSELECT',
				'SORT' => '22',
				'VALUES' => $groups
		),
		'BUYER_PERSONAL_TYPE' => array(
				'GROUP' => 'OPTION_5',
				'TITLE' => Loc::getMessage( $module_id . '_BUYER_PERSONAL_TYPE' ),
				'TYPE' => 'MSELECT',
				'REFRESH' => 'N',
				'SORT' => '30',
				'VALUES' => $personalTypes
		),
		'ORDER_PROP_INN' => array(
			'GROUP' => 'OPTION_5',
			'TITLE' => Loc::getMessage( $module_id . '_ORDER_PROP_INN' ),
			'TYPE' => 'MSELECT',
			'REFRESH' => 'N',
			'SORT' => '400',
			'VALUES' => $orderProps
		),
		'ORDER_PROP_ORG_NAME' => array(
			'GROUP' => 'OPTION_5',
			'TITLE' => Loc::getMessage( $module_id . '_ORDER_PROP_ORG_NAME' ),
			'TYPE' => 'MSELECT',
			'REFRESH' => 'N',
			'SORT' => '500',
			'VALUES' => $orderProps
		),
		'CLOSE_FIZ' => array(
			'GROUP' => 'OPTION_5',
			'TITLE' => Loc::getMessage( $module_id . '_CLOSE_FIZ' ),
			'TYPE' => 'CHECKBOX',
			'REFRESH' => 'N',
			'SORT' => '1300',
		),
		'OPT_FILTER_FIELDS' => array(
				'GROUP' => 'OPTION_105',
				'TITLE' => Loc::getMessage( $module_id . '_OPT_FILTER_FIELDS' ),
				'TYPE' => 'MSELECT',
				'REFRESH' => 'N',
				'SORT' => '60',
				'SIZE' => 10,
				'VALUES' => $optFilterFields
		),
		'OPT_PROPS' => array(
				'GROUP' => 'OPTION_105',
				'TITLE' => GetMessage( $module_id.'_OPT_PROPS' ),
				'TYPE' => 'MSELECT',
				'REFRESH' => 'N',
				'SORT' => '70',
				'SIZE' => 10,
				'VALUES' => $arAllProps
		),
		'OPT_UNIQUE_PROP' => array(
				'GROUP' => 'OPTION_105',
				'TITLE' => GetMessage( $module_id.'_OPT_UNIQUE_PROP' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'N',
				'SORT' => '75',
				'SIZE' => 10,
				'VALUES' => array('REFERENCE_ID' => array('ID','CODE','XML_ID'),'REFERENCE' => array('ID',GetMessage( $module_id.'_OPT_UNIQUE_PROP_CODE' ),GetMessage( $module_id.'_OPT_UNIQUE_PROP_XML_ID' )))
		),
		'OPT_ARTICUL_PROP' => array(
				'GROUP' => 'OPTION_105',
				'TITLE' => Loc::getMessage( $module_id . '_OPT_ARTICUL_PROP' ),
				'TYPE' => 'SELECT',
				'REFRESH' => 'N',
				'SORT' => '80',
				'SIZE' => 10,
				'VALUES' => $optArticul
		),
		'OPT_PERSONAL_ORDER_ACTIONS' => array(
				'GROUP' => 'OPTION_5',
				'TITLE' => Loc::getMessage( $module_id . '_OPT_PERSONAL_ORDER_ACTIONS' ),
				'TYPE' => 'MSELECT',
				'REFRESH' => 'N',
				'SORT' => '100',
				'SIZE' => 3,
				'VALUES' => array(
						'REFERENCE_ID' => array(
								'repeat',
								'cancel'
						),
						'REFERENCE' => array(
								Loc::getMessage( $module_id . '_OPT_PERSONAL_ORDER_ACTIONS_REPEAT' ),
								Loc::getMessage( $module_id . '_OPT_PERSONAL_ORDER_ACTIONS_CANCEL' ),
						))
		),
);

if($optArticulOffer)
{
	$arOptions['OPT_ARTICUL_PROP_OFFER'] = array(
			'GROUP' => 'OPTION_105',
			'TITLE' => Loc::getMessage( $module_id . '_OPT_ARTICUL_PROP_OFFER' ),
			'TYPE' => 'SELECT',
			'REFRESH' => 'N',
			'SORT' => '90',
			'SIZE' => 10,
			'VALUES' => $optArticulOffer
	);
}





$RIGHT = $APPLICATION->GetGroupRight( $module_id );
if( $RIGHT != "D" )
{
	if( B2BSKit::getStatus() == 2 )
	{
		?>
		<div class="adm-info-message-wrap adm-info-message-red">
			<div class="adm-info-message">
				<div class="adm-info-message-title"><?=Loc::getMessage("kit_ms_demo")?></div>

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
					<td class="left"><div class="empty"></div></td>
					<td><div class="empty"></div></td>
					<td class="right"><div class="empty"></div></td>
				</tr>
				<tr>
					<td class="left"><div class="empty"></div></td>
					<td class="content">
	                        <?=Loc::getMessage("kit_ms_parameters")?>
	                    </td>
					<td class="right"><div class="empty"></div></td>
				</tr>
				<tr class="bottom">
					<td class="left"><div class="empty"></div></td>
					<td><div class="empty"></div></td>
					<td class="right"><div class="empty"></div></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?
	$showRightsTab = false;
	$opt = new CModuleOptions( $module_id, $arTabs, $arGroups, $arOptions, $showRightsTab );
	$opt->ShowHTML();
}
if( $REQUEST_METHOD == "POST" && strlen( $save ) > 0 && check_bitrix_sessid() )
{
	if( isset( $_REQUEST["MAIN_PROPS"] ) || isset( $_REQUEST["DOP_PROPS"] ) )
	{
		if( !isset( $_REQUEST["MAIN_PROPS"] ) || !$_REQUEST["MAIN_PROPS"] )
			$_REQUEST["MAIN_PROPS"] = array();
		if( !isset( $_REQUEST["DOP_PROPS"] ) || !$_REQUEST["DOP_PROPS"] )
			$_REQUEST["DOP_PROPS"] = array();
		$_REQUEST["ALL_PROPS"] = array_merge( $_REQUEST["MAIN_PROPS"], $_REQUEST["DOP_PROPS"] );
		if( isset( $_REQUEST["ALL_PROPS"] ) && !empty( $_REQUEST["ALL_PROPS"] ) )
		{
			$allProps = serialize( $_REQUEST["ALL_PROPS"] );
			COption::SetOptionString( $module_id, "ALL_PROPS", $allProps );
		}
	}
	if( (strlen( $save ) > 0) || (strlen( $RestoreDefaults ) > 0) )
	{
		LocalRedirect( $APPLICATION->GetCurPage() . "?lang=" . LANGUAGE_ID . "&mid=" . urlencode( $mid ) . "&tabControl_active_tab=" . urlencode( $_REQUEST["tabControl_active_tab"] ) . "&back_url_settings=" . urlencode( $_REQUEST["back_url_settings"] ) );
	}
	else
	{
		LocalRedirect( $_REQUEST["back_url_settings"] );
	}
}
$APPLICATION->SetTitle( Loc::getMessage( $module_id . '_TITLE_SETTINGS' ) );
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>
