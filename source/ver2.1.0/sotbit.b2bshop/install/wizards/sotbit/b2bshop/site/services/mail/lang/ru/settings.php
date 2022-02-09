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
		<p>Вы делали у нас заказ №#ORDER_ID#, мы следим за нашим сервисом, нам важно мнение каждого клиентам о нашей работе. Поэтому просим вас оценить нас на яндекс-маркет, для этого перейдите по <a href="http://market.yandex.ru/shop/18433/reviews?from=18433" >ссылке</a> .</p>
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
	<table width="698px" align="center" cellpadding="0" cellspacing="0" style="border: 1px solid #e3e3e3;">
	  <tr>
		  <td>
			  <table width="100%" align="center" cellpadding="0" cellspacing="0" >
				  <tr bgcolor="#f8f8f8" height="26px">
					  <td width="40px" valign="top"  style="text-align: right; padding-right: 10px">
						 <img src="#TEMPL_URL#img/mail_img/letter_b2b_shop_header_phone.png" alt="" style="margin-top: 35px;"/>
					  </td>
					  <td valign="top" style="font-size: 14px; font-weight: bold; " width="150px">
						<p style="margin-top: 30px;"> 8 (495) 988-46-18<br />8 (800) 100-46-18</p>
					  </td>
					  <td align="center" width="300px">
						<a href="#SITE_URL#"><img src="#TEMPL_URL#img/mail_img/letter_b2b_shop_header_logo.png" /></a>
					  </td>
					  <td width="20px" valign="top" >
						 <img src="#TEMPL_URL#img/mail_img/letter_b2b_shop_header_email.png" alt="" style="margin-top: 35px;"/>
					  </td>
					  <td valign="top" style="font-size: 14px; font-weight: bold;" width="170px">
						<p style="margin-bottom: 0px; margin-top: 30px;">b2b_shop@mail.ru</p>
					  </td>
				  </tr>
			  </table>
		  </td>
	  </tr>
	  <tr>
		  <td>
			  <table width="100%" align="center" cellpadding="0" cellspacing="0" style="border-top: 1px solid #e3e3e3;border-bottom: 1px solid #e3e3e3; box-shadow: 0px 4px 19px 2px #dedede; -webkit-box-shadow:  0px 4px 19px 2px #dedede; -moz-box-shadow:  0px 4px 19px 2px #dedede;">
				<tr bgcolor="#f4f3f2" height="30px">
					<td width="10px"></td>
					<td style="font-size: 16px;" align="center"><a href="#SITE_URL#/catalog/bluzki/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">БЛУЗКИ</a></td>
					<td style="font-size: 16px;" align="center"><a href="#SITE_URL#/catalog/obuv/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">ОБУВЬ</a></td>
					<td style="font-size: 16px;" align="center"><a href="#SITE_URL#/catalog/platya/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">ПЛАТЬЯ</a></td>
					<td style="font-size: 16px;" align="center"><a href="#SITE_URL#/catalog/kofty/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">КОФТЫ</a></td>
					<td style="font-size: 16px;" align="center"><a href="#SITE_URL#/brands/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">БРЕНДЫ</a></td>
					<td style="font-size: 16px;" align="center"><a href="#SITE_URL#/help/delivery/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">ДОСТАВКА</a></td>
					<td width="10px"></td>
				</tr>
			  </table>
		  </td>
	  </tr>
	  <tr>
		  <td style="padding: 10px 56px 10px 60px;">
				#MESSAGE_TEXT#
			<table cellpadding="0" cellspacing="0" style="margin: 16px 0px 0px 0px; height: 254px; width: 578px; background: #FEF6F6; border: 1px solid #dedede; box-shadow:  0px 3px 12px 2px #dedede; -webkit-box-shadow:  0px 3px 12px 2px #dedede; -moz-box-shadow:  0px 3px 12px 2px #dedede;">
				  <tr>
					  <td style="padding-left: 23px; padding-right: 46px; padding-top: 0px;">
						  <img src="#TEMPL_URL#img/mail_img/letter_b2b_shop_banner1_devices.png" alt="" />
					  </td>
					  <td>
						  <p style="font-size: 14.39px; color: #e9b8c8; margin-bottom: 0px; margin-top: 28px;">Ваш любимый</p>
						  <h3 style="font-size: 30.08px; color: #e9b8c8; margin-top: 0px; margin-bottom: 5px;">магазин B2B Shop</h3>
						  <h4 style="font-size: 23.38px; margin-top: 12px; margin-bottom: 16px; font-style: italic;">Всегда и везде с вами</h4>
						  <p style="font-size: 14px; margin-top: 0px;">Совершайте покупки на работе за компьютером, дома с ноутбуком или прямо со своего смартфона</p>
						  <p align="right" style="margin-top: -30px;"><img src="#TEMPL_URL#img/mail_img/letter_b2b_shop_banner1_bird.png"></p>
					  </td>
				  </tr>
			  </table>


		  </td>
	  </tr>

	  <tr>
		  <td>
			  <table cellpadding="0" cellspacing="0" style="background: #F1EEED; border-top: 1px solid #BBBBBB; margin-top: 22px; height: 246px;">
				  <tr height="32"><td></td></tr>
				  <tr>
					  <td width="175px" style="padding-top: 0px; padding-left: 60px;" valign="top">
						  <h3 style="margin-top: 0px; font-size: 20px;">О КОМПАНИИ</h3>
						  <p style="margin-bottom: 8px; font-size: 14px;"><a href="#SITE_URL#/about/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">О нас</a></p>
						  <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/about/work/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">Работа у нас</a></p>
						  <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/about/shops/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">Посетите наши магазины</a></p>
						  <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/about/contacts/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">Контакты</a></p>
						  <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/news/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">Новости</a></p>
						  <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/about/circumstances.php?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">Постановления и условия</a></p>
					  </td>
					  <td width="178px" style="padding-top: 0px; padding-left: 25px; padding-right: 15px; border-left: 1px solid #DCD7D5; border-right: 1px solid #DCD7D5;" valign="top">
						  <h3 style="margin-top: 0px; font-size: 20px;">КЛИЕНТАМ</h3>
						  <p style="margin-bottom: 8px; font-size: 14px;"><a href="#SITE_URL#/clients/table_sizes/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">Таблица размеров</a></p>
						  <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/clients/help_choice/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">Помощь в подборе</a></p>
						  <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/clients/refuse_dispatch/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">Гарантия возврата</a></p>
						  <p style="margin-bottom: 8px; margin-top: 8px; font-size: 14px;"><a href="#SITE_URL#/clients/requirements_clients/?utm_source=newsletter&utm_medium=email&utm_campaign=b2bshop_mailing" target="_blank" style="text-decoration: none; color: #000000;">Требования к клиентам</a></p>
						  <p style="float: right; margin: 0;"><img src="#TEMPL_URL#img/mail_img/b-fly.png" alt="" /></p>
					  </td>
					  <td width="223px" style="padding-top: 0px; padding-left: 20px;" valign="top">
						  <h3 style="font-size: 20px; margin-bottom: 14px; margin-top: 0px;">КОНТАКТЫ</h3>
						  <p style="margin-top: 3px; margin-bottom: 16px; font-size: 14px; color: #986e6e">b2b_shop@mail.ru</p>
						  <p style="margin-bottom: 4px; font-family: Arial; font-size: 16px; color: #d48499">8 (495) 988-46-18</p>
						  <p style="margin-top: 5px; margin-bottom: 10px; font-family: Arial; font-size: 16px; color: #d48499">8 (800) 100-46-18</p>
						  <table cellpadding="0" cellspacing="0" style="border: 1px solid #787776; background-color: #f4f3f2; padding: 9px 18px 5px 17px">
							  <tr>
								  <td style="padding-right: 8px;"><a href="https://vk.com/sotbit" target="_blank"><img src="#TEMPL_URL#img/mail_img/letter_b2b_shop_footer_vk.png" alt="" /></a></td>
								  <td style="padding-right: 8px;"><a href="https://www.facebook.com/sotbit" target="_blank"><img src="#TEMPL_URL#img/mail_img/letter_b2b_shop_footer_facebook.png" alt="" /></a></td>
								  <td style="padding-right: 8px;"><a href="https://twitter.com/sotbit" target="_blank"><img src="#TEMPL_URL#img/mail_img/letter_b2b_shop_footer_twitter.png" alt="" /></a></td>
								  <td><a href="#" target="_blank"><img src="#TEMPL_URL#img/mail_img/letter_b2b_shop_footer_google.png" alt="" /></a></td>
							  </tr>
						  </table>
						  <p style="float: right; padding-right: 20px; margin: 0;"><img src="#TEMPL_URL#img/mail_img/bird-small.png" alt="" /></p>
					  </td>
				  </tr>
				  <tr height="30" >
					<td style="text-align:center;" colspan="3" > <a style="color: #353535; font-size: 14px" href="#SITE_URL#/?MAILING_MESSAGE=#MAILING_MESSAGE#&MAILING_UNSUBSCRIBE=#MAILING_UNSUBSCRIBE#&utm_source=newsletter&utm_medium=email&utm_campaign=sotbit_mailing_#MAILING_EVENT_ID#"  >Отписаться от рассылки</a></td>
				  </tr>
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





