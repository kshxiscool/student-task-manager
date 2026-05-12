<?php
// ============================================
// edit_task.php - Edit Task (UPDATE in CRUD)
// ============================================
require_once 'includes/functions.php';
require_once 'includes/db.php';

requireLogin();

$userId = $_SESSION['user_id'];
$errors = [];

// Get task ID from URL
$taskId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// ---- Fetch the task to edit ----
$stmt = mysqli_prepare($conn, "SELECT * FROM tasks WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $taskId, $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$task = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// If task not found or doesn't belong to user, redirect
if (!$task) {
    setFlash('danger', 'Task not found or access denied.');
    header("Location: dashboard.php");
    exit();
}

// ============================================
// HANDLE UPDATE (POST)
// ============================================
if (isset($_POST['update_task'])) {
    $title       = clean($_POST['title']       ?? '');
    $description = clean($_POST['description'] ?? '');
    $priority    = clean($_POST['priority']    ?? 'Medium');
    $status      = clean($_POST['status']      ?? 'Pending');
    $dueDate     = clean($_POST['due_date']    ?? '');

    // Server-side validation
    if (empty($title)) {
        $errors[] = 'Task title is required.';
    }

    $allowedPriority = ['Low', 'Medium', 'High'];
    $allowedStatus   = ['Pending', 'In Progress', 'Completed'];
    if (!in_array($priority, $allowedPriority)) $priority = 'Medium';
    if (!in_array($status,   $allowedStatus))   $status   = 'Pending';

    if (empty($errors)) {
        $dueDateVal = !empty($dueDate) ? $dueDate : null;

        $stmt = mysqli_prepare($conn,
            "UPDATE tasks SET title=?, description=?, priority=?, status=?, due_date=?
             WHERE id=? AND user_id=?"
        );
        mysqli_stmt_bind_param($stmt, 'sssssii',
            $title, $description, $priority, $status, $dueDateVal, $taskId, $userId
        );

        if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) >= 0) {
            setFlash('success', 'Task updated successfully! ✅');
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = 'Failed to update task. Please try again.';
        }
        mysqli_stmt_close($stmt);
    }

    // If errors, preserve form values
    $task['title']       = $title;
    $task['description'] = $description;
    $task['priority']    = $priority;
    $task['status']      = $status;
    $task['due_date']    = $dueDate;
}

$pageTitle = 'Edit Task';
include 'includes/header.php';
?>

<div class="container py-5" style="max-width: 680px;">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Edit Task</li>
        </ol>
    </nav>

    <div class="card p-4 p-md-5 fade-in-up">
        <div class="mb-4">
            <h3 class="fw-800 mb-1">
                <i class="bi bi-pencil-square text-primary me-2"></i>Edit Task
            </h3>
            <p class="text-muted small mb-0">Update the task details below.</p>
        </div>

        <!-- Errors -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <?= implode('<br>', $errors) ?>
            </div>
        <?php endif; ?>

        <form method="POST" id="taskForm" novalidate>
            <input type="hidden" name="update_task" value="1">

            <div class="mb-3">
                <label class="form-label" for="taskTitle">Task Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="taskTitle" name="title"
                       value="<?= htmlspecialchars($task['title']) ?>"
                       placeholder="Task title" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="taskDesc">Description</label>
                <textarea class="form-control" id="taskDesc" name="description"
                          rows="4" placeholder="Add more details..."><?= htmlspecialchars($task['description'] ?? '') ?></textarea>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="taskPriority">Priority</label>
                    <select class="form-select" id="taskPriority" name="priority">
                        <option value="Low"    <?= $task['priority'] === 'Low'    ? 'selected' : '' ?>>🟢 Low</option>
                        <option value="Medium" <?= $task['priority'] === 'Medium' ? 'selected' : '' ?>>🟡 Medium</option>
                        <option value="High"   <?= $task['priority'] === 'High'   ? 'selected' : '' ?>>🔴 High</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="taskStatus">Status</label>
                    <select class="form-select" id="taskStatus" name="status">
                        <option value="Pending"     <?= $task['status'] === 'Pending'     ? 'selected' : '' ?>>⏳ Pending</option>
                        <option value="In Progress" <?= $task['status'] === 'In Progress' ? 'selected' : '' ?>>🔄 In Progress</option>
                        <option value="Completed"   <?= $task['status'] === 'Completed'   ? 'selected' : '' ?>>✅ Completed</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="taskDueDate">Due Date</label>
                    <input type="date" class="form-control" id="taskDueDate" name="due_date"
                           value="<?= htmlspecialchars($task['due_date'] ?? '') ?>">
                </div>
            </div>

            <div class="d-flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary flex-fill rounded-pill fw-600 py-2">
                    <i class="bi bi-check2-circle me-2"></i>Save Changes
                </button>
                <a href="dashboard.php" class="btn btn-outline-secondary rounded-pill px-4 fw-600">
                    <i class="bi bi-x me-1"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
