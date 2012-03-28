<?php

    // Start session and bring in DB info
    require_once("db_setup.php");
    require_once("userClass.php");
    require_once("groupClass.php");
    session_start();
    $tbl_name = "groups";
    
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
    mysql_select_db("$db_name", $con) or die("Database does not exist");
    
    
    $name = $_POST['createGroupName'];
    $description = $_POST['createGroupDescription'];
    $emailString = $_POST['createGroupEmails'];
    

    $trimmedEmailString = str_replace(" " , "", $emailString);
    $emailArray = explode(",", $trimmedEmailString);
    
    
    // Function to check to see if any of the fields are empty
    function emptyFieldsTest($name, $description){
        return ($name == '' || $description == '');
    }

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
    
    
    
    if(emptyFieldsTest($name, $description)){
        echo("blankError");
    }
    
    if(!validateEmails($emailArray, $emailString) && $emailString != ""){
        echo("emailError");
    }
    
    
    //adds the group to the database
    if (!emptyFieldsTest($name, $description) && validateEmails($emailArray, $emailString)){
    
        // Find out the current number of groups then increment it to make new groupID
        $currentGroups = (mysql_query("SELECT groupID FROM groups"));
        
        $groupNums = NULL;
        
        while ($nextGroup = mysql_fetch_array($currentGroups)){
            $groupNums[] = $nextGroup['groupID'];
        }
        
        if($groupNums != NULL){
            $groupID = max($groupNums) + 1;
        }
        
        else {$groupID = 1;}
        
        // Get user from session and get the email
        $user = $_SESSION['user'];
        $adminEmail = $user->getEmail();
        
        // Add group to database
        $sql = "INSERT INTO groups (groupID, name, admin, description) VALUES ('$groupID', '$name', '$adminEmail', '$description')";
        mysql_query($sql) or die("Could not query: " . mysql_error());
        
        // Add admin to group
        $sql = "INSERT INTO member_of (email, groupID, accept, permission) VALUES ('$adminEmail', '$groupID', 1, 1)";
        mysql_query($sql) or die("Could not query: " . mysql_error());
                
        // Add the new groupID to the current users group's list
        $user->addGroup($groupID);
        
        // Create new group object
        $group = new groupClass($groupID);
        
        // Add each invited member the groups member list
        if($emailString != ""){
            foreach($emailArray as $email){
                $group->addMember($email);
    //            $message = "$adminEmail has invited to join the Esquire group $name!";
    //            mail($email, "Esquire Group Invite", $message);
            }
        }
    }
    
    //close database connection
    mysql_close($con);
?>