<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

$client_id = (int)$_SESSION['user_id'];

$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($project_id <= 0) {
    die("Invalid project.");
}

/* FETCH PROJECT */
$project = mysqli_fetch_assoc(
    mysqli_query($conn, "
        SELECT * FROM projects
        WHERE id = $project_id
        AND client_id = $client_id
    ")
);

if (!$project) {
    die("Project not found.");
}

$success = '';
$error = '';

/* UPDATE PROJECT */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $skills = mysqli_real_escape_string($conn, $_POST['skills']);
    $budget_type = mysqli_real_escape_string($conn, $_POST['budget_type']);
    $min_budget = (float)$_POST['min_budget'];
    $max_budget = (float)$_POST['max_budget'];
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);

    $sql = "UPDATE projects SET
                title = '$title',
                category = '$category',
                description = '$description',
                skills = '$skills',
                budget_type = '$budget_type',
                min_budget = $min_budget,
                max_budget = $max_budget,
                duration = '$duration'
            WHERE id = $project_id
            AND client_id = $client_id";

    if (mysqli_query($conn, $sql)) {
        $success = "Project updated successfully.";
    } else {
        $error = "Update failed.";
    }

    // Refresh project data
    $project = mysqli_fetch_assoc(
        mysqli_query($conn, "
            SELECT * FROM projects
            WHERE id = $project_id
        ")
    );
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Project</title>
</head>
<!DOCTYPE html>
<html>
<head>
<title>Edit Project</title>
</head>

<body>

<div class="container">

<h2>Edit Project</h2>
<p class="subtitle">Update your project details</p>

<?php if ($success): ?>
<div class="alert success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if ($error): ?>
<div class="alert error"><?php echo $error; ?></div>
<?php endif; ?>

<div class="edit-form">

<form method="post">

<input type="text"
name="title"
placeholder="Project Title"
value="<?php echo htmlspecialchars($project['title']); ?>"
required>


<input type="text"
name="category"
placeholder="Category"
value="<?php echo htmlspecialchars($project['category']); ?>"
required>


<textarea name="description"
placeholder="Project Description"
required><?php echo htmlspecialchars($project['description']); ?></textarea>


<input type="text"
name="skills"
placeholder="Required Skills"
value="<?php echo htmlspecialchars($project['skills']); ?>">


<input type="text"
name="budget_type"
placeholder="Budget Type (Fixed / Hourly)"
value="<?php echo htmlspecialchars($project['budget_type']); ?>">


<input type="number"
name="min_budget"
placeholder="Minimum Budget"
value="<?php echo $project['min_budget']; ?>">


<input type="number"
name="max_budget"
placeholder="Maximum Budget"
value="<?php echo $project['max_budget']; ?>">


<input type="text"
name="duration"
placeholder="Project Duration"
value="<?php echo htmlspecialchars($project['duration']); ?>">


<button type="submit">Update Project</button>

<a href="dashboard.php">Cancel</a>

</form>

</div>

</div>

</body>
</html>
<style>
:root {
    --primary: #016B61;
    --primary-dark: #02433d;
    --secondary: #70B2B2;
    --accent: #E5E9C5;
    --bg-light: #f4fbfa;
    --card: #ffffff;
    --text: #313647;
    --muted: #6b7a7a;
    --border: #e3f0ef;
    --danger: #dc3545;
    --info: #17a2b8;
}

/* ===== GLOBAL ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Segoe UI", Arial, sans-serif;
    background: linear-gradient(135deg, #f0f7f6 0%, #e8f5f4 100%);
    color: var(--text);
}

.container {
    width: 92%;
    max-width: 1050px;
    margin: 40px auto;
}

/* ===== HEADINGS ===== */
h2 {
    font-size: 26px;
    margin-bottom: 5px;
    color: var(--primary);
}

.subtitle {
    color: var(--muted);
    margin-bottom: 25px;
}

/* ===== ALERTS ===== */
.alert {
    padding: 14px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-size: 14px;
    border-left: 5px solid;
}

.success {
    background: #e6f4f1;
    border-color: var(--primary);
    color: var(--primary-dark);
}

.error {
    background: #fdeaea;
    border-color: var(--danger);
    color: var(--danger);
}

/* ===== PROJECT CARD ===== */
.project {
    background: var(--card);
    padding: 25px;
    margin-bottom: 25px;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    border: 1px solid var(--border);
    transition: 0.3s ease;
}

.project:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
}

.project h3 {
    margin-bottom: 12px;
    color: var(--primary-dark);
}

.project p {
    margin: 6px 0;
    line-height: 1.6;
}

/* ===== ACTION BUTTONS ===== */
.actions {
    margin-top: 15px;
}

.actions a {
    display: inline-block;
    padding: 6px 14px;
    margin-right: 8px;
    border-radius: 6px;
    font-size: 13px;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s ease;
}

.actions a.edit {
    background: var(--info);
    color: #fff;
}

.actions a.edit:hover {
    background: #138496;
}

.actions a.delete {
    background: var(--danger);
    color: #fff;
}

.actions a.delete:hover {
    background: #b02a37;
}

/* ===== BIDS SECTION ===== */
.bid-section {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid var(--border);
}

.bid {
    background: #f9fffd;
    padding: 15px;
    margin-top: 15px;
    border-radius: 10px;
    border-left: 4px solid var(--primary);
    box-shadow: 0 5px 15px rgba(0,0,0,0.04);
}

.bid p {
    margin: 5px 0;
    font-size: 14px;
}

/* View Profile Button */
.view-btn {
    margin-left: 10px;
    background: var(--primary);
    color: #fff;
    border: none;
    padding: 5px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 13px;
    transition: 0.3s ease;
}

.view-btn:hover {
    background: var(--primary-dark);
}

/* ===== EDIT FORM ===== */
.edit-form {
    background: var(--card);
    padding: 25px;
    margin-bottom: 30px;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    border: 1px solid var(--border);
}

.edit-form h3 {
    margin-bottom: 20px;
    color: var(--primary);
}

.edit-form input,
.edit-form textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid var(--border);
    font-size: 14px;
    background: #fafafa;
    transition: 0.2s ease;
}

.edit-form input:focus,
.edit-form textarea:focus {
    outline: none;
    border-color: var(--primary);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(1,107,97,0.15);
}

.edit-form textarea {
    min-height: 100px;
    resize: vertical;
}

.edit-form button {
    padding: 10px 18px;
    background: var(--primary);
    border: none;
    border-radius: 6px;
    color: #fff;
    font-size: 14px;
    cursor: pointer;
    transition: 0.3s ease;
}

.edit-form button:hover {
    background: var(--primary-dark);
}

.edit-form a {
    margin-left: 10px;
    font-size: 14px;
    text-decoration: none;
    color: var(--primary);
}

.edit-form a:hover {
    text-decoration: underline;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 600px) {
    .container {
        width: 95%;
    }

    .project {
        padding: 18px;
    }
}
</style>