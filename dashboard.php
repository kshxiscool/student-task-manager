<?php
// ============================================
// dashboard.php - Main Dashboard (Protected)
// Full CRUD: Create, Read, Update, Delete tasks
// ============================================
require_once 'includes/functions.php';
require_once 'includes/db.php';

requireLogin(); // Redirect to login if not authenticated

$userId = $_SESSION['user_id'];
$errors = [];
$success = '';

// ============================================
// CREATE TASK (POST)
// ============================================
if (isset($_POST['add_task'])) {
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
            "INSERT INTO tasks (user_id, title, description, priority, status, due_date)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, 'isssss',
            $userId, $title, $description, $priority, $status, $dueDateVal
        );

        if (mysqli_stmt_execute($stmt)) {
            setFlash('success', 'Task created successfully!');
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = 'Failed to create task. Please try again.';
        }
        mysqli_stmt_close($stmt);
    }
}

// ============================================
// DELETE TASK (POST)
// ============================================
if (isset($_POST['delete_task'])) {
    $taskId = (int)$_POST['task_id'];

    // Make sure the task belongs to this user (security check)
    $stmt = mysqli_prepare($conn,
        "DELETE FROM tasks WHERE id = ? AND user_id = ?"
    );
    mysqli_stmt_bind_param($stmt, 'ii', $taskId, $userId);

    if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
        setFlash('success', 'Task deleted successfully.');
    } else {
        setFlash('danger', 'Could not delete task. It may not exist.');
    }
    mysqli_stmt_close($stmt);
    header("Location: dashboard.php");
    exit();
}

// ============================================
// READ: Fetch all tasks for this user
// ============================================
$tasksResult = mysqli_query($conn,
    "SELECT * FROM tasks WHERE user_id = $userId ORDER BY
        FIELD(status, 'In Progress', 'Pending', 'Completed'),
        FIELD(priority, 'High', 'Medium', 'Low'),
        created_at DESC"
);
$tasks = mysqli_fetch_all($tasksResult, MYSQLI_ASSOC);

// ============================================
// READ: Task stats for the summary cards
// ============================================
$statsResult = mysqli_query($conn,
    "SELECT
        COUNT(*) as total,
        SUM(status = 'Pending') as pending,
        SUM(status = 'In Progress') as in_progress,
        SUM(status = 'Completed') as completed
     FROM tasks WHERE user_id = $userId"
);
$stats = mysqli_fetch_assoc($statsResult);

$pageTitle = 'Dashboard';
include 'includes/header.php';
?>

