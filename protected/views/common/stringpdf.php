<?php
session_start();
header('Content-Type: application/pdf');
//header('Content-disposition: attachment;filename='.$_SESSION['pdfname'].'.pdf');
header("Content-Type: application/force-download");
header('Content-Disposition: inline; filename="'.$_SESSION['pdfname'].'.pdf";');
echo $_SESSION['pdfstr'];
?>