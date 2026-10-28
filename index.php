<?php
declare(strict_types=1);

$pageTitle = 'Home';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/header.php';
?>
<section class="hero">
    <div class="container hero-content">
        <p class="eyebrow">A cleaner space. A clearer mind.</p>
        <h1>Come home to clean.</h1>
        <p class="hero-copy">Reliable, thoughtful cleaning for the spaces where life happens. We take care of the details, so you can enjoy the fresh feeling.</p>
        <a class="button" href="services.php">Explore our services</a>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">The Prime Cleaners difference</p>
            <h2>More time for what matters</h2>
            <p>From a quick refresh to a thorough deep clean, our friendly team makes it easier to keep your home feeling its best.</p>
        </div>
        <div class="card-grid">
            <article class="card">
                <span class="card-number">01</span>
                <h3>Care in every corner</h3>
                <p>We work carefully and consistently, treating your home with the respect it deserves.</p>
            </article>
            <article class="card">
                <span class="card-number">02</span>
                <h3>A plan that fits you</h3>
                <p>Choose the service and schedule that suit your home, routine, and priorities.</p>
            </article>
            <article class="card">
                <span class="card-number">03</span>
                <h3>People you can trust</h3>
                <p>Our approachable team aims to make every visit easy, dependable, and stress-free.</p>
            </article>
        </div>
    </div>
</section>
<section class="callout">
    <div class="container callout-content">
        <div>
            <p class="eyebrow">Ready for a refresh?</p>
            <h2>Let’s make your space shine.</h2>
        </div>
        <a class="button button-light" href="contact.php">Get in touch</a>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
