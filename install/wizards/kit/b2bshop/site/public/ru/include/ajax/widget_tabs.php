<?
/**
 * Copyright (c) 2017. Sergey Danilkin.
 */

if ($_POST['Open'] > 0)
{
	SetCookie("kit_personal_widgets_tab",$_POST['Open'],time()+3600*24*365,'/');
}