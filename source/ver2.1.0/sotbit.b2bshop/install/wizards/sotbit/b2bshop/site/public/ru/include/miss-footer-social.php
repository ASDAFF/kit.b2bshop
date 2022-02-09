<ul>
    <?$vk = COption::GetOptionString("sotbit.b2bshop", "LINK_VK", "");
    if($vk!=""):
    ?>
    <li><a class="social_vk" href="<?=$vk?>"></a></li>
    <?endif;?>
    <?$fb = COption::GetOptionString("sotbit.b2bshop", "LINK_FB", "");
    if($fb!=""):
    ?>
    <li><a class="social_fb" href="<?=$fb?>"></a></li>
    <?endif;?>
    <?$tw = COption::GetOptionString("sotbit.b2bshop", "LINK_TW", "");
    if($tw!=""):
    ?>
    <li><a class="social_twitt" href="<?=$tw?>"></a></li>
    <?endif;?>
    <?$gl = COption::GetOptionString("sotbit.b2bshop", "LINK_GL", "");
    if($gl!=""):
    ?>
    <li><a class="social_gog" href="<?=$gl?>"></a></li>
    <?endif;?>
    <?$in = COption::GetOptionString("sotbit.b2bshop", "LINK_INSTAGRAM", "");
    if($in!=""):
    ?>
    <li><a class="social_inst" href="<?=$in?>"></a></li>
    <?endif;?>
    <?$ok = COption::GetOptionString("sotbit.b2bshop", "LINK_OK", "");
    if($ok!=""):
    ?>
    <li><a class="social_ok" href="<?=$ok?>"></a></li>
    <?endif;?>

</ul>