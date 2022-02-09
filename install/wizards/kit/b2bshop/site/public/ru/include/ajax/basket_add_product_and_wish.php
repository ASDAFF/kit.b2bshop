<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if(!isset($_GET['ajax_basket']) || $_GET['ajax_basket'] != 'Y')
{
    die;
}

if(!isset($_GET['entity']) || !in_array(strtolower($_GET['entity']), array('basket', 'delay')) || !isset($_GET['action']) || !in_array(strtolower($_GET['action']), array('add', 'delete', 'move', 'calculate')) || !isset($_GET['s_id']) || intval($_GET['s_id']) < 1)
{
    die;
}

$entity = strtolower($_GET['entity']);
$action = strtolower($_GET['action']);
$func_name = $action.'_'.$entity;

ob_start();
$helper = new BasketHelper();
if(in_array($action, array('add', 'delete', 'move')))
    $result = $helper->$func_name(intval($_GET['s_id']));
else
    $result = $helper->$func_name(intval($_GET['offerID']), intval($_GET['s_id']));
ob_end_clean();

if($func_name == 'add_delay' && $result->isSuccess())
{
    $addResult = array('STATUS' => 'OK', 'MESSAGE' => 'asd');
    $APPLICATION->RestartBuffer();
    echo CUtil::PhpToJSObject($addResult);
    die();
}

if($func_name == 'add_basket' && $result->isSuccess())
{
    $addResult = array('STATUS' => 'OK', 'MESSAGE' => 'asd');
    $APPLICATION->RestartBuffer();
    echo CUtil::PhpToJSObject($addResult);
    die();
}

if(!$result->isSuccess())
{
    die;
}

$addResult = array('STATUS' => 'OK', 'MESSAGE' => 'asd');

$url = $_SERVER['HTTP_REFERER'];

if(strpos($url, '?'))
    $url .= '&bxajaxid='.$_REQUEST['bxajaxid'];
else
    $url .= '?bxajaxid='.$_REQUEST['bxajaxid'];

LocalRedirect($url);
die;
//LocalRedirect('/personal/cart/?bxajaxid=e62f6a5f110520d89685f42102c6cb7f');


class BasketHelper
{
    private static $saleIncluded = null;
    private static $statisticIncluded = null;

    public function add_basket(int $product_id)
    {
        $product = $product = $this->makeProductArray($product_id, 'N');
        return $this->addProduct($product);
    }

    public function add_delay(int $product_id)
    {        
        $product = $this->makeProductArray($product_id, 'Y');
        return $this->addProduct($product);
    }

    public function calculate_delay(int $product_id, int $basketItemId)
    {
        $filter = array(
            'ID' => $basketItemId
        );

        $curProductBasket = \Bitrix\Sale\Internals\BasketTable::getList(array('filter' => $filter, 'select' => array('ID', 'FUSER_ID', 'PRODUCT_ID', 'QUANTITY', 'DELAY')))->fetch();

        $result = new \Bitrix\Main\Result();

        if($curProductBasket['PRODUCT_ID'] == $product_id)
            return $result;

        if(empty($curProductBasket))
        {
            //$result->addError(new \Bitrix\Main\Error('not found product #'.$basketItemId));
            return $result;
        }

        $_REQUEST["quantity"] = $curProductBasket['QUANTITY'];
        $resultBasket = $this->add_delay($product_id);

        if($resultBasket->isSuccess())
            $resultBasket = \Bitrix\Sale\Internals\BasketTable::Delete($basketItemId);

        if(!$resultBasket->isSuccess())
        {
            $errors = $resultBasket->getErrors();

            foreach($errors as $error)
                $result->addError($error);
        }

        return $result;
    }

    public function calculate_basket(int $product_id, int $basketItemId)
    {
        $filter = array(
            'ID' => $basketItemId
        );

        $curProductBasket = \Bitrix\Sale\Internals\BasketTable::getList(array('filter' => $filter, 'select' => array('ID', 'FUSER_ID', 'PRODUCT_ID', 'QUANTITY', 'DELAY')))->fetch();

        $result = new \Bitrix\Main\Result();

        if($curProductBasket['PRODUCT_ID'] == $product_id)
            return $result;

        if(empty($curProductBasket))
        {
            //$result->addError(new \Bitrix\Main\Error('not found product #'.$basketItemId));
            return $result;
        }

        $_REQUEST["quantity"] = $curProductBasket['QUANTITY'];

        $resultBasket = $this->add_basket($product_id);

        if($resultBasket->isSuccess())
            $resultBasket = \Bitrix\Sale\Internals\BasketTable::Delete($basketItemId);

        if(!$resultBasket->isSuccess())
        {
            $errors = $resultBasket->getErrors();

            foreach($errors as $error)
                $result->addError($error);
        }

        return $result;
    }

