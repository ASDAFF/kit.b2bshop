<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $serverName;
$serverName = $_SERVER["SERVER_NAME"];

global $utm;

if($arParams['MAILING_EVENT_ID'] && $arParams['MAILING_MESSAGE'])
{
	$utm = '';
}
elseif($arParams['EVENT_NAME'])
{
	$utm = '?utm_source=newsletter&utm_medium=email&utm_campaign='.$arParams['EVENT_NAME'];
}

$phones = unserialize(COption::GetOptionString("sotbit.b2bshop","MICRO_ORGANIZATION_PHONE",""));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<head>
    <link href="https://fonts.googleapis.com/css?family=Proxima+Nova" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="background-color: #f7f8fa;">
<table width="700" align="center" cellpadding="0" cellspacing="0" border="0" style="margin:auto; padding:0;border: 1px solid #f1f1f1;" bgcolor="#ffffff">
    <tr>
        <td>
            <center style="width: 100%;">
                <!--[if gte mso 9]>
                <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0"><tr><td>
                <![endif]-->
                <table width="100%" height="18" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:0;" bgcolor="#28292d">
                    <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                        <td width="100%"></td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:40px 27px 33px 27px;">
                    <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                        <td width="35%" align="left" cellpadding="0" cellspacing="0" border="0">
                            <!--[if gte mso 9]>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0">
                                <tr cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <td width="20%" align="left" style="vertical-align: top; padding-top: 8px;">
                            <![endif]-->
                            <!--[if !mso]><!-- -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:0;">
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <td width="10%" align="left" style="vertical-align: top; padding-top: 8px;">
                                        <!--<![endif]-->
                                        <img src="/bitrix/templates/b2b_shop/img/mail_phone.png" alt="" border="0" width="12" height="12" style="display:block;text-decoration:none;outline:none;">
                                        <!--[if !mso]><!-- -->
                                    </td>
                                    <td width="90%" align="left">
                                        <!--<![endif]-->

                                        <!--[if gte mso 9]>
                                        </td>
                                        <td width="80%" align="right" cellpadding="0" cellspacing="0" border="0">
                                            <!--<![endif]-->
                                            <? foreach ($phones as $phone) { ?>
                                                <!--[if gte mso 9]>
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0">
                                                    <tr cellpadding="0" cellspacing="0" border="0" width="100%">
                                                        <td width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <![endif]-->
                                                <a href="tel:<?=$phone?>" value="+<?=$phone?>" target="_blank" style="font: 16px 'Proxima Nova', Arial, sans-serif;color: #000000;font-weight: bold;text-decoration: none;line-height:30px;display: block; -webkit-text-size-adjust:none;"><font color="#000000" size="3" face="Proxima Nova, Arial, sans-serif"><?=$phone?></font></a>

                                                <!--[if gte mso 9]>
                                                </td>
                                                </tr>
                                                </table>
                                                <![endif]-->
                                            <? } ?>

                                        <!--[if !mso]><!-- -->
                                    </td>
                                </tr>
                            </table>
                            <!--<![endif]-->

                            <!--[if gte mso 9]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>
                        <td align="center" width="35%">
                            <!--[if gte mso 9]>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0">
                                <tr >
                                    <td width="100%">
                            <![endif]-->
                             <a href="http://b2bshop.sotbit.ru" target="_blank" style=""><img src='<?=COption::GetOptionString("sotbit.b2bshop","LOGO","")?>' alt="" border="0" width="161" style="display:block;text-decoration:none; outline:none;"></a>
                            <!--[if gte mso 9]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>


                        <td width="30%" align="right" cellpadding="0" cellspacing="0" border="0">
                            <!--[if gte mso 9]>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0">
                                <tr cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <td width="20%" align="left" style="vertical-align: top; padding-top: 8px;">
                            <![endif]-->
                            <!--[if !mso]><!-- -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:0;">
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <td width="20%" align="right" style="vertical-align: top; padding-top: 10px;">
                                        <!--<![endif]-->
                                        <img src="/bitrix/templates/b2b_shop/img/mail_mail.png" alt="" border="0" width="14" height="12" style="display:block;text-decoration:none; outline:none;">
                                        <!--[if !mso]><!-- -->
                                    </td>
                                    <td width="80%" align="right">
                                        <!--<![endif]-->
                                        <!--[if gte mso 9]>
                                        </td>
                                        <td width="80%" align="right" cellpadding="0" cellspacing="0" border="0">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0">
                                                <tr cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    <td width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <![endif]-->
                                        <a href='<?=COption::GetOptionString("sotbit.b2bshop","EMAIL","")?>' target="_blank" style="font: 16px 'Proxima Nova', Arial, sans-serif;color: #000000;font-weight: bold;text-decoration: none;line-height:30px;display: block; -webkit-text-size-adjust:none;"><font color="#000000" size="3" face="Proxima Nova, Arial, sans-serif"><?=COption::GetOptionString("sotbit.b2bshop","EMAIL","")?></font></a>
                                        <!--[if !mso]><!-- -->
                                    </td>
                                </tr>
                            </table>
                            <!--<![endif]-->
                            <!--[if gte mso 9]>
                            </td>
                            </tr>
                            </table>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>


                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding: 10px 0; border-bottom: 1px solid #cfd2d9; border-top: 1px solid #cfd2d9;">
                    <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                        <td width="100%" align="center">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:0">
                                <tr>
                                    <?
                                    EventMessageThemeCompiler::includeComponent(
                                        "bitrix:menu",
                                        "top",
                                        array("ALLOW_MULTI_SELECT" => "N",
                                            "DELAY" => "N",
                                            "MAX_LEVEL" => "1",
                                            "MENU_CACHE_GET_VARS" => array(""),
                                            "MENU_CACHE_TIME" => "3600",
                                            "MENU_CACHE_TYPE" => "N",
                                            "MENU_CACHE_USE_GROUPS" => "Y",
                                            "ROOT_MENU_TYPE" => "top",
                                            "USE_EXT" => "Y",
                                        ),
                                        false
                                    );
                                    ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
    <tr>
        <td>
            <center style="width: 100%;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:22px 24px 23px 24px;">
                    <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                        <td width="100%">