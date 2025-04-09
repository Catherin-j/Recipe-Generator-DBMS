<?php
include 'db.php';
session_start();

// Check admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and trim inputs
    $name = trim($_POST['name']);
    $ingredients = trim($_POST['ingredients']);
    $steps = trim($_POST['steps']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO recipes (name, ingredients, steps) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $ingredients, $steps);

    if ($stmt->execute()) {
        // Redirect to admin dashboard with a success message
        $_SESSION['success'] = "Recipe added successfully!";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Redirect to add_recipe.php with an error message
        $_SESSION['error'] = "Error adding recipe: " . $conn->error;
        header("Location: add_recipe.php");
        exit();
    }

    $stmt->close();
} else {
    header("Location: add_recipe.php");
    exit();
}
?>