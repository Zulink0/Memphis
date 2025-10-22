# Memphis Fried Chicken
### Sistem Pemesanan dan Riwayat Pembelian
Dibuat menggunakan *PHP, **HTML, **CSS (Bootstrap), dan **JSON*  
untuk memenuhi tugas mata kuliah *Pemrograman Web Native*.

---

## Deskripsi Umum

Website ini merupakan sistem sederhana yang digunakan untuk melakukan *pemesanan makanan* di restoran Memphis Fried Chicken (MFC).  
Pengguna dapat memilih cabang restoran, jumlah menu, metode menggoreng, serta langsung melihat hasil perhitungan total harga.  
Setiap transaksi akan disimpan ke dalam file data.json, dan bisa dilihat kembali melalui halaman *Riwayat Pembelian*.

---

## ⚙ Fitur Website

### 1. **Form Pemesanan (index.php)**
- Pengguna dapat:
  - Memilih *cabang restoran* (Cikarang, Bekasi, Karawang, Bogor)
  - Mengisi *jumlah dada ayam, **paha ayam, dan **nasi*
  - Memilih teknik menggoreng:  
    - Normal  
    - Speed Fry (+Rp 3.000 per ayam)
- Menghitung total harga berdasarkan input pengguna.
- Menampilkan total per-item dan total keseluruhan.
- Menyimpan hasil transaksi ke data.json secara otomatis.
- Mencatat *tanggal & waktu pembelian (zona waktu WIB / Asia/Jakarta)*.
- Tersedia tombol untuk membuka *Riwayat Pembelian*.

---

### 2. **Riwayat Pembelian (datapesanan.php)**
- Menampilkan daftar seluruh pesanan dari data.json.
- Menampilkan informasi lengkap:
  - Nomor pesanan
  - Tanggal & waktu transaksi (WIB)
  - Cabang restoran
  - Jumlah menu
  - Status Speed Fry
  - Total harga (Rp)
- Tersedia tombol:
  -  *Kembali ke Form Pemesanan*
  -  *Hapus Semua Riwayat* (mengosongkan seluruh isi data.json)
- Jika file kosong → tampil pesan “Belum ada data pembelian.”

---

## Format Penyimpanan Data (data.json)

Setiap kali pengguna melakukan pemesanan, data akan disimpan dalam file data.json  
dengan format *JSON* seperti berikut:

```json
[
    {
        "Cabang": "Bekasi",
        "Dada": 2,
        "Paha": 2,
        "Nasi": 2,
        "SpeedFry": true,
        "Total": 60000,
        "Tanggal": "22-10-2025 07:09:48 WIB"
    }
]