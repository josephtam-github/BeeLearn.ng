<?php require_once './php/user-controller.php' ;
	if (!isset($_SESSION["id"])) {
		header("location: login.php?logout=1");
		exit();
	} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> Settings | BeeLearn.ng </title>
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

	<?php
		echo $errors["username-required"], $errors["username-rule"], $errors["username-length"], $errors["email-invalid"], $errors["email-required"], $errors["email-used"], $errors["mobile-pattern"], $errors["mobile-used"], $errors['wrong-credentials'], $errors["password-required"], $errors["password-short"], $errors["conf-empty"], $errors["password-mismatch"], $errors["file-type"], $errors["file-format"], $errors["file-size"], $errors["unknown-error"], $success["update"] ;
	?>
    <div class="container-fluid d-flex justify-content-center align-items-center my-3">
        <div class="border border-3 rounded-1 p-3 p-md-5">
			<h3 class="text-center mt-2 pb-3">Hello <?php echo $_SESSION['username']; ?>, let's make some changes</h3>
			<button id="expand-dp" type="button" class = "d-none" data-bs-toggle = "modal" data-bs-target = "#myModal1"> View image </button>
			<label class="d-block pointer" for="expand-dp"> <!-- label trigggers button to trigger modal -->
				<div style="width:300px; height:300px; clip-path: circle(50%);" class="m-auto">
            		<img src="<?php  
					if (isset($_SESSION["dp"])) {
						echo "./images/".$_SESSION["dp"];
					}
					?>" class="m-auto" style="width:300px;" alt="Profile Picture">
				</div>
			</label>
			
			<hr>
			<!-- modal for expanded profil picture -->
			<div class="modal"  id="myModal1">
				<div class="modal-dialog">
					<div class="modal-content">		
						<div class="modal-header">
							<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
						</div>
						<div class="modal-body">
							<img src="<?php  
								if (isset($_SESSION["dp"])) {
									echo "./images/".$_SESSION["dp"];
								}
								?>" class="card-image d-block w-100 m-auto" alt="full size profile picture">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-warning text-dark fw-bold" data-bs-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>


			<button type="button" class="btn dropdown-toggle fw-bold" onclick="toggleForm(this)">CHANGE PROFILE PICTURE</button>
			<div  style="display: none" class="animate-zoom-4 bg-light p-3">
				<!--Form needs to be sent using an encryption  enctype="multipart/form-data"-->
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" class="my-3">
					<div class="form-group row my-3">
						<input type="file"  name="dp" class="col form-control-file form-control font-montserrat border border-2" accept="image/*" id="dp" required >
						<input type="submit" name="change-dp-btn" value="Upload" style="background-color: #e6e6e6;" class="col-3 btn border border-2">
					</div> 
				</form>
			</div>
			<hr>

			<button type="button" class="btn dropdown-toggle fw-bold" onclick="toggleForm(this)">CHANGE USERNAME</button>
			<div  style="display: none" class="animate-zoom-4 bg-light p-3">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            	    <div class="form-group my-3">
            	        <label class="lead"  for="username">New Username</label>
						<div class="<?php echo $usernamestate ?> d-flex align-items-center">
            				<input type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
							<i class="<?php echo $usernameicon ?> m-2"></i>
						</div>
            	    </div>
					<div class="form-group text-end mt-1">
            	       <button type="submit" name="change-username-btn" class="btn btn-warning warning-hover fw-bold my-1 p-1">Save</button>
            	    </div>
				</form>
			</div>
			<hr>

			<button type="button" class="btn dropdown-toggle fw-bold" onclick="toggleForm(this)">CHANGE EMAIL</button>
			<div  style="display: none" class="animate-zoom-4 bg-light p-3">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            	    <div class="form-group my-3">
            	        <label class="lead"  for="email">Email</label>
						<div class="<?php echo $emailstate ?> d-flex align-items-center">
            	       		<input type="email" name="email" value="<?php echo $email; ?>" class="form-control form-control-lg" placeholder="example@gmail.com">
							<i class="<?php echo $emailicon ?> m-2"></i>
						</div>
            	    </div>
					<div class="form-group text-end mt-1">
            	       <button type="submit" name="change-email-btn" class="btn btn-warning warning-hover fw-bold my-1 p-1">Save</button>
            	    </div>
				</form>
			</div>
			<hr>

			<button type="button" class="btn dropdown-toggle fw-bold" onclick="toggleForm(this)">CHANGE MOBILE NUMBER</button>
			<div  style="display: none" class="animate-zoom-4 bg-light p-3">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            	    <div class="form-group my-3">
            	        <label class="my-1 lead" for="mobile">Mobile Number<small class="text-muted mx-3">(this field is optional)</small></label>
						<div class="<?php echo $mobilestate ?> d-flex align-items-center">
            	       		<input type="number" name="mobile" value="<?php echo $mobile; ?>" class="form-control form-control-lg">
							<i class="<?php echo $mobileicon ?> m-2"></i>
						</div>
            	    </div>
					<div class="form-group text-end mt-1">
            	       <button type="submit" name="change-mobile-btn" class="btn btn-warning warning-hover fw-bold my-1 p-1">Save</button>
            	    </div>
				</form>
			</div>
			<hr>


			<button type="button" class="btn dropdown-toggle fw-bold" onclick="toggleForm(this)">CHANGE PASSWORD</button>
			<div  style="display: none" class="animate-zoom-4 bg-light p-3">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            	    <div class="form-group my-3">
            	        <label class="lead" for="password">Old Password</label>
						<div class="<?php echo $oldpasswordstate ?> d-flex align-items-center relative">
            	        	<input id="idOldPassword" type="password" name="oldpassword" value="<?php echo $oldpassword; ?>" class="form-control form-control-lg">
							<i id="eye3" onclick="toggleEye(this)()" class="fas fa-eye btn"></i>
							<i class="<?php echo $oldpasswordicon ?> m-2"></i>
						</div>
            	    </div>
            	    <div class="form-group my-3">
            	        <label class="lead" for="password">New Password</label>
						<div class="<?php echo $newpasswordstate ?> d-flex align-items-center relative">
            	        	<input id="idNewPassword" type="password" name="newpassword" value="<?php echo $newpassword; ?>" class="form-control form-control-lg">
							<i id="eye4" onclick="toggleEye(this)()" class="fas fa-eye btn"></i>
							<i class="<?php echo $newpasswordicon ?> m-2"></i>
						</div>
            	    </div>
            	    <div class="form-group my-3">
            	        <label class="lead"  for="confirmpassword">Confirm Password</label>
						<div class="<?php echo $confstate ?> d-flex align-items-center relative">
            	        	<input id="idConfPassword" type="password" name="confpassword" value="<?php echo $confpassword; ?>" class="form-control form-control-lg">
							<i id="eye2" onclick="toggleEye(this)()" class="fas fa-eye btn"></i>
							<i class="<?php echo $newpasswordicon ?> m-2"></i>
						</div>
            	    </div>
					<div class="form-group text-end mt-1">
            	       <button type="submit" name="change-password-btn" class="btn btn-warning warning-hover fw-bold my-1 p-1">Save</button>
            	    </div>
				</form>
			</div>
			<hr>

			<button type="button" class="btn dropdown-toggle fw-bold" onclick="toggleForm(this)">CHANGE GENDER</button>
			<div  style="display: none" class="animate-zoom-4 bg-light p-3">			
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            	    <div class="form-group my-3">
            	        <label class="my-1 lead" for="gender">Gender</label>
						<div class="form-check">
						<label class="form-check-label">
							<input type="radio" class="form-check-input" name="gender" value="male" <?php if($_SESSION['gender'] == 'male'){echo 'checked';} ?> >Male
						</label>
						<label class="form-check-label ms-5">
							<input type="radio" class="form-check-input" name="gender" value="female" <?php if($_SESSION['gender'] == 'female'){echo 'checked';} ?> >Female
						</label>
            	    </div>
            	    <div class="text-end">
						<button type="submit" name="change-gender-btn" class="btn btn-warning warning-hover fw-bold my-1 p-1">Save</button>
					</div>
				</form>
			</div>
		</div>
			<hr>
		<div class="text-muted">
			<small>
			* Images must be of formats; jpeg, png & gif <br>
			* Images must be less than 5mb <br>
			* Username must have only letters, numbers, underscore and contain a minimum of 5 characters<br>
			* The email you enter must be valid<br>
			* The mobile number you enter must match the Nigerian telephone pattern<br>
			* Password should be at least 6 characters long<br>
			</small>
		</div>
    </div>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>-->
	<script src="./scripts/navbar.js"></script>
	<script src="./scripts/form.js"></script>
	<script src="./bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>

