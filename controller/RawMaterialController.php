<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/RawMaterial.php');
    $args = $_POST;
    
    $rawMaterialModel = new RawMaterial($args); 
    switch($controllerName[1]){
        case "add":
            $rawMaterialModel->addRawMaterial();
            break;
            
        case "supplier_view":
            $rawMaterialModel = new RawMaterial($_POST); 
            $data = $rawMaterialModel->viewRawMaterial();
            $row = http_build_query($data); 
            header("location: http://localhost/rlf/view/supplier/view_raw_materials.php?data[]=$row");
            break;

	case "fashion_designer_view":
            $rawMaterialModel = new RawMaterial($_POST); 
            $data = $rawMaterialModel->viewRawMaterial();
            $row = http_build_query($data); 
            header("location: http://localhost/rlf/view/fashion_designer/view_raw_materials.php?data[]=$row");
            break;

        case "manager_view":
            $rawMaterialModel = new RawMaterial($_POST); 
            $data = $rawMaterialModel->viewRawMaterial();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            if(isset($_POST['edit'])){ 
                //header("location: http://localhost/rlf/view/manager/edit_raw_material.php?data[]=$row");
                header("location: http://localhost/rlf/view/manager/edit_raw_material.php?data=true");
            }else if(isset($_POST['delete'])){
                //header("location: http://localhost/rlf/view/manager/delete_raw_materials.php?data[]=$row");
                header("location: http://localhost/rlf/view/manager/delete_raw_material.php?data=true");
            }
            break;
        case "merchandiser_view":
            $rawMaterialModel = new RawMaterial($_POST); 
            $data = $rawMaterialModel->viewRawMaterial();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            //header("location: http://localhost/rlf/view/merchandiser/view_raw_material.php?data[]=$row");
            header("location: http://localhost/rlf/view/merchandiser/view_raw_material.php?data=true");
            break;
        case "update":
            $rawMaterialModel->updateRawMaterial();
            break;
        case "delete":
            $rawMaterialModel->deleteRawMaterial();
            break;
    } 
    
?>