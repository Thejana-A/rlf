<?php
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    if($_SESSION["supplier_id"]==""){
        header("location:http://localhost/rlf/view/supplier/login/login.php");
        die();
    }
?>