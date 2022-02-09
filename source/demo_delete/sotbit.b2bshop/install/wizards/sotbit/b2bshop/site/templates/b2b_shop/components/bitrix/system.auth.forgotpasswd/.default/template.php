<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="row">
	<div class="col-sm-19 sm-padding-right-no">
		<div class="forgot_page">
			<form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
				<?if (strlen($arResult["BACKURL"]) > 0)
				{?>
					<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<?}?>
				<input type="hidden" name="AUTH_FORM" value="Y">
				<input type="hidden" name="TYPE" value="SEND_PWD">

				<div class="wrap_title_text">
					<?=GetMessage("AUTH_FORGOT_PASSWORD_1")?>
				</div>
				<?ShowMessage($arParams["~AUTH_RESULT"]);?>
				<div class="title">
					<?=GetMessage("AUTH_GET_CHECK_STRING")?>
				</div>
				<div class="wrap_forgot_form">
					<div class="wrap_block">
						<div class="row">
							<div class="col-sm-3 col-md-2 sm-padding-right-no">
								<label><?=GetMessage("AUTH_EMAIL")?></label>
							</div>
							<div class="col-sm-17 col-md-11">
								<input type="text" value="" maxlength="50" name="USER_EMAIL">
							</div>
						</div>
					</div>
				</div>
				<div class="wrap_forgot_form_2">
					<div class="wrap_block">
						<div class="row">
							<div class="col-sm-7 col-md-6 col-lg-6">
								<div class="wrap_btn">
									<input type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>"/>
								</div>
							</div>
							<div class="col-sm-8">
								<div class="wrap_auth">
									<a class="auth" rel="nofollow" href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a>
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
