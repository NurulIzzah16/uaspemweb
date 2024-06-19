<?php
 require_once("../config/koneksi.php");
 $id = $_GET['id'];

 // Hapus data terkait di tabel setor
 $query_setor = "DELETE FROM setor WHERE id_nasabah = '$id'";
 mysqli_query($conn, $query_setor);

 // Hapus data terkait di tabel tarik
 $query_tarik = "DELETE FROM tarik WHERE id_nasabah = '$id'";
 mysqli_query($conn, $query_tarik);

 // Hapus data nasabah
 $query_nasabah = "DELETE FROM nasabah WHERE id = '$id'";
 mysqli_query($conn, $query_nasabah);

 echo "<meta http-equiv='refresh' content='0; url=http://localhost/pilah_cantik/page/admin.php?page=data-nasabah-full'>";
?>
