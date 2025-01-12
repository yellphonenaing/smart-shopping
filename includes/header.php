<?php
$logged_in = false;
if(isset($_SESSION['user_access_token'])){
    $user = getUserByToken($_SESSION['user_access_token']);
    if($user){
        $logged_in = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APPNAME; ?></title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/gfonts.css" rel="stylesheet">
    <style>
        html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}
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
    max-width: 500px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    background-color: #ffffff;
    border-radius: 30px; /* Rounded corners */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out; /* Smooth transition */
}

.search-form input {
    width: 100%;
    padding: 12px 20px; /* Increase padding for a more comfortable input */
    font-size: 16px;
    border-radius: 25px; /* Rounded corners for input */
    border: 1px solid #ced4da;
    outline: none;
    transition: border-color 0.3s ease;
}

.search-form input:focus {
    border-color: #007bff; /* Highlight input field on focus */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add focus effect */
}

.search-form button {
    background-color: #007bff;
    color: white;
    padding: 12px 20px;
    font-size: 16px;
    border-radius: 25px; /* Rounded button */
    border: none;
    margin-left: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.search-form button:hover {
    background-color: #0056b3;
    transform: translateY(-2px); /* Slight lift effect on hover */
}

.search-form button:active {
    transform: translateY(2px); /* Slight press effect when clicked */
}

.search-form input::placeholder {
    color: #6c757d; /* Lighter placeholder text */
    font-style: italic;
}
.form-container {
            margin: 50px auto;
            max-width: 400px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }


        .profile-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-image-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 1rem;
        }

        .profile-image-wrapper img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }

        .profile-image-wrapper .upload-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .profile-image-wrapper .upload-btn:hover {
            background-color: #0056b3;
        }
    </style>


  <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfEfbQqAAAAAFgx8vd62JAnd_h9XNn66qb3ilIL"></script>


  <script>
  function login(e) {
    e.preventDefault();  // Prevent the form from submitting immediately

    grecaptcha.enterprise.ready(async () => {
      // Execute reCAPTCHA and get the token for the LOGIN action
      const token = await grecaptcha.enterprise.execute('6LfEfbQqAAAAAFgx8vd62JAnd_h9XNn66qb3ilIL', {action: 'LOGIN'});

      // Set the token as the value of the hidden input field
      document.getElementById('recaptchaToken').value = token;

      // Submit the form
      document.getElementById('loginForm').submit();
    });
  }
  function register(e) {
    e.preventDefault();  // Prevent the form from submitting immediately

    grecaptcha.enterprise.ready(async () => {
      // Execute reCAPTCHA and get the token for the LOGIN action
      const token = await grecaptcha.enterprise.execute('6LfEfbQqAAAAAFgx8vd62JAnd_h9XNn66qb3ilIL', {action: 'REGISTER'});

      // Set the token as the value of the hidden input field
      document.getElementById('recaptchaToken').value = token;

      // Submit the form
      document.getElementById('registerForm').submit();
    });
  }
</script>


</head>
<body>