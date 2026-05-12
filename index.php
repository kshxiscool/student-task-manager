<?php
// ============================================
// index.php - Home Page
// ============================================
require_once 'includes/functions.php';
require_once 'includes/db.php';

$pageTitle = 'Home';
include 'includes/header.php';
?>

<!-- ============ HERO SECTION ============ -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center gy-5">

            <!-- Left: Text Content -->
            <div class="col-lg-6">
                <div class="hero-badge fade-in-up">
                    <i class="bi bi-lightning-charge-fill"></i>
                    Built for Students
                </div>

                <h1 class="hero-title fade-in-up delay-1">
                    Manage Tasks.<br>
                    <span class="highlight">Stay Focused.</span><br>
                    Achieve More.
                </h1>

                <p class="hero-sub fade-in-up delay-2">
                    TaskFlow is a smart student task manager that helps you organize assignments,
                    track deadlines, and stay on top of your academic life — all in one place.
                </p>

                <div class="d-flex gap-3 flex-wrap fade-in-up delay-3">
                    <?php if (isLoggedIn()): ?>
                        <a href="dashboard.php" class="btn btn-primary btn-lg rounded-pill px-4">
                            <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                        </a>
                    <?php else: ?>
                        <a href="auth.php" class="btn btn-primary btn-lg rounded-pill px-4">
                            <i class="bi bi-rocket-takeoff me-2"></i>Get Started Free
                        </a>
                        <a href="features.php" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                            <i class="bi bi-play-circle me-2"></i>Learn More
                        </a>
                    <?php endif; ?>
                </div>

                <div class="stats-bar fade-in-up delay-4">
                    <div class="stat-item">
                        <span class="stat-number">6+</span>
                        <span class="stat-label">Pages</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">CRUD</span>
                        <span class="stat-label">Full Operations</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Responsive</span>
                    </div>
                </div>
            </div>

            <!-- Right: Mockup Card -->
            <div class="col-lg-6 text-center fade-in-up delay-2">
                <div class="hero-card-mockup">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fw-700" style="font-size:0.95rem;">My Tasks Today</span>
                        <span class="badge bg-primary rounded-pill">3 pending</span>
                    </div>

                    <div class="mockup-task">
                        <span class="dot" style="background:#28c76f;"></span>
                        <span>Submit Math Assignment</span>
                        <span class="ms-auto text-muted" style="font-size:0.78rem;">Today</span>
                    </div>
                    <div class="mockup-task">
                        <span class="dot" style="background:#ff9f43;"></span>
                        <span>Study for Physics Exam</span>
                        <span class="ms-auto text-muted" style="font-size:0.78rem;">Tomorrow</span>
                    </div>
                    <div class="mockup-task">
                        <span class="dot" style="background:#4f6ef7;"></span>
                        <span>Web Project Capstone</span>
                        <span class="ms-auto text-muted" style="font-size:0.78rem;">This week</span>
                    </div>
                    <div class="mockup-task" style="opacity:0.5;">
                        <span class="dot" style="background:#6c757d;"></span>
                        <span><s>Read Chapter 5</s></span>
                        <span class="ms-auto" style="font-size:0.78rem; color:#28c76f;">✓ Done</span>
                    </div>

                    <div class="mt-3 pt-3 border-top d-flex gap-2">
                        <div class="flex-fill text-center p-2 rounded-3" style="background:rgba(79,110,247,0.08);">
                            <div class="fw-700 text-primary">4</div>
                            <div class="text-muted" style="font-size:0.75rem;">Total</div>
                        </div>
                        <div class="flex-fill text-center p-2 rounded-3" style="background:rgba(255,159,67,0.08);">
                            <div class="fw-700" style="color:#ff9f43;">3</div>
                            <div class="text-muted" style="font-size:0.75rem;">Pending</div>
                        </div>
                        <div class="flex-fill text-center p-2 rounded-3" style="background:rgba(40,199,111,0.08);">
                            <div class="fw-700" style="color:#28c76f;">1</div>
                            <div class="text-muted" style="font-size:0.75rem;">Done</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ HOW IT WORKS ============ -->
<section class="py-5 mt-4">
    <div class="container">
        <div class="text-center mb-5">
            <span class="hero-badge d-inline-flex mb-3">How It Works</span>
            <h2 class="section-title">Simple. Powerful. Organised.</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4 fade-in-up">
                <div class="card p-4 text-center h-100">
                    <div class="feature-icon-box icon-blue mx-auto">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <h5 class="fw-700 mt-2">1. Register &amp; Login</h5>
                    <p class="text-muted small">Create your account in seconds. Your data is private and secure with hashed passwords.</p>
                </div>
            </div>
            <div class="col-md-4 fade-in-up delay-1">
                <div class="card p-4 text-center h-100">
                    <div class="feature-icon-box icon-green mx-auto">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <h5 class="fw-700 mt-2">2. Add Your Tasks</h5>
                    <p class="text-muted small">Create tasks with a title, description, priority level, status, and due date.</p>
                </div>
            </div>
            <div class="col-md-4 fade-in-up delay-2">
                <div class="card p-4 text-center h-100">
                    <div class="feature-icon-box icon-purple mx-auto">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h5 class="fw-700 mt-2">3. Track &amp; Complete</h5>
                    <p class="text-muted small">Monitor your progress on the dashboard, edit tasks and mark them complete.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ TECH STACK SECTION ============ -->
<section class="py-5" style="background: var(--bg-card); border-top: 1px solid var(--border-color);">
    <div class="container">
        <div class="text-center mb-4">
            <h5 class="text-muted fw-600">Built With Technologies</h5>
        </div>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <?php
            $techs = [
                ['HTML5', 'bi-filetype-html', '#e34c26'],
                ['CSS3',  'bi-filetype-css',  '#264de4'],
                ['Bootstrap', 'bi-bootstrap', '#7952b3'],
                ['JavaScript', 'bi-filetype-js', '#f7df1e'],
                ['PHP',   'bi-filetype-php',  '#787cb5'],
                ['MySQL', 'bi-database',      '#4479a1'],
            ];
            foreach ($techs as $t): ?>
            <div class="d-flex align-items-center gap-2 px-4 py-2 rounded-pill border"
                 style="font-weight:600; font-size:0.9rem; border-color: var(--border-color);">
                <i class="bi <?= $t[1] ?>" style="color:<?= $t[2] ?>; font-size:1.2rem;"></i>
                <?= $t[0] ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ CTA SECTION ============ -->
<?php if (!isLoggedIn()): ?>
<section class="py-5">
    <div class="container">
        <div class="card p-5 text-center" style="background: linear-gradient(135deg, #4f6ef7, #764ba2); border: none;">
            <h2 class="fw-800 text-white mb-3">Ready to Get Organised?</h2>
            <p class="text-white mb-4" style="opacity:0.85;">Join students who are managing their tasks smarter with TaskFlow.</p>
            <a href="auth.php" class="btn btn-light btn-lg rounded-pill px-5 fw-700">
                <i class="bi bi-rocket-takeoff me-2"></i>Start Now — It's Free
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
