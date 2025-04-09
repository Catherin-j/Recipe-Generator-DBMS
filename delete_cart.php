<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['index'])) {
    header("Location: view_cart.php");
    exit();
}

$index = intval($_GET['index']);

// Retrieve the current cart using a prepared statement
$stmt = $conn->prepare("SELECT cart FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $cart = json_decode($user['cart'], true) ?? [];

    // Remove the ingredient at the specified index if it exists
    if (isset($cart[$index])) {
        array_splice($cart, $index, 1); // Remove the ingredient
        $cart_json = json_encode($cart);

        // Update the cart in the database using a prepared statement
        $update_stmt = $conn->prepare("UPDATE users SET cart = ? WHERE id = ?");
        $update_stmt->bind_param("si", $cart_json, $user_id);
        $update_stmt->execute();
        $update_stmt->close();
    }
}

$stmt->close();
$conn->close();

// Redirect to view_cart.php or recipes.php
header("Location: view_cart.php");
exit();
?>