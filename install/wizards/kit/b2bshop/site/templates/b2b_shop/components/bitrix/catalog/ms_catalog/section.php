<?
if( !defined( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true )
	die();


if( !\Bitrix\Main\Loader::includeModule( "kit.b2bshop" ))
{
	return false;
}

$this->setFrameMode( true );

$arFilter = array(
		'ACTIVE' => 'Y',
		'GLOBAL_ACTIVE' => 'Y',
		'IBLOCK_ID' => $arParams['IBLOCK_ID']
);
if( 0 < intval( $arResult['VARIABLES']['SECTION_ID'] ) )
{
	$arFilter['ID'] = $arResult['VARIABLES']['SECTION_ID'];
}
elseif( '' != $arResult['VARIABLES']['SECTION_CODE'] )
{
	$arFilter['=CODE'] = $arResult['VARIABLES']['SECTION_CODE'];
}
$obCache = new CPHPCache();
if( $obCache->InitCache( 36000, serialize( $arFilter ), '/iblock/catalog' ) )
{
	$arCurSection = $obCache->GetVars();
}
elseif( $obCache->StartDataCache() )
{
	$arCurSection = array();
	if( \Bitrix\Main\Loader::includeModule( 'iblock' ) )
	{
		$dbRes = CIBlockSection::GetList( array(), $arFilter, false, array(
				'ID',
				'DEPTH_LEVEL'
		) );
		if( defined( 'BX_COMP_MANAGED_CACHE' ) )
		{
			global $CACHE_MANAGER;
			$CACHE_MANAGER->StartTagCache( '/iblock/catalog' );
			if( $arCurSection = $dbRes->Fetch() )
			{
				$CACHE_MANAGER->RegisterTag( 'iblock_id_' . $arParams['IBLOCK_ID'] );
			}
			$CACHE_MANAGER->EndTagCache();
		}
		else
		{
			if( !$arCurSection = $dbRes->Fetch() )
				$arCurSection = array();
		}
	}
	$obCache->EndDataCache( $arCurSection );
}


$sectionTemplate = new \Kit\B2BShop\Client\Template\Section();
$template = $sectionTemplate->identifySectionView($arCurSection['DEPTH_LEVEL']);


$ShowBricks = false;
if( $arParams['USE_BRICKS'] == 'Y' && $arCurSection['DEPTH_LEVEL'] == 1 )
{
	$ShowBricks = true;
}
if( $template == 'bricks' )
{
	?>
	<div class='row'>
		<div class='col-sm-24 sm-padding-right-no'>
			<?
			$APPLICATION->IncludeComponent( 'bitrix:breadcrumb', 'ms_breadcrumb_section',
					array(
							'PATH' => '',
							'START_FROM' => '0',
							'SITE_ID' => SITE_ID
					), false, Array(
							'HIDE_ICONS' => 'N'
					) );

			$APPLICATION->IncludeComponent( 'coffeediz:breadcrumb', 'coffeediz.schema.org',
					Array(
							'COMPONENT_TEMPLATE' => 'coffeediz.schema.org',
							'PATH' => '',
							'SHOW' => 'Y',
							'SITE_ID' => SITE_ID,
							'START_FROM' => '0'
					) );
			?>
		</div>
	</div>
	<?
}
else
{
	if( $arParams['USE_FILTER'] == 'Y' )
	{
		?>
		<div class='col-sm-6 sm-padding-left-no left-wrap'>
			<div class='left-block'>
				<?
				$arParams['AJAX_OPTION_HISTORY'] = 'N';

				$APPLICATION->IncludeComponent( 'kit:catalog.smart.filter.facet', 'catalog',
						Array(
								'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],
								'SECTION_ID' => $arCurSection['ID'],
								'FILTER_NAME' => $arParams['FILTER_NAME'],
								'PRICE_CODE' => $arParams['PRICE_CODE'],
								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'SAVE_IN_SESSION' => 'N',
								'XML_EXPORT' => 'N',
								'SECTION_TITLE' => 'NAME',
								'SECTION_DESCRIPTION' => 'DESCRIPTION',
								'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
								'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
								'AJAX_MODE' => $arParams['AJAX_MODE'],
								'AJAX_OPTION_JUMP' => $arParams['AJAX_OPTION_JUMP'],
								'AJAX_OPTION_STYLE' => $arParams['AJAX_OPTION_STYLE'],
								'AJAX_OPTION_HISTORY' => $arParams['AJAX_OPTION_HISTORY'],
								'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
								'OFFER_COLOR_PROP' => $arParams['OFFER_COLOR_PROP'],
								'SEF_MODE_FILTER' => 'Y',
								'SECTIONS' => 'N',
								'SECTIONS_DEPTH_LEVEL' => '2',
								'COLOR_IN_PRODUCT' => $arParams['COLOR_IN_PRODUCT'],
								'COLOR_IN_PRODUCT_CODE' => $arParams['COLOR_IN_PRODUCT_CODE'],
								'SEF_MODE' => \Bitrix\Main\Config\Option::get( 'kit.b2bshop', 'CATALOG_FILTER', 'N' ),
								'SEF_RULE' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['smart_filter'],
								'FILTER_ITEM_COUNT' => $arParams['FILTER_ITEM_COUNT']
						), $component, array(
								'HIDE_ICONS' => 'Y'
						) );
				$APPLICATION->IncludeComponent( 'kit:seo.meta', '.default',
						Array(
								'FILTER_NAME' => $arParams['FILTER_NAME'],
								'SECTION_ID' => $arCurSection['ID'],
								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME']
						) );
				global $kitSeoMetaAddDesc;
				if( isset( $kitSeoMetaAddDesc ) && !empty( $kitSeoMetaAddDesc ) )
				{
					echo $kitSeoMetaAddDesc;
				}
				?>
				</div>
		</div>
	<?
	}
	?>
<div class='col-sm-18'>
	<div class='row'>
		<div class='col-sm-24 sm-padding-right-no'>
	<?
	$APPLICATION->IncludeComponent( 'bitrix:breadcrumb', 'ms_breadcrumb_section',
			array(
					'START_FROM' => '0',
					'PATH' => '',
					'SITE_ID' => SITE_ID
			), false, Array(
					'HIDE_ICONS' => 'N'
			) );
	?>
	<?

	$APPLICATION->IncludeComponent( 'coffeediz:breadcrumb', 'coffeediz.schema.org',
			Array(
					'COMPONENT_TEMPLATE' => 'coffeediz.schema.org',
					'PATH' => '',
					'SHOW' => 'Y',
					'SITE_ID' => SITE_ID,
					'START_FROM' => '0'
			) );

	?>
			</div>
	<?
	$APPLICATION->IncludeComponent( 'bitrix:catalog.section.list', 'ms_img',
			array(
					'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
					'IBLOCK_ID' => $arParams['IBLOCK_ID'],
					'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
					'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
					'SECTION_FIELDS' => array(
							'PICTURE'
					),
					'CACHE_TYPE' => $arParams['CACHE_TYPE'],
					'CACHE_TIME' => $arParams['CACHE_TIME'],
					'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
					'COUNT_ELEMENTS' => $arParams['SECTION_COUNT_ELEMENTS'],
					'TOP_DEPTH' => $arParams['SECTION_TOP_DEPTH'],
					'SECTION_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
					'VIEW_MODE' => $arParams['SECTIONS_VIEW_MODE'],
					'SHOW_PARENT_NAME' => $arParams['SECTIONS_SHOW_PARENT_NAME'],
					'HIDE_SECTION_NAME' => (isset( $arParams['SECTIONS_HIDE_SECTION_NAME'] ) ? $arParams['SECTIONS_HIDE_SECTION_NAME'] : 'N'),
					'ADD_SECTIONS_CHAIN' => (isset( $arParams['ADD_SECTIONS_CHAIN'] ) ? $arParams['ADD_SECTIONS_CHAIN'] : '')
			), $component );

	if( \Bitrix\Main\Loader::includeModule( 'kit.mailing' ) && !\Bitrix\Main\Loader::includeModule( 'kit.b2bshop' ) )
	{
		?>
		<div class='col-sm-24 hidden-xs'>
			<a href="<?=$APPLICATION->GetCurPage();?>" style="display: inline-block;width:10px;height:10px;background:#fafafa;"></a>
			<?
			$APPLICATION->IncludeComponent( 'kit:kit.mailing.email.get', 'ms_field_section',
					Array(
							'TYPE' => 'SECTION_ID',
							'PARAM_2:SECTION_ID' => $arCurSection['ID'],
							'INFO_TEXT' => htmlspecialcharsBack( $arParams['~MAILING_INFO_TEXT'] ),
							'EMAIL_SEND_END' => htmlspecialcharsBack( $arParams['~MAILING_EMAIL_SEND_END'] ),
							'COLOR_BUTTON' => '6e7278',
							'DISPLAY_IF_ADMIN' => 'N',
							'DISPLAY_NO_AUTH' => 'N',
							'CATEGORIES_ID' => $arParams['MAILING_CATEGORIES_ID'],
							'JQUERY' => 'N',
							'CATEGORY_SUNC_USER' => 'N',
							'CATEGORY_SUNC_USER_GROUP' => array(),
							'CATEGORY_SUNC_USER_MESSAGE' => 'N',
							'CATEGORY_SUNC_USER_EVENT' => '1',
							'CATEGORY_SUNC_SUBSCRIPTION' => 'N',
							'CATEGORY_SUNC_SUBSCRIPTION_LIST' => array(),
							'CATEGORY_SUNC_MAILCHIMP' => 'N',
							'CATEGORY_SUNC_UNISENDER' => 'N'
					), false );
			?>
		</div>
		<?
	}
	$intSectionID = 0;
	?><?

	if( isset( $_POST['count'] ) )
	{
		$_SESSION['MS_COUNT'] = $_POST['count'];
	}
	if( isset( $_POST['sort'] ) )
	{
		$_SESSION['MS_SORT'] = $_POST['sort'];
	}
	$arAvailableSortKit = array(
			'default' => array(
			),
			'name_0' => Array(
					'name',
					'desc'
			),
			'name_1' => Array(
					'name',
					'asc'
			),
			'price_0' => Array(
					'PROPERTY_MINIMUM_PRICE',
					'desc'
			),
			'price_1' => Array(
					'PROPERTY_MINIMUM_PRICE',
					'asc'
			),
			'date_0' => Array(
					'DATE_CREATE',
					'desc'
			),
			'date_1' => Array(
					'DATE_CREATE',
					'asc'
			)
	);

	if( isset( $_SESSION['MS_SORT'] ) )
	{
		$arSort = $arAvailableSortKit[$_SESSION['MS_SORT']];
		$sort_field = $arSort[0];
		$sort_order = $arSort[1];
	}
	elseif( empty( $_SESSION['MS_SORT'] ) && $arAvailableSortKit[$arParams['ELEMENT_SORT_FIELD']] )
	{
		$arSort = $arAvailableSortKit[$arParams['ELEMENT_SORT_FIELD']];
		$sort_field = $arSort[0];
		$sort_order = $arSort[1];
	}
	global ${$arParams['FILTER_NAME']};
	global $kitFilterResult;
	$arResult['FILTER_CHECKED_FIRST_COLOR'] = array();
	foreach( $kitFilterResult['ITEMS'] as $key => $item )
	{
		if( $item['CODE'] == $arParams['OFFER_COLOR_PROP'] )
		{
			foreach( $item['VALUES'] as $key_value => $value )
			{
				if( isset( $value['CHECKED'] ) && $value['CHECKED'] == 1 )
					$arResult['FILTER_CHECKED_FIRST_COLOR'][] = $value['DEFAULT']['UF_XML_ID'];
			}
		}
	}

	if(
			$arParams['COLOR_IN_PRODUCT'] == 'Y' &&
			$arParams['COLOR_IN_SECTION_LINK'] == 2 &&
			$arParams['COLOR_IN_SECTION_LINK_MAIN'] )
	{
		if( empty( ${$arParams['FILTER_NAME']}['OFFERS'] ) )
		{
			$arFilter = array(
					'IBLOCK_ID' => $arParams['IBLOCK_ID'],
					'ACTIVE' => 'Y',
					'CODE' => $arParams['COLOR_IN_SECTION_LINK_MAIN']
			);

			$Property = CIBlockProperty::GetList( array(), $arFilter )->Fetch();

			if( isset( $Property ) )
			{
				if( $Property['PROPERTY_TYPE'] == 'L' ) // list
				{
					${$arParams['FILTER_NAME']}['=PROPERTY_' . $arParams['COLOR_IN_SECTION_LINK_MAIN'] . '_VALUE'] = array(

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
					${$arParams['FILTER_NAME']}['=PROPERTY_' . $arParams['COLOR_IN_SECTION_LINK_MAIN']] = array(
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
}

if($template == 'row')
{
	$arParams['PAGER_TEMPLATE'] = 'b2b_catalog';
}

if($ShowBricks)
{
	$template = 'bricks';
}

$intSectionID = $APPLICATION->IncludeComponent( 'bitrix:catalog.section', $template,
		array(
				'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
				'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
				'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
				'ADD_SECTIONS_CHAIN' => ($ShowBricks) ? 'Y' : 'N',
				'AJAX_MODE' => $arParams['AJAX_MODE'],
				'AJAX_OPTION_HISTORY' => $arParams['AJAX_OPTION_HISTORY'],
				'AJAX_OPTION_JUMP' => $arParams['AJAX_OPTION_JUMP'],
				'AJAX_OPTION_STYLE' => $arParams['AJAX_OPTION_STYLE'],
				'AJAX_PRODUCT_LOAD' => $arParams['AJAX_PRODUCT_LOAD'],
				'AVAILABLE_DELETE' => $arParams['AVAILABLE_DELETE'],
				'BASKET_URL' => $rParams['BASKET_URL'],
				'BROWSER_TITLE' => $arParams['LIST_BROWSER_TITLE'],
				'CACHE_FILTER' => $arParams['CACHE_FILTER'],
				'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
				'CACHE_TIME' => $arParams['CACHE_TIME'],
				'CACHE_TYPE' => $arParams['CACHE_TYPE'],
				'COLOR_IN_PRODUCT' => $arParams['COLOR_IN_PRODUCT'],
				'COLOR_IN_PRODUCT_CODE' => $arParams['COLOR_IN_PRODUCT_CODE'],
				'COLOR_IN_PRODUCT_LINK' => $arParams['COLOR_IN_PRODUCT_LINK'],
				'COLOR_IN_SECTION_LINK' => $arParams['COLOR_IN_SECTION_LINK'],
				'COLOR_IN_SECTION_LINK_MAIN' => $arParams['COLOR_IN_SECTION_LINK_MAIN'],
				'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
				'CURRENCY_ID' => $arParams['CURRENCY_ID'],
				'DELETE_OFFER_NOIMAGE' => $arParams['DELETE_OFFER_NOIMAGE'],
				'DETAIL_HEIGHT_BIG' => $arParams['DETAIL_HEIGHT_BIG'],
				'DETAIL_HEIGHT_MEDIUM' => $arParams['DETAIL_HEIGHT_MEDIUM'],
				'DETAIL_HEIGHT_SMALL' => $arParams['DETAIL_HEIGHT_SMALL'],
				'DETAIL_PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
				'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['element'],
				'DETAIL_WIDTH_BIG' => $arParams['DETAIL_WIDTH_BIG'],
				'DETAIL_WIDTH_MEDIUM' => $arParams['DETAIL_WIDTH_MEDIUM'],
				'DETAIL_WIDTH_SMALL' => $arParams['DETAIL_WIDTH_SMALL'],
				'DISPLAY_BOTTOM_PAGER' => $arParams['DISPLAY_BOTTOM_PAGER'],
				'DISPLAY_COMPARE' => $arParams['USE_COMPARE'],
				'DISPLAY_TOP_PAGER' => $arParams['DISPLAY_TOP_PAGER'],
				'ELEMENT_SORT_FIELD' => $sort_field ? $sort_field : $arParams['ELEMENT_SORT_FIELD'],
				'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
				'ELEMENT_SORT_ORDER' => $sort_order ? $sort_order : $arParams['ELEMENT_SORT_ORDER'],
				'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
				'FILTER_CHECKED_FIRST_COLOR' => $arResult['FILTER_CHECKED_FIRST_COLOR'],
				'FILTER_NAME' => $arParams['FILTER_NAME'],
				'FLAG_PROPS' => $arParams['FLAG_PROPS'],
				'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
				'IBLOCK_ID' => $arParams['IBLOCK_ID'],
				'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
				'IMAGE_RESIZE_MODE' => $arParams['IMAGE_RESIZE_MODE'],
				'INCLUDE_SUBSECTIONS' => $arParams['INCLUDE_SUBSECTIONS'],
				'LABEL_PROP' => $arParams['LABEL_PROP'],
				'LAZY_LOAD' => $arParams['LAZY_LOAD'],
				'LINE_ELEMENT_COUNT' => $arParams['LINE_ELEMENT_COUNT'],
				'LIST_HEIGHT_MEDIUM' => $arParams['LIST_HEIGHT_MEDIUM'],
				'LIST_HEIGHT_SMALL' => $arParams['LIST_HEIGHT_SMALL'],
				'LIST_WIDTH_MEDIUM' => $arParams['LIST_WIDTH_MEDIUM'],
				'LIST_WIDTH_SMALL' => $arParams['LIST_WIDTH_SMALL'],
				'MANUFACTURER_ELEMENT_PROPS' => $arParams['MANUFACTURER_ELEMENT_PROPS'],
				'MANUFACTURER_LIST_PROPS' => $arParams['MANUFACTURER_LIST_PROPS'],
				'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
				'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
				'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
				'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
				'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
				'META_DESCRIPTION' => $arParams['LIST_META_DESCRIPTION'],
				'META_KEYWORDS' => $arParams['LIST_META_KEYWORDS'],
				'MORE_PHOTO_OFFER_PROPS' => $arParams['MORE_PHOTO_OFFER_PROPS'],
				'MORE_PHOTO_PRODUCT_PROPS' => $arParams['MORE_PHOTO_PRODUCT_PROPS'],
				'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
				'OFFERS_FIELD_CODE' => $arParams['LIST_OFFERS_FIELD_CODE'],
				'OFFERS_LIMIT' => $arParams['LIST_OFFERS_LIMIT'],
				'OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
				'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
				'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
				'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
				'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
				'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
				'OFFER_COLOR_PROP' => $arParams['OFFER_COLOR_PROP'],
				'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
				'PAGER_DESC_NUMBERING' => $arParams['PAGER_DESC_NUMBERING'],
				'PAGER_DESC_NUMBERING_CACHE_TIME' => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
				'PAGER_SHOW_ALL' => $arParams['PAGER_SHOW_ALL'],
				'PAGER_SHOW_ALWAYS' => $arParams['PAGER_SHOW_ALWAYS'],
				'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
				'PAGER_TITLE' => $arParams['PAGER_TITLE'],
				'PAGE_ELEMENT_COUNT' => $_SESSION["MS_COUNT"] ? $_SESSION["MS_COUNT"] : $arParams["PAGE_ELEMENT_COUNT"],
				'PAGE_ELEMENT_COUNT_IN_ROW' => $arParams['PAGE_ELEMENT_COUNT_IN_ROW'],
				'PARTIAL_PRODUCT_PROPERTIES' => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
				'PICTURE_FROM_OFFER' => $arParams['PICTURE_FROM_OFFER'],
				'PRELOADER' => COption::GetOptionString( 'kit.preloader', 'IMAGE', '' ),
				'PRICE_CODE' => $arParams['PRICE_CODE'],
				'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
				'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
				'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
				'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],
				'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
				'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
				'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
				'PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'],
				'RCM_TYPE' => isset( $arParams['BIG_DATA_RCM_TYPE'] ) ? $arParams['BIG_DATA_RCM_TYPE'] : '',
				'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
				'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
				'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
				'SECTION_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
				'SEOMETA_TAGS' => $arParams['SEOMETA_TAGS'],
				'SET_BROWSER_TITLE' => $arParams['SET_BROWSER_TITLE'],
				'SET_META_DESCRIPTION' => $arParams['SET_META_DESCRIPTION'],
				'SET_META_KEYWORDS' => $arParams['SET_META_KEYWORDS'],
				'SET_STATUS_404' => $arParams['SET_STATUS_404'],
				'SET_TITLE' => $arParams['SET_TITLE'],
				'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
				'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
				'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
				'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
				'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
				'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY']
		), $component );

if( $ShowBricks )
{
	if( CModule::IncludeModule( 'kit.mailing' ) )
	{
		?>
		<div class='col-sm-24 hidden-xs'>
			<?
		$APPLICATION->IncludeComponent( 'kit:kit.mailing.email.get', 'ms_field_section',
				Array(
						'TYPE' => 'SECTION_ID',
						'PARAM_2:SECTION_ID' => $intSectionID,
						'INFO_TEXT' => htmlspecialcharsBack( $arParams['~MAILING_INFO_TEXT'] ),
						'EMAIL_SEND_END' => htmlspecialcharsBack( $arParams['~MAILING_EMAIL_SEND_END'] ),
						'COLOR_BUTTON' => '6e7278',
						'DISPLAY_IF_ADMIN' => 'N',
						'DISPLAY_NO_AUTH' => 'N',
						'CATEGORIES_ID' => $arParams['MAILING_CATEGORIES_ID'],
						'JQUERY' => 'N',
						'CATEGORY_SUNC_USER' => 'N',
						'CATEGORY_SUNC_USER_GROUP' => array(),
						'CATEGORY_SUNC_USER_MESSAGE' => 'N',
						'CATEGORY_SUNC_USER_EVENT' => '1',
						'CATEGORY_SUNC_SUBSCRIPTION' => 'N',
						'CATEGORY_SUNC_SUBSCRIPTION_LIST' => array(),
						'CATEGORY_SUNC_MAILCHIMP' => 'N',
						'CATEGORY_SUNC_UNISENDER' => 'N'
				), false );
		?>
		</div>
		<?
	}
}

unset( $_SESSION[$arParams['FILTER_NAME'] . '_MS'][0] );
unset( $_SESSION[$arParams['FILTER_NAME'] . '_SORT_MS'][0] );
// set breadcrumb from seometa
global $kitSeoMetaBreadcrumbLink;
global $kitSeoMetaBreadcrumbTitle;
if( isset( $kitSeoMetaBreadcrumbTitle ) && !empty( $kitSeoMetaBreadcrumbTitle ) )
{
	$APPLICATION->AddChainItem( $kitSeoMetaBreadcrumbTitle, $kitSeoMetaBreadcrumbLink );
}
if( !empty( ${$arParams['FILTER_NAME']} ) )
{
	if( $arResult['VARIABLES']['SECTION_ID'] || $arCurSection['ID'] )
	{
		$keyID = $arResult['VARIABLES']['SECTION_ID'] ? $arResult['VARIABLES']['SECTION_ID'] : $arCurSection['ID'];
		${$arParams['FILTER_NAME']}['SECTION_ID'] = $keyID;
		$_SESSION[$arParams['FILTER_NAME'] . '_MS'][$keyID] = ${$arParams['FILTER_NAME']};
		$_SESSION[$arParams['FILTER_NAME'] . '_SORT_MS'][$keyID] = array(
				$sort_field ? $sort_field : $arParams['ELEMENT_SORT_FIELD'] => $sort_order ? $sort_order : $arParams['ELEMENT_SORT_ORDER']
		);
	}
}
else
{
	$keyID = $arResult['VARIABLES']['SECTION_ID'] ? $arResult['VARIABLES']['SECTION_ID'] : $arCurSection['ID'];
	unset( $_SESSION[$arParams['FILTER_NAME'] . '_MS'][$keyID] );
	$_SESSION[$arParams['FILTER_NAME'] . '_MS'][$keyID]['SECTION_ID'] = $keyID;
	$_SESSION[$arParams['FILTER_NAME'] . '_SORT_MS'][$keyID] = array(
			$sort_field ? $sort_field : $arParams['ELEMENT_SORT_FIELD'] => $sort_order ? $sort_order : $arParams['ELEMENT_SORT_ORDER']
	);
}
if( isset( $_REQUEST['bxajaxid'] ) )
	return false;

if( !defined( 'ERROR_404' ) )
{
	$context = \Bitrix\Main\Application::getInstance()->getContext();
	$server = $context->getServer();
	if(\Bitrix\Main\Config\Option::get("kit.b2bshop", "SHOW_BIG_DATA_SECTION_UNDER","Y") == 'Y' && \Bitrix\Main\Config\Option::get("main", "gather_catalog_stat","N") == 'Y' && is_dir($server->getDocumentRoot().$server->getPersonalRoot().'/components/bitrix/catalog.bigdata.products'))
	{
		if(!defined('ERROR_404'))
		{
			$mxResult = CCatalogSKU::GetInfoByProductIBlock( $arParams['IBLOCK_ID'] );
			if( is_array( $mxResult ) )
			{
				$offersIblock = $mxResult['IBLOCK_ID'];
			}
			unset($mxResult);
			$this->SetViewTarget( 'ms_big_data' );

			$idUserGroups = [];
			$userPriceCode = [];
			$rs = CCatalogGroup::GetGroupsList(array("GROUP_ID"=>$USER->GetGroups(), "BUY"=>"Y"));
			while($group = $rs->Fetch())
			{
				$idUserGroups[$group['CATALOG_GROUP_ID']] = $group['CATALOG_GROUP_ID'];
			}
			if($idUserGroups)
			{
				$rs = \Bitrix\Catalog\GroupTable::getList(['filter' => ['ID' => $idUserGroups],'select' => ['NAME']]);
				while($group = $rs->fetch())
				{
					$userPriceCode[] = $group['NAME'];
				}
			}
			if(!$userPriceCode)
			{
				$userPriceCode = $arParams['PRICE_CODE'];
			}

			$APPLICATION->IncludeComponent( 'bitrix:catalog.bigdata.products', 'section',
					Array(
							'ACTION_VARIABLE' => 'action_cbdp',
							'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],'AJAX_PRODUCT_LOAD' => $arParams['AJAX_PRODUCT_LOAD'],
							'AVAILABLE_DELETE' => $arParams['AVAILABLE_DELETE'],
							'BASKET_URL' => $arParams['BASKET_URL'],
							'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
							'CACHE_TIME' => $arParams['CACHE_TIME'],
							'CACHE_TYPE' => $arParams['CACHE_TYPE'],
							'COLOR_IN_PRODUCT' => $arParams['COLOR_IN_PRODUCT'],
							'COLOR_IN_PRODUCT_CODE' => $arParams['COLOR_IN_PRODUCT_CODE'],
							'COLOR_IN_PRODUCT_LINK' => $arParams['COLOR_IN_PRODUCT_LINK'],
							'COLOR_IN_SECTION_LINK' => $arParams['COLOR_IN_SECTION_LINK'],
							'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
							'CURRENCY_ID' => $arParams['CURRENCY_ID'],
							'DELETE_OFFER_NOIMAGE' => $arParams['DELETE_OFFER_NOIMAGE'],
							'DETAIL_HEIGHT_BIG' => $arParams['DETAIL_HEIGHT_BIG'],
							'DETAIL_HEIGHT_MEDIUM' => $arParams['DETAIL_HEIGHT_MEDIUM'],
							'DETAIL_HEIGHT_SMALL' => $arParams['DETAIL_HEIGHT_SMALL'],
							'DETAIL_PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
							'DEPTH' => '2',
							'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['element'],
							'FLAG_PROPS' => $arParams['FLAG_PROPS'],
							'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
							'IBLOCK_ID' => $arParams['IBLOCK_ID'],
							'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
							'IMAGE_RESIZE_MODE' => $arParams['IMAGE_RESIZE_MODE'],
							'LAZY_LOAD' => $arParams['LAZY_LOAD'],
							'LIST_HEIGHT_MEDIUM' => $arParams['LIST_HEIGHT_MEDIUM'],
							'LIST_HEIGHT_SMALL' => $arParams['LIST_HEIGHT_SMALL'],
							'LIST_WIDTH_MEDIUM' => $arParams['LIST_WIDTH_MEDIUM'],
							'LIST_WIDTH_SMALL' => $arParams['LIST_WIDTH_SMALL'],
							'MANUFACTURER_ELEMENT_PROPS' => $arParams['MANUFACTURER_ELEMENT_PROPS'],
							'MANUFACTURER_LIST_PROPS' => $arParams['MANUFACTURER_LIST_PROPS'],
							'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
							'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
							'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
							'MORE_PHOTO_PRODUCT_PROPS' => $arParams['MORE_PHOTO_PRODUCT_PROPS'],
							'MORE_PHOTO_OFFER_PROPS' => $arParams['MORE_PHOTO_OFFER_PROPS'],
							'OFFER_COLOR_PROP' => $arParams['OFFER_COLOR_PROP'],
							'OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
							'OFFER_TREE_PROPS_' . $offersIblock => $arParams['OFFER_TREE_PROPS'],
							'PAGE_ELEMENT_COUNT' => '30',
							'PARTIAL_PRODUCT_PROPERTIES' => (isset( $arParams['PARTIAL_PRODUCT_PROPERTIES'] ) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
							'PICTURE_FROM_OFFER' => $arParams['PICTURE_FROM_OFFER'],
							"PRELOADER" => $arParams['PRELOADER'],
							'PRICE_CODE' => $userPriceCode,
							'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
							'PROPERTY_CODE_' . $arParams['IBLOCK_ID'] => $arParams['PRODUCT_PROPERTIES'],
							'PROPERTY_CODE_' . $offersIblock => $arParams['OFFER_TREE_PROPS'],
							'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
							'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
							'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
							'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
							'RCM_TYPE' => $arParams['BIG_DATA_RCM_TYPE'],
							'SECTION_CODE' => '',
							'SECTION_ELEMENT_CODE' => '',
							'SECTION_ELEMENT_ID' => '',
							'SECTION_ID' => $arCurSection['ID'],
							'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
							'SHOW_FROM_SECTION' => 'N',
							'SHOW_IMAGE' => 'Y',
							'SHOW_NAME' => 'Y',
							'SHOW_OLD_PRICE' => 'N',
							'SHOW_PRICE_COUNT' => '1',
							'SHOW_PRODUCTS_' . $arParams['IBLOCK_ID'] => 'Y',
							'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY']
							) );
			$this->EndViewTarget();
			unset($context, $server);
		}
	}
	if(\Bitrix\Main\Config\Option::get("kit.b2bshop", "SHOW_YOU_LOOK_SECTION_UNDER","Y") == 'Y')
	{
		if(!defined('ERROR_404'))
		{
			$this->SetViewTarget( 'ms_product_view' );

			if( isset( $_COOKIE['ms_viewed_products'] ) && sizeof( $_COOKIE['ms_viewed_products'] ) > 0 )
			{
				global $ViewedProducts;

				$Cook = array_reverse( $_COOKIE['ms_viewed_products'] );
				$Cook = array_unique( $Cook );

				$ElementCnt = 30;
				$Cook = array_slice( $Cook, 0, $ElementCnt );

				$ViewedProducts = array(
						'ID' => $Cook
				);

				$APPLICATION->IncludeComponent( 'bitrix:catalog.top', 'catalog_viewed_products',
						array(
								'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
								'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
								'AJAX_PRODUCT_LOAD' => $arParams['AJAX_PRODUCT_LOAD'],
								'AVAILABLE_DELETE' => $arParams['AVAILABLE_DELETE'],
								'BASKET_URL' => $arParams['BASKET_URL'],
								'CACHE_FILTER' => $arParams['CACHE_FILTER'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],
								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'COLOR_IN_PRODUCT' => $arParams['COLOR_IN_PRODUCT'],
								'COLOR_IN_PRODUCT_CODE' => $arParams['COLOR_IN_PRODUCT_CODE'],
								'COLOR_IN_PRODUCT_LINK' => $arParams['COLOR_IN_PRODUCT_LINK'],
								'COLOR_IN_SECTION_LINK' => $arParams['COLOR_IN_SECTION_LINK'],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'CURRENCY_ID' => $arParams['CURRENCY_ID'],
								'DELETE_OFFER_NOIMAGE' => $arParams['DELETE_OFFER_NOIMAGE'],
								'DETAIL_HEIGHT_BIG' => $arParams['DETAIL_HEIGHT_BIG'],
								'DETAIL_HEIGHT_MEDIUM' => $arParams['DETAIL_HEIGHT_MEDIUM'],
								'DETAIL_HEIGHT_SMALL' => $arParams['DETAIL_HEIGHT_SMALL'],
								'DETAIL_PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
								'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['element'],
								'DETAIL_WIDTH_BIG' => $arParams['DETAIL_WIDTH_BIG'],
								'DETAIL_WIDTH_MEDIUM' => $arParams['DETAIL_WIDTH_MEDIUM'],
								'DETAIL_WIDTH_SMALL' => $arParams['DETAIL_WIDTH_SMALL'],
								'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
								'ELEMENT_COUNT' => $ElementCnt,
								'ELEMENT_SORT_FIELD' => $arParams['ELEMENT_SORT_FIELD'],
								'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
								'ELEMENT_SORT_ORDER' => $arParams['ELEMENT_SORT_ORDER'],
								'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
								'FILTER_NAME' => 'ViewedProducts',
								'FLAG_PROPS' => $arParams['FLAG_PROPS'],
								'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],
								'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
								'IMAGE_RESIZE_MODE' => $arParams['IMAGE_RESIZE_MODE'],
								'LAZY_LOAD' => $arParams['LAZY_LOAD'],
								'LINE_ELEMENT_COUNT' => $arParams['LINE_ELEMENT_COUNT'],
								'LIST_HEIGHT_MEDIUM' => $arParams['LIST_HEIGHT_MEDIUM'],
								'LIST_HEIGHT_SMALL' => $arParams['LIST_HEIGHT_SMALL'],
								'LIST_WIDTH_MEDIUM' => $arParams['LIST_WIDTH_MEDIUM'],
								'LIST_WIDTH_SMALL' => $arParams['LIST_WIDTH_SMALL'],
								'MANUFACTURER_ELEMENT_PROPS' => $arParams['MANUFACTURER_ELEMENT_PROPS'],
								'MANUFACTURER_LIST_PROPS' => $arParams['MANUFACTURER_LIST_PROPS'],
								'MORE_PHOTO_OFFER_PROPS' => $arParams['MORE_PHOTO_OFFER_PROPS'],
								'MORE_PHOTO_PRODUCT_PROPS' => $arParams['MORE_PHOTO_PRODUCT_PROPS'],
								'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
								'OFFERS_FIELD_CODE' => $arParams['LIST_OFFERS_FIELD_CODE'],
								'OFFERS_LIMIT' => $arParams['LIST_OFFERS_LIMIT'],
								'OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
								'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
								'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
								'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
								'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
								'OFFER_COLOR_PROP' => $arParams['OFFER_COLOR_PROP'],
								'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
								'PARTIAL_PRODUCT_PROPERTIES' => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
								'PICTURE_FROM_OFFER' => $arParams['PICTURE_FROM_OFFER'],
								'PRELOADER' => $arParams['PRELOADER'],
								'PRICE_CODE' => $arParams['PRICE_CODE'],
								'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
								'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
								'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],
								'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
								'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
								'PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'],
								'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
								'SECTION_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
								'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
								'USERS_COUNT' => $arResult['USERS_COUNT'],
								'USERS_COUNT_TEXT' => $arResult['USERS_COUNT_TEXT'],
								'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
								'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY']
						) );
			}
			$this->EndViewTarget();
		}
	}
}

?>
	</div>
</div>
<?
global $kitSeoMetaTitle;
global $kitSeoMetaKeywords;
global $kitSeoMetaDescription;
if( isset( $kitSeoMetaTitle ) && !empty( $kitSeoMetaTitle ) )
{
	$APPLICATION->SetPageProperty( 'title', $kitSeoMetaTitle );
}
if( isset( $kitSeoMetaKeywords ) && !empty( $kitSeoMetaKeywords ) )
{
	$APPLICATION->SetPageProperty( 'keywords', $kitSeoMetaKeywords );
}
if( isset( $kitSeoMetaDescription ) && !empty( $kitSeoMetaDescription ) )
{
	$APPLICATION->SetPageProperty( 'description', $kitSeoMetaDescription );
}
?>