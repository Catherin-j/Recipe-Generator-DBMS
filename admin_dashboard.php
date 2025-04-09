<?php
// Secure session configurations
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Use only if HTTPS is enabled
ini_set('session.use_strict_mode', 1);
session_start();
include 'db.php';


// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        a {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
        hr {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h2>Welcome Admin!</h2>
    <a href="logout.php">Logout</a>
    <hr>
    <!-- Link to Add a New Recipe -->
    <a href="add_recipe.php">Add New Recipe</a>
    <br><br>
    <!-- Optionally, link to view the recipes list -->
    <a href="view_all_recipes.php">View All Recipes</a>
</body>
</html>