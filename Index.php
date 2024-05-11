<?php
// Harga bahan bakar per liter untuk setiap jenis
$harga_per_liter = [
    "Shell Super" => 15420,
    "Shell V-Power" => 16130,
    "Shell V-Power Diesel" => 18310,
    "Shell V-Power Nitro" => 16510
];

// PPN
$ppn = 0.1;

// Inisialisasi variabel hasil dan info
$hasil = "";
$info = "";

class Shell {
    public $jenis;
    public $harga;
    public $jumlah;
    public $ppn;

    function __construct($jenis, $harga, $jumlah, $ppn) {
        $this->jenis = $jenis;
        $this->harga = $harga;
        $this->jumlah = $jumlah;
        $this->ppn = $ppn;
    }
}

class Beli extends Shell {
    function totalHarga() {
        $total = ($this->harga * $this->jumlah) + ($this->harga * $this->jumlah * $this->ppn);
        return $total;
    }
}

// Proses input dan hitung total biaya jika tombol 'hitung' ditekan
if(isset($_POST['submit'])) {
    // Memastikan semua input diisi
    if(!empty($_POST['nama_pelanggan']) && !empty($_POST['jumlah_liter']) && !empty($_POST['bahan_bakar'])) {
        $nama_pelanggan = $_POST['nama_pelanggan'];
        $jumlah_liter = $_POST['jumlah_liter'];
        $bahan_bakar = $_POST['bahan_bakar'];

        // Fungsi untuk menghitung total biaya pembelian
        function hitungBiayaPembelian($nama_pelanggan, $jumlah_liter, $bahan_bakar)
        {
            global $harga_per_liter, $ppn; // Menggunakan variabel global $harga_per_liter dan $ppn

            // Membuat objek Shell untuk jenis bahan bakar yang dipilih
            $pembelian = new Beli($bahan_bakar, $harga_per_liter[$bahan_bakar], $jumlah_liter, $ppn);

            return $pembelian->totalHarga();
        }

        // Hitung total biaya pembelian
        $hasil = hitungBiayaPembelian($nama_pelanggan, $jumlah_liter, $bahan_bakar);

        // Menampilkan informasi sesuai kebutuhan
        if($hasil > 0) {
            $info .= "Anda membeli bahan bakar ".$bahan_bakar." sebanyak ".$jumlah_liter." liter dengan total yang harus dibayar adalah Rp. " . number_format($hasil, 0, ',', '.') . ",-";
        } else {
            $info = "Input tidak valid";
        }
    } else {
        $info = "Semua input harus diisi";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pembelian Bahan Bakar</title>
    <style>
        body {
            background: #f2f2f2;
            font-family: sans-serif;
        }

        .input-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .input-container .h21 {
            margin-right: 20px;
            flex: 0 0 auto; /* Menetapkan ukuran yang tetap untuk judul */
        }

        .input-container .bil1,
        .input-container .bil2,
        .opt {
            width: 100%;
            border: none;
            font-size: 16pt;
            border-radius: 5px;
            padding: 10px;
            margin: 5px;
        }

        .kalkulator {
            width: 400px;
            margin: 100px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 10px 20px 0px #d1d1d1;
            background-color: white;
        }

        .tombol {
            background: lightgreen;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            color: rgb(29, 27, 27);
            font-size: 15pt;
            margin-top: 20px;
            cursor: pointer;
        }

        .judul {
            text-align: center;
            color: black;
            font-weight: normal;
            margin-top: 50px;
            font-size: 3rem;
        }

        .hasil-container {
            text-align: center;
        }

        .info {
            text-align: center;
            font-size: 1.2rem;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<h2 class="judul">Pembelian Bahan Bakar</h2>
<div class="kalkulator">
    <form method="post" action="">
        <div class="container">
            <div class="input-container">
                <h2 class="h21">Nama Pelanggan:</h2>
                <input type="text" name="nama_pelanggan" class="bil1" autocomplete="off" placeholder="Masukkan nama pelanggan">
            </div>
            <div class="input-container">
                <h2 class="h21">Jumlah Liter:</h2>
                <input type="number" name="jumlah_liter" class="bil2" autocomplete="off" placeholder="Masukkan jumlah liter">
            </div>
        </div>
        <div class="container">
            <h2 class="h21">Jenis Bahan Bakar</h2>
            <select class="opt" name="bahan_bakar">
                <option value="Shell Super">Shell Super</option>
                <option value="Shell V-Power">Shell V-Power</option>
                <option value="Shell V-Power Diesel">Shell V-Power Diesel</option>
                <option value="Shell V-Power Nitro">Shell V-Power Nitro</option>
            </select>
        </div>
        <div class="container">
            <input type="submit" name="submit" value="Submit" class="tombol">
        </div>
    </form>
    <?php if(isset($_POST['submit'])){ ?>
    <div class="hasil-container">
        <p class="info"><?php echo $info; ?></p>
    </div>
<?php  } ?>

</div>
</body>
</html>
