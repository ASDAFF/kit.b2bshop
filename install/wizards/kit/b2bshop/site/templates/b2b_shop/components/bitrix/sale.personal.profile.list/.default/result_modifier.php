<?
use Bitrix\Main\Config\Option;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$needProfiles = unserialize(Option::get('kit.b2bshop','SHOW_PERSON_TYPE_BUYERS',''));
if(!is_array($needProfiles))
{
	$needProfiles = array();
}
foreach($arResult["PROFILES"] as $key => $val)
{
	if(!in_array($val['PERSON_TYPE_ID'],$needProfiles))
	{
		unset($arResult["PROFILES"][$key]);
	}
}