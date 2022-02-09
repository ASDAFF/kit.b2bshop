<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Config\Option;
$this->setFrameMode(true);
global $arrBrandFilter;
global $kitSeoMetaH1;

$arrBrandFilter["PROPERTY_".COption::GetOptionString("kit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", "PROIZVODITEL_ATTR_E")] = $arResult["ID"];
?>
<div class="col-sm-6 sm-padding-left-no left-wrap">
	<div class="left-block">
<?

	$APPLICATION->IncludeComponent(
	"kit:catalog.smart.filter.facet",
	"brand",
	array(
		"IBLOCK_TYPE" => COption::GetOptionString("kit.b2bshop", "IBLOCK_TYPE", ""),
		"IBLOCK_ID" => COption::GetOptionString("kit.b2bshop", "IBLOCK_ID", ""),
		"SECTION_ID" => "",
		"FILTER_NAME" => "arrBrandFilter",
		"PRICE_CODE" => ($_SESSION["KIT_REGIONS"]["PRICE_CODE"] && COption::GetOptionString("kit.b2bshop","USE_MULTIREGIONS","Y") == 'Y')
			?$_SESSION["KIT_REGIONS"]["PRICE_CODE"]:unserialize(COption::GetOptionString("kit.b2bshop","PRICE_CODE","")),
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "0",
		"CACHE_GROUPS" => "N",
		"SAVE_IN_SESSION" => "N",
		"XML_EXPORT" => "Y",
		"SECTION_TITLE" => "NAME",
		"SECTION_DESCRIPTION" => "DESCRIPTION",
		"HIDE_NOT_AVAILABLE" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
		"AJAX_OPTION_HISTORY" => "Y",
		"OFFER_TREE_PROPS" => unserialize(COption::GetOptionString("kit.b2bshop", "OFFER_TREE_PROPS", "")),
		"OFFER_COLOR_PROP" => COption::GetOptionString("kit.b2bshop", "OFFER_COLOR_PROP", ""),
		"SEF_MODE_FILTER" => "Y",
		"SECTIONS" => "Y",
		"SECTIONS_DEPTH_LEVEL" => "2",
		"FILTER_ITEM_COUNT" => COption::GetOptionString("kit.b2bshop", "FILTER_ITEM_COUNT", ""),
		"COLOR_IN_PRODUCT"=>$arParams["COLOR_IN_PRODUCT"],
		"COLOR_IN_PRODUCT_CODE" => $arParams["COLOR_IN_PRODUCT_CODE"],
		"SEF_MODE" => \Bitrix\Main\Config\Option::get("kit.b2bshop", "CATALOG_FILTER","N"),
		"SEF_RULE" => $arResult["DETAIL_PAGE_URL"].'/filter/#SMART_FILTER_PATH#/apply/',
		"INSTANT_RELOAD" => "N"
	),
	false,
	array(
		"HIDE_ICONS" => "N"
	)
);
	$APPLICATION->IncludeComponent(
		"kit:seo.meta",
		".default",
		Array(
			"FILTER_NAME" => "arrBrandFilter",
			"SECTION_ID" => $arCurSection['ID'],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
		)
	);
	?>
	</div>
</div>
<div class="col-sm-18">
	<div class="row">
		<div class="col-sm-24 sm-padding-right-no">
		<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "ms_breadcrumb_section", array(
			"START_FROM" => "0",
			"PATH" => "",
			"SITE_ID" => SITE_ID,
		),
		false,
		Array('HIDE_ICONS' => 'N')
		);?>
		<?
	$APPLICATION->IncludeComponent(
		"coffeediz:breadcrumb",
		"coffeediz.schema.org",
		Array(
			"COMPONENT_TEMPLATE" => "coffeediz.schema.org",
			"PATH" => "",
			"SHOW" => "Y",
			"SITE_ID" => SITE_ID,
			"START_FROM" => "0",
			)
	);
	?>
	</div>

