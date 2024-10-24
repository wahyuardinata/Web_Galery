<?php include './includes/header.php'; ?>
<?php include './includes/config.php'; ?>
<?php 
// Ambil waktu saat ini, UserID, FotoID
$tanggalKomentar = date('Y-m-d H:i:s');
$UserID = $_SESSION['UserID'];

if (isset($_GET['FotoID'])) {
    $fotoID = $_GET['FotoID'];
} else {
    echo "<div class='alert alert-danger'>FotoID tidak ditemukan.</div>";
    exit();
}

// Query untuk mengambil komentar dan nama lengkap user dari database
$query = "SELECT k.IsiKomentar, k.TanggalKomentar, u.NamaLengkap
          FROM komentarfoto k
          JOIN user u ON k.UserID = u.UserID
          WHERE k.FotoID = :fotoID
          ORDER BY k.TanggalKomentar DESC";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':fotoID', $fotoID);
$stmt->execute();
$komentarList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="row align-items-center px-3 py-2">
                    <div class="col">
                        <h5>Komentar</h5>
                    </div>
                    <div class="col text-end">
                        <a href="/index.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-right-to-bracket"></i></a>
                    </div> 
                </div>

                <div class="card-body">
                    <form method="POST" action="">
                        <!-- Hidden input untuk FotoID -->
                        <input type="hidden" name="fotoID" value="<?= htmlspecialchars($fotoID, ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="userID" value="<?= htmlspecialchars($UserID, ENT_QUOTES, 'UTF-8') ?>">

                        <!-- Form untuk mengisi komentar -->
                        <div class="d-flex align-items-end">
                            <div class="form-group flex-grow-1 me-2">
                                <label for="isiKomentar" class="form-label">Isi Komentar:</label>
                                <input type="text" name="isiKomentar" class="form-control" required>
                            </div>
                            <div class="mb-0">
                                <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-arrow-up"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <?php if (count($komentarList) > 0) : ?>
                        <?php foreach ($komentarList as $komentar) : ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <small class="text-body-secondary mb-0"><?= htmlspecialchars($komentar['NamaLengkap'], ENT_QUOTES, 'UTF-8') ?></small>
                                    <small class="text-muted"><?= htmlspecialchars($komentar['TanggalKomentar'], ENT_QUOTES, 'UTF-8') ?></small>
                                </div>
                                <p><?= htmlspecialchars($komentar['IsiKomentar'], ENT_QUOTES, 'UTF-8') ?></p>
                                <hr>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-muted">Belum ada komentar.</p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isiKomentar = $_POST['isiKomentar'];
    $fotoID = $_POST['fotoID'];
    $userID = $_POST['userID'];

    // Query untuk menyimpan komentar ke database
    $insertQuery = "INSERT INTO komentarfoto (FotoID, UserID, IsiKomentar, TanggalKomentar)
                    VALUES (:fotoID, :userID, :isiKomentar, :tanggalKomentar)";
    $stmt = $pdo->prepare($insertQuery);
    $stmt->bindParam(':fotoID', $fotoID);
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':isiKomentar', $isiKomentar);
    $stmt->bindParam(':tanggalKomentar', $tanggalKomentar);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success mt-3 small'>Komentar berhasil ditambahkan!</div>";
    } else {
        echo "<div class='alert alert-danger mt-3 small'>Terjadi kesalahan saat menambahkan komentar.</div>";
    }
    
}