<?php include __DIR__. './../../includes/config.php'; ?>
<?php include __DIR__. './../../includes/header.php'; ?>

    <?php
        
        if (isset($_GET['UserID'])) {
            $UserID = $_GET['UserID'];
            $query = "SELECT * FROM user where UserID = " . $UserID . " limit 1";
            $stmt = $pdo->query($query);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    ?>

    <div class="card border-radius p-4">
        <!-- baris judul dan kembali -->
        <div class="row align-item-center">
            <div class="col">
                <h2>Detail Data Pengguna</h2>
            </div>
            <div class="col text-end">
                <a href="/views/data-pengguna/index.php" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-right-to-bracket"></i></a>
            </div> 
        </div>

        <!-- list -->
         <div class="row mt-4">
            <div>
                <p>Nama: <?= $data['Username'] ?> </p>
                <p>Email: <?= $data['Email'] ?> </p>
                <p>Nama Lengkap: <?= $data['NamaLengkap'] ?> </p>
                <p>Alamat: <?= $data['Alamat'] ?> </p>
            </div>
         </div>
    </div>

<?php include __DIR__. './../../includes/footer.php'; ?>