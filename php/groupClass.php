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
        private $_flaggedPosts;
        
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

            // Initialize a dummy members so the array is never null
//            $this->_confirmedMembers[] = "dummy";
//            $this->_acceptedMembers[] = "dummy";
//            $this->_permittedMembers[] = "dummy";

            $this->_confirmedMembers = array();
            $this->_acceptedMembers = array();
            $this->_permittedMembers = array();
            
            
            // Find the confirmed members of the group
            $memberEmails = mysql_query("SELECT * FROM member_of WHERE groupID = '$groupID'");
            if ($memberEmails != null){
            	//$this->_confirmedMembers = array();
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
            
            $sql = "SELECT postID FROM posts WHERE groupID = $groupID and flag = 0 ORDER BY dateTime DESC";
            $result = mysql_query($sql);
            
            while($post = mysql_fetch_array($result)){
                $this->_posts[] = $post['postID'];
            }
            
            $sql = "SELECT postID FROM posts WHERE groupID = $groupID and flag = 1 ORDER BY dateTime DESC";
            $result = mysql_query($sql);
            
            while($post = mysql_fetch_array($result)){
                $this->_flaggedPosts[] = $post['postID'];
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
        
        public function getFlaggedPosts(){
            return $this->_flaggedPosts;
        }
        
        // Other functions
        public function addMember($email){
            $groupID = $this->getGroupID();
            $sql = "INSERT INTO member_of (email, groupID, accept, permission) VALUES ('$email', '$groupID', 0, 1)";
            mysql_query($sql) or die("Could not add member: " . mysql_error());
        }
        
        public function deleteMember($email){
            $groupID = $this->getGroupID();
            $sql = "DELETE FROM member_of WHERE email = '$email' and groupID = '$groupID'";
            mysql_query($sql) or die("Could not delete member: " . mysql_error());
        }
        
        public function deleteGroup(){
            $groupID = $this->_groupID;
            
            // Remove all the members of the group first
            $sql = "DELETE FROM member_of WHERE groupID = '$groupID'";
            mysql_query($sql) or die("Could not delete member: " . msql_error());
            
            // Remove the group itself
            $sql = "DELETE FROM groups WHERE groupID = '$groupID'";
            mysql_query($sql) or die("Could not delete group: " . mysql_error());      
        }
        
        public function permitMember($email){
            $groupID = $this->getGroupID();
            $sql = "UPDATE member_of SET permit = 1 WHERE email = $email and groupID = $groupID";
            mysql_query($sql) or die("Could not permit member: " . mysql_error());
        }
        
        public function denyMember($email){
            deleteMember($email);
        }
        
        public function ignoreFlaggedPost($postID){
            $sql = "UPDATE posts SET flag = 0 WHERE postID = $postID";
            mysql_query($sql) or die("Could not ignore post: " . mysql_error());            
        }
        
        public function deleteFlaggedPost($postID){
            $sql = "DELETE FROM posts WHERE groupID = $postID";
            mysql_query($sql) or die("could not delete post: " . msql_error());
            
        }
    }
?>
