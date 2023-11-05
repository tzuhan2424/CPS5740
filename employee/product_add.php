<?php
include 'helperFunction.php';
session_start();
checkLoginAndRedirect();

$vendorOptions = vendorDropdownList();


echo <<<HTML
<html>
<a href='employee_logout.php'>Employee logout</a><br>
<font size=4><b>Add products</b></font>
<form name="input" action="employee_insert_product.php" method="post" >
<br> Product Name: <input type="text" name="product_name" required="required">
<br> description: <input type="text" name="description" required="required">
<br> Cost: <input type="text" name="cost" required="required">
<br> Sell Price: <input type="text" name="sell_price" required="required">
<br> Quantity: <input type="text" name="quantity" required="required">
<br>Select vendor: 
    <SELECT name='vendor_id'>
        $vendorOptions
    </SELECT>
<br>
HTML;

// Fetch employee ID from cookie and include it as a hidden input
if(isset($_SESSION['employee_id'])) {
    $employeeId = htmlspecialchars($_SESSION['employee_id']);
    echo "<input type='hidden' name='employee_id' value='$employeeId'>";
} else {
    die("Employee ID not found. Please login.");
}

echo <<<HTML
<br><input type='submit' value='Submit'>
</form>
</html>
HTML;
?>


