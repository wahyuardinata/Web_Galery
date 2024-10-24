<?php
    require __DIR__ . '/../../includes/config.php';

    if (isset($_GET['AlbumID'])) {
        $AlbumID = $_GET['AlbumID'];

        $query = "DELETE FROM album WHERE AlbumID = :AlbumID";
        $stmt = $pdo->prepare($query);
        
        $stmt->bindParam(':AlbumID', $AlbumID);
        
        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil dihapus!'); window.location.replace('/views/data-album/index.php');</script>";
        } else {
            echo "<script>alert('Data tidak berhasil dihapus!');</script>";
        }
    }
?>