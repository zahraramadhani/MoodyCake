<?php
// auth_check.php
if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['admin_id'])) {
    // belum login -> redirect ke login page (index.php berada di folder admin)
    header("Location: index.php");
    exit();
}
// Kurung kurawal '}' yang berlebih sudah dihapus
?>