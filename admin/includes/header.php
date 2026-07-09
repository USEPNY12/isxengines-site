<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - ISX Engines</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <style>
        :root { --sidebar-width: 250px; --primary: #e94560; --dark: #1a1a2e; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f4f6f9; }
        
        /* Sidebar */
        .sidebar { position: fixed; top: 0; left: 0; width: var(--sidebar-width); height: 100vh; background: var(--dark); color: #fff; z-index: 1000; transition: transform 0.3s; overflow-y: auto; }
        .sidebar .brand { padding: 1.2rem; border-bottom: 1px solid rgba(255,255,255,0.1); font-size: 1.2rem; font-weight: 700; }
        .sidebar .brand i { color: var(--primary); }
        .sidebar .nav-link { color: rgba(255,255,255,0.7); padding: 0.75rem 1.2rem; border-radius: 8px; margin: 2px 8px; transition: all 0.2s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(233,69,96,0.2); }
        .sidebar .nav-link i { width: 24px; margin-right: 8px; }
        
        /* Main content */
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; }
        .top-bar { background: #fff; padding: 0.75rem 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        
        /* Mobile */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 999; }
            .sidebar-overlay.show { display: block; }
        }
        
        /* Cards */
        .card { border-radius: 12px; }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: #c73e54; border-color: #c73e54; }
        
        /* Quill editor */
        .ql-editor { min-height: 300px; }
    </style>
</head>
<body>
    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="brand">
            <i class="fas fa-cogs"></i> ISX Engines
        </div>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'engines.php' ? 'active' : '' ?>" href="engines.php">
                    <i class="fas fa-cogs"></i> Engine Pages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'blog.php' ? 'active' : '' ?>" href="blog.php">
                    <i class="fas fa-blog"></i> Blog Posts
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'pages.php' ? 'active' : '' ?>" href="pages.php">
                    <i class="fas fa-file-alt"></i> Pages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'media.php' ? 'active' : '' ?>" href="media.php">
                    <i class="fas fa-images"></i> Media Library
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'quotes.php' ? 'active' : '' ?>" href="quotes.php">
                    <i class="fas fa-envelope"></i> Quote Requests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'seo.php' ? 'active' : '' ?>" href="seo.php">
                    <i class="fas fa-search"></i> SEO Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'promotions.php' ? 'active' : '' ?>" href="promotions.php">
                    <i class="fas fa-bullhorn"></i> Promotions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>" href="settings.php">
                    <i class="fas fa-cog"></i> Site Settings
                </a>
            </li>
            <li class="nav-item mt-3">
                <a class="nav-link" href="<?= SITE_URL ?>" target="_blank">
                    <i class="fas fa-external-link-alt"></i> View Site
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <button class="btn btn-link d-md-none" onclick="toggleSidebar()">
                <i class="fas fa-bars fa-lg"></i>
            </button>
            <span class="d-none d-md-inline">Welcome, <?= sanitize($_SESSION['admin_name'] ?? 'Admin') ?></span>
            <div>
                <a href="<?= SITE_URL ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-eye"></i> <span class="d-none d-sm-inline">View Site</span>
                </a>
            </div>
        </div>
