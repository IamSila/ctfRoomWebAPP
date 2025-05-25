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
                        <li><a href="home.php">Judge's Portal</a></li>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <!-- <li><a href="teachers.php">Teachers</a></li>
                        <li><a href="classes.php">My classes</a></li> -->
                        <li><a href="planning.php">Schedule</a></li>
                        <li><a href="messages.php">Messages</a></li>
                        <li><a href="profile.php">Profile and Settings</a></li>
                        <li><a href="logout.php">logout</a></li>
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

                <a href="{% url 'profileUpdate' user.username %}" style="text-decoration: none;"><button class="edit-button">Edit</button></a>
            </div>
        </div>
    </section>

    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>
    <script>
        const calendar = new tui.Calendar('#calendar', {
            defaultView: 'month',
            useCreationPopup: true,
            useDetailPopup: true,
            calendars: [
                {
                    id: 'cal1',
                    name: 'Personal',
                    backgroundColor: '#03bd9e',
                },
            ],
        });

        // Function to update the month name
        const updateMonthName = () => {
            const date = calendar.getDate();
            const monthName = new Intl.DateTimeFormat('default', { month: 'long' }).format(date);
            document.getElementById('monthName').textContent = monthName;
        };

        // Initial month name update
        updateMonthName();

        // Previous month button
        document.getElementById('prevMonthBtn').addEventListener('click', () => {
            calendar.prev();
            updateMonthName();
        });

        // Next month button
        document.getElementById('nextMonthBtn').addEventListener('click', () => {
            calendar.next();
            updateMonthName();
        });

        // Fetch and display events
        async function fetchAndDisplayEvents() {
            try {
                const response = await fetch('api/tasks.php');
                const events = await response.json();
                
                // Get current date in YYYY-MM-DD format
                const today = new Date();
                const currentDate = today.toISOString().split('T')[0];
                
                // Get username prefix (before hyphen)
                const username = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>";
                const usernamePrefix = username.split('-')[0];
                
                // Filter events for current date and matching course code
                const todayEvents = events.filter(event => {
                    const eventDate = new Date(event.start).toISOString().split('T')[0];
                    // Check if event has courseCode and it matches username prefix
                    const courseCodeMatch = event.courseCode && event.courseCode.startsWith(usernamePrefix);
                    return eventDate === currentDate && courseCodeMatch;
                });
                
                // Get all event boxes
                const eventBoxes = document.querySelectorAll('.events .event-box');
                
                // Update each event box with the fetched data
                todayEvents.slice(0, 3).forEach((event, index) => {
                    if (eventBoxes[index]) {
                        const eventName = eventBoxes[index].querySelector('.event-name');
                        const eventTime = eventBoxes[index].querySelector('.event-time');
                        const markAttendanceBtn = eventBoxes[index].querySelector('.mark-attendance-btn');
                        const markAttendanceLink = eventBoxes[index].querySelector('.mark-attendance-btn-container');
                        
                        if (eventName) {
                            eventName.textContent = event.title || 'No Class during this time';
                        }
                        
                        if (eventTime) {
                            const dateElement = eventTime.querySelector('p:first-child');
                            const timeElement = eventTime.querySelector('p:last-child');
                            
                            if (dateElement) {
                                dateElement.textContent = new Date(event.start).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                            }
                            
                            if (timeElement) {
                                const startTime = new Date(event.start).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                                const endTime = new Date(event.end).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                                timeElement.textContent = `${startTime} - ${endTime}` || 'No Time';
                            }
                        }

                        // Update mark attendance button based on current time
                        if (markAttendanceBtn && markAttendanceLink) {
                            const now = new Date();
                            const classStart = new Date(event.start);
                            const classEnd = new Date(event.end);
                            
                            // Enable button only if current time is between class start and end times
                            if (now >= classStart && now <= classEnd) {
                                markAttendanceBtn.disabled = false;
                                markAttendanceBtn.textContent = 'Mark Attendance';
                                markAttendanceBtn.style.backgroundColor = 'white';
                                markAttendanceBtn.style.color = 'black';
                                markAttendanceLink.href = `mark-attendance.php?event=${encodeURIComponent(event.title)}`;
                            } else {
                                markAttendanceBtn.disabled = true;
                                if (now < classStart) {
                                    markAttendanceBtn.textContent = 'Class not started yet';
                                } else {
                                    markAttendanceBtn.textContent = 'Class already ended';
                                }
                                markAttendanceBtn.style.backgroundColor = '#f0f0f0';
                                markAttendanceBtn.style.color = '#888';
                                markAttendanceLink.href = '#';
                            }
                        }
                    }
                });

                // If no matching events for today, show default message
                if (todayEvents.length === 0) {
                    eventBoxes.forEach(box => {
                        const eventName = box.querySelector('.event-name');
                        const markAttendanceBtn = box.querySelector('.mark-attendance-btn');
                        if (eventName) {
                            eventName.textContent = 'No matching classes today';
                        }
                        if (markAttendanceBtn) {
                            markAttendanceBtn.disabled = true;
                            markAttendanceBtn.textContent = 'No class to mark';
                            markAttendanceBtn.style.backgroundColor = '#f0f0f0';
                            markAttendanceBtn.style.color = '#888';
                        }
                    });
                }
            } catch (error) {
                console.error('Error fetching events:', error);
            }
        }

        // Call the function when the page loads
        fetchAndDisplayEvents();
    </script>
</body>
</html>