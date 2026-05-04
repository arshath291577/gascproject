<?php include 'includes/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreelanceHub - Connect with Top Talent</title>
    <!-- use forward slashes -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- Header -->
 

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1>Find the Perfect Freelancer for Your Project</h1>
            <p>Connect with talented developers, designers, and creators from around the world. Get your projects done
                with confidence.</p>
            <div class="hero-buttons">
                <a href="<?php echo $isLoggedIn ? '#features' : 'auth/register.php'; ?>" class="btn btn-large btn-white">
                    <?php echo $isLoggedIn ? 'Explore Features' : 'Get Started Free'; ?>
                </a>
                <a href="#how-it-works" class="btn btn-large btn-outline">Learn More</a>
            </div>
        </div>
    </section>
    <br>
    <br>
    <br>

    <!-- Features -->
    <section class="features" id="features">
        <h2 class="section-title">Why Choose FreelanceHub?</h2>
        <p class="section-subtitle">Everything you need to succeed in the freelance marketplace</p>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🚀</div>
                <h3>Quick & Easy</h3>
                <p>Post your project in minutes and start receiving bids from qualified freelancers instantly.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3>Secure Payments</h3>
                <p>Your money is protected with our secure escrow system until you're 100% satisfied with the work.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⭐</div>
                <h3>Quality Talent</h3>
                <p>Access thousands of verified professionals with ratings and reviews from real clients.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💬</div>
                <h3>24/7 Support</h3>
                <p>Our dedicated support team is always here to help you succeed on your projects.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3>Smart Matching</h3>
                <p>Our AI-powered system helps you find the perfect freelancer for your specific needs.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Project Management</h3>
                <p>Track progress, manage milestones, and collaborate seamlessly all in one place.</p>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works" id="how-it-works">
        <h2 class="section-title">How It Works</h2>
        <p class="section-subtitle">Get started in three simple steps</p>

        <div class="steps">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Post Your Project</h3>
                <p>Describe your project requirements and set your budget. It takes just a few minutes.</p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h3>Review Proposals</h3>
                <p>Receive bids from talented freelancers. Review their profiles, portfolios, and ratings.</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h3>Start Working</h3>
                <p>Choose the best freelancer and collaborate to bring your project to life.</p>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="stats">
        <div class="stats-grid">
            <div class="stat">
                <h3>50K+</h3>
                <p>Active Freelancers</p>
            </div>
            <div class="stat">
                <h3>100K+</h3>
                <p>Projects Completed</p>
            </div>
            <div class="stat">
                <h3>98%</h3>
                <p>Client Satisfaction</p>
            </div>
            <div class="stat">
                <h3>150+</h3>
                <p>Countries</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="cta-content">
            <h2>Ready to Get Started?</h2>
            <p>Join thousands of satisfied clients and freelancers. Your next great project is just a click away.</p>
            <a href="auth/register.php" class="btn btn-primary btn-large">Create Free Account</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>FreelanceHub</h3>
                <p>Connecting talent with opportunity. Building the future of work, one project at a time.</p>
            </div>
            <div class="footer-section">
                <h3>For Clients</h3>
                <ul>
                    <li><a href="#">Post a Project</a></li>
                    <li><a href="#">Browse Talent</a></li>
                    <li><a href="#">How to Hire</a></li>
                    <li><a href="#">Success Stories</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>For Freelancers</h3>
                <ul>
                    <li><a href="#">Find Work</a></li>
                    <li><a href="#">Build Profile</a></li>
                    <li><a href="#">Resources</a></li>
                    <li><a href="#">Community</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Company</h3>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 FreelanceHub. All rights reserved.</p>
        </div>
    </footer>

    <!-- Welcome popup if logged in -->
    <?php if ($isLoggedIn): ?>
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                alert("Welcome <?php echo ucfirst($role) . ' ' . addslashes($name); ?>!");
            });
        </script>
    <?php endif; ?>
    <style>
        /* ========== GLOBAL RESET & THEME ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #016B61;
            /* Teal/Sea Gradient */
            --primary-dark: #2e3d3d;
            --secondary: #70B2B2;
            /* Teal/Sea Gradient */
            --accent: #E5E9C5;
            /* Teal/Sea Gradient */
            --dark: #313647;
            /* Navy / Sage / Earthy Gradient */
            --light: #faf7ef;
            --gray: #6b7a7a;
            --shadow: rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background: var(--light);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        /* Buttons */
        .btn {
            padding: 0.7rem 1.5rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-outline {
            border: 2px solid var(--primary);
            background: transparent;
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: #fff;
        }

        .btn-white {
            background: #fff;
            color: var(--primary);
        }

        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
        }

        /* ========== HEADER / NAVBAR ========== */
        header {
            background: rgba(3, 47, 47, 0.92);
            box-shadow: 0 2px 10px var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
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
            font-size: 1.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: #faf7ef;
        }

        .nav-links a:hover {
            color: #fff;
        }

        /* ========== HERO SECTION ========== */
 .hero {
    position: relative;
    color: #fff;
    padding: 7rem 2rem 6rem;
    text-align: center;
    background: url("index.png") center/cover no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
}



