<?
if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true )
	die();

$arServices = Array(
		"main" => Array(
				"NAME" => GetMessage( "SERVICE_MAIN_SETTINGS" ),
				"STAGES" => Array(
						//"modules.php",
						//"files.php",
						//"search.php",
						//"template.php",
						//"theme.php",
						//"menu.php",
						//"settings.php"
				)
		),
		"iblock" => Array(
				"NAME" => GetMessage( "SERVICE_IBLOCK_DEMO_DATA" ),
				"STAGES" => Array(
						//"types.php",
						//"news.php",
						//"shop.php",
						//"brand.php",
						//"references.php",
						//"catalog.php",
						//"catalog2.php",
						//"catalog3.php",
						//"catalog4.php",
						//"banner.php",
						//"documents.php"
				)
		),
		"sns.tools1c" => Array(
				"NAME" => GetMessage( "SERVICE_SNSTOOLS1C_DATA" ),
				"STAGES" => Array(
						"settings.php"
				)
		),
		"kit.cabinet" => Array(
				"NAME" => GetMessage( "SERVICE_KIT_CABINET_DATA" ),
				"STAGES" => Array(
						"settings.php"
				)
		),
		"sale" => Array(
				"NAME" => GetMessage( "SERVICE_SALE_DEMO_DATA" ),
				"STAGES" => Array(
						"locations.php",
						"step1.php",
						"payments.php",
						"orders.php",
						"step2.php",
						"step3.php"
				)
		),
		"mail" => Array(
				"NAME" => GetMessage( "SERVICE_MAIL_DATA" ),
				"STAGES" => Array(
						"settings.php"
				)
		),
		"kit.mailing" => Array(
				"NAME" => GetMessage( "SERVICE_SOTBTIMAILING_DATA" ),
				"STAGES" => Array(
						"settings.php"
				)
		),
		"kit.preloader" => Array(
				"NAME" => GetMessage( "SERVICE_SOTBTIPRELOADER_DATA" ),
				"STAGES" => Array(
						"settings.php"
				)
		),
		"shs.parser" => Array(
				"NAME" => GetMessage( "SERVICE_SOTBTIPARSER_DATA" ),
				"STAGES" => Array(
						"settings.php"
				)
		),
		"catalog" => Array(
				"NAME" => GetMessage( "SERVICE_CATALOG_SETTINGS" ),
				"STAGES" => Array(
						"index.php"
				)
		),
		"kit.auth" => Array(
				"NAME" => GetMessage( "SERVICE_KIT_AUTH_DATA" ),
				"STAGES" => Array(
						"settings.php"
				)
		),
		"kit.b2bshop" => Array(
				"NAME" => GetMessage( "SERVICE_SHOP_DATA" ),
				"STAGES" => Array(
						"settings.php"
				)
		),
		"support" => Array(
			"NAME" => GetMessage( "SERVICE_SUPPORT_DATA" ),
			"STAGES" => Array(
				"settings.php"
			)
		),
);
?>