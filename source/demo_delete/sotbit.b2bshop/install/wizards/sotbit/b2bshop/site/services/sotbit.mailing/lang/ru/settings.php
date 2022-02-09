<?
$MESS['WZD_DISCOUNT_NANE'] = 'B2BShop Скидка 5% маркетинговые рассылки';


$MESS['WZD_user_register_mailing_1_NAME'] = 'B2BShop уведомление о регистрации через сборщики e-mail';
$MESS['WZD_user_register_mailing_1_DESCRIPTION'] = 'Сценарий отправляет сообщение пользователю о регистрации и купон на скидку 5%';
$MESS['WZD_user_register_mailing_1_SUBJECT'] = 'Поздравляем с вступлением в наш клуб, берем подарки!'; 
$MESS['WZD_user_register_mailing_1_MESSAGE_TEXT'] = '  
        <br />       
        <p><b>Добрый день !</b></p>
        <br />
        <p>Благодарим вас за то что подписались на нашу рассылку, мы будем присылать только самые полезные и интересные новости. 
        <br />
        Мы создали для вас аккаунт на сайт.</p>
        <p>Логин: <b>#USER_LOGIN#</b> 
        <br />
        Пароль: <b>#USER_PASSWORD#</b></p>
        <p>Мы подготовили для вас подарок в честь вступления в наше сообщество. 
        <br />
        Подарочный купон <b>#COUPON#</b> с 5% скидкой на весь первый заказ. 
        <br />
        Попробуйте, вы не пожалеете.</p>
        <p>#VIEWED_PRODUCT#</p>
';



$MESS['WZD_mailimg_list_novelty_section_id_1_NAME'] = 'B2BShop новинки категории товаров, оповестим подписчиков';
$MESS['WZD_mailimg_list_novelty_section_id_1_DESCRIPTION'] = 'Производит рассылку новинок категорий товаров, на которые подписан пользователь. Выборка идет по привязке категории инфоблока к категории товаров.';
$MESS['WZD_mailimg_list_novelty_section_id_1_SUBJECT'] = 'Новое поступление в магазин!'; 
$MESS['WZD_mailimg_list_novelty_section_id_1_MESSAGE_TEXT'] = '         
        <br />
        <p><b>Добрый день #USER_NAME#!</b></p>
        <br />
        <p>Мы рады вам сообщить что у нас появились новинки за последнюю неделю.</p>
        <br />
        <br />
        #NOVELTY_GOODS# 
';

  
$MESS['WZD_forgotten_basket_discount_1_NAME'] = 'B2BShop брошенная корзина - напомним через 2 дня';
$MESS['WZD_forgotten_basket_discount_1_DESCRIPTION'] = 'Рассылка сообщений пользователям через 2 дня после того как они забыли товар в корзине';
$MESS['WZD_forgotten_basket_discount_1_SUBJECT'] = 'Вы, кажется, что-то забыли?'; 
$MESS['WZD_forgotten_basket_discount_1_MESSAGE_TEXT'] = '         
        <br />
        <p><b>Вы, кажется, что-то забыли? </b></p>
        <br />
        <p>Приветствуем Вас! Мы хотим Вам напомнить, что Вы забыли в корзине на сайте нашего магазина товары 2 дня тому назад. Хотим убедиться, что все в порядке, и это всего лишь случайное недоразумение. </p>
        <p>Если вам необходима помощь при оформлении заказа, Вы всегда можете нам позвонить или написать на почту, и мы окажем вам необходимую поддержку в тот же час, как получим ваше сообщение. </p>
        <br />
        <br />
        <p>Количество позиций: #BASKET_COUNT#</p>
        <p>Общая стоимость позиций: #BASKET_PRICE_ALL_FORMAT#</p>
        <br />
        <div style="text-align: right;"> <a style="text-decoration: none;color: #e9b8c8;font-size: 16px;display:inline-block;background-color:#FEF6F6;padding: 10px 30px 10px 30px; border: 1px solid #BFBFBF" href="#SITE_URL#/personal/cart/?MAILING_MESSAGE=#MAILING_MESSAGE#&utm_source=newsletter&utm_medium=email&utm_campaign=sotbit_mailing_#MAILING_EVENT_ID#" ><b>Оформить заказ</b></a> </div>
        <br />
        #FORGET_BASKET# 
        <br />
        <div style="text-align: right;"> <a style="text-decoration: none;color: #e9b8c8;font-size: 16px;display:inline-block;background-color:#FEF6F6;padding: 10px 30px 10px 30px; border: 1px solid #BFBFBF" href="#SITE_URL#/personal/cart/?MAILING_MESSAGE=#MAILING_MESSAGE#&utm_source=newsletter&utm_medium=email&utm_campaign=sotbit_mailing_#MAILING_EVENT_ID#" ><b>Оформить заказ</b></a> </div>
