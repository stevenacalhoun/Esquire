<?php
    // Pull in required files and make sure the user is logged in, if not redirect to log in
    require_once("classFiles/db_setup.php");
    session_start();
    if (!array_key_exists('user', $_SESSION)){
        header('Location:index.php');
    }
    
    // Get groupID and message from POST and sesison
    $groupID = $_SESSION['groupID'];
    $message = $_POST['message'];
    $message = mysql_real_escape_string($message);
    
    // Get user object and get email
    $user = $_SESSION['user'];
    $email = $user->getEmail();
        
    // Initialize the array that will hold all the post IDs
    $postNums = array();
    
    // Connect to the database
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
    mysql_select_db("$db_name", $con);
    
    // Construct SQL to get all post ID's for this group
    $sql = "SELECT postID FROM posts WHERE groupID = $groupID";
    $result = mysql_query($sql) or die("Could not get posts: " . mysql_error());
    
    // Add all the post numbers to the array
    while ($postIDresult = mysql_fetch_array($result)){
        $postID = $postIDresult['postID'];
        $postIDarray = explode("-", $postID);
        $postNum = $postIDarray[1];
        $postNums[] = $postNum;

    }
    
    // If there is at least one post ge the max of the post numbers and increment it for the new post
    if (sizeof($postNums) >= 1){
        $largestPostNum = max($postNums);
        $nextPostNum = $largestPostNum + 1;
    }
    
    // Otherwise start with the new post with number 1
    else {
        $nextPostNum = 1;
    }    
    
    // Construct the new postID and date
    $newPostID = $groupID . "-" . $nextPostNum;
    $phpDate = date($dateFormat);
    $sqlDate = strtotime($phpDate);    
    
    // Construct the SQL to add the post and query the database
    $sql = "INSERT INTO posts (email, groupID, postID, message, dateTime, flag) VALUES ('$email', $groupID, '$newPostID', '$message', $sqlDate, 0)";
    mysql_query($sql) or die("Could not add post: " . mysql_error());
    
    // Create a group object
    $group = new Group($groupID);
    
    // Make the subject the name of the group and the message the message
    $mailSubject = $group->getName();
    $mailMessage = $message;
    
    // For every member group notify them of the post
    foreach ($group->getMembers() as $member){
        // Make new object and don't send an email if the memer is the same as the person that made the post
        $memberObject = new User($member);
        if($user->getEmail() != $member){
        
        // Get full name
        $userName = $memberObject->getFullName();
            
            // If the user wants emails send an email
            if ($memberObject->getEmails()){
                // Send Email
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host = "cse.msstate.edu";
                $mail->SMTPDebug = 0;
                $mail->SetFrom('dcspg33@pluto.cse.msstate.edu', 'Esquire');
                $mail->Subject = $mailSubject;
                $mail->Body = $mailMessage;
                $address = $memberObject->getEmail();
                $mail->AddAddress($address, "$userName");
                $mail->Send();
            }
            
            // If the user wants text send a text
            if ($memberObject->getTexts()){
                // Send Text
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host = "cse.msstate.edu";
                $mail->SMTPDebug = 0;
                $mail->SetFrom('dcspg33@pluto.cse.msstate.edu', 'Esquire');
                $mail->Subject = $mailSubject;
                $message = $mailMessage;
                $mail->Body = $message;
                $address = $memberObject->getPhoneEmail();
                $mail->AddAddress($address, "$userName");
                $mail->Send();
            }
        }
    }
?>