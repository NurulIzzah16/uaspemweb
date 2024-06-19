<?php ob_start(); ?>
<html>
<head>
  <title>Cetak PDF</title>
  <link rel="shortcut icon" href="../../asset/internal/img/img-local/favicon.ico">
    
   <style>

     h1{
      color: #262626;
     }
     table {
      max-width: 960px;
      margin: 10px auto;
     }

      thead th {
        font-weight: 400;
        background: #8a97a0;
        color: #FFF;
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
        padding: 10px 15px;
        font-weight: 300;
      }
   
   </style>

</head>
<body>
  
<h1 align="center">DATA PENARIKAN SALDO</h1>
<table align="center" cellspacing='0'>
<thead>
<tr>
  <th>NO</th>
  <th>ID</th>
  <th>TANGGAL TARIK</th>
  <th>ID NASABAH</th>
  <th>JUMLAH TARIK</th>
  <th>ID ADMIN</th>
</tr>
</thead>


<?php
// Load file koneksi.php
require_once ('../config/koneksi.php');
 
$query = "SELECT * FROM tarik"; // Tampilkan semua data gambar
$sql = mysqli_query($conn, $query); // Eksekusi/Jalankan query dari variabel $query
$row = mysqli_num_rows($sql); // Ambil jumlah data dari hasil eksekusi $sql
    
    $no = 0;
    while($data = mysqli_fetch_array($sql)){$no++;// Ambil semua data dari hasil eksekusi $sql 
      ?>
        <tbody>
        <tr>
          <td><?php echo "$no" ?></td>
          <td><?php echo $data['id'] ?></td>
          <td><?php echo $data['tanggal_tarik'] ?></td>
          <td><?php echo $data['id_nasabah'] ?></td>
          <td><?php echo "Rp. ".number_format($data['jumlah_tarik'], 2, ",", ".")  ?></td>
          <td><?php echo $data['id_admin'] ?></td>
        </tr>
        </tbody>

<?php } ?>

</table>
</body>
</html>

<?php
$html = ob_get_clean();
        
require_once("../../asset/plugin/html2pdf/tcpdf.php");
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Title');
$pdf->SetSubject('Subject');
$pdf->SetKeywords('Keywords');
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
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
$filename = "Data-Setor-(".date('d-m-Y').").pdf";
$pdf->Output($filename, 'D');
?>