/* Glass container */
.hero-content {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 50px;
    border-radius: 20px;

    /* Glass Effect */
background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(14px);

    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}
.hero h1,
.hero p {
    text-shadow: 0 3px 15px rgba(0,0,0,0.5);
}

/* Heading */
.hero h1 {
    font-size: 3.2rem;
    margin-bottom: 1.5rem;
    font-weight: 700;
    letter-spacing: 1px;
}

/* Paragraph */
.hero p {
    font-size: 1.2rem;
    margin-bottom: 2.5rem;
    opacity: 0.95;
}

/* Buttons */
.hero-buttons {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Outline button */
.hero .btn-outline {
    border: 2px solid #fff;
    color: #fff;
}

.hero .btn-outline:hover {
    background: #fff;
    color: var(--primary-dark);
}

        /* ========== FEATURES SECTION ========== */
        .features {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
            background: linear-gradient(135deg,
                    #2e3d3d,
                    #2f5f63,
                    #2f5f63,
                    #f7e6ac,
                    #faf7ef);
            animation: gradientFlow 12s ease infinite;
            background-size: 400% 400%;
            border-radius: 20px;
        }

        @keyframes gradientFlow {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .section-subtitle {
            text-align: center;
            color: #fffdf6;
            font-size: 1.15rem;
            margin-bottom: 3rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: linear-gradient(135deg, #ffffffcc, #ffffffef);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            transition: 0.3s;
            backdrop-filter: blur(10px);
        }

        .feature-card:hover {
            transform: translateY(-8px);
        }

        .feature-icon {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            background: linear-gradient(135deg, #2e3d3d, #2f5f63, #f7e6ac);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        /* ========== HOW IT WORKS ========== */
        .how-it-works {
            background: #fff;
            padding: 5rem 2rem;
        }

        .steps {
            max-width: 1200px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2.5rem;
        }

        .step {
            text-align: center;
        }

        .step-number {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: bold;
            font-size: 1.4rem;
        }

        /* ========== STATS ========== */
        .stats {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            text-align: center;
            padding: 4rem 2rem;
        }

        .stats-grid {
            max-width: 1200px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 2rem;
        }

        .stat h3 {
            font-size: 2.5rem;
        }

        /* ========== CTA SECTION ========== */
        .cta {
            padding: 5rem 2rem;
            background: var(--light);
            text-align: center;
        }

        .cta-content {
            max-width: 700px;
            margin: auto;
        }

        /* ========== FOOTER ========== */
        footer {
            background: var(--dark);
            color: #fff;
            padding: 3rem 2rem 1.5rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
        }

        .footer-section a {
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-section a:hover {
            color: #fff;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            color: rgba(255, 255, 255, 0.7);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.3rem;
            }

            .nav-links {
                gap: 1rem;
                font-size: 0.9rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .section-title {
                font-size: 1.8rem;
            }
        }
    </style>

</body>

</html>