<?
require ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$opt = new \Kit\B2BShop\Client\Opt\User();
$userGroups = explode( ',', $USER->GetGroups() );
$hasAccess = $opt->checkAccess( $userGroups );
if(!$hasAccess)
{
	@define("ERROR_404","Y");
}


$APPLICATION->SetTitle( "Профили покупателя" );
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"ms_personal",
	array(
		"ROOT_MENU_TYPE" => "personal",
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "personal_inner",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(),
		"MENU_THEME" => "site",
		"DISPLAY_USER_NANE" => "Y"
	),
	false
);?>

<div class="col-sm-18 sm-padding-right-no blank_right-side <?php if($_COOKIE['blank_side'] == 'N') echo 'blank_right-side_full';?>" id="blank_right_side">
	<div class="personal_block_title personal_block_title_reviews">
		<h1 class="text"><?$APPLICATION->ShowTitle(false);?></h1>
	</div>
	<div id="wrapper_blank_resizer" class="wrapper_blank_resizer">
		<div class="blank_resizer">
			<div class="blank_resizer_tool <?php if($_COOKIE['blank_side'] == 'N') echo 'blank_resizer_tool_open';?>" ></div>
		</div>
		<?
			$context = \Bitrix\Main\Application::getInstance()->getContext();
			$request = $context->getRequest();
			$id = $request->get("id");
			if($id > 0)
			{
				$APPLICATION->IncludeComponent(
					"bitrix:sale.personal.profile.detail",
					"",
					array(
						"PATH_TO_LIST" => '/personal/profile/buyer/',
						"PATH_TO_DETAIL" => '/personal/profile/buyer/?id='.$id,
						"SET_TITLE" => 'Y',
						"USE_AJAX_LOCATIONS" => 'N',
						"COMPATIBLE_LOCATION_MODE" => 'N',
						"ID" => $id,
					),
					$component
				);
			}
			else
			{
				$APPLICATION->IncludeComponent( "bitrix:sale.personal.profile.list", "",
					array(
						"PATH_TO_DETAIL" => '?id=#ID#',
						"PATH_TO_DELETE" => '/personal/profile/buyer/?del_id=#ID#',
						"PER_PAGE" => 50,
						"SET_TITLE" => 'N'
				), $component );
			}
		?>
	</div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>