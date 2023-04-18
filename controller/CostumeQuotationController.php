<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/CostumeQuotation.php');
    
    $args = $_POST;
    $costumeQuotationModel = new CostumeQuotation($args); 
    switch($controllerName[1]){
        case "add":
            $costumeQuotationModel->addCostumeQuotation();
            break;
        case "manager_view":
            $data = $costumeQuotationModel->viewCostumeQuotation();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            //header("location: http://localhost/rlf/view/manager/edit_costume_quotation.php?data[]=$row");
            header("location: http://localhost/rlf/view/manager/edit_costume_quotation.php?data=true");
            break;
        case "merchandiser_view":
            $data = $costumeQuotationModel->viewCostumeQuotation();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            //header("location: http://localhost/rlf/view/merchandiser/view_costume_quotation.php?data[]=$row");
            header("location: http://localhost/rlf/view/merchandiser/view_costume_quotation.php?data=true");
            break;
        case "manager_update":
            $data = $costumeQuotationModel->viewCostumeQuotation();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            if(isset($_POST['update_costume_quotation'])){ 
                $costumeQuotationModel->updateCostumeQuotation();
            }else if(isset($_POST['add_costume_order'])){
                //header("location: http://localhost/rlf/view/manager/add_costume_order_onsite.php?data[]=$row");
                header("location: http://localhost/rlf/view/manager/add_costume_order_onsite.php?data=true");
            }
            break;
        case "customer_update":
            
            //$data = $costumeQuotationModel->viewCostumeQuotation(); 
            //$row = http_build_query($data); 
            //session_start();
            //$_SESSION["row"] = $data;
            //$costumeQuotationModel->updateCostumeQuotation();
            if(isset($_POST['edit'])){ 
                $costumeQuotationModel->updateCostumeQuotation();
                
            }else if(isset($_POST['delete'])){
                $costumeQuotationModel->deleteCostumeQuotation();
            }
            break;
            //print_r($_POST);
            
            break;

        case "merchandiser_update":
            $data = $costumeQuotationModel->viewCostumeQuotation();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            if(isset($_POST['update_costume_quotation'])){ 
                $costumeQuotationModel->updateCostumeQuotation();
            }else if(isset($_POST['add_costume_order'])){
                //header("location: http://localhost/rlf/view/merchandiser/add_costume_order_onsite.php?data[]=$row");
                header("location: http://localhost/rlf/view/merchandiser/add_costume_order_onsite.php?data=true");
            }
            break;
    } 
    
?>