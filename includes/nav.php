<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="/">Smart Shopping</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
        <?php if ($logged_in === true): ?>
            <li class="nav-item"><a class="nav-link" href="/account">Account</a></li>
            <li class="nav-item"><a class="nav-link" href="/logout?token=<?php echo logouttoken();?>">Logout</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="login">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
            <?php endif; ?>
            
            <li class="nav-item">
                <a class="nav-link" href="/cart">Cart <span id="cart-notification" class="badge badge-danger"><?php echo get_total_in_cart();?></span></a>
            </li>
        </ul>
    </div>
</nav>