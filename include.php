<?php

use Bitrix\Main\Config\Option;

IncludeModuleLangFile(__FILE__);

CModule::AddAutoloadClasses('kit.b2bshop', array(
        'B2BSKitParent' => 'classes/ms_kit_parent.php',
        'B2BSKitShop' => 'classes/ms_kit_shop.php',
        'PHPExcel' => 'classes/PHPExcel/PHPExcel.php',
        'PHPExcel_IOFactory' => 'classes/PHPExcel/PHPExcel/IOFactory.php',
    )
);

class B2BSKit
{
    public static $_1098613501 = 0;
    public static $_45965515 = array();
    public static $_233026658 = array();
    public static $_334833930 = "";
    public static $_2109707984 = "";
    public static $_168454199 = 0;
    public static $_1574143339 = "";
    protected $_125556197;

    function ShowPanel()
    {
        if ($GLOBALS['USER']->IsAdmin() && COption::GetOptionString('main', 'wizard_solution', '', SITE_ID) == 'b2bshop') {
            $GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/wizards/bitrix/b2bshop/css/panel.css');

            $_923747322 = array(array('ACTION' => 'jsUtils.Redirect([], \'' . CUtil::JSEscape('/bitrix/admin/wizard_install.php?lang=' . LANGUAGE_ID . '&wizardSiteID=' . SITE_ID . '&wizardName=kit:b2bshop&' . bitrix_sessid_get()) . '\')', 'ICON' => 'bx-popup-item-wizard-icon', 'TITLE' => GetMessage('STOM_BUTTON_TITLE_W1'), 'TEXT' => GetMessage('STOM_BUTTON_NAME_W1'),));


            $GLOBALS['APPLICATION']->AddPanelButton(array('HREF' => '/bitrix/admin/wizard_install.php?lang=' . LANGUAGE_ID . '&wizardName=kit:b2bshop&wizardSiteID=' . SITE_ID . '&' . bitrix_sessid_get(), 'ID' => 'eshop_wizard', 'ICON' => 'bx-panel-site-wizard-icon', 'MAIN_SORT' => 2500, 'TYPE' => 'BIG', 'SORT' => 10, 'ALT' => GetMessage('SCOM_BUTTON_DESCRIPTION'), 'TEXT' => GetMessage('SCOM_BUTTON_NAME'), 'MENU' => $_923747322,));


        }


    }

    function OnBuildGlobalMenu(&$_1637978865, &$_444812048)
    {
        if ($GLOBALS['APPLICATION']->GetGroupRight('main') < 'R') return;
        $MODULE_ID = basename(dirname(__FILE__));
        $_274798237 = array();
        return $_274798237;
        $_444812048[] = $_1752631377;
    }

    public function getField($_846019774)
    {
        return $this->_125556197[$_846019774];
    }

    public function getFields()
    {
        return $this->_125556197;
    }

    public function setFields($_634085460)
    {
        if (is_array($_634085460)) {
            foreach ($_634085460 as $_1610659773 => $_1800172428) {
                $this->setField($_1610659773, $_1800172428);
            }
        }
    }

    public function setField($_846019774, $_1800172428)
    {
        $this->_125556197[$_846019774] = $_1800172428;
    }

    public function unsetField($_1610659773)
    {
        unset($this->_125556197[$_1610659773]);
    }

    public function getStatus()
    {
        $_966224713 = "kit.b2bshop";
        $_530820518 = CModule::IncludeModuleEx($_966224713);
        return $_530820518;
    }

    public function FilterRedirect()
    {
        global $APPLICATION;
        if (0 && !defined('ADMIN_SECTION') || ADMIN_SECTION !== true) {

            $_244185232 = array();
            $_440408782 = array();
            $_1318348007 = $APPLICATION->GetCurPage(false);
            $_1534908705 = '';
            if (isset($_REQUEST['set_filter']) && isset($_REQUEST['bxajaxid']) && $_REQUEST['set_filter'] && $_REQUEST['bxajaxid']) {
                if (isset($_REQUEST['sef']) && $_REQUEST['sef'] == 'N') return true;
                foreach ($_REQUEST as $_391161298 => $_1387704539) {
                    $_872894553 = explode('=', $_1713660508);
                    if ($_391161298 == 'set_filter' || $_391161298 == 'kit_filter' || $_391161298 == 'ms_viewed_products') continue;
                    if (is_array($_1387704539)) {
                        foreach ($_1387704539 as $_836538163 => $_2063534486) {
                            if (empty($_2063534486)) {
                                continue;
                            }
                            $_836538163 .= '';
                            if ($_836538163 != 'from' && $_836538163 != 'to') {
                                $_244185232[$_391161298][] = $_2063534486;
                            } else {
                                $_440408782[$_391161298][$_836538163] = $_2063534486;
                            }
                        }
                    } elseif ($_391161298 == 'bxajaxid') {
                        $_698976542 = $_1387704539;
                    }
                }
                if (!empty($_244185232)) {
                    $_1534908705 = $_1318348007 . 'filter/';
                    foreach ($_244185232 as $_28888307 => $_326574135) {
                        $_1534908705 .= $_28888307 . '-';
                        foreach ($_326574135 as $_5861995 => $_705284547) {
                            if ($_5861995 > 0) {
                                $_1534908705 .= '-or-' . $_705284547;
                            } else $_1534908705 .= $_705284547;
                        }
                        $_1534908705 .= '/';
                    }
                }
                if (!empty($_440408782)) {
                    if (empty($_1534908705)) {
                        $_1534908705 = $_1318348007 . 'filter/';
                    }
                    foreach ($_440408782 as $_28888307 => $_326574135) {
                        $_1534908705 .= $_28888307;
                        foreach ($_326574135 as $_5861995 => $_705284547) {
                            $_1534908705 .= '-' . $_5861995 . '-' . $_705284547;
                        }
                        $_1534908705 .= '/';
                    }
                }
                if (!empty($_1534908705) && !isset($_REQUEST['del_filter'])) {
                    $_1534908705 .= 'apply/';
                    $_1534908705 .= '?bxajaxid=' . $_698976542;
                    LocalRedirect($_1534908705, false, 301);
                } else {
                    LocalRedirect($_1318348007 . '?bxajaxid=' . $_698976542, false, 301);
                }
            }
        }
    }

    public function OnSuccessCatalogImport1C()
    {
        B2BSKit::agentSectionsBrands();
    }

    public function agentSectionsBrands()
    {
        CModule::IncludeModule('main');
        CModule::IncludeModule('iblock');
        if (!B2BSKit::$_168454199) B2BSKit::$_168454199 = COption::GetOptionString('kit.b2bshop', 'IBLOCK_ID');
        $_764931930 = CIBlockSection::GetList(array('left_margin' => 'asc'), array('IBLOCK_ID' => B2BSKit::$_168454199, 'DEPTH_LEVEL' => 1), false, array('ID'));
        $_28888307 = COption::GetOptionString('kit.b2bshop', 'MANUFACTURER_ELEMENT_PROPS');
        $_1178106477 = B2BSKit::checkCategoryUF();
        if (!$_1178106477) return 'B2BSKit::agentSectionsBrands();';
        while ($_1799261788 = $_764931930->Fetch()) {
            $_1681421404 = array('IBLOCK_ID' => B2BSKit::$_168454199, 'SECTION_ID' => $_1799261788['ID'], 'INCLUDE_SUBSECTIONS' => 'Y');
            $_869484057 = array('ID', 'IBLOCK_ID', 'PROPERTY_' . $_28888307);
            $_391482219 = CIBlockElement::GetList(array(), $_1681421404, false, false, $_869484057);
            $_308486339 = new CIBlockSection;
            $_1744740708 = array();
            while ($_543559218 = $_391482219->Fetch()) {
                $_32589977 = $_543559218['PROPERTY_' . $_28888307 . '_VALUE'];
                $_1744740708[$_32589977] = $_32589977;
            }
            if (!empty($_1744740708)) $_1218062019 = $_308486339->Update($_1799261788['ID'], array($_1178106477 => $_1744740708));
            unset($_308486339);
        }
        return 'B2BSKit::agentSectionsBrands();';
    }

