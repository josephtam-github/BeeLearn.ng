<?php
require_once './php/user-controller.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Downloads | BeeLearn.ng</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
	<meta name="keywords" content="School news, University news, Education, Jamb CBT, UTME, WAEC NECO, School news, Nigerian, Syllabus, Textbooks, Admission, Portal, Video Tutorial">
	<meta name="description" content="Latest School News, JAMB, UTME, WAEC, NECO, GCE, NABTEB, Nigerian Universities, Colleges, Polythecnic, Pratice Quiz and Learning material">
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
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="./download.php">DOWNLOAD</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="./home.php">HOME</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="./news.php">NEWS</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="./explore.php">EXPLORE</a>
	 	<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="./tips.php">TIPS</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="./about.php">ABOUT&nbsp;US</a>
	</nav>

	<div id="eToggleObject1" class="shadow-sm d-md-none container-fuid">
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-2 border-top" href="./download.php">DOWNLOAD</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-4" href="./home.php">HOME</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-6" href="./news.php">NEWS</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-8" href="./explore.php">EXPLORE</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-10" href="./tips.php">TIPS</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-12" href="./about.php">ABOUT&nbsp;US</a>
		<?php 
			if (isset($_SESSION['id'])) {
				echo "<a class='text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-14' href='./settings.php'>SETTINGS</a>";
				}
		?>		
	</div>
	<div class="row mx-0 align-items-center">
		<div class="col-6">
		<img src="./images/download_banner.png" alt="Download for All devices" class="d-block w-100">		
		</div>
		<div class="col-6">
		<p style="font-size: 3.5vw" class="text-center font-montserrat pe-5">The best contents for the best learners</p>
		</div>
	</div>

	<table class="table table-hover font-monsterrat text-center">
		<thead class="table-head bg-light">
			<tr>
				<th colspan="3">CATEGORIES</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>WAEC</td>
				<td>JAMB</td>
				<td>NECO</td>
			</tr>
			<tr class="bg-light">
				<td>POST-UTME</td>
				<td>LITERATURE</td>
				<td>PAST QUESTIONS</td>
			</tr>
			<tr>
				<td>STUDY TOOLS</td>
				<td>TUTORIALS</td>
				<td>BROCHURES</td>
			</tr>
		</tbody>
	</table>

	<div class="row	mx-0">
		<div class="col-lg-6">
			<div class="pb-2 m-5">
				<h4 class="text-light text-center bg-primary-dark-hover p-0 my-0">WAEC BROCHURE</h4>
				<div class="card p-3 font-montserrat">
					<img src="./images/WBD.jpg" alt="world book day" id="lg-crop" class="card-body card-img d-block w-100 h-md-100">
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="pb-2 m-5">
				<h4 class="text-dark text-center bg-warning-light-hover p-0 my-0">JAMB SYLLABUS</h4>
				<div class="card p-3 font-montserrat">
					<img src="./images/WBD.jpg" alt="world book day" id="lg-crop" class="card-body card-img d-block w-100 h-md-100">
				</div>
			</div>
		</div>
	</div>
	<div class="text-light container-fluid text-center bg-secondary py-2 font-roboto"><i class="fas fa-link mx-2"></i>QUICK LINKS</div>
	<div class="container-fluid bg-dark text-white">
		<div class="d-flex flex-wrap justify-content-center alintext-wrap py-3">
				<a href="#" class="text-decoration-none text-muted text-center mx-5"><small>LEARNERS&nbsp;FORUM</small></a>
				<a href="#" class="text-decoration-none text-muted text-center mx-5"><small>SCHOOL&nbsp;NEWS</small></a>
				<a href="#" class="text-decoration-none text-muted text-center mx-5"><small>UNIVERSITY&nbsp;FORUM</small></a>
				<a href="#" class="text-decoration-none text-muted text-center mx-5"><small>PRIVATE&nbsp;ONLINE&nbsp;CLASS</small></a>
				<a href="#" class="text-decoration-none text-muted text-center mx-5"><small>VIDEO&nbsp;TUTORIALS</small></a>
				<a href="#" class="text-decoration-none text-muted text-center mx-5"><small>NEWS&nbsp;LETTER</small></a>
				<a href="#" class="text-decoration-none text-muted text-center mx-5"><small>SIGN&nbsp;UP&nbsp;TO&nbsp;OUR&nbsp;MAIL</small></a>
				<a href="#" class="text-decoration-none text-muted text-center mx-5"><small>CBT&nbsp;SOFTWARE</small></a>
				<a href="#" class="text-decoration-none text-muted text-center mx-5"><small>FAQ</small></a>
				<a href="#" class="text-decoration-none text-muted text-center mx-5"><small>OUR&nbsp;TEAM</small></a>
				<a href="#" class="text-decoration-none text-muted text-center mx-5"><small>CONTACT&nbsp;US</small></a>
				<a href="#" class="text-decoration-none text-muted text-center mx-5"><small>AGENT</small></a>
				<a href="#" class="text-decoration-none text-muted text-center mx-5"><small>DONATE</small></a>
		</div>
		<div class="d-flex justify-content-center">
			<a href="#"><i class="fab fa-facebook fa-2x text-muted mx-2"></i></a>
			<a href="#"><i class="fab fa-twitter fa-2x text-muted mx-2"></i></a>
			<a href="#"><i class="fab fa-whatsapp fa-2x text-muted mx-2"></i></a>
			<a href="#"><i class="fab fa-instagram fa-2x text-muted mx-2"></i></a>
		</div>
		<div class="text-center font-montserrat text-muted mt-1">&copy; 
			<?php echo date("Y");?>
			Copyright Created by &CircleDot; prime.designr 
		</div>
	</div>
	<script src="./scripts/navbar.js"></script>
	<script src="./scripts/form.js"></script>
	<script src="./bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>
