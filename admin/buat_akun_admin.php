<?php
// Ganti 'PasswordAmanSaya123' dengan password yang Anda inginkan
$password_saya = 'admin123';

$hash = password_hash($password_saya, PASSWORD_DEFAULT);

echo "<h3>Password Anda:</h3>";
echo "<p>" . htmlspecialchars($password_saya) . "</p>";

echo "<h3>Hash untuk Database (SAlIN INI):</h3>";
echo "<textarea style='width: 100%; height: 60px;'>" . $hash . "</textarea>";

echo "<p style='color:red; font-weight:bold;'>PENTING: Setelah menyalin hash di atas, segera HAPUS file 'buat_admin.php' ini dari server Anda.</p>";
?>