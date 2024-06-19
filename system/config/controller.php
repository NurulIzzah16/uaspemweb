<?php
if(isset($id)){
$var_saldo = mysqli_query($conn, "SELECT SUM(total) AS totalsaldo FROM setor WHERE id='".$id."'");
$var_tarik = mysqli_query($conn, "SELECT SUM(jumlah_tarik) AS totaltarik FROM tarik WHERE id='".$id."'");
$tot_saldo = mysqli_fetch_array($var_saldo); $tot_tarik = mysqli_fetch_array($var_tarik);
$tot_saldo_total=$tot_saldo['totalsaldo']-$tot_tarik['totaltarik'];
}