<?php
class Session{
public static function init(){
    session_start();
}

public static function set($key, $value){
$_SESSION[$key]=$value;
}

public static function get($key){
    if(isset($_SESSION[$key])){
        return $_SESSION([$key]);
    }else{
        return false;
    }
}

public function loginCheck(){
    self::init();
    if(self::get('login')==true){
        header('location:index.php');
    }
}

public static function checkSession(){
 self::init();
 if(self::get('login')==false){
    self::destroy();
}
}


public static function destroy(){
    session_destroy();
    header("location:login.php");
}

}

?>