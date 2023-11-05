<?php

session_start();

include "../dbconfig.php";
include "helperFunction.php";



if (!(checkEmployeeSession())) {
    echo "You must login.";
    // Give user a button to redirect to the login page
    echo '<form action="employee_login.php" method="get">
              <button type="submit">Go to Login</button>
          </form>';
    exit();
} 



$employee_id=$_SESSION['employee_id'];
$name=$_SESSION['employee_name'];
$role=$_SESSION['employee_role'];
$fullNameRole = FullNameRole($role);

echo "<div>employee id: $employee_id </div>";
echo "<div>Welcome $fullNameRole : $name</div>";
echo "<a href='employee_logout.php'>Employee logout</a><br>";

echo <<<HTML
    <br><a href="product_add.php">Add products</a>
    <br><a href="CPS5740_view_vendors_p2.php">View all vendors</a>
    <br><a href="CPS5740_employee_search_product.php">Search & update product</a>
    <form name="input" action="CPS5740_view_report.php" method="post">
        View Reports - period:
        <select name='report_period'>
            <option value="all">all</option>
            <option value="past_week">past week (Sun-Sat)</option>
            <option value="last_7days">last 7 days</option>
            <option value="current_month">current month</option>
            <option value="past_month">past month (1-31)</option>
            <option value="last_30days">last 30 days</option>
            <option value="this_year">this year (Jan to now)</option>
            <option value="last_365days">last 365 days</option>
            <option value="past_year">past year (Jan-Dec)</option>
        </select>
    , by:
        <select name='report_type'>
            <option value="all">all sales</option>
            <option value="products">products</option>
            <option value="vendors">vendors</option>
        </select>
        <input type="submit" value="Submit">
    </form>
HTML;


?>