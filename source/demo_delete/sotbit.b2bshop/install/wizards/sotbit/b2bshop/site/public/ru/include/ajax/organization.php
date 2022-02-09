<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$userId = $USER->GetID();
$orgId = htmlspecialchars($_POST['id']);
if($userId > 0 && $orgId > 0)
{
	$USER->Update($userId,['UF_ORGANIZATION' => $orgId]);
}