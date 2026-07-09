<?php
$stmt = $db->prepare("SELECT * FROM blog_posts WHERE slug = ? AND is_published = 1");
$stmt->execute([$slug]);
$post = $stmt->fetch();

if (!$post) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    return;
}

// Increment views
$db->prepare("UPDATE blog_posts SET views = views + 1 WHERE id = ?")->execute([$post['id']]);

$pageTitle = $post['meta_title'] ?: $post['title'] . ' | ISX Engines Blog';
$pageDescription = $post['meta_description'] ?: $post['excerpt'] ?: substr(strip_tags($post['content']), 0, 160);
$pageCanonical = SITE_URL . '/blog/' . $post['slug'];
$pageImage = $post['featured_image'];

// Article Schema
$schemaJson = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    'headline' => $post['title'],
    'description' => $pageDescription,
    'url' => $pageCanonical,
    'datePublished' => $post['created_at'],
    'dateModified' => $post['updated_at'],
    'author' => ['@type' => 'Person', 'name' => $post['author_name']],
    'publisher' => ['@type' => 'Organization', 'name' => 'ISX Engines'],
    'mainEntityOfPage' => $pageCanonical,
    'image' => $post['featured_image'] ? SITE_URL . $post['featured_image'] : ''
]);

include __DIR__ . '/header.php';
?>

    <article class="container py-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SITE_URL ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/blog">Blog</a></li>
                <li class="breadcrumb-item active"><?= sanitize($post['title']) ?></li>
            </ol>
        </nav>
        
        <div class="row">
            <div class="col-lg-8">
                <h1 class="mb-3"><?= sanitize($post['title']) ?></h1>
                <div class="text-muted mb-4">
                    <i class="fas fa-user"></i> <?= sanitize($post['author_name']) ?> | 
                    <i class="fas fa-calendar"></i> <?= date('F j, Y', strtotime($post['created_at'])) ?>
                    <?php if ($post['category']): ?> | <span class="badge bg-danger"><?= sanitize($post['category']) ?></span><?php endif; ?>
                </div>
                
                <?php if ($post['featured_image']): ?>
                    <img src="<?= SITE_URL . $post['featured_image'] ?>" class="img-fluid rounded mb-4 w-100" style="max-height:400px;object-fit:cover;" alt="<?= sanitize($post['title']) ?>">
                <?php endif; ?>
                
                <div class="blog-content">
                    <?= $post['content'] ?>
                </div>
                
                <?php if ($post['tags']): ?>
                <div class="mt-4">
                    <strong>Tags:</strong>
                    <?php foreach (explode(',', $post['tags']) as $tag): ?>
                        <span class="badge bg-light text-dark me-1"><?= sanitize(trim($tag)) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="col-lg-4">
                <!-- Related Posts -->
                <?php
                $related = $db->prepare("SELECT title, slug, created_at FROM blog_posts WHERE id != ? AND is_published = 1 ORDER BY created_at DESC LIMIT 5");
                $related->execute([$post['id']]);
                $relatedPosts = $related->fetchAll();
                ?>
                <div class="card border-0 shadow-sm sticky-top" style="top:80px;">
                    <div class="card-header bg-white"><strong>More Articles</strong></div>
                    <div class="list-group list-group-flush">
                        <?php foreach ($relatedPosts as $rp): ?>
                            <a href="<?= SITE_URL ?>/blog/<?= $rp['slug'] ?>" class="list-group-item list-group-item-action">
                                <?= sanitize($rp['title']) ?>
                                <br><small class="text-muted"><?= date('M j, Y', strtotime($rp['created_at'])) ?></small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </article>

<?php include __DIR__ . '/footer.php'; ?>
