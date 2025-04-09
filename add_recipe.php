<?php
session_start();
// Check that admin is logged in
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
    <title>Add Recipe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            height: 100px;
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
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add a New Recipe</h2>
        <form method="POST" action="process_recipe.php">
            <div class="form-group">
                <label for="name">Recipe Name</label>
                <input type="text" id="name" name="name" placeholder="Recipe Name" required>
            </div>
            <div class="form-group">
                <label for="ingredients">Ingredients</label>
                <input type="text" id="ingredients" name="ingredients" placeholder="Ingredients (comma-separated)" required>
            </div>
            <div class="form-group">
                <label for="steps">Cooking Steps</label>
                <textarea id="steps" name="steps" placeholder="Cooking Steps" required></textarea>
            </div>
            <button type="submit">Add Recipe</button>
        </form>
        <a href="admin_dashboard.php">Back to Admin Dashboard</a>
    </div>
</body>
</html>