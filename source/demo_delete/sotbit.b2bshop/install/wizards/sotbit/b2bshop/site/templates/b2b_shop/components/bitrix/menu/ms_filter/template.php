<?
use Bitrix\Main\Config\Option;
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?

if (!empty($arResult)):?>
<?

$defOpenLi=Option::get("sotbit.b2bshop", "LEFT_MENU_CNT_VISIBLE_LI","0");

$defLiHight = $defOpenLi*29;
?>
<div id="block_left_menu" class="block_left_menu">
	<ul class="left_top_menu">
	<?

	$Level=array(1=>'',2=>'',3=>'');
	$LevelCnt=array();

	$previousLevel = 0;
	foreach($arResult as $key=>$arItem):

	$Level[$arItem["DEPTH_LEVEL"]]=$key;
	if($arItem["DEPTH_LEVEL"]==2 || $arItem["DEPTH_LEVEL"]==3)
	{
		if(!isset($LevelCnt[$Level[$arItem["DEPTH_LEVEL"]-1]]))
		{
			$LevelCnt[$Level[$arItem["DEPTH_LEVEL"]-1]]=1;
		}
		else
		{
			++$LevelCnt[$Level[$arItem["DEPTH_LEVEL"]-1]];
		}
	}


	?>
		<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
			<?=str_repeat("</ul></div></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
		<?endif?>

		<?if ($arItem["IS_PARENT"] && $arItem["DEPTH_LEVEL"]==1):?>
			<li class="menu_left_top_li_js dropdown <?if($arItem["DEPTH_LEVEL"]!=1 && $LevelCnt[$arItem['PARENT']] <= $defOpenLi):?>li-first-open<?endif; ?> <?if($arItem["SELECTED"] || $arItem["CHILD_SELECTED"]):?>li-active  li-open<?endif;?> <?=(isset($arItem['OPENS']) && $arItem['OPENS']==1)?'li-open':''?>">
				<span class="open_close_menu" onclick="open_close_menu(this, '.inner-menu');"></span>
				<a href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a>
				<div class="inner-menu <?if($arItem["COUNT_CHILDREN"] > $defOpenLi && $defOpenLi!=0):?>scrollbarY<?endif;?>"  style="<?=($arItem["SELECTED"] || $arItem["CHILD_SELECTED"] || (isset($arItem['OPENS']) && $arItem['OPENS']==1))?'display:block;':''?>" >
				<ul class="overview two_level_wrap" style="<?=($arItem["COUNT_CHILDREN"] > $defOpenLi && $defOpenLi!=0)?'height:'.$defLiHight.'px;':''?>">
		<?elseif($arItem["IS_PARENT"]):?>
			<li class="menu_left_top_li_js dropdown <?if($LevelCnt[$arItem['PARENT']] <= $defOpenLi && $defOpenLi!=0):?>li-first-open<?endif; ?> <?if($arItem["SELECTED"] || $arItem["CHILD_SELECTED"]):?>li-active  li-open<?endif;?> <?=(isset($arItem['OPENS']) && $arItem['OPENS']==1)?'li-open':''?>">
				<span class="open_close_menu" onclick="open_close_menu(this, '.inner-menu');"></span>
				<a href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a>
				<div class="inner-menu" <?if($arItem["SELECTED"] || $arItem["CHILD_SELECTED"] || (isset($arItem['OPENS']) && $arItem['OPENS']==1)):?>style="display:block"<?endif;?>>

						<ul class="two_level_wrap">
		<?elseif($arItem["DEPTH_LEVEL"]==1):?>
			<?if ($arItem["PERMISSION"] > "D"):?>
				<li class="menu_left_top_li_js  <?if($arItem["SELECTED"] || $arItem["CHILD_SELECTED"]):?>li-active<?endif;?>">
					<a href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a>
				</li>
			<?endif;?>
		<?else:?>
			<?if ($arItem["PERMISSION"] > "D"):?>
				<li class="<?if($LevelCnt[$arItem['PARENT']] <= $defOpenLi && $arItem["DEPTH_LEVEL"]!=3 && $defOpenLi!=0):?>li-first-open<?endif;?> <?if($arItem["SELECTED"] || $arItem["CHILD_SELECTED"]):?>li-active<?endif;?>">
					<a href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a>
				</li>
			<?endif;?>
		<?endif;?>

		<?$previousLevel = $arItem["DEPTH_LEVEL"];?>
	<?endforeach?>
	<?if ($previousLevel > 1)://close last item tags?>
		<?=str_repeat("</ul></div></li>", ($previousLevel-1) );?>
	<?endif?>
	</ul>
</div>

<?endif?>
<?return;?>
<?if (!empty($arResult)):?>

<div class="menu-sitemap-tree">
<ul>
<?
$previousLevel = 0;
foreach($arResult as $arItem):

?>
	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>
			<li<?if($arItem["CHILD_SELECTED"] !== true):?> class="close"<?endif?>>
				<div class="folder" onClick="OpenMenuNode(this)"></div>
				<div class="item-text"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></div>
				<ul>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>
				<li>
					<div class="page"></div>
					<div class="item-text"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></div>
				</li>
		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
</div>
<?endif?>
