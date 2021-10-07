<?php
session_start();
require_once 'config/database.php';
require_once 'emailController.php';
require_once 'cameraController.php';
require_once 'commentController.php';
require_once 'likeController.php';
require_once 'function/functions.php';

$errors = array();
$message = "";
$username = "";
$email = "";

/* Register Config */
if (isset($_POST['signup-btn']))
{
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $passwordConf = htmlspecialchars($_POST['passwordConf']);

    if(empty($username)){
        $errors['username'] = "Username Required";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Email Address Wrong Format";
    }

    if(empty($email)){
        $errors['email'] = "Email Required";
    }

    if(empty($password) || empty($passwordConf)){
        $errors['password'] = "Password Required";
    }

    if($password !== $passwordConf){
        $errors['passwordMatch'] = "Password Don't Match";
    }

    if (strlen($password) < 8 || strlen($password) > 16){
        $errors['passwordLen'] = "Password should be min 8 characters and max 16 characters";
    }

    if (!preg_match("/\d/", $password)){
        $errors['passwordDigit'] = "Password should contain at least one number";
    }

    if (!preg_match("/[A-Z]/", $password)){
        $errors['passwordCapital'] = "Password should contain at least one Capital Letter";
    }

    if (!preg_match("/[a-z]/", $password)){
        $errors['passwordSmall'] = "Password should contain at least one small Letter";
    }

    if (!preg_match("/\W/", $password)){
        $errors['passwordSpecial'] = "Password should contain at least one special character";
    }

    if (preg_match("/\s/", $password)){
        $errors['passwordSpace'] = "Password should not contain any white space";
    }

    $emailQuery = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $conn->prepare($emailQuery);
    $stmt->execute(array(
        'email' => $email
    ));
    $count = $stmt->rowCount();
    $stmt = null;
    if($count > 0){
        $errors['email'] = "Email already exists";
    }
    $emailUsername = "SELECT * FROM users WHERE username = :username LIMIT 1";
    $stmt = $conn->prepare($emailUsername);
    $stmt->execute(array(
        'username' => $username
    ));
    $count = $stmt->rowCount();
    $stmt = null;
    if($count > 0){
        $errors['username'] = "Username Already exists";
    }

    if(count($errors) === 0)
    {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50));
        $verified = 0;
        $notification = 1;
        $queryInsert = "INSERT INTO users (username, email, verified, token, password, notification) VALUES (:username, :email, :verified, :token, :password, :notification)";
        $stmt = $conn->prepare($queryInsert);
        $ret = $stmt->execute(array(
            'username'      => $username,
            'email'         => $email,
            'verified'      => $verified,
            'token'         => $token,
            'password'      => $password,
            'notification'  => $notification
        ));
        if($ret)
        {
            sendVerificationEmail($email, $token);
            $_SESSION['message'] = 'Account created successfully check your mail to activate your account';
            $_SESSION['alert-class'] = 'alert-success';
            header('location: login.php');
            exit();
        }
        else
        {
            $errors['db_error'] = "Database Error: failed to register";
        }
        $stmt = null;
    }
}


/* Login Config */
if (isset($_POST['login-btn']))
{
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    if(empty($username)){
        $errors['username'] = "Username Required";
    }
    if(empty($password)){
        $errors['password'] = "Password Required";
    }
    if(count($errors) === 0)
    {
        $queryLogin = "SELECT * FROM users WHERE email = :email OR username = :username LIMIT 1";
        $stmt = $conn->prepare($queryLogin);
        $stmt->execute(array(
            'email'     => $username,
            'username'  => $username
        ));
        $user = $stmt->fetch();
        if(password_verify($password, $user['password']))
        {
            if($user['verified'] == 0)
            {
                $_SESSION['message'] = 'Account not confirmed, please check your mail';
                $_SESSION['alert-class'] = 'alert-danger';
                header('location: login.php');
                exit();
            }
            else
            {
                $user_id = $user['id'];
                $queryUpdateTime = "UPDATE users set log_date = NOW() where id = '$user_id'";
                $conn->exec($queryUpdateTime);
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['log_date'] = $user['log_date'];
                $_SESSION['verified'] = $user['verified'];
                $_SESSION['user_img'] = $user['user_img'];
                $_SESSION['notification'] = $user['notification'];
                $_SESSION['message'] = 'You are now logged in !';
                $_SESSION['alert-class'] = 'alert-success';
                header('location: profile.php');
                exit();
            }
        }
        else{
            $errors['db_error'] = "Wrong Creditentials";
        }
    }
    $stmt = null;
}

