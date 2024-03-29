<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/CostumeDesign.php');
    
    $args = $_POST;
    $costumeDesignModel = new CostumeDesign($args); 
    switch($controllerName[1]){
        case "add":
            $costumeDesignModel->addDesign();
            break;
        case "add_new_size":
            $costumeDesignModel->addNewSize();
            break;
        case "add_customized_design":
            $costumeDesignModel->addCustomizedDesign();
            break;
        case "manager_view_general_design":
            $designName = $args["name"];
            header("location: http://localhost/rlf/view/manager/view_costume_design.php?name=$designName");
            break;
        case "merchandiser_view_general_design":
            $designName = $args["name"];
            header("location: http://localhost/rlf/view/merchandiser/view_costume_design.php?name=$designName");
            break;
        case "fd_view_general_design";
            $designName = $args["name"];
            header("location: http://localhost/rlf/view/fashion_designer/view_general_design.php?name=$designName");
            break;
        case "manager_view":
            $costumeDesignModel = new CostumeDesign($_POST); 
            $data = $costumeDesignModel->viewDesign(); 
            session_start();
            $_SESSION["row"] = $data;
            if(isset($_POST['edit'])){ 
                header("location: http://localhost/rlf/view/manager/edit_costume_design.php?data=true");
            }else if(isset($_POST['delete'])){
                header("location: http://localhost/rlf/view/manager/delete_costume_design.php?data=true");
            }
            break;
            case "fashion_designer_view":
                $costumeDesignModel = new CostumeDesign($_POST); 
                $data = $costumeDesignModel->viewDesign(); 
                session_start();
                $_SESSION["row"] = $data;
                if(isset($_POST['edit'])){ 
                    header("location: http://localhost/rlf/view/fashion_designer/edit_costume_design.php?data=true");
                }else if(isset($_POST['delete'])){
                    header("location: http://localhost/rlf/view/fashion_designer/delete_costume_design.php?data=true");
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
        
        case "customer_view_customized_design":
            $costumeDesignModel->viewDesign();
            //$costumeDesignModel = new CostumeDesign($_POST); 
            //$data = $costumeDesignModel->viewDesign();
            //$row = http_build_query($data); 
            /*session_start();
            $_SESSION["row"] = $data;
            //header("location: http://localhost/rlf/view/manager/view_customized_design.php?data[]=$row");
            header("location: http://localhost/rlf/view/manager/view_customized_design.php?data=true");*/
            break;

        case "customer_operation":
            if(isset($_POST['edit'])){ 
                $costumeDesignModel->updateDesign();
                
            }else if(isset($_POST['delete'])){
                $costumeDesignModel->deleteDesign();
            }
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