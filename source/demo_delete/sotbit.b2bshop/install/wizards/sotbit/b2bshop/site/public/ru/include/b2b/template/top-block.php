<?php
global $APPLICATION, $USER;
use Bitrix\Main\Loader;
?>
<div class="top-block">
	<div class="container">
		<div class="top-block__wrapper">
			<?if(Loader::includeModule('sotbit.regions') && COption::GetOptionString("sotbit
				.b2bshop","USE_MULTIREGIONS","Y") == 'Y')
			{
				?>
				<div class="top-block__wrapper_region">
					<?
					$APPLICATION->IncludeComponent(
						"sotbit:regions.choose",
						"",
						array(
						),
						false
					);
					?>
				</div>
				<?
			}
			$APPLICATION->IncludeComponent(
				"bitrix:menu",
				"b2b_top",
				array(
					"ALLOW_MULTI_SELECT" => "N",
					"CHILD_MENU_TYPE" => "left",
					"COMPOSITE_FRAME_MODE" => "A",
					"COMPOSITE_FRAME_TYPE" => "AUTO",
					"DELAY" => "N",
					"MAX_LEVEL" => "1",
					"MENU_CACHE_GET_VARS" => array(),
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_TYPE" => "A",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"ROOT_MENU_TYPE" => "b2b_top",
					"USE_EXT" => "N",
					"COMPONENT_TEMPLATE" => "b2b_top",
					'CACHE_SELECTED_ITEMS' => false
				),
				false
			);
			$APPLICATION->IncludeComponent(
				"bitrix:menu",
				"b2b_lk_menu",
				array(
					"ALLOW_MULTI_SELECT" => "N",
					"CHILD_MENU_TYPE" => "left",
					"COMPOSITE_FRAME_MODE" => "A",
					"COMPOSITE_FRAME_TYPE" => "AUTO",
					"DELAY" => "N",
					"MAX_LEVEL" => "1",
					"MENU_CACHE_GET_VARS" => array(),
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_TYPE" => "N",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"ROOT_MENU_TYPE" => "b2b_top_dropdown",
					"USE_EXT" => "N",
					"COMPONENT_TEMPLATE" => "b2b_lk_menu",
					'CACHE_SELECTED_ITEMS' => false
				),
				false
			);
			?>
		</div>
	</div>
</div>