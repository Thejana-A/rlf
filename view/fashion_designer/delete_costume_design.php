<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
	<head>
	      <Meta name="viewpoint" content="width=device-width, initial-scale=1">
              <title> Delete costume design </title>
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
                    <a href="#">Fashion Designer </a> > Delete costume design
                </div>

                    <div id="list-box-small">
                        <center>
                            <h2>Delete Costume Design</h2>
                        </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Design ID</b>
                            <b>Design name</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>John Doe</span>
                            <a href="#" class="grey">View</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>John A</span>
                            <a href="#" class="grey">View</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0010</span>
                            <span>John B</span>
                            <a href="#" class="grey">View</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0011</span>
                            <span>John C</span>
                            <a href="#" class="grey">View</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0026</span>
                            <span>Harry P</span>
                            <a href="#" class="grey">View</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                    </div>


                </div>
                         
            </div> 
        </div> 


        <?php include 'footer.php';?>

</body> 
</html>

