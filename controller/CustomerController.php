<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/Customer.php');
    $args = $_POST;
    
    $customerModel = new Customer($args); 
    switch($controllerName[1]){
        case "add":
            $customerModel->addCustomer();
            break;
        case "view":
            $customerModel->viewCustomer();
            break;
        case "update":
            $customerModel->updateCustomer();
            break;
        case "delete":
            $customerModel->deleteCustomer();
            break;
        case "login":
            $customerModel->login();
            break;
        case "logout":
            $customerModel->logout();
            break;
        
    } 
    
?>