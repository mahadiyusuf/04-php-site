<?php
declare(strict_types=1);

$slug = $_GET['slug'] ?? '';
$service = null;

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data.php';

if (is_string($slug)) {
    foreach ($services as $availableService) {
        if ($availableService['slug'] === $slug) {
            $service = $availableService;
            break;
        }
    }
}

if ($service === null) {
    http_response_code(404);
    $pageTitle = 'Service not found';
} else {
    $pageTitle = $service['title'];
}

require_once __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <?php if ($service === null): ?>
            <p class="eyebrow">404 - Service not found</p>
            <h1>We couldn’t find that service.</h1>
            <p>It may have moved or the link may be incorrect. Browse our services to find what you need.</p>
            <a class="button" href="services.php">Browse our services</a>
        <?php else: ?>
            <p class="eyebrow">Our services</p>
            <h1><?= e($service['title']) ?></h1>
            <p><?= e($service['description']) ?></p>
        <?php endif; ?>
    </div>
</section>
<?php if ($service !== null): ?>
    <section class="section">
        <div class="container service-detail">
            <span class="service-icon" aria-hidden="true"><?= e($service['icon']) ?></span>
            <div>
                <p class="eyebrow">Service details</p>
                <h2><?= e($service['title']) ?></h2>
                <p><?= e($service['description']) ?></p>
                <p class="service-price">From <?= e(formatPrice($service['price'])) ?></p>
                <a class="button" href="contact.php">Ask us about this service</a>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
