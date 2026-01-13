<?php
// Cek koneksi database paling dasar
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_akademik2";

echo "<h2>Pengecekan Database</h2>";

// Test 1: Koneksi ke MySQL (tanpa database)
echo "<h3>Test 1: Koneksi ke MySQL Server</h3>";
$conn_test = mysqli_connect($host, $user, $pass);
if ($conn_test) {
    echo "✅ Koneksi ke MySQL Server BERHASIL!<br><br>";
    
    // Test 2: Cek database ada atau tidak
    echo "<h3>Test 2: Cek Database '$db' Ada atau Tidak</h3>";
    $db_check = mysqli_select_db($conn_test, $db);
    if ($db_check) {
        echo "✅ Database '$db' DITEMUKAN!<br><br>";
        
        // Test 3: Tampilkan semua tabel
        echo "<h3>Test 3: Daftar Tabel di Database '$db'</h3>";
        $tables = mysqli_query($conn_test, "SHOW TABLES");
        if ($tables) {
            echo "<ul>";
            $found_mahasiswa = false;
            $found_prodi = false;
            while ($table = mysqli_fetch_array($tables)) {
                echo "<li>" . $table[0] . "</li>";
                if ($table[0] == 'mahasiswa') $found_mahasiswa = true;
                if ($table[0] == 'program_studi') $found_prodi = true;
            }
            echo "</ul>";
            
            // Test 4: Cek tabel mahasiswa
            echo "<h3>Test 4: Cek Tabel Mahasiswa</h3>";
            if ($found_mahasiswa) {
                echo "✅ Tabel 'mahasiswa' DITEMUKAN!<br>";
                $count = mysqli_query($conn_test, "SELECT COUNT(*) as total FROM mahasiswa");
                $total = mysqli_fetch_assoc($count);
                echo "Jumlah data mahasiswa: " . $total['total'] . "<br><br>";
            } else {
                echo "❌ Tabel 'mahasiswa' TIDAK DITEMUKAN!<br><br>";
            }
            
            // Test 5: Cek tabel program_studi
            echo "<h3>Test 5: Cek Tabel Program Studi</h3>";
            if ($found_prodi) {
                echo "✅ Tabel 'program_studi' DITEMUKAN!<br>";
                $count = mysqli_query($conn_test, "SELECT COUNT(*) as total FROM program_studi");
                $total = mysqli_fetch_assoc($count);
                echo "Jumlah data program studi: " . $total['total'] . "<br><br>";
            } else {
                echo "❌ Tabel 'program_studi' TIDAK DITEMUKAN!<br><br>";
            }
            
            // Test 6: Coba query JOIN
            if ($found_mahasiswa && $found_prodi) {
                echo "<h3>Test 6: Test Query JOIN</h3>";
                $join_query = "SELECT mahasiswa.id, mahasiswa.nim, mahasiswa.nama_mhs, program_studi.nama_prodi 
                               FROM mahasiswa 
                               LEFT JOIN program_studi ON mahasiswa.program_studi_id = program_studi.id 
                               LIMIT 5";
                $result = mysqli_query($conn_test, $join_query);
                if ($result) {
                    echo "✅ Query JOIN BERHASIL!<br>";
                    echo "<table border='1' cellpadding='5' style='margin-top:10px;'>";
                    echo "<tr><th>ID</th><th>NIM</th><th>Nama</th><th>Program Studi</th></tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nim'] . "</td>";
                        echo "<td>" . $row['nama_mhs'] . "</td>";
                        echo "<td>" . ($row['nama_prodi'] ?? 'NULL') . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "❌ Query JOIN GAGAL!<br>";
                    echo "Error: " . mysqli_error($conn_test) . "<br>";
                }
            }
            
        } else {
            echo "❌ Gagal mengambil daftar tabel<br>";
            echo "Error: " . mysqli_error($conn_test) . "<br>";
        }
        
    } else {
        echo "❌ Database '$db' TIDAK DITEMUKAN!<br>";
        echo "Periksa nama database di phpMyAdmin<br><br>";
        
        echo "<h3>Daftar Database yang Ada:</h3>";
        $databases = mysqli_query($conn_test, "SHOW DATABASES");
        echo "<ul>";
        while ($db_name = mysqli_fetch_array($databases)) {
            echo "<li>" . $db_name[0] . "</li>";
        }
        echo "</ul>";
    }
    
} else {
    echo "❌ Koneksi ke MySQL Server GAGAL!<br>";
    echo "Error: " . mysqli_connect_error() . "<br>";
    echo "<br>Pastikan:<br>";
    echo "- XAMPP sudah running<br>";
    echo "- Apache dan MySQL sudah start<br>";
}
?>