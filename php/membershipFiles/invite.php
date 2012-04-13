<?php

    // Start session and bring in DB info
    require_once("../classFiles/db_setup.php");
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
            $group = new Group($groupID);
            $groupName = $group->getName();

            if ((mysql_result($result, 0) >= 1)){
                if(!in_array($email, $group->getAllMembers())){
                    $group->addMember($email);
                    $userObject = new User($email);
                    
                    $memberName = $userObject->getFullName();
                    
                    if ($userObject->getEmails()){
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->Host = "cse.msstate.edu";
                        $mail->SMTPDebug = 0;
                        $mail->SetFrom('dcspg33@pluto.cse.msstate.edu', 'Esquire');
                        $mail->Subject = "You've been inivted to the Group $groupName";
                        $message = "Login to join this group!";
                        $mail->Body = $message;
                        $address = $email;
                        $mail->AddAddress($address, "$memberName");
                        $mail->Send();                        
                    }
                    
                    if ($userObject->getTexts()){
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->Host = "cse.msstate.edu";
                        $mail->SMTPDebug = 0;
                        $mail->SetFrom('dcspg33@pluto.cse.msstate.edu', 'Esquire');
                        $mail->Subject = "You've been inivted to the Group $groupName";
                        $message = "Login to join this group!";
                        $mail->Body = $message;
                        $address = $userObject->getPhoneEmail();
                        $mail->AddAddress($address, "$memberName");
                        $mail->Send();
                    }
                }
            }    
            else{
                $adminObject = new User($adminEmail);
                $adminName = $adminObject->getFullName();
                
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host = "cse.msstate.edu";
                $mail->SMTPDebug = 0;
                $mail->SetFrom('dcspg33@pluto.cse.msstate.edu', 'Esquire');
                $mail->Subject = "Join Esquire!";
                $message = "$adminName has invited to join the Esquire group $groupName! You have to join Esquire first though!";
                $mail->Body = $message;
                $address = $email();
                $mail->AddAddress($address, "New Member");
                $mail->Send();   
            }
        }
    }
    
    else{
        echo "emailError";
    }
?>