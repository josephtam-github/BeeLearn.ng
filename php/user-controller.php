<?php
session_start();
require_once "db.php";
require_once "emailing.php";

// create empty variables that can be acted upon
$errors = array('username-required' => '', 'username-rule' => '', 'username-length' => '', 'username-used' => '', 'email-required' => '', 'email-invalid' => '', 'email-used' => '', 'email-sent' => '', 'email-null' => '', 'mobile-pattern' => '', 'mobile-used' => '', 'password-required' => '', 'password-short' => '', 'password-mismatch' => '', 'password-used' => '', 'conf-empty' => '', 'wrong-credentials' => '', 'unknown-error' => '', 'file-type' => '' , 'file-format' => '' , 'file-size' => '', 'file-exists' => '', 'login' => '');
$success = array('update' => '' );
$username = $email = $password = $oldpassword = $newpassword = $confpassword = $retrieveEmail = ""; // this will make previous wrong input  to still appear in form after error
$usernamestate = $emailstate = $mobile = $passwordstate = $oldpasswordstate = $newpasswordstate = $confstate = "";
$usernameicon = $emailicon = $mobileicon = $passwordicon = $oldpasswordicon = $newpasswordicon = $confpasswordicon = "";

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
	->setUsername(ENAME)
	->setPassword(EPASSWORD);


// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);


//collects and processes input to remove whitespace backslashes and prevent XSS attack
function process_input($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}

//function that converts timestap to  elapsed time string
function time_elapsed_string($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}
	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(',', $string) . ' ago' : ' just now';
}

//token generator and general password for login and signup
if(isset($_POST["signup-btn"])) {
$password = process_input($_POST["password"]);
$token = bin2hex(random_bytes(50));
$verified = false;
}
//check if button was clicked and assign values inputed to variables

