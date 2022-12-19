<?php
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    if(($_SESSION["employee_id"]=="")||($_SESSION["user_type"]!="fashion_designer")){
        header("location:http://localhost/rlf/view/fashion_designer/login.php");
        die();
    }
?>