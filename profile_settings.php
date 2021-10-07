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
                    <a class="list-group-item active" href="profile_settings.php"><i class="fe-icon-user text-muted"></i>Profile Settings</a>
                    <a class="list-group-item" href="profile_password.php"><i class="fe-icon-user text-muted"></i>Change Password</a>
                </nav>
            </div>
        </div>
        <!-- Profile Settings-->
        <div class="col-lg-8 pb-5">
                    <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </div>
                    <?php endif;?>
            <form class="row" method="post" action="profile_settings.php" enctype="multipart/form-data">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account-ln">Username</label>
                        <input name="user_username" class="form-control" type="text" id="account-ln" placeholder="<?php echo ucwords($_SESSION['username']);?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account-email">E-mail Address</label>
                        <input name="user_email" class="form-control" type="email" id="account-email" placeholder="<?php echo $_SESSION['email'];?>">
                    </div>
                </div>
                <div class="col-12">
                    <hr class="mt-2 mb-3">
                    <label for="user_notfication">Notification</label>
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div class="custom-control custom-radio custom-control-inline d-block">
                            <input type="radio" class="custom-control-input" id="yes" name="user_notfication" value="1" <?php if($_SESSION['notification'] == 1){echo "checked";}?>>
                            <label class="custom-control-label" for="yes">Yes</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline d-block">
                            <input type="radio" class="custom-control-input" id="no" name="user_notfication" value="0" <?php if($_SESSION['notification'] == 0){echo "checked";}?>>
                            <label class="custom-control-label" for="no">No</label>
                        </div>
                        <label class="file">
                            <input name="user_img" type="file" id="file" accept="image/png, image/jpg, image/jpeg, image/gif">
                            <span class="file-custom"></span>
                        </label>
                            <button class="btn btn-style-1 btn-warning" name="update_user_btn" type="submit">Update Profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'include/footer.php' ?>