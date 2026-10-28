<?php
declare(strict_types=1);

$pageTitle = 'Services';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Our services</p>
        <h1>Cleaning that works around you.</h1>
        <p>Choose the kind of clean you need, and we’ll help you find a practical plan for your space.</p>
    </div>
</section>
<section class="section">
    <div class="container service-grid">
        <?php foreach ($services as $service): ?>
            <?= renderServiceCard($service) ?>
        <?php endforeach; ?>
    </div>
</section>
<section class="callout">
    <div class="container callout-content">
        <div>
            <p class="eyebrow">Not sure what you need?</p>
            <h2>We’ll help you find the right fit.</h2>
        </div>
        <a class="button button-light" href="contact.php">Ask us a question</a>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
