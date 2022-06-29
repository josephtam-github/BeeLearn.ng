<?php 
require_once './php/user-controller.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> Reset Password | BeeLearn.ng </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
	<meta name="keywords" content="Sign up School, University, Education, Jamb CBt, School news, Nigerian, Syllabus, Textbooks, Admission, Portal, Video Tutorial">
	<meta name="description" content="Reset Password | BeeLearn.ng">
	<link rel="icon" href="images/icon.png">
	<script src="https://kit.fontawesome.com/f71a44a4e4.js"crossorigin="anonymous"></script>
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">-->
	<link rel="stylesheet" href="./scss/custom.css">
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center my-5">
        <div class="border border-3 rounded-1 p-5 bg-white">
          <?php if (isset($_GET["resetToken"]) && isset($_GET["id"])): ?>
            <?php   $emailResetToken = $_GET["resetToken"];
					$tokenid = $_GET["id"]; 
                	$query = "SELECT * FROM beelearn.tokendetail WHERE tokenid = $tokenid";
					$result = $userdb->query($query);
					$token_array = $result->fetch_assoc();
					$time_expired = $token_array['time_expired'];
					$resetToken = $token_array['token'];
					$userid = $token_array['id'];
				 ?>
			<?php endif; ?>
			<?php if ($resetToken === $emailResetToken): ?>
					<?php if (time() <= strtotime($time_expired)):?>
						<img src='images/email_page.svg' class='card-image d-block w-50 m-auto' alt='change password background'>
						<form action='<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
							<h2 class='text-center'>Type in your new password</h2>
							<div class='form-group my-3'>
								<label class='lead' for='password'>New password</label>
									<input type='hidden' name='id' value='<?php echo $userid ;?>'>
								<div class='<?php echo $passwordstate ;?> d-flex align-items-center relative'>
									<input id='idPassword' type='password' name='password' value='<?php echo $password; ?>' class='form-control form-control-lg'>
									<i id='eye1' onclick='toggleEye(this)()' class='fas fa-eye btn'></i>
									<i class='<?php $passwordicon; ?> m-2'></i>
								</div> <?php echo $errors['password-required'] , $errors['password-short'], $errors["password-used"]; ?> </div>
							<div class='form-group my-3'>
								<label class='lead'  for='confirmpassword'>Confirm new password</label>
								<div class='<?php echo $confstate ;?> d-flex align-items-center relative'>
									<input id='idConfPassword' type='password' name='confpassword' value='<?php echo $confpassword ;?>' class='form-control form-control-lg'>
									<i id='eye2' onclick='toggleEye(this)()' class='fas fa-eye btn'></i>	
									<i class='<?php $confpasswordicon ?> m-2'></i>
								</div> <?php echo $errors["conf-empty"] , $errors["password-mismatch"] ;?></div>
							<div class='form-group text-center mt-5'>
                   			<button type='submit' name='changepword-btn' class='btn btn-warning warning-hover fw-bold my-3 p-2'>Change</button>
					   		<p class='text-warning text-center fw-bold'>Hint: Choose something you'll remember!</p>
                			</div>
          			  	</form>  
					<?php endif; ?>
					<?php if (time() >= strtotime($time_expired)): ?>
						<h4 class='font-montserrat text-lead'> Your token has expired. Please try agian <a class='text-decoration-none text-warning' href='forgotpassword.php'>here.</a> <h4>
					<?php endif; ?>
			<?php endif; ?>	
			<?php if ($resetToken !== $emailResetToken): ?>
					<h4 class='font-montserrat text-lead'> Your token is invalid please ensure you clicked or copied the correct link <h4>
			<?php endif; ?>         
            <?php  if (!isset($_GET["resetToken"])): ?>
				<?php 
				header("location: ./forgotpassword.php");
				 ?>
			<?php endif; ?>
        </div>
    </div>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>-->
	<script src="./scripts/navbar.js"></script>
	<script src="./scripts/form.js"></script>
	<script src="./bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>