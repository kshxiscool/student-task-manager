<?php
// ============================================
// about.php - About Page
// ============================================
require_once 'includes/functions.php';
require_once 'includes/db.php';

$pageTitle = 'About';
include 'includes/header.php';
?>

<!-- Page Hero -->
<div class="page-hero fade-in-up">
    <div class="container">
        <span class="hero-badge d-inline-flex mb-3">Who We Are</span>
        <h1 class="mb-3">About <span style="background:linear-gradient(135deg,#4f6ef7,#764ba2);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">TaskFlow</span></h1>
        <p class="section-sub mx-auto">A capstone web project built to demonstrate real-world web development skills using HTML, CSS, Bootstrap, JavaScript, PHP and MySQL.</p>
    </div>
</div>

<!-- ============ PROJECT OVERVIEW ============ -->
<section class="py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 fade-in-up">
                <span class="hero-badge d-inline-flex mb-3">The Project</span>
                <h2 class="section-title mb-3">What is TaskFlow?</h2>
                <p class="text-muted" style="line-height:1.8;">
                    TaskFlow is a <strong>Student Task Manager</strong> web application developed as a Capstone Project
                    for the Web Technologies course (23CSE404). It allows students to register, log in, and
                    manage their academic tasks through a clean, responsive interface.
                </p>
                <p class="text-muted" style="line-height:1.8;">
                    The application demonstrates all key concepts taught in the course — from frontend design
                    with HTML and CSS to server-side processing with PHP and data persistence with MySQL.
                </p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <span class="badge rounded-pill" style="background:rgba(79,110,247,0.1);color:#4f6ef7;padding:8px 14px;font-size:0.82rem;">23CSE404 Capstone</span>
                    <span class="badge rounded-pill" style="background:rgba(40,199,111,0.1);color:#28c76f;padding:8px 14px;font-size:0.82rem;">Full Stack</span>
                    <span class="badge rounded-pill" style="background:rgba(255,159,67,0.1);color:#ff9f43;padding:8px 14px;font-size:0.82rem;">MVC Pattern</span>
                </div>
            </div>
            <div class="col-lg-6 fade-in-up delay-2">
                <div class="card p-4">
                    <h5 class="fw-700 mb-4"><i class="bi bi-code-slash text-primary me-2"></i>Course Details</h5>
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr><td class="text-muted fw-600" style="width:40%">Course</td><td class="fw-600">Web Technologies</td></tr>
                            <tr><td class="text-muted fw-600">Code</td><td class="fw-600">23CSE404</td></tr>
                            <tr><td class="text-muted fw-600">Instructor</td><td class="fw-600">Mir Junaid Rasool</td></tr>
                            <tr><td class="text-muted fw-600">Project</td><td class="fw-600">Capstone Web Project</td></tr>
                            <tr><td class="text-muted fw-600">Total Marks</td><td class="fw-600"><span class="text-primary">50 Marks</span></td></tr>
                            <tr><td class="text-muted fw-600">Type</td><td class="fw-600">Individual Project</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ BLOOM'S TAXONOMY ============ -->
<section class="py-5" style="background: var(--bg-card); border-top: 1px solid var(--border-color);">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="hero-badge d-inline-flex mb-3">Bloom's Taxonomy</span>
            <h2 class="section-title">Cognitive Levels Covered</h2>
            <p class="section-sub">This project is designed to address all six levels of Bloom's Taxonomy.</p>
        </div>
        <div class="row g-4">
            <?php
            $blooms = [
                ['Remember',  'bi-book',          'icon-blue',   'Recall HTML tags, CSS properties, PHP syntax, MySQL queries'],
                ['Understand','bi-lightbulb',      'icon-green',  'Explain how the DOM works, how PHP processes forms, how sessions persist'],
                ['Apply',     'bi-wrench',         'icon-orange', 'Build web pages using HTML/CSS, implement JS validation, connect PHP to MySQL'],
                ['Analyse',   'bi-search',         'icon-purple', 'Debug code, trace data flow between frontend and backend, identify errors'],
                ['Evaluate',  'bi-bar-chart',      'icon-teal',   'Assess responsiveness, performance, and security of the web application'],
                ['Create',    'bi-rocket-takeoff', 'icon-red',    'Design and develop a fully functional, original multi-page web application'],
            ];
            foreach ($blooms as $i => $b): ?>
            <div class="col-md-4 fade-in-up" style="animation-delay: <?= $i * 0.1 ?>s">
                <div class="card p-4 h-100">
                    <div class="feature-icon-box <?= $b[2] ?>">
                        <i class="bi <?= $b[1] ?>"></i>
                    </div>
                    <h6 class="fw-700"><?= $b[0] ?></h6>
                    <p class="text-muted small mb-0"><?= $b[3] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ TECH ARCHITECTURE ============ -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <h2 class="section-title">Project Architecture</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4 fade-in-up">
                <div class="card p-4 h-100 text-center">
                    <div class="feature-icon-box icon-blue mx-auto"><i class="bi bi-window"></i></div>
                    <h6 class="fw-700">Frontend Layer</h6>
                    <p class="text-muted small">HTML5 for structure, CSS3 for styling, Bootstrap 5 for responsiveness, JavaScript for interactivity and DHTML effects.</p>
                </div>
            </div>
            <div class="col-md-4 fade-in-up delay-1">
                <div class="card p-4 h-100 text-center">
                    <div class="feature-icon-box icon-orange mx-auto"><i class="bi bi-server"></i></div>
                    <h6 class="fw-700">Backend Layer</h6>
                    <p class="text-muted small">PHP for server-side logic, form processing, session management, cookie handling, and database connectivity.</p>
                </div>
            </div>
            <div class="col-md-4 fade-in-up delay-2">
                <div class="card p-4 h-100 text-center">
                    <div class="feature-icon-box icon-green mx-auto"><i class="bi bi-database"></i></div>
                    <h6 class="fw-700">Database Layer</h6>
                    <p class="text-muted small">MySQL for data storage. Tables for users, tasks, and contacts. Full CRUD operations via PHP + MySQLi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
