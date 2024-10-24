<?php include __DIR__. './../../includes/config.php'; ?>
<?php include __DIR__. './../../includes/header.php'; ?>

    <?php
        // Cek apakah AlbumID ada di URL dan ambil datanya
        if (isset($_GET['AlbumID'])) {
            $AlbumID = $_GET['AlbumID'];
            
            // Query untuk mendapatkan data album berdasarkan AlbumID
            $query = "SELECT * FROM album WHERE AlbumID = :AlbumID LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':AlbumID', $AlbumID);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            // Jika album tidak ditemukan
            if (!$data) {
                echo "<script>alert('Album tidak ditemukan!'); window.location.replace('/views/data-album/index.php');</script>";
                exit;
            }
        }

        // Jika form disubmit untuk update data
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Ambil input dari form
            $name = $_POST['name'];
            $deskripsi = $_POST['deskripsi'];
            $tglBuat = $_POST['tglBuat'];

            // Query untuk mengupdate data album
            $query = "UPDATE album SET NamaAlbum = :name, Deskripsi = :deskripsi, TanggalDibuat = :tglBuat WHERE AlbumID = :AlbumID";
            $stmt = $pdo->prepare($query);

            // Bind parameter
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':deskripsi', $deskripsi);
            $stmt->bindParam(':tglBuat', $tglBuat);
            $stmt->bindParam(':AlbumID', $AlbumID);

            // Eksekusi query update
            if ($stmt->execute()) {
                echo "<script>alert('Data berhasil diubah!'); window.location.replace('/views/data-album/index.php');</script>";
            } else {
                echo "<script>alert('Data tidak berhasil diubah!');</script>";
            }
        }
    ?>

    <div class="card border-radius p-4">
        <!-- baris judul dan kembali -->
        <div class="row align-item-center">
            <div class="col">
                <h2>Ubah Album</h2>
            </div>
            <div class="col text-end">
                <a href="/views/data-album/index.php" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </a>
            </div> 
        </div>

        <!-- form untuk edit data album -->
        <div class="row mt-4">
            <div class="col">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="inputNamaAlbum" class="form-label">Nama Album</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($data['NamaAlbum'], ENT_QUOTES) ?>" class="form-control" id="inputNamaAlbum" placeholder="Masukkan Nama Album Foto" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputDeskripsiAlbum" class="form-label">Deskripsi</label>
                        <input type="text" name="deskripsi" value="<?= htmlspecialchars($data['Deskripsi'], ENT_QUOTES) ?>" class="form-control" id="inputDeskripsiAlbum" placeholder="Masukkan Deskripsi Album Foto" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputTglBuat" class="form-label">Tanggal Buat</label>
                        <input type="date" name="tglBuat" value="<?= htmlspecialchars($data['TanggalDibuat'], ENT_QUOTES) ?>" class="form-control" id="inputTglBuat" required>
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

<?php include __DIR__. './../../includes/footer.php'; ?>
