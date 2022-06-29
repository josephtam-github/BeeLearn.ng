<?php
    require_once './content-controller.php';
    if (isset($_SESSION["badge"])) {
        if (!$_SESSION["badge"] == "ADMIN") {
            header("location: ../login.php?logout=1");
			exit();
        }
    } else {
        header("location: ../home.php");
		exit();
    }
?>
<?php
require_once '../php/user-controller.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> Image Uploader | BeeLearn.ng </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
	<link rel="icon" href="../images/icon.png">
	<script src="https://kit.fontawesome.com/f71a44a4e4.js"crossorigin="anonymous"></script>
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">-->
	<link rel="stylesheet" href="../scss/custom.css">
</head>
<body>
<div class="shadow-sm container-fluid p-0">
	<div class="d-flex justify-content-between align-items-center px-md-3">
			<a href="../home.php"><img id="logo" class="py-3 d-block" src="../images/BeeLearn.svg"></a>
			<button onclick="toggleSideBar()" class="align-self-center btn btn-warning rounded-circle d-md-none m-2"><i id="iconchange1" class="fas fa-bars"></i></button>
		</div>
	</div>

	<div class="text-center container-fluid justify-content-between d-flex z-index-1000"	>
		<div class="py-2  align-items-center eAnimateZoom" id="eToggleObject2" ><form><input type="text" placeholder="search"></form></div>
	</div>
    <?php
		echo $errors["unknown-error"], $errors["file-type"], $errors["file-format"], $errors["file-size"], $errors["file-exists"], $success["update"] ;
	?>
	<div class="row mx-0 bg-dark"> 
	
		<div id="edit-sidebar" class="col-lg-3 col-md-4 px-0 d-none d-md-flex bg-warning" style="overflow-y:scroll; display:flex; flex-direction:column; position: sticky; top: 0px;">
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./image-upload.php">IMAGE UPLOAD</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./dashboard.php">SITE STATISTICS</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./news-template.php">NEWS TEMPLATE</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="tips-template.php">TIPS TEMPLATE</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="tutorials-template.php">TUTORIALS TEMPLATE</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./community-watch.php">COMMUNITY WATCH</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./mailing.php">MAILING</a>			
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./add-question.php">ADD QUESTIONS</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./add-download.php">ADD DOWNLOADS</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./page-manager.php">PAGE MANAGER</a>
		</div>
		<div id="smSideBar" class="shadow-lg d-md-none bg-warning mx-0 px-0 animate-left-4" style="position:fixed; display:none; overflow-y:scroll;display:flex;flex-direction:column; position: sticky; top: 0px; z-index:20;">
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./image-upload.php">IMAGE UPLOAD</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./dashboard.php">SITE STATISTICS</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./news-template.php">NEWS TEMPLATE</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="tips-template.php">TIPS TEMPLATE</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="tutorials-template.php">TUTORIALS TEMPLATE</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./community-watch">COMMUNITY WATCH</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./mailing.php">MAILING</a>			
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./add-question.php">ADD QUESTIONS</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./add-download.php">ADD DOWNLOADS</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./page-manager.php">PAGE MANAGER</a>		</div>
		<div class="col-lg-9 col-md-6 text-white">
    		<p class="text-center fw-bold fs-2 font-montserrat mt-5"> Weclome <?php echo $_SESSION["username"];?> let's add some files! </p>
                <div class="mx-0 my-5">
                    <div class="align-items-center justify-contents-center">
                        <div class="m-5">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">

                                <div class="form-group my-4">
                                    <label class="lead fs-3">Directory</label>
                                  <select name="directory" class="form-select">
                                    <option value="../images/" selected>IMAGES FOLDER</option>
                                    <option value="../images/news/">IMAGES/NEWS</option>
                                    <option value="../images/tips/">IMAGES/TIPS</option>
                                    <option value="../images/download/">IMAGES/DOWNLOAD</option>
                                    <option value="../images/explore/">IMAGES/EXPLORE</option>
                                  </select>
                                </div>
                                <div class="form-group my-4">
                                  <label class="lead fs-3">Upload Image</label>
                                  <input type="file"  name="display-image" class="form-control-file form-control font-montserrat" accept="image/*" id="display-image" required>
                                </div>
                                <div class="form-group my-4">  
                                  <label class="lead fs-3">Image name</label>
                                  <input type="text"  name="display-image-name" class="form-control-file form-control font-montserrat" id="display-image-name" placeholder="Image name" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="upload-image" class="btn btn-warning warning-hover fw-bold my-3 p-2 no-shadow">Upload</button>						
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
		</div>
	</div>
	<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>-->
	<script src="../bootstrap/js/bootstrap.bundle.js"></script>
	<script src="../scripts/script.js"></script>
</body>
</html>
