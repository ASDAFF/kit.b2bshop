<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$list_page = $arResult["LIST_PAGE_URL"];
$site_dir = SITE_DIR;
$list_page = str_replace("#SITE_DIR#/", $site_dir, $list_page);
$arResult["LIST_PAGE_URL_"] = $list_page;
 
$this_alpha = "";
$ITEMS_APHABET = array();
$arEngAlpha = array("A", "a", "B", "b", "C", "c", "D", "d", "E", "e", "F", "f", "G", "g", "H", "h", "I", "i", "J", "j", "K", "k", "L", "l", "M", "m", "N", "n", "O", "o", "P", "p", "Q", "q", "R", "r", "S", "s", "T", "t", "U", "u", "V", "v", "W", "w", "X", "x", "Y", "y", "Z", "z");
foreach($arResult["ITEMS"] as $key => $arItem):
    $this_alpha = mb_substr($arItem['NAME'],0,1);
    if(in_array($this_alpha, $arEngAlpha)) {
      $ITEMS_APHABET["ENG"][$this_alpha][] = $arItem;   
    } else {
      $ITEMS_APHABET["RUS"][$this_alpha][] = $arItem;  
    }         
endforeach;
$arResult['ITEMS_APHABET'] = $ITEMS_APHABET;
?>