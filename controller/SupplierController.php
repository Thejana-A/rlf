<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/Supplier.php');
    $args = $_POST;
    
    $supplierModel = new Supplier($args); 
    switch($controllerName[1]){
        case "add":
            $supplierModel->addSupplier();
            break;
        case "view":
            $supplierModel->viewSupplier();
            break;
        case "update":
            $supplierModel->updateSupplier();
            break;
        case "delete":
            $supplierModel->deleteSupplier();
            break;
        case "login":
            $supplierModel->login();
            break;
        case "logout":
            $supplierModel->logout();
            break;
        case "sign_up":
            $supplierModel->signUp();
            break;
        
    } 
    
?>