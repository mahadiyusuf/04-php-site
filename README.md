# Na Manzo Computer Center

A small, multi-page website for a fictional cleaning business, built as a PHP 8 learning project. It demonstrates reusable page includes, data-driven service and team content, server-side form validation, and local JSON Lines storage for contact enquiries.

> **Learning project:** The business details are used for this local project. The messages page uses a hard-coded password for local practice only and is not suitable for protecting real or sensitive data.

## Features

- Shared site configuration, header, navigation, and footer
- Light and dark themes with a persistent, accessible theme toggle
- Responsive home, about, services, and contact pages
- Services and team members rendered from PHP arrays
- Individual service detail pages with a friendly 404 for unknown slugs
- Contact form with server-side validation, sticky values, and CSRF protection
- Contact submissions stored as JSON Lines in `storage/messages.jsonl`
- Password-gated messages page with newest-first sorting and a submission count
- Escaped dynamic output to help prevent HTML/script injection

## Tech stack

- PHP 8 (strict types, sessions, and standard library)
- HTML5
- CSS3 with responsive layouts
- Apache through XAMPP
- JSON Lines for local contact form storage

## Run with XAMPP

1. Install and start **Apache** from the XAMPP Control Panel.
2. Put this project folder at:

   ```text
   C:\xampp\htdocs\swd\04-php-site
   ```

3. Open the site at:

   [http://localhost/swd/04-php-site/](http://localhost/swd/04-php-site/)

4. Open the contact form at `http://localhost/swd/04-php-site/contact.php`. A valid submission is saved under `storage/messages.jsonl`.
5. To view locally stored submissions, visit `http://localhost/swd/04-php-site/messages.php` and enter the learning password configured as `$messagesPagePassword` in `includes/config.php`.

The `storage` directory is created automatically when the first valid contact form is submitted. The included `storage/.htaccess` denies direct web access to its files when Apache's `.htaccess` rules are enabled.

## Project structure

```text
04-php-site/
├── about.php
├── contact.php
├── index.php
├── messages.php
├── README.md
├── service.php
├── services.php
├── assets/
│   └── css/
│       └── style.css
├── includes/
│   ├── config.php
│   ├── data.php
│   ├── footer.php
│   ├── functions.php
│   └── header.php
└── storage/
    ├── .htaccess
    └── messages.jsonl  (created on the first valid form submission)
```

## Local messages page: security note

The messages page is protected by a hard-coded password in `includes/config.php` so it is straightforward to practise sessions and a password form locally. This is **not production-grade authentication**: the password is stored in source code, there is no user management or rate limiting, and anyone with access to the project files can discover it. Do not deploy this setup or use it for real personal data. A real application should use securely stored password hashes, proper account/session controls, HTTPS, rate limiting, and appropriate storage and access protections.

## What I learned

Fill these in as you work through the project:

- **PHP includes and strict types:** [Write what you learned]
- **Arrays, loops, and reusable functions:** [Write what you learned]
- **Form validation and sticky values:** [Write what you learned]
- **CSRF tokens and PHP sessions:** [Write what you learned]
- **JSON Lines and file locking:** [Write what you learned]
- **Output escaping and safe HTML:** [Write what you learned]
