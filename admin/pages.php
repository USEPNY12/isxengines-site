<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$db = getDB();
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = generateSlug($_POST['slug'] ?? $title);
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $content = $_POST['content'] ?? '';
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    
    if (empty($title)) {
        $message = '<div class="alert alert-danger">Title is required.</div>';
    } else {
        if ($id > 0) {
            $stmt = $db->prepare("UPDATE pages SET title=?, slug=?, meta_title=?, meta_description=?, content=?, is_published=? WHERE id=?");
            $stmt->execute([$title, $slug, $meta_title, $meta_description, $content, $is_published, $id]);
            $message = '<div class="alert alert-success">Page updated!</div>';
        } else {
            $stmt = $db->prepare("INSERT INTO pages (title, slug, meta_title, meta_description, content, is_published) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $meta_title, $meta_description, $content, $is_published]);
            $id = $db->lastInsertId();
            $message = '<div class="alert alert-success">Page created!</div>';
        }
        $action = 'edit';
    }
}

if ($action === 'delete' && $id > 0) {
    $db->prepare("DELETE FROM pages WHERE id = ?")->execute([$id]);
    redirect(SITE_URL . ADMIN_PATH . '/pages.php?msg=deleted');
}

include __DIR__ . '/includes/header.php';
?>

<div class="container-fluid py-4">
<?php if ($action === 'list'): ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Pages</h1>
        <a href="?action=new" class="btn btn-primary"><i class="fas fa-plus"></i> New Page</a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Title</th><th>Slug</th><th>Status</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                    <?php
                    $pages = $db->query("SELECT * FROM pages ORDER BY title")->fetchAll();
                    foreach ($pages as $page): ?>
                        <tr>
                            <td><?= sanitize($page['title']) ?></td>
                            <td><code>/<?= sanitize($page['slug']) ?></code></td>
                            <td><?= $page['is_published'] ? '<span class="badge bg-success">Live</span>' : '<span class="badge bg-secondary">Draft</span>' ?></td>
                            <td>
                                <a href="?action=edit&id=<?= $page['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <a href="?action=delete&id=<?= $page['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php else:
    $page = ['title'=>'','slug'=>'','meta_title'=>'','meta_description'=>'','content'=>'','is_published'=>1];
    if ($id > 0) {
        $stmt = $db->prepare("SELECT * FROM pages WHERE id = ?");
        $stmt->execute([$id]);
        $page = $stmt->fetch() ?: $page;
    }
?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><?= $id > 0 ? 'Edit' : 'New' ?> Page</h1>
        <a href="pages.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    
    <?= $message ?>
    
    <form method="POST">
        <div class="row g-3">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Page Title</label>
                            <input type="text" name="title" class="form-control" value="<?= sanitize($page['title']) ?>" required oninput="generateSlugField(this.value)">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL Slug</label>
                            <input type="text" name="slug" id="slugField" class="form-control" value="<?= sanitize($page['slug']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Content</label>
                            <div id="editor"><?= $page['content'] ?></div>
                            <input type="hidden" name="content" id="contentField">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>Publish</strong></div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_published" class="form-check-input" id="publishCheck" <?= $page['is_published'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="publishCheck">Published</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Save Page</button>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>SEO</strong></div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label small">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control form-control-sm" value="<?= sanitize($page['meta_title']) ?>">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Meta Description</label>
                            <textarea name="meta_description" class="form-control form-control-sm" rows="3"><?= sanitize($page['meta_description']) ?></textarea>
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
            modules: { toolbar: [[{'header':[1,2,3,false]}],['bold','italic','underline'],['link','image'],[{'list':'ordered'},{'list':'bullet'}],['blockquote'],['clean']] }
        });
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('contentField').value = quill.root.innerHTML;
        });
    });
    function generateSlugField(title) {
        document.getElementById('slugField').value = title.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/-+/g,'-').replace(/^-|-$/g,'');
    }
    </script>
<?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
