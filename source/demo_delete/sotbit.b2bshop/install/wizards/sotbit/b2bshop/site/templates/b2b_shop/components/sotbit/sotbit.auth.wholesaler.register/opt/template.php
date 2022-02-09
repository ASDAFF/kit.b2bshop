<?

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}
Loc::loadMessages(__FILE__);
?>
<div class="row">
	<div class="col-sm-19 sm-padding-right-no">
		<div class="registr_page">
			<? if($USER->IsAuthorized())
			{
				?>
				<p>
					<?php echo Loc::getMessage("MAIN_REGISTER_AUTH"); ?>
				</p>
				<?php
			}
			else
			{
				if(count($arResult["ERRORS"]) > 0)
				{
					foreach ($arResult["ERRORS"] as $key => $error)
					{
						if(intval($key) == 0 && $key !== 0)
						{
							$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;" . Loc::getMessage("REGISTER_FIELD_" . $key) . "&quot;", $error);
						}
					}
					ShowError(implode("<br />", $arResult["ERRORS"]));
				}
				elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y")
				{
					?>
					<p><?
						echo Loc::getMessage("REGISTER_EMAIL_WILL_BE_SENT") ?></p>
					<?php
				}
				if($arResult["CONFIRM_REGISTRATION"])
				{
					?>
					<p class="success-register-confirm"><?echo Loc::getMessage("CONFIRM_REGISTRATION")?></p>
					<?php
				}
				else
				{
					?>
					<noindex>
						<form method="post" action="<?= POST_FORM_ACTION_URI ?>" name="bform" class="register-form"
						      enctype="multipart/form-data">
							<div class="title"><?= Loc::getMessage("AUTH_REGISTER_TITLE") ?></div>
							<?php
							if($arResult["BACKURL"] <> '')
							{
								?>
								<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
								<?php
							} ?>
							<input type="hidden" id="LOGIN" name="REGISTER[LOGIN]" maxlength="50"
							       value="1"/>
							<div class="tabs">
								<?
								if(Option::get('sotbit.b2bshop', 'CLOSE_FIZ', 'N') == 'N')
								{
									?>
									<a href="<?= SITE_DIR ?>login/?register=yes&backurl=<?= SITE_DIR ?>personal/b2b/auth/index.php">
										<input id="tab1" type="radio" name="TAB" value="USER">
										<label class="tab1">
											<div class="tab-icon"></div>
											<?php echo Loc::getMessage('SOTBIT_AUTH_TAB1'); ?>
										</label>
									</a>
									<?
								} ?>

								<input id="tab2" type="radio" name="TAB" value="WHOLESALER" checked>
								<label for="tab2" class="tab2">
									<div class="tab-icon"></div>
									<?php echo Loc::getMessage('SOTBIT_AUTH_TAB2'); ?>
								</label>
								<section id="content-tab1">
									<div class="wrap_registr_form">
										<div class="wrap_block">
											<h3 class="block_title"><?= Loc::getMessage("AUTH_BLOCK_GENERAL_TITLE"); ?></h3>
											<?
											foreach ($arResult["SHOW_FIELDS"] as $FIELD)
											{
												if($FIELD == 'PASSWORD' || $FIELD == 'CONFIRM_PASSWORD' || $FIELD == 'EMAIL' || $FIELD == 'LOGIN')
												{
													continue;
												}
												else
												{
													?>
													<div class="row">
														<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
															<label><?= Loc::getMessage("REGISTER_FIELD_" . $FIELD) ?></label>
														</div>
														<div class="col-sm-17 col-md-10 col-lg-11">
															<input type="text" id="<?= $FIELD ?>"
															       name="REGISTER[<?= $FIELD ?>]" maxlength="50"
															       value="<?= $arResult["VALUES"]['FIELDS'][$FIELD] ?>"/>
														</div>
													</div>
													<?php
												}
											}
											if(in_array('EMAIL', $arResult["SHOW_FIELDS"]))
											{
												?>
												<div class="row">
													<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
														<label>
															<?php
															echo Loc::getMessage("REGISTER_FIELD_EMAIL");
															if(in_array('EMAIL', $arParams['REQUIRED_FIELDS']))
															{
																?>
																<span class="starrequired">*</span>
																<?php
															}
															?>
														</label>
													</div>
													<div class="col-sm-17 col-md-10 col-lg-11">
														<input type="text" id="EMAIL" name="REGISTER[EMAIL]" maxlength="50"
														       value="<?= $arResult["VALUES"]['FIELDS']['EMAIL'] ?>"/>
													</div>
												</div>
												<?php
											}
											?>
										</div>
									</div>
								</section>
								<section id="content-tab2">
									<div class="wrap_registr_form">
										<div class="wrap_block">
											<h3 class="block_title"><?= Loc::getMessage("AUTH_BLOCK_GENERAL_TITLE"); ?></h3>

											<div class="row">

												<div class="col-sm-24 col-md-24 col-lg-24">

													<?php foreach ($arResult['PERSON_TYPES'] as $key => $group): ?>
														<label class="checkbox-inline">
															<input type="radio" class="REGISTER_WHOLESALER_TYPE"
															       name="REGISTER_WHOLESALER[TYPE]"
															       value="<?= $group['ID']; ?>" <? if($arResult["VALUES"]['WHOLESALER_FIELDS']['TYPE'] == $group['ID']) echo 'checked'; elseif($key == '0' && is_null($arResult["VALUES"]['WHOLESALER_FIELDS']['TYPE'])) echo 'checked'; ?>> <?= $group['NAME']; ?>
														</label>
													<?php endforeach; ?>

												</div>
											</div>

											<?php foreach ($arResult['PERSON_TYPES'] as $key => $group): ?>
												<section id="content-fields-<?= $group['ID']; ?>" class="content-fields">
													<?php foreach ($arResult['OPT_FIELDS'][$group['ID']] as $key => $FIELD)
													{ ?>

														<div class="row">
															<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
																<label><?= Loc::getMessage("REGISTER_FIELD_" . $FIELD) ?></label>
																<? if(is_array($arResult['OPT_FIELDS_REQUIRED'][$group['ID']]) && in_array($FIELD, $arResult['OPT_FIELDS_REQUIRED'][$group['ID']]))
																{
																	?>
																	<span class="starrequired">*</span>
																	<?php
																} ?>
															</div>
															<div class="col-sm-17 col-md-10 col-lg-11">
																<input type="text" id="WHOLESALER_<?= $FIELD ?>"
																       name="REGISTER_WHOLESALER_USER[<?= $group['ID']; ?>][<?= $FIELD ?>]"
																       maxlength="50"
																       value="<?= $arResult["VALUES"]['WHOLESALER_FIELDS'][$FIELD] ?>"/>
															</div>
														</div>
													<?php } ?>
													<h3 class="block_title"><?= Loc::getMessage("AUTH_BLOCK_WHOLESALER_ORDER_TITLE"); ?></h3>

													<?php foreach ($arResult['OPT_ORDER_FIELDS'][$group['ID']] as $order)
													{
														; ?>
														<div class="row">
															<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
																<label><?= $order['NAME']; ?></label>
																<? if($order['REQUIRED'] == 'Y')
																{
																	?>
																	<span class="starrequired">*</span>
																	<?php
																}
																?>
															</div>
															<div class="col-sm-17 col-md-10 col-lg-11">
																<input type="text" id="WHOLESALER_<?= $order['CODE'] ?>"
																       name="REGISTER_WHOLESALER_OPT[<?= $group['ID']; ?>][<?= $order['CODE'] ?>]"
																       maxlength="50"
																       value="<?= $arResult["VALUES"]['WHOLESALER_ORDER_FIELDS'][$order['CODE']] ?>"/>
															</div>
														</div>
													<? } ?>

												</section>
											<?php endforeach;
											$APPLICATION->IncludeComponent("bitrix:main.file.input", "drag_n_drop",
												[
													"INPUT_NAME" => "FILE",
													"MULTIPLE" => "Y",
													"MODULE_ID" => "main",
													"MAX_FILE_SIZE" => "",
													"ALLOW_UPLOAD" => "F",
													"ALLOW_UPLOAD_EXT" => ""
												],
												false
											);
											?>
										</div>
									</div>
								</section>
							</div>
							<div class="wrap_registr_form">
								<div class="wrap_block">
									<?
									if($arResult['USER_GROUPS'])
									{
										?>
										<div class="user-group-block">
											<h3 class="block_title"><?= Loc::getMessage("AUTH_BLOCK_USER_GROUP_TITLE"); ?></h3>
											<div class="row">
												<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
													<label>
														<?= Loc::getMessage("USER_GROUP_GROUP") ?>
														<span class="starrequired">*</span>
													</label>
												</div>
												<div class="col-sm-17 col-md-10 col-lg-11">
													<div class="user-group-wrapper">
														<select name="REGISTER[USER_GROUP]" class="user-groups">
															<?
															foreach ($arResult['USER_GROUPS'] as $id => $name)
															{
																?>
																<option value="<?= $id ?>"><?= $name ?></option>
																<?
															}
															?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<?
									}
									?>
									<h3 class="block_title"><?= Loc::getMessage("AUTH_BLOCK_PASS_TITLE"); ?></h3>
									<?php
									foreach ($arResult["SHOW_FIELDS"] as $FIELD)
									{
										if($FIELD == 'PASSWORD' || $FIELD == 'CONFIRM_PASSWORD')
										{
											?>
											<div class="row">
												<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
													<label><?= Loc::getMessage("REGISTER_FIELD_" . $FIELD) ?><span
																class="starrequired">*</span></label>
												</div>
												<div class="col-sm-17 col-md-10 col-lg-11">
													<input type="password" name="REGISTER[<?= $FIELD ?>]" maxlength="50"
													       value="<?= $arResult["VALUES"]['FIELDS'][$FIELD] ?>"
													       autocomplete="off"/>
													<?
													if($arResult["SECURE_AUTH"])
													{
														?>
														<span class="bx-auth-secure" id="bx_auth_secure" title="<?
														echo Loc::getMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
																<div class="bx-auth-secure-icon"></div>
															</span>
														<noscript>
															<span class="bx-auth-secure" title="<?
															echo Loc::getMessage("AUTH_NONSECURE_NOTE") ?>">
																<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
															</span>
														</noscript>
														<script type="text/javascript">
															document.getElementById('bx_auth_secure').style.display = 'inline-block';
														</script>
														<?
													} ?>
												</div>
												<?php
												if($FIELD == 'PASSWORD')
												{
													?>
													<div class="col-sm-24 col-md-8">
														<div class="input_message_1"><?
															echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; ?></div>
													</div>
													<?php
												}
												else
												{
													?>
													<div class="col-sm-24 col-md-8">
														<div class="input_message_2"><span
																	class="starrequired">*</span><?= Loc::getMessage("AUTH_REQ") ?>
														</div>
													</div>
													<?php
												} ?>
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
												if(Option::get('sotbit.b2bshop', 'SHOW_CONFIDENTIAL_REGISTRATION', 'Y') == 'Y')
												{
													?>
													<div class="row">
														<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no"></div>
														<div class="col-sm-17 col-md-10 col-lg-11 confidential-field">
															<input
																	type="checkbox"
																<?php echo ($arResult["VALUES"]['FIELDS']['UF_CONFIDENTIAL'] == 1 || (!$arResult["VALUES"]['FIELDS'] && $arUserField['SETTINGS']['DEFAULT_VALUE'] == 1)) ? 'checked="checked"' : ''; ?>
																	class="checkbox"
																	name="<?php echo $FIELD_NAME; ?>"
																	id="<?php echo $FIELD_NAME; ?>"
																	value="1">
															<label for="UF_CONFIDENTIAL">
																<?= Loc::getMessage("REGISTER_CONFIDENTIAL") ?>
															</label>
														</div>
													</div>
													<?php
												}
												else
												{
													?>
													<input type="hidden" name="<?php echo $FIELD_NAME; ?>" value="1">
													<?php
												}
											}
										}
									} ?>
								</div>
							</div>
							<?
							if($arResult["USE_CAPTCHA"] == "Y")
							{
								?>
								<div class="wrap_registr_form_2">
									<div class="wrap_block">
										<h3 class="block_title"><?= Loc::getMessage("CAPTCHA_REGF_TITLE") ?></h3>
										<div class="row">
											<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
												<div class="wrap_img">
													<input type="hidden" name="captcha_sid"
													       value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
													<img class="img-responsive" width="170" height="42" alt="CAPTCHA"
													     src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>">
												</div>
											</div>
											<div class="col-sm-17 col-md-10 col-lg-11">
												<label><?= Loc::getMessage("CAPTCHA_REGF_PROMT") ?>:<span
															class="starrequired">*</span></label>
												<input type="text" name="captcha_word" maxlength="50" value=""
												       class="input_text_style"/>
											</div>
										</div>
									</div>
								</div>
								<?
							} ?>
							<div class="wrap_registr_form_2 buttons_under_tabs">
								<div class="row">
									<div class="col-sm-24">
										<div class="wrap_btn">
											<input type="submit" name="sotbit_auth_register"
											       value="<?= Loc::getMessage("AUTH_REGISTER") ?>"/>
										</div>
										<div class="wrap_auth">
											<a class="auth" rel="nofollow"
											   href="<?= SITE_DIR ?>login/index.php?login=yes&backurl=<?= SITE_DIR ?>personal/b2b/auth/index.php">
												<?= Loc::getMessage("AUTH_AUTH") ?>
											</a>
										</div>
									</div>
								</div>
							</div>
						</form>
					</noindex>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>
<style>
	.content-fields {
		display: none
	}

	/*.content-fields:nth-child(3) {display:block}*/
</style>
<script type="text/javascript">
	document.getElementById('NAME').focus()
	$('#EMAIL').on("change", function ()
	{
		var login_val = $(this).val();
		$('#LOGIN').val(login_val);
	});
	$('#WHOLESALER_EMAIL').on("change", function ()
	{
		var login_val = $(this).val();
		$('#LOGIN').val(login_val);
	});
	$('.REGISTER_WHOLESALER_TYPE').on('change', function ()
	{
		var id = $(this).val();
		$('.content-fields').fadeOut(0);
		$('#content-fields-' + id).fadeTo(0, 1);
	});

	var wId = $('.REGISTER_WHOLESALER_TYPE:checked').val();
	$('.content-fields').fadeOut(0);
	$('#content-fields-' + wId).fadeTo(0, 1);

</script>