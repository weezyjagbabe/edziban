<?php

require_once 'UserClass.php';
require_once 'Form.php';

class Session
{
    var $username;     				// Username given on sign-up
    var $userID;       				// Random value generated on current login
    var $userCode;       			// UserCode given on sign-up
    var $userLevel;    				// The level to which the user pertains
    var $time;         				// Time user was last active (page loaded)
    var $logged_in;   				// True if user is logged in, false otherwise
    var $userinfo = array();  		// The array holding all user info
    var $url; 						// The page url current being viewed
    var $referrer;     				// Last recorded site page viewed

    /**
     * Note: referrer should really only be considered the actual
     * page referrer in process.php, any other time it may be
     * inaccurate.
     */

    /* Class constructor */
    function __construct()
    {
        $this -> time = time(); $this -> startSession();
    }

    /**
     * startSession - Performs all the actions necessary to
     * initialize this session object. Tries to determine if the
     * the user has logged in already, and sets the variables
     * accordingly. Also takes advantage of this page load to
     * update the active visitors tables.
     */
    function startSession()
    {
        global $database;  //The database connection
        session_start();   //Tell PHP to start the session

        /* Determine if user is logged in */
        $this -> logged_in = $this -> checkLogin();

        /**
         * Set guest value to users not logged in, and update
         * active guests table accordingly.
         */
        if( !$this -> logged_in )
        {
            $this -> username = $_SESSION['username'] = GUEST_NAME;
            $this -> userLevel = GUEST_LEVEL;
            $database -> addActiveGuest( $_SERVER['REMOTE_ADDR'], $this -> time );
        }

        /* Update users last active timestamp */
        else
        {
            $database -> addActiveUser( $this -> username, $this -> time );
        }

        /* Remove inactive visitors from database */
        $database -> removeInactiveUsers();
        $database -> removeInactiveGuests();

        /* Set referrer page */
        if( isset( $_SESSION['url'] ) )
        {
            $this -> referrer = $_SESSION['url'];
        }
        else
        {
            $this -> referrer = "/";
        }

        /* Set current url */
        $this -> url = $_SESSION[ 'url' ] = $_SERVER[ 'PHP_SELF' ];
    }

    /**
     * checkLogin - Checks if the user has already previously
     * logged in, and a session with the user has already been
     * established. Also checks to see if user has been remembered.
     * If so, the database is queried to make sure of the user's
     * authenticity. Returns true if the user has logged in.
     */
    function checkLogin()
    {
        global $database;  //The database connection

        /* Check if user has been remembered */
        if( isset( $_COOKIE['cookname'] ) && isset( $_COOKIE['cookid'] ) )
        {
            $this->username = $_SESSION['username'] = $_COOKIE['cookname'];
            $this->userID   = $_SESSION['userID']   = $_COOKIE['cookid'];
        }

        /* Username and userID have been set and not guest */
        if( isset($_SESSION['username'] ) && isset( $_SESSION['userID'] ) && $_SESSION['username'] != GUEST_NAME )
        {
            /* Confirm that username and userID are valid */
            if ($database -> confirmuserID ($_SESSION['username'], $_SESSION['userID']) != 0 )
            {
                /* Variables are incorrect, user not logged in */
                unset($_SESSION['username']);
                unset($_SESSION['userID']);
                return false;
            }

            /* User is logged in, set class variables */
            $this -> userinfo  = $database -> getUserInfo( $_SESSION['username'] );
            $this -> userCode  = $this -> userinfo['userCode'];
            $this -> username  = $this -> userinfo['username'];
            $this -> userID    = $this -> userinfo['userID'];
            $this -> userLevel = $this -> userinfo['userLevel'];
            return true;
        }

        /* User not logged in */
        else
        {
            return false;
        }
    }

