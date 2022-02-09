<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("sotbit.mailing") || !CModule::IncludeModule("catalog") || !CModule::IncludeModule("iblock"))
    return;     
    
if(COption::GetOptionString("sotbit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
    return;

WizardServices::IncludeServiceLang("settings.php", 'ru');


// создадим скидку с купоном
// START
$arrDiscount = array();
$dbDiscount = CCatalogDiscount::GetList(array(),array('NAME'=>GetMessage("WZD_DISCOUNT_NANE")));  
$resDiscount = $dbDiscount->Fetch();
if($resDiscount) {
    $discount_ID = $resDiscount['ID'];    
} else {
 
    $discountCreate = Array (
        "SITE_ID" => WIZARD_SITE_ID,
        "ACTIVE" => "Y",
        "RENEWAL" => "N",
        "NAME" => GetMessage("WZD_DISCOUNT_NANE"),
        "SORT" => 100,
        "MAX_DISCOUNT" => 0,
        "VALUE_TYPE" => "P",
        "VALUE" => 5,
        "CURRENCY" => 'RUB',
        "CONDITIONS" => Array(
            'CLASS_ID' => 'CondGroup',
            'DATA' => array(
                'ALL' => 'AND',
                'True' => 'True'
            ),
            'CHILDREN' => array()
        )
    );
 
    $discount_ID = CCatalogDiscount::Add($discountCreate);
    if($discount_ID) {
        global $DB ;
        $COUPON = CatalogGenerateCoupon();
        $arCouponFields = array(
                "DISCOUNT_ID" => $discount_ID,
                "ACTIVE" => "Y",
                "ONE_TIME" => 'O',
                "COUPON" => $COUPON,
                "DATE_APPLY" => Date($DB->DateFormatToPHP(CLang::GetDateFormat("FULL", WIZARD_SITE_ID)))
        ); 
        CCatalogDiscountCoupon::Add($arCouponFields);                
    }
                 
}
// END


// создадим сценарии
// START
$arrevent = array();
$dbevent = CSotbitMailingEvent::GetList();
while($resevent = $dbevent->Fetch()) {
    $arrevent[$resevent['NAME']] = $resevent;      
}


$eventCreate = array();
// регистрация пользователя
if(empty($arrevent[GetMessage('WZD_user_register_mailing_1_NAME')])){ 
    
    $eventCreate[] = array(
        'ACTIVE' => 'Y',
        'NAME' => GetMessage('WZD_user_register_mailing_1_NAME'),
        'DESCRIPTION' =>  GetMessage('WZD_user_register_mailing_1_DESCRIPTION'),
        'SORT' => '100',
        'MODE' => 'WORK',
        'SITE_URL' => 'http://'.$_SERVER['SERVER_NAME'],
        'USER_AUTH' => 'Y',
        'TEMPLATE' => 'user_register_mailing',
        'EVENT_TYPE' => 'SOTBIT_MAILING_EVENT_SEND',
        'EVENT_SEND_SYSTEM' => 'BITRIX',
        'EXCLUDE_UNSUBSCRIBED_USER' => 'ALL',
        'EXCLUDE_HOUR_AGO' => '0', 
        'AGENT_TIME_START' => '8',
        'AGENT_TIME_END' => '22',
        'AGENT_ACTIVE' => 'N',  
        'AGENT_INTERVAL' => '3600',         
        //параметры рассылки     
        'TEMPLATE_PARAMS' => array(
            'SUBJECT' => GetMessage('WZD_user_register_mailing_1_SUBJECT'),
            'EMAIL_FROM' => $wizard->GetVar("shopEmail"),
            'EMAIL_TO' => "#USER_EMAIL#",
            'MESSAGE_TYPE' => 'html',            
            'MESSAGE' => GetMessage('WZD_TEMPLATE_PARAMS_MESSAGE',array('#MESSAGE_TEXT#' => GetMessage('WZD_user_register_mailing_1_MESSAGE_TEXT'),'#SITE_URL#'=>'http://'.$_SERVER['SERVER_NAME'],'#TEMPL_URL#'=>'http://'.$_SERVER['SERVER_NAME'].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/")),
            // рекомендованные товары
            'RECOMMEND_SHOW' => 'N',  
            // просмотренные товары
            'VIEWED_SHOW' => 'Y',
            'IBLOCK_TYPE_VIEWED'=> 'ms_catalog',
            'IBLOCK_ID_VIEWED' => $_SESSION["WIZARD_CATALOG_IBLOCK_ID"],
            'TOP_COUNT_FILLTER_VIEWED' => '4',
            'SORT_BY_VIEWED' => 'DATE_VISIT',
            'SORT_ORDER_VIEWED' => 'DESC',
            'PRICE_TYPE_VIEWED' => 'BASE',
            'IMG_WIDTH_VIEWED' => '100',
            'IMG_HEIGHT_VIEWED' => '200',
            'TEMP_TOP_VIEWED' => GetMessage('WZD_TEMPLATE_PARAMS_TEMP_TOP_VIEWED'),
            'TEMP_LIST_VIEWED' => GetMessage('WZD_TEMPLATE_PARAMS_TEMP_LIST_VIEWED'),
            'TEMP_BOTTOM_VIEWED' => GetMessage('WZD_TEMPLATE_PARAMS_TEMP_BOTTOM_VIEWED'),
            // купоны
            'COUPON_ADD' => 'Y',
            'COUPON_DISCOUNT_ID' => $discount_ID,
            'COUPON_ONE_TIME' => 'O',
            'COUPON_TIME_LIFE' => '48',
            'COUPON_TIME_LIFE_ACTION' => 'DELETE'        
        ),      
    ); 
    
} 
elseif($arrevent[GetMessage('WZD_user_register_mailing_1_NAME')]['TEMPLATE'] == 'user_register_mailing') {
    $ID_user_register_mailing = $arrevent[GetMessage('WZD_user_register_mailing_1_NAME')]['ID'];           
}   

// новинки категории товаров
if(empty($arrevent[GetMessage('WZD_mailimg_list_novelty_section_id_1_NAME')])){

    $eventCreate[] = array(
        'ACTIVE' => 'Y',
        'NAME' => GetMessage('WZD_mailimg_list_novelty_section_id_1_NAME'),
        'DESCRIPTION' =>  GetMessage('WZD_mailimg_list_novelty_section_id_1_DESCRIPTION'),
        'SORT' => '100',
        'MODE' => 'WORK',
        'SITE_URL' => 'http://'.$_SERVER['SERVER_NAME'],
        'USER_AUTH' => 'Y',
        'TEMPLATE' => 'mailimg_list_novelty_section_id',
        'EVENT_TYPE' => 'SOTBIT_MAILING_EVENT_SEND',
        'EVENT_SEND_SYSTEM' => 'BITRIX',
        'EXCLUDE_UNSUBSCRIBED_USER' => 'ALL',
        'EXCLUDE_HOUR_AGO' => '336', 
        'AGENT_TIME_START' => '8',
        'AGENT_TIME_END' => '22',
        'AGENT_ACTIVE' => 'Y',    
        'AGENT_INTERVAL' => '604800',               
        //параметры рассылки     
        'TEMPLATE_PARAMS' => array(
            'SUBJECT' => GetMessage('WZD_mailimg_list_novelty_section_id_1_SUBJECT'),
            'EMAIL_FROM' => $wizard->GetVar("shopEmail"),
            'EMAIL_TO' => "#SUBSCRIBLE_EMAIL_TO#",
            'MESSAGE_TYPE' => 'html',            
            'MESSAGE' => GetMessage('WZD_TEMPLATE_PARAMS_MESSAGE',array('#MESSAGE_TEXT#' => GetMessage('WZD_mailimg_list_novelty_section_id_1_MESSAGE_TEXT'),'#SITE_URL#'=>'http://'.$_SERVER['SERVER_NAME'],'#TEMPL_URL#'=>'http://'.$_SERVER['SERVER_NAME'].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/")),
            // новинки
            'NOVELTY_GOODS_DATE_CREATE_from' => '0',
            'NOVELTY_GOODS_DATE_CREATE_to'=> '7',
            'NOVELTY_GOODS_DATE_CREATE_type' => 'DAYS',
            'IBLOCK_TYPE_NOVELTY_GOODS' => 'ms_catalog',
            'IBLOCK_ID_NOVELTY_GOODS' => $_SESSION["WIZARD_CATALOG_IBLOCK_ID"],
            'TOP_COUNT_FILLTER_NOVELTY_GOODS_FROM' => '1',
            'TOP_COUNT_FILLTER_NOVELTY_GOODS_TO' => '7',
            'SORT_BY_NOVELTY_GOODS' => 'SORT',
            'SORT_ORDER_NOVELTY_GOODS' => 'ASC',
            'PRICE_TYPE_NOVELTY_GOODS' => 'BASE',   
            'NOVELTY_GOODS_IMG_WIDTH' => '100',
            'NOVELTY_GOODS_IMG_HEIGHT' => '200',
            'TEMP_NOVELTY_GOODS_TOP' => GetMessage('WZD_TEMP_NOVELTY_GOODS_TOP'),
            'TEMP_NOVELTY_GOODS_LIST' => GetMessage('WZD_TEMP_NOVELTY_GOODS_LIST'), 
            'TEMP_NOVELTY_GOODS_BOTTOM' => GetMessage('WZD_TEMP_NOVELTY_GOODS_BOTTOM'),    
            // рекомендованные товары
            'RECOMMEND_SHOW' => 'N',  
            // просмотренные товары
            'VIEWED_SHOW' => 'N',                 
            // купоны
            'COUPON_ADD' => 'N',       
        ),      
    );
               
} 

// брошенные корзины
if(empty($arrevent[GetMessage('WZD_forgotten_basket_discount_1_NAME')])){

    $eventCreate[] = array(
        'ACTIVE' => 'Y',
        'NAME' => GetMessage('WZD_forgotten_basket_discount_1_NAME'),
        'DESCRIPTION' =>  GetMessage('WZD_forgotten_basket_discount_1_DESCRIPTION'),
        'SORT' => '100',
        'MODE' => 'WORK',
        'SITE_URL' => 'http://'.$_SERVER['SERVER_NAME'],
        'USER_AUTH' => 'Y',
        'TEMPLATE' => 'forgotten_basket_discount',
        'EVENT_TYPE' => 'SOTBIT_MAILING_EVENT_SEND',
        'EVENT_SEND_SYSTEM' => 'BITRIX',
        'EXCLUDE_UNSUBSCRIBED_USER' => 'ALL',
        'EXCLUDE_HOUR_AGO' => '336', 
        'AGENT_TIME_START' => '8',
        'AGENT_TIME_END' => '23',
        'AGENT_ACTIVE' => 'Y',    
        'AGENT_INTERVAL' => '28800',               
        //параметры рассылки     
        'TEMPLATE_PARAMS' => array(
            'SITE_ID' => WIZARD_SITE_ID,
            'BASKET_DATE_UPDATE_from' => '44',
            'BASKET_DATE_UPDATE_to' => '54',
            'BASKET_DATE_UPDATE_type' => 'HOURS',
            'SUBJECT' => GetMessage('WZD_forgotten_basket_discount_1_SUBJECT'),
            'EMAIL_FROM' => $wizard->GetVar("shopEmail"),
            'EMAIL_TO' => "#USER_EMAIL#",
            'MESSAGE_TYPE' => 'html',
            'MESSAGE' => GetMessage('WZD_TEMPLATE_PARAMS_MESSAGE',array('#MESSAGE_TEXT#' => GetMessage('WZD_forgotten_basket_discount_1_MESSAGE_TEXT'),'#SITE_URL#'=>'http://'.$_SERVER['SERVER_NAME'],'#TEMPL_URL#'=>'http://'.$_SERVER['SERVER_NAME'].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/")),
            // список товаров корзины
            'FORGET_BASKET_IMG_WIDTH' => '100',
            'FORGET_BASKET_IMG_HEIGHT'=> '200',
            'TEMP_FORGET_BASKET_TOP' => GetMessage('WZD_TEMP_FORGET_BASKET_TOP'), 
            'TEMP_FORGET_BASKET_LIST' => GetMessage('WZD_TEMP_FORGET_BASKET_LIST'), 
            'TEMP_FORGET_BASKET_BOTTOM' => GetMessage('WZD_TEMP_FORGET_BASKET_BOTTOM'),    
            // рекомендованные товары
            'RECOMMEND_SHOW' => 'N',  
            // просмотренные товары
            'VIEWED_SHOW' => 'N',                 
            // купоны
            'COUPON_ADD' => 'N',       
        ),      
    );
               
}

// пользователь зарегистрирован, но ничего не купил
if(empty($arrevent[GetMessage('WZD_user_not_buy_anything_1_NAME')])){

    $eventCreate[] = array(
        'ACTIVE' => 'Y',
        'NAME' => GetMessage('WZD_user_not_buy_anything_1_NAME'),
        'DESCRIPTION' =>  GetMessage('WZD_user_not_buy_anything_1_DESCRIPTION'),
        'SORT' => '100',
        'MODE' => 'WORK',
        'SITE_URL' => 'http://'.$_SERVER['SERVER_NAME'],
        'USER_AUTH' => 'Y',
        'TEMPLATE' => 'user_not_buy_anything',
        'EVENT_TYPE' => 'SOTBIT_MAILING_EVENT_SEND',
        'EVENT_SEND_SYSTEM' => 'BITRIX',
        'EXCLUDE_UNSUBSCRIBED_USER' => 'ALL',
        'EXCLUDE_HOUR_AGO' => '336', 
        'AGENT_TIME_START' => '8',
        'AGENT_TIME_END' => '22',
        'AGENT_ACTIVE' => 'Y',    
        'AGENT_INTERVAL' => '86400',               
        //параметры рассылки     
        'TEMPLATE_PARAMS' => array(
            'SITE_ID' => WIZARD_SITE_ID,
            'DATE_REGISTER_from' => '14',
            'DATE_REGISTER_to' => '15',
            'DATE_REGISTER_type' => 'DAYS',
            'SUBJECT' => GetMessage('WZD_user_not_buy_anything_1_SUBJECT'),
            'EMAIL_FROM' => $wizard->GetVar("shopEmail"),
            'EMAIL_TO' => "#USER_EMAIL#",
            'MESSAGE_TYPE' => 'html',
            'MESSAGE' => GetMessage('WZD_TEMPLATE_PARAMS_MESSAGE',array('#MESSAGE_TEXT#' => GetMessage('WZD_user_not_buy_anything_1_MESSAGE_TEXT'),'#SITE_URL#'=>'http://'.$_SERVER['SERVER_NAME'],'#TEMPL_URL#'=>'http://'.$_SERVER['SERVER_NAME'].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/")),
            // рекомендованные товары
            'RECOMMEND_SHOW' => 'Y',  
            'IBLOCK_TYPE_RECOMMEND'=> 'ms_catalog',
            'IBLOCK_ID_RECOMMEND' => $_SESSION["WIZARD_CATALOG_IBLOCK_ID"],
            'TOP_COUNT_FILLTER_RECOMMEND' => '4',
            'SORT_BY_RECOMMEND' => 'RAND',
            'SORT_ORDER_RECOMMEND' => 'ASC',
            'PRICE_TYPE_RECOMMEND' => 'BASE',
            'IMG_WIDTH_RECOMMEND' => '100',
            'IMG_HEIGHT_RECOMMEND' => '200',
            'TEMP_TOP_RECOMMEND' => GetMessage('WZD_TEMP_TOP_RECOMMEND'),
            'TEMP_LIST_RECOMMEND' => GetMessage('WZD_TEMP_LIST_RECOMMEND'),
            'TEMP_BOTTOM_RECOMMEND' => GetMessage('WZD_TEMP_BOTTOM_RECOMMEND'),            
            // просмотренные товары
            'VIEWED_SHOW' => 'N',                 
            // купоны
            'COUPON_ADD' => 'N',       
        ),      
    );
               
} 


// просим оставить отзыв в яндекс-маркет
if(empty($arrevent[GetMessage('WZD_order_ask_for_review_1_NAME')])){

    $eventCreate[] = array(
        'ACTIVE' => 'Y',
        'NAME' => GetMessage('WZD_order_ask_for_review_1_NAME'),
        'DESCRIPTION' =>  GetMessage('WZD_order_ask_for_review_1_DESCRIPTION'),
        'SORT' => '100',
        'MODE' => 'TEST',
        'SITE_URL' => 'http://'.$_SERVER['SERVER_NAME'],
        'USER_AUTH' => 'Y',
        'TEMPLATE' => 'order_ask_for_review',
        'EVENT_TYPE' => 'SOTBIT_MAILING_EVENT_SEND',
        'EVENT_SEND_SYSTEM' => 'BITRIX',
        'EXCLUDE_UNSUBSCRIBED_USER' => 'ALL',
        'EXCLUDE_HOUR_AGO' => '336', 
        'AGENT_TIME_START' => '8',
        'AGENT_TIME_END' => '22',
        'AGENT_ACTIVE' => 'Y',    
        'AGENT_INTERVAL' => '86400',               
        //параметры рассылки     
        'TEMPLATE_PARAMS' => array(
            'SITE_ID' => WIZARD_SITE_ID,
            'ORDER_FILLTER_STATUS' => 'F',
            'ORDER_FILLTER_DATE_STATUS_AGO_from' => '2',
            'ORDER_FILLTER_DATE_STATUS_AGO_to' => '3',
            'ORDER_FILLTER_DATE_STATUS_AGO_type' => 'DAYS',
            'EXCEPTIONS_SALE_SEND' => 'Y',
            'EXCEPTIONS_USER_SEND' => 'Y',            
            'SUBJECT' => GetMessage('WZD_order_ask_for_review_1_SUBJECT'),
            'EMAIL_FROM' => $wizard->GetVar("shopEmail"),
            'EMAIL_TO' => "#ORDER_EMAIL#",
            'MESSAGE_TYPE' => 'html',
            'MESSAGE' => GetMessage('WZD_TEMPLATE_PARAMS_MESSAGE',array('#MESSAGE_TEXT#' => GetMessage('WZD_order_ask_for_review_1_MESSAGE_TEXT'),'#SITE_URL#'=>'http://'.$_SERVER['SERVER_NAME'],'#TEMPL_URL#'=>'http://'.$_SERVER['SERVER_NAME'].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/")),
            // список товаров корзины
            'FORGET_BASKET_IMG_WIDTH' => '100',
            'FORGET_BASKET_IMG_HEIGHT'=> '200',
            'TEMP_FORGET_BASKET_TOP' => GetMessage('WZD_TEMP_FORGET_BASKET_TOP'), 
            'TEMP_FORGET_BASKET_LIST' => GetMessage('WZD_TEMP_FORGET_BASKET_LIST'), 
            'TEMP_FORGET_BASKET_BOTTOM' => GetMessage('WZD_TEMP_FORGET_BASKET_BOTTOM'),               
            // рекомендованные товары
            'RECOMMEND_SHOW' => 'Y',  
            'IBLOCK_TYPE_RECOMMEND'=> 'ms_catalog',
            'IBLOCK_ID_RECOMMEND' => $_SESSION["WIZARD_CATALOG_IBLOCK_ID"],
            'TOP_COUNT_FILLTER_RECOMMEND' => '4',
            'SORT_BY_RECOMMEND' => 'RAND',
            'SORT_ORDER_RECOMMEND' => 'ASC',
            'PRICE_TYPE_RECOMMEND' => 'BASE',
            'IMG_WIDTH_RECOMMEND' => '100',
            'IMG_HEIGHT_RECOMMEND' => '200',
            'TEMP_TOP_RECOMMEND' => GetMessage('WZD_TEMP_TOP_RECOMMEND'),
            'TEMP_LIST_RECOMMEND' => GetMessage('WZD_TEMP_LIST_RECOMMEND'),
            'TEMP_BOTTOM_RECOMMEND' => GetMessage('WZD_TEMP_BOTTOM_RECOMMEND'),            
            // просмотренные товары
            'VIEWED_SHOW' => 'N',                 
            // купоны
            'COUPON_ADD' => 'N',       
        ),      
    );
               
}


// пользователь давно не заходил
if(empty($arrevent[GetMessage('WZD_user_have_not_had_1_NAME')])){

    $eventCreate[] = array(
        'ACTIVE' => 'Y',
        'NAME' => GetMessage('WZD_user_have_not_had_1_NAME'),
        'DESCRIPTION' =>  GetMessage('WZD_user_have_not_had_1_DESCRIPTION'),
        'SORT' => '100',
        'MODE' => 'WORK',
        'SITE_URL' => 'http://'.$_SERVER['SERVER_NAME'],
        'USER_AUTH' => 'Y',
        'TEMPLATE' => 'user_have_not_had',
        'EVENT_TYPE' => 'SOTBIT_MAILING_EVENT_SEND',
        'EVENT_SEND_SYSTEM' => 'BITRIX',
        'EXCLUDE_UNSUBSCRIBED_USER' => 'ALL',
        'EXCLUDE_HOUR_AGO' => '336', 
        'AGENT_TIME_START' => '8',
        'AGENT_TIME_END' => '22',
        'AGENT_ACTIVE' => 'Y',    
        'AGENT_INTERVAL' => '86400',               
        //параметры рассылки     
        'TEMPLATE_PARAMS' => array(
            'SITE_ID' => WIZARD_SITE_ID,
            'LAST_LOGIN_from' => '61',
            'LAST_LOGIN_to' => '62',
            'LAST_LOGIN_type' => 'DAYS',          
            'SUBJECT' => GetMessage('WZD_user_have_not_had_1_SUBJECT'),
            'EMAIL_FROM' => $wizard->GetVar("shopEmail"),
            'EMAIL_TO' => "#USER_EMAIL#",
            'MESSAGE_TYPE' => 'html',
            'MESSAGE' => GetMessage('WZD_TEMPLATE_PARAMS_MESSAGE',array('#MESSAGE_TEXT#' => GetMessage('WZD_user_have_not_had_1_MESSAGE_TEXT'),'#SITE_URL#'=>'http://'.$_SERVER['SERVER_NAME'],'#TEMPL_URL#'=>'http://'.$_SERVER['SERVER_NAME'].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/")),             
            // рекомендованные товары
            'RECOMMEND_SHOW' => 'Y',  
            'IBLOCK_TYPE_RECOMMEND'=> 'ms_catalog',
            'IBLOCK_ID_RECOMMEND' => $_SESSION["WIZARD_CATALOG_IBLOCK_ID"],
            'TOP_COUNT_FILLTER_RECOMMEND' => '4',
            'SORT_BY_RECOMMEND' => 'RAND',
            'SORT_ORDER_RECOMMEND' => 'ASC',
            'PRICE_TYPE_RECOMMEND' => 'BASE',
            'IMG_WIDTH_RECOMMEND' => '100',
            'IMG_HEIGHT_RECOMMEND' => '200',
            'TEMP_TOP_RECOMMEND' => GetMessage('WZD_TEMP_TOP_RECOMMEND'),
            'TEMP_LIST_RECOMMEND' => GetMessage('WZD_TEMP_LIST_RECOMMEND'),
            'TEMP_BOTTOM_RECOMMEND' => GetMessage('WZD_TEMP_BOTTOM_RECOMMEND'),            
            // просмотренные товары
            'VIEWED_SHOW' => 'N',                 
            // купоны
            'COUPON_ADD' => 'Y',
            'COUPON_DISCOUNT_ID' => $discount_ID,
            'COUPON_ONE_TIME' => 'O',
            'COUPON_TIME_LIFE' => '48',
            'COUPON_TIME_LIFE_ACTION' => 'DELETE'                   
        ),      
    );
               
}


foreach($eventCreate as $itemEvent){
    //создадим рассылку
    $TEMPLATE_PARAMS_MESSAGE = $itemEvent['TEMPLATE_PARAMS']['MESSAGE'];
    $itemEvent['TEMPLATE_PARAMS'] = serialize($itemEvent['TEMPLATE_PARAMS']); 
    $ID_EVENT = CSotbitMailingEvent::Add($itemEvent);
          
    // добавим шаблон сценария
    // START
    $arrAddTemplate = array(
        'ID_EVENT' => $ID_EVENT,
        'COUNT_START' => '0',
        'COUNT_END' => '0', 
        'TEMPLATE' => $TEMPLATE_PARAMS_MESSAGE,
        'ARCHIVE' => 'N'
    );
    CSotbitMailingMessageTemplate::Add($arrAddTemplate); 
    // END            
                          
    //создадим агент 
    if($ID_EVENT){
        $AGENT_ID = CAgent::AddAgent('CSotbitMailingTools::AgentStartTemplate('.$ID_EVENT.');', "sotbit.mailing", "N", $itemEvent['AGENT_INTERVAL'], "", $itemEvent['AGENT_ACTIVE']);
        CSotbitMailingEvent::Update($ID_EVENT , array('AGENT_ID' => $AGENT_ID));               
    }
    
    //выставим в категорию
    if($itemEvent['TEMPLATE']=='user_register_mailing' && $ID_EVENT){
        $ID_user_register_mailing = $ID_EVENT;         
    }
 
}
// END


// создать категорию рассылки
// START
$arrcategory = array();
$dbcategory = CSotbitMailingCategories::GetList();
while($rescategory = $dbcategory->Fetch()) {
    $arrcategory[$rescategory['NAME']] = $rescategory;  
}

$categoryCreate[] = array(
    'ACTIVE' => 'Y',
    'NAME' => GetMessage('WZD_CATEGORY_MISS_NAME'),
    'DESCRIPTION' => GetMessage('WZD_CATEGORY_MISS_DESCRIPTION'),
    'SUNC_USER' => 'Y',
    'SUNC_USER_MESSAGE' => 'Y',
    'SUNC_USER_EVENT' => $ID_user_register_mailing
);

foreach($categoryCreate as $itemcategory){
    
    if(empty($arrcategory[$itemcategory['NAME']])){
        $itemcategory['TEMPLATE_PARAMS'] = serialize($itemcategory['TEMPLATE_PARAMS']); 
        $CATEGORIES_ID = CSotbitMailingCategories::Add($itemcategory);                     
    } else {
        $CATEGORIES_ID = $arrcategory[$itemcategory['NAME']]['ID'];   
    }  

}
// END

//шаблоны миссшоп
//START 
COption::SetOptionString('sotbit.mailing','TEMPLATE_MAILING_DEF','/bitrix/components/sotbit/sotbit.mailing.logic/lang/ru/tpl_mailing/b2bshop.php');
CopyDirFiles(
    WIZARD_ABSOLUTE_PATH."/site/services/sotbit.mailing/lang/ru/tpl_mailing/",
    $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/sotbit/sotbit.mailing.logic/lang/ru/tpl_mailing/',
    $rewrite = true,
    $recursive = true,
    $delete_after_copy = false
);
//END

//заменим переменные
    $MAILING_CATEGORIES_ID = array(
        1
    );
    COption::SetOptionString("sotbit.b2bshop", "MAILING_CATEGORIES_ID", serialize($MAILING_CATEGORIES_ID));    
/*CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID.'/footer.php' , array("CATEGORIES_ID" => $CATEGORIES_ID)); 
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/catalog/index.php", array("CATEGORIES_ID" => $CATEGORIES_ID));   
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/brands/index.php", array("CATEGORIES_ID" => $CATEGORIES_ID));   */
?>