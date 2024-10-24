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
                <h2>Ubah Data Pengguna</h2>
            </div>
            <div class="col text-end">
                <a href="/views/data-pengguna/index.php" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-right-to-bracket"></i></a>
            </div> 
        </div>

        <!-- form -->
         <div class="row mt-4">
            <div class="col">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Nama</label>
                        <input type="text" name="name" value="<?= $data['Username'] ?>" class="form-control" id="inputName" placeholder="Masukkan nama anda">
                    </div>
                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" name="email"  value="<?= $data['Email'] ?>" class="form-control" id="inputEmail" placeholder="Masukkan email anda">
                    </div>
                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Masukkan password anda">
                    </div>
                    <div class="mb-3">
                        <label for="inputNamaLengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" name="namaLengkap"  value="<?= $data['NamaLengkap'] ?>" class="form-control" id="inputNamaLengkap" placeholder="Masukkan Nama Lengkap Anda">
                    </div>
                    <div class="mb-3">
                        <label for="inputAlamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat"  value="<?= $data['Alamat'] ?>" class="form-control" id="inputAlamat" placeholder="Masukkan Alamat Anda">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-cloud-arrow-up"></i></button>
                        <button type="reset" class="btn btn-secondary btn-sm"><i class="fa-solid fa-eraser"></i></button>
                    </div>
                </form>
            </div>
         </div>
    </div>

    <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            date_default_timezone_set('Asia/Jakarta');

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $namaLengkap = $_POST['namaLengkap'];
            $alamat = $_POST['alamat'];

            $query = "UPDATE user SET Username = :name, Email = :email, NamaLengkap = :namaLengkap, Alamat = :alamat";

            if ($password !== '') {
                $query .= ", Password = :password";
            }

            $query .= " WHERE UserID = :UserID";
            
            $stmt = $pdo->prepare($query);
            
            $stmt->bindParam(':UserID', $UserID);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':namaLengkap', $namaLengkap);
            $stmt->bindParam(':alamat', $alamat);

            if ($password !== '') {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $hashed_password);
            }
            
            if ($stmt->execute()) {
                echo "<script>alert('Data berhasil diubah!'); window.location.replace('/views/data-pengguna/index.php');</script>";
            } else {
                echo "<script>alert('Data tidak berhasil diubah!');</script>";
            }
        }
    ?>

<?php include __DIR__. './../../includes/footer.php'; ?>