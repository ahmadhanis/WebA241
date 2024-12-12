<?php
    include "../dbconnect.php";
    $adminid = $_GET['adminid'];
    $sql = "SELECT * FROM `tbl_admins` WHERE `admin_id` = '$adminid'";
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $numrow = $result->rowCount();
    if ($numrow > 0) {
        echo json_encode($row);
    } else {
        echo json_encode(array("message" => "No data found."));
    }
?>