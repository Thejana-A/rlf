<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/RawMaterialOrder.php');
    require_once('../model/RawMaterialQuotation.php');
    $args = $_POST;
    
    $rawMaterialQuotationModel = new RawMaterialQuotation($args); 
    $rawMaterialOrderModel = new RawMaterialOrder($args); 
    switch($controllerName[1]){
        case "add":
            $rawMaterialQuotationModel->addMaterialQuotation();
            break;
        case "manager_view":
            $rawMaterialQuotationModel = new RawMaterialQuotation($_POST); 
            $data = $rawMaterialQuotationModel->viewMaterialQuotation();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            //header("location: http://localhost/rlf/view/manager/view_material_quotation.php?data[]=$row");
            header("location: http://localhost/rlf/view/manager/view_material_quotation.php?data=true");
            break;
        case "merchandiser_view":
            $rawMaterialQuotationModel = new RawMaterialQuotation($_POST); 
            $data = $rawMaterialQuotationModel->viewMaterialQuotation();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            //header("location: http://localhost/rlf/view/merchandiser/view_material_quotation.php?data[]=$row");
            header("location: http://localhost/rlf/view/merchandiser/view_material_quotation.php?data=true");
            break;
        case "supplier_view":
            $rawMaterialQuotationModel = new RawMaterialQuotation($_POST); 
            $data = $rawMaterialQuotationModel->viewMaterialQuotation();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            //header("location: http://localhost/rlf/view/supplier/send_quotation.php?data[]=$row");
            header("location: http://localhost/rlf/view/supplier/send_quotation.php?data=true");
            break;
        case "update":
            if(isset($_POST['update_material_quotation'])){ 
                $rawMaterialQuotationModel->updateMaterialQuotation();
            }else if(isset($_POST['add_material_order'])){
                $rawMaterialOrderModel->addMaterialOrder();
            }
            break;
    } 
    
?>