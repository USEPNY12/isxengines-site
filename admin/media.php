<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$db = getDB();
$message = '';

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES['media_files'])) {
    $files = $_FILES['media_files'];
    $uploaded = 0;
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
    
    for ($i = 0; $i < count($files['name']); $i++) {
        if ($files['error'][$i] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed) && $files['size'][$i] <= MAX_UPLOAD_SIZE) {
                $newName = time() . '_' . uniqid() . '.' . $ext;
                $destPath = UPLOAD_DIR . 'media/' . $newName;
                if (move_uploaded_file($files['tmp_name'][$i], $destPath)) {
                    $altText = trim($_POST['alt_text'] ?? pathinfo($files['name'][$i], PATHINFO_FILENAME));
                    // Get image dimensions
                    $imgInfo = @getimagesize($destPath);
                    $width = $imgInfo[0] ?? 0;
                    $height = $imgInfo[1] ?? 0;
                    
                    $db->prepare("INSERT INTO media (filename, original_name, file_path, file_size, mime_type, alt_text, width, height, uploaded_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")
                       ->execute([$newName, $files['name'][$i], '/assets/uploads/media/' . $newName, $files['size'][$i], $files['type'][$i], $altText, $width, $height, $_SESSION['admin_id']]);
                    $uploaded++;
                }
            }
        }
    }
    $message = "<div class='alert alert-success'>$uploaded file(s) uploaded successfully!</div>";
}

// Handle delete
if (isset($_GET['delete'])) {
    $mediaId = intval($_GET['delete']);
    $media = $db->prepare("SELECT * FROM media WHERE id = ?");
    $media->execute([$mediaId]);
    $item = $media->fetch();
    if ($item) {
        $filePath = '/var/www/isxengines' . $item['file_path'];
        if (file_exists($filePath)) unlink($filePath);
        $db->prepare("DELETE FROM media WHERE id = ?")->execute([$mediaId]);
        $message = '<div class="alert alert-success">File deleted.</div>';
    }
}

// Handle alt text update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_alt'])) {
    $mediaId = intval($_POST['media_id']);
    $altText = trim($_POST['alt_text_update']);
    $db->prepare("UPDATE media SET alt_text = ? WHERE id = ?")->execute([$altText, $mediaId]);
    $message = '<div class="alert alert-success">Alt text updated.</div>';
}

include __DIR__ . '/includes/header.php';
?>

<div class="container-fluid py-4">
    <h1 class="h3 mb-4">Media Library</h1>
    
    <?= $message ?>
    
    <!-- Upload Form -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Upload Images</label>
                    <input type="file" name="media_files[]" class="form-control" accept="image/*" multiple required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Alt Text (for SEO)</label>
                    <input type="text" name="alt_text" class="form-control" placeholder="Describe the image">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-upload"></i> Upload</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Media Grid -->
    <div class="row g-3">
        <?php
        $media = $db->query("SELECT * FROM media ORDER BY created_at DESC")->fetchAll();
        foreach ($media as $item): ?>
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card border-0 shadow-sm h-100">
                    <img src="<?= SITE_URL . $item['file_path'] ?>" class="card-img-top" style="height:120px;object-fit:cover;" alt="<?= sanitize($item['alt_text']) ?>">
                    <div class="card-body p-2">
                        <small class="text-muted d-block text-truncate"><?= sanitize($item['original_name']) ?></small>
                        <small class="text-muted"><?= round($item['file_size']/1024) ?>KB</small>
                        <div class="mt-1">
                            <button class="btn btn-xs btn-outline-secondary" onclick="copyPath('<?= $item['file_path'] ?>')" title="Copy path"><i class="fas fa-copy"></i></button>
                            <a href="?delete=<?= $item['id'] ?>" class="btn btn-xs btn-outline-danger" onclick="return confirm('Delete?')" title="Delete"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($media)): ?>
            <div class="col-12 text-center text-muted py-5">
                <i class="fas fa-images fa-3x mb-3"></i>
                <p>No media files yet. Upload some images above.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function copyPath(path) {
    navigator.clipboard.writeText(path).then(function() {
        alert('Path copied: ' + path);
    });
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
