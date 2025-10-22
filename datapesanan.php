<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Riwayat Pembelian - Memphis Fried Chicken</title>

  <!-- Ikon website -->
  <link rel="icon" href="logo_mfc.jpg">

  <!-- Import CSS Bootstrap -->
  <link rel="stylesheet" href="bootstrap.css">

  <!-- Styling tambahan -->
  <style>
    body {
      background-color: #f8f9fa;
    }
    table {
      border-radius: 10px;
      overflow: hidden;
    }
  </style>
</head>
<body>

<!-- Container utama -->
<div class="container mt-4 border p-4 bg-white shadow-sm rounded">
  <div class="text-center mb-4">
    <img src="logo_mfc.JPG" alt="Logo MFC" width="120">
    <h2 class="mt-2">Riwayat Pembelian</h2>
    <hr>
  </div>

  <!-- Tombol navigasi -->
  <div class="mb-3 text-center">
    <!-- Kembali ke form utama -->
    <a href="index.php" class="btn btn-primary me-2">Kembali ke Form Pemesanan</a>
    <!-- Hapus semua data -->
    <a href="datapesanan.php?clear=1" class="btn btn-danger" 
       onclick="return confirm('Yakin ingin menghapus semua riwayat pembelian?')">
       Hapus Semua Riwayat
    </a>
  </div>

  <?php
  // Nama file tempat data disimpan
  $file = 'data.json';

  // Jika tombol "Hapus Semua Riwayat" ditekan
  if (isset($_GET['clear'])) {
      // Kosongkan file data.json
      file_put_contents($file, json_encode([], JSON_PRETTY_PRINT));
      // Tampilkan pesan sukses
      echo "<div class='alert alert-success text-center'>
              ✅ Semua riwayat pembelian berhasil dihapus.
            </div>";
  }

  // Periksa apakah file data.json ada
  if (file_exists($file)) {
      // Baca isi file dan ubah menjadi array PHP
      $data = json_decode(file_get_contents($file), true);

      // Jika data kosong / belum ada transaksi
      if (empty($data)) {
          echo "<div class='alert alert-warning text-center'>
                  ⚠ Belum ada data pembelian.
                </div>";
      } 
      // Jika ada data, tampilkan dalam bentuk tabel
      else {
          echo "
          <table class='table table-bordered table-striped'>
            <thead class='table-dark'>
              <tr>
                <th>No</th>
                <th>Tanggal & Waktu (WIB)</th>
                <th>Cabang</th>
                <th>Jumlah Dada</th>
                <th>Jumlah Paha</th>
                <th>Jumlah Nasi</th>
                <th>Speed Fry</th>
                <th>Total Harga (Rp)</th>
              </tr>
            </thead>
            <tbody>
          ";

          $no = 1; // nomor urut data

          // Looping semua data pesanan dari file JSON
          foreach ($data as $pesanan) {
              // Jika ada kolom "Tanggal", ambil datanya, jika tidak ada tampilkan "-"
              $tanggal = isset($pesanan['Tanggal']) ? $pesanan['Tanggal'] : '-';
              $cabang = htmlspecialchars($pesanan['Cabang']); // mengamankan teks dari karakter berbahaya
              $dada = (int)$pesanan['Dada']; // konversi ke integer
              $paha = (int)$pesanan['Paha'];
              $nasi = (int)$pesanan['Nasi'];
              $speedFry = $pesanan['SpeedFry'] ? 'Ya' : 'Tidak'; // ubah boolean jadi teks
              $total = number_format($pesanan['Total'], 0, ',', '.'); // format angka jadi ribuan

              // Cetak baris tabel
              echo "
              <tr>
                <td>{$no}</td>
                <td>{$tanggal}</td>
                <td>{$cabang}</td>
                <td>{$dada}</td>
                <td>{$paha}</td>
                <td>{$nasi}</td>
                <td>{$speedFry}</td>
                <td>{$total}</td>
              </tr>
              ";
              $no++;
          }

          // Tutup tabel
          echo "
            </tbody>
          </table>
          ";
      }
  } 
  // Jika file tidak ditemukan
  else {
      echo "<div class='alert alert-danger text-center'>
              ❌ File <b>data.json</b> tidak ditemukan!
            </div>";
  }
  ?>

</div>

</body>
</html>