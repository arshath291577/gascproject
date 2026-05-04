<?php
session_start();
require_once '../config/db.php';

$user_id = (int)$_SESSION['user_id'];

$success = '';
$error = '';

/* Save / Update profile */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $company = mysqli_real_escape_string($conn, $_POST['company_name']);
    $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $about   = mysqli_real_escape_string($conn, $_POST['about']);

    $check = mysqli_query($conn, "SELECT id FROM client_profiles WHERE id = $user_id");

    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "
            UPDATE client_profiles SET
            company_name='$company',
            phone='$phone',
            address='$address',
            about='$about'
            WHERE user_id=$user_id
        ");
        $success = "Profile updated successfully";
    } else {
        mysqli_query($conn, "
            INSERT INTO client_profiles (user_id, company_name, phone, address, about)
            VALUES ($user_id, '$company', '$phone', '$address', '$about')
        ");
        $success = "Profile created successfully";
    }
}

/* Fetch profile */
$profile = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM client_profiles WHERE user_id=$user_id")
);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Client Profile</title>

    <style>
        :root {
    --primary: #6c63ff;
    --primary-dark: #584ff5;
    --accent: #f3f4ff;
    --bg: #f6f8ff;
    --text-dark: #2d2f39;
    --text-light: #777;
    --border: #e4e7ff;
    --success-bg: #e9f8f1;
    --success-border: #2ecc71;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Segoe UI", sans-serif;
    background: linear-gradient(135deg, #eef1ff, #f8f9ff);
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 20px;
}

/* Card Container */
.box {
    width: 100%;
    max-width: 650px;
    background: #ffffff;
    padding: 40px;
    border-radius: 18px;
    box-shadow: 0 20px 45px rgba(108, 99, 255, 0.15);
    position: relative;
    animation: fadeIn 0.4s ease-in-out;
}

/* Soft Glow Background Effect */
.box::before {
    content: "";
    position: absolute;
    top: -60px;
    right: -60px;
    width: 180px;
    height: 180px;
    background: var(--primary);
    opacity: 0.07;
    border-radius: 50%;
    z-index: 0;
}

/* Title */
.box h2 {
    text-align: center;
    color: var(--text-dark);
    font-size: 26px;
    margin-bottom: 30px;
    position: relative;
    z-index: 1;
}

/* Label Styling */
label {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-dark);
    margin-top: 18px;
    display: block;
}

/* Inputs */
input[type="text"],
textarea {
    width: 100%;
    padding: 14px;
    margin-top: 6px;
    border-radius: 10px;
    border: 1px solid var(--border);
    background: var(--accent);
    font-size: 14px;
    transition: all 0.25s ease;
}

textarea {
    min-height: 110px;
    resize: vertical;
}

/* Focus Effect */
input:focus,
textarea:focus {
    outline: none;
    border-color: var(--primary);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(108, 99, 255, 0.15);
}

/* Button */
button {
    width: 100%;
    margin-top: 28px;
    padding: 14px;
    border-radius: 10px;
    border: none;
    font-size: 15px;
    font-weight: 600;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 10px 25px rgba(108, 99, 255, 0.25);
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(108, 99, 255, 0.35);
}

/* Success Alert */
.success {
    background: var(--success-bg);
    border-left: 5px solid var(--success-border);
    padding: 14px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 14px;
    color: #2c3e50;
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

    .box h2 {
        font-size: 22px;
    }
}

    </style>
</head>

<body>

    <div class="box">
        <h2>Client Profile</h2>

        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="post">
            <label>Company Name</label>
            <input type="text" name="company_name" value="<?php echo @$profile['company_name']; ?>">

            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo @$profile['phone']; ?>">

            <label>Address</label>
            <textarea name="address"><?php echo @$profile['address']; ?></textarea>

            <label>About</label>
            <textarea name="about"><?php echo @$profile['about']; ?></textarea>

            <button type="submit">Save Profile</button>
        </form>
    </div>

</body>

</html>