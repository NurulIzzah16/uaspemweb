<?php 
require_once ('../config/koneksi.php');

// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");


 
// Mendefinisikan nama file ekspor "hasil-export.xls"
$filename = "excel-tarik (".date('d-m-Y').").xls";
header("Content-Disposition: attachment; filename=$filename");
 	 ?>

<h2 style="font-size: 30px; color: #262626;">Data Tarik Saldo</h2>
	<br>
	<table id="example" class="display" cellspacing="0" width="100%" border="0" >
	<tr>
		<th>No</th>
        <th>ID Tarik</th>
        <th>Tanggal Penarikan</th>
        <th>Nomor ID Nasabah</th>
        <th>Saldo (Rp)</th>
        <th>Jumlah Tarik</th>
        <th>Nomor ID Admin</th>
    </tr>
    <?php
            $no = 0;
            $query = mysqli_query($conn, "SELECT * FROM tarik ORDER BY id ASC");
            while($row = mysqli_fetch_assoc($query)){$no++;
        ?>
        <tr align="center">
            <td><?php echo "$no" ?></td>
            <td><?php echo $row['id'] ?></td>
            <td><?php echo $row['tanggal_tarik'] ?></td>
            <td><?php echo $row['id_nasabah'] ?></td>
            <td><?php echo $row['saldo'] ?></td>
            <td><?php echo $row['jumlah_tarik'] ?></td>
            <td><?php echo $row['id_admin'] ?></td>
        </tr>
        <?php } ?>
</table>