    /**
     * login - The user has submitted his username and password
     * through the login form, this function checks the authenticity
     * of that information in the database and creates the session.
     * Effectively logging in the user if all goes well.
     */
    function login( $username, $password, $remember )
    {
        global $database, $form;  //The database and form object

        /* Username error checking */
        $field = "username";  //Use field name for username
        if( !$username || strlen( $username = trim( $username ) ) == 0 )
        {
            $form -> setError( $field, "Username not entered" );
        }

        /* Password error checking */
        $field = "password";  //Use field name for password
        if( !$password )
        {
            $form->setError( $field, "Password not entered" );
        }

        /* Return if form errors exist */
        if( $form -> num_errors > 0 )
        {
            return false;
        }

        /* Checks that username is in database and password is correct */
        $username = stripslashes( $username );
        $result = $database -> confirmUserPass( $username, md5( $password ) );

        /* Check error codes */
        if( $result == 1 )
        {
            $field = "username"; $form->setError( $field, "Username not found" );
        }
        else if( $result == 2 )
        {
            $field = "password"; $form->setError( $field, "Invalid password" );
        }

        /* Return if form errors exist */
        if( $form -> num_errors > 0 )
        {
            return false;
        }

        /* Username and password correct, register session variables */
        $this -> userinfo  = $database -> getUserInfo( $username );
        $this -> username  = $_SESSION['username'] = $this -> userinfo['username'];
        $this -> userID    = $_SESSION['userID']   = $this -> generateRandID();
        $this -> userLevel = $this -> userinfo['userLevel'];

        /* Insert userID into database and update active users table */
        $database -> updateUserField( $this -> username, "userID", $this -> userID );
        $database -> addActiveUser( $this -> username, $this -> time );
        $database -> removeActiveGuest( $_SERVER['REMOTE_ADDR']) ;

        /**
         * This is the cool part: the user has requested that we remember that
         * he's logged in, so we set two cookies. One to hold his username,
         * and one to hold his random value userID. It expires by the time
         * specified in constants.php. Now, next time he comes to our site, we will
         * log him in automatically, but only if he didn't log out before he left.
         */
        if( $remember )
        {
            setcookie( "cookname", $this->username, time()+COOKIE_EXPIRE, COOKIE_PATH );
            setcookie( "cookid",   $this->userID,   time()+COOKIE_EXPIRE, COOKIE_PATH );
        }

        /* Login completed successfully */
        return true;
    }

    /**
     * logout - Gets called when the user wants to be logged out of the
     * website. It deletes any cookies that were stored on the users
     * computer as a result of him wanting to be remembered, and also
     * unsets session variables and demotes his user level to guest.
     */
    function logout()
    {
        global $database;  //The database connection
        /**
         * Delete cookies - the time must be in the past,
         * so just negate what you added when creating the
         * cookie.
         */
        if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid']))
        {
            setcookie("cookname", "", time()-COOKIE_EXPIRE, COOKIE_PATH);
            setcookie("cookid",   "", time()-COOKIE_EXPIRE, COOKIE_PATH);
        }

        /* Unset PHP session variables */
        unset($_SESSION['username']);
        unset($_SESSION['userID']);

        /* Reflect fact that user has logged out */
        $this -> logged_in = false;

        /**
         * Remove from active users table and add to
         * active guests tables.
         */
        $database->removeActiveUser($this->username);
        $database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);

