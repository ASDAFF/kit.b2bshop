<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$phones = unserialize(COption::GetOptionString("sotbit.b2bshop","MICRO_ORGANIZATION_PHONE",""));
?>
                    </td>
                </tr>
            </table>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:16px 24px 31px 24px;">
                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                    <td width="100%" align="center">
                        <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #797e81;line-height:22px;display: block; -webkit-text-size-adjust:none;">Если у вас остались вопросы, звоните нам по телефону</span>
                        <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:22px; -webkit-text-size-adjust:none;">
                                                    <a href="tel:8 (800) 555-02-42" value="+84959884618" target="_blank" style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;text-decoration: none;line-height:22px; -webkit-text-size-adjust:none;">8 (800) 555-02-42</a>
                                                </span>
                        <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #797e81;line-height:22px; -webkit-text-size-adjust:none;">(бесплатно по РФ)</span>
                    </td>
                </tr>
            </table>
        </center>
    </td>
</tr>
<tr>
    <td>
        <center style="width: 100%;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f3f4f6" style="margin:0; padding:15px 30px 42px 30px;">
                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                    <td width="100%">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:0">
                            <tr>
                                <?
                                EventMessageThemeCompiler::includeComponent(
                                    "bitrix:menu",
                                    "bottom",
                                    array(
                                        "ALLOW_MULTI_SELECT" => "N",
                                        "DELAY" => "N",
                                        "MAX_LEVEL" => "2",
                                        "MENU_CACHE_GET_VARS" => array(""),
                                        "MENU_CACHE_TIME" => "3600",
                                        "MENU_CACHE_TYPE" => "N",
                                        "MENU_CACHE_USE_GROUPS" => "Y",
                                        "ROOT_MENU_TYPE" => "bottom_mail",
                                        "CHILD_MENU_TYPE" => "bottom_inner",
                                        "USE_EXT" => "Y"
                                    ),
                                    false
                                );
                                ?>
                                <td width="28%" style="vertical-align: top;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:0">
                                        <tr>
                                            <td width="100%">
                                                <!--[if gte mso 9]>
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0">
                                                    <tr >
                                                        <td width="100%">
                                                            <![endif]-->
                                                            <span style="font: 15px 'Times New Roman', Arial, sans-serif;color: #000000;text-transform:uppercase;line-height:49px;display: block; -webkit-text-size-adjust:none;"><font color="#000000" size="3" face="Times New Roman, Arial, sans-serif">Контакты</font></span>
                                                            <!--[if gte mso 9]>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <![endif]-->
                                                <!--[if gte mso 9]>
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0">
                                                    <tr >
                                                        <td width="100%">
                                                            <![endif]-->
                                                            <a href='mailto:<?=COption::GetOptionString("sotbit.b2bshop","EMAIL","")?>' target="_blank" style="font: 16px 'Proxima Nova', Arial, sans-serif;color: #9ea3b1;text-decoration: none;line-height:30px;padding-bottom: 13px;display: block; -webkit-text-size-adjust:none;"><font color="#9ea3b1" size="3" face="Proxima Nova, Arial, sans-serif"><?=COption::GetOptionString("sotbit.b2bshop","EMAIL","")?></font></a>
                                                            <!--[if gte mso 9]>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <![endif]-->
                                                <? foreach ($phones as $phone) { ?>
                                                <!--[if gte mso 9]>
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0">
                                                    <tr >
                                                        <td width="100%">
                                                            <![endif]-->
                                                            <a href="tel:<?=$phone?>" value="+<?=$phone?>" target="_blank" style="font: 16px 'Proxima Nova', Arial, sans-serif;color: #000000;text-decoration: none;line-height:25px;display: block; -webkit-text-size-adjust:none;"><font color="#000000" size="3" face="Proxima Nova, Arial, sans-serif"><?=$phone?></font></a>
                                                            <!--[if gte mso 9]>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <![endif]-->
                                               <? } ?>
                                                <div style="padding-top: 26px;">
                                                    <a href='<?=COption::GetOptionString("sotbit.b2bshop","LINK_VK","https://vk.com/sotbit")?>' target="_blank" style="font-weight: normal;text-decoration: none;cursor: pointer;">
                                                        <font color="#000000" face="Arial" size="2">
                                                            <img src="/bitrix/templates/b2b_shop/img/mail_vk.png" alt="vk" width="30" height="31" style="border: 0; outline:none; text-decoration:none;">
                                                        </font>
                                                    </a> &nbsp;
                                                    <a href='<?=COption::GetOptionString("sotbit.b2bshop","LINK_FB","https://www.facebook.com/sotbit")?>' target="_blank" style="font-weight: normal;text-decoration: none;cursor: pointer;">
                                                        <font color="#000000" face="Arial" size="2">
                                                            <img src="/bitrix/templates/b2b_shop/img/mail_fb.png" alt="facebook" width="30" height="31" style="border: 0; outline:none; text-decoration:none;">
                                                        </font>
                                                    </a> &nbsp;
                                                    <a href='<?=COption::GetOptionString("sotbit.b2bshop","LINK_TW","https://www.twitter.com/sotbit")?>' target="_blank" style="font-weight: normal;text-decoration: none;cursor: pointer;">
                                                        <font color="#000000" face="Arial" size="2">
                                                            <img src="/bitrix/templates/b2b_shop/img/mail_tw.png" alt="twitter" width="30" height="31" style="border: 0; outline:none; text-decoration:none;">
                                                        </font>
                                                    </a> &nbsp;
                                                    <a href='<?=COption::GetOptionString("sotbit.b2bshop","LINK_GL","https://www.google.ru")?>' target="_blank" style="font-weight: normal;text-decoration: none;cursor: pointer;">
                                                        <font color="#000000" face="Arial" size="2">
                                                            <img src="/bitrix/templates/b2b_shop/img/mail_g.png" alt="google" width="30" height="31" style="border: 0; outline:none; text-decoration:none;">
                                                        </font>
                                                    </a> &nbsp;
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if gte mso 9]>
            </td></tr></table>
            <![endif]-->
        </center>
    </td>
</tr>
</table>
</body>

