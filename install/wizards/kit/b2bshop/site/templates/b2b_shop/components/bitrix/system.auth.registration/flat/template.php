<?

use Bitrix\Main\Config\Option;
use Bitrix\Sale\Internals\PersonTypeTable;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(
	\Bitrix\Main\Loader::includeModule("kit.auth") &&
	\Bitrix\Main\Loader::includeModule("sale") &&
	\Bitrix\Main\Loader::includeModule("kit.b2bshop")
)
{
	$cntPersonTypes = PersonTypeTable::getCount([
		'ACTIVE' => 'Y'
	]);
	$idGroup = Option::get('kit.auth', 'WHOLESALERS_GROUP', 0, SITE_ID);
	if($idGroup > 0 && $cntPersonTypes > 1)
	{
		$APPLICATION->IncludeComponent("kit:kit.auth.wholesaler.register", "fiz",
			[
				"AUTH" => "Y",
				'AUTH_URL' => $arResult["AUTH_AUTH_URL"],
				"REQUIRED_FIELDS" => [
					"EMAIL"
				],
				"SET_TITLE" => "Y",
				"SHOW_FIELDS" => [
					"NAME",
					'LAST_NAME'
				],
				"SUCCESS_PAGE" => "/",
				"USER_PROPERTY" => [
					'UF_CONFIDENTIAL'
				],
				"USER_PROPERTY_NAME" => "",
				"USE_BACKURL" => "Y",
				"VARIABLE_ALIASES" => []
			]);
	}
	else
	{
		$APPLICATION->IncludeComponent("bitrix:main.register", "",
			[
				"SHOW_FIELDS" => [
					"NAME",
					'LAST_NAME'
				],
				"REQUIRED_FIELDS" => [
					"EMAIL"
				],
				"SET_TITLE" => "Y",
				"USER_PROPERTY" => [
					'UF_CONFIDENTIAL'
				],
				"VARIABLE_ALIASES" => [],
				"USE_BACKURL" => "Y",
				"AUTH" => "Y",
				"SUCCESS_PAGE" => "/",
				"COMPOSITE_FRAME_MODE" => "A",
				"COMPOSITE_FRAME_TYPE" => "AUTO",
				'AUTH_URL' => $arResult["AUTH_AUTH_URL"]
			]);
	}
}
else
{
	$APPLICATION->IncludeComponent("bitrix:main.register", "",
		[
			"SHOW_FIELDS" => [
				"NAME",
				'LAST_NAME'
			],
			"REQUIRED_FIELDS" => [
				"EMAIL"
			],
			"SET_TITLE" => "Y",
			"USER_PROPERTY" => [
				'UF_CONFIDENTIAL'
			],
			"VARIABLE_ALIASES" => [],
			"USE_BACKURL" => "Y",
			"AUTH" => "Y",
			"SUCCESS_PAGE" => "/",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO",
			'AUTH_URL' => $arResult["AUTH_AUTH_URL"]
		]);
}
?>