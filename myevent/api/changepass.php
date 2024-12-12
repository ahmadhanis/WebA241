<?php
$useremail = $_POST['email'];
$newpass = ($_POST['newpass']);
$oldpassword = ($_POST['oldpass']);
$confirmpass = ($_POST['confirmpass']);

// echo json_encode(array("message" => $useremail .",". $newpass .",". $oldpassword .",". $confirmpass));
if ($newpass == $confirmpass) {
    $newpass = sha1($newpass);
    $oldpassword = sha1($oldpassword);
    
    include "../dbconnect.php";
    $sql = "UPDATE tbl_admins SET admin_password = '$newpass' WHERE admin_email = '$useremail' AND admin_password = '$oldpassword'";
    $conn->query($sql);
    echo json_encode(array("message" => "Success."));
}else{
    echo json_encode(array("message" => "Failed."));
} 


?>