<?
use Bitrix\Main\Loader;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if(!Loader::includeModule('kit.b2bshop'))
{
	return false;
}
$menu = new \Kit\B2BShop\Client\Personal\Menu();
?>
<div class="col-sm-19 sm-padding-right-no blank_right-side <?= (!$menu->isOpen()) ? 'blank_right-side_full' : '' ?>"
	 id="blank_right_side">
	<div id="wrapper_blank_resizer" class="wrapper_blank_resizer">
		<div class="blank_resizer">
			<div class="blank_resizer_tool <?= (!$menu->isOpen()) ? 'blank_resizer_tool_open' : '' ?>"></div>
		</div>
		<div class="personal-right-content">
			<?
			$APPLICATION->IncludeComponent(
				"bitrix:support.ticket.edit",
				"",
				[
					"ID" => $arResult["VARIABLES"]["ID"],
					"TICKET_LIST_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["ticket_list"],
					"TICKET_EDIT_TEMPLATE" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["ticket_edit"],
					"MESSAGES_PER_PAGE" => $arParams["MESSAGES_PER_PAGE"],
					"MESSAGE_SORT_ORDER" => $arParams["MESSAGE_SORT_ORDER"],
					"MESSAGE_MAX_LENGTH" => $arParams["MESSAGE_MAX_LENGTH"],
					"SET_PAGE_TITLE" => $arParams["SET_PAGE_TITLE"],
					'SHOW_COUPON_FIELD' => $arParams['SHOW_COUPON_FIELD'],
					"SET_SHOW_USER_FIELD" => $arParams["SET_SHOW_USER_FIELD"],
				],
				false,
				['HIDE_ICONS' => 'Y']
			);
			?>
		</div>
	</div>
</div>
