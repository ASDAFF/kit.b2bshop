<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="row">
	<div class="col-sm-19 sm-padding-right-no">
		<div class="change_pass_page">
			<?
			ShowMessage($arParams["~AUTH_RESULT"]);
			?>
			<form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
				<?if (strlen($arResult["BACKURL"]) > 0)
				{?>
					<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<?}?>
				<input type="hidden" name="AUTH_FORM" value="Y">
				<input type="hidden" name="TYPE" value="CHANGE_PWD">

				<div class="title"><?=GetMessage("AUTH_CHANGE_PASSWORD")?></div>

				<div class="wrap_change_form">
					<div class="wrap_block">
						<div class="row">
							<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
								<label><?=GetMessage("AUTH_LOGIN_EMAIL")?><span class="starrequired">*</span></label>
							</div>
							<div class="col-sm-17 col-md-10 col-lg-11">
								<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
								<label><?=GetMessage("AUTH_CHECKWORD")?><span class="starrequired">*</span></label>
							</div>
							<div class="col-sm-17 col-md-10 col-lg-11">
								<input type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" />
							</div>
						</div>

						<div class="row">
							<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
								<label><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?><span class="starrequired">*</span></label>
							</div>
							<div class="col-sm-17 col-md-10 col-lg-11">
								<input type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
								<label><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?><span class="starrequired">*</span></label>
							</div>
							<div class="col-sm-17 col-md-10 col-lg-11">
								<input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>"/>
							</div>
						</div>
					</div>
				</div>
				<div class="wrap_change_form_2">
					<div class="wrap_block">
						<div class="row">
							<div class="col-sm-7 col-md-6 col-lg-6">
								<div class="wrap_btn">
									<input type="submit" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>"/>
								</div>
							</div>
							<div class="col-sm-8">
								<div class="wrap_auth">
									<a class="auth" href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	document.bform.USER_LOGIN.focus();
</script>