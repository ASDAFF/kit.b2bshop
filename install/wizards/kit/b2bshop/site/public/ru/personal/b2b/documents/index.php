<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Документы");

use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

if(!$USER->IsAuthorized())
{
	?>
	<div class="personal_block_title personal_block_title_documents">
		<h1 class="text">
			<?$APPLICATION->ShowTitle(false); ?>
		</h1>
	</div>
	<?php
	$APPLICATION->AuthForm('', false, false, 'N', false);
}
else
{
	?>
	<div class="personal_block_title personal_block_title_documents">
		<h1 class="text"><?$APPLICATION->ShowTitle(false);?></h1>
	</div>

	<?php
	if(!Loader::includeModule('kit.b2bshop'))
	{
		return false;
	}
	$opt = new \Kit\B2BShop\Client\Shop\Opt();
	$menu = new \Kit\B2BShop\Client\Personal\Menu();
	?>
	<div class="personal-wrapper personal-documents-wrapper personal-comments-wrapper-fiz <?=($opt->hasAccess())?'personal-wrapper-access':''?>">
		<?php
		$Template = new \Kit\B2BShop\Client\Template\Main();
		$Template->includeBlock('template/personal/tabs.php');
		?>
		<div class="row border-profile border-profile-documents border-profile-documents-fiz">
			<?
			$Template->includeBlock('template/personal/leftblock.php');
			?>

			<div class="col-sm-19 sm-padding-right-no blank_right-side <?= (!$menu->isOpen()) ? 'blank_right-side_full' : '' ?>" id="blank_right_side">
				<div id="wrapper_blank_resizer" class="wrapper_blank_resizer">
					<div class="blank_resizer">
						<div class="blank_resizer_tool <?= (!$menu->isOpen()) ? 'blank_resizer_tool_open':''?>" ></div>
					</div>
					<div class="personal-right-content">
						<?$APPLICATION->IncludeComponent(
							"bitrix:news",
							"documents",
							Array(
								"ADD_ELEMENT_CHAIN" => "N",
								"ADD_SECTIONS_CHAIN" => "Y",
								"AJAX_MODE" => "N",
								"AJAX_OPTION_ADDITIONAL" => "",
								"AJAX_OPTION_HISTORY" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"BROWSER_TITLE" => "-",
								"CACHE_FILTER" => "N",
								"CACHE_GROUPS" => "Y",
								"CACHE_TIME" => "36000000",
								"CACHE_TYPE" => "A",
								"CHECK_DATES" => "Y",
								"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
								"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
								"DETAIL_DISPLAY_TOP_PAGER" => "N",
								"DETAIL_FIELD_CODE" => array("", ""),
								"DETAIL_PAGER_SHOW_ALL" => "Y",
								"DETAIL_PAGER_TEMPLATE" => "",
								"DETAIL_PAGER_TITLE" => "Страница",
								"DETAIL_PROPERTY_CODE" => array("", ""),
								"DETAIL_SET_CANONICAL_URL" => "N",
								"DISPLAY_BOTTOM_PAGER" => "Y",
								"DISPLAY_DATE" => "Y",
								"DISPLAY_NAME" => "Y",
								"DISPLAY_PICTURE" => "Y",
								"DISPLAY_PREVIEW_TEXT" => "Y",
								"DISPLAY_TOP_PAGER" => "N",
								"FILTER_NAME" => "documents",
								"HIDE_LINK_WHEN_NO_DETAIL" => "N",
								"IBLOCK_ID" => Option::get("kit.b2bshop", "DOCUMENT_IBLOCK_ID", ""),
								"IBLOCK_TYPE" => Option::get("kit.b2bshop", "DOCUMENT_IBLOCK_TYPE", ""),
								"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
								"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
								"LIST_FIELD_CODE" => array("DATE_CREATE", "TIMESTAMP_X"),
								"LIST_PROPERTY_CODE" => array("ORDER", "ORGANIZATION","USER"),
								"MESSAGE_404" => "",
								"META_DESCRIPTION" => "-",
								"META_KEYWORDS" => "-",
								"NEWS_COUNT" => "20",
								"PAGER_BASE_LINK_ENABLE" => "N",
								"PAGER_DESC_NUMBERING" => "N",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
								"PAGER_SHOW_ALL" => "N",
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_TEMPLATE" => ".default",
								"PAGER_TITLE" => "Новости",
								"PREVIEW_TRUNCATE_LEN" => "",
								"SEF_FOLDER" => '/personal/b2b/documents/',
								"SEF_MODE" => "Y",
								"SET_LAST_MODIFIED" => "N",
								"SET_STATUS_404" => "N",
								"SET_TITLE" => "Y",
								"SEF_URL_TEMPLATES" => Array(
									"detail" => "#SECTION_CODE#/#ELEMENT_CODE#/",
									"news" => "",
									"section" => "#SECTION_CODE#/"
								),
								"SHOW_404" => "N",
								"SORT_BY1" => "ACTIVE_FROM",
								"SORT_BY2" => "SORT",
								"SORT_ORDER1" => "DESC",
								"SORT_ORDER2" => "ASC",
								"STRICT_SECTION_CHECK" => "N",
								"USE_CATEGORIES" => "N",
								"USE_FILTER" => "Y",
								"USE_PERMISSIONS" => "N",
								"USE_RATING" => "N",
								"USE_REVIEW" => "N",
								"USE_RSS" => "N",
								"USE_SEARCH" => "N",
								"VARIABLE_ALIASES" => Array(
									"ELEMENT_ID" => "ELEMENT_ID",
									"SECTION_ID" => "SECTION_ID"
								)
							)
						);?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?
}
?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>