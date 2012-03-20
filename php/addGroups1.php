<?php

  // Start session and bring in DB info
    session_start();
    require_once("db_setup.php");
    require_once("userClass.php");
    $tbl_name = "groups";
    
    $con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
    mysql_select_db("$db_name", $con) or die("Database does not exist");
    
    
    $name = $_POST['createGroupName'];
    $descripton = $_POST['createGroupDescription'];
    $email_string = $_POST['createGroupEmails'];
    
    $email_array = explode(",", $email_string);
    
    
    //checks to see if any of the fields are empty
    function emptyFieldsTest($name, $description, $email_string){
        return ($name == '' || $description == '' || $email_string == '');
    }

    //checks to make sure all emails are valid
    function validateEmails ($email_array){
    foreach ($email_array as $item){
      $check = (ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email));
      if($check == false){
          return false;
      }
    }
    return true;
    }
    
    
    
    if(!emptyFieldsTest($name, $description, $email_string)){
        echo("blankError");
    }
    
    if(!validateEmails($email_array)){
        echo("emailError");
    }
    
    
    //adds the group to the database
    if (emptyFieldsTest($name,$description,$email_string) &&
    validateEmails($email_array)){
    
      $numGroups = (mysql_num_rows(mysql_query("SELECT COUNT() FROM groups")) <= 0);
      $groupID = $numGroups + 1;
    
      $user = $_SESSION['user'];
      $adminEmail = $user->getName();
    
      $squl = "INSERT INTO groups (groupID, name, admin, description) VALUES ('$groupID', '$name', '$adminEmail', '$description')";
      mysql_query($sql) or die("Could not query: " . mysql_error());
    
      //sends the invites to all emails included
      foreach($email_array as $email){
          $message = "$adminEmail has invited to join the Esquire group $name!";
          mail($email, "Esquire Group Invite", $message);
      }
    
    }
    
    //close database connection
    mysql_close($con);
?>