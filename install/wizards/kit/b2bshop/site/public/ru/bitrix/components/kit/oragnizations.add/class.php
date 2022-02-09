<?php

/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage sale
 * @copyright 2001-2016 Bitrix
 */

use Bitrix\Main;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale;
use Kit\Auth\Internals\BuyerConfirmTable;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class OnrganizationsAdd extends CBitrixComponent
{
	const E_SALE_MODULE_NOT_INSTALLED = 10000;

	protected $accessPersonTypes = [];

	/** @var  Main\ErrorCollection $errorCollection */
	protected $errorCollection;

	protected $showMessage = false;

	/**
	 * Function checks and prepares all the parameters passed. Everything about $arParam modification is here.
	 * @param $params        Parameters of component.
	 * @return array        Checked and valid parameters.
	 */
	public function onPrepareComponentParams($params)
	{
		$this->errorCollection = new Main\ErrorCollection();

		return $params;
	}

	public function executeComponent()
	{
		global $USER, $APPLICATION;

		Loc::loadMessages(__FILE__);

		$this->setFrameMode(false);

		$this->checkRequiredModules();

		if(!$USER->IsAuthorized())
		{
			$APPLICATION->AuthForm(Loc::getMessage("SALE_ACCESS_DENIED"), false, false, 'N', false);
		}

		$request = Main\Application::getInstance()->getContext()->getRequest();

		if($this->arParams["SET_TITLE"] === 'Y')
		{
			$APPLICATION->SetTitle(Loc::getMessage("SPPD_TITLE") . $this->idProfile);
		}

		if(!$request->get('add'))
		{
			LocalRedirect($this->arParams["PATH_TO_LIST"]);
		}


		$this->setAccessPersonTypes();

		if(count($this->accessPersonTypes) <= 0)
		{
			$this->errorCollection->setError(new Main\Error(Loc::getMessage("ORG_NO_TYPES")));
		}

		$idPersonType = reset($this->accessPersonTypes);


		if($request->isPost() && ($request->get("change_person_type")) && check_bitrix_sessid())
		{
			if(in_array($request->get('PERSON_TYPE'), $this->accessPersonTypes))
			{
				$idPersonType = $request->get('PERSON_TYPE');
			}
		}

		if($request->isPost() && ($request->get("save") || $request->get("apply")) && check_bitrix_sessid())
		{
			$this->addProfileProperties($request, $userOrderProperties);
		}

		$this->fillResultArray($idPersonType, $request);

		$this->formatResultErrors();

		$this->includeComponentTemplate();
	}

	protected function setAccessPersonTypes()
	{
		$this->accessPersonTypes = [2];

		if(!is_array($this->accessPersonTypes))
		{
			$this->accessPersonTypes = [];
		}
	}

	/**
	 *
	 * @return array
	 */
	protected function getAccessPersonTypes()
	{
		return $this->accessPersonTypes;
	}

	/**
	 * Function checks if required modules installed. If not, throws an exception
	 * @throws Main\SystemException
	 * @return void
	 */
	protected function checkRequiredModules()
	{
		if(!Loader::includeModule('sale') || !Loader::includeModule('kit.b2bshop'))
		{
			throw new Main\SystemException(Loc::getMessage("SALE_MODULE_NOT_INSTALL"), self::E_SALE_MODULE_NOT_INSTALLED);
		}
	}


	/**
	 *
	 * @param  Main\HttpRequest $request
	 */
	protected function addProfileProperties($request)
	{
		$fieldValues = $this->prepareAddProperties($request);
		if($this->errorCollection->isEmpty())
		{
			$idProfile = $this->executeAddProperties($request, $fieldValues);
		}

		if($this->errorCollection->isEmpty() && $idProfile > 0)
		{
			if(strlen($request->get("save")) > 0)
			{
				//js because AJAX_MODE
				?>
				<script type="text/javascript">
					window.top.location.href = '<?=$this->arParams["PATH"]?>';
				</script>
				<?php
			}
			elseif(strlen($request->get("apply")) > 0)
			{
				//js because AJAX_MODE
				?>
				<script type="text/javascript">
					window.top.location.href = '<?=CComponentEngine::MakePathFromTemplate(
						$this->arParams["PATH"] . $this->arParams["PATH_TO_DETAIL"],
						[
							'ID' => $idProfile
						]
					)?>';
				</script>
				<?php
			}
		}
		elseif($this->showMessage)
		{
			?>
			<script type="text/javascript">
				window.top.location.href = '<?=CComponentEngine::MakePathFromTemplate(
					$this->arParams["PATH"] . '?add=Y&confirm=Y',
					[

					]
				)?>';
			</script>
			<?php
		}
	}

	/**
	 *
	 * @param  Main\HttpRequest $request
	 * @return array
	 */
	protected function prepareAddProperties($request)
	{
		if(strlen($request->get("NAME")) <= 0)
		{
			$this->errorCollection->setError(new Main\Error(Loc::getMessage("SALE_NO_INN") . "<br>"));
		}

		if(!$request->get('PERSON_TYPE') || !in_array($request->get('PERSON_TYPE'), $this->accessPersonTypes))
		{
			$this->errorCollection->setError(new Main\Error(Loc::getMessage("SALE_NO_PERSON_TYPE") . "<br>"));
		}

		$fieldValues = [];
		$orderPropertiesList = CSaleOrderProps::GetList(
			[
				"SORT" => "ASC",
				"NAME" => "ASC"
			],
			[
				"PERSON_TYPE_ID" => $request->get('PERSON_TYPE'),
				"USER_PROPS" => "Y",
				"ACTIVE" => "Y",
				"UTIL" => "N"
			],
			false,
			false,
			[
				"ID",
				"NAME",
				"TYPE",
				"REQUIED",
				"MULTIPLE",
				"IS_LOCATION",
				"PROPS_GROUP_ID",
				"IS_EMAIL",
				"IS_PROFILE_NAME",
				"IS_PAYER",
				"IS_LOCATION4TAX",
				"CODE",
				"SORT"
			]
		);

		while ($orderProperty = $orderPropertiesList->GetNext())
		{
			$currentValue = $request->get("ORDER_PROP_" . $orderProperty["ID"]);

			if($this->checkProperty($orderProperty, $currentValue))
			{
				$fieldValues[$orderProperty["ID"]] = [
					"USER_PROPS_ID" => $this->idProfile,
					"ORDER_PROPS_ID" => $orderProperty["ID"],
					"NAME" => $orderProperty["NAME"],
					'MULTIPLE' => $orderProperty["MULTIPLE"]
				];

				if($orderProperty["TYPE"] === 'FILE')
				{
					$fileIdList = [];

					$currentValue = $request->getFile("ORDER_PROP_" . $orderProperty["ID"]);

					foreach ($currentValue['name'] as $key => $fileName)
					{
						if(strlen($fileName) > 0)
						{
							$fileArray = [
								'name' => $fileName,
								'type' => $currentValue['type'][$key],
								'tmp_name' => $currentValue['tmp_name'][$key],
								'error' => $currentValue['error'][$key],
								'size' => $currentValue['size'][$key],
							];

							$fileIdList[] = CFile::SaveFile($fileArray, "/sale/profile/");
						}
					}

					$fieldValues[$orderProperty["ID"]]['VALUE'] = $fileIdList;
				}
				elseif($orderProperty['TYPE'] == "MULTISELECT")
				{
					$fieldValues[$orderProperty["ID"]]['VALUE'] = implode(',', $currentValue);
				}
				else
				{
					$fieldValues[$orderProperty["ID"]]['VALUE'] = $currentValue;
				}
			}
			else
			{
				$this->errorCollection->setError(new Main\Error(Loc::getMessage("SALE_NO_FIELD") . " \"" . $orderProperty["NAME"] . "\".<br />"));
			}
		}

		return $fieldValues;
	}


	/**
	 * @param Main\HttpRequest $request
	 * @param array $fieldValues
	 * @return void
	 */
	protected function executeAddProperties(
		$request,
		$fieldValues
	)
	{
		$idProfile = 0;
		global $USER;
		$idUser = $USER->GetID();
		if(!$idUser)
		{
			$this->errorCollection->setError(new Main\Error(Loc::getMessage("SALE_NO_USER") . "<br />"));
		}
		if($this->errorCollection->isEmpty())
		{
			if(Loader::includeModule('kit.auth') && Option::get('kit.auth', 'CONFIRM_BUYER', 'N', SITE_ID) == 'Y')
			{
				$fields = [
					'PERSON_TYPE' => $request->get('PERSON_TYPE'),
					'ORDER_FIELDS' => []
				];

				$orderPropertiesList = \CSaleOrderProps::GetList(
					[
						"SORT" => "ASC",
						"NAME" => "ASC"
					],
					[
						"PERSON_TYPE_ID" => $request->get('PERSON_TYPE'),
						"USER_PROPS" => "Y",
						"ACTIVE" => "Y",
						"UTIL" => "N"
					],
					false,
					false,
					[
						"ID",
						"NAME",
						"TYPE",
						"REQUIED",
						"MULTIPLE",
						"IS_LOCATION",
						"PROPS_GROUP_ID",
						"IS_EMAIL",
						"IS_PROFILE_NAME",
						"IS_PAYER",
						"IS_LOCATION4TAX",
						"CODE",
						"SORT"
					]
				);

				while ($orderProperty = $orderPropertiesList->GetNext())
				{
					$fields['ORDER_FIELDS'][$orderProperty['CODE']] = $request->get('ORDER_PROP_' . $orderProperty['ID']);
				}

				$innCode = Option::get('kit.auth', 'GROUP_ORDER_INN_FIELD_' . $request->get('PERSON_TYPE'), 'INN',
					SITE_ID);

				$user = Main\UserTable::getList([
					'filter' => [
						'ID' => $idUser
					],
					'limit' => 1,
					'select' => ['EMAIL']

				])->fetch();

				BuyerConfirmTable::add([
					'LID' => SITE_ID,
					'FIELDS' => $fields,
					'EMAIL' => $user['EMAIL'],
					'ID_USER' => $idUser,
					'INN' => $fields['ORDER_FIELDS'][$innCode]
				]);

				$this->showMessage = true;
			}
			else
			{
				$saleProps = new \CSaleOrderUserProps;
				$idProfile = $saleProps->Add(
					[
						'NAME' => trim($request->get("NAME")),
						'USER_ID' => $idUser,
						'PERSON_TYPE_ID' => $request->get('PERSON_TYPE')
					]
				);

				if(!$idProfile)
				{
					$this->errorCollection->setError(new Main\Error(Loc::getMessage("SALE_ERROR_ADD_PROF") . "<br />"));

					return;
				}
				$updatedValues = [];
				$saleOrderUserPropertiesValue = new CSaleOrderUserPropsValue;

				$orderPropertiesList = \CSaleOrderProps::GetList(
					[
						"SORT" => "ASC",
						"NAME" => "ASC"
					],
					[
						"PERSON_TYPE_ID" => $request->get('PERSON_TYPE'),
						"USER_PROPS" => "Y",
						"ACTIVE" => "Y",
						"UTIL" => "N"
					],
					false,
					false,
					[
						"ID",
						"NAME",
						"TYPE",
						"REQUIED",
						"MULTIPLE",
						"IS_LOCATION",
						"PROPS_GROUP_ID",
						"IS_EMAIL",
						"IS_PROFILE_NAME",
						"IS_PAYER",
						"IS_LOCATION4TAX",
						"CODE",
						"SORT"
					]
				);

				while ($orderProperty = $orderPropertiesList->GetNext())
				{
					$saleOrderUserPropertiesValue->Add(
						[
							'USER_PROPS_ID' => $idProfile,
							'ORDER_PROPS_ID' => $orderProperty['ID'],
							'NAME' => $orderProperty['NAME'],
							'VALUE' => $request->get('ORDER_PROP_' . $orderProperty['ID'])
						]
					);
				}

				return $idProfile;
			}
		}
	}

	/**
	 * Fill $arResult array for output in template
	 * @param int $idPersonType
	 * @param Main\HttpRequest $request
	 */
	protected function fillResultArray(
		$idPersonType,
		$request
	)
	{
		$this->arResult["ORDER_PROPS"] = [];
		$this->arResult["ORDER_PROPS_VALUES"] = [];

		if($request->get('NAME'))
		{
			$this->arResult['NAME'] = $request->get('NAME');
		}

		$rsPersonTypes = \Bitrix\Sale\Internals\PersonTypeTable::getList(
			[
				'filter' => [
					'LID' => SITE_ID,
					'ID' => $this->accessPersonTypes
				]

			]
		);
		while ($personType = $rsPersonTypes->fetch())
		{
			$this->arResult['PERSON_TYPES'][$personType['ID']] = $personType['NAME'];
		}


		$personType = Sale\PersonType::load(SITE_ID, $idPersonType);


		$this->arResult["PERSON_TYPE"] = $personType[$idPersonType];
		$this->arResult["PERSON_TYPE"]["NAME"] = htmlspecialcharsbx($this->arResult["PERSON_TYPE"]["NAME"]);

		$locationValue = [];

		if($this->arParams['COMPATIBLE_LOCATION_MODE'] == 'Y')
		{
			$locationDb = CSaleLocation::GetList(
				[
					"SORT" => "ASC",
					"COUNTRY_NAME_LANG" => "ASC",
					"CITY_NAME_LANG" => "ASC"
				],
				[],
				LANGUAGE_ID
			);
			while ($location = $locationDb->Fetch())
			{
				$locationValue[] = $location;
			}
		}

		$arrayTmp = [];

		$orderPropertiesListGroup = CSaleOrderPropsGroup::GetList(
			[
				"SORT" => "ASC",
				"NAME" => "ASC"
			],
			["PERSON_TYPE_ID" => $idPersonType],
			false,
			false,
			[
				"ID",
				"PERSON_TYPE_ID",
				"NAME",
				"SORT"
			]
		);
		while ($orderPropertyGroup = $orderPropertiesListGroup->GetNext())
		{
			$arrayTmp[$orderPropertyGroup["ID"]] = $orderPropertyGroup;
			$orderPropertiesList = CSaleOrderProps::GetList(
				[
					"SORT" => "ASC",
					"NAME" => "ASC"
				],
				[
					"PERSON_TYPE_ID" => $idPersonType,
					"PROPS_GROUP_ID" => $orderPropertyGroup["ID"],
					"USER_PROPS" => "Y",
					"ACTIVE" => "Y",
					"UTIL" => "N"
				],
				false,
				false,
				[
					"ID",
					"PERSON_TYPE_ID",
					"NAME",
					"TYPE",
					"REQUIED",
					"DEFAULT_VALUE",
					"SORT",
					"USER_PROPS",
					"IS_LOCATION",
					"PROPS_GROUP_ID",
					"SIZE1",
					"SIZE2",
					"DESCRIPTION",
					"IS_EMAIL",
					"IS_PROFILE_NAME",
					"IS_PAYER",
					"IS_LOCATION4TAX",
					"CODE",
					"SORT",
					"MULTIPLE"
				]
			);
			while ($orderProperty = $orderPropertiesList->GetNext())
			{
				if($orderProperty["REQUIED"] == "Y" || $orderProperty["IS_EMAIL"] == "Y" || $orderProperty["IS_PROFILE_NAME"] == "Y" || $orderProperty["IS_LOCATION"] == "Y" || $orderProperty["IS_PAYER"] == "Y")
					$orderProperty["REQUIED"] = "Y";
				if(in_array($orderProperty["TYPE"], [
					"SELECT",
					"MULTISELECT",
					"RADIO"
				]))
				{
					$dbVars = CSaleOrderPropsVariant::GetList(($by = "SORT"), ($order = "ASC"), ["ORDER_PROPS_ID" => $orderProperty["ID"]]);
					while ($vars = $dbVars->GetNext())
						$orderProperty["VALUES"][] = $vars;
				}
				elseif($orderProperty["TYPE"] == "LOCATION" && $this->arParams['COMPATIBLE_LOCATION_MODE'] == 'Y')
				{
					$orderProperty["VALUES"] = $locationValue;
				}
				if($request->get('ORDER_PROP_' . $orderProperty['ID']))
				{
					$this->arResult["ORDER_PROPS_VALUES"]['ORDER_PROP_' . $orderProperty['ID']] = $request->get('ORDER_PROP_' . $orderProperty['ID']);
				}
				$arrayTmp[$orderPropertyGroup["ID"]]["PROPS"][] = $orderProperty;
			}

			$this->arResult["ORDER_PROPS"] = $arrayTmp;
		}
	}

	/**
	 * Move all errors to $this->arResult, if there were any
	 * @return void
	 */
	protected function formatResultErrors()
	{
		if(!$this->errorCollection->isEmpty())
		{
			/** @var Main\Error $error */
			foreach ($this->errorCollection->toArray() as $error)
			{
				$this->arResult['ERROR_MESSAGE'] .= $error->getMessage();
			}
		}
	}

	/**
	 * Check value required params of property
	 * @param $property
	 * @param $currentValue
	 * @return bool
	 */
	protected function checkProperty(
		$property,
		$currentValue
	)
	{
		if($property["TYPE"] == "LOCATION" && $property["IS_LOCATION"] == "Y")
		{
			if((int)($currentValue) <= 0)
				return false;
		}
		elseif($property["IS_PROFILE_NAME"] == "Y")
		{
			if(strlen(trim($currentValue)) <= 0)
				return false;
		}
		elseif($property["IS_PAYER"] == "Y")
		{
			if(strlen(trim($currentValue)) <= 0)
				return false;
		}
		elseif($property["IS_EMAIL"] == "Y")
		{
			if(strlen(trim($currentValue)) <= 0 || !check_email(trim($currentValue)))
				return false;
		}
		elseif($property["REQUIED"] == "Y")
		{
			if($property["TYPE"] == "LOCATION")
			{
				if((int)($currentValue) <= 0)
					return false;
			}
			elseif($property["TYPE"] == "MULTISELECT")
			{
				if(!is_array($currentValue) || count($currentValue) <= 0)
					return false;
			}
			else
			{
				if(strlen($currentValue) <= 0)
					return false;
			}
		}

		return true;
	}
}