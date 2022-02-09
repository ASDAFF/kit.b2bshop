<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?

if($REQUEST_METHOD == "POST")
{
    SetCookie("sotbit_filter[".$Code."]",$Open,time()+3600*24*3,'/');
}
?>