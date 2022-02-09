<?
use Bitrix\Main\Web\Json;
if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true )
	die();
if( !$GLOBALS['USER']->IsAuthorized() )
{
	$arParamsToDelete = array(
			"login",
			"logout",
			"register",
			"forgot_password",
			"change_password",
			"confirm_registration",
			"confirm_code",
			"confirm_user_id" 
	);
	
	$arResult['AUTH_URL'] = $arParams["REGISTER_URL"] . (strpos( $arParams["REGISTER_URL"], "?" ) !== false ? "&" : "?") . "backurl=" . urlencode( 
			$APPLICATION->GetCurPageParam( "", array_merge( $arParamsToDelete, array(
					"backurl" 
			) ), $get_index_page = false ) );
	
	$arResult["AUTH_AJAX_LOGIN_URL"] = SITE_DIR . "include/ajax/auth_form_ajax.php";
	$context = \Bitrix\Main\Application::getInstance()->getContext();
	$request = $context->getRequest();
	$arResult['AUTH_AJAX_PARAMS'] = array(
			'backurl' => $request->getRequestUri(),
			'register_url' => $arParams["REGISTER_URL"],
			'forgot_password' => $arParams["FORGOT_PASSWORD_URL"],
			'open_login' => 'yes'
	);
	$arResult['AUTH_AJAX_PARAMS'] = htmlentities(Json::encode($arResult['AUTH_AJAX_PARAMS']));
	unset( $context );
	unset( $request );
}
?>