/* Forgot Password as Login */
if (isset($_POST['forgot-btn']))
{
    $email = htmlspecialchars($_POST['email']);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Email Address Wrong Format";
    }
    if(empty($email)){
        $errors['email'] = "Email Required";
    }

    if(count($errors) == 0)
    {
        $queryMail = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($queryMail);
        $stmt->execute(array(
            'email'     => $email
        ));
        $user = $stmt->fetch();
        $token = $user['token'];
        sendPasswordResetLink($email, $token);
        header('location: password_message.php');
        exit(0);
    }
    $stmt = null;
}

/* Reset Password  */
if(isset($_POST['resetPassword-btn']))
{
    $password = htmlspecialchars($_POST['password']);
    $passwordConf = htmlspecialchars($_POST['passwordConf']);

    if(empty($password) || empty($passwordConf)){
        $errors['password'] = "Password Required";
    }

    if($password !== $passwordConf){
        $errors['password'] = "Password Don't Match";
    }

    if (strlen($password) < 8 || strlen($password) > 16){
        $errors['password'] = "Password should be min 8 characters and max 16 characters";
    }

    if (!preg_match("/\d/", $password)){
        $errors['password'] = "Password should contain at least one number";
    }

    if (!preg_match("/[A-Z]/", $password)){
        $errors['password'] = "Password should contain at least one Capital Letter";
    }

    if (!preg_match("/[a-z]/", $password)){
        $errors['password'] = "Password should contain at least one small Letter";
    }

    if (!preg_match("/\W/", $password)){
        $errors['password'] = "Password should contain at least one special character";
    }

    if (preg_match("/\s/", $password)){
        $errors['password'] = "Password should not contain any white space";
    }

    if(count($errors) == 0)
    {
        $email = $_SESSION['email'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $queryUpdatePassword = 'UPDATE users SET password = :password WHERE email = :email';
        $stmt = $conn->prepare($queryUpdatePassword);
        $result = $stmt->execute(array(
            'password'  => $password,
            'email'     => $email
        ));
        if($result)
        {
            $_SESSION['message'] = 'Password Changed you can log now';
            $_SESSION['alert-class'] = 'alert-success';
            header('location: login.php');
            exit(0);
        }
    }
    $stmt = null;
}

/* Update User */
if(isset($_POST['update_user_btn']))
{
    $username = htmlspecialchars($_POST['user_username']);
    $email = htmlspecialchars($_POST['user_email']);
    $user_notif = $_POST['user_notfication'];
    $user_img_name = $_FILES['user_img']['name'];
    $user_img_tname = $_FILES['user_img']['tmp_name'];
    $user_img_size = $_FILES['user_img']['size'];
    $fileError = $_FILES['user_img']['error'];

    if(empty($username) && empty($email) && $user_notif == $_SESSION['notification'] && empty($_FILES['user_img']['name'])){
        $errors['allempty'] = "No update done ....";
    }

    if(empty($username)){
        $username = $_SESSION['username'];
    }

    if(empty($email)){
        $email = $_SESSION['email'];
    }
    if($_FILES['user_img']['error'] == 4){
        $user_img_name = $_SESSION['user_img'];
        $status_img = true;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Email Address Wrong Format";
    }
    
    if($user_img_size > 1000000){
        $errors['user_img_size'] = "Your image is too big";
    }
    $emailQuery = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $conn->prepare($emailQuery);
    $stmt->execute(array(
        'email' => $email
    ));
    $count = $stmt->rowCount();
    $user = $stmt->fetch();
    if($count > 0)
    {
        if($user['email'] == $_SESSION['email'])
            $Verified_status = 1;
        else
            $errors['emailSame'] = "Email already exist";

    }
    else{
        $Verified_status = 0;
    }
    $stmt = null;
    $usernameCheckQuery = "SELECT * FROM users WHERE username = :username LIMIT 1";
    $stmt = $conn->prepare($usernameCheckQuery);
    $stmt->execute(array(
        'username' => $username
    ));
    $count = $stmt->rowCount();
    $user = $stmt->fetch();
    if($count > 0 )
    {
        if($user['username'] != $_SESSION['username'])
        {
            $Verified_status = 0;
            $errors['usernameSame'] = "Username already exists";
        }
    }

    if(count($errors) === 0)
    {
        if($status_img == false){
            unlink($_SESSION['user_img']);
            $user_img_destination = 'web/user_img/'.$user_img_name;
        }
        else{
            $user_img_destination = $user_img_name;
        }
        $password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50));

        move_uploaded_file($user_img_tname, $user_img_destination);
        if($Verified_status  == 1)
        {
            $queryUpdateUserData = "UPDATE users SET username = :username, email = :email, notification = :notification, user_img = :user_img WHERE id = :id";
            $stmt = $conn->prepare($queryUpdateUserData);
            $check = $stmt->execute(array(
                'username'      => $username,
                'email'         => $email,
                'notification'  => $user_notif,
                'id'            => $_SESSION['id'],
                'user_img'      => $user_img_destination
            ));
        }
        else
        {
            $queryUpdateUserData = "UPDATE users SET username = :username, email = :email, verified = :verified, token = :token, notification = :notification, user_img = :user_img WHERE id = :id";
            $stmt = $conn->prepare($queryUpdateUserData);
            $check = $stmt->execute(array(
                'username'      => $username,
                'email'         => $email,
                'verified'      => 0,
                'token'         => $token,
                'notification'  => $user_notif,
                'id'            => $_SESSION['id'],
                'user_img'      => $user_img_destination
            ));
        }
        if($check)
        {
            $user_id = $_SESSION['id'];
            $_SESSION['id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['verified'] = $Verified_status;
            $_SESSION['notification'] = $user_notif;
            $_SESSION['user_img'] = $user_img_destination;
            $_SESSION['message'] = 'Account Have been updated';
            $_SESSION['alert-class'] = 'alert-success';
            if($Verified_status != 1){
                sendVerificationEmail($email, $token);
            }
            header("location: profile_settings.php");
            exit();
        }
        else
        {
            $errors['db_error'] = "Database Error: failed to register";
        }
        $stmt = null;
    }
}

