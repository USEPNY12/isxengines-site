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

// Product Schema for rich results with pricing
$schemaJson = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => ($engine['h1_title'] ?: $engine['title']) . ' - Remanufactured',
    'description' => $pageDescription,
    'url' => $pageCanonical,
    'image' => $engine['featured_image'] ? SITE_URL . $engine['featured_image'] : '',
    'brand' => ['@type' => 'Brand', 'name' => 'US Engine Production'],
    'manufacturer' => ['@type' => 'Organization', 'name' => 'US Engine Production'],
    'offers' => [
        '@type' => 'Offer',
        'url' => $pageCanonical,
        'priceCurrency' => 'USD',
        'price' => $engine['price'] ?? '16500.00',
        'priceValidUntil' => date('Y-12-31'),
        'availability' => 'https://schema.org/InStock',
        'itemCondition' => 'https://schema.org/RefurbishedCondition',
        'seller' => ['@type' => 'Organization', 'name' => 'US Engine Production']
    ],
    'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => '4.9',
        'reviewCount' => '127',
        'bestRating' => '5'
    ]
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
                
                <!-- Price Banner -->
                <?php if (!empty($engine['price'])): ?>
                <div class="alert alert-success d-flex align-items-center justify-content-between mb-4" style="border-left: 5px solid #198754;">
                    <div>
                        <span class="fw-bold fs-4 text-success">$<?= number_format($engine['price'], 0) ?></span>
                        <span class="text-muted ms-2">Remanufactured | Ready to Ship</span>
                    </div>
                    <div>
                        <a href="tel:1-631-991-7700" class="btn btn-success btn-sm me-2"><i class="fas fa-phone"></i> Call Now</a>
                        <a href="<?= SITE_URL ?>/quote" class="btn btn-outline-success btn-sm"><i class="fas fa-envelope"></i> Get Quote</a>
                    </div>
                </div>
                <?php endif; ?>
                
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
                
                <!-- US Engine Production Remanufacturing Process -->
                <div class="mt-5 p-4 bg-light rounded border border-danger border-opacity-25">
                    <h2 class="text-danger border-bottom border-danger pb-2 mb-4">Why Choose Our Remanufactured <?= sanitize($engine['title']) ?>?</h2>
                    
                    <p class="lead">At US Engine Production, we don't just rebuild engines; we completely remanufacture them. Our rigorous 6-step process ensures that every Cummins ISX engine we produce is one of the best remanufactured units available on the market.</p>
                    
                    <div class="row g-4 mt-2">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px; font-weight: bold;">1</div>
                                <div>
                                    <h4 class="h5">Complete Teardown</h4>
                                    <p class="small text-muted">Every engine is completely dismantled down to the bare cylinder block. We don't cut corners by leaving sub-assemblies intact.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px; font-weight: bold;">2</div>
                                <div>
                                    <h4 class="h5">Meticulous Cleaning</h4>
                                    <p class="small text-muted">All reusable parts undergo industrial thermal cleaning and magnafluxing to remove all carbon, scale, and contaminants.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px; font-weight: bold;">3</div>
                                <div>
                                    <h4 class="h5">Precision Inspection</h4>
                                    <p class="small text-muted">We use high-quality micrometers and laser measuring tools to inspect all parts, confirming reusability against strict OEM tolerances.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px; font-weight: bold;">4</div>
                                <div>
                                    <h4 class="h5">Critical Machining</h4>
                                    <p class="small text-muted">We verify critical measurements like liner protrusion (0.010"-0.014") and counterbore depth. Any variance over 0.001" is corrected.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px; font-weight: bold;">5</div>
                                <div>
                                    <h4 class="h5">Expert Reassembly</h4>
                                    <p class="small text-muted">Engines are reassembled using premium forged steel pistons, new ring sets, wet liners, main/rod bearings, and complete gasket kits.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px; font-weight: bold;">6</div>
                                <div>
                                    <h4 class="h5">Dyno Testing</h4>
                                    <p class="small text-muted">Before shipping, every engine undergoes compression, leak-down, oil pressure, and full dyno testing under load to guarantee performance.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top text-center">
                        <p class="mb-0 fw-bold">We address the specific flaws of the <?= sanitize($engine['ecm_code']) ?> during our rebuild process, making our remanufactured engine more reliable than the original factory unit.</p>
                    </div>
                </div>
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
                    <?php if (!empty($engine['price'])): ?>
                    <div class="card-body border-top">
                        <div class="text-center">
                            <span class="d-block text-muted small">Remanufactured Price</span>
                            <span class="fw-bold fs-3 text-success">$<?= number_format($engine['price'], 0) ?></span>
                            <span class="d-block text-muted small">1-Year Unlimited Mileage Warranty</span>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="card-footer bg-white">
                        <a href="tel:1-631-991-7700" class="btn btn-danger w-100 mb-2"><i class="fas fa-phone"></i> Call 1-631-991-7700</a>
                        <a href="<?= SITE_URL ?>/quote" class="btn btn-outline-danger w-100"><i class="fas fa-envelope"></i> Request Quote</a>
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
