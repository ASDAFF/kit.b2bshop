<?
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
require ($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle( 'Заказы' );
Loc::loadMessages( __FILE__ );


if(!$USER->IsAuthorized())
{
	?>
	<div class="personal_block_title personal_block_title_documents">
		<h1 class="text">
			<?$APPLICATION->ShowTitle(false); ?>
		</h1>
	</div>
	<?php
	$APPLICATION->AuthForm('', false, false, 'N', false);
}
else
{
?>

<div class="personal_block_title personal_block_title_documents">
	<h1 class="text"><?$APPLICATION->ShowTitle(false);?></h1>
</div>

<?php
if(!Loader::includeModule('sotbit.b2bshop'))
{
	return false;
}
$opt = new \Sotbit\B2BShop\Client\Shop\Opt();
$menu = new \Sotbit\B2BShop\Client\Personal\Menu();
?>
<div class="personal-wrapper personal-documents-wrapper personal-comments-wrapper-fiz <?=($opt->hasAccess())?'personal-wrapper-access':''?>">
	<?php
	$Template = new \Sotbit\B2BShop\Client\Template\Main();
	$Template->includeBlock('template/personal/tabs.php');
	?>
	<div class="row border-profile border-profile-documents border-profile-documents-fiz">
		<?
		$Template->includeBlock('template/personal/leftblock.php');
		?>

		<div class="col-sm-19 sm-padding-right-no blank_right-side <?= (!$menu->isOpen()) ? 'blank_right-side_full' : '' ?>" id="blank_right_side">
			<div id="wrapper_blank_resizer" class="wrapper_blank_resizer">
				<div class="blank_resizer">
					<div class="blank_resizer_tool <?= (!$menu->isOpen()) ? 'blank_resizer_tool_open':''?>" ></div>
				</div>
				<div class="personal-right-content">

<?php
if( Option::get( 'sotbit.b2bshop', 'ORDER_ORDERPHONE', 'Y' ) == 'Y' )
{
	$APPLICATION->IncludeComponent( 'sotbit:order.phone', 'basket',
			array(
					'DELIVERY_ID' => Option::get( 'sotbit.b2bshop', 'TEL_DELIVERY_ID', '' ),
					'LOCAL_REDIRECT' => '/personal/order/success/',
					'OFFERS_PROPS' => unserialize( Option::get( 'sotbit.b2bshop', 'OFFER_TREE_PROPS', '' ) ),
					'ORDER_ID' => 'ORDER_ID',
					'ORDER_PROPS' => array(),
					'ORDER_TEL_PROP' => '3',
					'PAY_SYSTEM_ID' => Option::get( 'sotbit.b2bshop', 'TEL_PAY_SYSTEM_ID', '' ),
					'PERSON_TYPE' => '1',
					'PRODUCT_ID' => '',
					'PRODUCT_PROPS' => '',
					'PRODUCT_PROPS_VALUE' => '',
					'SELECT_USER' => 'new',
					'SEND_EVENT' => 'Y',
					'STATUS_ORDER' => 'N',
					'SUBMIT_VALUE' => 'Отправить заказ',
					'SUCCESS_TEXT' => 'Ваш заказ оформлен',
					'TEL_MASK' => Option::get( 'sotbit.b2bshop', 'TEL_MASK', '+7(999)999-99-99' ),
					'TEXT_BOTTOM' => Loc::getMessage( 'MS_PHONE_TEXT_BOTTOM' ),
					'TEXT_TOP' => 'Введите Ваш телефон',
					'USER_GROUP' => '0'
			), false );
}




if( Option::get( 'sotbit.b2bshop', 'CART_IN_ORDER', '' ) == 'Y' )
{
	$APPLICATION->IncludeComponent( 'bitrix:sale.basket.basket', (Loader::includeModule('sotbit.b2bshop')?'b2b_basket_order':'ms_basket_order'),
			array(
					'ACTION_VARIABLE' => 'action',
					'AJAX_MODE' => 'Y',
					'AJAX_OPTION_HISTORY' => 'N',
					'AJAX_OPTION_JUMP' => 'N',
					'COLUMNS_LIST' => array(
							0 => 'NAME',
							1 => 'DISCOUNT',
							2 => 'WEIGHT',
							3 => 'DELETE',
							4 => 'DELAY',
							5 => 'TYPE',
							6 => 'PRICE',
							7 => 'QUANTITY'
					),
					'COUNT_DISCOUNT_4_ALL_QUANTITY' => 'N',
					'GIFTS_BLOCK_TITLE' => '',
					'GIFTS_CONVERT_CURRENCY' => 'Y',
					'GIFTS_HIDE_BLOCK_TITLE' => 'N',
					'GIFTS_HIDE_NOT_AVAILABLE' => 'N',
					'GIFTS_MESS_BTN_BUY' => '',
					'GIFTS_MESS_BTN_DETAIL' => '',
					'GIFTS_PAGE_ELEMENT_COUNT' => '4',
					'GIFTS_PLACE' => 'BOTTOM',
					'GIFTS_PRODUCT_PROPS_VARIABLE' => 'prop',
					'GIFTS_PRODUCT_QUANTITY_VARIABLE' => '',
					'GIFTS_SHOW_DISCOUNT_PERCENT' => 'Y',
					'GIFTS_SHOW_IMAGE' => 'Y',
					'GIFTS_SHOW_NAME' => 'Y',
					'GIFTS_SHOW_OLD_PRICE' => 'Y',
					'GIFTS_TEXT_LABEL_GIFT' => '',
					'HIDE_COUPON' => 'N',
					'IBLOCK_ID' => Option::get( 'sotbit.b2bshop', 'IBLOCK_ID', '' ),
					'IBLOCK_TYPE' => Option::get( 'sotbit.b2bshop', 'IBLOCK_TYPE', '' ),
					'IMG_HEIGHT' => Option::get( 'sotbit.b2bshop', 'CART_IMG_HEIGHT', '' ),
					'IMG_WIDTH' => Option::get( 'sotbit.b2bshop', 'CART_IMG_WIDTH', '' ),
					'MANUFACTURER_ELEMENT_PROPS' => Option::get( 'sotbit.b2bshop', 'MANUFACTURER_ELEMENT_PROPS', '' ),
					'MANUFACTURER_LIST_PROPS' => Option::get( 'sotbit.b2bshop', 'MANUFACTURER_LIST_PROPS', '' ),
					'MORE_PHOTO_OFFER_PROPS' => Option::get( 'sotbit.b2bshop', 'MORE_PHOTO_OFFER_PROPS', '' ),
					'MORE_PHOTO_PRODUCT_PROPS' => Option::get( 'sotbit.b2bshop', 'MORE_PHOTO_PRODUCT_PROPS', '' ),
					'OFFERS_PROPS' => unserialize( Option::get( 'sotbit.b2bshop', 'OFFER_TREE_PROPS', '' ) ),
					'OFFER_COLOR_PROP' => Option::get( 'sotbit.b2bshop', 'OFFER_COLOR_PROP', '' ),
					'OFFER_TREE_PROPS' => unserialize( Option::get( 'sotbit.b2bshop', 'OFFER_TREE_PROPS', '' ) ),
					'PATH_TO_ORDER' => SITE_DIR.'personal/b2b/order/make/',
					'PICTURE_FROM_OFFER' => Option::get( 'sotbit.b2bshop', 'PICTURE_FROM_OFFER', '' ),
					'PRICE_VAT_SHOW_VALUE' => 'Y',
					'QUANTITY_FLOAT' => 'N',
					'SET_TITLE' => 'N',
					'USE_GIFTS' => 'Y',
					'USE_PREPAYMENT' => 'N',
					'SHOW_VAT_PRICE' => 'Y',
			), false );
}

$APPLICATION->IncludeComponent( 'bitrix:sale.order.ajax', 'b2b_order_ajax_personal',
		Array(
				'ALLOW_AUTO_REGISTER' => 'Y',
				'ALLOW_NEW_PROFILE' => 'Y',
				'BUYER_PERSONAL_TYPE' => unserialize( Option::get( 'sotbit.b2bshop', 'BUYER_PERSONAL_TYPE', 'a:0:{}' ) ),
				'COMPONENT_TEMPLATE' => 'ms_order_ajax',
				'COUNT_DELIVERY_TAX' => 'N',
				'COUNT_DISCOUNT_4_ALL_QUANTITY' => 'N',
				'DELIVERY2PAY_SYSTEM' => Array(),
				'DELIVERY_NO_AJAX' => 'Y',
				'DELIVERY_NO_SESSION' => 'N',
				'DELIVERY_TO_PAYSYSTEM' => 'd2p',
				'DISABLE_BASKET_REDIRECT' => 'N',
				'ONLY_FULL_PAY_FROM_ACCOUNT' => 'Y',
				'ORDER_ITEM_SHOW_COUNT' => Option::get( 'sotbit.b2bshop', 'ORDER_ITEM_SHOW_COUNT', '5' ),
				'PATH_TO_AUTH' => '/auth/',
				'PATH_TO_BASKET' => Option::get( 'sotbit.b2bshop', 'URL_CART', '' ),
				'PATH_TO_ORDER' => SITE_DIR.'personal/b2b/order/make/',
				'PATH_TO_PAYMENT' => Option::get( 'sotbit.b2bshop', 'URL_PAYMENT', '' ),
				'PATH_TO_PERSONAL' => Option::get( 'sotbit.b2bshop', 'URL_PERSONAL', '' ),
				'PAY_FROM_ACCOUNT' => 'Y',
				'PRODUCT_COLUMNS' => array(),
				'PROP_1' => array(),
				'SEND_NEW_USER_NOTIFY' => 'Y',
				'SET_TITLE' => 'Y',
				'SHOW_ACCOUNT_NUMBER' => 'Y',
				'SHOW_PAYMENT_SERVICES_NAMES' => 'Y',
				'SHOW_STORES_IMAGES' => 'N',
				'TEMPLATE_LOCATION' => 'popup',
				'USE_PREPAYMENT' => 'N'
				)
		);
?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}
require ($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>