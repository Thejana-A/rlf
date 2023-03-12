<?php
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    if(($_SESSION["employee_id"]=="")||($_SESSION["user_type"]!="manager")){
        header("location:http://localhost/rlf/view/customer/customer_login.php");
        die();
    }
?>