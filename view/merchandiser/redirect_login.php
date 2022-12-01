<?php
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    if(($_SESSION["employee_id"]=="")||($_SESSION["user_type"]!="merchandiser")){
        header("location:http://localhost/rlf/view/merchandiser/login.php");
        die();
    }
?>