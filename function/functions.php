<?php 
function verifyUser($token)
{
    global $conn;
    $queryToken = "SELECT * FROM users WHERE token = :token LIMIT 1";
    $stmt = $conn->prepare($queryToken);
    $stmt->execute(array(
        'token'     => $token
    ));
    $count = $stmt->rowCount();
    if($count > 0)
    {
        $user = $stmt->fetch();
        $queryUpdateUser = "UPDATE users SET verified = :verified WHERE token = :token";
        $st = $conn->prepare($queryUpdateUser);
        $result = $st->execute(array(
            'verified'  => 1,
            'token'     => $token
        ));
        if($result)
        {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = 1;
            $_SESSION['user_img'] = $user['user_img'];
            $_SESSION['log_date'] = $user['log_date'];
            $_SESSION['notification'] = $user['notification'];
            $_SESSION['message'] = 'You are addrress is now verified !';
            $_SESSION['alert-class'] = 'alert-success';
            header("location: profile.php");
            exit();
        }
        else{
            echo 'user not found';
        }
    }
}

/* ResetPassword func for Forgot Password */
function resetPassword($passwordToken)
{
    global $conn;
 
    $queryResetPasswd = "SELECT * FROM users WHERE token = :token LIMIT 1";
    $stmt = $conn->prepare($queryResetPasswd);
    $result = $stmt->execute(array(
        'token' => $passwordToken
    ));
    if ($result)
    {
        $user = $stmt->fetch();
        $_SESSION['email'] = $user['email'];
        header("location: password_change.php");
        exit();
    } else{
        echo 'user not found';
    }
}


function checkuserStatus($user_id)
{
    global $conn;

    $queryCheckUserStatus = "SELECT verified FROM users WHERE verified = :status AND id = :user_id";
    $stmt = $conn->prepare($queryCheckUserStatus);
    $result = $stmt->execute(array(
        'status'    => 1,
        'id'        => $user_id
    ));
    $count = $stmt->rowCount();
    if($result && $count === 1){
        return true;
    }
    return false;
}


function generateImage($img, $status)
{
    if($status === "overlay"){
        $folderPath = "web/overlay/";
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.png';
        file_put_contents($file, $image_base64);
    }
    if($status === "img"){
        $folderPath = "web/camera_img/";
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.jpeg';
        file_put_contents($file, $image_base64);
    } 

    return $file;

}

function time_elapsed_string($time){
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return '1 min ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
} 

function getUserNotif($id)
{
    global $conn;
    $queryGetUserNotif = "SELECT notification FROM users WHERE id = :id LIMIT 1";
    $stmt = $conn->prepare($queryGetUserNotif);
    $result = $stmt->execute(array(
        'id'    => $id
    ));
    if ($result) {
        $data = $stmt->fetchColumn();
        return $data;
    }
}

function getUserEmail($id)
{
    global $conn;
    $queryGetUserEmail = "SELECT email FROM users WHERE id = :id LIMIT 1";
    $stmt = $conn->prepare($queryGetUserEmail);
    $result = $stmt->execute(array(
        'id'    => $id
    ));
    if ($result) {
        $email = $stmt->fetchColumn();
        return $email;
    }
}

function getUsername($id)
{
    global $conn;
    $queryGetUserName = "SELECT username FROM users WHERE id = :id LIMIT 1";
    $stmt = $conn->prepare($queryGetUserName);
    $result = $stmt->execute(array(
        'id'    => $id
    ));
    if ($result) {
        $username = $stmt->fetchColumn();
        return ucwords($username);
    }
}

function getUserImage($id)
{
    global $conn;
    $queryGetUserImage = "SELECT user_img FROM users WHERE id = :id LIMIT 1";
    $stmt = $conn->prepare($queryGetUserImage);
    $result = $stmt->execute(array(
        'id'    => $id
    ));
    if ($result) {
        $username = $stmt->fetchColumn();
        return ucwords($username);
    }
}

function getUserComment($post_id, $user_comment_id)
{
    global $conn;
    $queryGetComment = "SELECT comment FROM post_comment WHERE post_id = :id AND comment_user_id = :user_comment";
    $stmt = $conn->prepare($queryGetComment);
    $result = $stmt->execute(array(
        'id'            => $post_id,
        'user_comment'  => $user_comment_id
    ));
    if($result)
    {
        $comment = $stmt->fetchAll();
        foreach ($comment as $elem)
        {
            echo '<strong>' . getUsername($user_comment_id) . '</strong>' . ' ' . ucfirst($elem['comment']) . '<br>';
        }
    }
}

