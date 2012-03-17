<?php
    class groupClass{
        var $_groupID;
        var $_name;
        var $_admin;
        var $_description;
        
        public function __constructor($groupID){
            require("db_setup.php");
            $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
            mysql_select_db("$db_name", $con);
            
            $this->_groupID = $groupID;
            
            $groupInfo = mysql_fetch_array(mysql_query("SELECT * FROM groups WHERE groupID = '$groupID'"));
            $this->_name = $groupInfo['name'];
            $this->_description = $groupInfo['description'];
            $this->_admin = $groupInfo['admin'];
        
        }
    }
?>
