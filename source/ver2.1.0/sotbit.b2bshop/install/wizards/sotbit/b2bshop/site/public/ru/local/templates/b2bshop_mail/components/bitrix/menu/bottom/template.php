<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $utm;

if (!empty($arResult))
{
	global $serverName;

	$flag=true;
	$CntCol=0;
	foreach($arResult as $i=>$arItem)
	{
		if($arItem['DEPTH_LEVEL']==1)
		{
			if ($CntCol>2)
				break;
			if($i!=0)
			{
				?>
                            </td>
                        </tr>
                    </table>
				</td>
				<?
			}
			if($flag)
			{
				?>
				<td width="36%" style="" valign="top">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="100%">
				<?
				$flag=false;
			}
			else 
			{
				?>
				<td width="36%" style="" valign="top">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="100%">
				
				<?
				$flag=true;
			}
			?>
            <!--[if gte mso 9]>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0">
                <tr>
                    <td width="100%">
                        <![endif]-->
                        <span style="font: 15px 'Times New Roman', Arial, sans-serif;color: #000000;text-transform:uppercase;line-height:49px;display: block; -webkit-text-size-adjust:none;"><font color="#000000" size="3" face="Times New Roman, Arial, sans-serif"><?=$arItem['TEXT'] ?></font></span>
                        <!--[if gte mso 9]>
                    </td>
                </tr>
            </table>
            <![endif]-->
			<?
			++$CntCol;
		}
		if($arItem['DEPTH_LEVEL']==2)
		{
			?>
			<!--[if gte mso 9]>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0">
                <tr >
                    <td width="100%">
                        <![endif]-->
                        <a href="<?=$serverName.$arItem["LINK"].$utm?>" style="font: 13px 'Proxima Nova', Arial, sans-serif;color: #6d717c;text-decoration: none;line-height:24px;display: block; -webkit-text-size-adjust:none;" target="_blank"><font color="#6d717c" size="2" face="Proxima Nova, Arial, sans-serif"><?=$arItem['TEXT'] ?></font></a>
                        <!--[if gte mso 9]>
                    </td>
                </tr>
            </table>
            <![endif]-->
			<?
            if($arItem == end($arResult)) {
                ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <?
            }
		}
	}
}?>