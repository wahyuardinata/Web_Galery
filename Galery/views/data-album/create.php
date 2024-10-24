<?php
ob_start(); // Memulai output buffering
include __DIR__ . './../../includes/config.php';
include __DIR__ . './../../includes/header.php';
?>

<div class="card border-radius p-4">
    <!-- Baris judul dan kembali -->
    <div class="row align-item-center">
        <div class="col">
            <h2>Tambah Data Album</h2>
        </div>
        <div class="col text-end">
            <a href="/views/data-album" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </a>
        </div> 
    </div>

    <!-- Form -->
    <div class="row mt-4">
        <div class="col">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="inputNamaAlbum" class="form-label">Nama Album</label>
                    <input type="text" name="name" class="form-control" id="inputNamaAlbum" placeholder="Masukkan Nama Album Foto" required>
                </div>
                <div class="mb-3">
                    <label for="inputDeskripsiAlbum" class="form-label">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control" id="inputDeskripsiAlbum" placeholder="Masukkan Deskripsi Album Foto" required>
                </div>
                <div class="mb-3">
                    <label for="inputTglBuat" class="form-label">Tanggal Buat</label>
                    <input type="date" name="tglBuat" class="form-control" id="inputTglBuat" placeholder="Masukkan Tanggal Buat Album Foto" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-floppy-disk"></i>
                    </button>
                    <button type="reset" class="btn btn-secondary btn-sm">
                        <i class="fa-solid fa-eraser"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Ambil UserID dari session
$UserID = $_SESSION['UserID'];

// Ambil Nama Lengkap pengguna
$sql = "SELECT NamaLengkap FROM user WHERE UserID = :UserID";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':UserID', $UserID);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Ambil nama lengkap
$namaLengkap = $user ? $user['NamaLengkap'] : 'Nama tidak ditemukan';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Atur timezone
    date_default_timezone_set('Asia/Jakarta');

    // Ambil input dari form
    $name = $_POST['name'];
    $deskripsi = $_POST['deskripsi'];
    $tglBuat = $_POST['tglBuat'];

    // Query untuk menyimpan data album
    $sql = "INSERT INTO album (NamaAlbum, Deskripsi, TanggalDibuat, UserID) 
            VALUES (:name, :deskripsi, :tglBuat, :UserID)";
    $stmt = $pdo->prepare($sql);

    // Bind parameter
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->bindParam(':tglBuat', $tglBuat);
    $stmt->bindParam(':UserID', $UserID); // Menggunakan UserID di sini

    // Eksekusi query
    if ($stmt->execute()) {
        // Redirect ke halaman data album setelah berhasil
        header("Location: /views/data-album/index.php");
        exit(); // Hentikan eksekusi setelah header
    } else {
        echo "Gagal menambahkan album.";
    }
}

ob_end_flush(); // Mengirim semua output setelah header diproses
?>

<?php include __DIR__ . './../../includes/footer.php'; ?>