if (isset($_POST["signup-btn"])) {
	//proccess inputed variable and assign to variable
	$email = process_input($_POST["email"]);
	$username = process_input($_POST["username"]);
	$mobile = process_input($_POST["mobile"]);
	$confpassword = process_input($_POST["confpassword"]);
	$gender = $_POST["gender"];
	if ($gender == "male") {
		$dp = "avatar1.png";
	} else {
		$dp = "avatar2.png";
	}

	//database statement
	$usernamestmt = "SELECT * FROM beelearn.userdetail WHERE username = '$username' LIMIT 1";
	$emailstmt = "SELECT * FROM beelearn.userdetail WHERE email = '$email' LIMIT 1";
	$mobilestmt = "SELECT * FROM beelearn.userdetail WHERE mobile = '$mobile' LIMIT 1";

	if ($usernamelist = $userdb->query($usernamestmt)) {
		$usernamecount = $usernamelist->num_rows;
	} else {
		echo $usernamelist->error;
	}

	if ($emaillist = $userdb->query($emailstmt)) {
		$emailcount = $emaillist->num_rows;
	} else {
		echo $emaillist->error;
	}

	if ($mobilelist = $userdb->query($mobilestmt)) {
		$mobilecount = $mobilelist->num_rows;
	} else {
		echo $mobilelist->error;
	}

	//All input verification

	if (empty($username)) {
		$errors["username-required"] = "<div class='py-1 text-danger'>* Username required</div>";//creates error message in array if no input
	} else {
		if(preg_match('/\W/',$username)) {
			$errors["username-rule"] = "<div class='py-1 text-danger'>* Username must have only letters and numbers and underscore</div>";//creates error message in array if no input
		} else {
			if(strlen($username) < 5 ) {
				$errors["username-length"] = "<div class='py-1 text-danger'>* Username must contain a minimum of 5 characters</div>";
			} else {
				if ($usernamecount > 0 ) {
					$errors['username-used'] = "<div class='py-1 text-danger'>* The username you entered has already been used. Try something unique</div>";
				}
			}
		}
	}

	if(empty($email)) {
		$errors["email-required"] = "<div class='py-1 text-danger'>* Email address is required</div>";
	} else {
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
			$errors["email-invalid"] = "<div class='py-1 text-danger'>* The email you entered is invalid</div>";
		} else {
			if ($emailcount > 0 ) {
				$errors['email-used'] = "<div class='py-1 text-danger'>* The email you entered has already been used. Try signing in</div>";
			}
		}
	}
	//regex for mobile number
	if(empty($mobile)){
		$errors["mobile-pattern"] = '';
	} else {
		if(!preg_match('/^0[7-9][0-9]{9}$/',$mobile)) {
			$errors["mobile-pattern"] = "<div class='py-1 text-danger'>* The mobile number you entered does not match the Nigerian telephone pattern</div>";
		} else {
			if ($mobilecount > 0 ) {
			$errors["mobile-used"] = "<div class='py-1 text-danger'>* The mobile number you entered has already been used</div>";
			}
		}
	}

	if (empty($password)) {
		$errors["password-required"] = "<div class='py-1 text-danger'>* Password is required</div>";
	} else {
		if(strlen($password) < 6) {
			$errors["password-short"] = "<div class='py-1 text-danger'>* Password should be at least 6 characters long</div>";
		}
	}

	if(empty($confpassword)) {
		$errors["conf-empty"] = "<div class='py-1 text-danger'>* Please confirm your password</div>";
	} else {
		if($confpassword !== $password) {
			$errors["password-mismatch"] = "<div class='py-1 text-danger'>* The password you entered does not match</div>";
		}
	}

	//input field border color and correct icon controller

	if(empty($errors["username-required"] || $errors["username-rule"] || $errors["username-length"] || $errors["username-used"])) {
		$usernamestate = "right-input";
		$usernameicon = "fas fa-check-circle";
	} else {
		$usernamestate = "wrong-input";
		$usernameicon = "fas fa-times-circle";
	}

	if(empty($errors["email-required"] || $errors["email-invalid"] || $errors["email-used"])) {
		$emailstate = "right-input";
		$emailicon = "fas fa-check-circle";
	} else {
		$emailstate = "wrong-input";
		$emailicon = "fas fa-times-circle";
	}

	if(empty($errors["mobile-pattern"] || $errors["mobile-used"])) {
		$mobilestate = "right-input";
		$mobileicon = "fas fa-check-circle";
	} else {
		$mobilestate = "wrong-input";
		$mobileicon = "fas fa-times-circle";
	}

	// password and confirm password viewer and icon controller

	if(empty($errors["password-required"] || $errors["password-short"])) {
		$passwordstate = "right-input";
		$passwordicon = "fas fa-check-circle";
	} else {
		$passwordstate = "wrong-input";
		$passwordicon = "fas fa-times-circle";
	}

	if(empty($errors["password-mismatch"] || $errors["conf-empty"])) {
		$confstate = "right-input";
		$confpasswordicon = "fas fa-check-circle";
	} else {
		$confstate = "wrong-input";
		$confpasswordicon = "fas fa-times-circle";
	}

	//If there are no errors put data into a database

	if(empty($errors["username-required"] || $errors["username-rule"] || $errors["username-length"] || $errors["username-used"] || $errors["email-required"] || $errors["email-invalid"] || $errors["email-used"] || $errors["mobile-pattern"] || $errors["mobile-used"] || $errors["password-required"] || $errors["password-short"] || $errors["password-mismatch"] || $errors["conf-empty"])) {
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		$autoinsert = "INSERT INTO beelearn.userdetail (username, email, mobile, verified, token, passwords, dp, gender) VALUES (?,?,?,?,?,?,?,?)";
		$task = $userdb->prepare($autoinsert);
		$task->bind_param("sssbssss", $username, $email, $mobile, $verified, $token, $password_hash, $dp, $gender);
		if($task->execute()) {
			//create directory for the dp and comment images
			mkdir("./images/users/".strtolower($username)."/");
			//session creation
			$user_id = $userdb->insert_id;
			$_SESSION['id'] = $user_id;
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $email;
			$_SESSION['mobile'] = $mobile;
			$_SESSION['verified'] = $verified;
			$_SESSION['dp'] = $dp;
			$_SESSION['gender'] = $gender;
			$_SESSION['badge'] = "NEWBEE";
			$_SESSION['logout-btn'] = "<button type='button' class='btn btn-dark text-warning rounded-pill m-2'><i class='fas fa-sign-out-alt'></i></button>";

			//emailverificaton

			SendVerificationEmail($email, $token);

			//flash message
			$_SESSION['message'] = '<div class="my-2 text-center text-warning py-3"><h5><i class="fas fa-user-check fa-4x"></i><br><h1>Congratulations</h1><br> You have successfully Logged in!</h5><br><a href="#" class="text-decoration-none my-2"><h6>Log Out</h6></a></div>';
			$_SESSION['alert-class'] = 'alert-warning';
			header('location: php/landing.php');
			exit();
		} else {
			$_SESSION['error_msg'] = "Database error: Could not register user";
		}
		$task->close();
		$userdb->close();
	}
}

//lOGIN SECTION
//login verification

