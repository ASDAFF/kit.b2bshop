<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);?>

<?$CntVisibleInInnerMenu=5; ?>

<?if (!empty($arResult)):?>
<div id="open-mobile-menu" class="open-mobile-menu visible-xs">
    <a id="open-menu" href="#menu_mobile">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="navbar-menu-name"><?=GetMessage("MS_MENU_TOP_MOBILE_OPEN")?></span>
    </a>
</div>

<!--This content for menu mobile-->
<div id="menu_mobile" class="menu_mobile"></div>
<!--End content for menu mobile-->
<div id="main-top-menu" class="main-top-menu hidden-xs">
    <div id="wrap-main-top-menu" class="wrap-main-top-menu">
        <ul class="main-menu-lv-1">
        <?
        $cnt = 0;
        $index=0;
        foreach($arResult as $arItem):
        if($cnt==0)
        {
        	if(($arItem['MENU_SHOW']!='-1' && $arItem['MENU_SHOW']<$arItem['CATALOG_MENU_CNT']) || $arItem['MENU_SHOW']==0)
        	{
        	?>
        	<li class="first-top-menu">
        	<a data-index="<?=$index?>">
        		<span class="first-top-menu-icon">
        			<span class="first-top-menu-icon-line"></span>
					<span class="first-top-menu-icon-line"></span>
					<span class="first-top-menu-icon-line"></span>
        		</span>
        		</a>
        	</li>
        <?
        ++$index;
        	}
        }
		else
		{
			if(($cnt>$arResult[0]['MENU_SHOW'] && $arItem['PARAMS']['FROM_IBLOCK']) && $arResult[0]['MENU_SHOW']!=0 && $arResult[0]['MENU_SHOW']!=-1)
				continue;
        ?>
          <li class="<?if($arItem["SELECTED"]):?>li-active<?endif;?><?if($index == "0"):?> li-first<?endif;?>">
             <?if($arItem["LINK"]):?>
                <a href="<?=$arItem["LINK"]?>" data-index="<?=$index?>"><span><?=$arItem["TEXT"]?></span></a>
             <?else:?>
                <span><?=$arItem["TEXT"]?></span>
             <?endif;?>
          </li>
          <?
          ++$index;
		}
		$cnt++;?>
        <?endforeach?>
        </ul>
    </div> <?/*end #wrap-main-top-menu*/?>

    <div id="wrap-top-inner-menu" class="wrap-top-inner-menu hidden-xs">
        <div id="slide-inner-menu" class="wrap-item">
            <?
            $cnt = 0;
            $j=0;
            $n=0;
            $m=0;
            $NeedClose=false;

            foreach($arResult as $arItem):
            	    if(($j==0 && $arResult[0]['MENU_SHOW']!=-1 && ($arResult[0]['MENU_SHOW']<$arResult[0]['CATALOG_MENU_CNT'] || $arResult[0]['MENU_SHOW']==0)) ||
						($j>0 && ($j<=$arResult[0]['MENU_SHOW'] || $arResult[0]['MENU_SHOW']==-1 || $arResult[0]['MENU_SHOW']==0 || $arItem['PARAMS']['FROM_IBLOCK']!=1)))
	            {


            ?>
                <div class="item <?=($j==0)?'first-item':''?>">
                    <div class="row">
                    <?if($j==0): ?>
                   <div class="col-sm-24 wrapper-first-top-menu-content">
						<div class="first-top-menu-content">
                    <?foreach($arResult as $FirstLevelItem)
                    {
                    	if($m<$arResult[0]['MENU_SHOW']+1 && $arItem['MENU_SHOW']!=0)
                    	{
                    		++$m;
                    		continue;
                    	}


                    	if(!is_array($FirstLevelItem) || count($FirstLevelItem)<1 || !$FirstLevelItem['PARAMS']['FROM_IBLOCK'])
                    	{
                    		continue;
                    	}

						if($n%5==0 )
						{
							$NeedClose=true;
							?>
								<div class="first-top-menu-content-menu-row">
							<?
						}
						?>
						<div class="first-top-menu-content-menu">
						<div class="first-top-menu-content-menu-title-wrapper">
							<a class="<?if($FirstLevelItem["SELECTED"]):?>active<?endif;?> first-top-menu-content-menu-title" href="<?=$FirstLevelItem['LINK'] ?>"><?=$FirstLevelItem['TEXT'] ?></a>
						</div>
						<div class="first-top-menu-content-menu-childmenu">
						<?
							if(isset($FirstLevelItem['INNER_MENU']) && is_array($FirstLevelItem['INNER_MENU']) && count($FirstLevelItem['INNER_MENU']))
							{
								?>

								<?
								$CntInInnerMenu=0;
								$NeedHide=false;
								foreach($FirstLevelItem['INNER_MENU'] as $SecondLevelItem)
								{
									if($CntVisibleInInnerMenu<=$CntInInnerMenu && !$NeedHide)
									{
										$NeedHide=true;
										?>
										<div class="childmenu-hide">
										<?
									}
									?>
									<div class="childmenu-item <?=(isset($SecondLevelItem['INNER_MENU']) && count($SecondLevelItem['INNER_MENU'])>0)?'dropdown':'' ?> <?=($arResult[0]['SHOW_THIRD']!='Y')?'li-open':'' ?>">
									<?if(isset($SecondLevelItem['INNER_MENU']) && count($SecondLevelItem['INNER_MENU'])>0)
									{
										?>
										<span class="open_close_top_menu" onclick="open_close_menu(this, '.first-top-menu-content-menu-childmenu-third');"></span>
										<?
									}?>
										<a <?if($SecondLevelItem["SELECTED"]):?>class="active"<?endif;?> href="<?=$SecondLevelItem['LINK'] ?>"><?=$SecondLevelItem['TEXT'] ?></a>
										<?
										if(isset($SecondLevelItem['INNER_MENU']) && count($SecondLevelItem['INNER_MENU'])>0)
										{
										?>
										<div class="first-top-menu-content-menu-childmenu-third" <?=($arResult[0]['SHOW_THIRD']=='Y')?'style="display:block;"':'' ?>>
										<?
											foreach($SecondLevelItem['INNER_MENU'] as $ThirdLevelItem)
											{
											?>
												<a <?if($ThirdLevelItem["SELECTED"]):?>class="active"<?endif;?> href="<?=$ThirdLevelItem['LINK'] ?>"><?=$ThirdLevelItem['TEXT'] ?></a>
											<?
											}
											?>
										</div>

										<?
									}
									?></div><?
									++$CntInInnerMenu;
								}
								if($NeedHide)
								{
									?></div>
									<div class="hide-bottoms" onmouseenter="open_hide_items(this, '.first-top-menu-content-menu');">
										<div class="hide-bottoms-inner">
											<span class="hide-bottom"></span>
											<span class="hide-bottom"></span>
											<span class="hide-bottom"></span>
										</div>
									</div>

									<?
								}

							}
							?></div><?
?>
</div>
<?
							if($n%5==4)
							{
								$NeedClose=false;
							?>
									</div>
							<?
							}
							++$n;
                    	}
if($NeedClose)
{?></div><?
}
					?>
							</div>
						</div>


                    <?else: ?>
                        <div class="col-sm-13">
                            <?if($arItem["BANNER"]["ADD_LEFT_TEXT"] == "Y"):?>
                                <?if($arItem["BANNER"]["LINK"] && !$arItem["BANNER"]["CATALOG_ELEMENT"]["0"]):?>
                                    <a class="wrap-banner" href="<?=$arItem["BANNER"]["LINK"]?>">
                                <?endif;?>
                                <div class="row">
                                    <div class="col-md-8 hidden-sm">
                                        <span class="wrap-title-banner">
                                                <?if($arItem["BANNER"]["LEFT_TITLE"] && $arItem["BANNER"]["LEFT_TEXT"]):?>
                                                    <p class="banner-title"><?=$arItem["BANNER"]["LEFT_TITLE"]?></p>
                                                    <p class="banner-title-del"></p>
                                                    <p class="banner-title-2"><?=$arItem["BANNER"]["LEFT_TEXT"]?></p>
                                                <?elseif($arItem["BANNER"]["LEFT_TITLE"] || $arItem["BANNER"]["LEFT_TEXT"]):?>
                                                    <p class="banner-title"><?=$arItem["BANNER"]["LEFT_TITLE"]?></p>
                                                    <p class="banner-title-2"><?=$arItem["BANNER"]["LEFT_TEXT"]?></p>
                                                <?endif?>
                                        </span>
                                    </div>

                                    <?if($arItem["BANNER"]["CATALOG_ELEMENT"]["0"]):?>
                                        <div class="col-sm-24 col-md-16">
                                            <div class="row">
                                                <?$cnt = 0?>
                                                <?foreach($arItem["BANNER"]["CATALOG_ELEMENT"] as $CatalogItem):?>
                                                   <?$cnt++;
                                                   if($cnt > 2) break;?>
                                                   <div class="col-sm-12 sm-padding-right-no">
                                                        <a class="wrap-element" href="<?=$CatalogItem["DETAIL_PAGE_URL"]?>">
                                                            <?if(is_array($CatalogItem["PICTURE"])):?>
                                                                <span class="wrap-img">
                                                                    <img class="img-responsive" src="<?=(isset($CatalogItem["PICTURE"]["RESIZE"]["SRC"]))?$CatalogItem["PICTURE"]["RESIZE"]["SRC"]:$CatalogItem["PICTURE"]["SRC"]?>" width="<?=(isset($CatalogItem["PICTURE"]["RESIZE"]["WIDTH"]))?$CatalogItem["PICTURE"]["RESIZE"]["WIDTH"]:$CatalogItem["PICTURE"]["WIDTH"]?>" height="<?=(isset($CatalogItem["PICTURE"]["RESIZE"]["HEIGHT"]))?$CatalogItem["PICTURE"]["RESIZE"]["HEIGHT"]:$CatalogItem["PICTURE"]["HEIGHT"]?>" title="<?=$CatalogItem["PICTURE"]["TITLE"]?>" alt="<?=$CatalogItem["PICTURE"]["ALT"]?>"/>
                                                                    <span class="img_hover"></span>
                                                                </span>
                                                            <?endif;?>
                                                            <span class="wrap-name">
                                                                <?if($CatalogItem["BRAND"]):?>
                                                                    <span class="item-name"><?=$CatalogItem["BRAND"]?></span>
                                                                <?endif;?>
                                                                <span class="item-second-name"><?=$CatalogItem["NAME"]?></span>
                                                            </span>
                                                            <span class="wrap-price">
                                                              <?if($CatalogItem["MIN_PRICE"]["DISCOUNT_VALUE"] && ($CatalogItem["MIN_PRICE"]["VALUE"] > $CatalogItem["MIN_PRICE"]["DISCOUNT_VALUE"])):?>
                                                                <p class="item_price"><?=$CatalogItem["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"]?></p>
                                                                <p class="item_price_big"><?=$CatalogItem["MIN_PRICE"]["PRINT_VALUE"]?></p>
                                                              <?elseif($CatalogItem["MIN_PRICE"]["VALUE"]):?>
                                                                <p class="item_price"><?=$CatalogItem["MIN_PRICE"]["PRINT_VALUE"]?></p>
                                                              <?endif;?>
                                                            </span>
                                                        </a>
                                                   </div>

                                                <?endforeach;?>
                                            </div>
                                        </div>
                                    <?else:?>
                                        <div class="col-sm-24 col-md-16">
                                            <span class="wrap-img">
                                                    <img
                                                        class="img-responsive"
                                                        src="<?=$arItem["BANNER"]["PREVIEW_PICTURE"]["RESIZE"]["SRC"]?>"
                                                        width="<?=$arItem["BANNER"]["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"]?>"
                                                        height="<?=$arItem["BANNER"]["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"]?>"
                                                        title="<?=$arItem["BANNER"]["PREVIEW_PICTURE"]["TITLE"]?>"
                                                        alt="<?=$arItem["BANNER"]["PREVIEW_PICTURE"]["ALT"]?>"
                                                        />
                                                    <?if($arItem["BANNER"]["PROPERTY_BANNER_TITLE_VALUE"] || $arItem["BANNER"]["PROPERTY_BANNER_TEXT_VALUE"]):?>
                                                    <span class="wrap-img-text">
                                                        <?if($arItem["BANNER"]["PROPERTY_BANNER_TITLE_VALUE"]):?>
                                                            <span class="text-1"><?=$arItem["BANNER"]["PROPERTY_BANNER_TITLE_VALUE"]?></span>
                                                        <?endif;?>
                                                        <?if($arItem["BANNER"]["PROPERTY_BANNER_TEXT_VALUE"]):?>
                                                            <span class="text-2"><?=$arItem["BANNER"]["PROPERTY_BANNER_TEXT_VALUE"]?></span>
                                                        <?endif;?>
                                                    </span>
                                                    <?endif;?>
                                                    <span class="img_hover"></span>
                                            </span>
                                        </div>
                                    <?endif?>
                                </div>
                                <?if($arItem["BANNER"]["LINK"] && !$arItem["BANNER"]["ELEMENT_CATALOG"]["0"]):?>
                                    </a>
                                <?endif;?>
                            <?else:?>
                                <?if($arItem["BANNER"]["LINK"]):?>
                                    <a class="wrap-banner" href="<?=$arItem["BANNER"]["LINK"]?>">
                                <?else:?>
                                    <span class="wrap-banner">
                                <?endif;?>

                                    <img
                                        class="img-responsive"
                                        src="<?=$arItem["BANNER"]["PREVIEW_PICTURE"]["RESIZE"]["SRC"]?>"
                                        width="<?=$arItem["BANNER"]["PREVIEW_PICTURE"]["RESIZE"]["WIDTH"]?>"
                                        height="<?=$arItem["BANNER"]["PREVIEW_PICTURE"]["RESIZE"]["HEIGHT"]?>"
                                        title="<?=$arItem["BANNER"]["PREVIEW_PICTURE"]["TITLE"]?>"
                                        alt="<?=$arItem["BANNER"]["PREVIEW_PICTURE"]["ALT"]?>"
                                    />
                                    <?if($arItem["BANNER"]["PROPERTY_BANNER_TITLE_VALUE"] || $arItem["BANNER"]["PROPERTY_BANNER_TEXT_VALUE"]):?>
                                    <span class="wrap-img-text">
                                        <?if($arItem["BANNER"]["PROPERTY_BANNER_TITLE_VALUE"]):?>
                                            <span class="text-1"><?=$arItem["BANNER"]["PROPERTY_BANNER_TITLE_VALUE"]?></span>
                                        <?endif;?>
                                        <?if($arItem["BANNER"]["PROPERTY_BANNER_TEXT_VALUE"]):?>
                                            <span class="text-2"><?=$arItem["BANNER"]["PROPERTY_BANNER_TEXT_VALUE"]?></span>
                                        <?endif;?>
                                    </span>
                                    <?endif;?>
                                    <span class="img_hover"></span>
                                <?if($arItem["BANNER"]["LINK"]):?>
                                    </a>
                                <?else:?>
                                    </span>
                                <?endif;?>
                            <?endif?>
                        </div>
                        <div class="col-sm-10 col-sm-offset-1 sm-padding-left-no">
                            <div class="row">
                                <div class="col-sm-24 col-lg-20">
                                    <div class="wrap-title">
                                        <p class="menu-inner-title">
                                             <?if($arItem["LINK"]):?>
                                                <a href="<?=$arItem["LINK"]?>" rel="nofollow">
                                                    <?=$arItem["TEXT"]?>
                                                </a>
                                             <?else:?>
                                                <?=$arItem["TEXT"]?>
                                             <?endif;?>
                                        </p>
                                        <?if($arItem["SECOND_TITLE"]):?>
                                            <p class="menu-inner-title-2"><?=$arItem["SECOND_TITLE"]?></p>
                                        <?elseif($arItem["PARAMS"]["SECOND_TITLE"]):?>
                                            <p class="menu-inner-title-2"><?=$arItem["PARAMS"]["SECOND_TITLE"]?></p>
                                            <?if($arItem['PARAMS']["DISPLAY_LINE"] == "Y"):?>
                                                <p class="menu-inner-title-del"></p>
                                            <?endif;?>
                                        <?endif;?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                              <?if($arItem['LINK'] == "/brands/"):
                                              $nBrand = COption::GetOptionString("kit.b2bshop", "COUNT_BRAND_MENU", "10");
                                              ?>

                                                <?$one_part = ceil(count($arItem["INNER_MENU"])/2);
                                                if($nBrand<$one_part)
                                                    $one_part = $nBrand;

                                                ?>
                                                    <?if(is_array($arItem["INNER_MENU"])||true):?>
                                                        <div class="col-sm-12">
                                                            <ul class="menu-lv-2-1">
                                                            <?$cnt=0;
                                                            ?>
                                                            <?foreach($arItem["INNER_MENU"] as $arItemSecond):?>
                                                                <?if($cnt>=$one_part*2)
                                                                    break 1;?>
                                                                <?if($cnt == $one_part):?>
                                                                   </ul>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                      <ul class="menu-lv-2-2">
                                                                <?
                                                                endif;?>
                                                                <?if($arItemSecond["LINK"]):?>
                                                                    <li><a href="<?=$arItemSecond["LINK"]?>"><?=$arItemSecond["TEXT"]?></a></li>
                                                                <?else:?>
                                                                    <li><?=$arItemSecond["TEXT"]?></li>
                                                                <?endif;?>
                                                                <?$cnt++;?>
                                                            <?endforeach;?>
                                                        </ul>
                                                        </div>
                                                    <?endif;?>
                                              <?else:?>
                                              <?if($arItem["INNER_MENU"]):?>
                                                  <div class="col-sm-12">
                                                  <?if(is_array($arItem["INNER_MENU"])):?>
                                                    <ul class="menu-lv-2-1">
                                                        <?foreach($arItem["INNER_MENU"] as $arItemSecond):?>
                                                            <?if($arItemSecond["LINK"]):?>
                                                                <li class="<?if($arItemSecond["SELECTED"]):?>li-active <?endif;?><?=(isset($arItemSecond['INNER_MENU']) && count($arItemSecond['INNER_MENU'])>0)?'dropdown':'' ?> <?=($arResult[0]['SHOW_THIRD']!='Y')?'li-open':'' ?>" >

                                                                <?if(isset($arItemSecond['INNER_MENU']) && count($arItemSecond['INNER_MENU'])>0)
																	{
																		?>
																		<span class="open_close_top_menu" onclick="open_close_menu(this, '.top-menu-content-menu-childmenu-third');"></span>
																		<?
																	}
																	?>
                                                                <a href="<?=$arItemSecond["LINK"]?>"><?=$arItemSecond["TEXT"]?></a>
                                                                	<?
																	if(isset($arItemSecond['INNER_MENU']) && count($arItemSecond['INNER_MENU'])>0)
																	{
																	?>
																	<ul class="top-menu-content-menu-childmenu-third" <?=($arResult[0]['SHOW_THIRD']=='Y')?'style="display:block;"':'' ?>>
																	<?
																		foreach($arItemSecond['INNER_MENU'] as $ThirdLevelItem)
																		{
																		?>
																			<li><a <?if($ThirdLevelItem["SELECTED"]):?>class="active"<?endif;?> href="<?=$ThirdLevelItem['LINK'] ?>"><?=$ThirdLevelItem['TEXT'] ?></a></li>
																		<?
																		}
																		?>
																	</ul>

																	<?

																}
?>
                                                                </li>
                                                            <?else:?>
                                                                <li><?=$arItemSecond["TEXT"]?></li>
                                                            <?endif;?>
                                                        <?endforeach;?>
                                                    </ul>
                                                  <?endif;?>
                                                </div>
                                                <? endif; ?>
                                                <?
                                                        $countToWidth = 0;
                                                        if(empty($arItem["INNER_MENU"]) && empty($arItem["BRANDS"])):
                                                        	$countToWidth = 24;
                                                        else:
                                                        	$countToWidth = 12;
                                                        endif;
                                                        ?>
                                                		<?if($arItem["BANNER"]["DOP_SECTION"]):?>
                                                		    <div class="col-sm-<?=$countToWidth;?> <?if($countToWidth==13): echo('col-sm-offset-1'); endif;?>">
																<h2 class="title-dop-section"><? echo($arItem["BANNER"]["DOP_SECTION_TITLE"]); ?></h2>
                                                		        <? echo($arItem["BANNER"]["DOP_SECTION"]); ?>
                                                		 	</div>
                                                		<?endif;?>
                                                
                                                <?if($arItem["BRANDS"]):?>
                                                <div class="col-sm-12">
                                                    <?if(is_array($arItem["BRANDS"])):?>
                                                        <ul class="menu-lv-2-2">
                                                        <?foreach($arItem["BRANDS"] as $arItemBrand):?>
                                                            <?if($arItemBrand["DETAIL_PAGE_URL"]):?>
                                                                <li><a href="<?=$arItemBrand["DETAIL_PAGE_URL"]?>"><?=$arItemBrand["NAME"]?></a></li>
                                                            <?else:?>
                                                                <li><?=$arItemBrand["NAME"]?></li>
                                                            <?endif;?>
                                                        <?endforeach;?>
                                                        </ul>
                                                    <?endif;?>
                                                </div>
                                                <?endif;?>
                                            <?endif?>

                                <?if($arItem["URL_TEXT_INNER"]):?>
                                    <div class="col-sm-24 col-lg-22">
                                        <div class="menu-inner-wrap-text">
                                            <?$APPLICATION->IncludeFile($arItem["URL_TEXT_INNER"],
                                                Array(),
                                                Array("MODE"=>"html", "NAME" => $arItem["TEXT"], "TEMPLATE" => SITE_TEMPLATE_PATH."/menuText.php")
                                            );?>
                                        </div>
                                    </div>
                                <?endif;?>
                            </div>
                        </div>
                        <?endif; ?>
                    </div>
                </div> <?//item?>
            <?}$cnt++;?>
            <?++$j; ?>
            <?endforeach?>
        </div> <?/*end wrap_item*/?>
    </div>  <?/*end wrap_item*/?>

</div>  <?/*end #main-top-menu*/?>
<?endif;?>