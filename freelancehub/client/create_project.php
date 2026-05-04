<?php
session_start();
require_once '../config/db.php';

$client_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

$success = $error = "";

// Default values
$title = $category = $description = $skills = $budget_type = $duration = "";
$min_budget = $max_budget = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title       = trim($_POST['title']);
    $category    = trim($_POST['category']);
    $description = trim($_POST['description']);
    $skills      = trim($_POST['skills']);
    $budget_type = trim($_POST['budget_type']);
    $duration    = trim($_POST['duration']);

    $min_budget = ($_POST['min_budget'] != "") ? floatval($_POST['min_budget']) : 0;
    $max_budget = ($_POST['max_budget'] != "") ? floatval($_POST['max_budget']) : 0;

    if ($title == "" || $category == "" || $description == "" || $budget_type == "" || $duration == "") {
        $error = "All required fields must be filled.";
    } else {

        /* FILE UPLOAD */
        $attachment = NULL;
        if (!empty($_FILES['attachment']['name'])) {

            $upload_dir = __DIR__ . "/uploads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_name = time() . "_" . basename($_FILES['attachment']['name']);
            $target    = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $target)) {
                $attachment = "uploads/" . $file_name;
            }
        }

        /* INSERT */
        $sql = "INSERT INTO projects 
        (client_id, title, category, description, skills, budget_type, min_budget, max_budget, duration, attachment_path, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "isssssddss",
            $client_id,
            $title,
            $category,
            $description,
            $skills,
            $budget_type,
            $min_budget,
            $max_budget,
            $duration,
            $attachment
        );

        if (mysqli_stmt_execute($stmt)) {
            $success = "Project created successfully!";
            $title = $category = $description = $skills = $budget_type = $duration = "";
            $min_budget = $max_budget = "";
        } else {
            $error = "Database error.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Project</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
        }

        .box {
            width: 600px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 20px;
            background: #4f46e5;
            color: #fff;
            border: none;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>
    <div class="box">
        <h2>🚀 Create New Project</h2>

        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>

        <form method="post" enctype="multipart/form-data">

            <div class="field">
                <label>Title <span>*</span></label>
                <input type="text" name="title" placeholder="Enter project title"
                    value="<?php echo htmlspecialchars($title); ?>">
            </div>

            <div class="field">
                <label>Category <span>*</span></label>
                <select name="category">
                    <option value="">Select a category</option>
                    <option value="web">Web Development</option>
                    <option value="mobile">Mobile App</option>
                    <option value="design">Design</option>
                </select>
            </div>

            <div class="field">
                <label>Description <span>*</span></label>
                <textarea name="description" placeholder="Describe your project..."><?php echo htmlspecialchars($description); ?></textarea>
            </div>

            <div class="field">
                <label>Skills</label>
                <input type="text" name="skills" placeholder="e.g. PHP, React, UI/UX"
                    value="<?php echo htmlspecialchars($skills); ?>">
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Budget Type <span>*</span></label>
                    <select name="budget_type">
                        <option value="">Select</option>
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                        <option value="large">Large</option>
                    </select>
                </div>

                <div class="field">
                    <label>Duration <span>*</span></label>
                    <select name="duration">
                        <option value="">Select</option>
                        <option value="1-week">1 Week</option>
                        <option value="1-month">1 Month</option>
                        <option value="3-months">3 Months</option>
                    </select>
                </div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Min Budget</label>
                    <input type="number" name="min_budget" placeholder="0">
                </div>

                <div class="field">
                    <label>Max Budget</label>
                    <input type="number" name="max_budget" placeholder="1000">
                </div>
            </div>

            <div class="field file-upload">
                <label>Attachment</label>
                <input type="file" name="attachment">
                <small>PDF, DOCX, or ZIP (max 5MB)</small>
            </div>

            <button type="submit">✨ Create Project</button>
        </form>
    </div>
</body>

<style>
    :root {
        --primary: #016B61;
        --primary-dark: #02433d;
        --secondary: #70B2B2;
        --accent: #E5E9C5;
        --dark: #313647;
        --light: #faf7ef;
        --gray: #6b7a7a;
        --shadow: rgba(0, 0, 0, 0.08);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: linear-gradient(135deg, #f4fbfa, #ffffff);
        color: var(--dark);
        min-height: 100vh;
    }

    /* Container */
    .box {
        max-width: 720px;
        margin: 50px auto;
        background: #ffffff;
        padding: 34px 36px;
        border-radius: 16px;
        box-shadow: 0 18px 40px var(--shadow);
        border: 1px solid rgba(112, 178, 178, 0.25);
    }

    /* Heading */
    .box h2 {
        margin-bottom: 26px;
        color: var(--primary);
        border-bottom: 3px solid var(--accent);
        padding-bottom: 14px;
        font-size: 24px;
        letter-spacing: 0.4px;
    }

    /* Form groups */
    .field {
        margin-bottom: 18px;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    /* Labels */
    label {
        font-weight: 600;
        font-size: 14px;
        color: var(--primary-dark);
        margin-bottom: 6px;
        display: block;
    }

    label span {
        color: #c62828;
    }

    /* Inputs */
    input[type="text"],
    input[type="number"],
    textarea,
    select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid var(--secondary);
        border-radius: 10px;
        font-size: 14px;
        background: var(--light);
        transition: all 0.25s ease;
    }

    textarea {
        min-height: 140px;
        resize: vertical;
    }

    /* Focus */
    input:focus,
    textarea:focus,
    select:focus {
        outline: none;
        border-color: var(--primary);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(1, 107, 97, 0.15);
    }

    /* File input */
    .file-upload input[type="file"] {
        background: #ffffff;
        padding: 10px;
    }

    .file-upload small {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        color: var(--gray);
    }

    /* Button */
    button {
        width: 100%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: #ffffff;
        border: none;
        padding: 14px 30px;
        font-size: 16px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 8px 18px rgba(1, 107, 97, 0.25);
        margin-top: 10px;
    }

    button:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(1, 107, 97, 0.35);
    }

    button:active {
        transform: translateY(0);
        box-shadow: 0 6px 14px rgba(1, 107, 97, 0.25);
    }

    /* Alerts */
    .error {
        background: #ffe5e5;
        color: #b00020;
        padding: 14px;
        border-radius: 8px;
        margin-bottom: 18px;
        border-left: 5px solid #b00020;
    }

    .success {
        background: #e6f4f1;
        color: var(--primary-dark);
        padding: 14px;
        border-radius: 8px;
        margin-bottom: 18px;
        border-left: 5px solid var(--primary);
    }

    /* Small Screens */
    @media (max-width: 650px) {
        .box {
            margin: 20px;
            padding: 24px;
        }

        .grid-2 {
            grid-template-columns: 1fr;
        }

        .box h2 {
            font-size: 21px;
        }
    }
</style>