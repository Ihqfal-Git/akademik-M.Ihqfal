<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

$jenis = $_GET['jenis'];

if ($jenis == 'prodi') {
    $id = $_GET['id'];
    $query = "SELECT * FROM program_studi WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
} elseif ($jenis == 'mahasiswa') {
    $nim = $_GET['nim'];
    $query = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data - Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-dark">
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-mortarboard-fill me-2"></i>Sistem Akademik
            </a>
            <span class="text-light">
                <i class="bi bi-person-circle me-1"></i><?= $_SESSION['nama_lengkap']; ?>
            </span>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="d-flex align-items-center mb-4">
                    <a href="index.php?page=<?= $jenis == 'prodi' ? 'prodi' : 'mahasiswa'; ?>" class="btn btn-outline-secondary me-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h3 class="fw-bold mb-0">
                            <i class="bi bi-pencil-square me-2"></i>
                            <?= $jenis == 'prodi' ? 'Edit Program Studi' : 'Edit Mahasiswa'; ?>
                        </h3>
                        <p class="text-secondary mb-0">Perbarui informasi data</p>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="card shadow">
                    <div class="card-body p-4">
                        <?php if ($jenis == 'prodi'): ?>
                        <!-- FORM EDIT PROGRAM STUDI -->
                        <form action="proses.php?aksi=edit_prodi" method="POST">
                            <input type="hidden" name="id" value="<?= $data['id']; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-book me-1"></i>Nama Program Studi
                                </label>
                                <input type="text" name="nama_prodi" class="form-control form-control-lg" value="<?= $data['nama_prodi']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-mortarboard me-1"></i>Jenjang
                                </label>
                                <select name="jenjang" class="form-select form-select-lg" required>
                                    <option value="D2" <?= $data['jenjang'] == 'D2' ? 'selected' : ''; ?>>D2</option>
                                    <option value="D3" <?= $data['jenjang'] == 'D3' ? 'selected' : ''; ?>>D3</option>
                                    <option value="D4" <?= $data['jenjang'] == 'D4' ? 'selected' : ''; ?>>D4</option>
                                    <option value="S2" <?= $data['jenjang'] == 'S2' ? 'selected' : ''; ?>>S2</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-award me-1"></i>Akreditasi
                                </label>
                                <input type="text" name="akreditasi" class="form-control form-control-lg" value="<?= $data['akreditasi']; ?>" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-card-text me-1"></i>Keterangan
                                </label>
                                <textarea name="keterangan" class="form-control" rows="4"><?= $data['keterangan']; ?></textarea>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                    <i class="bi bi-check-circle me-2"></i>Update Data
                                </button>
                                <a href="index.php?page=prodi" class="btn btn-outline-secondary btn-lg">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </div>
                        </form>
                        
                        <?php else: ?>
                        <!-- FORM EDIT MAHASISWA -->
                        <form action="proses.php?aksi=edit_mahasiswa" method="POST">
                            <input type="hidden" name="nim_lama" value="<?= $data['nim']; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-credit-card me-1"></i>NIM
                                </label>
                                <input type="text" name="nim" class="form-control form-control-lg" value="<?= $data['nim']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person me-1"></i>Nama Mahasiswa
                                </label>
                                <input type="text" name="nama_mhs" class="form-control form-control-lg" value="<?= $data['nama_mhs']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-calendar-event me-1"></i>Tanggal Lahir
                                </label>
                                <input type="date" name="tgl_lahir" class="form-control form-control-lg" value="<?= $data['tgl_lahir']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-geo-alt me-1"></i>Alamat
                                </label>
                                <textarea name="alamat" class="form-control" rows="3" required><?= $data['alamat']; ?></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-book me-1"></i>Program Studi
                                </label>
                                <select name="program_studi_id" class="form-select form-select-lg" required>
                                    <?php
                                    $query_prodi = "SELECT * FROM program_studi";
                                    $result_prodi = mysqli_query($conn, $query_prodi);
                                    while ($prodi = mysqli_fetch_assoc($result_prodi)):
                                    ?>
                                    <option value="<?= $prodi['id']; ?>" <?= $data['program_studi_id'] == $prodi['id'] ? 'selected' : ''; ?>>
                                        <?= $prodi['nama_prodi']; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                    <i class="bi bi-check-circle me-2"></i>Update Data
                                </button>
                                <a href="index.php?page=mahasiswa" class="btn btn-outline-secondary btn-lg">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </div>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>