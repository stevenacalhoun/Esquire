<?php 
    class Post{
        // All info variables for password class    
        private $_postID;
        private $_message;
        private $_groupID;
        private $_dateTime;
        private $_flag;
        private $_email;
        
        // Constructor function for post given a postID
        public function Post($postID){
            // Pull on required files and connect to database
            require("db_setup.php");
            $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
            mysql_select_db("$db_name", $con);
            
            // Get all info from database with a given postID
            $postInfoArray = mysql_query("SELECT * FROM posts WHERE postID = '$postID'")or die("Could not get post info: " . mysql_error());
            $postInfo = mysql_fetch_array($postInfoArray);

            // Parse out the data to the different instance variables
            $this->_postID = $postID;
            $this->_message = $postInfo['message'];
            $this->_groupID = $postInfo['groupID'];
            $this->_dateTime = $postInfo['dateTime'];
            $this->_flag = $postInfo['flag'];
            $this->_email = $postInfo['email'];
        }
        
        /** Getters for all private variables **/
        public function getPostID(){
            return $this->_postID;
        }
        
        public function getMessage(){
            return $this->_message;
        }
        
        public function getEmail(){
            return $this->_email;
        }
        
        public function getDateTime(){
            return date("g:ia M j, Y", $this->_dateTime);
        }
        
        public function getGroupID(){
            return $this->_groupID;
        }
        
        public function getFlag(){
            return $this->_flag;
        }
        
        /** Other class related functions **/
        
        // Remove the flag from the post object
        public function removeFlag(){
        $postID = $this->_postID;
        $sql = "UPDATE posts SET flag = 0 WHERE postID = '$postID' ";
        mysql_query($sql) or die("Could not remove flag: " . mysql_error());
        }
    }    
?>