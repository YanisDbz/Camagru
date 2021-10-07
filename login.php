<?php
require_once 'controllers/authController.php';
require_once 'include/header.php'; 
if(isset($_SESSION['username']))
    header("location: profile.php");
if (isset($_GET['token']) AND !empty($_GET['token']))
{
    $token = htmlspecialchars($_GET['token']);
    verifyUser($token);
}
if (isset($_GET['password-token']) AND !empty($_GET['password-token']))
{
    $passwordToken = htmlspecialchars($_GET['password-token']);
    resetPassword($passwordToken);
}
?>
<body>
<?php if(isset($_SESSION['message'])):?>
    <div class="alert <?php echo $_SESSION['alert-class'];?> text-center">
        <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            unset($_SESSION['alert-class']);
        ?>
    </div>
<?php endif; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-div login">
                <form action="login.php" method="post">
                    <h3 class="text-center">Login</h3>
                    <?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="username">Username or Email</label>
                        <input type="text" name="username" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="login-btn" class="btn btn-warning btn-block btn-lg">Login</button>
                    </div>
                    <p class="text-center">Not yet a member ? <a href="signup.php" class="text-warning"> Sign Up</a></p>
                    <div style="font-size: 0.8em; text-align: center;">
                        <a class="text-warning" href="forgot_password.php"> Forgot password ?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require_once 'include/footer.php' ;?>