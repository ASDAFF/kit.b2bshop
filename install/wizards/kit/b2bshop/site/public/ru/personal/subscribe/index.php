<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Подписка");
use Bitrix\Main\Loader;

if(!$USER->IsAuthorized())
{
	$APPLICATION->AuthForm('', false, false, 'N', false);
}
else
{
	?>
	<div class="personal_block_title personal_block_title_subscribe">
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
	<div class="personal-wrapper personal-subscribe-wrapper personal-subscribe-wrapper-fiz <?=($opt->hasAccess())?'personal-wrapper-access':''?>">
		<?php
		$Template = new \Kit\B2BShop\Client\Template\Main();
		$Template->includeBlock('template/personal/tabs.php');
		?>

		<div class="row border-profile border-profile-subscribe border-profile-subscribe-fiz">
			<?
			$Template->includeBlock('template/personal/leftblock.php');

			$APPLICATION->IncludeComponent(
				"kit:kit.mailing.email.get",
				"ms_field_personal",
				array(
					"TYPE" => "FIELD",
					"INFO_TEXT" => "Подпишитесь на рассылку и получите скидку 5%",
					"EMAIL_SEND_END" => "Настройки сохранены",
					"DISPLAY_IF_ADMIN" => "Y",
					"DISPLAY_NO_AUTH" => "Y",
					"CATEGORIES_ID" => array(
						0 => "1",
					),
					"JQUERY" => "N",
					"CACHE_TYPE" => "N",
					"CATEGORIES_SHOW" => "Y"
				),
				false
			);?>
		</div>
	</div>
<?
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>