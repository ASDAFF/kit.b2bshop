<?
if($arParams[2]=="top") $page = "TOP";
else $page="BOTTOM";
$arAvailableSortSotbit = array(
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

foreach($arAvailableSortSotbit as $key=>$arSort)
{
	if($arSort[0]==$sort_field && $sort_order==$arSort[1]) $currentKey = $key;
}
?>
<div class="col-sm-24 sm-padding-right-no sort-catalog">
	<form method="POST" action="">
		<input type="submit" name="sub" style="display:none" />
		<div class="block-pagination">
			<div class="row">
				<div class="col-sm-4 sm-padding-right-no">
					<div class="count_item">
						<span class="count_name_1"><?=GetMessage("B2BS_CATALOG_ALL_PRODUCTS1")?></span><span class="count_name_2"> <?=GetMessage("B2BS_CATALOG_ALL_PRODUCTS2")?></span>:
						<span class="number"><?=$arParams[0]["NAV_RESULT"]->NavRecordCount?></span>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="visible_item">
						<div class="wrap_text">
							<span class="visible_name_1"><?=GetMessage("B2BS_CATALOG_COUNT_ELEMENT1")?></span><span class="visible_name_2"> <?=GetMessage("B2BS_CATALOG_COUNT_ELEMENT2")?></span>:
						</div>
						<div class="wrap_select_number">
						<?
						$arCount['reference'] = array(12, 24, 36);
						$arCount['reference_id'] = array(12, 24, 36);
						?>
						<?=SelectBoxFromArray('count', $arCount, $arParams[1]["PAGE_ELEMENT_COUNT"], "", "");?>
						</div>
					</div>
				</div>
				<div class="col-sm-7 col-sm-push-7 sm-padding-left-no">
					<div class="block_sort">
						<span class="block_sort_name"><?=GetMessage('B2BS_CATALOG_SECT_SORT_LABEL')?></span>
						<div class="wrap_select_sort">
						<??><select name="sort">
							<?foreach($arAvailableSortSotbit as $key=>$v):?>
								<option <?if($key==$currentKey) echo 'selected=""'?> value="<?=$key?>"><?=GetMessage('SECT_SORT_'.$key)?></option>
							<?endforeach?>
						</select><??>
						</div>
					</div>
				</div>
				<?
				if ($arParams[1]["DISPLAY_".$page."_PAGER"])
				{
				?>
					<div class="col-sm-7 col-sm-pull-7 sm-padding-left-no">
						<?echo $arParams[0]["NAV_STRING"]; ?>
					</div>
				<?
				}?>
			</div>
		</div>
	</form>
</div>