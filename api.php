<?php
session_start();
include('./includes/functions.php');
include('./includes/config.php');
// Sample product data (in a real application, this would come from a database)

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validate input
    if (isset($input['productId']) && verify_product($input['productId'])) {
        // Initialize cart in session if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Add the product to the cart
        $productId = (int) $input['productId'];
        $sql = "SELECT * FROM products WHERE id = '${productId}' AND is_public = 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += 1; // Increment quantity if already in cart
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => $row['id'],
                'name' => htmlspecialchars($row['product_name']),
                'price' => htmlspecialchars($row['price']),
                'quantity' => 1,
            ];
        }

        // Respond with success
        echo json_encode(['success' => true, 'message' => 'Product added to cart', 'cartCount' => count($_SESSION['cart'])]);
    } else {
        // Invalid product ID
        echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    }
} else {
    // Method not allowed
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
