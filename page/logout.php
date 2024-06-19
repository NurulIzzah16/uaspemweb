<?php
 if(!isset($_SESSION['id'])){
session_start();
unset($_SESSION['nama']);
unset($_SESSION['pass']);
unset($_SESSION['telepon']);
unset($_SESSION['id']);
}

header('location:login.php');
?>