    public function move_basket(int $product_id)
    {
        \Bitrix\Main\Loader::includeModule('sale');
        $filter = array(
            'FUSER_ID' => \Bitrix\Sale\Fuser::getId(),
            'LID' => SITE_ID,
            'ORDER_ID' => false,
            'PRODUCT_ID' => $product_id,
            'DELAY' => 'N'
        );

        $curProductBasket = \Bitrix\Sale\Internals\BasketTable::getList(array('filter' => $filter, 'select' => array('ID', 'FUSER_ID', 'PRODUCT_ID', 'QUANTITY', 'DELAY')))->fetch();
        $result = new \Bitrix\Main\Result();

        if(empty($curProductBasket))
        {
            $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_PRODUCT')));
            return $result;
        }

        $similarBasketProduct = \Bitrix\Sale\Internals\BasketTable::getList(array('filter' => array_merge($filter, array('DELAY' => 'Y')), 'select' => array('ID', 'FUSER_ID', 'PRODUCT_ID', 'QUANTITY', 'DELAY')))->fetch();

        if(empty($similarBasketProduct))
        {
            $resultBasket =  \Bitrix\Sale\Internals\BasketTable::Update($curProductBasket['ID'], array('DELAY' => 'Y'));
        }
        else
        {
            $resultBasket = \Bitrix\Sale\Internals\BasketTable::Update($similarBasketProduct['ID'], array('QUANTITY' => intval($curProductBasket['QUANTITY'] + $similarBasketProduct['QUANTITY'])));

            if($resultBasket->isSuccess())
                $resultBasket = \Bitrix\Sale\Internals\BasketTable::Delete($curProductBasket['ID']);
        }

        if(!$resultBasket->isSuccess())
            $result->addError('bad update basket');

        return $result;
    }

    public function move_delay(int $product_id)
    {
        //$basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), SITE_ID);
        \Bitrix\Main\Loader::includeModule('sale');
        $filter = array(
            'FUSER_ID' => \Bitrix\Sale\Fuser::getId(),
            'LID' => SITE_ID,
            'ORDER_ID' => false,
            'PRODUCT_ID' => $product_id,
            'DELAY' => 'Y'
        );

        $curProductBasket = \Bitrix\Sale\Internals\BasketTable::getList(array('filter' => $filter, 'select' => array('ID', 'FUSER_ID', 'PRODUCT_ID', 'QUANTITY', 'DELAY')))->fetch();
        $result = new \Bitrix\Main\Result();

        if(empty($curProductBasket))
        {
            $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_PRODUCT')));
            return $result;
        }

        $similarBasketProduct = \Bitrix\Sale\Internals\BasketTable::getList(array('filter' => array_merge($filter, array('DELAY' => 'N')), 'select' => array('ID', 'FUSER_ID', 'PRODUCT_ID', 'QUANTITY', 'DELAY')))->fetch();
        
        if(empty($similarBasketProduct))
        {
            $resultBasket =  \Bitrix\Sale\Internals\BasketTable::Update($curProductBasket['ID'], array('DELAY' => 'N'));
        }
        else
        {
            $resultBasket = \Bitrix\Sale\Internals\BasketTable::Update($similarBasketProduct['ID'], array('QUANTITY' => intval($curProductBasket['QUANTITY'] + $similarBasketProduct['QUANTITY'])));

            if($resultBasket->isSuccess())
                $resultBasket = \Bitrix\Sale\Internals\BasketTable::Delete($curProductBasket['ID']);
        }

        if(!$resultBasket->isSuccess())
            $result->addError('bad update basket');

        return $result;
    }

