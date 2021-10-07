<?php
require_once 'function/functions.php';

if(isset($_POST['like_btn']))
{
    if(!isset($_SESSION['id'])){
        header("location: login.php");
    }

    $stmt = null;
    if(isset($_POST['post_page']))
        $page = $_POST['post_page'];
    $post_id = $_POST['post_id'];
    $user_post_id = $_POST['post_user'];
    $user_like_id = $_SESSION['id'];

    if(checkUserLike($post_id, $user_like_id) == 1)
    {
        $queryDeleteLike = "DELETE FROM post_like WHERE post_id = :post_id AND like_user_id = :like_user_id AND post_user_id = :post_user_id";
        $stmt = $conn->prepare($queryDeleteLike);
        $result = $stmt->execute(array(
            'post_id'       => $post_id,
            'like_user_id'  => $user_like_id,
            'post_user_id'  => $user_post_id
        ));
        if($result)
        {
            if(isset($page))
                header("location: index.php?page=$page");
            else
                header('location: index.php');
            exit(0);
        }
    }
    else
    {
        $queryInsertLike = "INSERT INTO post_like (post_id, like_user_id, post_user_id, status) VALUES (:post_id, :like_user_id, :post_user_id, :status)";
        $stmt = $conn->prepare($queryInsertLike);
        $result = $stmt->execute(array(
            'post_id'       => $post_id,
            'like_user_id'  => $user_like_id,
            'post_user_id'  => $user_post_id,
            'status'        => 1
        ));
        if($result)
        {
            if(getUserNotif($user_post_id) && $user_post_id != $_SESSION['id'])
                sendNotificationLike(getUserEmail($user_post_id), getUsername($user_like_id), $post_id);
            if(isset($page))
                header("location: index.php?page=$page");
            else
                header('location: index.php');
            exit(0);
        }
    }
}

if(isset($_POST['like_btn_comment']))
{
    if(!isset($_SESSION['id'])){
        header("location: login.php");
    }

    $stmt = null;
    $post_id = $_POST['post_id'];
    $user_post_id = $_POST['post_user'];
    $user_like_id = $_SESSION['id'];

    if(checkUserLike($post_id, $user_like_id) == 1)
    {
        $queryDeleteLike = "DELETE FROM post_like WHERE post_id = :post_id AND like_user_id = :like_user_id AND post_user_id = :post_user_id";
        $stmt = $conn->prepare($queryDeleteLike);
        $result = $stmt->execute(array(
            'post_id'       => $post_id,
            'like_user_id'  => $user_like_id,
            'post_user_id'  => $user_post_id
        ));
        if($result)
        {
            header("location: post.php?post=$post_id&display=all");
            exit(0);
        }
    }
    else
    {
        $page = $_GET['page'];
        $queryInsertLike = "INSERT INTO post_like (post_id, like_user_id, post_user_id, status) VALUES (:post_id, :like_user_id, :post_user_id, :status)";
        $stmt = $conn->prepare($queryInsertLike);
        $result = $stmt->execute(array(
            'post_id'       => $post_id,
            'like_user_id'  => $user_like_id,
            'post_user_id'  => $user_post_id,
            'status'        => 1
        ));
        if($result)
        {
            if(getUserNotif($user_post_id))
                sendNotificationLike(getUserEmail($user_post_id), getUsername($user_like_id), $post_id);
            header("location: post.php?post=$post_id&display=all");
            exit(0);
        }
    }
}
?>