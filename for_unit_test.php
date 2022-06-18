<!DOCTYPE html>
<html lang='en'>
<head>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<title> succes i hope</title>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0 shrink-to-fit=no'>
	<meta name='keywords' content='School news, University news, Education, Jamb CBT, UTME, WAEC NECO, School news, Nigerian, Syllabus, Textbooks, Admission, Portal, Video Tutorial'>
	<meta name='description' content='Latest School News, JAMB, UTME, WAEC, NECO, GCE, NABTEB, Nigerian Universities, Colleges, Polythecnic, Pratice Quiz and Learning material'>
	<link rel='stylesheet' href='../stylesheets/edit.css'>
	<link rel='stylesheet' href='../fontawesome/fontawesome-free-5.15.4-web/fontawesome-free-5.15.4-web/css/all.css'>
	<link rel='icon' href='../images/icon.png'>
	<script src='https://kit.fontawesome.com/f71a44a4e4.js'crossorigin='anonymous'></script>
	<script src='../scripts/script.js'></script>
	<script src='../scripts/comment.js'></script>
	<script>
		var page_id = 2;
		var parent_id = 0;
		var show_more = 0;
	</script>
	<!--<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl' crossorigin='anonymous'>-->
	<link rel='stylesheet' href='../bootstrap/bootstrap/css/bootstrap.min.css'>
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lobster&effect=brick-sign'>
</head>
<body onload='loadComment();'>
</body>
</html>
<?php
$target_name = "../news/file.php";
$target_preview_name = "../emp";
	$generate_button = `

		<form action='<?php echo htmlspecialchars(\$_SERVER['PHP_SELF']);?>' method='POST'>
		<input type='hidden'  name='target-name' value='".$target_name."' >
		<input type='hidden'  name='current-name' value='".$target_preview_name."' >
		<div class='form-group text-center'>
            <button type='submit' name='generate-page' class='btn btn-warning warning-hover fw-bold my-3 p-2 no-shadow'>Generate</button>						
            <button type='submit' name='cancel-page' class='btn btn-warning warning-hover fw-bold my-3 p-2 no-shadow'>Cancel</button>						
        </div>
		</form>

	`;
    echo $generate_button;

?>
