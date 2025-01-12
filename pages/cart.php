<style>
        body {
            background-color: #f0f2f5;
            font-family: 'Montserrat', sans-serif;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
        }

        .footer p {
            margin: 0;
        }

        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .cart-title {
            font-weight: 600;
        }

        .cart-price {
            color: #007bff;
        }

        .total {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .coupon {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Shopping Cart</h1>
    <div class="row">
    <div id="alert-container" class="container mt-3">
    <!-- The alert messages will appear here dynamically -->
</div>

        <div class="col-md-12">
<?php
foreach ($_SESSION['cart'] as $item) {
?>
            <div class="cart-item d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="cart-title"><?= $item['name'];?></h5>
                    <p class="cart-price">$<?= $item['price'];?></p>
                </div>
                <div class="cart-quantity">
        <span>Quantity: <?= (int)$item['quantity'];?></span>
    </div>
                <button class="btn btn-danger btn-sm" product-id="<?= $item['id'];?>" quantity="<?= (int)$item['quantity'];?>">Remove</button>
            </div>
<?php } ?>

            <div class="total mt-4 text-right">
                <strong>Total: $<?php echo get_total_price();?></strong>
            </div>

            <div class="coupon mt-4">
                <h5>Apply Coupon Code</h5>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter coupon code" aria-label="Coupon code">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">Apply</button>
                    </div>
                </div>
            </div>

            <div class="text-right mt-3">
                <a href="checkout.html" class="btn btn-primary">Proceed to Checkout</a>
            </div>
        </div>
    </div>
</div>
<script>
    // Attach event listeners to all "Remove" buttons
    let cartCount = <?php echo get_total_in_cart();?>;
    document.querySelectorAll('.btn-danger').forEach(button => {
        button.addEventListener('click', function() {
            // Get the productId from the cart item (you can embed it in the HTML element)
            const productId = this.getAttribute('product-id');
            const cartItem = this.closest('.cart-item');
            const quantity = this.getAttribute('quantity');

            // Call the API to remove the item from the cart
            fetch('/remove_from_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    productId: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success alert
                    showAlert('Product removed from cart.', 'success');
                    cartCount -= quantity;
                     updateCartNotification();

                    // Optionally, update the UI (e.g., remove the item from the cart list)
                    cartItem.remove();
                    document.querySelector('.total strong').textContent = `Total: $${data.total_price}`;
                } else {
                    // Show error alert
                    showAlert(data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Show error alert if the request fails
                showAlert('Failed to remove the product.', 'danger');
            });
        });
    });

    // Function to show the alert
    function showAlert(message, type) {
        // Create alert element
        const alertBox = document.createElement('div');
        alertBox.classList.add('alert', `alert-${type}`, 'alert-dismissible', 'fade', 'show');
        alertBox.setAttribute('role', 'alert');
        alertBox.innerHTML = `${message} <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>`;
        
        // Append the alert box to the body or a specific container
        const alertContainer = document.getElementById('alert-container');
        alertContainer.appendChild(alertBox);

        // Automatically hide the alert after 5 seconds
        setTimeout(() => {
            alertBox.classList.remove('show');
        }, 5000);
    }
    function updateCartNotification() {
        const notification = document.getElementById('cart-notification');
        notification.style.display = 'inline'; // Show the notification
        notification.innerText = cartCount; // Update the count
    }
</script>

