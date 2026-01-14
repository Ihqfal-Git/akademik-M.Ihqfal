<<<<<<< HEAD
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Tentukan halaman aktif
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Hitung total program studi
$query_prodi = "SELECT COUNT(*) as total FROM program_studi";
$result_prodi = mysqli_query($conn, $query_prodi);
$total_prodi = mysqli_fetch_assoc($result_prodi)['total'];

// Hitung total mahasiswa
$query_mhs = "SELECT COUNT(*) as total FROM mahasiswa";
$result_mhs = mysqli_query($conn, $query_mhs);
$total_mhs = mysqli_fetch_assoc($result_mhs)['total'];

// Get all program studi
$query_all_prodi = "SELECT * FROM program_studi ORDER BY id DESC";
$result_all_prodi = mysqli_query($conn, $query_all_prodi);

// Get all mahasiswa
$query_all_mhs = "SELECT * FROM mahasiswa ORDER BY nim DESC";
$result_all_mhs = mysqli_query($conn, $query_all_mhs);
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Akademik Muhammad Ihqfal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-dark">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-journal-text me-2"></i>Sistem Akademik
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $page == 'dashboard' ? 'active' : ''; ?>" href="index.php?page=dashboard">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $page == 'prodi' ? 'active' : ''; ?>" href="index.php?page=prodi">
                            <i class="bi bi-book me-1"></i>Program Studi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $page == 'mahasiswa' ? 'active' : ''; ?>" href="index.php?page=mahasiswa">
                            <i class="bi bi-people me-1"></i>Mahasiswa
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="text-light me-3">
                        <i class="bi bi-person-circle me-1"></i><?= $_SESSION['nama_lengkap']; ?>
                    </span>
                    <a href="profil.php" class="btn btn-outline-primary btn-sm me-2">
                        <i class="bi bi-gear me-1"></i>Profil
                    </a>
                    <a href="proses.php?aksi=logout" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <?php include 'bagian/notifikasi.php'; ?>

        <?php if ($page == 'dashboard'): ?>
            <!-- Dashboard -->
            <div class="mb-4">
                <h2 class="fw-bold mb-2">Dashboard</h2>
                <p class="text-secondary">Selamat datang di Sistem Manajemen Akademik</p>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card bg-success bg-gradient text-white shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 opacity-75">Total Program Studi</h6>
                                    <h2 class="card-title mb-0 fw-bold"><?= $total_prodi; ?></h2>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="bi bi-book"></i>
                                </div>
                            </div>
                            <a href="index.php?page=prodi" class="btn btn-outline-light btn-sm mt-3">
                                Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-primary bg-gradient text-white shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 opacity-75">Total Mahasiswa</h6>
                                    <h2 class="card-title mb-0 fw-bold"><?= $total_mhs; ?></h2>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="bi bi-people"></i>
                                </div>
                            </div>
                            <a href="index.php?page=mahasiswa" class="btn btn-outline-light btn-sm mt-3">
                                Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-body text-center py-5">
                    <i class="bi bi-journal-text fs-1 text-primary mb-3"></i>
                    <h4 class="mb-3">Selamat Datang, <?= $_SESSION['nama_lengkap']; ?>!</h4>
                    <p class="text-secondary">Pilih menu di atas untuk mengelola data akademik</p>
                </div>
            </div>

        <?php elseif ($page == 'prodi'): ?>
            <!-- Program Studi -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">Program Studi</h2>
                    <p class="text-secondary mb-0">Kelola data program studi</p>
                </div>
                <button class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#modalTambahProdi">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Program Studi
                </button>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
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
                                    <td><span class="badge bg-primary"><?= $prodi['jenjang']; ?></span></td>
                                    <td><span class="badge bg-success"><?= $prodi['akreditasi']; ?></span></td>
                                    <td><?= $prodi['keterangan']; ?></td>
                                    <td>
                                        <a href="input.php?jenis=prodi&id=<?= $prodi['id']; ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="hapus.php?jenis=prodi&id=<?= $prodi['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php elseif ($page == 'mahasiswa'): ?>
            <!-- Mahasiswa -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">Mahasiswa</h2>
                    <p class="text-secondary mb-0">Kelola data mahasiswa</p>
                </div>
                <button class="btn btn-success shadow" data-bs-toggle="modal" data-bs-target="#modalTambahMhs">
                    <i class="bi bi-person-plus me-1"></i>Tambah Mahasiswa
                </button>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
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
                                    $prodi_id = $mhs['program_studi_id'];
                                    $query_prodi = "SELECT nama_prodi FROM program_studi WHERE id = $prodi_id";
                                    $result_prodi_temp = mysqli_query($conn, $query_prodi);
                                    $prodi_data = mysqli_fetch_assoc($result_prodi_temp);
                                    $nama_prodi = $prodi_data ? $prodi_data['nama_prodi'] : '-';
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><span class="badge bg-info"><?= $mhs['nim']; ?></span></td>
                                    <td><?= $mhs['nama_mhs']; ?></td>
                                    <td><?= date('d-m-Y', strtotime($mhs['tgl_lahir'])); ?></td>
                                    <td><?= $mhs['alamat']; ?></td>
                                    <td><?= $nama_prodi; ?></td>
                                    <td>
                                        <a href="input.php?jenis=mahasiswa&nim=<?= $mhs['nim']; ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="hapus.php?jenis=mahasiswa&nim=<?= $mhs['nim']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- Modal Tambah Program Studi -->
    <?php include 'bagian/form_tambah_prodi.php'; ?>

    <!-- Modal Tambah Mahasiswa -->
    <?php include 'bagian/form_tambah_mahasiswa.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
=======
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Tentukan halaman aktif
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Hitung total program studi
$query_prodi = "SELECT COUNT(*) as total FROM program_studi";
$result_prodi = mysqli_query($conn, $query_prodi);
$total_prodi = mysqli_fetch_assoc($result_prodi)['total'];

// Hitung total mahasiswa
$query_mhs = "SELECT COUNT(*) as total FROM mahasiswa";
$result_mhs = mysqli_query($conn, $query_mhs);
$total_mhs = mysqli_fetch_assoc($result_mhs)['total'];

// Get all program studi
$query_all_prodi = "SELECT * FROM program_studi ORDER BY id DESC";
$result_all_prodi = mysqli_query($conn, $query_all_prodi);

// Get all mahasiswa
$query_all_mhs = "SELECT * FROM mahasiswa ORDER BY nim DESC";
$result_all_mhs = mysqli_query($conn, $query_all_mhs);
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Akademik - Modern Dark</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-dark">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-mortarboard-fill me-2"></i>Sistem Akademik
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $page == 'dashboard' ? 'active' : ''; ?>" href="index.php?page=dashboard">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $page == 'prodi' ? 'active' : ''; ?>" href="index.php?page=prodi">
                            <i class="bi bi-book me-1"></i>Program Studi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $page == 'mahasiswa' ? 'active' : ''; ?>" href="index.php?page=mahasiswa">
                            <i class="bi bi-people me-1"></i>Mahasiswa
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="text-light me-3">
                        <i class="bi bi-person-circle me-1"></i><?= $_SESSION['nama_lengkap']; ?>
                    </span>
                    <a href="proses.php?aksi=logout" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <?php include 'bagian/notifikasi.php'; ?>

        <?php if ($page == 'dashboard'): ?>
            <!-- Dashboard -->
            <div class="mb-4">
                <h2 class="fw-bold mb-2">Dashboard</h2>
                <p class="text-secondary">Selamat datang di Sistem Manajemen Akademik</p>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card bg-primary bg-gradient text-white shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 opacity-75">Total Program Studi</h6>
                                    <h2 class="card-title mb-0 fw-bold"><?= $total_prodi; ?></h2>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="bi bi-book"></i>
                                </div>
                            </div>
                            <a href="index.php?page=prodi" class="btn btn-light btn-sm mt-3">
                                Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-success bg-gradient text-white shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 opacity-75">Total Mahasiswa</h6>
                                    <h2 class="card-title mb-0 fw-bold"><?= $total_mhs; ?></h2>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="bi bi-people"></i>
                                </div>
                            </div>
                            <a href="index.php?page=mahasiswa" class="btn btn-light btn-sm mt-3">
                                Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-body text-center py-5">
                    <i class="bi bi-mortarboard-fill fs-1 text-primary mb-3"></i>
                    <h4 class="mb-3">Selamat Datang, <?= $_SESSION['nama_lengkap']; ?>!</h4>
                    <p class="text-secondary">Pilih menu di atas untuk mengelola data akademik</p>
                </div>
            </div>

        <?php elseif ($page == 'prodi'): ?>
            <!-- Program Studi -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">Program Studi</h2>
                    <p class="text-secondary mb-0">Kelola data program studi</p>
                </div>
                <button class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#modalTambahProdi">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Program Studi
                </button>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
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
                                    <td><span class="badge bg-info"><?= $prodi['jenjang']; ?></span></td>
                                    <td><span class="badge bg-success"><?= $prodi['akreditasi']; ?></span></td>
                                    <td><?= $prodi['keterangan']; ?></td>
                                    <td>
                                        <a href="input.php?jenis=prodi&id=<?= $prodi['id']; ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="hapus.php?jenis=prodi&id=<?= $prodi['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php elseif ($page == 'mahasiswa'): ?>
            <!-- Mahasiswa -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">Mahasiswa</h2>
                    <p class="text-secondary mb-0">Kelola data mahasiswa</p>
                </div>
                <button class="btn btn-success shadow" data-bs-toggle="modal" data-bs-target="#modalTambahMhs">
                    <i class="bi bi-person-plus me-1"></i>Tambah Mahasiswa
                </button>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
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
                                    $prodi_id = $mhs['program_studi_id'];
                                    $query_prodi = "SELECT nama_prodi FROM program_studi WHERE id = $prodi_id";
                                    $result_prodi_temp = mysqli_query($conn, $query_prodi);
                                    $prodi_data = mysqli_fetch_assoc($result_prodi_temp);
                                    $nama_prodi = $prodi_data ? $prodi_data['nama_prodi'] : '-';
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><span class="badge bg-info"><?= $mhs['nim']; ?></span></td>
                                    <td><?= $mhs['nama_mhs']; ?></td>
                                    <td><?= date('d-m-Y', strtotime($mhs['tgl_lahir'])); ?></td>
                                    <td><?= $mhs['alamat']; ?></td>
                                    <td><?= $nama_prodi; ?></td>
                                    <td>
                                        <a href="input.php?jenis=mahasiswa&nim=<?= $mhs['nim']; ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="hapus.php?jenis=mahasiswa&nim=<?= $mhs['nim']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- Modal Tambah Program Studi -->
    <?php include 'bagian/form_tambah_prodi.php'; ?>

    <!-- Modal Tambah Mahasiswa -->
    <?php include 'bagian/form_tambah_mahasiswa.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
>>>>>>> 9a54bd385a028bd6b80ae4be33669ade1cc7fbf6
</html>