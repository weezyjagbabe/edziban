<?php
require_once 'dbconfig.php';
require_once 'functions/functions.php';

class user
{
    public function __construct()
    {

    }
    public function is_logged_in(){
        return false;
    }

    public function redirect($url){
        echo "<script>location.href='$url'</script>";
    }

    public function login($email,$password){

        $conn = connection();
        $stmt = $conn->prepare('SELECT password FROM user WHERE email=?');
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->bind_result($compPass);
        $stmt->fetch();
       if(password_verify($password,$compPass)) {



           $conn = connection();
           $stmt = $conn->prepare('SELECT userCode, loginCount FROM user WHERE email=?');
           $stmt->bind_param('s', $email);
           $stmt->execute();
           $stmt->bind_result($userCode, $loginCount);
           $stmt->fetch();
            if(!empty($userCode))
            {
                if(insertlastLogin($userCode,$loginCount)) {

                    $conn = connection();
                    $stmt = $conn->prepare('SELECT lastLogin FROM user WHERE userCode=?');
                    $stmt->bind_param('i', $userCode);
                    $stmt->execute();
                    $stmt->bind_result($lastLogin);
                    $stmt->fetch();

                    if(updateLogin($email, $lastLogin)){
                        return array($userCode,$loginCount);
                    }else{
                        return array(0);
                    }
                }else {
                    return false;
                }
            }
            else{
                return false;
            }
       }
    }


}