<?php 
require_once 'controllers/authController.php';
require_once 'include/header.php';

if(!isset($_SESSION['username'])){
    header("location: login.php");
}

$queryCameraimage = "SELECT * FROM camera_img WHERE user_id = :id ORDER BY img_id DESC";
$stmt = $conn->prepare($queryCameraimage);
$stmt->execute(array(
    'id'    => $_SESSION['id']
));
$rowcount = $stmt->rowCount();
$camera_img = $stmt->fetchAll(PDO::FETCH_OBJ);
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
                <div class="author-card-cover" style="background-image: url(web/avatar/cover.jpg);"><a class="btn btn-style-1 btn-white btn-sm" href="#"><i class="fa fa-award text-md"></i>&nbsp;<?php echo $rowcount?> Pic</a></div>
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
                    <a class="list-group-item active" href="profile.php"><i class="fe-icon-user text-muted"></i>Profile</a>
                    <a class="list-group-item" href="profile_settings.php"><i class="fe-icon-user text-muted"></i>Profile Settings</a>
                    <a class="list-group-item" href="profile_password.php"><i class="fe-icon-user text-muted"></i>Change Password</a>
                </nav>
            </div>
        </div>
        <div class="col-lg-8 pb-5">
                <!-- begin -->
                <div class="tab-pane active" id="profile">
                            <div class="row">
                            <?php if($rowcount > 0): ?>
                                <?php foreach($camera_img as $element): ?>
                                <div class="col-sm-4">
                                    <form action="profile.php" method="post">
                                        <div class="gal-detail thumb">
                                                <img src="<?php echo $element->img; ?>" class="thumb-img <?php if(!empty($element->img_filter)){echo $element->img_filter;}?>" alt="<?php echo $element->id; ?>">
                                            <h4 class="text-center">Image</h4>
                                            <div class="ga-border"></div>
                                            <p class="text-muted text-center"><small><?php echo $element->img_date; ?></small></p>
                                        </div>
                                        <input type="hidden" name="img_id" value="<?php echo $element->img_id;?>">
                                        <input type="hidden" name="user_id" value="<?php echo $element->user_id;?>">
                                        <input type="hidden" name="img_path" value="<?php echo $element->img;?>">
                                        <button type="submit" name="delete_img_profile" class="btn btn-danger btn-block"><i class="fa fa-trash-o"></i></button>
                                    </form>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <div class="alert alert-warning text-center w-100">
                                    There is no photo actually got take some pic <a class="text-secondary" href="camera.php">Here</a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                <!-- end -->
            </div>
        </div>
    </div>
</div>
<?php require_once 'include/footer.php' ?>
