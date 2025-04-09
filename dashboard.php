<?php
// Secure session configurations
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Use only if HTTPS is enabled
ini_set('session.use_strict_mode', 1);
session_start();

// Include reusable session check function
include 'auth.php';
checkUserSession();

echo "Welcome! <a href='logout.php'>Logout</a>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        a {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        a:hover {
            background-color: #0056b3;
        }
        .btn {
            background-color: #ffc107;
        }
        .btn:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Ingredients to Cart</h2>
        <form method="POST" action="add_to_cart.php">
            <input type="text" name="ingredient" placeholder="Enter ingredient" required>
            <button type="submit">Add</button>
        </form>

        <a href="recipes.php">View Recipes</a>
        <a href="view_cart.php" class="btn">View Cart</a>
    </div>
</body>
</html>