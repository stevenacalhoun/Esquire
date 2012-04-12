<?php
    require_once("classFiles/db_setup.php");
    session_start();
    
    $groupID = $_SESSION['groupID'];
    $message = $_POST['message'];

    $user = $_SESSION['user'];
    $email = $user->getEmail();
        
    $postNums = array();
    
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
    mysql_select_db("$db_name", $con);
    
    
    $sql = "SELECT postID FROM posts WHERE groupID = $groupID";
    $result = mysql_query($sql) or die("Could not get posts: " . mysql_error());
    
    while ($postIDresult = mysql_fetch_array($result)){
        $postID = $postIDresult['postID'];
        $postIDarray = explode("-", $postID);
        $postNum = $postIDarray[1];
        $postNums[] = $postNum;

    }
    
    if (sizeof($postNums) >= 1){
        $largestPostNum = max($postNums);
        $nextPostNum = $largestPostNum + 1;
    }
    
    else {
        $nextPostNum = 1;
    }
    
    echo $groupID;
    
    
    $newPostID = $groupID . "-" . $nextPostNum;
    $phpDate = date($dateFormat);
    $sqlDate = strtotime($phpDate);    
    
    $sql = "INSERT INTO posts (email, groupID, postID, message, dateTime, flag) VALUES ('$email', $groupID, '$newPostID', '$message', $sqlDate, 0)";
    mysql_query($sql) or die("Could not add post: " . mysql_error());
    
    $group = new Group($groupID);
    
    foreach ($group->getMembers(), $member){
        $memberObject = new User($member);
        if ($memberObject->getEmails()){
            // Send Email
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
        
        if ($memberObject->getTexts()){
            // Send text
        }
        
?>