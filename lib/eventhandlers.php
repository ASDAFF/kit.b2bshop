<?php
namespace Kit\B2BShop;

/**
 * class for catch events
 *
 * @author Sergey Danilkin < s.danilkin@kit.ru >
 */
class EventHandlers {
    public function OnSaleOrderBeforeSavedHandler($event) {
        if($event instanceof \Bitrix\Main\Event) {
            $parameters = $event->getParameters();
            $order = $parameters['ENTITY'];
            if($order->isNew()) {
                $propertyCollection = $order->getPropertyCollection();
                $equal = false;
                foreach($propertyCollection as $property) {
                    if($property->getField('CODE') == 'EQ_POST' && $property->getValue()) {
                        $equal = true;
                    }
                }
                if($equal) {
                    $Vals = array();
                    foreach($propertyCollection as $property) {
                        if($property->getField('CODE') == 'UR_ZIP') {
                            $Vals['ZIP'] = $property->getValue();
                        }
                        if($property->getField('CODE') == 'UR_CITY') {
                            $Vals['CITY'] = $property->getValue();
                        }
                        if($property->getField('CODE') == 'UR_ADDRESS') {
                            $Vals['ADDRESS'] = $property->getValue();
                        }
                    }
                    foreach($propertyCollection as $property) {
                        if($property->getField('CODE') == 'POST_ZIP') {
                            $property->setValue($Vals['ZIP']);
                        }
                        if($property->getField('CODE') == 'POST_CITY') {
                            $property->setValue($Vals['CITY']);
                        }
                        if($property->getField('CODE') == 'POST_ADDRESS') {
                            $property->setValue($Vals['ADDRESS']);
                        }
                    }
                    unset($Vals);
                }
            }
        }
    }
    
    public function OnBeforeUserAddHandler(&$arFields) {
        if(!$arFields['UF_CONFIDENTIAL']) {
            $arFields['UF_CONFIDENTIAL'] = 1;
        }
    }
    
    public function OnBeforeEventSendHandler(&$arFields, &$arTemplate) {
        $arFields['EVENT_NAME'] = $arTemplate['EVENT_NAME'];
        $arFields['UTM'] = '?utm_source=newsletter&utm_medium=email&utm_campaign='.$arFields['EVENT_NAME'];
    }
    
    public function onBeforeResultAdd($WEB_FORM_ID, &$arFields, &$arrVALUES) {
        if($WEB_FORM_ID == \COption::GetOptionString("kit.b2bshop", "FORM_MANAGER_CALLBACK", false)) {
            //\CEvent::Send("KIT_AUTH_NEW_USER_PASSWORD", SITE_ID, array_merge($arEventFields, $arFields));
            $keyName = \COption::GetOptionString("kit.b2bshop", "FORM_FIELD_NAME", false);
            $keyPhone = \COption::GetOptionString("kit.b2bshop", "FORM_FIELD_PHONE", false);
            $keyComment = \COption::GetOptionString("kit.b2bshop", "FORM_FIELD_COMMENT", false);
            $arrayFields = array();
            if($keyName)
                $arrayFields['USER_NAME'] = $arrVALUES[$keyName];
            if($keyPhone)
                $arrayFields['USER_PHONE'] = $arrVALUES[$keyPhone];
            if($keyComment)
                $arrayFields['MESSAGE'] = $arrVALUES[$keyComment];
            $managerID = \COption::GetOptionString("kit.b2bshop", "DEFAUL_MANAGER_ID", 1);
            global $USER;
            $user = \Bitrix\main\UserTable::getList(array(
                'filter' => array('ID' => $USER->getId()),
                'select' => array('UF_*')
            ))->fetch();
            if($user['UF_MANAGER'])
                $managerID = $user['UF_MANAGER'];
            $user = \Bitrix\main\UserTable::getList(array(
                'filter' => array('ID' => $managerID),
                'select' => array('EMAIL')
            ))->fetch();
            if(isset($user['EMAIL']))
                $arrayFields['MANAGER_EMAIL'] = $user['EMAIL'];
            \CEvent::Send("PERSONAL_MANAGER_BLOCK", array(SITE_ID), $arrayFields);
        }
    }
}

?>