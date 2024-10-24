<?php include __DIR__. './../../includes/config.php'; ?>
<?php include __DIR__. './../../includes/header.php'; ?>

<?php
    // Cek session UserID
    $UserID = $_SESSION['UserID'];

    // Jika ada AlbumID di URL
    if (isset($_GET['AlbumID'])) {
        $AlbumID = $_GET['AlbumID'];
        
        // Query untuk mengambil data album dan user yang sesuai dengan AlbumID
        $query = "SELECT album.NamaAlbum, album.Deskripsi, album.TanggalDibuat, user.NamaLengkap 
                  FROM album
                  JOIN user ON album.UserID = user.UserID
                  WHERE album.AlbumID = :AlbumID
                  LIMIT 1";       
        // Persiapan dan eksekusi query
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':AlbumID', $AlbumID);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Query untuk mengambil data foto
        $fotoQuery = "SELECT * FROM foto WHERE AlbumID = :AlbumID";
        $fotoStmt = $pdo->prepare($fotoQuery);
        $fotoStmt->bindParam(':AlbumID', $AlbumID);   
        $fotoStmt->execute();      
        $fotos = $fotoStmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<div class="card border-radius p-4">
    <!-- Baris judul dan tombol kembali -->
    <div class="row align-item-center">
        <div class="col">
            <h2>Detail Album</h2>
        </div>
        <div class="col text-end">
            <a href="/views/data-album/index.php" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </a>
        </div> 
    </div>

    <!-- Tampilkan data album -->
    <div class="row mt-4">
        <div>
            <p><strong>Nama Album:</strong> <?= htmlspecialchars($data['NamaAlbum'], ENT_QUOTES) ?></p>
            <p><strong>Deskripsi:</strong> <?= htmlspecialchars($data['Deskripsi'], ENT_QUOTES) ?></p>
            <p><strong>Tanggal Dibuat:</strong> <?= htmlspecialchars($data['TanggalDibuat'], ENT_QUOTES) ?></p>
            <p><strong>Nama Pembuat:</strong> <?= htmlspecialchars($data['NamaLengkap'], ENT_QUOTES) ?></p> <!-- Nama pengguna -->
        </div>
    </div>
</div>

<div class="row mt-4">
        <?php if (!empty($fotos)): ?>
            <div class="row">
                <?php foreach ($fotos as $foto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card" style="width: 14rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 15px;">
                            <!-- Menampilkan foto -->
                            <img src="<?= htmlspecialchars('/views/data-foto/uploads/' . $foto['LokasiFile'], ENT_QUOTES, 'UTF-8') ?>" class="card-img-top" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                            <div class="card-body">
                                <h5 class="card-title mb-0"><?= htmlspecialchars($foto['JudulFoto'], ENT_QUOTES, 'UTF-8') ?></h5>
                                <p><small class="text-muted"><?= htmlspecialchars($foto['TanggalUnggah'], ENT_QUOTES) ?></small></p>
                                <p class="card-text">Deskripsi:<?= htmlspecialchars($foto['DeskripsiFoto'], ENT_QUOTES, 'UTF-8') ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Belum ada foto dalam album ini.</p>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__. './../../includes/footer.php'; ?>
