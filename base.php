<?php
/**
 * Created by PhpStorm.
 * User: ederlo
 * Date: 05/10/16
 * Time: 21:27
 */

require_once 'vendor/autoload.php';
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ederlo Rodrigo de Oliveira');
$pdf->SetTitle('Meu primeiro Relatório em PDF');
$pdf->SetSubject('Estudando assuntos relacionados ao TCPDF');
$pdf->SetKeywords('PDF');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData([0, 64, 0], [0, 64, 128]);
$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}
$pdf->setFontSubsetting(true);
$pdf->SetFont('dejavusans', '', 14, '', true);
$pdf->AddPage();
$pdf->setTextShadow(['enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal']);

$html = file_get_contents('http://localhost/relatorios/modelo1.php');
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->Output('Primeiro exemplo', 'I');
