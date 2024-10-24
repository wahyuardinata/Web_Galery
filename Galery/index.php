<?php include './includes/header.php'; ?>
<?php include './includes/config.php'; ?>

<?php
// Mengambil data foto dari database
$query = "SELECT f.*, u.NamaLengkap, COUNT(l.LikeID) AS TotalLikes, 
                 (SELECT COUNT(k.KomentarID) FROM komentarfoto k WHERE k.FotoID = f.FotoID) AS TotalComments
          FROM foto f
          JOIN user u ON f.UserID = u.UserID
          LEFT JOIN likefoto l ON f.FotoID = l.FotoID
          GROUP BY f.FotoID";

$stmt = $pdo->query($query);
$datas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Menangani Like
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fotoID']) && isset($_POST['userID'])) {
    $fotoID = $_POST['fotoID'];
    $userID = $_POST['userID'];

    // Cek apakah user sudah like foto ini
    $checkQuery = "SELECT * FROM likefoto WHERE FotoID = :fotoID AND UserID = :userID";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->bindParam(':fotoID', $fotoID);
    $checkStmt->bindParam(':userID', $userID);
    $checkStmt->execute();
    
    if ($checkStmt->rowCount() > 0) {
        // Jika sudah like, hapus like
        $deleteQuery = "DELETE FROM likefoto WHERE FotoID = :fotoID AND UserID = :userID";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->bindParam(':fotoID', $fotoID);
        $deleteStmt->bindParam(':userID', $userID);
        $deleteStmt->execute();
    } else {
        // Jika belum like, tambahkan like
        $insertQuery = "INSERT INTO likefoto (FotoID, UserID) VALUES (:fotoID, :userID)";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(':fotoID', $fotoID);
        $insertStmt->bindParam(':userID', $userID);
        $insertStmt->execute();
    }

    // Redirect ke halaman yang sama untuk melihat perubahan
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover; /* Agar gambar tetap proporsional */
        }
    </style>
</head>
<body>
    <!-- card untuk foto -->
    <div class="container mt-4">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($datas as $data) : ?>
            <div class="col">
                <!-- Card Foto -->
                <div class="card h-100" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 15px;">
                    <!-- Tampilkan foto yang diunggah -->
                    <img src="<?= htmlspecialchars('/views/data-foto/uploads/' . $data['LokasiFile'], ENT_QUOTES, 'UTF-8') ?>" class="card-img-top img-fluid" alt="Foto">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($data['JudulFoto'], ENT_QUOTES, 'UTF-8') ?></h5>
                        <p class="card-text mb-0"><?= htmlspecialchars($data['NamaLengkap'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="text-body-secondary" style="font-size: 12px;"><em><?= htmlspecialchars($data['TanggalUnggah'], ENT_QUOTES) ?></em></p>
                        <div class="d-flex justify-content-between">
                            <!-- Tombol detail -->
                            <a href="/detail.php?FotoID=<?= $data['FotoID'] ?>" class="btn btn-info btn-sm p-0 d-flex justify-content-center align-items-center" style="width: 35px; height: 35px;">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <!-- Tombol like & Comment -->
                            <div class="d-flex align-items-center gap-2">
                                <form method="POST" action="">
                                    <input type="hidden" name="fotoID" value="<?= $data['FotoID'] ?>">
                                    <input type="hidden" name="userID" value="<?= $_SESSION['UserID'] ?>">
                                    <button type="submit" style="border: none; background: none; padding: 10px; cursor: pointer;" class="like-button d-flex align-items-center">
                                        <i class="fa-regular fa-heart <?= (isset($data['TotalLikes']) && $data['TotalLikes'] > 0) ? 'text-danger' : '' ?>" style="font-size: 24px;"></i>
                                        <span style="font-size: 16px; margin-left: 5px;"><?= htmlspecialchars($data['TotalLikes'], ENT_QUOTES, 'UTF-8') ?></span>
                                    </button>
                                </form>

                                <p class="d-flex align-items-center mb-0">
                                    <a href="/coment.php?FotoID=<?= $data['FotoID'] ?>" class="d-flex align-items-center text-decoration-none">
                                        <i class="fa-regular fa-comment fs-4 text-secondary"></i>
                                    </a>
                                    <span style="margin-left: 5px;"><?= $data['TotalComments'] ?></span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

<?php include './includes/footer.php'; ?>
