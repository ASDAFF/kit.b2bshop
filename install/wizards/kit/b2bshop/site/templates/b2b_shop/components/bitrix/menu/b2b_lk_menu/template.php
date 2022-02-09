<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();
if($USER->IsAuthorized())
{
	?>
	<div class="top-block__wrapper__dropmenu">
		<div class="top-block__wrapper__dropmenu__title">
			<span class="top-block__wrapper__dropmenu__title-text">
				<?
				if($arResult['USER_DATA']['COMPANY'] && count($arResult['USER_DATA']['COMPANY']) > 0)
				{
					echo reset($arResult['USER_DATA']['COMPANY']);
				}
				else
				{
					echo Loc::getMessage('B2B_LK_TITLE');
				}
				?>
			</span>
		</div>
		<div class="top-block__dropmenu top-block__dropmenu-hidden">
			<div class="top-block__dropmenu__block">
				<div class="top-block__dropmenu__block__email">
					<span class="top-block__dropmenu__block__email__text">
						<?=$arResult['USER_DATA']['USER_EMAIL']?>
					</span>
				</div>
				<div class="top-block__dropmenu__block__info">
					<div class="top-block__dropmenu__block__info__img">
						<?
						if(isset($arResult['USER_DATA']['USER_PERSONAL_PHOTO'])):?>
							<img src="<?=$arResult['USER_DATA']['USER_PERSONAL_PHOTO']['src']?>" alt="" title="">
						<?else:?>
							<img src="<?=SITE_TEMPLATE_PATH?>/site_files/img/grey_sq.png" alt="" title="">
						<? endif; ?>
					</div>
					<?if (!empty($arResult)):?>
						<div class="top-block__dropmenu__block__info__text_wrap">
							<?foreach($arResult as $arItem):?>
								<div class="top-block__dropmenu__block__info__text_inner">
									<a
											class="top-block__dropmenu__block__info__text <?=($arItem["SELECTED"])?'selected':''?>"
											href="<?=$arItem["LINK"]?>"
									>
										<?=$arItem["TEXT"]?>
									</a>
								</div>
							<?endforeach?>
						</div>
					<?endif?>
				</div>
				<div class="top-block__dropmenu__block__button-block">
					<a class="top-block__dropmenu__block__button-lk" href="<?=SITE_DIR?>personal/b2b/">
						<?=Loc::getMessage('B2B_LK')?>
					</a>
					<a class="top-block__dropmenu__block__button-exit" href="<?=SITE_DIR?>index.php?logout=yes">
						<?=Loc::getMessage('B2B_LK_EXIT')?>
					</a>
				</div>
				<? if($arResult['USER_DATA']['COMPANY']): ?>
					<div class="top-block__dropmenu__block-contragents">
						<div class="top-block__dropmenu__block-contragents__title">
							<span>
								<?=Loc::getMessage('B2B_LK_COMPANY_LIST')?>
							</span>
						</div>
						<div class="top-block__dropmenu__block-contragents__text">
							<? foreach ($arResult['USER_DATA']['COMPANY'] as $profileId => $company): ?>
								<a
										class="top-block__dropmenu__block-contragents__text-item"
										href="<?=SITE_DIR?>personal/b2b/profile/buyer/?id=<?=$profileId?>"
								>
									<?=$company?>
								</a>
							<? endforeach; ?>
						</div>
					</div>
				<? endif; ?>
			</div>
		</div>
	</div>
	<?php
}
else
{
	?>
	<div class="top-block__wrapper__dropmenu_href">
		<div class="top-block__wrapper__dropmenu__title_href">
			<span
				class="top-block__auth-href open-modal-login black"
				onclick="OpenModal(
						'<?=SITE_DIR?>include/ajax/auth_form_ajax.php',
						'<?=htmlentities(\Bitrix\Main\Web\Json::encode(array(
					'backurl' => $request->getRequestUri(),
					'register_url' => '/login/',
					'forgot_password' => SITE_DIR."login/?forgot_password=yes",
					'open_login' => 'yes'
				))) ?>',
						'login_enter');return false;"
				rel="nofollow"
			>
				<?echo Loc::getMessage('B2B_LK_TITLE_HREF');?>
			</span>
		</div>
	</div>
	<?php
}
?>