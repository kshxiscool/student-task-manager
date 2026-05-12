<?php
// ============================================
// auth.php - Login & Register Page
// Handles both login and registration in one file
// ============================================
require_once 'includes/functions.php';
require_once 'includes/db.php';

redirectIfLoggedIn(); // Send to dashboard if already logged in

$activeTab = 'login'; // Which tab to show by default
$errors    = [];

// ============================================
// HANDLE REGISTRATION (POST)
// ============================================
if (isset($_POST['action']) && $_POST['action'] === 'register') {
    $activeTab = 'register';

    // Get and sanitize inputs
    $name     = clean($_POST['name']     ?? '');
    $email    = clean($_POST['email']    ?? '');
    $password =       $_POST['password'] ?? '';
    $confirm  =       $_POST['confirm']  ?? '';

    // ---- Server-side Validation ----
    if (strlen($name) < 2) {
        $errors[] = 'Name must be at least 2 characters.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    // Check if email is already taken
    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors[] = 'An account with this email already exists. Please login.';
            $activeTab = 'login';
        }
        mysqli_stmt_close($stmt);
    }

    // Insert new user if no errors
    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT); // Secure hashing

        $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $hashed);

        if (mysqli_stmt_execute($stmt)) {
            // Auto-login after registration
            $userId = mysqli_insert_id($conn);
            $_SESSION['user_id']   = $userId;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;

            setFlash('success', "Welcome, {$name}! Your account has been created.");
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = 'Registration failed. Please try again.';
        }
        mysqli_stmt_close($stmt);
    }
}

// ============================================
// HANDLE LOGIN (POST)
// ============================================
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $activeTab = 'login';

    $email    = clean($_POST['email']    ?? '');
    $password =       $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    // ---- Server-side Validation ----
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    // Check credentials if no errors
    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "SELECT id, name, email, password FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($user && password_verify($password, $user['password'])) {
            // ---- Login Successful ----
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_name']  = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            // Set remember-me cookie if checked
            if ($remember) {
                setRememberCookie($email);
            } else {
                clearRememberCookie();
            }

            setFlash('success', "Welcome back, {$user['name']}! 👋");
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = 'Invalid email or password. Please try again.';
        }
    }
}

// Prefill email from cookie
$rememberedEmail = getRememberedEmail();

$pageTitle = 'Login / Register';
include 'includes/header.php';
?>

<div class="auth-wrapper">
    <div class="container px-3">
        <div class="auth-card card mx-auto">

            <!-- Logo -->
            <div class="text-center mb-4">
                <a href="index.php" class="text-decoration-none">
                    <div class="d-inline-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-check2-square text-primary" style="font-size:2rem;"></i>
                        <span class="fw-800" style="font-size:1.5rem; color:var(--text-main);">TaskFlow</span>
                    </div>
                </a>
                <p class="text-muted small mb-0">Student Task Manager</p>
            </div>

            <!-- Flash / Error Alerts -->
            <?php showFlash(); ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?= implode('<br>', $errors) ?>
                </div>
            <?php endif; ?>

            <!-- Tabs -->
            <ul class="nav nav-tabs auth-tabs mb-4" id="authTabs">
                <li class="nav-item flex-fill text-center">
                    <button class="nav-link w-100 <?= $activeTab === 'login' ? 'active' : '' ?>"
                            data-bs-toggle="tab" data-bs-target="#loginTab">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </button>
                </li>
                <li class="nav-item flex-fill text-center">
                    <button class="nav-link w-100 <?= $activeTab === 'register' ? 'active' : '' ?>"
                            data-bs-toggle="tab" data-bs-target="#registerTab">
                        <i class="bi bi-person-plus me-1"></i>Register
                    </button>
                </li>
            </ul>

            <div class="tab-content">

                <!-- ---- LOGIN TAB ---- -->
                <div class="tab-pane fade <?= $activeTab === 'login' ? 'show active' : '' ?>" id="loginTab">
                    <form method="POST" id="loginForm" novalidate>
                        <input type="hidden" name="action" value="login">

                        <div class="mb-3">
                            <label class="form-label" for="loginEmail">Email Address</label>
                            <input type="email" class="form-control" id="loginEmail" name="email"
                                   placeholder="you@example.com"
                                   value="<?= $rememberedEmail ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="loginPassword">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="loginPassword" name="password"
                                       placeholder="Min. 6 characters" required>
                                <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePwd('loginPassword', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                       <?= $rememberedEmail ? 'checked' : '' ?>>
                                <label class="form-check-label small" for="remember">Remember me (7 days)</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-600">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login to TaskFlow
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted small mb-0">
                            Don't have an account?
                            <a href="#" class="text-primary fw-600" onclick="switchTab('register')">Register now</a>
                        </p>
                    </div>
                </div>

                <!-- ---- REGISTER TAB ---- -->
                <div class="tab-pane fade <?= $activeTab === 'register' ? 'show active' : '' ?>" id="registerTab">
                    <form method="POST" id="registerForm" novalidate>
                        <input type="hidden" name="action" value="register">

                        <div class="mb-3">
                            <label class="form-label" for="regName">Full Name</label>
                            <input type="text" class="form-control" id="regName" name="name"
                                   placeholder="Your full name"
                                   value="<?= isset($_POST['name']) && $activeTab === 'register' ? clean($_POST['name']) : '' ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="regEmail">Email Address</label>
                            <input type="email" class="form-control" id="regEmail" name="email"
                                   placeholder="you@example.com"
                                   value="<?= isset($_POST['email']) && $activeTab === 'register' ? clean($_POST['email']) : '' ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="regPassword">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="regPassword" name="password"
                                       placeholder="Min. 6 characters" required>
                                <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePwd('regPassword', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="regConfirm">Confirm Password</label>
                            <input type="password" class="form-control" id="regConfirm" name="confirm"
                                   placeholder="Repeat your password" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-600">
                            <i class="bi bi-person-plus me-2"></i>Create Account
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted small mb-0">
                            Already have an account?
                            <a href="#" class="text-primary fw-600" onclick="switchTab('login')">Login here</a>
                        </p>
                    </div>
                </div>

            </div><!-- /tab-content -->
        </div><!-- /auth-card -->
    </div>
</div>

<script>
// Switch tabs programmatically
function switchTab(tab) {
    document.querySelector('[data-bs-target="#' + tab + 'Tab"]').click();
}

// Password show/hide toggle
function togglePwd(inputId, btn) {
    var input = document.getElementById(inputId);
    var icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>

<?php include 'includes/footer.php'; ?>
