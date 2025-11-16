<?php
session_start();
// jika sudah login, redirect ke dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

include '../db_connect.php';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usernameInput = trim($_POST['username'] ?? '');
    $passwordInput = trim($_POST['password'] ?? '');

    if ($usernameInput === '' || $passwordInput === '') {
        $error = "Username dan password tidak boleh kosong.";
    } else {
        // 1. Coba cari berdasarkan username
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $usernameInput);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        // 2. Jika tidak ketemu, coba cari berdasarkan email
        if (!$user) {
            $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $usernameInput);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
        }

        // 3. Verifikasi user
        if ($user) {
            $storedHash = $user['password'];

            // Verifikasi password hash
            if (password_verify($passwordInput, $storedHash)) {
                // login sukses
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'] ?? $user['email'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Username atau password salah.";
            }
        } else {
            $error = "Username atau password salah.";
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - MoodyCake</title>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div style="text-align: center; margin-bottom: 32px;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);">
                    <span style="font-size: 40px;">🎂</span>
                </div>
                <h1 style="margin: 0;">Admin Login</h1>
                <p style="color: #64748b; margin: 8px 0 0 0;">MoodyCake Dashboard</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="error-message">
                    ⚠️ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="index.php" method="POST">
                <div class="form-group">
                    <label for="username">Username atau Email</label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           required 
                           placeholder="Masukkan username atau email"
                           value="<?php echo isset($usernameInput) ? htmlspecialchars($usernameInput) : ''; ?>"
                           style="padding-left: 40px; background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%2394a3b8%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2%22></path><circle cx=%2212%22 cy=%227%22 r=%224%22></circle></svg>'); background-repeat: no-repeat; background-position: 12px center;">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           placeholder="Masukkan password"
                           style="padding-left: 40px; background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%2394a3b8%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><rect x=%223%22 y=%2211%22 width=%2218%22 height=%2211%22 rx=%222%22 ry=%222%22></rect><path d=%22M7 11V7a5 5 0 0 1 10 0v4%22></path></svg>'); background-repeat: no-repeat; background-position: 12px center;">
                </div>
                <button type="submit" class="btn btn-primary">
                    🔐 Login Sekarang
                </button>
            </form>

            <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #e2e8f0; text-align: center;">
                <p style="color: #94a3b8; font-size: 13px; margin: 0;">
                    © 2024 MoodyCake. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>