/* Change Password User Logged */

if(isset($_POST['change_pwd_btn']))
{
    $password = $_POST['new_pwd'];
    $passwordConf = $_POST['new_pwd_conf'];

    if(empty($password) || empty($passwordConf)){
        $errors['passwordRequired'] = "Password Required";
    }

    if($password !== $passwordConf){
        $errors['passwordMatch2'] = "Password Don't Match";
    }

    if (strlen($password) < 8 || strlen($password) > 16){
        $errors['passwordLen2'] = "Password should be min 8 characters and max 16 characters";
    }

    if (!preg_match("/\d/", $password)){
        $errors['passwordDigit2'] = "Password should contain at least one number";
    }

    if (!preg_match("/[A-Z]/", $password)){
        $errors['passwordCapital2'] = "Password should contain at least one Capital Letter";
    }

    if (!preg_match("/[a-z]/", $password)){
        $errors['passwordSmall2'] = "Password should contain at least one small Letter";
    }

    if (!preg_match("/\W/", $password)){
        $errors['passwordSpecial2'] = "Password should contain at least one special character";
    }

    if (preg_match("/\s/", $password)){
        $errors['passwordSpace2'] = "Password should not contain any white space";
    }
    if(count($errors) === 0)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $queryUpdatePassword = 'UPDATE users SET password = :password WHERE id = :id';
        $stmt = $conn->prepare($queryUpdatePassword);
        $result = $stmt->execute(array(
            'password'  => $password,
            'id'        => $_SESSION['id']
        ));
        if($result)
        {
            $_SESSION['message'] = 'Password Changed';
            $_SESSION['alert-class'] = 'alert-success';
            header("location: profile.php");
            exit(0);
        }

    }
    $stmt = null;
}

/* Delete Profile pic */
if(isset($_POST['delete_img_profile']))
{
    $img_id = $_POST['img_id'];
    $user_id = $_POST['user_id'];
    $img = $_POST['img_path'];
    $queryDeleteProfileImg = "DELETE FROM camera_img WHERE img_id = :img_id AND user_id = :user_id LIMIT 1";
    $stmt = $conn->prepare($queryDeleteProfileImg);
    $res = $stmt->execute(array(
        'img_id'    => $img_id,
        'user_id'   => $user_id
    ));
    if($res)
    {
        unlink($img);
        unlink($overlay);
        unlink($img_file);
        $_SESSION['message'] = 'Picture have beeen deleted';
        $_SESSION['alert-class'] = 'alert-success';
        header('location: profile.php');
        exit(0);
    }
}
?>