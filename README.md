# Project Overview

This is a LAMP (Linux, Apache, MySQL, PHP) stack web application. The main aim of the project was to create a web application that has a user interface where they can see the scoreboard of all other players ranked from top to bottom according to points of each player. It also has an admin panel where an admin can add a judge who has the privileges of assigning marks to individual players and players can be filtered depending on the category they participate in e.g linux, binary exploitation, software Engineering. The project includes a web interface connected to a MySQL database managed through XAMPP, but I have hosted the application for easy demonstration.

# application link: http://1133f68.dcomhost.com/ctfRoom/dashboard.php

# Manual configuration

## Prerequisites

Before you begin, ensure you have the following installed:

    XAMPP (includes Apache, MySQL, and PHP)

    Git (for cloning the repository)

    A modern web browser i.e chrome, brave, firefox.
# Setup Instructions
## 1. Clone the Repository

git clone https://github.com/IamSila/ctfRoomWebAPP.git

cd ctfRoomWebAPP

## 2. Start XAMPP Services
On linux run the commands

```bash
sudo /etc/init.d/Apache2 stop
sudo /opt/lampp/lampp start
```

These commands should start all the required services(mysql, apache2 and ProFTPD)

Launch the XAMPP Control Panel - Navigate to http://localhost/dashboard to see the xampp interface.
Start the Apache and MySQL services
Verify they're running (the module names will turn green)

## 3. Import the Database

Open phpMyAdmin in your browser: http://localhost/phpmyadmin

Create a new database named ctfroom

You can use the command below;

```sql
CREATE DATABASE IF NOT EXISTS ctfroom;
```

Navigate to Databases folder. I have provided a database named ctfroom.sql. Import the SQL file into the database you created above(ctfroom). It will populate all the required tables.

## 4. Configure Database Connection

Edit the database configuration file ( /includes/config.php in the project root):
Edit the lines to match these ones;

```php
$host = 'localhost';
$dbname = 'ctfroom';
$username = 'root';  // default XAMPP username
$password = '';      // default XAMPP password (empty)

```

under scoreboard.php --> responsible for showing the scoreboard table, edit the db configuration to match this

```php
$db_host = 'localhost';
$db_name = 'ctfroom';
$db_user = 'root';
$db_pass = '';
```

under admin.php --> responsible for adding judges into the system, in line 201, edit the db configuration to match this

```php
 $conn = new mysqli('localhost', 'root', '', 'ctfroom');
```

under judgesPortal.php --> responsible for assigning points to the players, in line 203, edit the db configuration to match this

```php
$conn = new mysqli('localhost', 'root', '', 'ctfroom');
```

## 5. Deploy the Project

Copy all project files to your XAMPP htdocs folder (usually C:\xampp\htdocs\ctfRoomWebAPP on Windows or /opt/lampp/htdocs/ctfRoomWebAPP). I used linux on my case.

## 6. Access the Application

Open your web browser and navigate to:

http://localhost/ctfRoomWebAPP/dashboard.php

Project Navigation

Once the application is running:

dashboard.php ->Is the main entry point with overview and navigation

Login/Register ->  Authentication is not required for this project, but the authentication files are ready.

Main Features: After navigation to dashboard.php, there are links on the side nav to core features. Admin Panel, score board . Under admin panel we have judges portal where you can add students marks and admin panel where judges can be added to the system.

Admin Panel: To access admin panel, first navigate to dashboard.php. On the side bar we have a link which will take you to admin panel. There you will find all the features.


# The application is also hosted and can be accessed via via this link: http://1133f68.dcomhost.com/ctfRoom/dashboard.php

# Troubleshooting

Connection issues: Verify XAMPP services are running and credentials in config file match your setup

404 errors: Ensure files are in the correct htdocs subfolder

Database errors: Confirm the SQL file was imported correctly


# Database Structure Choices;

1. Used a simple users table with essential columns (id, username, first_name, last_name, category, points)

2. Included points as a dedicated column for easy sorting/ranking

3. Added category for filtering capability

4. Normalized structure for basic user data storage

## PHP Constructs Used;

1. Prepared statements (prepare() + bindParam()) for security against SQL injection

2. try-catch blocks for robust error handling

3. fetchAll(PDO::FETCH_ASSOC) for clean array output

# What to add to the system
1. Add a challenges section where players can participate in challenges and add points to their score board automatically.
2. Work on the profile page and add a page for updating the profile page
3. Add a user specific button that fetches their scores from the database.
4. Integrate secure login and profile registration pages.