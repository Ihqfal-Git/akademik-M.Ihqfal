<!-- Modal Tambah Mahasiswa -->
<div class="modal fade" id="modalTambahMhs" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="proses.php?aksi=tambah_mahasiswa" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="text" name="nim" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Mahasiswa</label>
                        <input type="text" name="nama_mhs" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Program Studi</label>
                        <select name="program_studi_id" class="form-select" required>
                            <option value="">Pilih Program Studi</option>
                            <?php
                            $query_prodi_list = "SELECT * FROM program_studi";
                            $result_prodi_list = mysqli_query($conn, $query_prodi_list);
                            while ($prodi_list = mysqli_fetch_assoc($result_prodi_list)):
                            ?>
                            <option value="<?= $prodi_list['id']; ?>"><?= $prodi_list['nama_prodi']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>