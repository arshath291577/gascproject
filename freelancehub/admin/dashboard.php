<?php
session_start();
require_once '../config/db.php';

/* Optional: Restrict access */
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Access Denied");
}

/* Get Clients with Total Projects */
$clients = mysqli_query($conn, "
    SELECT u.id, u.name, u.email,
           COUNT(p.id) AS total_projects
    FROM users u
    LEFT JOIN projects p ON u.id = p.client_id
    WHERE u.role = 'client'
    GROUP BY u.id
");

/* Get Developers with Total Bids */
$developers = mysqli_query($conn, "
    SELECT u.id, u.name, u.email,
           COUNT(b.id) AS total_bids
    FROM users u
    LEFT JOIN bids b ON u.id = b.developer_id
    WHERE u.role = 'developer'
    GROUP BY u.id
");


/* Stats */
$total_users = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM users"));
$total_projects = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM projects"));
$total_bids = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM bids"));
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<style>
:root{
    --primary:#016B61;
    --dark:#02433d;
    --bg:#f4f6f9;
    --card:#ffffff;
    --text:#333;
    --muted:#777;
    --border:#e3e6f0;
}

/* ===== Layout ===== */
body{
    margin:0;
    font-family:Segoe UI, Arial;
    background:var(--bg);
}

.dashboard{
    display:flex;
}

/* ===== Sidebar ===== */
.sidebar{
    width:250px;
    background:#1f2937;
    min-height:100vh;
    color:#fff;
}

.sidebar h2{
    padding:20px;
    background:var(--primary);
    margin:0;
    text-align:center;
}

.sidebar a{
    display:block;
    padding:15px 20px;
    color:#ddd;
    text-decoration:none;
}

.sidebar a:hover{
    background:var(--primary);
    color:#fff;
}

/* ===== Main ===== */
.main{
    flex:1;
    padding:30px;
}

.topbar{
    background:#fff;
    padding:15px 25px;
    box-shadow:0 2px 6px rgba(0,0,0,0.05);
    margin-bottom:25px;
    display:flex;
    justify-content:space-between;
}

/* ===== Cards ===== */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.card{
    background:var(--card);
    padding:25px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    text-align:center;
}

.card h3{
    margin:10px 0;
    font-size:28px;
    color:var(--primary);
}

/* ===== Tables ===== */
.section{
    background:#fff;
    padding:20px;
    border-radius:10px;
    margin-bottom:30px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

table{
    width:100%;
    border-collapse:collapse;
}

table th, table td{
    padding:10px;
    border-bottom:1px solid var(--border);
    font-size:14px;
}

table th{
    text-align:left;
    background:#f9fafc;
}

.btn{
    padding:5px 10px;
    border:none;
    border-radius:4px;
    cursor:pointer;
    font-size:12px;
}

.btn-danger{
    background:#dc3545;
    color:#fff;
}

.btn-danger:hover{
    opacity:0.8;
}

@media(max-width:768px){
    .sidebar{display:none;}
}
</style>

</head>
<body>

<div class="dashboard">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="projects.php">Projects</a>
        <a href="bids.php">Bids</a>
        <a href="../auth/logout.php">Logout</a>
    </div>

    <!-- Main -->
    <div class="main">

        <div class="topbar">
            <h2>Admin Dashboard</h2>
            <div>Welcome Admin</div>
        </div>

        <!-- Stats Cards -->
        <div class="cards">
            <div class="card">
                <h3><?php echo $total_users['total']; ?></h3>
                <p>Total Users</p>
            </div>

            <div class="card">
                <h3><?php echo $total_projects['total']; ?></h3>
                <p>Total Projects</p>
            </div>

            <div class="card">
                <h3><?php echo $total_bids['total']; ?></h3>
                <p>Total Bids</p>
            </div>
        </div>

        <div class="section">
    <h3>Clients List</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Total Projects</th>
        </tr>

        <?php while($c = mysqli_fetch_assoc($clients)){ ?>
        <tr>
            <td><?php echo htmlspecialchars($c['name']); ?></td>
            <td><?php echo htmlspecialchars($c['email']); ?></td>
            <td><?php echo $c['total_projects']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

        <!-- Recent Projects -->
<div class="section">
    <h3>Developers List</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Total Bids</th>
        </tr>

        <?php while($d = mysqli_fetch_assoc($developers)){ ?>
        <tr>
            <td><?php echo htmlspecialchars($d['name']); ?></td>
            <td><?php echo htmlspecialchars($d['email']); ?></td>
            <td><?php echo $d['total_bids']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

    </div>
</div>

</body>
</html>