<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
} 
include 'Authentication/notauthenticated.php';
?>
<!DOCTYPE html>
<html lang="en">  

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Luo Catering Reservation</title>
    <link href="statics/css/bootstrap.min.css" rel="stylesheet">
    <script src="statics/js/bootstrap.js"></script>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background-image: url('LuoPictures/Luo1.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-5">
            <div class="card p-3 shadow-lg">
                <div class="text-center" style="color:black;">
                    <p><h3><Strong> <i class="fa fa-user-plus"></i> Create your account </strong></h3></p>
                </div>
                <?php if (isset($_SESSION['errors'])): ?>
                <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['errors'];
                    unset($_SESSION['errors']);
                    ?>
                </div>
                <?php endif; ?>

                <form class="form" action="register.php" method="POST">
                    <div class="mb-2">
                        <label class="form-label"><i class="fa fa-user"></i> First name</label>
                        <input type="text" class="form-control" name="firstname" required />
                    </div>
                    <div class="mb-2">
                        <label class="form-label"><i class="fa fa-user"></i> Last name</label>
                        <input type="text" class="form-control" name="lastname" required />
                    </div>
                    <div class="mb-2">
                        <label class="form-label"><i class="fa fa-phone"></i> Phone number</label>
                        <input type="text" class="form-control" name="phonenum" required />
                    </div>
                    <div class="mb-2">
                        <label class="form-label"><i class="fa fa-user"></i> Username</label>
                        <input type="text" class="form-control" name="username" required />
                    </div>
                    <div class="mb-2">
                        <label class="form-label"><i class="fa fa-lock"></i> Password</label>
                        <input type="password" class="form-control" name="password" required />
                    </div>
                    <div class="mb-2">
                        <label class="form-label"><i class="fa fa-lock"></i> Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" required />
                    </div>
                    <div class="mb-2 text-end">
                        <a href="signin.php"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
