<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Мои вопросы");
use Bitrix\Main\Loader;
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
	<div class="personal_block_title personal_block_title_questions">
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
	<div class="personal-wrapper personal-questions-wrapper personal-questions-wrapper-fiz <?=($opt->hasAccess())?'personal-wrapper-access':''?>">
		<?php
		$Template = new \Kit\B2BShop\Client\Template\Main();
		$Template->includeBlock('template/personal/tabs.php');
		?>

		<div class="row border-profile border-profile-questions border-profile-questions-fiz">
			<?
			$Template->includeBlock('template/personal/leftblock.php');
			?>

			<div class="col-sm-19 sm-padding-right-no blank_right-side <?= (!$menu->isOpen()) ? 'blank_right-side_full' : '' ?>" id="blank_right_side">
				<div id="wrapper_blank_resizer" class="wrapper_blank_resizer">
					<div class="blank_resizer">
						<div class="blank_resizer_tool  <?= (!$menu->isOpen()) ? 'blank_resizer_tool_open':''?>" ></div>
					</div>
					<div class="personal-right-content">
						<?
						if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/bitrix/components/kit/reviews.personalquestions/component.php'))
						{
							$APPLICATION->IncludeComponent(
								"kit:reviews.personalquestions",
								"bootstrap",
								array(
									"TEXTBOX_MAXLENGTH"=>"200",
									'ID_USER'=>$USER->GetID(),
									"PRIMARY_COLOR"=>"#a76e6e",
									"NOTICE_EMAIL" => "",
									'CACHE_TIME'=>"36000000",
									'CACHE_GROUPS'=>'N',
									"DATE_FORMAT"=>"d F Y, H:i",
								),
								$component
							);
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?
}
?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>