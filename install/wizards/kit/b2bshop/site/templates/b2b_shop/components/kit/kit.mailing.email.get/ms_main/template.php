<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Config\Option;
$frame = $this->createFrame()->begin();
if($_COOKIE['MAILING_USER_MAIL_GET'] == 'Y')
{
	return false;
}
?>
<div class="footer_block_top">
	<div class='container'>
		<div class='row'>
			<div class="col-sm-10 sm-padding-no">
				<div class="footer_block_top_left">
					<p><?= $arParams["INFO_TEXT"] ?></p>
				</div>
			</div>
			<div class="col-sm-14">
				<form id="kit_reg_panel_form" method="post" action="#" class="form-subscribe">
					<div class='row'>
						<div class="col-sm-15 sm-padding-no">
							<div class="footer_block_top_center">
								<label><?= GetMessage('PANNEL_EMAIL_TITLE') ?></label>
								<input type="text" title="<?= GetMessage('PANNEL_EMAIL') ?>"
								       placeholder="<?= GetMessage('PANNEL_EMAIL') ?>" maxlength="50" name="EMAIL_TO"
								       value="<?= $arResult['SUBSCRIBER_INFO']['EMAIL_TO'] ?>">
							</div>
						</div>
						<div class="col-sm-9 sm-padding-no">
							<div class="footer_block_top_right">
								<div class="wrap_input">
									<input type="submit" value="<?= GetMessage('PANNEL_SEND') ?>" name="Save">
								</div>
							</div>
						</div>
					</div>
					<?
					if(Option::get('kit.b2bshop','SHOW_CONFIDENTIAL_SUBSCRIBE','Y') == 'Y')
					{
						?>
						<div class="row">
							<div class="col-sm-24 sm-padding-no">
								<div class="confidential-field">
									<input type="checkbox" id="UF_CONFIDENTIAL_MAIN" name="UF_CONFIDENTIAL" class="checkbox"
									       checked="checked"
									       required>
									<label for="UF_CONFIDENTIAL_MAIN" class="label-active">
										<?=GetMessage("AUTH_UF_CONFIDENTIAL");?>
									</label>
								</div>
							</div>
						</div>
						<?
					}
					?>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#kit_reg_panel_form").on('submit', function ()
	{
		var email = $("#kit_reg_panel_form input[name=EMAIL_TO]").val();
		var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
		if (email == "<?=GetMessage('AUTH_REGISTER_PANNEL_EMAIL')?>")
		{
			var email = "";
		}

		if (pattern.test(email))
		{

			var class_ = "kit_reg_form";
			var params = "<?=$arResult['STR_PARAMS']?>";


			<?
			if($arParams["~EMAIL_SEND_END"])
			{
				$EMAIL_SEND_END = $arParams["~EMAIL_SEND_END"];
			}
			else
			{
				$EMAIL_SEND_END = GetMessage('EMAIL_SEND_END');
			}
			?>

			BX.ajax({
				url: "<?=$this->GetFolder() ?>/ajax.php",
				method: 'POST',
				dataType: 'html',
				data: 'getemail=Y&EMAIL_TO=' + email + '&' + params,
				onsuccess: function (data)
				{
					$('.footer_block_top_center').html('<?=$EMAIL_SEND_END?>');

				},
			});

		}
		else
		{
			var email = "";
		}

		return false;
	});
</script>
<? $frame->end(); ?>
    
