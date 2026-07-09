<?php
/**
 * ISX Engines - Main Router
 * SEO-optimized public frontend
 */
require_once __DIR__ . '/includes/config.php';

$route = $_GET['route'] ?? 'home';
$slug = $_GET['slug'] ?? '';

$db = getDB();

// Get site settings
$siteSettings = [];
$rows = $db->query("SELECT * FROM site_settings")->fetchAll();
foreach ($rows as $r) $siteSettings[$r['setting_key']] = $r['setting_value'];

$seoSettings = [];
$rows = $db->query("SELECT * FROM seo_settings")->fetchAll();
foreach ($rows as $r) $seoSettings[$r['setting_key']] = $r['setting_value'];

// Route handling
switch ($route) {
    case 'home':
        include __DIR__ . '/templates/home.php';
        break;
        
    case 'engines':
        include __DIR__ . '/templates/engines-list.php';
        break;
        
    case 'engine':
        // First check if slug matches a category
        $catCheck = $db->prepare("SELECT id FROM engine_categories WHERE slug = ?");
        $catCheck->execute([$slug]);
        if ($catCheck->fetch()) {
            // It's a category slug - show engines list filtered by category
            include __DIR__ . '/templates/engines-list.php';
        } else {
            // It's an individual engine slug
            include __DIR__ . '/templates/engine-single.php';
        }
        break;
        
    case 'blog':
        include __DIR__ . '/templates/blog-list.php';
        break;
        
    case 'blog-post':
        include __DIR__ . '/templates/blog-single.php';
        break;
        
    case 'page':
        include __DIR__ . '/templates/page.php';
        break;
        
    case 'quote':
        include __DIR__ . '/templates/quote.php';
        break;
        
    default:
        http_response_code(404);
        include __DIR__ . '/templates/404.php';
        break;
}
