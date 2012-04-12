<?php

    function getIndexOf($value, $array, $i=0){
        foreach ($array as $arrayValue){
            if ($arrayValue == $value){
                return $i;
            }
            $i++;
        }
    }
    
    class Password{
        // All info variables for password class
        private $_password;
        private $_cipher;
        private $_availableCharacters;
        
        // Constructor function
        public function Password($password){
            require("db_setup.php");
            $this->_password = $password;
            $this->_availableCharacters = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890");
            $this->_cipher = str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890");
        }
        
        public function getDefaultCipher(){
            return $this->_cipher;
        }
        
        public function getCipherFromDB($email){
            require("db_setup.php");
            $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
            mysql_select_db("$db_name", $con);
            $sql = "SELECT cipher FROM users WHERE email = '$email'";
            $result = mysql_query($sql);
            return $result['cipher'];
        }
            
        public function encrypt(){
            $encryptedPassword = "";
            $cipherArray = str_split($this->_cipher);
            $passwordArray = str_split($this->_password);
            foreach ($passwordArray as $char){
                $charIndex = getIndexOf($char, $this->_availableCharacters);
                $encryptedChar = $cipherArray[$charIndex];
                $encryptedPassword = $encryptedPassword . $encryptedChar;
            }
            return $encryptedPassword;
        }
        
        public function decrypt($cipher){
            $decryptedPassword = "";
            $cipherArray = str_split($cipher);            
            $passwordArray = str_split($this->_password);
            foreach($passwordArray as $char){
                $charIndex = getIndexOf($char, $cipherArray);
                $decryptedChar = $this->_availableCharacters[$charIndex];
                $decryptedPassword = $decryptedPassword . $decryptedChar;
            }
            return $decryptedPassword;
        }
    }
?>