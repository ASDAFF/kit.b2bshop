<?

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if(!Loader::includeModule('kit.b2bshop'))
{
	return false;
}

Loc::loadMessages(__FILE__);

$menu = new \Kit\B2BShop\Client\Personal\Menu();

$filter = [];
$filterOption = new Bitrix\Main\UI\Filter\Options('TICKET_LIST');
$filterData = $filterOption->getFilter([]);


unset($_SESSION['main.interface.grid']);
foreach ($filterData as $key => $value)
{
	if(in_array($key, [
		'ID',
		'MESSAGE',
		'CLOSE',
		'LAMP'
	]))
		$_REQUEST[$key] = $value;
}

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
				"bitrix:support.ticket.list",
				"",
				[
					"TICKET_EDIT_TEMPLATE" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["ticket_edit"],
					"TICKETS_PER_PAGE" => $arParams["TICKETS_PER_PAGE"],
					"SET_PAGE_TITLE" => $arParams["SET_PAGE_TITLE"],
					"TICKET_ID_VARIABLE" => $arResult["ALIASES"]["ID"],
					"SITE_ID" => $arParams["SITE_ID"],
					"SET_SHOW_USER_FIELD" => $arParams["SET_SHOW_USER_FIELD"],
					"AJAX_ID" => $arParams["AJAX_ID"]
				],
				$component,
				['HIDE_ICONS' => 'Y']
			);
			$APPLICATION->SetTitle(Loc::getMessage('TITLE'),false);
			?>
		</div>
	</div>
</div>