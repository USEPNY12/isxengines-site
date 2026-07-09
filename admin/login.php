<?php
session_start();
require_once __DIR__ . '/../includes/config.php';

if (isLoggedIn()) {
    redirect(SITE_URL . ADMIN_PATH . '/');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_name'] = $user['full_name'];
            $_SESSION['admin_role'] = $user['role'];
            
            // Update last login
            $db->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);
            
            redirect(SITE_URL . ADMIN_PATH . '/');
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ISX Engines</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: #fff; border-radius: 16px; padding: 2.5rem; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-width: 420px; width: 100%; }
        .login-card h2 { color: #1a1a2e; font-weight: 700; }
        .login-card .logo { font-size: 2rem; color: #e94560; margin-bottom: 1rem; }
        .btn-primary { background: #e94560; border-color: #e94560; }
        .btn-primary:hover { background: #c73e54; border-color: #c73e54; }
        .form-control:focus { border-color: #e94560; box-shadow: 0 0 0 0.2rem rgba(233,69,96,0.25); }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center">
            <div class="logo"><i class="fas fa-cogs"></i></div>
            <h2>ISX Engines Admin</h2>
            <p class="text-muted">Sign in to manage your website</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger mt-3"><i class="fas fa-exclamation-circle"></i> <?= sanitize($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label class="form-label">Username or Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Enter username" required autofocus>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 mt-2">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>
    </div>
</body>
</html>
