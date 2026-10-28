<?php
declare(strict_types=1);

$pageTitle = 'About';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">About us</p>
        <h1>A little more care in every clean.</h1>
        <p>We believe a clean, comfortable space can make everyday life feel that bit brighter.</p>
    </div>
</section>
<section class="section">
    <div class="container content-layout">
        <div>
            <p class="eyebrow">Our story</p>
            <h2>Friendly service. Thoughtful results.</h2>
        </div>
        <div class="prose">
            <p>Na Manzo Computer Center was created to make home cleaning feel personal, straightforward, and dependable. We listen to what matters to you, take care with the small details, and leave your space ready to enjoy.</p>
            <p>Every home is different. That is why we take time to understand your preferences and shape our cleaning around your needs, whether you are looking for regular help or a one-off reset.</p>
            <a class="text-link" href="contact.php">Tell us what you need <span aria-hidden="true">&rarr;</span></a>
        </div>
    </div>
</section>
<section class="values">
    <div class="container card-grid">
        <article class="card">
            <h3>Respect</h3>
            <p>Your home and your instructions come first. We aim to make every visit feel comfortable and considered.</p>
        </article>
        <article class="card">
            <h3>Reliability</h3>
            <p>Clear communication and dependable service help take one more thing off your to-do list.</p>
        </article>
        <article class="card">
            <h3>Quality</h3>
            <p>We take pride in the details and in leaving each space fresh, tidy, and ready for you.</p>
        </article>
    </div>
</section>
<section class="section team-section">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Meet the team</p>
            <h2>Good people, thoughtful service.</h2>
            <p>Get to know the people who make every Na Manzo Computer Center visit feel personal.</p>
        </div>
        <div class="card-grid">
            <?php foreach ($team as $member): ?>
                <article class="card team-card">
                    <h3><?= e($member['name']) ?></h3>
                    <p class="team-role"><?= e($member['role']) ?></p>
                    <p><?= e($member['bio']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
