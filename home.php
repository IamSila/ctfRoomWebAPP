<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance system</title>
    <link rel="stylesheet" href="src/css/home.css">
    <link rel="stylesheet" href="src/css/profile.css">
    <link rel="stylesheet" href="src/css/dashboard.css">
    <!-- Load an icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
</head>
<body>

    <section id="body-section">
        <section id="section-heading">
            <div class="heading-container">
                <div class="left">
                    <a href="home.php" class="logo"><img src="images/logo.png" alt=""></a>
                    <h2>Welcome.</h2>
                    <form action="" method="post">
                        <input type="search" name="search" id="search" placeholder="Search">
                        <input type="submit" value="search">
                    </form>
                </div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="right">
                        <a href="#"><i class="fa-solid fa-bell"></i></a>
                        <img src="<?php echo htmlspecialchars($_SESSION['user_image'] ?? 'images/default-profile.png'); ?>" alt="">
                        <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                        <a href="logout.php" class="logout">logout</a>
                    </div>
                <?php else: ?>
                <div class="right no-login">
                    <a href="dashboard.php">Dashboard</a>
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                </div>
                <?php endif; ?>
            </div>
        </section>
    
        <section class="section-2">
            <section class="side-nav">
                <div>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <ul>
                            <li><a href="dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
                            <li><a href="planning.php"><i class="fa-regular fa-calendar"></i>My Planning</a></li>
                            <li><a href="profile.php"><i class="fa fa-fw fa-user"></i>Profile and Settings</a></li>
                            <li><a href="markAttendance.php"><i class="fa-solid fa-people-roof fa"></i>Mark Attendance</a></li>
                            <li><a href="myAttendance.php"><i class="fa-solid fa-people-roof"></i>My Attendance</a></li>
                            <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>logout</a></li>
                        </ul>
                    <?php else: ?>
                        <ul>
                            <li><a href="login.php"><i class="fa-solid fa-right-from-bracket"></i>login</a></li>
                            <li><a href="dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
                            <li><a href="markAttendance.php"><i class="fa-solid fa-people-roof"></i>Mark Attendance</a></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </section>
    
            <section class="features">
                <?php 
                // This is where your page-specific content will be included
                if (isset($content)) {
                    include($content);
                }
                ?>
            </section>
        </section>
    </section>

    <script src="js/planning.js"></script>
</body>
</html>
