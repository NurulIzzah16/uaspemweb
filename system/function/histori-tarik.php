<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Histori Tarik Nasabah</title>
    <link rel="stylesheet" type="text/css" href="../datatables/css/jquery.dataTables.css">
    <style>
        label {
            font-family: Montserrat;
            font-size: 18px;
            display: block;
            color: #262626;
        }
    </style>
</head>
<body>
    <h2 style="font-size: 30px; color: #262626;">Histori Tarik Nasabah</h2>
    <br>
    <table id="example" class="display" cellspacing="0" width="100%" border="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Saldo (Rp)</th>
                <th>Jumlah Tarik</th>
                <th>ID Nasabah</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            //session_start();
            include '../system/config/koneksi.php';
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            $no = 0; 
            $query = mysqli_query($conn, "SELECT * FROM tarik WHERE id_nasabah='".$_SESSION['id']."' ORDER BY id DESC");
            while ($row = mysqli_fetch_array($query)) {
                $no++;
            ?>
            <tr align="center">
                <td><?php echo $no; ?></td>
                <td><?php echo $row['tanggal_tarik']; ?></td>
                <td><?php echo "Rp. ".number_format($row['saldo'], 2, ",", "."); ?></td>
                <td><?php echo "Rp. ".number_format($row['jumlah_tarik'], 2, ",", "."); ?></td>
                <td><?php echo $row['id_nasabah']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <br>
    
    <a target="_blank" href="../system/function/print-histori-tarik.php">
        <button><i class="fa fa-print" aria-hidden="true"></i> Cetak</button>
    </a>

    <script type="text/javascript" src="../datatables/js/jquery.min.js"></script>
    <script type="text/javascript" src="../datatables/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
           $('#example').DataTable();
        });
    </script>
</body>
</html>
