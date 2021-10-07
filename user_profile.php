<?php 
require_once 'include/header.php';
require_once 'config/database.php';
require_once 'function/functions.php';


$user_id = htmlspecialchars($_GET['user']);

if(empty($user_id) || $user_id != $user_id){
    header('location: index.php');
}
$queryCameraimage = "SELECT * FROM camera_img WHERE user_id = :id ORDER BY img_id DESC";
$stmt = $conn->prepare($queryCameraimage);
$stmt->execute(array(
    'id'    => $user_id
));
$rowcount = $stmt->rowCount();
$camera_img = $stmt->fetchAll();
?>
<?php if($rowcount > 0) : ?>
<div class="container">
<div class="profile">
    <div class="profile-image">
        <img class="img-responsive" src="<?= getUserImage($user_id)?>" alt="">
    </div>
    <div class="profile-user-settings">
        <h1 class="profile-user-name"><?= getUsername($user_id)?></h1>
    </div>
    <div class="profile-stats">
        <ul>
            <li><span class="profile-stat-count"><?= getUserTotalPost($user_id)?></span> Total Post</li>
            <li><span class="profile-stat-count"><?= getUserTotaLikeNum($user_id)?></span> Total Like</li>
            <li><span class="profile-stat-count"><?= getUserTotalCommentNum($user_id)?></span> Total Comment</li>
        </ul>
    </div>
</div>
<!-- End of profile section -->
</div>
<!-- End of container -->
<main>
<div class="container">
<div class="gallery">
    <?php if($rowcount > 1): ?>
    <?php foreach($camera_img as $element): ?>
    <div class="gallery-item">
        <img src="<?php echo $element['img']; ?>" class="gallery-image <?php if(!empty($element['img_filter'])){echo $element['img_filter'];}?>" alt="<?php echo $element['img_filter']; ?>">
        <div class="gallery-item-info">
            <ul>
                <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i class="fa fa-heart" aria-hidden="true"></i>&nbsp;<?= getTotalLike($element['img_id'])?></li>
                <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fa fa-comment" aria-hidden="true"></i>&nbsp;<?= getTotalComment($element['img_id'])?></li>
            </ul>
        </div>
    </div>
    <?php endforeach; ?>
    <?php elseif($rowcount == 1): ?>
    <?php foreach($camera_img as $element): ?>
    <div class="gallery-item">
        <img src="<?php echo $element['img']; ?>" class="profile-img-fluid <?php if(!empty($element['img_filter'])){echo $element['img_filter'];}?>" alt="<?php echo $element['img_filter']; ?>">
        <div class="gallery-item-info" id="og" onmouseover="responsivegallery()">
            <ul>
                <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i class="fa fa-heart" aria-hidden="true"></i>&nbsp;<?= getTotalLike($element['img_id'])?></li>
                <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fa fa-comment" aria-hidden="true"></i>&nbsp;<?= getTotalComment($element['img_id'])?></li>
            </ul>
        </div>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <div class="alert alert-warning text-center w-100">
        There is no photo
    </div>
    <?php endif; ?>
</div>
<!-- End of gallery -->
</div>
<!-- End of container -->
</main>
<?php else: ?>
<div class="alert alert-danger text-center">
    User not found
</div>
<?php endif; ?>
<script>
function responsivegallery()
{
    document.getElementById("og").style.width = "390px";
}
</script>
<?php require_once 'include/footer.php'?>