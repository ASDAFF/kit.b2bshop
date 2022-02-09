<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$serverName = $_SERVER["SERVER_NAME"];
$phones = unserialize(COption::GetOptionString("kit.b2bshop","MICRO_ORGANIZATION_PHONE",""));

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<head>
    <link href="https://fonts.googleapis.com/css?family=Proxima+Nova" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="background-color: #f7f8fa;">
<table width="700" align="center" cellpadding="0" cellspacing="0" border="0" style="margin:auto; padding:0" bgcolor="#ffffff">
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
                            <a href="<?=$serverName?>" target="_blank" style="color: #000000;text-decoration: none;display: block; -webkit-text-size-adjust:none;"><img src='<?=COption::GetOptionString("kit.b2bshop","LOGO","")?>' alt="" border="0" width="161" style="display:block;text-decoration:none; outline:none;"></a>
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
                                    <td width="20%" align="right" style="vertical-align: top; padding-top: 8px;">
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
                                        <a href="mailto:b2b_shop@mail.ru" target="_blank" style="font: 16px 'Proxima Nova', Arial, sans-serif;color: #000000;font-weight: bold;text-decoration: none;line-height:30px;display: block; -webkit-text-size-adjust:none;"><font color="#000000" size="3" face="Proxima Nova, Arial, sans-serif">b2b_shop@mail.ru</font></a>
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
                                    /*EventMessageThemeCompiler::includeComponent(
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
                                    );*/
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
                            <!--================================================================================================================================-->

                            <span style="font: 22px 'Proxima Nova', Arial, sans-serif;color: #070908;font-weight: bold;line-height:44px;display: block; -webkit-text-size-adjust:none;">Ваш заказ принят</span>
                            <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #797e81;line-height:20px;display: block; -webkit-text-size-adjust:none;">В данный момент ваш заказ принят и мы уже его формируем.<br>Ознакомьтесь с данными вашего заказа:</span>

                            <?
                            $iblock = COption::GetOptionString("kit.b2bshop","OPT_IBLOCK_ID","");
                            $id_props = unserialize(COption::GetOptionString("kit.b2bshop","OPT_PROPS",""));
                            $off= CCatalogSKU::GetInfoByProductIBlock($iblock);
                            $offer_block_id = $off['IBLOCK_ID'];
                            $props = array();
                            foreach ($id_props as $id_prop) {
                                $res = CIBlockProperty::GetByID($id_prop, $offer_block_id);
                                if($ar_res = $res->GetNext()) {
                                    $props[] = 'PROPERTY_'.$ar_res['CODE'];
                                }
                            }

                            $arr = array(
                                0 => "NAME",
                                1 => "QUANTITY",
                                2 => COption::GetOptionString("kit.b2bshop","OPT_ARTICUL_PROP_OFFER","PROPERTY_CML2_ARTICLE"),
                                3 => "PRICE_FORMATED"
                            );
                            $custom_props = array_merge($arr, $props);

                            global $APPLICATION;
                            $APPLICATION->IncludeComponent(
                                "bitrix:sale.personal.order.detail.mail",
                                "b2bshop",
                                array(
                                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                    "CACHE_TIME" => "3600",
                                    "CACHE_TYPE" => "A",
                                    "CUSTOM_SELECT_PROPS" => $custom_props,
                                    "ID" => "134",
                                    "PATH_TO_CANCEL" => "",
                                    "PATH_TO_LIST" => "",
                                    "PATH_TO_PAYMENT" => "payment.php",
                                    "PICTURE_HEIGHT" => "110",
                                    "PICTURE_RESAMPLE_TYPE" => "1",
                                    "PICTURE_WIDTH" => "110",
                                    "PROP_1" => array(
                                    ),
                                    "PROP_2" => array(
                                    ),
                                    "SHOW_ORDER_BASE" => "N",
                                    "SHOW_ORDER_BASKET" => "Y",
                                    "SHOW_ORDER_BUYER" => "Y",
                                    "SHOW_ORDER_DELIVERY" => "Y",
                                    "SHOW_ORDER_PARAMS" => "N",
                                    "SHOW_ORDER_PAYMENT" => "Y",
                                    "SHOW_ORDER_SUM" => "Y",
                                    "SHOW_ORDER_USER" => "N",
                                    "COMPONENT_TEMPLATE" => "b2bshop",
                                    "SHOW_PAYMENT_BUTTON" => 'N', // кнопка "Повторить оплату" при неудачной оплате (Y или N)
                                ),
                                false
                            );
                            ?>
                            <?
                            $APPLICATION->IncludeComponent(
                                "kit:kit.mailing.products.mail",
                                "b2bshop",
                                Array(
                                    "BLOCK_TITLE" => "Вас может заинтересовать",
                                    "COUNT_PRODUCT" => "4",
                                    "LIST_ITEM_ID" => array(0=>"",),
                                    "LIST_ITEM_ID_OUR" => "{#RECOMMEND_PRODUCT_ID#}",
                                    "ORDER_ID" => "{#ORDER_ID#}",
                                    "TYPE_WORK" => "BUYER"
                                )
                            );?>


                            <!--<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:22px 24px 23px 24px;">
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <td width="100%">

                                    </td>
                                </tr>
                            </table>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:16px 24px 31px 24px;">
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <td width="100%" align="center">
                                        <span style="font: 22px 'Proxima Nova', Arial, sans-serif;color: #070908;line-height:28px;font-weight:bold;display: block; -webkit-text-size-adjust:none;">Покупайте со скидкой!</span>
                                        <span style="font: 16px 'Proxima Nova', Arial, sans-serif;color: #c80202;line-height:25px; -webkit-text-size-adjust:none;">купон на скидку 5%</span>
                                        <span style="font: 16px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:25px; -webkit-text-size-adjust:none;">в ваших руках</span>
                                    </td>
                                </tr>
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <td width="100%" align="center">
                                        <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:22px;display: block;padding-top: 11px; -webkit-text-size-adjust:none;">
                                            #SITE_NAME# благодарит вас за оставленный отзыв к <a style="font: 14px 'Proxima Nova', Arial, sans-serif;text-decoration:none;color: #000000;line-height:22px; -webkit-text-size-adjust:none;" href="http://#SERVER_NAME##ELEMENT_LINK#" target="_blank">#ELEMENT_NAME#</a>.
                                        </span>
                                        <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:22px;padding-bottom: 7px;display: block; -webkit-text-size-adjust:none;">
                                          У нас для вас отличные новости! Мы предоставляем купон на скидку "#DISCOUNT_NAME#".<br>Спешите! Cрок действия купона ограничен!
                                        </span>
                                    </td>
                                </tr>
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:16px 24px 31px 24px;">
                                            <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <td width="50%" align="center" style="padding-right: 5px;">
                                                    <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #000000;line-height:38px;border: 1px solid #d1d4d6;display: block;float: right;max-width:236px; width: 100%; text-align: center; -webkit-text-size-adjust:none;">#COUPON#</span>
                                                </td>
                                                <td width="50%" align="center">
                                                    <a href="#SERVER_NAME#" target="_blank" style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #ffffff;text-transform:uppercase;text-decoration: none;line-height:40px;display: block;float: left;max-width:236px; width: 100%; text-align: center;background-color: #000000; -webkit-text-size-adjust:none;">Перейти на сайт</a>
                                                </td>
                                            </tr>
                                        </table>
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
                            </table>-->

                            <!--<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:22px 24px 23px 24px;">
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <td width="100%">
                                        <span style="font: 22px 'Proxima Nova', Arial, sans-serif;color: #070908;font-weight: bold;line-height:44px;display: block; -webkit-text-size-adjust:none;">Здравствуйте.</span>
                                    </td>
                                </tr>
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <td width="100%">
                                        <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #797e81;line-height:20px;display: block; -webkit-text-size-adjust:none;">Вы получили это сообщение, так как ваш адрес был использован при регистрации нового пользователя на сервере #SERVER_NAME#.</span>
                                    </td>
                                </tr>
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0"><td><br></td></tr>
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <td width="100%">
                                        <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #797e81;line-height:20px;display: block; -webkit-text-size-adjust:none;">Ваш код для подтверждения регистрации: #CONFIRM_CODE#.</span>
                                    </td>
                                </tr>
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0"><td><br></td></tr>
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <td width="100%">
                                        <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #797e81;line-height:20px;display: block; -webkit-text-size-adjust:none;">Для подтверждения регистрации перейдите по следующей ссылке:<br>#SERVER_NAME#/auth/index.php?confirm_registration=yes&confirm_user_id=#USER_ID#&confirm_code=#CONFIRM_CODE#</span>
                                    </td>
                                </tr>
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0"><td><br></td></tr>
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <td width="100%">
                                        <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #797e81;line-height:20px;display: block; -webkit-text-size-adjust:none;">Вы также можете ввести код для подтверждения регистрации на странице: http://#SERVER_NAME#/auth/index.php?confirm_registration=yes&confirm_user_id=#USER_ID#</span>
                                    </td>
                                </tr>
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0"><td><br></td></tr>
                            </table>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:16px 24px 31px 24px;">
                                <tr width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <td width="100%">
                                        <span style="font: 14px 'Proxima Nova', Arial, sans-serif;color: #797e81;line-height:22px;display: block; -webkit-text-size-adjust:none;">Внимание! Ваш профиль не будет активным, пока вы не подтвердите свою регистрацию.</span>
                                    </td>
                                </tr>
                            </table>-->
                            <!--                        ================================================================================================================================-->
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
                                    $APPLICATION->IncludeComponent(
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
                                                    <a href="mailto:<?=COption::GetOptionString("kit.b2bshop","EMAIL","")?>" target="_blank" style="font: 16px 'Proxima Nova', Arial, sans-serif;color: #9ea3b1;text-decoration: none;line-height:30px;padding-bottom: 13px;display: block; -webkit-text-size-adjust:none;"><font color="#9ea3b1" size="3" face="Proxima Nova, Arial, sans-serif"><?=COption::GetOptionString("kit.b2bshop","EMAIL","")?></font></a>
                                                    <!--[if gte mso 9]>
                                                    </td>
                                                    </tr>
                                                    </table>
                                                    <![endif]-->
                                                    <? foreach ($phones as $phone) { ?>
                                                    <!--[if gte mso 9]>
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0;">
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

                                                        <a href="<?=COption::GetOptionString("kit.b2bshop","LINK_VK","https://vk.com/kit")?>" target="_blank" style="font-weight: normal;text-decoration: none;cursor: pointer;">
                                                            <font color="#000000" face="Arial" size="2">
                                                                <img src="/bitrix/templates/b2b_shop/img/mail_vk.png" alt="vk" width="30" height="31" style="border: 0; outline:none; text-decoration:none;">
                                                            </font>
                                                        </a> &nbsp;
                                                        <a href="<?=COption::GetOptionString("kit.b2bshop","LINK_FB","https://www.facebook.com/kit")?>" target="_blank" style="font-weight: normal;text-decoration: none;cursor: pointer;">
                                                            <font color="#000000" face="Arial" size="2">
                                                                <img src="/bitrix/templates/b2b_shop/img/mail_fb.png" alt="facebook" width="30" height="31" style="border: 0; outline:none; text-decoration:none;">
                                                            </font>
                                                        </a> &nbsp;
                                                        <a href="<?=COption::GetOptionString("kit.b2bshop","LINK_TW","https://www.twitter.com/kit")?>" target="_blank" style="font-weight: normal;text-decoration: none;cursor: pointer;">
                                                            <font color="#000000" face="Arial" size="2">
                                                                <img src="/bitrix/templates/b2b_shop/img/mail_tw.png" alt="twitter" width="30" height="31" style="border: 0; outline:none; text-decoration:none;">
                                                            </font>
                                                        </a> &nbsp;
                                                        <a href="<?=COption::GetOptionString("kit.b2bshop","LINK_GL","https://www.google.ru")?>" target="_blank" style="font-weight: normal;text-decoration: none;cursor: pointer;">
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

