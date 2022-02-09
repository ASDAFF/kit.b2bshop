<?use Bitrix\Main\Web\Json;
define("NOT_CHECK_PERMISSIONS", true);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->ShowAjaxHead();
//$data= Json::decode($data);
$data = json_decode($data, true);
if($data['open_login'] == 'yes' || $_REQUEST['auth_service_id'])
{
	$APPLICATION->IncludeComponent("bitrix:system.auth.form", "miss_login_enter_modal", Array(
		"REGISTER_URL" => $data["register_url"],
		"FORGOT_PASSWORD_URL" => $data["forgot_password"],
		"BACKURL" => $data["backurl"],
		"SHOW_ERRORS" => "N"
	),
		false
	);
}
else
{
	LocalRedirect(SITE_DIR);
}