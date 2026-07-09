<?php
$pageTitle = 'Get a Free Quote - Remanufactured ISX Engine | US Engine Production';
$pageDescription = 'Request a free quote on any remanufactured Cummins ISX engine. Call 1-631-991-7700 or fill out our form. Ships in 24-48 hours with 1-year unlimited mileage warranty.';
$pageCanonical = SITE_URL . '/quote';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $engine_model = trim($_POST['engine_model'] ?? '');
    $vin = trim($_POST['vin'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $truck_make = trim($_POST['truck_make'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (empty($name) || empty($phone)) {
        $error = 'Please provide at least your name and phone number.';
    } else {
        $stmt = $db->prepare("INSERT INTO quotes (name, email, phone, engine_model, vin_number, vehicle_year, vehicle_make, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'new')");
        $stmt->execute([$name, $email, $phone, $engine_model, $vin, $year, $truck_make, $message]);
        $success = true;
    }
}

// Get engines for dropdown
$quoteEngines = $db->query("SELECT title, ecm_code FROM engines WHERE is_published = 1 ORDER BY sort_order")->fetchAll();

include __DIR__ . '/header.php';
?>

<section class="py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= SITE_URL ?>">Home</a></li>
                        <li class="breadcrumb-item active">Get a Quote</li>
                    </ol>
                </nav>
                
                <h1 class="fw-bold mb-3">Get a Free ISX Engine Quote</h1>
                <p class="text-muted mb-4">Fill out the form below and our ISX specialists will get back to you within 1 business hour. Or call us directly at <a href="tel:6319917700" class="text-danger fw-bold">1-631-991-7700</a>.</p>
                
                <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i><strong>Quote Request Received!</strong> Our team will contact you within 1 business hour. For immediate assistance, call <a href="tel:6319917700">1-631-991-7700</a>.
                </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?= sanitize($error) ?></div>
                <?php endif; ?>
                
                <?php if (!$success): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form method="POST" action="<?= SITE_URL ?>/quote">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Full Name *</label>
                                    <input type="text" name="name" class="form-control" required placeholder="Your full name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Phone Number *</label>
                                    <input type="tel" name="phone" class="form-control" required placeholder="(555) 123-4567">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="your@email.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Engine Model Needed</label>
                                    <select name="engine_model" class="form-select">
                                        <option value="">-- Select Engine --</option>
                                        <?php foreach ($quoteEngines as $qe): ?>
                                        <option value="<?= sanitize($qe['title']) ?>"><?= sanitize($qe['title']) ?> <?= $qe['ecm_code'] ? '(' . sanitize($qe['ecm_code']) . ')' : '' ?></option>
                                        <?php endforeach; ?>
                                        <option value="Other ISX Model">Other ISX Model (specify below)</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">VIN Number</label>
                                    <input type="text" name="vin" class="form-control" placeholder="17-digit VIN">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Truck Year</label>
                                    <input type="text" name="year" class="form-control" placeholder="e.g. 2015">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Truck Make/Model</label>
                                    <input type="text" name="truck_make" class="form-control" placeholder="e.g. Kenworth T680">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Additional Details</label>
                                    <textarea name="message" class="form-control" rows="4" placeholder="Tell us about your needs: HP rating, configuration, any specific requirements..."></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger btn-lg w-100">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Quote Request
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Trust Signals -->
                <div class="row g-3 mt-4 text-center">
                    <div class="col-4">
                        <div class="p-3 bg-white rounded shadow-sm">
                            <i class="fas fa-shield-alt text-danger fa-2x mb-2"></i>
                            <p class="small mb-0 fw-bold">1-Year Warranty</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-white rounded shadow-sm">
                            <i class="fas fa-shipping-fast text-danger fa-2x mb-2"></i>
                            <p class="small mb-0 fw-bold">24-48hr Shipping</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-white rounded shadow-sm">
                            <i class="fas fa-dollar-sign text-danger fa-2x mb-2"></i>
                            <p class="small mb-0 fw-bold">60% Less Than New</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
