<?php
if ($logged_in === true){
    echo "<script>window.location = '/'</script>";
exit;
}
$postParams = [
    'username',
    'password',
];
if(validatePost($postParams) && verifyCaptchaEnterprise($_POST['token'],'REGISTER')){
    validate_CSRFToken('register','/register');
    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);
    $checkuser = getUserByUsername($username);
    if(isset($checkuser['id'])){
        $_SESSION['reg_alert'] = "Account already existed !";
    }else{
        if(registerUser($username, $password)){
            $_SESSION['to_login'] = "Your account has been created, Please login.";
            echo "<script>window.location = '/login'</script>";
exit;
        }
    }
}
?>

<section id="login-section" class="form-container">
        <h2>Register</h2>
        
        <form action="/register" method="post" onsubmit="register(event)" id="registerForm">
            <?php
            if(isset($_SESSION['reg_alert'])){ ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <?php echo $_SESSION['reg_alert'];unset($_SESSION['reg_alert']); ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div><?php } ?>
            <div class="form-group">
                <label for="login-email">Username</label>
                <input type="text" class="form-control" id="login-email" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="login-password">Password</label>
                <input type="password" class="form-control" id="login-password" name="password" placeholder="Enter your password" required>
                <?php
                echo CSRFToken('register');?>
                 <input type="hidden" name="token" id="recaptchaToken">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
    </section>