if (isset($_POST["login-btn"])) {
	$email = process_input($_POST["email"]);
	$password = $_POST["password"];
	if(empty($email)) {
		$errors["email-required"] = "<div class='py-1 text-danger'>* Email address is required</div>";
	}

	if (empty($password)) {
		$errors["password-required"] = "<div class='py-1 text-danger'>* Password is required</div>";
	}

	if(empty($errors["email-required"])) {
		$emailstate = "right-input";
		$emailicon = "fas fa-check-circle";
	} else {
		$emailstate = "wrong-input";
		$emailicon = "fas fa-times-circle";
	}

	if(empty($errors["password-required"])) {
		$passwordstate = "right-input";
		$passwordicon = "fas fa-check-circle";
	} else {
		$passwordstate = "wrong-input";
		$passwordicon = "fas fa-times-circle";
	}

	//check from database if inputed email matches an inputed mail or password

	if (empty($errors["email-required"] || $errors["password-required"])) {
		$checkstmt = "SELECT * FROM beelearn.userdetail WHERE email=? OR username=? LIMIT 1";
		$checktask = $userdb->prepare($checkstmt);
		$checktask->bind_param('ss', $email, $email);
		$checktask->execute();
		$result = $checktask->get_result();
		$user = $result->fetch_assoc();
		echo $userdb->error;
	//check if login password matches password in database
		if(isset($user)){
			if(password_verify($password, $user['passwords'])){
				$_SESSION['id'] = $user['id'];
				$_SESSION['username'] = $user['username'];
				$_SESSION['email'] = $user['email'];
				$_SESSION['mobile'] = $user['mobile'];
				$_SESSION['dp'] = $user['dp'];
				$_SESSION['gender'] = $user['gender'];
				$_SESSION['badge'] = $user['badge'];
				$_SESSION['verified'] = $user['verified'];
				$_SESSION['logout-btn'] = '<button type="button" class="btn btn-dark text-warning rounded-pill m-2"><i class="fas fa-sign-out-alt"></i></button>';
				header('location: ./home.php');
				exit();
			} else {
				$errors["wrong-credentials"] = "<div class='py-1 text-danger text-center'>The password or email address you entered is incorrect</div>";
				$emailstate = "wrong-input";
				$emailicon = "fas fa-times-circle";
				$passwordstate = "wrong-input";
				$passwordicon = "fas fa-times-circle";
			}
		}
	}
}

//unset and destroy session if logout is clicked
if (isset($_GET['logout'])){
	session_destroy();
	unset($_SESSION['id']);
	unset($_SESSION['username']);
	unset($_SESSION['email']);
	unset($_SESSION['mobile']);
	unset($_SESSION['verified']);
	unset($_SESSION['dp']);
	unset($_SESSION['gender']);
	unset($_SESSION['badge']);
	unset($_SESSION['logout-btn']);
	header('location: ./home.php');
	exit();
}

function VerifyUser($token)
{
	global $userdb;
	$sql = "SELECT * FROM beelearn.userdetail WHERE token='$token' LIMIT 1";
	$result = mysqli_query($userdb, $sql);

	if (mysqli_num_rows($result) > 0) {
		$user = mysqli_fetch_assoc($result);
		$update_query = "UPDATE beelearn.userdetail SET verified=1 WHERE token='$token'";

		if (mysqli_query($userdb, $update_query)) {
			$_SESSION['id'] = $user['id'];
			$_SESSION['username'] = $user['username'];
			$_SESSION['email'] = $user['email'];
			$_SESSION['mobile'] = $user['mobile'];
			$_SESSION['dp'] = $user['dp'];
			$_SESSION['gender'] = $user['gender'];
			$_SESSION['verified'] = 1;
			$_SESSION['badge'] = $user['badge'];
			$_SESSION['logout-btn'] = '<button type="button" class="btn btn-dark text-warning rounded-pill m-2"><i class="fas fa-sign-out-alt"></i></button>' ;
			$userdb->close();
		}
		$userdb->close();
	}

}


