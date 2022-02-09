<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->IncludeComponent( "sotbit:oragnizations.add", "",
		array(
				'AJAX_MODE' => 'Y',
				"PATH_TO_DETAIL" => $arParams['PATH_TO_DETAIL'],
				"PATH_TO_DELETE" => $arParams['PATH'].$arParams['PATH_TO_DELETE'],
				"PATH" => $arParams['PATH'],
		), $component );
?>