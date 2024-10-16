<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$task_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];
$errors = [];
$success = '';

if (!$task_id) {
    $errors[] = "Task ID is missing.";
} else {
    // Fetch the task from the database
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
    } else {
        $errors[] = "Task not found.";
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($errors)) {
    $task_name = trim($_POST['task_name']);
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];

    // Validate inputs
    if (empty($task_name)) {
        $errors[] = "Task name is required.";
    }
    if (empty($due_date)) {
        $errors[] = "Due date is required.";
    }

    // Update task if no validation errors
    if (empty($errors)) {
        $stmt = $conn->prepare(
            "UPDATE tasks SET task_name = ?, description = ?, due_date = ? WHERE id = ? AND user_id = ?"
        );
        $stmt->bind_param("sssii", $task_name, $description, $due_date, $task_id, $user_id);

        if ($stmt->execute()) {
            $success = "Task updated successfully!";
        } else {
            $errors[] = "Error updating task: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;            /* Flexbox layout for vertical & horizontal centering */
            align-items: center;      /* Center vertically */
            justify-content: center;  /* Center horizontally */
            min-height: 100vh;        /* Ensure it fills the viewport height */
            overflow: hidden;         /* Avoid scrollbars from appearing unnecessarily */
        }
        .container {
            max-width: 400px;
            width: 100%;              /* Ensure the container fills the available space */
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;       /* Center text content */
        }
        h2 {
            margin-bottom: 20px;
        }
        input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ced4da;
            border-radius: 5px;
            width: calc(100% - 20px); /* Avoid content overflow */
            text-align: left;
        }
        input, textarea {
            width: calc(100% - 20px); /* Avoid overflow within the container */
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ced4da;
            border-radius: 5px;
            text-align: left;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #218838;
        }
        .error, .success {
            margin-bottom: 10px;
            text-align: center;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Task</h2>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success">
                <p><?php echo $success; ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($task)): ?>
            <form method="post" action="edit_task.php?id=<?php echo $task_id; ?>">
                <label>Task Name:</label>
                <input type="text" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>

                <label>Description:</label>
                <textarea name="description"><?php echo htmlspecialchars($task['description']); ?></textarea>

                <label>Due Date:</label>
                <input type="date" name="due_date" value="<?php echo $task['due_date']; ?>" required>

                <button type="submit" class="btn">Update Task</button>
            </form>
            <a href="dashboard.php" class="back-link">Back to Dashboard</a>
        <?php endif; ?>
    </div>
</body>
</html>
