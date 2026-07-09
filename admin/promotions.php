<?php
require_once __DIR__ . '/../includes/config.php';
requireLogin();
$db = getDB();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create' || $action === 'update') {
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'link_url' => trim($_POST['link_url'] ?? ''),
            'link_text' => trim($_POST['link_text'] ?? 'Learn More'),
            'display_type' => $_POST['display_type'] ?? 'banner',
            'position' => $_POST['position'] ?? 'homepage_top',
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'starts_at' => $_POST['starts_at'] ?: null,
            'ends_at' => $_POST['ends_at'] ?: null,
            'sort_order' => intval($_POST['sort_order'] ?? 0)
        ];
        
        if ($action === 'create') {
            $stmt = $db->prepare("INSERT INTO promotions (title, content, link_url, link_text, display_type, position, is_active, starts_at, ends_at, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute(array_values($data));
        } else {
            $id = intval($_POST['id']);
            $stmt = $db->prepare("UPDATE promotions SET title=?, content=?, link_url=?, link_text=?, display_type=?, position=?, is_active=?, starts_at=?, ends_at=?, sort_order=? WHERE id=?");
            $stmt->execute([...array_values($data), $id]);
        }
        header('Location: promotions.php?success=1');
        exit;
    }
    
    if ($action === 'delete') {
        $id = intval($_POST['id']);
        $db->prepare("DELETE FROM promotions WHERE id = ?")->execute([$id]);
        header('Location: promotions.php?deleted=1');
        exit;
    }
    
    if ($action === 'toggle') {
        $id = intval($_POST['id']);
        $db->prepare("UPDATE promotions SET is_active = NOT is_active WHERE id = ?")->execute([$id]);
        header('Location: promotions.php');
        exit;
    }
}

$promotions = $db->query("SELECT * FROM promotions ORDER BY sort_order, created_at DESC")->fetchAll();
$editPromo = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM promotions WHERE id = ?");
    $stmt->execute([intval($_GET['edit'])]);
    $editPromo = $stmt->fetch();
}

include __DIR__ . '/includes/header.php';
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-bullhorn me-2"></i>Promotions Manager</h2>
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#promoModal"><i class="fas fa-plus me-1"></i>New Promotion</button>
    </div>
    
    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check me-2"></i>Promotion saved successfully.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Position</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($promotions as $promo): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($promo['title']) ?></strong></td>
                        <td><span class="badge bg-info"><?= $promo['display_type'] ?></span></td>
                        <td><span class="badge bg-secondary"><?= $promo['position'] ?></span></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="action" value="toggle">
                                <input type="hidden" name="id" value="<?= $promo['id'] ?>">
                                <button type="submit" class="btn btn-sm <?= $promo['is_active'] ? 'btn-success' : 'btn-outline-secondary' ?>">
                                    <?= $promo['is_active'] ? 'Active' : 'Inactive' ?>
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="?edit=<?= $promo['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form method="POST" class="d-inline" onsubmit="return confirm('Delete this promotion?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $promo['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($promotions)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No promotions yet. Create your first one!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Promotion Modal -->
<div class="modal fade" id="promoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="action" value="<?= $editPromo ? 'update' : 'create' ?>">
                <?php if ($editPromo): ?><input type="hidden" name="id" value="<?= $editPromo['id'] ?>"><?php endif; ?>
                <div class="modal-header">
                    <h5 class="modal-title"><?= $editPromo ? 'Edit' : 'New' ?> Promotion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editPromo['title'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control" rows="3"><?= htmlspecialchars($editPromo['content'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Link URL</label>
                            <input type="text" name="link_url" class="form-control" value="<?= htmlspecialchars($editPromo['link_url'] ?? '') ?>" placeholder="/quote">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Link Text</label>
                            <input type="text" name="link_text" class="form-control" value="<?= htmlspecialchars($editPromo['link_text'] ?? 'Learn More') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Display Type</label>
                            <select name="display_type" class="form-select">
                                <option value="banner" <?= ($editPromo['display_type'] ?? '') === 'banner' ? 'selected' : '' ?>>Banner</option>
                                <option value="popup" <?= ($editPromo['display_type'] ?? '') === 'popup' ? 'selected' : '' ?>>Popup</option>
                                <option value="sidebar" <?= ($editPromo['display_type'] ?? '') === 'sidebar' ? 'selected' : '' ?>>Sidebar</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Position</label>
                            <select name="position" class="form-select">
                                <option value="homepage_top" <?= ($editPromo['position'] ?? '') === 'homepage_top' ? 'selected' : '' ?>>Homepage Top</option>
                                <option value="homepage_bottom" <?= ($editPromo['position'] ?? '') === 'homepage_bottom' ? 'selected' : '' ?>>Homepage Bottom</option>
                                <option value="sidebar" <?= ($editPromo['position'] ?? '') === 'sidebar' ? 'selected' : '' ?>>Sidebar</option>
                                <option value="all_pages" <?= ($editPromo['position'] ?? '') === 'all_pages' ? 'selected' : '' ?>>All Pages</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="<?= $editPromo['sort_order'] ?? 0 ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="datetime-local" name="starts_at" class="form-control" value="<?= $editPromo['starts_at'] ?? '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="datetime-local" name="ends_at" class="form-control" value="<?= $editPromo['ends_at'] ?? '' ?>">
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="promoActive" <?= ($editPromo['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="promoActive">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Save Promotion</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if ($editPromo): ?>
<script>document.addEventListener('DOMContentLoaded', function() { new bootstrap.Modal(document.getElementById('promoModal')).show(); });</script>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
