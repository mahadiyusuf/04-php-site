<?php
declare(strict_types=1);

session_start();

$pageTitle = 'Messages';
$errors = [];
$isAuthenticated = ($_SESSION['messages_authenticated'] ?? false) === true;

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data.php';

if (!isset($_SESSION['messages_csrf_token']) || !is_string($_SESSION['messages_csrf_token'])) {
    $_SESSION['messages_csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['messages_csrf_token'];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $postedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($postedToken) || !hash_equals($csrfToken, $postedToken)) {
        $errors[] = 'Your form session has expired. Please try again.';
    } elseif (($_POST['action'] ?? '') === 'logout') {
        unset($_SESSION['messages_authenticated']);
        header('Location: messages.php', true, 303);
        exit;
    } elseif (($_POST['action'] ?? '') === 'login') {
        $password = $_POST['password'] ?? '';
        if (!is_string($password) || !hash_equals($messagesPagePassword, $password)) {
            $errors[] = 'The password was not correct. Please try again.';
        } else {
            session_regenerate_id(true);
            $_SESSION['messages_authenticated'] = true;
            $_SESSION['messages_csrf_token'] = bin2hex(random_bytes(32));
            header('Location: messages.php', true, 303);
            exit;
        }
    } else {
        $errors[] = 'The form request was not recognized.';
    }

    $isAuthenticated = ($_SESSION['messages_authenticated'] ?? false) === true;
    $csrfToken = $_SESSION['messages_csrf_token'];
}

$messages = [];
$storageError = null;
$malformedLineCount = 0;

if ($isAuthenticated) {
    $messagesFile = __DIR__ . '/storage/messages.jsonl';

    if (is_file($messagesFile)) {
        if (!is_readable($messagesFile)) {
            $storageError = 'The messages file exists but cannot be read. Check the file permissions.';
        } else {
            $lines = file($messagesFile, FILE_IGNORE_NEW_LINES);
            if ($lines === false) {
                $storageError = 'The messages file could not be read.';
            } else {
                foreach ($lines as $line) {
                    if (trim($line) === '') {
                        continue;
                    }

                    try {
                        $record = json_decode($line, true, 512, JSON_THROW_ON_ERROR);
                    } catch (JsonException) {
                        $malformedLineCount++;
                        continue;
                    }

                    if (!is_array($record)
                        || !isset($record['timestamp'], $record['name'], $record['email'], $record['service'], $record['message'])
                    ) {
                        $malformedLineCount++;
                        continue;
                    }

                    $timestamp = is_string($record['timestamp']) ? strtotime($record['timestamp']) : false;
                    if ($timestamp === false) {
                        $malformedLineCount++;
                        continue;
                    }

                    $serviceTitle = is_string($record['service']) ? $record['service'] : '';
                    foreach ($services as $serviceOption) {
                        if ($serviceOption['slug'] === $record['service']) {
                            $serviceTitle = $serviceOption['title'];
                            break;
                        }
                    }

                    $messages[] = [
                        'timestamp' => $timestamp,
                        'name' => is_string($record['name']) ? $record['name'] : '',
                        'email' => is_string($record['email']) ? $record['email'] : '',
                        'phone' => isset($record['phone']) && is_string($record['phone']) ? $record['phone'] : '',
                        'service' => $serviceTitle,
                        'message' => is_string($record['message']) ? $record['message'] : '',
                    ];
                }

                usort(
                    $messages,
                    static fn (array $first, array $second): int => $second['timestamp'] <=> $first['timestamp']
                );
            }
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Private area</p>
        <h1>Contact messages</h1>
        <p>Review submissions received through the contact form.</p>
    </div>
</section>
<section class="section">
    <div class="container messages-container">
        <?php foreach ($errors as $error): ?>
            <div class="form-alert form-alert-error" role="alert"><?= e($error) ?></div>
        <?php endforeach; ?>

        <?php if (!$isAuthenticated): ?>
            <div class="messages-login">
                <h2>Sign in to view messages</h2>
                <form class="contact-form" method="post" action="messages.php">
                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                    <input type="hidden" name="action" value="login">
                    <div class="form-field">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required>
                    </div>
                    <button class="button" type="submit">View messages</button>
                </form>
            </div>
        <?php else: ?>
            <div class="messages-heading">
                <div>
                    <p class="eyebrow">Inbox</p>
                    <h2>Submissions <span class="count-badge"><?= count($messages) ?></span></h2>
                </div>
                <form method="post" action="messages.php">
                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                    <input type="hidden" name="action" value="logout">
                    <button class="button button-outline" type="submit">Sign out</button>
                </form>
            </div>

            <?php if ($storageError !== null): ?>
                <div class="form-alert form-alert-error" role="alert"><?= e($storageError) ?></div>
            <?php elseif ($malformedLineCount > 0): ?>
                <div class="form-alert form-alert-error" role="alert">
                    <?= e((string) $malformedLineCount) ?> message record(s) could not be read because their JSON data is invalid.
                </div>
            <?php endif; ?>

            <?php if ($messages === []): ?>
                <div class="empty-state">
                    <h3>No messages yet</h3>
                    <p>Contact form submissions will appear here.</p>
                </div>
            <?php elseif ($storageError === null): ?>
                <div class="messages-table-wrap">
                    <table class="messages-table">
                        <thead>
                            <tr>
                                <th scope="col">Received</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Service</th>
                                <th scope="col">Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message): ?>
                                <tr>
                                    <td><?= e(date('M j, Y g:i a', $message['timestamp'])) ?></td>
                                    <td><?= e($message['name']) ?></td>
                                    <td><a href="mailto:<?= e($message['email']) ?>"><?= e($message['email']) ?></a></td>
                                    <td><?= e($message['phone'] !== '' ? $message['phone'] : '—') ?></td>
                                    <td><?= e($message['service']) ?></td>
                                    <td class="message-cell"><?= e($message['message']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
