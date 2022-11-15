<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit self profile</title>
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
                    <a href="#">Manager </a> > Edit self profile
                </div> 

                <div id="form-box-small">
                    <form method="post" action="">
                        <center>
                            <h2>Edit profile</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Employee ID : 
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
                                User type :
                            </div>
                            <div class="form-row-data">
                                <select name="user_type" id="">
                                    <option>Manager</option>
                                    <option>Merchadiser</option>
                                    <option>Fashion designer</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Date of birth : 
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Joined date : 
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" />
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
