<?php
/**
 * Created by PhpStorm.
 * User: ederlo
 * Date: 05/10/16
 * Time: 21:27
 */

require_once 'vendor/autoload.php';


class EdataPdf extends TCPDF
{
    public function Header()
    {
        $image = 'logo.jpg';
        $this->Image($image, 16, 10, 40, '', 'JPG', '', 'T', false, 300, false, false, 0, false, false, false);
        $this->SetFont('helvetica', 'B', 20);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new EdataPdf();
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

$img = file_get_contents('http://img.cinemablend.com/cb/0/f/c/5/9/e/0fc59efffd13d661c3231986d2d7c60b4cb03b10a15b266dd6694c0326a224a2.jpg');
$imgdata = base64_decode(base64_encode($img));
$pdf->Image('@' . $imgdata, 16, 10);