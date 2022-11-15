<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit customer</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Manager </a> >
                    <a href="#">Customers </a> > Edit
                </div> 

                <div id="form-box-small">
                    <form method="post" action="">
                        <center>
                            <h2>Edit customer details</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                First name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Last name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Email : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Contact number : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                City : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-submit">
                                <input type="submit" value="Save" />
                            </div>
                            <div class="form-row-reset">
                                <input type="reset" value="Cancel" />
                            </div>
                        </div> 
                    </form>
                </div>  
                

            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
