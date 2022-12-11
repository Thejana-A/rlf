<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/RawMaterialQuotation.php');
    require_once('../model/RawMaterialOrder.php');
    $args = $_POST;
    
    $rawMaterialQuotationModel = new RawMaterialQuotation($args); 
    $rawMaterialOrderModel = new RawMaterialOrder($args); 
    switch($controllerName[1]){
        case "add":
            $rawMaterialQuotationModel->addMaterialQuotation();
            break;
        case "manager_view":
            $data = $rawMaterialQuotationModel->viewMaterialQuotation();
            $row = http_build_query($data); 
            header("location: http://localhost/rlf/view/manager/view_material_quotation.php?data[]=$row");
            break;
        case "merchandiser_view":
            $data = $rawMaterialQuotationModel->viewMaterialQuotation();
            $row = http_build_query($data); 
            header("location: http://localhost/rlf/view/merchandiser/view_material_quotation.php?data[]=$row");
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