<?
if($arParams[2]=="top") $page = "TOP";
else $page="BOTTOM";
$arAvailableSortKit = array(
	"default"=>array(),
	"name_0" => Array("name", "desc"),
	"name_1" => Array("name", "asc"),
	"price_0" => Array('PROPERTY_MINIMUM_PRICE', "desc"),
	"price_1" => Array('PROPERTY_MINIMUM_PRICE', "asc"),
	"date_0" => Array('DATE_CREATE', "desc"),
	"date_1" => Array('DATE_CREATE', "asc"),
	"articul_0" => Array('ARTICUL', "desc"),
	"articul_1" => Array('ARTICUL', "asc"),

);

$sort_field = $arParams[1]["ELEMENT_SORT_FIELD"];
$sort_order = $arParams[1]["ELEMENT_SORT_ORDER"];
$currentKey = "";

if($sort_field)
{
	if($sort_field == 'PROPERTY_'.$arParams[1]['OPT_ARTICUL_PROPERTY'])
	{
		$sort_field = 'ARTICUL';
	}
}


foreach($arAvailableSortKit as $key=>$arSort)
{
	if($arSort[0]==$sort_field && $sort_order==$arSort[1]) $currentKey = $key;
}
?>
<div class="col-sm-24 sort-catalog">
	<form method="POST" action="">
		<input type="submit" name="sub" style="display:none" />
		<div class="block-pagination">
			<div class="row">
				<div class="col-sm-6 sm-padding-right-no">
					<div class="count_item">
						<span class="count_name_1"><?=GetMessage("B2BS_CATALOG_ALL_PRODUCTS1")?></span><span class="count_name_2"> <?=GetMessage("B2BS_CATALOG_ALL_PRODUCTS2")?></span>:
						<span class="number"><?=$arParams[0]["NAV_RESULT"]->NavRecordCount?></span>
					</div>
				</div>
				<div class="col-sm-10">
					<div class="block_sort">
						<span class="block_sort_name"><?=GetMessage('B2BS_CATALOG_SECT_SORT_LABEL')?></span>
						<div class="wrap_select_sort">
						<??><select name="sort">
							<?foreach($arAvailableSortKit as $key=>$v):?>
								<option <?if($key==$currentKey) echo 'selected=""'?> value="<?=$key?>"><?=GetMessage('SECT_SORT_'.$key)?></option>
							<?endforeach?>
						</select>
						</div>
					</div>
				</div>
				<div class="col-sm-8 sm-padding-left-no">
					<div class="blank_nav_tring">
						<?
						if ($arParams[1]["DISPLAY_".$page."_PAGER"])
						{
						?>

								<?echo $arParams[0]["NAV_STRING"]; ?>

						<?
						}?>
					</div>
				</div>

			</div>
		</div>
	</form>
</div>