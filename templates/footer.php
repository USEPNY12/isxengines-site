    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3"><i class="fas fa-cogs text-danger me-2"></i>ISX Engines</h5>
                    <p class="text-white-50 small">A division of US Engine Production. America's most trusted source for premium remanufactured Cummins ISX engines since 1985. Every engine built in-house, dyno-tested, and backed by our 1-year unlimited mileage warranty.</p>
                    <div class="mt-3">
                        <a href="tel:6319917700" class="text-white text-decoration-none d-block mb-1"><i class="fas fa-phone text-danger me-2"></i>1-631-991-7700</a>
                        <a href="mailto:sales@usepny.com" class="text-white text-decoration-none d-block mb-1"><i class="fas fa-envelope text-danger me-2"></i>sales@usepny.com</a>
                        <span class="text-white-50 d-block"><i class="fas fa-map-marker-alt text-danger me-2"></i>200 Bangor St, Lindenhurst, NY 11757</span>
                        <span class="text-white-50 d-block mt-1"><i class="fas fa-clock text-danger me-2"></i>Mon-Fri 8am-6pm ET</span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">ISX Engine Models</h6>
                    <ul class="list-unstyled small">
                        <?php
                        $footerEngines = $db->query("SELECT title, slug FROM engines WHERE is_published = 1 ORDER BY sort_order LIMIT 10")->fetchAll();
                        foreach ($footerEngines as $fe): ?>
                        <li class="mb-1"><a href="<?= SITE_URL ?>/engines/<?= $fe['slug'] ?>" class="text-white-50 text-decoration-none"><?= sanitize($fe['title']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1"><a href="<?= SITE_URL ?>/engines" class="text-white-50 text-decoration-none">All Engines</a></li>
                        <li class="mb-1"><a href="<?= SITE_URL ?>/blog" class="text-white-50 text-decoration-none">Technical Blog</a></li>
                        <li class="mb-1"><a href="<?= SITE_URL ?>/quote" class="text-white-50 text-decoration-none">Get a Quote</a></li>
                        <li class="mb-1"><a href="<?= SITE_URL ?>/about" class="text-white-50 text-decoration-none">About Us</a></li>
                        <li class="mb-1"><a href="<?= SITE_URL ?>/contact" class="text-white-50 text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">We Serve</h6>
                    <ul class="list-unstyled small text-white-50">
                        <li class="mb-1"><i class="fas fa-truck text-danger me-1"></i> Over-the-Road Trucking</li>
                        <li class="mb-1"><i class="fas fa-bus text-danger me-1"></i> School Bus & Transit</li>
                        <li class="mb-1"><i class="fas fa-hard-hat text-danger me-1"></i> Construction & Industrial</li>
                        <li class="mb-1"><i class="fas fa-ship text-danger me-1"></i> Marine Applications</li>
                        <li class="mb-1"><i class="fas fa-bolt text-danger me-1"></i> Power Generation</li>
                        <li class="mb-1"><i class="fas fa-tractor text-danger me-1"></i> Agricultural Equipment</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="text-white-50 small mb-0">&copy; <?= date('Y') ?> US Engine Production. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="<?= SITE_URL ?>/about" class="text-white-50 text-decoration-none small me-3">About</a>
                    <a href="<?= SITE_URL ?>/contact" class="text-white-50 text-decoration-none small me-3">Contact</a>
                    <a href="<?= SITE_URL ?>/sitemap.xml" class="text-white-50 text-decoration-none small">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
