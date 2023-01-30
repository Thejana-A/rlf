<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/CostumeDesign.php');
    
    $args = $_POST;
    $costumeDesignModel = new CostumeDesign($args); 
    switch($controllerName[1]){
        case "add":
            $costumeDesignModel->addDesign();
            break;
        case "manager_view":
            $costumeDesignModel = new CostumeDesign($_POST); 
            $data = $costumeDesignModel->viewDesign();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            if(isset($_POST['edit'])){ 
                //header("location: http://localhost/rlf/view/manager/edit_costume_design.php?data[]=$row");
                header("location: http://localhost/rlf/view/manager/edit_costume_design.php?data=true");
            }else if(isset($_POST['delete'])){
                //header("location: http://localhost/rlf/view/manager/delete_costume_design.php?data[]=$row");
                header("location: http://localhost/rlf/view/manager/delete_costume_design.php?data=true");
            }
            break;
        case "fashion_designer_view":
            $costumeDesignModel = new CostumeDesign($_POST); 
            $data = $costumeDesignModel->viewDesign();
            $row = http_build_query($data); 
            if(isset($_POST['edit'])){ 
                header("location: http://localhost/rlf/view/fashion_designer/edit_costume_design.php?data[]=$row");
            }else if(isset($_POST['delete'])){
                header("location: http://localhost/rlf/view/fashion_designer/delete_costume_design.php?data[]=$row");
            }
            break;
        case "manager_view_customized_design":
            $costumeDesignModel = new CostumeDesign($_POST); 
            $data = $costumeDesignModel->viewDesign();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            //header("location: http://localhost/rlf/view/manager/view_customized_design.php?data[]=$row");
            header("location: http://localhost/rlf/view/manager/view_customized_design.php?data=true");
            break;
        case "merchandiser_view":
            $costumeDesignModel = new CostumeDesign($_POST); 
            $data = $costumeDesignModel->viewDesign();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            //header("location: http://localhost/rlf/view/merchandiser/edit_costume_design.php?data[]=$row");
            header("location: http://localhost/rlf/view/merchandiser/edit_costume_design.php?data=true");
            break;
        case "update":
            $costumeDesignModel->updateDesign();
            break;
        case "update_price":
            $costumeDesignModel->updatePrice();
            break;
        case "delete":
            $costumeDesignModel->deleteDesign();
            break;
    } 
    
?>