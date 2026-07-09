<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$db = getDB();
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);
$message = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = generateSlug($_POST['slug'] ?? $title);
    $category_id = intval($_POST['category_id'] ?? 0);
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $h1_title = trim($_POST['h1_title'] ?? $title);
    $content = $_POST['content'] ?? '';
    $excerpt = trim($_POST['excerpt'] ?? '');
    $years_produced = trim($_POST['years_produced'] ?? '');
    $displacement = trim($_POST['displacement'] ?? '');
    $horsepower = trim($_POST['horsepower'] ?? '');
    $torque = trim($_POST['torque'] ?? '');
    $ecm_code = trim($_POST['ecm_code'] ?? '');
    $fuel_type = trim($_POST['fuel_type'] ?? 'Diesel');
    $bore_stroke = trim($_POST['bore_stroke'] ?? '');
    $configuration = trim($_POST['configuration'] ?? 'Inline 6-Cylinder');
    $emission_standard = trim($_POST['emission_standard'] ?? '');
    $key_features = trim($_POST['key_features'] ?? '');
    $common_problems = trim($_POST['common_problems'] ?? '');
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    $featured_image = trim($_POST['featured_image'] ?? '');
    
    // Handle image upload
    if (!empty($_FILES['image_upload']['name'])) {
        $file = $_FILES['image_upload'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        
        if (in_array($ext, $allowed) && $file['size'] <= MAX_UPLOAD_SIZE) {
            $newName = 'engine_' . time() . '_' . uniqid() . '.' . $ext;
            $destPath = UPLOAD_DIR . 'engines/' . $newName;
            if (move_uploaded_file($file['tmp_name'], $destPath)) {
                $featured_image = '/assets/uploads/engines/' . $newName;
                $db->prepare("INSERT INTO media (filename, original_name, file_path, file_size, mime_type, uploaded_by) VALUES (?, ?, ?, ?, ?, ?)")
                   ->execute([$newName, $file['name'], $featured_image, $file['size'], $file['type'], $_SESSION['admin_id']]);
            }
        }
    }
    
    if (empty($title)) {
        $message = '<div class="alert alert-danger">Title is required.</div>';
    } else {
        if ($id > 0) {
            $stmt = $db->prepare("UPDATE engines SET title=?, slug=?, category_id=?, meta_title=?, meta_description=?, h1_title=?, content=?, excerpt=?, featured_image=?, years_produced=?, displacement=?, horsepower=?, torque=?, ecm_code=?, fuel_type=?, bore_stroke=?, configuration=?, emission_standard=?, key_features=?, common_problems=?, is_published=? WHERE id=?");
            $stmt->execute([$title, $slug, $category_id ?: null, $meta_title, $meta_description, $h1_title, $content, $excerpt, $featured_image, $years_produced, $displacement, $horsepower, $torque, $ecm_code, $fuel_type, $bore_stroke, $configuration, $emission_standard, $key_features, $common_problems, $is_published, $id]);
            $message = '<div class="alert alert-success">Engine page updated!</div>';
        } else {
            $stmt = $db->prepare("INSERT INTO engines (title, slug, category_id, meta_title, meta_description, h1_title, content, excerpt, featured_image, years_produced, displacement, horsepower, torque, ecm_code, fuel_type, bore_stroke, configuration, emission_standard, key_features, common_problems, is_published) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $category_id ?: null, $meta_title, $meta_description, $h1_title, $content, $excerpt, $featured_image, $years_produced, $displacement, $horsepower, $torque, $ecm_code, $fuel_type, $bore_stroke, $configuration, $emission_standard, $key_features, $common_problems, $is_published]);
            $id = $db->lastInsertId();
            $message = '<div class="alert alert-success">Engine page created!</div>';
        }
        $action = 'edit';
    }
}

// Handle delete
if ($action === 'delete' && $id > 0) {
    $db->prepare("DELETE FROM engines WHERE id = ?")->execute([$id]);
    redirect(SITE_URL . ADMIN_PATH . '/engines.php?msg=deleted');
}

$categories = $db->query("SELECT * FROM engine_categories ORDER BY sort_order")->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<div class="container-fluid py-4">
<?php if ($action === 'list'): ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Engine Pages</h1>
        <a href="?action=new" class="btn btn-primary"><i class="fas fa-plus"></i> Add Engine</a>
    </div>
    
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success">Operation completed successfully.</div>
    <?php endif; ?>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Engine</th>
                            <th class="d-none d-md-table-cell">ECM</th>
                            <th class="d-none d-md-table-cell">Years</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $engines = $db->query("SELECT e.*, c.name as cat_name FROM engines e LEFT JOIN engine_categories c ON e.category_id = c.id ORDER BY e.sort_order, e.title")->fetchAll();
                    foreach ($engines as $eng): ?>
                        <tr>
                            <td>
                                <strong><?= sanitize($eng['title']) ?></strong>
                                <br><small class="text-muted"><?= sanitize($eng['cat_name'] ?? '') ?></small>
                            </td>
                            <td class="d-none d-md-table-cell"><?= sanitize($eng['ecm_code']) ?></td>
                            <td class="d-none d-md-table-cell"><?= sanitize($eng['years_produced']) ?></td>
                            <td>
                                <?= $eng['is_published'] ? '<span class="badge bg-success">Live</span>' : '<span class="badge bg-secondary">Draft</span>' ?>
                            </td>
                            <td>
                                <a href="?action=edit&id=<?= $eng['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <a href="?action=delete&id=<?= $eng['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($engines)): ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">No engine pages yet.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php else:
    $engine = ['title'=>'','slug'=>'','category_id'=>0,'meta_title'=>'','meta_description'=>'','h1_title'=>'','content'=>'','excerpt'=>'','featured_image'=>'','years_produced'=>'','displacement'=>'','horsepower'=>'','torque'=>'','ecm_code'=>'','fuel_type'=>'Diesel','bore_stroke'=>'','configuration'=>'Inline 6-Cylinder','emission_standard'=>'','key_features'=>'','common_problems'=>'','is_published'=>1];
    if ($id > 0) {
        $stmt = $db->prepare("SELECT * FROM engines WHERE id = ?");
        $stmt->execute([$id]);
        $engine = $stmt->fetch() ?: $engine;
    }
?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><?= $id > 0 ? 'Edit' : 'New' ?> Engine Page</h1>
        <a href="engines.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    
    <?= $message ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Engine Title</label>
                            <input type="text" name="title" class="form-control" value="<?= sanitize($engine['title']) ?>" required oninput="generateSlugField(this.value)">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">URL Slug</label>
                                <input type="text" name="slug" id="slugField" class="form-control" value="<?= sanitize($engine['slug']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">H1 Title</label>
                                <input type="text" name="h1_title" class="form-control" value="<?= sanitize($engine['h1_title']) ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Content</label>
                            <div id="editor"><?= $engine['content'] ?></div>
                            <input type="hidden" name="content" id="contentField">
                        </div>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>Technical Specifications</strong></div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-6 col-md-4">
                                <label class="form-label small">Years Produced</label>
                                <input type="text" name="years_produced" class="form-control form-control-sm" value="<?= sanitize($engine['years_produced']) ?>" placeholder="e.g. 2010-2020">
                            </div>
                            <div class="col-6 col-md-4">
                                <label class="form-label small">Displacement</label>
                                <input type="text" name="displacement" class="form-control form-control-sm" value="<?= sanitize($engine['displacement']) ?>" placeholder="e.g. 14.9L (912ci)">
                            </div>
                            <div class="col-6 col-md-4">
                                <label class="form-label small">ECM Code</label>
                                <input type="text" name="ecm_code" class="form-control form-control-sm" value="<?= sanitize($engine['ecm_code']) ?>" placeholder="e.g. CM2250">
                            </div>
                            <div class="col-6 col-md-4">
                                <label class="form-label small">Horsepower</label>
                                <input type="text" name="horsepower" class="form-control form-control-sm" value="<?= sanitize($engine['horsepower']) ?>" placeholder="e.g. 400-600 hp">
                            </div>
                            <div class="col-6 col-md-4">
                                <label class="form-label small">Torque</label>
                                <input type="text" name="torque" class="form-control form-control-sm" value="<?= sanitize($engine['torque']) ?>" placeholder="e.g. 1,450-2,050 lb-ft">
                            </div>
                            <div class="col-6 col-md-4">
                                <label class="form-label small">Bore x Stroke</label>
                                <input type="text" name="bore_stroke" class="form-control form-control-sm" value="<?= sanitize($engine['bore_stroke']) ?>" placeholder="e.g. 137mm x 169mm">
                            </div>
                            <div class="col-6 col-md-4">
                                <label class="form-label small">Fuel Type</label>
                                <select name="fuel_type" class="form-select form-select-sm">
                                    <option value="Diesel" <?= $engine['fuel_type'] === 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                                    <option value="Natural Gas" <?= $engine['fuel_type'] === 'Natural Gas' ? 'selected' : '' ?>>Natural Gas</option>
                                    <option value="Hydrogen" <?= $engine['fuel_type'] === 'Hydrogen' ? 'selected' : '' ?>>Hydrogen</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-4">
                                <label class="form-label small">Configuration</label>
                                <input type="text" name="configuration" class="form-control form-control-sm" value="<?= sanitize($engine['configuration']) ?>">
                            </div>
                            <div class="col-6 col-md-4">
                                <label class="form-label small">Emission Standard</label>
                                <input type="text" name="emission_standard" class="form-control form-control-sm" value="<?= sanitize($engine['emission_standard']) ?>" placeholder="e.g. EPA 2010">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>Key Features & Common Problems</strong></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small">Key Features (one per line)</label>
                            <textarea name="key_features" class="form-control form-control-sm" rows="4"><?= sanitize($engine['key_features']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Common Problems (one per line)</label>
                            <textarea name="common_problems" class="form-control form-control-sm" rows="4"><?= sanitize($engine['common_problems']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>Publish</strong></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small">Category</label>
                            <select name="category_id" class="form-select form-select-sm">
                                <option value="">-- Select --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= $engine['category_id'] == $cat['id'] ? 'selected' : '' ?>><?= sanitize($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_published" class="form-check-input" id="publishCheck" <?= $engine['is_published'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="publishCheck">Published</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Save Engine</button>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>Featured Image</strong></div>
                    <div class="card-body">
                        <?php if ($engine['featured_image']): ?>
                            <img src="<?= SITE_URL . $engine['featured_image'] ?>" class="img-fluid rounded mb-2" style="max-height:150px;">
                        <?php endif; ?>
                        <input type="file" name="image_upload" class="form-control" accept="image/*">
                        <input type="hidden" name="featured_image" value="<?= sanitize($engine['featured_image']) ?>">
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>SEO</strong></div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label small">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control form-control-sm" value="<?= sanitize($engine['meta_title']) ?>" maxlength="70">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Meta Description</label>
                            <textarea name="meta_description" class="form-control form-control-sm" rows="3" maxlength="320"><?= sanitize($engine['meta_description']) ?></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Excerpt</label>
                            <textarea name="excerpt" class="form-control form-control-sm" rows="2"><?= sanitize($engine['excerpt']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['blockquote', 'code-block'],
                    ['link', 'image'],
                    [{ 'align': [] }],
                    ['clean']
                ]
            }
        });
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('contentField').value = quill.root.innerHTML;
        });
    });
    function generateSlugField(title) {
        var slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
        document.getElementById('slugField').value = slug;
    }
    </script>
<?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
