<?php
// Get categories for nav dropdown
$navCategories = $db->query("SELECT * FROM engine_categories WHERE is_active = 1 ORDER BY sort_order")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'ISX Engines - US Engine Production' ?></title>
    <meta name="description" content="<?= $pageDescription ?? 'Premium remanufactured Cummins ISX engines from US Engine Production. 1-year unlimited mileage warranty. Call 1-631-991-7700.' ?>">
    <link rel="canonical" href="<?= $pageCanonical ?? SITE_URL ?>">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= $pageTitle ?? 'ISX Engines' ?>">
    <meta property="og:description" content="<?= $pageDescription ?? '' ?>">
    <meta property="og:url" content="<?= $pageCanonical ?? SITE_URL ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="ISX Engines - US Engine Production">
    <?php if (!empty($pageImage)): ?>
    <meta property="og:image" content="<?= SITE_URL . $pageImage ?>">
    <?php endif; ?>
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $pageTitle ?? 'ISX Engines' ?>">
    <meta name="twitter:description" content="<?= $pageDescription ?? '' ?>">
    
    <!-- Geo Tags for Local SEO -->
    <meta name="geo.region" content="US-NY">
    <meta name="geo.placename" content="Lindenhurst">
    <meta name="geo.position" content="40.6868;-73.3734">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?= SITE_URL ?>/assets/css/style.css" rel="stylesheet">
    
    <?php if (!empty($schemaJson)): ?>
    <script type="application/ld+json"><?= $schemaJson ?></script>
    <?php endif; ?>
    
    <!-- Organization Schema on every page -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "AutoPartsStore",
        "name": "US Engine Production",
        "url": "<?= SITE_URL ?>",
        "telephone": "1-631-991-7700",
        "email": "sales@usepny.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "200 Bangor St",
            "addressLocality": "Lindenhurst",
            "addressRegion": "NY",
            "postalCode": "11757",
            "addressCountry": "US"
        },
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            "opens": "08:00",
            "closes": "18:00"
        }
    }
    </script>
</head>
<body>
    <!-- Top Bar -->
    <div class="bg-dark text-white py-1 d-none d-md-block" style="font-size: 0.85rem;">
        <div class="container d-flex justify-content-between align-items-center">
            <span><i class="fas fa-map-marker-alt text-danger me-1"></i> 200 Bangor St, Lindenhurst, NY 11757</span>
            <span>
                <a href="tel:6319917700" class="text-white text-decoration-none me-3"><i class="fas fa-phone text-danger me-1"></i> 1-631-991-7700</a>
                <a href="mailto:sales@usepny.com" class="text-white text-decoration-none"><i class="fas fa-envelope text-danger me-1"></i> sales@usepny.com</a>
            </span>
        </div>
    </div>
    
    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background: #1a1a2e;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= SITE_URL ?>">
                <i class="fas fa-cogs text-danger me-2"></i>ISX Engines
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= SITE_URL ?>">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="<?= SITE_URL ?>/engines" id="enginesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Engines
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="enginesDropdown">
                            <li><a class="dropdown-item" href="<?= SITE_URL ?>/engines"><i class="fas fa-th-list me-2 text-danger"></i>All ISX Engines</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php foreach ($navCategories as $nc): ?>
                            <li><a class="dropdown-item" href="<?= SITE_URL ?>/engines/<?= $nc['slug'] ?>"><?= sanitize($nc['name']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= SITE_URL ?>/blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= SITE_URL ?>/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= SITE_URL ?>/contact">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link btn btn-danger text-white px-3" href="<?= SITE_URL ?>/quote">Get Quote</a>
                    </li>
                </ul>
                <!-- Mobile Phone Link -->
                <div class="d-lg-none mt-3 text-center">
                    <a href="tel:6319917700" class="btn btn-outline-light w-100"><i class="fas fa-phone me-2"></i>1-631-991-7700</a>
                </div>
            </div>
        </div>
    </nav>
