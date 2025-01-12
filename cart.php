<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Shopping</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/gfonts.css" rel="stylesheet">
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

        .navbar-nav .nav-link:hover {
            color: #f8f9fa !important;
            text-decoration: underline;
        }

        .card {
            height: 400px; /* Set a fixed height */
            display: flex;
            flex-direction: column; /* Allow vertical alignment */
        }

        .card-img-top {
            max-height: 200px; /* Limit image height */
            object-fit: cover; /* Ensure the image covers the area */
        }

        .card-body {
            flex-grow: 1; /* Allow card body to take up remaining space */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Space out title, text, and button */
        }

        h1 {
            margin-bottom: 40px;
            color: #343a40;
        }

        .card {
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
            border-radius: 8px;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: #007bff;
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .footer p {
            margin: 0;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .badge {
            margin-right: 5px;
        }

        /* Add the CSS code here */
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .container {
            flex-grow: 1;
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        /* Search form styling */
        .search-form {
            max-width: 400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
        }

        .search-form input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .search-form button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            margin-left: 10px;
        }

        .search-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="/">Smart Shopping</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="login">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="register">Register</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="cart">Cart <span id="cart-notification" class="badge badge-danger">0</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Search Form -->
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h5>Search Products:</h5>
            <form action="/search" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Search for products..." required>
                <button type="submit">Search</button>
            </form>
        </div>

        <h1 class="text-center">Featured Products</h1>
        <div class="text-center mb-4">
            <h5>Categories:</h5>
            <a href="/?cat=1" class="badge badge-info">Electronics</a>
            <a href="/?cat=2" class="badge badge-info">Fashion</a>
            <a href="/?cat=3" class="badge badge-info">Home & Garden</a>
            <a href="/?cat=4" class="badge badge-info">Sports</a>
        </div>

        <div class="row mt-4" id="product-list">
            <!-- Featured Products List (existing content) -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/smartphone.png" class="card-img-top" alt="Smartphone">
                    <div class="card-body">
                        <h5 class="card-title">Smartphone</h5>
                        <p class="card-text">$999.99</p>
                        <a href="product?id=1" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Add more product cards here -->
        </div>
    </div>

    <footer class="footer text-center">
        <p>&copy; Smart Shopping (V 1.0) . All Rights Reserved.</p>
    </footer>

    <script src="/assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
</body>
</html>
