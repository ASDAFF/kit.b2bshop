<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отзывы пользователя");

if(file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/components/kit/reviews.userreviews/component.php'))
{
$APPLICATION->IncludeComponent(

		"kit:reviews.userreviews",
		"bootstrap",
		array(
				'MAX_RATING'=>"5",
				'ID_USER'=>(isset($user) && $user>0)?$user:$USER->GetID(),
				"PRIMARY_COLOR"=>"#a76e6e",
				'CACHE_TIME'=>"36000000",
				"DATE_FORMAT"=>"d F Y, H:i",
		),
		$component
		);
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>