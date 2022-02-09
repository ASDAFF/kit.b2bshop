<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

WizardServices::IncludeServiceLang("settings.php", 'ru');

$arEvents = [
	'NEW_USER',
	'NEW_USER_CONFIRM',
	'USER_INFO',
	'USER_PASS_CHANGED',
	'USER_PASS_REQUEST',
	'SALE_NEW_ORDER',
	'SALE_NEW_ORDER_RECURRING',
	'SALE_ORDER_REMIND_PAYMENT',
	'SALE_ORDER_CANCEL',
	'SALE_ORDER_PAID',
	'SALE_ORDER_DELIVERY',
	'SALE_RECURRING_CANCEL',
	'SALE_SUBSCRIBE_PRODUCT',
];

foreach ($arEvents as $Event)
{
	$rsET = CEventMessage::GetList($by = "site_id", $order = "desc", ['TYPE_ID' => $Event]);
	while ($arET = $rsET->Fetch())
	{
		$em = new CEventMessage;
		$em->Update($arET['ID'], ['SITE_TEMPLATE_ID' => 'b2bshop_mail']);
	}
}


$arEvents = [
	'USER_PASS_CHANGED',
	'USER_PASS_REQUEST',
];

foreach ($arEvents as $Event)
{
	$rsET = CEventMessage::GetList($by = "site_id", $order = "desc", ['TYPE_ID' => $Event]);
	while ($arET = $rsET->Fetch())
	{
		$mess = $arET['MESSAGE'];

		$mess = str_replace(['Login: #LOGIN#',], '', $mess);

		$em = new CEventMessage;
		$em->Update($arET['ID'], ['MESSAGE' => $mess]);
	}
}


