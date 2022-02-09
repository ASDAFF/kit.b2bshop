<?
use Bitrix\Main\Loader;

$aMenuLinks = Array(
	Array(
		"Корзина", 
		"/personal/cart/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"История заказов", 
		"/personal/order/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Wish List", 
		Bitrix\Main\Config\Option::get("sotbit.b2bshop", "URL_CART",'/personal/cart/'), 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Подписки", 
		"/personal/subscribe/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Изменить профиль", 
		"/personal/profile/", 
		Array(), 
		Array(), 
		"" 
	),
);
if(Loader::includeModule('sotbit.b2bshop') && Loader::includeModule('support'))
{
	$aMenuLinks[] = Array(
		"Техническая поддержка",
		"/personal/support/",
		Array(),
		Array(),
		""
	);
}
?>