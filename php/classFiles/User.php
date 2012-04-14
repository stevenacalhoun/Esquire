<?php

class User {
    // All info variables for the user calss
    private $_firstName;
    private $_lastName;
    private $_email;
    private $_phoneEmail;
    private $_password;
    private $_groups;
    private $_groupInvites;

    // Constructor function
    public function User($email){
        // Connect to database
        require("db_setup.php");
        $con = mysql_connect("$host", "$sqlusername", "$sqlpassword");
        mysql_select_db("$db_name", $con);
        
        // The email is the passed in value
        $this->_email = $email;
        
        // For the rest of the variables query database and assign to class variables
        $userRow = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE email = '$this->_email'"));
        $this->_firstName = $userRow['firstName'];
        $this->_lastName = $userRow['lastName'];
        $this->_password = $userRow['password'];
        $this->_phoneNum = $userRow['phoneNum'];
        $this->_textUpdates = $userRow['textUpdates'];
        $this->_emailUpdates = $userRow['emailUpdates'];
        $this->_phoneEmail = $userRow['phoneEmail'];
        
        // Initialize the groups array
        $this->_groups = array();
        
        // Populate it from the database
        $groupsIDs = mysql_query("SELECT groupID FROM member_of WHERE email = '$email'");
        while($ID = mysql_fetch_array($groupsIDs)){
            $this->_groups[] = $ID['groupID'];
        }
        
        // Intitialize the array for the groups the user has an invite to
        $this->_groupInvites = array();
        
        // Populate it from the database
        $result = mysql_query("SELECT groupID FROM member_of WHERE email = '$email' and accept = 0");
        while($ID = mysql_fetch_array($result)){
            $this->_groupInvites[] = $ID['groupID'];
        }
    }
    
    /** Getters for all private variables **/
    public function getFirstName(){
        return $this->_firstName;
    }
    
    public function getEmail(){
        return $this->_email;
    }
    
    public function getLastName(){
        return $this->_lastName;
    }
    
    public function getFullName(){
    	return $this->_firstName . ' ' . $this->_lastName;
    }
    
    public function getPhone(){
    	return $this->_phoneNum;
    }
    
    public function getCarrier(){
    	$carrier = $this->_phoneEmail;
    	if(strpos($carrier, "tmomail.net")){
    		return "T-Mobile";
    	}
    	else if(strpos($carrier, "vtext.com")){
    		return "Verizon";
    	}
    	else if(strpos($carrier, "txt.att.net")){
    		return "AT&T";
    	}
    }
    
    public function getPhoneEmail(){
        return $this->_phoneEmail;
    }
    
    public function getTexts(){
    	return $this->_textUpdates;
    }
    
    public function getEmails(){
    	return $this->_emailUpdates;
    }
    
    public function getGroups(){
        return $this->_groups;
    }  
    
    public function getGroupInvites(){
        return $this->_groupInvites;
    }
    
    /** Other functions **/

    // Add a new groupID to the list of groups for a member    
    public function addGroup($groupID){
        $this->_groups[] = $groupID;
    }
    
    // Remove a groupID from the list of groups for a member
    public function removeGroup($groupID){
        $this->_groups = array_diff($this->_groups, array($groupID));
        $this->_groups = array_values($this->_groups);
    }
        
    // Search groups
    public function searchGroups($search){
        $groupList = mysql_query("SELECT groupID FROM groups WHERE name LIKE '%$search%'");
        $groupIDs = null;
        
        while($ID = mysql_fetch_array($groupList)){
            $groupIDs[] = $ID['groupID'];
        }
        return $groupIDs;
    }
    
    // Request admission to a given group
    public function requestAdmission($groupID){     
        $email = $this->_email;    
        $sql = "INSERT INTO member_of (email, groupID, accept, permission) VALUES ('$email', '$groupID', 1, 0)"; 
        mysql_query($sql) or die("Could not reqeust Admission: " . mysql_error()); 
    }
	
	// Accept an awaiting group invitation
	public function acceptInvitation($groupID){
	    $email = $this->_email;
        $sql = "UPDATE  member_of SET  accept =  1 WHERE  email ='$email' AND  groupID = '$groupID'";
        mysql_query($sql) or die("Could not accept invitation: " . mysql_error()); 
	}
	
	// Decline an awaiting group invitation
    public function declineInvitation($groupID){
    	$email = $this->_email;
        $sql = "DELETE FROM member_of WHERE groupID = '$groupID' AND email = '$email'  ";
        mysql_query($sql) or die("Could not delete member: " . msql_error());	
    }
    
    // Delete a post by a given postID
    public function deletePost($postID){
    	$sql = "DELETE FROM posts WHERE postID = '$postID' ";
        mysql_query($sql) or die("Could not delete post: " . mysql_error());
    }
    
    // Flag a post by a given postID
    public function flagPost($postID){
        $sql = "UPDATE posts SET flag = 1 WHERE postID = '$postID'";
        mysql_query($sql);
    }
}