';


$MESS['WZD_user_not_buy_anything_1_NAME'] = 'B2BShop пользователь зарегистрирован, но ничего не купил 14 дней.';
$MESS['WZD_user_not_buy_anything_1_DESCRIPTION'] = 'Производит рассылку сообщений пользователям, которые зарегистрировались, но не сделали ни одной покупки за 2 недели.';
$MESS['WZD_user_not_buy_anything_1_SUBJECT'] = 'Возникли проблемы #USER_NAME#? Поможем!'; 
$MESS['WZD_user_not_buy_anything_1_MESSAGE_TEXT'] = '         
        <br />
        <p><b>Добрый день !</b></p>      
        <br />
        <p>Приветствуем Вас! Вы зарегистрировались на сайте нашего магазина, но так и не совершили ни одной покупки за 2 недели, хотим убедиться, что все в порядке. </p>
        <p>Если Вам необходима помощь при оформлении заказа, то Вы всегда можете нам позвонить или написать на почту. Мы окажем Вам необходимую поддержку в тот же час, как получим ваше сообщение. </p>
        <br />
        <br />
        Удачных покупок! 
        <br />
        <br />
        #RECOMMEND_PRODUCT# 
        <br />
        <br />
';



$MESS['WZD_order_ask_for_review_1_NAME'] = 'B2BShop просим оставить отзыв в яндекс-маркет о магазине первый заказ через 2 дня';
$MESS['WZD_order_ask_for_review_1_DESCRIPTION'] = 'Сценарий помогает собирать отзывы на яндекс-маркет о магазине и на вашем сайте о товарах';
$MESS['WZD_order_ask_for_review_1_SUBJECT'] = 'Заказ доставлен, нам важно ваше мнение о нас!'; 
$MESS['WZD_order_ask_for_review_1_MESSAGE_TEXT'] = '         
        <br />
        <p><b>Добрый день, #ORDER_PROP_FIO#!</b></p>
        <br />
        <p>Вы делали у нас заказ №#ORDER_ID#, мы следим за нашим сервисом, нам важно мнение каждого клиентам о нашей работе. Поэтому просим вас оценить нас на яндекс-маркет, для этого перейдите по <a href="market.yandex.ru/shop/18433/reviews?from=18433" >ссылке</a> .</p>
        <br />
        #FORGET_BASKET# 
        <br />
        <br />
        <p>Сделайте себе подарок: получите именно то, что хочется Вам!</p>
        #RECOMMEND_PRODUCT# 
';


