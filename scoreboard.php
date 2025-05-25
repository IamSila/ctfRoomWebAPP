<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Database configuration - replace with your actual credentials
$db_host = 'localhost';
$db_name = 'ctfroom';
$db_user = 'root';
$db_pass = '';

// Create database connection
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch all users ordered by points (descending)
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$query = "SELECT id, username, first_name, last_name, category, points FROM users";

if (!empty($category_filter)) {
    $query .= " WHERE category = :category";
}

$query .= " ORDER BY points DESC";

try {
    $stmt = $pdo->prepare($query);
    
    if (!empty($category_filter)) {
        $stmt->bindParam(':category', $category_filter);
    }
    
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching users: " . $e->getMessage());
}

// Get unique categories for filter dropdown
$categories = [];
try {
    $stmt = $pdo->query("SELECT DISTINCT category FROM users WHERE category IS NOT NULL");
    $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Continue even if categories can't be fetched
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTF Scoreboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
    --primary-dark: #0a0a0a;
    --primary-accent: #00ff00;
    --secondary-accent: #ff3333;
    --neutral-light: #ffffff;
    --neutral-mid: #e0e0e0;
    --neutral-dark: #333333;
    --success: #00cc66;
    --warning: #ffcc00;
    --danger: #ff3333;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Courier New', monospace;
}

body {
    background-color: var(--primary-dark);
    color: var(--neutral-light);
    line-height: 1.6;
}

/* Header Styles */
#section-heading {
    background-color: var(--primary-dark);
    border-bottom: 1px solid var(--primary-accent);
    padding: 1rem 2rem;
}

.heading-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1400px;
    margin: 0 auto;
}

.left {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.logo img {
    height: 50px;
    filter: invert(1) hue-rotate(90deg);
}

h2 {
    color: var(--neutral-light);
    font-size: 1.5rem;
    font-weight: 600;
}

form {
    display: flex;
    gap: 0.5rem;
}

input[type="search"] {
    padding: 0.5rem 1rem;
    border: 1px solid var(--primary-accent);
    background-color: var(--primary-dark);
    color: var(--neutral-light);
    border-radius: 4px;
    min-width: 250px;
}

input[type="submit"] {
    padding: 0.5rem 1rem;
    background-color: var(--primary-accent);
    color: var(--primary-dark);
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s;
}

input[type="submit"]:hover {
    background-color: var(--neutral-light);
}

.right {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.right img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid var(--primary-accent);
}

.right h3 {
    color: var(--neutral-light);
    font-size: 1rem;
}

.logout {
    color: var(--secondary-accent);
    font-weight: bold;
}

/* Main Dashboard Layout */
#dash-section {
    display: grid;
    grid-template-columns: 250px 1fr;
    max-width: 1800px;
    margin: 0 auto;
    min-height: calc(100vh - 82px);
}

/* Sidebar Styles */
.dash-section-left {
    background-color: var(--neutral-dark);
    padding: 1.5rem;
    border-right: 1px solid var(--primary-accent);
}

.side-container {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.side-container img {
    width: 100%;
    border: 1px solid var(--primary-accent);
    border-radius: 4px;
}

.side-bar ul {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.side-bar li a {
    display: block;
    padding: 0.75rem 1rem;
    color: var(--neutral-light);
    border-left: 3px solid transparent;
    transition: all 0.3s;
}

.side-bar li a:hover,
.side-bar li a.active {
    background-color: rgba(0, 255, 0, 0.1);
    border-left: 3px solid var(--primary-accent);
    color: var(--primary-accent);
}

/* Scoreboard Styles */
.dash-section-right {
    padding: 2rem;
    background-color: var(--primary-dark);
}

.scoreboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--primary-accent);
}

.scoreboard-title {
    font-size: 1.8rem;
    color: var(--primary-accent);
}

.category-filter {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.category-filter label {
    color: var(--neutral-mid);
}

.category-filter select {
    padding: 0.5rem 1rem;
    background-color: var(--neutral-dark);
    color: var(--neutral-light);
    border: 1px solid var(--primary-accent);
    border-radius: 4px;
}

.category-filter button {
    padding: 0.5rem 1rem;
    background-color: var(--neutral-dark);
    color: var(--primary-accent);
    border: 1px solid var(--primary-accent);
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s;
}

.category-filter button:hover {
    background-color: var(--primary-accent);
    color: var(--neutral-dark);
}

.scoreboard-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.scoreboard-table th {
    background-color: var(--neutral-dark);
    color: var(--primary-accent);
    padding: 1rem;
    text-align: left;
    border-bottom: 2px solid var(--primary-accent);
}

.scoreboard-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--neutral-dark);
}

.scoreboard-table tr:nth-child(even) {
    background-color: rgba(0, 255, 0, 0.05);
}

.scoreboard-table tr:hover {
    background-color: rgba(0, 255, 0, 0.1);
}

.rank {
    font-weight: bold;
    color: var(--primary-accent);
    width: 50px;
    text-align: center;
}

.username {
    font-weight: bold;
}

.name {
    color: var(--neutral-mid);
}

.category {
    text-transform: capitalize;
}

.points {
    font-weight: bold;
    text-align: right;
    color: var(--primary-accent);
}

.first-place {
    background-color: rgba(255, 215, 0, 0.1) !important;
    border-left: 4px solid gold;
}

.second-place {
    background-color: rgba(192, 192, 192, 0.1) !important;
    border-left: 4px solid silver;
}

.third-place {
    background-color: rgba(205, 127, 50, 0.1) !important;
    border-left: 4px solid #cd7f32;
}

/* Responsive Design */
@media (max-width: 768px) {
    #dash-section {
        grid-template-columns: 1fr;
    }

    .dash-section-left {
        display: none;
    }

    .scoreboard-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}
    </style>
    
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
        <!-- Sidebar -->
        <div class="dash-section-left">
            <div class="side-container">
                <img src="lab/webcam_settings(1).png" alt="">
                <div class="side-bar">
                    <ul>
                        <li><a href="admin.php">Admin Panel</a></li>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="scoreboard.php" class="active">Score Board</a></li>
                        <li><a href="profile.php">Profile and Settings</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Scoreboard Content -->
        <div class="dash-section-right">
            <div class="scoreboard-header">
                <h1 class="scoreboard-title">CTF Scoreboard</h1>
                <form method="get" class="category-filter">
                    <label for="category">Filter by Category:</label>
                    <select name="category" id="category">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>" 
                                <?php echo ($category_filter === $cat) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Apply</button>
                </form>
            </div>

            <table class="scoreboard-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Player</th>
                        <th>Category</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">No players found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $index => $user): ?>
                            <tr class="<?php 
                                echo ($index === 0) ? 'first-place' : '';
                                echo ($index === 1) ? 'second-place' : '';
                                echo ($index === 2) ? 'third-place' : '';
                            ?>">
                                <td class="rank"><?php echo $index + 1; ?></td>
                                <td>
                                    <span class="username"><?php echo htmlspecialchars($user['username']); ?></span><br>
                                    <span class="name"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></span>
                                </td>
                                <td class="category"><?php echo htmlspecialchars($user['category'] ?? 'N/A'); ?></td>
                                <td class="points"><?php echo htmlspecialchars($user['points']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>