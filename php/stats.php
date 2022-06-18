<?php
require_once "user-controller.php";
require_once "db.php";

    $statdb = new mysqli(DBHOST, DBUSER, DBPASS);

    $user_count_stmnt = "SELECT * FROM beelearn.userdetail";
    $user_count_result = $statdb->query($user_count_stmnt);
    $user_array = $user_count_result->fetch_all();
    echo $statdb->error;
    $user_count = count($user_array);
    $verified_users = 0;

    for ($i=0; $i < $user_count; $i++) { 
        if ($user_array[$i][4] == 1) {
            $verified_users++ ;
        }
    }


    $page_count_stmnt = "SELECT * FROM beelearn.pagedetail";
    $page_count_result = $statdb->query($page_count_stmnt);
    $page_array = $page_count_result->fetch_all();
    echo $statdb->error;
    $page_count = count($page_array);


    $cmnt_count_stmnt = "SELECT * FROM beelearn.commentdetail";
    $cmnt_count_result = $statdb->query($cmnt_count_stmnt);
    $cmnt_array = $cmnt_count_result->fetch_all();
    echo $statdb->error;
    $cmnt_count = count($cmnt_array);
    $cmnt_data = null;

    for ($row=0; $row < $cmnt_count; $row++) { 

        #get commenters username
        $cmnt_user_id = $cmnt_array[$row][1];
        $username_stmnt = "SELECT username FROM beelearn.userdetail WHERE id = $cmnt_user_id";
        $username_data =  $statdb->query($username_stmnt);
        $username_array =  $username_data->fetch_assoc();
        $cmnt_username = implode($username_array);
        $cmnt_data .= "
        <tr><td>".$cmnt_username."</td> \n <td>".$cmnt_array[$row][4]."</td> \n <td> <button name='cmnt_delete' value='".$cmnt_array[$row][0]."' onclick='unComment(this)' class='text-secondary pointer fw-bold bg-white border-0 reply'> <i class='fas fa-trash'></i></button>
        </td>
        </tr>";

        
    }
?>