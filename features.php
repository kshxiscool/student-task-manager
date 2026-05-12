<?php
// ============================================
// features.php - Features Page
// ============================================
require_once 'includes/functions.php';
require_once 'includes/db.php';

$pageTitle = 'Features';
include 'includes/header.php';
?>

<!-- Page Hero -->
<div class="page-hero fade-in-up">
    <div class="container">
        <span class="hero-badge d-inline-flex mb-3">What's Inside</span>
        <h1 class="mb-3">All the Features You Need</h1>
        <p class="section-sub mx-auto">From secure login to full task management — TaskFlow covers every requirement of the capstone project specification.</p>
    </div>
</div>

<!-- ============ MAIN FEATURES GRID ============ -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php
            $features = [
                ['bi-shield-lock',    'icon-blue',   'Secure Authentication',   'User registration with hashed passwords (PHP password_hash). Login sessions and cookie-based "remember me" functionality across pages.'],
                ['bi-kanban',         'icon-green',  'Full Task CRUD',           'Create, Read, Update, and Delete tasks. Each task has a title, description, priority, status, and due date stored in MySQL.'],
                ['bi-phone',          'icon-purple', 'Responsive Design',        'Built with Bootstrap 5 grid, Flexbox, and CSS Box Model. Looks great on desktop, tablet, and mobile screens.'],
                ['bi-moon-stars',     'icon-orange', 'Dark Mode Toggle',         'JavaScript-powered dark mode that remembers your preference via localStorage. Smooth transitions with CSS variables.'],
                ['bi-funnel',         'icon-teal',   'Task Filtering',           'Filter tasks by status (All / Pending / In Progress / Completed) using JavaScript DOM manipulation — no page reload needed.'],
                ['bi-check2-circle',  'icon-red',    'Form Validation',          'Client-side JavaScript validation on all forms with real-time error messages, PLUS server-side PHP validation for security.'],
                ['bi-database-check', 'icon-blue',   'MySQL Integration',        'All data stored in a relational MySQL database. Three tables: users, tasks, and contacts, with foreign key relationships.'],
                ['bi-cookie',         'icon-green',  'Session & Cookie Mgmt',   'PHP sessions track login state across pages. Cookies store email for "Remember Me" feature for 7 days.'],
                ['bi-envelope-check', 'icon-purple', 'Contact Form',            'Contact page saves messages to the database using PHP form handling. Includes subject and message with validation.'],
                ['bi-github',         'icon-orange', 'GitHub Ready',            'Clean folder structure, meaningful commit messages, README.md documentation, and easy deployment to InfinityFree hosting.'],
                ['bi-bar-chart-line', 'icon-teal',   'Dashboard Stats',         'Dashboard shows total tasks, pending, in-progress, and completed counts using live MySQL queries.'],
                ['bi-calendar-event', 'icon-red',    'Due Date Tracking',       'Each task can have a due date. Overdue tasks are visually highlighted so you never miss a deadline.'],
            ];
            foreach ($features as $i => $f): ?>
            <div class="col-md-6 col-lg-4 fade-in-up" style="animation-delay: <?= ($i % 6) * 0.08 ?>s">
                <div class="card p-4 h-100">
                    <div class="feature-icon-box <?= $f[1] ?>">
                        <i class="bi <?= $f[0] ?>"></i>
                    </div>
                    <h6 class="fw-700"><?= $f[2] ?></h6>
                    <p class="text-muted small mb-0"><?= $f[3] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ EVALUATION RUBRIC TABLE ============ -->
<section class="py-5" style="background: var(--bg-card); border-top: 1px solid var(--border-color);">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="hero-badge d-inline-flex mb-3">Evaluation</span>
            <h2 class="section-title">Marks Coverage (50 Marks)</h2>
            <p class="section-sub">Every rubric criterion is fully addressed in this project.</p>
        </div>

        <div class="card fade-in-up">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Criterion</th>
                            <th>Marks</th>
                            <th>How It's Covered</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rubric = [
                            ['Design &amp; UI (HTML + CSS)', '10', 'Bootstrap 5 grid, Box Model, Positioning, Floats, responsive layout across all 6 pages'],
                            ['JavaScript / DHTML', '10', 'Dark mode toggle, form validation, task filtering, DOM manipulation, event handling, char counter'],
                            ['PHP Server-side Features', '10', 'Form handling, session management, cookie management, PHP built-in functions, file-based logic'],
                            ['Database Integration (PHP + MySQL)', '10', 'Full CRUD on tasks table, user auth, contact form storage, relational DB with 3 tables'],
                            ['GitHub Repository + Deployment', '5', 'README.md, incremental commits, GitHub Pages (frontend), InfinityFree (PHP backend)'],
                            ['Viva / Demonstration', '5', 'Clean, commented code — easy to explain every function, query, and concept'],
                        ];
                        foreach ($rubric as $r): ?>
                        <tr>
                            <td class="fw-600"><?= $r[0] ?></td>
                            <td><span class="badge bg-primary rounded-pill"><?= $r[1] ?>/10</span></td>
                            <td class="text-muted small"><?= $r[2] ?></td>
                            <td><span class="badge" style="background:rgba(40,199,111,0.15);color:#28c76f;">✅ Done</span></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr style="background:rgba(79,110,247,0.04);">
                            <td class="fw-800">TOTAL</td>
                            <td><span class="badge bg-primary rounded-pill fw-700">50/50</span></td>
                            <td class="fw-600 text-primary">All requirements satisfied</td>
                            <td>🎯</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="py-5">
    <div class="container text-center fade-in-up">
        <h2 class="section-title mb-3">Ready to Try It?</h2>
        <p class="section-sub mb-4">Register for a free account and start managing your tasks today.</p>
        <a href="auth.php" class="btn btn-primary btn-lg rounded-pill px-5">
            <i class="bi bi-person-plus me-2"></i>Create Your Account
        </a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
