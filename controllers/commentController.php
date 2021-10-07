<?php
require_once 'function/functions.php';

if(isset($_POST['comment-btn']))
{
    $stmt = null;
    if(isset($_POST['post_page']))
        $page = $_POST['post_page'];
    $post_id = $_POST['post_id'];
    $comment = htmlspecialchars($_POST['comment']);
    $comment_user_id = $_SESSION['id'];
    $post_user_id = $_POST['post_user'];

    $queryInsertComment = "INSERT INTO post_comment (post_id, comment_user_id, post_user_id, comment) VALUES (:post_id, :comment_user_id, :post_user_id, :comment)";
    $stmt = $conn->prepare($queryInsertComment);
    $result = $stmt->execute(array(
        'post_id'           => $post_id,
        'comment_user_id'   => $comment_user_id,
        'post_user_id'      => $post_user_id,
        'comment'           => $comment
    ));
    if($result)
    {
        if(getUserNotif($post_user_id) && $post_user_id != $_SESSION['id'])
            sendNotificationComment(getUserEmail($post_user_id), getUsername($comment_user_id), $post_id, $comment);
        if(isset($page))
            header("location: index.php?page=$page");
        else
            header('location: index.php');
        exit(0);
    }
}

if(isset($_POST['comment-btn-comment']))
{
    $stmt = null;
    $post_id = $_POST['post_id'];
    $comment = htmlspecialchars($_POST['comment']);
    $comment_user_id = $_SESSION['id'];
    $post_user_id = $_POST['post_user'];

    $queryInsertComment = "INSERT INTO post_comment (post_id, comment_user_id, post_user_id, comment) VALUES (:post_id, :comment_user_id, :post_user_id, :comment)";
    $stmt = $conn->prepare($queryInsertComment);
    $result = $stmt->execute(array(
        'post_id'           => $post_id,
        'comment_user_id'   => $comment_user_id,
        'post_user_id'      => $post_user_id,
        'comment'           => $comment
    ));
    if($result)
    {
        if(getUserNotif($post_user_id))
            sendNotificationComment(getUserEmail($post_user_id), getUsername($comment_user_id), $post_id, $comment);
        header("location: post.php?post=$post_id&display=all");
        exit(0);
    }
}
?>