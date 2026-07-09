<?php
$pageTitle = 'Remanufactured Cummins ISX Engines | US Engine Production';
$pageDescription = 'Premium remanufactured Cummins ISX engines from US Engine Production. ISX CM570, CM870, CM871, ISX15 CM2250, CM2350, X15, and X12. 1-year unlimited mileage warranty. Call 1-631-991-7700.';
$pageCanonical = SITE_URL;

// Get all engines for homepage display
$allEngines = $db->query("SELECT e.*, c.name as cat_name, c.slug as cat_slug FROM engines e LEFT JOIN engine_categories c ON e.category_id = c.id WHERE e.is_published = 1 ORDER BY e.sort_order, e.years_produced")->fetchAll();

// Get categories
$categories = $db->query("SELECT * FROM engine_categories WHERE is_active = 1 ORDER BY sort_order")->fetchAll();

// Get active promotions
$promotions = $db->query("SELECT * FROM promotions WHERE is_active = 1 AND (starts_at IS NULL OR starts_at <= NOW()) AND (ends_at IS NULL OR ends_at >= NOW()) ORDER BY sort_order")->fetchAll();

// Organization Schema
$schemaJson = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'AutoPartsStore',
    'name' => 'US Engine Production - ISX Engines',
    'description' => $pageDescription,
    'url' => SITE_URL,
    'telephone' => '1-631-991-7700',
    'email' => 'sales@usepny.com',
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => '200 Bangor St',
        'addressLocality' => 'Lindenhurst',
        'addressRegion' => 'NY',
        'postalCode' => '11757',
        'addressCountry' => 'US'
    ],
    'openingHours' => 'Mo-Fr 08:00-18:00',
    'priceRange' => '$16,500'
]);

include __DIR__ . '/header.php';
?>

<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); padding: 80px 0; position: relative; overflow: hidden;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-danger mb-3 px-3 py-2" style="font-size: 0.9rem;">
                    <i class="fas fa-shield-alt me-1"></i> 1-Year Unlimited Mileage Warranty
                </span>
                <h1 class="text-white display-4 fw-bold mb-3">
                    Remanufactured<br>
                    <span style="color: #e94560;">Cummins ISX Engines</span>
                </h1>
                <p class="text-white-50 lead mb-4">
                    Factory-rebuilt ISX engines from US Engine Production. Every engine CNC-machined to exact tolerances, assembled with new OEM-spec components, and dyno-tested in our Lindenhurst, NY facility. Up to 60% less than new.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="<?= SITE_URL ?>/quote" class="btn btn-danger btn-lg px-4">
                        <i class="fas fa-file-invoice me-2"></i>Get Free Quote
                    </a>
                    <a href="tel:6319917700" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-phone me-2"></i>1-631-991-7700
                    </a>
                </div>
                <div class="d-flex flex-wrap gap-4 text-white-50 small">
                    <span><i class="fas fa-check-circle text-success me-1"></i> In-House Remanufacturing</span>
                    <span><i class="fas fa-check-circle text-success me-1"></i> Dyno Tested</span>
                    <span><i class="fas fa-check-circle text-success me-1"></i> Ships in 24-48 hrs</span>
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <div style="font-size: 8rem; opacity: 0.3; color: #e94560;">
                    <i class="fas fa-cogs"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trust Bar -->
<section class="bg-dark py-3 border-bottom border-secondary">
    <div class="container">
        <div class="row text-center text-white-50 small">
            <div class="col-6 col-md-3 py-2">
                <i class="fas fa-industry text-danger me-1"></i> Built In-House Since 1985
            </div>
            <div class="col-6 col-md-3 py-2">
                <i class="fas fa-database text-danger me-1"></i> 478,000+ Engines in Stock
            </div>
            <div class="col-6 col-md-3 py-2">
                <i class="fas fa-shipping-fast text-danger me-1"></i> Nationwide Shipping
            </div>
            <div class="col-6 col-md-3 py-2">
                <i class="fas fa-award text-danger me-1"></i> 100,000+ Engines Built
            </div>
        </div>
    </div>
</section>

