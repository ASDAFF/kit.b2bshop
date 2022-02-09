<?php 
global $APPLICATION;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
if(!Loader::includeModule('kit.b2bshop'))
{
	return;
}
$Template = new \Kit\B2BShop\Client\Template\Main();
$priceCode=unserialize(Option::get("kit.b2bshop", "PRICE_CODE", ""));
$iblockType = Option::get("kit.b2bshop", "IBLOCK_TYPE", "");
$iblockId = Option::get("kit.b2bshop", "IBLOCK_ID", "");
if(!is_array($priceCode))
{
	$priceCode = array();
}
?>
<div class="header bootstrap_style" id="header">
	<div class="header-top">
		<div class="container">
			<div class="row">
				<div class="col-sm-24 xs-padding-no">
					<div class="header-top__wrapper">
						<div class="logo">
							<a href="<?=SITE_DIR?>">
								<img 
									class="logo-miss" 
									src="<?=Option::get("kit.b2bshop", "LOGO", "")?>"
									width="534" 
									height="208" 
									title="<?=$Template->getSiteName()?>" 
									alt="<?=$Template->getSiteName()?>"
								/>
							</a>
						</div>
						<div class="header-contacts-info">
							<div class="header-top-block-left">
								<div class="title">
									<?$APPLICATION->IncludeFile(SITE_DIR."/include/miss-header-phone-title.php",
										Array(),
										Array("MODE"=>"html")
									);?>
								</div>
								<div class="wrap-phone">
									<?=Option::get("kit.b2bshop", "TEL", "")?>
								</div>
							</div>
							<div class="wrap-address">
								<?$APPLICATION->IncludeFile(SITE_DIR."/include/miss-header-address.php",
									Array(),
									Array("MODE"=>"html")
								);?>
							</div>
						</div>
						<div class="header-top-block-right">
							<div class="header-top-block-right__wrapper">
								<div class="wrap-top-block-right1">
									<?
									$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line","b2b_header_basket",Array(
											"PATH_TO_BASKET" => Option::get("kit.b2bshop", "URL_CART", ""),
											"PATH_TO_PERSONAL" => SITE_DIR."personal/",
											"SHOW_PERSONAL_LINK" => "N",
											"HIDE_ON_BASKET_PAGES"=>"N",
											"SHOW_NUM_PRODUCTS" => "Y",
											"SHOW_TOTAL_PRICE" => "N",
											"SHOW_EMPTY_VALUES" => "Y",
											"SHOW_PRODUCTS" => "Y",
											"POSITION_FIXED" => "Y",
											"POSITION_HORIZONTAL" => "right",
											"POSITION_VERTICAL" => "top",
											"PATH_TO_ORDER" => Option::get("kit.b2bshop", "URL_ORDER", ""),
											"SHOW_DELAY" => "N",
											"SHOW_AUTHOR" => "Y",
											"SHOW_NOTAVAIL" => "N",
											"SHOW_SUBSCRIBE" => "N",
											"SHOW_IMAGE" => "N",
											"SHOW_PRICE" => "N",
											"SHOW_SUMMARY" => "N"
										)
									);?>
								</div>
								<?
								$APPLICATION->IncludeComponent(
									"bitrix:search.title",
									"miss_header_search",
									array(
										"NUM_CATEGORIES" => "1",
										"TOP_COUNT" => "5",
										"ORDER" => "date",
										"USE_LANGUAGE_GUESS" => "Y",
										"CHECK_DATES" => "N",
										"SHOW_OTHERS" => "N",
										"PAGE" => SITE_DIR."catalog/",
										"CATEGORY_0_TITLE" => Loc::getMessage("SEARCH_GOODS"),
										"CATEGORY_0" => array(
											0 => "iblock_".$iblockType,
										),
										"SHOW_INPUT" => "Y",
										"INPUT_ID" => "title-search-input",
										"CONTAINER_ID" => "search",
										"PRICE_CODE" => $priceCode,
										"PRICE_VAT_INCLUDE" => "Y",
										"PREVIEW_TRUNCATE_LEN" => "",
										"SHOW_PREVIEW" => "Y",
										"PREVIEW_WIDTH" => "36",
										"PREVIEW_HEIGHT" => "50",
										"CONVERT_CURRENCY" => "Y",
										"CURRENCY_ID" => "",
										"CATEGORY_0_iblock_".$iblockType => array(
											0 => $iblockId,
										),
										"COMPONENT_TEMPLATE" => "miss_header_search",
									),
									false
								);?>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="b2b-top-menu">
			<div>
				<?
				$APPLICATION->IncludeComponent(
					"bitrix:menu",
					"b2b_main",
					array(
						"ROOT_MENU_TYPE" => "top",
						"MENU_CACHE_TYPE" => "A",
						"MENU_CACHE_TIME" => "36000000",
						"MENU_CACHE_USE_GROUPS" => "N",
						"MENU_CACHE_GET_VARS" => array(
						),
						"MAX_LEVEL" => "2",
						"CHILD_MENU_TYPE" => "top_sub",
						"USE_EXT" => "Y",
						"DELAY" => "N",
						"ALLOW_MULTI_SELECT" => "N",
						"COMPONENT_TEMPLATE" => "ms_top",
						"PROP_BANNER_TYPE_VIEW" => "top",
						"IBLOCK_CATALOG" => $iblockId,
						"IBLOCK_BRAND" => Option::get("kit.b2bshop", "BRAND_IBLOCK_ID", ""),
						"IBLOCK_BANNER" => Option::get("kit.b2bshop", "BANNER_IBLOCK_ID", ""),
						"PROP_BANNER_TYPE" => "TYPE",
						"CATALOG_PROP_TEXT" => "UF_SECOND_TITLE",
						"CATALOG_PROP_BRAND" => "UF_B2BS_BRAND",
						"CURRENCY_ID" => "",
						"IMAGE_RESIZE_MODE" => Option::get( "kit.b2bshop", "IMAGE_RESIZE_MODE", BX_RESIZE_IMAGE_PROPORTIONAL ),
						"PRICE_CODE" => $priceCode,
						"HIDE_NOT_AVAILABLE" => COption::GetOptionString("kit.b2bshop","HIDE_NOT_AVAILABLE","L"),
						'CACHE_SELECTED_ITEMS' => false
					),
					false
				);?>
			</div>
		</div>
	</div>
</div>