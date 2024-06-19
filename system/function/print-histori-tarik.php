<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cetak PDF</title>
  <link rel="shortcut icon" href="../../asset/internal/img/img-local/favicon.ico">
    
   <style>
   h1 {
      color: #262626;
    }
    table {
      max-width: 960px;
      margin: 10px auto;
      border-collapse: collapse;
    }
    thead th {
      font-weight: 400;
      background: #8a97a0;
      color: #FFF;
      border: 1px solid #FFF;
    }
    tr {
      background: #f4f7f8;
      border-bottom: 1px solid #FFF;
      margin-bottom: 5px;
    }
    tr:nth-child(even) {
      background: #e8eeef;
    }
    th, td {
      text-align: center;
      padding: 15px 20px;
      font-weight: 300;
      border: 1px solid #FFF;
    }
   </style>
</head>
<body>
  
<h1 align="center">DATA PENARIKAN SAMPAH</h1>
<table align="center" cellspacing="0">
<thead>
<tr>
  <th>NO</th>
  <th>TANGGAL TARIK</th>
  <th>SALDO</th>
  <th>JUMLAH TARIK</th>
  <th>ID NASABAH</th>
</tr>
</thead>
<tbody>
<?php
// Load file koneksi.php
require_once ('../config/koneksi.php');

// Pastikan session telah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$query = "SELECT * FROM tarik WHERE id_nasabah='".@$_SESSION['id']."' ORDER BY id DESC"; 
$sql = mysqli_query($conn, $query);
$row = mysqli_num_rows($sql);

$no = 0;
while($data = mysqli_fetch_array($sql)) {
  $no++;
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $data['tanggal_tarik']; ?></td>
    <td><?php echo "Rp. ".number_format($data['saldo'], 2, ",", "."); ?></td>
    <td><?php echo "Rp. ".number_format($data['jumlah_tarik'], 2, ",", "."); ?></td>
    <td><?php echo $data['id_nasabah']; ?></td>
  </tr>
<?php } ?>
</tbody>
</table>
</body>
</html>

<?php
$html = ob_get_contents();
ob_end_clean();
        
require_once("../../asset/plugin/html2pdf/tcpdf.php");
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Data Penarikan Sampah');
$pdf->SetSubject('Laporan');
$pdf->SetKeywords('Data, Sampah, PDF, Laporan');
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Data Penarikan Sampah', 'Bank Sampah Kosmetik Lowayu');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');
$filename = "Data-Penarikan-Sampah-(".date('d-m-Y').").pdf";
$pdf->Output($filename, 'D');
?>
