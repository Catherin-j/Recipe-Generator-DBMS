<?php
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $ingredient = htmlspecialchars(trim($_POST['ingredient'])); // Sanitize input

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
    $cart = json_decode($user['cart'], true) ?? [];
    $cart[] = $ingredient; // Add the new ingredient to the cart
    $cart_json = json_encode($cart);

    // Update the user's cart in the database
    $update_stmt = $conn->prepare("UPDATE users SET cart = ? WHERE id = ?");
    $update_stmt->bind_param("si", $cart_json, $user_id);

    if ($update_stmt->execute()) {
        $_SESSION['success'] = "Ingredient added to cart!";
    } else {
        $_SESSION['error'] = "Failed to update cart.";
    }

    $stmt->close();
    $update_stmt->close();
    $conn->close();

    header("Location: dashboard.php");
    exit();
}
?>