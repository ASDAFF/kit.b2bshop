<?
use Bitrix\Main\Config\Option;
require ($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

?>
<div class="main_inner_title">
	<h1 class="text">Регистрация нового пользователя</h1>
</div>
<?
$APPLICATION->IncludeComponent( "sotbit:sotbit.auth.wholesaler.register", "opt",
	Array(
		"AUTH" => "Y",
		'AUTH_URL' => $arResult["AUTH_AUTH_URL"],
		"REQUIRED_FIELDS" => array(
			"EMAIL"
		),
		"REQUIRED_WHOLESALER_FIELDS" => array(
			"EMAIL"
		),
		"SET_TITLE" => "Y",
		"SHOW_FIELDS" => array(
			"NAME",
			'LAST_NAME'
		),
		"SHOW_WHOLESALER_FIELDS" => unserialize( Option::get( 'sotbit.b2bshop', 'OPT_REGISTER_FIELDS', '' ) ),
		"SHOW_WHOLESALER_ORDER_FIELDS" => unserialize( Option::get( 'sotbit.b2bshop', 'OPT_REGISTER_ORDER_FIELDS', '' ) ),
		"SUCCESS_PAGE" => "/",
		"USER_PROPERTY" => Array(
			'UF_CONFIDENTIAL'
		),
		"USER_PROPERTY_NAME" => "",
		"USE_BACKURL" => "Y",
		"VARIABLE_ALIASES" => Array()
	) );
require ($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>