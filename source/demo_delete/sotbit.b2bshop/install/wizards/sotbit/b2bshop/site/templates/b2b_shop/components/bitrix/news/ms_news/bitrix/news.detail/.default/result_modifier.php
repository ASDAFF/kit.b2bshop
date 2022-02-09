<?

if( !defined( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true )
	die();

$templateUrl = $this->GetFolder();
$arResult["AJAX_URL"] = $templateUrl . "/ajax.php";

if( $arResult["DISPLAY_PROPERTIES"]["FIRST"] )
{
	$url = $arResult["DISPLAY_PROPERTIES"]["FIRST"]["VALUE"];
	$url = parse_url($url);
	$arResult["DISPLAY_PROPERTIES"]["FIRST"]["SITE"] = $url['host'];
}

if( $arParams["DISPLAY_PICTURE"] != "N" && is_array( $arResult["DETAIL_PICTURE"] ) && ($arResult["DETAIL_PICTURE"]["WIDTH"] > $arParams["DETAIL_WIDTH_IMG"] || $arResult["DETAIL_PICTURE"]["HEIGHT"] > $arParams["DETAIL_HEIGHT_IMG"]) )
{
	$detailPic = CFile::ResizeImageGet( $arResult["DETAIL_PICTURE"], array(
			'width' => $arParams["DETAIL_WIDTH_IMG"],
			'height' => $arParams["DETAIL_HEIGHT_IMG"] 
	), BX_RESIZE_IMAGE_PROPORTIONAL, true );
	$arResult["DETAIL_PICTURE"]["RESIZE"]["WIDTH"] = $detailPic["width"];
	$arResult["DETAIL_PICTURE"]["RESIZE"]["HEIGHT"] = $detailPic["height"];
	$arResult["DETAIL_PICTURE"]["RESIZE"]["SRC"] = $detailPic["src"];
	$arResult["DETAIL_PICTURE"]["RESIZE"]["FILE_SIZE"] = $detailPic["size"];
}
else
{
	$arResult["DETAIL_PICTURE"]["RESIZE"]["WIDTH"] = $arResult["DETAIL_PICTURE"]["WIDTH"];
	$arResult["DETAIL_PICTURE"]["RESIZE"]["HEIGHT"] = $arResult["DETAIL_PICTURE"]["HEIGHT"];
	$arResult["DETAIL_PICTURE"]["RESIZE"]["SRC"] = $arResult["DETAIL_PICTURE"]["SRC"];
	$arResult["DETAIL_PICTURE"]["RESIZE"]["FILE_SIZE"] = $arResult["DETAIL_PICTURE"]["FILE_SIZE"];
}

// VIDEO START
if( isset( $arResult["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"] ) && is_array( $arResult["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"] ) && count( $arResult["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"] ) > 0 )
{
	foreach( $arResult["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"] as $Video )
	{
		// YOUTUBE
		if( strpos( $Video, "youtube.com" ) )
		{
			$VideoPath = explode( '?v=', $Video );
			$VideoNumber = $VideoPath[count( $VideoPath ) - 1];
			$arResult["VIDEO"][] = '<iframe src="https://www.youtube.com/embed/' . $VideoNumber . '" frameborder="0" allowfullscreen></iframe>';
		}
		// VIMEO
		elseif( strpos( $Video, "vimeo.com" ) )
		{
			$VideoPath = explode( '/', $Video );
			$VideoNumber = $VideoPath[count( $VideoPath ) - 1];
			$arResult["VIDEO"][] = '<iframe src="https://player.vimeo.com/video/' . $VideoNumber . '"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}
		// HTML5
		else
		{
			$arResult["VIDEO"][] = '<video src="' . $Video . '"  controls autobuffer preload ></video>';
		}
	}
}

// VIDEO END
if(!$arResult['PREVIEW_TEXT'])
{
	$arResult['PREVIEW_TEXT'] = $arResult['DETAIL_TEXT'];
	preg_match_all('/<img[^>]+>/i',$arResult['DETAIL_TEXT'], $images); 
	if($images[0])
	{
		foreach($images[0] as $image)
		{
			$arResult['PREVIEW_TEXT'] = str_replace($image,'',$arResult['PREVIEW_TEXT']);
		}
	}
	$arResult['PREVIEW_TEXT'] = substr($arResult['DETAIL_TEXT'],0,100);
}
?>