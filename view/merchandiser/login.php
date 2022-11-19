<?php
    session_start();
    error_reporting(E_ERROR | E_PARSE);
    $_SESSION["username"] = "";
    $_SESSION["employee_id"] = "";
    $_SESSION["user_type"] = "";
    $_SESSION["email"] = "";
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <script>
            function validateForm(){
                var email = document.forms["loginForm"]["email"].value;
                var password = document.forms["loginForm"]["password"].value;
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
            Username : <input type="text" name="email" id="email" /><br />
            Password : <input type="password" name="password" id="password" /><br />
            <input type="submit" value="Login" />
            <input type="reset" value="Cancel" />
        </form>
    </body>
</html>