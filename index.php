<?php
session_start();
include('./includes/functions.php');
include('./includes/config.php');
include('./includes/header.php');
include('./includes/nav.php');

switch($_GET['page']){
    case 'login':
        include('./pages/login.php');
        break;
    case 'register':
        include('./pages/register.php');
        break;
    case 'logout':
        include('./pages/logout.php');
        break;
    case 'account':
        include('./pages/profile.php');
        break;
    case 'product':
        include('./pages/product.php');
        break;
    case 'cart':
        include('./pages/cart.php');
        break;
    case '':
        include('./pages/index.php');
        break;
    default :
    include('./pages/404.php');include('./includes/footer.php');exit();

}
include('./includes/footer.php');
?>