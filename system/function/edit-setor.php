<?php
require_once("../system/config/koneksi.php");

if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $tanggal_setor = $_POST['tanggal_setor'];
    $jenis_sampah = $_POST['jenis_sampah'];
    $berat = $_POST['berat'];
    $total = $_POST['total'];
    $harga = $_POST['harga'];
    $id_nasabah = $_POST['id_nasabah'];

    // Periksa apakah id_nasabah ada di tabel setor
    $check_query = "SELECT * FROM nasabah WHERE id = '$id_nasabah'";
    $result = mysqli_query($conn, $check_query);
    if(mysqli_num_rows($result) > 0) {
        // Update data setor
        $query = "UPDATE setor SET tanggal_setor = '$tanggal_setor', jenis_sampah = '$jenis_sampah', berat = '$berat', total ='$total', harga = '$harga', id_nasabah = '$id_nasabah' WHERE id='$id'";
        $queryact = mysqli_query($conn, $query);

        if ($queryact) {
            echo "<meta http-equiv='refresh' content='0; url=http://localhost/pilah_cantik/page/admin.php?page=data-setor'>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "ID Nasabah tidak valid";
    }
}
?>

<html>
<head>

  <script type="text/javascript" src="../asset/plugin/datepicker/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../asset/plugin/datepicker/css/jquery.datepick.css"> 
  <script type="text/javascript" src="../asset/plugin/datepicker/js/jquery.plugin.js"></script> 
  <script type="text/javascript" src="../asset/plugin/datepicker/js/jquery.datepick.js"></script>

  
  <!--link datatables-->
    <style>

        label{
        font-family: Montserrat;    
        font-size: 18px;
        display: block;
        color: #262626;
        }

        input[type=text], input[type=password]{
          border-radius: 5px;
          width: 40%;
          height: 35px;
          background: #eee;
          padding: 0 10px;
          box-shadow: 1px 2px 2px 1px #ccc;
          color: #262626;
        }
        
        select{
          border-radius: 5px;
          width: 42%;
          height: 39px;
          background: #eee;
          padding: 0 10px;
          box-shadow: 1px 2px 2px 1px #ccc;
          color: #262626;
        }

        input[type=submit]{
          height: 35px;
          width: 200px;
          background: #8cd91a;
          border-radius: 20px;
          color: #fff;
          margin-top: 20px;
          cursor: pointer;
        }

        input, select{
            font-family: Montserrat;
            font-size: 16px;
        }

        .form-group{
            padding: 5px 0;
        }
    </style>    

<body>
    <h2 style="font-size: 30px; color: #262626;">Edit Data Penyetoran</h2>
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $cek = mysqli_query($conn, "SELECT * FROM setor WHERE id='$id'");
        $row = mysqli_fetch_array($cek);
    ?>
    <form action="" method="post">
    <div class="form-group">
    <label class="text-left">Tanggal Penyetoran</label>
    <input type="text" placeholder="Masukan tanggal setor" id="date"  name="tanggal_setor" value="<?php echo $row['tanggal_setor']; ?>" />
    <script type="text/javascript">$('#date').datepick({dateFormat: 'yyyy-mm-dd'});</script>    
</div>

<div class="form-group">
    <label class="">Nomor ID Nasabah</label>
    <select class="nomornasabah" name="id_nasabah" >
        <?php 
            $query = mysqli_query($conn, "SELECT * FROM nasabah");
            while ($data_nasabah = mysqli_fetch_array($query)) {
                $selected = ($data_nasabah['id'] == $row['id_nasabah']) ? 'selected' : '';
                echo '<option value="' . $data_nasabah['id'] . '" ' . $selected . '>' . $data_nasabah['id'] . '</option>';
            }
        ?>
    </select>
</div>

<div class="form-group">
    <label class="">Jenis Sampah</label>
    <select class="jensampah" name="jenis_sampah" id="jenis_sampah" onchange="changeValue(this.value)" >
        <?php 
            $query = mysqli_query($conn, "SELECT * FROM sampah");
            $jsArray = "var dtsampah = new Array();\n";
            while ($data_sampah = mysqli_fetch_array($query)) {
                $selected = ($data_sampah['jenis_sampah'] == $row['jenis_sampah']) ? 'selected' : '';
                echo '<option value="' . $data_sampah['jenis_sampah'] . '" ' . $selected . '>' . $data_sampah['jenis_sampah'] . '</option>';
                $jsArray .= "dtsampah['" . $data_sampah['jenis_sampah'] . "'] = {harga:'" . addslashes($data_sampah['harga']) . "'};\n";
            }
        ?>
    </select>
</div>

<div class="form-group">
    <label class="">Berat Sampah</label>
    <input type="text" placeholder="Masukan berat sampah" id="berat" name="berat" onkeyup="sum();" value="<?php echo $row['berat']; ?>" />
</div>

<div class="form-group">
    <label class="">Harga Sampah (Rp)</label>
    <input type="text" placeholder="Otomatis terisi" style="cursor: not-allowed;" id="harga" name="harga" value="<?php echo $row['harga']; ?>" readonly />
</div>

<div class="form-group">
    <label class="">Total (Rp)</label>
    <input type="text" placeholder="Otomatis terisi" style="cursor: not-allowed;" id="total"  name="total" value="<?php echo $row['total']; ?>" readonly />
</div>

<div class="form-group">
    <label class="">Nomor Induk Admin</label>
    <input type="text" style="cursor: not-allowed;" name="id_admin" value="<?php echo $_SESSION["id"]; ?>" readonly />
</div>

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
<input class="button" type="submit" name="simpan" value="Simpan Data" />

<script type="text/javascript">
    <?php echo $jsArray; ?>  
    function changeValue(jenis_sampah){
        document.getElementById('harga').value = dtsampah[jenis_sampah]['harga'];
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
    </form>
    <?php
    }
    ?>
</body>
</html>

