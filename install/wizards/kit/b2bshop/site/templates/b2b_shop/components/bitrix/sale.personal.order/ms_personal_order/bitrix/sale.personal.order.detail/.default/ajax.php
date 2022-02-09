<?
require_once ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
/*
 * Good code for create real xmls if can connect PHPExcel
 * 
 require_once ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/kit.b2bshop/classes/PHPExcel/PHPExcel.php");

 $fname = $OrderId . '_' . rand ();
 $path = $_SERVER['DOCUMENT_ROOT'] . SITE_DIR . 'upload/' . $fname . ".xlsx";
 $objPHPExcel = new PHPExcel();

 $k=0;
 $objPHPExcel->setActiveSheetIndex(0);
 foreach($Headers as $key=>$Header)
 {
 $char = chr($k+65);

 if(LANG_CHARSET == 'windows-1251')
 {
 $data = iconv( "UTF-8", "WINDOWS-1251", $Header );
 }
 else
 {
 $data =$Header;
 }
 $objPHPExcel->setActiveSheetIndex(0)
 ->setCellValue($char.'1', $data);


 $i=2;
 foreach($arResult as $row)
 {
 if($key=="IMAGE")
 {
 $iDrowing = new PHPExcel_Worksheet_Drawing();
 $iDrowing->setPath($_SERVER["DOCUMENT_ROOT"].$row['PICTURE']["src"]);
 $iDrowing->setCoordinates('A2');
 $iDrowing->setResizeProportional(false);
 $iDrowing->setWidth($row['PICTURE']["width"]);
 $iDrowing->setHeight($row['PICTURE']["height"]);
 $iDrowing->setWorksheet($objPHPExcel->getActiveSheet());
 $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight($row['PICTURE']["height"]);
 }
 elseif($key=="NAME")
 {
 $value=$row[$key];
 if(isset($row["PROPS"]))
 {
 foreach($row["PROPS"] as $prop)
 {
 $value.="\n";
 $value.=$prop["NAME"].': '.$prop["VALUE"];
 }
 }
 $objPHPExcel->setActiveSheetIndex(0)
 ->setCellValue($char.$i, $value);
 }
 elseif($key=="PRICE")
 {
 $objPHPExcel->setActiveSheetIndex(0)
 ->setCellValue($char.$i, $row["PRICE_FORMATED"]);
 }
 elseif($key=="DISCOUNT")
 {
 $objPHPExcel->setActiveSheetIndex(0)
 ->setCellValue($char.$i, $row["DISCOUNT_PRICE_PERCENT_FORMATED"]);
 }
 elseif($key=="SUMMARY")
 {
 $objPHPExcel->setActiveSheetIndex(0)
 ->setCellValue($char.$i, $row["FULL_PRICE_FORMATED"]);
 }
 else
 {
 $objPHPExcel->setActiveSheetIndex(0)
 ->setCellValue($char.$i, $row[$key]);
 }
 $objPHPExcel->getActiveSheet()->getStyle($char.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 $objPHPExcel->getActiveSheet()->getStyle($char.$i)->getAlignment()->setWrapText(true);
 ++$i;
 $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(-1);
 }

 $objPHPExcel->getActiveSheet()->getColumnDimension($char)->setAutoSize(true);

 ++$k;
 }
 $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);

 $i+=3;
 $k=0;
 $j=$i+1;

 foreach($HeadersSum as $key=>$Header)
 {
 $char = chr($k+65);
 $objPHPExcel->setActiveSheetIndex(0)
 ->setCellValue($char.$i, $Header['TITLE']);
 $objPHPExcel->setActiveSheetIndex(0)
 ->setCellValue($char.$j, $Header['VALUE']);
 ++$k;
 }

 $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 $objWriter->save($path);

 $url = @($_SERVER["HTTPS"] != 'on') ? 'http://' . $_SERVER["SERVER_NAME"] : 'https://' . $_SERVER["SERVER_NAME"];
 $url .= ($_SERVER["SERVER_PORT"] != 80) ? ":" . $_SERVER["SERVER_PORT"] : "";
 $url .= SITE_DIR . 'upload/' . $fname . ".xlsx";
 echo $url.'||'.$fname . ".xlsx";

 require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_admin_after.php");
 die();*/
