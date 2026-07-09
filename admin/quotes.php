<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$db = getDB();

// Update status
if (isset($_POST['update_status'])) {
    $qid = intval($_POST['quote_id']);
    $status = $_POST['status'];
    $db->prepare("UPDATE quote_requests SET status = ? WHERE id = ?")->execute([$status, $qid]);
}

// Delete
if (isset($_GET['delete'])) {
    $db->prepare("DELETE FROM quote_requests WHERE id = ?")->execute([intval($_GET['delete'])]);
    redirect(SITE_URL . ADMIN_PATH . '/quotes.php');
}

include __DIR__ . '/includes/header.php';
?>

<div class="container-fluid py-4">
    <h1 class="h3 mb-4">Quote Requests</h1>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th class="d-none d-md-table-cell">Email</th>
                            <th>Engine</th>
                            <th>Status</th>
                            <th class="d-none d-md-table-cell">Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $quotes = $db->query("SELECT * FROM quote_requests ORDER BY created_at DESC")->fetchAll();
                    foreach ($quotes as $q): ?>
                        <tr>
                            <td>
                                <?= sanitize($q['name']) ?>
                                <br><small class="text-muted d-md-none"><?= sanitize($q['email']) ?></small>
                            </td>
                            <td class="d-none d-md-table-cell"><?= sanitize($q['email']) ?></td>
                            <td><?= sanitize($q['engine_model']) ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="quote_id" value="<?= $q['id'] ?>">
                                    <input type="hidden" name="update_status" value="1">
                                    <select name="status" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                                        <option value="new" <?= $q['status']==='new'?'selected':'' ?>>New</option>
                                        <option value="contacted" <?= $q['status']==='contacted'?'selected':'' ?>>Contacted</option>
                                        <option value="quoted" <?= $q['status']==='quoted'?'selected':'' ?>>Quoted</option>
                                        <option value="closed" <?= $q['status']==='closed'?'selected':'' ?>>Closed</option>
                                    </select>
                                </form>
                            </td>
                            <td class="d-none d-md-table-cell"><?= date('M j, Y', strtotime($q['created_at'])) ?></td>
                            <td>
                                <a href="?delete=<?= $q['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($quotes)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">No quote requests yet.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
