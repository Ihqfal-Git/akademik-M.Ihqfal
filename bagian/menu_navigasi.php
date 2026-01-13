<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistem Akademik</a>
        <div class="d-flex">
            <span class="navbar-text text-white me-3">
                <?= $_SESSION['nama_lengkap']; ?>
            </span>
            <a href="proses.php?aksi=logout" class="btn btn-light btn-sm">Logout</a>
        </div>
    </div>
</nav>