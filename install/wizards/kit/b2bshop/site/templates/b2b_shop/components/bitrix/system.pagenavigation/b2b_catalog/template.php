<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?/*<pre><?print_r($arResult)?></pre>*/?>
<?
function paralax_start($var_1, $var_2) {
    $var_3 = $var_2-$var_1;
    if ($var_3>=4){$var_4 = $var_1-4;}
    elseif ($var_3>=3){$var_4 = $var_1-56;}
    elseif ($var_3>=2){$var_4 = $var_1-6;}
    elseif ($var_3>=1){$var_4 = $var_1-7;}
    else {$var_4 = $var_1-8;}
    return abs($var_4);
}

function paralax_end($var_1, $var_2) {
    $var_3 = $var_2-$var_1;
    if ($var_3>=4){$var_4 = $var_1+4;}
    elseif ($var_3>=3){$var_4 = $var_1+3;}
    elseif ($var_3>=2){$var_4 = $var_1+2;}
    elseif ($var_3>=1){$var_4 = $var_1+1;}
    else {$var_4 = $var_1;}
    return abs($var_4);
}

$var_1 = $arResult["NavPageNomer"]; $var_2 = $arResult["NavPageCount"];

if ($arResult["NavPageCount"]>3)
{
    if ($arResult["NavPageNomer"]>$arResult["nStartPage"] && $arResult["NavPageNomer"]>2){
        $arResult["nStartPage"]=paralax_start($var_1, $var_2);$arResult["nEndPage"]=paralax_end($var_1, $var_2);
    }
    else {$arResult["nStartPage"] = 1;$arResult["nEndPage"]=3;}
}
else {$arResult["nStartPage"]=1;$arResult["nEndPage"]=$arResult["NavPageCount"];}


