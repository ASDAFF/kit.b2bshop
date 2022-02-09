<?php 
if (! defined ( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true)
	die ();

if($arParams['HIDE'])
{
	foreach($arResult as $i => $li)
	{
		if(in_array($li['LINK'], $arParams['HIDE']))
		{
			unset($arResult[$i]);
		}
	}
}
?>