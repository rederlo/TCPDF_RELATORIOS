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
    public function LoadData($file)
    {
        $lines = file($file);
        $data = [];
        foreach ($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }

    public function ColoredTable($header, $data)
    {
        $this->SetFillColor(23, 210, 225);
        $this->SetTextColor(0);
        $this->SetDrawColor(217, 71,255);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        $w = [40, 35, 40, 45];
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        $this->SetFillColor(217, 71, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
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
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 011', PDF_HEADER_STRING);
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

$pdf->SetFont('helvetica', '', 12);
$pdf->AddPage();
$headers = ['Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)'];
$data = $pdf->LoadData('data.txt');
$pdf->ColoredTable($headers, $data);
$pdf->Output('Tabela_colorida.pdf', 'I');