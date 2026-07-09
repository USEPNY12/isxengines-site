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
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $content = $_POST['content'] ?? '';
    $excerpt = trim($_POST['excerpt'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $tags = trim($_POST['tags'] ?? '');
    $author_name = trim($_POST['author_name'] ?? 'ISX Engines Team');
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    $featured_image = trim($_POST['featured_image'] ?? '');
    
    // Handle image upload
    if (!empty($_FILES['image_upload']['name'])) {
        $file = $_FILES['image_upload'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        
        if (in_array($ext, $allowed) && $file['size'] <= MAX_UPLOAD_SIZE) {
            $newName = 'blog_' . time() . '_' . uniqid() . '.' . $ext;
            $destPath = UPLOAD_DIR . 'blog/' . $newName;
            if (move_uploaded_file($file['tmp_name'], $destPath)) {
                $featured_image = '/assets/uploads/blog/' . $newName;
                // Save to media library
                $db->prepare("INSERT INTO media (filename, original_name, file_path, file_size, mime_type, uploaded_by) VALUES (?, ?, ?, ?, ?, ?)")
                   ->execute([$newName, $file['name'], $featured_image, $file['size'], $file['type'], $_SESSION['admin_id']]);
            }
        }
    }
    
    if (empty($title)) {
        $message = '<div class="alert alert-danger">Title is required.</div>';
    } else {
        if ($id > 0) {
            // Update
            $stmt = $db->prepare("UPDATE blog_posts SET title=?, slug=?, meta_title=?, meta_description=?, content=?, excerpt=?, featured_image=?, author_name=?, category=?, tags=?, is_published=? WHERE id=?");
            $stmt->execute([$title, $slug, $meta_title, $meta_description, $content, $excerpt, $featured_image, $author_name, $category, $tags, $is_published, $id]);
            $message = '<div class="alert alert-success">Blog post updated successfully!</div>';
        } else {
            // Insert
            $stmt = $db->prepare("INSERT INTO blog_posts (title, slug, meta_title, meta_description, content, excerpt, featured_image, author_name, category, tags, is_published) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $meta_title, $meta_description, $content, $excerpt, $featured_image, $author_name, $category, $tags, $is_published]);
            $id = $db->lastInsertId();
            $message = '<div class="alert alert-success">Blog post created successfully!</div>';
        }
        $action = 'edit';
    }
}

// Handle delete
if ($action === 'delete' && $id > 0) {
    $db->prepare("DELETE FROM blog_posts WHERE id = ?")->execute([$id]);
    redirect(SITE_URL . ADMIN_PATH . '/blog.php?msg=deleted');
}

include __DIR__ . '/includes/header.php';
?>

<div class="container-fluid py-4">
<?php if ($action === 'list'): ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Blog Posts</h1>
        <a href="?action=new" class="btn btn-primary"><i class="fas fa-plus"></i> New Post</a>
    </div>
    
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-success">Post deleted successfully.</div>
    <?php endif; ?>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th class="d-none d-md-table-cell">Category</th>
                            <th>Status</th>
                            <th class="d-none d-md-table-cell">Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $posts = $db->query("SELECT * FROM blog_posts ORDER BY created_at DESC")->fetchAll();
                    foreach ($posts as $post): ?>
                        <tr>
                            <td><?= sanitize($post['title']) ?></td>
                            <td class="d-none d-md-table-cell"><?= sanitize($post['category']) ?></td>
                            <td>
                                <?php if ($post['is_published']): ?>
                                    <span class="badge bg-success">Published</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td class="d-none d-md-table-cell"><?= date('M j, Y', strtotime($post['created_at'])) ?></td>
                            <td>
                                <a href="?action=edit&id=<?= $post['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <a href="?action=delete&id=<?= $post['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this post?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($posts)): ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">No blog posts yet. <a href="?action=new">Create one!</a></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php else: // Edit/New form
    $post = ['title'=>'','slug'=>'','meta_title'=>'','meta_description'=>'','content'=>'','excerpt'=>'','featured_image'=>'','author_name'=>'ISX Engines Team','category'=>'','tags'=>'','is_published'=>0];
    if ($id > 0) {
        $stmt = $db->prepare("SELECT * FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        $post = $stmt->fetch() ?: $post;
    }
?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><?= $id > 0 ? 'Edit' : 'New' ?> Blog Post</h1>
        <a href="blog.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    
    <?= $message ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Title</label>
                            <input type="text" name="title" class="form-control" value="<?= sanitize($post['title']) ?>" required oninput="generateSlugField(this.value)">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL Slug</label>
                            <input type="text" name="slug" id="slugField" class="form-control" value="<?= sanitize($post['slug']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Content</label>
                            <div id="editor"><?= $post['content'] ?></div>
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
                            <input type="checkbox" name="is_published" class="form-check-input" id="publishCheck" <?= $post['is_published'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="publishCheck">Published</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Save Post</button>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>Featured Image</strong></div>
                    <div class="card-body">
                        <?php if ($post['featured_image']): ?>
                            <img src="<?= SITE_URL . $post['featured_image'] ?>" class="img-fluid rounded mb-2" style="max-height:150px;">
                        <?php endif; ?>
                        <input type="file" name="image_upload" class="form-control" accept="image/*">
                        <input type="hidden" name="featured_image" value="<?= sanitize($post['featured_image']) ?>">
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>SEO</strong></div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label small">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control form-control-sm" value="<?= sanitize($post['meta_title']) ?>" maxlength="70">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Meta Description</label>
                            <textarea name="meta_description" class="form-control form-control-sm" rows="3" maxlength="320"><?= sanitize($post['meta_description']) ?></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Excerpt</label>
                            <textarea name="excerpt" class="form-control form-control-sm" rows="2"><?= sanitize($post['excerpt']) ?></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>Details</strong></div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label small">Author Name</label>
                            <input type="text" name="author_name" class="form-control form-control-sm" value="<?= sanitize($post['author_name']) ?>">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Category</label>
                            <input type="text" name="category" class="form-control form-control-sm" value="<?= sanitize($post['category']) ?>">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Tags (comma separated)</label>
                            <input type="text" name="tags" class="form-control form-control-sm" value="<?= sanitize($post['tags']) ?>">
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
        
        // Sync content on form submit
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
