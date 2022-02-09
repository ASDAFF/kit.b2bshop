<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($arResult['SECTIONS'] && is_array($arResult['SECTIONS']) &&sizeof($arResult['SECTIONS']) > 0)
{
	?>
	<div class="row">
		<div class="col-sm-24"> 
	        <div class="main_inner_title">
	            <h1 class="text"><?=$arResult['NAME'] ?></h1>
	        </div>
	    </div>
    </div>
	<div id="bricks">
	<div class="grid-sizer"></div>
	<?
	$i = 1;
	foreach($arResult['SECTIONS'] as $Section)
	{
		?>
			<a href="<?=$Section['SECTION_PAGE_URL'] ?>" onclick="">
				<div class="grid-item grid-item-<?=$i ?> grid-item--width<?=$Section['BRICK_IMAGE']['WIDTH_CLASS']?> grid-item--height<?=$Section['BRICK_IMAGE']['HEIGHT_CLASS']?>">
					<div class="brick-image" style="background-image:url('<?=$Section['BRICK_IMAGE']['SRC'] ?>')">
						
					</div>
				</div>
			</a>
		<?
		++$i;
	}?>
	</div>
	<?
}