<!-- ============ DASHBOARD HEADER ============ -->
<div class="dashboard-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="fw-800 mb-1">👋 Hello, <?= getUserName() ?>!</h2>
                <p class="mb-0" style="opacity:0.85;">Here's your task overview for today — <?= date('D, d M Y') ?></p>
            </div>
            <div class="col-auto">
                <button class="btn btn-light rounded-pill fw-600" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <i class="bi bi-plus-circle me-2"></i>Add New Task
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">

    <!-- Flash Messages -->
    <?php showFlash(); ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <?= implode('<br>', $errors) ?>
        </div>
    <?php endif; ?>

    <!-- ============ STATS CARDS ============ -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3 fade-in-up">
            <div class="stat-card stat-card-total p-3 rounded-3">
                <div style="font-size:0.75rem;opacity:0.85;text-transform:uppercase;letter-spacing:0.5px;">Total Tasks</div>
                <div style="font-size:2rem;font-weight:800;line-height:1.2;"><?= $stats['total'] ?? 0 ?></div>
                <i class="bi bi-list-task" style="font-size:1.5rem;opacity:0.5;"></i>
            </div>
        </div>
        <div class="col-6 col-md-3 fade-in-up delay-1">
            <div class="stat-card stat-card-pending p-3 rounded-3">
                <div style="font-size:0.75rem;opacity:0.85;text-transform:uppercase;letter-spacing:0.5px;">Pending</div>
                <div style="font-size:2rem;font-weight:800;line-height:1.2;"><?= $stats['pending'] ?? 0 ?></div>
                <i class="bi bi-hourglass-split" style="font-size:1.5rem;opacity:0.5;"></i>
            </div>
        </div>
        <div class="col-6 col-md-3 fade-in-up delay-2">
            <div class="stat-card stat-card-progress p-3 rounded-3">
                <div style="font-size:0.75rem;opacity:0.75;text-transform:uppercase;letter-spacing:0.5px;">In Progress</div>
                <div style="font-size:2rem;font-weight:800;line-height:1.2;"><?= $stats['in_progress'] ?? 0 ?></div>
                <i class="bi bi-arrow-repeat" style="font-size:1.5rem;opacity:0.5;"></i>
            </div>
        </div>
        <div class="col-6 col-md-3 fade-in-up delay-3">
            <div class="stat-card stat-card-done p-3 rounded-3">
                <div style="font-size:0.75rem;opacity:0.85;text-transform:uppercase;letter-spacing:0.5px;">Completed</div>
                <div style="font-size:2rem;font-weight:800;line-height:1.2;"><?= $stats['completed'] ?? 0 ?></div>
                <i class="bi bi-check-circle" style="font-size:1.5rem;opacity:0.5;"></i>
            </div>
        </div>
    </div>

    <!-- ============ TASK FILTER BUTTONS (JavaScript DOM Manipulation) ============ -->
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <h5 class="fw-700 mb-0">My Tasks</h5>
        <div class="d-flex gap-2 flex-wrap">
            <button class="btn btn-sm btn-primary rounded-pill active" data-filter="all">All</button>
            <button class="btn btn-sm btn-outline-warning rounded-pill" data-filter="Pending">Pending</button>
            <button class="btn btn-sm btn-outline-primary rounded-pill" data-filter="In Progress">In Progress</button>
            <button class="btn btn-sm btn-outline-success rounded-pill" data-filter="Completed">Completed</button>
        </div>
    </div>

    <!-- ============ TASK LIST ============ -->
    <?php if (empty($tasks)): ?>
        <div id="emptyState" class="text-center py-5 fade-in-up">
            <i class="bi bi-inbox" style="font-size:4rem;color:var(--text-muted);"></i>
            <h5 class="mt-3 fw-700">No Tasks Yet</h5>
            <p class="text-muted">Click "Add New Task" to create your first task.</p>
            <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <i class="bi bi-plus-circle me-2"></i>Add Your First Task
            </button>
        </div>
    <?php else: ?>
        <div id="emptyState" class="text-center py-4" style="display:none;">
            <p class="text-muted">No tasks found for this filter.</p>
        </div>

        <?php foreach ($tasks as $i => $task):
            // Determine colors
            $priorityColors = ['High' => '#ea5455', 'Medium' => '#ff9f43', 'Low' => '#28c76f'];
            $statusColors   = ['Pending' => '#6c757d', 'In Progress' => '#4f6ef7', 'Completed' => '#28c76f'];
            $pColor = $priorityColors[$task['priority']] ?? '#6c757d';
            $sColor = $statusColors[$task['status']] ?? '#6c757d';

            // Overdue check
            $isOverdue = $task['due_date'] && $task['status'] !== 'Completed'
                         && strtotime($task['due_date']) < strtotime('today');
        ?>
        <div class="task-card fade-in-up" data-status="<?= htmlspecialchars($task['status']) ?>"
             style="animation-delay: <?= $i * 0.05 ?>s; border-left: 4px solid <?= $pColor ?>;">

            <div class="d-flex align-items-start gap-3">
                <!-- Status Dot -->
                <div class="mt-1">
                    <span class="status-dot" style="background:<?= $sColor ?>;"></span>
                </div>

                <!-- Task Info -->
                <div class="flex-fill">
                    <div class="task-title <?= ($task['status'] === 'Completed') ? 'text-muted' : '' ?>"
                         style="<?= ($task['status'] === 'Completed') ? 'text-decoration:line-through;' : '' ?>">
                        <?= htmlspecialchars($task['title']) ?>
                        <?php if ($isOverdue): ?>
                            <span class="badge bg-danger ms-2" style="font-size:0.7rem;">Overdue</span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($task['description'])): ?>
                    <p class="text-muted small mb-2" style="margin-top:4px;">
                        <?= htmlspecialchars(substr($task['description'], 0, 120)) ?>
                        <?= strlen($task['description']) > 120 ? '...' : '' ?>
                    </p>
                    <?php endif; ?>

                    <div class="task-meta">
                        <!-- Priority Badge -->
                        <span class="badge badge-priority-<?= $task['priority'] ?> rounded-pill"
                              style="font-size:0.75rem; padding:4px 10px;">
                            <?= $task['priority'] ?> Priority
                        </span>

                        <!-- Status Badge -->
                        <span class="badge rounded-pill"
                              style="font-size:0.75rem; padding:4px 10px;
                                     background:rgba(79,110,247,0.1);color:<?= $sColor ?>;">
                            <?= $task['status'] ?>
                        </span>

                        <!-- Due Date -->
                        <?php if ($task['due_date']): ?>
                        <span style="color:<?= $isOverdue ? '#ea5455' : 'var(--text-muted)' ?>;">
                            <i class="bi bi-calendar me-1"></i>
                            <?= date('d M Y', strtotime($task['due_date'])) ?>
                            <?= $isOverdue ? '⚠️' : '' ?>
                        </span>
                        <?php endif; ?>

                        <!-- Created date -->
                        <span><i class="bi bi-clock me-1"></i>Added <?= date('d M', strtotime($task['created_at'])) ?></span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 flex-shrink-0">
                    <a href="edit_task.php?id=<?= $task['id'] ?>"
                       class="btn btn-sm btn-outline-primary rounded-pill"
                       title="Edit Task">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" class="delete-form d-inline">
                        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                        <input type="hidden" name="delete_task" value="1">
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Delete Task">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- ============ ADD TASK MODAL ============ -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:var(--bg-card); border:1px solid var(--border-color); border-radius:20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-700">
                    <i class="bi bi-plus-circle text-primary me-2"></i>Add New Task
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="taskForm" novalidate>
                    <input type="hidden" name="add_task" value="1">

                    <div class="mb-3">
                        <label class="form-label" for="taskTitle">Task Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="taskTitle" name="title"
                               placeholder="e.g. Submit Math Assignment" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="taskDesc">Description <span class="text-muted">(optional)</span></label>
                        <textarea class="form-control" id="taskDesc" name="description"
                                  rows="3" placeholder="Add details about this task..."></textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label" for="taskPriority">Priority</label>
                            <select class="form-select" id="taskPriority" name="priority">
                                <option value="Low">🟢 Low</option>
                                <option value="Medium" selected>🟡 Medium</option>
                                <option value="High">🔴 High</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="taskStatus">Status</label>
                            <select class="form-select" id="taskStatus" name="status">
                                <option value="Pending" selected>⏳ Pending</option>
                                <option value="In Progress">🔄 In Progress</option>
                                <option value="Completed">✅ Completed</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="taskDueDate">Due Date <span class="text-muted">(optional)</span></label>
                        <input type="date" class="form-control" id="taskDueDate" name="due_date"
                               min="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill rounded-pill fw-600">
                            <i class="bi bi-check2 me-2"></i>Create Task
                        </button>
                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reopen modal if there were errors (PHP posted) -->
<?php if (!empty($errors) && isset($_POST['add_task'])): ?>
<script>
    window.addEventListener('load', function () {
        if (window.bootstrap) {
            var modalEl = document.getElementById('addTaskModal');
            if (modalEl) {
                bootstrap.Modal.getOrCreateInstance(modalEl).show();
            }
        }
    });
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
