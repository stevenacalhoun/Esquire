<?php
    class groupClass{
        // All info variables for group calss
        private $_groupID;
        private $_name;
        private $_admin;
        private $_description;
        private $_confirmedMembers;
        private $_allowedMembers;
        private $_permittedMembers;
        private $_posts;
        
        // Constructor function
        public function groupClass($groupID){
            // Connect to database
            require("db_setup.php");
            require_once("userClass.php");
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
            $this->_acceptedMembers[] = "dummy";
            $this->_permittedMembers[] = "dummy";
            
            // Find the confirmed members of the group
            $memberEmails = mysql_query("SELECT * FROM member_of WHERE groupID = '$groupID'");
            if ($memberEmails != null){
            	$this->_confirmedMembers = array();
                while($email = mysql_fetch_array($memberEmails)){
                    if ($email['accept'] and $email['permission']){
                        $this->_confirmedMembers[] = $email['email'];
                    }
                    else if ($email['accept']){
                        $this->_acceptedMembers[] = $email['email'];
                    }
                    else if ($email['permission']){
                        $this->_permittedMembers[] = $email['email'];
                    }
                }
            }
            
            $sql = "SELECT postID FROM posts WHERE groupID=$groupID ORDER BY dateTime DESC";
            $result = mysql_query($sql);
            
            while($post = mysql_fetch_array($result)){
                $this->_posts[] = $post['postID'];
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
        
        public function getPermittedMembers(){
            return $this->_permittedMembers;
        }
        
        public function getAcceptedMembers(){
            return $this->_acceptedMembers;
        }
        
        public function getPosts(){
            return $this->_posts;
        }
        
        // Other functions
        public function addMember($email){
            $groupID = $this->getGroupID();
            $sql = "INSERT INTO member_of (email, groupID, accept, permission) VALUES ('$email', '$groupID', 0, 1)";
            mysql_query($sql) or die("Could not query: " . mysql_error());
        }
        
        public function deleteMember($email){
            $groupID = $this->getGroupID();
            $sql = "DELETE FROM member_of WHERE email = '$email' and groupID = '$groupID'";
            mysql_query($sql) or die("Could not query: " . mysql_error());
        }
        
        public function deleteGroup(){
            $groupID = $this->_groupID;
            
            // Remove all the members of the group first
            $sql = "DELETE FROM member_of WHERE groupID = '$groupID'";
            mysql_query($sql) or die("could not delete some member " . msql_error());
            
            // Remove the group itself
            $sql = "DELETE FROM groups WHERE groupID = '$groupID'";
            mysql_query($sql) or die("could not delete group: " . mysql_error());      
        }
    }
?>
