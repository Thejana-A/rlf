<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Suppliers</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Manager </a> > Suppliers
                </div>
                <div class="link-row">
                    <a href="./add_supplier.php" class="right-button">Add new Supplier</a>
                </div>
                <div id="list-box">
                    <center>
                        <h2>Suppliers</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Supplier ID</b>
                            <b>Supplier name</b>
                            <b>City</b>
                            <b>Contact no</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT supplier_id, first_name, last_name, city, contact_no, verify_status FROM supplier";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        $class = ($row["verify_status"]=="approve")?"green":(($row["verify_status"]=="deny")?"red":"grey");
                                        echo "<div class='item-data-row'>";
                                        echo "<span class='manager-ID-column'>".$row["supplier_id"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span><span>".$row["city"]."</span><span>".$row["contact_no"]."</span>";
                                        echo "<a href=./edit_supplier.php?supplier_id=".$row["supplier_id"]." class='".$class."'>Edit</a>";
                                        echo "<a href='./delete_supplier.php' class='".$class."'>Delete</a>";
                                        echo "<hr class='manager-long-hr' />";
                                        echo "</div>";
                                    }
                                }else {
                                    echo "0 results";
                                }
                            }else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }
                            mysqli_close($conn);
                        ?>
                        <!--<div class="item-data-row">
                            <span>0003</span>
                            <span>John Doe</span>
                            <span>Piliyandala</span>
                            <span>0777762043</span>
                            <a href="#" class="red">Edit</a>
                            <a href="#" class="red">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>John A</span>
                            <span>Borella</span>
                            <span>0777762045</span>
                            <a href="#" class="grey">Edit</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0010</span>
                            <span>John B</span>
                            <span>Galle</span>
                            <span>0777762044</span>
                            <a href="#" class="green">Edit</a>
                            <a href="#" class="green">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0011</span>
                            <span>John C</span>
                            <span>Kandy</span>
                            <span>0777762046</span>
                            <a href="#" class="grey">Edit</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0026</span>
                            <span>Harry P</span>
                            <span>Jaffna</span>
                            <span>0777762049</span>
                            <a href="#" class="green">Edit</a>
                            <a href="#" class="green">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>  -->
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
