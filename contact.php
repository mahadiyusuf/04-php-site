<?php
declare(strict_types=1);

session_start();

$pageTitle = 'Contact';
$errors = [];
$values = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'service' => '',
    'message' => '',
];

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data.php';

if (!isset($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    foreach ($values as $field => $defaultValue) {
        $postedValue = $_POST[$field] ?? $defaultValue;
        $values[$field] = is_string($postedValue) ? trim($postedValue) : '';
    }

    $postedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($postedToken) || !hash_equals($csrfToken, $postedToken)) {
        $errors['csrf_token'] = 'Your form session has expired. Please check your details and submit again.';
    }

    if ($values['name'] === '') {
        $errors['name'] = 'Please enter your name.';
    }

    if ($values['email'] === '') {
        $errors['email'] = 'Please enter your email address.';
    } elseif (filter_var($values['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if ($values['service'] === '') {
        $errors['service'] = 'Please choose a service.';
    } else {
        $serviceExists = false;
        foreach ($services as $serviceOption) {
            if ($serviceOption['slug'] === $values['service']) {
                $serviceExists = true;
                break;
            }
        }

        if (!$serviceExists) {
            $errors['service'] = 'Please choose one of the listed services.';
        }
    }

    if ($values['message'] === '') {
        $errors['message'] = 'Please enter a message.';
    } else {
        $messageLength = function_exists('mb_strlen')
            ? mb_strlen($values['message'], 'UTF-8')
            : preg_match_all('/./us', $values['message']);

        if ($messageLength === false) {
            $errors['message'] = 'Please enter a message using valid text.';
        } elseif ($messageLength < 10 || $messageLength > 1000) {
            $errors['message'] = 'Your message must be between 10 and 1000 characters.';
        }
    }

    if ($errors === []) {
        $storageDirectory = __DIR__ . '/storage';
        if (!is_dir($storageDirectory)
            && !mkdir($storageDirectory, 0755, true)
            && !is_dir($storageDirectory)
        ) {
            throw new RuntimeException('Unable to create the contact message storage directory.');
        }

        $submission = [
            'timestamp' => date(DATE_ATOM),
            'name' => $values['name'],
            'email' => $values['email'],
            'phone' => $values['phone'],
            'service' => $values['service'],
            'message' => $values['message'],
        ];
        $jsonLine = json_encode(
            $submission,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        ) . PHP_EOL;

        if (file_put_contents(
            $storageDirectory . '/messages.jsonl',
            $jsonLine,
            FILE_APPEND | LOCK_EX
        ) === false) {
            throw new RuntimeException('Unable to save the contact form submission.');
        }

        unset($_SESSION['csrf_token']);
        header('Location: contact.php?sent=1', true, 303);
        exit;
    }
}

$wasSent = ($_GET['sent'] ?? '') === '1';

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
            <a class="contact-email" href="mailto:<?= e($contactEmail) ?>"><?= e($contactEmail) ?></a>
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
        <div>
            <?php if ($wasSent): ?>
                <div class="form-alert form-alert-success" role="status">
                    Thanks for getting in touch. Your message has been received.
                </div>
            <?php endif; ?>
            <?php if (isset($errors['csrf_token'])): ?>
                <div class="form-alert form-alert-error" role="alert">
                    <?= e($errors['csrf_token']) ?>
                </div>
            <?php endif; ?>
            <form class="contact-form" method="post" action="contact.php" novalidate>
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

                <div class="form-field">
                    <label for="name">Name <span aria-hidden="true">*</span></label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        autocomplete="name"
                        value="<?= e($values['name']) ?>"
                        required
                        <?= isset($errors['name']) ? 'aria-invalid="true" aria-describedby="name-error"' : '' ?>
                    >
                    <?php if (isset($errors['name'])): ?>
                        <p class="field-error" id="name-error"><?= e($errors['name']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="email">Email address <span aria-hidden="true">*</span></label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        value="<?= e($values['email']) ?>"
                        required
                        <?= isset($errors['email']) ? 'aria-invalid="true" aria-describedby="email-error"' : '' ?>
                    >
                    <?php if (isset($errors['email'])): ?>
                        <p class="field-error" id="email-error"><?= e($errors['email']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="phone">Phone <span class="optional">(optional)</span></label>
                    <input
                        id="phone"
                        name="phone"
                        type="tel"
                        autocomplete="tel"
                        value="<?= e($values['phone']) ?>"
                    >
                </div>

                <div class="form-field">
                    <label for="service">Service <span aria-hidden="true">*</span></label>
                    <select
                        id="service"
                        name="service"
                        required
                        <?= isset($errors['service']) ? 'aria-invalid="true" aria-describedby="service-error"' : '' ?>
                    >
                        <option value="">Choose a service</option>
                        <?php foreach ($services as $serviceOption): ?>
                            <option
                                value="<?= e($serviceOption['slug']) ?>"
                                <?= $values['service'] === $serviceOption['slug'] ? 'selected' : '' ?>
                            ><?= e($serviceOption['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['service'])): ?>
                        <p class="field-error" id="service-error"><?= e($errors['service']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="message">Message <span aria-hidden="true">*</span></label>
                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        required
                        aria-describedby="<?= isset($errors['message']) ? 'message-help message-error' : 'message-help' ?>"
                        <?= isset($errors['message']) ? 'aria-invalid="true"' : '' ?>
                    ><?= e($values['message']) ?></textarea>
                    <p class="field-hint" id="message-help">Please write between 10 and 1000 characters.</p>
                    <?php if (isset($errors['message'])): ?>
                        <p class="field-error" id="message-error"><?= e($errors['message']) ?></p>
                    <?php endif; ?>
                </div>

                <button class="button" type="submit">Send message</button>
            </form>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
