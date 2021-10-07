<?php 
require_once 'controllers/authController.php';
require_once 'include/header.php';
if(!isset($_SESSION['username'])){
    header("location: login.php");
}
?>

<body>
<div class="container mt-5">
<?php if(isset($_SESSION['verified'])):?>
                    <div class="alert <?php echo $_SESSION['alert-class'];?> text-center">
                        <?php
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                            unset($_SESSION['alert-class']);
                        ?>
                    </div>
                <?php endif; ?>
    <div class="row">
        <div class="col-lg-4 pb-5">
            <!-- Account Sidebar-->
            <div class="author-card pb-3">
                <div class="author-card-cover" style="background-image: url(web/avatar/cover.jpg);"></div>
                <?php if(!$_SESSION['verified']): ?>
                    <div class="alert alert-warning text-center">
                        You need to verify your account
                        Go to your mail and click on the verification link
                        <strong><?php echo $_SESSION['email']?></strong>
                    </div>
                <?php else: ?>
                <div class="alert alert-success text-center">
                        Your account is verified
                        <strong><?php echo ucwords($_SESSION['username']);?></strong>
                    </div>
                <?php endif;?>
                <div class="author-card-profile">
                    <div class="author-card-avatar"><img src="<?php echo $_SESSION['user_img']?>" alt="<?php echo $_SESSION['username']?>">
                    </div>
                    <div class="author-card-details">
                        <h5 class="author-card-name text-lg"><?php echo ucwords($_SESSION['username']);?></h5><span class="badge badge-pill badge-success">Online</span>
                    </div>
                    
                </div>
            </div>
            <div class="wizard">
                <nav class="list-group list-group-flush">
                    <a class="list-group-item" href="profile.php"><i class="fe-icon-user text-muted"></i>Profile</a>
                    <a class="list-group-item" href="profile_settings.php"><i class="fe-icon-user text-muted"></i>Profile Settings</a>
                    <a class="list-group-item active" href="profile_password.php"><i class="fe-icon-user text-muted"></i>Change Password</a>
                </nav>
            </div>
        </div>
        <div class="col-lg-8 pb-5">
                    <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </div>
                    <?php endif;?>
            <form class="row" method="post" action="profile_password.php">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account-pwd">New Password</label>
                        <input name="new_pwd" class="form-control" type="password" id="account-pwd">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account-pwdConf">Confirm New Password</label>
                        <input name="new_pwd_conf" class="form-control" type="password" id="account-pwdConf">
                    </div>
                </div>
                <div class="col-12">
                    <hr class="mt-2 mb-3">
                    <div class="d-flex justify-content-lg-end">
                            <button class="btn btn-style-1 btn-warning" name="change_pwd_btn" type="submit">Update Profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'include/footer.php';?>