<?php
// Handle static pages: about, contact, or dynamic pages from DB
if ($slug === 'about') {
    $pageTitle = 'About US Engine Production | ISX Engine Specialists Since 1985';
    $pageDescription = 'US Engine Production has been remanufacturing diesel engines since 1985. Learn about our state-of-the-art facility in Lindenhurst, NY and our 17-step ISX engine rebuilding process.';
    $pageCanonical = SITE_URL . '/about';
    include __DIR__ . '/header.php';
?>
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SITE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">About Us</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-4">About US Engine Production</h1>
                <p class="lead text-muted">America's most trusted source for premium remanufactured Cummins ISX engines since 1985.</p>
                
                <h2 class="h4 mt-4">Who We Are</h2>
                <p>US Engine Production is a precision diesel engine remanufacturing facility located in Lindenhurst, New York. Unlike engine brokers and resellers who simply mark up someone else's work, we build every engine in-house with complete quality control from disassembly through final dynamometer testing.</p>
                <p>Since 1985, we have remanufactured over 100,000 diesel engines for customers across all 50 states and internationally. Our team of certified diesel technicians specializes in Cummins ISX engines — from the original 1998 CM570 Signature series through the modern X15 platform.</p>
                
                <h2 class="h4 mt-4">Our 17-Step Remanufacturing Process</h2>
                <p>Every remanufactured ISX engine undergoes our comprehensive rebuilding process:</p>
                <ol>
                    <li>Complete disassembly to individual components</li>
                    <li>Ultrasonic cleaning of all parts</li>
                    <li>Magnaflux crack inspection</li>
                    <li>CNC precision boring and honing of block</li>
                    <li>Crankshaft grinding and polishing</li>
                    <li>Connecting rod reconditioning</li>
                    <li>Cylinder head rebuild (new valves, guides, seats)</li>
                    <li>All wear components replaced with new OEM-spec parts</li>
                    <li>New pistons, rings, bearings, gaskets, seals</li>
                    <li>New timing components</li>
                    <li>Camshaft inspection/replacement</li>
                    <li>Turbocharger rebuild or replacement</li>
                    <li>Fuel system service</li>
                    <li>Assembly with calibrated torque specs</li>
                    <li>Dynamometer break-in testing</li>
                    <li>Full performance verification (HP, torque, oil pressure, compression)</li>
                    <li>Paint, preserve, and prepare for shipping</li>
                </ol>
                
                <h2 class="h4 mt-4">Our Facility</h2>
                <p>Our state-of-the-art remanufacturing facility features the latest CNC machining equipment, computerized testing systems, and OEM service data. We use precision measurement tools and follow Cummins service specifications for every rebuild.</p>
                
                <h2 class="h4 mt-4">Our Warranty</h2>
                <p>Every remanufactured ISX engine comes with our industry-leading <strong>1-year unlimited mileage warranty</strong>. No mileage caps, no fine print. We stand behind our work because we know the quality that goes into every engine we build.</p>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-danger"><i class="fas fa-map-marker-alt me-2"></i>Visit Our Facility</h5>
                        <p class="mb-2"><strong>US Engine Production</strong></p>
                        <p class="text-muted mb-2">200 Bangor St<br>Lindenhurst, NY 11757</p>
                        <p class="mb-2"><a href="tel:6319917700" class="text-decoration-none"><i class="fas fa-phone text-danger me-1"></i> 1-631-991-7700</a></p>
                        <p class="mb-2"><a href="mailto:sales@usepny.com" class="text-decoration-none"><i class="fas fa-envelope text-danger me-1"></i> sales@usepny.com</a></p>
                        <p class="text-muted small mb-0"><i class="fas fa-clock text-danger me-1"></i> Mon-Fri 8am-6pm ET</p>
                        <hr>
                        <a href="<?= SITE_URL ?>/quote" class="btn btn-danger w-100"><i class="fas fa-file-invoice me-2"></i>Get a Free Quote</a>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold">By The Numbers</h5>
                        <div class="row g-2 mt-2">
                            <div class="col-6"><div class="p-2 bg-light rounded"><h4 class="text-danger mb-0">38+</h4><small class="text-muted">Years</small></div></div>
                            <div class="col-6"><div class="p-2 bg-light rounded"><h4 class="text-danger mb-0">100K+</h4><small class="text-muted">Engines Built</small></div></div>
                            <div class="col-6"><div class="p-2 bg-light rounded"><h4 class="text-danger mb-0">50</h4><small class="text-muted">States Served</small></div></div>
                            <div class="col-6"><div class="p-2 bg-light rounded"><h4 class="text-danger mb-0">1 Year</h4><small class="text-muted">Warranty</small></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/footer.php'; return; } ?>

<?php if ($slug === 'contact') {
    $pageTitle = 'Contact US Engine Production | ISX Engine Quotes & Support';
    $pageDescription = 'Contact US Engine Production for remanufactured ISX engine quotes. Call 1-631-991-7700, email sales@usepny.com, or visit us at 200 Bangor St, Lindenhurst, NY 11757.';
    $pageCanonical = SITE_URL . '/contact';
    include __DIR__ . '/header.php';
?>
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SITE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">Contact</li>
            </ol>
        </nav>
        <h1 class="fw-bold mb-4">Contact Us</h1>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-phone fa-3x text-danger mb-3"></i>
                        <h5>Call Us</h5>
                        <a href="tel:6319917700" class="h4 text-decoration-none text-dark">1-631-991-7700</a>
                        <p class="text-muted small mt-2">Mon-Fri 8am-6pm ET</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-envelope fa-3x text-danger mb-3"></i>
                        <h5>Email Us</h5>
                        <a href="mailto:sales@usepny.com" class="h5 text-decoration-none text-dark">sales@usepny.com</a>
                        <p class="text-muted small mt-2">We respond within 1 business hour</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-map-marker-alt fa-3x text-danger mb-3"></i>
                        <h5>Visit Us</h5>
                        <p class="text-dark">200 Bangor St<br>Lindenhurst, NY 11757</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 text-center">
            <a href="<?= SITE_URL ?>/quote" class="btn btn-danger btn-lg px-5"><i class="fas fa-file-invoice me-2"></i>Request a Free Quote</a>
        </div>
    </div>
</section>
<?php include __DIR__ . '/footer.php'; return; } ?>

<?php
// Dynamic pages from database
$stmt = $db->prepare("SELECT * FROM pages WHERE slug = ? AND is_published = 1");
$stmt->execute([$slug]);
$page = $stmt->fetch();

if (!$page) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    return;
}

$pageTitle = $page['meta_title'] ?: $page['title'] . ' | ISX Engines';
$pageDescription = $page['meta_description'] ?: substr(strip_tags($page['content']), 0, 160);
$pageCanonical = SITE_URL . '/' . $page['slug'];

include __DIR__ . '/header.php';
?>
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SITE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= sanitize($page['title']) ?></li>
            </ol>
        </nav>
        <h1 class="fw-bold mb-4"><?= sanitize($page['title']) ?></h1>
        <div class="content-body">
            <?= $page['content'] ?>
        </div>
    </div>
</section>
<?php include __DIR__ . '/footer.php'; ?>
