<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Loader;

global $APPLICATION;
$curPage = $APPLICATION->GetCurPage(true);
$aMenuNativeExt = [];

if(!$GLOBALS["USER"]->IsAuthorized() && $curPage == "/personal/subscribe/index.php")
{
	$arParamsToDelete = [
		"login",
		"logout",
		"register",
		"forgot_password",
		"change_password",
		"confirm_registration",
		"confirm_code",
		"confirm_user_id"
	];

	$loginPath = SITE_DIR . "login/?backurl=" . urlencode($APPLICATION->GetCurPageParam("", array_merge($arParamsToDelete, [
			"backurl"
		]), $get_index_page = false));
	$aMenuNativeExt = [
		[
			"Войти",
			$loginPath,
			[],
			[],
			""
		]
	];
}
elseif($GLOBALS["USER"]->IsAuthorized())
{
	$aMenuNativeExt = [
		[
			"Рабочий стол",
			"/personal/",
			[],
			[],
			""
		],		
		[
			"Персональные данные",
			"/personal/profile/",
			[],
			[],
			""
		],
		[
			"Заказы",
			"/personal/order/",
			[],
			[
				"add_fly" => "Y"
			],
			""
		],
		[
			"Подписка",
			"/personal/subscribe/",
			[],
			[],
			""
		],
		[
			"Отзывы и вопросы",
			"/personal/reviews/",
			[],
			[],
			""
		],
	];
	if(Loader::includeModule('sotbit.b2bshop') && Loader::includeModule('support'))
	{
		$aMenuNativeExt[] = [
			"Техническая поддержка",
			"/personal/support/",
			[],
			[],
			""
		];
	}
	$aMenuNativeExt[] = [
		"Выйти",
		$APPLICATION->GetCurPageParam("logout=yes", [
			"logout"
		]),
		[],
		[],
		""
	];
}
$aMenuLinks = array_merge($aMenuLinks, $aMenuNativeExt);
?>