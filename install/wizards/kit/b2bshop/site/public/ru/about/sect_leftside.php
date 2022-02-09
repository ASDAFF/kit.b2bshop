<div class="col-sm-24 center_wrap">
	<div class="row">
		<div class="col-sm-6 sm-padding-left-no left-wrap">
			<div class="left-block">
				<div class="left-block-inner margin-top" id="block_menu_filter">
					<?
					$APPLICATION->IncludeComponent( "bitrix:menu", "ms_filter", 
							array(
									"ROOT_MENU_TYPE" => "left_content",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_TIME" => "36000000",
									"MENU_CACHE_USE_GROUPS" => "Y",
									"MENU_CACHE_GET_VARS" => array(),
									"MAX_LEVEL" => "2",
									"CHILD_MENU_TYPE" => "left_content_inner",
									"USE_EXT" => "Y",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N",
									"COMPONENT_TEMPLATE" => "ms_filter",
									"DEF_SHOW_POINTS" => "8" 
							), false );
					?>
				</div>
			</div>
		</div>
		<div class="col-sm-18">
			<div class="row">
				<div class="col-sm-24 sm-padding-right-no">
					<?
						$APPLICATION->IncludeComponent( "bitrix:breadcrumb", "ms_breadcrumb_section", 
						array(
								"START_FROM" => "0",
								"PATH" => "",
								"SITE_ID" => SITE_ID,
								"SSB_CODE_BACKGROUND" => "#fff",
								"SSB_CODE_BORDER" => "#000",
								"COMPONENT_TEMPLATE" => "ms_breadcrumb" 
						), false, array(
								"HIDE_ICONS" => "N" 
						) );
						$APPLICATION->IncludeComponent( "coffeediz:breadcrumb", "coffeediz.schema.org", 
								Array(
										"COMPONENT_TEMPLATE" => "coffeediz.schema.org",
										"PATH" => "",
										"SHOW" => "Y",
										"SITE_ID" => SITE_ID,
										"START_FROM" => "0" 
								) );
						?>
				</div>
				<div class="col-sm-24 sm-padding-right-no">
					<div class="inner_title_brand">
						<h1 class="text"><?$APPLICATION->ShowTitle(false);?></h1>
					</div>
				</div>
				<div class="col-sm-24 sm-padding-right-no text_page">