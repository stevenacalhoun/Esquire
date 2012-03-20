<?php

class userClass {
    // All info variables for the user calss
    private $_firstName;
    private $_lastName;
    private $_email;
    private $_phoneEmail;
    private $_password;
    private $_groups;

    // Constructor function
    public function userClass($email){
            // Connect to database
            require("db_setup.php");
            $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
            mysql_select_db("$db_name", $con);
            
            // The email is the passed in value
            $this->_email = $email;
            
            // For the rest of the variables query database and assign to class variables
            $userRow = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE email = '$this->_email'"));
            $this->_firstName = $userRow['firstName'];
            $this->_lastName = $userRow['lastName'];
            $this->_password = $userRow['password'];
            $this->_phoneEmail = $userRow['phoneEmail'];
            
            // Query member_of table and so long as there are rows add the groupID to the groups array
            $groupsIDs = mysql_query("SELECT groupID FROM member_of WHERE email = '$email'");
            while($ID = mysql_fetch_array($groupsIDs)){
                $this->_groups[] = $ID['groupID'];
            }
    }
    
    // Getters for all the private varbles
    public function getFirstName(){
        return $this->_firstName;
    }
    
    public function getEmail(){
        return $this->_email;
    }
    
    public function getLastName(){
        return $this->_lastName;
    }
    
    public function getGroups(){
        return $this->_groups;
    }  
    
    public function addGroup($groupID){
        $this->_groups[] = $groupID;
    }
    
    public function removeGroup($groupID){
        $this->_groups = array_diff($this->_groups, array($groupID));
        $this->_groups = array_values($this->_groups);
    }
}