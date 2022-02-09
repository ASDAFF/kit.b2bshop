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
<div class="col-sm-24 sort-catalog sm-padding-no">
	<form method="POST" action="">
		<input type="submit" name="sub" style="display:none" />
		<div class="block-pagination">
			<div class="row">
				<div class="col-sm-6 sm-padding-right-no">
					<div class="count_item">
					</div>
				</div>
				<div class="col-sm-10">
					<div class="block_sort">
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