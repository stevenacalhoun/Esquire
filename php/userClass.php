<?php

class userClass {
    
    private $_firstName;
    private $_lastName;
    private $_email;
    private $_phoneEmail;
    private $_password;
    private $_groups;

        
    public function userClass($email){
            require("db_setup.php");
            $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
            mysql_select_db("$db_name", $con);
            
            $this->_email = $email;

            $userRow = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE email = '$this->_email'"));
            $this->_firstName = $userRow['firstName'];
            $this->_lastName = $userRow['lastName'];
            $this->_password = $userRow['password'];
            $this->_phoneEmail = $userRow['phoneEmail'];
            
            $groupsIDs = mysql_query("SELECT groupID FROM member_of WHERE email = '$email'");
            while($ID = mysql_fetch_array($groupsIDs)){
                $this->_groups[] = $ID['groupID'];
            }
    }
    
    // Getters
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
}