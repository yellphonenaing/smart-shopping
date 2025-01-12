<?php
if ($logged_in === false){
    echo "<script>window.location = '/login'</script>";
exit;
}
$postParams = [
    'password',
];
if(validatePost($postParams)){
    validate_CSRFToken('profile','/profile');
    $password = addslashes($_POST['password']);
    if(updateUserAccount($user['id'],$password)){
        $_SESSION['user_info_updated'] = "Your profile has been updated";
        if(isset($_FILES['profileImage'])){
            $file = $_FILES['profileImage'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];
            $uploadPath = "./images/profiles/". $user['id'].".png";
            if ($fileSize <= 5 * 1024 * 1024){
                move_uploaded_file($fileTmpName, $uploadPath);
            }
        }
    }
}
?>
<div class="profile-container">
<form action="/account" method="post" enctype="multipart/form-data">
<?php
            if(isset($_SESSION['user_info_updated'])){ ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
  <?php echo $_SESSION['user_info_updated'];unset($_SESSION['user_info_updated']); ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div><?php } ?>
        <div class="profile-image-wrapper">
        <img src="/images/profiles/<?php echo htmlspecialchars($user['id']);?>.png"  
     id="profileImage" 
     onerror="this.onerror=null; this.src='/images/profile.png';">
            <input type="file" name="profileImage" id="imageUpload" accept="image/*" style="display: none;" onchange="loadFile(event)">
            <button type="button" class="upload-btn" onclick="document.getElementById('imageUpload').click();">
                <i class="bi bi-camera"></i>
            </button>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" placeholder="Enter your username" value="<?php echo htmlspecialchars($user['username']);?>" disabled>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" value="<?php echo htmlspecialchars($user['password']);?>" required>
            <?php echo CSRFToken('profile');?>
        </div>

        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
    </form>
</div>

<script>
    const loadFile = (event) => {
        const output = document.getElementById('profileImage');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = () => {
            URL.revokeObjectURL(output.src); // Free up memory
        };
    };
</script>
