<?php
require_once "password.php";
    $errorbook = array();
    $userdb = new mysqli(DBHOST,DBUSER,DBPASS);

    if ($userdb->connect_error) {
        die(" Database error: <br>". $userdb->connect_error);
    }
    
    $database = "CREATE DATABASE beelearn";
    if ($userdb->query($database) === TRUE) {
        null;
    } else {
        array_push($errorbook, $userdb->error);
    }
    
    $userdetail = "CREATE TABLE beelearn.userdetail
    (
    id INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(225) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    verified TINYINT(1) NOT NULL DEFAULT '0',
    token VARCHAR(100) DEFAULT NULL,
    passwords VARCHAR(225) NOT NULL,
    dp VARCHAR(225) NOT NULL,
    gender VARCHAR(6),
    badge VARCHAR(225) NOT NULL DEFAULT 'NEWBEE',
    PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    
    if ($userdb->query($userdetail) === TRUE) {
       null;
    } else {
        array_push($errorbook, $userdb->error) ;
    }

    
    $pagedetail = "CREATE TABLE beelearn.pagedetail
    (
    pageid INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    id INT(11) UNSIGNED NOT NULL,
    template VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    tag VARCHAR(255) NOT NULL,
    display_image VARCHAR(255) NOT NULL,
    time_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    PRIMARY KEY(pageid),
    FOREIGN KEY(id) REFERENCES beelearn.userdetail(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    
    if ($userdb->query($pagedetail) === TRUE) {
        null; 
    } else {
        array_push($errorbook, $userdb->error);
    }

    $commentdetail = "CREATE TABLE beelearn.commentdetail
    (
    commentid INT(11) UNSIGNED AUTO_INCREMENT,
    id INT(11) UNSIGNED NOT NULL,
    pageid INT(11) UNSIGNED NOT NULL,
    parentid INT(11) UNSIGNED NOT NULL,
    comment VARCHAR(8000) NOT NULL,
    notify TINYINT(1) NOT NULL,
    commenttime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(commentid),
    FOREIGN KEY(id) REFERENCES beelearn.userdetail(id),
    FOREIGN KEY(pageid) REFERENCES beelearn.pagedetail(pageid)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

    if ($userdb->query($commentdetail) === TRUE) {
        null; 
    } else {
        array_push($errorbook, $userdb->error);
    }

    $reactiondetail = "CREATE TABLE beelearn.reactiondetail
    (
    id INT(11) UNSIGNED NOT NULL,
    commentid INT(11) UNSIGNED NOT NULL,
    reaction VARCHAR(11) NOT NULL, 
    FOREIGN KEY(id) REFERENCES beelearn.userdetail(id),
    FOREIGN KEY(commentid) REFERENCES beelearn.commentdetail(commentid),
    CONSTRAINT PK_reaction PRIMARY KEY (id, commentid)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    
    if ($userdb->query($reactiondetail) === TRUE) {
        null; 
    } else {
        array_push($errorbook, $userdb->error);
    }
    //Note when using forreign keys and you should use transitive referencing i.e if B is referencing A then C  should reference B;  
    

    $tokendetail = "CREATE TABLE beelearn.tokendetail
    (
    tokenid INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    id INT(11) UNSIGNED NOT NULL,
    token VARCHAR(255) NOT NULL,
    time_requested DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    time_expired DATETIME NOT NULL,
    PRIMARY KEY(tokenid),
    FOREIGN KEY(id) REFERENCES beelearn.userdetail(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    
    if ($userdb->query($tokendetail) === TRUE) {
        null; 
    } else {
        array_push($errorbook, $userdb->error);
    }

    $tutdetail = "CREATE TABLE beelearn.tutdetail
    (
    pageid INT(11) UNSIGNED NOT NULL,
    link VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    tag VARCHAR(255) NOT NULL,
    PRIMARY KEY(pageid),
    FOREIGN KEY(pageid) REFERENCES beelearn.pagedetail(pageid)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    
    if ($userdb->query($tutdetail) === TRUE) {
        null; 
    } else {
        array_push($errorbook, $userdb->error);
    }
?>