$MESS['WZD_MAIL_SALE_NEW_ORDER_SUBJECT'] = '#SITE_NAME#: Новый заказ №#ORDER_ID#';
$MESS["WZD_MAIL_SALE_NEW_ORDER_BODY"] = '<span style="font: 22px "Proxima Nova", Arial, sans-serif;color: #070908;font-weight: bold;line-height:44px;display: block; -webkit-text-size-adjust:none;">Ваш заказ принят</span> <span style="font: 14px "Proxima Nova", Arial, sans-serif;color: #797e81;line-height:20px;display: block; -webkit-text-size-adjust:none;">В данный момент ваш заказ принят и мы уже его формируем.<br>
Ознакомьтесь с данными вашего заказа:</span>
											<?

										   EventMessageThemeCompiler::includeComponent(
												"bitrix:sale.personal.order.detail.mail",
												"b2bshop",
												array(
													"ACTIVE_DATE_FORMAT" => "d.m.Y",
													"CACHE_TIME" => "3600",
													"CACHE_TYPE" => "A",
													"CUSTOM_SELECT_PROPS" => array(
														0 => "NAME",
														1 => "QUANTITY",
														2 => "PROPERTY_CML2_ARTICLE",
														3 => "PRICE_FORMATED"
													),
													"ID" => "{#ORDER_ID#}",
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
													"SHOW_PAYMENT_BUTTON" => "N", // кнопка "Повторить оплату" при неудачной оплате (Y или N),
"UTM" => "{#UTM#}"
												),
												false
											);
											?>
									   <?
										EventMessageThemeCompiler::includeComponent(
											"sotbit:sotbit.mailing.products.mail",
											"b2bshop",
											Array(
												"BLOCK_TITLE" => "Вас может заинтересовать",
												"COUNT_PRODUCT" => "4",
												"LIST_ITEM_ID" => array(0=>"",),
												"LIST_ITEM_ID_OUR" => "{#RECOMMEND_PRODUCT_ID#}",
												"ORDER_ID" => "{#ORDER_ID#}",
												"TYPE_WORK" => "BUYER"
											)
										);?>';

