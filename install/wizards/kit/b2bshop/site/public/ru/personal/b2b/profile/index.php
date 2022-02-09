<?
use Bitrix\Main\Loader;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Персональные данные");
if(!$USER->IsAuthorized())
{
	$APPLICATION->AuthForm('', false, false, 'N', false);
}
else
{
	?>
	<div class="personal_block_title personal_block_title_personal">
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
	<div class="personal-wrapper personal-profile-wrapper personal-profile-wrapper-fiz <?=($opt->hasAccess())?'personal-wrapper-access':''?>">
		<?php
		$Template = new \Kit\B2BShop\Client\Template\Main();
		$Template->includeBlock('template/personal/tabs.php');
		?>

		<div class="row border-profile border-profile-personal border-profile-personal-opt">
			<?$Template->includeBlock('template/personal/leftblock.php');

			$APPLICATION->IncludeComponent(
				"bitrix:main.profile",
				"ms_profile",
				array(
					"SET_TITLE" => "Y",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"USER_PROPERTY" => array(),
					"SEND_INFO" => "N",
					"CHECK_RIGHTS" => "N",
					"USER_PROPERTY_NAME" => "",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_MODE" => "Y"
				),
				false
			);
			?>
		</div>
	</div>
	<?php
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>