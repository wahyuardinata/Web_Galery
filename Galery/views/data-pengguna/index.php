<?php include __DIR__. './../../includes/config.php'; ?>
<?php include __DIR__. './../../includes/header.php'; ?>


    <?php
        $query = "SELECT * FROM user";
        $stmt = $pdo->query($query);
        $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="card border-radius p-4">
        <!-- baris judul dan tambah data pengguna -->
        <div class="row align-item-center">
            <div class="col">
                <h2>List Data Pengguna</h2>
            </div>
            <div class="col text-end">
                <a href="/views/data-pengguna/create.php" class="btn btn-primary" > <i class="fa-solid fa-user-plus"></i> Tambah Data Pengguna</a>
            </div> 
        </div>

        <!-- table -->
         <div class="row mt-4">
            <div class="col">
                <table class="table table-border table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- start looping foreach -->
                        <?php foreach ($datas as $key => $data) : ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td>
                                <?= $data['Username'] ?>
                            </td>
                            <td>
                                <?= $data['Email'] ?>
                            </td>
                            <td>
                                <?= $data['NamaLengkap'] ?>
                            </td>
                            <td>
                                <?= $data['Alamat'] ?>
                            </td>
                            <td class="text-center">
                                <a href="/views/data-pengguna/detail.php?UserID=<?= $data['UserID'] ?>" class="btn btn-sm btn-info"><i class="fa-solid fa-eye"></i></a>
                                <a href="/views/data-pengguna/edit.php?UserID=<?= $data['UserID'] ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="/views/data-pengguna/delete.php?UserID=<?= $data['UserID'] ?>" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <!-- end looping foreach -->
                    </tbody>
                </table>
            </div>
         </div>
    </div>

<?php include __DIR__. './../../includes/footer.php'; ?>