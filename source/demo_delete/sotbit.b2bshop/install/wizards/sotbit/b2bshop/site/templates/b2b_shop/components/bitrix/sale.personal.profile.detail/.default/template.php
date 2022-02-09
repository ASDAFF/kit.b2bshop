<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
?>
<div class="table_detail_organization">
	<div class="b2b_detail_order__second__tab b2b_detail_order__second__tab--absolute b2b_detail_organization__second__tab">
		<a href="<?= $arParams["PATH_TO_LIST"] ?>"
		   class="b2b_detail_order__second__tab__backlink b2b_detail_organization__second__tab__backlink">
			<?=Loc::getMessage("SPPD_RECORDS_LIST") ?>
		</a>
	</div>
	<div class="b2b_detail_order__second__tab b2b_detail_order__second__tab--absolute">
		<a href="<?=$arResult["URL_TO_LIST"] ?>" class="b2b_detail_order__second__tab__backlink">
			<?=Loc::getMessage('SPOD_GO_BACK') ?>
		</a>
		<div class="b2b_detail_order__second__tab__btn">
			<span class="b2b_detail_order__second__tab__btn__text">
				<?=Loc::getMessage('SPPD_SECOND_TAB_TITLE') ?>
			</span>
			<i class="fa fa-angle-down" aria-hidden="true"></i>
		</div>
		<div class="b2b_detail_order__second__tab__btn__block b2b_detail_order__second__tab__btn__block-hide">
			<a class="order_cancel" href="<?php echo $arResult['URL_TO_ADD'] ?>">
				<?php echo Loc::getMessage("SPPD_ADD") ?>
			</a>
			<a class="order_cancel" href="<?php echo $arResult['URL_TO_DELETE'] ?>">
				<?php echo Loc::getMessage("SPPD_DELETE") ?>
			</a>
		</div>
	</div>
	<div class="table_header">
		<div>
			<ul class="nav nav-tabs b2b_detail_order__nav_ul__block" role="tablist" id="b2b_detail_order__nav_ul">
				<li role="presentation" class="b2b_detail_order__nav_li active">
					<a href="#b2b_detail_organization__tab_block_1" aria-controls="b2b_detail_organization__tab_block_1"
					   role="tab" data-toggle="tab" class="b2b_detail_order__nav__link">
						<?= Loc::getMessage('PERSONAL_PROFILE_MAIN') ?>
					</a>
				</li>
				<li role="presentation" class="b2b_detail_order__nav_li">
					<a href="#b2b_detail_organization__tab_block_2" aria-controls="b2b_detail_organization__tab_block_2"
					   role="tab" data-toggle="tab" class="b2b_detail_order__nav__link">
						<?= Loc::getMessage('PERSONAL_PROFILE_DOC') ?>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="table_body">
		<div class="tab-content b2b_detail_organization__tab-content">
			<div role="tabpanel" class="tab-pane b2b_detail_organization__tab-pane active"
			     id="b2b_detail_organization__tab_block_1">
				<?
				if(strlen($arResult["ID"]) > 0)
				{
					ShowError($arResult["ERROR_MESSAGE"]);
					?>
					<form method="post" action="<?= POST_FORM_ACTION_URI ?>" enctype="multipart/form-data">
						<?= bitrix_sessid_post() ?>
						<input type="hidden" name="ID" value="<?= $arResult["ID"] ?>">
						<div class="b2b-detail-organization__type_block">
							<p class="b2b-detail-organization__type_block__text-wrap">
								<span class="b2b-detail-organization__type_block__text_title"><?= Loc::getMessage('SALE_PERS_TYPE') ?>
									:</span>
								<span class="b2b-detail-organization__type_block__text"><?= $arResult["PERSON_TYPE"]["NAME"] ?></span>
							</p>
							<p class="b2b-detail-organization__type_block__text-wrap">
								<span class="b2b-detail-organization__type_block__text_title"><?= Loc::getMessage('SALE_PNAME') ?>
									:</span>
								<span class="b2b-detail-organization__type_block__text"><?= htmlspecialcharsbx($arResult["NAME"]) ?></span>
							</p>
							<input type="hidden" name="NAME" id="NAME"
							       value="<?= htmlspecialcharsbx($arResult["NAME"]) ?>"/>
						</div>
						<div class="b2b-detail-order__flex-wrapper b2b-detail-organization__flex-wrapper">
							<div class="b2b-detail-organization___info_block">
								<?
								foreach ($arResult["ORDER_PROPS"] as $block)
								{
									if(!empty($block["PROPS"]))
									{
										?>
										<li class="b2b-detail-organization__block__li">
											<div class="b2b-detail-organization__block">
												<div class="b2b-detail-organization__block__title-wrap">
													<h3 class="b2b-detail-organization__block__title">
														<?= $block['NAME']; ?>
													</h3>
												</div>
												<div class="b2b-detail-organization__block__text-wrap">
													<? foreach ($block["PROPS"] as $key => $property)
													{
														if($property['CODE'] == 'EQ_POST')
														{
															continue;
														}
														$name = "ORDER_PROP_" . $property["ID"];
														$currentValue = $arResult["ORDER_PROPS_VALUES"][$name];
														$alignTop = ($property["TYPE"] === "LOCATION" && $arParams['USE_AJAX_LOCATIONS'] === 'Y') ? "vertical-align-top" : "";
														?>
														<div class="b2b-detail-organization__block__text">
															<div class="b2b-detail-organization__block__prop-wrap">
																<div class="b2b-detail-organization__block__prop__title-wrap">
																	<label class="b2b-detail-organization__block__prop__title">
																		<?php echo $property["NAME"];
																		if($property['REQUIED'] == 'Y')
																		{
																			?>
																			<span class="req">*</span>
																			<?php
																		} ?>
																	</label>
																</div>
																<div class="b2b-detail-organization__block__prop__text-wrap">
																	<? if($property["TYPE"] == 'TEXT')
																	{ ?>
																		<input class="b2b-detail-organization__block__prop__text"
																		       id="<?php echo $property['CODE']; ?>"
																		       type="text" name="<?= $name ?>"
																		       maxlength="50" value="<?= $currentValue ?>">
																	<? }
																	elseif($property["TYPE"] == "CHECKBOX")
																	{ ?>
																		<input
																				class="sale-personal-profile-detail-form-checkbox b2b-detail-organization__block__prop__text-checkbox"
																				id="sppd-property-<?= $key ?>"
																				type="checkbox"
																				name="<?= $name ?>"
																				value="Y"
																			<? if($currentValue == "Y" || !isset($currentValue) && $property["DEFAULT_VALUE"] == "Y") echo " checked"; ?>/>
																	<?
																	}
																	elseif($property["TYPE"] == "SELECT")
																	{ ?>
																		<select
																				class="form-control b2b-detail-organization__block__prop__text-select"
																				name="<?= $name ?>"
																				id="sppd-property-<?= $key ?>"
																				size="<? echo (intval($property["SIZE1"]) > 0) ? $property["SIZE1"] : 1; ?>">
																			<?
																			foreach ($property["VALUES"] as $value)
																			{
																				?>
																				<option value="<?= $value["VALUE"] ?>" <?
																				if($value["VALUE"] == $currentValue || !isset($currentValue) && $value["VALUE"] == $property["DEFAULT_VALUE"]) echo " selected" ?>>
																					<?= $value["NAME"] ?>
																				</option>
																				<?
																			}
																			?>
																		</select>
																	<?
																	}
																	elseif($property["TYPE"] == "MULTISELECT")
																	{ ?>
																		<select
																				class="form-control b2b-detail-organization__block__prop__text-multiselect"
																				id="sppd-property-<?= $key ?>"
																				multiple name="<?= $name ?>[]"
																				size="<? echo (intval($property["SIZE1"]) > 0) ? $property["SIZE1"] : 5; ?>">
																			<?
																			$arCurVal = array();
																			$arCurVal = explode(",", $currentValue);
																			for ($i = 0, $cnt = count($arCurVal); $i < $cnt; $i++)
																				$arCurVal[$i] = trim($arCurVal[$i]);
																			$arDefVal = explode(",", $property["DEFAULT_VALUE"]);
																			for ($i = 0, $cnt = count($arDefVal); $i < $cnt; $i++)
																				$arDefVal[$i] = trim($arDefVal[$i]);
																			foreach ($property["VALUES"] as $value)
																			{
																				?>
																				<option value="<?= $value["VALUE"] ?>"<?
																				if(in_array($value["VALUE"], $arCurVal) || !isset($currentValue) && in_array($value["VALUE"], $arDefVal)) echo " selected" ?>><?
																					echo $value["NAME"] ?></option>
																				<?
																			}
																			?>
																		</select>
																	<?
																	} elseif($property["TYPE"] == "TEXTAREA")
																	{ ?>
																		<textarea
																				class="form-control b2b-detail-organization__block__prop__text-textarea"
																				id="sppd-property-<?= $key ?>"
																				rows="<? echo ((int)($property["SIZE2"]) > 0) ? $property["SIZE2"] : 4; ?>"
																				cols="<? echo ((int)($property["SIZE1"]) > 0) ? $property["SIZE1"] : 40; ?>"
																				name="<?= $name ?>"><?= (isset($currentValue)) ? $currentValue : $property["DEFAULT_VALUE"]; ?>
																		</textarea>
																	<? }
																	elseif($property["TYPE"] == "LOCATION")
																	{
																		$locationTemplate = ($arParams['USE_AJAX_LOCATIONS'] !== 'Y') ? "popup" : "";

																		$locationValue = intval($currentValue) ? $currentValue : $property["DEFAULT_VALUE"];
																		CSaleLocation::proxySaleAjaxLocationsComponent(
																			array(
																				"AJAX_CALL" => "N",
																				'CITY_OUT_LOCATION' => 'Y',
																				'COUNTRY_INPUT_NAME' => $name . '_COUNTRY',
																				'CITY_INPUT_NAME' => $name,
																				'LOCATION_VALUE' => $locationValue,
																			),
																			array(),
																			$locationTemplate,
																			true,
																			'location-block-wrapper'
																		);

																	}
																	elseif($property["TYPE"] == "RADIO")
																	{
																		foreach ($property["VALUES"] as $value)
																		{
																			?>
																			<input
																					class="form-control b2b-detail-organization__block__prop__text-radio"
																					type="radio"
																					id="sppd-property-<?= $key ?>"
																					name="<?= $name ?>"
																					value="<?
																					echo $value["VALUE"] ?>"
																				<?
																				if($value["VALUE"] == $currentValue || !isset($currentValue) && $value["VALUE"] == $property["DEFAULT_VALUE"]) echo " checked" ?>>
																			<?= $value["NAME"] ?><br/>
																			<?
																		}
																	}
																	elseif($property["TYPE"] == "FILE")
																	{
																		$multiple = ($property["MULTIPLE"] === "Y") ? "multiple" : '';
																		?>
																		<label>
	                                                                            <span class="btn-themes btn-default btn-md btn">
	                                                                                <?= Loc::getMessage('SPPD_SELECT') ?>
	                                                                            </span>
																			<span class="sale-personal-profile-detail-load-file-info">
	                                                                                <?= Loc::getMessage('SPPD_FILE_NOT_SELECTED') ?>
	                                                                            </span>
																			<?= CFile::InputFile($name . "[]", 20, null, false, 0, "IMAGE", "class='btn sale-personal-profile-detail-input-file' " . $multiple) ?>
																		</label>
																		<span class="sale-personal-profile-detail-load-file-cancel sale-personal-profile-hide"></span>
																		<?
																		if(count($currentValue) > 0)
																		{
																			?>
																			<input type="hidden" name="<?= $name ?>_del"
																			       class="profile-property-input-delete-file">
																			<?
																			$profileFiles = unserialize(htmlspecialchars_decode($currentValue));
																			if(!is_array($profileFiles))
																			{
																				$profileFiles = array($profileFiles);
																			}
																			foreach ($profileFiles as $file)
																			{
																				?>
																				<div class="sale-personal-profile-detail-form-file">
																					<input type="checkbox"
																					       value="<?= $file ?>"
																					       class="profile-property-check-file"
																					       id="profile-property-check-file-<?= $file ?>">
																					<label for="profile-property-check-file-<?= $file ?>"><?= Loc::getMessage('SPPD_DELETE_FILE') ?></label>
																					<?
																					$fileInfo = CFile::GetByID($file);
																					$fileInfoArray = $fileInfo->Fetch();
																					if(CFile::IsImage($fileInfoArray['FILE_NAME']))
																					{
																						?>
																						<p>
																							<?= CFile::ShowImage($file, 150, 150, "border=0", "", true) ?>
																						</p>
																						<?
																					}
																					else
																					{
																						?>
																						<a download="<?= $fileInfoArray["ORIGINAL_NAME"] ?>"
																						   href="<?= CFile::GetFileSRC($fileInfoArray) ?>">
																							<?= Loc::getMessage('SPPD_DOWNLOAD_FILE', array("#FILE_NAME#" => $fileInfoArray["ORIGINAL_NAME"])) ?>
																						</a>
																						<?
																					}
																					?>
																				</div>
																				<?
																			}
																		}
																	} ?>

																</div>
															</div>
														</div>
													<? } ?>
												</div>
											</div>
										</li>
										<?
									}
								}
								?>
							</div>
						</div>
						<div class="b2b-detail-organization___btn_block">
							<input type="submit"
							       class="b2b-detail-organization__block__prop__btn_save b2b-detail-organization__block__prop__btn_black"
							       name="save" value="<? echo GetMessage("SALE_SAVE") ?>">
							<input type="submit"
							       class="b2b-detail-organization__block__prop__btn_apply b2b-detail-organization__block__prop__btn_black"
							       name="apply" value="<?= GetMessage("SALE_APPLY") ?>">
							<input type="submit" class="b2b-detail-organization__block__prop__btn_reset" name="reset"
							       value="<? echo GetMessage("SALE_RESET") ?>">
						</div>
					</form>
				<?
				}
				else
				{
					ShowError($arResult["ERROR_MESSAGE"]);
				}
				?>
			</div>
			<div role="tabpanel" class="tab-pane b2b_detail_organization__tab-pane"
			     id="b2b_detail_organization__tab_block_2">
				<div class="main-ui-filter-search-wrapper">
					<?
					$APPLICATION->IncludeComponent('bitrix:main.ui.filter', 'ms_personal_order', [
						'FILTER_ID' => 'DOCUMENTS_LIST',
						'GRID_ID' => 'DOCUMENTS_LIST',
						'FILTER' => [
							['id' => 'ID', 'name' => Loc::getMessage('DOC_ID'), 'type' => 'string'],
							['id' => 'NAME', 'name' => Loc::getMessage('DOC_NAME'), 'type' => 'string'],
							['id' => 'DATE_CREATE', 'name' => Loc::getMessage('DOC_DATE_CREATE'), 'type' => 'date'],
							['id' => 'DATE_UPDATE', 'name' => Loc::getMessage('DOC_DATE_UPDATE'), 'type' => 'date'],
						],
						'ENABLE_LIVE_SEARCH' => true,
						'ENABLE_LABEL' =>  true
					]);
					?>
				</div>
				<?
				$APPLICATION->IncludeComponent(
					'bitrix:main.ui.grid',
					'',
					array(
						'GRID_ID'   => 'DOCUMENTS_LIST',
						'HEADERS' => array(
							array("id"=>"ID", "name"=>Loc::getMessage('DOC_ID'), "sort"=>"ID", "default"=>true, "editable"=>false),
							array("id"=>"NAME", "name"=>Loc::getMessage('DOC_NAME'), "sort"=>"NAME", "default"=>true, "editable"=>false),
							array("id"=>"DATE_CREATE", "name"=>Loc::getMessage('DOC_DATE_CREATE'), "sort"=>"DATE_CREATE", "default"=>true, "editable"=>false),
							array("id"=>"DATE_UPDATE", "name"=>Loc::getMessage('DOC_DATE_UPDATE'), "sort"=>"DATE_UPDATE", "default"=>true, "editable"=>false),
							array("id"=>"ORDER", "name"=>Loc::getMessage('DOC_ORDER'),  "default"=>true, "editable"=>false),
						),
						'ROWS'      => $arResult['ROWS'],
						'AJAX_MODE'           => 'Y',

						"AJAX_OPTION_JUMP"    => "N",
						"AJAX_OPTION_STYLE"   => "N",
						"AJAX_OPTION_HISTORY" => "N",

						"ALLOW_COLUMNS_SORT"      => true,
						"ALLOW_ROWS_SORT"         => ['ID','NAME','DATE_CREATE','DATE_UPDATE'],
						"ALLOW_COLUMNS_RESIZE"    => true,
						"ALLOW_HORIZONTAL_SCROLL" => true,
						"ALLOW_SORT"              => true,
						"ALLOW_PIN_HEADER"        => true,
						"ACTION_PANEL"            => [],

						"SHOW_CHECK_ALL_CHECKBOXES" => false,
						"SHOW_ROW_CHECKBOXES"       => false,
						"SHOW_ROW_ACTIONS_MENU"     => true,
						"SHOW_GRID_SETTINGS_MENU"   => true,
						"SHOW_NAVIGATION_PANEL"     => true,
						"SHOW_PAGINATION"           => true,
						"SHOW_SELECTED_COUNTER"     => false,
						"SHOW_TOTAL_COUNTER"        => true,
						"SHOW_PAGESIZE"             => true,
						"SHOW_ACTION_PANEL"         => true,

						"ENABLE_COLLAPSIBLE_ROWS" => true,
						'ALLOW_SAVE_ROWS_STATE'=>true,

						"SHOW_MORE_BUTTON" => false,
						'~NAV_PARAMS'       => $arResult['GET_LIST_PARAMS']['NAV_PARAMS'],
						'NAV_OBJECT'       => $arResult['NAV_OBJECT'],
						'NAV_STRING'       => $arResult['NAV_STRING'],
						"TOTAL_ROWS_COUNT"  => count($arResult['ROWS']),
						"CURRENT_PAGE" => $arResult[ 'CURRENT_PAGE' ],
						"PAGE_SIZES" => $arParams['ORDERS_PER_PAGE'],
						"DEFAULT_PAGE_SIZE" => 50
					),
					$component,
					array('HIDE_ICONS' => 'Y')
				);
				?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#INN').on("change", function ()
	{
		var val = $(this).val();
		$('#NAME').val(val);
	});
	$('.b2b_detail_order__second__tab__btn').on('click', function ()
	{
		$('.b2b_detail_order__second__tab__btn__block').toggle();
	});
</script>