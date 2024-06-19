<?php
require_once("../system/config/koneksi.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Nasabah</title>
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
<h2 style="font-size: 30px; color: #262626;">Data Nasabah</h2>
<br>
<table id="example" class="display" cellspacing="0" width="100%" border="0">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nama Nasabah</th>
        <th>Password</th>
        <th>Alamat</th>
        <th>Telepon</th>
        <th>E-mail</th>
        <th>Saldo</th>
        <th>Sampah</th>
        <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $query = mysqli_query($conn, "SELECT * FROM nasabah ORDER BY id ASC");
    while ($row = mysqli_fetch_assoc($query)) {
        ?>
        <tr align="center">
            <td><?php echo $row['id'] ?></td>
            <td><?php echo $row['nama'] ?></td>
            <td><?php echo $row['password'] ?></td>
            <td><?php echo $row['alamat'] ?></td>
            <td><?php echo $row['no_telepon'] ?></td>
            <td><?php echo $row['email'] ?></td>
            <td>
                <?php
                $saldonya = mysqli_query($conn, "SELECT SUM(total) AS totalsaldo FROM setor WHERE id_nasabah='" . $row['id'] . "'");
                $tariknya = mysqli_query($conn, "SELECT SUM(jumlah_tarik) AS totaltarik FROM tarik WHERE id_nasabah='" . $row['id'] . "'");
                $var_saldo = mysqli_fetch_array($saldonya);
                $var_tarik = mysqli_fetch_array($tariknya);
                $tot_saldo_total = ($var_saldo['totalsaldo']) - ($var_tarik['totaltarik']);
                mysqli_query($conn, "UPDATE nasabah SET saldo='$tot_saldo_total' WHERE id='" . $row['id'] . "'");
                ?>
                <?php echo "Rp. " . number_format($tot_saldo_total ?: 0, 2, ",", ".") ?></td>
            <td>
                <?php
                $querysampah = mysqli_query($conn, "SELECT SUM(berat) AS totalberat FROM setor WHERE id_nasabah='" . $row['id'] . "'");
                $rowsampah = mysqli_fetch_array($querysampah);
                $sampahnya = $rowsampah['totalberat'];
                mysqli_query($conn, "UPDATE nasabah SET sampah='$sampahnya' WHERE id='" . $row['id'] . "'");
                ?>
                <?php echo number_format($sampahnya ?: 0) . " Kg" ?></td>
            <td>
                <a href="admin.php?page=edit-nasabah-id&id=<?php echo $row['id']; ?>">
                    <button><i class="fa fa-pencil"></i> Edit</button>
                </a>
                <a onclick="return confirm('Anda yakin ingin menghapus data ini?')"
                   href="../system/function/delete-nasabah.php?id=<?php echo $row['id']; ?>">
                    <button><i class="fa fa-trash-o"></i> Hapus</button>
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<br>
<br>
<a href="admin.php?page=tambah-data-nasabah">
    <button><i class="fa fa-plus" aria-hidden="true"></i> Tambah</button>
</a>
<a target="_blank" href="../system/function/excel-nasabah.php">
    <button><i class="fa fa-print" aria-hidden="true"></i> Excel</button>
</a>
<a target="_blank" href="../system/function/print-nasabah.php">
    <button><i class="fa fa-print" aria-hidden="true"></i> Cetak</button>
</a>

<script type="text/javascript" src="../datatables/js/jquery.min.js"></script>
<script type="text/javascript" src="../datatables/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
</body>
</html>
