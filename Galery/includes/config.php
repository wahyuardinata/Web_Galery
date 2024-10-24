<?php
    $host = 'localhost';
    $dbname = 'web_galery';
    $username = 'root';
    $password = '';

    try{
        $pdo = new PDO("mysql:host=$host; dbname=$dbname", $username, $password, );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo 'berhasil';
    }catch (PDOException $e) {
        echo "connection falid: " . $e->getMessage();
    }
?>