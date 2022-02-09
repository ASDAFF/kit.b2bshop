<?
require ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle( "Вопросы пользователя" );

if(file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/components/sotbit/reviews.userquestions/component.php'))
{

$APPLICATION->IncludeComponent( "sotbit:reviews.userquestions", "bootstrap",
		Array(
				'ID_USER' => (isset( $user ) && $user > 0) ? $user : $USER->GetID(),
				"PRIMARY_COLOR" => "#a76e6e",
				'CACHE_TIME'=>"36000000",
				"DATE_FORMAT"=>"d F Y, H:i",
				"INIT_JQUERY" => "N"
		) );
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>