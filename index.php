<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Memphis Fried Chicken</title>
	<link rel="icon" href="logo_mfc.jpg">
	<link rel="stylesheet" href="bootstrap.css">
</head>
<body>

<?php
// Atur zona waktu ke WIB (Jakarta)
date_default_timezone_set('Asia/Jakarta');

// Daftar cabang restoran
$cabangList = ["Cikarang", "Bekasi", "Karawang", "Bogor"];
sort($cabangList);
?>

<div class="container border mt-4 p-4">
	<div class="text-center mb-3">
		<img src="logo_mfc.JPG" alt="Logo MFC" width="150">
		<h2>Form Pemesanan</h2>
	</div>

	<form action="index.php" method="post">
		<div class="row mb-3">
			<div class="col-lg-4">Cabang:</div>
			<div class="col-lg-8">
				<select name="cabang" class="form-control" required>
					<?php
					foreach ($cabangList as $cb) {
						echo "<option value='$cb'>$cb</option>";
					}
					?>
				</select>
			</div>
		</div>

		<div class="row mb-2">
			<div class="col-lg-4">Jumlah Dada Ayam:</div>
			<div class="col-lg-8">
				<input type="number" name="dada" class="form-control" min="0" required>
			</div>
		</div>

		<div class="row mb-2">
			<div class="col-lg-4">Jumlah Paha Ayam:</div>
			<div class="col-lg-8">
				<input type="number" name="paha" class="form-control" min="0" required>
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-4">Jumlah Nasi:</div>
			<div class="col-lg-8">
				<input type="number" name="nasi" class="form-control" min="0" required>
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-4">Teknik Menggoreng:</div>
			<div class="col-lg-8">
				<input type="radio" name="speedfry" value="false" checked> Normal
				<input type="radio" name="speedfry" value="true"> Speed Fry (+Rp 3000)
			</div>
		</div>

		<div class="row mb-3 text-center">
			<button type="submit" name="hitung" class="btn btn-primary">Hitung Total</button>
		</div>
	</form>
</div>

<?php
if(isset($_POST['hitung'])) {

	// Ambil input dari form
	$jmlDada = (int) $_POST['dada'];
	$jmlPaha = (int) $_POST['paha'];
	$jmlNasi = (int) $_POST['nasi'];
	$cabang = $_POST['cabang'];
	$speedFry = ($_POST['speedfry'] == "true");

	// Harga dasar
	$hrgDada = 11000;
	$hrgPaha = 8000;
	$hrgNasi = 5000;

	// Cabang Cikarang dikenai tambahan harga
	if ($cabang == "Cikarang") {
		$hrgDada += 1000;
		$hrgPaha += 1000;
		$hrgNasi += 1000;
	}

	// Jika menggunakan speed fry, tambah biaya
	if ($speedFry) {
		$hrgDada += 3000;
		$hrgPaha += 3000;
	}

	// Fungsi hitung total per item
	function hitung_total_harga_item($jumlah, $harga) {
		return $jumlah * $harga;
	}

	// Hitung total tiap item
	$totDada = hitung_total_harga_item($jmlDada, $hrgDada);
	$totPaha = hitung_total_harga_item($jmlPaha, $hrgPaha);
	$totNasi = hitung_total_harga_item($jmlNasi, $hrgNasi);

	// Hitung total keseluruhan
	$totalHarga = $totDada + $totPaha + $totNasi;

	// Simpan ke file JSON
	$berkas = "data.json";
	$dataLama = file_exists($berkas) ? json_decode(file_get_contents($berkas), true) : [];

	$dataBaru = [
		"Cabang" => $cabang,
		"Dada" => $jmlDada,
		"Paha" => $jmlPaha,
		"Nasi" => $jmlNasi,
		"SpeedFry" => $speedFry,
		"Total" => $totalHarga,
		"Tanggal" => date("d-m-Y H:i:s") . " WIB"
	];

	$dataLama[] = $dataBaru;
	file_put_contents($berkas, json_encode($dataLama, JSON_PRETTY_PRINT));

	// Tampilkan hasil perhitungan
	echo "
	<br>
	<div class='container border p-3'>
		<h3>Hasil Perhitungan</h3><hr>

		<div class='row'>
			<div class='col-lg-5'>Cabang:</div>
			<div class='col-lg-5'>$cabang</div>
		</div>

		<div class='row'>
			<div class='col-lg-5'>Menggunakan teknik speed fry:</div>
			<div class='col-lg-5'>".($speedFry ? 'Ya' : 'Tidak')."</div>
		</div><br>

		<div class='row'>
			<div class='col-lg-5'>Jumlah Dada Ayam:</div>
			<div class='col-lg-5'>$jmlDada</div>
		</div>
		<div class='row'>
			<div class='col-lg-5'>Harga Satuan Dada Ayam:</div>
			<div class='col-lg-5'>Rp $hrgDada</div>
		</div>
		<div class='row'>
			<div class='col-lg-5'>Total Harga Dada Ayam:</div>
			<div class='col-lg-5'>Rp $totDada</div>
		</div><br>

		<div class='row'>
			<div class='col-lg-5'>Jumlah Paha Ayam:</div>
			<div class='col-lg-5'>$jmlPaha</div>
		</div>
		<div class='row'>
			<div class='col-lg-5'>Harga Satuan Paha Ayam:</div>
			<div class='col-lg-5'>Rp $hrgPaha</div>
		</div>
		<div class='row'>
			<div class='col-lg-5'>Total Harga Paha Ayam:</div>
			<div class='col-lg-5'>Rp $totPaha</div>
		</div><br>

		<div class='row'>
			<div class='col-lg-5'>Jumlah Nasi:</div>
			<div class='col-lg-5'>$jmlNasi</div>
		</div>
		<div class='row'>
			<div class='col-lg-5'>Harga Satuan Nasi:</div>
			<div class='col-lg-5'>Rp $hrgNasi</div>
		</div>
		<div class='row'>
			<div class='col-lg-5'>Total Harga Nasi:</div>
			<div class='col-lg-5'>Rp $totNasi</div>
		</div><br>

		<div class='row'>
			<div class='col-lg-5'><b>Total Harga Keseluruhan:</b></div>
			<div class='col-lg-5'><b>Rp ".number_format($totalHarga,0,',','.')."</b></div>
		</div>

		<div class='row mt-3'>
			<div class='col-lg-5'>Waktu Pemesanan:</div>
			<div class='col-lg-5'>".date('d-m-Y H:i:s')." WIB</div>
		</div>
	</div>
	";
}
?>

<div class="text-center mt-4 mb-5">
  <a href="datapesanan.php" class="btn btn-primary">Lihat Riwayat Pembelian</a>
</div>

</body>
</html>