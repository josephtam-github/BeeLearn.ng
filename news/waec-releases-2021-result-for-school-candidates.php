<?php
require_once '../php/user-controller.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> WAEC 2020/2021 Result for School Candidates </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
	<meta name="keywords" content="School news, University news, Education, Jamb CBT, UTME, WAEC NECO, School news, Nigerian, Syllabus, Textbooks, Admission, Portal, Video Tutorial">
	<meta name="description" content="Latest School News, JAMB, UTME, WAEC, NECO, GCE, NABTEB, Nigerian Universities, Colleges, Polythecnic, Pratice Quiz and Learning material">
	<link rel="stylesheet" href="../scss/custom.css">
	<!-- REMOVE THIS -->
	<link rel="stylesheet" href="../fontawesome/css/all.css">
	<link rel="icon" href="../images/icon.png">
	<script src="https://kit.fontawesome.com/f71a44a4e4.js"crossorigin="anonymous"></script>
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">-->

	<script>
		const page_id = 1;
		var parent_id = 0;
		var show_more = 0;
		var offset = 0;
	</script>
</head>
<body onload="loadComment();">
	<div class="shadow-sm container-fluid p-0">
		<div class="d-block d-md-flex justify-content-between align-items-center px-md-3">
			<a href="./home.php"><img id="logo" class="py-3 d-block" src="../images/BeeLearn.svg"></a>
			<div class="d-flex bg-md-warning bg-md-none align-items-center justify-content-end">
				<button type="button" class="btn btn-dark text-warning rounded-circle m-2" onclick="toggleSearchHide()"><i class="fas fa-search"></i></button>
				<?php 
					if (isset($_SESSION['id'])) {
						echo "<a href='../settings.php'><button class='btn btn-dark text-warning m-2 rounded-circle d-none d-md-block' ><i class='fas fa-cog'></i></button></a>";
					} else {
						echo "<a href='../signup.php'><button class='btn btn-dark text-warning m-2 rounded-circle' ><i class='fas fa-user'></i></button></a>";
					}
				?>				
				<div><button onclick="toggleNavHide()" class="align-self-center btn btn-dark text-warning rounded-circle d-md-none m-2"><i id="iconchange1" class="fas fa-bars"></i></button></div>		
				<a href="../home.php?logout=1">
				<?php if(isset($_SESSION['logout-btn'])) { echo  $_SESSION['logout-btn']; } ?>
				</a>
			</div>
		</div>
	</div>

	<div class="text-center container-fluid justify-content-between d-flex z-index-1000"	>
		<div class="py-2  align-items-center animate-zoom-12" id="eToggleObject2" ><form><input class="form-control border-warning" type="text" placeholder="search"></form></div>
	</div>

	<nav class="d-none d-md-flex nav nav-tabs nav-justified text-dark shadow-sm sticky-top">
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="../home.php">HOME</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="../news.php">NEWS</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="../explore.php">EXPLORE</a>
	 	<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="../tips.php">TIPS</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="../download.php">DOWNLOAD</a>
		<a class="nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1 bg-warning" href="../about.php">ABOUT&nbsp;US</a>
	</nav>

	<div id="eToggleObject1" class="shadow-sm d-md-none container-fuid">
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-2 border-top" href="../home.php">HOME</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-4" href="../news.php">NEWS</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-6" href="../explore.php">EXPLORE</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-8" href="../tips.php">TIPS</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-10" href="../download.php">DOWNLOAD</a>
		<a class="text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-12" href="../about.php">ABOUT&nbsp;US</a>
		<?php 
			if (isset($_SESSION['id'])) {
				echo "<a class='text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1 bg-warning animate-left-14' href='../settings.php'>SETTINGS</a>";
				}
		?>		
	</div>
	
    <div class="row mx-0">
		<div class="col-lg-10 align-items-center justify-contents-center">
			<div class="m-3">
                <h2 class="text-center mt-4 font-montserrat"> WAEC 2020/2021 Result for School Candidates </h2>
                <hr class="dropdown-divider">
                <img src="../images/WBD.jpg" alt="world book day" class="card-body card-img d-block thumbnail w-100 mx-auto">
                <p class="font-montserrat">The long wait is over WACE has finally released their 2020/2021 session exam result for school candidates and promises to release that of private candidates in the next two months</p>
			
				<div class="row my-3">
            		<div class="col-md-6 card">
            	    	<h4 class="card-title text-center">Table of contents</h4>
            	    	<ul class="card-text">
            	    	    <li><a href="" class="text-decoration-none">WAEC result</a></li>
            	    	    <li><a href="" class="text-decoration-none">How to prepare</a></li>
            	    	    <li><a href="" class="text-decoration-none">Alterations to expect</a></li>
            	    	    <li><a href="" class="text-decoration-none">When to expect GCE</a></li>
            	    	    <li><a href="" class="text-decoration-none">Pass in one sitting</a></li>
            	    	</ul>
					</div>
					<div class="col-md-6 mt-3 mt-md-0 bg-danger">
						advertisement
					</div>
            	</div>

				<p class="font-montserrat mt-5">
					dolor sit amet consectetur adipisicing elit. Qui veniam sapiente natus, suscipit eos illo, ex dolores, totam aliquam sunt provident nam! Beatae placeat voluptas deleniti saepe soluta repudiandae voluptatem.
					Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus amet excepturi accusamus consectetur temporibus ullam dolores, nam error nesciunt eveniet voluptatibus dignissimos veritatis sapiente dolorum reiciendis laboriosam magnam, tenetur sequi?
					adipisicing elit. Neque iusto magnam soluta in. Odit officiis quam cupiditate eius magnam modi debitis doloribus qui in eaque rem, aperiam dolorum delectus? Dignissimos.
					Lorem ipsum dolor sit amet,
				</p>
				<br>
	 			<div class="my-5 d-md-flex flex-row justify-content-evenly align-items-center">
					<div class="h-100 bg-danger  d-inline-block">
					advertisement box
					</div>
					<div class="h-100 bg-danger d-inline-block">
					advertisement box
					</div>
				</div>
				<p class="font-montserrat mt-5">
				consectetur adipisicing elit. Magnam eum quidem dolorem error reiciendis? Vel blanditiis dignissimos alias hic, minima eum deleniti autem tempora natus accusamus officia unde, quis eligendi?
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita earum voluptates saepe, nobis dicta, cupiditate sunt dolor deleniti numquam doloremque ullam voluptate blanditiis officiis, tenetur quis error voluptas laudantium cum?
				amet consectetur adipisicing elit. Quibusdam, enim, accusamus dignissimos, eos itaque modi dolore non natus quidem asperiores perspiciatis impedit totam iure maxime minus! Vero doloremque maxime debitis.
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam optio delectus cumque! Quo, sunt possimus. Explicabo aperiam in fuga ratione vero sapiente distinctio, laborum, temporibus reiciendis doloribus cupiditate eum consequatur?
				</p>
			</div>

			<div class="text-center bg-warning font-roboto container-fluid fw-bold text-dark" >COMMENTS <i class="fas fa-comment mx-2"></i></div>
			<!-- <img src="" alt="There are no comments yet, be the first person to share your thoughts" class="w-100 d-block"> -->

			<div class="font-montserrat mt-2" id="comment_box" ></div>
			<div class="container-fluid my-3 justify-content-center align-items-center">
        		<div class="bg-light border border-3 rounded-1 px-5 py-3">
					<form method="POST" id="comment_form" onsubmit="submitForm(event)">
						<div class="animate-zoom-10 form-group">
							<label class="lead mb-2"  for="comment">Share your thoughts</label> <i onclick="loadComment()" id="replyIcon" style="display: none" class="pointer float-end fas fa-times animate-zoom-20"></i>
							<textarea rows="3" cols="20" name="comment" class="form-control" id="comment_id" required></textarea>
							<small class="font-montserrat text-dark mt-2" id="comment_error"></small>
						</div>
						<div class="form-group">
							<input type='hidden' name='comment_id' id='hidden_id' value='0'> 
						</div>
						<div class="form-group">
							<button type="submit" name="send-btn" class="btn btn-warning fw-bold my-3 p-2"  id="comment_btn">Comment</button>						
						</div>
						<div class="form-group form-check my-2" id="notifyToggle">
							<label class="form-check-label">
							<input type="checkbox" name="notify" value="1" class="form-control form-check-input me-2" id="checkbox_id"> Notify me if I get a reply!
							</label>
						</div>
					</form>
				</div>
			</div>
 		</div>
		<div class="col-lg-2 bg-secondary">
			<div class="bg-light m-5">
			advertisement
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
	<script src="../bootstrap/js/bootstrap.bundle.js"></script>
	<script src="../scripts/comment.js"></script>
	<script src="../scripts/navbar.js"></script>
	<script src="../scripts/script.js"></script>
</body>
</html>
