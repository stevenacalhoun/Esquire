<?php

class userClass {
    public $_firstName;
    var $_lastName;
    var $_email;
    var $_phoneEmail;
    var $_password;
    private $_groups;
    
    public function __construct($firstName, $lastName, $email, $phoneEmail, $password, $groups){
        $this->_firstName = $firstName;
        $this->_lastName = $lastName;
        $this->_email = $email;
        $this->_phoneEmail = $phoneEmail;
        $this->_password = $password;
        $this->_groups = $groups;
    }
    
    // Getters
    function getGroups(){
        return $this->_groups;
    }
    function getName(){
        echo $this->_firstName;
    }
}