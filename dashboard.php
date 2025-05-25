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
                <a href="dashboard.php" class="logo"><img src="src/images/logo.png" alt=""></a>
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
                        <li><a href="planning.php">Score Board</a></li>
                        <li><a href="scoreboard.php">Messages</a></li>
                        <li><a href="profile.php">Profile and Settings</a></li>
                        <!-- <li><a href="logout.php">logout</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
        <!-- end div-section-left -->

        <!-- start div-section-center -->
        <div class="dash-section-center">
            <div class="summary-heading">
                <h2>Summary</h2>
                <select name="semester" id="semester">
                    <option value="1">Cyber Security</option>
                    <option value="2">Software Development</option>
                    <option value="2">Linux</option>
                    <option value="2">Binary Exploitation</option>
                    <option value="2">General Computing</option>
                    <option value="2">Cryptography</option>
                </select>
            </div>
    
            <div class="summary-container">
                <div class="summary-box">
                    <h2>Attempted CTFs</h2>
                    <div class="summary">
                        <img src="src/images/icons/try.png" alt="">
                        <h2><span>20</span>/20</h2>
                        <p>100%</p>
                    </div>
                    <p>Solve challenges to upskill</p>
                </div>
                <div class="summary-box">
                    <h2>Solved CTFs</h2>
                    <div class="summary">
                        <img src="src/images/icons/trophy.png" alt="">
                        <h2><span>19</span>/20 Challenges</h2>
                        <p>100%</p>
                    </div>
                    <p>Don't forget about your next challenge</p>
                </div>
                <div class="summary-box">
                    <h2>Ranking</h2>
                    <div class="summary">
                        <img src="src/images/icons/rank.png" alt="">
                        <h2><span>85</span>/100 players</h2>
                        <p>100%</p>
                    </div>
                    <p>There is no too late, start now.</p>
                </div>
            </div>
        
            <div class="schedule-container">
                <div class="schedule-heading">
                    <h2>My Schedule</h2>
                </div>
    
                <div class="calender-events">
                    <div>
                        <div class="calendar-header" style="display: flex; justify-content: center; align-items: center; ">
                            <button id="prevMonthBtn" style="border-radius: 4px; padding: 5px; margin: 5px; background-color: rgb(15, 10, 90); color: white; text-align: center; display: inline-block;">Prev</button>
                            <center style="background-color: rgb(15, 10, 90); padding: 5px; font-size: 25px; border-radius: 8px; color: white;" id="monthName"></center>
                            <button id="nextMonthBtn" style="border-radius: 4px; padding: 5px; margin: 5px; background-color: rgb(15, 10, 90); color: white; text-align: center; display: inline-block;">Next</button>
                        </div>
                        <div id="calendar" style="height: 400px; width: 400px; margin: 10px; border-radius: 2px; box-shadow: 0 0 1px 3px rgb(197, 194, 194);">
                        </div>
                    </div>
                    
                    <div class="events">
                        <div class="event-box">
                            <h3 class="event-name">No CTF challenge at this time</h3>
                            <div class="event-time">
                                <p></p>
                                <p></p>
                            </div>
                            <a href="#" class="mark-attendance-btn-container">
                                <button class="mark-attendance-btn" disabled>No challenge to play</button>
                            </a>
                        </div>
    
                        <div class="event-box">
                            <h3 class="event-name">No CTF challenge at this time</h3>
                            <div class="event-time">
                                <p></p>
                                <p></p>
                            </div>
                            <a href="#" class="mark-attendance-btn-container">
                                <button class="mark-attendance-btn" disabled>No challenge to play</button>
                            </a>
                        </div>
    
                        <div class="event-box">
                            <h3 class="event-name">No CTF challenge at this time</h3>
                            <div class="event-time">
                                <p></p>
                                <p></p>
                            </div>
                            <a href="#" class="mark-attendance-btn-container">
                                <button class="mark-attendance-btn" disabled>No challenge to play</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end div-section-center -->

        <div class="dash-section-right">
            <div class="teacher-events-container">
                <div class="teachers">
                    <h2>Challenge Instructors and availabe Mentors</h2>
                    <?php
                    // Fetch teachers from database
                    $teachers = []; // Replace with actual database query
                    if (empty($teachers)) {
                        // Default teacher data if none found
                        $teachers = [
                            ['name' => 'ctfRoom', 'subject' => 'All Round', 'email' => 'silamulingi@gmail.com'],
                            ['name' => 'r3c0n', 'subject' => 'all things security', 'email' => 'silamulingi@gmail.com'],
                            ['name' => 'Sila Mulingi', 'subject' => 'Programming and Security', 'email' => 'silamulingi@gmail.com']
                        ];
                    }
                    
                    foreach ($teachers as $teacher): ?>
                    <div class="teacher-box">
                        <img src="src/images/profiles/ctfroom.png" alt="">
                        <span><h2><?php echo htmlspecialchars($teacher['name']); ?></h2>
                        <br>
                        <p><?php echo htmlspecialchars($teacher['subject']); ?></p></span>
                        <a href="mailto:<?php echo htmlspecialchars($teacher['email']); ?>"><i class="fa-solid fa-envelope-open-text"></i></a>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="events">
                    <h2>Up-Coming CTF Events</h2>
                    <?php
                    // Fetch events from database
                    $events = []; // Replace with actual database query
                    if (empty($events)) {
                        // Default event data if none found
                        $events = [
                            ['title' => 'Coding: what is it eaten with', 'date' => '11.6.2025', 'time' => '14.00pm', 'image' => 'event1.jpg'],
                            ['title' => 'Hacking: Api security: BOLA', 'date' => '30.5.2025', 'time' => '14.00pm', 'image' => 'event2.jpg'],
                            ['title' => 'Security: Writing safe code', 'date' => '15.6.2025', 'time' => '14.00pm', 'image' => 'event3.jpg'],
                            ['title' => 'Coding: what is it eaten with', 'date' => '10.7.2025', 'time' => '08.00pm', 'image' => 'event4.jpg']
                        ];
                    }
                    
                    foreach ($events as $event): ?>
                    <div class="event-box">
                        <div class="image">
                            <img src="images/dashboard/<?php echo htmlspecialchars($event['image']); ?>" alt="">
                        </div>

                        <div class="title">
                            <h2><?php echo htmlspecialchars($event['title']); ?></h2>
                            <div class="time">
                                <p><?php echo htmlspecialchars($event['date']); ?></p>
                                <p><?php echo htmlspecialchars($event['time']); ?></p>
                                <a href=""><i class="fa-solid fa-ellipsis-vertical"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
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