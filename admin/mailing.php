<?php
    require_once './content-controller.php';
    require_once '../admin/content-controller.php';
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
require_once '../php/templates.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> News creator | BeeLearn.ng </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
	<link rel="stylesheet" href="../scss/custom.css">
	<link rel="stylesheet" href="../codemirror-5.65.2/lib/codemirror.css">
	<link rel="stylesheet" href="../codemirror-5.65.2/theme/midnight.css">
	<link rel="icon" href="../images/icon.png">
	<script src="https://kit.fontawesome.com/f71a44a4e4.js"crossorigin="anonymous"></script>
</head>
<body>
<div class="shadow-sm container-fluid p-0">
		<div class="d-flex justify-content-between align-items-center px-md-3">
			<a href="../home.php"><img id="logo" class="py-3 d-block" src="../images/BeeLearn.svg"></a>
			<button onclick="toggleSideBar()" class="align-self-center btn btn-warning rounded-circle d-md-none m-2"><i id="iconchange1" class="fas fa-bars"></i></button>
		</div>
	</div>

    <?php
		echo $errors["unknown-error"], $errors["file-type"], $errors["file-format"], $errors["file-size"], $errors["file-exists"], $success["update"] ;
	?>
	<div class="text-center container-fluid justify-content-between d-flex z-index-1000"	>
		<div class="py-2  align-items-center eAnimateZoom" id="eToggleObject2" ><form><input type="text" placeholder="search"></form></div>
	</div>
	<div class="row mx-0 bg-dark"> 
	
		<div id="edit-sidebar" class="col-lg-3 col-md-4 px-0 d-none d-md-flex bg-warning" style="overflow-y:scroll; display:flex; flex-direction:column; position: sticky; top: 0px;">
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./mailing.php">MAILING</a>			
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./image-upload.php">IMAGE UPLOAD</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="tips-template.php">TIPS TEMPLATE</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./news-template.php">NEWS TEMPLATE</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./dashboard.php">SITE STATISTICS</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./community-watch.php">COMMUNITY WATCH</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./add-question.php">ADD QUESTIONS</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./add-download.php">ADD DOWNLOADS</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-4 ps-3" href="./page-manager.php">PAGE MANAGER</a>
		</div>
		<div id="smSideBar" class="shadow-lg d-md-none bg-warning mx-0 px-0 eAnimateLeft" style="position:fixed; display:none; overflow-y:scroll;display:flex;flex-direction:column; position: sticky; top: 0px; z-index:20;">
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./mailing.php">MAILING</a>			
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./image-upload.php">IMAGE UPLOAD</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="tips-template.php">TIPS TEMPLATE</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./news-template.php">NEWS TEMPLATE</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./dashboard.php">SITE STATISTICS</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./community-watch">COMMUNITY WATCH</a>
            <a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./add-question.php">ADD QUESTIONS</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./add-download.php">ADD DOWNLOADS</a>
			<a class="nav-link text-reset fw-bold fs-5 border-bottom border-2 border-dark text-start text-decoration-none font-roboto rounded-0 py-3" href="./page-manager.php">PAGE MANAGER</a>		
        </div>
		<?php
			echo $success["update"];
		?>
		<div class="col-lg-9 col-md-6 text-white">
    		<p class="text-center fw-bold fs-2 font-montserrat mt-5"> Weclome <?php echo $_SESSION["username"];?> let's pass the message! </p>
                <div class="mx-0 my-5">
                    <div class="align-items-center justify-contents-center">
                        <div class="m-5">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                <div class="form-group my-4">
                                  <label class="lead fs-3">Mail Subject</label>
								  <input type="text"  name="mail-subject" class="form-control form-control font-montserrat" placeholder="Mail Subject" required>
                                </div>
								<div class="form-group my-5">
        	                      <label class="form-label lead fs-3">Mail Body</label>
    	                          <textarea rows="80" cols="30" name="mail-content" class="form-control no-shadow" required id="MirrorTextArea"><?php echo $mail_template;?></textarea>
	                            </div>
                                <div class="form-group">
                                    <button type="submit" name="test-mail" class="btn btn-warning warning-hover fw-bold my-3  me-3 p-2 no-shadow">Test</button>						
                                    <button type="submit" name="send-mail" class="btn btn-warning warning-hover fw-bold my-3 p-2 no-shadow">Send</button>						
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
		</div>
	</div>
	<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>-->
	<script src="../beelearn/bootstrap/bootstrap/js/bootstrap.bundle.js"></script>
	<script> 
		window.onload = function() {
			window.editor = CodeMirror = CodeMirror.fromTextArea(MirrorTextArea, {
				mode: 'htmlmixed',
				theme: 'midnight',
				lineNumbers: true,
				foldGutter: {
					rangeFinder: new CodeMirror.fold.combine(CodeMirror.fold.brace, CodeMirror.fold.comment)
				},
				gutters: ['CodeMirror-linenumbers', 'CodeMirror-foldgutter']
			}).setSize("100%","100%");
		};
	</script>
	<script src="../scripts/script.js"></script>
	<script src="../bootstrap/js/bootstrap.bundle.js"></script>
	<script src='../codemirror-5.65.2/lib/codemirror.js'></script>
	<script src='../codemirror-5.65.2/mode/xml/xml.js'></script>
	<script src='../codemirror-5.65.2/mode/javascript/javascript.js'></script>
	<script src='../codemirror-5.65.2/mode/css./css.js'></script>
	<script src='../codemirror-5.65.2/mode/htmlmixed/htmlmixed.js'></script>
	<script src='../codemirror-5.65.2/addon/fold/foldcode.js'></script>
</body>
</html>
