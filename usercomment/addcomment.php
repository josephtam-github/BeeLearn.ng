<?php 
require_once "../php/user-controller.php";
require_once "../php/db.php";
require_once "../php/emailing.php";

//check if user has logged in 
if (isset($_SESSION['id'])) {

  $userid = $_SESSION['id'];
  //get XMLHttp JSON request with file_get_contents(php://input)
  $json = file_get_contents('php://input');
  $data = json_decode($json);
  //put JSON contents into variables
  $comment = $data->comment;
  $notify = $data->notify;
  $pageid = $data->pageid;
  $parentid = $data->parentid;
  $comment_encoded = htmlspecialchars($comment);
  
  $commentdb = new mysqli(DBHOST,DBUSER,DBPASS);
  $cmnt_autoinsert = "INSERT INTO beelearn.commentdetail (id, pageid, parentid, comment, notify) VALUES (?,?,?,?,?)";
  $cmnt_task = $commentdb->prepare($cmnt_autoinsert);
  $cmnt_task->bind_param("iiisi", $userid, $pageid, $parentid, $comment_encoded, $notify);
  
  if($cmnt_task->execute()) {
    //check if the comment is a reply then trace the user notify option and email address to send an email
    if ($parentid != 0) {
      $check_parent_stmnt = "SELECT id, notify FROM beelearn.commentdetail WHERE commentid = $parentid";
      $check_data = $commentdb->query($check_parent_stmnt);
      $check_array = $check_data->fetch_assoc();

      if ($check_array["notify"] == 1 && $userid != $check_array["id"]) {
        $check_user_stmnt = "SELECT username, email FROM beelearn.userdetail WHERE id = ".$check_array['id']." ";
        $check_user_data = $commentdb->query($check_user_stmnt);
        $check_user = $check_user_data->fetch_assoc();
        //send user an email that he/she has been replied by another person
        //notifyReply($check_user["username"], $check_user["email"], $comment_encoded);
      }
      
    }

    $commentdb->close();
  } else {
    array_push($errorbook, $commentdb->connect_error);
    array_push($errorbook, $commentdb->error);
  }
} else {
  $msg = "You must <a href='../login.php' target='_blank' class='text-warning fw-bold text-decoration-none'>login</a> to be able to comment or react";
  echo $msg;
}

?>