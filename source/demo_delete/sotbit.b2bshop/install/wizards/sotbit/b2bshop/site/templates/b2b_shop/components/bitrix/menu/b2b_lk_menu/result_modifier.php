<?
use Bitrix\Main\UserTable;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;

Loader::includeModule('sale');

$user = UserTable::getList(
			array(
					'select' => array('ID','EMAIL','PERSONAL_PHOTO','NAME','LAST_NAME'),
					'filter' => array('ID' => $USER->GetID()),
					'limit' => 1
			)
		)->fetch();
$arResult['USER_DATA']['USER_EMAIL'] = $user['EMAIL'];

if($user['PERSONAL_PHOTO'] > 0)
{
	$arResult['USER_DATA']['USER_PERSONAL_PHOTO'] = CFile::ResizeImageGet(
														$user['PERSONAL_PHOTO'],
														array(
																'width'=>76,
																'height'=>95

														),
														BX_RESIZE_IMAGE_PROPORTIONAL,
														true
													);
}
$personTypes = unserialize(Option::get('sotbit.b2bshop','BUYER_PERSONAL_TYPE',''));
if(!is_array($personTypes))
{
	$personTypes = array();
}

$profiles = array();
if(count($personTypes) > 0)
{
	$db_sales = CSaleOrderUserProps::GetList(
			array("DATE_UPDATE" => "DESC"),
			array("USER_ID" => $user['ID'], 'PERSON_TYPE_ID' => $personTypes)
	);
	$arCompany = array();
	while ($profile = $db_sales->Fetch())
	{
		$profiles[] = $profile['ID'];
	}
}

if($profiles)
{
	$arResult['USER_DATA']['COMPANY'] = array();
	$db_propVals = CSaleOrderUserPropsValue::GetList(
			array("ID" => "ASC"),
			array("USER_PROPS_ID"=>$profiles,'CODE' => 'COMPANY')
			);
	while ($arPropVals = $db_propVals->Fetch())
	{
		if($arPropVals['VALUE'])
		{
			$arResult['USER_DATA']['COMPANY'][$arPropVals['USER_PROPS_ID']] = $arPropVals['VALUE'];
		}
	}
}