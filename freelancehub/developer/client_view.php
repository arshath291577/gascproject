<?php
session_start();
require_once '../config/db.php';

$client_id = isset($_GET['client_id']) ? (int)$_GET['client_id'] : 0;

if($client_id<=0){
die("Invalid Client");
}

/* Fetch client info */
$client = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT u.name,cp.*
FROM users u
LEFT JOIN client_profiles cp
ON u.id = cp.user_id
WHERE u.id=$client_id
")
);

/* Count projects */
$count = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM projects
WHERE client_id=$client_id
")
);
?>
<!DOCTYPE html>
<html>
<head>
<title>Client Profile</title>

<style>
:root{
    --primary:#016B61;
    --primary-dark:#02433d;
    --bg:#f4fbfa;
    --card:#ffffff;
    --text:#313647;
    --muted:#6b7a7a;
    --border:#e3f0ef;
    --success:#5E936C;
}

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:"Segoe UI",Arial,sans-serif;
}

body{
background:linear-gradient(135deg, #f7e6ac 0%, #2f5f63 100%);
padding:50px 20px;
}

/* Profile Card */
.card{
max-width:750px;
margin:auto;
background:var(--card);
border-radius:18px;
overflow:hidden;
box-shadow:0 15px 40px rgba(0,0,0,0.08);
animation:fadeIn .5s ease-in-out;
}

/* Header Section */
.profile-header{
background:linear-gradient(135deg,var(--primary),var(--primary-dark));
padding:40px 30px;
text-align:center;
color:#fff;
position:relative;
}

.avatar{
width:100px;
height:100px;
background:#fff;
color:var(--primary);
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
font-size:36px;
font-weight:bold;
margin:0 auto 15px;
box-shadow:0 5px 15px rgba(0,0,0,0.15);
}

.profile-header h2{
font-size:24px;
letter-spacing:.5px;
}

/* Body */
.profile-body{
padding:30px;
}

.section{
margin-bottom:25px;
}

.section h3{
font-size:16px;
color:var(--primary-dark);
margin-bottom:8px;
border-left:4px solid var(--primary);
padding-left:8px;
}

.section p{
color:var(--text);
line-height:1.6;
}

/* Skills Tags */
.skills{
display:flex;
flex-wrap:wrap;
gap:8px;
}

.skill-tag{
background:#eef2ff;
color:var(--primary-dark);
padding:6px 12px;
border-radius:20px;
font-size:13px;
}

/* Portfolio Button */
.portfolio-btn{
display:inline-block;
margin-top:8px;
padding:8px 14px;
background:var(--success);
color:#fff;
text-decoration:none;
border-radius:8px;
font-size:13px;
transition:.2s;
}

.portfolio-btn:hover{
background:#17a673;
}

/* Stats */
.stat{
background:#f8f9fc;
border:1px solid var(--border);
padding:15px;
border-radius:10px;
text-align:center;
font-weight:600;
color:var(--primary-dark);
}

/* Animation */
@keyframes fadeIn{
from{opacity:0;transform:translateY(10px);}
to{opacity:1;transform:translateY(0);}
}

/* Responsive */
@media(max-width:600px){
.profile-body{padding:20px;}
.profile-header{padding:30px 20px;}
}
</style>

</head>
<body>

<div class="card">

<!-- Header -->
<div class="profile-header">

    <div class="avatar">
        <?php echo strtoupper(substr($client['name'],0,1)); ?>
    </div>

    <h2><?php echo htmlspecialchars($client['name']); ?></h2>

</div>


<!-- Profile Body -->
<div class="profile-body">

    <div class="section">
        <h3>Company</h3>
        <p><?php echo htmlspecialchars(@$client['company_name']); ?></p>
    </div>

  

    <div class="section">
        <h3>Email</h3>
        <p><?php echo nl2br(@$client['address']); ?></p>
    </div>

    <div class="section">
        <h3>About</h3>
        <p><?php echo nl2br(@$client['about']); ?></p>
    </div>


    <!-- Stats -->
    <div class="stat">
        Total Projects Posted: <?php echo $count['total']; ?>
    </div>


    <!-- Back Button -->
    <br>

    <a href="browse_projects.php" class="portfolio-btn">
        ← Back
    </a>

</div>

</div>

</body>
</html>
