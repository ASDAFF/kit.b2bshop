<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if(isset($arResult['ELEMENT_H1']) && !empty($arResult['ELEMENT_H1']))
{
	$this->SetViewTarget("kit_seometa_h1");
	echo $arResult['ELEMENT_H1'];
	$this->EndViewTarget();
}
if(isset($arResult['ELEMENT_TOP_DESC']) && !empty($arResult['ELEMENT_TOP_DESC']))
{
	$this->SetViewTarget("kit_seometa_top_desc");
	echo $arResult['ELEMENT_TOP_DESC'];
	$this->EndViewTarget();
}
if(isset($arResult['ELEMENT_BOTTOM_DESC']) && !empty($arResult['ELEMENT_BOTTOM_DESC']))
{
	$this->SetViewTarget("kit_seometa_bottom_desc");
	echo $arResult['ELEMENT_BOTTOM_DESC'];
	$this->EndViewTarget();
}
if(isset($arResult['ELEMENT_ADD_DESC']) && !empty($arResult['ELEMENT_ADD_DESC']))
{
	$this->SetViewTarget("kit_seometa_add_desc");
	echo $arResult['ELEMENT_ADD_DESC'];
	$this->EndViewTarget();
}
?>