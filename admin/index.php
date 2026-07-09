<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$db = getDB();

// Get stats
$engineCount = $db->query("SELECT COUNT(*) FROM engines")->fetchColumn();
$blogCount = $db->query("SELECT COUNT(*) FROM blog_posts")->fetchColumn();
$mediaCount = $db->query("SELECT COUNT(*) FROM media")->fetchColumn();
$quoteCount = $db->query("SELECT COUNT(*) FROM quote_requests WHERE status = 'new'")->fetchColumn();

include __DIR__ . '/includes/header.php';
?>

<div class="container-fluid py-4">
    <h1 class="h3 mb-4">Dashboard</h1>
    
    <div class="row g-3">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-cogs fa-2x text-primary mb-2"></i>
                    <h3 class="mb-0"><?= $engineCount ?></h3>
                    <small class="text-muted">Engine Pages</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-blog fa-2x text-success mb-2"></i>
                    <h3 class="mb-0"><?= $blogCount ?></h3>
                    <small class="text-muted">Blog Posts</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-images fa-2x text-info mb-2"></i>
                    <h3 class="mb-0"><?= $mediaCount ?></h3>
                    <small class="text-muted">Media Files</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-envelope fa-2x text-warning mb-2"></i>
                    <h3 class="mb-0"><?= $quoteCount ?></h3>
                    <small class="text-muted">New Quotes</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4 g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h5 class="mb-0">Quick Actions</h5></div>
                <div class="card-body">
                    <a href="engines.php" class="btn btn-outline-primary me-2 mb-2"><i class="fas fa-plus"></i> Add Engine</a>
                    <a href="blog.php?action=new" class="btn btn-outline-success me-2 mb-2"><i class="fas fa-plus"></i> New Blog Post</a>
                    <a href="media.php" class="btn btn-outline-info me-2 mb-2"><i class="fas fa-upload"></i> Upload Images</a>
                    <a href="pages.php" class="btn btn-outline-secondary me-2 mb-2"><i class="fas fa-file"></i> Edit Pages</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h5 class="mb-0">Recent Quote Requests</h5></div>
                <div class="card-body">
                    <?php
                    $quotes = $db->query("SELECT * FROM quote_requests ORDER BY created_at DESC LIMIT 5")->fetchAll();
                    if (empty($quotes)): ?>
                        <p class="text-muted">No quote requests yet.</p>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                        <?php foreach ($quotes as $q): ?>
                            <div class="list-group-item px-0">
                                <strong><?= sanitize($q['name']) ?></strong> - <?= sanitize($q['engine_model']) ?>
                                <br><small class="text-muted"><?= date('M j, Y', strtotime($q['created_at'])) ?></small>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
