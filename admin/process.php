<?php
require_once 'models/configurations/configuration.php'; // Include the overall Configurations file
require_once 'models/classes/Session.php';

class Process
{
    /* Class constructor */
    function __construct()
    {
        global $session;

        /* User submitted login form */
        if( isset( $_POST['sublogin'] ) )
        {
            $this->procLogin();
        }

        /* User submitted registration form */
        else if(isset($_POST['subjoin']))
        {
            $this->procRegister();
        }

        /* User submitted registration form */
        elseif( isset( $_POST['member_subjoin'] ) )
        {
            $this->procMemberRegister();
        }

        /* User submitted registration form */
        elseif( isset( $_POST['master_subjoin'] ) )
        {
            $this->procMasterRegister();
        }

        /* User submitted registration form */
        elseif( isset( $_POST['agent_subjoin'] ) )
        {
            $this->procAgentRegister();
        }

        /* User submitted forgot password form */
        elseif( isset( $_POST['subforgot'] ) )
        {
            $this->procForgotPass();
        }

        /* User submitted edit account form */
        else if( isset( $_POST['subedit'] ) )
        {
            $this->procEditAccount();
        }

        /**
         * The only other reason user should be directed here
         * is if he wants to logout, which means user is
         * logged in currently.
         */
        elseif( $session -> logged_in )
        {
            $this -> procLogout();
        }

        /**
         * Should not get here, which means user is viewing this page
         * by mistake and therefore is redirected.
         */
        else
        {
            header( "Location: dashboard" );
        }
    }

    /**
     * procLogin - Processes the user submitted login form, if errors
     * are found, the user is redirected to correct the information,
     * if not, the user is effectively logged in to the system.
     */
    function procLogin()
    {
        global $session, $form;
        /* Login attempt */
        $retval = $session -> login( $_POST['username'], $_POST['password'], isset( $_POST['remember'] ) );

        /* Login successful */
        if( $retval )
        {
            $this->Redirect("dashboard");
        }

        /* Login failed */
        else
        {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form -> getErrorArray();
            $this->Redirect("login");
        }
    }

    function Redirect($Url)
    {
        echo '<script>location.href=\''.$Url.'\';</script>';
    }

    /**
     * procLogout - Simply attempts to log the user out of the system
     * given that there is no logout form to process.
     */
    function procLogout()
    {
        global $session;

        $retval = $session -> logout();
        $this->Redirect("login");
    }

    /**
     * procRegister - Processes the user submitted registration form,
     * if errors are found, the user is redirected to correct the
     * information, if not, the user is effectively registered with
     * the system and an email is (optionally) sent to the newly
     * created user.
     */
    function procRegister()
    {
        global $session, $form;

        /* Convert username to all lowercase (by option) */
        if( ALL_LOWERCASE )
        {
            $_POST['username'] = strtolower($_POST['username']);
        }
        /* Registration attempt */
        $retval = $session -> register( $_POST['username'], $_POST['password'], $_POST['email'] );
        /* Registration Successful */
        if( $retval == 0 )
        {
            $_SESSION['reguname'] = $_POST['username'];
            $_SESSION['regsuccess'] = true;
            header("Location: ".$session -> referrer);
        }

        /* Error found with form */
        elseif( $retval == 1 )
        {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form -> getErrorArray();

            header("Location: ".$session -> referrer);
        }

        /* Registration attempt failed */
        elseif ( $retval == 2 )
        {
            $_SESSION['reguname'] = $_POST['username'];
            $_SESSION['regsuccess'] = false;
            header( "Location: ".$session -> referrer );
        }
    }

    function procMasterRegister()
    {
        global $session, $form;

        /* Convert username to all lowercase (by option) */
        if( ALL_LOWERCASE )
        {
            $_POST['username'] = strtolower( $_POST['username'] );
        }

        /* Registration attempt */
        $retval = $session -> SessionMasterRegister( $_POST['username'], $_POST['password'], $_POST['email'] );

        /* Registration Successful */
        if( $retval == 0 )
        {
            $_SESSION['reguname'] = $_POST['username'];
            $_SESSION['regsuccess'] = true;
            header( "Location: ".$session->referrer.'?'.$session->username );
        }
        /* Error found with form */
        elseif( $retval == 1 )
        {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form -> getErrorArray();
            header( "Location: ".$session->referrer.'?'.$session->username );
        }
        /* Registration attempt failed */
        elseif( $retval == 2 )
        {
            $_SESSION['reguname'] = $_POST['username'];
            $_SESSION['regsuccess'] = false;
            header( "Location: ".$session -> referrer.'?'.$session -> username );
        }
    }

