<?php
use Bitrix\Main\Localization\Loc;
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
Loc::loadMessages(__FILE__);
if($arParams["~AUTH_RESULT"]['TYPE'] == 'OK')
{
	$arParams["~AUTH_RESULT"]['MESSAGE'] = Loc::getMessage('SUCCESS_SEND_EMAIL');
}
?>