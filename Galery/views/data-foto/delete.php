<?php
    require __DIR__ . '/../../includes/config.php';

    if (isset($_GET['FotoID'])) {
        $FotoID = $_GET['FotoID'];

        $query = "DELETE FROM foto WHERE FotoID = :FotoID";
        $stmt = $pdo->prepare($query);
        
        $stmt->bindParam(':FotoID', $FotoID);
        
        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil dihapus!'); window.location.replace('/views/data-foto/index.php');</script>";
        } else {
            echo "<script>alert('Data tidak berhasil dihapus!');</script>";
        }
    }
?>