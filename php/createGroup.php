<?php
    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }

    // Connect to database    
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
    mysql_select_db("$db_name", $con) or die("Database does not exist");
    
    // Get the new group info from the post form
    $name = $_POST['createGroupName'];
    $description = $_POST['createGroupDescription'];
    $emailString = $_POST['createGroupEmails'];

    // Remove all spaces from email list and seperate it on every ","
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
    
    // Check if any fields are empty
    if(emptyFieldsTest($name, $description)){
        echo("blankError");
    }
    
    // Validate every error
    if(!validateEmails($emailArray, $emailString) && $emailString != ""){
        echo("emailError");
    }
    
    // Adds the group to the database if everything is valid
    if (!emptyFieldsTest($name, $description) && validateEmails($emailArray, $emailString)){
        // Find out the current number of groups then increment it to make new groupID
        $currentGroups = (mysql_query("SELECT groupID FROM groups"));
        
        // Create an array with all the groupIDs
        $groupNums = NULL;
        while ($nextGroup = mysql_fetch_array($currentGroups)){
            $groupNums[] = $nextGroup['groupID'];
        }
        
        // If there are groups then increment the max ID by one
        if($groupNums != NULL){
            $groupID = max($groupNums) + 1;
        }
        
        // Otherwise start off the groupID with 1
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
        $group = new Group($groupID);
        
        // Add each invited member the groups member list and email and/or text them
        if($emailString != ""){
            foreach($emailArray as $email){
                $sql = "SELECT COUNT(*) FROM users WHERE email = '$email'";
                $result = mysql_query($sql);
                
                // If the email is a member of Esquire email them
                if ((mysql_result($result, 0) >= 1)){
                    // Create user object from email
                    $group->addMember($email);
                    $userObject = new User($email);
                    
                    // Check for email notifications and send accordingly
                    if ($userObject->getEmails()){
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->Host = "cse.msstate.edu";
                        $mail->SMTPDebug = 0;
                        $mail->SetFrom('dcspg33@pluto.cse.msstate.edu', 'Esquire');
                        $mail->Subject = "You've been inivted to the Group $name";
                        $message = "Login to join this group!";
                        $mail->Body = $message;
                        $address = $email;
                        $mail->AddAddress($address, "$firstName $lastName");
                        $mail->Send();
                    }
                    
                    // Check for text notifactions and send accordingly
                    if ($userObject->getTexts()){
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->Host = "cse.msstate.edu";
                        $mail->SMTPDebug = 0;
                        $mail->SetFrom('dcspg33@pluto.cse.msstate.edu', 'Esquire');
                        $mail->Subject = "You've been inivted to the Group $name";
                        $message = "Login to join this group!";
                        $mail->Body = $message;
                        $address = $userObject->getPhoneEmail();
                        $mail->AddAddress($address, "$firstName $lastName");
                        $mail->Send();
                        
                    }
                }
                
                // If the email is not part of Esquire send them an Email with an invite to Esquire
                else{
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->Host = "cse.msstate.edu";
                    $mail->SMTPDebug = 0;
                    $mail->SetFrom('dcspg33@pluto.cse.msstate.edu', 'Esquire');
                    $mail->Subject = "$adminEmail has invited to join the Esquire group $name! You have to join Esquire first though!";
                    $message = "Join Esquire!";
                    $mail->Body = $message;
                    $address = $email;
                    $mail->AddAddress($address, "$firstName $lastName");
                    $mail->Send();   
                }
            }
        }
    }
  
    // Close database connection
    mysql_close($con);
?>