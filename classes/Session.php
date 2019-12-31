<?php
class Session
{
    public static function init(){
        session_start();
    }
    public static function set($key, $val){
        $_SESSION[$key] = $val;
    }
    public static function get($key){
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        else{
            return false;
        }
    }
    public static function destroy()
    {
        session_destroy();
        header("Location:login.php");
    }
    public static function checkAdminSession(){
        self::init();
        if(self::get("admin-login") == false){
            unset($_SESSION["admin-login"]);
            header("Location:login.php");
        }
    }

    public static function checkStationSession(){
        self::init();
        if(self::get("station-login") == false){
            unset($_SESSION["station-login"]);
            header("Location:login.php");
        }
    }

    public static function checkCustomerSession(){
        self::init();
        if(self::get("customer-login") == false){
            unset($_SESSION["customer-login"]);
            header("Location:login.php");
        }
    }

    public static function checkAdminLogin(){
        self::init();
        if(self::get("admin-login") == true){
            header("Location:index.php");
        }
    }

    public static function checkStationLogin(){
        self::init();
        if(self::get("station-login") == true){
            header("Location:index.php");
        }
    }

    public static function checkCustomerLogin(){
        self::init();
        if(self::get("customer-login") == true){
            header("Location:index.php");
        }
    }
}
?>