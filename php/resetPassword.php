<?php
    // Pull in required files
    require_once("classFiles/db_setup.php");

    // Get email to reset
    $email = $_POST['resetEmail'];
    
    // Connect to database
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
    mysql_select_db("$db_name", $con);
    
    // Make sure the user exists on Esquire
    $sql = "SELECT COUNT(*) FROM users WHERE email = '$email'";
    $result = mysql_query($sql);
    
    // If they do exist start creating a random password
    if ((mysql_result($result, 0) >= 1)){
        // Initialize the new password and start counter
        $newPassword = "";
        $i = 0;
        
        // Take the available characters for a password a shuffle them and get the first character 10 times
        while ($i <= 10){
            $availableCharacters = str_split(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"));
            $newPassword = $newPassword . $availableCharacters[0];
            $i++;
        }
        
        // Create a password object, encrypt it, and get the cipher        
        $newPasswordObject = new Password($newPassword);
        $encryptedNewPassword = $newPasswordObject->encrypt();
        $cipher = $newPasswordObject->getDefaultCipher();
        
        // Construct the update query and query it
        $sql = "UPDATE users SET password='$encryptedNewPassword', cipher='$cipher' WHERE email='$email'";
        mysql_query($sql) or die("Could not rest password: " . mysql_error());
        
        // Create user object for email and get name        
        $user = new User($email);
        $memberName = $user->getFullName();
        
        // Mail the user with the new password
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "cse.msstate.edu";
        $mail->SMTPDebug = 0;
        $mail->SetFrom('dcspg33@pluto.cse.msstate.edu', 'Esquire');
        $mail->Subject = "Password Reset";
        $message = "Hi, you have recently reset your password. Your new password is: '$newPassword'. You'll want to change it immediately.";
        $mail->Body = $message;
        $address = $email;
        $mail->AddAddress($address, "$memberName");
        $mail->Send();  
        
        // Echo success for pop over
        echo "success";
    }
?>