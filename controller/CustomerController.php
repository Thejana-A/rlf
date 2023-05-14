<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/Customer.php');
    $args = $_POST;
    
    $customerModel = new Customer($args); 
    switch($controllerName[1]){
        case "add":
            $customerModel->addCustomer();
            break;
        case "manager_view": 
            $data = $customerModel->viewCustomer();
            session_start();
            $_SESSION["row"] = $data;
            if(isset($_POST['edit'])){ 
                header("location: http://localhost/rlf/view/manager/edit_customer.php?data=true");
            }else if(isset($_POST['delete'])){
                header("location: http://localhost/rlf/view/manager/delete_customer.php?data=true");
            } 
            break; 
        case "merchandiser_view":
            $data = $customerModel->viewCustomer();
            session_start();
            $_SESSION["row"] = $data;
            header("location: http://localhost/rlf/view/merchandiser/view_customer.php?data=true");
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
        case "sign_up":
            $customerModel->signUp();
            break;
        case "verify_email":
            $customerModel->verifyEmail();
            break;

        case "reset_password":
            $customerModel->resetPassword();
            break;
    
        case "reset_forgot_password":
            $customerModel->resetForgotPassword();
            break;
        
    } 
    
?>