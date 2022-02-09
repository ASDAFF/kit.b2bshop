<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
if(!Loader::includeModule('sotbit.b2bshop'))
{
	return false;
}
$menu = new \Sotbit\B2BShop\Client\Personal\Menu();
?>

<div class="col-sm-19 sm-padding-right-no blank_right-side <?=(!$menu->isOpen()) ? 'blank_right-side_full':''?>" id="blank_right_side">
	<div id="wrapper_blank_resizer" class="wrapper_blank_resizer">
		<div class="blank_resizer">
			<div class="blank_resizer_tool <?=(!$menu->isOpen()) ? 'blank_resizer_tool_open':''?>" ></div>
		</div>
		<div class="personal-right-content">
			<div class="personal_block_subscribe">
				<form  method="post" action="#" id="sotbit_mailing_subsrib">
					<div class="title"><?=GetMessage('SETTING_SUBSCR_TITLE')?></div>
					<div class="wrap_content">
						<div class="row">
							<div class="col-sm-12">
								<div class="block_subscribe_left">
									<div class="subscribe_email">
										<div class="row">
											<div class="col-sm-9 col-md-7 sm-padding-right-no">
												<label><?=GetMessage('PANNEL_EMAIL')?><span class="starrequired">*</span></label>
											</div>
											<div class="col-sm-15 col-md-17">
												<input type="text" value="<?=$arResult['SUBSCRIBER_INFO']['EMAIL_TO']?>" name="EMAIL_TO" title="<?=GetMessage('PANNEL_EMAIL')?>" placeholder="<?=GetMessage('PANNEL_EMAIL')?>">
											</div>
										</div>
									</div>
									<?if($arParams["CATEGORIES_SHOW"]=='Y' && count($arParams["CATEGORIES_ID"])>0):?>
									<div class="subscribe_choose">
										<p><?=GetMessage('CATEGORIES_TITLE')?> <span class="starrequired">*</span></p>
										<div class="wrap_input">
										<?
										foreach($arResult['SUBSCRIBER_INFO']['CATEGORIES_ID'] as $k=>$v) {
											if(!in_array($v, $arParams["CATEGORIES_ID"])){
												$arParams["CATEGORIES_ID"][] = $v;
											}
										}
										?>
										 <?foreach($arParams["CATEGORIES_ID"] as $category_id):?>
										 <?if($arResult['CATEGORIES'][$category_id]):?>
										<div>
											<input type="checkbox" value="<?=$arResult['CATEGORIES'][$category_id]['ID']?>" name="CATEGORIES_ID_CHECK[<?=$arResult['CATEGORIES'][$category_id]['ID']?>]" <?if($arResult['CATEGORIES'][$category_id]['CHECKED']=='Y'):?>checked="checked"<?endif;?> id="CATEGORIES_ID_CHECK[<?=$arResult['CATEGORIES'][$category_id]['ID']?>]" />
											<label for="CATEGORIES_ID_CHECK[<?=$arResult['CATEGORIES'][$category_id]['ID']?>]"><?=$arResult['CATEGORIES'][$category_id]['NAME']?> </label>
										</div>
										<?endif;?>
										<?endforeach;?>
										</div>
									</div>
									<?endif;?>
									<div class="row">
										<div class="col-sm-11 sm-padding-right-no">
											<input class="subscribe_save" type="submit" value="<?=GetMessage('MS_PANNEL_SAVE')?>" name="Save">
										</div>
										<div class="col-sm-10">
											<div class="sotbit_mailing_subscr_wrap_answer"></div>
										</div>
									</div>
								</div>
							</div>

						</div>

						<?
						if(Option::get('sotbit.b2bshop','SHOW_CONFIDENTIAL_SUBSCRIBE','Y') == 'Y')
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


					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$("#sotbit_mailing_subsrib").on('submit', function(){

	var email = $("#sotbit_mailing_subsrib input[name=EMAIL_TO]").val();
	var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
	if(email == "<?=GetMessage('AUTH_REGISTER_PANNEL_EMAIL')?>") {
		 var email = "";
	}

	if(pattern.test(email)) {

		var params = "<?=$arResult['STR_PARAMS']?>";
		var form_send = $(this).serialize();

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
			data: 'getemail=Y&'+ params + '&'+ form_send,
			onsuccess: function(data){
				$('.sotbit_mailing_subscr_wrap_answer').html('<label style="color:green"><?=$EMAIL_SEND_END?></label>');
			},
		});

	}  else {
		 var email = "";
	}

	return false;
});
</script>
