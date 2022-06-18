<?php 
require_once "../php/user-controller.php";
require_once "../php/db.php";

if (isset($_SESSION['id'])) {
    $userid = $_SESSION['id'];

    if (isset($_GET['deleteId'])) {
        $deletedb = new mysqli(DBHOST,DBUSER,DBPASS);
        $delete_id = $_GET['deleteId'];
        $replies_stmnt = "SELECT * FROM beelearn.commentdetail WHERE parentid = $delete_id";
        $replies_data = $deletedb->query($replies_stmnt);
        $replies_array =  $replies_data->fetch_all();
        $replies_array_len = count($replies_array);

        //delete parent comments
        for ($row=0; $row < $replies_array_len ; $row++) { 
            $p_delete_reaction = "DELETE FROM beelearn.reactiondetail WHERE commentid = ".$replies_array[$row][0]."";
            $p_delete_cmnt = "DELETE FROM beelearn.commentdetail WHERE commentid = ".$replies_array[$row][0]."";
            $deletedb->query($p_delete_reaction); 
            $deletedb->query($p_delete_cmnt);
        }

        //delete main comments
        $delete_reaction = "DELETE FROM beelearn.reactiondetail WHERE commentid = $delete_id";
        $delete_cmnt = "DELETE FROM beelearn.commentdetail WHERE commentid = $delete_id";
        $deletedb->query($delete_reaction); 
        $deletedb->query($delete_cmnt);
        echo $deletedb->error;
        $deletedb->close();
    }
} else {
    $msg = "You must <a href='../login.php' target='_blank' class='text-warning fw-bold text-decoration-none'>login</a> to be able to comment or react";
    echo $msg;}
?>