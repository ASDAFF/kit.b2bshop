<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$name = $arResult["NAME"];
$text = $arResult["~PREVIEW_TEXT"]?$arResult["~PREVIEW_TEXT"]:$arResult["~DETAIL_TEXT"];
$url = $arResult["DETAIL_PAGE_URL"];
$img = $arResult["PREVIEW_PICTURE"]["SRC"]?$arResult["PREVIEW_PICTURE"]["SRC"]:$arResult["DETAIL_PICTURE"]["SRC"];

B2BSKit::createSocMeta($name, $text, $url, $img, "");

$arParams["PRODUCT_ID_VARIABLE"] = "s_id";
$strError = '';
$successfulAdd = true;
?>
<script type="text/javascript">
    $(function() {
        <?if($USER->IsAuthorized()):?>
        $(".subscribe_new").hide();
        <?else:?>
        $(".subscribe_product_form").hide();
        <?endif;?>
    });
</script>
<?
$codeBrand = $arParams["MANUFACTURER_LIST_PROPS"];
if (isset($_REQUEST[$arParams["ACTION_VARIABLE"]]) && isset($_REQUEST[$arParams["PRODUCT_ID_VARIABLE"]]))
{
    if(isset($_REQUEST[$arParams["ACTION_VARIABLE"]."BUY"]))
        $action = "BUY";
    elseif(isset($_REQUEST[$arParams["ACTION_VARIABLE"]."ADD2BASKET"]))
        $action = "ADD2BASKET";
    else
        $action = strtoupper($_REQUEST[$arParams["ACTION_VARIABLE"]]);

    $productID = intval($_REQUEST[$arParams["PRODUCT_ID_VARIABLE"]]);
    if (($action == "ADD2BASKET" || $action == "BUY" || $action == "SUBSCRIBE_PRODUCT" || $action == "DELAY") && $productID > 0)
    {   
        if (\Bitrix\Main\Loader::includeModule("sale") && \Bitrix\Main\Loader::includeModule("catalog"))
        {
            $addByAjax = isset($_REQUEST['ajax_basket']) && 'Y' == $_REQUEST['ajax_basket'];
            $QUANTITY = isset($_REQUEST["quantity"])?$_REQUEST["quantity"]:1;
            $product_properties = array();
            $intProductIBlockID = intval(CIBlockElement::GetIBlockByID($productID));
            if (0 < $intProductIBlockID)
            {   
                if ($arParams['ADD_PROPERTIES_TO_BASKET'] == 'Y')
                {
                    if ($intProductIBlockID == $arParams["IBLOCK_ID"])
                    {   
                        if (!empty($arParams["PRODUCT_PROPERTIES"]))
                        {   //printr($arParams);
                            
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
                            //printr($product_properties);
                            /*if (
                                isset($_REQUEST[$arParams["PRODUCT_PROPS_VARIABLE"]])
                                && is_array($_REQUEST[$arParams["PRODUCT_PROPS_VARIABLE"]])
                            )
                            {  
                                $product_properties = CIBlockPriceTools::CheckProductProperties(
                                    $arParams["IBLOCK_ID"],
                                    $productID,
                                    $arParams["PRODUCT_PROPERTIES"],
                                    $_REQUEST[$arParams["PRODUCT_PROPS_VARIABLE"]],
                                    $arParams['PARTIAL_PRODUCT_PROPERTIES'] == 'Y'
                                );
                                if (!is_array($product_properties))
                                {
                                    $strError = GetMessage("B2BS_CATALOG_ERROR2BASKET");
                                    $successfulAdd = false;
                                }
                            }
                            else
                            {
                                $strError = GetMessage("B2BS_CATALOG_ERROR2BASKET");
                                $successfulAdd  = false;
                            }*/
                        }
                    }
                    else
                    {   //printr($_REQUEST);
                        $skuAddProps = (isset($_REQUEST['basket_props']) && !empty($_REQUEST['basket_props']) ? $_REQUEST['basket_props'] : '');
                        if (!empty($arParams["OFFERS_CART_PROPERTIES"]) || !empty($skuAddProps))
                        {   /*$product_properties0 = $product_properties1 = array();
                            if($arResult["PROPERTIES"][$codeBrand]["VALUE"])
                            {
                                $product_properties0 = CIBlockPriceTools::CheckProductProperties(
                                    $arParams["IBLOCK_ID"],
                                    $arResult["ID"],
                                    $arParams["PRODUCT_PROPERTIES"],
                                    array($codeBrand => $arResult["PROPERTIES"][$codeBrand]["VALUE_ENUM_ID"]),
                                    $arParams['PARTIAL_PRODUCT_PROPERTIES'] == 'Y'
                                );
                            }
                            if(!is_array($product_properties0)) $product_properties0 = array();*/
                            $product_properties = CIBlockPriceTools::GetOfferProperties(
                                $productID,
                                $arParams["IBLOCK_ID"],
                                $arParams["OFFERS_CART_PROPERTIES"],
                                $skuAddProps
                            );

                            //$product_properties = array_merge($product_properties0, $product_properties1);
                        }
                    }
                }
                if ($arParams["USE_PRODUCT_QUANTITY"])
                {
                    if (isset($_REQUEST[$arParams["PRODUCT_QUANTITY_VARIABLE"]]))
                    {
                        $QUANTITY = doubleval($_REQUEST[$arParams["PRODUCT_QUANTITY_VARIABLE"]]);
                    }
                }
                if (0 >= $QUANTITY)
                {
                    $rsRatios = CCatalogMeasureRatio::getList(
                        array(),
                        array('PRODUCT_ID' => $productID),
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

            if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET['ajax_email'] == "Y" && check_bitrix_sessid() && !$USER->IsAuthorized() && isset($_GET['user_mail']))
            {
                $arResultSubscribe["MESSAGE"] = "";
		        $arErrors = array();
                $user_mail = trim($_REQUEST['user_mail']);
        		$id = IntVal($_REQUEST['id']);
        		$user_login = trim($_REQUEST["user_login"]);
        		$user_password = trim($_REQUEST["user_password"]);
        		$url = trim($_REQUEST["notifyurl"]);
                $arResultSubscribe["STATUS"] = "ERROR";
                if (strlen($user_login) <= 0 && strlen($user_password) <= 0 && strlen($user_mail) <= 0)
        			$arResultSubscribe["MESSAGE"] = 'NOTIFY_ERR_NULL';

        		if (strlen($user_mail) > 0 && strlen($arResultSubscribe["MESSAGE"]) <= 0)
        		{
        			$res = CUser::GetList($b, $o, array("=EMAIL" => $user_mail));
        			if($res->Fetch())
        				$arResultSubscribe["MESSAGE"] = 'NOTIFY_ERR_MAIL_EXIST';
        		}

                if (strlen($arResultSubscribe["MESSAGE"]) <= 0)
        		{
        			if (strlen($user_mail) > 0 && COption::GetOptionString("main", "new_user_registration", "N") == "Y")
        			{
        				$user_id = CSaleUser::DoAutoRegisterUser($user_mail, array(), SITE_ID, $arErrors);
        				if ($user_id > 0)
        				{
        					$USER->Authorize($user_id);
        					if (count($arErrors) > 0)
        					{
        						$arResultSubscribe["MESSAGE"] = $arErrors[0]["TEXT"];
        					}
        				}
        				else
        				{
        					$arResultSubscribe["MESSAGE"] = 'NOTIFY_ERR_REG';
                            $arResultSubscribe["MESSAGE"] = $arErrors[0]["TEXT"];
        				}
        			}
        			else
        			{
        				$arAuthResult = $USER->Login($user_login, $user_password, "Y");
        				$rs = $APPLICATION->arAuthResult = $arAuthResult;
        				if (count($rs) > 0 && $rs["TYPE"] == "ERROR")
        					$arResultSubscribe["MESSAGE"] = $rs["MESSAGE"];
        			}

        			if (strlen($arResultSubscribe["MESSAGE"]) <= 0)
        			{
        				$arResultSubscribe["STATUS"] = "Y";
        			}
        		}
                if (strlen($arResultSubscribe["MESSAGE"]) > 0)
                {
                    $APPLICATION->RestartBuffer();
                    echo CUtil::PhpToJSObject($arResultSubscribe);
                    die();
                }

            }

            if ($successfulAdd)
            {
                $notifyOption = COption::GetOptionString("sale", "subscribe_prod", "");
                $arNotify = unserialize($notifyOption);
                $arRewriteFields = array();
                if ($action == "SUBSCRIBE_PRODUCT" && $arNotify[SITE_ID]['use'] == 'Y')
                {
                    $arRewriteFields["SUBSCRIBE"] = "Y";
                    $arRewriteFields["CAN_BUY"] = "N";
                }elseif($action=="DELAY")
                {
                    $arRewriteFields["DELAY"] = "Y";
                    $arRewriteFields["CAN_BUY"] = "N";
                }
            }
            
            $arRewriteFields["DETAIL_PAGE_URL"] = $arResult["DETAIL_PAGE_URL"];
            //printr(array($productID, $QUANTITY, $arRewriteFields, $product_properties));
            if ($successfulAdd)
            {   $arRewriteFields["DETAIL_PAGE_URL"] = $arResult["DETAIL_PAGE_URL"];
                //$arRewriteFields["DETAIL_PAGE_URL"] = "/catalog/";
                
                
                if(!Add2BasketByProductID($productID, $QUANTITY, $arRewriteFields, $product_properties))
                {
                    if ($ex = $APPLICATION->GetException())
                        $strError = $ex->GetString();
                    else
                        $strError = GetMessage("B2BS_CATALOG_ERROR2BASKET");
                    $successfulAdd = false;
                }
            }

            if ($addByAjax)
            {
                if ($successfulAdd)
                {
                    $addResult = array('STATUS' => 'OK', 'MESSAGE' => GetMessage('CATALOG_SUCCESSFUL_ADD_TO_BASKET'));
                }
                else
                {
                    $addResult = array('STATUS' => 'ERROR', 'MESSAGE' => $strError);
                }
                $APPLICATION->RestartBuffer();
                //printr(array($productID, $QUANTITY, $arRewriteFields, $product_properties));
                //printr($arParams["OFFERS_CART_PROPERTIES"]);
                echo CUtil::PhpToJSObject($addResult);
                 die();
            }
            else
            {
                if ($successfulAdd)
                {
                    $pathRedirect = (
                        $action == "BUY"
                        ? $arParams["BASKET_URL"]
                        : $APPLICATION->GetCurPageParam("", array(
                            $arParams["PRODUCT_ID_VARIABLE"],
                            $arParams["ACTION_VARIABLE"],
                            $arParams['PRODUCT_QUANTITY_VARIABLE'],
                            $arParams['PRODUCT_PROPS_VARIABLE']
                        ))
                    );
                    LocalRedirect($pathRedirect);
                }
            }
        }
    }
}




return;
//printr($arResult);
$mess = array(
      'MS_JS_CATALOG_ADD_BASKET' => GetMessage("MS_JS_CATALOG_ADD_BASKET"),
      'MS_JS_CATALOG_ADD_WISH' => GetMessage("MS_JS_CATALOG_ADD_WISH"),
      'MS_JS_CATALOG_SELECT_PROP' => GetMessage("MS_JS_CATALOG_SELECT_PROP"),
);
?>
<script type="text/javascript">
    BX.message(<?=json_encode($mess)?>);
</script>
<?
$name = $arResult["NAME"];
$text = $arResult["~PREVIEW_TEXT"]?$arResult["~PREVIEW_TEXT"]:$arResult["~DETAIL_TEXT"];
$url = $arResult["DETAIL_PAGE_URL"];
$img = $arResult["PREVIEW_PICTURE"]["SRC"]?$arResult["PREVIEW_PICTURE"]["SRC"]:$arResult["DETAIL_PICTURE"]["SRC"];

B2BSKit::createSocMeta($name, $text, $url, $img, "");

$arParams["PRODUCT_ID_VARIABLE"] = "s_id";
$strError = '';
$successfulAdd = true;
//printr($arResult);
$codeBrand = $arParams["MANUFACTURER_LIST_PROPS"];
if (isset($_REQUEST[$arParams["ACTION_VARIABLE"]]) && isset($_REQUEST[$arParams["PRODUCT_ID_VARIABLE"]]))
{
	if(isset($_REQUEST[$arParams["ACTION_VARIABLE"]."BUY"]))
		$action = "BUY";
	elseif(isset($_REQUEST[$arParams["ACTION_VARIABLE"]."ADD2BASKET"]))
		$action = "ADD2BASKET";
	else
		$action = strtoupper($_REQUEST[$arParams["ACTION_VARIABLE"]]);

	$productID = intval($_REQUEST[$arParams["PRODUCT_ID_VARIABLE"]]);
	if (($action == "ADD2BASKET" || $action == "BUY" || $action == "SUBSCRIBE_PRODUCT" || $action == "DELAY") && $productID > 0)
	{
		if (\Bitrix\Main\Loader::includeModule("sale") && \Bitrix\Main\Loader::includeModule("catalog"))
		{
			$addByAjax = isset($_REQUEST['ajax_basket']) && 'Y' == $_REQUEST['ajax_basket'];
			$QUANTITY = 0;
			$product_properties = array();
			$intProductIBlockID = intval(CIBlockElement::GetIBlockByID($productID));
			if (0 < $intProductIBlockID)
			{
				if ($arParams['ADD_PROPERTIES_TO_BASKET'] == 'Y')
				{
					if ($intProductIBlockID == $arParams["IBLOCK_ID"])
					{
						if (!empty($arParams["PRODUCT_PROPERTIES"]))
						{
							if (
								isset($_REQUEST[$arParams["PRODUCT_PROPS_VARIABLE"]])
								&& is_array($_REQUEST[$arParams["PRODUCT_PROPS_VARIABLE"]])
							)
							{
								$product_properties = CIBlockPriceTools::CheckProductProperties(
									$arParams["IBLOCK_ID"],
									$productID,
									$arParams["PRODUCT_PROPERTIES"],
									$_REQUEST[$arParams["PRODUCT_PROPS_VARIABLE"]],
									$arParams['PARTIAL_PRODUCT_PROPERTIES'] == 'Y'
								);
								if (!is_array($product_properties))
								{
									$strError = GetMessage("B2BS_CATALOG_ERROR2BASKET");
									$successfulAdd = false;
								}
							}
							else
							{
								$strError = GetMessage("B2BS_CATALOG_ERROR2BASKET");
								$successfulAdd  = false;
							}
						}
					}
					else
					{
						$skuAddProps = (isset($_REQUEST['basket_props']) && !empty($_REQUEST['basket_props']) ? $_REQUEST['basket_props'] : '');
						if (!empty($arParams["OFFERS_CART_PROPERTIES"]) || !empty($skuAddProps))
						{   $product_properties0 = $product_properties1 = array();
                            if($arResult["PROPERTIES"][$codeBrand]["VALUE"])
                            {
                                $product_properties0 = CIBlockPriceTools::CheckProductProperties(
									$arParams["IBLOCK_ID"],
									$arResult["ID"],
									$arParams["PRODUCT_PROPERTIES"],
									array($codeBrand => $arResult["PROPERTIES"][$codeBrand]["VALUE_ENUM_ID"]),
									$arParams['PARTIAL_PRODUCT_PROPERTIES'] == 'Y'
								);
                            }
                            if(!is_array($product_properties0)) $product_properties0 = array();
                            $product_properties1 = CIBlockPriceTools::GetOfferProperties(
								$productID,
								$arParams["IBLOCK_ID"],
								$arParams["OFFERS_CART_PROPERTIES"],
								$skuAddProps
							);

                            $product_properties = array_merge($product_properties0, $product_properties1);
						}
					}
				}
				if ($arParams["USE_PRODUCT_QUANTITY"])
				{
					if (isset($_REQUEST[$arParams["PRODUCT_QUANTITY_VARIABLE"]]))
					{
						$QUANTITY = doubleval($_REQUEST[$arParams["PRODUCT_QUANTITY_VARIABLE"]]);
					}
				}
				if (0 >= $QUANTITY)
				{
					$rsRatios = CCatalogMeasureRatio::getList(
						array(),
						array('PRODUCT_ID' => $productID),
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
				$notifyOption = COption::GetOptionString("sale", "subscribe_prod", "");
				$arNotify = unserialize($notifyOption);
				$arRewriteFields = array();
				if ($action == "SUBSCRIBE_PRODUCT" && $arNotify[SITE_ID]['use'] == 'Y')
				{
					$arRewriteFields["SUBSCRIBE"] = "Y";
					$arRewriteFields["CAN_BUY"] = "N";
				}elseif($action=="DELAY")
                {
                    $arRewriteFields["DELAY"] = "Y";
					$arRewriteFields["CAN_BUY"] = "N";
                }
			}
            
			if ($successfulAdd)
			{   $arRewriteFields["DETAIL_PAGE_URL"] = $arResult["DETAIL_PAGE_URL"];
                //$arRewriteFields["DETAIL_PAGE_URL"] = "/catalog/";
				if(!Add2BasketByProductID($productID, $QUANTITY, $arRewriteFields, $product_properties))
				{
					if ($ex = $APPLICATION->GetException())
						$strError = $ex->GetString();
					else
						$strError = GetMessage("B2BS_CATALOG_ERROR2BASKET");
					$successfulAdd = false;
				}
			}

			if ($addByAjax)
			{
				if ($successfulAdd)
				{
					$addResult = array('STATUS' => 'OK', 'MESSAGE' => GetMessage('CATALOG_SUCCESSFUL_ADD_TO_BASKET'));
				}
				else
				{
					$addResult = array('STATUS' => 'ERROR', 'MESSAGE' => $strError);
				}
				$APPLICATION->RestartBuffer();
				echo CUtil::PhpToJSObject($addResult);
 				die();
			}
			else
			{
				if ($successfulAdd)
				{
					$pathRedirect = (
						$action == "BUY"
						? $arParams["BASKET_URL"]
						: $APPLICATION->GetCurPageParam("", array(
							$arParams["PRODUCT_ID_VARIABLE"],
							$arParams["ACTION_VARIABLE"],
							$arParams['PRODUCT_QUANTITY_VARIABLE'],
							$arParams['PRODUCT_PROPS_VARIABLE']
						))
					);
					LocalRedirect($pathRedirect);
				}
			}
		}
	}
}
//printr($arResult);
if (isset($_REQUEST["productAction"]))
{
    $arFilter["IBLOCK_ID"] = $arParams["IBLOCK_ID"];
    $arFilter["INCLUDE_SUBSECTIONS"] = "Y";
    if(isset($_SESSION[$arParams["FILTER_NAME"]."_MS"]))
    {
        $arSectID[] = $arResult["IBLOCK_SECTION_ID"];
        if(isset($arResult["SECTION"]["PATH"]) && !empty($arResult["SECTION"]["PATH"]))
        {
            foreach($arResult["SECTION"]["PATH"] as $arPath)
            {
                $arSectID[] = $arPath["ID"];
            }
        }
        foreach($arSectID as $sectID)
        {
            if(isset($_SESSION[$arParams["FILTER_NAME"]."_MS"][$sectID]) && !empty($_SESSION[$arParams["FILTER_NAME"]."_MS"][$sectID]))
            {
                $arFilter = array_merge($arFilter, $_SESSION[$arParams["FILTER_NAME"]."_MS"][$sectID]);
            }
        }
        if(count($arFilter)<=2)
        {
            $arFilter["SECTION_ID"] = $arResult["IBLOCK_SECTION_ID"];
        }

    }else{
        $arFilter["SECTION_ID"] = $arResult["IBLOCK_SECTION_ID"];
    }

    //$arFilter["SECTION_CODE"] = $arResult["IBLOCK_SECTION_ID"];
    $APPLICATION->RestartBuffer();
    $arSort = array(
		$arParams["ELEMENT_SORT_FIELD"] => $arParams["ELEMENT_SORT_ORDER"],
		$arParams["ELEMENT_SORT_FIELD2"] => $arParams["ELEMENT_SORT_ORDER2"],
	);
    $arSelect = array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PICTURE", "DETAIL_PAGE_URL");
    $ID = $arResult["ID"];
    printr($arFilter);
    $rsElement = CIBlockElement::GetList($arSort, $arFilter, false, array("nPageSize"=>2, "nElementID"=>$arResult["ID"]), $arSelect);
    //$rsElement = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
    $find = -1;
    while($arElement = $rsElement->GetNext())
    {
        //printr($arElement);
        $arFind[] = $arElement;
        if($arElement["ID"]==$ID)
        {
            $find = count($arFind)-1;
            unset($arFind[$find]);
            //continue;
        }elseif((count($arFind))>$find && $find!=-1) break;

    }//print "FIND".$find;
    //printr($arFind);
    array_splice($arFind, $find-1, $find-1);


    foreach($arFind as &$arF)
    {
        $arF["PREVIEW_PICTURE"] = $arF["PREVIEW_PICTURE"]?$arF["PREVIEW_PICTURE"]:$arF["DETAIL_PICTURE"];
        if($arF["PREVIEW_PICTURE"])
        {
            $arF["PREVIEW_PICTURE"] = CFile::ResizeImageGet($arF["PREVIEW_PICTURE"], array('width'=>40, 'height'=>60), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        }
    }
    printr($arFind);
    die();
}

?>
