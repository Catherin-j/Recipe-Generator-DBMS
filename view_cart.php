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
$cart = json_decode($user['cart'], true) ?? [];
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        a {
            color: #dc3545;
            text-decoration: none;
            font-size: 14px;
        }
        a:hover {
            text-decoration: underline;
        }
        .empty-cart {
            text-align: center;
            color: #888;
            font-size: 16px;
            margin-top: 20px;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Cart Ingredients</h2>
        <?php if (empty($cart)): ?>
            <p class="empty-cart">Your cart is empty.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($cart as $index => $ingredient): ?>
                    <li>
                        <?php echo htmlspecialchars($ingredient); ?>
                        <a href="delete_cart.php?index=<?php echo $index; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="dashboard.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>