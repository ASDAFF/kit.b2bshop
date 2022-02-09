<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

?>
<div class="support-wrapper">
	<?if($arResult['SUPPORT_PAGE']):?>
	<div class="b2b_detail_order__second__tab b2b_detail_order__second__tab--absolute">
		<a href="<?=$APPLICATION->GetCurDir()?>" class="b2b_detail_order__second__tab__backlink">
			<?= Loc::getMessage('SUP_LIST') ?>
		</a>
	</div>
	<?endif;?>

	<?= ShowError($arResult["ERROR_MESSAGE"]); ?>
	<?
	if(!empty($arResult["TICKET"]['ID']))
	{
		?>
		<div class="support-chat">
			<div class="support-chat__title">
				<?= $arResult["TICKET"]["TITLE"] ?>
			</div>
			<div class="support-chat__info">
				<div class="support-chat__info__row">
					<div class="support-chat__info__row__left">
						<?= Loc::getMessage("SUP_CREATE") ?>:
					</div>
					<div class="support-chat__info__row__right">
						<?= FormatDate($DB->DateFormatToPHP('DD.MM.YYYY'), MakeTimeStamp($arResult["TICKET"]["TIMESTAMP_X"])) ?>
					</div>
				</div>
				<? if(strlen($arResult["TICKET"]["CATEGORY_NAME"]) > 0)
				{
					?>
					<div class="support-chat__info__row">
						<div class="support-chat__info__row__left">
							<?= Loc::getMessage("SUP_CATEGORY") ?>:
						</div>
						<div class="support-chat__info__row__right">
							<?= $arResult["TICKET"]["CATEGORY_NAME"] ?>
						</div>
					</div>
					<?
				}
				if($arResult['RESPONSIBLE'])
				{
					?>
					<div class="support-chat__info__row">
						<div class="support-chat__info__row__left">
							<?= Loc::getMessage("SUP_RESPONSIBLE") ?>:
						</div>
						<div class="support-chat__info__row__right">
							<?= $arResult['RESPONSIBLE'] ?>
						</div>
					</div>
				<? }
				if($arResult["TICKET"]["DATE_CLOSE"])
				{
					?>
					<div class="support-chat__info__row">
						<div class="support-chat__info__row__left">
							<?= Loc::getMessage("SUP_DATE_CLOSE") ?>:
						</div>
						<div class="support-chat__info__row__right">
							<?= $arResult["TICKET"]["DATE_CLOSE"] ?>
						</div>
					</div>
					<?
				}
				?>
			</div>
			<div class="support-chat__title2">
				<?= Loc::getMessage("SUP_DISCUSSION") ?>
			</div>
			<div class="support-chat__nav">
				<?= $arResult["NAV_STRING"] ?>
			</div>
			<? foreach ($arResult["MESSAGES"] as $message)
			{
				?>
				<div class="support-chat__message <?= ($message['MESSAGE_BY_SUPPORT_TEAM'] == 'Y') ? 'support-chat__message__support' : '' ?>">
					<div class="support-chat__message__header">
						<div class="support-chat__message__header__left">
							<div class="support-chat__message__header__user">
								<div class="support-chat__message__header__user__left">
									<?= ($message['MESSAGE_BY_SUPPORT_TEAM'] == 'Y') ? Loc::getMessage('SUP_SUPPORT_TEAM')
										: Loc::getMessage('SUP_CLIENT') ?>:
								</div>
								<div class="support-chat__message__header__user__right">
									<?= $message["OWNER_NAME"] ?>
								</div>
							</div>
							<div class="support-chat__message__header__date">
								<?= FormatDate($DB->DateFormatToPHP(CSite::GetDateFormat('FULL')), MakeTimeStamp($arMessage["DATE_CREATE"])) ?>
							</div>
						</div>
						<div class="support-chat__message__header__quote">
						<span OnMouseDown="javascript:SupQuoteMessage('quotetd<?= $message["ID"] ?>')">
							<?= Loc::getMessage("SUP_QUOTE") ?>
						</span>
						</div>
					</div>
					<div class="support-chat__message__body">
						<div class="support-chat__message__body__left">
							<div class="support-chat__message__body__left__avatar">
								<?
								if($message["PERSONAL_PHOTO"])
								{
									?>
									<img src="<?= $message["PERSONAL_PHOTO"]['src'] ?>"
									     width="55"
									     height="55">
									<?
								}
								?>
							</div>
						</div>
						<div class="support-chat__message__body__right" id="quotetd<?= $message["ID"] ?>">
							<?= $message["MESSAGE"] ?>
						</div>
					</div>
					<?
					if($message["FILES"])
					{
					?>
						<div class="support-chat__message__footer">
							<div class="support-chat__message__footer__left"></div>
							<div class="support-chat__message__footer__right">
								<?
								$aImg = [
									"gif",
									"png",
									"jpg",
									"jpeg",
									"bmp"
								];
								foreach ($message["FILES"] as $file)
								{
									if(in_array(strtolower(GetFileExtension($file["NAME"])), $aImg))
									{
										?>
										<a
												class="support-chat__message__footer__right__name"
												title="<?= Loc::getMessage("SUP_VIEW_ALT") ?>"
												href="<?= $componentPath ?>/ticket_show_file.php?hash=<?= $file["HASH"] ?>&amp;lang=<?= LANG ?>">
											<?= $file["NAME"] ?>
										</a>
										<?
									}
									else
									{
										echo $file["NAME"];
									}
									?>
									<span>(<? echo CFile::FormatSize($file["FILE_SIZE"]); ?>)</span> |
									<a
										class="support-chat__message__footer__right__download"
										title="<?= str_replace("#FILE_NAME#", $file["NAME"], Loc::getMessage("SUP_DOWNLOAD_ALT")) ?>"
										href="<?= $componentPath ?>/ticket_show_file.php?hash=<?= $file["HASH"] ?>&amp;lang=<?= LANG ?>&amp;action=download">
									<?= Loc::getMessage("SUP_DOWNLOAD") ?>
								</a><br>
									<?
								}
								?>
							</div>
						</div>
					<?}?>
				</div>
				<?
			} ?>
			<div class="support-chat__nav">
				<?= $arResult["NAV_STRING"] ?>
			</div>
		</div>
	<? }
	?>
	<div class="support_form">
		<form name="support_edit" method="post" id="supportForm" action="<?= $arResult["REAL_FILE_PATH"] ?>"
		      enctype="multipart/form-data">
			<?= bitrix_sessid_post() ?>
			<input type="hidden" name="set_default" value="Y"/>
			<input type="hidden" name="ID"
			       value=<?= (empty($arResult["TICKET"]['ID']) ? 0 : $arResult["TICKET"]["ID"]) ?>/>
			<input type="hidden" name="edit" value="1">
			<input type="hidden" name="lang" value="<?= LANG ?>"/>
			<? if(!$arResult["TICKET"]["DATE_CLOSE"])
			{
				?>
				<div class="support-form-inner">
					<div class="support-form__title">
						<?= (empty($arResult["TICKET"]['ID'])) ? Loc::getMessage("SUP_TICKET") : Loc::getMessage("SUP_ANSWER") ?>
					</div>
					<?
					if(empty($arResult["TICKET"]['ID']))
					{
						if($arResult['SUPPORT_PAGE'])
						{
							?>
							<div class="support-form__row">
								<div class="support-form__row__left">
									<label for="TITLE">
										<?= Loc::getMessage("SUP_TITLE") ?>
									</label>
								</div>
								<div class="support-form__row__right">
									<input type="text" name="TITLE" id="TITLE"
									       value="<?= htmlspecialcharsbx($_REQUEST["TITLE"]) ?>" size="48"
									       maxlength="255"/>
								</div>
							</div>
							<div class="support-form__row">
								<div class="support-form__row__left">
									<label for="CATEGORY_ID">
										<?= Loc::getMessage("SUP_CATEGORY") ?>
									</label>
								</div>
								<div class="support-form__row__right">
									<select name="CATEGORY_ID" id="CATEGORY_ID">
										<option value="">&nbsp;</option>
										<? foreach ($arResult["DICTIONARY"]["CATEGORY"] as $value => $option)
										{
											?>
											<option value="<?= $value ?>" <?= ($category == $value) ? 'selected="selected"' : '' ?>>
												<?= $option ?>
											</option>
										<? } ?>
									</select>
								</div>
							</div>
							<?
						}
						else
						{
							?>
							<input type="hidden" name="TITLE" value="<?=Loc::getMessage('SUP_ORDER',['#ORDER_ID#' =>
								$arParams['ORDER_ID']])?>">
							<input type="hidden" name="UF_ORDER" value="<?=$arParams['ORDER_ID']?>">
							<?
						}
					}
					if(!$arResult['SUPPORT_PAGE'])
					{
						?>
						<input type="hidden" name="CATEGORY_ID" value="<?=$arResult['ORDER_CATEGORY']?>">
						<?
					}
					?>
					<div class="support-form__row">
						<div class="support-form__row__left">
							<label for="MESSAGE">
								<?= Loc::getMessage("SUP_MESSAGE") ?>
							</label>
						</div>
						<div class="support-form__row__right">
								<textarea name="MESSAGE" id="MESSAGE" rows="10" wrap="virtual"><?= htmlspecialcharsbx
									($_REQUEST["MESSAGE"]) ?></textarea>
						</div>
					</div>
					<div class="support-form__row">
						<div class="support-form__row__left">
							<label>
								<?= Loc::getMessage("SUP_ATTACH") ?>
								(max
								- <?= $arResult["OPTIONS"]["MAX_FILESIZE"] ?> <?= Loc::getMessage("SUP_KB") ?>
								):
							</label>
							<input type="hidden" name="MAX_FILE_SIZE"
							       value="<?= ($arResult["OPTIONS"]["MAX_FILESIZE"] * 1024) ?>">
						</div>
						<div class="support-form__row__right">
							<div class="support-form__upload">
								<input name="FILE_0" id="FILE_0" type="file" multiple
								       class="support-form__upload__file"/>
								<label for="FILE_0"><?= Loc::getMessage("SUP_CHOOSE") ?></label>
								<span><?= Loc::getMessage("SUP_CHOOSE_NO") ?></span>
							</div>
							<div class="support-form__upload">
								<input name="FILE_1" id="FILE_1" type="file" multiple
								       class="support-form__upload__file"/>
								<label for="FILE_1"><?= Loc::getMessage("SUP_CHOOSE") ?></label>
								<span><?= Loc::getMessage("SUP_CHOOSE_NO") ?></span>
							</div>
							<div class="support-form__upload">
								<input name="FILE_2" id="FILE_2" type="file" multiple
								       class="support-form__upload__file"/>
								<label for="FILE_2"><?= Loc::getMessage("SUP_CHOOSE") ?></label>
								<span><?= Loc::getMessage("SUP_CHOOSE_NO") ?></span>
							</div>
							<span id="files_table_2"></span>
							<input class="support-form__upload__more" type="button"
							       value="<?= Loc::getMessage("SUP_MORE") ?>"
							       OnClick="AddFileInput(
									       '<?= Loc::getMessage("SUP_MORE") ?>',
									       '<?= Loc::getMessage("SUP_CHOOSE") ?>',
									       '<?= Loc::getMessage("SUP_CHOOSE_NO") ?>')"/>
							<input type="hidden" name="files_counter" id="files_counter" value="2"/>
						</div>
					</div>
					<div class="support-form__row">
						<div class="support-form__row__left">
						</div>
						<div class="support-form__row__right">
							<input type="submit" name="apply" value="<?= Loc::getMessage("SUP_APPLY") ?>"/>&nbsp;
							<input type="hidden" value="Y" name="apply"/>
						</div>
					</div>
				</div>
				<?
				if(!empty($arResult["TICKET"]['ID']))
				{
					?>
					<div class="support-form__footer">
						<div class="support-form__footer__title">
							<?= Loc::getMessage('SUP_MARK') ?>
						</div>
						<div class="support-form__footer__inner">
							<?
							$mark = (strlen($arResult["ERROR_MESSAGE"]) > 0 ? htmlspecialcharsbx($_REQUEST["MARK_ID"]) : $arResult["TICKET"]["MARK_ID"]);
							if(!$mark)
							{
								$mark = ($arResult['DEFAULT_MARK'] > 0)?$arResult['DEFAULT_MARK']:key($arResult["DICTIONARY"]["MARK"]);
							}
							foreach ($arResult["DICTIONARY"]["MARK"] as $value => $option)
							{
								?>
								<div class="support-form__footer__option <?= ($mark == $value)
									? 'support-form__footer__option__active' : '' ?>" data-mark="<?= $value ?>">
									<div class="support-form__footer__bullet">
										<div class="support-form__footer__bullet__inner"></div>
									</div>
									<span><?= $option ?></span>
								</div>
								<?
							} ?>
							<input type="hidden" name="MARK_ID" id="MARK_ID" value="<?= $mark ?>">
						</div>
					</div>
					<input type="button" name="save-close" value="<?= Loc::getMessage("SUP_CLOSE") ?>"
					       class="support-form__close">
					<input type="hidden" name="CLOSE" id="CLOSE" value="N">
				<? }
			}
			else
			{
				?>
				<input type="submit" name="apply" value="<?= Loc::getMessage("SUP_OPEN") ?>"
				       class="support-form__open">
				<input type="hidden" name="OPEN" value="Y">
				<?
			}
			?>

			<script type="text/javascript">
				var inputs = document.querySelectorAll('.support-form__upload__file');
				Array.prototype.forEach.call(inputs, function (input)
				{
					var label = input.nextElementSibling,
						labelVal = label.innerHTML;

					input.addEventListener('change', function (e)
					{
						var fileName = '';
						if (this.files && this.files.length > 1)
							fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
						else
							fileName = e.target.value.split('\\').pop();

						if (fileName)
						{
							label.nextElementSibling.innerHTML = fileName;
						}
					});
				});
				BX.ready(function ()
				{
					var buttons = BX.findChildren(document.forms['support_edit'], {attr: {type: 'submit'}});
					for (i in buttons)
					{
						BX.bind(buttons[i], "click", function (e)
						{
							setTimeout(function ()
							{
								var _buttons = BX.findChildren(document.forms['support_edit'], {attr: {type: 'submit'}});
								for (j in _buttons)
								{
									_buttons[j].disabled = true;
								}

							}, 30);
						});
					}
				});
			</script>
		</form>
	</div>
</div>