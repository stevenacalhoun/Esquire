<?php

    // Start session and bring in DB info
    require_once("db_setup.php");
    require_once("userClass.php");
    require_once("groupClass.php");
    require_once("./lib/class.phpmailer.php");
    session_start();
    $tbl_name = "groups";
    
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
    mysql_select_db("$db_name", $con) or die("Database does not exist");

    $emailString = $_POST['emails'];
    $groupID = $_POST['groupID'];
    
    $trimmedEmailString = str_replace(" " , "", $emailString);
    $emailArray = explode(",", $trimmedEmailString);
        
    // Function to check to make sure all emails are valid
    function validateEmails ($emailArray, $emailString){
        if ($emailString == "") return true;
        foreach ($emailArray as $email){
            $check = (ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email));
            if($check == false){
                return false;
            }
        }
            return true;
    }
    
    if (validateEmails($emailArray, $emailString)){
        foreach($emailArray as $email){
            $sql = "SELECT COUNT(*) FROM users WHERE email = '$email'";
            $result = mysql_query($sql);
            $group = new groupClass($groupID);
            if ((mysql_result($result, 0) >= 1)){
                $group->addMember($email);
                $userObject = new userClass($email);
        
            }
        }
    }
    
    else{
        echo "emailError";
    }
?>