$MESS['WZD_user_have_not_had_1_NAME'] = 'B2BShop пользователь не заходил 2 месяца, отправим приглашение и скидку';
$MESS['WZD_user_have_not_had_1_DESCRIPTION'] = 'Производит рассылку сообщений пользователям, которые давно не заходили на сайт.';
$MESS['WZD_user_have_not_had_1_SUBJECT'] = 'Давно не заходили #USER_NAME#, приглашаем в гости!'; 
$MESS['WZD_user_have_not_had_1_MESSAGE_TEXT'] = '         
        <br />
        <p><b>Добрый день !</b></p>  
        <br />
        <p>Вы к нам не заходили уже 2 месяца, за это время у нас появилось много интересного.</p> 
        <p>Мы дарим Вам купон на 5% скидки, который будет действовать 2 дня.</p>
        <p>Номер купона: <b>#COUPON#</b></p>
        <p>Сделайте себе подарок: получите именно то, что хочется Вам!</p>
        #RECOMMEND_PRODUCT# 
';


$MESS['WZD_TEMPLATE_PARAMS_MESSAGE'] = '
<table width="700px" align="center" cellpadding="0" cellspacing="0" style="border: 1px solid #e3e3e3;">
      <tr>
          <td>
              <table width="100%" align="center" cellpadding="0" cellspacing="0" style="position:relative;">
                  <tr height="26px">
                      <td width="45px" valign="top"  style="text-align: right; padding-right: 10px">
                         <img src="#SITE_URL#/bitrix/templates/b2b_shop/img/mail_img/letter_b2bshop_header_phone.png" alt="" style="margin-top: 23px;"/>
                      </td>
                      <td valign="top" style="font-size: 15px; font-weight: bold; " width="150px">
                        <p style="margin-top: 20px;color:#052640;"> 8 (495) 988-46-18<br />8 (800) 100-46-18</p>
                      </td>
                      <td align="center" width="300px">
                        <a href="#SITE_URL#" style="height:115px;display:block;"><img src="#SITE_URL#/bitrix/templates/b2b_shop/img/mail_img/mister_header_logo.png" style="position:absolute;left:50%;top:4px;margin-left:-105px;width:210px;height:88px;"/></a>
                      </td>
                      <td width="20px" valign="top" >
                         <img src="#SITE_URL#/bitrix/templates/b2b_shop/img/mail_img/letter_b2bshop_header_email.png" alt="" style="margin-top: 28px;"/>
                      </td>
                      <td valign="top" style="font-size: 15px; font-weight: bold;" width="155px">
                        <p style="margin-bottom: 0px; margin-top: 23px;color:#052640;">b2b_shop@mail.ru</p>
                      </td>
                  </tr>
              </table>
          </td>
      </tr>
      <tr>
          <td style="border-bottom: 1px solid #797e8a;padding-bottom: 2px;">
              <table width="90%" align="center" cellpadding="0" cellspacing="0" style="border-bottom: 1px solid #797e8a;">
                <tr height="30px">
                    <td style="font-size: 12px;" align="" width="75px"><a href="#SITE_URL#/catalog/bleyzery_i_zhilety/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #000000;">БЛЕЙЗЕРЫ</a></td>
                    <td style="font-size: 12px;" align="center"><a href="#SITE_URL#/catalog/kostyumy/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #000000;">КОСТЮМЫ</a></td>
                    <td style="font-size: 12px;" align="center"><a href="#SITE_URL#/catalog/obuv/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #000000;">ОБУВЬ</a></td>
                    <td style="font-size: 12px;" align="center"><a href="#SITE_URL#/catalog/aksessuary/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #000000;">АКСЕССУАРЫ</a></td>
                    <td style="font-size: 12px;" align="center"><a href="#SITE_URL#/brands/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #000000;">БРЕНДЫ</a></td>
                    <td style="font-size: 12px;" align="center"><a href="#SITE_URL#/sales/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #000000;">РАСПРОДАЖА</a></td>
                    <td style="font-size: 12px;" align="right" width="84px"><a href="#SITE_URL#/about/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #000000;">О МАГАЗИНЕ</a></td>
                </tr>
              </table>
          </td>
      </tr>
      
        <tr>
            <td style="padding: 46px 56px 51px 60px;">
                #MESSAGE_TEXT# 
               
            </td>
        </tr>
      <tr>
          <td style="padding: 35px;border-top: 1px solid #cfd3da;" bgcolor="#f3f4f6">
              <table cellpadding="0" cellspacing="0" style="height:200px;border:1px solid #dbdee5;" bgcolor="#ffffff">
                  <tr height="20"><td></td></tr>
                  <tr>
                      <td width="200px" style="padding-top: 0px; padding-left:30px;padding-right:52px;" valign="top">
                          <h3 style="margin-top: 0px; font-size: 18px;color:#001f37;font-weight:normal;">О КОМПАНИИ</h3>
                          <p style="margin-bottom: 8px; font-size: 14px;"><a href="#SITE_URL#/about/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #6c727d;">О нас</a></p>
                          <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/about/work/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #6c727d;">Работа у нас</a></p>
                          <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/about/shops/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #6c727d;">Отзывы клиентов</a></p>
                          <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/about/contacts/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #6c727d;">Информация для 
