<?use Bitrix\Main\Localization\Loc;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

Loc::loadMessages(__FILE__);
$frame = $this->createFrame()->begin( "" );
$injectId = $arParams['UNIQ_COMPONENT_ID'];
$injectId.='element';
if( isset( $arResult['REQUEST_ITEMS'] ) )
{
	// code to receive recommendations from the cloud
	CJSCore::Init( array(
			'ajax'
	) );
	
	// component parameters
	$signer = new \Bitrix\Main\Security\Sign\Signer();
	$signedParameters = $signer->sign( base64_encode( serialize( $arResult['_ORIGINAL_PARAMS'] ) ), 'bx.bd.products.recommendation' );
	$signedTemplate = $signer->sign( $arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation' );
	
	?>

<span id="<?=$injectId?>"></span>

<script type="text/javascript">
		BX.ready(function(){
			bx_rcm_get_from_cloud(
				'<?=CUtil::JSEscape($injectId)?>',
				<?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
				{
					'parameters':'<?=CUtil::JSEscape($signedParameters)?>',
					'template': '<?=CUtil::JSEscape($signedTemplate)?>',
					'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
					'rcm': 'yes'
				}
			);
		});
	</script>
<?
	$frame->end();
	return;
	
	// \ end of the code to receive recommendations from the cloud
}

if (!empty($arResult['ITEMS']))
{
	$rand = "";
	if($arResult["IS_FANCY"])
	{
		$rand = $arResult["RAND"];
	}
	
	?>
	<div class="detail-right-block">
		<h2 class="title"><?=Loc::getMessage('MS_PV_BIG_DATA_SECTION')?></h2>
		<ul class="block-picture">
		<?foreach($arResult['ITEMS'] as $key=>$arItem)
		{
			?>
			<li>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>" class="dsqv quick_view<?=$rand?>" data-index="<?=$key?>" <?if($arResult["IS_FANCY"]):?>onclick=""<?endif;?>>
					<?if(isset($arResult['MORE_PHOTO_JS'][$arItem['ID']][$arItem['FIRST_COLOR']]['SMALL'][0]["src"]))
					{?>
						<img class="img-responsive" src="<?=$arResult['MORE_PHOTO_JS'][$arItem['ID']][$arItem['FIRST_COLOR']]['SMALL'][0]["src"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" height="<?=$arResult['MORE_PHOTO_JS'][$arItem['ID']][$arItem['FIRST_COLOR']]['SMALL'][0]["height"]?>" width="<?=$arResult['MORE_PHOTO_JS'][$arItem['ID']][$arItem['FIRST_COLOR']]['SMALL'][0]["width"]?>">
					<?
					}else 
					{?>
						<img class="img-responsive" src="/upload/no_photo_small.jpg" title="" alt="" height="171" width="131">
					<?}?>
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
		<?}?>
		</ul>
	</div>
<?
}
?>