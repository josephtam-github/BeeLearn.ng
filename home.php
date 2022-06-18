<?php
require_once 'php/user-controller.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> BeeLearn.ng Educational Platform </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
	<meta name="keywords" content="School, University, Education, Jamb CBT, UTME, WAEC NECO, School news, Nigerian, Syllabus, Textbooks, Admission, Portal, Video Tutorial">
	<meta name="description" content="Latest School News, JAMB, UTME, WAEC, NECO, GCE, NABTEB, Nigerian Universities, Colleges, Polythecnic, Pratice Quiz and Learning material">
	<link rel="icon" href="images/icon.png">
	<script src="https://kit.fontawesome.com/f71a44a4e4.js"crossorigin="anonymous"></script>
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">-->
	<link rel="stylesheet" href="scss/custom.css">
</head>
<body>
	<div class="shadow-sm container-fluid p-0">
		<div class="d-block d-md-flex justify-content-between align-items-center px-md-3">
			<a href="home.php"><img id="logo" class="py-3 d-block" src="images/BeeLearn.svg"></a>
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
		<div class="py-2  align-items-center animate-zoom-12" id="eToggleObject2" ><form><input type="text" placeholder="search"></form></div>
	</div>

	<nav class="d-none d-md-flex nav nav-tabs nav-justified text-dark shadow-sm sticky-top">
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="home.php">HOME</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="news.php">NEWS</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="explore.php">EXPLORE</a>
	 	<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="tips.php">TIPS</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="download.php">DOWNLOAD</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="about.php">ABOUT&nbsp;US</a>
	</nav>

	<div id="eToggleObject1" class="shadow-sm d-md-none container-fuid">
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-2 border-top" href="home.php">HOME</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-4" href="news.php">NEWS</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-6" href="explore.php">EXPLORE</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-8" href="tips.php">TIPS</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-10" href="download.php">DOWNLOAD</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-12" href="about.php">ABOUT&nbsp;US</a>
		<?php 
			if (isset($_SESSION['id'])) {
				echo "<a class='text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-14' href='./settings.php'>SETTINGS</a>";
				}
		?>		
	</div>
			
	<div id="carouselIndicators" class="carousel slide" data-bs-ride="carousel">
		<div class="carousel-indicators">
		  <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
		  <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
		  <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
		</div>
		<div class="carousel-inner">
		  <div class="carousel-item active">
			<img src="images/primary_boy.jpg" class="darken d-block w-100 h-50" alt="Student Learning">
			<div class="carousel-caption">
				<span class="rh-3">Get all your school info here</span>
				<br><span class="rh-1">We will keep you in stream with the latest educational news and headlines </span>
				<br><span class="text-muted rh-1"><a href="www.freepik.com">Images from www.freepik.com </a></span>
			</div>
		  </div>
		  <div class="carousel-item">
			<img src="images/library.jpg" class="darken d-block w-100" alt="Library bookshelf">
			<div class="carousel-caption">
				<span class="rh-3">Browse our library of educational materials</span>
				<br><span class="rh-1">Get the latest books, syllabuses, past questions, manuals and many more!</span>
				<br><span class="text-muted rh-1"><a href="www.freepik.com">Images from www.freepik.com</a></span>
			</div>
		  </div>
		  <div class="carousel-item">
			<img src="images/students_studying.jpg" class="darken d-block w-100" alt="Group of Students Studying">
			<div class="carousel-caption">
				<span class="rh-3">Learn at your comfort and pace.</span>
				<br><span class="rh-1">Get access to our in-depth tutorials and register for our online classes</span>
				<br><span class="text-muted rh-1"><a href="www.freepik.com">Images from www.freepik.com</a></span>
			</div>
		  </div>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators"  data-bs-slide="prev">
		  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		  <span class="visually-hidden">Prev</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators"  data-bs-slide="next">
		  <span class="carousel-control-next-icon" aria-hidden="true"></span>
		  <span class="visually-hidden">Next</span>
		</button>
	</div>

	<div class="container-fluid my-5">
		<div class="row g-2 my-5 align-items-center">
			<div class="col-lg-2 col-md-10 d-lg-block">
				<div class="shadow-sm ">
					<p>advertisement0b</p>
				</div>
			</div>
			<div class="col-md-10 col-lg-8">
				<div class="shadow-sm">
					<div class="d-flex justify-content-center bg-warning-light-hover">
						<h5 class="text-center rh-2">LATEST NEWS ON EDUCATION</h5>
					</div>
					<div id="carouselIndicator2" class="carousel slide" data-bs-ride="carousel">
						<div class="carousel-indicators">
							<button type="button" data-bs-target="#carouselIndicator2" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
							<button type="button" data-bs-target="#carouselIndicator2" data-bs-slide-to="1" aria-label="Slide 2"></button>
							<button type="button" data-bs-target="#carouselIndicator2" data-bs-slide-to="2" aria-label="Slide 3"></button>
						</div>
						<div class="carousel-inner">
							<div class="carousel-item active">
								<a href="./news.php"> <img src="images/Lion.jpg" class="darken d-block w-100 p-3" alt="lion community"> </a>
								<p class="carousel-caption rh-2"> The LION association celebrates anniversery </p>
							</div>
							<div class="carousel-item">
								<a href="./news.php"> <img src="images/undergraduates.jpg" class="darken d-block w-100 p-3" alt="undergraduates"></a>
								<p class="carousel-caption rh-2"> University are struggling with online classes </p>
							</div>
							<div class="carousel-item">
								<a href="./news.php"> <img src="images/Wike.jpg" class="darken d-block w-100 p-3" alt="wike">
								<p class="carousel-caption rh-2"> Gov. Nyesom Wike gives intervention pf N6.1bn </p></a>
							</div>
						</div>
						<button class="carousel-control-prev" data-bs-target="#carouselIndicator2" data-bs-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Prev</span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#carouselIndicator2" data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Next</span>
						</button>
					</div>
					<a href="#" class="text-decoration-none font-montserrat">
						<div class="card rounded-lg m-3" >
							<div class="row align-items-center no-gutters">
								<div class="d-none d-md-block col-4">
									<img src="images/Lion.jpg" class="rounded-lg thumbnail card-img p-3" alt=" lion community">
								</div>
								<div class="card-body col-8">
									<h4 class="card-title rh-2 px-2 px-md-0">The LION community celebrates</h4>
									<p class="card-text text-truncate rh-1 px-2 px-md-0">The LION community of nigeria rejoice as they The LION community of nigeria rejoice as</p>
									<small class="card-text text-muted px-2 px-md-0"><i class="fas fa-clock"></i> 1 minute ago</small>
								</div>
							</div>
						</div>
					</a>
					<a href="#" class="text-decoration-none font-montserrat">
						<div class="card rounded-lg m-3" >
							<div class="row align-items-center no-gutters">
								<div class="col-4 d-none d-md-block">
									<img src="images/Wike.jpg" class="rounded-lg thumbnail card-img p-3" alt="Governor Nyesom Wike">
								</div>
								<div class="card-body col-8">
									<h4 class="card-title rh-2 px-2 px-md-0">Gov. Nyesom Wike Releaeses N6.12Bn</h4>
									<p class="card-text text-truncate rh-1 px-2 px-md-0">THE Governor of Rivers State, Nyesom Ezenwo Wike has openly come out to THE Governor of Rivers State, Nyesom Ezenwo Wike has openly c</p>
									<small class="card-text text-muted px-2 px-md-0"><i class="fas fa-clock"></i> 1 minute ago</small>
								</div>
							</div>
						</div>
					</a>
					<a href="#" class="text-decoration-none">
						<div class="d-flex justify-content-center bg-warning text-dark bg-warning-light-hover">
							<h5 class="px-5 rh-2">What's happening?</h5>
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-2 col-lg-2">
				<div class="shadow-sm">
					<p>advertisement0a</p>
				</div>
			</div>
		</div>

		<div class="row g-2 my-5 align-items-center">
			<div class="col-lg-2 col-md-10 d-lg-block">
				<div class="shadow-sm ">
					<p>advertisement1a</p>
				</div>
			</div>
			<div class="col-lg-8 col-md-10 shadow-sm p-0 ">
				<a href="#" class="text-decoration-none">
					<div class="d-flex justify-content-center bg-primary-dark-hover">
						<h5 class="text-light text-center rh-2">LEARNING HAS NEVER GOTTEN EASIER</h5>
					</div>
				</a>
					<img src="images/videotutorials.svg" class="w-100 d-block" alt="tutorials">
				<a href="#" class="text-decoration-none">
					<div class="card rounded-lg p-3 m-2" >
						<div class="card-body d-flex justify-content-center align-items-center">
							<i class="fas fa-book fa-3x"></i>
						</div>
						<div class="card-body d-flex justify-content-center align-items-center font-montserrat">
							<h4 class="card-text rh-2">Explore our reasources</h4>
						</div>
					</div>
				</a>
				<a href="#" class="text-decoration-none">
					<div class="card rounded-lg p-3 m-2" >
						<div class="card-body d-flex justify-content-center align-items-center">
							<i class="fas fa-film fa-3x"></i>
						</div>
						<div class="card-body d-flex justify-content-center align-items-center font-montserrat">
							<h4 class="card-text rh-2">Wacth our lesson videos</h4>
						</div>
					</div>
				</a>
				<a href="#" class="text-decoration-none">
					<div class="card rounded-lg p-3 m-2" >
						<div class="card-body d-flex justify-content-center align-items-center">
							<i class="fas fa-chalkboard-teacher fa-3x"></i>
						</div>
						<div class="card-body d-flex justify-content-center font-montserrat">
							<h4 class="card-text rh-2">Get a private tutor online </h4>
						</div>
					</div>
				</a>
				<a href="#" class="text-decoration-none">
					<div class="d-flex justify-content-center bg-primary-dark-hover">
						<h5 class="text-light rh-2">Teach me!</h5>
					</div>
				</a>
			</div>
			<div class="col-md-2 col-lg-2">
				<div class="shadow-sm ">
					<p>advertisements1b<p>
				</div>
			</div>
		</div>
		
		<div class="row g-2 my-5 align-items-center">
			<div class="col-lg-2 col-md-10 d-lg-block">
				<div class="shadow-sm ">
					<p>advertisements2a<p>
				</div>
			</div>
			<div class="col-lg-8 col-md-10 shadow-sm p-0 ">
				<div class="d-flex justify-content-center align-items-center bg-warning-light-hover text-dark">
					<h5 class="rh-2">EDU-FORUM</h5>
				</div>
				<div>
					<img src="images/forum.svg" class="w-100 d-block" alt="forum">
				</div>
				<a href="#" class="text-decoration-none">
					<div class="card rounded-lg p-3 m-2" >
						<div class="card-body d-flex justify-content-center align-items-center">
							<i class="fas fa-university fa-3x"></i>
						</div>
						<div class="card-body d-flex justify-content-center align-items-center font-montserrat">
							<h4 class="card-text text-center rh-2">Join the stream and get the latest updates from your university</h4>
						</div>
					</div>
				</a>
				<a href="#" class="text-decoration-none">
					<div class="card rounded-lg p-3 m-2" >
						<div class="card-body d-flex justify-content-center align-items-center">
							<i class="fas fa-users fa-3x"></i>
						</div>
						<div class="card-body d-flex justify-content-center font-montserrat">
							<h4 class="card-text text-center rh-2">Preparing for external exams?<br>No problem we got you covered</h5>
						</div>
						<div class='font-montserrat'>
							<h4 class="text-center rh-1">Be apart our community of active learners, get tips from past students and test yourself with our QuizBee</h6>
						</div>
					</div>
				</a>
				<a href="#" class="text-decoration-none">
					<div class="d-flex justify-content-center bg-warning-light-hover">
						<h5 class="text-dark rh-2">Tell me more!</h5>
					</div>
				</a>
			</div>
			<div class="col-md-2 col-lg-2">
				<div class="shadow-sm ">
					<p>advertisements2b</p>
				</div>
			</div>
		</div>

		<div class="row g-2 my-5 align-items-center">
			<div class="col-lg-2 col-md-10 d-lg-block">
				<div class="shadow-sm ">
					<p>advertisements3a</p>
				</div>
			</div>
			<div class="col-lg-8 col-md-10 shadow-sm p-0 ">
				<div class="d-flex justify-content-center align-items-center bg-primary-dark-hover text-light">
					<h5 class="rh-2">OUR STREAM</h5>
				</div>
				<div>
					<img src="images/community.jpg" class="w-100 d-block" alt="forum">
				</div>
				<a href="#" class="text-decoration-none">
					<div class="card rounded-lg p-3 m-2" >
						<div class="card-body d-flex justify-content-center align-items-center">
							<i class="fas fa-comments fa-3x"></i>
						</div>
						<div class="card-body d-flex justify-content-center font-montserrat">
							<h4 class="card-text text-center rh-2">Explore our ever-growing blogspot<br> Share your comments ask questions and get feedback! </h4>
						</div>
					</div>
				</a>
				<a href="#" class="text-decoration-none">
					<div class="card rounded-lg p-3 m-2" >
						<div class="card-body d-flex justify-content-center align-items-center">
							<i class="fas fa-mail-bulk fa-3x"></i>
						</div>
						<div class="card-body d-flex justify-content-center align-items-center font-montserrat">
							<h4 class="card-text text-center rh-2">Sign-up and get news and updates sent directly to your email</h4>
						</div>
					</div>
				</a>
				<a href="#" class="text-decoration-none">
					<div class="d-flex justify-content-center bg-primary-dark-hover">
						<h5 class="text-light rh-2">Sign me up!</h5>
					</div>
				</a>
			</div>
			<div class="col-md-2 col-lg-2">
				<div class="shadow-sm ">
					<p>advertisements3b</p>
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
		<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>-->
		<script src="scripts/navbar.js"></script>
		<script src="bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>