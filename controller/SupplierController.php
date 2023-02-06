<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/Supplier.php');
    $args = $_POST;
    
    $supplierModel = new Supplier($args); 
    switch($controllerName[1]){
        case "add":
            $supplierModel->addSupplier();
            break;
        case "supplier_view":
            $supplierModel = new Supplier($_POST); 
            $data = $supplierModel->viewSupplier();
            $row = http_build_query($data); 
            if(isset($_POST['view'])){ 
                //header("location: http://localhost/rlf/view/supplier/edit_self_profile.php?data[]=$row");
                header("location: http://localhost/rlf/view/supplier/edit_self_profile.php?data=true");
                break;
            }
        case "manager_view":
            //$supplierModel = new Supplier($_POST); 
            $data = $supplierModel->viewSupplier();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            if(isset($_POST['edit'])){ 
                //header("location: http://localhost/rlf/view/manager/edit_supplier.php?data[]=$row");
                header("location: http://localhost/rlf/view/manager/edit_supplier.php?data=true");
            }else if(isset($_POST['delete'])){
                //header("location: http://localhost/rlf/view/manager/delete_supplier.php?data[]=$row");
                header("location: http://localhost/rlf/view/manager/delete_supplier.php?data=true");
            }
            break;
        case "merchandiser_view":
            $supplierModel = new Supplier($_POST); 
            $data = $supplierModel->viewSupplier();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            //header("location: http://localhost/rlf/view/merchandiser/view_supplier.php?data[]=$row");
            header("location: http://localhost/rlf/view/merchandiser/view_supplier.php?data=true");
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
        case "reset_password":
            $supplierModel->resetPassword();
            break;

        case "verify_email":
            $supplierModel->verifyEmail();
            break;
        case "request_forgot_password":
            $supplierModel->requestForgotPassword();
            break;
        case "reset_forgot_password":
            $supplierModel->resetForgotPassword();
            break;
        case "edit_self_profile":
            $supplierModel->editSelfProfile();
            break;
        
    } 
    
?>