<div class="col-sm-24 sm-padding-right-no xs-padding-no">
	<div class="banner_descpript">
		<div class="inner_descpript">
			<div class="row">
				<div class="col-sm-5 sm-padding-right-no">
					<?if($arResult["DETAIL_PICTURE"]):?>
					<div class="wrap_img">
						<img width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" title="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]?>" alt="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]?>" class="img-responsive">
					</div>
					<?elseif($arResult["PREVIEW_PICTURE"]):?>
					<div class="wrap_img">
						<img width="<?=$arResult["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arResult["PREVIEW_PICTURE"]["HEIGHT"]?>" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" title="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]?>" alt="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"]?>" class="img-responsive">
					</div>
					<?endif;?>
				</div>
				<?if($arResult["PREVIEW_TEXT"] )?>
				<div class="col-sm-19 sm-padding-right-no">
					<div class="wrap_text"><?=$arResult["PREVIEW_TEXT"]?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?if(CModule::IncludeModule('kit.mailing')):?>
<div class="col-sm-24 hidden-xs">
		<?$APPLICATION->IncludeComponent(
			"kit:kit.mailing.email.get",
			"ms_field_brand",
			Array(
				"TYPE" => "PROPERTY",
				"PARAM_2:PROPERTY" => COption::GetOptionString("kit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", "PROIZVODITEL_ATTR_E"),
				"PARAM_3:PROPERTY" => $arrBrandFilter["PROPERTY_".COption::GetOptionString("kit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", "PROIZVODITEL_ATTR_E")],
				"INFO_TEXT" => htmlspecialcharsBack($arParams['~MAILING_INFO_TEXT']),
				"EMAIL_SEND_END" => htmlspecialcharsBack($arParams['~MAILING_EMAIL_SEND_END']),
				"COLOR_BUTTON" => "6e7278",
				"DISPLAY_IF_ADMIN" => "Y",
				"DISPLAY_NO_AUTH" => "Y",
				"CATEGORIES_ID" => $arParams['MAILING_CATEGORIES_ID'],
			),
		false
		);
		?>
</div>
<?endif;?>
<?
$intSectionID = 0;
?><?

if(isset($_POST["count"])) $_SESSION["MS_COUNT"] = $_POST["count"];
if(isset($_POST["sort"])) $_SESSION["MS_SORT"] = $_POST["sort"];

$arAvailableSortKit = array(
	"name_0" => Array("name", "desc"),
	"name_1" => Array("name", "asc"),
	"price_0" => Array('PROPERTY_MINIMUM_PRICE', "desc"),
	"price_1" => Array('PROPERTY_MINIMUM_PRICE', "asc"),
	"date_0" => Array('DATE_CREATE', "desc"),
	"date_1" => Array('DATE_CREATE', "asc"),

);
if(isset($_SESSION["MS_SORT"]))
{
	$arSort = $arAvailableSortKit[$_SESSION["MS_SORT"]];
	$sort_field = $arSort[0];
	$sort_order = $arSort[1];
}
?>
<div class="col-sm-24 sm-padding-right-no">
	<div class="inner_title_brand">
		<h1 class="text"><?=(isset($kitSeoMetaH1) && !empty($kitSeoMetaH1))?$kitSeoMetaH1:$arResult["NAME"]?></h1>
	</div>
</div>
<?

global $kitFilterResult;
$arResult['FILTER_CHECKED_FIRST_COLOR']=array();
foreach($kitFilterResult['ITEMS'] as $key=>$item)
{
	if($item['CODE']==COption::GetOptionString("kit.b2bshop", "OFFER_COLOR_PROP", ""))
	{
		foreach($item['VALUES'] as $key_value=>$value)
		{
			if(isset($value['CHECKED']) && $value['CHECKED']==1)
				$arResult['FILTER_CHECKED_FIRST_COLOR'][]=$value['DEFAULT']['UF_XML_ID'];
		}
	}
}

