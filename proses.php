<?php
session_start();
include 'koneksi.php';

$aksi = $_GET['aksi'];

if ($aksi == 'register') {
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Cek email sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM pengguna WHERE email = '$email'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['error'] = "Email sudah terdaftar!";
        header("Location: register.php");
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO pengguna (nama_lengkap, email, password) VALUES ('$nama_lengkap', '$email', '$password_hash')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
            header("Location: login.php");
        }
    }
}

if ($aksi == 'login') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM pengguna WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['email'] = $user['email'];
            header("Location: index.php");
        } else {
            $_SESSION['error'] = "Password salah!";
            header("Location: login.php");
        }
    } else {
        $_SESSION['error'] = "Email tidak ditemukan!";
        header("Location: login.php");
    }
}

if ($aksi == 'logout') {
    session_destroy();
    header("Location: login.php");
}

if ($aksi == 'tambah_prodi') {
    $nama_prodi = mysqli_real_escape_string($conn, $_POST['nama_prodi']);
    $jenjang = $_POST['jenjang'];
    $akreditasi = mysqli_real_escape_string($conn, $_POST['akreditasi']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    
    $query = "INSERT INTO program_studi (nama_prodi, jenjang, akreditasi, keterangan) VALUES ('$nama_prodi', '$jenjang', '$akreditasi', '$keterangan')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Program studi berhasil ditambahkan!";
    }
    header("Location: index.php#prodi");
}

if ($aksi == 'edit_prodi') {
    $id = $_POST['id'];
    $nama_prodi = mysqli_real_escape_string($conn, $_POST['nama_prodi']);
    $jenjang = $_POST['jenjang'];
    $akreditasi = mysqli_real_escape_string($conn, $_POST['akreditasi']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    
    $query = "UPDATE program_studi SET nama_prodi='$nama_prodi', jenjang='$jenjang', akreditasi='$akreditasi', keterangan='$keterangan' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Program studi berhasil diupdate!";
    }
    header("Location: index.php#prodi");
}

if ($aksi == 'tambah_mahasiswa') {
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama_mhs = mysqli_real_escape_string($conn, $_POST['nama_mhs']);
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $program_studi_id = $_POST['program_studi_id'];
    
    $query = "INSERT INTO mahasiswa (nim, nama_mhs, tgl_lahir, alamat, program_studi_id) VALUES ('$nim', '$nama_mhs', '$tgl_lahir', '$alamat', $program_studi_id)";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Mahasiswa berhasil ditambahkan!";
    }
    header("Location: index.php#mahasiswa");
}

if ($aksi == 'edit_mahasiswa') {
    $nim_lama = $_POST['nim_lama'];  // NIM lama untuk WHERE clause
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);  // NIM baru
    $nama_mhs = mysqli_real_escape_string($conn, $_POST['nama_mhs']);
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $program_studi_id = $_POST['program_studi_id'];
    
    $query = "UPDATE mahasiswa SET nim='$nim', nama_mhs='$nama_mhs', tgl_lahir='$tgl_lahir', alamat='$alamat', program_studi_id=$program_studi_id WHERE nim='$nim_lama'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Mahasiswa berhasil diupdate!";
    }
    header("Location: index.php#mahasiswa");
}
?>