<!-- Promotions Banner -->
<?php 
$topPromos = array_filter($promotions, function($p) { return $p["position"] === "homepage_top"; });
foreach ($topPromos as $promo): ?>
<section class="py-3" style="background: linear-gradient(90deg, #e94560, #c0392b);">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="text-white">
                <strong><i class="fas fa-tag me-2"></i><?= htmlspecialchars($promo["title"]) ?></strong>
                <span class="ms-2 d-none d-md-inline" style="opacity:0.9;"><?= htmlspecialchars($promo["content"]) ?></span>
            </div>
            <?php if ($promo["link_url"]): ?>
            <a href="<?= SITE_URL . $promo["link_url"] ?>" class="btn btn-light btn-sm mt-2 mt-md-0"><?= htmlspecialchars($promo["link_text"]) ?></a>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endforeach; ?>

<!-- Featured ISX Engines - Clickable Cards -->
<section class="py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Remanufactured ISX Engines For Sale</h2>
            <p class="text-muted lead">Click any engine below for full specifications, common problems, and pricing</p>
        </div>
        
        <div class="row g-4">
            <?php foreach ($allEngines as $eng): ?>
            <div class="col-md-6 col-lg-4">
                <a href="<?= SITE_URL ?>/engines/<?= $eng['slug'] ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 engine-card" style="transition: all 0.3s; cursor: pointer;">
                        <?php if ($eng['featured_image']): ?>
                            <img src="<?= SITE_URL . $eng['featured_image'] ?>" class="card-img-top" style="height:200px;object-fit:cover;" alt="<?= sanitize($eng['title']) ?> Remanufactured Engine">
                        <?php else: ?>
                            <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" style="height:200px;">
                                <i class="fas fa-cogs fa-4x text-danger" style="opacity:0.5;"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h3 class="h5 card-title text-dark mb-0"><?= sanitize($eng['title']) ?></h3>
                            </div>
                            <?php if (!empty($eng['price'])): ?>
                            <div class="mb-2">
                                <span class="fw-bold fs-5 text-success">$<?= number_format($eng['price'], 0) ?></span>
                                <span class="badge bg-success ms-1">In Stock</span>
                            </div>
                            <?php endif; ?>
                            <p class="text-muted small mb-2"><?= sanitize($eng['excerpt'] ?: substr(strip_tags($eng['content']), 0, 100)) ?>...</p>
                            <div class="mt-2 mb-3">
                                <?php if ($eng['years_produced']): ?><span class="badge bg-secondary me-1"><?= sanitize($eng['years_produced']) ?></span><?php endif; ?>
                                <?php if ($eng['ecm_code']): ?><span class="badge bg-danger"><?= sanitize($eng['ecm_code']) ?></span><?php endif; ?>
                                <?php if ($eng['horsepower']): ?><span class="badge bg-dark"><?= sanitize($eng['horsepower']) ?></span><?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pt-0">
                            <span class="btn btn-outline-danger btn-sm w-100">View Details & Order <i class="fas fa-arrow-right ms-1"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($allEngines)): ?>
        <div class="text-center text-muted py-5">
            <i class="fas fa-cogs fa-3x mb-3"></i>
            <p>Engine listings are being added. Call 1-631-991-7700 for immediate availability.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Engine Categories Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Browse by ISX Generation</h2>
            <p class="text-muted">Select an engine generation to explore detailed guides and available inventory</p>
        </div>
        <div class="row g-3">
            <?php 
            $icons = ['fas fa-wrench', 'fas fa-recycle', 'fas fa-filter', 'fas fa-microchip', 'fas fa-rocket', 'fas fa-truck', 'fas fa-leaf', 'fas fa-hard-hat'];
            foreach ($categories as $i => $cat): 
                $icon = $icons[$i % count($icons)];
                // Count engines in category
                $countStmt = $db->prepare("SELECT COUNT(*) FROM engines WHERE category_id = ? AND is_published = 1");
                $countStmt->execute([$cat['id']]);
                $count = $countStmt->fetchColumn();
            ?>
            <div class="col-6 col-md-4 col-lg-3">
                <a href="<?= SITE_URL ?>/engines/<?= $cat['slug'] ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center p-3 h-100" style="transition: all 0.3s;">
                        <div class="text-danger mb-2" style="font-size: 2rem;">
                            <i class="<?= $icon ?>"></i>
                        </div>
                        <h6 class="text-dark fw-bold mb-1"><?= sanitize($cat['name']) ?></h6>
                        <small class="text-muted"><?= $count ?> engine<?= $count != 1 ? 's' : '' ?></small>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-white">Why Buy Your ISX Engine From Us?</h2>
            <p class="text-white-50">US Engine Production is a precision remanufacturing facility, not a broker or middleman</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="text-center text-white p-3">
                    <div class="text-danger mb-3" style="font-size: 2.5rem;"><i class="fas fa-industry"></i></div>
                    <h5>In-House Remanufacturing</h5>
                    <p class="text-white-50 small">Every ISX engine is completely disassembled, CNC-machined, and rebuilt in our Lindenhurst, NY facility. Complete quality control from start to finish.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="text-center text-white p-3">
                    <div class="text-danger mb-3" style="font-size: 2.5rem;"><i class="fas fa-tachometer-alt"></i></div>
                    <h5>Dyno Tested</h5>
                    <p class="text-white-50 small">Every engine is mounted on our dynamometer test stand for comprehensive break-in testing: HP, torque, oil pressure, compression, fuel system, and electronics.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="text-center text-white p-3">
                    <div class="text-danger mb-3" style="font-size: 2.5rem;"><i class="fas fa-shield-alt"></i></div>
                    <h5>1-Year Unlimited Mileage Warranty</h5>
                    <p class="text-white-50 small">No mileage caps. No fine print. We stand behind every ISX engine we build with our industry-leading warranty.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="text-center text-white p-3">
                    <div class="text-danger mb-3" style="font-size: 2.5rem;"><i class="fas fa-dollar-sign"></i></div>
                    <h5>Up to 60% Less Than New</h5>
                    <p class="text-white-50 small">Same performance and reliability as a factory-fresh engine at a fraction of the cost. Smart choice for fleets and owner-operators.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="text-center text-white p-3">
                    <div class="text-danger mb-3" style="font-size: 2.5rem;"><i class="fas fa-shipping-fast"></i></div>
                    <h5>Ships in 24-48 Hours</h5>
                    <p class="text-white-50 small">Most in-stock ISX engines ship within 24-48 hours of order confirmation. Nationwide delivery to all 50 states.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="text-center text-white p-3">
                    <div class="text-danger mb-3" style="font-size: 2.5rem;"><i class="fas fa-history"></i></div>
                    <h5>Since 1985 - 100,000+ Engines Built</h5>
                    <p class="text-white-50 small">Over 38 years of diesel engine remanufacturing experience. Our certified technicians know ISX engines inside and out.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Blog Posts -->