    protected function makeProductArray($product_id, $delay)
    {
        $addByAjax = isset($_REQUEST['ajax_basket']) && 'Y' == $_REQUEST['ajax_basket'];
        $QUANTITY = isset($_REQUEST["quantity"])?$_REQUEST["quantity"]:1;
        $product_properties = array();
        $intProductIBlockID = intval(CIBlockElement::GetIBlockByID($product_id));
        $mxCatalog = CCatalogSKU::GetInfoByProductIBlock($intProductIBlockID);
        $mxOffer = CCatalogSKU::GetInfoByOfferIBlock($intProductIBlockID);
        $iblock = false;
        $arParams["PRODUCT_PROPERTIES"] = array();

        if(is_array($mxCatalog))
        {
            $iblock = $mxOffer['PRODUCT_IBLOCK_ID'];
        }

        if(is_array($mxOffer))
        {
            $iblock = $mxOffer['IBLOCK_ID'];
        }

        if($iblock)
        {
            if(!isset($_GET['props']) || empty(explode(',', $_GET['props'])))
            {
                $resProps = \Bitrix\Iblock\PropertyTable::getList(array(
                    'filter' => array('IBLOCK_ID' => $iblock),
                    'select' => array('CODE'),
                    'cache' => array('ttl' => 36000000)
                ));

                while($arProp = $resProps->fetch())
                    $arParams["PRODUCT_PROPERTIES"][] = $arProp['CODE'];
            }
            else
                $arParams["PRODUCT_PROPERTIES"] = explode(',', $_GET['props']);

            $resProductProps = \CIBlockElement::GetProperty($iblock, $product_id, array());

            $arResult["PROPERTIES"] = array();

            while($arProp = $resProductProps->fetch())
            {
                $arResult["PROPERTIES"][$arProp['CODE']] = array(
                    'NAME' => $arProp['NAME'],
                    'CODE' => $arProp['CODE'],
                    'VALUE' => $arProp['VALUE']
                );
            }
        }

        $arResult = array();

        if (0 < $intProductIBlockID)
        {
            if (is_array($mxCatalog))
            {
                if (!empty($arParams["PRODUCT_PROPERTIES"]))
                {
                    foreach($arParams["PRODUCT_PROPERTIES"] as $prop)
                    {
                        $arProp = $arResult["PROPERTIES"][$prop];
                        $product_properties[] = array(
                            "NAME" => $arProp["NAME"],
                            "CODE" => $arProp["CODE"],
                            "VALUE" => $arProp["VALUE"],
                            "SORT" => "100"
                        ) ;
                    }
                }
            }
            else
            {
                $skuAddProps = (isset($_REQUEST['basket_props']) && !empty($_REQUEST['basket_props']) ? $_REQUEST['basket_props'] : '');

                if (!empty($arParams["PRODUCT_PROPERTIES"]) || !empty($skuAddProps))
                {
                    $product_properties = CIBlockPriceTools::GetOfferProperties(
                        $product_id,
                        $mxOffer['PRODUCT_IBLOCK_ID'],
                        $arParams["PRODUCT_PROPERTIES"],
                        $skuAddProps
                    );

                    //$product_properties = array_merge($product_properties0, $product_properties1);
                }
            }

            if (0 >= $QUANTITY)
            {
                $rsRatios = CCatalogMeasureRatio::getList(
                    array(),
                    array('PRODUCT_ID' => $product_id),
                    false,
                    false,
                    array('PRODUCT_ID', 'RATIO')
                );
                if ($arRatio = $rsRatios->Fetch())
                {
                    $intRatio = intval($arRatio['RATIO']);
                    $dblRatio = doubleval($arRatio['RATIO']);
                    $QUANTITY = ($dblRatio > $intRatio ? $dblRatio : $intRatio);
                }
            }
            if (0 >= $QUANTITY)
                $QUANTITY = 1;
        }
        else
        {
            $strError = GetMessage('B2BS_CATALOG_ERROR2BASKET');
            $successfulAdd = false;
        }

        if ($successfulAdd)
        {
            //$notifyOption = COption::GetOptionString("sale", "subscribe_prod", "");
            //$arNotify = unserialize($notifyOption);
            $default_subscribe = COption::GetOptionString("catalog", "default_subscribe", "");
            $arRewriteFields = array();

            if(isset($_GET['delay']))
            {
                $arRewriteFields["DELAY"] = "Y";
                $arRewriteFields["CAN_BUY"] = "N";
            }
        }

        return  array(
            'PRODUCT_ID' => $product_id,
            'QUANTITY' => $QUANTITY,
            'DELAY' => ($delay == 'Y') ? 'Y' : 'N',
            'PROPS' => $product_properties
        );
    }

