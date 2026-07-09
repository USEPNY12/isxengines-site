<?php
// If slug is provided, show engines in that category
$category = null;
if (!empty($slug)) {
    $stmt = $db->prepare("SELECT * FROM engine_categories WHERE slug = ?");
    $stmt->execute([$slug]);
    $category = $stmt->fetch();
}

if ($category) {
    $pageTitle = $category['name'] . ' - Cummins ISX Engine Guide | ISX Engines';
    $pageDescription = $category['description'];
    $pageCanonical = SITE_URL . '/engines/' . $category['slug'];
    $engines = $db->prepare("SELECT * FROM engines WHERE category_id = ? AND is_published = 1 ORDER BY sort_order, years_produced");
    $engines->execute([$category['id']]);
    $engines = $engines->fetchAll();
} else {
    $pageTitle = 'All Cummins ISX Engines - Complete Model Guide | ISX Engines';
    $pageDescription = 'Browse every Cummins ISX engine model from 1998 to present. Detailed specs, common problems, and expert guides for ISX CM570, CM870, CM871, ISX15, X15, and X12.';
    $pageCanonical = SITE_URL . '/engines';
    $engines = $db->query("SELECT e.*, c.name as cat_name FROM engines e LEFT JOIN engine_categories c ON e.category_id = c.id WHERE e.is_published = 1 ORDER BY e.sort_order, e.years_produced")->fetchAll();
}

// BreadcrumbList schema
$breadcrumbs = [
    ['name' => 'Home', 'url' => SITE_URL],
    ['name' => 'Engines', 'url' => SITE_URL . '/engines']
];
if ($category) {
    $breadcrumbs[] = ['name' => $category['name'], 'url' => $pageCanonical];
}
$schemaJson = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => array_map(function($b, $i) {
        return ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $b['name'], 'item' => $b['url']];
    }, $breadcrumbs, array_keys($breadcrumbs))
]);

include __DIR__ . '/header.php';
?>

    <div class="container py-5">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SITE_URL ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/engines">Engines</a></li>
                <?php if ($category): ?>
                    <li class="breadcrumb-item active"><?= sanitize($category['name']) ?></li>
                <?php endif; ?>
            </ol>
        </nav>
        
        <h1 class="mb-4"><?= $category ? sanitize($category['name']) : 'All Cummins ISX Engines' ?></h1>
        <?php if ($category): ?>
            <p class="lead text-muted mb-4"><?= sanitize($category['description']) ?></p>
        <?php endif; ?>
        
        <?php if (!$category): ?>
        <!-- Category Filter -->
        <div class="mb-4">
            <?php
            $cats = $db->query("SELECT * FROM engine_categories WHERE is_active = 1 ORDER BY sort_order")->fetchAll();
            foreach ($cats as $c): ?>
                <a href="<?= SITE_URL ?>/engines/<?= $c['slug'] ?>" class="btn btn-outline-danger btn-sm me-1 mb-1"><?= sanitize($c['name']) ?></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <!-- Engine Grid -->
        <div class="row g-4">
            <?php foreach ($engines as $eng): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <?php if ($eng['featured_image']): ?>
                            <img src="<?= SITE_URL . $eng['featured_image'] ?>" class="card-img-top" style="height:200px;object-fit:cover;" alt="<?= sanitize($eng['title']) ?>">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                                <i class="fas fa-cogs fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h3 class="h5 card-title">
                                <a href="<?= SITE_URL ?>/engines/<?= $eng['slug'] ?>" class="text-decoration-none text-dark"><?= sanitize($eng['title']) ?></a>
                            </h3>
                            <p class="card-text text-muted small"><?= sanitize($eng['excerpt'] ?: substr(strip_tags($eng['content']), 0, 100)) ?>...</p>
                            <div class="mt-2">
                                <?php if ($eng['years_produced']): ?><span class="badge bg-secondary me-1"><?= sanitize($eng['years_produced']) ?></span><?php endif; ?>
                                <?php if ($eng['ecm_code']): ?><span class="badge bg-danger"><?= sanitize($eng['ecm_code']) ?></span><?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="<?= SITE_URL ?>/engines/<?= $eng['slug'] ?>" class="btn btn-outline-danger btn-sm w-100">View Full Specs &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($engines)): ?>
                <div class="col-12 text-center text-muted py-5">
                    <i class="fas fa-cogs fa-3x mb-3"></i>
                    <p>Engine pages are being added. Check back soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php include __DIR__ . '/footer.php'; ?>
