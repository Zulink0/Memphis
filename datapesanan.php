<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Riwayat Pembelian - Memphis Fried Chicken</title>
  <link rel="icon" href="logo_mfc.jpg">
  <link rel="stylesheet" href="bootstrap.css">
</head>
<body>

<div class="container mt-4 border p-4">
  <div class="text-center mb-4">
    <img src="logo_mfc.JPG" alt="Logo MFC" width="120">
    <h2>Riwayat Pembelian</h2>
    <hr>
  </div>

  <div class="mb-3 text-center">
    <a href="index.php" class="btn btn-primary me-2">Kembali ke Form Pemesanan</a>
    <a href="datapesanan.php?clear=1" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus semua riwayat pembelian?')">Hapus Semua Riwayat</a>
  </div>

  <?php
  $file = 'data.json';

  if (isset($_GET['clear'])) {
      file_put_contents($file, json_encode([], JSON_PRETTY_PRINT));
      echo "<div class='alert alert-success'>Semua riwayat pembelian berhasil dihapus.</div>";
  }

  if (file_exists($file)) {
      $data = json_decode(file_get_contents($file), true);

      if (empty($data)) {
          echo "<div class='alert alert-warning'>Belum ada data pembelian.</div>";
      } else {
          echo "
          <table class='table table-bordered table-striped'>
            <thead class='table-dark'>
              <tr>
                <th>No</th>
                <th>Tanggal & Waktu</th>
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

          $no = 1;
          foreach ($data as $pesanan) {
              $tanggal = isset($pesanan['Tanggal']) ? $pesanan['Tanggal'] : '-';
              echo "
              <tr>
                <td>{$no}</td>
                <td>{$tanggal}</td>
                <td>{$pesanan['Cabang']}</td>
                <td>{$pesanan['Dada']}</td>
                <td>{$pesanan['Paha']}</td>
                <td>{$pesanan['Nasi']}</td>
                <td>" . ($pesanan['SpeedFry'] ? 'Ya' : 'Tidak') . "</td>
                <td>" . number_format($pesanan['Total'], 0, ',', '.') . "</td>
              </tr>
              ";
              $no++;
          }

          echo "
            </tbody>
          </table>
          ";
      }
  } else {
      echo "<div class='alert alert-danger'>File data.json tidak ditemukan!</div>";
  }
  ?>

</div>

</body>
</html>