#forgot password
$resetInstruction = "<p class='lead mt-3'> When you click send, a reset link will be mailed to the address provided. <br>  Please check your spam folder if the mail is not found </p>";
if (isset($_POST["retrieve-btn"])) {
	$retrieveEmail = process_input($_POST["retrieveEmail"]);
	$retrieveStmnt = "SELECT id, email, username, passwords FROM beelearn.userdetail WHERE email = '$retrieveEmail'";
	$retrieveData = $userdb->query($retrieveStmnt);
	$retrieveArray = $retrieveData->fetch_assoc();
	$retrieveRow = $retrieveData->num_rows;
	echo $userdb->error;
	if(empty($retrieveEmail)) {
		$errors["email-required"] = "<div class='py-1 text-danger'>Please enter an email address</div>";
	} else {
		if(!filter_var($retrieveEmail,FILTER_VALIDATE_EMAIL)) {
			$errors["email-invalid"] = "<div class='py-1 text-danger'>The email you entered is invalid</div>";
		} else {
			if ($retrieveRow === 0 ) {
				$errors['email-null'] = "<div class='py-1 text-danger'>We don't have an account with that email, Please try another one.</div>";
			} else {
				$unexpired_stmnt = "SELECT * FROM beelearn.tokendetail WHERE id = ".$retrieveArray["id"]."";
				$unexpired_result = $userdb->query($unexpired_stmnt);
				$unexpired_array = $unexpired_result->fetch_assoc();
				$last_token_id = $unexpired_result->num_rows;
				echo $userdb->error;
				$last_token_stmnt = "SELECT * FROM beelearn.tokendetail WHERE tokenid = ". $last_token_id."";
				$last_token_result = $userdb->query($last_token_stmnt);
				$last_token_array = $last_token_result->fetch_assoc();
				$unexpired_time = strtotime($last_token_array["time_expired"]);
				if (time() < $unexpired_time) {
					$errors["email-sent"] = "<div class='py-1 text-danger'>We have already mailed you a reset link, check your spam folder or search for it.</div>";
				} else {
					#reset token
					$resetToken = bin2hex(random_bytes(50));
					#put token, expiration date and user id into databse
					$now = time();
					$expiring = $now + 1810;
					$time_expired = date("Y-m-d H:i:s", $expiring);
					$autoinsert = "INSERT INTO beelearn.tokendetail (id, token, time_expired) VALUES (?,?,?)";
					$reset_task = $userdb->prepare($autoinsert);
					$reset_task->bind_param("iss", $retrieveArray['id'], $resetToken, $time_expired);
					if($reset_task->execute()) {
						$tokenId = $userdb->insert_id;
						if (sendResetMail($retrieveArray['email'], $retrieveArray['username'], $resetToken, $tokenId)) {
							$resetInstruction = "<p class='lead text-success'> We just sent a you mail, please check your inbox </p>";
						} else {
							$error["unknown-error"] = "Something went wrong please try again later.";
						}
					} else {
						echo $userdb->error;
					}
				}
			}
		}
	}

	if(empty($errors["email-required"] || $errors["email-invalid"] || $errors["email-null"] || $errors["unknown-error"] || $errors["email-sent"])) {
		$emailstate = "right-input";
		$emailicon = "fas fa-check-circle";
	} else {
		$emailstate = "wrong-input";
		$emailicon = "fas fa-times-circle";
	}
}

#Change passsword code
if (isset($_POST["changepword-btn"])) {
	$confpassword = process_input($_POST["confpassword"]);
	$password = process_input($_POST["password"]);
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	$user_id = process_input($_POST["id"]);

	#check if password exists
	$checkpword = "SELECT passwords FROM beelearn.userdetail WHERE id = $user_id";
	$result = $userdb->query($checkpword);
	$array = $result->fetch_assoc();
	echo $userdb->error;
	$old_password = $array['passwords'];

	if (empty($password)) {
		$errors["password-required"] = "<div class='py-1 text-danger'>* Password is required.</div>";
	} else {
		if(strlen($password) < 6) {
			$errors["password-short"] = "<div class='py-1 text-danger'>* Password should be at least 6 characters long.</div>";
		} else {
			if (password_verify($password,$old_password)) {
				$errors["password-used"] = "<div class='py-1 text-danger'>* You already used this password.</div>";
			}
		}
	}

	if(empty($confpassword)) {
		$errors["conf-empty"] = "<div class='py-1 text-danger'>* Please confirm your password.</div>";
	} else {
		if($confpassword !== $password) {
			$errors["password-mismatch"] = "<div class='py-1 text-danger'>* The password you entered does not match.</div>";
		}
	}
	 // password and confirm password viewer and icon controller

	 if(empty($errors["password-required"] || $errors["password-short"] || $errors["password-used"])) {
		$passwordstate = "right-input";
		$passwordicon = "fas fa-check-circle";
	} else {
		$passwordstate = "wrong-input";
		$passwordicon = "fas fa-times-circle";
	}


	if(empty($errors["password-mismatch"] || $errors["conf-empty"])) {
		$confstate = "right-input";
		$confpasswordicon = "fas fa-check-circle";
	} else {
		$confstate = "wrong-input";
		$confpasswordicon = "fas fa-times-circle";
	}


	if(empty($errors["password-required"] || $errors["password-short"] || $errors["password-mismatch"] || $errors["conf-empty"] || $errors["password-used"])) {
		$pword_update = "UPDATE beelearn.userdetail SET passwords='".$passwords."' WHERE id= $user_id";
		if ($userdb->query($pword_update)) {
			echo "<div class='container fluid bg-success p-3 text-center text-lead text-white font-montserrat animate-left-10'> Your password has been changed succesfully! </div>";
		} else {
			echo $userdb->error;
		}
	}
}

