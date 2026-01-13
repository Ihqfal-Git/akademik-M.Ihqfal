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
            <?php
            // Data tambahan untuk dashboard
            $query_d2 = "SELECT COUNT(*) as total FROM program_studi WHERE jenjang='D2'";
            $query_d3 = "SELECT COUNT(*) as total FROM program_studi WHERE jenjang='D3'";
            $query_d4 = "SELECT COUNT(*) as total FROM program_studi WHERE jenjang='D4'";
            $query_s2 = "SELECT COUNT(*) as total FROM program_studi WHERE jenjang='S2'";
            
            $total_d2 = mysqli_fetch_assoc(mysqli_query($conn, $query_d2))['total'];
            $total_d3 = mysqli_fetch_assoc(mysqli_query($conn, $query_d3))['total'];
            $total_d4 = mysqli_fetch_assoc(mysqli_query($conn, $query_d4))['total'];
            $total_s2 = mysqli_fetch_assoc(mysqli_query($conn, $query_s2))['total'];
            
            // Mahasiswa terbaru
            $query_mhs_baru = "SELECT * FROM mahasiswa ORDER BY nim DESC LIMIT 5";
            $result_mhs_baru = mysqli_query($conn, $query_mhs_baru);
            
            // Prodi dengan mahasiswa terbanyak
            $query_prodi_populer = "SELECT p.nama_prodi, p.jenjang, COUNT(m.nim) as jumlah 
                                    FROM program_studi p 
                                    LEFT JOIN mahasiswa m ON p.id = m.program_studi_id 
                                    GROUP BY p.id 
                                    ORDER BY jumlah DESC 
                                    LIMIT 5";
            $result_prodi_populer = mysqli_query($conn, $query_prodi_populer);
            
            // Greeting
            $jam = date('H');
            if ($jam >= 5 && $jam < 11) {
                $greeting = "Selamat Pagi";
                $icon = "☀️";
            } elseif ($jam >= 11 && $jam < 15) {
                $greeting = "Selamat Siang";
                $icon = "🌤️";
            } elseif ($jam >= 15 && $jam < 18) {
                $greeting = "Selamat Sore";
                $icon = "🌅";
            } else {
                $greeting = "Selamat Malam";
                $icon = "🌙";
            }
            $hari = date('l, d F Y');
            ?>
            
            <!-- Welcome Banner -->
            <div class="card bg-primary bg-gradient text-white shadow mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-bold mb-2"><?= $greeting ?>, <?= $_SESSION['nama_lengkap']; ?>! <?= $icon ?></h3>
                            <p class="mb-0 opacity-75"><i class="bi bi-calendar3 me-2"></i><?= $hari ?></p>
                        </div>
                        <div class="fs-1 opacity-25 d-none d-md-block">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-primary bg-gradient text-white shadow h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="fs-2 opacity-50">
                                    <i class="bi bi-book"></i>
                                </div>
                                <span class="badge bg-light text-primary">Total</span>
                            </div>
                            <h2 class="fw-bold mb-1"><?= $total_prodi; ?></h2>
                            <p class="mb-0 opacity-75">Program Studi</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-success bg-gradient text-white shadow h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="fs-2 opacity-50">
                                    <i class="bi bi-people"></i>
                                </div>
                                <span class="badge bg-light text-success">Total</span>
                            </div>
                            <h2 class="fw-bold mb-1"><?= $total_mhs; ?></h2>
                            <p class="mb-0 opacity-75">Mahasiswa</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-info bg-gradient text-white shadow h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="fs-2 opacity-50">
                                    <i class="bi bi-award"></i>
                                </div>
                                <span class="badge bg-light text-info">D3/D4</span>
                            </div>
                            <h2 class="fw-bold mb-1"><?= $total_d3 + $total_d4; ?></h2>
                            <p class="mb-0 opacity-75">Diploma</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-warning bg-gradient text-white shadow h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="fs-2 opacity-50">
                                    <i class="bi bi-mortarboard"></i>
                                </div>
                                <span class="badge bg-light text-warning">S2</span>
                            </div>
                            <h2 class="fw-bold mb-1"><?= $total_s2; ?></h2>
                            <p class="mb-0 opacity-75">Magister</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">
                        <i class="bi bi-lightning-charge-fill text-warning me-2"></i>Quick Actions
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#modalTambahProdi">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Prodi
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#modalTambahMhs">
                                <i class="bi bi-person-plus me-2"></i>Tambah Mahasiswa
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="index.php?page=prodi" class="btn btn-outline-info w-100">
                                <i class="bi bi-list-ul me-2"></i>Lihat Prodi
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="index.php?page=mahasiswa" class="btn btn-outline-warning w-100">
                                <i class="bi bi-people-fill me-2"></i>Lihat Mahasiswa
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <!-- Program Studi Populer -->
                <div class="col-lg-6">
                    <div class="card shadow h-100">
                        <div class="card-header bg-transparent border-bottom">
                            <h5 class="card-title fw-bold mb-0">
                                <i class="bi bi-star-fill text-warning me-2"></i>Program Studi Populer
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <?php 
                                $no = 1;
                                while ($prodi_pop = mysqli_fetch_assoc($result_prodi_populer)): 
                                ?>
                                <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <div class="fw-semibold"><?= $no++; ?>. <?= $prodi_pop['nama_prodi']; ?></div>
                                        <small class="text-secondary"><?= $prodi_pop['jenjang']; ?></small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill"><?= $prodi_pop['jumlah']; ?> mahasiswa</span>
                                </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mahasiswa Terbaru -->
                <div class="col-lg-6">
                    <div class="card shadow h-100">
                        <div class="card-header bg-transparent border-bottom">
                            <h5 class="card-title fw-bold mb-0">
                                <i class="bi bi-person-badge text-success me-2"></i>Mahasiswa Terbaru
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <?php while ($mhs_baru = mysqli_fetch_assoc($result_mhs_baru)): 
                                    $prodi_id = $mhs_baru['program_studi_id'];
                                    $q_prodi = mysqli_query($conn, "SELECT nama_prodi FROM program_studi WHERE id=$prodi_id");
                                    $prodi_name = mysqli_fetch_assoc($q_prodi)['nama_prodi'] ?? '-';
                                ?>
                                <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <div class="fw-semibold"><?= $mhs_baru['nama_mhs']; ?></div>
                                        <small class="text-secondary"><i class="bi bi-credit-card me-1"></i><?= $mhs_baru['nim']; ?> • <?= $prodi_name; ?></small>
                                    </div>
                                    <span class="badge bg-success">Baru</span>
                                </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Per Jenjang -->
            <div class="card shadow">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="card-title fw-bold mb-0">
                        <i class="bi bi-bar-chart-fill text-info me-2"></i>Statistik Per Jenjang
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center g-4">
                        <div class="col-md-3">
                            <div class="p-3 border rounded">
                                <h3 class="text-primary fw-bold"><?= $total_d2; ?></h3>
                                <p class="mb-0 text-secondary">Program D2</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded">
                                <h3 class="text-success fw-bold"><?= $total_d3; ?></h3>
                                <p class="mb-0 text-secondary">Program D3</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded">
                                <h3 class="text-info fw-bold"><?= $total_d4; ?></h3>
                                <p class="mb-0 text-secondary">Program D4</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded">
                                <h3 class="text-warning fw-bold"><?= $total_s2; ?></h3>
                                <p class="mb-0 text-secondary">Program S2</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($page == 'prodi'): ?>
            <!-- Program Studi -->
            <?php
            // Search & Filter
            $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
            $filter_jenjang = isset($_GET['jenjang']) ? $_GET['jenjang'] : '';
            
            $query_prodi_filter = "SELECT * FROM program_studi WHERE 1=1";
            if ($search != '') {
                $query_prodi_filter .= " AND (nama_prodi LIKE '%$search%' OR akreditasi LIKE '%$search%')";
            }
            if ($filter_jenjang != '') {
                $query_prodi_filter .= " AND jenjang='$filter_jenjang'";
            }
            $query_prodi_filter .= " ORDER BY id DESC";
            $result_all_prodi = mysqli_query($conn, $query_prodi_filter);
            $total_filtered = mysqli_num_rows($result_all_prodi);
            ?>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1"><i class="bi bi-book-fill text-primary me-2"></i>Program Studi</h2>
                    <p class="text-secondary mb-0">Kelola data program studi</p>
                </div>
                <button class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#modalTambahProdi">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Program Studi
                </button>
            </div>

            <!-- Search & Filter Card -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="GET" action="index.php">
                        <input type="hidden" name="page" value="prodi">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" name="search" class="form-control" placeholder="Cari nama prodi atau akreditasi..." value="<?= $search; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="jenjang" class="form-select">
                                    <option value="">🎓 Semua Jenjang</option>
                                    <option value="D2" <?= $filter_jenjang == 'D2' ? 'selected' : ''; ?>>D2</option>
                                    <option value="D3" <?= $filter_jenjang == 'D3' ? 'selected' : ''; ?>>D3</option>
                                    <option value="D4" <?= $filter_jenjang == 'D4' ? 'selected' : ''; ?>>D4</option>
                                    <option value="S2" <?= $filter_jenjang == 'S2' ? 'selected' : ''; ?>>S2</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-funnel-fill me-1"></i>Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Data Card -->
            <div class="card shadow">
                <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">
                        <i class="bi bi-list-check me-2"></i>Daftar Program Studi
                    </span>
                    <span class="badge bg-primary"><?= $total_filtered; ?> Data</span>
                </div>
                <div class="card-body p-0">
                    <?php if ($total_filtered > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 60px;">No</th>
                                    <th>Nama Program Studi</th>
                                    <th class="text-center" style="width: 100px;">Jenjang</th>
                                    <th class="text-center" style="width: 120px;">Akreditasi</th>
                                    <th>Keterangan</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                while ($prodi = mysqli_fetch_assoc($result_all_prodi)): 
                                ?>
                                <tr>
                                    <td class="text-center fw-semibold"><?= $no++; ?></td>
                                    <td>
                                        <div class="fw-semibold"><?= $prodi['nama_prodi']; ?></div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info"><?= $prodi['jenjang']; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><?= $prodi['akreditasi']; ?></span>
                                    </td>
                                    <td><small class="text-secondary"><?= $prodi['keterangan'] ?: '-'; ?></small></td>
                                    <td class="text-center">
                                        <a href="input.php?jenis=prodi&id=<?= $prodi['id']; ?>" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="hapus.php?jenis=prodi&id=<?= $prodi['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-inbox fs-1 text-secondary"></i>
                        </div>
                        <h5 class="text-secondary">Tidak ada data ditemukan</h5>
                        <p class="text-secondary mb-4">
                            <?= $search != '' || $filter_jenjang != '' ? 'Coba ubah filter atau kata kunci pencarian' : 'Belum ada program studi yang ditambahkan' ?>
                        </p>
                        <?php if ($search == '' && $filter_jenjang == ''): ?>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahProdi">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Program Studi Pertama
                        </button>
                        <?php else: ?>
                        <a href="index.php?page=prodi" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Reset Filter
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php elseif ($page == 'mahasiswa'): ?>
            <!-- MAHASISWA -->
            <?php
            // Search & Filter
            $search_mhs = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
            $filter_prodi = isset($_GET['prodi_id']) ? $_GET['prodi_id'] : '';
            
            $query_mhs_filter = "SELECT * FROM mahasiswa WHERE 1=1";
            if ($search_mhs != '') {
                $query_mhs_filter .= " AND (nim LIKE '%$search_mhs%' OR nama_mhs LIKE '%$search_mhs%' OR alamat LIKE '%$search_mhs%')";
            }
            if ($filter_prodi != '') {
                $query_mhs_filter .= " AND program_studi_id='$filter_prodi'";
            }
            $query_mhs_filter .= " ORDER BY nim DESC";
            $result_all_mhs = mysqli_query($conn, $query_mhs_filter);
            $total_filtered_mhs = mysqli_num_rows($result_all_mhs);
            ?>
            
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1"><i class="bi bi-people-fill text-success me-2"></i>Mahasiswa</h2>
                    <p class="text-secondary mb-0">Kelola data mahasiswa</p>
                </div>
                <button class="btn btn-success shadow" data-bs-toggle="modal" data-bs-target="#modalTambahMhs">
                    <i class="bi bi-person-plus me-2"></i>Tambah Mahasiswa
                </button>
            </div>

            <!-- Search & Filter Card -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="GET" action="index.php">
                        <input type="hidden" name="page" value="mahasiswa">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" name="search" class="form-control" placeholder="Cari NIM, nama, atau alamat..." value="<?= $search_mhs; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="prodi_id" class="form-select">
                                    <option value="">📚 Semua Program Studi</option>
                                    <?php
                                    $q_all_prodi = mysqli_query($conn, "SELECT * FROM program_studi ORDER BY nama_prodi");
                                    while ($p = mysqli_fetch_assoc($q_all_prodi)):
                                    ?>
                                    <option value="<?= $p['id']; ?>" <?= $filter_prodi == $p['id'] ? 'selected' : ''; ?>>
                                        <?= $p['nama_prodi']; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-funnel-fill me-1"></i>Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Data Card -->
            <div class="card shadow">
                <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">
                        <i class="bi bi-person-lines-fill me-2"></i>Daftar Mahasiswa
                    </span>
                    <span class="badge bg-success"><?= $total_filtered_mhs; ?> Data</span>
                </div>
                <div class="card-body p-0">
                    <?php if ($total_filtered_mhs > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 60px;">No</th>
                                    <th style="width: 120px;">NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th style="width: 130px;">Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th>Program Studi</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                while ($mhs = mysqli_fetch_assoc($result_all_mhs)): 
                                    $prodi_id = $mhs['program_studi_id'];
                                    $query_prodi = "SELECT nama_prodi, jenjang FROM program_studi WHERE id = $prodi_id";
                                    $result_prodi_temp = mysqli_query($conn, $query_prodi);
                                    $prodi_data = mysqli_fetch_assoc($result_prodi_temp);
                                    $nama_prodi = $prodi_data ? $prodi_data['nama_prodi'] : '-';
                                    $jenjang = $prodi_data ? $prodi_data['jenjang'] : '';
                                ?>
                                <tr>
                                    <td class="text-center fw-semibold"><?= $no++; ?></td>
                                    <td><span class="badge bg-info text-dark"><?= $mhs['nim']; ?></span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                <i class="bi bi-person-fill text-white"></i>
                                            </div>
                                            <div class="fw-semibold"><?= $mhs['nama_mhs']; ?></div>
                                        </div>
                                    </td>
                                    <td><small><i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($mhs['tgl_lahir'])); ?></small></td>
                                    <td><small class="text-secondary"><?= substr($mhs['alamat'], 0, 30) . (strlen($mhs['alamat']) > 30 ? '...' : ''); ?></small></td>
                                    <td>
                                        <div class="fw-semibold text-truncate" style="max-width: 150px;"><?= $nama_prodi; ?></div>
                                        <small class="text-secondary"><?= $jenjang; ?></small>
                                    </td>
                                    <td class="text-center">
                                        <a href="input.php?jenis=mahasiswa&nim=<?= $mhs['nim']; ?>" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="hapus.php?jenis=mahasiswa&nim=<?= $mhs['nim']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-people fs-1 text-secondary"></i>
                        </div>
                        <h5 class="text-secondary">Tidak ada data ditemukan</h5>
                        <p class="text-secondary mb-4">
                            <?= $search_mhs != '' || $filter_prodi != '' ? 'Coba ubah filter atau kata kunci pencarian' : 'Belum ada mahasiswa yang ditambahkan' ?>
                        </p>
                        <?php if ($search_mhs == '' && $filter_prodi == ''): ?>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahMhs">
                            <i class="bi bi-person-plus me-2"></i>Tambah Mahasiswa Pertama
                        </button>
                        <?php else: ?>
                        <a href="index.php?page=mahasiswa" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Reset Filter
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
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
</html>