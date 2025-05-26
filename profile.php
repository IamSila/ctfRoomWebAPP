<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Start session and include necessary files
session_start();
require_once 'includes/config.php'; // Assuming you have a config file for database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="src/css/dashProfile.css">
    <link rel="stylesheet" href="src/css/profile.css">
    
</head>
<body>
    <section id="section-heading">
        <div class="heading-container">
            <div class="left">
                <a href="home.php" class="logo"><img src="images/logo.png" alt=""></a>
                <h2>Player Dashboard, Welcome.</h2>
                <form action="" method="post">
                    <input type="search" name="search" id="search" placeholder="Search">
                    <input type="submit" value="search">
                </form>
            </div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="right">
                    <a href=""><i class="fa-solid fa-bell"></i></a>
                    <img src="images/dashboard/profile.png" alt="">
                    <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                    <a href="logout.php" class="logout">logout</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section id="dash-section">
        <!-- start div-section-left -->
        <div class="dash-section-left">
            <div class="side-container">
                <img src="lab/webcam_settings(1).png" alt="">
    
                <div class="side-bar">
                    <ul>
                        <li><a href="admin.php">Admin Panel</a></li>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <!-- <li><a href="teachers.php">Teachers</a></li>
                        <li><a href="classes.php">My classes</a></li> -->
                        <!-- <li><a href="planning.php">Schedule</a></li> -->
                        <li><a href="scoreboard.php">Score Board</a></li>
                        <li><a href="profile.php">Profile and Settings</a></li>
                        <!-- <li><a href="logout.php">logout</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
        <!-- end div-section-left -->

        <!-- start div-section-center -->
        
        <!-- end div-section-center -->

        <div class="dash-section-right">
                <div class="profile-container">
                    <div class="profile-header">
                        <h1>My Profile</h1>
                        <div class="profile-info">
                            <div class="profile-name">
                                <h2>{{student}}</h2>
                                <p>{{student.course}}</p>
                                <p>Machakos</p>
                            </div>
                        </div>
                    </div>

                <div class="personal-info">
                    <h2 class="section-title">Personal Information</h2>
                    <div class="info-group">
                        <div class="info-row">
                            <div class="info-label">First Name</div>
                            <div class="info-label">Middle Name</div>
                            <div class="info-label right">Last Name</div>
                        </div>
                        <div class="info-row">
                            <div class="info-value">{{student.first_name}}</div>
                            <div class="info-value">{{student.middle_name}}</div>
                            <div class="info-value">{{student.last_name}}</div>
                        </div>
                    </div>

                    <div class="info-group">
                        <div class="info-row">
                            <div class="info-label">Email address</div>
                            <div class="info-label">Phone</div>
                        </div>

                        <div class="info-row">
                            <div class="info-value">{{student.email}}</div>
                            <div class="info-value">{{student.phone}}</div>
                        </div>
                    </div>
                </div>

                <div class="address-section">
                    <h2 class="section-title">Course Details</h2>
                    <div class="info-group">
                        <div class="info-row">
                            <div class="info-label">School</div>
                            <div class="info-label right">Course</div>
                        </div>
                        <div class="info-row">
                            <div class="info-value">Engineering and Technology</div>
                            <div class="info-value">Computer Science</div>
                        </div>
                    </div>

                    <div class="info-group">
                        <div class="info-row">
                            <div class="info-label">Reg Number</div>
                            <div class="info-label right">Year of Study</div>
                        </div>
                        <div class="info-row">
                            <div class="info-value">{{student.username}}</div>
                            <div class="info-value">4</div>
                        </div>
                    </div>
                </div>

                <a href="" style="text-decoration: none;"><button class="edit-button">Edit</button></a>
            </div>
        </div>
    </section>

    
</body>
</html>