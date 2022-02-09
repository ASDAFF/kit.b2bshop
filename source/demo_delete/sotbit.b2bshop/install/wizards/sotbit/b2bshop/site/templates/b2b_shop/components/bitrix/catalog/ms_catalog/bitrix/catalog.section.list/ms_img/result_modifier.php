<?   
if(isset($arResult["SECTION"]["PICTURE"]) && !empty($arResult["SECTION"]["PICTURE"]))
{
    $arResult['PICTURE'] = intval($arResult["SECTION"]['PICTURE']);
	$arResult['PICTURE'] = (0 < $arResult["SECTION"]['PICTURE'] ? CFile::GetFileArray($arResult["SECTION"]['PICTURE']) : false);

    if(!isset($arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]) || empty($arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]))
    {
        $arResult["PICTURE"]["TITLE"] = $arResult["SECTION"]["NAME"];
    }
    if(!isset($arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]) || empty($arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]))
    {
        $arResult["PICTURE"]["ALT"] = $arResult["SECTION"]["NAME"];
    }
}
?>