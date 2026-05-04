<?php
session_start();
require_once '../config/db.php';

$developer_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

$success = '';
$error   = '';

/* Fetch developer profile */
$dev_profile = mysqli_fetch_assoc(
    mysqli_query($conn, "
        SELECT dp.*, u.name 
        FROM developer_profiles dp
        JOIN users u ON dp.user_id = u.id
        WHERE dp.user_id = $developer_id
    ")
);

/* =====================================================
   HANDLE BID SUBMISSION (NO CHANGE – LOGIC IS CORRECT)
   ===================================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_bid'])) {

    $project_id = (int)$_POST['project_id'];
    $amount     = (float)$_POST['bid_amount'];
    $days       = (int)$_POST['delivery_time'];
    $letter     = trim($_POST['cover_letter']);

    if ($project_id > 0 && $amount > 0 && $days > 0 && $letter != '') {

        $letter_esc = mysqli_real_escape_string($conn, $letter);

        $sql = "INSERT INTO bids 
                (project_id, developer_id, amount, delivery_days, cover_letter)
                VALUES (
                    $project_id,
                    $developer_id,
                    $amount,
                    $days,
                    '$letter_esc'
                )";

        if (mysqli_query($conn, $sql)) {
            $success = "Bid placed successfully!";
        } else {
            $error = "Insert failed: " . mysqli_error($conn);
        }
    } else {
        $error = "All fields are required.";
    }
}

/* =====================================================
   FETCH ALL PROJECTS (NO CHANGE)
   ===================================================== */
$projects = array();
$where = array();
$order = "created_at DESC";

/* SEARCH */
if(isset($_GET['search']) && $_GET['search'] != ""){
    $s = mysqli_real_escape_string($conn,$_GET['search']);
    $where[] = "(title LIKE '%$s%' OR description LIKE '%$s%')";
}

/* CATEGORY */
if(isset($_GET['category']) && $_GET['category'] != ""){
    $c = mysqli_real_escape_string($conn,$_GET['category']);
    $where[] = "category='$c'";
}

/* BUDGET */
if(isset($_GET['budget']) && $_GET['budget'] != ""){

    if($_GET['budget']=="low"){
        $where[] = "max_budget < 5000";
    }

    if($_GET['budget']=="mid"){
        $where[] = "max_budget BETWEEN 5000 AND 20000";
    }

    if($_GET['budget']=="high"){
        $where[] = "max_budget > 20000";
    }
}

/* SORT */
if(isset($_GET['sort'])){
    if($_GET['sort']=="low"){
        $order="max_budget ASC";
    }

    if($_GET['sort']=="high"){
        $order="max_budget DESC";
    }
}

/* MAIN QUERY */
$sql = "SELECT * FROM projects";

/* APPLY FILTER */
if(!empty($where)){
    $sql .= " WHERE ".implode(" AND ",$where);
}

/* ORDER */
$sql .= " ORDER BY $order";

/* RUN QUERY */
$res = mysqli_query($conn,$sql);

/* FETCH RESULTS */
while($row = mysqli_fetch_assoc($res)){
    $projects[] = $row;
}       

/* =====================================================
   ✅ NEW: FETCH SINGLE PROJECT FOR BID PAGE
   (FIXES $p UNDEFINED ERROR)
   ===================================================== */
$selected_project = null;

if (isset($_GET['bid'])) {
    $bid_id = (int)$_GET['bid'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM projects WHERE id = $bid_id LIMIT 1"
    );

    if ($result && mysqli_num_rows($result) === 1) {
        $selected_project = mysqli_fetch_assoc($result);
    }
}


$already_bid = false; // ✅ DEFAULT VALUE (IMPORTANT)



/* =====================================================
   ❌ REMOVED WRONG CODE
   -----------------------------------------------------
   $pid = (int)$p['id'];   ❌ $p DOES NOT EXIST HERE
   -----------------------------------------------------
   This logic MUST be inside foreach loop in HTML
   ===================================================== */
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Browse Projects</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            background: #f5f7fb;
            color: #333;
        }

        .app {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: #ffffff;
            padding: 25px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        }

        .logo {
            color: #6c63ff;
            margin-bottom: 30px;
        }

        .sidebar nav a {
            display: block;
            padding: 12px;
            margin-bottom: 8px;
            color: #555;
            text-decoration: none;
            border-radius: 8px;
        }

        .sidebar nav a.active,
        .sidebar nav a:hover {
            background: #eef0ff;
            color: #6c63ff;
        }

        /* Main */
        .main {
            flex: 1;
            padding: 30px;
        }

        /* Header */
        .header-card {
            background: white;
            padding: 30px;
            border-radius: 14px;
            margin-bottom: 25px;
        }

        .header-card h1 {
            font-size: 26px;
        }

        .header-card p {
            color: #777;
            margin-top: 5px;
        }

        /* Filters */
        .filters {
            background: white;
            padding: 20px;
            border-radius: 14px;
            display: grid;
            grid-template-columns: 2fr repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .filters input,
        .filters select {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        /* Project Card */
        .project-card {
            background: white;
            padding: 25px;
            border-radius: 16px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .project-info h3 {
            margin-bottom: 6px;
        }

        .posted {
            font-size: 13px;
            color: #888;
        }

        .project-info p {
            margin: 15px 0;
            color: #555;
        }

        .tags span {
            background: #eef0ff;
            color: #6c63ff;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-right: 8px;
        }

        /* Right Side */
        .project-side {
            text-align: right;
            min-width: 160px;
        }

        .price {
            color: #2ecc71;
            font-size: 22px;
            font-weight: bold;
        }

        .price small {
            display: block;
            color: #777;
            font-size: 13px;
        }

        .primary {
            margin-top: 15px;
            padding: 10px 18px;
            background: #2ecc71;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .disabled {
            margin-top: 15px;
            padding: 10px 18px;
            background: #ccc;
            border: none;
            border-radius: 8px;
            cursor: not-allowed;
        }
    </style>

</head>

<body>

    <div class="app">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2 class="logo">FreelanceHub</h2>
            <nav>
                <a href="#">Dashboard</a>
                <a class="active" href="#">Browse Projects</a>
                <a href="#">My Bids</a>
                <a href="#">Active Projects</a>
                <a href="#">Messages</a>
                <a href="#">Earnings</a>
                <a href="#">Settings</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main">
            <!-- Header -->
            <section class="header-card">
                <h1>Browse Projects</h1>
                <p>Find the perfect projects that match your skills</p>
            </section>

           <form method="GET">

<section class="filters">

<input type="text" name="search"
placeholder="Search projects..."
value="<?php echo isset($_GET['search'])?$_GET['search']:''; ?>">

<select name="category">
<option value="">All Categories</option>
<option value="web">Web</option>
<option value="app">App</option>
<option value="ai">AI</option>
</select>

<select name="budget">
<option value="">Any Budget</option>
<option value="low">Below 5000</option>
<option value="mid">5000-20000</option>
<option value="high">Above 20000</option>
</select>

<select name="sort">
<option value="">Newest First</option>
<option value="low">Budget Low</option>
<option value="high">Budget High</option>
</select>

<button type="submit">Filter</button>

</section>
</form>

            </section>

            <!-- Project List -->
            <?php foreach ($projects as $p): ?>

                <?php
                $pid = (int)$p['id'];

                // ✅ overwrite default value per project
                $check_bid = mysqli_query(
                    $conn,
                    "SELECT id FROM bids 
         WHERE project_id = $pid 
         AND developer_id = $developer_id"
                );

                $already_bid = ($check_bid && mysqli_num_rows($check_bid) > 0);


                ?>
                <div class="project-card">
                    <div class="project-info">
                        <h3><?php echo htmlspecialchars($p['title']); ?></h3>
                        <span class="posted">Posted recently</span>

                        <p><?php echo nl2br(htmlspecialchars($p['description'])); ?></p>
<div class="tags">

<?php
if(!empty($p['skills'])){

    $skills = explode(',', $p['skills']);

    foreach($skills as $skill){
        echo "<span>".htmlspecialchars(trim($skill))."</span>";
    }

}else{

    echo "<span>MongoDB</span>";
    echo "<span>Node.js</span>";
    echo "<span>React</span>";

}
?>

</div>
                       
                    </div>

                    <div class="project-side">
                       <div class="price">

$<?php echo (int)$p['min_budget']; ?> 
- 
$<?php echo (int)$p['max_budget']; ?>

<small><?php echo htmlspecialchars($p['budget_type']); ?></small>

</div>

                        <?php if ($already_bid): ?>
                            <button class="disabled">Already Bid</button>
                        <?php else: ?>
                            <a href="place_bid.php?project_id=<?php echo (int)$p['id']; ?>">
                               <button class="primary">Place Bid</button>
                           </a>

                        <?php endif; ?>
                        <a href="client_view.php?client_id=<?php echo (int)$p['client_id']; ?>">
    <button style="background:#6c63ff;margin-top:8px;">
        View Client
    </button>
</a>

                    </div>
                </div>
            <?php endforeach; ?>

        </main>
    </div>

</body>


</html>


