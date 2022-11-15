<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/Employee.php');
    $args = $_POST;
    
    $employeeModel = new Employee($args); 
    switch($controllerName[1]){
        case "add":
            $employeeModel->addEmployee();
            break;
        case "view":
            $employeeModel->viewEmployee();
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
        
    } 
    
?>