<?php
/**
 * Dynamic XML Sitemap Generator
 */
require_once __DIR__ . '/includes/config.php';
$db = getDB();

header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= SITE_URL ?></loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?= SITE_URL ?>/engines</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc><?= SITE_URL ?>/blog</loc>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    
    <?php
    // Engine categories
    $cats = $db->query("SELECT slug, sort_order FROM engine_categories WHERE is_active = 1")->fetchAll();
    foreach ($cats as $cat): ?>
    <url>
        <loc><?= SITE_URL ?>/engines/<?= $cat['slug'] ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>
    
    <?php
    // Individual engines
    $engines = $db->query("SELECT slug, updated_at FROM engines WHERE is_published = 1")->fetchAll();
    foreach ($engines as $eng): ?>
    <url>
        <loc><?= SITE_URL ?>/engines/<?= $eng['slug'] ?></loc>
        <lastmod><?= date('Y-m-d', strtotime($eng['updated_at'])) ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>
    
    <?php
    // Blog posts
    $posts = $db->query("SELECT slug, updated_at FROM blog_posts WHERE is_published = 1")->fetchAll();
    foreach ($posts as $post): ?>
    <url>
        <loc><?= SITE_URL ?>/blog/<?= $post['slug'] ?></loc>
        <lastmod><?= date('Y-m-d', strtotime($post['updated_at'])) ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>
    
    <?php
    // Static pages
    $pages = $db->query("SELECT slug, updated_at FROM pages WHERE is_published = 1")->fetchAll();
    foreach ($pages as $p): ?>
    <url>
        <loc><?= SITE_URL ?>/<?= $p['slug'] ?></loc>
        <lastmod><?= date('Y-m-d', strtotime($p['updated_at'])) ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <?php endforeach; ?>
    
    <url>
        <loc><?= SITE_URL ?>/quote</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
</urlset>
