<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if($arResult["PICTURE"])
{?>
	<div class="col-sm-6 sm-padding-right-no detail_right_wrap">
		<div class="detail_block_banner">
			<?if($arResult["PROPERTY_LINK_VALUE"])
			{?>
				<a href="<?=$arResult["PROPERTY_LINK_VALUE"]?>">
			<?}?>
			<img width="<?=$arResult["PICTURE"]["WIDTH"]?>" height="<?=$arResult["PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["PICTURE"]["ALT"]?>" title="<?=$arResult["PICTURE"]["TITLE"]?>" src="<?=$arResult["PICTURE"]["SRC"]?>" class="img-responsive">
			<?if($arResult["PROPERTY_LINK_VALUE"])
			{?>
				</a>
			<?}?>
		</div>
	</div>
<?}?>