<?php
session_start();
require_once "../config/db.php";

$alert = "";

if (isset($_POST['register'])) {

    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role     = trim($_POST['role']); // client OR developer

    if ($name == "" || $email == "" || $password == "" || $role == "") {
        $alert = "All fields are required!";
    } else {

        // Check if email exists
        $query = "SELECT id FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $alert = "Email already exists!";
        } else {

            $hashedPwd = $password;

            $sql = "INSERT INTO users(name, email, password, role)
                    VALUES('$name', '$email', '$hashedPwd', '$role')";

            if (mysqli_query($conn, $sql)) {
                $alert = "Registration successful!";
            } else {
                $alert = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>

<body>

    <div class="register-container">

        <div class="logo">
            <h1>Create Account</h1>
            <p>Join as a Client or Developer</p>
        </div>

        <?php if (!empty($alert)): ?>
            <p style="text-align:center; margin-bottom:1rem; color:#c0392b;">
                <?php echo $alert; ?>
            </p>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter your full name">
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Create a password">
            </div>

            <div class="form-group">
                <label>Select Role</label>
                <select name="role">
                    <option value="">Choose role</option>
                    <option value="client">Client</option>
                    <option value="developer">Developer</option>
                </select>
            </div>

            <button type="submit" name="register" class="btn">
                Register
            </button>

        </form>

        <div class="login-link">
            Already have an account?
            <a href="login.php">Login</a>
        </div>

        <div class="back-home">
            <a href="index.php">← Back to Home</a>
        </div>

    </div>

</body>

</html>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        /* Updated color palette */
        --primary: #2f5f63;
        /* Teal blue */
        --primary-dark: #2e3d3d;
        /* Deep slate green */
        --secondary: #f7e6ac;
        /* Soft pastel yellow */

        --dark: #2e3d3d;
        --light: #faf7ef;
        --gray: #6b7a7a;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f7e6ac 0%, #2f5f63 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .register-container {
        background: var(--light);
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
        max-width: 500px;
        width: 100%;
        padding: 3rem;
    }

    .logo {
        text-align: center;
        margin-bottom: 2rem;
    }

    .logo h1 {
        font-size: 2rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }

    .logo p {
        color: var(--gray);
        font-size: 0.95rem;
    }

    .user-type-selector {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .user-type {
        flex: 1;
        padding: 1rem;
        border: 2px solid #d3d9d8;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: #ffffff;
    }

    .user-type:hover {
        border-color: var(--primary);
    }

    .user-type.active {
        border-color: var(--primary);
        background: rgba(47, 95, 99, 0.08);
    }

    .user-type .icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .user-type .label {
        font-weight: 600;
        color: var(--dark);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-row {
        display: flex;
        gap: 1rem;
    }

    .form-row .form-group {
        flex: 1;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--dark);
        font-weight: 500;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.9rem;
        border: 2px solid #d3d9d8;
        border-radius: 10px;
        font-size: 1rem;
        transition: border-color 0.3s;
        background: #ffffff;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary);
    }

    .terms {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .terms input {
        margin-top: 0.2rem;
    }

    .terms label {
        color: var(--gray);
    }

    .terms a {
        color: var(--primary);
        text-decoration: none;
    }

    .terms a:hover {
        text-decoration: underline;
    }

    .btn {
        width: 100%;
        padding: 1rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(47, 95, 99, 0.3);
    }

    .login-link {
        text-align: center;
        margin-top: 1.5rem;
        color: var(--gray);
    }

    .login-link a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    .back-home {
        text-align: center;
        margin-top: 1rem;
    }

    .back-home a {
        color: var(--gray);
        text-decoration: none;
        font-size: 0.9rem;
    }

    .back-home a:hover {
        color: var(--dark);
    }

    @media (max-width: 480px) {
        .register-container {
            padding: 2rem;
        }

        .form-row {
            flex-direction: column;
        }

        .user-type-selector {
            flex-direction: column;
        }
    }
</style>