<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?


if ($REQUEST_METHOD == "POST" && $arImage && $arSizes)
{
	if ($arImage)
	{
		foreach ( $arImage as $color => $Images )
		{
			foreach ( $Images['SMALL'] as $i => $SmallImg )
			{
				if (isset ( $SmallImg['src'] )) // if dont need resize
				{
					continue;
				}
				$arImage[$color]['SMALL'][$i] = CFile::ResizeImageGet ( $SmallImg, array (
						'width' => $arSizes['SMALL']['WIDTH'],
						'height' => $arSizes['SMALL']['HEIGHT'] 
				), $arSizes['RESIZE'], true );
			}
			foreach ( $Images['MEDIUM'] as $i => $MediumImg )
			{
				if (isset ( $MediumImg['src'] )) // if dont need resize
				{
					continue;
				}
				$arImage[$color]['MEDIUM'][$i] = CFile::ResizeImageGet ( $MediumImg, array (
						'width' => $arSizes['MEDIUM']['WIDTH'],
						'height' => $arSizes['MEDIUM']['WIDTH']
				), $arSizes['RESIZE'], true );
			}
		}
	}
	
	unset ( $i );
	unset ( $color );
	unset ( $Images );
	unset ( $SmallImg );
	unset ( $MediumImg );
	echo json_encode ( $arImage );
}
?>