партнеров</a></p>
                          <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/news/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #6c727d;">Пресса о нас</a></p>
                          
                      </td>
                      <td width="320px" style="padding-top: 0px; padding-left:29px;padding-right:31px; border-left: 1px solid #f2efed; border-right: 1px solid #f2efed;" valign="top">
                          <h3 style="margin-top: 0px; font-size: 18px;color:#001f37;font-weight:normal;">КЛИЕНТАМ</h3>
                          <p style="margin-bottom: 8px; font-size: 14px;"><a href="#SITE_URL#/clients/table_sizes/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #6c727d;">Таблица размеров</a></p>
                          <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/clients/help_choice/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #6c727d;">Помощь в подборе</a></p>
                          <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/clients/refuse_dispatch/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #6c727d;">Подарочный сертификат</a></p>
                          <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/clients/requirements_clients/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing&MAILING_MESSAGE=#MAILING_MESSAGE#" target="_blank" style="text-decoration: none; color: #6c727d;">Отписаться от смс-
рассылки</a></p>
                      </td>
                      <td width="223px" style="padding-top: 0px; padding-left:30px;" valign="top">
                          <h3 style="font-size: 18px; margin-top: 0px;color:#001f37;font-weight:normal;">КОНТАКТЫ</h3>
                          <p style="margin-top: 3px; margin-bottom:23px; font-size: 14px; color: #9da5b3">b2b_shop@mail.ru</p>
                          <p style="margin-bottom: 4px; font-family: Arial; font-size: 15px; font-weight:bold;color: #052640">8 (495) 988-46-18</p>
                          <p style="margin-top: 5px; margin-bottom: 10px; font-family: Arial; font-weight:bold;font-size: 15px; color: #052640">8 (800) 100-46-18</p>
                          <table cellpadding="0" cellspacing="0" style="padding: 9px 18px 5px 0;">
                              <tr>
                                  <td style="padding-right: 8px;"><a href="https://vk.com/sotbit" target="_blank" style="background: url(\'#SITE_URL#/bitrix/templates/b2b_shop/img/mail_img/mister_sprite_social_icon.png\');background-position: -5px -5px;width:30px;height: 31px;display: block;"></a></td>
                                  <td style="padding-right: 8px;"><a href="https://www.facebook.com/sotbit" target="_blank"  style="background: url(\'#SITE_URL#/bitrix/templates/b2b_shop/img/mail_img/mister_sprite_social_icon.png\');background-position: -5px -75px;width:30px;height: 31px;display: block;"></a></td>
                                  <td style="padding-right: 8px;"><a href="https://twitter.com/sotbit" target="_blank" style="background: url(\'#SITE_URL#/bitrix/templates/b2b_shop/img/mail_img/mister_sprite_social_icon.png\');background-position: -5px -145px;width:30px;height: 31px;display: block;"></a></td>
                                  <td><a href="#" target="_blank" target="_blank" style="background: url(\'#SITE_URL#/bitrix/templates/b2b_shop/img/mail_img/mister_sprite_social_icon.png\');background-position: -5px -215px;width:30px;height: 31px;display: block;"></a></td>
                              </tr>
                          </table>
                      </td>
                  </tr>
                  <tr height="20"></tr>
              </table>
          </td>
      </tr>
    </table>          
