<?php
session_start();
if (isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-mortarboard-fill fs-1 text-white"></i>
                    </div>
                    <h3 class="fw-bold">Sistem Akademik</h3>
                    <p class="text-secondary">Buat akun baru</p>
                </div>

                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="bi bi-exclamation-triangle me-2"></i><?= $_SESSION['error']; unset($_SESSION['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form action="proses.php?aksi=register" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person me-1"></i>Nama Lengkap
                                </label>
                                <input type="text" name="nama_lengkap" class="form-control form-control-lg" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-1"></i>Email
                                </label>
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="nama@email.com" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-lock me-1"></i>Password
                                </label>
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="Buat password" required>
                                <small class="text-secondary">Minimal 6 karakter</small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold">
                                <i class="bi bi-person-plus me-2"></i>Register
                            </button>
                        </form>
                        
                        <hr class="my-4">
                        
                        <div class="text-center">
                            <p class="text-secondary mb-0">Sudah punya akun? <a href="login.php" class="text-primary fw-semibold text-decoration-none">Login disini</a></p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <small class="text-secondary">&copy; 2025 Sistem Akademik. Muhammad Ihqfal.</small>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>