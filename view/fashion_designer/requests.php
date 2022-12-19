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

                    <div id="list-box-small">
                        <center>
                            <h2>Requests</h2>
                        </center>

                        <div class="form-row">
                                <div class="form-row-theme">
                                    Design ID : 
                                </div>
                                <div class="form-row-data">
                                    <input type="text" name="name" id="name"  readonly />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-row-theme">
                                    Design name : 
                                </div>
                                <div class="form-row-data">
                                    <input type="text" name="name" id="name"  readonly />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-row-theme">
                                    Published Date: 
                                </div>
                                <div class="form-row-data">
                                    <input type="text" name="name" id="name"  readonly/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-row-theme">
                                    Status: 
                                </div>
                                <div class="form-row-data">
                                    <input type="text" name="name" id="name"  readonly/>
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