function getUserTotalPost($user_id)
{
    global $conn;
    $queryGetUserTotalPost = "SELECT img_id FROM camera_img WHERE user_id = :user_id";
    $stmt = $conn->prepare($queryGetUserTotalPost);
    $result = $stmt->execute(array(
        'user_id'   => $user_id
    ));
    if($result)
    {
        $count = $stmt->rowCount();
        return $count;
    }
}

function getUserTotalCommentNum($user_id)
{
    global $conn;
    $queryGetTotalCommentNum = "SELECT id FROM post_comment WHERE post_user_id = :user_id";
    $stmt = $conn->prepare($queryGetTotalCommentNum);
    $result = $stmt->execute(array(
        'user_id'   => $user_id
    ));
    if($result)
    {
        $count = $stmt->rowCount();
        return $count;
    }
}

function getUserTotaLikeNum($user_id)
{
    global $conn;
    $queryGetTotalLikeNum = "SELECT id FROM post_like WHERE post_user_id = :user_id AND status = 1";
    $stmt = $conn->prepare($queryGetTotalLikeNum);
    $result = $stmt->execute(array(
        'user_id'   => $user_id
    ));
    if($result)
    {
        $count = $stmt->rowCount();
        return $count;
    }
}
function getTotalComment($post_id)
{
    global $conn;
    $queryGetNumOfComment = "SELECT comment FROM post_comment WHERE post_id = :post_id";
    $stmt = $conn->prepare($queryGetNumOfComment);
    $result = $stmt->execute(array(
        'post_id'   => $post_id
    ));
    if($result)
    {
        $count = $stmt->rowCount();
        return $count;
    }
}

function getTotalLike($post_id)
{
    global $conn;
    $queryGetNumOfLike = "SELECT id FROM post_like WHERE post_id = :post_id";
    $stmt = $conn->prepare($queryGetNumOfLike);
    $result = $stmt->execute(array(
        'post_id'   => $post_id
    ));
    if($result)
    {
        $count = $stmt->rowCount();
        return $count;
    }
}

function getTotalPost()
{
    global $conn;
    $queryGetTotalPost = "SELECT img_id FROM camera_img";
    $stmt = $conn->prepare($queryGetTotalPost);
    $result = $stmt->execute();
    if($result)
    {
        $count = $stmt->rowCount();
        return $count;
    }
}

function getUserCommentNum($post_id, $user_id)
{
    global $conn;
    $queryGetNumOfComment = "SELECT comment FROM post_comment WHERE post_id = :post_id AND comment_user_id = :user_id";
    $stmt = $conn->prepare($queryGetNumOfComment);
    $result = $stmt->execute(array(
        'post_id'   => $post_id,
        'user_id'   => $user_id
    ));
    if($result)
    {
        $count = $stmt->rowCount();
        return $count;
    }
}

function checkUserLike($post_id, $user_id)
{
    global $conn;
    $queryCheckUserLike = "SELECT status FROM post_like WHERE post_id = :post_id AND like_user_id = :like_user_id";
    $stmt = $conn->prepare($queryCheckUserLike);
    $result = $stmt->execute(array(
        'post_id'       => $post_id,
        'like_user_id'  => $user_id
    ));
    if($result)
    {
        $count = $stmt->rowCount();
        return $count;
    }

}


function UserLikeData($post_id)
{
    global $conn;

    $queryDisplayUserLikeImg = "SELECT users.id AS user_id, users.user_img, users.username, users.email FROM users LEFT JOIN post_like ON users.id = post_like.like_user_id WHERE post_like.post_id = :post_id LIMIT 0,5";
    $stmt = $conn->prepare($queryDisplayUserLikeImg);
    $result = $stmt->execute(array(
        'post_id'   => $post_id
    ));
    $count = $stmt->rowCount();
    if($result && $count > 0)
    {
        $data_user = $stmt->fetchAll();
        foreach ($data_user as $elem_user) {
            echo '<li><a href="user_profile.php?user='.$elem_user['user_id'].'"><img src="'.$elem_user['user_img'].'" class="img-fluid rounded-circle" alt="'.$elem_user['username'].'"></a></li>';
        }
    }
}
?>