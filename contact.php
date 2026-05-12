<?php
// ============================================
// contact.php - Contact Page
// PHP form handling + MySQL storage of messages
// ============================================
require_once 'includes/functions.php';
require_once 'includes/db.php';

$errors  = [];
$success = false;

// ============================================
// HANDLE CONTACT FORM SUBMISSION (POST)
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {

    // Get and sanitize inputs
    $name    = clean($_POST['name']    ?? '');
    $email   = clean($_POST['email']   ?? '');
    $subject = clean($_POST['subject'] ?? '');
    $message = clean($_POST['message'] ?? '');

    // Server-side validation
    if (strlen($name) < 2) {
        $errors[] = 'Name must be at least 2 characters.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (strlen($message) < 10) {
        $errors[] = 'Message must be at least 10 characters.';
    }

    // Save to database if valid
    if (empty($errors)) {
        $stmt = mysqli_prepare($conn,
            "INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $subject, $message);

        if (mysqli_stmt_execute($stmt)) {
            $success = true;
            // Use PHP built-in function to store success in session
            setFlash('success', "Thanks {$name}! Your message has been received. We'll get back to you soon.");
            header("Location: contact.php");
            exit();
        } else {
            $errors[] = 'Could not send message. Please try again later.';
        }
        mysqli_stmt_close($stmt);
    }
}

$pageTitle = 'Contact';
include 'includes/header.php';
?>

<!-- Page Hero -->
<div class="page-hero fade-in-up">
    <div class="container">
        <span class="hero-badge d-inline-flex mb-3">Get In Touch</span>
        <h1 class="mb-3">Contact Us</h1>
        <p class="section-sub mx-auto">Have a question or feedback about TaskFlow? We'd love to hear from you.</p>
    </div>
</div>

<section class="py-5">
    <div class="container">

        <?php showFlash(); ?>

        <div class="row g-5">

            <!-- ---- Contact Form ---- -->
            <div class="col-lg-7 fade-in-up">
                <div class="card p-4 p-md-5">
                    <h4 class="fw-700 mb-4">
                        <i class="bi bi-send text-primary me-2"></i>Send Us a Message
                    </h4>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <?= implode('<br>', $errors) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" id="contactForm" novalidate>
                        <input type="hidden" name="send_message" value="1">

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="contactName">Your Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="contactName" name="name"
                                       placeholder="Full name"
                                       value="<?= isset($_POST['name']) ? clean($_POST['name']) : '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="contactEmail">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="contactEmail" name="email"
                                       placeholder="you@example.com"
                                       value="<?= isset($_POST['email']) ? clean($_POST['email']) : '' ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="contactSubject">Subject</label>
                            <input type="text" class="form-control" id="contactSubject" name="subject"
                                   placeholder="What is this about?"
                                   value="<?= isset($_POST['subject']) ? clean($_POST['subject']) : '' ?>">
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="contactMessage">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="contactMessage" name="message"
                                      rows="5"
                                      placeholder="Write your message here (min. 10 characters)..."
                                      required><?= isset($_POST['message']) ? clean($_POST['message']) : '' ?></textarea>
                        </div>

                        <!-- Real-time character counter (JavaScript DOM Manipulation) -->
                        <div class="text-end mb-4">
                            <small class="text-muted"><span id="charCount">0</span> / 500 characters</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-600">
                            <i class="bi bi-send me-2"></i>Send Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- ---- Contact Info ---- -->
            <div class="col-lg-5 fade-in-up delay-2">

                <div class="card contact-info-card mb-4">
                    <h5 class="fw-700 mb-4">Contact Information</h5>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="feature-icon-box icon-blue" style="width:44px;height:44px;font-size:1.1rem;flex-shrink:0;">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <div>
                                <div class="fw-700 small">Instructor</div>
                                <div class="text-muted small">Mir Junaid Rasool</div>
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-start">
                            <div class="feature-icon-box icon-green" style="width:44px;height:44px;font-size:1.1rem;flex-shrink:0;">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                            <div>
                                <div class="fw-700 small">Course</div>
                                <div class="text-muted small">Web Technologies — 23CSE404</div>
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-start">
                            <div class="feature-icon-box icon-orange" style="width:44px;height:44px;font-size:1.1rem;flex-shrink:0;">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <div class="fw-700 small">Email</div>
                                <div class="text-muted small">contact@taskflow.dev</div>
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-start">
                            <div class="feature-icon-box icon-purple" style="width:44px;height:44px;font-size:1.1rem;flex-shrink:0;">
                                <i class="bi bi-github"></i>
                            </div>
                            <div>
                                <div class="fw-700 small">GitHub</div>
                                <div class="text-muted small">github.com/yourusername/taskflow</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card p-4">
                    <h6 class="fw-700 mb-3">Quick Links</h6>
                    <div class="d-flex flex-column gap-2">
                        <a href="index.php" class="btn btn-outline-secondary text-start rounded-pill">
                            <i class="bi bi-house me-2"></i>Home Page
                        </a>
                        <a href="features.php" class="btn btn-outline-secondary text-start rounded-pill">
                            <i class="bi bi-stars me-2"></i>Features
                        </a>
                        <a href="about.php" class="btn btn-outline-secondary text-start rounded-pill">
                            <i class="bi bi-info-circle me-2"></i>About This Project
                        </a>
                        <?php if (!isLoggedIn()): ?>
                        <a href="auth.php" class="btn btn-primary text-start rounded-pill">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login / Register
                        </a>
                        <?php else: ?>
                        <a href="dashboard.php" class="btn btn-primary text-start rounded-pill">
                            <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
