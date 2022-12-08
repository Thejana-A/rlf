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
            $employeeModel = new Employee($_POST); 
            $data = $employeeModel->viewEmployee();
            $row = http_build_query($data); 
            if(isset($_POST['edit'])){ 
                header("location: http://localhost/rlf/view/manager/edit_employee.php?data[]=$row");
            }else if(isset($_POST['delete'])){
                header("location: http://localhost/rlf/view/manager/delete_employee.php?data[]=$row");
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
            break;
        
    } 
    
?>