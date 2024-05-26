<?php
session_start();

include 'config.php';


$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

if ($user_id == 0) {
    echo json_encode(['count' => 0]);
    exit();
}


$sql = "SELECT SUM(quantity) as cart_count FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$cart_count = $row['cart_count'] ?? 0;

echo json_encode(['count' => $cart_count]);


$stmt->close();
$conn->close();
?>
