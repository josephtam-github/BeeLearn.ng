<?php
require_once "../php/user-controller.php";
require_once "../php/db.php";
//require_once "addcomment.php";
$pageid = process_input($_GET['pageid']);
$parentid = process_input($_GET['parentid']);
if (isset($_GET['offset'])) {
  $offset = process_input($_GET['offset']);
} else {
  $offset = 0;
}
$loadcommentdb = new mysqli(DBHOST,DBUSER,DBPASS);
$cmnt_statment = "SELECT * FROM beelearn.commentdetail WHERE pageid = $pageid  AND parentid = 0 ORDER BY commenttime ASC";

    if ($cmnt_data = $loadcommentdb->query($cmnt_statment)) {
      $cmnt_array = $cmnt_data->fetch_all(MYSQLI_NUM);
      $cmnt_array_len = count($cmnt_array);
      if (process_input($_GET['show_more']) == 0 && count($cmnt_array) >  5 ) {
        $cmnt_array_len = 5;
      } elseif (process_input($_GET['show_more']) == 1) {
        $cmnt_array_len = count($cmnt_array);
      }
      //put comments in comment or reply shell
      
      for ($row=$offset;  $row < $cmnt_array_len ;  $row++) {
        $comment_id = $cmnt_array[$row][0];
        $parent_stmnt = "SELECT * FROM beelearn.commentdetail WHERE parentid = $comment_id ORDER BY commentid ASC";
        $parent_data =  $loadcommentdb->query($parent_stmnt);
        $parent_array =  $parent_data->fetch_all(MYSQLI_NUM);
        $parent_array_len = count($parent_array);
        $cmnt_user_id = $cmnt_array[$row][1];

        if (isset($_SESSION['id'])) {
          if ($cmnt_user_id == $_SESSION['id']) {
            $delete_btn = "<button name='cmnt_delete' value='".$cmnt_array[$row][0]."' onclick='unComment(this)' class='mx-1 text-secondary pointer fw-bold bg-light border-0 reply'> <i class='fas fa-trash'></i> </button> ";
          } else {
            $delete_btn = '';
          }
        } else {
          $delete_btn = '';
        }

        $username_stmnt = "SELECT username, dp FROM beelearn.userdetail WHERE id = $cmnt_user_id";
        $username_data =  $loadcommentdb->query($username_stmnt);
        $username_array =  $username_data->fetch_assoc();
        $profilepic = $username_array["dp"];

        $upvote_stmnt = "SELECT reaction FROM beelearn.reactiondetail WHERE commentid = $comment_id AND reaction = 'UPVOTE'";
        $upvote_data =  $loadcommentdb->query($upvote_stmnt);
        $upvote_array =  $upvote_data->fetch_all();
        $upvote_array_len = count($upvote_array);
        
        if ($upvote_array_len === 0) {
          $upvote_count = '';
        } else {
          $upvote_count = $upvote_array_len;
        }

        $downvote_stmnt = "SELECT reaction FROM beelearn.reactiondetail WHERE commentid = $comment_id AND reaction = 'DOWNVOTE'";
        $downvote_data =  $loadcommentdb->query($downvote_stmnt);
        $downvote_array =  $downvote_data->fetch_all();
        $downvote_array_len = count($downvote_array);
        
        if ($downvote_array_len === 0) {
          $downvote_count = '';
        } else {
          $downvote_count = $downvote_array_len;
        }

          $cmnt_shell = 
            "<div class='container-fluid px-4 pt-5 d-flex row comment-text'>
              <div class='bg-light col-12 pt-3 border-5 border-start border-warning'>
                <div class='d-flex'>
                  <div class='d-flex flex-column align-items-center justify-content-center'>
                    	<div style='width:50px; height:50px; clip-path: circle(50%);'>
                        <img src='../images/". $profilepic ."' alt='Profile Photo' class='comment' style='width:50px;'>
                      </div>
                    <div class='text-center'>". $username_array['username'] ."</div>
                  </div>
                  <div class='d-flex ms-3 ms-md-5 flex-column justify-content-evenly'>
                    <div class='d-flex pe-0 pe-md-5'>". $cmnt_array[$row][4] ."</div>
                    <div class='d-flex'>
                      <div class='text-secondary  border rounded-3 px-2'>
                      ". $upvote_count ."  <button class='mx-1 text-secondary pointer fw-bold bg-light border-0 reply'  onclick='upvoteComment(this)' type='submit' value='".$cmnt_array[$row][0]."'> <i class='fas fa-arrow-up' id='like'></i> </button>
                      ". $downvote_count ." <button class='mx-1 text-secondary pointer fw-bold bg-light border-0 reply'  onclick='downvoteComment(this)' type='submit' value='".$cmnt_array[$row][0]."'> <i class='fas fa-arrow-down' id='dislike'></i> </button>
                      <a href='#comment_id' class='text-decoration-none'> <button onclick='replyComment(this)' class='mx-1 text-secondary pointer fw-bold bg-light border-0 reply' id='".$cmnt_array[$row][0]."'> <i class='fas fa-reply'></i> </button> </a>
                      ".$delete_btn."
                      </div>
                    </div>	
                  </div>
                </div>
                <div class='d-flex justify-content-end'> 
                  <small class='text-secondary float-end'><i class='fas fa-clock'></i> ". time_elapsed_string ($cmnt_array[$row][6]) ." </small>	
                </div>
              </div>
              </div>";
              echo $cmnt_shell;
            for ($rep=0; $rep < $parent_array_len; $rep++) {
              $parent_user_id = $parent_array[$rep][1];
              
              #parent upvote data
              $p_upvote_stmnt = "SELECT reaction FROM beelearn.reactiondetail WHERE commentid = ".$parent_array[$rep][0]." AND reaction = 'UPVOTE'";
              $p_upvote_data =  $loadcommentdb->query($p_upvote_stmnt);
              $p_upvote_array =  $p_upvote_data->fetch_all();
              $p_upvote_array_len = count($p_upvote_array);
              
              if ($p_upvote_array_len === 0) {
                $p_upvote_count = '';
              } else {
                $p_upvote_count = $p_upvote_array_len;
              }
              
              #parent downvote data
              $p_downvote_stmnt = "SELECT reaction FROM beelearn.reactiondetail WHERE commentid = ".$parent_array[$rep][0]." AND reaction = 'DOWNVOTE'";
              $p_downvote_data =  $loadcommentdb->query($p_downvote_stmnt);
              $p_downvote_array =  $p_downvote_data->fetch_all();
              $p_downvote_array_len = count($p_downvote_array);
              
              if ($p_downvote_array_len === 0) {
                $p_downvote_count = '';
              } else {
                $p_downvote_count = $p_downvote_array_len;
              }

              if (isset($_SESSION['id'])) {
                if ($parent_user_id == $_SESSION['id']) {
                  $delete_btn = "<button name='cmnt_delete' value='".$parent_array[$rep][0]."' onclick='unComment(this)' class='mx-1 text-secondary pointer fw-bold bg-light border-0 reply'> <i class='fas fa-trash'></i> </button> ";
                } else {
                  $delete_btn = '';
                }
              } else {
                $delete_btn = '';
              }

              $parent_name_stmnt = "SELECT username, dp FROM beelearn.userdetail WHERE id = $parent_user_id";
              $parent_name_data =  $loadcommentdb->query($parent_name_stmnt);
              $parent_name_array =  $parent_name_data->fetch_assoc(); 
              $profilepic = $parent_name_array["dp"];

              $reply_shell = 
                "<div class='container-fluid ps-5 pt-1 d-flex row comment-text'>
                  <div class='bg-light col-11 pt-2 border-5 border-start border-dark'>
                    <div class='d-flex'>
                      <div class='d-flex flex-column align-items-center justify-content-center'>
                          <div style='width:50px; height:50px; clip-path: circle(50%);'>
                            <img src='../images/". $profilepic ."' alt='Profile Photo' class='comment' style='width:50px;'>
                          </div>
                        <div class='text-center'>". $parent_name_array['username'] ."</div>
                      </div>
                      <div class='d-flex ms-3 ms-md-5 flex-column justify-content-evenly'>
                        <div class='d-flex pe-0 pe-md-5'>". $parent_array[$rep][4] ."</div>
                        <div class='d-flex'>
                          <div class='text-secondary border rounded-3 px-2'> 
                            ". $p_upvote_count ." <button class='mx-1 text-secondary fw-bold pointer bg-light border-0 reply'  onclick='upvoteComment(this)' type='submit' value='".$parent_array[$rep][0]."'> <i class='fas fa-arrow-up' id='like'></i> </button>
                            ". $p_downvote_count ." <button class='mx-1 text-secondary fw-bold pointer bg-light border-0 reply'  onclick='downvoteComment(this)' type='submit' value='".$parent_array[$rep][0]."'> <i class='fas fa-arrow-down' id='dislike'></i> </button>
                            ".$delete_btn."  
                          </div>	
                        </div>
                      </div>
                    </div>
                    <div class='d-flex justify-content-end'> 
                      <small class='text-secondary float-end'><i class='fas fa-clock'></i> ". time_elapsed_string($parent_array[$rep][6]) ." </small>	
                    </div>
                  </div>
                </div>";
                echo $reply_shell;  
              }
        }
      if (count($cmnt_array) > 5) {
        if ($_GET['show_more'] == 0) {
          echo "<br> <div class='container-fluid text-center comment-text'> <button onclick='showMore()' class='btn btn-warning waarning-hover fw-bold p-1 no-shadow' id='showMore'>Show more</button> <div>";
        } else {
          echo "<br> <div class='container-fluid text-center comment-text'> <button onclick='showLess()' class='btn btn-warning waarning-hover fw-bold p-1 no-shadow' id='showMore'>Show less</button> <div>";
        }
      }
      $loadcommentdb->close();
    } else {
      array_push($errorbook, $loadcommentdb->error);      
    }
?>