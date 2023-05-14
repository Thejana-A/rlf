<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/Employee.php');
    $args = $_POST;
    
    $employeeModel = new Employee($args); 
    switch($controllerName[1]){
        case "add": 
            $employeeModel->addEmployee();
            break;
        case "manager_view": 
            $data = $employeeModel->viewEmployee();
            session_start();
            $_SESSION["row"] = $data;
            if(isset($_POST['edit'])){ 
                header("location: http://localhost/rlf/view/manager/edit_employee.php?data=true");
            }else if(isset($_POST['delete'])){
                header("location: http://localhost/rlf/view/manager/delete_employee.php?data=true");
            }
            break;
        case "update":
            $employeeModel->updateEmployee();
            break;
        case "delete":
            $employeeModel->deleteEmployee();
            break;
        case "login":
            $employeeModel->login();
            break;
        case "logout":
            $employeeModel->logout();
            break;
        case "sign_up":
            $employeeModel->signUp();
            print_r($_POST);
            break;
        case "reset_password":
            $employeeModel->resetPassword();
            break;

            
        case "verify_email":
            $employeeModel->verifyEmail();
            break;
        case "request_forgot_password":
            $employeeModel->requestForgotPassword();
            break;
        case "reset_forgot_password":
            $employeeModel->resetForgotPassword();
            break;
    } 
    
?>