';


// рекомендованные товары
$MESS['WZD_TEMP_TOP_RECOMMEND'] = '
    <div style="background-color: #f4f3f2; padding: 5px 10px 5px 10px;color: #353535; margin-bottom: 10px;"><b>Рекомендуем посмотреть:</b></div>     
    <div style="background-color: #fafbfb; border: 1px solid #d3dcdd; padding: 0px 20px 0px 20px;">         
    <table width="100%" cellpadding="0" cellspacing="0">
        <tbody>
';
$MESS['WZD_TEMP_LIST_RECOMMEND'] = '
                <tr>
                    <td width="110px" style="vertical-align: top; padding-bottom: 20px;padding-top: 20px; #BORDER_TABLE_STYLE#">
                        <a href="#DETAIL_PAGE_URL#"><img src="#PICTURE_SRC#" width="#PICTURE_WIDTH#" height="#PICTURE_HEIGHT#" /></a>     
                    </td>
                    <td style="vertical-align: top; padding-bottom: 20px;padding-top: 20px; #BORDER_TABLE_STYLE#">
                        <a href="#DETAIL_PAGE_URL#" style="color: #353535; font-size: 14px"; >#NAME#</a> <br />
                        <br />
                         #PREVIEW_TEXT#
                    </td>
                    <td  style="vertical-align: top; padding-bottom: 20px;padding-top: 20px; #BORDER_TABLE_STYLE#">
                        <s style="color:red;display:block;">#PRINT_NO_DISCOUNT_PRICE#</s>
                        <b style="white-space: nowrap">#PRINT_PRICE#</b>
                    </td>                    
                </tr>   
';
$MESS['WZD_TEMP_BOTTOM_RECOMMEND'] = '
        </tbody>
    </table>
</div>
';


// просмотренные товары
$MESS['WZD_TEMPLATE_PARAMS_TEMP_TOP_VIEWED'] = '
    <div style="background-color: #89cbf5; padding: 5px 10px 5px 10px;color: #FFFFFF; margin-bottom: 10px;"><b>Вы интересовались:</b></div> 
    <div style="background-color: #fafbfb; border: 1px solid #d3dcdd; padding: 0px 20px 0px 20px;">         
    <table width="100%" cellpadding="0" cellspacing="0">
        <tbody>
';
$MESS['WZD_TEMPLATE_PARAMS_TEMP_LIST_VIEWED'] = '
                <tr>
                    <td width="110px" style="vertical-align: top; padding-bottom: 20px;padding-top: 20px; #BORDER_TABLE_STYLE#">
                        <a href="#DETAIL_PAGE_URL#"><img src="#PICTURE_SRC#" width="#PICTURE_WIDTH#" height="#PICTURE_HEIGHT#" /></a>     
                    </td>
                    <td style="vertical-align: top; padding-bottom: 20px;padding-top: 20px; #BORDER_TABLE_STYLE#">
                        <a href="#DETAIL_PAGE_URL#" style="color: #00b6f4; font-size: 14px"; >#NAME#</a> <br />
                        <br />
                         #PREVIEW_TEXT#
                    </td>
                    <td  style="vertical-align: top; padding-bottom: 20px;padding-top: 20px; #BORDER_TABLE_STYLE#">
                        <s style="color:red;display:block;">#PRINT_NO_DISCOUNT_PRICE#</s>
                        <b style="white-space: nowrap">#PRINT_PRICE#</b>
                    </td>                    
                </tr>   
';
$MESS['WZD_TEMPLATE_PARAMS_TEMP_BOTTOM_VIEWED'] = '
        </tbody>
    </table>
    </div>
';
     
     
     
