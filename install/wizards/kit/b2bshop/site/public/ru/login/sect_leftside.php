<div class="col-sm-24 center_wrap sm-padding-no">
	<?
	$APPLICATION->IncludeComponent( "bitrix:breadcrumb", "ms_breadcrumb", 
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
			array(
					"COMPONENT_TEMPLATE" => "coffeediz.schema.org",
					"PATH" => "",
					"SHOW" => "Y",
					"SITE_ID" => SITE_ID,
					"START_FROM" => "0" 
	) );
	?>
	<div class="main_inner_title">
		<h1 class="text"><?$APPLICATION->ShowTitle(false);?></h1>
	</div>
