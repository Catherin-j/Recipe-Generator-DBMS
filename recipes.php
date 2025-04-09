<?php
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the user's cart using a prepared statement
$stmt = $conn->prepare("SELECT cart FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>Error: User cart not found.</p>";
    exit();
}

$user = $result->fetch_assoc();
$cart = json_decode($user['cart'], true) ?? []; // Decode the cart JSON into an array
$stmt->close();

// Flatten the cart array if it contains comma-separated strings
$cart = array_reduce($cart, function ($carry, $item) {
    return array_merge($carry, array_map('trim', explode(',', $item)));
}, []);

// Handle empty cart
if (empty($cart)) {
    echo '<p class="no-recipes">Your cart is empty. Please add ingredients to see recommendations.</p>';
    exit();
}

// Convert cart ingredients to lowercase for case-insensitive matching
$cart = array_map('strtolower', $cart);

// Fetch all recipes from the database
$recipe_query = "SELECT * FROM recipes";
$recipes = $conn->query($recipe_query);

if (!$recipes) {
    echo '<p class="no-recipes">An error occurred while fetching recipes. Please try again later.</p>';
    error_log("Database error: " . $conn->error); // Log the error for debugging
    exit();
}

if ($recipes->num_rows === 0) {
    echo '<p class="no-recipes">No recipes found in the database. Please contact the administrator.</p>';
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommended Recipes</title>
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
        .no-recipes {
            text-align: center;
            color: #888;
            font-size: 16px;
            margin-top: 20px;
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
        <h2>Recommended Recipes</h2>
        <?php
        $foundRecipe = false;

        while ($recipe = $recipes->fetch_assoc()) {
            // Convert recipe ingredients to an array and trim whitespace
            $recipe_ingredients = array_map('strtolower', array_map('trim', explode(",", $recipe['ingredients'])));

            // Check for intersection between cart and recipe ingredients
            $intersection = array_intersect($cart, $recipe_ingredients);

            if (!empty($intersection)) {
                $foundRecipe = true;

                // Highlight matching ingredients
                $highlighted_ingredients = array_map(function ($ingredient) use ($cart) {
                    return in_array(strtolower($ingredient), $cart) ? "<strong>$ingredient</strong>" : $ingredient;
                }, explode(",", $recipe['ingredients']));

                $highlighted_ingredients = implode(", ", $highlighted_ingredients);

                echo '<div class="recipe">';
                echo "<h3>" . htmlspecialchars($recipe['name']) . "</h3>";
                echo "<p><strong>Ingredients:</strong> " . $highlighted_ingredients . "</p>";
                echo "<p><strong>Steps:</strong> " . htmlspecialchars($recipe['steps']) . "</p>";
                echo '</div>';
            }
        }

        if (!$foundRecipe) {
            echo '<p class="no-recipes">No recommendations found. Please add matching ingredients to your cart or check the recipes.</p>';
            echo '<a href="view_cart.php" class="back-link">Go to Cart</a>';
        }

        $conn->close();
        ?>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>