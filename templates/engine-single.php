<?php
$stmt = $db->prepare("SELECT e.*, c.name as cat_name, c.slug as cat_slug FROM engines e LEFT JOIN engine_categories c ON e.category_id = c.id WHERE e.slug = ? AND e.is_published = 1");
$stmt->execute([$slug]);
$engine = $stmt->fetch();

if (!$engine) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    return;
}

$pageTitle = $engine['title'] . ' Remanufactured Long Block | ISX Engines';
$pageDescription = 'Buy a remanufactured ' . $engine['title'] . ' long block from US Engine Production. ' . $engine['horsepower'] . '. 1-Year Unlimited Mileage Warranty. $' . number_format($engine['price'], 0) . '. Ships in 24-48 hrs.';
$pageCanonical = SITE_URL . '/engines/' . $engine['slug'];
$pageImage = $engine['featured_image'];

// Generate SKU from engine title
$sku = 'USISX' . strtoupper(preg_replace('/[^A-Za-z0-9]/', '', str_replace(['Cummins ', 'ISX ', 'ISX15 ', ' Series'], '', $engine['title'])));

// Product Schema for rich results
$schemaJson = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $engine['title'] . ' Remanufactured Long Block',
    'description' => $pageDescription,
    'sku' => $sku,
    'url' => $pageCanonical,
    'image' => $engine['featured_image'] ? SITE_URL . $engine['featured_image'] : '',
    'brand' => ['@type' => 'Brand', 'name' => 'Cummins'],
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

    <article class="container py-4">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="<?= SITE_URL ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/engines">Engines</a></li>
                <?php if ($engine['cat_name']): ?>
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/engines/<?= $engine['cat_slug'] ?>"><?= sanitize($engine['cat_name']) ?></a></li>
                <?php endif; ?>
                <li class="breadcrumb-item active"><?= $sku ?></li>
            </ol>
        </nav>
        
        <!-- Product Header Section -->
        <div class="row mb-5">
            <!-- Product Image -->
            <div class="col-lg-5 mb-4 mb-lg-0">
                <?php if ($engine['featured_image']): ?>
                    <div class="bg-dark rounded p-3 text-center">
                        <img src="<?= SITE_URL . $engine['featured_image'] ?>" class="img-fluid" style="max-height:400px;object-fit:contain;" alt="<?= sanitize($engine['title']) ?> Remanufactured Long Block">
                    </div>
                <?php else: ?>
                    <div class="bg-dark rounded d-flex align-items-center justify-content-center" style="height:400px;">
                        <i class="fas fa-cogs fa-5x text-secondary"></i>
                    </div>
                <?php endif; ?>
                <div class="text-center mt-2">
                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> In Stock - Ready to Ship</span>
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="col-lg-7">
                <span class="text-danger fw-bold text-uppercase small"><?= sanitize($engine['cat_name'] ?: 'Cummins ISX') ?></span>
                
                <h1 class="h2 fw-bold mt-1 mb-2"><?= sanitize($engine['title']) ?> Remanufactured Long Block (<?= sanitize($engine['horsepower']) ?>)</h1>
                
                <p class="text-muted mb-3">SKU: <strong><?= $sku ?></strong></p>
                
                <!-- Warranty Badge -->
                <div class="alert alert-success py-2 px-3 d-inline-flex align-items-center mb-3">
                    <i class="fas fa-shield-alt text-success me-2"></i>
                    <strong>1 Year Unlimited Mileage Warranty</strong> <span class="ms-1">included with this remanufactured engine</span>
                </div>
                
                <!-- Price -->
                <div class="mb-4">
                    <span class="display-5 fw-bold">$<?= number_format($engine['price'], 2) ?></span>
                </div>
                
                <!-- Action Buttons -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <a href="<?= SITE_URL ?>/quote" class="btn btn-danger btn-lg px-4"><i class="fas fa-shopping-cart me-2"></i>Add to Quote</a>
                    <a href="tel:6319917700" class="btn btn-outline-dark btn-lg px-4"><i class="fas fa-phone me-2"></i>Call for Better Price</a>
                </div>
                
                <!-- Short Description -->
                <div class="border-top pt-3">
                    <p class="text-muted"><?= sanitize($engine['excerpt']) ?> 1-Year Warranty. Ships in 24-48 hours.</p>
                </div>
            </div>
        </div>
        
        <!-- Product Details Section -->
        <div class="row">
            <div class="col-lg-8">
                <h2 class="h4 fw-bold border-bottom pb-2 mb-4">Product Details</h2>
                
                <!-- What's Included -->
                <div class="mb-4">
                    <h3 class="h5 fw-bold mb-3">Our <?= sanitize($engine['title']) ?> Remanufactured Long Block Includes:</h3>
                    <div class="row g-0">
                        <div class="col-md-4">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td><i class="fas fa-check text-success me-1"></i> Cam Bearings</td></tr>
                                <tr><td><i class="fas fa-check text-success me-1"></i> Main Bearings</td></tr>
                                <tr><td><i class="fas fa-check text-success me-1"></i> Rod Bearings</td></tr>
                                <tr><td><i class="fas fa-check text-success me-1"></i> Camshaft</td></tr>
                                <tr><td><i class="fas fa-check text-success me-1"></i> Connecting Rods</td></tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td><i class="fas fa-check text-success me-1"></i> Pistons</td></tr>
                                <tr><td><i class="fas fa-check text-success me-1"></i> Piston Rings</td></tr>
                                <tr><td><i class="fas fa-check text-success me-1"></i> Oil Pump</td></tr>
                                <tr><td><i class="fas fa-check text-success me-1"></i> Push Rods</td></tr>
                                <tr><td><i class="fas fa-check text-success me-1"></i> Rocker Arms</td></tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td><i class="fas fa-check text-success me-1"></i> Timing Gears</td></tr>
                                <tr><td><i class="fas fa-check text-success me-1"></i> Valves</td></tr>
                                <tr><td><i class="fas fa-check text-success me-1"></i> Valve Guides</td></tr>
                                <tr><td><i class="fas fa-check text-success me-1"></i> Valve Springs</td></tr>
                                <tr><td><i class="fas fa-check text-success me-1"></i> Complete Gasket Set</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Engine Specifications -->
                <div class="mb-4">
                    <h3 class="h5 fw-bold mb-3">Engine Specifications:</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <ul class="list-unstyled">
                                <?php if ($engine['displacement']): ?><li class="mb-2"><strong>Displacement:</strong> <?= sanitize($engine['displacement']) ?></li><?php endif; ?>
                                <?php if ($engine['horsepower']): ?><li class="mb-2"><strong>Horsepower:</strong> <?= sanitize($engine['horsepower']) ?></li><?php endif; ?>
                                <?php if ($engine['torque']): ?><li class="mb-2"><strong>Torque:</strong> <?= sanitize($engine['torque']) ?></li><?php endif; ?>
                                <?php if ($engine['configuration']): ?><li class="mb-2"><strong>Configuration:</strong> <?= sanitize($engine['configuration']) ?></li><?php endif; ?>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="list-unstyled">
                                <?php if ($engine['years_produced']): ?><li class="mb-2"><strong>Years:</strong> <?= sanitize($engine['years_produced']) ?></li><?php endif; ?>
                                <?php if ($engine['ecm_code']): ?><li class="mb-2"><strong>ECM:</strong> <?= sanitize($engine['ecm_code']) ?></li><?php endif; ?>
                                <?php if ($engine['bore_stroke']): ?><li class="mb-2"><strong>Bore x Stroke:</strong> <?= sanitize($engine['bore_stroke']) ?></li><?php endif; ?>
                                <?php if ($engine['emission_standard']): ?><li class="mb-2"><strong>Emissions:</strong> <?= sanitize($engine['emission_standard']) ?></li><?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Application Info -->
                <div class="mb-4">
                    <h3 class="h5 fw-bold mb-3">Application:</h3>
                    <p>Class 8 heavy-duty trucks, over-the-road (OTR), vocational, and heavy-haul applications. Compatible with Kenworth, Peterbilt, Freightliner, International, Western Star, and Volvo/Mack chassis.</p>
                </div>
                
                <!-- Product Description -->
                <div class="mb-4">
                    <p>Every long block is completely remanufactured to OEM specifications using premium components. All wear surfaces are restored to factory tolerances. Our in-house team at US Engine Production in Lindenhurst, NY disassembles each core down to the bare block, inspects and machines all critical surfaces, and reassembles with new or reconditioned parts that meet or exceed original specifications.</p>
                    
                    <p>We stand behind our unbeatable quality with a <strong>One Year Unlimited Mileage Warranty!</strong></p>
                    
                    <p>Call us today with any questions and to verify this engine will work for your application: <a href="tel:6319917700" class="text-danger fw-bold">(631) 991-7700</a></p>
                </div>
                
                <!-- Remanufacturing Process -->
                <div class="bg-light rounded p-4 mb-4">
                    <h3 class="h5 fw-bold mb-3"><i class="fas fa-tools text-danger me-2"></i>Our Remanufacturing Process</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <span class="badge bg-danger rounded-circle me-2 mt-1" style="width:24px;height:24px;line-height:16px;font-size:12px;">1</span>
                                <div><strong>Complete Teardown</strong> — Dismantled to bare block</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <span class="badge bg-danger rounded-circle me-2 mt-1" style="width:24px;height:24px;line-height:16px;font-size:12px;">2</span>
                                <div><strong>Thermal Cleaning</strong> — Magnafluxing & decontamination</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <span class="badge bg-danger rounded-circle me-2 mt-1" style="width:24px;height:24px;line-height:16px;font-size:12px;">3</span>
                                <div><strong>Precision Inspection</strong> — Measured to OEM tolerances</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <span class="badge bg-danger rounded-circle me-2 mt-1" style="width:24px;height:24px;line-height:16px;font-size:12px;">4</span>
                                <div><strong>CNC Machining</strong> — All critical surfaces restored</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <span class="badge bg-danger rounded-circle me-2 mt-1" style="width:24px;height:24px;line-height:16px;font-size:12px;">5</span>
                                <div><strong>Expert Assembly</strong> — Premium OEM-spec components</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <span class="badge bg-danger rounded-circle me-2 mt-1" style="width:24px;height:24px;line-height:16px;font-size:12px;">6</span>
                                <div><strong>Dyno Tested</strong> — Full load testing before shipping</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Order Card -->
                <div class="card border-danger shadow-sm mb-4 sticky-top" style="top:80px;">
                    <div class="card-header bg-danger text-white text-center">
                        <strong><i class="fas fa-truck-fast me-1"></i> Ships in 24-48 Hours</strong>
                    </div>
                    <div class="card-body text-center">
                        <span class="display-6 fw-bold">$<?= number_format($engine['price'], 2) ?></span>
                        <p class="text-muted small mb-3">1-Year Unlimited Mileage Warranty</p>
                        <a href="<?= SITE_URL ?>/quote" class="btn btn-danger w-100 mb-2"><i class="fas fa-shopping-cart me-1"></i> Add to Quote</a>
                        <a href="tel:6319917700" class="btn btn-outline-dark w-100 mb-3"><i class="fas fa-phone me-1"></i> (631) 991-7700</a>
                        <div class="border-top pt-3">
                            <div class="row text-center small text-muted">
                                <div class="col-4"><i class="fas fa-shield-alt d-block text-success mb-1"></i>1-Year<br>Warranty</div>
                                <div class="col-4"><i class="fas fa-truck d-block text-primary mb-1"></i>Free<br>Shipping</div>
                                <div class="col-4"><i class="fas fa-tools d-block text-warning mb-1"></i>Dyno<br>Tested</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Related Engines -->
                <?php
                $related = $db->prepare("SELECT title, slug, price, horsepower FROM engines WHERE category_id = ? AND id != ? AND is_published = 1 LIMIT 4");
                $related->execute([$engine['category_id'], $engine['id']]);
                $relatedEngines = $related->fetchAll();
                if (!$relatedEngines) {
                    $related = $db->prepare("SELECT title, slug, price, horsepower FROM engines WHERE id != ? AND is_published = 1 ORDER BY RAND() LIMIT 4");
                    $related->execute([$engine['id']]);
                    $relatedEngines = $related->fetchAll();
                }
                if ($relatedEngines): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white"><strong>Related ISX Engines</strong></div>
                    <div class="list-group list-group-flush">
                        <?php foreach ($relatedEngines as $rel): ?>
                            <a href="<?= SITE_URL ?>/engines/<?= $rel['slug'] ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?= sanitize($rel['title']) ?></strong>
                                    <br><small class="text-muted"><?= sanitize($rel['horsepower']) ?></small>
                                </div>
                                <span class="text-success fw-bold">$<?= number_format($rel['price'], 0) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Need Help Section -->
        <div class="bg-dark text-white rounded p-4 mt-5 text-center">
            <h3 class="h4 mb-2">Need Help Choosing the Right Engine?</h3>
            <p class="text-light mb-3">Our experts are ready to help you find the perfect remanufactured engine for your application.</p>
            <a href="tel:6319917700" class="btn btn-danger btn-lg me-2"><i class="fas fa-phone me-2"></i>(631) 991-7700</a>
            <a href="<?= SITE_URL ?>/quote" class="btn btn-outline-light btn-lg"><i class="fas fa-envelope me-2"></i>Request Quote</a>
        </div>
    </article>

<?php include __DIR__ . '/footer.php'; ?>
