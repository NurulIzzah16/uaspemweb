<?php
if (isset($_POST['simpan'])) {
  require_once("../system/config/koneksi.php");
  $tanggal_setor = $_POST['tanggal_setor'];
  $id_nasabah = $_POST['id_nasabah'];
  $jenis_sampah = $_POST['jenis_sampah'];
  $berat = $_POST['berat'];
  $harga = $_POST['harga'];
  $total = $_POST['total'];
  $id_admin = $_POST['id_admin'];
  $query = "INSERT INTO setor(id,tanggal_setor,id_nasabah,jenis_sampah,berat,harga,total,id_admin) VALUE (NULL, '$tanggal_setor', '$id_nasabah', '$jenis_sampah', '$berat', '$harga', '$total', '$id_admin')";
  $queryact = mysqli_query($conn, $query);

  echo "<script>alert('Selamat berhasil input data!')</script>";
  echo "<meta http-equiv='refresh' content='0; url=http://localhost/pilah_cantik/page/admin.php?page=data-setor'>";
}
?>

<html>
<head>
  <title>Homepage</title>
  <script type="text/javascript" src="../asset/plugin/datepicker/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../asset/plugin/datepicker/css/jquery.datepick.css"> 
  <script type="text/javascript" src="../asset/plugin/datepicker/js/jquery.plugin.js"></script> 
  <script type="text/javascript" src="../asset/plugin/datepicker/js/jquery.datepick.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
  <style>
    label {
      font-family: Montserrat;
      font-size: 18px;
      display: block;
      color: #262626;
    }
    input[type=text], input[type=password] {
      border-radius: 5px;
      width: 40%;
      height: 35px;
      background: #eee;
      padding: 0 10px;
      box-shadow: 1px 2px 2px 1px #ccc;
      color: #262626;
    }
    select {
      border-radius: 5px;
      width: 42%;
      height: 39px;
      background: #eee;
      padding: 0 10px;
      box-shadow: 1px 2px 2px 1px #ccc;
      color: #262626;
    }
    input[type=submit] {
      height: 35px;
      width: 200px;
      background: #8cd91a;
      border-radius: 20px;
      color: #fff;
      margin-top: 20px;
      cursor: pointer;
    }
    input, select {
      font-family: Montserrat;
      font-size: 16px;
    }
    .form-group {
      padding: 5px 0;
    }
  </style>  

  <script type="text/javascript">
    function cek_data() {
      var x = daftar_user.tanggal_setor.value;
      if(x == "") {
        alert("Maaf harap input tanggal setor!");
        daftar_user.tanggal_setor.focus(); 
        return false;
      }
      var pnin = daftar_user.id_nasabah.value;
      if (pnin == "pnin") {
        alert("Maaf harap input nomor induk nasabah!");
        return false;
      }
      var pjs = daftar_user.jenis_sampah.value;
      if (pjs == "pjs") {
        alert("Maaf harap input jenis sampah!");
        return false;
      }
      var x = daftar_user.berat.value;
      var angka = /^[0-9]+$/;
      if(x == "") {
        alert("Maaf harap input berat sampah!");
        daftar_user.berat.focus(); 
        return false;
      }
      if (!x.match(angka)) {
        alert("Berat sampah harus di input angka!");
        daftar_user.berat.focus();
        return false;
      }
      var x = daftar_user.harga.value;
      if(x == "") {
        alert("Maaf harga sampah masih kosong!");
        daftar_user.harga.focus(); 
        return false;
      }
      var x = daftar_user.total.value;
      if(x == "") {
        alert("Maaf total transaksi penyetoran masih kosong!");
        daftar_user.total.focus(); 
        return false;
      } else {
        confirm("Apakah Anda yakin sudah input data dengan benar?");
      }
      return true;
    }

    function changeValue(jenis_sampah){
      document.getElementById('harga').value = dtsampah[jenis_sampah].harga;
      sum();
    };

    function sum() {
      var txtFirstNumberValue = document.getElementById('berat').value;
      var txtSecondNumberValue = document.getElementById('harga').value;
      var result = parseInt(txtFirstNumberValue) * parseInt(txtSecondNumberValue);
      if (!isNaN(result)) {
        document.getElementById('total').value = result;
      }
    }
  </script>
</head>

<body>
  <h2 style="font-size: 30px; color: #262626;">Setor Sampah</h2>
  <form id="daftar_user" name='autoSumForm' action="" method="post" onsubmit="return cek_data()">
    <div class="form-group">
      <label class="text-left">Tanggal Penyetoran</label>
      <input type="text" placeholder="Masukan tanggal setor" id="date" name="tanggal_setor" />
      <script type="text/javascript">  $('#date').datepick({dateFormat: 'yyyy-mm-dd'});</script>  
    </div>
    <div class="form-group">
      <label class="">Nomor ID Nasabah</label>
      <select class="nomornasabah" name="id_nasabah" >
        <option value="pnin">---Pilih ID Nasabah---</option>
        <?php 
          $query = mysqli_query($conn, "SELECT * FROM nasabah");
          while ($row = mysqli_fetch_array($query)) {
            echo '<option value="' . $row['id'] . '">' . $row['id'] . '</option>';
          }
        ?>
      </select>
    </div>
    <div class="form-group">
      <label class="">Jenis Sampah</label>
      <select class="jensampah" name="jenis_sampah" id="jenis_sampah" onchange="changeValue(this.value)" >
        <option value="pjs">---Pilih Jenis Sampah---</option>
        <?php 
          $query = mysqli_query($conn, "SELECT * FROM sampah");
          $jsArray = "var dtsampah = {};\n";
          while ($row = mysqli_fetch_array($query)) {
            echo '<option value="' . $row['jenis_sampah'] . '">' . $row['jenis_sampah'] . '</option>';    
            $jsArray .= "dtsampah['" . $row['jenis_sampah'] . "'] = {harga:'" . addslashes($row['harga']) . "'};\n";
          }
        ?>
      </select>
    </div>
    <div class="form-group">
      <label class="">Berat Sampah</label>
      <input type="text" placeholder="Masukan berat sampah" id="berat" name="berat" onkeyup="sum();" />
    </div>
    <div class="form-group">
      <label class="">Harga Sampah (Rp)</label>
      <input type="text" placeholder="Otomatis terisi" style="cursor: not-allowed;" id="harga" name="harga" readonly />
    </div>
    <div class="form-group">
      <label class="">Total (Rp)</label>
      <input type="text" placeholder="Otomatis terisi" style="cursor: not-allowed;" id="total" name="total" readonly />
    </div>
    <div class="form-group">
      <label class="">Nomor Induk Admin</label>
      <input type="text" style="cursor: not-allowed;" name="id_admin" value="<?php echo $_SESSION['id']; ?>" readonly />
    </div>
    <input type="submit" name="simpan" value="Simpan" />
    <div id="insert-form"></div>
    <hr>
  </form>
  <input type="hidden" id="jumlah-form" value="1">
  <script>
    <?php echo $jsArray; ?>
    $(document).ready(function() {
      $('.nomornasabah').select2();
      $('.jensampah').select2();
    });
  </script>
</body>
</html>
