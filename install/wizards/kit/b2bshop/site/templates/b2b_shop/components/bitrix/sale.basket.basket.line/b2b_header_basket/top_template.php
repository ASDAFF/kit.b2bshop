<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
Loc::loadMessages(__FILE__);
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();
if (!$compositeStub && $arParams['SHOW_AUTHOR'] == 'Y')
{
	if ($USER->IsAuthorized())
	{
		$name = trim($USER->GetFullName());
		if (! $name)
		{
			$name = trim($USER->GetLogin());
		}
		if (strlen($name) > 15)
		{
			$name = substr($name, 0, 12).'...';
		}
		?>
		<div class="header-login enter">
			<a href="<?=$arParams['PATH_TO_PROFILE']?>"><?=htmlspecialcharsbx($name)?></a>
			<a href="?logout=yes" class="black"><?=Loc::getMessage('TSB1_LOGOUT')?></a>
		</div>
	<?
	}
	else
	{
		$arParamsToDelete = array(
				"login",
				"backurl",
				"login_form",
				"logout",
				"register",
				"forgot_password",
				"change_password",
				"confirm_registration",
				"confirm_code",
				"confirm_user_id",
				"logout_butt",
				"auth_service_id",
				"clear_cache"
		);

		$currentUrl = urlencode($APPLICATION->GetCurPageParam("", $arParamsToDelete));
		if ($arParams['AJAX'] == 'N')
		{
			?><script type="text/javascript"><?=$cartId?>.currentUrl = '<?=$currentUrl?>';</script><?
		}
		else
		{
			$currentUrl = '#CURRENT_URL#';
		}

		?>
		<div class="header-login">
			<a
				href="<?=$arParams['PATH_TO_REGISTER']?>?register=yes&backurl=<?=$currentUrl; ?>"
			>
				<?=Loc::getMessage('TSB1_REGISTER')?>
			</a>
			<a
				href="<?=SITE_DIR ?>include/ajax/auth_form_ajax.php"
				class="open-modal-login black"
				onclick="OpenModal(
					'<?=SITE_DIR?>include/ajax/auth_form_ajax.php',
					'<?=htmlentities(\Bitrix\Main\Web\Json::encode(array(
							'backurl' => $request->getRequestUri(),
							'register_url' => $arParams['PATH_TO_REGISTER'],
							'forgot_password' => SITE_DIR."login/?forgot_password=yes",
							'open_login' => 'yes'
					))) ?>',
					'login_enter');return false;"
				rel="nofollow"
			>
				<?=Loc::getMessage('TSB1_LOGIN')?>
			</a>
		</div>
	<?}
}?>
<div class="bx-hdr-profile" >
	<div class="bx-basket-block" onmouseenter="<?=$cartId?>.toggleOpenCloseCart('open')">
		<a href="<?=(Option::get('kit.b2bshop','URL_PATH','ORDER') == 'ORDER')
			?$arParams['PATH_TO_ORDER']:$arParams['PATH_TO_BASKET']?>"><?//=Loc::getMessage('TSB1_CART')?></a>
		<?
		if (!$compositeStub)
		{
			if ($arParams['SHOW_NUM_PRODUCTS'] == 'Y' && $arResult['QNT'] > 0)
			{
				echo '<span><a href="';
				echo (Option::get('kit.b2bshop','URL_PATH','ORDER') == 'ORDER')
					?$arParams['PATH_TO_ORDER']:$arParams['PATH_TO_BASKET'];
				echo '">'.$arResult['QNT'].' '.Loc::getMessage("TSB1_PRODUCT").$arResult['PRODUCT_QNT']
					.'</a></span>';
			}
			if ($arParams['SHOW_TOTAL_PRICE'] == 'Y')
			{?>
			<br <? if ($arParams['POSITION_FIXED'] == 'Y'){ ?>class="hidden-xs"<?} ?>/>
			<span>
				<?= Loc::getMessage('TSB1_TOTAL_PRICE') ?>
				<? if ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y')
				{?>
					<strong><?= $arResult['TOTAL_PRICE'] ?></strong>
				<?} ?>
			</span>
			<?}
		}
		if ($arParams['SHOW_PERSONAL_LINK'] == 'Y')
		{?>
			<br>
			<span class="icon_info"></span>
			<a href="<?=$arParams['PATH_TO_PERSONAL']?>"><?=Loc::getMessage('TSB1_PERSONAL')?></a>
		<?}?>
	</div>
</div>