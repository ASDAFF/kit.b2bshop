<?php 
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
foreach($arResult['ERRORS'] as $i => $Error)
{
	if($arResult['USER_PROPERTIES']['DATA']['UF_CONFIDENTIAL']['EDIT_FORM_LABEL'] && strpos($Error,$arResult['USER_PROPERTIES']['DATA']['UF_CONFIDENTIAL']['EDIT_FORM_LABEL']))
	{
		$arResult['ERRORS'][$i] = Loc::getMessage('ERROR_CONFIDENTIAL');
	}
}

?>