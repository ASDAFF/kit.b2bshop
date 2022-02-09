<?
define('NO_AGENT_CHECK', true);
define("STOP_STATISTICS", true);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

if (isset($_POST['AJAX']) && $_POST['AJAX'] == 'Y' && $_POST['addCounter'] ='Y' && isset($_POST['id_element']))
{
if(CModule::IncludeModule("iblock"))
    CIBlockElement::CounterInc($_POST['id_element']);           
}

?>
