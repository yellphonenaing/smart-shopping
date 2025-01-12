<?php
define('APPNAME','Smart Shopping');
define('VERSION','1.0');
//Database connection details
define('db_server', 'localhost');
define('db_username', 'root');
define('db_password', 'root');
define('db_name', 'smart_shopping');
$conn = mysqli_connect(db_server, db_username, db_password, db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Add slashes to all GET parameters
foreach ($_GET as $key => $value) {
    $_GET[$key] = addslashes($value);
}

// Add slashes to all POST parameters
foreach ($_POST as $key => $value) {
    $_POST[$key] = addslashes($value);
}
?>