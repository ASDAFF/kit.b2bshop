<?
use Bitrix\Main\Config\Option;

if($arParams[2]=="top")
{
    $page = "TOP";
}
else
{
    $page="BOTTOM";
}
$arAvailableSortKit = array(
    "default"=>array(),
    "name_0" => Array("name", "desc"),
    "name_1" => Array("name", "asc"),
    "price_0" => Array('PROPERTY_MINIMUM_PRICE', "desc"),
    "price_1" => Array('PROPERTY_MINIMUM_PRICE', "asc"),
    "date_0" => Array('DATE_CREATE', "desc"),
    "date_1" => Array('DATE_CREATE', "asc"),
    
);

$sort_field = $arParams[1]["ELEMENT_SORT_FIELD"];
$sort_order = $arParams[1]["ELEMENT_SORT_ORDER"];
$currentKey = "";

foreach($arAvailableSortKit as $key=>$arSort)
{
    if($arSort[0]==$sort_field && $sort_order==$arSort[1]) $currentKey = $key;
}

$counts = array(12,24,36);

$accessSection = unserialize(Option::get('kit.b2bshop','SECTION_VIEW_ACCESS',''));
if(!is_array($accessSection))
{
    $accessSection = array();
}
$section = new \Kit\B2BShop\Client\Template\Section();





?>
<div class="col-sm-24 sm-padding-right-no sort-catalog b2b-sort-catalog">
	<form method="POST" action="">
		<input type="submit" name="sub" style="display:none" />
		<div class="block-pagination">
			<div class="b2b-catalog-panel">
				<div class="b2b-catalog-panel__view">
					<?php
					if(count($accessSection) > 1)
					{
						if(in_array('row',$accessSection))
						{
							?>
							<a href="<?=$section->getViewPath('row')?>" class="b2b-catalog-panel__view__1 b2b-catalog-panel__view__tumb <?=($arParams[3] == 'row')?'active':''?>" rel="nofollow"></a>
							<?php
						}
						if(in_array('block',$accessSection))
						{
							?>
							<a href="<?=$section->getViewPath('block')?>" class="b2b-catalog-panel__view__3 b2b-catalog-panel__view__tumb <?=($arParams[3] == 'block')?'active':''?>" rel="nofollow"></a>
							<?php
						}
					}
					?>
				</div>
				<div class="visible_item">
					<div class="wrap_text">
						<span class="visible_name_1"><?=GetMessage("B2BS_CATALOG_COUNT_ELEMENT1")?></span><span class="visible_name_2"> <?=GetMessage("B2BS_CATALOG_COUNT_ELEMENT2")?></span>:
					</div>
					<div class="wrap_select_number">
						<select name="count">
							<?foreach($counts as $count):?>
								<option <?if($arParams[1]["PAGE_ELEMENT_COUNT"]==$count) echo 'selected=""'?> value="<?=$count?>"><?=$count?></option>
							<?endforeach?>
						</select>
					</div>
				</div>
			</div>
			<div class="b2b-catalog-block-sort">
				<div class="block_sort">
					<span class="block_sort_name"><?=GetMessage('B2BS_CATALOG_SECT_SORT_LABEL')?></span>
					<div class="wrap_select_sort">
						<select name="sort">
							<?foreach($arAvailableSortKit as $key=>$v):?>
								<option <?if($currentKey==$key) echo 'selected=""'?> value="<?=$key?>"><?=GetMessage('SECT_SORT_'.$key)?></option>
							<?endforeach?>
						</select>
					</div>
				</div>
				<?
				if ($arParams[1]["DISPLAY_".$page."_PAGER"])
				{
				?>
					<div class="navigation">
						<?echo $arParams[0]["NAV_STRING"]; ?>
					</div>
				<?
				}?>
			</div>
		</div>
	</form>
</div>