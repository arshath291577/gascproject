<?php
session_start();
require_once '../config/db.php';

$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : 0;

if ($project_id <= 0) {
    die("Invalid project.");
}

/* Fetch Project */
$project = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM projects WHERE id = $project_id")
);

/* Fetch Bids */
$bids = mysqli_query($conn, "
    SELECT b.*, u.name
    FROM bids b
    JOIN users u ON b.developer_id = u.id
    WHERE b.project_id = $project_id
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Project Bids</title>
</head>
<body>

<div class="container">

<h2>Bids for: <?php echo htmlspecialchars($project['title']); ?></h2>
<p class="subtitle">Developers who applied for this project</p>

<?php if (mysqli_num_rows($bids) > 0): ?>

    <?php while ($b = mysqli_fetch_assoc($bids)): ?>

    <div class="bid">

        <p>
            <b>Developer:</b>
            <?php echo htmlspecialchars($b['name']); ?>
        </p>

        <p>
            <b>Bid Amount:</b>
            ₹<?php echo htmlspecialchars($b['amount']); ?>
        </p>

        <p>
            <b>Delivery Time:</b>
            <?php echo htmlspecialchars($b['delivery_days']); ?> days
        </p>

        <p>
            <b>Proposal Message:</b><br>
            <?php echo nl2br(htmlspecialchars($b['cover_letter'])); ?>
        </p>

        <br>

        <a href="view_developer.php?developer_id=<?php echo (int)$b['developer_id']; ?>&project_id=<?php echo (int)$project_id; ?>">
            <button class="view-btn">View Developer Profile</button>
        </a>

    </div>

    <?php endwhile; ?>

<?php else: ?>

<p>No bids yet.</p>

<?php endif; ?>

<br>

<a href="dashboard.php" class="view-btn">Back to Dashboard</a>

</div>

</body><style>
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
</html>