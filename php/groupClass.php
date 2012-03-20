<?php
    class groupClass{
        // All info variables for group calss
        private $_groupID;
        private $_name;
        private $_admin;
        private $_description;
        private $_confirmedMembers;
        
        // Constructor function
        public function groupClass($groupID){
            // Connect to database
            require("db_setup.php");
            $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
            mysql_select_db("$db_name", $con);
            
            // The ID is the passed in value
            $this->_groupID = $groupID;
            
            // Pull the rest of the values from the database and assign them to the class variables
            $groupInfo = mysql_fetch_array(mysql_query("SELECT * FROM groups WHERE groupID = '$groupID'"));
            $this->_name = $groupInfo['name'];
            $this->_description = $groupInfo['description'];
            $this->_admin = $groupInfo['admin'];

            //
//            $memberInfo = mysql_fetch_array(mysql_query("SELECT * FROM member_of WHERE groupID = '$groupID' and email = '$email'");
//            $this->_acceptance = $memberInfo['accept'];
            
            // Initialize a dummy members so the array is never null
            $this->_confirmedMembers[] = "dummy";
            
            // Find the confirmed members of the group
            $memberEmails = mysql_query("SELECT email FROM member_of WHERE groupID = '$groupID' and accept = 'yes'");
            if ($memberEmails != null){
                while($email = mysql_fetch_array($memberEmails)){
                    $this->_confirmedMembers[] = $email['email'];
                }
            }
        }
     
        // Getters for all variables because they are private
        public function getGroupID(){
            return $this->_groupID;
        }   
        
        public function getName(){
            return $this->_name;
        }
        
        public function getAdmin(){
            return $this->_admin;
        }
        
        public function getDescription(){
            return $this->_description;
        }
        
        public function getMembers(){
            return $this->_confirmedMembers;
        }
        
        public function addMember($email){
            $groupID = $this->getGroupID();
            $sql = "INSERT INTO member_of (email, groupID, accept) VALUES ('$email', '$groupID', 'no')";
            mysql_query($sql) or die("Could not query: " . mysql_error());
        }
    }
?>
