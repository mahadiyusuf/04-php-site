<?php
declare(strict_types=1);

require_once __DIR__ . '/functions.php';

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= e($tagline) ?>">
    <title><?= e($pageTitle) ?> | <?= e($siteName) ?></title>
    <script>
        (() => {
            try {
                const savedTheme = localStorage.getItem('site-theme');
                const theme = savedTheme === 'light' || savedTheme === 'dark'
                    ? savedTheme
                    : (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                document.documentElement.dataset.theme = theme;
            } catch {
                document.documentElement.dataset.theme = 'light';
            }
        })();
    </script>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/theme-toggle.js" defer></script>
</head>
<body>
    <header class="site-header">
        <div class="container header-content">
            <a class="brand" href="index.php">
                <span class="brand-name"><?= e($siteName) ?></span>
                <span class="brand-tagline"><?= e($tagline) ?></span>
            </a>
            <nav class="site-nav" aria-label="Main navigation">
                <?php foreach ($navItems as $label => $fileName): ?>
                    <?php $isCurrentPage = $currentPage === $fileName; ?>
                    <a
                        href="<?= e($fileName) ?>"
                        class="<?= $isCurrentPage ? 'active' : '' ?>"
                        <?= $isCurrentPage ? 'aria-current="page"' : '' ?>
                    ><?= e($label) ?></a>
                <?php endforeach; ?>
            </nav>
            <button class="theme-toggle" type="button" aria-pressed="false">
                <span class="theme-toggle-icon" aria-hidden="true">☾</span>
                <span class="theme-toggle-label">Dark mode</span>
            </button>
        </div>
    </header>
    <main>
