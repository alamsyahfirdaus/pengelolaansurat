<?php 
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    public function Header() {

        $logo = '<img src="'. base_url('assets/img/logo_umtas.png') .'" alt="" style="height: 80px;">';

        $header = <<<EOD
            <table style="width: 100%;" border="0" cellpadding="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width: 15%; text-align: center; border-right: 0.5px solid gray;">{$logo}</td>
                    <td style="width: 85%; text-align: center; padding-top: 0px; margin: 0px;">
                        <p style="font-size: 18px; color: #22228A; line-height: 0.5; margin: 0px; padding: 0px;">UNIVERSITAS MUHAMMADIYAH TASIKMALAYA</p>
                        <p style="font-size: 16px; line-height: 0.5; margin: 0px; padding: 0px;">Fakultas Keguruan dan Ilmu Pendidikan</p>
                        <p style="font-size: 8px; color: gray; line-height: 0.5; margin: 0px; padding: 0px;">Bimbingan Konseling (S1) PG PAUD (S1) PGSD (S1) Pendidikan Teknologi Informasi (S1) Pendidikan Seni Drama, Tari & Musik (S1)</p>
                        <p style="font-size: 10px; padding: 0px; line-height: 0.5; margin: 0px; padding: 0px;">Jl. Tamansari Km. 2,5 Kota Tasikmalaya PO Box 115, Jawa Barat, Indonesia 46196</p>
                        <p style="font-size: 10px; margin: 0px; line-height: 0.5; padding: 0px;">Website : <a href="">www.umtas.ac.id</a></p>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%; text-align: center; padding: 0px; margin: 0px; border-bottom: 1px solid black;" colspan="2"></td>
                </tr>
            </table>
        EOD;

        // $this->Image('assets/img/logo_umtas.png', 20, 3, 22, '', 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetFont('helvetica', 'B', 16);
        $this->SetY(14);
        $this->Cell(0, 20, $this->writeHTML($header, true, 0, true, 0), 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, '', 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle($title);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins('20', '50', '20');
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 11);

// add a page
$pdf->AddPage();

// create some HTML content

$paragraf3 = $surat['paragraf3'] != null ? '<p style="text-align: justify; line-height: 1.5;">'. $surat['paragraf3'] .'</p>' : '';

$jenis_surat = strtoupper($surat['jenis_surat']);

$html = <<<EOD

<table style="width: 100%;">
    <tr>
        <td style="text-align: center; padding-top: 0px;">
            <span style="font-weight: bold; font-size: 15px; text-decoration: underline;"><br>{$jenis_surat}</span>
        </td>
    </tr>
    <tr>
        <td style="text-align: center;">NO:{$surat['nomor_surat']}</td>
    </tr>
</table>

<br>

<p style="text-align: justify; line-height: 1.5;">{$surat['paragraf1']}</p>

<table style="width: 100%;">
  <tr>
    <td style="width: 30%;"><span style="line-height: 1.5;">Nama</span></td>
    <td style="width: 5%;"><span style="line-height: 1.5;">:</span></td>
    <td style="width: 65%;"><span style="line-height: 1.5;">{$surat['nama_lengkap']}</span></td>
  </tr>
  <tr>
    <td style="width: 30%;"><span style="line-height: 1.5;">NIM</span></td>
    <td style="width: 5%;"><span style="line-height: 1.5;">:</span></td>
    <td style="width: 65%;"><span style="line-height: 1.5;">{$surat['nim']}</span></td>
  </tr>
  <tr>
    <td style="width: 30%;"><span style="line-height: 1.5;">Program</span></td>
    <td style="width: 5%;"><span style="line-height: 1.5;">:</span></td>
    <td style="width: 65%;"><span style="line-height: 1.5;">Sarjana</span></td>
  </tr>
  <tr>
    <td style="width: 30%;"><span style="line-height: 1.5;">Program Studi</span></td>
    <td style="width: 5%;"><span style="line-height: 1.5;">:</span></td>
    <td style="width: 65%;"><span style="line-height: 1.5;">{$surat['program_studi']}</span></td>
  </tr>
  <tr>
    <td style="width: 30%;"><span style="line-height: 1.5;">Tahun Masuk</span></td>
    <td style="width: 5%;"><span style="line-height: 1.5;">:</span></td>
    <td style="width: 65%;"><span style="line-height: 1.5;">{$surat['tahun_masuk']}</span></td>
  </tr>
  <tr>
    <td style="width: 30%;"><span style="line-height: 1.5;">Studi Semester ke-</span></td>
    <td style="width: 5%;"><span style="line-height: 1.5;">:</span></td>
    <td style="width: 65%;"><span style="line-height: 1.5;">{$surat['smt_mhs']}</span></td>
  </tr>
  <tr>
    <td style="width: 30%;"><span style="line-height: 1.5;">Tahun Akademik</span></td>
    <td style="width: 5%;"><span style="line-height: 1.5;">:</span></td>
    <td style="width: 65%;"><span style="line-height: 1.5;">{$surat['tahun_akademik']}</span></td>
  </tr>
</table>

<p style="text-align: justify; line-height: 1.5;">{$surat['paragraf2']}</p>

$paragraf3

<table style="width: 100%;">
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr>
        <td></td>
        <td style="text-align: right;">Tasikmalaya, {$surat['tanggal']}</td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align: center;">{$surat['ttd_dekan']}</td>
    </tr>
</table>

EOD;

// output the HTML content
$pdf->writeHTML($html, true, 0, true, 0);
// reset pointer to the last page
$pdf->lastPage();
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output(''. $surat['nomor_surat'] .'.pdf', 'I');