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
?>