$module = 'kit.b2bshop';
if($module == 'kit.b2bshop')
{

	$Sites = [];
	$rsSites = \Bitrix\Main\SiteTable::getList([
		'filter' => [
			"ACTIVE" => "Y"
		]
	]);
	while ($arSite = $rsSites->Fetch())
	{
		$Sites[] = $arSite['LID'];
	}
	$arFilter = [
		"TYPE_ID" => [
			"SALE_NEW_ORDER",
			"SALE_ORDER_PAID",
			'SALE_STATUS_CHANGED_F',
			'SALE_STATUS_CHANGED_N',
			'SALE_STATUS_CHANGED_C',
			'SALE_STATUS_CHANGED_A',
			'SALE_STATUS_CHANGED_P',
			'SALE_ORDER_CANCEL',
		],
	];

	if(\Bitrix\Main\Loader::includeModule('support'))
	{
		$rsET = CEventMessage::GetList($by = "site_id", $order = "desc", [
			'TYPE_ID' => [
				'TICKET_NEW_FOR_TECHSUPPORT',
				'TICKET_CHANGE_FOR_TECHSUPPORT'
			]
		]);
		while ($arET = $rsET->Fetch())
		{
			$em = new CEventMessage;
			$em->Update($arET['ID'], ['SITE_TEMPLATE_ID' => 'b2bshop_mail']);
		}
		$arFilter['TYPE_ID'][] = 'TICKET_CHANGE_BY_SUPPORT_FOR_AUTHOR';
	}

	$rsMess = CEventMessage::GetList($by = "site_id", $order = "desc", $arFilter);

	while ($arMess = $rsMess->GetNext())
	{
		$em = new CEventMessage;
		$em->Update($arMess['ID'], ['ACTIVE' => 'N']);
	}

	$oEventMessage = new CEventMessage();
	$oEventMessage->Add([
		'ACTIVE' => 'Y',
		'EVENT_NAME' => 'SALE_NEW_ORDER',
		'LID' => $Sites,
		'EMAIL_FROM' => '#SALE_EMAIL#',
		'EMAIL_TO' => '#EMAIL#',
		'SUBJECT' => GetMessage('WZD_MAIL_SALE_NEW_ORDER_SUBJECT'),
		'MESSAGE' => GetMessage('WZD_MAIL_SALE_NEW_ORDER_BODY'),
		'BODY_TYPE' => 'html',
		'SITE_TEMPLATE_ID' => 'b2bshop_mail'
	]);
	$oEventMessage = new CEventMessage();
	$oEventMessage->Add([
		'ACTIVE' => 'Y',
		'EVENT_NAME' => 'SALE_ORDER_PAID',
		'LID' => $Sites,
		'EMAIL_FROM' => '#SALE_EMAIL#',
		'EMAIL_TO' => '#EMAIL#',
		'SUBJECT' => GetMessage('WZD_MAIL_SALE_ORDER_PAID_SUBJECT'),
		'MESSAGE' => GetMessage('WZD_MAIL_SALE_ORDER_PAID_BODY'),
		'BODY_TYPE' => 'html',
		'SITE_TEMPLATE_ID' => 'b2bshop_mail'
	]);
	$oEventMessage = new CEventMessage();
	$oEventMessage->Add([
		'ACTIVE' => 'Y',
		'EVENT_NAME' => 'SALE_STATUS_CHANGED_F',
		'LID' => $Sites,
		'EMAIL_FROM' => '#SALE_EMAIL#',
		'EMAIL_TO' => '#EMAIL#',
		'SUBJECT' => GetMessage('WZD_MAIL_SALE_STATUS_CHANGED_F_SUBJECT'),
		'MESSAGE' => GetMessage('WZD_MAIL_SALE_STATUS_CHANGED_F_BODY'),
		'BODY_TYPE' => 'html',
		'SITE_TEMPLATE_ID' => 'b2bshop_mail'
	]);
	$oEventMessage = new CEventMessage();
	$oEventMessage->Add([
		'ACTIVE' => 'Y',
		'EVENT_NAME' => 'SALE_STATUS_CHANGED_N',
		'LID' => $Sites,
		'EMAIL_FROM' => '#SALE_EMAIL#',
		'EMAIL_TO' => '#EMAIL#',
		'SUBJECT' => GetMessage('WZD_MAIL_SALE_STATUS_CHANGED_N_SUBJECT'),
		'MESSAGE' => GetMessage('WZD_MAIL_SALE_STATUS_CHANGED_N_BODY'),
		'BODY_TYPE' => 'html',
		'SITE_TEMPLATE_ID' => 'b2bshop_mail'
	]);
	$oEventMessage = new CEventMessage();
	$oEventMessage->Add([
		'ACTIVE' => 'Y',
		'EVENT_NAME' => 'SALE_STATUS_CHANGED_C',
		'LID' => $Sites,
		'EMAIL_FROM' => '#SALE_EMAIL#',
		'EMAIL_TO' => '#EMAIL#',
		'SUBJECT' => GetMessage('WZD_MAIL_SALE_STATUS_CHANGED_C_SUBJECT'),
		'MESSAGE' => GetMessage('WZD_MAIL_SALE_STATUS_CHANGED_C_BODY'),
		'BODY_TYPE' => 'html',
		'SITE_TEMPLATE_ID' => 'b2bshop_mail'
	]);
	$oEventMessage = new CEventMessage();
	$oEventMessage->Add([
		'ACTIVE' => 'Y',
		'EVENT_NAME' => 'SALE_STATUS_CHANGED_A',
		'LID' => $Sites,
		'EMAIL_FROM' => '#SALE_EMAIL#',
		'EMAIL_TO' => '#EMAIL#',
		'SUBJECT' => GetMessage('WZD_MAIL_SALE_STATUS_CHANGED_A_SUBJECT'),
		'MESSAGE' => GetMessage('WZD_MAIL_SALE_STATUS_CHANGED_A_BODY'),
		'BODY_TYPE' => 'html',
		'SITE_TEMPLATE_ID' => 'b2bshop_mail'
	]);
	$oEventMessage = new CEventMessage();
	$oEventMessage->Add([
		'ACTIVE' => 'Y',
		'EVENT_NAME' => 'SALE_STATUS_CHANGED_P',
		'LID' => $Sites,
		'EMAIL_FROM' => '#SALE_EMAIL#',
		'EMAIL_TO' => '#EMAIL#',
		'SUBJECT' => GetMessage('WZD_MAIL_SALE_STATUS_CHANGED_P_SUBJECT'),
		'MESSAGE' => GetMessage('WZD_MAIL_SALE_STATUS_CHANGED_P_BODY'),
		'BODY_TYPE' => 'html',
		'SITE_TEMPLATE_ID' => 'b2bshop_mail'
	]);
	$oEventMessage = new CEventMessage();
	$oEventMessage->Add([
		'ACTIVE' => 'Y',
		'EVENT_NAME' => 'SALE_ORDER_CANCEL',
		'LID' => $Sites,
		'EMAIL_FROM' => '#SALE_EMAIL#',
		'EMAIL_TO' => '#EMAIL#',
		'SUBJECT' => GetMessage('WZD_MAIL_SALE_ORDER_CANCEL_SUBJECT'),
		'MESSAGE' => GetMessage('WZD_MAIL_SALE_ORDER_CANCEL_BODY'),
		'BODY_TYPE' => 'html',
		'SITE_TEMPLATE_ID' => 'b2bshop_mail'
	]);
	$oEventMessage = new CEventMessage();
	$oEventMessage->Add([
		'ACTIVE' => 'Y',
		'EVENT_NAME' => 'TICKET_CHANGE_BY_SUPPORT_FOR_AUTHOR',
		'LID' => $Sites,
		'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
		'EMAIL_TO' => '#OWNER_EMAIL#',
		'SUBJECT' => GetMessage('WZD_MAIL_TICKET_CHANGE_BY_SUPPORT_FOR_AUTHOR_SUBJECT'),
		'MESSAGE' => GetMessage('WZD_MAIL_TICKET_CHANGE_BY_SUPPORT_FOR_AUTHOR_BODY'),
		'BODY_TYPE' => 'html',
		'SITE_TEMPLATE_ID' => 'b2bshop_mail'
	]);
}

?>