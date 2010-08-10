<?php
	require('html2fpdf.php');
	$pdf=new HTML2FPDF();
	$pdf->AddPage();
	$fp = fopen("reporte.php","r");
	$strContent = fread($fp, filesize("reporte.php"));
	fclose($fp);
	$pdf->WriteHTML($strContent);
	$pdf->Output("sample.pdf");

?>