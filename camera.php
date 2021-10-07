<?php 
require_once 'controllers/authController.php';
require_once 'include/header.php'; 

$stickers_dir = "web/stickers/*.png";
$stickers = glob($stickers_dir);

if(!isset($_SESSION['id'])){
    header("location: login.php");
}

$queryGalleryUser = "SELECT * FROM camera_img WHERE user_id = :id ORDER BY img_id DESC";
$stmt = $conn->prepare($queryGalleryUser);
$stmt->execute(array(
    'id'    => $_SESSION['id']
));
$gallerycount = $stmt->rowCount();
$user_gallery = $stmt->fetchAll();
?>
<body>
<div class="container-fluid mt-5 ml-auto">
    <div class="row">
        <div class="col-md-4">
            <div onscroll="addpix()" id="videobox">
                <div id="video_overlays">
                    <img class="img-responsive" id="video_overlays_img">
                </div>
                <video id="sourcevid" class="img-fluid w-75"></video>
                <p><img class="img-fluid" id="output"/></p>
            </div>
            <p><button id="campress" class="btn btn-warning" onclick='clone()'><i class="fa fa-camera-retro" disabled></i></button>
            <button id="campress2" class="btn btn-warning" onclick='clone2()'><i class="fa fa-camera-retro" disabled></i></button></p>
            <form action="camera.php" method="post">
           <p><select name="img-filter" id="filter">
                <option value="none"selected >No Filter</option>
                <option value="newyork">New York</option>
                <option value="brasil">Brasil</option>
                <option value="texas">Texas</option>
                <option value="sydney">Sydney</option>
                <option value="arctic">Arctic</option>
                <option value="paris">Paris</option>
                <option value="brooklyn">Brooklyn</option>
                <option value="london">London</option>
            </select></p>
            <p><input type="file"  accept="image/*" name="image" id="img-file"  onchange="onFileSelected(event)"></p>
        </div>
        <div class="col-md-4">
            <div class="tab-pane active" id="profile">
                <div class="row">
                    <?php foreach($stickers as $sticker):?>
                    <div class="col-sm-4">
                        <?php $stickname = pathinfo($sticker);?>
                            <div class="gal-detail thumb">
                                <img id="<?= $stickname['filename']?>" class="img-fluid bb" src="<?= $sticker ?>" alt="<?= $stickname['filename'] ?>" onclick="change(this.src)">
                                <h4 class="text-center"><?= $stickname['filename']?></h4>
                            <div class="ga-border"></div>
                            </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <canvas id="cvs" style="display: none"></canvas>
            <canvas id="myCanvas" style="display: none"></canvas>
            <canvas id="combined" width="595" height="355"></canvas>
            <input type="hidden" name="overlay-l" id="ov-left">
            <input type="hidden" name="overlay-t" id="ov-top">
            <input type="hidden" name="img-data" id='tar'>
            <input type="hidden" name="img-over" id="img_over">
            <p><button type="submit" name="img-btn" id="btn1" class="btn btn-warning btn-sub">Use this Photo</button>
            <button  onclick='removecvs()' id="btn2" class="btn btn-danger btn-sub">Cancel</button></p>
            </form>
        </div>
    </div>
    <?php if($gallerycount > 0) :?>
    <div class="col-sm-12">
        <div class="tab-pane active" id="profile">
            <div class="row">
                <?php foreach($user_gallery as $gal):?>
                <div class="col-sm-4">
                    <div class="gal-detail thumb img-thumbnail">
                        <img class="w-100 mx-auto d-block img-fluid <?php if(isset($gal['img_filter'])){echo $gal['img_filter'];}?>" src="<?= $gal['img'] ?>" alt="">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif;?>
</div>
<script src="js/app.js?<?php echo time();?>"></script>
<script src="js/tools.js?<?php echo time();?>"></script>
<?php require_once 'include/footer.php';?>