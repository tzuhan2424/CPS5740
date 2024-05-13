<?php

include 'helperFunction.php';
session_start();

if (checkEmployeeSession() && checkEmployeeCookie()) {
    // Redirect to the Employee Home Page
    header("Location: employee_home.php");
    exit();
} 
// if (checkEmployeeCookie()) {
//     // Redirect to the Employee Home Page
//     header("Location: employee_home.php");
//     exit();
// } 


echo <<<HTML
<HTML>
<font size=4><b>Employee login</b></font>
<form name="input" action="employee_check.php" method="post" >
<br> Login ID: <input type="text" name="login_id">
<br> Password: <input type="password" name="password">
<input type="submit" value="Login">
</form>
<div>Login ID: tiger,  passwords: xyz123</div>
<div>Login ID: panda, passwords: xyz123</div>

</HTML>


HTML;


?>