        /* Set user level to guest */
        $this->username  = GUEST_NAME;
        $this->userLevel = GUEST_LEVEL;
    }

    /**
     * register - Gets called when the user has just submitted the
     * registration form. Determines if there were any errors with
     * the entry fields, if so, it records the errors and returns
     * 1. If no errors were found, it registers the new user and
     * returns 0. Returns 2 if registration failed.
     */
    function register( $username, $password, $subemail )
    {
        global $database, $form, $mailer;  //The database, form and mailer object

        /* Username error checking */
        $field = "username";  //Use field name for username
        if( !$username || strlen( $username = trim( $username ) ) == 0 )
        {
            $form -> setError( $field, "Username not entered" );
        }
        else
        {
            /* Spruce up username, check length */
            $username = stripslashes( $username );
            if( strlen( $username ) < 5 )
            {
                $form->setError( $field, "Username below 5 characters" );
            }
            elseif( strlen( $username ) > 30 )
            {
                $form->setError( $field, "Username above 30 characters" );
            }
            /* Check if username is not alphanumeric */
            elseif( !eregi( "^([0-9a-z_])+$", $username ) )
            {
                $form->setError( $field, "Username not alphanumeric" );
            }

            /* Check if username is reserved */
            elseif( strcasecmp( $username, GUEST_NAME ) == 0 )
            {
                $form -> setError( $field, "Username reserved word" );
            }

            /* Check if username is already in use */
            elseif( $database -> usernameTaken( $username ) )
            {
                $form -> setError( $field, "Username already in use");
            }

            /* Check if username is banned */
            elseif( $database->usernameBanned( $username ) )
            {
                $form -> setError( $field, "Username banned" );
            }
        }

        /* Password error checking */
        $field = "password";  //Use field name for password

        if( !$password )
        {
            $form -> setError( $field, "Password not entered" );
        }
        else
        {
            /* Spruce up password and check length*/
            $password = stripslashes( $password );

            if( strlen( $password ) < 4 )
            {
                $form -> setError( $field, "Password too short" );
            }

            /* Check if password is not alphanumeric */
            elseif( !eregi( "^([0-9a-z])+$", ( $password = trim( $password ) ) ) )
            {
                $form -> setError( $field, "Password not alphanumeric" );
            }

            /**
             * Note: I trimmed the password only after I checked the length
             * because if you fill the password field up with spaces
             * it looks like a lot more characters than 4, so it looks
             * kind of stupid to report "password too short".
             */
        }

        /* Email error checking */
        $field = "email";  //Use field name for email

        if( !$subemail || strlen( $subemail = trim( $subemail ) ) == 0 )
        {
            $form -> setError( $field, "Email not entered" );
        }

        else
        {
            /* Check if valid email address */
            $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"."\.([a-z]{2,}){1}$";

            if( !eregi( $regex, $subemail ) )
            {
                $form -> setError( $field, "Email invalid" );
            }

            $subemail = stripslashes( $subemail );
        }

        /* Errors exist, have user correct them */
        if($form->num_errors > 0){
            return 1;  //Errors with form
        }
        /* No errors, add the new account to the */
        else{
            if($database->addNewUser($username, md5($password), $subemail)){
                if(EMAIL_WELCOME){
                    $mailer->sendWelcome($username,$subemail,$password);
                }
                return 0;  //New user added succesfully
            }else{
                return 2;  //Registration attempt failed
            }
        }
    }

    function SessionMasterRegister($username, $password, $subemail){

        global $database, $form, $mailer;  //The database, form and mailer object

        /* Username error checking */
        $field = "username";  //Use field name for username
        if(!$username || strlen($username = trim($username)) == 0){
            $form->setError($field, "* Username not entered");
        }
        else{
            /* Spruce up username, check length */
            $username = stripslashes($username);
            if(strlen($username) < 5){
                $form->setError($field, "* Username below 5 characters");
            }
            else if(strlen($username) > 30){
                $form->setError($field, "* Username above 30 characters");
            }
            /* Check if username is not alphanumeric */
            else if(!eregi("^([0-9a-z])+$", $username)){
                $form->setError($field, "* Username not alphanumeric");
            }
            /* Check if username is reserved */
            else if(strcasecmp($username, GUEST_NAME) == 0){
                $form->setError($field, "* Username reserved word");
            }
            /* Check if username is already in use */
            else if($database->usernameTaken($username)){
                $form->setError($field, "* Username already in use");
            }
            /* Check if username is banned */
            else if($database->usernameBanned($username)){
                $form->setError($field, "* Username banned");
            }
        }

        /* Password error checking */
        $field = "password";  //Use field name for password
        if(!$password){
            $form->setError($field, "* Password not entered");
        }
        else{
            /* Spruce up password and check length*/
            $password = stripslashes($password);
            if(strlen($password) < 4){
                $form->setError($field, "* Password too short");
            }
            /* Check if password is not alphanumeric */
            else if(!eregi("^([0-9a-z])+$", ($password = trim($password)))){
                $form->setError($field, "* Password not alphanumeric");
            }
            /**
             * Note: I trimmed the password only after I checked the length
             * because if you fill the password field up with spaces
             * it looks like a lot more characters than 4, so it looks
             * kind of stupid to report "password too short".
             */
        }

        /* Email error checking */
        $field = "email";  //Use field name for email
        if(!$subemail || strlen($subemail = trim($subemail)) == 0){
            $form->setError($field, "* Email not entered");
        }
        else{
            /* Check if valid email address */
            $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                ."\.([a-z]{2,}){1}$";
            if(!eregi($regex,$subemail)){
                $form->setError($field, "* Email invalid");
            }
            $subemail = stripslashes($subemail);
        }

        /* Errors exist, have user correct them */
        if($form->num_errors > 0){
            return 1;  //Errors with form
        }
        /* No errors, add the new account to the */
        else{
            //THE NAME OF THE CURRENT USER THE PARENT...
            $parent = $this->username;
            if($database->addNewMaster($username, md5($password), $subemail, $parent)){
                if(EMAIL_WELCOME){
                    $mailer->sendWelcome($username,$subemail,$password);
                }
                return 0;  //New user added succesfully
            }else{
                return 2;  //Registration attempt failed
            }
        }
    }


    function SessionMemberRegister($username, $password, $subemail){

        global $database, $form, $mailer;  //The database, form and mailer object

        /* Username error checking */
        $field = "username";  //Use field name for username
        if(!$username || strlen($username = trim($username)) == 0){
            $form->setError($field, "* Username not entered");
        }
        else{
            /* Spruce up username, check length */
            $username = stripslashes($username);
            if(strlen($username) < 5){
                $form->setError($field, "* Username below 5 characters");
            }
            else if(strlen($username) > 30){
                $form->setError($field, "* Username above 30 characters");
            }
            /* Check if username is not alphanumeric */
            else if(!eregi("^([0-9a-z])+$", $username)){
                $form->setError($field, "* Username not alphanumeric");
            }
            /* Check if username is reserved */
            else if(strcasecmp($username, GUEST_NAME) == 0){
                $form->setError($field, "* Username reserved word");
            }
            /* Check if username is already in use */
            else if($database->usernameTaken($username)){
                $form->setError($field, "* Username already in use");
            }
            /* Check if username is banned */
            else if($database->usernameBanned($username)){
                $form->setError($field, "* Username banned");
            }
        }

        /* Password error checking */
        $field = "password";  //Use field name for password
        if(!$password){
            $form->setError($field, "* Password not entered");
        }
        else{
            /* Spruce up password and check length*/
            $password = stripslashes($password);
            if(strlen($password) < 4){
                $form->setError($field, "* Password too short");
            }
            /* Check if password is not alphanumeric */
            else if(!eregi("^([0-9a-z])+$", ($password = trim($password)))){
                $form->setError($field, "* Password not alphanumeric");
            }
            /**
             * Note: I trimmed the password only after I checked the length
             * because if you fill the password field up with spaces
             * it looks like a lot more characters than 4, so it looks
             * kind of stupid to report "password too short".
             */
        }

        /* Email error checking */
        $field = "email";  //Use field name for email
        if(!$subemail || strlen($subemail = trim($subemail)) == 0){
            $form->setError($field, "* Email not entered");
        }
        else{
            /* Check if valid email address */
            $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                ."\.([a-z]{2,}){1}$";
            if(!eregi($regex,$subemail)){
                $form->setError($field, "* Email invalid");
            }
            $subemail = stripslashes($subemail);
        }

        /* Errors exist, have user correct them */
        if($form->num_errors > 0){
            return 1;  //Errors with form
        }
        /* No errors, add the new account to the */
        else{
            //THE NAME OF THE CURRENT USER THE PARENT...
            $parent = $this->username;
            if($database->addNewMember($username, md5($password), $subemail, $parent)){
                if(EMAIL_WELCOME){
                    $mailer->sendWelcome($username,$subemail,$password);
                }
                return 0;  //New user added succesfully
            }else{
                return 2;  //Registration attempt failed
            }
        }
    }


    function SessionAgentRegister($username, $password, $subemail){

        global $database, $form, $mailer;  //The database, form and mailer object

        /* Username error checking */
        $field = "username";  //Use field name for username
        if(!$username || strlen($username = trim($username)) == 0){
            $form->setError($field, "* Username not entered");
        }
        else{
            /* Spruce up username, check length */
            $username = stripslashes($username);
            if(strlen($username) < 5){
                $form->setError($field, "* Username below 5 characters");
            }
            else if(strlen($username) > 30){
                $form->setError($field, "* Username above 30 characters");
            }
            /* Check if username is not alphanumeric */
            else if(!eregi("^([0-9a-z])+$", $username)){
                $form->setError($field, "* Username not alphanumeric");
            }
            /* Check if username is reserved */
            else if(strcasecmp($username, GUEST_NAME) == 0){
                $form->setError($field, "* Username reserved word");
            }
            /* Check if username is already in use */
            else if($database->usernameTaken($username)){
                $form->setError($field, "* Username already in use");
            }
            /* Check if username is banned */
            else if($database->usernameBanned($username)){
                $form->setError($field, "* Username banned");
            }
        }

        /* Password error checking */
        $field = "password";  //Use field name for password
        if(!$password){
            $form->setError($field, "* Password not entered");
        }
        else{
            /* Spruce up password and check length*/
            $password = stripslashes($password);
            if(strlen($password) < 4){
                $form->setError($field, "* Password too short");
            }
            /* Check if password is not alphanumeric */
            else if(!eregi("^([0-9a-z])+$", ($password = trim($password)))){
                $form->setError($field, "* Password not alphanumeric");
            }
            /**
             * Note: I trimmed the password only after I checked the length
             * because if you fill the password field up with spaces
             * it looks like a lot more characters than 4, so it looks
             * kind of stupid to report "password too short".
             */
        }

        /* Email error checking */
        $field = "email";  //Use field name for email
        if(!$subemail || strlen($subemail = trim($subemail)) == 0){
            $form->setError($field, "* Email not entered");
        }
        else{
            /* Check if valid email address */
            $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                ."\.([a-z]{2,}){1}$";
            if(!eregi($regex,$subemail)){
                $form->setError($field, "* Email invalid");
            }
            $subemail = stripslashes($subemail);
        }

        /* Errors exist, have user correct them */
        if($form->num_errors > 0){
            return 1;  //Errors with form
        }
        /* No errors, add the new account to the */
        else{
            //THE NAME OF THE CURRENT USER THE PARENT...
            $parent = $this->username;
            if($database->addNewAgent($username, md5($password), $subemail, $parent)){
                if(EMAIL_WELCOME){
                    $mailer->sendWelcome($username,$subemail,$password);
                }
                return 0;  //New user added succesfully
            }else{
                return 2;  //Registration attempt failed
            }
        }
    }
    /**
     * editAccount - Attempts to edit the user's account information
     * including the password, which it first makes sure is correct
     * if entered, if so and the new password is in the right
     * format, the change is made. All other fields are changed
     * automatically.
     */
    function editAccount($subcurpass, $subnewpass, $subemail)
    {
        global $database, $form;  //The database and form object
        /* New password entered */
        if($subnewpass){
            /* Current Password error checking */
            $field = "curpass";  //Use field name for current password
            if(!$subcurpass){
                $form->setError($field, "* Current Password not entered");
            }
            else{
                /* Check if password too short or is not alphanumeric */
                $subcurpass = stripslashes($subcurpass);
                if(strlen($subcurpass) < 4 ||
                    !eregi("^([0-9a-z])+$", ($subcurpass = trim($subcurpass)))){
                    $form->setError($field, "* Current Password incorrect");
                }
                /* Password entered is incorrect */
                if($database->confirmUserPass($this->username,md5($subcurpass)) != 0){
                    $form->setError($field, "* Current Password incorrect");
                }
            }

            /* New Password error checking */
            $field = "newpass";  //Use field name for new password
            /* Spruce up password and check length*/
            $password = stripslashes($subnewpass);
            if(strlen($subnewpass) < 4){
                $form->setError($field, "* New Password too short");
            }
            /* Check if password is not alphanumeric */
            else if(!eregi("^([0-9a-z])+$", ($subnewpass = trim($subnewpass)))){
                $form->setError($field, "* New Password not alphanumeric");
            }
        }
        /* Change password attempted */
        else if($subcurpass){
            /* New Password error reporting */
            $field = "newpass";  //Use field name for new password
            $form->setError($field, "* New Password not entered");
        }

        /* Email error checking */
        $field = "email";  //Use field name for email
        if($subemail && strlen($subemail = trim($subemail)) > 0){
            /* Check if valid email address */
            $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                ."\.([a-z]{2,}){1}$";
            if(!eregi($regex,$subemail)){
                $form->setError($field, "* Email invalid");
            }
            $subemail = stripslashes($subemail);
        }

        /* Errors exist, have user correct them */
        if($form->num_errors > 0){
            return false;  //Errors with form
        }

        /* Update password since there were no errors */
        if($subcurpass && $subnewpass){
            $database->updateUserField($this->username,"password",md5($subnewpass));
        }

        /* Change Email */
        if($subemail){
            $database->updateUserField($this->username,"email",$subemail);
        }

        /* Success! */
        return true;
    }

    /**
     * isAdmin - Returns true if currently logged in user is
     * an administrator, false otherwise.
     */
    function isAdmin()
    {
        return ( $this->userLevel == ADMIN_LEVEL || $this->username  == ADMIN_NAME );
    }

    function isBranchAdmin()
    {
        return ( $this->userLevel == BRANCH_ADMIN_LEVEL );
    }

    function isTeacher()
    {
        return ( $this->userLevel == TEACHER_LEVEL );
    }

    function isSecretary()
    {
        return ( $this->userLevel == SECRETARY_LEVEL );
    }

    function isAccountant()
    {
        return ( $this->userLevel == ACCOUNTANT_LEVEL );
    }

    function isResourceManager()
    {
        return ( $this->userLevel == RESOURCE_MANAGER_LEVEL );
    }

    function isStudent()
    {
        return ( $this->userLevel == STUDENT_LEVEL );
    }

    function isParent()
    {
        return ( $this->userLevel == PARENT_LEVEL );
    }

    /**
     * generateRandID - Generates a string made up of randomized
     * letters (lower and upper case) and digits and returns
     * the md5 hash of it to be used as a userID.
     */
    function generateRandID()
    {
        return md5( $this -> generateRandStr( 16 ) );
    }

    /**
     * generateRandStr - Generates a string made up of randomized
     * letters (lower and upper case) and digits, the length
     * is a specified parameter.
     */
    function generateRandStr( $length )
    {
        $randstr = "";
        for( $i = 0; $i < $length; $i++ )
        {
            $randnum = mt_rand( 0, 61 );
            if( $randnum < 10 )
            {
                $randstr .= chr($randnum+48);
            }
            elseif( $randnum < 36 )
            {
                $randstr .= chr( $randnum + 55 );
            }
            else
            {
                $randstr .= chr( $randnum + 61 );
            }
        }
        return $randstr;
    }
};


/**
 * Initialize session object - This must be initialized before
 * the form object because the form uses session variables,
 * which cannot be accessed unless the session has started.
 */
$session = new Session();

/* Initialize form object */
$form = new Form();

?>
