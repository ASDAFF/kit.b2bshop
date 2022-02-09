<?
require ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
use Bitrix\Main\Loader;
$APPLICATION->SetTitle('Организации');
$APPLICATION->AddHeadScript('/bitrix/js/main/utils.js');
if(!$USER->IsAuthorized())
{
	?>
	<div class="personal_block_title personal_block_title_buyer">
		<h1 class="text"><?
			$APPLICATION->ShowTitle(false); ?></h1>
	</div>
	<?php
	$APPLICATION->AuthForm('', false, false, 'N', false);
}
else
{
	?>
	<div class="personal_block_title personal_block_title_buyer">
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
	<div class="personal-wrapper personal-buyer-wrapper personal-buyer-wrapper-opt <?=($opt->hasAccess())?'personal-wrapper-access':''?>">
		<?php
		$Template = new \Kit\B2BShop\Client\Template\Main();
		$Template->includeBlock('template/personal/tabs.php');
		?>
		<div class="row border-profile border-profile-personal border-profile-personal-opt">
			<?
			$Template->includeBlock('template/personal/leftblock.php');
			?>
			<div class="col-sm-19 sm-padding-right-no blank_right-side <?= (!$menu->isOpen()) ? 'blank_right-side_full' : '' ?>" id="blank_right_side">
				<div id="wrapper_blank_resizer" class="wrapper_blank_resizer">
					<div class="blank_resizer">
						<div class="blank_resizer_tool <?= (!$menu->isOpen()) ? 'blank_resizer_tool_open':''?>" ></div>
					</div>
					<div class="personal-right-content">
						<?
						$context = \Bitrix\Main\Application::getInstance()->getContext();
						$request = $context->getRequest();
						$id = $request->get("id");
						
						$APPLICATION->IncludeComponent(
							"kit:organizations",
							"",
							array(
								"PATH" => SITE_DIR.'personal/b2b/profile/buyer/',
								"PATH_TO_ADD" => '?add=Y',
								"PATH_TO_DETAIL" => '?id=#ID#',
								"PATH_TO_DELETE" => '?del_id=#ID#',
								"SET_TITLE" => 'Y',
								"USE_AJAX_LOCATIONS" => 'N',
								"COMPATIBLE_LOCATION_MODE" => 'N',
							),
							$component
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