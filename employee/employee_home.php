<?php


include "../dbconfig.php";
include 'helperFunction.php';
session_start();
checkLoginAndRedirect();




$employee_id=$_SESSION['employee_id'];
$name=$_SESSION['employee_name'];
$role=$_SESSION['employee_role'];
$fullNameRole = FullNameRole($role);

echo "<div>employee id: $employee_id </div>";
echo "<div>Welcome $fullNameRole : $name</div>";
echo "<a href='employee_logout.php'>Employee logout</a><br>";

echo <<<HTML
    <br><a href="product_add.php">Add products</a>
    <br><a href="employee_view_vendors.php">View all vendors</a>
    <br><a href="employee_search_product.php">Search & update product</a>
    HTML;
if ($role == 'M'){
    echo <<<HTML
        <form name="input" action="manager_view_reports.php" method="post">
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
}



?>