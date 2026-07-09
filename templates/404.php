<?php
$pageTitle = 'Page Not Found | ISX Engines';
$pageDescription = 'The page you are looking for does not exist.';
$pageCanonical = SITE_URL;
include __DIR__ . '/header.php';
?>

    <div class="container py-5 text-center">
        <i class="fas fa-exclamation-triangle fa-4x text-warning mb-4"></i>
        <h1>404 - Page Not Found</h1>
        <p class="lead text-muted">The page you're looking for doesn't exist or has been moved.</p>
        <a href="<?= SITE_URL ?>" class="btn btn-danger mt-3"><i class="fas fa-home"></i> Back to Home</a>
        <a href="<?= SITE_URL ?>/engines" class="btn btn-outline-secondary mt-3"><i class="fas fa-cogs"></i> Browse Engines</a>
    </div>

<?php include __DIR__ . '/footer.php'; ?>
