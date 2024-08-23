<?php

include_once './lib/Database.php';
include_once './helpers/Formate.php';
include_once './PHPmailar/Exception.php';
include_once './PHPmailar/PHPMailer.php';
include_once './PHPmailar/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Register{
public $db;
public $fr;
public function __construct(){
$this->db= new Database();
$this->fr= new Format();
}


public function AddUser($data){
    function  sendemail_varifi($name,$email,$v_token){
        $mail= new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth=true;
        $mail->Host='smtp.gmail.com';
        $mail->Username='kk.shahid44@gmail.com';
        $mail->Password='@shahid@526121';
        $mail->SMTPSecure='tls';
        $mail->Port='587';
        $mail->setFrom('kk.shahid44@gmail.com', $name);
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject="Email Varification From Project";
        $email_template="
        <h2>You have register with Project</h2>
        <h5>Verify your email address to login please click the link below</h5>
        <a href='http://localhost/project/admin/verify-email.php?token=$v_token'>Click Here</a>
        ";

        $mail->Body=$email_template;
        $mail->send();


    }
 $name= $this->fr->validation($data["name"]);
 $phone= $this->fr->validation($data["phone"]);
 $email= $this->fr->validation($data["email"]);
 $password= $this->fr->validation($data["password"]);
 $v_token= md5(rand());


if(empty($name) || empty($email)||empty($password)||empty($phone) ){
$error="fild Must Not Be Empty";
return $error;
}else{
    $e_query="SELECT * FROM tbl_user WHERE email='$email'";
    $check_email = $this->db->select($e_query);
    if($check_email >0){
       $error="Email already exisit";
       header('location:register.php');
       return $error;
       
    }else{
        $insert_query="INSERT INTO tbl_user(user_name,phone,user_email,user_password,v_token) VALUES('$name','$phone','$email','$password','$v_token')";
        $insert_row= $this->db->insert($insert_query);

        if($insert_row){
            sendemail_varifi($name,$email,$v_token);
            $success="Registration Successfull. Please check your email inbox";
            return $success;
        }else{
            $error="Registration Failed";
            return $error;
        }
    }
}


}
}

?>