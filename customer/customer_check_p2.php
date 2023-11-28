<?php
include "../dbconfig.php";
include 'customerHelpFunction.php';
session_start();
checkLoginAndRedirect();

$customer_address = $_SESSION['customer_address'];
$customer_name = $_SESSION['customer_name'];
$customer_id = $_SESSION['customer_id'];

echo <<<HTML
<HTML>
Welcome customer: <b>{$customer_name}</b>
<br>{$customer_address}
<br><a href='customer_logout.php'>Customer logout</a>
<br><a href='CPS5740_customer_display_customer.php'>Update my data</a>
<br><a href='customer_order_history.php'>View my order history</a>
<br>Search product (* for all):
<form name="input" action="search_product.php" method="get">
  <input type="text" name="search_items">
  <input type="submit" value="Search">
</form>
<br>Your Ad here from $50
<br><br><a href='index.html'>project home page</a>
</HTML>
HTML;
?>