$MESS["WZD_MAIL_SALE_ORDER_PAID_SUBJECT"] = "#SITE_NAME#: Заказ №#ORDER_ID# оплачен";
$MESS["WZD_MAIL_SALE_ORDER_PAID_BODY"] = '<span style="font: 22px "Proxima Nova", Arial, sans-serif;color: #070908;font-weight: bold;line-height:44px;display: block; -webkit-text-size-adjust:none;">Ваш заказ №#ORDER_ID#&nbsp;оплачен</span><span style="font: 14px "Proxima Nova", Arial, sans-serif;color: #797e81;line-height:20px;display: block; -webkit-text-size-adjust:none;">Ознакомьтесь с данными вашего заказа:<br>
 <br>
 </span>
											<?
										   EventMessageThemeCompiler::includeComponent(
												"bitrix:sale.personal.order.detail.mail",
												"b2bshop",
												array(
													"ACTIVE_DATE_FORMAT" => "d.m.Y",
													"CACHE_TIME" => "3600",
													"CACHE_TYPE" => "A",
													"CUSTOM_SELECT_PROPS" => array(
														0 => "NAME",
														1 => "QUANTITY",
														2 => "PROPERTY_CML2_ARTICLE",
														3 => "PRICE_FORMATED"
													),
													"ID" => "{#ORDER_ID#}",
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
													"SHOW_PAYMENT_BUTTON" => "N",
"UTM" => "{#UTM#}"
												),
												false
											);
											?>
										<?
										EventMessageThemeCompiler::includeComponent(
											"sotbit:sotbit.mailing.products.mail",
											"b2bshop",
											Array(
												"BLOCK_TITLE" => "Вас может заинтересовать",
												"COUNT_PRODUCT" => "4",
												"LIST_ITEM_ID" => array(0=>"",),
												"LIST_ITEM_ID_OUR" => "{#RECOMMEND_PRODUCT_ID#}",
												"ORDER_ID" => "{#ORDER_ID#}",
												"TYPE_WORK" => "BUYER"
											)
										);?>';



