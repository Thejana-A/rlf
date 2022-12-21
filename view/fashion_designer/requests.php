<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
	<head>
	      <Meta name="viewpoint" content="width=device-width, initial-scale=1">
              <title> View Request </title>
              <link rel="stylesheet" type="text/css" href="../css/fashion_designer/data_form_style.css" />
              <link rel="stylesheet" type="text/css" href="../css/fashion_designer/view_list_style.css" />
	</head>

<body>
	<?php include 'header.php';?>

	<div id="page-body">
            <?php include 'leftnav.php';?>

	        <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Fashion Designer </a> 
                    <a href="#">View Requests </a> > View 
                </div>

                    <div id="form-box">
                        <center>
                            <h2>Requests</h2>
                        </center>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Material ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="material_id"  id="material_id" value = "" readonly  />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Material name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" id="name" value = "" readonly />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="size" id="size" value = "" readonly />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Measuring Unit : 
                            </div>
                            <div class="form-row-data">
                                <select name="measuring_unit" id="" >
                                    <option value="units">Units</option>
                                    <option value="metre">metre</option>
                                    <option value="kilogram">kilogram</option>
                                    <option value="litre">litre</option>
                                    <option value="yards">yards</option>
                                    <option value="m^2">m^2</option>
                                </select>
                            </div>
                        </div>
                        
                        
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Status (By manager) :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" id="" <?php echo ($row["manager_approval"]=="approve")?'checked':'disabled' ?> /> Accepted
                                        </td>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" id="" <?php echo ($row["manager_approval"]=="reject")?'checked':'disabled' ?> /> Rejected
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Acceptance description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="" name="approval_description" id="approval_description" value = "" rows="4" cols="40" readonly ></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="" name="description" id="description" rows="4" cols="40" readonly ></textarea>
                            </div>
                        </div>
                            

                <!--    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Design ID</b>
                            <b>Design name</b>
                            <b>Published Date</b>
                            <b>Status</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>Linen black</span>
                            <span>11.11.2022</span>
                            <span>Pending</span>
                            <a href="#" class="grey">View</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>silk sky blue</span>
                            <span>25.10.2022</span>
                            <span>Approved</span>
                            <a href="#" class="grey">View</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0010</span>
                            <span>fabrics black</span>
                            <span>10.05.2022</span>
                            <span>Approved</span>
                            <a href="#" class="grey">View</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0011</span>
                            <span>Linen red</span>
                            <span>01.02.2022</span>
                            <span>Approved</span>
                            <a href="#" class="grey">View</a>
                            <hr class="manager-long-hr" />
                        </div>
                    </div>-->


                </div>
                         
            </div> 
        </div> 


        <?php include 'footer.php';?>

</body> 
</html>
