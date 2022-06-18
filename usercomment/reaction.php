<?php 
require_once "../php/user-controller.php";
require_once "../php/db.php";

if (isset($_SESSION['id'])) {

    if (isset($_GET['voteId'])) {

        $userid = $_SESSION['id'];
        $vote_id = $_GET['voteId'];
        $vote_type = $_GET['voteType'];
        
        $votedb = new mysqli(DBHOST,DBUSER,DBPASS);
        $voted = "SELECT * FROM beelearn.reactiondetail WHERE id = $userid AND commentid = $vote_id";
        $type_voted = "SELECT * FROM beelearn.reactiondetail WHERE id = $userid AND commentid = $vote_id AND (reaction = 'UPVOTE' OR reaction = 'DOWNVOTE')";
        $voted_result = $votedb->query($voted);

        if ($voted_result->num_rows ==  0) {
            $vote_stmnt = "INSERT INTO beelearn.reactiondetail (id, commentid, reaction) VALUES (?,?,?)";
            $vote_task = $votedb->prepare($vote_stmnt);
            $vote_task->bind_param("iis", $userid, $vote_id, $vote_type);
            $vote_task->execute();
            echo $votedb->connect_error;
            echo $votedb->error;
        } else {
            $drop_stmnt = "DELETE FROM beelearn.reactiondetail WHERE id = $userid AND commentid = $vote_id";
            $votedb->query($drop_stmnt);
        }
        $votedb->close();
    }
} else {
    $msg = "You must <a href='../login.php' target='_blank' class='text-warning fw-bold text-decoration-none'>login</a> to be able to comment or react";
    echo $msg;}
?>