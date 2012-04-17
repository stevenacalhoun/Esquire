<?php
    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("../classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
        
    // Connect to the database
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
    mysql_select_db("$db_name", $con) or die("Database does not exist");
    
    // Get groupID and list of emails to invite from post
    $emailString = $_POST['emails'];
    $groupID = $_POST['groupID'];
    
    // Strip whitespace and seperate the emails by commas
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
    
    // If all the emails are valid then invite them
    if (validateEmails($emailArray, $emailString)){
        foreach($emailArray as $email){
            // SQL to make sure the user is part of Esquire
            $sql = "SELECT COUNT(*) FROM users WHERE email = '$email'";
            $result = mysql_query($sql);
            
            // Make group object and get name
            $group = new Group($groupID);
            $groupName = $group->getName();
            
            // If the user is part of Esquire start inviting
            if ((mysql_result($result, 0) >= 1)){
                // If the user is already a member then don't invite them
                if(!in_array($email, $group->getAllMembers())){
                    // Add the member and make a new user object
                    $group->addMember($email);
                    $userObject = new User($email);
                    
                    // Get name for email
                    $memberName = $userObject->getFullName();
                    
                    // Check for email notifications and send accordingly
                    if ($userObject->getEmails()){
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->Host = $smtpHost;
                        $mail->SMTPDebug = 0;
                        $mail->SetFrom($mailUser, 'Esquire');
                        $mail->Subject = "You've been inivted to the Group $groupName";
                        $message = "Login to join this group!";
                        $mail->Body = $message;
                        $address = $email;
                        $mail->AddAddress($address, "$memberName");
                        $mail->Send();                        
                    }
                    
                    // Check for text notifications and send accordingly
                    if ($userObject->getTexts()){
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->Host = $smtpHost;
                        $mail->SMTPDebug = 0;
                        $mail->SetFrom($mailUser, 'Esquire');
                        $mail->Subject = "You've been inivted to the Group $groupName";
                        $message = "Login to join this group!";
                        $mail->Body = $message;
                        $address = $userObject->getPhoneEmail();
                        $mail->AddAddress($address, "$memberName");
                        $mail->Send();
                    }
                }
            }    
            
            // If the email is not a user of Esquire invite them to join Esquire
            else{
                $adminObject = new User($adminEmail);
                $adminName = $adminObject->getFullName();
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host = $smtpHost;
                $mail->SMTPDebug = 0;
                $mail->SetFrom($mailUser, 'Esquire');
                $mail->Subject = "Join Esquire!";
                $message = "$adminName has invited to join the Esquire group $groupName! You have to join Esquire first though!";
                $mail->Body = $message;
                $address = $email();
                $mail->AddAddress($address, "New Member");
                $mail->Send();   
            }
        }
    }
    
    // If there is an invalid email echo an error
    else{
        echo "emailError";
    }
?>