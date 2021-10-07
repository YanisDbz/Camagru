<?php 
if(isset($_GET['post']) AND !empty($_GET['post']) AND $_GET['post'] > 0 AND isset($_GET['display']) AND !empty($_GET['display']) AND $_GET['display'] === "all")
{
    $_GET['post'] = intval($_GET['post']);
    $post = $_GET['post'];

    $queryDisplayAllMessagePost = "SELECT comment, comment_user_id FROM post_comment WHERE post_id = :post_id";
    $stmt = $conn->prepare($queryDisplayAllMessagePost);
    $result = $stmt->execute(array(
        'post_id'   => $post
    ));
    if($result)
    {
        $allComment = $stmt->fetchAll();
    }
    $stmt = null;
    $queryGetpostInformation = "SELECT * FROM `camera_img` INNER JOIN users ON camera_img.user_id = users.id WHERE img_id = :post";
    $stmt = $conn->prepare($queryGetpostInformation);
    $res = $stmt->execute(array(
        'post'  => $post
    ));
    if($res)
    {
        $user = $stmt->fetch();
    }
}
?>