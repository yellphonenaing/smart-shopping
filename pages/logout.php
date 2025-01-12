<?php
if(isset($_GET['token']) && $_GET['token'] == $_SESSION['logout_token']){
    unset($_SESSION['user_access_token']);
    echo "<script>window.location = '/'</script>";exit();
}
?>