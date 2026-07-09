<?php
/**
 * ISX Engines - Database Configuration
 * Supports both Docker (env vars) and local deployment
 */
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_NAME', getenv('DB_NAME') ?: 'isxengines_db');
define('DB_USER', getenv('DB_USER') ?: 'isxuser');
define('DB_PASS', getenv('DB_PASS') ?: 'ISXpass2026!');
define('SITE_URL', getenv('SITE_URL') ?: 'https://isxengines.com');
define('SITE_NAME', 'ISX Engines - US Engine Production');
define('ADMIN_PATH', '/admin');

// File upload settings
define('UPLOAD_DIR', '/var/www/html/assets/uploads/');
define('UPLOAD_URL', SITE_URL . '/assets/uploads/');
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10MB

// Session settings
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
}

// Business Info
define('BUSINESS_PHONE', '1-631-991-7700');
define('BUSINESS_EMAIL', 'sales@usepny.com');
define('BUSINESS_ADDRESS', '200 Bangor St, Lindenhurst, NY 11757');
define('BUSINESS_NAME', 'US Engine Production');

// Database connection function
function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    return $pdo;
}

// Authentication check
function requireLogin() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: ' . SITE_URL . ADMIN_PATH . '/login.php');
        exit;
    }
}

// Helper functions
function sanitize($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}

function generateSlug($str) {
    $str = strtolower(trim($str));
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = preg_replace('/-+/', '-', $str);
    return trim($str, '-');
}
