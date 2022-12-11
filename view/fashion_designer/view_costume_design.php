<!DOCTYPE html>
<html>
	<head>
	      <Meta name="viewpoint" content="width=device-width, initial-scale=1">
              <title> View Costume Design </title>
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
                    <a href="#">Fashion Designer </a> > View Costume Design
                </div>

                    <div id="list-box-small">
                        <center>
                            <h2>View Costume Design</h2>
                        </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Design Name</b>
                            <b>Design View</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>Linen black</span>
                            <span><img src="../icons/shirt.png" alt="All-views" class="design-view" length="375px" width="325"/></span>
                            <a href="./costume_design.php" class="grey">View</a>
                            <hr class="manager-long-hr" />
                        </div>
                    </div>


                </div>
                         
            </div> 
        </div> 


        <?php include 'footer.php';?>

</body> 
</html>
