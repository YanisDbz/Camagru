<?php
require_once 'function/functions.php';
if(isset($_POST['img-btn']))
{
    $user_id = $_SESSION['id'];
    $img_filter = $_POST['img-filter'];
    $postion_l = $_POST['overlay-l'];
    $postion_t = $_POST['overlay-t'];
    $img_file = generateImage($_POST['img-data'], "img");
    $overlay = generateImage($_POST['img-over'], "overlay");
    $final = "web/img/" . uniqid() . '.jpeg';
   
    $dest = imagecreatefromjpeg($img_file);
    $sticker = imagecreatefrompng($overlay);
    imagecopy($dest, $sticker, $postion_l, $postion_t, 0, 0, imagesx($sticker), imagesy($sticker));
    imagejpeg($dest, $final);
    imagedestroy($dest);
    imagedestroy($sticker);
    unlink($img_file);
    unlink($overlay);
    $queryInsertPhoto = "INSERT into camera_img (user_id, img, img_filter, img_date) VALUES(:user_id, :img, :img_filter, NOW())";
    $stmt = $conn->prepare($queryInsertPhoto);
    $new_res = $stmt->execute(array(
        'user_id'    => $user_id,
        'img'        => $final,
        'img_filter' => $img_filter
    ));
    if($new_res)
    {

        $_SESSION['message'] = 'New picture added';
        $_SESSION['alert-class'] = 'alert-success';
        header('location: profile.php');
        exit(0);
    }
    $stmt = null;
}
?>