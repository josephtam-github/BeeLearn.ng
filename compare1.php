"
<?php require_once '../php/user-controller.php'; ?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<title> PAGE TITLE HERE </title>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0 shrink-to-fit=no'>
	<meta name='keywords' content='PAGE KEYWORDS HERE'>
	<meta name='description' content='PAGE DESCRIPTION HERE'>
	<link rel='stylesheet' href='../stylesheets/edit.css'>
	<link rel='stylesheet' href='../fontawesome/fontawesome-free-5.15.4-web/fontawesome-free-5.15.4-web/css/all.css'>
	<link rel='icon' href='../images/icon.png'>
	<script src='https://kit.fontawesome.com/f71a44a4e4.js'crossorigin='anonymous'></script>
	<script src='../scripts/script.js'></script>
	<script src='../scripts/comment.js'></script>
	<script>
		var page_id = $last_id;
		var parent_id = 0;
		var show_more = 0;
	</script>
	<!--<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl' crossorigin='anonymous'>-->
	<link rel='stylesheet' href='../bootstrap/bootstrap/css/bootstrap.min.css'>
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lobster&effect=brick-sign'>
</head>
<body onload='loadComment();'>
	<div class='shadow-lg container-fluid'>
		<div class='d-flex justify-content-between align-items-center'>
			<a href='../home.php'><img id='logo' class='py-3'  src='../images/BeeLearn.svg'></a>
			<div class='d-flex align-items-center'>
				<button type='button' class='btn btn-warning rounded-circle m-2' onclick='toggleSearchHide(this)'><i class='fas fa-search'></i></button>
				<?php 
					if (isset(\$_SESSION['id'])) {
						echo '<a href=\'../settings.php\'><button class=\'btn btn-warning m-2 rounded-circle d-none d-md-block\' ><i class=\'fas fa-cog\'></i></button></a>';
					} else {
						echo '<a href=\'../signup.php\'><button class=\'btn btn-warning m-2 rounded-circle\' ><i class=\'fas fa-user\'></i></button></a>';
					}
				?>
				<div><button onclick='toggleNavHide(this)' class='align-self-center btn btn-warning rounded-circle d-md-none m-2'><i id='iconchange1' class='fas fa-bars'></i></button></div>		
				<a href='../home.php?logout=1'>   
				<?php if(isset(\$_SESSION['logout-btn'])) { echo  \$_SESSION['logout-btn']; } ?>
				</a>
			</div>
		</div>
	</div>

	<div class='text-center container-fluid justify-content-between d-flex z-index-1000'	>
		<div class='py-2  align-items-center eAnimateZoom' id='eToggleObject2' ><form><input type='text' placeholder='search'></form></div>
	</div>

	<nav class='shadow-lg sticky-top d-none d-md-flex nav nav-tabs text-dark nav-justified font-bold justify-content-center'>
		<a class='nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1' href='../news.php'>NEWS</a>
		<a class='nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1' href='../home.php'>HOME</a>
		<a class='nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1' href='../explore.php'>EXPLORE</a>
	 	<a class='nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1' href='../tips.php'>TIPS</a>
		<a class='nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1' href='../download.php'>DOWNLOAD</a>
		<a class='nav-link text-reset fw-bold fs-6 border-bottom-0 font-roboto border-top-0 rounded-0 border-dark border-1' href='../about.php'>ABOUT&nbsp;US</a>
	</nav>

	<div id='eToggleObject1' class='shadow-lg d-md-none container-fuid bg-warning text-dark font-bold eAnimateLeft'>
		<a class='text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1' href='../news.php'>NEWS</a>
		<a class='text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1' href='../home.php'>HOME</a>
		<a class='text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1' href='../explore.php'>EXPLORE</a>
		<a class='text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1' href='../tips.php'>TIPS</a>
		<a class='text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1' href='../download.php'>DOWNLOAD</a>
		<?php 
			if (isset(\$_SESSION['id'])) {
				echo '<a class=\'text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1\' href=\'./settings.php\'>SETTINGS</a>';
			}
		?>
		<a class='text-center text-decoration-none text-reset fw-bold border-bottom border-2 font-roboto border-dark py-2 nav-link p-1' href='../about.php'>ABOUT&nbsp;US</a>
	</div>

    <div class='row mx-0 my-5'>
		<div class='col-lg-10 align-items-center justify-contents-center'>
			<div class='m-5'>
                <h2 class='text-center font-montserrat'> PAGE HEADING HERE </h2>
                <hr class='dropdown-divider'>
                <img src='../images/WBD.jpg' alt='world book day' class='card-body card-img d-block thumbnail w-100 mx-auto'>
                <p class='font-montserrat'>The long wait is over WACE has finally released their 2020/2021 session exam result for school candidates and promises to release that of private candidates in the next two months</p>
			
				<div class='row my-3'>
            		<div class='col card w-50'>
            	    	<h4 class='card-title text-center'>Table of contents</h4>
            	    	<ul class='card-text'>
            	    	    <li><a href='' class='text-decoration-none'>WAEC result</a></li>
            	    	    <li><a href='' class='text-decoration-none'>How to prepare</a></li>
            	    	    <li><a href='' class='text-decoration-none'>Alterations to expect</a></li>
            	    	    <li><a href='' class='text-decoration-none'>When to expect GCE</a></li>
            	    	    <li><a href='' class='text-decoration-none'>Pass in one sitting</a></li>
            	    	</ul>
					</div>
					<div class='col bg-danger'>
						advertisement
					</div>
            	</div>

				<p class='font-montserrat mt-5'>
					MAIN TEXT HERE
				</p>
				<br>
				<div class='my-5 d-flex flex-row justify-content-evenly' style='height:100px;'>
					<div class='h-100 bg-danger  d-inline-block'>
					advertisement box
					</div>
					<div class='h-100 bg-danger d-inline-block'>
					advertisement box
					</div>
					<div class='h-100 bg-danger d-inline-block'>
					advertisement box
					</div>
					<div class='h-100 bg-danger d-inline-block'>
					advertisment box
					</div>
				</div>
				<p class='font-montserrat mt-5'>
				CONCLUSION HERE
				</p>
			</div>

			<div class='text-center bg-warning font-roboto container-fluid fw-bold text-dark' >COMMENTS <i class='fas fa-comment mx-2'></i></div>
			<!-- <img src='' alt='There are no comments yet, be the first person to share your thoughts' class='w-100 d-block'> -->

			<div class='font-montserrat mt-2' id='comment_box' ></div>
			<div class='container-fluid mt-3 justify-content-center align-items-center'>
        		<div class='bg-light border border-3 rounded-1 px-5 py-3'>
					<form method='POST' id='comment_form' onsubmit='submitForm(event)'>
						<div class='for animate-zoom-20m-group'>
							<label class='lead mb-2'  for='comment'>Share your thoughts</label><i onclick='loadComment()' id='replyIcon' style='display: none' class='pointer float-end fas fa-times animate-zoom-20'></i>
							<textarearegex rows='3' cols='20' name='comment' class='form-control no-shadow' id='comment_id' required></textarearegex>
							<small class='font-montserrat text-dark mt-2' id='comment_error'></small>
						</div>
						<div class='form-group'>
							<input type='hidden' name='comment_id' id='hidden_id' value='0'> 
						</div>
						<div class='form-group'>
							<button type='submit' name='send-btn' class='btn btn-warning warning-hover fw-bold my-3 p-2 no-shadow'  id='comment_btn'>Comment</button>						
						</div>
						<div class='form-group form-check my-2' id='notifyToggle'>
							<label class='form-check-label'>
							<input type='checkbox' name='notify' value='1' class='form-control form-check-input me-2' id='checkbox_id'> Notify me if I get a reply!
							</label>
						</div>
					</form>
				</div>
			</div>
 		</div>
		<div class='col-lg-2 bg-secondary'>
			<div class='bg-light m-5'>
			advertisement
			</div>
		</div>
    </div>

	<div class='text-light container-fluid text-center bg-secondary py-2 font-roboto'><i class='fas fa-link mx-2'></i>QUICK LINKS</div>
	<div class='container-fluid bg-dark text-white'>
		<div class='d-flex flex-wrap justify-content-center alintext-wrap py-3'>
				<a href='#' class='text-decoration-none text-muted text-center mx-5'><small>LEARNERS&nbsp;FORUM</small></a>
				<a href='#' class='text-decoration-none text-muted text-center mx-5'><small>SCHOOL&nbsp;NEWS</small></a>
				<a href='#' class='text-decoration-none text-muted text-center mx-5'><small>UNIVERSITY&nbsp;FORUM</small></a>
				<a href='#' class='text-decoration-none text-muted text-center mx-5'><small>PRIVATE&nbsp;ONLINE&nbsp;CLASS</small></a>
				<a href='#' class='text-decoration-none text-muted text-center mx-5'><small>VIDEO&nbsp;TUTORIALS</small></a>
				<a href='#' class='text-decoration-none text-muted text-center mx-5'><small>NEWS&nbsp;LETTER</small></a>
				<a href='#' class='text-decoration-none text-muted text-center mx-5'><small>SIGN&nbsp;UP&nbsp;TO&nbsp;OUR&nbsp;MAIL</small></a>
				<a href='#' class='text-decoration-none text-muted text-center mx-5'><small>CBT&nbsp;SOFTWARE</small></a>
				<a href='#' class='text-decoration-none text-muted text-center mx-5'><small>FAQ</small></a>
				<a href='#' class='text-decoration-none text-muted text-center mx-5'><small>OUR&nbsp;TEAM</small></a>
				<a href='#' class='text-decoration-none text-muted text-center mx-5'><small>CONTACT&nbsp;US</small></a>
				<a href='#' class='text-decoration-none text-muted text-center mx-5'><small>AGENT</small></a>
				<a href='#' class='text-decoration-none text-muted text-center mx-5'><small>DONATE</small></a>
		</div>
		<div class='d-flex justify-content-center'>
			<a href='#'><i class='fab fa-facebook fa-2x text-muted mx-2'></i></a>
			<a href='#'><i class='fab fa-twitter fa-2x text-muted mx-2'></i></a>
			<a href='#'><i class='fab fa-whatsapp fa-2x text-muted mx-2'></i></a>
			<a href='#'><i class='fab fa-instagram fa-2x text-muted mx-2'></i></a>
		</div>
		<div class='text-center font-montserrat text-muted mt-1'>&copy; 
			<?php echo date('Y');?>
			Copyright Created by &CircleDot; prime.designr 
		</div>
	</div>
		<!--<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js' integrity='sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0' crossorigin='anonymous'></script>-->
		<script src='../beelearn/bootstrap/bootstrap/js/bootstrap.bundle.js'></script>
</body>
</html>

    ";
