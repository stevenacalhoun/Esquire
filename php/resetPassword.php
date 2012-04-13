<?php
    require_once("classFiles/db_setup.php");

    // Get email to reset
    $email = $_POST['email'];
    
    // Take the available characters for a password a shuffle them
    $availableCharacters = str_split(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"));
    
    // Grab the first 10 characters and create password object
    $newPassword = $availableCharacters[0:9];
    $newPasswordObject = new Password($newPassword);
    
    // Encrypt it and get the cipher
    $encryptedNewPassword = $newPasswordObject->encrypt();
    $cipher = $newPasswordObject->getDefaultCipher();
    
    // Construct the update query and query it
    $sql = "UPDATE users SET password='$encryptedNewPassword' cipher='$cipher' WHERE email='$email'";
    mysql_query($sql);
    
    $user = new User($email);
    $memberName = $user->getFullName();
    
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
?>