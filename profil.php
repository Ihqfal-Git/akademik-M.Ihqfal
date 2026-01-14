<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Ambil data user dari database
$user_id = $_SESSION['id'];
$query = "SELECT * FROM pengguna WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Sistem Akademik</title>
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
            <div class="col-lg-6">
                
                <!-- Header -->
                <div class="mb-4">
                    <a href="index.php" class="btn btn-outline-secondary btn-sm mb-3">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                    <h3 class="fw-bold">Edit Profil</h3>
                    <p class="text-secondary">Kelola informasi akun Anda</p>
                </div>

                <!-- Alert -->
                <?php if (isset($_SESSION['success_profil'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= $_SESSION['success_profil']; unset($_SESSION['success_profil']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error_profil'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= $_SESSION['error_profil']; unset($_SESSION['error_profil']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Form Edit Profil -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Informasi Akun</h5>
                        <form action="proses.php?aksi=update_profil" method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($user['nama_lengkap']); ?>" required minlength="3" maxlength="100">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" disabled>
                                <small class="text-secondary">Email tidak dapat diubah</small>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>

                <!-- Form Ubah Password -->
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Ubah Password</h5>
                        <form action="proses.php?aksi=change_password" method="POST" id="formPassword">
                            
                            <div class="mb-3">
                                <label class="form-label">Password Lama</label>
                                <input type="password" name="password_lama" class="form-control" required minlength="6">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password_baru" id="password_baru" class="form-control" required minlength="6" maxlength="50">
                                <small class="text-secondary">Minimal 6 karakter</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control" required minlength="6" maxlength="50">
                                <div id="passwordError" class="text-danger mt-1" style="display: none;">
                                    Password tidak cocok!
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-danger">Ubah Password</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validasi konfirmasi password
        const form = document.getElementById('formPassword');
        const passwordBaru = document.getElementById('password_baru');
        const konfirmasiPassword = document.getElementById('konfirmasi_password');
        const passwordError = document.getElementById('passwordError');

        function checkPassword() {
            if (konfirmasiPassword.value !== '') {
                if (passwordBaru.value !== konfirmasiPassword.value) {
                    passwordError.style.display = 'block';
                    konfirmasiPassword.setCustomValidity('Password tidak cocok');
                } else {
                    passwordError.style.display = 'none';
                    konfirmasiPassword.setCustomValidity('');
                }
            }
        }

        passwordBaru.addEventListener('input', checkPassword);
        konfirmasiPassword.addEventListener('input', checkPassword);

        form.addEventListener('submit', function(e) {
            if (passwordBaru.value !== konfirmasiPassword.value) {
                e.preventDefault();
                passwordError.style.display = 'block';
            }
        });
    </script>
</body>
</html>