global $arrBrandFilter;
if(
		$arParams['COLOR_IN_PRODUCT'] == 'Y' &&
		$arParams['COLOR_IN_SECTION_LINK'] == 2 &&
		isset($arParams['COLOR_IN_SECTION_LINK_MAIN'] )
)
{
	if( empty( $arrBrandFilter['OFFERS'] ) )
	{
		$arFilter = array(
				'IBLOCK_ID' => COption::GetOptionString("kit.b2bshop", "IBLOCK_ID", ""),
				'ACTIVE' => 'Y',
				'CODE' => $arParams['COLOR_IN_SECTION_LINK_MAIN']
		);

		$Property = CIBlockProperty::GetList( array(), $arFilter )->Fetch();

		if( isset( $Property ) )
		{
			if( $Property['PROPERTY_TYPE'] == 'L' ) // list
			{
				$arrBrandFilter['=PROPERTY_' . $arParams['COLOR_IN_SECTION_LINK_MAIN'] . '_VALUE'] = array(

						'true',
						'TRUE',
						'Y',
						'y',
						\Bitrix\Main\Localization\Loc::getMessage( 'COLOR_IN_SECTION_YES_1' ),
						\Bitrix\Main\Localization\Loc::getMessage( 'COLOR_IN_SECTION_YES_2' ),
						\Bitrix\Main\Localization\Loc::getMessage( 'COLOR_IN_SECTION_YES_3' )
				);
			}
			else
			{
				$arrBrandFilter['=PROPERTY_' . $arParams['COLOR_IN_SECTION_LINK_MAIN']] = array(
						'true',
						'TRUE',
						'Y',
						'y',
						\Bitrix\Main\Localization\Loc::getMessage( 'COLOR_IN_SECTION_YES_1' ),
						\Bitrix\Main\Localization\Loc::getMessage( 'COLOR_IN_SECTION_YES_2' ),
						\Bitrix\Main\Localization\Loc::getMessage( 'COLOR_IN_SECTION_YES_3' )
				);
			}
		}
	}
}




if(Bitrix\Main\Loader::includeModule("kit.price"))
{
	KitPrice::NeedChangePrice();
}






$sectionTemplate = new \Kit\B2BShop\Client\Template\Section();
$template = $sectionTemplate->identifySectionView(0);

