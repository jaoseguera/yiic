<?php
session_start();
$content = $_SESSION['excel_table_pdf_view'];
$table_name = $_SESSION['table_name'];
define('FPDF_FONTPATH','font/');
require('lib/pdftable.inc.php');
$p = new PDFTable();
// I set margins out of class
$p->AddFont('vni_times');
$p->AddFont('vni_times', 'B');
$p->AddFont('vni_times', 'I');
$p->AddFont('vni_times', 'BI');

$p->SetMargins(1,1,1);
$p->AddPage();
$p->defaultFontFamily = 'Arial';
$p->defaultFontStyle  = '';
$p->defaultFontSize   = '11';

$p->SetFont($p->defaultFontFamily, $p->defaultFontStyle, $p->defaultFontSize);

$p->htmltable($content);
$p->output($table_name.'.pdf','D');
?>