    public function checkCategoryUF()
    {
        global $APPLICATION;
        if (!B2BSKit::$_1574143339 && B2BSKit::$_168454199) {
            $_867748218 = array('ENTITY_ID' => 'IBLOCK_' . B2BSKit::$_168454199 . '_SECTION', 'FIELD_NAME' => 'UF_B2BS_BRAND');
            $_1335607116 = CUserTypeEntity::GetList(array('ID' => 'asc'), $_867748218)->Fetch();
            if (!$_1335607116) {
                $_1345677076['IBLOCK_TYPE_ID'] = COption::GetOptionString('kit.b2bshop', 'BRAND_IBLOCK_TYPE');
                $_1345677076['IBLOCK_ID'] = COption::GetOptionString('kit.b2bshop', 'BRAND_IBLOCK_ID');
                $_1345677076['LIST_HEIGHT'] = 10;
                $_1667127547 = new CUserTypeEntity();
                $_2006275658 = array('ENTITY_ID' => 'IBLOCK_' . B2BSKit::$_168454199 . '_SECTION', 'FIELD_NAME' => 'UF_B2BS_BRAND', 'USER_TYPE_ID' => 'iblock_element', 'MULTIPLE' => 'Y', 'SETTINGS' => $_1345677076);
                $_1667127547->Add($_2006275658);
                unset($_1667127547);
            }
            B2BSKit::$_1574143339 = 'UF_B2BS_BRAND';
            return B2BSKit::$_1574143339;
        } elseif (B2BSKit::$_168454199) return B2BSKit::$_1574143339;
        else return false;
    }

    public function getCIBlockProperty($_1419413357, $_2092726963)
    {
        CModule::IncludeModule('iblock');
        $_2080302148 = new CIBlockProperty;
        $_1431496568 = $_2080302148->GetList(array(), array('IBLOCK_ID' => $_1419413357, 'ACTIVE' => 'Y'));
    }

    public function createSocMeta($_877841411, $_1729779499, $_1482827813, $_956909620, $_1111920421)
    {
        global $APPLICATION;

        if (substr($_1482827813, 0, 1) == '/') {
            if (defined('SITE_SERVER_NAME') && strlen(SITE_SERVER_NAME) > 0) $_1482827813 = 'http://' . SITE_SERVER_NAME . $_1482827813; else $_1482827813 = 'http://' . COption::GetOptionString('main', 'server_name', $GLOBALS['SERVER_NAME']) . $_1482827813;
        }
        if (substr($_956909620, 0, 1) == '/') {
            if (substr('SITE_SERVER_NAME') && strlen(SITE_SERVER_NAME) > 0) $_956909620 = 'http://' . SITE_SERVER_NAME . $_956909620; else $_956909620 = 'http://' . COption::GetOptionString('main', 'server_name', $GLOBALS['SERVER_NAME']) . $_956909620;
        }
        $_877841411 = B2BSKit::msUrlencode($_877841411);
        $_956909620 = B2BSKit::msUrlencode($_956909620);
        $_1729779499 = TruncateText(strip_tags($_1729779499), 300);
        $_1729779499 = B2BSKit::msUrlencode($_1729779499);
        if (strlen($_877841411)) $APPLICATION->AddHeadString('<meta property="og:title" content="' . $_877841411 . '"/> ');
        if (strlen($_1729779499)) $APPLICATION->AddHeadString('<meta property="og:description" content="' . $_1729779499 . '"/> ');
        if (strlen($_1482827813)) $APPLICATION->AddHeadString('<meta property="og:url" content="' . $_1482827813 . '"/> ');
        if (strlen($_956909620)) $APPLICATION->AddHeadString('<meta property="og:image" content="' . $_956909620 . '"/> ');
        if (strlen($_1111920421)) $APPLICATION->AddHeadString('<meta property="og:site_name" content="' . $_1111920421 . '"/> ');
    }

    public function msUrlencode($_1266154208)
    {
        if (trim($_1266154208) == '') return $_1266154208;
        return $_1266154208;
        $_1266154208 = urlencode($GLOBALS['APPLICATION']->ConvertCharset($_1266154208, SITE_CHARSET, 'UTF-8'));
        return $_1266154208;
    }

