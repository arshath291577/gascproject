<?php
session_start();
require_once '../config/db.php';

$user_id = (int)$_SESSION['user_id'];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $skills = mysqli_real_escape_string($conn, $_POST['skills']);
    $exp    = mysqli_real_escape_string($conn, $_POST['experience']);
    $link   = mysqli_real_escape_string($conn, $_POST['portfolio']);
    $bio    = mysqli_real_escape_string($conn, $_POST['bio']);

    $check = mysqli_query($conn, "SELECT id FROM developer_profiles WHERE user_id = $user_id");

    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "
            UPDATE developer_profiles SET
            skills='$skills',
            experience='$exp',
            portfolio_link='$link',
            bio='$bio'
            WHERE user_id=$user_id
        ");
        $success = "Profile updated successfully";
    } else {
        mysqli_query($conn, "
            INSERT INTO developer_profiles (user_id, skills, experience, portfolio_link, bio)
            VALUES ($user_id, '$skills', '$exp', '$link', '$bio')
        ");
        $success = "Profile created successfully";
    }
}

$profile = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM developer_profiles WHERE user_id=$user_id")
);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Developer Profile</title>
    <!-- Uses the SAME CSS as Client Profile -->
</head>

<body>

    <div class="box">
        <h2>Developer Profile</h2>

        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="post">

            <label>Skills</label>
            <input type="text" name="skills"
                placeholder="HTML, CSS, PHP, MySQL"
                value="<?php echo @$profile['skills']; ?>">

            <label>Experience</label>
            <input type="text" name="experience"
                placeholder="e.g. 2 Years"
                value="<?php echo @$profile['experience']; ?>">

            <label>Portfolio Link</label>
            <input type="text" name="portfolio"
                placeholder="https://your-portfolio.com"
                value="<?php echo @$profile['portfolio_link']; ?>">

            <label>About You</label>
            <textarea name="bio"
                placeholder="Tell something about yourself..."><?php
                                                                echo @$profile['bio'];
                                                                ?></textarea>

            <button type="submit">Save Profile</button>
        </form>
    </div>
    <style>
        :root {
            --primary: #016B61;
            --primary-dark: #2e3d3d;
            --secondary: #70B2B2;
            --accent: #E5E9C5;
            --dark: #313647;
            --light: #faf7ef;
            --gray: #6b7a7a;
            --shadow: rgba(0, 0, 0, 0.08);

            /* extra soft colors */
            --soft-bg: #f2f7f6;
            --border: rgba(1, 107, 97, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, var(--light), var(--soft-bg));
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Profile Card */
        .box {
            width: 100%;
            max-width: 650px;
            background: #ffffff;
            padding: 32px;
            border-radius: 14px;
            box-shadow: 0 14px 35px var(--shadow);
            border: 1px solid var(--border);
        }

        /* Title */
        .box h2 {
            text-align: center;
            color: var(--primary);
            margin-bottom: 25px;
            font-size: 24px;
            letter-spacing: 0.5px;
            position: relative;
        }

        .box h2::after {
            content: "";
            display: block;
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            margin: 10px auto 0;
            border-radius: 5px;
        }

        /* Labels */
        label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            color: var(--primary-dark);
            margin-bottom: 6px;
            margin-top: 15px;
        }

        /* Inputs */
        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px 14px;
            font-size: 14px;
            border-radius: 8px;
            border: 1px solid var(--secondary);
            background: var(--light);
            transition: all 0.25s ease;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(1, 107, 97, 0.15);
        }

        /* Button */
        button {
            margin-top: 25px;
            width: 100%;
            padding: 14px;
            font-size: 15px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            color: #ffffff;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            box-shadow: 0 8px 20px rgba(1, 107, 97, 0.3);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(1, 107, 97, 0.35);
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        }

        /* Alerts */
        .success {
            background: #e6f4f1;
            color: var(--primary-dark);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            border-left: 5px solid var(--primary);
            font-size: 14px;
        }

        /* Small screens */
        @media (max-width: 600px) {
            .box {
                margin: 15px;
                padding: 24px;
            }

            .box h2 {
                font-size: 21px;
            }
        }
    </style>

</body>

</html>