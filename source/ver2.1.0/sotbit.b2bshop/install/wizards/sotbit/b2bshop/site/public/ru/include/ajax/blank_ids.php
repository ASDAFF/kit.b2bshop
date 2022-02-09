<?php
define('STOP_STATISTICS', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if($_POST['id'] > 0)
{
	if($_POST['qnt'] == 0)
	{
		unset($_SESSION['BLANK_IDS'][$_POST['id']]);
	}
	else
	{
		$_SESSION['BLANK_IDS'][$_POST['id']] = [
			'QNT' => $_POST['qnt'],
			'PRICE' => $_POST['price'],
			'IBLOCK_ID' => $_POST['iblock']
		];
	}
	echo json_encode($_SESSION['BLANK_IDS']);
}
?>