<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Delete supplier</title>
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
                    <a href="#">Suppliers </a> > Delete
                </div>

                <div id="form-box-small">
                    <form method="post" action="">
                        <center>
                            <h2>Delete suppliers</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Contact number : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                User name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Email : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                City : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw materials : 
                            </div>
                            <div class="form-row-data">
                                <select name="" id="">
                                    <option disabled>ID - Material name</option>
                                    <option>0004 - Black Thread-S</option>
                                    <option>0014 - Blue Thread-S</option>
                                    <option>0022 - Red anchor button-L</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Verify :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="verify_status" class="input-radio" id="" disabled /> Approve
                                        </td>
                                        <td>
                                            <input type="radio" name="verify_status" class="input-radio" id="" disabled /> Deny
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-center-button">
                                <input type="submit" value="Delete" />
                            </div>
                        </div> 
                        
                    </form>
                </div> 

            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
