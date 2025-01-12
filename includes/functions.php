<?php
function get_total_in_cart(){
    $totalQuantity = 0;
    foreach ($_SESSION['cart'] as $item) {
        $totalQuantity += $item["quantity"];
    }
    return (int) $totalQuantity;
}
function get_total_price(){
    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $item) {
        $totalPrice += $item["price"] * $item['quantity'];
    }
    return (float) $totalPrice;
}
function verify_product($id){
    global $conn;
    $id = (int) $id;
    $sql = "SELECT * FROM products WHERE id = '${id}' AND is_public = 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return true;
    }else{
        return false;
    }
}
function CSRFToken($type) {
    if(!isset($_SESSION['csrf_token_'.$type])){
        $tokenLength = 32; 
        $randomBytes = random_bytes($tokenLength / 2);
        $token = bin2hex($randomBytes);
        $_SESSION['csrf_token_'.$type] = $token;
        }
    return '<input type="hidden" class="form-control" id="newProjectName" name="csrf_token" value="' .$_SESSION["csrf_token_".$type]. '">';
}
function logouttoken() {
    if(!isset($_SESSION['logout_token'])){
        $tokenLength = 32; 
        $randomBytes = random_bytes($tokenLength / 2);
        $token = bin2hex($randomBytes);
        $_SESSION['logout_token'] = $token;
        }
    return $_SESSION['logout_token'];
}
function validate_CSRFToken($type,$redirect){
    if(isset($_POST['csrf_token']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token_'.$type]){
        unset($_SESSION['csrf_token_'.$type]);
    }else{
        echo "<script>alert('CSRF token is missing / incorrect');window.location = '" .htmlspecialchars($redirect)."'</script>";
        exit();
    }
}
function getUserByUsername($username) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE username = ?");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function getUserByToken($token) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE token = ?");
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function validatePost($params) {
    $isValid = true;
    foreach ($params as $param) {
        if (!isset($_POST[$param]) || empty($_POST[$param])) {
            $isValid = false;
            break; // Exit the loop early if any parameter fails validation
        }
    }

    return $isValid;
}
function registerUser($username, $password) {
    global $conn;
    $randomBytes = random_bytes(32 / 2);
    $token = bin2hex($randomBytes);
    $stmt = mysqli_prepare($conn, "INSERT INTO user (username, password, token) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sss', $username, $password, $token);

    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        return false;
    }
}
function isBlocked($lastFailedAttempt, $failedAttempts) {
    if ($failedAttempts >= 10) {
        $blockedTime = strtotime($lastFailedAttempt) + 600; // 10 minutes lock
        if (time() < $blockedTime) {
            return true; // Blocked if within 10 minutes
        }
    }
    return false; // Not blocked
}
function updateFailedAttempt($userId) {
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE user SET failed_attempts = failed_attempts + 1, last_failed_attempt = NOW() WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
}

// Reset failed login attempts
function resetFailedAttempts($userId) {
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE user SET failed_attempts = 0, last_failed_attempt = NULL WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
}
function updateUserToken($userId,$token) {
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE user SET token = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $token, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function updateUserAccount($userId,$password) {
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE user SET password = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $password, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}
function verifyCaptchaEnterprise($token, $expectedAction) {
    $siteKey = '6LfEfbQqAAAAAFgx8vd62JAnd_h9XNn66qb3ilIL';  // Your reCAPTCHA Site Key
    $apiKey = 'AIzaSyCmRpPJv4Nck5ZNXO5AVMAwI-6Rh-Bfojk';  // Replace with your API Key from Google Cloud Console
    
    // URL for the reCAPTCHA Enterprise verification API
    $url = 'https://recaptchaenterprise.googleapis.com/v1/projects/smart-shopping-1736594878189/assessments?key=' . $apiKey;
    
    // Prepare the POST data
    $postData = json_encode([
        'event' => [
            'token' => $token,
            'expectedAction' => $expectedAction,
            'siteKey' => $siteKey
        ]
    ]);
    
    // Initialize cURL session
    $ch = curl_init();
    
    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($postData)
    ]);
    
    // Execute the request
    $response = curl_exec($ch);
    $error = curl_error($ch);
    
    // Close cURL session
    curl_close($ch);
    
    // Handle errors
    if ($error) {
        return "cURL Error: " . $error;
    }
    
    // Decode the response to check success
    $responseData = json_decode($response, true);
    
    // Check for success in the response data
    if (isset($responseData['tokenProperties']) && $responseData['tokenProperties']['valid'] === true) {
        return true;  // Token is valid
    } else {
        return false;  // Token verification failed
    }
}


?>