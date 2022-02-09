<?
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;
if( !defined( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true )
	die();

if( !\Bitrix\Main\Loader::includeModule( 'sotbit.b2bshop' ))
{
	return false;
}

$this->setFrameMode( true );
?>
<div class='col-sm-24 sm-padding-no'>
<?
	$APPLICATION->IncludeComponent( 'bitrix:breadcrumb', 'ms_breadcrumb', array(
			'START_FROM' => '0',
			'PATH' => '',
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

<?
$ElementTemplate = Bitrix\Main\Config\Option::get( 'sotbit.b2bshop', 'ELEMENT_TEMPLATE', '.default' );
if( $ElementTemplate == 'other' )
{
	$ElementTemplate = Bitrix\Main\Config\Option::get( 'sotbit.b2bshop', 'ELEMENT_TEMPLATE_OTHER', '.default' );
}
?>

<div class='col-sm-24'>
	<div class='row detail_page_wrap no_preview <?=str_replace('.','',$ElementTemplate)?>'>
		<?
		if( isset( $_REQUEST['preview'] ) )
		{
			$GLOBALS['APPLICATION']->RestartBuffer();

			if( $ElementTemplate == '.default' )
			{
				$ElementTemplate = 'preview';
			}
			else
			{
				$ElementTemplate = 'preview_' . $ElementTemplate;
			}
		}


		$arDetailParams = array(
				'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
				'ADD_DETAIL_TO_SLIDER' => (isset( $arParams['DETAIL_ADD_DETAIL_TO_SLIDER'] ) ? $arParams['DETAIL_ADD_DETAIL_TO_SLIDER'] : ''),
				'ADD_ELEMENT_CHAIN' => (isset( $arParams['ADD_ELEMENT_CHAIN'] ) ? $arParams['ADD_ELEMENT_CHAIN'] : ''),
				'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
				'ADD_PROPERTIES_TO_BASKET' => (isset( $arParams['ADD_PROPERTIES_TO_BASKET'] ) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
				'ADD_SECTIONS_CHAIN' => (isset( $arParams['ADD_SECTIONS_CHAIN'] ) ? $arParams['ADD_SECTIONS_CHAIN'] : ''),
				'AVAILABLE_DELETE' => $arParams['AVAILABLE_DELETE'],
				'BASKET_URL' => $arParams['BASKET_URL'],
				'BIG_DATA_RCM_TYPE' => $arParams['BIG_DATA_RCM_TYPE'],
				'BLOG_URL' => (isset( $arParams['DETAIL_BLOG_URL'] ) ? $arParams['DETAIL_BLOG_URL'] : ''),
				'BLOG_USE' => (isset( $arParams['DETAIL_BLOG_USE'] ) ? $arParams['DETAIL_BLOG_USE'] : ''),
				'BRAND_PROP_CODE' => (isset( $arParams['DETAIL_BRAND_PROP_CODE'] ) ? $arParams['DETAIL_BRAND_PROP_CODE'] : ''),
				'BRAND_USE' => (isset( $arParams['DETAIL_BRAND_USE'] ) ? $arParams['DETAIL_BRAND_USE'] : 'N'),
				'BROWSER_TITLE' => $arParams['DETAIL_BROWSER_TITLE'],
				'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
				'CACHE_TIME' => $arParams['CACHE_TIME'],
				'CACHE_TYPE' => $arParams['CACHE_TYPE'],
				'COLOR_FROM_IMAGE' => $arParams['COLOR_FROM_IMAGE'],
				'COLOR_IMAGE_HEIGHT' => $arParams['COLOR_IMAGE_HEIGHT'],
				'COLOR_IMAGE_WIDTH' => $arParams['COLOR_IMAGE_WIDTH'],
				'COLOR_IN_PRODUCT' => $arParams['COLOR_IN_PRODUCT'],
				'COLOR_IN_PRODUCT_CODE' => $arParams['COLOR_IN_PRODUCT_CODE'],
				'COLOR_IN_PRODUCT_LINK' => $arParams['COLOR_IN_PRODUCT_LINK'],
				'COLOR_SLIDER_COUNT_IMAGES_HOR' => $arParams['COLOR_SLIDER_COUNT_IMAGES_HOR'],
				'COLOR_SLIDER_COUNT_IMAGES_VER' => $arParams['COLOR_SLIDER_COUNT_IMAGES_VER'],
				'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
				'CURRENCY_ID' => $arParams['CURRENCY_ID'],
				'DELETE_OFFER_NOIMAGE' => $arParams['DELETE_OFFER_NOIMAGE'],
				'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['element'],
				'DETAIL_HEIGHT_BIG' => $arParams['DETAIL_HEIGHT_BIG'],
				'DETAIL_HEIGHT_MEDIUM' => $arParams['DETAIL_HEIGHT_MEDIUM'],
				'DETAIL_HEIGHT_SMALL' => $arParams['DETAIL_HEIGHT_SMALL'],
				'DETAIL_PICTURE_MODE' => (isset( $arParams['DETAIL_DETAIL_PICTURE_MODE'] ) ? $arParams['DETAIL_DETAIL_PICTURE_MODE'] : ''),
				'DETAIL_WIDTH_BIG' => $arParams['DETAIL_WIDTH_BIG'],
				'DETAIL_WIDTH_MEDIUM' => $arParams['DETAIL_WIDTH_MEDIUM'],
				'DETAIL_WIDTH_SMALL' => $arParams['DETAIL_WIDTH_SMALL'],
				'DISPLAY_NAME' => (isset( $arParams['DETAIL_DISPLAY_NAME'] ) ? $arParams['DETAIL_DISPLAY_NAME'] : ''),
				'DISPLAY_PREVIEW_TEXT_MODE' => (isset( $arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE'] ) ? $arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE'] : ''),
				'ELEMENT_SORT_FIELD' => $arParams['ELEMENT_SORT_FIELD'],
				'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
				'ELEMENT_SORT_ORDER' => $arParams['ELEMENT_SORT_ORDER'],
				'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
				'FB_APP_ID' => (isset( $arParams['DETAIL_FB_APP_ID'] ) ? $arParams['DETAIL_FB_APP_ID'] : ''),
				'FB_USE' => (isset( $arParams['DETAIL_FB_USE'] ) ? $arParams['DETAIL_FB_USE'] : ''),
				'FILTER_NAME' => $arParams['FILTER_NAME'],
				'FLAG_PROPS' => $arParams['FLAG_PROPS'],
				'FULL_WIDTH_DESCRIPTION' => \Bitrix\Main\Config\Option::get( 'sotbit.b2bshop', 'FULL_WIDTH_DESCRIPTION', 'N' ),
				'GIFTS_DETAIL_BLOCK_TITLE' => $arParams['GIFTS_DETAIL_BLOCK_TITLE'],
				'GIFTS_DETAIL_HIDE_BLOCK_TITLE' => 'N',
				'GIFTS_DETAIL_PAGE_ELEMENT_COUNT' => '3',
				'GIFTS_DETAIL_TEXT_LABEL_GIFT' => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],
				'GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],
				'GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE' => 'N',
				'GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT' => '3',
				'GIFTS_MESS_BTN_BUY' => $arParams['GIFTS_MESS_BTN_BUY'],
				'GIFTS_SHOW_DISCOUNT_PERCENT' => 'Y',
				'GIFTS_SHOW_IMAGE' => 'Y',
				'GIFTS_SHOW_NAME' => 'Y',
				'GIFTS_SHOW_OLD_PRICE' => 'Y',
				'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
				'IBLOCK_ID' => $arParams['IBLOCK_ID'],
				'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
				'IMAGE_RESIZE_MODE' => $arParams['IMAGE_RESIZE_MODE'],
				'IS_FANCY' => $arParams['IS_FANCY'],
				'LABEL_PROP' => $arParams['LABEL_PROP'],
				'LINK_ELEMENTS_URL' => $arParams['LINK_ELEMENTS_URL'],
				'LINK_IBLOCK_ID' => $arParams['LINK_IBLOCK_ID'],
				'LINK_IBLOCK_TYPE' => $arParams['LINK_IBLOCK_TYPE'],
				'LINK_PROPERTY_SID' => $arParams['LINK_PROPERTY_SID'],
				'LIST_HEIGHT_MEDIUM' => $arParams['LIST_HEIGHT_MEDIUM'],
				'LIST_HEIGHT_SMALL' => $arParams['LIST_HEIGHT_SMALL'],
				'LIST_WIDTH_MEDIUM' => $arParams['LIST_WIDTH_MEDIUM'],
				'LIST_WIDTH_SMALL' => $arParams['LIST_WIDTH_SMALL'],
				'MANUFACTURER_ELEMENT_PROPS' => $arParams['MANUFACTURER_ELEMENT_PROPS'],
				'MANUFACTURER_LIST_PROPS' => $arParams['MANUFACTURER_LIST_PROPS'],
				'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
				'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
				'MESS_BTN_COMPARE' => $arParams['MESS_BTN_COMPARE'],
				'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
				'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
				'META_DESCRIPTION' => $arParams['DETAIL_META_DESCRIPTION'],
				'META_KEYWORDS' => $arParams['DETAIL_META_KEYWORDS'],
				'MODIFICATION' => $arParams['MODIFICATION'],
				'MODIFICATION_COUNT' => $arParams['MODIFICATION_COUNT'],
				'MORE_PHOTO_OFFER_PROPS' => $arParams['MORE_PHOTO_OFFER_PROPS'],
				'MORE_PHOTO_PRODUCT_PROPS' => $arParams['MORE_PHOTO_PRODUCT_PROPS'],
				'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
				'OFFERS_FIELD_CODE' => (is_array( $arParams['OFFER_ELEMENT_PROPS'] )) ? $arParams['DETAIL_OFFERS_FIELD_CODE'] + $arParams['OFFER_ELEMENT_PROPS'] : $arParams['DETAIL_OFFERS_FIELD_CODE'], // $arParams['DETAIL_OFFERS_FIELD_CODE'],//
				'OFFERS_PROPERTY_CODE' => $arParams['DETAIL_OFFERS_PROPERTY_CODE'],
				'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
				'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
				'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
				'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
				'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
				'OFFER_COLOR_PROP' => $arParams['OFFER_COLOR_PROP'],
				'OFFER_TREE_PROPS' => (is_array( $arParams['OFFER_ELEMENT_PARAMS'] )) ? $arParams['OFFER_TREE_PROPS'] + $arParams['OFFER_ELEMENT_PARAMS'] : $arParams['OFFER_TREE_PROPS'], // $arParams['OFFER_TREE_PROPS'],
				'PARTIAL_PRODUCT_PROPERTIES' => (isset( $arParams['PARTIAL_PRODUCT_PROPERTIES'] ) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
				'PICTURE_FROM_OFFER' => $arParams['PICTURE_FROM_OFFER'],
				'PRELOADER' => $arParams['PRELOADER'],
				'PRICE_CODE' => $arParams['PRICE_CODE'],
				'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
				'PRICE_VAT_SHOW_VALUE' => $arParams['PRICE_VAT_SHOW_VALUE'],
				'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
				'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],
				'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
				'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
				'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
				'PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
				'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
				'SET_STATUS_404' => $arParams['SET_STATUS_404'],
				'SET_TITLE' => $arParams['SET_TITLE'],
				'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
				'SHOW_MAX_QUANTITY' => $arParams['DETAIL_SHOW_MAX_QUANTITY'],
				'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
				'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
				'TEL_DELIVERY_ID' => $arParams['TEL_DELIVERY_ID'],
				'TEL_MASK' => $arParams['TEL_MASK'],
				'TEL_PAY_SYSTEM_ID' => $arParams['TEL_PAY_SYSTEM_ID'],
				'TEMPLATE_THEME' => (isset( $arParams['TEMPLATE_THEME'] ) ? $arParams['TEMPLATE_THEME'] : ''),
				'USE_COMMENTS' => $arParams['DETAIL_USE_COMMENTS'],
				'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
				'USE_GIFTS_DETAIL' => 'Y',
				'USE_GIFTS_MAIN_PR_SECTION_LIST' => 'Y',
				'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
				'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
				'USE_VOTE_RATING' => $arParams['DETAIL_USE_VOTE_RATING'],
				'VK_API_ID' => (isset( $arParams['DETAIL_VK_API_ID'] ) ? $arParams['DETAIL_VK_API_ID'] : 'API_ID'),
				'VK_USE' => (isset( $arParams['DETAIL_VK_USE'] ) ? $arParams['DETAIL_VK_USE'] : ''),
				'VOTE_DISPLAY_AS_RATING' => (isset( $arParams['DETAIL_VOTE_DISPLAY_AS_RATING'] ) ? $arParams['DETAIL_VOTE_DISPLAY_AS_RATING'] : ''),
		);


		$ElementID = $APPLICATION->IncludeComponent( 'bitrix:catalog.element', $ElementTemplate,
				array_merge( $arDetailParams,
						array(
								'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
								'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
								'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
								'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
								'SECTION_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
								'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['element']
						) ), $component );
		if( !$_COOKIE['ms_viewed_products'] )
		{
			setcookie( 'ms_viewed_products[0]', $ElementID, strtotime( '+30 days' ), '/' );
		}
		else
		{
			$key = max( array_keys( $_COOKIE['ms_viewed_products'] ) ) + 1;
			setcookie( 'ms_viewed_products[' . $key . ']', $ElementID, strtotime( '+30 days' ), '/' );
			unset( $key );
		}

		if( isset( $_REQUEST['preview'] ) )
		{
			die();
		}

		$APPLICATION->IncludeComponent( 'sotbit:reviews', 'bootstrap',
				Array(
						'ADD_REVIEW_PLACE' => '1',
						'AJAX_MODE' => 'Y',
						'BUTTON_BACKGROUND' => "url('". SITE_DIR . "bitrix/components/sotbit/reviews.comments.add/templates/bootstrap/images/button.jpg') left top no-repeat #dbbfb9",
						'CACHE_TIME' => '36000000',
						'CACHE_TYPE' => 'A',
						'COMMENTS_TEXTBOX_MAXLENGTH' => '200',
						'DATE_FORMAT' => 'd.m.Y H:i:s',
						'DEFAULT_RATING_ACTIVE' => '3',
						'FIRST_ACTIVE' => '1',
						'ID_ELEMENT' => $ElementID,
						'INIT_JQUERY' => 'N',
						'MAX_RATING' => '5',
						'NOTICE_EMAIL' => '',
						'PRIMARY_COLOR' => '#a76e6e',
						'QUESTIONS_TEXTBOX_MAXLENGTH' => '200',
						'REVIEWS_TEXTBOX_MAXLENGTH' => '200',
						'SHOW_COMMENTS' => 'Y',
						'SHOW_QUESTIONS' => 'Y',
						'SHOW_REVIEWS' => 'Y'
				) );
		?>
	</div>
	<?
	if( isset( $_REQUEST['bxajaxid'] ) )
	{
		return false;
	}
	if( !defined( 'ERROR_404' ) )
	{
		$result = \Bitrix\Iblock\ElementTable::getList(array(
				'select' => array('IBLOCK_SECTION_ID'),
				'filter' => array('ID' => $ElementID),
				'limit' => 1
		));
		if($Element = $result->fetch())
		{
			$idSection = $Element['IBLOCK_SECTION_ID'];
		}
		if(\Bitrix\Main\Config\Option::get('sotbit.b2bshop', 'SHOW_YOU_LOOK_ELEMENT_UNDER','Y') == 'Y')
		{
			$this->SetViewTarget( 'ms_product_view_detail' );
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

				unset($result, $Element);
				$colorCode = ($arParams['COLOR_IN_PRODUCT'] == 'Y' && $arParams['COLOR_IN_PRODUCT_CODE']) ? $arParams['COLOR_IN_PRODUCT_CODE'] : $arParams['OFFER_COLOR_PROP'];
				$APPLICATION->IncludeComponent( 'bitrix:catalog.top', 'catalog_viewed_products_element',
						array(
								'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
								'ADD_PROPERTIES_TO_BASKET' => 'N',
								'AJAX_PRODUCT_LOAD' => $arParams['AJAX_PRODUCT_LOAD'],
								'AVAILABLE_DELETE' => $arParams['AVAILABLE_DELETE'],
								'BANNER_ID' => $ElementID,
								'BANNER_SECTION_ID' => $idSection,
								'BASKET_URL' => '',
								'CACHE_FILTER' => $arParams['CACHE_FILTER'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],
								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'COLOR_IN_PRODUCT' => $arParams['COLOR_IN_PRODUCT'],
								'COLOR_IN_PRODUCT_CODE' => $arParams['COLOR_IN_PRODUCT_CODE'],
								'COLOR_IN_PRODUCT_LINK' => $arParams['COLOR_IN_PRODUCT_LINK'],
								'COLOR_IN_SECTION_LINK' => $arParams['COLOR_IN_SECTION_LINK'],
								'CONVERT_CURRENCY' => 'N',
								'CURRENCY_ID' => '',
								'DELETE_OFFER_NOIMAGE' => $arParams['DELETE_OFFER_NOIMAGE'],
								'DETAIL_HEIGHT_BIG' => $arParams['DETAIL_HEIGHT_BIG'],
								'DETAIL_HEIGHT_MEDIUM' => $arParams['DETAIL_HEIGHT_MEDIUM'],
								'DETAIL_HEIGHT_SMALL' => $arParams['DETAIL_HEIGHT_SMALL'],
								'DETAIL_PROPERTY_CODE' => array(),
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
								'FLAG_PROPS' => array(),
								'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],
								'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
								'IMAGE_RESIZE_MODE' => $arParams['IMAGE_RESIZE_MODE'],
								'LAZY_LOAD' => $arParams['LAZY_LOAD'],
								'LINE_ELEMENT_COUNT' => $arParams['LINE_ELEMENT_COUNT'],
								'LIST_HEIGHT_MEDIUM' => $arParams['LIST_HEIGHT_MEDIUM'],
								'LIST_HEIGHT_SMALL' => 171,
								'LIST_WIDTH_MEDIUM' => $arParams['LIST_WIDTH_MEDIUM'],
								'LIST_WIDTH_SMALL' => 131,
								'MANUFACTURER_ELEMENT_PROPS' => '',
								'MANUFACTURER_LIST_PROPS' => '',
								'MORE_PHOTO_OFFER_PROPS' => $arParams['MORE_PHOTO_OFFER_PROPS'],
								'MORE_PHOTO_PRODUCT_PROPS' => $arParams['MORE_PHOTO_PRODUCT_PROPS'],
								'OFFERS_CART_PROPERTIES' => array(),
								'OFFERS_FIELD_CODE' => array(0=>"NAME",1=>"PREVIEW_PICTURE",2=>"DETAIL_PICTURE",3=>""),
								'OFFERS_LIMIT' => $arParams['LIST_OFFERS_LIMIT'],
								'OFFERS_PROPERTY_CODE' => array($colorCode),
								'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
								'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
								'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
								'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
								'OFFER_COLOR_PROP' => $arParams['OFFER_COLOR_PROP'],
								'OFFER_TREE_PROPS' => array(),
								'PARTIAL_PRODUCT_PROPERTIES' => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
								'PICTURE_FROM_OFFER' => $arParams['PICTURE_FROM_OFFER'],
								'PRELOADER' => $arParams['PRELOADER'],
								'PRICE_CODE' => array(),
								'PRICE_VAT_INCLUDE' => 'N',
								'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
								'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],
								'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
								'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
								'PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'],
								'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
								'SECTION_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
								'SHOW_PRICE_COUNT' => 'N',
								'TITLE' => Loc::getMessage( 'B2BS_CATALOG_ELEMENT_IAM_VIEW_TITLE' ),
								'USERS_COUNT' => $arResult['USERS_COUNT'],
								'USERS_COUNT_TEXT' => $arResult['USERS_COUNT_TEXT'],
								'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
								'USE_PRODUCT_QUANTITY' => 'N',
						) );
			}
			$this->EndViewTarget();
		}
		$context = \Bitrix\Main\Application::getInstance()->getContext();
		$server = $context->getServer();
		if(\Bitrix\Main\Config\Option::get('sotbit.b2bshop', 'SHOW_BIG_DATA_ELEMENT_UNDER','Y') == 'Y' && \Bitrix\Main\Config\Option::get('main', 'gather_catalog_stat','N') == 'Y' && is_dir($server->getDocumentRoot().$server->getPersonalRoot().'/components/bitrix/catalog.bigdata.products'))
		{
			$mxResult = CCatalogSKU::GetInfoByProductIBlock( $arParams['IBLOCK_ID'] );
			if( is_array( $mxResult ) )
			{
				$offersIblock = $mxResult['IBLOCK_ID'];
			}
			unset($mxResult);
			$this->SetViewTarget( 'ms_big_data_detail' );

			$APPLICATION->IncludeComponent( 'bitrix:catalog.bigdata.products', 'element',
					Array(
							'ACTION_VARIABLE' => 'action_cbdp',
							'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
							'AJAX_PRODUCT_LOAD' => $arParams['AJAX_PRODUCT_LOAD'],
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
							'ID' => $ElementID,
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
							'PRELOADER' => $arParams['PRELOADER'],
							'PRICE_CODE' => $arParams['PRICE_CODE'],
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
							'SECTION_ID' => $idSection,
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
?>