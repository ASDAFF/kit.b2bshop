<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
echo "<pre>";
//var_dump($arResult['PAY_SYSTEM_ID']);
echo "</pre>";

$db_ptype = CSalePaySystem::GetList(
    Array(), Array("ID"=>$arResult['PAY_SYSTEM_ID']), Array(), Array(), Array('IS_CASH')
);
while ($ptype = $db_ptype->Fetch())
{
    $payment_type = $ptype["IS_CASH"];
}
$arResult['PAYMENT_IS_CACHE_TYPE'] = $payment_type;

foreach ($arResult['ORDER_PROPS'] as $k => $prop) {
    // фигня для вывода данных по макету
    switch ($prop["CODE"]) {
        case 'CONFIDENTIAL': unset($arResult['ORDER_PROPS'][$k]); break;
        case 'EQ_POST': unset($arResult['ORDER_PROPS'][$k]); break;
        case 'CONTACT_PERSON': unset($arResult['ORDER_PROPS'][$k]); break;
        case 'UR_ADDRESS': unset($arResult['ORDER_PROPS'][$k]); break;
        case 'UR_CITY': unset($arResult['ORDER_PROPS'][$k]); break;
        case 'UR_ZIP': unset($arResult['ORDER_PROPS'][$k]); break;


        case 'LAST_NAME': $last_name = $prop['VALUE']; break;
        case 'SECOND_NAME': $second_name = $prop['VALUE']; break;
        case 'NAME': $name = $prop['VALUE']; break;

        case 'POST_ZIP': $zip = $prop['VALUE']; break;
        case 'POST_CITY': $city = $prop['VALUE']; break;
        case 'POST_ADDRESS': $address = $prop['VALUE']; break;

        case 'EMAIL': $arResult['EMAIL'] = $prop; unset($arResult['ORDER_PROPS'][$k]); break;
        case 'PHONE':  $arResult['PHONE'] = $prop; unset($arResult['ORDER_PROPS'][$k]); break;
    }
}

foreach ($arResult["BASKET"] as $k => $prod) {
    $total = $prod["PRICE"]*$prod["QUANTITY"];
    $arResult["BASKET"][$k]['TOTAL_PRICE'] = CurrencyFormat($total, CCurrency::GetBaseCurrency());
}

$arResult['FULL_NAME'] = $last_name . ' ' . $name . ' ' .$second_name;
$arResult['FULL_ADDRESS'] = $zip . ' ' . $city . ', ' .$address;
/*echo "<pre>";
var_dump($arResult['PHONE']);
echo "</pre>";*/

$arParams["CUSTOM_SELECT_PROPS"] = array(
    0 => "NAME",
    1 => "PROPERTY_CML2_ARTICLE",
    2 => "QUANTITY",
    3 => "PRICE_FORMATED",
);


$all_quantity = 0;
foreach($arResult["BASKET"] as $prod) {
    $all_quantity += $prod['QUANTITY'];
}
$arResult['ALL_QUANTITY'] = $all_quantity;