$MESS['WZD_MAIL_SALE_ORDER_CANCEL_SUBJECT'] = '#SITE_NAME#: Отмена заказа N#ORDER_ID#';
$MESS["WZD_MAIL_SALE_ORDER_CANCEL_BODY"] = '
											<span style="font: 22px "Proxima Nova", Arial, sans-serif;color: #070908;font-weight: bold;line-height:44px;display: block; -webkit-text-size-adjust:none;">Заказ №#ORDER_ID# отменен</span>
											<span style="font: 14px "Proxima Nova", Arial, sans-serif;color: #797e81;line-height:20px;display: block; -webkit-text-size-adjust:none;">#ORDER_CANCEL_DESCRIPTION#</span>
<span style="font: 14px "Proxima Nova", Arial, sans-serif;color: #797e81;line-height:22px;display: block; -webkit-text-size-adjust:none;">Для получения подробной информации по заказу пройдите на сайт #SERVER_NAME#/personal/order/#ORDER_ID#/</span>
									  ';

$MESS['WZD_MAIL_SALE_STATUS_CHANGED_F_SUBJECT'] = '#SERVER_NAME#: Заказ №#ORDER_ID# успешно завершен';
$MESS["WZD_MAIL_SALE_STATUS_CHANGED_F_BODY"] = '<span style="font: 22px "Proxima Nova", Arial, sans-serif;color: #070908;font-weight: bold;line-height:44px;display: block; -webkit-text-size-adjust:none;">Ваш №#ORDER_ID#&nbsp;заказ исполнен</span><span style="color: #797e81; font-family: &quot;Proxima Nova&quot;, Arial, sans-serif; font-size: 14px;">Ознакомьтесь с данными вашего заказа:</span><span style="font: 14px "Proxima Nova", Arial, sans-serif;color: #797e81;line-height:20px;display: block; -webkit-text-size-adjust:none;"><br>
</span>
										  <?
										   EventMessageThemeCompiler::includeComponent(
												"bitrix:sale.personal.order.detail.mail",
												"b2bshop",
												array(
													"ACTIVE_DATE_FORMAT" => "d.m.Y",
													"CACHE_TIME" => "3600",
													"CACHE_TYPE" => "A",
													"CUSTOM_SELECT_PROPS" => array(
														0 => "NAME",
														1 => "QUANTITY",
														2 => "PROPERTY_CML2_ARTICLE",
														3 => "PRICE_FORMATED"
													),
													"ID" => "{#ORDER_ID#}",
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
													"SHOW_PAYMENT_BUTTON" => "N",
"UTM" => "{#UTM#}"
												),
												false
											);
											?>
										<?
										EventMessageThemeCompiler::includeComponent(
											"sotbit:sotbit.mailing.products.mail",
											"b2bshop",
											Array(
												"BLOCK_TITLE" => "Вас может заинтересовать",
												"COUNT_PRODUCT" => "4",
												"LIST_ITEM_ID" => array(0=>"",),
												"LIST_ITEM_ID_OUR" => "{#RECOMMEND_PRODUCT_ID#}",
												"ORDER_ID" => "{#ORDER_ID#}",
												"TYPE_WORK" => "BUYER"
											)
										);?>';

