<?php

include 'helperFunction.php';
session_start();
checkLoginAndRedirect();


echo <<<HTML
  <a href='employee_logout.php'>Employee logout</a><br>
    <br>search product (* for all, you could search multiple keyword by separate them with white space):
    <form name="input" action="employee_display_product.php" method="post">
    <input type="text" name="search_items" required>
    <input type="submit" value="Search">
  </form>
HTML;

?>
