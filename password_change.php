<?php require_once 'controllers/authController.php';?>
<?php require_once 'include/header.php'; ?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-div login">
                <form action="password_change.php" method="post">
                    <h3 class="text-center">Reset Your Password</h3>
                    <?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="password">Confirm Password</label>
                        <input type="password" name="passwordConf" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="resetPassword-btn" class="btn btn-warning btn-block btn-lg">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require_once 'include/footer.php'; ?>