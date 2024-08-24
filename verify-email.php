<?php 
include_once './lib/Database.php';
include_once './lib/Session.php';
Session::init();
$db= new Database();

if(isset($_GET['token'])){
$token =$_GET['token'];
$query= "SELECT v_token, v_status FROM tbl_user WHERE v_token='$token'";
$result =$db->select($query);

if($result != false){
$row= mysqli_fetch_assoc($result);
if($row['v_status']== 0){
$click_token =$row['v_token'];
$update_statue= "UPDATE tbl_user SET v_status='1' WHERE v_token='$click_token'";

$update_result= $db->update($update_statue);
if($update_result){
    $_SESSION['status']="Your account has been varified Successfully";
    header('location:login.php');
}else{
    $_SESSION['status']=" Varification Failed!";
    header('location:login.php');
}
}else{
    $_SESSION['status']="Email already varified !";
    header('location:login.php');
}
}else{
    $_SESSION['status']="This Token Does not Exsist!";
    header('location:login.php');
}
}else{
    $_SESSION['status']="Not Allowed";
    header('location:login.php');
}
?>