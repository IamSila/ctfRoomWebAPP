<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judges Management</title>

    <!-- cdn link for all favicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="src/css/admin.css">

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
                    <a href="dashboard.php"><li><i class="fa-solid fa-book-open-reader"></i>User Dashboard</li></a>
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
                    <h1>Judges Management</h1>
                    <div class="actionButtons">
                        <button id="addJudgeBtn" class="btn-add"><i class="fa-solid fa-plus"></i>Add a Judge</button>
                    </div>
                </div>
                <div class="filters">
                    <form action="" method="get">
                        <label for="course">judge categories: </label>
                        <select name="course" id="course">
                            <option value="" selected>Choose a category</option>
                            <option value="Software Engineering">Software Engineering</option>
                            <option value="linux">linux</option>
                            <option value="Binary Exploitation">Binary Exploitation</option>
                            <option value="Web Security">Web Security</option>
                            <option value="Api Security">Api Security</option>
                        </select>
                        <button type="submit">Fetch</button>
                    </form>
                </div>
            </div>
    
            <div class="results">
                <h1>All Judges</h1>
                
                <table id="attendanceTable">
                    <thead>
                        <tr>
                            <th>Judge ID</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Admin actions</th>
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
                        
                        // Process form submission
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_judge'])) {
                            $username = $_POST['username'];
                            $name = $_POST['name'];
                            $email = $_POST['email'];
                            
                            $stmt = $conn->prepare("INSERT INTO judges (username, name, email) VALUES (?, ?, ?)");
                            $stmt->bind_param("sss", $username, $name, $email);
                            $stmt->execute();
                            $stmt->close();
                            
                            // Refresh the page to show the new record
                            header("Location: ".$_SERVER['PHP_SELF']);
                            exit();
                        }
                        
                        // Fetch judges from database
                        $sql = "SELECT * FROM judges";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while($judge = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($judge['id'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($judge['username'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($judge['name'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($judge['email'] ?? ''); ?></td>
                                <td>
                                    <a href="update.php?id=<?php echo urlencode($judge['id']); ?>" class="btn btn-update">
                                        <i class="fa-solid fa-file-pen"></i>
                                    </a>
                                    <a href="delete.php?id=<?php echo urlencode($judge['id']); ?>" class="btn btn-delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                    <a href="view.php?id=<?php echo urlencode($judge['id']); ?>" class="btn btn-view">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="mailto:<?php echo htmlspecialchars($judge['email']); ?>" class="btn btn-contact">
                                        <i class="fa-solid fa-envelope"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile;
                        } else {
                            echo "<tr><td colspan='5'>No judges found</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Add Judge Modal -->
    <div id="addJudgeModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Judge</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit" name="add_judge" class="form-submit">Add Judge</button>
            </form>
        </div>
    </div>

    <script src="js/admin.js"></script>
    <script>
        // Modal functionality
        const modal = document.getElementById("addJudgeModal");
        const btn = document.getElementById("addJudgeBtn");
        const span = document.getElementsByClassName("close")[0];
        
        btn.onclick = function() {
            modal.style.display = "block";
        }
        
        span.onclick = function() {
            modal.style.display = "none";
        }
        
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>