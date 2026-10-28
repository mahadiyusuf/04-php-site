<?php
$pageTitle = 'Services';
require_once __DIR__ . '/includes/config.php';
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
    <div class="container card-grid">
        <article class="card service-card">
            <span class="card-number">01</span>
            <h2>Regular home cleaning</h2>
            <p>Keep on top of everyday cleaning with a recurring visit that suits your schedule.</p>
            <ul>
                <li>Kitchen and bathroom surfaces</li>
                <li>Dusting and general tidying</li>
                <li>Vacuuming and floor care</li>
            </ul>
        </article>
        <article class="card service-card">
            <span class="card-number">02</span>
            <h2>Deep cleaning</h2>
            <p>Give your home a more detailed refresh, with extra attention to those often-missed spots.</p>
            <ul>
                <li>Detailed clean of key areas</li>
                <li>Extra attention to buildup</li>
                <li>A one-off or seasonal reset</li>
            </ul>
        </article>
        <article class="card service-card">
            <span class="card-number">03</span>
            <h2>Move-in / move-out</h2>
            <p>Make moving day a little simpler with a thorough clean before you arrive or after you leave.</p>
            <ul>
                <li>Room-by-room cleaning</li>
                <li>Kitchen and bathroom focus</li>
                <li>Planned around your move</li>
            </ul>
        </article>
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
