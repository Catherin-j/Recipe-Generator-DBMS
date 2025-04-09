<?php
include 'db.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all recipes from the database
$query = "SELECT * FROM recipes";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Recipes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
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
        .recipe {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .recipe h3 {
            margin: 0 0 10px;
            color: #007bff;
        }
        .recipe p {
            margin: 5px 0;
            color: #555;
        }
        .delete-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        a {
            display: inline-block;
            margin-top: 20px;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>All Recipes</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($recipe = $result->fetch_assoc()): ?>
                <div class="recipe">
                    <h3><?php echo htmlspecialchars($recipe['name']); ?></h3>
                    <p><strong>Ingredients:</strong> <?php echo htmlspecialchars($recipe['ingredients']); ?></p>
                    <p><strong>Steps:</strong> <?php echo htmlspecialchars($recipe['steps']); ?></p>
                    <a href="delete_recipe.php?id=<?php echo $recipe['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this recipe?');">Delete</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No recipes found.</p>
        <?php endif; ?>
        <a href="admin_dashboard.php">Back to Admin Dashboard</a>
    </div>
</body>
</html>