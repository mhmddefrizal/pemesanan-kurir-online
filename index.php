<?php
//Instruksi ke-1 Pembuatan Array
$layanan = ["Reguler", "Ekspres", "Same Day", "Instant", "Drone Delivery"];

//Instruksi ke-2 Pengurutan Array
sort($layanan); // Mengurutkan A-Z

//Instruksi ke-6 Fungsi hitung_biaya_kirim beserta komentar untuk menjelaskan fungsi tersebut
// Fungsi untuk menghitung biaya kirim berdasarkan biaya dasar, jarak, dan tarif per km
function hitung_biaya_kirim($biaya_dasar, $jarak, $biaya_per_km) {
  return $biaya_dasar + ($jarak * $biaya_per_km);
}


?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Pemesanan Kurir Online</title>
  <!-- Instruksi ke-4 Hubungkan CSS -->
  <link rel="stylesheet" href="css/bootstrap.css">
</head>

<body>
  <div class="container mt-5">
    <div class="header">
      <!-- Instruksi ke-5 Penambahan Logo -->
      <img src="img/logo.png" alt="Logo" style="height:50px; margin-right:10px;">
      <h1>Pemesanan Kurir Online</h1>
    </div>
    <form action="" method="POST">

      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Anda">
      </div>

      <div class="mb-3">
        <label for="no_hp" class="form-label">No Hp</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan No Hp">
      </div>

      <div class="mb-3">
        <label for="layanan" class="form-label">Jenis Layanan</label>
        <!-- Instruksi ke-3 Pilihan Jenis Layanan menggunakan Dropdown memanfaatkan perulangan array -->
        <select class="form-select" name="layanan" id="layanan">
          <?php
            foreach($layanan as $item){
                echo "<option value=\"$item\">$item</option>";
            }
          ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="jarak" class="form-label">Jarak Pengiriman (km)</label>
        <input type="number" class="form-control" id="jarak" name="jarak" placeholder="Masukkan Jarak">
      </div>

      <button type="submit" class="btn btn-primary" name="hitung">Hitung</button>
    </form>


    <?php 
      if(isset($_POST['hitung'])){
        $nama = $_POST["nama"];
        $no_hp = $_POST["no_hp"];
        $jenis_layanan = $_POST["layanan"];
        $jarak_pengiriman = (int)$_POST["jarak"];

        $total_biaya = 0;
        $hasil = "";

        //Instruksi ke-7 kontrol percabangan untuk menentukan biaya platform dan biaya per km berdasarkan jenis layanan
        //Instruksi ke-8 Simpan biaya dasar dalam variabel $biaya_dasar dan biaya per km dalam $tarif_per_km
        switch ($jenis_layanan) {
          case "Reguler":
            $biaya_dasar = 8000;
            $tarif_per_km = 3000;
            break;
          case "Ekspres":
            $biaya_dasar = 10000;
            $tarif_per_km = 4000;
            break;
          case "Same Day":
            $biaya_dasar = 15000;
            $tarif_per_km = 5000;
            break;
          case "Instant":
            $biaya_dasar = 20000;
            $tarif_per_km = 7000;
            break;
          case "Drone Delivery":
            $biaya_dasar = 30000;
            $tarif_per_km = 10000;
            break;
          default:
            $biaya_dasar = 0;
            $tarif_per_km = 0;
            break;
        }

        

        // Hitung total biaya
        $total_biaya = hitung_biaya_kirim($biaya_dasar, $jarak_pengiriman, $tarif_per_km);

        // Simpan ke file JSON
        $data = [
            "nama" => $nama,
            "no_hp" => $no_hp,
            "layanan" => $jenis_layanan,
            "jarak" => $jarak_pengiriman,
            "total_biaya" => $total_biaya
        ];

        $file = 'data/data.json';
        //Instruksi ke-9 Simpan data pemesanan ke file data.json dalam format JSON
        // Cek apakah file sudah ada dan tidak kosong
        if (file_exists($file) && filesize($file) > 0) {
            $json_data = file_get_contents($file);
            $data_array = json_decode($json_data, true);
        } else {
            $data_array = [];
        }

// Tambahkan data baru ke array
$data_array[] = $data;

// Encode ke JSON dan simpan ulang
file_put_contents($file, json_encode($data_array, JSON_PRETTY_PRINT));

        echo "<div class='alert alert-success mt-4'>
        <h5>Pemesanan Berhasil:</h5>
        <strong>Nama:</strong> " . $nama . "<br>
        <strong>No Hp:</strong> " . $no_hp . "<br>
        <strong>Jenis Layanan:</strong> " . $jenis_layanan . "<br>
        <strong>Jarak:</strong> " . $jarak_pengiriman . " km <br>
        <strong>Total Biaya:</strong> Rp " . number_format($total_biaya, 0, ',', '.')."<br>
        </div>";
      }
    //Instruksi ke-13 Buatlah FILE README yang menjelaskan Deskripsi Aplikasi, Tujuan aplikasi, Cara penggunaan, Struktur folder
  
    ?>
  </div>
</body>

</html>