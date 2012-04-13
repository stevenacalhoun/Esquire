<?php
    // Pull in necessary files and start session
    require_once("classFiles/db_setup.php");
   
    session_start();
    
    // Redirect back to log in if no one is logged in
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
    mysql_select_db("$db_name", $con);

    $user = $_SESSION['user'];    
    $postID = $_POST['postID'];
    
    $user->flagPost($postID);
?>