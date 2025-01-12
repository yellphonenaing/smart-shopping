<?php
session_start();
include('./includes/functions.php');
// Check if the cart session exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$productId = isset($_POST['productId']) ? (int) $_POST['productId'] : die(json_encode(['success' => false, 'message' => 'Product ID is required.']));
if(isset($_SESSION['cart'][$productId])){
    unset($_SESSION['cart'][$productId]);
    echo json_encode(['success' => true, 'message' => 'Product removed from cart.', 'total_price' => get_total_price()]);
    exit;
}
?>