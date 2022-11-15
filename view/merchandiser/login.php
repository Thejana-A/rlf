<?php
    session_start();
    error_reporting(E_ERROR | E_PARSE);
    $_SESSION["username"] = "";
    $_SESSION["employee_id"] = "";
    $_SESSION["user_type"] = "";
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <script>
            function validateForm(){
                var username = document.forms["loginForm"]["username"].value;
                var password = document.forms["loginForm"]["password"].value;
                var user_type = document.forms["loginForm"]["user_type"].value;
                if (username == "") {
                    alert("User name must be filled out");
                    return false;
                }else if(password == "") {
                    alert("Password can't be empty");
                    return false;
                }else if(user_type == "") {
                    alert("Select the user role");
                    return false;
                }else{
                    return true; 
                }
            }
        </script>
    </head>

    <body>
        <?php include 'header.php';?>
        <form name="loginForm" id="loginForm" method="post" onSubmit="return validateForm()" action="../RouteHandler.php">
            <input type="text" hidden="true" name="framework_controller" value="employee/login" />
            <h2>Login</h2>
            Username : <input type="text" name="username" id="username" /><br />
            Password : <input type="password" name="password" id="password" /><br />
            User role : 
            <select name="user_type" id="user_type">
                <option value="" disabled selected>Select user role </option>
                <option value="customer">Customer</option>
                <option value="supplier">Supplier</option>
                <option value="merchandiser">Merchandiser</option>
                <option value="fashion designer">Fashion designer</option>
            </select><br />
            <input type="submit" value="Login" />
            <input type="reset" value="Cancel" />
        </form>
    </body>
</html>