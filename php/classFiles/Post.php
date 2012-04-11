<?php 
    
    class Post{
        private $_postID;
        private $_message;
        private $_groupID;
        private $_dateTime;
        private $_flag;
        private $_email;
        
        public function Post($postID){
            require("db_setup.php");
            $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
            mysql_select_db("$db_name", $con);
            
            $postInfoArray = mysql_query("SELECT * FROM posts WHERE postID = '$postID'")or die("Could not get post info: " . mysql_error());
            $postInfo = mysql_fetch_array($postInfoArray);

            $this->_postID = $postID;
            $this->_message = $postInfo['message'];
            $this->_groupID = $postInfo['groupID'];
            $this->_dateTime = $postInfo['dateTime'];
            $this->_flag = $postInfo['flag'];
            $this->_email = $postInfo['email'];

        }
        
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
        
    }
    
?>