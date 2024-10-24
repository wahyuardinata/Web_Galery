<?php include __DIR__. './../../includes/config.php'; ?>
<?php include __DIR__. './../../includes/header.php'; ?>

    <div class="card border-radius p-4">
        <!-- baris judul dan kembali -->
        <div class="row align-item-center">
            <div class="col">
                <h2>Tambah Data Penggun</h2>
            </div>
            <div class="col text-end">
                <a href="/views/data-pengguna" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-right-to-bracket"></i></a>
            </div> 
        </div>

        <!-- form -->
         <div class="row mt-4">
            <div class="col">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="inputUsername" class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" id="inputUsername" placeholder="Masukkan nama anda" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Masukkan email anda" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Masukkan password anda" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputNamaLengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" name="namaLengkap" class="form-control" id="inputNamaLengkap" placeholder="Masukkan Nama Lengkap anda" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputAlamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control" id="inputAlamat" placeholder="Masukkan Alamat Anda" required>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i></button>
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

            // Hashing the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO user (Username, Email, Password, NamaLengkap, Alamat) VALUES (:name, :email, :password, :namaLengkap, :alamat)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':namaLengkap', $namaLengkap);
            $stmt->bindParam(':alamat', $alamat);
            
            if ($stmt->execute()) {
                echo "<script>alert('Data berhasil ditambah!'); window.location.replace('/views/data-pengguna/index.php');</script>";
            } else {
                echo "Failed to create user.";
            }
        }
    ?>

<?php include __DIR__. './../../includes/footer.php'; ?>