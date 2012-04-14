<?php
    class Group{
        // All info variables for group calss
        private $_groupID;
        private $_name;
        private $_admin;
        private $_description;
        private $_confirmedMembers;
        private $_allowedMembers;
        private $_permittedMembers;
        private $_allMembers;
        private $_posts;
        private $_flaggedPosts;
        
        // Constructor function
        public function Group($groupID){
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

            // Initialize all arrays for different variants of members
            $this->_confirmedMembers = array();
            $this->_acceptedMembers = array();
            $this->_permittedMembers = array();
            $this->_allMembers = array();
                        
            // Query the database to get different type of members
            $memberEmails = mysql_query("SELECT * FROM member_of WHERE groupID = '$groupID'");
            if ($memberEmails != null){
                while($email = mysql_fetch_array($memberEmails)){
                    // Gather members that are both accepted and permitted
                    if ($email['accept'] and $email['permission']){
                        $this->_confirmedMembers[] = $email['email'];
                    }
                    
                    // Gather accepted members
                    else if ($email['accept']){
                        $this->_acceptedMembers[] = $email['email'];
                    }
                    
                    // Gather permitted members
                    else if ($email['permission']){
                        $this->_permittedMembers[] = $email['email'];
                    }
                }
            }
            
            // All member is just a combonation of all three arrays
            $this->_allMembers = array_merge($this->_confirmedMembers, $this->_acceptedMembers, $this->_permittedMembers);
            
            // Query database for postIDs that are pertaining to this group
            $sql = "SELECT postID FROM posts WHERE groupID = $groupID ORDER BY dateTime DESC";
            $result = mysql_query($sql) or die("Could not get postID's: " . mysql_error());
            
            // Populate the post array from the database
            $this->_posts = array();
            while($post = mysql_fetch_array($result)){
                $this->_posts[] = $post['postID'];
            }
            
            // Query database for flagged postIDs that are pertaining to this group
            $sql = "SELECT postID FROM posts WHERE groupID = $groupID and flag = 1 ORDER BY dateTime DESC";
            $result = mysql_query($sql) or die("Could not get flagged postID's: " . mysql_error());

            // Populate the flagged post array from the database
            $this->_flaggedPosts = array();
            while($post = mysql_fetch_array($result)){
                $this->_flaggedPosts[] = $post['postID'];
            }            
        }
     
        /** Getters for all private variables **/
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
        
        public function getAllMembers(){
            return $this->_allMembers;
        }
        
        public function getPosts(){
            return $this->_posts;
        }
        
        public function getFlaggedPosts(){
            return $this->_flaggedPosts;
        }
        
        /** Admin functions **/
        
        // Function to add a member to the group
        public function addMember($email){
            $groupID = $this->getGroupID();
            $sql = "INSERT INTO member_of (email, groupID, accept, permission) VALUES ('$email', '$groupID', 0, 1)";
            mysql_query($sql) or die("Could not add member: " . mysql_error());
        }
        
        // Function to delete a member from the group
        public function deleteMember($email){
            $groupID = $this->getGroupID();
            $sql = "DELETE FROM member_of WHERE email = '$email' and groupID = '$groupID'";
            mysql_query($sql) or die("Could not delete member: " . mysql_error());
        }
        
        // Function to delete the group entirely
        public function deleteGroup(){
            $groupID = $this->_groupID;
            
            // Remove all the members of the group first
            $sql = "DELETE FROM member_of WHERE groupID = '$groupID'";
            mysql_query($sql) or die("Could not delete member: " . msql_error());
            
            // Remove the group itself
            $sql = "DELETE FROM groups WHERE groupID = '$groupID'";
            mysql_query($sql) or die("Could not delete group: " . mysql_error());      
        }
        
        // Function to permit a request to join from a user
        public function permitRequest($email){
            $groupID = $this->_groupID;
            $sql = "UPDATE member_of SET permission = 1 WHERE email = '$email' and groupID = $groupID";
            mysql_query($sql) or die("Could not permit member: " . mysql_error());
        }
        
        // Funciton to deny a request to join from a user
        public function denyRequest($email){
            $this->deleteMember($email);
        }
        
        // Function to ignore a flagged post
        public function ignoreFlaggedPost($postID){
            $sql = "UPDATE posts SET flag = 0 WHERE postID = $postID";
            mysql_query($sql) or die("Could not ignore post: " . mysql_error());            
        }
        
        // Function to delete a flagged post
        public function deleteFlaggedPost($postID){
            $sql = "DELETE FROM posts WHERE groupID = $postID";
            mysql_query($sql) or die("could not delete post: " . msql_error());
        }
        
        // Function to promote another member to admin
        public function changeAdmin($email){
            $groupID = $this->_groupID;
            $this->_admin = $email;
            $sql = "UPDATE  groups SET admin = '$email' WHERE groupID = '$groupID'";
            mysql_query($sql) or die("Could not change admin: " . mysql_error()); 
        }
    }
?>
