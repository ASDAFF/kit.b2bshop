<?
use Bitrix\Main\Config\Option;

if (! defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true)
	die();

if( !\Bitrix\Main\Loader::includeModule( "kit.b2bshop" ))
{
	return false;
}
$frame = $this->createFrame()->begin();
if (!empty($arResult['ITEMS']))
{
	$rand = $arResult["RAND"];
	?>
	<div class="detail_bottom_wrap">
		<div class="container">
			<div class="row">
				<div class="col-sm-18 detail_left_wrap">
					<div class="row">
						<div class="col-sm-24 sm-padding-left-no">
							<div class="block_similar_goods">
								<?if($arParams["TITLE"]):?><h2 class="block_similar_title"><?=$arParams["TITLE"]?></h2><?endif;?>
								<div class="wrap_block_similar_in">
									<div class="js_slider_6 block_similar_in">
									<?
									$key=0;
									foreach($arResult["ITEMS"] as $key=>$arItem)
									{
									?>
										<div class='item'>
											<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>" class="dsqv quick_view<?=$rand?>" data-index="<?=$key?>" onclick="">
												<?if(isset($arResult["MORE_PHOTO_JS"][$arItem['ID']][$arItem['FIRST_COLOR']]["SMALL"][0]["src"]))
												{?>
													<img class="img-responsive" src="<?=$arResult["MORE_PHOTO_JS"][$arItem['ID']][$arItem['FIRST_COLOR']]["SMALL"][0]["src"]?>" title="<?=$arItem["NAME"]?>" alt="<?=$arItem["NAME"]?>" height="<?=$arResult["MORE_PHOTO_JS"][$arItem['ID']][$arItem['FIRST_COLOR']]["SMALL"][0]["height"]?>" width="<?=$arResult["MORE_PHOTO_JS"][$arItem['ID']][$arItem['FIRST_COLOR']]["SMALL"][0]["width"]?>">
												<?}
												else
												{?>
													<img class="img-responsive" src="/upload/no_photo_small.jpg" title="" alt="" height="171" width="131">
												<?}?>
											</a>
										</div>
										<?
										++$key;
									}?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?
				$APPLICATION->IncludeComponent("kit:product.banner", "ms_product", array(
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"BANNER_IBLOCK_ID" => Option::get("kit.b2bshop", "BANNER_IBLOCK_ID"),
					"ID" => $arParams["BANNER_ID"],
					"SECTION_ID" => $arParams["BANNER_SECTION_ID"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
				),
				false
				);
				?>
			</div>
		</div>
	</div>
	<?
	if(isset($arResult["FANCY"]) && !empty($arResult["FANCY"]))
	{
		foreach($arResult["FANCY"] as $arItem)
		{
			$quick_view_id[] = $arItem['ID'];
			$detail_page[] = $arItem["DETAIL_PAGE_URL"];
		}
		$APPLICATION->IncludeComponent(
		"kit:kit.quick.view_new",
		"",
		Array(
			"ELEMENT_ID" => $quick_view_id,
			"PARAB2BS_CATALOG" => $arParams["DETAIL_PARAMS"],
			"ELEMENT_TEMPLATE" => 'preview',
			"DETAIL_PAGE_URL" => $detail_page,
			"RAND" => $arResult["RAND"]
		),
		false
		);
	}
}
$frame->beginStub();
$frame->end();
?>