$fname = $OrderId . '_' . rand ();
$path = $_SERVER['DOCUMENT_ROOT'] . SITE_DIR . 'upload/' . $fname . ".xls";

$url = @($_SERVER["HTTPS"] != 'on') ? 'http://' . $_SERVER["SERVER_NAME"] : 'https://' . $_SERVER["SERVER_NAME"];
$url .= ($_SERVER["SERVER_PORT"] != 80) ? ":" . $_SERVER["SERVER_PORT"] : "";
$data = '';
$data .= '
		<html>
		<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=' . LANG_CHARSET . '">
		<style>
			td {mso-number-format:\@;}
			.number0 {mso-number-format:0;}
			.number2 {mso-number-format:Fixed;}
		</style>
		</head>
		<body>';


$data .= "<table border=\"1\">";
//headers
$data .= "<tr>";
foreach($Headers as $key=>$Header)
{
	$data .= '<td>';
	if(LANG_CHARSET == 'windows-1251')
	{
		$data .= iconv( "UTF-8", "WINDOWS-1251", $Header );
	}
	else
	{
		$data .=$Header;
	}

	$data .='</td>';
}
$data .= "</tr>";

//body
foreach($arResult as $row)
{
	$data .= "<tr>";
	foreach($Headers as $key=>$Header)
	{
		if($key=="IMAGE")
		{
			$height = $row['PICTURE']["height"]+20;
			$data .= '<td height="'.$height.'" width="'.$row['PICTURE']["width"].'">';
			if(isset($row['PICTURE']["src"]))
			{
				$src = htmlspecialcharsex(CHTTP::URN2URI($row['PICTURE']["src"]));
				$data .= '<img src="'.$src.'" />';
			}
			else
			{

			}
				
		}
		elseif($key=="NAME")
		{
			$data .='<td valign="middle"><a href="'.$url.$row["DETAIL_PAGE_URL"].'">';
			$value=$row[$key];
			$data .='</a>';
			if(isset($row["PROPS"]))
			{
				foreach($row["PROPS"] as $prop)
				{
					$value.="\n";
					$value.=$prop["NAME"].': '.$prop["VALUE"];
				}
			}
			$data .= $value;
		}
		elseif($key=="PRICE")
		{
			$data .='<td valign="middle">';
			$data .= $row["PRICE_FORMATED"];
		}
		elseif($key=="DISCOUNT")
		{
			$data .='<td valign="middle">';
			$data .= $row["DISCOUNT_PRICE_PERCENT_FORMATED"];
		}
		elseif($key=="SUMMARY")
		{
			$data .='<td valign="middle">';
			$data .= $row["FULL_PRICE_FORMATED"];
		}
		else
		{
			$data .='<td valign="middle">';
			$data .= $row[$key];
		}

		$data .='</td>';
	}
	$data .= "</tr>";
}

$data .= '</table>';
$data .= "<table border=\"0\">";
$data .= '<tr></tr>';
$data .= '<tr></tr>';
$data .= '</table>';
$data .= "<table border=\"1\">";
$data .= '<tr>';
foreach($HeadersSum as $key=>$Header)
{
	$data .= '<td>';
	$data .= $Header['TITLE'];
	$data .= '</td>';
}
$data .= '</tr>';
foreach($HeadersSum as $key=>$Header)
{
	$data .= '<td>';
	$data .= $Header['VALUE'];
	$data .= '</td>';
}
$data .= '</tr>';
$data .= "</table>";
$data .= '</body></html>';


$fh = fopen ( $path, "w+" );
fwrite ( $fh, $data );
fclose ( $fh );


$url .= SITE_DIR . 'upload/' . $fname . ".xls";
echo $url.'||'.$fname . ".xls";
require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_admin_after.php");
die();
?>