<?php

require_once("DBController.php");
$db_handle = new DBController();

$email = $_POST["email"];

if (!empty($email)) {
    $query = "SELECT * FROM fe_users WHERE email='" . $email . "' AND deleted='0' ";
    $user_count = $db_handle->numRows($query);
    if ($user_count>0) {
        echo "<span class='status-not-available'>Email Not Available</span>";
    } else {
        echo "<span class='status-available'>Email Available</span>";
    }
}
