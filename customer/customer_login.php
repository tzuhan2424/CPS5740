<?php

include 'customerHelpFunction.php';
session_start();

if (checkCustomerSession() && checkCustomerCookie()) {
    header("Location: customer_check_p2.php");
    exit();
} 



echo <<<HTML
<HTML>
<font size=4><b>Customer login</b></font>
<form name="input" action="customer_check.php" method="post" >
<br> Login ID: <input type="text" name="login_id">
<br> Password: <input type="password" name="password">
<input type="submit" value="Login">
</form>
</HTML>


HTML;


?>
