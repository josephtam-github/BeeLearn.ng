<?php
require_once './php/user-controller.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> BeeHive | BeeLearn.ng Forum</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
	<meta name="keywords" content="School, University, Education, Jamb CBT, UTME, WAEC NECO, School news, Nigerian, Syllabus, Textbooks, Admission, Portal, Video Tutorial">
	<meta name="description" content="Latest School News, JAMB, UTME, WAEC, NECO, GCE, NABTEB, Nigerian Universities, Colleges, Polythecnic, Pratice Quiz and Learning material">
	<link rel="icon" href="images/icon.png">
	<script src="https://kit.fontawesome.com/f71a44a4e4.js"crossorigin="anonymous"></script>
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">-->
	<link rel="stylesheet" href="./scss/custom.css">
	<!-- REMOVE THIS -->
	<link rel="stylesheet" href="fontawesome/css/all.css">
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
		echo $errors["unknown-error"], $errors["file-type"], $errors["file-format"], $errors["file-size"], $errors["file-exists"], $errors["login"],$success["update"] ;
	?>
    <div class="row mx-0 my-5">
		<?php
			$f_pagedb = new mysqli(DBHOST,DBUSER,DBPASS);
			#loop through pagedetails that are forums
			$query = "SELECT * FROM beelearn.pagedetail WHERE template = 'forum_detail'";
			$result = $f_pagedb->query($query);
			$array = $result->fetch_all(MYSQLI_NUM);
			$len =  count($array);
			for ($row=0; $row < $len; $row++) { 
				#get user details
				$user_query = "SELECT * FROM beelearn.userdetail WHERE id =".$array[$row][1]."";
				$user_result = $f_pagedb->query($user_query);
				$user_array = $user_result->fetch_assoc();

				#get comment details 
				$cmnt_query = "SELECT * FROM beelearn.commentdetail WHERE id =".$array[$row][1]." AND pageid = ".$array[$row][0]." AND parentid = 0";
				$cmnt_result = $f_pagedb->query($cmnt_query);
				$cmnt_array = $cmnt_result->fetch_assoc();

				#parent upvote data
				$upvote_stmnt = "SELECT reaction FROM beelearn.reactiondetail WHERE commentid = ".$cmnt_array["commentid"]." AND reaction = 'UPVOTE'";
				$upvote_data =  $f_pagedb->query($upvote_stmnt);
				$upvote_array =  $upvote_data->fetch_all();
				$upvote_array_len = count($upvote_array);
				if ($upvote_array_len === 0) {
				$upvote_count = '';
				} else {
				$upvote_count = $upvote_array_len;
				}
				
				#parent downvote data
				$downvote_stmnt = "SELECT reaction FROM beelearn.reactiondetail WHERE commentid = ".$cmnt_array["commentid"]." AND reaction = 'DOWNVOTE'";
				$downvote_data =  $f_pagedb->query($downvote_stmnt);
				$downvote_array =  $downvote_data->fetch_all();
				$downvote_array_len = count($downvote_array);
				if ($downvote_array_len === 0) {
				$downvote_count = '';
				} else {
				$downvote_count = $downvote_array_len;
				}
				
				echo "
					<div class='col-lg-9 align-items-center justify-contents-center'>
						<div class='card  font-montserrat p-2 mb-3'>
							<div class='d-flex'>
								<div class='d-flex flex-column pt-3 align-items-center justify-content-center ps-2'>
									<div style='width:50px; height:50px; clip-path: circle(50%);'>
										<img src='images/".$user_array['dp']."' alt='Profile Photo' class='comment' style='width:50px;'>
									</div>
									<div class='text-center'><small>".$user_array["username"]."</small></div>
								</div>
								<div class='d-flex ms-5 flex-column justify-content-evenly'>
									<a href='./forum/topic.php?id=".$array[$row][0]."' class='text-decoration-none'>	
										<div class='d-flex pe-5' style='overflow-y: auto;'>".$array[$row][3]."</div>
										<small class='text-muted'>".$cmnt_array["comment"]."</small>
									</a>
									<div class='d-flex'>
										<div class='d-flex text-secondary border rounded-3 px-2'> 
											".$upvote_count."<button class='mx-1 text-secondary not-allowed bg-white border-0'> <i class='fas fa-arrow-up' id='like'></i></button>
											".$downvote_count."<button class='mx-1 text-secondary not-allowed bg-white border-0'> <i class='fas fa-arrow-down' id='dislike'></i></button>
										</div>
									</div>
								</div>
							</div>
							<div class='d-flex justify-content-end'> 
								  <div class='text-secondary float-end fs-6'><small><i class='fas fa-clock me-1'></i>".time_elapsed_string($array[$row][6])."</small></div>	
							</div>
						</div>
			 		</div>
				";
			}
		?>
		
		<div class="container-fluid mt-3 justify-content-center align-items-center col-lg-9">
    		<div class="bg-light border border-3 rounded-3 px-5 py-3">
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
					<h5 class="font-montserrat text-center">Create a Topic</h5>
					<hr class="mt-0">
					<label class="lead my-2"  for="topic-title">Title</label>
					<input type="text" name="topic-title" required class="form-control no-shadow"placeholder="Keep it short and simple">
					<label class="lead my-2"  for="topic-desc">Description</label>
					<textarea rows="2" cols="5" name="topic-desc" class="form-control no-shadow" required placeholder="This will be the first comment"></textarea>
					<label class="lead my-2"  for="topic-image">Image </label> <small class="text-muted"> (optional) </small>
					<input type="file" name="topic-image" class="form-control-file form-control" accept="image/*">
                    <label class="lead my-2">Tag</label>
                    <select name="topic-tag" class="form-select">
                        <option value="MISC" selected>DEFAULT</option>
                        <option value="ADMISSION">ADMISSION</option>
                        <option value="SOLVE">HARD QUESTIONS</option>
                        <option value="DEBATE">DEBATE</option>
                        <option value="SCIENCE">SCIENCE</option>
                        <option value="ART">ART</option>
                    </select>
					<div class="form-group form-check my-2" id="notifyToggle">
						<label for="topic-notify" class="form-check-label">
						<input type="checkbox" name="topic-notify" value="1" class="form-control form-check-input me-2"> Notify me if I get a reply!
						</label>
					</div>
					<div class="form-group">
						<button type="submit" name="send-topic" class="btn btn-warning warning-hover fw-bold my-2 p-2 no-shadow">Create</button>						
					</div>
				</form>
			</div>
		</div>
		<div class="col-lg-3 bg-secondary">
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
		<script src="./scripts/navbar.js"></script>
		<script src="./bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>
