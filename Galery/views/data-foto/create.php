<?php
include __DIR__. './../../includes/config.php';
include __DIR__. './../../includes/header.php';

$UserID = $_SESSION['UserID']; // Mengambil UserID dari sesi

// Mengambil data album dari database, hanya album yang dibuat oleh UserID yang sedang login
$query = "SELECT a.*, u.NamaLengkap FROM album a JOIN user u ON a.UserID = u.UserID WHERE a.UserID = :UserID";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':UserID', $UserID);
$stmt->execute();
$datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Foto</title>
</head>
<body>

<div class="card border-radius p-4">
    <!-- baris judul dan kembali -->
    <div class="row align-item-center">
        <div class="col">
            <h2>Tambah Foto</h2>
        </div>
        <div class="col text-end">
            <a href="/views/data-foto" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </a>
        </div> 
    </div>

    <!-- form -->
    <div class="row mt-4">
        <div class="col">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="inputJudul" class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" id="inputJudul" placeholder="Masukkan Judul Foto" required>
                </div>
                <div class="mb-3">
                    <label for="inputDeskripsi" class="form-label">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control" id="inputDeskripsi" placeholder="Masukkan Deskripsi Foto" required>
                </div>
                <div class="mb-3">
                    <label for="inputTanggalUnggah" class="form-label">Tanggal Unggah</label>
                    <input type="date" name="tanggalUnggah" class="form-control" id="inputTanggalUnggah" required>
                </div>
                <div class="mb-3">
                    <label for="inputLokasiFile" class="form-label">Unggah Foto</label>
                    <input type="file" name="lokasiFile" class="form-control" id="inputLokasiFile" required>
                </div>
                <div class="mb-3">
                    <label for="inputAlbum" class="form-label">Pilih Album</label>
                    <select name="album" id="inputAlbum" class="form-control">
                        <option value="" disabled selected>--Pilih Album--</option>
                        <?php foreach ($datas as $album): ?>
                            <option value="<?= $album['AlbumID']; ?>" <?= isset($data['AlbumID']) && $album['AlbumID'] == $data['AlbumID'] ? 'selected' : ''; ?>>
                                <?= $album['NamaAlbum']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Asia/Jakarta');

    // Ambil data dari form
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggalUnggah = $_POST['tanggalUnggah'];
    $album = $_POST['album'];

    // Proses file yang diunggah
    $lokasiFile = $_FILES['lokasiFile']['name'];
    $targetDir = __DIR__ . "/uploads/";
    $targetFile = $targetDir . basename($lokasiFile);
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validasi file (hanya gambar yang diperbolehkan)
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES['lokasiFile']['tmp_name'], $targetFile)) {
            // Jika file berhasil diunggah, simpan data ke database
            $sql = "INSERT INTO foto (JudulFoto, DeskripsiFoto, TanggalUnggah, LokasiFile, AlbumID, UserID) 
                    VALUES (:judul, :deskripsi, :tanggalUnggah, :lokasiFile, :album, :UserID)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':judul', $judul);
            $stmt->bindParam(':deskripsi', $deskripsi);
            $stmt->bindParam(':tanggalUnggah', $tanggalUnggah);
            $stmt->bindParam(':lokasiFile', $lokasiFile);
            $stmt->bindParam(':album', $album);
            $stmt->bindParam(':UserID', $UserID);
            
            if ($stmt->execute()) {
                echo "<script>alert('Foto berhasil ditambahkan!'); window.location.replace('/views/data-foto/index.php');</script>";
            } else {
                echo "Gagal menambahkan foto.";
            }
        } else {
            echo "Gagal mengunggah file.";
        }
    } else {
        echo "Format file tidak didukung. Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
    }
}
?>

</body>
</html>

<?php include __DIR__. './../../includes/footer.php'; ?>