    function procMemberRegister()
    {
        global $session, $form;

        /* Convert username to all lowercase (by option) */
        if( ALL_LOWERCASE )
        {
            $_POST['username'] = strtolower( $_POST['username'] );
        }

        /* Registration attempt */
        $retval = $session -> SessionMemberRegister( $_POST['username'], $_POST['password'], $_POST['email'] );

        /* Registration Successful */
        if( $retval == 0 )
        {
            $_SESSION['reguname'] = $_POST['username'];
            $_SESSION['regsuccess'] = true;
            header("Location: ".$session -> referrer.'?'.$session -> username);
        }
        /* Error found with form */
        elseif( $retval == 1 )
        {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form -> getErrorArray();
            header("Location: ".$session -> referrer.'?'.$session -> username);
        }
        /* Registration attempt failed */
        elseif( $retval == 2 )
        {
            $_SESSION['reguname'] = $_POST['username'];
            $_SESSION['regsuccess'] = false;
            header("Location: ".$session -> referrer.'?'.$session -> username);
        }
    }

    function procAgentRegister()
    {
        global $session, $form;

        /* Convert username to all lowercase (by option) */
        if( ALL_LOWERCASE )
        {
            $_POST['username'] = strtolower($_POST['username']);
        }
        /* Registration attempt */
        $retval = $session -> SessionAgentRegister( $_POST['username'], $_POST['password'], $_POST['email'] );

        /* Registration Successful */
        if( $retval == 0 )
        {
            $_SESSION['reguname'] = $_POST['username'];
            $_SESSION['regsuccess'] = true;
            header("Location: ".$session -> referrer.'?'.$session -> username);
        }
        /* Error found with form */
        elseif( $retval == 1 )
        {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form -> getErrorArray();
            header( "Location: ".$session -> referrer.'?'.$session -> username );
        }
        /* Registration attempt failed */
        elseif( $retval == 2 )
        {
            $_SESSION['reguname'] = $_POST['username'];
            $_SESSION['regsuccess'] = false;
            header("Location: ".$session->referrer.'?'.$session->username);
        }
    }

    /**
     * procForgotPass - Validates the given username then if
     * everything is fine, a new password is generated and
     * emailed to the address the user gave on sign up.
     */
    function procForgotPass()
    {
        global $database, $session, $mailer, $form;

        /* Username error checking */
        $subusername = $_POST['username'];
        $field = "username";  //Use field name for username

        if( !$subusername || strlen( $subusername = trim( $subusername) ) == 0 )
        {
            $form->setError($field, "* Username not entered<br>");
        }
        else
        {
            /* Make sure username is in database */
            $subusername = stripslashes($subusername);
            if(strlen($subusername) < 5 || strlen($subusername) > 30 ||
                !eregi("^([0-9a-z])+$", $subusername) ||
                (!$database->usernameTaken($subusername))){
                $form->setError($field, "* Username does not exist<br>");
            }
        }

        /* Errors exist, have user correct them */
        if($form->num_errors > 0){
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
        }
        /* Generate new password and email it to user */
        else{
            /* Generate new password */
            $newpass = $session->generateRandStr(8);

            /* Get email of user */
            $usrinf = $database->getUserInfo($subusername);
            $email  = $usrinf['email'];

            /* Attempt to send the email with new password */
            if($mailer->sendNewPass($subusername,$email,$newpass)){
                /* Email sent, update database */
                $database->updateUserField($subusername, "password", md5($newpass));
                $_SESSION['forgotpass'] = true;
            }
            /* Email failure, do not change password */
            else{
                $_SESSION['forgotpass'] = false;
            }
        }

        header("Location: ".$session->referrer);
    }

    /**
     * procEditAccount - Attempts to edit the user's account
     * information, including the password, which must be verified
     * before a change is made.
     */
    function procEditAccount(){
        global $session, $form;
        /* Account edit attempt */
        $retval = $session->editAccount($_POST['curpass'], $_POST['newpass'], $_POST['email']);

        /* Account edit successful */
        if($retval){
            $_SESSION['useredit'] = true;
            header("Location: ".$session->referrer);
        }
        /* Error found with form */
        else{
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location: ".$session->referrer);
        }
    }
};

/* Initialize process */
$process = new Process;

?>
