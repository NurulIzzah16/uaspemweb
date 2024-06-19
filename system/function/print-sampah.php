<?php
ob_start();
?>
<!DOCTYPE html>
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
        padding: 15px 13px;
        font-weight: 300;
      }

   img{
    width: 100px;
    height: 50px;
    }
   </style>

</head>
<body>

  
<h1 align="center">LAPORAN DATA SAMPAH</h1>
<table align="center" cellspacing="0">
<thead>
<tr>
  <th>JENIS SAMPAH</th>
  <th>SATUAN</th>
  <th>HARGA</th>
  <th>GAMBAR</th>
  <th>DESKRIPSI</th>
</tr>
</thead>

<tbody>
<?php
// Load file koneksi.php
require_once ('../config/koneksi.php');
 
$query = "SELECT * FROM sampah"; // Tampilkan semua data gambar
$sql = mysqli_query($conn, $query); // Eksekusi/Jalankan query dari variabel $query
$row = mysqli_num_rows($sql); // Ambil jumlah data dari hasil eksekusi $sql
    
    while($data = mysqli_fetch_array($sql)){// Ambil semua data dari hasil eksekusi $sql 
      ?>
        <tr align="center">
          <td><?php echo $data['jenis_sampah'] ?></td>
          <td><?php echo $data['satuan'] ?></td>
          <td><?php echo "Rp. ".number_format($data['harga'], 2, ",", ".")  ?></td>
          <td> <img src="../../asset/internal/img/uploads/<?php echo $data['gambar'] ?>"> </td>
          <td><?php echo $data['deskripsi'] ?></td>
        </tr>
<?php } ?>
</tbody>
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
$filename = "Data-Sampah-(".date('d-m-Y').").pdf";
$pdf->Output($filename, 'D');
?>