// новинки товаров     
$MESS['WZD_TEMP_NOVELTY_GOODS_TOP'] = '
    <div style="background-color: #f4f3f2; padding: 5px 10px 5px 10px;color: #353535; margin-bottom: 10px;"><b>Новинки раздела #SECTION_NAME#:</b></div>
         
    <div style="background-color: #fafbfb; border: 1px solid #d3dcdd; padding: 0px 20px 0px 20px;">         
    <table width="100%" cellpadding="0" cellspacing="0">
        <tbody>

';
$MESS['WZD_TEMP_NOVELTY_GOODS_LIST'] = '
                <tr>
                    <td width="110px" style="vertical-align: top; padding-bottom: 20px;padding-top: 20px; #BORDER_TABLE_STYLE#">
                        <a href="#DETAIL_PAGE_URL#"><img src="#PICTURE_SRC#" width="#PICTURE_WIDTH#" height="#PICTURE_HEIGHT#" /></a>     
                    </td>
                    <td style="vertical-align: top; padding-bottom: 20px;padding-top: 20px; #BORDER_TABLE_STYLE#">
                        <a href="#DETAIL_PAGE_URL#" style="color: #353535; font-size: 14px"; >#NAME#</a> <br />
                        <br />
                         #PREVIEW_TEXT#
                    </td>
                    <td  style="vertical-align: top; padding-bottom: 20px;padding-top: 20px; #BORDER_TABLE_STYLE#">
                        <s style="color:red;display:block;">#PRINT_NO_DISCOUNT_PRICE#</s>
                        <b style="white-space: nowrap">#PRINT_PRICE#</b>
                    </td>                    
                </tr>  
';
$MESS['WZD_TEMP_NOVELTY_GOODS_BOTTOM'] = '
        </tbody>
    </table>
</div>
<br />
';     

// брошенные корзины
$MESS['WZD_TEMP_FORGET_BASKET_TOP'] = '
<div style="background-color: #f4f3f2; padding: 5px 10px 5px 10px;color: #353535; margin-bottom: 10px;"><b>Товары в корзине:</b></div>     
<div style="background-color: #fafbfb; border: 1px solid #d3dcdd; padding: 0px 20px 0px 20px;">         
    <table width="100%" cellpadding="0" cellspacing="0">
        <tbody>


';
$MESS['WZD_TEMP_FORGET_BASKET_LIST'] = '
                <tr>
                    <td width="110px" style="vertical-align: top; padding-bottom: 20px;padding-top: 20px; #BORDER_TABLE_STYLE#">
                        <a href="#PRODUCT_DETAIL_PAGE_URL#"><img src="#PRODUCT_PICTURE_SRC#" width="#PRODUCT_PICTURE_WIDTH#" height="#PRODUCT_PICTURE_HEIGHT#" /></a>     
                    </td>
                    <td style="vertical-align: top; padding-bottom: 20px;padding-top: 20px; #BORDER_TABLE_STYLE#">
                        <a href="#PRODUCT_DETAIL_PAGE_URL#" style="color: #353535; font-size: 14px"; >#BASKET_NAME#</a> <br />
                        <br />
                         Количество: #BASKET_QUANTITY# 
                    </td>
                    <td width="100px" style="vertical-align: top; padding-bottom: 20px;padding-top: 20px; #BORDER_TABLE_STYLE#" align="center">
                        <b style=" font-size: 16px;"> #BASKET_PRICE_FORMAT# </b>            
                    </td>
                </tr>     
';
$MESS['WZD_TEMP_FORGET_BASKET_BOTTOM'] = '
        </tbody>
    </table>
</div>
';  


     
     
$MESS['WZD_CATEGORY_MISS_NAME'] = 'B2BShop Акции, скидки и новости';     
$MESS['WZD_CATEGORY_MISS_DESCRIPTION'] = 'Категория для подписчиков сайта собранных через сборщики e-mail';   

?>