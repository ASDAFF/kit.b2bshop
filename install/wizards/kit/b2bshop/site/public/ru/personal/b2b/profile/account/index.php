<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
$APPLICATION->SetTitle('Личный счет');

if(!$USER->IsAuthorized())
{
	?>
	<div class="personal_block_title personal_block_title_reviews">
		<h1 class="text"><?
			$APPLICATION->ShowTitle(false); ?></h1>
	</div>
	<?php
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
	<div class="personal-wrapper personal-account-wrapper personal-account-wrapper-opt <?=($opt->hasAccess())?'personal-wrapper-access':''?>">
		<?php
		$Template = new \Kit\B2BShop\Client\Template\Main();
		$Template->includeBlock('template/personal/tabs.php');
		?>

		<div class="row border-profile border-profile-personal border-profile-personal-fiz">
			<?php
			$Template->includeBlock('template/personal/leftblock.php');
			?>

			<div class="col-sm-19 sm-padding-right-no blank_right-side <?= (!$menu->isOpen()) ? 'blank_right-side_full' : '' ?>" id="blank_right_side">
				<div id="wrapper_blank_resizer" class="wrapper_blank_resizer">
					<div class="blank_resizer">
						<div class="blank_resizer_tool <?= (!$menu->isOpen()) ? 'blank_resizer_tool_open':''?>" ></div>
					</div>
					<div class="personal-right-content">
						<?
						$APPLICATION->IncludeComponent(
							"bitrix:sale.personal.account",
							"",
							Array(
								"SET_TITLE" => "N"
							),
							''
						);

						$APPLICATION->IncludeComponent(
							"bitrix:sale.account.pay",
							"",
							Array(
								"COMPONENT_TEMPLATE" => ".default",
								"REFRESHED_COMPONENT_MODE" => "Y",
								"ELIMINATED_PAY_SYSTEMS" => array("0"),
								"PATH_TO_BASKET" => Option::get('kit.b2bshop', 'URL_CART','/personal/cart/'),
								"PATH_TO_PAYMENT" => Option::get('kit.b2bshop', 'URL_PAYMENT','/personal/order/payment/'),
								"PERSON_TYPE" => Option::get('kit.b2bshop', 'PERSONAL_PERSON_TYPE','1'),
								"REDIRECT_TO_CURRENT_PAGE" => "N",
								"SELL_AMOUNT" => array("100","200","500","1000","5000",""),
								"SELL_CURRENCY" => '',
								"SELL_SHOW_FIXED_VALUES" => 'Y',
								"SELL_SHOW_RESULT_SUM" =>  '',
								"SELL_TOTAL" => array("100","200","500","1000","5000",""),
								"SELL_USER_INPUT" => 'Y',
								"SELL_VALUES_FROM_VAR" => "N",
								"SELL_VAR_PRICE_VALUE" => "",
								"SET_TITLE" => "N",
							),
							''
						);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>