<?php
session_start();
$page = $_SERVER['PHP_SELF'];
switch ($page)
{
    case 'index.php':
        $title = "Take Your shoot";
        break;
    
    case 'login.php':
        $title = "TYS Login";
        break;
    case 'signup.php':
        $title = "TYS Register";
        break;
    case 'forgot_password.php':
        $title = 'TYS Forgot Password';
        break;
    case 'password_change.php':
        $title = 'TYS Change Password';
        break;
    case 'password_message.php':
        $title = 'TYS Message Password';
        break;
    default:
        $title = "Take Your Shoot";
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css?version=<?php echo time();?>">
    <title><?php echo $title;?></title>
</head>
<?php if(isset($_SESSION['username'])) :?>
<nav class="navbar navbar-expand-sm bg-warning navbar-light">
    <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link pl-0" href="index.php">Take Your Shoot</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php"><?= ucwords($_SESSION['username']) ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        <a href="camera.php" class="navbar-brand mx-auto d-block text-center order-0 order-md-1 w-25"><i class="fa fa-camera fa-2x"></i></a>
    </div>
</nav>
<?php else: ?>
<nav class="navbar navbar-expand-sm bg-warning navbar-light">
    <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link pl-0" href="index.php">Take Your Shoot</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signup.php">Register</a>
                </li>
            </ul>
        <a href="camera.php" class="navbar-brand mx-auto d-block text-center order-0 order-md-1 w-25"><i class="fa fa-camera fa-2x"></i></a>
    </div>
</nav>
<?php endif; ?>