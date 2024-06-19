<?php
 require_once("../config/koneksi.php");
 $id = $_GET['id'];
 $query = "DELETE FROM admin WHERE id = '$id'";
 $queryact = mysqli_query($conn, $query);
 echo "<meta http-equiv='refresh'
        content='0; url=http://localhost/pilah_cantik/page/admin.php?page=data-admin-full'>";
?>