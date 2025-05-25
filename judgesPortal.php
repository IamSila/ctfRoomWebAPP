<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judges Management</title>

    <!-- cdn link for all favicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="src/css/admin1.css">

    <style>
        table {
            width: 100%;
            font-size: 16px;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: black;
            color: white;
            position: sticky;
            top: 0;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr {
            transition: 1s;
        }
        tr:hover {
            transform: scale(1.02);
            background-color: gray;
            color: white;
        }
        .profilePhoto {
            height: 10px;
            width: 10px;
            border-radius: 50%;
        }
        .present {
            color: green;
        }
        .absent {
            color: red;
        }
        .late {
            color: orange;
        }
        .status-select {
            padding: 3px;
        }
        table .btn {
            padding: 5px;
            color: white;
            font-size: 14px;
            border-radius: 8px;
            border: none;
            margin-right: 5px;
            transition: 1s;
        }

        table .btn:hover {
            transform: scale(1.15);
        }

        table .btn-update {
            background-color: green;
        }
        table .btn-delete {
            background-color: firebrick;
        }
        table .btn-view {
            background-color: orange;
        }
        table .btn-contact {
            background-color: rgb(0, 132, 255);
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover {
            color: black;
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-submit {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <section id="adminDash">
        <div class="leftSideNav">
            <center><h2>Admin Dashboard</h2></center>
            <div class="sideNavButtons1">
                <ul>
                    <a href="admin1.php"><li><i class="fa-solid fa-rectangle-list"></i>Admin Panel</li></a>
                    <a href="judgesPortal.php"><li><i class="fa-solid fa-rectangle-list"></i>Judge Portal</li></a>
                    <a href="attendanceRecords.php"><li><i class="fa-solid fa-book-open-reader"></i>Player Records</li></a>
                    <a href=""><li><i class="fa-solid fa-chart-line"></i>Analytics</li></a>
                </ul>
            </div>
            <hr>
            <div class="sideNavButtons2">
                <ul>
                    <a href=""><li><i class="fa-solid fa-comments"></i>Notifications</li></a>
                    <a href=""><li><i class="fa-solid fa-circle-question"></i>Help & Support</li></a>
                    <a href=""><li><i class="fa-solid fa-gear"></i>Settings</li></a>
                </ul>
            </div>
        </div>

        <!-- end leftSideNav -->

        <!-- start rightside -->
        <div class="studentQueries">
    <div class="heading">
        <div class="title">
            <h1>Participants Management</h1>
            <div class="actionButtons">
                <!-- <button id="assignPointsBtn" class="btn-add"><i class="fa-solid fa-plus"></i>Assign Points</button> -->
            </div>
        </div>
        <div class="filters">
            <form action="" method="get">
                <label for="category">Participant category: </label>
                <select name="category" id="category">
                    <option value="" selected>All Categories</option>
                    <option value="linux">Linux</option>
                    <option value="software engineering">Software Engineering</option>
                    <option value="binary exploitation">Binary Exploitation</option>
                    <option value="web">Web Security</option>
                    <option value="general">General</option>
                </select>
                <button type="submit">Filter</button>
            </form>
        </div>
    </div>

    <div class="results">
        <h1>All Participants</h1>
        
        <table id="participantsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Category</th>
                    <th>Points</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php
                // Connect to database
                $conn = new mysqli('localhost', 'root', '', 'ctfroom');
                
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                // Process points submission
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign_points'])) {
                    $user_id = $_POST['user_id'];
                    $points = $_POST['points'];
                    
                    $stmt = $conn->prepare("UPDATE users SET points = ? WHERE id = ?");
                    $stmt->bind_param("ii", $points, $user_id);
                    $stmt->execute();
                    $stmt->close();
                    
                    // Refresh the page to show updated points
                    header("Location: ".$_SERVER['PHP_SELF']);
                    exit();
                }
                
                // Build filter query
                $category_filter = "";
                if (isset($_GET['category'])) {
                    $category = $_GET['category'];
                    if (!empty($category)) {
                        $category_filter = " WHERE category = '" . $conn->real_escape_string($category) . "'";
                    }
                }
                
                // Fetch users from database
                $sql = "SELECT id, username, first_name, last_name, email, category, points FROM users" . $category_filter;
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($user['username'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')); ?></td>
                        <td><?php echo htmlspecialchars($user['email'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($user['category'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($user['points'] ?? '0'); ?></td>
                        <td>
                            <button onclick="openPointsModal(<?php echo $user['id']; ?>)" class="btn btn-update">
                                <i class="fa-solid fa-plus"></i> Assign Points
                            </button>
                        </td>
                    </tr>
                    <?php endwhile;
                } else {
                    echo "<tr><td colspan='7'>No participants found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Assign Points Modal -->
<div id="pointsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePointsModal()">&times;</span>
        <h2>Assign Points</h2>
        <form method="POST" action="">
            <input type="hidden" id="user_id" name="user_id">
            <div class="form-group">
                <label for="points">Points (1-100):</label>
                <input type="number" id="points" name="points" min="1" max="100" required>
            </div>
            <button type="submit" name="assign_points" class="form-submit">Save Points</button>
        </form>
    </div>
</div>

<script>
    // Points Modal functionality
    function openPointsModal(userId) {
        document.getElementById("user_id").value = userId;
        document.getElementById("pointsModal").style.display = "block";
    }
    
    function closePointsModal() {
        document.getElementById("pointsModal").style.display = "none";
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById("pointsModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>