    private function addProduct(array $product)
    {
        $result = new \Bitrix\Main\Result();

        if (empty($product['PRODUCT_ID']))
        {
            $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_PRODUCT')));
            return $result;
        }
        $product_id = (int)$product['PRODUCT_ID'];
        if ($product_id <= 0)
        {
            $result->addError(new \Bitrix\Main\Error(Main\Localization\Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_PRODUCT')));
            return $result;
        }

        $product['MODULE'] = 'catalog';
        $product['PRODUCT_PROVIDER_CLASS'] = self::getDefaultProviderName();

        if (self::$saleIncluded === null)
            self::$saleIncluded = \Bitrix\Main\Loader::includeModule('sale');

        if (!self::$saleIncluded)
        {
            $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_SALE')));
            return $result;
        }

        $siteId = SITE_ID;
        if (!empty($basketFields['LID']))
            $siteId = $basketFields['LID'];

        $context = array(
            'SITE_ID' => $siteId,
        );

        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), $siteId);

        $options['CHECK_PERMISSIONS'] = 'Y';
        $options['USE_MERGE'] = (isset($options['USE_MERGE']) && $options['USE_MERGE'] == 'N' ? 'N' : 'Y');
        $options['CHECK_CRAWLERS'] = 'Y';

        $result = static::add($basket, $product, $context, $options, $product['DELAY']);
        if ($result->isSuccess())
        {
            $saveResult = $basket->save();

            if ($saveResult->isSuccess())
            {
                $resultData = $result->getData();
                if (!empty($resultData['BASKET_ITEM']))
                {
                    $item = $resultData['BASKET_ITEM'];
                    if ($item instanceof \Bitrix\Sale\BasketItemBase)
                    {
                        if (self::$statisticIncluded === null)
                            self::$statisticIncluded = \Bitrix\Main\Loader::includeModule('statistic');

                        //                        if (self::$statisticIncluded)
                        //                        {
                        //                            \CStatistic::Set_Event(
                        //                                'sale2basket', 'catalog', $item->getField('DETAIL_PAGE_URL')
                        //                            );
                        //                        }
                        $result->setData(array(
                            'ID' => $item->getId()
                        ));
                    }
                    else
                    {
                        $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_UNKNOWN')));
                    }
                    unset($item);
                }
                else
                {
                    $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_UNKNOWN')));
                }
                unset($resultData);
            }
            else
            {
                $result->addErrors($saveResult->getErrors());
            }
            unset($saveResult);
        }
        unset($basket, $context, $siteId);

        return $result;
    }

