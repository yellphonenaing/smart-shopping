<?php
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = '${id}' AND is_public = 1";
    $result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
?>
<div class="container mt-5">
    <h1 class="text-center" id="product_name" product-id="<?= htmlspecialchars($row['id']);?>"><?= htmlspecialchars($row['product_name']);?></h1>
    <div class="row">
        <div class="col-md-6">
            <img src="images/<?= htmlspecialchars($row['product_image']);?>" alt="Smartphone" class="img-fluid product-image">
        </div>
        <div class="col-md-6">
            <h5 class="text-primary">$<?= htmlspecialchars($row['price']);?></h5>
            <p class="product-description"><?= htmlspecialchars($row['description']);?></p>
            <button class="btn btn-primary btn-lg">Add to Cart</button>
        </div>
    </div>

    <div class="specifications">
        <h4>Specifications</h4>
        <ul>
        <?= $row['specifications'];
        //HTML characters are allowed
        ?>
        </ul>
    </div>
</div>



<?php }}else{echo '<h1>Product not found</h1>';} ?>

<script>
    // Initialize the cart count
    let cartCount = <?php echo get_total_in_cart();?>;
    var productName = document.getElementById("product_name");
    var productID = productName.getAttribute("product-id");

    // Function to add item to the cart
    function addToCart(productId) {
        fetch('/api.php', { // Replace with your actual API endpoint
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ productId: productId }),
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Failed to add to cart');
            }
        })
        .then(data => {
            console.log(data); // Handle response data
            cartCount++;
            updateCartNotification();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Function to update the cart notification
    function updateCartNotification() {
        const notification = document.getElementById('cart-notification');
        notification.style.display = 'inline'; // Show the notification
        notification.innerText = cartCount; // Update the count
    }

    // Attach event listener to the "Add to Cart" button
    document.querySelector('.btn-primary').addEventListener('click', function() {
        addToCart(productID); // Replace with actual product ID
    });
</script>