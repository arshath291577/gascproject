<?php
session_start();
require_once "../config/db.php";

$alert = "";

if (isset($_POST['login'])) {

    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email == "" || $password == "") {
        $alert = "Email and password are required!";
    } else {

        $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {

            $row = mysqli_fetch_assoc($result);

            if ($password === $row['password']) {

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role']    = $row['role'];

                if ($row['role'] == "client") {
                    header("Location: ../index.php");
                } else if ($row['role'] == "developer") {
                    header("Location: ../index.php");
                } else {
                    header("Location: ../admin/dashboard.php");
                }
                exit;
            } else {
                $alert = "Invalid password!";
            }
        } else {
            $alert = "Email not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>

    <div class="login-container">

        <!-- Logo / Title -->
        <div class="logo">
            <h1>Welcome Back</h1>
            <p>Please login to your account</p>
        </div>

        <!-- Alert Message -->
        <?php if (!empty($alert)) : ?>
            <p style="color: var(--error); text-align:center; margin-bottom:1rem;">
                <?php echo $alert; ?>
            </p>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST">

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <!-- Remember / Forgot -->
            <div class="form-options">
                <div class="remember-me">
                    <input type="checkbox" id="remember">
                    <label for="remember">Remember me</label>
                </div>
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>

            <button type="submit" name="login" class="btn">Login</button>

        </form>

        <!-- Divider -->
        <div class="divider">OR</div>

        <!-- Social Login (optional UI only) -->
        <div class="social-login">
            <button class="social-btn">Google</button>
            <button class="social-btn">GitHub</button>
        </div>

        <!-- Register Link -->
        <div class="register-link">
            Don’t have an account?
            <a href="../auth/register.php">Register</a>
        </div>

        <!-- Back Home -->
        <div class="back-home">
            <a href="../index.php">← Back to Home</a>
        </div>

    </div>

</body>

</html>


<style>
    /* =========================
   Global Reset & Variables
========================= */
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
        --error: #ef4444;
    }

    /* =========================
   Body
========================= */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f7e6ac 0%, #2f5f63 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    /* =========================
   Common Container Styles
   (used by both login & register)
========================= */
    .register-container,
    .login-container {
        background: var(--light);
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
        width: 100%;
        padding: 3rem;
    }

    /* Specific widths (keep your existing class names) */
    .register-container {
        max-width: 500px;
    }

    .login-container {
        max-width: 450px;
    }

    /* =========================
   Logo / Title (Common)
========================= */
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

    /* =========================
   Form Groups (Common)
========================= */
    .form-group {
        margin-bottom: 1.5rem;
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

    /* =========================
   Buttons (Common)
========================= */
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

    /* =========================
   Links & Extras (Common)
========================= */
    .login-link,
    .register-link {
        text-align: center;
        margin-top: 1.5rem;
        color: var(--gray);
        font-size: 0.95rem;
    }

    .login-link a,
    .register-link a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }

    .login-link a:hover,
    .register-link a:hover {
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

    /* =========================
   REGISTER PAGE SPECIFIC
========================= */

    /* User type selector */
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

    /* Row layout for name, etc. */
    .form-row {
        display: flex;
        gap: 1rem;
    }

    .form-row .form-group {
        flex: 1;
    }

    /* Terms section */
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

    /* =========================
   LOGIN PAGE SPECIFIC
========================= */

    /* Remember + Forgot password */
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .forgot-password {
        color: var(--primary);
        text-decoration: none;
        font-size: 0.9rem;
    }

    .forgot-password:hover {
        text-decoration: underline;
    }

    /* Divider */
    .divider {
        text-align: center;
        margin: 1.5rem 0;
        position: relative;
        color: var(--gray);
        font-size: 0.9rem;
    }

    .divider::before,
    .divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 45%;
        height: 1px;
        background: #d3d9d8;
    }

    .divider::before {
        left: 0;
    }

    .divider::after {
        right: 0;
    }

    /* Social buttons */
    .social-login {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .social-btn {
        flex: 1;
        padding: 0.9rem;
        border: 2px solid #d3d9d8;
        background: white;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
    }

    .social-btn:hover {
        border-color: var(--primary);
        transform: translateY(-2px);
    }

    /* =========================
   Responsive
========================= */
    @media (max-width: 480px) {

        .register-container,
        .login-container {
            padding: 2rem;
        }

        .form-row {
            flex-direction: column;
        }

        .user-type-selector {
            flex-direction: column;
        }

        .social-login {
            flex-direction: column;
        }
    }
</style>

</body>

</html>