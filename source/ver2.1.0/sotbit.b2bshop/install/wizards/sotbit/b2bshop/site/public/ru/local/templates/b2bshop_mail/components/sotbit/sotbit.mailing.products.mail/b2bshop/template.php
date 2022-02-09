<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main\Localization\Loc;
$skuTemplate = array();
global $utm;
?>


<? if(!empty($arResult['ITEMS'])):?>
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:16px 24px 31px 24px;">
        <tr width="100%" cellpadding="0" cellspacing="0" border="0">
            <td width="100%">
            </td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:27px 24px 35px 24px;" bgcolor="#f7f8fa">
        <tr width="100%" cellpadding="0" cellspacing="0" border="0">
            <td width="100%">
                <?if($arParams['BLOCK_TITLE']):?>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:0px 0 21px 0;">
                        <tr>
                            <td>
                                <span style="font: 22px 'Proxima Nova', Arial, sans-serif;font-weight:bold;color: #070908;line-height:22px;display: block; -webkit-text-size-adjust:none;"><?=$arParams['BLOCK_TITLE']?></span>
                            </td>
                        </tr>
                    </table>
                <?endif;?>
                <?
                $all_count = count($arResult['ITEMS']);
                $count_now = 0;
                ?>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0; padding: 0;border: 1px solid #d3d3d3;border-bottom: none;" bgcolor="#ffffff">
                    <tbody>
                        <tr>
                            <td width="50%" align="left" style="padding-left: 14px;">
                                <span style="font: 13px 'Proxima Nova', Arial, sans-serif;color: #999999;padding: 12px 0;line-height:26px;display: block; -webkit-text-size-adjust:none;"><?=GetMessage('MAIL_NAME')?></span>
                            </td>
                            <td width="25%" align="center">
                                <span style="font: 13px 'Proxima Nova', Arial, sans-serif;color: #999999;padding: 12px 0;line-height:26px;display: block; -webkit-text-size-adjust:none;"><?=GetMessage('MAIL_ARTICLE')?></span>
                            </td>
                            <td width="25%" align="center">
                                <span style="font: 13px 'Proxima Nova', Arial, sans-serif;color: #999999;padding: 12px 0;line-height:26px;display: block; -webkit-text-size-adjust:none;"><?=GetMessage('MAIL_PRICE')?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?
                foreach($arResult['ITEMS'] as $item): ?>

                    <?  $count_now++;
                    if(($count_now%2) == 0 ) {
                        $table_bg_color = '#ffffff';
                    }
                    else {
                        $table_bg_color='';
                    }
                    ?>
                    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="<?=$table_bg_color?>" style="border-right: 1px solid #d3d3d3;border-left: 1px solid #d3d3d3;<?if($all_count==$count_now):?>border-bottom: 1px solid #d3d3d3;<?endif;?>padding: 0;">
                        <tbody>
                        <tr>
                            <td width="50%" align="left" style="padding-left:14px;">
                                <a href="<?=$item['DETAIL_PAGE_URL'].$utm?>" style="font: 13px 'Proxima Nova', Arial, sans-serif;color: #000000;text-decoration: none;line-height:24px;display: block; -webkit-text-size-adjust:none;">
                                    <font color="#000000" size="2" face="Proxima Nova, Arial, sans-serif"><?=$item['NAME']?></font><img alt="" src="/bitrix/templates/b2b_shop/img/zoom_mail.png" border="0" width="12" height="12" style="padding-left: 6px;">
                                </a>
                            </td>
                            <td width="25%" align="center">
                                <span style="font: 13px 'Proxima Nova', Arial, sans-serif;color: #000000;padding: 12px 0;text-decoration: none;line-height:24px;display: block; -webkit-text-size-adjust:none;"><?=$item["PROPERTIES"]['CML2_ARTICLE']["VALUE"]?></span>
                            </td>
                            <td width="25%" align="center">
                                <span style="font: 13px 'Proxima Nova', Arial, sans-serif;color: #000000;padding: 12px 0;text-decoration: none;line-height:24px;display: block; -webkit-text-size-adjust:none;"><?=$item['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></span>
                                <? if($item['MIN_PRICE']['VALUE'] != $item['MIN_PRICE']['DISCOUNT_VALUE']): ?>
                                    <span style="font: 13px 'Proxima Nova', Arial, sans-serif;color: #000000;padding: 12px 0;text-decoration: none;line-height:24px;display: block; -webkit-text-size-adjust:none;">
                                            <?=$item['MIN_PRICE']['PRINT_VALUE']?>
                                        </span>
                                <?endif; ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                <? endforeach;?>
            </td>
        </tr>
    </table>
<? endif ?>
