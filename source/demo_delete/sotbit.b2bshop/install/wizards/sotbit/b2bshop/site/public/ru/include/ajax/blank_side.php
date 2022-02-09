<?
if($_REQUEST['Open'])
{
	SetCookie("blank_side",$_REQUEST['Open'],time()+3600*24*3,'/');
}
?>