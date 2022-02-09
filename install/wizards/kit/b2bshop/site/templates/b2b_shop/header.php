<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
define("PATH_TO_404", "/404.php");
Loc::loadMessages(__FILE__);
CUtil::InitJSCore();

if(!Loader::includeModule('kit.b2bshop'))
{
	echo Loc::getMessage('HEADER_DEMO_END',array('#MODULE#' => 'kit.b2bshop'));
	die;
}

$Template = new \Kit\B2BShop\Client\Template\Main();

global $BRAND_PROP;
global $BRAND_IBLOCK_ID;
global $BRAND_IBLOCK_TYPE;

$BRAND_IBLOCK_TYPE = Option::get("kit.b2bshop", "BRAND_IBLOCK_TYPE", "");
$BRAND_IBLOCK_ID = Option::get("kit.b2bshop", "BRAND_IBLOCK_ID", "");
$BRAND_PROP = Option::get("kit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", "");
?>
<!DOCTYPE html>
<html>
<head>
	<?php $Template::includeBlock('template/head.php');?>
</head>
<body>
<?=Option::get("kit.b2bshop", "YANDEX", "")?>
<?=Option::get("kit.b2bshop", "GOOGLE", "")?>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<?
$Template->includeBlock('template/top-block.php');
$Template->includeBlock('template/header.php');
if (defined("ERROR_404"))
{
	$class_main = "bg-404";
}
elseif($Template->needAddMainBgClass())
{
	$class_main = "main-bg";
}
else
{
	$class_main = "";
}?>
<div class="content-text bootstrap_style main-border <?=$class_main?>">
	<?if (!defined("ERROR_404"))
	{
		if($BRAND_PROP && $BRAND_IBLOCK_ID && $BRAND_IBLOCK_TYPE)
		{
			$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"ms_brand_aphabet",
			array(
				"DISPLAY_DATE" => "N",
				"DISPLAY_NAME" => "N",
				"DISPLAY_PICTURE" => "N",
				"DISPLAY_PREVIEW_TEXT" => "N",
				"AJAX_MODE" => "N",
				"IBLOCK_TYPE" => $BRAND_IBLOCK_TYPE,
				"IBLOCK_ID" => $BRAND_IBLOCK_ID,
				"NEWS_COUNT" => "10000",
				"SORT_BY1" => "NAME",
				"SORT_ORDER1" => "ASC",
				"SORT_BY2" => "SORT",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "",
				"FIELD_CODE" => array(
					0 => "",
					1 => "",
				),
				"PROPERTY_CODE" => array(
					0 => "",
					1 => "",
				),
				"CHECK_DATES" => "N",
				"DETAIL_URL" => "",
				"PREVIEW_TRUNCATE_LEN" => "",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_STATUS_404" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"INCLUDE_SUBSECTIONS" => "N",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_NOTES" => "",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"COMPONENT_TEMPLATE" => "ms_brand_aphabet"
				),
				false
			);
		}
	}
	if ($Template::getCurPage() == '/')
	{

		$APPLICATION->IncludeFile(SITE_DIR."include/miss-header-mainpage.php",
			Array(),
			Array("MODE"=>"php")
		);
	}

	?>

	<div <?if($Template::getCurPage() == '/'){?>class="main_page"<?} else {?>class="inner_page"<?}?>>
		<div class="container">
			<div class="row">
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"ms_left",
					Array(
						"AREA_FILE_SHOW" => "sect",
						"AREA_FILE_SUFFIX" => "left",
						"AREA_FILE_RECURSIVE" => "Y",
						"EDIT_MODE" => "html",
						),
						false,
						Array('HIDE_ICONS' => 'Y')
					);
				?>
				<?if ($Template->needShowBreadcrumbs())
				{?>
						<div class="col-sm-24 sm-padding-no">
						<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "ms_breadcrumb", array(
							"START_FROM" => "0",
							"PATH" => "",
							"SITE_ID" => SITE_ID,
							"SSB_CODE_BACKGROUND" => "#fff",
							"SSB_CODE_BORDER" => "#000"
						),
						false,
						Array('HIDE_ICONS' => 'N')
						);

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
				<?}
				if(defined("ERROR_404"))
				{
					?>
					<div class="col-sm-24 center_wrap sm-padding-no">
						<div class="row">
							<div class="col-sm-12">
					<?php
				}
				else
				{
					$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
									"AREA_FILE_RECURSIVE" => "Y",
									"AREA_FILE_SHOW" => "sect",
									"AREA_FILE_SUFFIX" => "leftside",
									"EDIT_TEMPLATE" => ""
									)
							);
				}