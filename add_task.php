<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $task_name = trim($_POST['task_name']);
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];

    // Server-side validation
    if (empty($task_name)) {
        $errors[] = "Task name is required.";
    }
    if (!empty($due_date) && $due_date < date('Y-m-d')) {
        $errors[] = "Due date cannot be in the past.";
    }

    if (empty($errors)) {
        // Insert the task into the database
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_name, description, due_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $task_name, $description, $due_date);

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = "Error adding task: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Task</title>
    <style>
        /* General Reset and Body Styles */
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

        /* Container Styling */
        .container {
            max-width: 400px;
            width: 100%;              /* Ensure the container fills the available space */
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;       /* Center text content */
        }

        /* Heading Styling */
        h2 {
            margin-bottom: 20px;
        }

        /* Input Fields */
        input, textarea {
            width: calc(100% - 20px); /* Avoid overflow within the container */
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ced4da;
            border-radius: 5px;
            text-align: left;
        }

        /* Buttons */
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
            background-color: #0056b3;
        }

        /* Links */
        a {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Error and Success Messages */
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
        a {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Task</h2>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="add_task.php">
            <label>Task Name:</label>
            <input type="text" name="task_name" required>

            <label>Description:</label>
            <textarea name="description" rows="4"></textarea>

            <label>Due Date:</label>
            <input type="date" name="due_date">

            <button type="submit" class="btn">Add Task</button>
        </form>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
