<?php 
use Bitrix\Main\Localization\Loc;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?php
$APPLICATION->IncludeComponent(
		"bitrix:sale.personal.profile.detail",
		"",
		array(
				"PATH_TO_LIST" => '/personal/b2b/profile/buyer/',
				"PATH_TO_DETAIL" => '/personal/b2b/profile/buyer/?id='.$arParams['ID'],
				"SET_TITLE" => 'Y',
				"USE_AJAX_LOCATIONS" => 'N',
				"COMPATIBLE_LOCATION_MODE" => 'N',
				"ID" => $arParams['ID'],
		),
		$component
		);
?>