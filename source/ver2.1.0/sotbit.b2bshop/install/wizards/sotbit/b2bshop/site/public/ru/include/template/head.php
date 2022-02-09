<?php
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Config\Option;
global $APPLICATION;
?>

<meta name="viewport" content="initial-scale=1.0, width=device-width">
<?php
if(Option::get("sotbit.b2bshop", "SHOW_PHONES", "Y") != 'Y')
{
	?>
	<meta name="format-detection" content="telephone=no">
	<?php
}?>
<meta name="cmsmagazine" content="8bebb8ebc14dc459af971f03b3ab51a6" />
<link rel="shortcut icon" type="image/x-icon" href="<?=SITE_DIR?>favicon.ico" />
<title><?$APPLICATION->ShowTitle()?></title>
<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/r29/html5.min.js"></script>
<![endif]-->
<?
$APPLICATION->ShowHead();

Asset::getInstance()->addString('<script>var SITE_DIR = "'.SITE_DIR.'";</script>');

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/plugins/jquery/jquery.1.11.1.min.js");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/site_files/plugins/bootstrap/css/bootstrap.min.css");?>
<!--[if lt IE 9]>
	<script src="<?=SITE_TEMPLATE_PATH?>/site_files/plugins/bootstrap/js/respond.min.js"></script>
<![endif]-->
<?
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/site_files/plugins/owl-carousel/owl.carousel.min.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/plugins/owl-carousel/owl.carousel.js");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/site_files/plugins/jquery.mmenu/4.3.7/jquery.mmenu.all.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/plugins/jquery.mmenu/4.3.7/jquery.mmenu.min.all.js");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/site_files/plugins/nouislider/jquery.nouislider.min.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/plugins/nouislider/jquery.nouislider.min.js");
?>
<script type="text/javascript">var Link = $.noUiSlider.Link;</script>
<?
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/plugins/niceScroll/jquery.nicescroll.changed.min.js");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/site_files/plugins/ZoomIt/zoomIt.min.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/plugins/ZoomIt/zoomit.jquery.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/plugins/ikSelect/jquery.ikSelect.min.js");

if(Option::get('sotbit.b2bshop', 'LAZY_LOAD','N') == 'Y')
{
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/plugins/bLazy/blazy.min.js");
}
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/site_files/plugins/idangerous.swiper/idangerous.swiper.min.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/plugins/idangerous.swiper/idangerous.swiper.min.js");

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/site_files/fonts/FontAwesome/css/font-awesome.min.css");

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/site_files/css/style.css");

if(Option::get("sotbit.b2bshop", "STYLE", "default")=="default")
{
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/site_files/css/bg.css");
}
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/site_files/css/style_quick_view.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/js/script.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/plugins/fancybox2/lib/jquery.mousewheel-3.0.6.pack.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/plugins/fancybox2/source/jquery.fancybox.pack.js?v=2.1.5");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/site_files/plugins/fancybox2/source/jquery.fancybox.min.css?v=2.1.5");

if(COption::GetOptionString( "sotbit.b2bshop", "SHOW_BRICKS", "N" ) == 'Y')
{
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/plugins/masonry/masonry.min.js");
}

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/site_files/plugins/mask/jquery.maskedinput.min.js");
?>

<!--[if lt IE 9]>
	<script src="<?=SITE_TEMPLATE_PATH?>/site_files/plugins/pie/PIE.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/site_files/plugins/pie/PIE.css"/>
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/site_files/css/ie.css"/>
<![endif]-->
<!--[if lt IE 10]>
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/site_files/css/ie9.css"/>
<![endif]-->
<?
$AddFiles = unserialize(Option::get("sotbit.b2bshop", "ADD_FILES", "a:0:{}"));
if(is_array($AddFiles) && sizeof($AddFiles)>0)
{
	$AddFiles = array_unique(array_diff($AddFiles,array('')));
	foreach($AddFiles as $AddFile)
	{
		if(strpos($AddFile,'.css')===false && strpos($AddFile,'.js')===false)
		{
			continue;
		}
		elseif(strpos($AddFile,'.css')!==false)
		{
			Asset::getInstance()->addCss($AddFile);
		}
		elseif(strpos($AddFile,'.js')!==false)
		{
			Asset::getInstance()->addJs($AddFile);
		}
	}
}
?>