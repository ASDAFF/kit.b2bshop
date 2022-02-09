<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?$script_name;
if($_SERVER["REAL_FILE_PATH"]) {
	$script_name = $_SERVER["REAL_FILE_PATH"];	
} else {
	$script_name = $_SERVER['SCRIPT_NAME'];	 
}?>
<?if ($script_name ==SITE_DIR."personal/order/make/index.php" || $script_name == SITE_DIR."personal/index.php" || $script_name == SITE_DIR."personal/profile/index.php" || $script_name == SITE_DIR."personal/subscribe/index.php" || $script_name == SITE_DIR."personal/order/index.php"):?>
<div class="personal_auth_title">
	<div class="main_inner_title">
		<h1 class="text"><?$APPLICATION->ShowTitle(false);?></h1>
	</div>
<?endif;?>

<div class="row">
	<div class="col-sm-19 sm-padding-right-no">
		<div class="login_page">
	<div class="title"><span class="bg_fly"><?echo GetMessage("AUTH_TITLE")?></span></div>
			 <?
			ShowMessage($arParams["~AUTH_RESULT"]);
			ShowMessage($arResult['ERROR_MESSAGE']);
			?>
			
	<form name="form_auth" method="post" target="_top" action="<?=SITE_DIR?>auth/<?//=$arResult["AUTH_URL"]?>" class="bx_auth_form">
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
		<?if (strlen($arParams["BACKURL"]) > 0 || strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?=($arParams["BACKURL"] ? $arParams["BACKURL"] : $arResult["BACKURL"])?>" />
		<?endif?>
		<?foreach ($arResult["POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?endforeach?>
		<div class="wrap_login_form">
			<div class="wrap_block">
				<h3 class="block_title"><?=GetMessage('AUTH_TITLE_LOGIN');?></h3>
				<div class="row">
					<div class="col-sm-7 col-md-6 col-lg-5">
						<label><?=GetMessage('AUTH_EMAIL_LOGIN')?></label>
					</div>
					<div class="col-sm-17 col-md-10 col-lg-11 sm-padding-left-no">
						<input class="login_input" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
					</div>
				</div>
			</div>

			<div class="wrap_block">
				<h3 class="block_title"><?=GetMessage("AUTH_TITLE_PASSWORD")?></h3>
				<div class="row">
					<div class="col-sm-7 col-md-6 col-lg-5">
						<label><?=GetMessage("AUTH_PASSWORD")?></label>
					</div>
					<div class="col-sm-17 col-md-10 col-lg-11 sm-padding-left-no">
						<input class="password_inout" type="password" name="USER_PASSWORD" maxlength="255" />
						<div class="wrap_remember_forgot">
							<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
								<div class="rememberme">
									<input type="checkbox" id="PAGE_USER_REMEMBER" name="USER_REMEMBER" value="Y" checked/>
									<label class="label-active" for="PAGE_USER_REMEMBER"><?=GetMessage("AUTH_REMEMBER_ME")?></label>
								</div>
							<?endif?>							
							<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
								<a class="forgot_password" rel="nofollow" href="<?=$arParams["AUTH_FORGOT_PASSWORD_URL"] ? $arParams["AUTH_FORGOT_PASSWORD_URL"] : $arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
							<?endif?>							
						</div>
					</div>
					<div class="col-sm-24 col-md-8">
						
					</div>
				</div>
			</div>
			<div class="wrap_block">
				<div class="row">
					<div class="col-sm-7 col-md-6 col-lg-5 sm-padding-right-no">
						<div class="wrap_btn">
							<input type="submit" name="Login" class="login_btn" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
						</div>
					</div>
				</div>
			</div>
		</div><!--end wrap_login_page-->
	</form>
		</div>  <?/*end login_page*/?>
	</div>  <?/*end col-sm-19 sm-padding-right-no*/?>
</div>  <?/*end row*/?>

<script type="text/javascript">
<?if (strlen($arResult["LAST_LOGIN"])>0):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script>


<?if ($script_name ==SITE_DIR."personal/order/make/index.php" || $script_name == SITE_DIR."personal/index.php" || $script_name == SITE_DIR."personal/profile/index.php" || $script_name == SITE_DIR."personal/subscribe/index.php" || $script_name == SITE_DIR."personal/order/index.php"):?>
</div>
<?endif;?>