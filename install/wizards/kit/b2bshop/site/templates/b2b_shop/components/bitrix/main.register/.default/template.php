<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}

Loc::loadMessages( __FILE__ );
?>
<div class="row">
	<div class="col-sm-19 sm-padding-right-no"> 
		<div class="registr_page">
			<?if($USER->IsAuthorized())
			{
				?>
				<p>
					<?php echo Loc::getMessage("MAIN_REGISTER_AUTH");?>
				</p>
				<?php
			}
			else 
			{
				if (count($arResult["ERRORS"]) > 0)
				{
					foreach ($arResult["ERRORS"] as $key => $error)
					{
						if (intval($key) == 0 && $key !== 0)
						{
							$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".Loc::getMessage("REGISTER_FIELD_".$key)."&quot;", $error);
						}
					}
					ShowError(implode("<br />", $arResult["ERRORS"]));
				}
				elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y")
				{
					?>
					<p><?echo Loc::getMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
					<?php 
				}
				?>
				<noindex>
					<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="bform" class="register-form" enctype="multipart/form-data">
						<div class="title"><?=Loc::getMessage("AUTH_REGISTER_TITLE")?></div>
						<div class="wrap_registr_form">
							<div class="wrap_block">
								<h3 class="block_title"><?=Loc::getMessage("AUTH_BLOCK_GENERAL_TITLE");?></h3>
								<?
								if($arResult["BACKURL"] <> '')
								{
									?>
									<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
									<?php
								}
								foreach ($arResult["SHOW_FIELDS"] as $FIELD)
								{
									if($FIELD == 'PASSWORD' || $FIELD == 'CONFIRM_PASSWORD' || $FIELD == 'EMAIL')
									{
										continue;
									}
									if($FIELD == 'LOGIN')
									{
										?>
										<input type="hidden" id="LOGIN" name="REGISTER[<?=$FIELD?>]" maxlength="50" value="<?=$arResult["VALUES"][$FIELD]?>" />
										<?php 
									}
									else 
									{
										?>
										<div class="row">
											<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
												<label><?=Loc::getMessage("REGISTER_FIELD_".$FIELD)?></label>
											</div>
											<div class="col-sm-17 col-md-10 col-lg-11">
												<input type="text" id="<?=$FIELD?>" name="REGISTER[<?=$FIELD?>]" maxlength="50" value="<?=$arResult["VALUES"][$FIELD]?>" />
											</div>
										</div>
										<?php 
									}
								}
								if(in_array('EMAIL',$arResult["SHOW_FIELDS"]))
								{
									?>
									<div class="row">
										<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
											<label><?=Loc::getMessage("REGISTER_FIELD_EMAIL")?></label>
										</div>
										<div class="col-sm-17 col-md-10 col-lg-11">
											<input type="text" id="EMAIL" name="REGISTER[EMAIL]" maxlength="50" value="<?=$arResult["VALUES"]['EMAIL']?>" />
										</div>
									</div>
									<?php
								}
								?>
							</div>
							<div class="wrap_block">
								<h3 class="block_title"><?=Loc::getMessage("AUTH_BLOCK_PASS_TITLE");?></h3>
								<?php
								foreach ($arResult["SHOW_FIELDS"] as $FIELD)
								{
									if($FIELD == 'PASSWORD' || $FIELD == 'CONFIRM_PASSWORD')
									{
									?>
										<div class="row">
											<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
												<label><?=Loc::getMessage("REGISTER_FIELD_".$FIELD)?><span class="starrequired">*</span></label>
											</div>
											<div class="col-sm-17 col-md-10 col-lg-11">
												<input type="password" name="REGISTER[<?=$FIELD?>]" maxlength="50" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off"/>
												<?if($arResult["SECURE_AUTH"])
												{?>
													<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo Loc::getMessage("AUTH_SECURE_NOTE")?>" style="display:none">
														<div class="bx-auth-secure-icon"></div>
													</span>
													<noscript>
													<span class="bx-auth-secure" title="<?echo Loc::getMessage("AUTH_NONSECURE_NOTE")?>">
														<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
													</span>
													</noscript>
													<script type="text/javascript">
														document.getElementById('bx_auth_secure').style.display = 'inline-block';
													</script>
												<?}?>
											</div>
											<?php 
											if($FIELD == 'PASSWORD')
											{
												?>
												<div class="col-sm-24 col-md-8">
													<div class="input_message_1"><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></div>
												</div>
												<?php 
											}
											else
											{
												?>
												<div class="col-sm-24 col-md-8">
													<div class="input_message_2"><span class="starrequired">*</span><?=Loc::getMessage("AUTH_REQ")?></div>
												</div>
												<?php
											}?>
										</div>
									<?php
									}
								}
								if($arResult["USER_PROPERTIES"]["SHOW"] == "Y")
								{
									foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField)
									{
										if($FIELD_NAME == 'UF_CONFIDENTIAL')
										{
											if(Option::get('kit.b2bshop', 'SHOW_CONFIDENTIAL_REGISTRATION','Y') == 'Y')
											{
												?>
												<div class="row">
													<div class="col-sm-24 confidential-field">
														<input 
															type="checkbox" 
															<?php echo ($arResult["VALUES"]['UF_CONFIDENTIAL'] == 1 || (!$arResult["VALUES"] && $arUserField['SETTINGS']['DEFAULT_VALUE'] == 1))?'checked="checked"':'';?>
															class="checkbox"
															name="<?php echo $FIELD_NAME;?>"
															id="<?php echo $FIELD_NAME;?>"
															value="1">
														<label for="UF_CONFIDENTIAL">
															<?=Loc::getMessage("REGISTER_CONFIDENTIAL")?>
														</label>
													</div>
												</div>
												<?php
											}
											else 
											{
												?>
												<input type="hidden" name="<?php echo $FIELD_NAME;?>" value="1">
												<?php
											}
										}
									}
								}?>
							</div>
						</div>
						<div class="wrap_registr_form_2">
							<div class="wrap_block">
								<?if ($arResult["USE_CAPTCHA"] == "Y")
								{?>
									<h3 class="block_title"><?=Loc::getMessage("CAPTCHA_REGF_TITLE")?></h3>
									<div class="row">
										<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
											<div class="wrap_img">
												<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
												<img class="img-responsive" width="170" height="42" alt="CAPTCHA" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>">
											</div>
										</div>
										<div class="col-sm-17 col-md-10 col-lg-11">
											<label><?=Loc::getMessage("CAPTCHA_REGF_PROMT")?>:<span class="starrequired">*</span></label>
											<input type="text" name="captcha_word" maxlength="50" value="" class="input_text_style" />
										</div>					 
									</div>
								<?}?>
								<div class="row">
									<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
									</div>
									<div class="col-sm-13 col-md-6 col-lg-6 col-sm-offset-4 col-md-offset-4 col-lg-offset-5">
										<div class="wrap_btn">
											<input type="submit" name="register_submit_button" value="<?=Loc::getMessage("AUTH_REGISTER")?>"/>
										</div>
									</div>
									<div class="col-sm-13 col-md-8 col-sm-offset-11 col-md-offset-0">
										<div class="wrap_auth">
											<a class="auth" rel="nofollow" href="<?=$arParams["~AUTH_URL"]?>"><?=Loc::getMessage("AUTH_AUTH")?></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</noindex>
			<?php 
			}
			?>
		</div>
	</div>
</div>
<script type="text/javascript">
	document.getElementById('NAME').focus()
	$('#EMAIL').on("change", function() {
		var login_val = $(this).val();
		$('#LOGIN').val(login_val);       
	});
</script>