$intSectionID = $APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	$template,
	array(
		"IBLOCK_TYPE" => COption::GetOptionString("kit.b2bshop", "IBLOCK_TYPE", ""),
		"IBLOCK_ID" => COption::GetOptionString("kit.b2bshop", "IBLOCK_ID", ""),
		"ELEMENT_SORT_FIELD" => $sort_field?$sort_field:"sort",
		"ELEMENT_SORT_ORDER" => $sort_order?$sort_order:"asc",
		"ELEMENT_SORT_FIELD2" => "timestamp_x",
		"ELEMENT_SORT_ORDER2" => "desc",
		"SEOMETA_TAGS"=>$arParams['SEOMETA_TAGS'],
		"PROPERTY_CODE" => array(
			0 => COption::GetOptionString("kit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", "PROIZVODITEL_ATTR_E"),
		),
		"PAGE_ELEMENT_COUNT_IN_ROW"=>$arParams["PAGE_ELEMENT_COUNT_IN_ROW"],
		"META_KEYWORDS" => "",
		"LAZY_LOAD" => $arParams["LAZY_LOAD"],
		"IMAGE_RESIZE_MODE" => $arParams["IMAGE_RESIZE_MODE"],
		"PRELOADER" => $arParams["PRELOADER"],
		"META_DESCRIPTION" => "",
		"SET_BROWSER_TITLE"=>$arParams["SET_BROWSER_TITLE"],
		"SET_META_KEYWORDS"=>$arParams["SET_META_KEYWORDS"],
		"SET_META_DESCRIPTION"=>$arParams["SET_META_DESCRIPTION"],
		"BROWSER_TITLE" => "-",
		"INCLUDE_SUBSECTIONS" => "Y",
		"BASKET_URL" => "",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"SECTION_ID_VARIABLE" => "",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"FILTER_NAME" => "arrBrandFilter",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"DISPLAY_COMPARE" => "N",
		"PAGE_ELEMENT_COUNT" => $_SESSION["MS_COUNT"]?$_SESSION["MS_COUNT"]:$arParams["NEWS_COUNT"],
		"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
		"PRICE_CODE" => ($_SESSION["KIT_REGIONS"]["PRICE_CODE"] && COption::GetOptionString("kit.b2bshop","USE_MULTIREGIONS","Y") == 'Y')
			?$_SESSION["KIT_REGIONS"]["PRICE_CODE"]:unserialize(COption::GetOptionString("kit.b2bshop","PRICE_CODE","")),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
			0 => "CML2_MANUFACTURER",
		),
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "catalog",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "",
		"PAGER_SHOW_ALL" => "N",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "RAZMER_ATTR_S_DIRECTORY",
			1 => "TSVET_ATTR_S_DIRECTORY",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
		),
		"OFFERS_PROPERTY_CODE" => unserialize(COption::GetOptionString("kit.b2bshop", "OFFER_TREE_PROPS", "")),
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
		"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "",
		"HIDE_NOT_AVAILABLE" => "Y",
		"LABEL_PROP" => $arParams["LABEL_PROP"],
		"ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
		"PRODUCT_DISPLAY_MODE" => $arParams["PRODUCT_DISPLAY_MODE"],
		"OFFER_ADD_PICT_PROP" => $arParams["OFFER_ADD_PICT_PROP"],
		"OFFER_TREE_PROPS" => unserialize(COption::GetOptionString("kit.b2bshop", "OFFER_TREE_PROPS", "")),
		"PRODUCT_SUBSCRIPTION" => $arParams["PRODUCT_SUBSCRIPTION"],
		"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
		"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
		"MESS_BTN_BUY" => $arParams["MESS_BTN_BUY"],
		"MESS_BTN_ADD_TO_BASKET" => $arParams["MESS_BTN_ADD_TO_BASKET"],
		"MESS_BTN_SUBSCRIBE" => $arParams["MESS_BTN_SUBSCRIBE"],
		"MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
		"MESS_NOT_AVAILABLE" => $arParams["MESS_NOT_AVAILABLE"],
		"TEMPLATE_THEME" => (isset($arParams["TEMPLATE_THEME"])?$arParams["TEMPLATE_THEME"]:""),
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "Y",
		"BY_LINK" => "Y",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SHOW_ALL_WO_SECTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"BY_LINK" => "Y",
		"OFFER_COLOR_PROP" => COption::GetOptionString("kit.b2bshop", "OFFER_COLOR_PROP", ""),
		"MANUFACTURER_ELEMENT_PROPS" => COption::GetOptionString("kit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", ""),
		"MANUFACTURER_LIST_PROPS" => COption::GetOptionString("kit.b2bshop", "MANUFACTURER_LIST_PROPS", ""),
		"FLAG_PROPS" => unserialize(COption::GetOptionString("kit.b2bshop", "FLAG_PROPS", "")),
		"DELETE_OFFER_NOIMAGE" => COption::GetOptionString("kit.b2bshop", "DELETE_OFFER_NOIMAGE", ""),
		"PICTURE_FROM_OFFER" => COption::GetOptionString("kit.b2bshop", "PICTURE_FROM_OFFER", ""),
		"MORE_PHOTO_PRODUCT_PROPS" => COption::GetOptionString("kit.b2bshop", "MORE_PHOTO_PRODUCT_PROPS", ""),
		"MORE_PHOTO_OFFER_PROPS" => COption::GetOptionString("kit.b2bshop", "MORE_PHOTO_OFFER_PROPS", ""),
		"AVAILABLE_DELETE" => COption::GetOptionString("kit.b2bshop", "AVAILABLE_DELETE", "N"),
		"LIST_WIDTH_SMALL" => COption::GetOptionString("kit.b2bshop", "LIST_WIDTH_SMALL", ""),
		"LIST_HEIGHT_SMALL" => COption::GetOptionString("kit.b2bshop", "LIST_HEIGHT_SMALL", ""),
		"LIST_WIDTH_MEDIUM" => COption::GetOptionString("kit.b2bshop", "LIST_WIDTH_MEDIUM", ""),
		"LIST_HEIGHT_MEDIUM" => COption::GetOptionString("kit.b2bshop", "LIST_HEIGHT_MEDIUM", ""),
		"DETAIL_PROPERTY_CODE" => unserialize(COption::GetOptionString("kit.b2bshop", "ALL_PROPS", "")),
		"DETAIL_WIDTH_SMALL" => COption::GetOptionString("kit.b2bshop", "DETAIL_WIDTH_SMALL", ""),
		"DETAIL_HEIGHT_SMALL" => COption::GetOptionString("kit.b2bshop", "DETAIL_HEIGHT_SMALL", ""),
		"DETAIL_WIDTH_MEDIUM" => COption::GetOptionString("kit.b2bshop", "DETAIL_WIDTH_MEDIUM", ""),
		"DETAIL_HEIGHT_MEDIUM" => COption::GetOptionString("kit.b2bshop", "DETAIL_HEIGHT_MEDIUM", ""),
		"DETAIL_WIDTH_BIG" => COption::GetOptionString("kit.b2bshop", "DETAIL_WIDTH_BIG", ""),
		"DETAIL_HEIGHT_BIG" => COption::GetOptionString("kit.b2bshop", "DETAIL_HEIGHT_BIG", ""),

		//START FILTER COLOR FOR SECTION
		"FILTER_CHECKED_FIRST_COLOR"=>$arResult["FILTER_CHECKED_FIRST_COLOR"],
		//END FILTER COLOR FOR SECTION
		//START PRODUCTS LINK
		"COLOR_IN_PRODUCT"=>$arParams["COLOR_IN_PRODUCT"],
		"COLOR_IN_PRODUCT_CODE" => $arParams["COLOR_IN_PRODUCT_CODE"],
		"COLOR_IN_PRODUCT_LINK"=>$arParams["COLOR_IN_PRODUCT_LINK"],
		"COLOR_IN_SECTION_LINK"=>$arParams["COLOR_IN_SECTION_LINK"],
		"COLOR_IN_SECTION_LINK_MAIN"=>$arParams["COLOR_IN_SECTION_LINK_MAIN"],
		//END PRODUCTS LINK

	),
	false
);
if($arResult["~DETAIL_TEXT"]):
?>
<div class="col-sm-24 sm-padding-right-no">
	<div class="section_description">
		<h2 class="title"><?=$arResult["NAME"]?></h2>
		<?=$arResult["~DETAIL_TEXT"]?>
	</div>
