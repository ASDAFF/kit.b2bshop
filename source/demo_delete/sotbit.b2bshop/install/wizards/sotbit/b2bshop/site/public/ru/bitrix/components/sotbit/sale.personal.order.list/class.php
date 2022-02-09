<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CBitrixComponent::includeComponentClass("bitrix:sale.personal.order.list");
class CSotbitPersonalOrderListComponent extends CBitrixPersonalOrderListComponent
{
	protected function prepareFilter()
	{
		global $USER;
		global $DB;

		$arFilter = array();
		$arFilter["USER_ID"] = $USER->GetID();
		$arFilter["LID"] = SITE_ID;

		if ($_REQUEST["filter_id"])
		{
			if ($this->options['USE_ACCOUNT_NUMBER'])
				$arFilter["ACCOUNT_NUMBER"] = $_REQUEST["filter_id"];
			else
				$arFilter["ID"] = $_REQUEST["filter_id"];
		}

		if (strlen($_REQUEST["filter_date_from"]))
		{
			$arFilter[">=DATE_INSERT"] = trim($_REQUEST["filter_date_from"]);
		}

		if (strlen($_REQUEST["filter_date_to"]))
		{
			$arFilter["<=DATE_INSERT"] = trim($_REQUEST["filter_date_to"]);

			if ($arDate = ParseDateTime(trim($_REQUEST["filter_date_to"]), $this->dateFormat))
			{
				if (strlen(trim($_REQUEST["filter_date_to"])) < 11)
				{
					$arDate["HH"] = 23;
					$arDate["MI"] = 59;
					$arDate["SS"] = 59;
				}

				$arFilter["<=DATE_INSERT"] = date($DB->DateFormatToPHP($this->dateFormat), mktime($arDate["HH"], $arDate["MI"], $arDate["SS"], $arDate["MM"], $arDate["DD"], $arDate["YYYY"]));
			}
		}

		if (strlen($_REQUEST["filter_status"]))
			$arFilter["STATUS_ID"] = trim($_REQUEST["filter_status"]);

		if (strlen($_REQUEST["filter_payed"]))
			$arFilter["PAYED"] = trim($_REQUEST["filter_payed"]);

		if (!isset($_REQUEST['show_all']) || $_REQUEST['show_all'] == 'N')
		{
			if (isset($_REQUEST["filter_history"]) && $_REQUEST["filter_history"] == "Y")
			{
				if ($_REQUEST["show_canceled"] == "Y")
				{
					$arFilter['CANCELED'] = 'Y';
				}
				else
				{
					$arFilter[] = array(
						'@STATUS_ID' => $this->arParams['HISTORIC_STATUSES']
					);
				}
			}
			else
			{
				$arFilter[] = array(
					'!@STATUS_ID' => $this->arParams['HISTORIC_STATUSES'],
					'CANCELED' => 'N'
				);
			}
		}

		if (strlen($_REQUEST["filter_canceled"]))
			$arFilter["CANCELED"] = trim($_REQUEST["filter_canceled"]);

		$this->filter = $arFilter;
	}
}
?>