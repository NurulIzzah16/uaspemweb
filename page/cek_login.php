<?php
include '../system/config/koneksi.php';

if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

    // Query untuk memeriksa admin
    $data_admin = mysqli_query($conn, "SELECT * FROM admin WHERE nama = '$user' AND password = '$pass'");
    // Query untuk memeriksa nasabah
    $data_nasabah = mysqli_query($conn, "SELECT * FROM nasabah WHERE nama = '$user' AND password = '$pass'");

    $a = mysqli_fetch_array($data_admin);
    $n = mysqli_fetch_array($data_nasabah);

    $cek_admin = mysqli_num_rows($data_admin);
    $cek_nasabah = mysqli_num_rows($data_nasabah);

    if ($user == "" || $pass == "") {
        echo "
        <script>
            alert('Username dan Password tidak boleh kosong!');
            document.location.href ='login.php';
        </script>
        ";
    } else {
        if ($cek_admin > 0) {
            session_start();
            $_SESSION['id'] = $a['id'];
            $_SESSION['nama'] = $a['nama'];
            $_SESSION['email'] = $a['email'];
            $_SESSION['pass'] = $a['password'];
            $_SESSION['telepon'] = $a['telepon'];
            echo "
            <script>
                alert('Selamat Anda berhasil login sebagai admin!');
                document.location.href ='admin.php';
            </script>
            ";
        } elseif ($cek_nasabah > 0) {
            session_start();
            $_SESSION['id'] = $n['id'];
            $_SESSION['nama'] = $n['nama'];
            $_SESSION['email'] = $n['email'];
            $_SESSION['pass'] = $n['password'];
            $_SESSION['telepon'] = $n['no_telepon'];
            $_SESSION['alamat'] = $n['alamat'];
            $_SESSION['saldo'] = $n['saldo'];
            $_SESSION['sampah'] = $n['sampah'];
            echo "
            <script>
                alert('Selamat Anda berhasil login sebagai nasabah!');
                document.location.href ='nasabah.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Maaf username dan password tidak valid!');
                document.location.href ='login.php';
            </script>
            ";
        }
    }
} else {
    header('location:login.php');
}
?>
