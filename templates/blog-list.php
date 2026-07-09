<?php
$pageTitle = 'ISX Engine Blog - Expert Guides & Technical Articles | ISX Engines';
$pageDescription = 'Expert articles on Cummins ISX engines: troubleshooting guides, maintenance tips, performance upgrades, and technical comparisons for all ISX generations.';
$pageCanonical = SITE_URL . '/blog';

$page_num = max(1, intval($_GET['page'] ?? 1));
$per_page = 9;
$offset = ($page_num - 1) * $per_page;

$total = $db->query("SELECT COUNT(*) FROM blog_posts WHERE is_published = 1")->fetchColumn();
$posts = $db->prepare("SELECT * FROM blog_posts WHERE is_published = 1 ORDER BY created_at DESC LIMIT " . intval($per_page) . " OFFSET " . intval($offset));
$posts->execute();
$posts = $posts->fetchAll();

include __DIR__ . '/header.php';
?>

    <div class="container py-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SITE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">Blog</li>
            </ol>
        </nav>
        
        <h1 class="mb-4">ISX Engine Blog</h1>
        <p class="lead text-muted mb-5">Expert technical articles, troubleshooting guides, and maintenance tips for Cummins ISX engines.</p>
        
        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <?php if ($post['featured_image']): ?>
                            <img src="<?= SITE_URL . $post['featured_image'] ?>" class="card-img-top" style="height:200px;object-fit:cover;" alt="<?= sanitize($post['title']) ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <?php if ($post['category']): ?>
                                <span class="badge bg-danger mb-2"><?= sanitize($post['category']) ?></span>
                            <?php endif; ?>
                            <h2 class="h5 card-title">
                                <a href="<?= SITE_URL ?>/blog/<?= $post['slug'] ?>" class="text-decoration-none text-dark"><?= sanitize($post['title']) ?></a>
                            </h2>
                            <p class="card-text text-muted small"><?= sanitize($post['excerpt'] ?: substr(strip_tags($post['content']), 0, 150)) ?>...</p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <small class="text-muted"><i class="fas fa-user"></i> <?= sanitize($post['author_name']) ?> | <i class="fas fa-calendar"></i> <?= date('M j, Y', strtotime($post['created_at'])) ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($posts)): ?>
                <div class="col-12 text-center text-muted py-5">
                    <i class="fas fa-blog fa-3x mb-3"></i>
                    <p>Blog posts coming soon. We're writing expert ISX engine guides.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($total > $per_page): ?>
        <nav class="mt-5">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= ceil($total / $per_page); $i++): ?>
                    <li class="page-item <?= $i === $page_num ? 'active' : '' ?>">
                        <a class="page-link" href="<?= SITE_URL ?>/blog?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>

<?php include __DIR__ . '/footer.php'; ?>
