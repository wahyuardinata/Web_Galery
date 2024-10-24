<?php 
include __DIR__. './../../includes/config.php';
include __DIR__. './../../includes/header.php';

$UserID = $_SESSION['UserID']; // Get logged-in user's ID

// Fetch albums only for the logged-in user
$query = "SELECT a.*, u.NamaLengkap FROM album a JOIN user u ON a.UserID = u.UserID WHERE a.UserID = :UserID";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
$stmt->execute();
$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Maintain the original card styling */
        .card {
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card border-radius p-4">
            <!-- Title row -->
            <div class="row align-items-center">
                <div class="col">
                    <h2>Album Saya</h2>
                </div>
                <div class="col text-end">
                    <a href="/views/data-album/create.php" class="btn btn-primary">
                        <i class="fa-solid fa-user-plus"></i> Tambah Album
                    </a>
                </div>
            </div>

            <!-- Album display -->
            <div class="row mt-4">
                <?php if (count($albums) > 0): ?>
                    <?php foreach ($albums as $album) : ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <!-- Card for each album -->
                        <div class="card h-100">
                            <!-- Album image -->
                            <img src="../../assets/img/galery.jpg" class="card-img-top" alt="Image">
                            
                            <!-- Album details -->
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($album['NamaAlbum']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($album['Deskripsi']) ?></p>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($album['TanggalDibuat']) ?></small></p>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($album['NamaLengkap']) ?></small></p>
                            </div>

                            <!-- Action buttons -->
                            <div class="card-body text-center">
                                <a href="/views/data-album/detail.php?AlbumID=<?= $album['AlbumID'] ?>" class="btn btn-sm btn-info"><i class="fa-solid fa-eye"></i></a>
                                <a href="/views/data-album/edit.php?AlbumID=<?= $album['AlbumID'] ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="/views/data-album/delete.php?AlbumID=<?= $album['AlbumID'] ?>" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Anda belum membuat album.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include __DIR__. './../../includes/footer.php'; ?>
