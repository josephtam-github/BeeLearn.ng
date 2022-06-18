<?php require_once "./php/user-controller.php";

//verify the user when email link is clicked
if(isset($_GET['token'])) {
	$token = $_GET['token'];
	VerifyUser($token);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> Almost there! | BeeLearn.ng </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
	<meta name="keywords" content="School, University, Education, Jamb CBT, UTME, WAEC NECO, School news, Nigerian, Syllabus, Textbooks, Admission, Portal, Video Tutorial">
	<meta name="description" content="Latest School News, JAMB, UTME, WAEC, NECO, GCE, NABTEB, Nigerian Universities, Colleges, Polythecnic, Pratice Quiz and Learning material">
	<link rel="stylesheet" href="fontawesome/fontawesome-free-5.15.4-web/fontawesome-free-5.15.4-web/css/all.css">
	<link rel="icon" href="images/icon.png">
	<script src="https://kit.fontawesome.com/f71a44a4e4.js"crossorigin="anonymous"></script>
	<script src="scripts/script.js"></script>
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">-->
	<link rel="stylesheet" href="bootstrap/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster&effect=brick-sign">
</head>
<body class="cheese-bg">
     <div class="container">
         <div class="row justify-content-center align-items-center my-5">
             <div class="col-6 bg-light  border-warning border rounded">
                <?php if($_SESSION["verified"]): ?>
                <div class="my-2 text-center text-warning py-3"><i class="fas fa-user-check fa-4x"></i><br><h1>Congratulations</h1><br><h5>You have successfully Logged in!</h5><a href="../home.php" class='text-decoration-none'><button class="btn btn-warning warning-hover my-3 p-2">Go Home</button></a> </div>;
                <?php endif; ?>
                <?php if(!$_SESSION["verified"]): ?>
                 <div class="rounded text-dark bg-warning container  text-center p-2 my-5"><h3>Your almost there!</h3> <br> We have just sent a verification link to the email address you provided at <?php echo $_SESSION['email']; ?> <br> click the link in it and your done</div>
                <?php endif; ?>
                <?php if($_SESSION["verified"]): ?>
                 <div class="rounded text-white text-center container p-2 my-5 bg-dark text-light">You have been verified congratulations!</div>
                <?php endif; ?>
             </div>
         </div>
     </div>
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>-->
<script src="http://localhost//beelearn/bootstrap/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>