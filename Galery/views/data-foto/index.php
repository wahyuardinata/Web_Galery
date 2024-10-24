<?php 
include __DIR__. './../../includes/config.php';
include __DIR__. './../../includes/header.php';

$UserID = $_SESSION['UserID']; // Get logged-in user's ID

// Fetch photos only for the logged-in user
$query = "SELECT * FROM foto WHERE UserID = :UserID";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
$stmt->execute();
$photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "INSERT INTO foto (JudulFoto, DeskripsiFoto, TanggalUnggah, LokasiFile, AlbumID, UserID) 
        VALUES (:judul, :deskripsi, :tanggalUnggah, :lokasiFilePath, :album, :UserID)";
$stmt = $pdo->prepare($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foto Saya</title>
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
    <div class="container mt-4">
        <div class="card border-radius p-4">
            <!-- Title row and add new photo button -->
            <div class="row align-items-center">
                <div class="col">
                    <h2>Foto Saya</h2>
                </div>
                <div class="col text-end">
                    <a href="/views/data-foto/create.php" class="btn btn-primary">
                        <i class="fa-solid fa-user-plus"></i> Upload Foto
                    </a>
                </div>
            </div>

            <!-- Card to display photos -->
            <div class="row mt-4">
                <div class="col">
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php if (count($photos) > 0): ?>
                            <?php foreach ($photos as $photo) : ?>
                            <div class="col">
                                <!-- Photo card -->
                                <div class="card h-100" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 15px;">
                                    <!-- Display uploaded photo -->
                                    <img src="<?= htmlspecialchars('/views/data-foto/uploads/' . $photo['LokasiFile'], ENT_QUOTES, 'UTF-8') ?>" class="card-img-top img-fluid" alt="Foto">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($photo['JudulFoto'], ENT_QUOTES, 'UTF-8') ?></h5>
                                        <!-- Detail, Like, and Comment buttons -->
                                        <div class="d-flex justify-content-between">
                                            <!-- View detail button -->
                                             <div class="d-flex gap-3">
                                                <a href="/views/data-foto/detail.php?FotoID=<?= $photo['FotoID'] ?>" class="btn btn-info btn-sm p-0 d-flex justify-content-center align-items-center" style="width: 30px; height: 30px;">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a href="/views/data-foto/edit.php?FotoID=<?= $photo['FotoID'] ?>" class="btn btn-warning btn-sm p-0 d-flex justify-content-center align-items-center" style="width: 30px; height: 30px;">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a href="/views/data-foto/delete.php?FotoID=<?= $photo['FotoID'] ?>" class="btn btn-danger btn-sm p-0 d-flex justify-content-center align-items-center" style="width: 30px; height: 30px;">
                                                <i class="fa-solid fa-trash"></i>
                                                </a>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-center">Anda belum mengunggah foto apapun.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include __DIR__. './../../includes/footer.php'; ?>
