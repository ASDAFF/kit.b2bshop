<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
use Bitrix\Main\Loader;

if(!Loader::includeModule('kit.b2bshop'))
{
	return;
}
$menu = new \Kit\B2BShop\Client\Personal\Menu();
?>
<div class="col-sm-18 sm-padding-right-no blank_right-side <?= (!$menu->isOpen()) ? 'blank_right-side_full' : '';?>" id="blank_right_side">
	<div id="wrapper_blank_resizer" class="wrapper_blank_resizer">
		<div class="blank_resizer">
			<div class="blank_resizer_tool <?= (!$menu->isOpen()) ? 'blank_resizer_tool_open' : ''?>" ></div>
		</div>
		<div class="personal-right-content">
			<div class="personal_block_inform">
				<?ShowError($arResult["strProfileError"]);
				if ($arResult['DATA_SAVED'] == 'Y')
				{
					ShowNote(GetMessage('PROFILE_DATA_SAVED'));
				}
				?>
	
				<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
					<?=$arResult["BX_SESSION_CHECK"]?>
					<input type="hidden" name="lang" value="<?=LANG?>" />
					<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
					<input type="hidden" name="EMAIL" value="<? echo $arResult["arUser"]["EMAIL"]?>"/>
					<input type="hidden" name="LOGIN" value="<? echo $arResult["arUser"]["LOGIN"]?>"/>
					
					<div class="title"><?=GetMessage('REG_MAIN_TITLE');?></div>
					<div class="wrap_content">
						<div class="row">
							<div class="col-sm-22 col-md-20 col-lg-16 sm-padding-right-no">
								<div class="wrap_block">
									<h3 class="block_title">
										<?=GetMessage("REG_SHOW_HIDE")?>
									</h3> 
									<?if($arResult["arUser"]["LOGIN"] != $arResult["arUser"]["EMAIL"]):?>
										<?if($arResult["arUser"]["LOGIN"]):?>
											<div class="row">
												<div class="col-sm-9 col-md-7 sm-padding-right-no">
													<label><?=GetMessage('LOGIN')?></label>
												</div>
												<div class="col-sm-15 col-md-17">
													<p class="personal_field_val">
														<?echo $arResult["arUser"]["LOGIN"]?>
													</p>
												</div>
											</div>
										<?endif;?>
										<?if($arResult["arUser"]["EMAIL"]):?>
											<div class="row">
												<div class="col-sm-9 col-md-7 sm-padding-right-no">
													<label><?=GetMessage('EMAIL')?></label>
												</div>
												<div class="col-sm-15 col-md-17">
													<p class="personal_field_val">
														<?echo $arResult["arUser"]["EMAIL"];?>
													</p>
												</div>
											</div>
										<?endif;?>
									<?else:?>
										<?if($arResult["arUser"]["EMAIL"]):?>
											<div class="row">
												<div class="col-sm-9 col-md-7 sm-padding-right-no">
													<label><?=GetMessage('EMAIL_LOGIN')?></label>
												</div>
												<div class="col-sm-15 col-md-17">
													<p class="personal_field_val">
														<?echo $arResult["arUser"]["EMAIL"];?>
													</p>
												</div>
											</div>
										 <?endif;?>
									<?endif;?>
									<div class="row">
										<div class="col-sm-9 col-md-7 sm-padding-right-no">
											<label><?=GetMessage('NAME_')?></label>
										</div>
										<div class="col-sm-15 col-md-17">
											<input
													type="text"
													name="NAME"
													maxlength="50"
													value="<?=$arResult["arUser"]["NAME"]?>"
													pattern="[�-��-߸�a-zA-Z]+"
											/>
										</div>
									</div>
		
									<div class="row">
										<div class="col-sm-9 col-md-7 sm-padding-right-no">
											<label><?=GetMessage('LAST_NAME')?></label>
										</div>
										<div class="col-sm-15 col-md-17">
											<input
													type="text"
													name="LAST_NAME"
													maxlength="50"
													value="<?=$arResult["arUser"]["LAST_NAME"]?>"
													pattern="[�-��-߸�a-zA-Z]+"
											/>
										</div>
									</div>
						
									<div class="row">
										<div class="col-sm-9 col-md-7 sm-padding-right-no">
											<label><?=GetMessage('SECOND_NAME')?></label>
										</div>
										<div class="col-sm-15 col-md-17">
											<input
													type="text"
													name="SECOND_NAME"
													maxlength="50"
													value="<?=$arResult["arUser"]["SECOND_NAME"]?>"
													pattern="[�-��-߸�a-zA-Z]+"
											/>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-9 col-md-7 sm-padding-right-no">
											<label><?=GetMessage('PERSONAL_PHONE')?></label>
										</div>
										<div class="col-sm-15 col-md-17">
											<input
													type="text"
													name="PERSONAL_PHONE"
													maxlength="255"
													value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>"
													pattern="[0-9+\s-]+"
											/>
										</div>
									</div>
								</div>
								<h3 class="block_title"><?=\Bitrix\Main\Localization\Loc::getMessage("AVATAR") ?></h3>
								<div class="himself_content">
									<div class="content">
										<div class="drop-files clearfix" id="drop-files"
											ondragover="return false">
											<div class="file-upload">
												<label> 
												<?=$arResult["arUser"]["PERSONAL_PHOTO_INPUT"]?>
												<span></span>
												</label>
											</div>
											<div class="img_block_avatar">
											<?
											if($arResult['arUser']['PERSONAL_PHOTO_IMG']['src'])
											{
												?>
												<img src="<?=$arResult['arUser']['PERSONAL_PHOTO_IMG']['src'] ?>" width="<?=$arResult['arUser']['PERSONAL_PHOTO_IMG']['width'] ?>" height="<?=$arResult['arUser']['PERSONAL_PHOTO_IMG']['height'] ?>">
												<?
											}
											?>
											</div>
											<div class="text_block clearfix">
												<p class="title"><?=($arResult['arUser']['PERSONAL_PHOTO_IMG']['src'])?\Bitrix\Main\Localization\Loc::getMessage("EDIT_AVATAR"):\Bitrix\Main\Localization\Loc::getMessage("ADD_AVATAR") ?></p>
												<input type="text" id="filename" class="filename" value="<?=\Bitrix\Main\Localization\Loc::getMessage("PUSH") ?>" disabled>
											</div>
										</div>
									<?
									if($arResult['arUser']['PERSONAL_PHOTO_IMG']['src'])
									{
										?>
										<div class="del-avatar">
										<input type="checkbox" name="PERSONAL_PHOTO_del" value="Y" id="del_avatar" class="checkbox">
										<label for="del_avatar"><?=\Bitrix\Main\Localization\Loc::getMessage("DEL_AVATAR") ?></label>
										</div>
										<?
									}
									?>
									</div>
								</div>
								<?if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == ''):?>
									<div class="wrap_block">
										<h3 class="block_title"><?=GetMessage("NEW_PASSWORD_TITLE")?></h3> 
										<div class="row">
											<div class="col-sm-9 col-md-7 sm-padding-right-no">
												<label><?=GetMessage('NEW_PASSWORD_REQ')?></label>
											</div>
											<div class="col-sm-15 col-md-17">
												<input type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" class="bx-auth-input" />
											</div>
										</div>
										<div class="row">
											<div class="col-sm-9 col-md-7 sm-padding-right-no">
												<label><?=GetMessage('NEW_PASSWORD_CONFIRM')?></label>
											</div>
											<div class="col-sm-15 col-md-17">
												<input type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" />
											</div>
										</div>
									</div>
								<?endif?>
								<?// ********************* User properties ***************************************************?>
								<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
									<div class="wrap_block">
									<h3 class="block_title"><?=strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?></h3>
										<?$first = true;?>
										<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
										<div class="row">
											<div class="col-sm-9 col-md-7 sm-padding-right-no">
												<label><?=$arUserField["EDIT_FORM_LABEL"]?>:</label>
											</div>
											<div class="col-sm-15 col-md-17">
												<?$APPLICATION->IncludeComponent(
													"bitrix:system.field.edit",
													$arUserField["USER_TYPE"]["USER_TYPE_ID"],
													array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS"=>"Y"));?>
											</div>
										</div>
										<?endforeach;?>
									</div>
								<?endif;?>
								<div class="row">
									<div class="col-sm-15 col-md-17">
										<input type="submit" name="save" value="<?=GetMessage("MAIN_SAVE_BTN");?>">
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>