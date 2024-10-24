<?php include __DIR__. './../../includes/config.php'; ?>
<?php include __DIR__. './../../includes/header.php'; ?>

<?php
$UserID = $_SESSION['UserID'];
$FotoID = $_GET['FotoID'];

// Mengambil data foto yang akan diedit
$query = "SELECT * FROM foto WHERE FotoID = :FotoID AND UserID = :UserID";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':FotoID', $FotoID);
$stmt->bindParam(':UserID', $UserID);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// Mengambil data album untuk dropdown
$queryAlbums = "SELECT * FROM album WHERE UserID = :UserID";
$stmtAlbums = $pdo->prepare($queryAlbums);
$stmtAlbums->bindParam(':UserID', $UserID);
$stmtAlbums->execute();
$albums = $stmtAlbums->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto</title>
</head>
<body>

<div class="card border-radius p-4">
    <!-- Baris judul dan kembali -->
    <div class="row align-item-center">
        <div class="col">
            <h2>Edit Foto</h2>
        </div>
        <div class="col text-end">
            <a href="/views/data-foto/index.php" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </a>
        </div> 
    </div>

    <!-- Form -->
    <div class="row mt-4">
        <div class="col">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="inputJudul" class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" id="inputJudul" value="<?= htmlspecialchars($data['JudulFoto'], ENT_QUOTES); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="inputDeskripsi" class="form-label">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control" id="inputDeskripsi" value="<?= htmlspecialchars($data['DeskripsiFoto'], ENT_QUOTES); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="inputTanggalUnggah" class="form-label">Tanggal Unggah</label>
                    <input type="date" name="tanggalUnggah" class="form-control" id="inputTanggalUnggah" value="<?= $data['TanggalUnggah']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="inputLokasiFile" class="form-label">Unggah Foto (biarkan kosong jika tidak ingin mengganti)</label>
                    <input type="file" name="lokasiFile" class="form-control" id="inputLokasiFile">
                </div>
                <div class="mb-3">
                    <label for="inputAlbum" class="form-label">Pilih Album</label>
                    <select name="album" id="inputAlbum" class="form-control" required>
                        <option value="" disabled>--Pilih Album--</option>
                        <?php foreach ($albums as $album): ?>
                            <option value="<?= $album['AlbumID']; ?>" <?= $album['AlbumID'] == $data['AlbumID'] ? 'selected' : ''; ?>><?= $album['NamaAlbum']; ?></option>
                        <?php endforeach; ?>
                    </select>
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Asia/Jakarta');

    // Ambil data dari form
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggalUnggah = $_POST['tanggalUnggah'];
    $album = $_POST['album'];

    // Proses file yang diunggah
    $updateFileSql = "";  // Variabel untuk menambah SQL jika file diunggah
    if (!empty($_FILES['lokasiFile']['name'])) {
        $lokasiFile = $_FILES['lokasiFile']['name'];
        $targetDir = __DIR__ . "/uploads/";
        $targetFile = $targetDir . basename($lokasiFile);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validasi file (hanya gambar yang diperbolehkan)
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['lokasiFile']['tmp_name'], $targetFile)) {
                // Perbarui lokasi file jika berhasil diunggah
                $updateFileSql = ", LokasiFile = :lokasiFile";
            } else {
                echo "<script>alert('Gagal mengunggah file.');</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format file tidak didukung. Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.');</script>";
            exit;
        }
    }

    // Update data ke database
    $sql = "UPDATE foto SET JudulFoto = :judul, DeskripsiFoto = :deskripsi, TanggalUnggah = :tanggalUnggah, AlbumID = :album $updateFileSql WHERE FotoID = :FotoID AND UserID = :UserID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':judul', $judul);
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->bindParam(':tanggalUnggah', $tanggalUnggah);
    $stmt->bindParam(':album', $album);
    if (!empty($lokasiFile)) {
        $stmt->bindParam(':lokasiFile', $lokasiFile);
    }
    $stmt->bindParam(':FotoID', $FotoID);
    $stmt->bindParam(':UserID', $UserID);

    if ($stmt->execute()) {
        echo "<script>alert('Foto berhasil diperbarui!'); window.location.replace('/views/data-foto/index.php');</script>";
    } else {
        echo "<script>alert('Gagal memperbarui foto.');</script>";
    }
}
?>

</body>
</html>

<?php include __DIR__. './../../includes/footer.php'; ?>