</div>
<?endif;?>
<?

if(!empty($arrBrandFilter))
{
	if($arResult["VARIABLES"]["SECTION_ID"])
	{
		$arrBrandFilter["PROPERTY_PROIZVODITEL_ATTR_E"] = $arResult["ID"];
		$_SESSION["arrBrandFilter_MS"] = $arrBrandFilter;
	}
}else{
	unset($_SESSION["arrBrandFilter_MS"]);
	$_SESSION["arrBrandFilter_MS"]["PROPERTY_PROIZVODITEL_ATTR_E"] = $arResult["ID"];
}
if(isset($_REQUEST["bxajaxid"])) return false;
$context = \Bitrix\Main\Application::getInstance()->getContext();
$server = $context->getServer();
if(\Bitrix\Main\Config\Option::get("kit.b2bshop", "SHOW_BIG_DATA_SECTION_UNDER","Y") == 'Y' && \Bitrix\Main\Config\Option::get("main", "gather_catalog_stat","N") == 'Y' && is_dir($server->getDocumentRoot().$server->getPersonalRoot().'/components/bitrix/catalog.bigdata.products'))
{
	if(!defined('ERROR_404'))
	{
		$mxResult = CCatalogSKU::GetInfoByProductIBlock( Option::get( "kit.b2bshop", "IBLOCK_ID", "" ));
		if( is_array( $mxResult ) )
		{
			$offersIblock = $mxResult['IBLOCK_ID'];
		}
		unset($mxResult);
		$this->__template->SetViewTarget( 'ms_big_data' );
		$APPLICATION->IncludeComponent( 'bitrix:catalog.bigdata.products', 'section',
				Array(
						'ACTION_VARIABLE' => 'action_cbdp',
						'ADD_PROPERTIES_TO_BASKET' => "Y",
						'AJAX_PRODUCT_LOAD' => Option::get( "kit.b2bshop", "AJAX_PRODUCT_LOAD", "" ),
						'AVAILABLE_DELETE' => Option::get( "kit.b2bshop", "AVAILABLE_DELETE", "N" ),
						'BASKET_URL' => Option::get( "kit.b2bshop", "URL_CART", "" ),
						'CACHE_GROUPS' => "Y",
						'CACHE_TIME' => '36000000',
						'CACHE_TYPE' => 'A',
						"COLOR_IN_PRODUCT" => Option::get( "kit.b2bshop", "COLOR_IN_PRODUCT", "" ),
						"COLOR_IN_PRODUCT_CODE" => Option::get( "kit.b2bshop", "COLOR_IN_PRODUCT_CODE", "" ),
						"COLOR_IN_PRODUCT_LINK" => Option::get( "kit.b2bshop", "COLOR_IN_PRODUCT_LINK", "" ),
						"COLOR_IN_SECTION_LINK" => Option::get( "kit.b2bshop", "COLOR_IN_SECTION_LINK", "1" ),
						'CONVERT_CURRENCY' => 'Y',
						'CURRENCY_ID' => '',
						'DELETE_OFFER_NOIMAGE' => Option::get( "kit.b2bshop", "DELETE_OFFER_NOIMAGE", "" ),
						"DETAIL_HEIGHT_BIG" => Option::get( "kit.b2bshop", "DETAIL_HEIGHT_BIG", "" ),
						"DETAIL_HEIGHT_MEDIUM" => Option::get( "kit.b2bshop", "DETAIL_HEIGHT_MEDIUM", "" ),
						"DETAIL_HEIGHT_SMALL" => Option::get( "kit.b2bshop", "DETAIL_HEIGHT_SMALL", "" ),
						"DETAIL_PROPERTY_CODE" => unserialize( Option::get( "kit.b2bshop", "ALL_PROPS", "" ) ),
						'DEPTH' => '2',
						'DETAIL_URL' => '',
						'FLAG_PROPS' => unserialize( Option::get( "kit.b2bshop", "FLAG_PROPS", "" ) ),
						'HIDE_NOT_AVAILABLE' => "N",
						"IBLOCK_ID" => Option::get( "kit.b2bshop", "IBLOCK_ID", "" ),
						"IBLOCK_TYPE" => Option::get( "kit.b2bshop", "IBLOCK_TYPE", "" ),
						"IMAGE_RESIZE_MODE" => Option::get( "kit.b2bshop", "IMAGE_RESIZE_MODE", BX_RESIZE_IMAGE_PROPORTIONAL ),
						'LAZY_LOAD' => Option::get( "kit.b2bshop", "LAZY_LOAD", "" ),
						"LIST_HEIGHT_MEDIUM" => "455",
						"LIST_HEIGHT_SMALL" => "150",
						"LIST_WIDTH_MEDIUM" => "255",
						"LIST_WIDTH_SMALL" => "90",
						"MANUFACTURER_ELEMENT_PROPS" => Option::get( "kit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", "" ),
						"MANUFACTURER_LIST_PROPS" => Option::get( "kit.b2bshop", "MANUFACTURER_LIST_PROPS", "" ),
						'MESS_BTN_BUY' => '',
						'MESS_BTN_DETAIL' => '',
						'MESS_BTN_SUBSCRIBE' => '',
						"MORE_PHOTO_OFFER_PROPS" => Option::get( "kit.b2bshop", "MORE_PHOTO_OFFER_PROPS", "" ),
						"MORE_PHOTO_PRODUCT_PROPS" => Option::get( "kit.b2bshop", "MORE_PHOTO_PRODUCT_PROPS", "" ),
						"OFFER_COLOR_PROP" => Option::get( "kit.b2bshop", "OFFER_COLOR_PROP", "" ),
						"OFFERS_PROPERTY_CODE" => unserialize( Option::get( "kit.b2bshop", "OFFER_TREE_PROPS", "" ) ),
						'OFFER_TREE_PROPS_' . $offersIblock => unserialize( Option::get( "kit.b2bshop", "OFFER_TREE_PROPS", "" ) ),
						'PAGE_ELEMENT_COUNT' => '30',
						'PARTIAL_PRODUCT_PROPERTIES' => "N",
						"PICTURE_FROM_OFFER" => Option::get( "kit.b2bshop", "PICTURE_FROM_OFFER", "" ),
						"PRELOADER" => Option::get( "kit.preloader", "IMAGE", "" ),
						"PRICE_CODE" => unserialize( Option::get( "kit.b2bshop", "PRICE_CODE", "" ) ),
						'PRICE_VAT_INCLUDE' => "Y",
						'PROPERTY_CODE_' . Option::get( "kit.b2bshop", "IBLOCK_ID", "" ) => array(),
						'PROPERTY_CODE_' . $offersIblock => unserialize( Option::get( "kit.b2bshop", "OFFER_TREE_PROPS", "" ) ),
						'PRODUCT_ID_VARIABLE' => 'id',
						'PRODUCT_PROPS_VARIABLE' => 'prop',
						'PRODUCT_QUANTITY_VARIABLE' => 'quantity',
						'PRODUCT_SUBSCRIPTION' => '',
						'RCM_TYPE' => 'personal',
						'SECTION_CODE' => '',
						'SECTION_ELEMENT_CODE' => '',
						'SECTION_ELEMENT_ID' => '',
						'SECTION_ID' => '',
						'SHOW_DISCOUNT_PERCENT' => 'Y',
						'SHOW_FROM_SECTION' => 'N',
						'SHOW_IMAGE' => 'Y',
						'SHOW_NAME' => 'Y',
						'SHOW_OLD_PRICE' => 'N',
						'SHOW_PRICE_COUNT' => '1',
						'SHOW_PRODUCTS_' . Option::get( "kit.b2bshop", "IBLOCK_ID", "" ) => 'Y',
						'USE_PRODUCT_QUANTITY' => "N"
						) );
		$this->__template->EndViewTarget();
		unset($context, $server);
	}
}
$this->__template->SetViewTarget("ms_product_view");
if(isset($_COOKIE['ms_viewed_products']) && sizeof($_COOKIE['ms_viewed_products'])>0)
{
	if(!defined('ERROR_404'))
	{
		global $ViewedProducts;

		$Cook = array_reverse($_COOKIE['ms_viewed_products']);
		$Cook = array_unique($Cook);

		$ElementCnt = 30;
		$Cook = array_slice($Cook, 0, $ElementCnt);

		$ViewedProducts=array('ID'=>$Cook);

		$APPLICATION->IncludeComponent( "bitrix:catalog.top", "catalog_viewed_products", array(
				"IBLOCK_TYPE" => COption::GetOptionString("kit.b2bshop", "IBLOCK_TYPE", ""),
				"IBLOCK_ID" => COption::GetOptionString("kit.b2bshop", "IBLOCK_ID", ""),
				"LAZY_LOAD" => COption::GetOptionString("kit.b2bshop","LAZY_LOAD",""),
				"PRELOADER" => COption::GetOptionString("kit.preloader","IMAGE",""),
				"ELEMENT_SORT_FIELD" => "sort",
				"ELEMENT_SORT_ORDER" => "asc",
				"ELEMENT_SORT_FIELD2" => "timestamp_x",
				"ELEMENT_SORT_ORDER2" => "desc",
				"FILTER_NAME" => "ViewedProducts",
				"HIDE_NOT_AVAILABLE" => "N",
				"ELEMENT_COUNT" => $ElementCnt,
				"PROPERTY_CODE" => array("","NEWPRODUCT","SALELEADER","SPECIALOFFER",""),
				"OFFERS_FIELD_CODE" => array(0=>"PREVIEW_PICTURE",1=>"DETAIL_PICTURE",2=>""),
				"OFFERS_PROPERTY_CODE" => unserialize(COption::GetOptionString("kit.b2bshop","OFFER_TREE_PROPS","")),
				"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
				"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
				"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
				"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
				"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
				"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
				"CACHE_FILTER" => $arParams["CACHE_FILTER"],
				"PRICE_CODE" => unserialize(COption::GetOptionString("kit.b2bshop", "PRICE_CODE", "")),
				"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
				"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
				"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
				"CURRENCY_ID" => $arParams["CURRENCY_ID"],
				"BASKET_URL" => $arParams["BASKET_URL"],
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
				"ADD_PROPERTIES_TO_BASKET" => $arParams["ADD_PROPERTIES_TO_BASKET"],
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PARTIAL_PRODUCT_PROPERTIES" => "Y",
				"PRODUCT_PROPERTIES" => array(),
				"OFFERS_CART_PROPERTIES" => unserialize(COption::GetOptionString("kit.b2bshop","OFFER_TREE_PROPS","")),
				"PRODUCT_QUANTITY_VARIABLE" => "quantity",
				"OFFER_TREE_PROPS" => unserialize(COption::GetOptionString("kit.b2bshop", "OFFER_TREE_PROPS", "")),
				"OFFER_COLOR_PROP" => COption::GetOptionString("kit.b2bshop", "OFFER_COLOR_PROP", ""),
				"MANUFACTURER_ELEMENT_PROPS" => COption::GetOptionString("kit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", ""),
				"MANUFACTURER_LIST_PROPS" => COption::GetOptionString("kit.b2bshop", "MANUFACTURER_LIST_PROPS", ""),
				"FLAG_PROPS" => unserialize(COption::GetOptionString("kit.b2bshop","FLAG_PROPS","")),
				"DELETE_OFFER_NOIMAGE" => COption::GetOptionString("kit.b2bshop","DELETE_OFFER_NOIMAGE",""),
				"PICTURE_FROM_OFFER" => COption::GetOptionString("kit.b2bshop", "PICTURE_FROM_OFFER", ""),
				"MORE_PHOTO_PRODUCT_PROPS" => COption::GetOptionString("kit.b2bshop", "MORE_PHOTO_PRODUCT_PROPS", ""),
				"MORE_PHOTO_OFFER_PROPS" => COption::GetOptionString("kit.b2bshop", "MORE_PHOTO_OFFER_PROPS", ""),
				"LIST_WIDTH_SMALL" => COption::GetOptionString("kit.b2bshop", "LIST_WIDTH_SMALL", ""),
				"LIST_HEIGHT_SMALL" => COption::GetOptionString("kit.b2bshop", "LIST_HEIGHT_SMALL", ""),
				"LIST_WIDTH_MEDIUM" => COption::GetOptionString("kit.b2bshop", "LIST_WIDTH_MEDIUM", ""),
				"LIST_HEIGHT_MEDIUM" => COption::GetOptionString("kit.b2bshop", "LIST_HEIGHT_MEDIUM", ""),
				"COLOR_IN_PRODUCT" => COption::GetOptionString("kit.b2bshop","COLOR_IN_PRODUCT",""),
				"COLOR_IN_PRODUCT_CODE" => COption::GetOptionString("kit.b2bshop","COLOR_IN_PRODUCT_CODE",""),
				"COLOR_IN_PRODUCT_LINK" => COption::GetOptionString("kit.b2bshop","COLOR_IN_PRODUCT_LINK",""),
				"COLOR_IN_SECTION_LINK" => COption::GetOptionString("kit.b2bshop","COLOR_IN_SECTION_LINK","1"),
				"COLOR_IN_SECTION_LINK_MAIN" => COption::GetOptionString("kit.b2bshop","COLOR_IN_SECTION_LINK_MAIN",""),
				"AVAILABLE_DELETE" => COption::GetOptionString("kit.b2bshop", "AVAILABLE_DELETE", "N"),
				"AJAX_PRODUCT_LOAD" => COption::GetOptionString("kit.b2bshop","AJAX_PRODUCT_LOAD",""),
				"IMAGE_RESIZE_MODE" => COption::GetOptionString("kit.b2bshop","IMAGE_RESIZE_MODE","BX_RESIZE_IMAGE_PROPORTIONAL"),
		));
	}
}

$this->__template->EndViewTarget();?>
	</div>
</div>
<?
global $kitSeoMetaTitle;
global $kitSeoMetaKeywords;
global $kitSeoMetaDescription;
if(isset($kitSeoMetaTitle) && !empty($kitSeoMetaTitle))
{
	$APPLICATION->SetPageProperty("title", $kitSeoMetaTitle);
}
if(isset($kitSeoMetaKeywords) && !empty($kitSeoMetaKeywords))
{
	$APPLICATION->SetPageProperty("keywords", $kitSeoMetaKeywords);
}
if(isset($kitSeoMetaDescription) && !empty($kitSeoMetaDescription))
{
	$APPLICATION->SetPageProperty("description", $kitSeoMetaDescription);
}
?>