<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<h3 class="modal-title"><?=GetMessage("AUTH_TITLE")?></h3>
<div class="login-form">
	<?/*                                           
	ShowMessage($arParams["~AUTH_RESULT"]);
	ShowMessage($arResult['ERROR_MESSAGE']);
	*/?>
	<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arParams["REGISTER_URL"]?>" class="bx_auth_form">
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
		<?if (strlen($arParams["BACKURL"]) > 0 || strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?=($arParams["BACKURL"] ? $arParams["BACKURL"] : $arResult["BACKURL"])?>" />
		<?endif?>
		<?foreach ($arResult["POST"] as $key => $value):?>
            <?if($key != "form_url" && $key != "register_url" && $key != "forgot_password"):?>
		        <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
            <?endif;?>
		<?endforeach?>

        <div class="wrap-label">
            <label><?=GetMessage("AUTH_EMAIL")?></label>
            <?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
                <a rel="nofollow" href="<?=$arParams["FORGOT_PASSWORD_URL"] ? $arParams["FORGOT_PASSWORD_URL"] : $arResult["FORGOT_PASSWORD_URL"]?>"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
            <?endif?>            
        </div>
        <div>
            <input class="input_txt" type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" />
        </div>
        <div class="wrap-label">
            <label><?=GetMessage("AUTH_PASSWORD")?></label>
        </div>
        <div>
            <input class="input_txt" type="password" maxlength="50" name="USER_PASSWORD">
        </div>
        <?if ($arResult["STORE_PASSWORD"] == "Y"):?>
            <div class="rememberme">
                <input id="USER_REMEMBER" type="checkbox" checked value="Y" name="USER_REMEMBER">
                <label class="label-active" for="USER_REMEMBER"><?=GetMessage("AUTH_REMEMBER_ME")?></label>
            </div>
        <?endif?>        

        <div class="wrap-login">
            <div class="login-btn-wpar">
                <input class="login_send" type="submit" name="Login"  value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
            </div>
            
            <div class="social">
                <?if($arResult["AUTH_SERVICES"]):
                    $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "ms_modal_def",
                        array(
                            "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                            "CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
                            "AUTH_URL"=> ($arParams["BACKURL"] ? $arParams["BACKURL"] : $arResult["BACKURL"]),
                            "POST"=>$arResult["POST"],
                            "SUFFIX" => "main",
                        ),
                        $component,
                        array("HIDE_ICONS"=>"Y")
                    );
                endif;?>
                
            </div>
        </div>
	</form>
</div>