<section class="py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">ISX Engine Technical Guides</h2>
            <p class="text-muted">Expert troubleshooting, maintenance tips, and ISX engine news</p>
        </div>
        <?php
        $posts = $db->query("SELECT * FROM blog_posts WHERE is_published = 1 ORDER BY created_at DESC LIMIT 3")->fetchAll();
        if (!empty($posts)): ?>
        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5><a href="<?= SITE_URL ?>/blog/<?= $post['slug'] ?>" class="text-decoration-none text-dark"><?= sanitize($post['title']) ?></a></h5>
                        <p class="text-muted small"><?= sanitize($post['excerpt'] ?: substr(strip_tags($post['content']), 0, 150)) ?>...</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="<?= SITE_URL ?>/blog/<?= $post['slug'] ?>" class="btn btn-sm btn-outline-danger">Read More</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center text-muted">
            <p>Technical guides coming soon. Check back for expert ISX engine articles.</p>
        </div>
        <?php endif; ?>
        <div class="text-center mt-4">
            <a href="<?= SITE_URL ?>/blog" class="btn btn-outline-dark">View All Articles <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-danger">
    <div class="container text-center">
        <h2 class="text-white fw-bold mb-3">Need a Remanufactured ISX Engine?</h2>
        <p class="text-white mb-4" style="opacity: 0.9;">Call us now or request a free quote. Our ISX specialists are ready to help.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="tel:6319917700" class="btn btn-light btn-lg px-4 fw-bold">
                <i class="fas fa-phone me-2"></i>1-631-991-7700
            </a>
            <a href="<?= SITE_URL ?>/quote" class="btn btn-outline-light btn-lg px-4">
                <i class="fas fa-envelope me-2"></i>Request Quote
            </a>
            <a href="mailto:sales@usepny.com" class="btn btn-outline-light btn-lg px-4">
                <i class="fas fa-at me-2"></i>sales@usepny.com
            </a>
        </div>
        <p class="text-white mt-3 small" style="opacity: 0.7;">
            <i class="fas fa-map-marker-alt me-1"></i> 200 Bangor St, Lindenhurst, NY 11757 | Mon-Fri 8am-6pm ET
        </p>
    </div>
</section>

<style>
.engine-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}
</style>

<?php include __DIR__ . '/footer.php'; ?>