    private static function add(\Bitrix\Sale\BasketBase $basket, array $fields, array $context, array $options = array(), $delay = 'N')
    {
        $result = new \Bitrix\Main\Result();

        if (!isset($options['CHECK_CRAWLERS']) || $options['CHECK_CRAWLERS'] == 'Y')
        {
            $validBuyer = static::checkCurrentUser();
            if (!$validBuyer->isSuccess())
            {
                $result->addErrors($validBuyer->getErrors());
                return $result;
            }
            unset($validBuyer);
        }

        if (empty($fields['PRODUCT_ID']))
        {
            $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_PRODUCT')));
            return $result;
        }
        $product_id = (int)$fields['PRODUCT_ID'];
        if ($product_id <= 0)
        {
            $result->addError(new \Bitrix\Main\Error(Main\Localization\Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_PRODUCT')));
            return $result;
        }
        unset($fields['PRODUCT_ID']);

        if (empty($fields['QUANTITY']))
        {
            $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_EMPTY_QUANTITY')));
            return $result;
        }
        $quantity = (float)$fields['QUANTITY'];
        if ($quantity <= 0)
        {
            $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_EMPTY_QUANTITY')));
            return $result;
        }

        if (self::$saleIncluded === null)
            self::$saleIncluded = Loader::includeModule('sale');

        if (!self::$saleIncluded)
        {
            $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_SALE')));
            return $result;
        }

        $module = 'catalog';

        $presets = array(
            'PRODUCT_ID' => $product_id
        );

        if (array_key_exists('MODULE', $fields))
        {
            $module = $fields['MODULE'];
            unset($fields['MODULE']);
        }

        if (isset($fields['PRODUCT_PROVIDER_CLASS']))
        {
            $presets['PRODUCT_PROVIDER_CLASS'] = $fields['PRODUCT_PROVIDER_CLASS'];
        }
        unset($fields['PRODUCT_PROVIDER_CLASS']);

        if (isset($fields['CALLBACK_FUNC']))
        {
            $presets['CALLBACK_FUNC'] = $fields['CALLBACK_FUNC'];
        }
        unset($fields['CALLBACK_FUNC']);

        if (isset($fields['PAY_CALLBACK_FUNC']))
        {
            $presets['PAY_CALLBACK_FUNC'] = $fields['PAY_CALLBACK_FUNC'];
        }
        unset($fields['PAY_CALLBACK_FUNC']);

        if (isset($fields['SUBSCRIBE']))
        {
            $presets['SUBSCRIBE'] = $fields['SUBSCRIBE'];
        }
        unset($fields['SUBSCRIBE']);

        $propertyList = array();
        if (!empty($fields['PROPS']) && is_array($fields['PROPS']))
        {
            $propertyList = $fields['PROPS'];
            unset($fields['PROPS']);
        }

        if ($module == 'catalog')
        {
            $elementFilter = array(
                'ID' => $product_id,
                'ACTIVE' => 'Y',
                'ACTIVE_DATE' => 'Y',
                'CHECK_PERMISSIONS' => 'N'
            );

            if (!empty($options['CHECK_PERMISSIONS']) && $options['CHECK_PERMISSIONS'] == "Y")
            {
                $elementFilter['CHECK_PERMISSIONS'] = 'Y';
                $elementFilter['MIN_PERMISSION'] = 'R';
                if (isset($context['USER_ID']))
                    $elementFilter['PERMISSIONS_BY'] = $context['USER_ID'];
            }

            $iterator = \CIBlockElement::GetList(
                array(),
                $elementFilter,
                false,
                false,
                array(
                    "ID",
                    "IBLOCK_ID",
                    "XML_ID",
                    "NAME",
                    "DETAIL_PAGE_URL",
                )
            );
            if (!($elementFields = $iterator->GetNext()))
            {
                $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_IBLOCK_ELEMENT')));
                return $result;
            }

            $iterator = \Bitrix\Catalog\ProductTable::getList(array(
                'select' => array(
                    'ID', 'TYPE', 'AVAILABLE', 'CAN_BUY_ZERO', 'QUANTITY_TRACE', 'QUANTITY',
                    'WEIGHT', 'WIDTH', 'HEIGHT', 'LENGTH',
                    'MEASURE'
                ),
                'filter' => array('=ID' => $product_id)
            ));
            $productFields = $iterator->fetch();
            unset($iterator);
            if (empty($productFields))
            {
                $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_PRODUCT')));
                return $result;
            }

            if (
                ($productFields['TYPE'] == \Bitrix\Catalog\ProductTable::TYPE_SKU || $productFields['TYPE'] == \Bitrix\Catalog\ProductTable::TYPE_EMPTY_SKU)
                && (string)\Bitrix\Main\Config\Option::get('catalog', 'show_catalog_tab_with_offers') != 'Y'
            )
            {
                $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_CANNOT_ADD_SKU')));
                return $result;
            }
            if ($productFields['AVAILABLE'] != \Bitrix\Catalog\ProductTable::STATUS_YES)
            {
                $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_PRODUCT_RUN_OUT')));
                return $result;
            }
            if ($productFields['TYPE'] == \Bitrix\Catalog\ProductTable::TYPE_OFFER)
            {
                $skuInfo = \CCatalogSku::GetProductInfo($product_id, $elementFields['IBLOCK_ID']);
                if (empty($skuInfo))
                {
                    $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_PRODUCT_BAD_TYPE')));
                    return $result;
                }
                else
                {
                    $parentIterator = \CIBlockElement::GetList(
                        array(),
                        array(
                            'ID' => $skuInfo['ID'],
                            'IBLOCK_ID' => $skuInfo['IBLOCK_ID'],
                            'ACTIVE' => 'Y',
                            'ACTIVE_DATE' => 'Y',
                            'CHECK_PERMISSIONS' => 'N'
                        ),
                        false,
                        false,
                        array('ID', 'IBLOCK_ID', 'XML_ID')
                    );
                    $parent = $parentIterator->Fetch();
                    if (empty($parent))
                    {
                        $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_PRODUCT')));
                        return $result;
                    }
                    elseif (strpos($elementFields["~XML_ID"], '#') === false)
                    {
                        $elementFields["~XML_ID"] = $parent['XML_ID'].'#'.$elementFields["~XML_ID"];
                    }
                    unset($parent, $parentIterator);
                }
            }

            if ($productFields['TYPE'] == \Bitrix\Catalog\ProductTable::TYPE_SET)
            {
                $allSets = \CCatalogProductSet::getAllSetsByProduct($product_id, \CCatalogProductSet::TYPE_SET);
                if (empty($allSets))
                {
                    $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_PRODUCT_SET')));
                    return $result;
                }
                $set = current($allSets);
                unset($allSets);
                $itemIds = array();
                foreach ($set['ITEMS'] as $item)
                {
                    if ($item['ITEM_ID'] != $item['OWNER_ID'])
                        $itemIds[$item['ITEM_ID']] = $item['ITEM_ID'];
                }
                if (empty($itemIds))
                {
                    $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_PRODUCT_SET')));
                    return $result;
                }

                $setFilter = array(
                    'ID' => $itemIds,
                    'ACTIVE' => 'Y',
                    'ACTIVE_DATE' => 'Y',
                    'CHECK_PERMISSIONS' => 'N'
                );
                if (!empty($options['CHECK_PERMISSIONS']) && $options['CHECK_PERMISSIONS'] == "Y")
                {
                    $setFilter['CHECK_PERMISSIONS'] = 'Y';
                    $setFilter['MIN_PERMISSION'] = 'R';
                    if (isset($context['USER_ID']))
                        $setFilter['PERMISSIONS_BY'] = $context['USER_ID'];
                }

                $iterator = \CIBlockElement::GetList(
                    array(),
                    $setFilter,
                    false,
                    false,
                    array('ID', 'IBLOCK_ID')
                );
                while ($row = $iterator->Fetch())
                {
                    if (isset($itemIds[$row['ID']]))
                        unset($itemIds[$row['ID']]);
                }
                unset($row, $iterator);
                if (!empty($itemIds))
                {
                    $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_NO_PRODUCT_SET_ITEMS')));
                    return $result;
                }
            }

            $propertyIndex = self::getPropertyIndex('CATALOG.XML_ID', $propertyList);
            if (!isset($fields['CATALOG_XML_ID']) || $propertyIndex === null)
            {
                $iBlockXmlID = (string)\CIBlock::GetArrayByID($elementFields['IBLOCK_ID'], 'XML_ID');
                if ($iBlockXmlID !== '')
                {
                    $fields['CATALOG_XML_ID'] = $iBlockXmlID;
                    $propertyData = array(
                        'NAME' => 'Catalog XML_ID',
                        'CODE' => 'CATALOG.XML_ID',
                        'VALUE' => $iBlockXmlID
                    );
                    if ($propertyIndex !== null)
                        $propertyList[$propertyIndex] = $propertyData;
                    else
                        $propertyList[] = $propertyData;
                    unset($propertyData);
                }
                unset($iBlockXmlID);
            }

            $propertyIndex = self::getPropertyIndex('PRODUCT.XML_ID', $propertyList);
            if (!isset($fields['PRODUCT_XML_ID']) || $propertyIndex === null)
            {
                $fields['PRODUCT_XML_ID'] = $elementFields['~XML_ID'];
                $propertyData = array(
                    'NAME' => 'Product XML_ID',
                    'CODE' => 'PRODUCT.XML_ID',
                    'VALUE' => $elementFields['~XML_ID']
                );
                if ($propertyIndex !== null)
                    $propertyList[$propertyIndex] = $propertyData;
                else
                    $propertyList[] = $propertyData;
                unset($propertyData);
            }

            unset($propertyIndex);
        }

        if (static::isCompatibilityEventAvailable())
        {
            $eventFields = array_merge($presets, $fields);
            $eventFields['MODULE'] = $module;
            $eventFields['PROPS'] = $propertyList;

            $eventResult = static::runCompatibilityEvent($eventFields);
            if ($eventResult === false)
            {
                return $result;
            }

            foreach ($eventResult as $key => $value)
            {
                if (isset($presets[$key]))
                {
                    if ($presets[$key] !== $value)
                    {
                        $presets[$key] = $value;
                    }
                }
                elseif (!isset($fields[$key]) || $fields[$key] !== $value)
                {
                    $fields[$key] = $value;
                }
            }

            $propertyList = $eventResult['PROPS'];
        }

        $basketItem = null;
        // using merge by default
        if (!isset($options['USE_MERGE']) || $options['USE_MERGE'] === 'Y')
        {
            $basketItem = self::getExistsItem($basket, $module, $product_id, $delay);
        }

        if ($basketItem)
        {
            $fields['QUANTITY'] = $basketItem->getQuantity() + $quantity;
        }
        else
        {
            $fields['QUANTITY'] = $quantity;
            $basketItem = $basket->createItem($module, $product_id);
        }

        if (!$basketItem)
        {
            throw new \Bitrix\Main\ObjectNotFoundException('BasketItem');
        }

        /** @var Sale\BasketPropertiesCollection $propertyCollection */
        $propertyCollection = $basketItem->getPropertyCollection();
        if ($propertyCollection)
        {
            $propertyCollection->setProperty($propertyList);
        }

        $r = $basketItem->setFields($presets);
        if (!$r->isSuccess())
        {
            $result->addErrors($r->getErrors());
            return $result;
        }

        $r = $basketItem->setField('QUANTITY', $fields['QUANTITY']);
        if (!$r->isSuccess())
        {
            $result->addErrors($r->getErrors());
            return $result;
        }
        unset($fields['QUANTITY']);

        $settableFields = array_fill_keys($basketItem::getSettableFields(), true);
        $basketFields = array_intersect_key($fields, $settableFields);

        if (!empty($basketFields))
        {
            $r = $basketItem->setFields($basketFields);
            if (!$r->isSuccess())
            {
                $result->addErrors($r->getErrors());
                return $result;
            }
        }

        $result->setData(
            array(
                'BASKET_ITEM' => $basketItem
            )
        );

        return $result;
    }

    private static function getExistsItem($basket, $moduleId, $product_id, $delay = 'N')
    {
        /** @var BasketItem $basketItem */
        foreach ($basket as $basketItem)
        {
            if ($basketItem->getField('PRODUCT_ID') == $product_id && $basketItem->getField('MODULE') == $moduleId && $basketItem->getField('DELAY') == $delay)
            {
                return $basketItem;
            }
        }

        return null;
    }

    /**
     * Search basket property.
     *
     * @param string $code				Property code.
     * @param array $propertyList		Basket properties.
     * @return int|null
     */
    private static function getPropertyIndex($code, array $propertyList = array())
    {
        $propertyIndex = null;
        if (empty($propertyList))
            return $propertyIndex;

        foreach ($propertyList as $index => $propertyData)
        {
            if (!empty($propertyData['CODE']) && $code == $propertyData['CODE'])
            {
                $propertyIndex = $index;
                break;
            }
        }
        unset($index, $propertyData);

        return $propertyIndex;
    }

    /**
     * @return bool
     */
    private static function isCompatibilityEventAvailable()
    {
        return \Bitrix\Main\Config\Option::get('sale', 'expiration_processing_events', 'N') === 'Y';
    }

    /**
     * Checking that the current user is not a search robot.
     *
     * @return Main\Result
     */
    private static function checkCurrentUser()
    {
        $result = new \Bitrix\Main\Result();

        if (self::$statisticIncluded === null)
            self::$statisticIncluded = \Bitrix\Main\Loader::includeModule('statistic');

        if (!self::$statisticIncluded)
            return $result;

        if (isset($_SESSION['SESS_SEARCHER_ID']) && (int)$_SESSION['SESS_SEARCHER_ID'] > 0)
            $result->addError(new \Bitrix\Main\Error(Loc::getMessage('BX_CATALOG_PRODUCT_BASKET_ERR_SEARCHER')));

        return $result;
    }

    public static function getDefaultProviderName()
    {
        return "\Bitrix\Catalog\Product\CatalogProvider";
    }

    public function __call($name, $arg)
    {
        if(method_exists($this, $name))
            return call_user_func(array($this, $name), $arg[0], $arg[1]);
        else
            throw new Exception('Class '.get_class($this).' have not function "'.$name.'"');
    }
	private static function runCompatibilityEvent(array $fields)
	{
		foreach (GetModuleEvents("sale", "OnBeforeBasketAdd", true) as $event)
		{
			if (ExecuteModuleEventEx($event, array(&$fields)) === false)
				return false;
		}

		return $fields;
	}
}
?>