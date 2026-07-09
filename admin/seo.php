<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$db = getDB();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'seo_') === 0) {
            $settingKey = substr($key, 4);
            $db->prepare("INSERT INTO seo_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?")->execute([$settingKey, $value, $value]);
        }
    }
    $message = '<div class="alert alert-success">SEO settings saved!</div>';
}

$settings = [];
$rows = $db->query("SELECT * FROM seo_settings")->fetchAll();
foreach ($rows as $r) $settings[$r['setting_key']] = $r['setting_value'];

include __DIR__ . '/includes/header.php';
?>

<div class="container-fluid py-4">
    <h1 class="h3 mb-4">SEO Settings</h1>
    <?= $message ?>
    
    <form method="POST">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><strong>Global SEO</strong></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Default Site Title</label>
                    <input type="text" name="seo_site_title" class="form-control" value="<?= sanitize($settings['site_title'] ?? '') ?>">
                    <small class="text-muted">Appears in browser tab and search results</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Default Meta Description</label>
                    <textarea name="seo_site_description" class="form-control" rows="3"><?= sanitize($settings['site_description'] ?? '') ?></textarea>
                    <small class="text-muted">160-320 characters recommended</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Google Search Console Verification</label>
                    <input type="text" name="seo_google_verification" class="form-control" value="<?= sanitize($settings['google_verification'] ?? '') ?>" placeholder="google-site-verification content value">
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><strong>Schema.org / Structured Data</strong></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Organization Name</label>
                        <input type="text" name="seo_schema_org_name" class="form-control" value="<?= sanitize($settings['schema_org_name'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Organization Type</label>
                        <select name="seo_schema_org_type" class="form-select">
                            <option value="Organization" <?= ($settings['schema_org_type'] ?? '') === 'Organization' ? 'selected' : '' ?>>Organization</option>
                            <option value="LocalBusiness" <?= ($settings['schema_org_type'] ?? '') === 'LocalBusiness' ? 'selected' : '' ?>>Local Business</option>
                            <option value="AutoPartsStore" <?= ($settings['schema_org_type'] ?? '') === 'AutoPartsStore' ? 'selected' : '' ?>>Auto Parts Store</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save SEO Settings</button>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
