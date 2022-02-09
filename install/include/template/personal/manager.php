<?php

use Bitrix\Main\Config\Option;
global $APPLICATION;
global $USER;
$user = \Bitrix\main\UserTable::getList(array(
        'filter' => array('ID' => $USER->getId()),
        'select' => array('UF_*')
    ))->fetch();

$managerID = COption::GetOptionString("kit.b2bshop","DEGAULT_MANAGER_ID", 1);

if($user['UF_MANAGER'])
    $managerID = $user['UF_MANAGER'];

$APPLICATION->IncludeComponent("bitrix:forum.user.profile.view", "manager_block", Array(
        "CACHE_TIME" => "0",
        "CACHE_TYPE" => "A",
        "DATE_FORMAT" => "d.m.Y",
        "DATE_TIME_FORMAT" => "d.m.Y H:i:s",
        "FID_RANGE" => array(),
        "RATING_ID" => "",
        "RATING_TYPE" => "",
        "SEND_ICQ" => "A",
        "SEND_MAIL" => "E",
        "SET_NAVIGATION" => "Y",
        "SET_TITLE" => "Y",
        "SHOW_RATING" => "",
        "UID" => $managerID,
        "DISPLAY_PICTURE" => "Y",
        "URL_TEMPLATES_MESSAGE" => "message.php?FID=#FID#&TID=#TID#&MID=#MID#",
        "URL_TEMPLATES_MESSAGE_SEND" => "message_send.php?TYPE=#TYPE#&UID=#UID#",
        "URL_TEMPLATES_PM_EDIT" => "pm_edit.php",
        "URL_TEMPLATES_PM_LIST" => "pm_list.php",
        "URL_TEMPLATES_PROFILE" => "profile.php?UID=#UID#",
        "URL_TEMPLATES_READ" => "read.php?FID=#FID#&TID=#TID#",
        "URL_TEMPLATES_SUBSCR_LIST" => "subscr_list.php",
        "URL_TEMPLATES_USER_LIST" => "user_list.php",
        "URL_TEMPLATES_USER_POST" => "user_post.php?UID=#UID#&mode=#mode#",
        "USER_PROPERTY" => array(),
        "USER_PROPERTY_NAME" => ""
    ), false);