<?php
$pageTitle = 'Contact';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Contact us</p>
        <h1>Let’s talk about your space.</h1>
        <p>Tell us what you are looking for and we’ll be happy to help you explore the options.</p>
    </div>
</section>
<section class="section">
    <div class="container contact-layout">
        <div>
            <p class="eyebrow">Get in touch</p>
            <h2>We’re just an email away.</h2>
            <p>For a quote or more information about our cleaning services, send us a message. We’ll get back to you as soon as we can.</p>
            <a class="contact-email" href="mailto:<?= htmlspecialchars($contactEmail, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($contactEmail, ENT_QUOTES, 'UTF-8') ?></a>
        </div>
        <aside class="contact-note">
            <h3>Helpful details to include</h3>
            <ul>
                <li>The type of cleaning you’re interested in</li>
                <li>The size or type of your property</li>
                <li>Any preferred dates or schedule</li>
                <li>Anything specific you’d like us to know</li>
            </ul>
        </aside>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
