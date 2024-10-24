<?php
    require __DIR__ . '/../../includes/config.php';

    if (isset($_GET['UserID'])) {
        $UserID = $_GET['UserID'];

        $query = "DELETE FROM user WHERE UserID = :UserID";
        $stmt = $pdo->prepare($query);
        
        $stmt->bindParam(':UserID', $UserID);
        
        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil dihapus!'); window.location.replace('/views/data-pengguna/index.php');</script>";
        } else {
            echo "<script>alert('Data tidal berhasil dihapus!');</script>";
        }
    }
?>