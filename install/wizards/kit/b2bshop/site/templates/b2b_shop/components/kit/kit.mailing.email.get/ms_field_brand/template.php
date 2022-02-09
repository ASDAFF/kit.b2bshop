<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Config\Option;
$arResult['CATEGORIES_BRAND'] = array();
foreach($arResult['CATEGORIES'] as $k=>$v)
{
	if($v['PARAM_1']=='PROPERTY' && $v['PARAM_2']==$arParams['PARAM_2:PROPERTY'])
	{
		$arResult['CATEGORIES_BRAND'][$v['PARAM_3']] = $v['ID'];
	}
}

if($arResult['CATEGORIES_BRAND'][$arParams['PARAM_3:PROPERTY']] && in_array($arResult['CATEGORIES_BRAND'][$arParams['PARAM_3:PROPERTY']],$arResult['SUBSCRIBER_INFO']['CATEGORIES_ID']))
{}
else
{?> 
<div class="right_block_subscribt">
	<div class="row">
		<div class="col-sm-11 sm-padding-right-no">
			<div class="right_block_subscribt_left">
				<p><?=$arParams["INFO_TEXT"]?></p>
			</div>
		</div>
		<div class="col-sm-13">
			<form id="kit_mailing_subsrib_brand" method="post" action="#" class="form-subscribe">
				<div class="row">
					<div class="col-sm-16 sm-padding-no">
						<div class="right_block_subscribt_center">
							<?$frame = $this->createFrame()->begin('');
								if($arResult['CATEGORIES_BRAND'][$arParams['PARAM_3:PROPERTY']] && in_array($arResult['CATEGORIES_BRAND'][$arParams['PARAM_3:PROPERTY']],$arResult['SUBSCRIBER_INFO']['CATEGORIES_ID']))
								{
									echo $arParams["~EMAIL_SEND_END"];
								}
								else
								{?> 
									<label><?=GetMessage('PANNEL_EMAIL_TITLE')?></label>
									<input type="text" placeholder="<?=GetMessage('PANNEL_EMAIL')?>" maxlength="50" name="EMAIL_TO" value="<?=$arResult['SUBSCRIBER_INFO']['EMAIL_TO']?>" <?if($arResult['SUBSCRIBER_INFO']['EMAIL_TO']){?>disabled="disabled" title="<?=GetMessage('PANNEL_EMAIL')?>"<?}else{?>title="<?=GetMessage('PANNEL_EMAIL')?>"<?}?> >
								<?}
							$frame->end();?>
						</div>
					</div>
					<div class="col-sm-8 sm-padding-no">
						<div class="right_block_subscribt_right">
							<div class="wrap_input">
								<input type="submit" name="Save" value="<?=GetMessage('PANNEL_SEND')?>">
							</div>
						</div>
					</div>
				</div>
				<?
				if(Option::get('kit.b2bshop','SHOW_CONFIDENTIAL_SUBSCRIBE','Y') == 'Y')
				{
					?>
					<div class="row">
						<div class="col-sm-24 sm-padding-no">
							<div class="confidential-field">
								<input type="checkbox" id="UF_CONFIDENTIAL" name="UF_CONFIDENTIAL" class="checkbox"
								       checked="checked"
								       required>
								<label for="UF_CONFIDENTIAL" class="label-active">
									<?=GetMessage("AUTH_UF_CONFIDENTIAL");?>
								</label>
							</div>
						</div>
					</div>
					<?
				}
				?>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">   
$("#kit_mailing_subsrib_brand").on('submit', function(){
	var email = $("#kit_mailing_subsrib_brand input[name=EMAIL_TO]").val();
	var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
	if(email == "<?=GetMessage('AUTH_REGISTER_PANNEL_EMAIL')?>") {
		 var email = "";
	}
	
	if(pattern.test(email)) {

		var params = "<?=$arResult['STR_PARAMS']?>";
		<?
		if($arParams["EMAIL_SEND_END"]){
			$EMAIL_SEND_END = $arParams["~EMAIL_SEND_END"];
		} else{
			$EMAIL_SEND_END = GetMessage('EMAIL_SEND_END');
		}
		?>
		BX.ajax({
			url: "<?=$this->GetFolder() ?>/ajax.php",
			method: 'POST',
			dataType: 'html',
			data: 'getemail=Y&EMAIL_TO=' + email +'&'+ params,
			onsuccess: function(data){
				$('.right_block_subscribt_center').html('<?=$EMAIL_SEND_END?>');
			},
		});
		
	}
	else {
		 var email = "";
	}

	return false;
});
</script>
<style>
.kit_mailing_subscr_wrap_in input[type="submit"]{
	background-color: #<?=$arParams["COLOR_BUTTON"]?>;	
}
</style>

<?}?> 