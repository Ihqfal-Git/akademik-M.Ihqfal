<!-- Modal Tambah Program Studi -->
<div class="modal fade" id="modalTambahProdi" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Program Studi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="proses.php?aksi=tambah_prodi" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Program Studi</label>
                        <input type="text" name="nama_prodi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenjang</label>
                        <select name="jenjang" class="form-select" required>
                            <option value="D2">D2</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                            <option value="S2">S2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Akreditasi</label>
                        <input type="text" name="akreditasi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
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