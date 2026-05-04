<?php
session_start();
require_once '../config/db.php';

$developer_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

if (!$developer_id) {
    die("Login required");
}

$success = "";
$error   = "";

/* ==============================
   GET PROJECT
============================== */

$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : 0;

$project = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM projects WHERE id=$project_id")
);

if (!$project) {
    die("Invalid Project");
}

/* ==============================
   SUBMIT BID
============================== */

if (isset($_POST['submit_bid'])) {

    $amount = (float)$_POST['bid_amount'];
    $days   = (int)$_POST['delivery_time'];
    $letter = mysqli_real_escape_string($conn, trim($_POST['cover_letter']));

    if ($amount > 0 && $days > 0 && $letter != "") {

        $check = mysqli_query(
            $conn,
            "SELECT id FROM bids 
             WHERE project_id=$project_id 
             AND developer_id=$developer_id"
        );

        if (mysqli_num_rows($check) > 0) {
            $error = "You already placed bid.";
        } else {

            $sql = "INSERT INTO bids
                    (project_id, developer_id, amount, delivery_days, cover_letter)
                    VALUES
                    ($project_id,$developer_id,$amount,$days,'$letter')";

            if (mysqli_query($conn, $sql)) {

                header("Location: browse_projects.php?bid_success=1");
                exit;

            } else {
                $error = mysqli_error($conn);
            }
        }

    } else {
        $error = "All fields required";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Place Bid</title>
<style>
:root {
    --primary: #6c63ff;
    --primary-dark: #584ff5;
    --success: #2ecc71;
    --bg: #f4f6ff;
    --card-bg: #ffffff;
    --border: #e6e9ff;
    --text-dark: #2d2f39;
    --text-light: #777;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Segoe UI", sans-serif;
    background: linear-gradient(135deg, #eef1ff, #f9faff);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

/* Card Container */
.box {
    background: var(--card-bg);
    width: 100%;
    max-width: 550px;
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0 20px 45px rgba(108, 99, 255, 0.15);
    position: relative;
    animation: fadeIn 0.4s ease-in-out;
}

/* Title */
.box h2 {
    font-size: 22px;
    color: var(--text-dark);
    margin-bottom: 10px;
}

/* Project Budget Highlight */
.project-budget {
    font-size: 14px;
    color: var(--success);
    font-weight: 600;
    margin-bottom: 20px;
}

/* Inputs */
input[type="number"],
textarea {
    width: 100%;
    padding: 14px;
    margin-bottom: 16px;
    border-radius: 10px;
    border: 1px solid var(--border);
    background: #f8f9ff;
    font-size: 14px;
    transition: all 0.25s ease;
}

textarea {
    min-height: 120px;
    resize: vertical;
}

/* Focus Effect */
input:focus,
textarea:focus {
    outline: none;
    border-color: var(--primary);
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(108, 99, 255, 0.15);
}

/* Button */
button {
    width: 100%;
    padding: 14px;
    border-radius: 10px;
    border: none;
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    box-shadow: 0 10px 25px rgba(108, 99, 255, 0.25);
    transition: all 0.25s ease;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(108, 99, 255, 0.35);
}

/* Error Message */
.error {
    background: #ffecec;
    color: #e74c3c;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 14px;
    border-left: 4px solid #e74c3c;
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 600px) {
    .box {
        padding: 25px;
    }
}

</style>
</head>
<body>

<div class="box">

<h2><?php echo htmlspecialchars($project['title']); ?></h2>

<?php if($error) echo "<p class='error'>$error</p>"; ?>

<form method="post">

<input type="number" name="bid_amount" placeholder="Bid Amount" required>

<input type="number" name="delivery_time" placeholder="Delivery Days" required>

<textarea name="cover_letter" placeholder="Cover Letter" required></textarea>

<button name="submit_bid">Submit Bid</button>

</form>

</div>

</body>
</html>
