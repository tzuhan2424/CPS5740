<?php
include "../dbconfig.php";
include "helperFunction.php";

if (checkEmployeeCookie()) {
    // Redirect to the Employee Home Page
    header("Location: employee_check.php");
    exit();
} else {
    // Redirect to the login page
    header("Location: ../index.html");
    exit();
}

?>