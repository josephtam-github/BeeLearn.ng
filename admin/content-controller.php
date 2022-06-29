<?php
require_once '../php/user-controller.php';

$contentdb = new mysqli(DBHOST,DBUSER,DBPASS);

function titlelize($input)
{
    $input = strtolower($input);
    $input = preg_replace('/\s/',"-",$input);
    $input = preg_replace('/\W/',"-",$input);
    $input = preg_replace('/-+/',"-",$input);
    return $input;
}

function reg_textarea($text) {
	$text = str_replace("textarearegex", "textarea", $text);
	return $text;
}

if (isset($_POST["preview-page"])) {
	#the page form data
	$directory = $_POST["directory"];
    $title = htmlspecialchars($_POST["title"]);
	$tag= htmlspecialchars($_POST["tag"]);
    $image_name = titlelize($_POST["display-image-name"]);
    $preview_text = $_POST["page-content"];
	$preview_text = reg_textarea($preview_text);
	$target_name = "../".$directory."/".titlelize($title).".php";
	$target_preview_name = "../".$directory."/".titlelize($title)."-preview.php";
	
    #file data
    $target_dir = "../images/".$directory."/";
	$file_name = htmlspecialchars($_FILES["display-image"]["name"]);
	$file_type = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
	$new_file_name = $image_name.".".$file_type;
	$target_file = $target_dir . $new_file_name;
	$file_tmp_name = $_FILES["display-image"]["tmp_name"];
	$file_size = $_FILES["display-image"]["size"];
	$file_error = $_FILES["display-image"]["error"];
	$check = getimagesize($file_tmp_name);
	
	#generate
	$generate_button = "
	<?php
		echo \"
		<form action='../admin/content-controller.php' method='POST'>
		<input type='hidden'  name='target-name' value='$target_name'>
		<input type='hidden'  name='current-name' value='$target_preview_name'>
		<input type='hidden'  name='target-file' value='$target_file'>
		<input type='hidden'  name='title' value='$title'>
		<input type='hidden'  name='tag' value='$tag'>
		<input type='hidden'  name='directory' value='$directory' >
		<input type='hidden'  name='display-image' value='$new_file_name'>
		<div class='form-group text-center'>
            <button type='submit' name='generate-page' class='btn btn-warning warning-hover fw-bold my-3 p-2 no-shadow'>Generate</button>						
            <button type='submit' name='cancel-page' class='btn btn-warning warning-hover fw-bold my-3 p-2 no-shadow'>Cancel</button>						
        </div>
		</form>
		\";
	?>
	";

    #Check if image file is a actual image or fake image
	if($check == false) {
		$errors["file-type"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>File is not an image </div>";
	} else {
		// Allow certain file formats
		if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif" ) {
			$errors["file-format"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Only JPG, JPEG, PNG & GIF files are allowed </div>";
		} else {
			// Check file size
			if ($file_size > 50000000) {
			$errors["file-size"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>File is too large, it must be less than 5mb. </div>";
			} else {
				if (file_exists($target_file)) {
					$errors["file-exists"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>File already exists.</div>";
                } else {   
				    if ($file_error == 0) {
				    	if (empty($errors["file-type"] || $errors["file-format"] || $errors["file-size"] || $errors["file-exists"])) {
				    		if (move_uploaded_file($file_tmp_name, $target_file)) {
                                #Now creating the preview file for the user to upload 
								$preview_file = fopen($target_preview_name, "a+");
								$main_file = fopen("../".$directory."/temp.tmp", "w+");
								if (fwrite($preview_file, $preview_text)) {
									if (fwrite($main_file, $preview_text)) {
										if (fwrite($preview_file, $generate_button)) {
											fclose($preview_file);
											fclose($main_file);
											header("location: ".$target_preview_name."");
										}
									}
								}
				    		} else {
								$errors["unknown-error"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Something went wrong with the upload. Please try agan later. </div>";
				    		}
				    	} else {
				    		$errors["unknown-error"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Something went wrong with the upload. Please try agan later. </div>";
				    	}
				    } else {
				    	$errors["unknown-error"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Something went wrong <br> Please try agan later. </div>";
				    }
                }
			}
		}
	}

}

if (isset($_POST["generate-page"])) {
	$user_id = $_SESSION['id'];
	$directory = $_POST["directory"];
	$template = "".$directory."_detail";
	$tag = $_POST["tag"];
	$target_name = $_POST["target-name"];
	$current_name = $_POST["current-name"];
	$title = $_POST["title"];
	$display_image = $_POST["display-image"];
	$target_file = $_POST["target-file"];

	$query = "INSERT INTO beelearn.pagedetail (id,template,title,tag,display_image) VALUES (?,?,?,?,?)";
    $task =  $contentdb->prepare($query);
    $task->bind_param("issss", $user_id, $template,$title,$tag,$display_image);
    if ($task->execute()) {
		if(rename("../".$directory."/temp.tmp", $target_name)) {
			header("location: ".$target_name."");
			unlink($current_name);
			exit();
		}
	} else {
		echo $contentdb->error;
	}
}

if (isset($_POST["cancel-page"])) {
	$target_name = $_POST["target-name"];
	$current_name = $_POST["current-name"];
	$target_file = $_POST["target-file"];

	header("location: ../admin/".$directory."-template.php");
	unlink($target_file);
	unlink($current_name);
	unlink("../".$directory."/temp.tmp");
	exit();
}


#file-upload 
if (isset($_POST["upload-image"])) {
	$image_name = titlelize($_POST["display-image-name"]);
	$target_dir = $_POST["directory"];
	$file_name = $_FILES["display-image"]["name"];
	$file_type = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
	$new_file_name = $image_name.".".$file_type;
	$target_file = $target_dir . $new_file_name;
	$file_tmp_name = $_FILES["display-image"]["tmp_name"];
	$file_size = $_FILES["display-image"]["size"];
	$file_error = $_FILES["display-image"]["error"];
	$check = getimagesize($file_tmp_name);
	


	#Check if image file is a actual image or fake image
	if($check == false) {
		$errors["file-type"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>File is not an image </div>";
	} else {
		// Allow certain file formats
		if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif" ) {
			$errors["file-format"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Only JPG, JPEG, PNG & GIF files are allowed </div>";
		} else {
			// Check file size
			if ($file_size > 5000000) {
			$errors["file-size"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>File is too large, it must be less than 5mb. </div>";
			} else {
				if (file_exists($target_file)) {
					$errors["file-exists"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>File already exists</div>";
				} else {
					if ($file_error == 0) {
						if (empty($errors["file-type"] || $errors["file-format"] || $errors["file-size"])) {
							if (move_uploaded_file($file_tmp_name, $target_file)) {
								$success["update"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> Your image has successfully been updated!</div>";
							} else {
								echo $userdb->error;
							}
						} else {
							$errors["unknown-error"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Something went wrong with the upload. Please try agan later. </div>";
						}
					} else {
						$errors["unknown-error"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Something went wrong <br> Please try agan later. </div>";
					}
				}
			}
		}
	}
}


if (isset($_POST["preview-tutorial"])) {
	
	
	//getting all the variables and creating paths for the image
	$id = $_SESSION["id"];
	$title = htmlspecialchars($_POST["title"]);
	$tag= htmlspecialchars($_POST["tag"]);
	$link= htmlspecialchars($_POST["link"]);
	$author= htmlspecialchars($_POST["author"]);
    $image_name = titlelize($_POST["display-image-name"]);
    $preview_text = $_POST["page-content"];
	$preview_text = reg_textarea($preview_text);
	$target_name = "../tutorial/".$tag."/".titlelize($title).".php";
	$target_preview_name = "../tutorial/".$tag."/".titlelize($title)."-preview.php";
	
	#file data
	$target_dir = "../images/explore/";
	$file_name = htmlspecialchars($_FILES["display-image"]["name"]);
	$file_type = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
	$new_file_name = $image_name.".".$file_type;
	$target_file = $target_dir . $new_file_name;
	$file_tmp_name = $_FILES["display-image"]["tmp_name"];
	$file_size = $_FILES["display-image"]["size"];
	$file_error = $_FILES["display-image"]["error"];
	$check = getimagesize($file_tmp_name);

	#generate
	$generate_button = "
	<?php
		echo \"
		<form action='../../admin/content-controller.php' method='POST'>
		<input type='hidden'  name='target-name' value='$target_name'>
		<input type='hidden'  name='current-name' value='$target_preview_name'>
		<input type='hidden'  name='target-file' value='$target_file'>
		<input type='hidden'  name='title' value='$title'>
		<input type='hidden'  name='link' value='$link'>
		<input type='hidden'  name='author' value='$author'>
		<input type='hidden'  name='tag' value='$tag'>
		<input type='hidden'  name='directory' value='explore'>
		<input type='hidden'  name='display-image' value='$new_file_name'>
		<div class='form-group text-center'>
	        <button type='submit' name='generate-tutpage' class='btn btn-warning warning-hover fw-bold my-3 p-2 no-shadow'>Generate</button>						
	        <button type='submit' name='cancel-tutpage' class='btn btn-warning warning-hover fw-bold my-3 p-2 no-shadow'>Cancel</button>						
	    </div>
		</form>
		\";
	?>
	";

	//Check if image file is a actual image or fake image
	if($check == false) {
		$errors["file-type"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>File is not an image </div>";
	} else {
		// Allow certain file formats
		if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif" ) {
			$errors["file-format"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Only JPG, JPEG, PNG & GIF files are allowed </div>";
		} else {
			// Check file size
			if ($file_size > 50000000) {
			$errors["file-size"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>File is too large, it must be less than 5mb. </div>";
			} else {
				if (file_exists($target_file)) {
					$errors["file-exists"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>File already exists.</div>";
	            } else {   
				    if ($file_error == 0) {
				    	if (empty($errors["file-type"] || $errors["file-format"] || $errors["file-size"] || $errors["file-exists"])) {
				    		if (move_uploaded_file($file_tmp_name, $target_file)) {
	                            #Now creating the preview file for the user to upload 
								$preview_file = fopen($target_preview_name, "a+");
								$main_file = fopen("../tutorial/".$tag."/temp.tmp", "w+");
								if (fwrite($preview_file, $preview_text)) {
									if (fwrite($main_file, $preview_text)) {
										if (fwrite($preview_file, $generate_button)) {
											fclose($preview_file);
											fclose($main_file);
											header("location: ".$target_preview_name."");
										}
									}
								}
				    		} else {
								$errors["unknown-error"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Something went wrong with the upload. Please try agan later. </div>";
							}
				    	} else {
				    		$errors["unknown-error"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Something went wrong with the upload. Please try agan later. </div>";
				    	}
				    } else {
				    	$errors["unknown-error"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Something went wrong <br> Please try agan later. </div>";
				    }
	            }
			}
		}
	}	

	
}

if (isset($_POST["generate-tutpage"])) {
	$user_id = $_SESSION['id'];
	$directory = $_POST["directory"];
	$template = "tutorial_detail";
	$link = $_POST["link"];
	$author = $_POST["author"];
	$tag = strtoupper($_POST["tag"]);
	$target_name = $_POST["target-name"];
	$current_name = $_POST["current-name"];
	$title = $_POST["title"];
	$display_image = $_POST["display-image"];
	$target_file = $_POST["target-file"];

	$query = "INSERT INTO beelearn.pagedetail (id,template,title,tag,display_image) VALUES (?,?,?,?,?)";
	$task =  $contentdb->prepare($query);
	$task->bind_param("issss", $user_id, $template,$title,$tag,$display_image);
	if ($task->execute()) {
		if(rename("../tutorial/".strtolower($tag)."/temp.tmp", $target_name)) {
			$last_id = $contentdb->insert_id;
			$tut_query = "INSERT INTO beelearn.tutdetail (pageid,link,author,tag) VALUES (?,?,?,?)";
			$task2 =  $contentdb->prepare($tut_query);
			$task2->bind_param("isss", $last_id, $link, $author, $tag);
			if ($task2->execute()) {
				unlink($current_name);
				header("location: ".$target_name."");
				exit();
			} else {
				echo $contentdb->error;
			}
		}
	} else {
		echo $contentdb->error;
	}
}

if (isset($_POST["cancel-tutpage"])) {
	$target_name = $_POST["target-name"];
	$current_name = $_POST["current-name"];
	$target_file = $_POST["target-file"];

	header("location: ../admin/tutorials-template.php");
	unlink($target_file);
	unlink($current_name);
	unlink("../tutorial/".$directory."/temp.tmp");
	exit();
}

?>