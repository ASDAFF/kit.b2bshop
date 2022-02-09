<?use Bitrix\Main\Web\Json;
define("NOT_CHECK_PERMISSIONS", true);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->ShowAjaxHead();
$data = html_entity_decode($data);
$data= Json::decode($data);
if($data['add_wish'] == 'Y')
{
    IncludeModuleLangFile(__FILE__);
	?>
	<div class="modal-content modal-content-basket">
		<div class="modal_basket_header bootstrap_style content-text">
			<div class="basket_block_top">
				<div class="basket_text">
					<h5 class="name"><?=GetMessage('ADD_WISH_POPUP_TITLE');?></h5>
				</div>
			</div>
			<p class="text text-to-basket"><?=GetMessage('ADD_WISH_POPUP_TEXT');?></p>
		</div>
		<div class="modal_basket_body bootstrap_style content-text">
			<div class="wrap_btn clearfix">
				<span class="btn close btn-close"><?=GetMessage('ADD_WISH_POPUP_BUTTON_CONTINUE');?></span>
				<a class="go_basket" href="<?php echo $data['basket_url'];?>"><?=GetMessage('ADD_WISH_POPUP_BUTTON_GO_TO_BASKET');?></a>
			</div>
		</div>
	</div>
	<?php
}
?>