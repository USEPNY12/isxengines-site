<?php
$stmt = $db->prepare("SELECT e.*, c.name as cat_name, c.slug as cat_slug FROM engines e LEFT JOIN engine_categories c ON e.category_id = c.id WHERE e.slug = ? AND e.is_published = 1");
$stmt->execute([$slug]);
$engine = $stmt->fetch();

if (!$engine) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    return;
}

// Increment views (optional tracking)
$pageTitle = $engine['meta_title'] ?: $engine['title'] . ' - Specs, Problems & Guide | ISX Engines';
$pageDescription = $engine['meta_description'] ?: $engine['excerpt'] ?: 'Complete guide to the ' . $engine['title'] . '. Technical specifications, common problems, and expert maintenance tips.';
$pageCanonical = SITE_URL . '/engines/' . $engine['slug'];
$pageImage = $engine['featured_image'];

// Article Schema
$schemaJson = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $engine['h1_title'] ?: $engine['title'],
    'description' => $pageDescription,
    'url' => $pageCanonical,
    'datePublished' => $engine['created_at'],
    'dateModified' => $engine['updated_at'],
    'author' => ['@type' => 'Organization', 'name' => 'ISX Engines'],
    'publisher' => ['@type' => 'Organization', 'name' => 'ISX Engines'],
    'mainEntityOfPage' => $pageCanonical
]);

include __DIR__ . '/header.php';
?>

    <article class="container py-5">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SITE_URL ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/engines">Engines</a></li>
                <?php if ($engine['cat_name']): ?>
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/engines/<?= $engine['cat_slug'] ?>"><?= sanitize($engine['cat_name']) ?></a></li>
                <?php endif; ?>
                <li class="breadcrumb-item active"><?= sanitize($engine['title']) ?></li>
            </ol>
        </nav>
        
        <div class="row">
            <div class="col-lg-8">
                <h1 class="mb-3"><?= sanitize($engine['h1_title'] ?: $engine['title']) ?></h1>
                
                <?php if ($engine['featured_image']): ?>
                    <img src="<?= SITE_URL . $engine['featured_image'] ?>" class="img-fluid rounded mb-4 w-100" style="max-height:400px;object-fit:cover;" alt="<?= sanitize($engine['title']) ?>">
                <?php endif; ?>
                
                <!-- Content -->
                <div class="engine-content">
                    <?= $engine['content'] ?>
                </div>
                
                <!-- Key Features -->
                <?php if ($engine['key_features']): ?>
                <div class="mt-4">
                    <h2>Key Features</h2>
                    <ul class="list-group list-group-flush">
                        <?php foreach (explode("\n", $engine['key_features']) as $feature): 
                            $feature = trim($feature);
                            if ($feature): ?>
                                <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i><?= sanitize($feature) ?></li>
                        <?php endif; endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <!-- Common Problems -->
                <?php if ($engine['common_problems']): ?>
                <div class="mt-4">
                    <h2>Common Problems & Issues</h2>
                    <ul class="list-group list-group-flush">
                        <?php foreach (explode("\n", $engine['common_problems']) as $problem): 
                            $problem = trim($problem);
                            if ($problem): ?>
                                <li class="list-group-item"><i class="fas fa-exclamation-triangle text-warning me-2"></i><?= sanitize($problem) ?></li>
                        <?php endif; endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Specs Card -->
                <div class="card border-0 shadow-sm mb-4 sticky-top" style="top:80px;">
                    <div class="card-header bg-danger text-white"><strong><i class="fas fa-clipboard-list"></i> Technical Specifications</strong></div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <?php if ($engine['years_produced']): ?><tr><th class="ps-3">Years</th><td><?= sanitize($engine['years_produced']) ?></td></tr><?php endif; ?>
                            <?php if ($engine['displacement']): ?><tr><th class="ps-3">Displacement</th><td><?= sanitize($engine['displacement']) ?></td></tr><?php endif; ?>
                            <?php if ($engine['configuration']): ?><tr><th class="ps-3">Configuration</th><td><?= sanitize($engine['configuration']) ?></td></tr><?php endif; ?>
                            <?php if ($engine['bore_stroke']): ?><tr><th class="ps-3">Bore x Stroke</th><td><?= sanitize($engine['bore_stroke']) ?></td></tr><?php endif; ?>
                            <?php if ($engine['horsepower']): ?><tr><th class="ps-3">Horsepower</th><td><?= sanitize($engine['horsepower']) ?></td></tr><?php endif; ?>
                            <?php if ($engine['torque']): ?><tr><th class="ps-3">Torque</th><td><?= sanitize($engine['torque']) ?></td></tr><?php endif; ?>
                            <?php if ($engine['ecm_code']): ?><tr><th class="ps-3">ECM</th><td><?= sanitize($engine['ecm_code']) ?></td></tr><?php endif; ?>
                            <?php if ($engine['fuel_type']): ?><tr><th class="ps-3">Fuel</th><td><?= sanitize($engine['fuel_type']) ?></td></tr><?php endif; ?>
                            <?php if ($engine['emission_standard']): ?><tr><th class="ps-3">Emissions</th><td><?= sanitize($engine['emission_standard']) ?></td></tr><?php endif; ?>
                        </table>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="<?= SITE_URL ?>/quote" class="btn btn-danger w-100"><i class="fas fa-envelope"></i> Get a Quote</a>
                    </div>
                </div>
                
                <!-- Related Engines -->
                <?php
                $related = $db->prepare("SELECT title, slug FROM engines WHERE category_id = ? AND id != ? AND is_published = 1 LIMIT 5");
                $related->execute([$engine['category_id'], $engine['id']]);
                $relatedEngines = $related->fetchAll();
                if ($relatedEngines): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white"><strong>Related Engines</strong></div>
                    <div class="list-group list-group-flush">
                        <?php foreach ($relatedEngines as $rel): ?>
                            <a href="<?= SITE_URL ?>/engines/<?= $rel['slug'] ?>" class="list-group-item list-group-item-action"><?= sanitize($rel['title']) ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </article>

<?php include __DIR__ . '/footer.php'; ?>
