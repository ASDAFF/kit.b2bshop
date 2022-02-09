<?php

namespace Sotbit\B2BShop\Base\Shop;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
/**
 *
 * @author Sergey Danilkin < s.danilkin@sotbit.ru >
 *
 */
class Opt
{
	/**
	 *
	 * @var boolean
	 */
	protected static $hasAccess;

	/**
	 * check user access to b2b
	 * @param array $userGroups
	 */
	public function hasAccess()
	{
		if(self::$hasAccess === NULL)
		{
			global $USER;
			$userGroups = $USER->GetGroups();
			$userGroups = explode(',', $userGroups);
			self::$hasAccess = false;
			if(Loader::includeModule('sotbit.b2bshop'))
			{
				$groups = unserialize(Option::get("sotbit.b2bshop", "OPT_BLANK_GROUPS", ""));
				if(!is_array($groups))
				{
					$groups = [];
				}
				self::$hasAccess = array_intersect($groups, $userGroups);
			}
		}

		return self::$hasAccess;
	}

	/**
	 * @return array
	 * @throws \Bitrix\Main\ArgumentNullException
	 * @throws \Bitrix\Main\ArgumentOutOfRangeException
	 */
	public function getBlankParams()
	{
		return [
			"ACTION_VARIABLE" => "action",
			"ADD_ELEMENT_CHAIN" => "Y",
			"ADD_PICT_PROP" => "-",
			"ADD_PROPERTIES_TO_BASKET" => "Y",
			"ADD_SECTIONS_CHAIN" => "Y",
			"AJAX_MODE" => "Y",
			"AJAX_OPTION_ADDITIONAL" => "",
			"AJAX_OPTION_HISTORY" => "Y",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_PRODUCT_LOAD" => Option::get("sotbit.b2bshop", "AJAX_PRODUCT_LOAD", ""),
			"ALSO_BUY_ELEMENT_COUNT" => "3",
			"ALSO_BUY_MIN_BUYES" => "2",
			"AVAILABLE_DELETE" => Option::get("sotbit.b2bshop", "AVAILABLE_DELETE", "N"),
			"BASKET_URL" => Option::get("sotbit.b2bshop", "URL_CART", ""),
			'BIG_DATA_RCM_TYPE' => 'personal',
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "Y",
			"CACHE_TIME" => "36000000",
			"CACHE_TYPE" => "A",
			"COLOR_FROM_IMAGE" => Option::get("sotbit.b2bshop", "COLOR_FROM_IMAGE", "Y"),
			"COLOR_IMAGE_HEIGHT" => Option::get("sotbit.b2bshop", "COLOR_IMAGE_HEIGHT", "100"),
			"COLOR_IMAGE_WIDTH" => Option::get("sotbit.b2bshop", "COLOR_IMAGE_WIDTH", "37"),
			"COLOR_IN_PRODUCT" => Option::get("sotbit.b2bshop", "COLOR_IN_PRODUCT", ""),
			"COLOR_IN_PRODUCT_CODE" => Option::get("sotbit.b2bshop", "COLOR_IN_PRODUCT_CODE", ""),
			"COLOR_IN_PRODUCT_LINK" => Option::get("sotbit.b2bshop", "COLOR_IN_PRODUCT_LINK", ""),
			"COLOR_IN_SECTION_LINK" => Option::get("sotbit.b2bshop", "COLOR_IN_SECTION_LINK", "1"),
			"COLOR_IN_SECTION_LINK_MAIN" => Option::get("sotbit.b2bshop", "COLOR_IN_SECTION_LINK_MAIN", ""),
			"COLOR_SLIDER_COUNT_IMAGES_HOR" => Option::get("sotbit.b2bshop", "COLOR_SLIDER_COUNT_IMAGES_HOR", "0"),
			"COLOR_SLIDER_COUNT_IMAGES_VER" => Option::get("sotbit.b2bshop", "COLOR_SLIDER_COUNT_IMAGES_VER", "0"),
			"CONVERT_CURRENCY" => "Y",
			"CURRENCY_ID" => "",
			"DELETE_OFFER_NOIMAGE" => Option::get("sotbit.b2bshop", "DELETE_OFFER_NOIMAGE", ""),
			"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",
			"DETAIL_BACKGROUND_IMAGE" => "-",
			"DETAIL_BRAND_USE" => "N",
			"DETAIL_BROWSER_TITLE" => "-",
			"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
			"DETAIL_DETAIL_PICTURE_MODE" => "IMG",
			"DETAIL_DISPLAY_NAME" => "Y",
			"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",
			"DETAIL_HEIGHT_BIG" => Option::get("sotbit.b2bshop", "DETAIL_HEIGHT_BIG", ""),
			"DETAIL_HEIGHT_MEDIUM" => Option::get("sotbit.b2bshop", "DETAIL_HEIGHT_MEDIUM", ""),
			"DETAIL_HEIGHT_SMALL" => Option::get("sotbit.b2bshop", "DETAIL_HEIGHT_SMALL", ""),
			"DETAIL_META_DESCRIPTION" => "-",
			"DETAIL_META_KEYWORDS" => "-",
			"DETAIL_OFFERS_FIELD_CODE" => [0 => "NAME"],
			"DETAIL_OFFERS_PROPERTY_CODE" => unserialize(Option::get("sotbit.b2bshop", "OPT_OFFER_TREE_PROPS", "")),
			"DETAIL_PROPERTY_CODE" => unserialize(Option::get("sotbit.b2bshop", "ALL_PROPS", "")),
			"DETAIL_SET_CANONICAL_URL" => "N",
			"DETAIL_SET_VIEWED_IN_COMPONENT" => "N",
			"DETAIL_SHOW_MAX_QUANTITY" => "N",
			"DETAIL_USE_COMMENTS" => "N",
			"DETAIL_USE_VOTE_RATING" => "N",
			"DETAIL_WIDTH_BIG" => Option::get("sotbit.b2bshop", "DETAIL_WIDTH_BIG", ""),
			"DETAIL_WIDTH_MEDIUM" => Option::get("sotbit.b2bshop", "DETAIL_WIDTH_MEDIUM", ""),
			"DETAIL_WIDTH_SMALL" => Option::get("sotbit.b2bshop", "DETAIL_WIDTH_SMALL", ""),
			"DISABLE_INIT_JS_IN_COMPONENT" => "N",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"DISPLAY_TOP_PAGER" => "Y",
			"ELEMENT_SORT_FIELD" => "IBLOCK_SECTION_ID",
			"ELEMENT_SORT_FIELD2" => "name",
			"ELEMENT_SORT_ORDER" => "asc",
			"ELEMENT_SORT_ORDER2" => "asc",
			"FIELDS" => [
				"",
				""
			],
			"FILTER_FIELD_CODE" => [
				"",
				""
			],
			"FILTER_ITEM_COUNT" => Option::get("sotbit.b2bshop", "FILTER_ITEM_COUNT", ""),
			"FILTER_NAME" => "blankFilter",
			"FILTER_OFFERS_FIELD_CODE" => [
				0 => "PREVIEW_PICTURE",
				1 => "DETAIL_PICTURE",
				2 => ""
			],
			"FILTER_OFFERS_PROPERTY_CODE" => [
				0 => "",
				1 => ""
			],
			"FILTER_PRICE_CODE" => unserialize(Option::get("sotbit.b2bshop", "PRICE_CODE", "")),
			"FILTER_PROPERTY_CODE" => [
				"",
				""
			],
			"FILTER_VIEW_MODE" => "VERTICAL",
			"FLAG_PROPS" => unserialize(Option::get("sotbit.b2bshop", "FLAG_PROPS", "")),
			"FORUM_ID" => "1",
			"GIFTS_DETAIL_BLOCK_TITLE" => Loc::getMessage("GIFTS_DETAIL_BLOCK_TITLE"),
			"GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
			"GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "3",
			"GIFTS_DETAIL_TEXT_LABEL_GIFT" => Loc::getMessage("GIFTS_DETAIL_TEXT_LABEL_GIFT"),
			"GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => Loc::getMessage("GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE"),
			"GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
			"GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "3",
			"GIFTS_MESS_BTN_BUY" => Loc::getMessage("GIFTS_MESS_BTN_BUY"),
			"GIFTS_SECTION_LIST_BLOCK_TITLE" => Loc::getMessage("GIFTS_SECTION_LIST_BLOCK_TITLE"),
			"GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE" => "N",
			"GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT" => "3",
			"GIFTS_SECTION_LIST_TEXT_LABEL_GIFT" => Loc::getMessage("GIFTS_SECTION_LIST_TEXT_LABEL_GIFT"),
			"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
			"GIFTS_SHOW_IMAGE" => "Y",
			"GIFTS_SHOW_NAME" => "Y",
			"GIFTS_SHOW_OLD_PRICE" => "Y",
			"HIDE_NOT_AVAILABLE" => "N",
			"IBLOCK_ID" => Option::get("sotbit.b2bshop", "OPT_IBLOCK_ID", ""),
			"IBLOCK_TYPE" => Option::get("sotbit.b2bshop", "OPT_IBLOCK_TYPE", ""),
			"IMAGE_RESIZE_MODE" => Option::get("sotbit.b2bshop", "IMAGE_RESIZE_MODE", BX_RESIZE_IMAGE_PROPORTIONAL),
			"INCLUDE_SUBSECTIONS" => "Y",
			"IS_FANCY" => Option::get("sotbit.b2bshop", "IS_FANCY", ""),
			"LABEL_PROP" => "-",
			"LAZY_LOAD" => Option::get("sotbit.b2bshop", "LAZY_LOAD", ""),
			"LINE_ELEMENT_COUNT" => "3",
			"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
			"LINK_IBLOCK_ID" => "",
			"LINK_IBLOCK_TYPE" => "",
			"LINK_PROPERTY_SID" => "",
			"LIST_BROWSER_TITLE" => "-",
			"LIST_HEIGHT_MEDIUM" => Option::get("sotbit.b2bshop", "LIST_HEIGHT_MEDIUM", ""),
			"LIST_HEIGHT_SMALL" => Option::get("sotbit.b2bshop", "LIST_HEIGHT_SMALL", ""),
			"LIST_META_DESCRIPTION" => "-",
			"LIST_META_KEYWORDS" => "-",
			"LIST_OFFERS_FIELD_CODE" => [
				0 => "NAME",
				1 => "PREVIEW_PICTURE",
				2 => "DETAIL_PICTURE",
				3 => "CODE",
				4 => "XML_ID"
			],
			"LIST_OFFERS_LIMIT" => "0",
			"LIST_OFFERS_PROPERTY_CODE" => unserialize(Option::get("sotbit.b2bshop", "OPT_PROPS", "")),
			"LIST_PROPERTY_CODE" => [
				"",
				"NEWPRODUCT",
				"SALELEADER",
				"SPECIALOFFER"
			],
			"LIST_WIDTH_MEDIUM" => Option::get("sotbit.b2bshop", "LIST_WIDTH_MEDIUM", ""),
			"LIST_WIDTH_SMALL" => Option::get("sotbit.b2bshop", "LIST_WIDTH_SMALL", ""),
			"MAILING_CATEGORIES_ID" => [],
			"MAILING_EMAIL_SEND_END" => Loc::getMessage("MAILING_EMAIL_SEND_END"),
			"MAILING_INFO_TEXT" => Loc::getMessage("MAILING_INFO_TEXT"),
			"MAIN_TITLE" => Loc::getMessage("MAIN_TITLE"),
			"MANUFACTURER_ELEMENT_PROPS" => Option::get("sotbit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", ""),
			"MANUFACTURER_LIST_PROPS" => Option::get("sotbit.b2bshop", "MANUFACTURER_LIST_PROPS", ""),
			"MESSAGES_PER_PAGE" => "10",
			"MESSAGE_404" => "",
			"MESS_BTN_ADD_TO_BASKET" => Loc::getMessage("MESS_BTN_ADD_TO_BASKET"),
			"MESS_BTN_BUY" => Loc::getMessage("MESS_BTN_BUY"),
			"MESS_BTN_COMPARE" => Loc::getMessage("MESS_BTN_COMPARE"),
			"MESS_BTN_DETAIL" => Loc::getMessage("MESS_BTN_DETAIL"),
			"MESS_NOT_AVAILABLE" => Loc::getMessage("MESS_NOT_AVAILABLE"),
			"MODIFICATION" => Option::get("sotbit.b2bshop", "MODIFICATION", ""),
			"MODIFICATION_COUNT" => Option::get("sotbit.b2bshop", "MODIFICATION_COUNT", "4"),
			"MORE_PHOTO_OFFER_PROPS" => Option::get("sotbit.b2bshop", "MORE_PHOTO_OFFER_PROPS", ""),
			"MORE_PHOTO_PRODUCT_PROPS" => Option::get("sotbit.b2bshop", "MORE_PHOTO_PRODUCT_PROPS", ""),
			"OFFERS_CART_PROPERTIES" => unserialize(Option::get("sotbit.b2bshop", "OPT_OFFER_TREE_PROPS", "")),
			"OFFERS_SORT_FIELD" => "sort",
			"OFFERS_SORT_FIELD2" => "id",
			"OFFERS_SORT_ORDER" => "asc",
			"OFFERS_SORT_ORDER2" => "desc",
			"OFFER_ADD_PICT_PROP" => "-",
			"OFFER_COLOR_PROP" => Option::get("sotbit.b2bshop", "OFFER_COLOR_PROP", ""),
			"OFFER_ELEMENT_PARAMS" => unserialize(Option::get("sotbit.b2bshop", "OFFER_ELEMENT_PARAMS", "")),
			"OFFER_ELEMENT_PROPS" => unserialize(Option::get("sotbit.b2bshop", "OFFER_ELEMENT_PROPS", "")),
			"OFFER_TREE_PROPS" => unserialize(Option::get("sotbit.b2bshop", "OPT_PROPS", "")),
			'OPT_FILTER_PROPERTIES' => unserialize(Option::get("sotbit.b2bshop", "OPT_FILTER_FIELDS", "")),
			'OPT_ARTICUL_PROPERTY' => Option::get("sotbit.b2bshop", "OPT_ARTICUL_PROP", ""),
			'OPT_ARTICUL_PROPERTY_OFFER' => Option::get("sotbit.b2bshop", "OPT_ARTICUL_PROP_OFFER", ""),
			'OPT_UNIQUE_PROP' => Option::get("sotbit.b2bshop", "OPT_UNIQUE_PROP", "CODE"),
			"PAGER_BASE_LINK_ENABLE" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => "catalog",
			"PAGER_TITLE" => Loc::getMessage("PAGER_TITLE"),
			"PAGE_ELEMENT_COUNT" => Option::get("sotbit.b2bshop", "CATALOG_LIST_COUNT", "12"),
			"PAGE_ELEMENT_COUNT_IN_ROW" => Option::get("sotbit.b2bshop", "CATALOG_LIST_COUNT_IN_ROW", "4"),
			"PARTIAL_PRODUCT_PROPERTIES" => "Y",
			"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
			"PICTURE_FROM_OFFER" => Option::get("sotbit.b2bshop", "PICTURE_FROM_OFFER", ""),
			"PRELOADER" => Option::get("sotbit.preloader", "IMAGE", ""),
			"PRICE_CODE" => ($_SESSION["SOTBIT_REGIONS"]["PRICE_CODE"] && Option::get("sotbit.b2bshop", "USE_MULTIREGIONS", "Y") == 'Y')
				? $_SESSION["SOTBIT_REGIONS"]["PRICE_CODE"] : unserialize(Option::get("sotbit.b2bshop", "PRICE_CODE", "")),
			"PRICE_VAT_INCLUDE" => "Y",
			"PRICE_VAT_SHOW_VALUE" => "N",
			"PRODUCT_DISPLAY_MODE" => "N",
			"PRODUCT_ID_VARIABLE" => "id",
			"PRODUCT_PROPERTIES" => [],
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"PRODUCT_QUANTITY_VARIABLE" => "quantity",
			"REVIEW_AJAX_POST" => "Y",
			"SECTIONS_SHOW_PARENT_NAME" => "Y",
			"SECTIONS_VIEW_MODE" => "LIST",
			"SECTION_BACKGROUND_IMAGE" => "-",
			"SECTION_COUNT_ELEMENTS" => "N",
			"SECTION_ID_VARIABLE" => "SECTION_ID",
			"SECTION_TOP_DEPTH" => "1",
			"SEF_FOLDER" => "/personal/b2b/blank_zakaza/",
			"SEF_MODE" => "Y",
			"SEF_URL_TEMPLATES" => [
				"compare" => "compare/",
				"element" => "#SECTION_CODE#/#ELEMENT_CODE#/",
				"section" => "#SECTION_CODE#/",
				"sections" => "",
				"smart_filter" => "#SECTION_CODE#/filter/#SMART_FILTER_PATH#/apply/"
			],
			'SEOMETA_TAGS' => Option::get("sotbit.b2bshop", "SEOMETA_TAGS", "BOTTOM"),
			"SET_BROWSER_TITLE" => "Y",
			"SET_LAST_MODIFIED" => "N",
			"SET_META_DESCRIPTION" => "Y",
			"SET_META_KEYWORDS" => "Y",
			"SET_STATUS_404" => "Y",
			"SET_TITLE" => "Y",
			"SHOW_404" => "Y",
			"SHOW_DEACTIVATED" => "N",
			"SHOW_DISCOUNT_PERCENT" => "N",
			"SHOW_EMPTY_STORE" => "Y",
			"SHOW_GENERAL_STORE_INFORMATION" => "N",
			"SHOW_LINK_TO_FORUM" => "Y",
			"SHOW_OLD_PRICE" => "N",
			"SHOW_PRICE_COUNT" => "1",
			"SHOW_TOP_ELEMENTS" => "N",
			"STORES" => [],
			"STORE_PATH" => "/store/#store_id#",
			"TEL_DELIVERY_ID" => Option::get("sotbit.b2bshop", "TEL_DELIVERY_ID", ""),
			"TEL_MASK" => Option::get("sotbit.b2bshop", "TEL_MASK", "+7(999)999-99-99"),
			"TEL_PAY_SYSTEM_ID" => Option::get("sotbit.b2bshop", "TEL_PAY_SYSTEM_ID", ""),
			"TEMPLATE_THEME" => "blue",
			"URL_TEMPLATES_READ" => "",
			"USER_FIELDS" => [
				"",
				""
			],
			"USE_ALSO_BUY" => "Y",
			'USE_BIG_DATA' => 'Y',
			'USE_BRICKS' => Option::get("sotbit.b2bshop", "SHOW_BRICKS", "N"),
			"USE_CAPTCHA" => "Y",
			"USE_COMPARE" => "N",
			"USE_ELEMENT_COUNTER" => "Y",
			"USE_FILTER" => "Y",
			"USE_GIFTS_DETAIL" => "Y",
			"USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",
			"USE_GIFTS_SECTION" => "Y",
			"USE_MAIN_ELEMENT_SECTION" => "N",
			"USE_MIN_AMOUNT" => "N",
			"USE_PRICE_COUNT" => "N",
			"USE_PRODUCT_QUANTITY" => "Y",
			"USE_REVIEW" => "Y",
			"USE_STORE" => "Y",
			"USE_STORE_PHONE" => "Y",
			"USE_STORE_SCHEDULE" => "Y"
		];
	}
}