if(!$arResult["NavShowAlways"])
{
if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
return;
}
?>
<div class="bx_pagination_page">
    <span class="bx_pg_text"><?=GetMessage("pages")?></span>
    <ul>
        <?php
        if ( ! defined ( 'B_PROLOG_INCLUDED' ) || ! B_PROLOG_INCLUDED )
            die ( );

        if ( ! $arResult [ 'NavShowAlways' ] ) {
            if ( $arResult [ 'NavRecordCount' ] == '0' || ( $arResult [ 'NavPageCount' ] == '1' && ! $arResult [ 'NavShowAll' ] ) ) {
                return;
            }
        }
        $strNavQueryString = ( $arResult [ 'NavQueryString' ] != '' ? $arResult [ 'NavQueryString' ] . '&amp;' : '' );
        $strNavQueryStringFull = ( $arResult [ 'NavQueryString' ] != '' ? '?' . $arResult [ 'NavQueryString' ] : '' );
        if ( $arResult [ 'bDescPageNumbering' ] ) {
            if ( $arResult [ 'NavPageNomer' ] < $arResult [ 'NavPageCount' ] ) {
                echo '';
                if ( $arResult [ 'bSavePage' ] ) {
                    echo '<a href="' . $arResult [ 'sUrlPath' ] . '?' . 'PAGEN_' . $arResult [ 'NavNum' ] . '=' . ( $arResult [ 'NavPageNomer' ] + '1' ) .'" id="next_page">[1]' . GetMessage ( 'nav_prev' ) . '</a>';
                } else {
                    if ( $arResult [ 'NavPageCount' ] == ( $arResult [ 'NavPageNomer' ] + '1' ) ) {
                        echo '<a href="' . $arResult [ 'sUrlPath' ] . $strNavQueryStringFull . '" id="next_page">[2]' . GetMessage ( 'nav_prev' ) . '</a>';
                    } else {
                        echo '<a href="' . $arResult [ 'sUrlPath' ] . '?' . 'PAGEN_' . $arResult [ 'NavNum' ] . '=' . ( $arResult [ 'NavPageNomer' ] + '1' ) . '" id="next_page">[3]' . GetMessage ( 'nav_prev' ) . '</a>';
                    }
                }
            } else {
                echo '[4]' . GetMessage ( 'nav_prev' ) . '';
            }
            if ( $arResult [ 'NavPageNomer' ] >= '2' ) {
                echo '<li class="right_arrow"><a href="' . $arResult [ 'sUrlPath' ] . '?' . $strNavQueryString . 'PAGEN_' . $arResult [ 'NavNum' ] . '=' . ( $arResult [ 'NavPageNomer' ] - '1' ) .'"  id="previous_page"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
            } else {
                echo '' . GetMessage ( 'nav_next' ) . ' 
             
            ';
            }

            while ( $arResult [ 'nStartPage' ] >= $arResult [ 'nEndPage' ] ) {
                $NavRecordGroupPrint = $arResult [ 'NavPageCount' ] - $arResult [ 'nStartPage' ] + '1';
                if ( $arResult [ 'nStartPage' ] == $arResult [ 'NavPageNomer' ] ) {
                    echo '<li class="bx_active"><a href="#">' . $NavRecordGroupPrint . '</a></li>';
                } elseif ( $arResult [ 'nStartPage' ] == $arResult [ 'NavPageCount' ] && ! $arResult [ 'bSavePage' ] ) {
                    echo '<a href="' . $arResult [ 'sUrlPath' ] . $strNavQueryStringFull . '">' . $NavRecordGroupPrint . '</a>';
                } else {
                    echo '<a href="' . $arResult [ 'sUrlPath' ] . '?' . $strNavQueryString . 'PAGEN_' . $arResult [ 'NavNum' ] . '=' . $arResult [ 'nStartPage' ] . '">' . $NavRecordGroupPrint . '</a>';
                }
                $arResult [ 'nStartPage' ] --;
            }
        } else {
            if ( $arResult [ 'NavPageNomer' ] > '1' ) {
                echo '';
                if ( $arResult [ 'bSavePage' ] ) {
                    echo '<a href="' . $arResult [ 'sUrlPath' ] . '?' . $strNavQueryString . 'PAGEN_' . $arResult [ 'NavNum' ] . '=' . ( $arResult [ 'NavPageNomer' ] - '1' ) .  '" id="next_page">[5]' . GetMessage ( 'nav_prev' ) . '</a>';
                } else {
                    if ( $arResult [ 'NavPageNomer' ] >= '2' ) {
                        echo '<li class="left_arrow"><a href="' . $arResult [ 'sUrlPath' ] . '?' . 'PAGEN_' . $arResult [ 'NavNum' ] . '=' . ( $arResult [ 'NavPageNomer' ] - '1' ) .'" id="next_page"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>';
                    } else {
                        echo "<li><a href='".$arResult['sUrlPath']."' class='page_arr_left'></a></li>";
                    }
                }
            } else {
                echo "";
            }

            if ( $arResult [ 'NavPageNomer' ] < $arResult [ 'NavPageCount' ] ) {
                echo '';
            } else {

            }
            // вывод страниц
            while ( $arResult [ 'nStartPage' ] <= $arResult [ 'nEndPage' ] ) {
                if ( $arResult [ 'nStartPage' ] == $arResult [ 'NavPageNomer' ] ) {
                    echo '<li class="bx_active"><a href="#">' . $arResult [ 'nStartPage' ] . '</a></li>';
                } elseif ( $arResult [ 'nStartPage' ] == '1' && ! $arResult [ 'bSavePage' ] ) {
                    echo '<li><a href="' . $arResult [ 'sUrlPath' ] . '?PAGEN_1=1">' . $arResult [ 'nStartPage' ] . '</a></li>';
                } else {
                    echo '<li><a href="' . $arResult [ 'sUrlPath' ] . '?' . 'PAGEN_' . $arResult [ 'NavNum' ] . '=' . $arResult [ 'nStartPage' ]. '">' . $arResult [ 'nStartPage' ] . '</a></li>';
                }
                $arResult [ 'nStartPage' ] ++;
            }
            if ( $arResult [ 'NavPageNomer' ] >= '2' ) {
                echo '';
                if ( $arResult [ 'bSavePage' ] ) {
                    echo '<a href="' . $arResult [ 'sUrlPath' ] . '?' . 'PAGEN_' . $arResult [ 'NavNum' ] . '=' . ( $arResult [ 'NavPageNomer' ] - '1' ) .'" id="next_page">[5]' . GetMessage ( 'nav_prev' ) . '</a>';
                } else {
                    if ( $arResult [ 'NavPageNomer' ] > '2' ) {
                        echo '';
                    } else {
                        echo "";
                    }
                }
            } else {
                echo "";
            }

            if ( $arResult [ 'NavPageNomer' ] < $arResult [ 'NavPageCount' ] ) {
                echo '<li class="right_arrow"><a href="' . $arResult [ 'sUrlPath' ] . '?' . 'PAGEN_' . $arResult [ 'NavNum' ] . '=' . ( $arResult [ 'NavPageNomer' ] + '1' ) .'" id="previous_page"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
            } else {

            }
        }
        ?></ul></div>