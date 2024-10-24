<?php require __DIR__ . '/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>My Project</title>
        <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/css/style.css" rel="stylesheet">
    </head>
    <body class="d-flex align-items-center py-4">
        
        <main class="form-signin w-50 m-auto">
            <div class="container">
                <div class="d-flex jusify-content-center">
                    <img class="mb-4 mx-auto text-center" src="/assets/img/kitakale-vertikal-logo.png" alt="" width="200">
                </div>
                <div class="card p-4">
                    <form action="" method="post">
                        <h1 class="h3 mb-3 fw-normal">Silahkan Daftar!</h1>

                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control" id="inputUsername" placeholder="Masukkan nama anda" required>
                            <label for="inputUsername" class="form-label">Nama</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Masukkan email anda" required>
                            <label for="inputEmail" class="form-label">Email Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Masukkan password anda" required>
                            <label for="inputPassword" class="form-label">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="namaLengkap" class="form-control" id="inputNamaLengkap" placeholder="Masukkan Nama Lengkap anda" required>
                            <label for="inputNamaLengkap" class="form-label">Nama Lengkap</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="alamat" class="form-control" id="inputAlamat" placeholder="Masukkan Alamat Anda" required>
                            <label for="inputAlamat" class="form-label">Alamat</label>
                        </div>

                        <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
                        <p class="mt-2 mb-3 text-body-secondary text-center">Sudah Punya Akun? <a href="/auth/login.php">Login</a></p>
                        <p class="mt-5 mb-3 text-body-secondary text-center">© 2024 - copyright of wahyu</p>
                    </form>
                </div>
            </div>
        </main>

        <?php
            session_start();

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
                    echo "<script>alert('Data berhasil ditambah!'); window.location.replace('/auth/login.php');</script>";
                } else {
                    echo "Failed to create user.";
                }
            }
        ?>

    </body>
</html>