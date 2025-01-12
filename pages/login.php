<?php
if ($logged_in === true){
    echo "<script>window.location = '/'</script>";
exit;
}
$postParams = [
    'username',
    'password',
];
if(validatePost($postParams) && verifyCaptchaEnterprise($_POST['token'],'LOGIN')){
    validate_CSRFToken('login','/login');
    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);
    $user = getUserByUsername($username);
    if ($user) {
        if (isBlocked($user['last_failed_attempt'], $user['failed_attempts'])) {
            $_SESSION['login_alert'] = "Your account is blocked for 10 minutes due to multiple failed login attempts.";
        }elseif($password == $user['password']){
            $randomBytes = random_bytes(32 / 2);
            $token = bin2hex($randomBytes);
            updateUserToken($user['id'],$token);
            $_SESSION['user_access_token'] = $token;
            echo "<script>window.location = '/'</script>";exit();
        }else{
            updateFailedAttempt($user['id']);
        }
    } else {
        $_SESSION['login_alert'] = "Login failed ! User not found";
    }
}
?>
<section id="login-section" class="form-container">
        <h2>Login</h2>
        <form action="/login" method="post" onsubmit="login(event)" id="loginForm">
        <?php
            if(isset($_SESSION['to_login'])){ ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
  <?php echo $_SESSION['to_login'];unset($_SESSION['to_login']); ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div><?php } ?>

<?php
            if(isset($_SESSION['login_alert'])){ ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <?php echo $_SESSION['login_alert'];unset($_SESSION['login_alert']); ?>
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
                <?php echo CSRFToken('login');?>
                <input type="hidden" name="token" id="recaptchaToken">
            </div>
           
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </section>