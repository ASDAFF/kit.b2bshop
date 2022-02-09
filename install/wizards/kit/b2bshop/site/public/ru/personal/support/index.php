<?
use Bitrix\Main\Loader;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Техподдержка");
if(!$USER->IsAuthorized())
{
	$APPLICATION->AuthForm('', false, false, 'N', false);
}
else
{
	?>
	<div class="personal_block_title personal_block_title_support">
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
	<div class="personal-wrapper personal-profile-wrapper personal-profile-wrapper-opt <?=($opt->hasAccess())?'personal-wrapper-access':''?>">
		<?php
		$Template = new \Kit\B2BShop\Client\Template\Main();
		$Template->includeBlock('template/personal/tabs.php');
		?>

		<div class="row border-profile border-profile-support border-profile-personal-opt">
			<?$Template->includeBlock('template/personal/leftblock.php');

			$APPLICATION->IncludeComponent(
				"bitrix:support.wizard",
				"",
				Array(
					"AJAX_MODE" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"IBLOCK_ID" => 0,
					"IBLOCK_TYPE" => "-",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
					"MESSAGES_PER_PAGE" => "20",
					"MESSAGE_MAX_LENGTH" => "70",
					"MESSAGE_SORT_ORDER" => "asc",
					"PROPERTY_FIELD_TYPE" => "",
					"PROPERTY_FIELD_VALUES" => "",
					"SECTIONS_TO_CATEGORIES" => "N",
					"SET_PAGE_TITLE" => "Y",
					"SET_SHOW_USER_FIELD" => array(),
					"SHOW_COUPON_FIELD" => "N",
					"SHOW_RESULT" => "Y",
					"TEMPLATE_TYPE" => "",
					"TICKETS_PER_PAGE" => "50",
					"VARIABLE_ALIASES_ID" => "ID"
				)
			);
			?>
		</div>
	</div>
	<?php
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>