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
    
    // CEK APAKAH PRODI MASIH DIPAKAI OLEH MAHASISWA
    $cek = mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa WHERE program_studi_id = $id");
    $hasil = mysqli_fetch_assoc($cek);
    
    if ($hasil['total'] > 0) {
        // PRODI MASIH DIPAKAI, TIDAK BISA DIHAPUS
        $_SESSION['error'] = "Program studi tidak bisa dihapus! Masih ada " . $hasil['total'] . " mahasiswa yang terdaftar di program studi ini.";
    } else {
        // PRODI TIDAK DIPAKAI, BOLEH DIHAPUS
        $query = "DELETE FROM program_studi WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Program studi berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus program studi!";
        }
    }
    header("Location: index.php#prodi");
    
} elseif ($jenis == 'mahasiswa') {
    $nim = $_GET['nim'];
    $query = "DELETE FROM mahasiswa WHERE nim = '$nim'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Mahasiswa berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus mahasiswa!";
    }
    header("Location: index.php#mahasiswa");
}
?>