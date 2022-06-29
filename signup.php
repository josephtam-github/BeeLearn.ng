<?php require_once './php/user-controller.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> Sign up | BeeLearn.ng </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
	<meta name="keywords" content="Sign up School, University, Education, Jamb CBt, School news, Nigerian, Syllabus, Textbooks, Admission, Portal, Video Tutorial">
	<meta name="description" content="Sign up | BeeLearn.ng">
	<link rel="icon" href="images/icon.png">
	<script src="https://kit.fontawesome.com/f71a44a4e4.js"crossorigin="anonymous"></script>
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">-->
	<link rel="stylesheet" href="./scss/custom.css">
</head>
<body>
	<div class="shadow-sm container-fluid p-0">
		<div class="d-block d-md-flex justify-content-between align-items-center px-md-3">
			<a href="./home.php"><img id="logo" class="py-3 d-block" src="./images/BeeLearn.svg"></a>
			<div class="d-flex bg-md-warning bg-md-none align-items-center justify-content-end">
				<button type="button" class="btn btn-dark text-warning rounded-circle m-2" onclick="toggleSearchHide()"><i class="fas fa-search"></i></button>
				<?php 
					if (isset($_SESSION['id'])) {
						echo "<a href='./settings.php'><button class='btn btn-dark text-warning m-2 rounded-circle d-none d-md-block' ><i class='fas fa-cog'></i></button></a>";
					} else {
						echo "<a href='./signup.php'><button class='btn btn-dark text-warning m-2 rounded-circle' ><i class='fas fa-user'></i></button></a>";
					}
				?>				
				<div><button onclick="toggleNavHide()" class="align-self-center btn btn-dark text-warning rounded-circle d-md-none m-2"><i id="iconchange1" class="fas fa-bars"></i></button></div>		
				<a href="home.php?logout=1">
				<?php if(isset($_SESSION['logout-btn'])) { echo  $_SESSION['logout-btn']; } ?>
				</a>
			</div>
		</div>
	</div>

	<div class="text-center container-fluid justify-content-between d-flex z-index-1000"	>
		<div class="py-2  align-items-center animate-zoom-12" id="eToggleObject2" ><form><input class="form-control border-warning" type="text" placeholder="search"></form></div>
	</div>

	<nav class="d-none d-md-flex nav nav-tabs nav-justified text-dark shadow-sm sticky-top">
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="./home.php">HOME</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="./news.php">NEWS</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="./explore.php">EXPLORE</a>
	 	<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="./tips.php">TIPS</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="./download.php">DOWNLOAD</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="./about.php">ABOUT&nbsp;US</a>
	</nav>

	<div id="eToggleObject1" class="shadow-sm d-md-none container-fuid">
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-2 border-top" href="./home.php">HOME</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-4" href="./news.php">NEWS</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-6" href="./explore.php">EXPLORE</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-8" href="./tips.php">TIPS</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-10" href="./download.php">DOWNLOAD</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-12" href="./about.php">ABOUT&nbsp;US</a>
		<?php 
			if (isset($_SESSION['id'])) {
				echo "<a class='text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-14' href='./settings.php'>SETTINGS</a>";
				}
		?>		
	</div>

    <div class="container-fluid d-flex justify-content-center align-items-center my-5">
        <div class="border border-3 rounded-1 p-5">
            <img src="images/email_page.svg" class="card-image d-block w-75 m-auto" alt="email sign up background">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <h2 class="text-center">Sign Up for our full user experience</h2>
                <div class="form-group my-3">
                    <label class="lead"  for="username">Username</label>
					<div class="<?php echo $usernamestate ?> d-flex align-items-center">
            			<input type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
						<i class="<?php echo $usernameicon ?> m-2"></i>
					</div>
					<?php echo $errors["username-required"] ?>
					<?php echo $errors["username-rule"] ?>
					<?php echo $errors["username-length"] ?>
					<?php echo $errors["username-used"] ?>
                </div>
                <div class="form-group my-3">
                    <label class="lead"  for="email">Email</label>
					<div class="<?php echo $emailstate ?> d-flex align-items-center">
                   		<input type="email" name="email" value="<?php echo $email; ?>" class="form-control form-control-lg" placeholder="example@mail.com">
						<i class="<?php echo $emailicon ?> m-2"></i>
					</div>
					<?php echo $errors["email-invalid"] ?>
					<?php echo $errors["email-required"] ?>
					<?php echo $errors["email-used"] ?>
                </div>
                <div class="form-group my-3">
                    <label class="my-1 lead" for="mobile">Mobile Number<small class="text-muted mx-none mx-md-3 d-block d-md-flex">(this field is optional)</small></label>
					<div class="<?php echo $mobilestate ?> d-flex align-items-center">
                   		<input type="number" name="mobile" value="<?php echo $mobile; ?>" class="form-control form-control-lg">
						<i class="<?php echo $mobileicon ?> m-2"></i>
					</div>
					<?php echo $errors["mobile-pattern"] ?>
					<?php echo $errors["mobile-used"] ?>
                </div>
                <div class="form-group my-3">
                    <label class="lead" for="password">Password</label>
					<div class="<?php echo $passwordstate ?> d-flex align-items-center relative">
                    	<input id="idPassword" type="password" name="password" value="<?php echo $password; ?>" class="form-control form-control-lg">
						<i id="eye1" onclick="toggleEye(this)" class="fas fa-eye btn"></i>
						<i class="<?php echo $passwordicon ?> m-2"></i>
					</div>
					<?php echo $errors["password-required"] ?>
					<?php echo $errors["password-short"] ?>
                </div>
                <div class="form-group my-3">
                    <label class="lead"  for="confirmpassword">Confirm Password</label>
					<div class="<?php echo $confstate ?> d-flex align-items-center relative">
                    	<input id="idConfPassword" type="password" name="confpassword" value="<?php echo $confpassword; ?>" class="form-control form-control-lg">
						<i id="eye2" onclick="toggleEye(this)" class="fas fa-eye btn"></i>	
						<i class="<?php echo $confpasswordicon ?> m-2"></i>
					</div>
					<?php echo $errors["conf-empty"] ?>
					<?php echo $errors["password-mismatch"] ?>
                </div>
                <div class="form-group my-3">
                    <label class="my-1 lead" for="gender">Gender</label>
					<div class="form-check">
					<label class="form-check-label">
						<input type="radio" class="form-check-input" name="gender" value="male" checked>Male
					</label>
					<label class="form-check-label ms-5">
						<input type="radio" class="form-check-input" name="gender" value="female">Female
					</label>
					</div>
                </div>
				<small class="text-muted">
				* Username must have only letters, numbers, underscore (no whitespace) and contain a minimum of 5 characters<br>
				* The email you enter must be valid<br>
				* The mobile number you enter must match the Nigerian telephone pattern<br>
				* Password should be at least 6 characters long<br>
				</small>
                <div class="form-group text-center mt-5">
                   <button type="submit" name="signup-btn" class="btn btn-warning warning-hover fw-bold my-3 p-2">Submit</button>
				   <p class="text-warning text-center fw-bold">Already a memeber? <a href="./login.php" class="text-decoration-none">Log In</a></p>
                </div>
            </form>   
        </div>
    </div>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>-->
	<script src="./scripts/navbar.js"></script>
	<script src="./scripts/form.js"></script>
	<script src="./bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>