<div class="card mb-4" id="mahasiswa">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Mahasiswa</h5>
        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahMhs">
            Tambah Mahasiswa
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Program Studi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while ($mhs = mysqli_fetch_assoc($result_all_mhs)): 
                        // Ambil nama prodi secara manual
                        $prodi_id = $mhs['program_studi_id'];
                        $query_prodi = "SELECT nama_prodi FROM program_studi WHERE id = $prodi_id";
                        $result_prodi_temp = mysqli_query($conn, $query_prodi);
                        $prodi_data = mysqli_fetch_assoc($result_prodi_temp);
                        $nama_prodi = $prodi_data ? $prodi_data['nama_prodi'] : '-';
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $mhs['nim']; ?></td>
                        <td><?= $mhs['nama_mhs']; ?></td>
                        <td><?= date('d-m-Y', strtotime($mhs['tgl_lahir'])); ?></td>
                        <td><?= $mhs['alamat']; ?></td>
                        <td><?= $nama_prodi; ?></td>
                        <td>
                            <a href="input.php?jenis=mahasiswa&nim=<?= $mhs['nim']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus.php?jenis=mahasiswa&nim=<?= $mhs['nim']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>