#User settings | Change username
if (isset($_POST["change-username-btn"])) {
	$user_id = $_SESSION["id"];
	//proccess inputed variable and assign to variable
	$username = process_input($_POST["username"]);
	#username verification
	if (empty($username)) {
		$errors["username-required"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> Username required</div>";//creates error message in array if no input
	} else {
		if(preg_match('/\W/',$username)) {
			$errors["username-rule"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> Username must have only letters and numbers and underscore</div>";//creates error message in array if no input
		} else {
			if(strlen($username) < 5 ) {
				$errors["username-length"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> Username must contain a minimum of 5 characters</div>";
			}
		}
	}

	if(empty($errors["username-required"] || $errors["username-rule"] || $errors["username-length"])) {
		$usernamestate = "right-input";
		$usernameicon = "fas fa-check-circle";
	} else {
		$usernamestate = "wrong-input";
		$usernameicon = "fas fa-times-circle";
	}

	if(empty($errors["username-required"] || $errors["username-rule"] || $errors["username-length"])) {
	 $update_query = "UPDATE beelearn.userdetail SET username='".$username."' WHERE id=".$user_id."";
	 if (mysqli_query($userdb, $update_query)) {
			$unset($_SESSION["username"]);
			$_SESSION["username"] = $username;
			$success["update"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> Username successfully updated! </div>";
			$userdb->close();
		} else {
			echo $userdb->error;
		}
	}
}

#User settings |Change email
if (isset($_POST["change-email-btn"])) {
	$user_id = $_SESSION["id"];
	$token = bin2hex(random_bytes(50));
	//proccess inputed variable and assign to variable
	$email = process_input($_POST["email"]);
	#email verification
		//database statement
	$emailstmt = "SELECT * FROM beelearn.userdetail WHERE email = '$email' LIMIT 1";

	if ($emaillist = $userdb->query($emailstmt)) {
		$emailcount = $emaillist->num_rows;
	} else {
		echo $emaillist->error;
	}

	if(empty($email)) {
		$errors["email-required"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> Email address is required</div>";
	} else {
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
			$errors["email-invalid"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> The email you entered is invalid</div>";
		} else {
			if ($emailcount > 0 ) {
				$errors['email-used'] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>  The email you entered has already been used. Try a new one</div>";
			}
		}
	}

	if(empty($errors["email-required"] || $errors["email-invalid"] || $errors["email-used"])) {
		$emailstate = "right-input";
		$emailicon = "fas fa-check-circle";
	} else {
		$emailstate = "wrong-input";
		$emailicon = "fas fa-times-circle";
	}

	if(empty($errors["email-required"] || $errors["email-invalid"] || $errors["email-used"])) {
		$update_query = "UPDATE beelearn.userdetail SET email='$email', token='$token', verified = 0 WHERE id=".$user_id."";
		if (mysqli_query($userdb, $update_query)) {
			unset($_SESSION["email"]);
			 $_SESSION['email'] = $email;
			//emailverificaton
			SendVerificaltionEmail($email, $token);
			$userdb->close();
		} else {
			 echo $userdb->error;
		}
	}
}

#User settings | Change mobile
if (isset($_POST["change-mobile-btn"])) {
	$user_id = $_SESSION["id"];
	//proccess inputed variable and assign to variable
	$mobile = process_input($_POST["mobile"]);

	#check for existing mobile number
	$mobilestmt = "SELECT * FROM beelearn.userdetail WHERE mobile = '$mobile' LIMIT 1";

	if ($mobilelist = $userdb->query($mobilestmt)) {
		$mobilecount = $mobilelist->num_rows;
	} else {
		echo $mobilelist->error;
	}
	 //mobile verification
	 if(empty($mobile)){
		$errors["mobile-pattern"] = '';
	} else {
		if(!preg_match('/^0[7-9][0-9]{9}$/',$mobile)) {
			$errors["mobile-pattern"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> The mobile number you entered does not match the Nigerian telephone pattern</div>";
		} else {
			if ($mobilecount > 0 ) {
			$errors["mobile-used"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> The mobile number you entered has already been used</div>";
			}
		}
	}

	if(empty($errors["mobile-pattern"] || $errors["mobile-used"])) {
		$mobilestate = "right-input";
		$mobileicon = "fas fa-check-circle";
	} else {
		$mobilestate = "wrong-input";
		$mobileicon = "fas fa-times-circle";
	}

	if(empty($errors["mobile-pattern"] || $errors["mobile-used"])) {
		$update_query = "UPDATE beelearn.userdetail SET mobile='$mobile' WHERE id=".$user_id."";
		if (mysqli_query($userdb, $update_query)) {
			$success["update"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> Mobile number successfully updated! </div>";
			$userdb->close();
		} else {
			 echo $userdb->error;
		}
	}
}


#User settings | Change Password
if (isset($_POST["change-password-btn"])) {
	$user_id = $_SESSION["id"];
	//proccess inputed variable and assign to variable
	$oldpassword = process_input($_POST["oldpassword"]);
	$newpassword = process_input($_POST["newpassword"]);
	$confpassword = process_input($_POST["confpassword"]);

	#check oldpassword matches new one
	$checkstmnt = "SELECT * FROM beelearn.userdetail WHERE id = '$user_id'";
	$result = $userdb->query($checkstmnt);
	$user = $result->fetch_assoc();
	$password = $user["passwords"];
	echo $userdb->error;
	if (!password_verify($oldpassword, $password)) {
		$errors["wrong-credentials"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>The password you entered is incorrect</div>";
	}
	 //newpassword verification
	 if (empty($newpassword)) {
		$errors["password-required"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>New password is required</div>";
	} else {
		if(strlen($newpassword) < 6) {
			$errors["password-short"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Password should be at least 6 characters long</div>";
		}
	}

	if(empty($confpassword)) {
		$errors["conf-empty"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> Please confirm your password</div>";
	} else {
		if($confpassword !== $newpassword) {
			$errors["password-mismatch"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> The password you entered does not match</div>";
		}
	}


	if(empty($errors["wrong-credentials"])) {
		$oldpasswordstate = "right-input";
		$oldpasswordicon = "fas fa-check-circle";
	} else {
		$oldpasswordstate = "wrong-input";
		$oldpasswordicon = "fas fa-times-circle";
	}

	if(empty($errors["password-required"] || $errors["password-short"])) {
		$newpasswordstate = "right-input";
		$newpasswordicon = "fas fa-check-circle";
	} else {
		$newpasswordstate = "wrong-input";
		$newpasswordicon = "fas fa-times-circle";
	}

	if(empty($errors["password-mismatch"] || $errors["conf-empty"])) {
		$confstate = "right-input";
		$confpasswordicon = "fas fa-check-circle";
	} else {
		$confstate = "wrong-input";
		$confpasswordicon = "fas fa-times-circle";
	}

	if(empty($errors["wrong-credentials"] || $errors["password-required"] || $errors["password-short"] || $errors["password-mismatch"] || $errors["conf-empty"])) {
		$newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
		$update_query = "UPDATE beelearn.userdetail SET passwords='$newpassword' WHERE id=".$user_id."";
		if (mysqli_query($userdb, $update_query)) {
			$success["update"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> Password successfully updated! </div>";
			$userdb->close();
		} else {
			 echo $userdb->error;
		}
	}
}

if (isset($_POST["change-gender-btn"])) {
	$user_id = $_SESSION["id"];
	$gender = $_POST["gender"];
	$update_query = "UPDATE beelearn.userdetail SET gender='$gender' WHERE id=".$user_id."";
	if (mysqli_query($userdb, $update_query)) {
		$success["update"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> Gender successfully updated! </div>";
		unset($_SESSION["gender"]);
		$_SESSION["gender"] = $gender;
		$userdb->close();
	} else {
		 echo $userdb->error;
	}
}

#Profile picture upload section
if (isset($_POST["change-dp-btn"])) {
	$user_id = $_SESSION["id"];
	$checkstmnt = "SELECT * FROM beelearn.userdetail WHERE id = '$user_id'";
	$result = $userdb->query($checkstmnt);
	$user = $result->fetch_assoc();
	echo $userdb->error;

	$target_dir = "./images/users/".strtolower($user["username"])."/";
	$file_name = $_FILES["dp"]["name"];
	$file_type = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
	$new_file_name = strtolower($user["username"])."_".md5($user_id).".".$file_type;
	$target_file = $target_dir . $new_file_name;
	$file_tmp_name = $_FILES["dp"]["tmp_name"];
	$file_size = $_FILES["dp"]["size"];
	$file_error = $_FILES["dp"]["error"];
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
				/* I feel this isn't needed since users get only one profile picture
				if (file_exists($target_file)) {
					$errors["file-exists"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>File is too large </div>";
				}*/
				if ($file_error == 0) {
					if (empty($errors["file-type"] || $errors["file-format"] || $errors["file-size"])) {
						if (move_uploaded_file($file_tmp_name, $target_file)) {
							$new_dp = "users/".strtolower($user["username"])."/".$new_file_name;
							$update_query = "UPDATE beelearn.userdetail SET dp='$new_dp' WHERE id=".$user_id."";
							if (mysqli_query($userdb, $update_query)) {
								unset($_SESSION["dp"]);
								$_SESSION["dp"] = "users/".$user["username"]."/".$new_file_name;
								$success["update"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> Your profile picture has successfully been updated!</div>";
								$userdb->close();
							} else {
								 echo $userdb->error;
							}
						} else {
							$errors["unknown-error"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Something went wrong with the upload. Please try agan later. </div>";
						}
					}
				} else {
					$errors["unknown-error"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Something went wrong <br> Please try agan later. </div>";
				}
			}
		}
	}
}

#Admin Login
if (isset($_POST["admin-login-btn"])) {
	$email = process_input($_POST["email"]);
	$password = $_POST["password"];
	if(empty($email)) {
		$errors["email-required"] = "<div class='py-1 text-danger'>* Email address is required</div>";
	}

	if (empty($password)) {
		$errors["password-required"] = "<div class='py-1 text-danger'>* Password is required</div>";
	}

	if(empty($errors["email-required"])) {
		$emailstate = "right-input";
		$emailicon = "fas fa-check-circle";
	} else {
		$emailstate = "wrong-input";
		$emailicon = "fas fa-times-circle";
	}

	if(empty($errors["password-required"])) {
		$passwordstate = "right-input";
		$passwordicon = "fas fa-check-circle";
	} else {
		$passwordstate = "wrong-input";
		$passwordicon = "fas fa-times-circle";
	}

	//check from database if inputed email matches an inputed mail or password

	if (empty($errors["email-required"] || $errors["password-required"])) {
		$checkstmt = "SELECT * FROM beelearn.userdetail WHERE email=? OR username=? LIMIT 1";
		$checktask = $userdb->prepare($checkstmt);
		$checktask->bind_param('ss', $email, $email);
		$checktask->execute();
		$result = $checktask->get_result();
		$user = $result->fetch_assoc();
		echo $userdb->error;
	//check if login password matches password in database
		if(isset($user)){
			if(password_verify($password, $user['passwords'])){
				if ($user['badge'] == "ADMIN") {
					$_SESSION['id'] = $user['id'];
					$_SESSION['username'] = $user['username'];
					$_SESSION['email'] = $user['email'];
					$_SESSION['mobile'] = $user['mobile'];
					$_SESSION['dp'] = $user['dp'];
					$_SESSION['gender'] = $user['gender'];
					$_SESSION['verified'] = $user['verified'];
					$_SESSION['badge'] = $user['badge'];
					$_SESSION['logout-btn'] = '<button type="button" class="btn btn-dark text-warning rounded-pill m-2"><i class="fas fa-sign-out-alt"></i></button>';
					header('location: ./admin/dashboard.php');
					exit();
				} else {
					$errors["wrong-credentials"] = "<div class='py-1 text-danger text-center'>You are not an admin.</div>";
					$emailstate = "wrong-input";
					$emailicon = "fas fa-times-circle";
					$passwordstate = "wrong-input";
					$passwordicon = "fas fa-times-circle";
				}
			} else {
				$errors["wrong-credentials"] = "<div class='py-1 text-danger text-center'>The password or email address you entered is incorrect</div>";
				$emailstate = "wrong-input";
				$emailicon = "fas fa-times-circle";
				$passwordstate = "wrong-input";
				$passwordicon = "fas fa-times-circle";
			}
		}
	}
}

if (isset($_POST["send-mail"])) {
	$messageBody = $_POST["mail-content"];
	$messageSubject = $_POST["mail-subject"];
	$list_users_query = "SELECT email FROM beelearn.userdetail WHERE verified = 1";
	$list_result = mysqli_query($userdb, $list_users_query);
	if ($list_result) {
		$list_array = $list_result->fetch_all();
		$len = count($list_array);
		for ($i=0; $i < $len; $i++) { 
			$email = $list_array[$i][0];
			sendMail($email, $messageSubject, $messageBody);
			if ($i == 1 - $len) {
				$success["update"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> The email has been succesfully sent!</div>";
			}
		}
	} else {
		 echo $userdb->error;
	}
}
#test email before sending all user
if (isset($_POST["test-mail"])) {
	$messageBody = $_POST["mail-content"];
	$messageSubject = $_POST["mail-subject"];
	$email = "tamj963@gmail.com";
	if(sendMail($email, $messageSubject, $messageBody)){
		$success["update"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'> The email has been succesfully sent!</div>";
	}
}




#Forum section
if (isset($_POST["send-topic"])) {
	$msg = "";
	if (isset($_SESSION['id'])) {
		$user_id = $_SESSION["id"];
		$checkstmnt = "SELECT * FROM beelearn.userdetail WHERE id = '$user_id'";
		$result = $userdb->query($checkstmnt);
		$user = $result->fetch_assoc();
		echo $userdb->error;
		$userid = htmlspecialchars($_SESSION['id']);
		$template = "forum_detail";
		$title = htmlspecialchars($_POST["topic-title"]);
		$desc = htmlspecialchars($_POST["topic-desc"]);
		$tag = htmlspecialchars($_POST["topic-tag"]);
		if (isset($_POST["topic-notify"])) {
			$notify = htmlspecialchars($_POST["topic-notify"]);
		} else {
			$notify = 0;			
		}
		#form image
		if(!empty($_FILES["topic-image"]["tmp_name"])) {
			$target_dir = "./images/users/".strtolower($user["username"])."/";
			$file_name = $_FILES["topic-image"]["name"];
			$file_type = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
			$now = time();
			$new_file_name = strtolower($now."_".$user["username"])."_".$user_id.".".$file_type;
			$target_file = $target_dir.$new_file_name;
			$file_tmp_name = $_FILES["topic-image"]["tmp_name"];
			$file_size = $_FILES["topic-image"]["size"];
			$file_error = $_FILES["topic-image"]["error"];
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
						if ($file_error == 0) {
							if (empty($errors["file-type"] || $errors["file-format"] || $errors["file-size"])) {
								if (move_uploaded_file($file_tmp_name, $target_file)) {
									$topic_image = "users/".strtolower($user["username"])."/".$new_file_name;
								} else {
									$errors["unknown-error"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Something went wrong with the upload. Please try agan later. </div>";
								}
							}
						} else {
							$errors["unknown-error"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Something went wrong <br> Please try agan later. </div>";
						}
					}
				}
			}
		} else {
			$topic_image = "images/noimage.png";
		}

		if (isset($topic_image)) {
			$forumdb = new mysqli(DBHOST,DBUSER,DBPASS);
			$query = "INSERT INTO beelearn.pagedetail (id,template,title,tag,display_image) VALUES (?,?,?,?,?)";
			echo $forumdb->error;
			$task =  $forumdb->prepare($query);
			$task->bind_param("issss", $user_id, $template, $title, $tag, $topic_image);
			echo $forumdb->error;
			if ($task->execute()) {
				$parentid = 0;
				$last_pageid = $forumdb->insert_id;
				$forum_autoinsert = "INSERT INTO beelearn.commentdetail (id, pageid, parentid, comment, notify) VALUES (?,?,?,?,?)";
				$forum_task = $forumdb->prepare($forum_autoinsert);
				$forum_task->bind_param("iiisi", $userid, $last_pageid, $parentid, $desc, $notify);
				
				if($forum_task->execute()) {
					$success["update"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>Your topic has been published!</div>";
					  //check if the comment is a reply then trace the user notify option and email address to send an email
					  if ($parentid != 0) {
						$check_parent_stmnt = "SELECT id, notify FROM beelearn.commentdetail WHERE commentid = $parentid";
						$check_data = $forumdb->query($check_parent_stmnt);
						$check_array = $check_data->fetch_assoc();
					
						if ($check_array["notify"] == 1 && $userid != $check_array["id"]) {
						  $check_user_stmnt = "SELECT username, email FROM beelearn.userdetail WHERE id = ".$check_array['id']." ";
						  $check_user_data = $forumdb->query($check_user_stmnt);
						  $check_user = $check_user_data->fetch_assoc();
						  //send user an email that he/she has been replied by another person
						  //notifyReply($check_user["username"], $check_user["email"], $comment_encoded);
						}
					  }
					  $forumdb->close();
				} else {
				  array_push($errorbook, $forumdb->connect_error);
				  array_push($errorbook, $forumdb->error);
				}
			} else {
				echo $forumdb->error;
			}
		}

	} else {
		$errors["login"] = "<div class='py-1 text-white container-fluid bg-primary text-center animate-left-10'>You must <a href='./login.php' target='_blank' class='text-warning fw-bold text-decoration-none'>login</a> to be able to create topics</div>";

	}
	  
}

?>