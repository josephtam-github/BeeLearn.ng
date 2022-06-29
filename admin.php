<?php require_once './php/user-controller.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin | BeeLearn.ng</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
	<link rel="icon" href="images/icon.png">
	<script src="https://kit.fontawesome.com/f71a44a4e4.js"crossorigin="anonymous"></script>
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">-->
	<link rel="stylesheet" href="./scss/custom.css">
</head>
<body class="bg-dark">
    <div class="container-fluid d-flex justify-content-center align-items-center my-5">
        <div class="border border-3 border-warning rounded-1 p-5 bg-dark text-white">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <h3 class="text-center">Admin Login</h3>
				<?php echo $errors["wrong-credentials"], $errors["password-mismatch"] ?>
                <div class="form-group my-3">
                    <label for="email">Email or Username</label>
					<div class="<?php echo $emailstate ?> d-flex align-items-center">
                   		<input type="text" name="email" value="<?php echo $email; ?>" class="form-control form-control-lg">
						<i class="<?php echo $emailicon ?> m-2"></i>
					</div>
					<?php echo $errors["email-required"] ?>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
					<div class="<?php echo $passwordstate ?> d-flex align-items-center relative">
                    	<input id="idPassword" type="password" name="password" value="<?php echo $password; ?>" class="form-control form-control-lg">
						<i id="eye1" onclick="toggleEye(this)()" class="fas fa-eye btn"></i>
						<i class="<?php echo $passwordicon ?> m-2"></i>
					</div>
					<?php echo $errors["password-required"] ?>
                </div>
                <div class="form-group text-center mt-4">
                   <button type="submit" name="admin-login-btn" class="border border-warning btn btn-dark warning-hover fw-bold p-2 text-warning">Submit</button>
                </div>
			</form>   
        </div>
    </div>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>-->
	<script src="./scripts/form.js"></script>
	<script src="./bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>