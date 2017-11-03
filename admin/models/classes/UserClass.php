<?php
	/******************************************************
	* The Content Manager                      
	* Copyright (c) 2015 Mep Lab Studio, All Rights Reserved. 
	* 
	* userClass.php
	* 
	* The userClass is meant to simplify the task of accessing
	* information specifically about the user from the database.
	*
	* Written by: Solomon Bortey
	* email: sbortey@payswitch.com.gh
	*******************************************************/

	class UserClass
	{
	   	var $connection;         //The MySQL database connection
	   	var $num_active_users;   //Number of active users viewing site
	   	var $num_active_guests;  //Number of active guests viewing site
	   	var $num_members;        //Number of signed-up users
	   	/* Note: call getNumMembers() to access $num_members! */
	
	   	/* Class constructor */
	   	function __construct()
	   	{
	      	/**
	       	* Only query database to find out number of members
	       	* when getNumMembers() is called for the first time,
	       	* until then, default value set.
	       	*/
	      	$this->num_members = -1;
	      
	      	if( TRACK_VISITORS ) 
	      	{
	      		/* Calculate number of users at site */ 
	      		$this -> calcNumActiveUsers();
	      
	         	/* Calculate number of guests at site */
	         	$this -> calcNumActiveGuests();
	      	}
	   	}
	
	   	/**
	    * confirmUserPass - Checks whether or not the given
	    * username is in the database, if so it checks if the
	    * given password is the same password in the database
	    * for that user. If the user doesn't exist or if the
	    * passwords don't match up, it returns an error code
	    * (1 or 2). On success it returns 0.
	    */
		function confirmUserPass( $username, $password )
	   	{
			/* Add slashes if necessary (for query) */
			if( !get_magic_quotes_gpc() ) 
			{
				$username = addslashes( $username ); 
			}
			
	    	/* Verify that user is in database */
	    	$connection = mysqlconnect();
	    	$stmt = $connection->prepare(" SELECT password FROM ".TBL_USERS." WHERE username = '$username' ");
			$stmt -> bind_result( $dbPassword );
			$stmt -> execute();
			$stmt -> store_result();
		
			if ( !$stmt || $stmt -> num_rows() < 1 ) 
			{
				return 1; /* Indicates username failure */ 
			}
			
			while ( $row = $stmt ->fetch() ) 
			{
				$dbPassword = stripslashes( $dbPassword ); 
			}
			$password = stripslashes( $password );
			
			if ( $password == $dbPassword ) 
			{
				return 0; /* Success! Username and password confirmed */ 
			}
			
			else 
			{
				return 2; /* Indicates password failure */ 
			}
	   	}
	   
		/**
	    * confirmUserID - Checks whether or not the given
	    * username is in the database, if so it checks if the
	    * given userID is the same userID in the database
	    * for that user. If the user doesn't exist or if the
	    * userIDs don't match up, it returns an error code
	    * (1 or 2). On success it returns 0.
	    */
		function confirmUserID( $username, $userID )
	   	{	
			/* Add slashes if necessary (for query) */
	      	if( !get_magic_quotes_gpc() ) { $username = addslashes( $username ); }
			
			$connection = mysqlconnect();
	    	$stmt = $connection->prepare(" SELECT userID FROM ".TBL_USERS." WHERE username = '$username' ");
			$stmt -> bind_result( $dbUserid );
			$stmt -> execute();
			$stmt -> store_result();
			
			if ( !$stmt || $stmt -> num_rows() < 1 ) 
			{
				return 1; /* Indicates username failure */ 
			}
			
			while ( $row = $stmt ->fetch() ) 
			{
				$dbUserid = stripslashes( $dbUserid ); 
			}
			
			$userID = stripslashes( $userID );
			
			if( $userID == $dbUserid )
			{
				return 0; /* Success! Username and userID confirmed */ 
			}
	      	else
	      	{
	      		return 2; /* Indicates userID invalid */ 
			}
	   	}
	   
	   	/**
	   	* usernameTaken - Returns true if the username has
	   	* been taken by another user, false otherwise.
	   	*/
	   	function usernameTaken( $username )
	   	{
	   		if(!get_magic_quotes_gpc()) { $username = addslashes($username); }
			
			$connection = mysqlconnect();
	    	$stmt = $connection->prepare(" SELECT username FROM ".TBL_USERS." WHERE username = '$username' ");
			$stmt -> bind_result( $dbUsername );
			$stmt -> execute();
			$stmt -> store_result();
			return ( $stmt -> num_rows() < 1 );
	   	}
	   
	   	/**
	    * usernameBanned - Returns true if the username has
	    * been banned by the administrator.
	    */
	   	function usernameBanned( $username )
	   	{
	   		if(!get_magic_quotes_gpc()) { $username = addslashes($username); }
			
			$connection = mysqlconnect();
	    	$stmt = $connection->prepare(" SELECT username FROM ".TBL_BANNED_USERS." WHERE username = '$username' ");
			$stmt -> execute();
			$stmt -> store_result();
			return ( $stmt -> num_rows() > 0 );
	   	}
	   
	   	/**
	    * addNewUser - Inserts the given (username, password, email)
	    * info into the database. Appropriate user level is set.
	    * Returns true on success, false otherwise.
	    */
	   	function addNewUser( $username, $password, $email )
	   	{
	   		$time = time();
	      	/* If admin sign up, give admin user level */
	      	if( strcasecmp( $username, ADMIN_NAME ) == 0 ) { $ulevel = ADMIN_LEVEL; }
	      	else{ $ulevel = MASTER_LEVEL; }

            $connection = mysqlconnect();
			$stmt = $connection->prepare(" INSERT INTO ".TBL_USERS." VALUES ( ?,?,?,?,?,? ) ");
  			$stmt->bind_param( 'ssisss', $username, $password, 0, $ulevel, $email, $time );
  			$stmt->execute();
	   	}
	   
	   	// add new Master
	   	function addNewMaster( $username, $password, $email, $parentDirectory )
	   	{
	   		$time = time();
	      	$ulevel = MASTER_LEVEL;   //8

            $connection = mysqlconnect();
	      	$stmt = $connection->prepare(" INSERT INTO ".TBL_USERS." VALUES ( ?,?,?,?,?,?,? ) ");
  			$stmt->bind_param( 'ssissss', $username, $password, 0, $ulevel, $email, $time, $parentDirectory );
  			$stmt->execute();
		}
	   
	   
	   	// add new Agent
	   	function addNewAgent( $username, $password, $email, $parentDirectory )
	   	{
	   		$time = time();
	      	$ulevel = AGENT_LEVEL;   //2

            $connection = mysqlconnect();
            $stmt = $connection->prepare(" INSERT INTO ".TBL_USERS." VALUES ( ?,?,?,?,?,?,? ) ");
  			$stmt->bind_param( 'ssissss', $username, $password, 0, $ulevel, $email, $time, $parentDirectory );
  			$stmt->execute();
	   }
	   
	   	//add new Member
	   	function addNewMember( $username, $password, $email, $parentDirectory )
	   	{
	   		$time = time();
	      	$ulevel = AGENT_MEMBER_LEVEL;

            $connection = mysqlconnect();
	      	$stmt = $connection->prepare(" INSERT INTO ".TBL_USERS." VALUES ( ?,?,?,?,?,?,? ) ");
  			$stmt->bind_param( 'ssissss', $username, $password, 0, $ulevel, $email, $time, $parentDirectory );
  			$stmt->execute();
	   }
	   
	   	/**
	    * updateUserField - Updates a field, specified by the field
	    * parameter, in the user's row of the database.
	    */
	   	function updateUserField( $username, $field, $value )
	   	{
	   		$connection = mysqlconnect();
	    	$stmt = $connection->prepare(" UPDATE ".TBL_USERS." SET ".$field." = '$value' WHERE username = '$username' ");
			$stmt -> execute();
	   	}
	   
	   	/**
	    * getUserInfo - Returns the result array from a mysql
	    * query asking for all information stored regarding
	    * the given username. If query fails, NULL is returned.
	    */
	   	function getUserInfo( $username )
	   	{
			$connection = mysqlconnect();
			$stmt = $connection -> prepare(" SELECT userCode, userID, username, userLevel, primaryGroup, lastLogin FROM ".TBL_USERS." WHERE username = ? ");
			$stmt -> bind_param ('s', $username);
			$stmt -> execute();
    		$stmt->bind_result( $userCode, $userID, $username, $userLevel, $primaryGroup, $lastLogin );
    		$stmt->store_result();

    		while( $stmt->fetch() )
    		{
        		$dbarray = array
        		(
        			$userCode,			"userCode" 			=> $userCode,
	        		$userID, 			"userID" 			=> $userID,
	        		$username, 			"username" 			=> $username,
	        		$userLevel, 		"userLevel" 		=> $userLevel,
	        		$primaryGroup, 		"primaryGroup" 		=> $primaryGroup,
	        		$lastLogin, 		"lastLogin" 		=> $lastLogin,
				);	
    		}
			
			if( !$stmt || $stmt -> num_rows() < 1 ) 
			{
				return NULL; 
			}
			return $dbarray;
	   	}
	   
	    function getUserOnly( $username )
	    {
			$connection = mysqlconnect();
			$stmt = $connection -> prepare(" SELECT username, userID, userlevel, email, lastLogin, parentDirectory FROM ".TBL_USERS." WHERE username = ? ");
			$stmt -> bind_param ('s', $username);
			$stmt -> execute();
    		$stmt->bind_result( $username, $userID, $userlevel, $email, $lastLogin, $parentDirectory );
    		$stmt->store_result();

    		while( $stmt->fetch() )
    		{
        		$dbarray = array(
        		$username, 			"username" => $username, 
        		$userID, 			"userID" => $userID,
        		$userlevel, 		"userlevel" => $userlevel,
        		$email, 			"email" => $email,
        		$lastLogin, 		"lastLogin" => $lastLogin,
        		$parentDirectory, 	"parentDirectory" => $parentDirectory
				);	
    		}
			
			if( !$stmt || $stmt -> num_rows() < 1 ) { return NULL; }
			return $dbarray;
	   	}
	   
	   	/**
	    * getNumMembers - Returns the number of signed-up users
	    * of the website, banned members not included. The first
	    * time the function is called on page load, the database
	    * is queried, on subsequent calls, the stored result
	    * is returned. This is to improve efficiency, effectively
	    * not querying the database when no call is made.
	    */
	   	function getNumMembers()
	   	{
	      	if( $this->num_members < 0 )
	      	{
	      		$connection = mysqlconnect();
				$stmt = $connection->prepare(" SELECT username, userlevel, email, lastLogin, parentDirectory FROM ".TBL_USERS." ");
				$stmt -> bind_result( $username, $userlevel, $email, $lastLogin, $parentDirectory );
				$stmt -> execute();
				$stmt -> store_result();
				$this -> num_members = $stmt -> num_rows();
	      	}
	      	return $this -> num_members;
	   	}
	   
	   	/**
	    * calcNumActiveUsers - Finds out how many active users
	    * are viewing site and sets class variable accordingly.
	    */
	   	function calcNumActiveUsers()
	   	{
	   		$connection = mysqlconnect();
			$stmt = $connection->prepare(" SELECT username, lastLogin FROM ".TBL_ACTIVE_USERS." ");
			$stmt -> bind_result( $username, $lastLogin );
			$stmt -> execute();
			$stmt -> store_result();
			$this -> num_active_users = $stmt -> num_rows();
	   	}
	   
	   	/**
	    * calcNumActiveGuests - Finds out how many active guests
	    * are viewing site and sets class variable accordingly.
	    */
	   	function calcNumActiveGuests()
	   	{
	   		$connection = mysqlconnect();
			$stmt = $connection->prepare(" SELECT ip, lastLogin FROM ".TBL_ACTIVE_GUESTS." ");
			$stmt -> bind_result( $ip, $lastLogin );
			$stmt -> execute();
			$stmt -> store_result();
			$this -> num_active_guests = $stmt -> num_rows();
	   	}
	   
	   	/**
	    * addActiveUser - Updates username's last active lastLogin
	    * in the database, and also adds him to the table of
	    * active users, or updates lastLogin if already there.
	    */
	   	function addActiveUser( $username, $time )
	   	{
	   		$connection = mysqlconnect();
	    	$stmt = $connection->prepare(" UPDATE ".TBL_USERS." SET lastLogin = '$time' WHERE username = '$username' ");
			$stmt -> execute();
			
	      	if( !TRACK_VISITORS ) return;
			$stmt = $connection->prepare(" REPLACE INTO ".TBL_ACTIVE_USERS." VALUES ('$username', '$time') ");
			$stmt -> execute();
			
	      	$this -> calcNumActiveUsers();
	   	}
	   
	   	/* addActiveGuest - Adds guest to active guests table */
	   	function addActiveGuest( $ip, $time )
	   	{
	   		if( !TRACK_VISITORS ) return;
	   		$connection = mysqlconnect();
	    	$stmt = $connection->prepare(" REPLACE INTO ".TBL_ACTIVE_GUESTS." VALUES ('$ip', '$time') ");
			$stmt -> execute();
	   		
	      	$this -> calcNumActiveGuests();
	   	}
	   
	   	/* These functions are self explanatory, no need for comments */
	   
	   	/* removeActiveUser */
	   	function removeActiveUser( $username )
	   	{
	   		if(!TRACK_VISITORS) return;
			$connection = mysqlconnect();
	    	$stmt = $connection->prepare(" DELETE FROM ".TBL_ACTIVE_USERS." WHERE username = '$username' ");
			$stmt -> execute();
			
	      	$this -> calcNumActiveUsers();
	   }
	   
	   	/* removeActiveGuest */
	   	function removeActiveGuest( $ip )
	   	{
	   		if( !TRACK_VISITORS ) return;
	   		$connection = mysqlconnect();
	    	$stmt = $connection->prepare(" DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE ip = '$ip' ");
			$stmt -> execute();
			
	      	$this -> calcNumActiveGuests();
	   	}
	   
	   	/* removeInactiveUsers */
	   	function removeInactiveUsers()
	   	{
	   		if( !TRACK_VISITORS ) return;
	      	$timeout = time()-USER_TIMEOUT*60;
	      	$connection = mysqlconnect();
	    	$stmt = $connection->prepare(" DELETE FROM ".TBL_ACTIVE_USERS." WHERE lastLogin < $timeout ");
			$stmt -> execute();
			
	      	$this -> calcNumActiveUsers();
	   	}
	
	   	/* removeInactiveGuests */
	   	function removeInactiveGuests()
	   	{
	   		if( !TRACK_VISITORS ) return;
	      	$timeout = time()-GUEST_TIMEOUT*60;
	      	$connection = mysqlconnect();
	    	$stmt = $connection->prepare(" DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE lastLogin < $timeout ");
			$stmt -> execute();
			
	      	$this -> calcNumActiveGuests();
	   	}
	};
	
	/* Create database connection */
	$database = new UserClass();
	
?>