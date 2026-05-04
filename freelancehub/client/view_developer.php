<?php
session_start();
require_once '../config/db.php';

$developer_id = isset($_GET['developer_id']) ? (int)$_GET['developer_id'] : 0;
$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : 0;

if($developer_id<=0){
die("Invalid Developer");
}

$dev = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT u.name,dp.*
FROM users u
LEFT JOIN developer_profiles dp
ON u.id = dp.user_id
WHERE u.id=$developer_id
")
);

/* Count completed projects (optional) */
$count = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM bids
WHERE developer_id=$developer_id
")
);
?>
<!DOCTYPE html>
<html>
<head>
<title>Developer Profile</title>

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

<div class="profile-header">
    <div class="avatar">
        <?php echo strtoupper(substr($dev['name'],0,1)); ?>
    </div>
    <h2><?php echo htmlspecialchars($dev['name']); ?></h2>
</div>

<div class="profile-body">

    <div class="section">
        <h3>Skills</h3>
        <div class="skills">
            <?php
            $skills = explode(',', $dev['skills']);
            foreach($skills as $skill){
                echo '<span class="skill-tag">'.htmlspecialchars(trim($skill)).'</span>';
            }
            ?>
        </div>
    </div>

    <div class="section">
        <h3>Experience</h3>
        <p><?php echo htmlspecialchars($dev['experience']); ?></p>
    </div>

    <div class="section">
        <h3>About</h3>
        <p><?php echo nl2br(htmlspecialchars($dev['bio'])); ?></p>
    </div>

    <div class="section">
        <h3>Portfolio</h3>
        <?php if(!empty($dev['portfolio_link'])): ?>
            <a class="portfolio-btn" 
               href="<?php echo htmlspecialchars($dev['portfolio_link']); ?>" 
               target="_blank">
               View Portfolio
            </a>
        <?php else: ?>
            <p>No portfolio added.</p>
        <?php endif; ?>
    </div>

    <div class="stat">
        Total Bids Placed: <?php echo $count['total']; ?>
    </div>

</div>
<a href="project_bids.php?project_id=<?php echo $project_id; ?>">
    <button style="margin-top:20px;padding:8px 15px;background:#016B61;color:white;border:none;border-radius:6px;">
        ← Back to Bids
    </button>
</a>
</div>


</body>
</html>
