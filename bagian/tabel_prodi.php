<div class="card mb-4" id="prodi">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Program Studi</h5>
        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahProdi">
            Tambah Program Studi
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Program Studi</th>
                        <th>Jenjang</th>
                        <th>Akreditasi</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while ($prodi = mysqli_fetch_assoc($result_all_prodi)): 
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $prodi['nama_prodi']; ?></td>
                        <td><?= $prodi['jenjang']; ?></td>
                        <td><?= $prodi['akreditasi']; ?></td>
                        <td><?= $prodi['keterangan']; ?></td>
                        <td>
                            <a href="input.php?jenis=prodi&id=<?= $prodi['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus.php?jenis=prodi&id=<?= $prodi['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>