    public function CalculateBasketOrder()
    {
        global $APPLICATION;
        if (isset($_REQUEST['msCalculateBasket']) && intval($_REQUEST['basketItemId']) > 0 && isset($_REQUEST['offerID'])) {
            if (intval($_REQUEST['offerID']) == 0) return false;
            global $USER;
            $USER = new CUser();
            CModule::IncludeModule('iblock');
            CModule::IncludeModule('sale');
            $_869484057 = array('ID', 'IBLOCK_ID', 'PROPERTY_CML2_LINK', 'XML_ID');
            $_100321037 = isset($_REQUEST['props']) ? $_REQUEST['props'] : array();
            $_1056889763 = isset($_REQUEST['select_props']) ? $_REQUEST['select_props'] : '';
            $_1760386317 = explode(',', $_1056889763);
            $_2143186106 = isset($_REQUEST['offers_props']) ? $_REQUEST['offers_props'] : '';
            $_2143186106 = explode(',', $_2143186106);
            $_231890286 = array('ID', 'XML_ID', 'PRODUCT_ID', 'PRICE', 'CURRENCY', 'WEIGHT', 'QUANTITY', 'MODULE', 'PRODUCT_PROVIDER_CLASS', 'CALLBACK_FUNC',);
            $_1302142988 = CSaleBasket::GetList(array(), array('ID' => intval($_REQUEST['basketItemId'])), false, false, $_231890286);
            if ($_453440267 = $_1302142988->Fetch()) {
                $_1091042788 = CSaleBasket::GetPropsList(array('SORT' => 'ASC', 'ID' => 'ASC'), array('BASKET_ID' => $_453440267['ID']));
                while ($_326574135 = $_1091042788->GetNext()) {
                    $_453440267['PROPS'][] = $_326574135;
                }
                $_1338338834 = CIBlockElement::GetList(array('SORT' => 'ASC', 'ID' => 'ASC'), array('ID' => $_453440267['PRODUCT_ID']), false, false, $_869484057);
                if ($_543559218 = $_1338338834->Fetch()) {
                    $_1029069150 = false;
                    $_100321037['CML2_LINK'] = $_543559218['PROPERTY_CML2_LINK_VALUE'];
                    $_2014011827 = $_REQUEST['offerID'];
                    if ($_2014011827 > 0) {
                        if ($_81905316 = CSaleBasket::GetProductProvider($_453440267)) {
                            $_1517440391 = $_81905316::GetProductData(array('PRODUCT_ID' => $_2014011827, 'QUANTITY' => $_453440267['QUANTITY'], 'RENEWAL' => 'N', 'USER_ID' => $USER->GetID(), 'SITE_ID' => SITE_ID, 'BASKET_ID' => $_453440267['ID'], 'CHECK_QUANTITY' => 'Y', 'CHECK_PRICE' => 'Y'));
                        } elseif (isset($_453440267['CALLBACK_FUNC']) && !empty($_453440267['CALLBACK_FUNC'])) {
                            $_1517440391 = CSaleBasket::ExecuteCallbackFunction($_453440267['CALLBACK_FUNC'], $_453440267['MODULE'], $_2014011827, $_453440267['QUANTITY'], 'N', $USER->GetID(), SITE_ID);
                        }
                        if (isset($_1517440391) && is_array($_1517440391)) {
                            $_2006275658 = array('PRODUCT_ID' => $_2014011827, 'PRODUCT_PRICE_ID' => $_1517440391['PRODUCT_PRICE_ID'], 'PRICE' => $_1517440391['PRICE'], 'CURRENCY' => $_1517440391['CURRENCY'], 'QUANTITY' => $_1517440391['QUANTITY'], 'WEIGHT' => $_1517440391['WEIGHT'],);
                            $_1460919468 = CIBlockElement::GetList(array(), array('ID' => $_2014011827), false, false, array('IBLOCK_ID', 'IBLOCK_SECTION_ID', 'XML_ID'));
                            if ($_1315486624 = $_1460919468->Fetch()) {
                                $_402066618 = CCatalogSku::GetProductInfo($_2014011827, $_543559218['IBLOCK_ID']);
                                if ($_402066618 && !empty($_402066618)) {
                                    $_35853214 = array();
                                    if (strpos($_1315486624['XML_ID'], '#') === false) {
                                        $_2065155114 = CIBlockElement::GetList(array(), array('ID' => $_402066618['ID']), false, false, array('ID', 'XML_ID'));
                                        if ($_1958884010 = $_2065155114->Fetch()) {
                                            $_1315486624['XML_ID'] = $_1958884010['XML_ID'] . '#' . $_1315486624['XML_ID'];
                                        }
                                    }
                                    $_2006275658['PRODUCT_XML_ID'] = $_1315486624['XML_ID'];
                                    $_415571569 = CIBlock::GetProperties($_1315486624['IBLOCK_ID'], array(), array('!XML_ID' => 'CML2_LINK'));
                                    while ($_823231734 = $_415571569->Fetch()) {
                                        $_622400343[] = $_823231734['CODE'];
                                    }
                                    $_1868838718 = CIBlockPriceTools::GetOfferProperties($_2014011827, $_402066618['IBLOCK_ID'], $_622400343);
                                    foreach ($_1868838718 as $_2144774972) {
                                        $_1599295773 = false;
                                        foreach ($_2143186106 as $_361747323) {
                                            if ($_361747323 == $_2144774972['CODE']) {
                                                $_1599295773 = true;
                                                break;
                                            }
                                        }
                                        if ($_1599295773 === true) {
                                            $_2006275658['PROPS'][] = array('NAME' => $_2144774972['NAME'], 'CODE' => $_2144774972['CODE'], 'VALUE' => $_2144774972['VALUE'], 'SORT' => $_2144774972['SORT']);
                                        }
                                    }
                                    $_2006275658['PROPS'][] = array('NAME' => 'Product XML_ID', 'CODE' => 'PRODUCT.XML_ID', 'VALUE' => $_1315486624['XML_ID']);
                                } else {
                                    $_1900790918[] = GetMessage('SBB_PRODUCT_PRICE_NOT_FOUND');
                                }
                                if (empty($_1900790918)) {
                                    $_1029069150 = CSaleBasket::Update($_453440267['ID'], $_2006275658);
                                    $_1037854514 = \Bitrix\Sale\Basket\Storage::getInstance(\Bitrix\Sale\Fuser::getId(), \Bitrix\Main\Context::getCurrent()->getSite());
                                    $_1835228341 = $_1037854514->getBasket();
                                    foreach ($_1835228341 as $_171995457) {
                                        if ($_171995457->getField('ID') == $_453440267['ID']) {
                                            $_466341422 = $_171995457->getPropertyCollection();
                                            if ($_2006275658['PROPS']) {
                                                foreach ($_466341422 as $_1860479365) {
                                                    $_1860479365->delete();
                                                }
                                                foreach ($_2006275658['PROPS'] as $_705284547) {
                                                    $_466341422->setProperty(array(array('NAME' => $_705284547['NAME'], 'CODE' => $_705284547['CODE'], 'VALUE' => $_705284547['VALUE'], 'SORT' => $_705284547['SORT'],),));
                                                }
                                                $_466341422->save();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } elseif (check_bitrix_sessid() && isset($_POST['msCalculateBasket']) && (isset($_POST['coupon']) || isset($_POST['COUPON']))) {
            CModule::IncludeModule('main');
            CModule::IncludeModule('catalog');
            $_566827602 = array();
            $_566827602['RESULT'] = 'ERROR';
            $_POST['coupon'] = isset($_POST['coupon']) ? $_POST['coupon'] : $_POST['COUPON'];
            if (isset($_POST['coupon']) && !empty($_POST['coupon'])) {
                $_566827602['VALID_COUPON'] = CCatalogDiscountCoupon::SetCoupon($_POST['coupon']);
                if ($_566827602['VALID_COUPON']) $_566827602['RESULT'] = 'SUCCESS';
            }
            if (!isset($_566827602['VALID_COUPON']) || (isset($_566827602['VALID_COUPON']) && $_566827602['VALID_COUPON'] === false)) {
                CCatalogDiscountCoupon::ClearCoupon();
            }
            ob_end_clean();
            ob_start();
            header('Content-Type: application/json; charset=' . LANG_CHARSET);
            echo CUtil::PhpToJSObject($_566827602);
            die();
        }
    }

    public function getProductByProps($_1745207413, $_1666879552)
    {
        $_1010293782 = false;
        $_869484057 = array();
        $_628093341 = array('IBLOCK_ID' => $_1745207413,);
        $_1353295138 = CIBlockProperty::GetList(array('SORT' => 'ASC', 'ID' => 'ASC'), array('IBLOCK_ID' => $_1745207413, 'ACTIVE' => 'Y'));
        while ($_326574135 = $_1353295138->Fetch()) {
            if (!$_326574135['CODE']) $_326574135['CODE'] = $_326574135['ID'];
            if (isset($_1666879552[$_326574135['CODE']])) {
                if ($_326574135['CODE'] == 'CML2_LINK' || $_326574135['PROPERTY_TYPE'] == 'E' || ($_326574135['PROPERTY_TYPE'] == 'S' && $_326574135['USER_TYPE'] == 'directory')) {
                    $_628093341['PROPERTY_' . $_326574135['CODE']] = $_1666879552[$_326574135['CODE']];
                } elseif ($_326574135['PROPERTY_TYPE'] == 'L') {
                    $_628093341['PROPERTY_' . $_326574135['CODE'] . '_VALUE'] = $_1666879552[$_326574135['CODE']];
                }
                $_869484057[] = 'PROPERTY_' . $_326574135['CODE'];
            }
        }
        $_1772117933 = CIBlockElement::GetList(array(), $_628093341, false, false, array_merge(array('ID'), $_869484057));
        if ($_1155952816 = $_1772117933->GetNext()) $_1010293782 = $_1155952816['ID'];
        return $_1010293782;
    }

    public function DoIBlockAfterSave($_2001235794, $_1497515944 = false)
    {
        $_1599211611 = false;
        $_1419413357 = false;
        $_1431332036 = false;
        $_1379114419 = false;
        if (CModule::IncludeModule('currency')) $_1587261140 = CCurrency::GetBaseCurrency();
        if (is_array($_1497515944) && $_1497515944['PRODUCT_ID'] > 0) {
            $_1839800157 = CIBlockElement::GetList(array(), array('ID' => $_1497515944['PRODUCT_ID'],), false, false, array('ID', 'IBLOCK_ID'));
            if ($_538747636 = $_1839800157->Fetch()) {
                $_1133329834 = CCatalog::GetByID($_538747636['IBLOCK_ID']);
                if (is_array($_1133329834)) {
                    if ($_1133329834['OFFERS'] == 'Y') {
                        $_274429931 = CIBlockElement::GetProperty($_538747636['IBLOCK_ID'], $_538747636['ID'], 'sort', 'asc', array('ID' => $_1133329834['SKU_PROPERTY_ID']));
                        $_543559218 = $_274429931->Fetch();
                        if ($_543559218 && $_543559218['VALUE'] > 0) {
                            $_1599211611 = $_543559218['VALUE'];
                            $_1419413357 = $_1133329834['PRODUCT_IBLOCK_ID'];
                            $_1431332036 = $_1133329834['IBLOCK_ID'];
                            $_1379114419 = $_1133329834['SKU_PROPERTY_ID'];
                        }
                    } elseif ($_1133329834['OFFERS_IBLOCK_ID'] > 0) {
                        $_1599211611 = $_538747636['ID'];
                        $_1419413357 = $_538747636['IBLOCK_ID'];
                        $_1431332036 = $_1133329834['OFFERS_IBLOCK_ID'];
                        $_1379114419 = $_1133329834['OFFERS_PROPERTY_ID'];
                    } else {
                        $_1599211611 = $_538747636['ID'];
                        $_1419413357 = $_538747636['IBLOCK_ID'];
                        $_1431332036 = false;
                        $_1379114419 = false;
                    }
                }
            }
        } elseif (is_array($_2001235794) && $_2001235794['ID'] > 0 && $_2001235794['IBLOCK_ID'] > 0) {
            $_1064746976 = CIBlockPriceTools::GetOffersIBlock($_2001235794['IBLOCK_ID']);
            if (is_array($_1064746976)) {
                $_1599211611 = $_2001235794['ID'];
                $_1419413357 = $_2001235794['IBLOCK_ID'];
                $_1431332036 = $_1064746976['OFFERS_IBLOCK_ID'];
                $_1379114419 = $_1064746976['OFFERS_PROPERTY_ID'];
            }
        }
        $_1602080860 = false;
        $_1218062019 = CIBlock::GetList(array(), array('ID' => $_1419413357,), true);
        if ($_498431500 = $_1218062019->Fetch()) {
            $_1806210742 = $_498431500['LID'];
        }
        if (\Bitrix\Main\Config\Option::get('sale', 'use_sale_discount_only', 'N') == 'Y') {
            $_1403252341 = array();
            $_1219265506 = array('ID');
            $_480584506 = \CCatalogSKU::getOffersList($_1599211611, 0, array('ACTIVE' => 'Y'), $_1219265506, $_1403252341);
            if ($_480584506[$_1599211611]) {
                foreach ($_480584506[$_1599211611] as $_1888897691) {
                    if ($_1888897691['ID']) {
                        $_1851567167 = CCatalogDiscount::GetDiscountByProduct($_1888897691['ID'], array(), 'N', array(), $_1806210742);
                        if (isset($_1851567167) && is_array($_1851567167) && count($_1851567167) > 0) {
                            break;
                        }
                    }
                }
            }
        } else {
            $_1851567167 = CCatalogDiscount::GetDiscountByProduct($_1599211611, array(), 'N', array(), $_1806210742);
        }
        if (isset($_1851567167) && is_array($_1851567167) && count($_1851567167) > 0) $_1602080860 = true;
        if ($_1602080860) {
            $_1693387108 = 'SALE';
            $_538371065 = CIBlockPropertyEnum::GetList(array('DEF' => 'DESC', 'SORT' => 'ASC'), array('IBLOCK_ID' => $_1419413357, 'CODE' => $_1693387108));
            if ($_280777863 = $_538371065->Fetch()) {
                $_1974483494 = array($_1693387108 => $_280777863['ID'],);
                CIBlockElement::SetPropertyValuesEx($_1599211611, false, $_1974483494);
            }
        }
        if ($_1599211611) {
            static $_1344837583 = array();
            if (!array_key_exists($_1419413357, $_1344837583)) {
                $_575530065 = CIBlockProperty::GetByID('MINIMUM_PRICE', $_1419413357);
                $_1974483494 = $_575530065->Fetch();
                if ($_1974483494) $_1344837583[$_1419413357] = $_1974483494['ID']; else $_1344837583[$_1419413357] = false;
            }
            if ($_1344837583[$_1419413357]) {
                if ($_1431332036) {
                    $_1772117933 = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $_1431332036, 'PROPERTY_' . $_1379114419 => $_1599211611,), false, false, array('ID'));
                    while ($_1155952816 = $_1772117933->Fetch()) $_458533235[] = $_1155952816['ID'];
                    if (!is_array($_458533235)) $_458533235 = array($_1599211611);
                } else $_458533235 = array($_1599211611);
                $_1526252879 = false;
                $_800788089 = false;
                $_212846028 = CPrice::GetList(array(), array('PRODUCT_ID' => $_458533235,));
                while ($_414850766 = $_212846028->Fetch()) {
                    if ($_1602080860) {
                        $_1851567167 = CCatalogDiscount::GetDiscountByPrice($_414850766['ID'], array(), 'N', $_1806210742);
                        $_74111579 = CCatalogProduct::CountPriceWithDiscount($_414850766['PRICE'], $_414850766['CURRENCY'], $_1851567167);
                        $_414850766['DISCOUNT_PRICE'] = $_74111579;
                    }
                    if (isset($_74111579)) {
                        $_2064490301 = $_74111579;
                        unset($_74111579);
                    } else {
                        $_2064490301 = $_414850766['PRICE'];
                    }
                    if (CModule::IncludeModule('currency') && $_1587261140 != $_414850766['CURRENCY']) $_2064490301 = CCurrencyRates::ConvertCurrency($_2064490301, $_414850766['CURRENCY'], $_1587261140);
                    $_518805335 = $_2064490301;
                    $_518805335 = $_414850766['PRICE'];
                    if ($_1526252879 === false || $_1526252879 > $_518805335) $_1526252879 = $_518805335;
                    if ($_800788089 === false || $_800788089 < $_518805335) $_800788089 = $_518805335;
                }
                if ($_1526252879 !== false) {
                    CIBlockElement::SetPropertyValuesEx($_1599211611, $_1419413357, array('MINIMUM_PRICE' => $_1526252879, 'MAXIMUM_PRICE' => $_800788089,));
                }
            }
        }
    }

    public function ExpandStringWithMacros($_1651156902, $_1864248882)
    {
        if (is_array($_1651156902)) {
            $_295404037 = array();
            foreach ($_1651156902 as $_1610659773 => $_1800172428) $_295404037[$_1610659773] = B2BSKit::__136825466($_1800172428, $_1864248882);
        } else {
            $_295404037 = '';
            $_295404037 = B2BSKit::__136825466($_1651156902, $_1864248882);
        }
        return $_295404037;
    }

    private function __136825466($_1713660508, $_1864248882)
    {
        $_295404037 = '';
        $_1651156902 = 0;
        $_292453156 = array();
        $_1701746442 = explode('#', $_1713660508);
        if (isset($_1864248882) && is_array($_1864248882)) foreach ($_1701746442 as $_836137043) {
            if ($_5861995 % 2 == 0) {
                $_295404037 .= $_836137043;
            } else {
                $_1247995260 = explode('||', $_836137043);
                if (count($_1247995260) > 1) {
                    $_292453156 = $_1864248882[$_1247995260[0]];
                    $_1651156902 = 0;
                    while (is_array($_292453156)) {
                        if (count($_1247995260) < $_1651156902 - 1) break;
                        if (!isset($_1247995260[$_1651156902]) && !isset($_1247995260[$_1651156902 + 1])) break;
                        $_292453156 = B2BSKit::__452302845($_292453156, $_1247995260[$_1651156902 + 1]);
                        ++$_1651156902;
                    }
                    if (isset($_292453156) && !is_array($_292453156)) $_295404037 .= $_292453156;
                } else {
                    if (isset($_1864248882[$_1247995260[0]]) && !is_array($_1864248882[$_1247995260[0]])) $_295404037 .= $_1864248882[$_1247995260[0]];
                }
            }
            ++$_5861995;
        }
        return $_295404037;
    }

    private function __452302845($_292453156, $_642518419)
    {
        if (is_array($_292453156)) {
            return $_292453156[$_642518419];
        } else {
            return $_292453156;
        }
    }

    public function ReplaceComponentParams($_262489769, &$_1724505242)
    {
        $_1076306348 = Option::get("kit.b2bshop", "REPLACE_COMPONENT_PARAMS", "Y");
        if ($_1076306348 == 'Y') {
            $_141094850 = array('b2bs_catalog' => array('bitrix:catalog' => array('AJAX_PRODUCT_LOAD' => array('COPTION_KEY' => 'AJAX_PRODUCT_LOAD', 'COPTION_VALUE' => ''), 'AVAILABLE_DELETE' => array('COPTION_KEY' => 'AVAILABLE_DELETE', 'COPTION_VALUE' => 'N'), 'BASKET_URL' => array('COPTION_KEY' => 'URL_CART', 'COPTION_VALUE' => ''), 'COLOR_FROM_IMAGE' => array('COPTION_KEY' => 'COLOR_FROM_IMAGE', 'COPTION_VALUE' => 'Y'), 'COLOR_IMAGE_HEIGHT' => array('COPTION_KEY' => 'COLOR_IMAGE_HEIGHT', 'COPTION_VALUE' => '100'), 'COLOR_IMAGE_WIDTH' => array('COPTION_KEY' => 'COLOR_IMAGE_WIDTH', 'COPTION_VALUE' => '37'), 'COLOR_IN_PRODUCT' => array('COPTION_KEY' => 'COLOR_IN_PRODUCT', 'COPTION_VALUE' => ''), 'COLOR_IN_PRODUCT_CODE' => array('COPTION_KEY' => 'COLOR_IN_PRODUCT_CODE', 'COPTION_VALUE' => ''), 'COLOR_IN_PRODUCT_LINK' => array('COPTION_KEY' => 'COLOR_IN_PRODUCT_LINK', 'COPTION_VALUE' => ''), 'COLOR_IN_SECTION_LINK' => array('COPTION_KEY' => 'COLOR_IN_SECTION_LINK', 'COPTION_VALUE' => '1'), 'COLOR_IN_SECTION_LINK_MAIN' => array('COPTION_KEY' => 'COLOR_IN_SECTION_LINK_MAIN', 'COPTION_VALUE' => ''), 'COLOR_SLIDER_COUNT_IMAGES_HOR' => array('COPTION_KEY' => 'COLOR_SLIDER_COUNT_IMAGES_HOR', 'COPTION_VALUE' => '0'), 'COLOR_SLIDER_COUNT_IMAGES_VER' => array('COPTION_KEY' => 'COLOR_SLIDER_COUNT_IMAGES_VER', 'COPTION_VALUE' => '0'), 'DELETE_OFFER_NOIMAGE' => array('COPTION_KEY' => 'DELETE_OFFER_NOIMAGE', 'COPTION_VALUE' => ''), 'DETAIL_HEIGHT_BIG' => array('COPTION_KEY' => 'DETAIL_HEIGHT_BIG', 'COPTION_VALUE' => ''), 'DETAIL_HEIGHT_MEDIUM' => array('COPTION_KEY' => 'DETAIL_HEIGHT_MEDIUM', 'COPTION_VALUE' => ''), 'DETAIL_HEIGHT_SMALL' => array('COPTION_KEY' => 'DETAIL_HEIGHT_SMALL', 'COPTION_VALUE' => ''), 'DETAIL_OFFERS_PROPERTY_CODE' => array('COPTION_KEY' => 'OFFER_TREE_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'DETAIL_PROPERTY_CODE' => array('COPTION_KEY' => 'ALL_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'DETAIL_WIDTH_BIG' => array('COPTION_KEY' => 'DETAIL_WIDTH_BIG', 'COPTION_VALUE' => ''), 'DETAIL_WIDTH_MEDIUM' => array('COPTION_KEY' => 'DETAIL_WIDTH_MEDIUM', 'COPTION_VALUE' => ''), 'DETAIL_WIDTH_SMALL' => array('COPTION_KEY' => 'DETAIL_WIDTH_SMALL', 'COPTION_VALUE' => ''), 'FILTER_ITEM_COUNT' => array('COPTION_KEY' => 'FILTER_ITEM_COUNT', 'COPTION_VALUE' => ''), 'FILTER_PRICE_CODE' => array('COPTION_KEY' => 'PRICE_CODE', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'FLAG_PROPS' => array('COPTION_KEY' => 'FLAG_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'IBLOCK_ID' => array('COPTION_KEY' => 'IBLOCK_ID', 'COPTION_VALUE' => ''), 'IBLOCK_TYPE' => array('COPTION_KEY' => 'IBLOCK_TYPE', 'COPTION_VALUE' => ''), 'IMAGE_RESIZE_MODE' => array('COPTION_KEY' => 'IMAGE_RESIZE_MODE', 'COPTION_VALUE' => 'BX_RESIZE_IMAGE_PROPORTIONAL'), 'IS_FANCY' => array('COPTION_KEY' => 'IS_FANCY', 'COPTION_VALUE' => ''), 'LAZY_LOAD' => array('COPTION_KEY' => 'LAZY_LOAD', 'COPTION_VALUE' => ''), 'LIST_HEIGHT_MEDIUM' => array('COPTION_KEY' => 'LIST_HEIGHT_MEDIUM', 'COPTION_VALUE' => ''), 'LIST_HEIGHT_SMALL' => array('COPTION_KEY' => 'LIST_HEIGHT_SMALL', 'COPTION_VALUE' => ''), 'LIST_OFFERS_PROPERTY_CODE' => array('COPTION_KEY' => 'OFFER_TREE_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'LIST_WIDTH_MEDIUM' => array('COPTION_KEY' => 'LIST_WIDTH_MEDIUM', 'COPTION_VALUE' => ''), 'LIST_WIDTH_SMALL' => array('COPTION_KEY' => 'LIST_WIDTH_SMALL', 'COPTION_VALUE' => ''), 'MANUFACTURER_ELEMENT_PROPS' => array('COPTION_KEY' => 'MANUFACTURER_ELEMENT_PROPS', 'COPTION_VALUE' => ''), 'MANUFACTURER_LIST_PROPS' => array('COPTION_KEY' => 'MANUFACTURER_LIST_PROPS', 'COPTION_VALUE' => ''), 'MODIFICATION' => array('COPTION_KEY' => 'MODIFICATION', 'COPTION_VALUE' => ''), 'MODIFICATION_COUNT' => array('COPTION_KEY' => 'MODIFICATION_COUNT', 'COPTION_VALUE' => '4'), 'MORE_PHOTO_OFFER_PROPS' => array('COPTION_KEY' => 'MORE_PHOTO_OFFER_PROPS', 'COPTION_VALUE' => ''), 'MORE_PHOTO_PRODUCT_PROPS' => array('COPTION_KEY' => 'MORE_PHOTO_PRODUCT_PROPS', 'COPTION_VALUE' => ''), 'OFFERS_CART_PROPERTIES' => array('COPTION_KEY' => 'OFFER_TREE_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'OFFER_COLOR_PROP' => array('COPTION_KEY' => 'OFFER_COLOR_PROP', 'COPTION_VALUE' => ''), 'OFFER_ELEMENT_PARAMS' => array('COPTION_KEY' => 'OFFER_ELEMENT_PARAMS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'OFFER_ELEMENT_PROPS' => array('COPTION_KEY' => 'OFFER_ELEMENT_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'OFFER_TREE_PROPS' => array('COPTION_KEY' => 'OFFER_TREE_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'PAGE_ELEMENT_COUNT' => array('COPTION_KEY' => 'CATALOG_LIST_COUNT', 'COPTION_VALUE' => '36'), 'PAGE_ELEMENT_COUNT_IN_ROW' => array('COPTION_KEY' => 'CATALOG_LIST_COUNT_IN_ROW', 'COPTION_VALUE' => '4'), 'PICTURE_FROM_OFFER' => array('COPTION_KEY' => 'PICTURE_FROM_OFFER', 'COPTION_VALUE' => ''), 'PRELOADER' => array('COPTION_KEY' => 'IMAGE', 'COPTION_VALUE' => '', 'COPTION_MODULE' => 'kit.preloader'), 'PRICE_CODE' => array('COPTION_KEY' => 'PRICE_CODE', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'SEOMETA_TAGS' => array('COPTION_KEY' => 'SEOMETA_TAGS', 'COPTION_VALUE' => 'BOTTOM'), 'TEL_DELIVERY_ID' => array('COPTION_KEY' => 'TEL_DELIVERY_ID', 'COPTION_VALUE' => ''), 'TEL_MASK' => array('COPTION_KEY' => 'TEL_MASK', 'COPTION_VALUE' => '+7999999-99-99'), 'TEL_PAY_SYSTEM_ID' => array('COPTION_KEY' => 'TEL_PAY_SYSTEM_ID', 'COPTION_VALUE' => ''))), 'ms_brands' => array('kit:news' => array('COLOR_IN_PRODUCT' => array('COPTION_KEY' => 'COLOR_IN_PRODUCT', 'COPTION_VALUE' => ''), 'COLOR_IN_PRODUCT_CODE' => array('COPTION_KEY' => 'COLOR_IN_PRODUCT_CODE', 'COPTION_VALUE' => ''), 'COLOR_IN_PRODUCT_LINK' => array('COPTION_KEY' => 'COLOR_IN_PRODUCT_LINK', 'COPTION_VALUE' => ''), 'COLOR_IN_SECTION_LINK' => array('COPTION_KEY' => 'COLOR_IN_SECTION_LINK', 'COPTION_VALUE' => '1'), 'COLOR_IN_SECTION_LINK_MAIN' => array('COPTION_KEY' => 'COLOR_IN_SECTION_LINK_MAIN', 'COPTION_VALUE' => ''), 'IBLOCK_ID' => array('COPTION_KEY' => 'BRAND_IBLOCK_ID', 'COPTION_VALUE' => ''), 'IBLOCK_ID_CATALOG' => array('COPTION_KEY' => 'IBLOCK_TYPE', 'COPTION_VALUE' => ''), 'IBLOCK_TYPE' => array('COPTION_KEY' => 'BRAND_IBLOCK_TYPE', 'COPTION_VALUE' => ''), 'IBLOCK_TYPE_CATALOG' => array('COPTION_KEY' => 'IBLOCK_ID', 'COPTION_VALUE' => ''), 'IMAGE_RESIZE_MODE' => array('COPTION_KEY' => 'IMAGE_RESIZE_MODE', 'COPTION_VALUE' => 'BX_RESIZE_IMAGE_PROPORTIONAL'), 'LAZY_LOAD' => array('COPTION_KEY' => 'LAZY_LOAD', 'COPTION_VALUE' => ''), 'NEWS_COUNT' => array('COPTION_KEY' => 'CATALOG_LIST_COUNT', 'COPTION_VALUE' => '36'), 'PAGE_ELEMENT_COUNT_IN_ROW' => array('COPTION_KEY' => 'CATALOG_LIST_COUNT_IN_ROW', 'COPTION_VALUE' => '4'), 'PRELOADER' => array('COPTION_KEY' => 'IMAGE', 'COPTION_VALUE' => '', 'COPTION_MODULE' => 'kit.preloader'), 'PRICE_CODE' => array('COPTION_KEY' => 'PRICE_CODE', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'SEOMETA_TAGS' => array('COPTION_KEY' => 'SEOMETA_TAGS', 'COPTION_VALUE' => 'BOTTOM'), 'TEL_DELIVERY_ID' => array('COPTION_KEY' => 'TEL_DELIVERY_ID', 'COPTION_VALUE' => ''), 'TEL_MASK' => array('COPTION_KEY' => 'TEL_MASK', 'COPTION_VALUE' => '+7999999-99-99'), 'TEL_PAY_SYSTEM_ID' => array('COPTION_KEY' => 'TEL_PAY_SYSTEM_ID', 'COPTION_VALUE' => ''))), 'ms_sales' => array('bitrix:catalog' => array('AVAILABLE_DELETE' => array('COPTION_KEY' => 'AVAILABLE_DELETE', 'COPTION_VALUE' => 'N'), 'BASKET_URL' => array('COPTION_KEY' => 'URL_CART', 'COPTION_VALUE' => ''), 'COLOR_IN_PRODUCT' => array('COPTION_KEY' => 'COLOR_IN_PRODUCT', 'COPTION_VALUE' => ''), 'COLOR_IN_PRODUCT_CODE' => array('COPTION_KEY' => 'COLOR_IN_PRODUCT_CODE', 'COPTION_VALUE' => ''), 'COLOR_IN_PRODUCT_LINK' => array('COPTION_KEY' => 'COLOR_IN_PRODUCT_LINK', 'COPTION_VALUE' => ''), 'COLOR_IN_SECTION_LINK' => array('COPTION_KEY' => 'COLOR_IN_SECTION_LINK', 'COPTION_VALUE' => '1'), 'COLOR_IN_SECTION_LINK_MAIN' => array('COPTION_KEY' => 'COLOR_IN_SECTION_LINK_MAIN', 'COPTION_VALUE' => ''), 'DELETE_OFFER_NOIMAGE' => array('COPTION_KEY' => 'DELETE_OFFER_NOIMAGE', 'COPTION_VALUE' => ''), 'DETAIL_HEIGHT_BIG' => array('COPTION_KEY' => 'DETAIL_HEIGHT_BIG', 'COPTION_VALUE' => ''), 'DETAIL_HEIGHT_MEDIUM' => array('COPTION_KEY' => 'DETAIL_HEIGHT_MEDIUM', 'COPTION_VALUE' => ''), 'DETAIL_HEIGHT_SMALL' => array('COPTION_KEY' => 'DETAIL_HEIGHT_SMALL', 'COPTION_VALUE' => ''), 'DETAIL_OFFERS_PROPERTY_CODE' => array('COPTION_KEY' => 'OFFER_TREE_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'DETAIL_PROPERTY_CODE' => array('COPTION_KEY' => 'ALL_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'DETAIL_WIDTH_BIG' => array('COPTION_KEY' => 'DETAIL_WIDTH_BIG', 'COPTION_VALUE' => ''), 'DETAIL_WIDTH_MEDIUM' => array('COPTION_KEY' => 'DETAIL_WIDTH_MEDIUM', 'COPTION_VALUE' => ''), 'DETAIL_WIDTH_SMALL' => array('COPTION_KEY' => 'DETAIL_WIDTH_SMALL', 'COPTION_VALUE' => ''), 'FILTER_PRICE_CODE' => array('COPTION_KEY' => 'PRICE_CODE', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'FLAG_PROPS' => array('COPTION_KEY' => 'FLAG_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'IBLOCK_ID' => array('COPTION_KEY' => 'IBLOCK_ID', 'COPTION_VALUE' => ''), 'IBLOCK_TYPE' => array('COPTION_KEY' => 'IBLOCK_TYPE', 'COPTION_VALUE' => ''), 'IMAGE_RESIZE_MODE' => array('COPTION_KEY' => 'IMAGE_RESIZE_MODE', 'COPTION_VALUE' => 'BX_RESIZE_IMAGE_PROPORTIONAL'), 'IS_FANCY' => array('COPTION_KEY' => 'IS_FANCY', 'COPTION_VALUE' => ''), 'LAZY_LOAD' => array('COPTION_KEY' => 'LAZY_LOAD', 'COPTION_VALUE' => ''), 'LIST_HEIGHT_MEDIUM' => array('COPTION_KEY' => 'LIST_HEIGHT_MEDIUM', 'COPTION_VALUE' => ''), 'LIST_HEIGHT_SMALL' => array('COPTION_KEY' => 'LIST_HEIGHT_SMALL', 'COPTION_VALUE' => ''), 'LIST_OFFERS_PROPERTY_CODE' => array('COPTION_KEY' => 'OFFER_TREE_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'LIST_WIDTH_MEDIUM' => array('COPTION_KEY' => 'LIST_WIDTH_MEDIUM', 'COPTION_VALUE' => ''), 'LIST_WIDTH_SMALL' => array('COPTION_KEY' => 'LIST_WIDTH_SMALL', 'COPTION_VALUE' => ''), 'MANUFACTURER_ELEMENT_PROPS' => array('COPTION_KEY' => 'MANUFACTURER_ELEMENT_PROPS', 'COPTION_VALUE' => ''), 'MANUFACTURER_LIST_PROPS' => array('COPTION_KEY' => 'MANUFACTURER_LIST_PROPS', 'COPTION_VALUE' => ''), 'MORE_PHOTO_OFFER_PROPS' => array('COPTION_KEY' => 'MORE_PHOTO_OFFER_PROPS', 'COPTION_VALUE' => ''), 'MORE_PHOTO_PRODUCT_PROPS' => array('COPTION_KEY' => 'MORE_PHOTO_PRODUCT_PROPS', 'COPTION_VALUE' => ''), 'OFFERS_CART_PROPERTIES' => array('COPTION_KEY' => 'OFFER_TREE_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'OFFER_COLOR_PROP' => array('COPTION_KEY' => 'OFFER_COLOR_PROP', 'COPTION_VALUE' => ''), 'OFFER_TREE_PROPS' => array('COPTION_KEY' => 'OFFER_TREE_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'PAGE_ELEMENT_COUNT' => array('COPTION_KEY' => 'CATALOG_LIST_COUNT', 'COPTION_VALUE' => '36'), 'PAGE_ELEMENT_COUNT_IN_ROW' => array('COPTION_KEY' => 'CATALOG_LIST_COUNT_IN_ROW', 'COPTION_VALUE' => '4'), 'PICTURE_FROM_OFFER' => array('COPTION_KEY' => 'PICTURE_FROM_OFFER', 'COPTION_VALUE' => ''), 'PRELOADER' => array('COPTION_KEY' => 'IMAGE', 'COPTION_VALUE' => '', 'COPTION_MODULE' => 'kit.preloader'), 'PRICE_CODE' => array('COPTION_KEY' => 'PRICE_CODE', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'SEOMETA_TAGS' => array('COPTION_KEY' => 'SEOMETA_TAGS', 'COPTION_VALUE' => 'BOTTOM'),)), 'ms_basket' => array('bitrix:sale.basket.basket' => array('IBLOCK_ID' => array('COPTION_KEY' => 'IBLOCK_ID', 'COPTION_VALUE' => ''), 'IBLOCK_TYPE' => array('COPTION_KEY' => 'IBLOCK_TYPE', 'COPTION_VALUE' => ''), 'IMG_HEIGHT' => array('COPTION_KEY' => 'CART_IMG_HEIGHT', 'COPTION_VALUE' => ''), 'IMG_WIDTH' => array('COPTION_KEY' => 'CART_IMG_WIDTH', 'COPTION_VALUE' => ''), 'MANUFACTURER_ELEMENT_PROPS' => array('COPTION_KEY' => 'MANUFACTURER_ELEMENT_PROPS', 'COPTION_VALUE' => ''), 'MANUFACTURER_LIST_PROPS' => array('COPTION_KEY' => 'MANUFACTURER_LIST_PROPS', 'COPTION_VALUE' => ''), 'MORE_PHOTO_OFFER_PROPS' => array('COPTION_KEY' => 'MORE_PHOTO_OFFER_PROPS', 'COPTION_VALUE' => ''), 'MORE_PHOTO_PRODUCT_PROPS' => array('COPTION_KEY' => 'MORE_PHOTO_PRODUCT_PROPS', 'COPTION_VALUE' => ''), 'OFFER_COLOR_PROP' => array('COPTION_KEY' => 'OFFER_COLOR_PROP', 'COPTION_VALUE' => ''), 'OFFER_TREE_PROPS' => array('COPTION_KEY' => 'OFFER_TREE_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'OFFERS_PROPS' => array('COPTION_KEY' => 'OFFER_TREE_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'PATH_TO_ORDER' => array('COPTION_KEY' => 'URL_ORDER', 'COPTION_VALUE' => ''), 'PICTURE_FROM_OFFER' => array('COPTION_KEY' => 'PICTURE_FROM_OFFER', 'COPTION_VALUE' => ''))), 'ms_news' => array('bitrix:news' => array('IBLOCK_ID' => array('COPTION_KEY' => 'NEWS_IBLOCK_ID', 'COPTION_VALUE' => ''), 'IBLOCK_TYPE' => array('COPTION_KEY' => 'NEWS_IBLOCK_TYPE', 'COPTION_VALUE' => ''))), 'ms_basket_order' => array('bitrix:sale.basket.basket' => array('OFFERS_PROPS' => array('COPTION_KEY' => 'OFFER_TREE_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'PATH_TO_ORDER' => array('COPTION_KEY' => 'URL_PAGE_ORDER', 'COPTION_VALUE' => ''), 'IBLOCK_TYPE' => array('COPTION_KEY' => 'IBLOCK_TYPE', 'COPTION_VALUE' => ''), 'IBLOCK_ID' => array('COPTION_KEY' => 'IBLOCK_ID', 'COPTION_VALUE' => ''), 'OFFER_TREE_PROPS' => array('COPTION_KEY' => 'OFFER_TREE_PROPS', 'COPTION_VALUE' => '', 'SERIALIZED' => 'Y'), 'OFFER_COLOR_PROP' => array('COPTION_KEY' => 'OFFER_COLOR_PROP', 'COPTION_VALUE' => ''), 'MANUFACTURER_ELEMENT_PROPS' => array('COPTION_KEY' => 'MANUFACTURER_ELEMENT_PROPS', 'COPTION_VALUE' => ''), 'MANUFACTURER_LIST_PROPS' => array('COPTION_KEY' => 'MANUFACTURER_LIST_PROPS', 'COPTION_VALUE' => ''), 'PICTURE_FROM_OFFER' => array('COPTION_KEY' => 'PICTURE_FROM_OFFER', 'COPTION_VALUE' => ''), 'MORE_PHOTO_PRODUCT_PROPS' => array('COPTION_KEY' => 'MORE_PHOTO_PRODUCT_PROPS', 'COPTION_VALUE' => ''), 'MORE_PHOTO_OFFER_PROPS' => array('COPTION_KEY' => 'MORE_PHOTO_OFFER_PROPS', 'COPTION_VALUE' => ''), 'IMG_WIDTH' => array('COPTION_KEY' => 'CART_IMG_WIDTH', 'COPTION_VALUE' => ''), 'IMG_HEIGHT' => array('COPTION_KEY' => 'CART_IMG_HEIGHT', 'COPTION_VALUE' => ''))), 'ms_order_ajax' => array('bitrix:sale.order.ajax' => array('ORDER_ITEM_SHOW_COUNT' => array('COPTION_KEY' => 'ORDER_ITEM_SHOW_COUNT', 'COPTION_VALUE' => '5'), 'PATH_TO_BASKET' => array('COPTION_KEY' => 'URL_CART', 'COPTION_VALUE' => ''), 'PATH_TO_ORDER' => array('COPTION_KEY' => 'URL_ORDER', 'COPTION_VALUE' => ''), 'PATH_TO_PAYMENT' => array('COPTION_KEY' => 'URL_PAYMENT', 'COPTION_VALUE' => ''), 'PATH_TO_PERSONAL' => array('COPTION_KEY' => 'URL_PERSONAL', 'COPTION_VALUE' => ''))));
            foreach ($_141094850 as $_2081113493 => $_2013452766) {
                foreach ($_2013452766 as $_1686281183 => $_149460704) {
                    foreach ($_149460704 as $_1541074310 => $_1922182322) {
                        if (strripos($_1724505242, $_1686281183) !== false && strripos($_1724505242, $_2081113493) !== false) {
                            if (isset($_1922182322['COPTION_MODULE']) && !empty($_1922182322['COPTION_MODULE'])) {
                                $_1070643306 = $_1922182322['COPTION_MODULE'];
                            } else {
                                $_1070643306 = 'kit.b2bshop';
                            }
                            if (strripos($_1724505242, $_1541074310) === false) {
                                $_1410869626 = '/"' . $_1686281183 . '",
(.*)"(.*)",
(.*)
/';
                                if (isset($_1922182322['SERIALIZED']) && $_1922182322['SERIALIZED'] == 'Y') {
                                    $_580611492 = '"' . $_1686281183 . '",
$1"$2",$3
"' . $_1541074310 . '" => unserialize(COption::GetOptionString("' . $_1070643306 . '","' . $_1922182322['COPTION_KEY'] . '","' . $_1922182322['COPTION_VALUE'] . '")),
';
                                } else {
                                    $_580611492 = '"' . $_1686281183 . '",
$1"$2",$3
"' . $_1541074310 . '" => COption::GetOptionString("' . $_1070643306 . '","' . $_1922182322['COPTION_KEY'] . '","' . $_1922182322['COPTION_VALUE'] . '"),
';
                                }
                            } else {
                                $_988183630 = '/"' . $_1541074310 . '"[ ]+=>[ ]+(.*),/';
                                preg_match($_988183630, $_1724505242, $_561790992);
                                unset($_988183630);
                                if (isset($_561790992[1]) && strripos($_561790992[1], 'COption::GetOptionString') === false) {
                                    if ($_1922182322['SERIALIZED'] == 'Y') {
                                        $_561790992[1] = str_replace(array('array(', ')', '"', '\''), ' ', $_561790992[1]);
                                        $_530670248 = explode(',', $_561790992[1]);
                                        $_1245780571 = array_values(array_diff($_530670248, array('')));
                                        unset($_530670248);
                                        if (count($_1245780571) > 0) {
                                        }
                                        unset($_1245780571);
                                    } else {
                                        $_807168213 = str_replace(array('"', '\''), ' ', $_561790992[1]);
                                        unset($_561790992);
                                        if (strlen($_807168213) > 0) {
                                        }
                                    }
                                }
                                $_1410869626 = '/"' . $_1541074310 . '"[ ]+=>[ ]+(.*?),
/';
                                if (isset($_1922182322['SERIALIZED']) && $_1922182322['SERIALIZED'] == 'Y') {
                                    $_580611492 = '"' . $_1541074310 . '" => unserialize(COption::GetOptionString("' . $_1070643306 . '","' . $_1922182322['COPTION_KEY'] . '","' . $_1922182322['COPTION_VALUE'] . '")),
';
                                } else {
                                    $_580611492 = '"' . $_1541074310 . '" => COption::GetOptionString("' . $_1070643306 . '","' . $_1922182322['COPTION_KEY'] . '","' . $_1922182322['COPTION_VALUE'] . '"),
';
                                }
                            }
                            $_1724505242 = preg_replace($_1410869626, $_580611492, $_1724505242, 1);
                        }
                    }
                }
            }
        }
        return true;
    }

    public function OnBeforeUserAddHandler(&$_2006275658)
    {
        if (isset($_2006275658["LOGIN"]) && isset($_2006275658["EMAIL"]) && $_2006275658["LOGIN"] != $_2006275658["EMAIL"]) {
            $_2006275658["LOGIN"] = $_2006275658["EMAIL"];
        }
    }

    public function Redirect404()
    {
        if (!defined('ADMIN_SECTION') && defined("ERROR_404") && defined("PATH_TO_404") && file_exists($_SERVER["DOCUMENT_ROOT"] . '/404.php')) {
            global $APPLICATION;
            $APPLICATION->RestartBuffer();
            CHTTP::SetStatus('404 Not Found');
            include($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php');
            include($_SERVER['DOCUMENT_ROOT'] . '/404.php');
            include($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php');
        }
    }

    public function OnSaleComponentOrderPropertiesHandler(&$_1877535881, $_1651404512, &$_329485612, &$_1864248882)
    {
        if ($_1877535881['PERSON_TYPE_ID'] != $_1877535881['PERSON_TYPE_OLD'] && $_SESSION['KIT']['DEFAULT_ORGANIZATION'] > 0 && $_1864248882['ORDER_PROP']['USER_PROFILES'][$_SESSION['KIT']['DEFAULT_ORGANIZATION']]) {
            $_1877535881['PROFILE_ID'] = $_SESSION['KIT']['DEFAULT_ORGANIZATION'];
            $_635159958 = \Bitrix\Sale\OrderUserProperties::getProfileValues($_SESSION['KIT']['DEFAULT_ORGANIZATION']);
            $_1877535881['ORDER_PROP'] = $_635159958;
            foreach ($_1864248882['ORDER_PROP']['USER_PROFILES'] as $_1217432760 => $_503059810) {
                if ($_503059810['CHECKED']) {
                    unset($_1864248882['ORDER_PROP']['USER_PROFILES'][$_1217432760]['CHECKED']);
                }
            }
            $_1864248882['ORDER_PROP']['USER_PROFILES'][$_SESSION['KIT']['DEFAULT_ORGANIZATION']]['CHECKED'] = 'Y';
        }
    }

    public function OnPageStartHandler()
    {
        if ($_REQUEST['was'] == 1 && $_REQUEST['del_filter'] == 1) {
            unset($_SESSION["MS_ONLY_AVAILABLE"]);
            unset($_SESSION['MS_ONLY_CHECKED']);
            unset($_SESSION['MS_SECTIONS']);
        }
    }
}