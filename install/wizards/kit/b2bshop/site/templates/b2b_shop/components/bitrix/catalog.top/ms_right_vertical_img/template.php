<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule("kit.b2bshop")) return false;
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
if (!empty($arResult['ITEMS'])):
?>
<?
$rand = "";
if($arResult["IS_FANCY"])
{
	$rand = $arResult["RAND"];
}
?>
<div class="detail-right-block">
	<?if($arParams["TITLE"]):?>
	<h2 class="title"><?=$arParams["TITLE"]?></h2>
	<?endif;?>
	<ul class="block-picture">
	<?foreach($arResult['ITEMS'] as $key=>$arItem):?>
		<li>
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>" class="dsqv quick_view<?=$rand?>" data-index="<?=$key?>" <?if($arResult["IS_FANCY"]):?>onclick=""<?endif;?>>
				<?if(isset($arItem["PREVIEW_PICTURE_RESIZE"]["src"])):?>
				<img class="img-responsive" src="<?=$arItem["PREVIEW_PICTURE_RESIZE"]["src"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" height="<?=$arItem["PREVIEW_PICTURE_RESIZE"]["height"]?>" width="<?=$arItem["PREVIEW_PICTURE_RESIZE"]["width"]?>">
				<?else:?>
				<img class="img-responsive" src="/upload/no_photo_small.jpg" title="" alt="" height="171" width="131">
				<?endif;?>
				<span class="picture-descript">
					<span class="picture-descript-in">
						<span class="name"><?=$arItem["NAME"]?><br/><?/*=$arItem["PROPERTIES"]["CML2_MANUFACTURER"]["VALUE"]*/?></span>
						<?$frame = $this->createFrame()->begin();?>
						<span class="price"><?=$arItem["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"]?></span>
						<?$frame->end();?>
					</span>
				</span>
			</a>
		</li>
	<?endforeach?>
	</ul>
</div>
<?
endif;
?>