<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit self profile</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="index.php">Welcome </a> >
                    <a href="login.php">Login </a> >
                    <a href="home.php">Supplier </a> > Edit self profile
                </div> 

                <div id="form-box-small">
                    <form method="post" action="">
                        <center>
                            <h2>Edit profile</h2>
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
                                NIC : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Password : 
                            </div>
                            <div class="form-row-data">
                                <input type="password" name="" id="" />
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
                                Contact no : 
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
                
                <div id="form-box-small">
                    <form method="post" action="">
                        <center>
                            <h2>Reset password</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Current password : 
                            </div>
                            <div class="form-row-data">
                                <input type="password" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                New password : 
                            </div>
                            <div class="form-row-data">
                                <input type="password" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Confirm password : 
                            </div>
                            <div class="form-row-data">
                                <input type="password" name="" id="" />
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
