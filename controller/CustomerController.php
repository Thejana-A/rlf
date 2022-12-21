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
            //$customerModel = new Customer($_POST); 
            $data = $customerModel->viewCustomer();
            $row = http_build_query($data); 
            if(isset($_POST['edit'])){ 
                header("location: http://localhost/rlf/view/manager/edit_customer.php?data[]=$row");
            }else if(isset($_POST['delete'])){
                header("location: http://localhost/rlf/view/manager/delete_customer.php?data[]=$row");
            }
            break; 
        case "merchandiser_view":
            //$customerModel = new Customer($_POST); 
            $data = $customerModel->viewCustomer();
            $row = http_build_query($data); 
            header("location: http://localhost/rlf/view/merchandiser/view_customer.php?data[]=$row");
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
        
    } 
    
?>