$MESS['WZD_MAIL_SALE_STATUS_CHANGED_N_SUBJECT'] = '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#';
$MESS["WZD_MAIL_SALE_STATUS_CHANGED_N_BODY"] = ' <span style="font: 22px "Proxima Nova", Arial, sans-serif;color: #070908;font-weight: bold;line-height:44px;display: block; -webkit-text-size-adjust:none;">Статус вашего заказа изменен</span> <span style="font: 14px "Proxima Nova", Arial, sans-serif;color: #797e81;line-height:20px;display: block; -webkit-text-size-adjust:none;">Новый статус заказа: #ORDER_STATUS#</span>

		 <? EventMessageThemeCompiler::includeComponent(
											"sotbit:sotbit.mailing.products.mail",
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
	';
$MESS['WZD_MAIL_SALE_STATUS_CHANGED_P_SUBJECT'] = '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#';
$MESS["WZD_MAIL_SALE_STATUS_CHANGED_P_BODY"] = '<span style="font: 22px "Proxima Nova", Arial, sans-serif;color: #070908;font-weight: bold;line-height:44px;display: block; -webkit-text-size-adjust:none;">Ваш заказ оплачен</span> <span style="font: 14px "Proxima Nova", Arial, sans-serif;color: #797e81;line-height:20px;display: block; -webkit-text-size-adjust:none;">Ваш заказ оплачен, идет формирование к отгрузке.</span>

		 <?EventMessageThemeCompiler::includeComponent(
											"sotbit:sotbit.mailing.products.mail",
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
	';

$MESS['WZD_MAIL_SALE_STATUS_CHANGED_A_SUBJECT'] = '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#';
$MESS["WZD_MAIL_SALE_STATUS_CHANGED_A_BODY"] = '<span style="font: 22px "Proxima Nova", Arial, sans-serif;color: #070908;font-weight: bold;line-height:44px;display: block; -webkit-text-size-adjust:none;">Статус вашего заказа изменен</span>
											<span style="font: 14px "Proxima Nova", Arial, sans-serif;color: #797e81;line-height:20px;display: block; -webkit-text-size-adjust:none;">Новый статус заказа: #ORDER_STATUS#</span>

										<?EventMessageThemeCompiler::includeComponent(
											"sotbit:sotbit.mailing.products.mail",
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

	';
$MESS['WZD_MAIL_SALE_STATUS_CHANGED_C_SUBJECT'] = '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#';
$MESS["WZD_MAIL_SALE_STATUS_CHANGED_C_BODY"] = '<span style="font: 22px "Proxima Nova", Arial, sans-serif;color: #070908;font-weight: bold;line-height:44px;display: block; -webkit-text-size-adjust:none;">Статус вашего заказа изменен</span>
											<span style="font: 14px "Proxima Nova", Arial, sans-serif;color: #797e81;line-height:20px;display: block; -webkit-text-size-adjust:none;">Новый статус заказа: #ORDER_STATUS#</span>

<?										EventMessageThemeCompiler::includeComponent(
											"sotbit:sotbit.mailing.products.mail",
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
	';
$MESS['WZD_MAIL_TICKET_CHANGE_BY_SUPPORT_FOR_AUTHOR_SUBJECT'] = '[TID##ID#] ответ в обращении "#TITLE#"';
$MESS["WZD_MAIL_TICKET_CHANGE_BY_SUPPORT_FOR_AUTHOR_BODY"] = '<p style="font-size: 20px;font-weight: bold;">
	 Новый ответ на Ваше обращение <a href="http://#SERVER_NAME##PUBLIC_EDIT_URL#?ID=#ID#">№#ID#</a>
</p>
 <br>
 Отвечаем на ваше обращение «#TITLE#»<br>
 От кого: #MESSAGE_AUTHOR_USER_NAME# <br>
 <br>
 <b>Ответ:</b> <br>
 #MESSAGE_BODY# <br>
 #FILES_LINKS#&nbsp;<br>
<p>
 <b> <a style="font: 14px \'Proxima Nova\', Arial, sans-serif;color: #000000;text-transform:uppercase;text-decoration: none;line-height:30px;display: block;float: right;max-width:204px; width: 100%; text-align: center;border: 1px solid #d3d3d3; -webkit-text-size-adjust:none;" href="http://#SERVER_NAME##PUBLIC_EDIT_URL#?ID=#ID#">Ответить</a> <br>
 </b>
</p>
<p>
 <b><br>
 </b>
</p>
<p>
 <b>Помогите нам стать лучше! </b>
</p>
<p>
	 Пожалуйста, оцените нашу работу. Это займет не более минуты. Выберите один из вариантов в блоке <a href="http://#SERVER_NAME##PUBLIC_EDIT_URL#?ID=#ID#">Оцените нашу работу</a>.
</p>';
?>