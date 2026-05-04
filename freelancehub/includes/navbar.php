<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>

<header>
    <nav>
        <div class="logo">FreelanceHub</div>

        <ul class="nav-links">
            <li><a href="../index.php">Home</a></li>

            <?php if ($isLoggedIn): ?>

                
                <?php if ($role === 'client'): ?>
                    <li><a href="create_project.php" class="btn ">Post project</a></li>
                     <li><a href="client/dashboard.php" class="btn btn-outline"> Dashboard</a></li>
                    
                <?php elseif ($role === 'developer'): ?>
                    <li><a href="developer/browse_projects.php" class="btn btn-outline">Developer Dashboard</a></li>
                <?php elseif ($role === 'admin'): ?>
                    <li><a href="admin/dashboard.php" class="btn btn-outline">Admin Panel</a></li>
                <?php endif; ?>

                <li><a href="auth/logout.php" class="btn btn-primary">Logout</a></li>

            <?php else: ?>

                <li><a href="auth/login.php" class="btn btn-outline">Login</a></li>
                <li><a href="auth/register.php" class="btn btn-primary">Sign Up</a></li>

            <?php endif; ?>
        </ul>
    </nav>
</header>
<style>
    /* ========== NAVBAR ========== */
header {
    background: rgba(3, 47, 47, 0.95);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
    backdrop-filter: blur(8px);
}

nav {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 1.6rem;
    font-weight: bold;
    background: linear-gradient(135deg, #016B61, #70B2B2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.nav-links {
    display: flex;
    gap: 1.5rem;
    align-items: center;
}

.nav-links a {
    color: #faf7ef;
    font-weight: 500;
    transition: 0.3s;
}

.nav-links a:hover {
    color: #ffffff;
}

.welcome {
    color: #E5E9C5;
    font-weight: 500;
}

/* Buttons */
.btn {
    padding: 0.5rem 1.2rem;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: 0.3s;
}

.btn-primary {
    background: #016B61;
    color: #fff;
}

.btn-primary:hover {
    background: #02433d;
}

.btn-outline {
    border: 2px solid #70B2B2;
    color: #70B2B2;
}

.btn-outline:hover {
    background: #016B61;
    color: #fff;
}

</style>