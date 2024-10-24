<?php include __DIR__. './../../includes/config.php'; ?>
<?php include __DIR__. './../../includes/header.php'; ?>

<?php
    // Cek session UserID
    $UserID = $_SESSION['UserID'];

    // Jika ada FotoID di URL
    if (isset($_GET['FotoID'])) {
        $FotoID = $_GET['FotoID'];
        
        // Query untuk mengambil data foto, album, dan user
        $query = "SELECT foto.JudulFoto, foto.DeskripsiFoto, foto.TanggalUnggah, album.NamaAlbum, user.NamaLengkap 
                  FROM foto
                  JOIN album ON foto.AlbumID = album.AlbumID
                  JOIN user ON foto.UserID = user.UserID
                  WHERE foto.FotoID = :FotoID
                  LIMIT 1";
        
        // Persiapan dan eksekusi query
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':FotoID', $FotoID);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>

<div class="card border-radius p-4">
    <!-- Baris judul dan tombol kembali -->
    <div class="row align-item-center">
        <div class="col">
            <h2>Detail Foto</h2>
        </div>
        <div class="col text-end">
            <a href="/views/data-foto/index.php" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </a>
        </div> 
    </div>

    <!-- Tampilkan data foto -->
    <div class="row mt-4">
        <div class="text-body-secondary">
            <p><em><strong>Judul Foto:</strong> <?= htmlspecialchars($data['JudulFoto'], ENT_QUOTES) ?></em></p>
            <p><em><strong>Deskripsi:</strong> <?= htmlspecialchars($data['DeskripsiFoto'], ENT_QUOTES) ?></em></p>
            <p><em><strong>Tanggal Unggah:</strong> <?= htmlspecialchars($data['TanggalUnggah'], ENT_QUOTES) ?></em></p>
            <p><em><strong>Nama Album:</strong> <?= htmlspecialchars($data['NamaAlbum'], ENT_QUOTES) ?></em></p>
            <p><em><strong>Pembuat:</strong> <?= htmlspecialchars($data['NamaLengkap'], ENT_QUOTES) ?></em></p>
        </div>
    </div>
</div>

<?php include __DIR__. './../../includes/footer.php'; ?>
