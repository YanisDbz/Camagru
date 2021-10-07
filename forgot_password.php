<?php require_once 'controllers/authController.php';?>
<?php require_once 'include/header.php'; ?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-div login">
                <form action="forgot_password.php" method="post">
                    <h3 class="text-center">Forgot Password</h3>
                    <p>
                        Please enter your email address you used to sign up on TYS
                        and we will assist you in recovering your password.
                    </p>
                    <?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg">
                    </div> 
                    <div class="form-group">
                        <button type="submit" name="forgot-btn" class="btn btn-warning btn-block btn-lg">Recover Your Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require_once 'include/footer.php';?>