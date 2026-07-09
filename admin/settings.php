<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$db = getDB();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'set_') === 0) {
            $settingKey = substr($key, 4);
            $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?")->execute([$settingKey, $value, $value]);
        }
    }
    $message = '<div class="alert alert-success">Settings saved!</div>';
}

$settings = [];
$rows = $db->query("SELECT * FROM site_settings")->fetchAll();
foreach ($rows as $r) $settings[$r['setting_key']] = $r['setting_value'];

include __DIR__ . '/includes/header.php';
?>

<div class="container-fluid py-4">
    <h1 class="h3 mb-4">Site Settings</h1>
    <?= $message ?>
    
    <form method="POST">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><strong>General</strong></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Site Name</label>
                        <input type="text" name="set_site_name" class="form-control" value="<?= sanitize($settings['site_name'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Site URL</label>
                        <input type="text" name="set_site_url" class="form-control" value="<?= sanitize($settings['site_url'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact Email</label>
                        <input type="email" name="set_contact_email" class="form-control" value="<?= sanitize($settings['contact_email'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="set_phone" class="form-control" value="<?= sanitize($settings['phone'] ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <input type="text" name="set_address" class="form-control" value="<?= sanitize($settings['address'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><strong>Social Media</strong></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Facebook URL</label>
                        <input type="url" name="set_facebook_url" class="form-control" value="<?= sanitize($settings['facebook_url'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Twitter/X URL</label>
                        <input type="url" name="set_twitter_url" class="form-control" value="<?= sanitize($settings['twitter_url'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">YouTube URL</label>
                        <input type="url" name="set_youtube_url" class="form-control" value="<?= sanitize($settings['youtube_url'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Settings</button>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
