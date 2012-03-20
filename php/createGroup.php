<?php

    // Start session and bring in DB info
    require_once("db_setup.php");
    require_once("userClass.php");
    session_start();
    $tbl_name = "groups";
    
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
    mysql_select_db("$db_name", $con) or die("Database does not exist");
    
    
    $name = $_POST['createGroupName'];
    $description = $_POST['createGroupDescription'];
    $emailString = $_POST['createGroupEmails'];
    
    $trimmedEmailString = trim($emailString);
    $emailArray = explode(",", $trimmedEmailString);
    
    
    // Function to check to see if any of the fields are empty
    function emptyFieldsTest($name, $description){
        return ($name == '' || $description == '');
    }

    // Function to check to make sure all emails are valid
    function validateEmails ($emailArray){
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
    
    if(!validateEmails($emailArray)){
        echo("emailError");
    }
    
    
    //adds the group to the database
    if (!emptyFieldsTest($name, $description) && validateEmails($emailArray)){
    
      $currentGroups = (mysql_query("SELECT * FROM groups"));
      $numGroups = mysql_num_rows($currentGroups);
      $groupID = $numGroups + 1;
    
      $user = $_SESSION['user'];
      $adminEmail = $user->getEmail();
    
      $sql = "INSERT INTO groups (groupID, name, admin, description) VALUES ('$groupID', '$name', '$adminEmail', '$description')";
      mysql_query($sql) or die("Could not query: " . mysql_error());
      
      $sql = "INSERT INTO member_of (email, groupID, accept) VALUES ('$adminEmail', '$groupID', 'yes')";
      mysql_query($sql) or die("Could not query: " . mysql_error());
    
      //sends the invites to all emails included
//      foreach($email_array as $email){
//          $message = "$adminEmail has invited to join the Esquire group $name!";
//          mail($email, "Esquire Group Invite", $message);
//      }
//    
    }
    
    //close database connection
    mysql_close($con);
?>